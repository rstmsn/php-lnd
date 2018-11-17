<?php

class lnd {

	/*
	 * version of the lnd rest api that we are communicating with
	 */
	private $lndApiVersion = 'v1';

	/*
	 * lnd rest endpoint
	 * (includes lnd host ip&port & api version, formatted as url)
	 */
	private $lndEndPoint = '';

	/*
	 * local disk path to tls.cert
	 * (required when sending SSL/TLS encrypted requests to lnd)
	 */
	private $tlsCertificatePath = '';

	/*
	 * forces curl to use SSL/TLS when communicating with lnd
	 * (requires that tlsCertificatePath is set)
	 */
	public $useSSL = false;

	/*
	 * the hexadecimal representation of the lnd macaroon file
	 * (this is sent in the header of every request we make
	 * and is used by lnd for authentication)
	 */
	protected $macaroonHex;


	public function __construct($lndHost = ''){
		if(!empty($lndHost)){
			$this->setHost($lndHost);
		}
	}

	/*
	 * Formats the lnd host details into an endpoint URL
	 * This will be the URL to which all our curl requests are sent
	 */
	public function setHost($lndHost){
    	// run a basic regex check to ensure the provided host
    	// string is in the format of host:port
    	$regex = "([a-z0-9\-\.]*)\.(([a-z]{2,4})|([0-9]{1,3}\.([0-9]{1,3})\.([0-9]{1,3})))";
	    $regex .= "(:[0-9]{2,5})?";

	    if(preg_match("~^$regex$~i", $lndHost)){
			$this->lndEndPoint = 'https://' . $lndHost . '/' . $this->lndApiVersion . '/';
	    }else{
			throw new Exception("Invalid lnd host. Use host:port syntax.");
	    }
	}

	/*
	 * construct a new lnd api request using curl and send it to our lnd endpoint.
	 * decode the JSON response and return an object of stdClass
	 */
	public function request($path,$postOptions = ''){

		$requestUrl = $this->lndEndPoint . $path;
		// include lnd authentication macaroon (hex representation) in our curl request
		// header and set the request content type to JSON
		$requestHeader = array('Grpc-Metadata-macaroon:'. $this->macaroonHex,
		 						'Content-Type:application/json');

		$curlHandle = curl_init();
		curl_setopt($curlHandle, CURLOPT_URL, $requestUrl);
		curl_setopt($curlHandle, CURLOPT_HTTPHEADER, $requestHeader);
		curl_setopt($curlHandle, CURLOPT_CAPATH, $this->tlsCertificatePath);
		curl_setopt($curlHandle, CURLOPT_SSL_VERIFYHOST, $this->useSSL);
		curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, $this->useSSL);
		curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);

		// if lnd expects additional parameters for a request,
		// we include these by setting the curl postfields option to a JSON encoded
		// representation of the supplied $postOptions array
		if(is_array($postOptions) && count($postOptions)>0) {
			curl_setopt($curlHandle, CURLOPT_POSTFIELDS, json_encode($postOptions));
		}

		// execute the curl request then decode the JSON response to an
		// object of standard class
		$requestResponse = json_decode(curl_exec($curlHandle));
		curl_close($curlHandle);

		// if the response is empty, throw an exception
		// otherwise return response data object
		if(!$requestResponse){
			$exceptionString = "Request to " . $requestUrl . " failed.\n";
			$exceptionString .= "See https://api.lightning.community/rest documentation.";
			throw new Exception($exceptionString);
		}else{
			return $requestResponse;
		}

	}

	/*
	 * Read the lnd authentication .macaroon file from disk
	 * convert to its (uppercase) hexadecimal representation and store
	 * for later use (in constructing curl request headers)
	 */
	public function loadMacaroon($macaroonPath){
		if(file_exists($macaroonPath)){
			$this->macaroonHex = strtoupper(bin2hex(file_get_contents($macaroonPath)));
		}else{
			throw new Exception('Macaroon not found.');
		}
	}

	/*
	 * Check lnd TLS certificate exists on disk and
	 * store its path for later use (in constructing curl request headers)
	 */
	public function loadTlsCert($tlsCertificatePath){
		if(file_exists($tlsCertificatePath)){
			$this->tlsCertificatePath = $tlsCertificatePath;
		}else{
			throw new Exception('TLS Certificate not found.');
		}
	}

}