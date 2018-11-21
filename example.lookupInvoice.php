<?php

require_once("classes/lnd.class.php");

$lnd = new lnd();
$lnd->setHost('86.122.84.24:8080');
$lnd->loadMacaroon('../../admin.macaroon');

/*
 * Look up a Lightning Invoice
  */

$rHash = bin2hex(base64_decode("gC2FK31DaPYBRmIZMVvywvoqcLAiUsqVjkc7i7t7mhU="));

try {
	$invoice = $lnd->request('invoice/' . $rHash);

	echo $invoice->memo 		. "\n";
	echo $invoice->r_preimage 	. "\n";
	echo $invoice->r_hash 		. "\n";
	echo $invoice->value 		. "\n";
	echo $invoice->creation_date 	. "\n";
	echo $invoice->payment_request 	. "\n";
	echo $invoice->expiry 		. "\n";
	echo $invoice->cltv_expiry 	. "\n";
	echo $invoice->add_index 	. "\n";

	# if the invoice has not yet been settled, the lnd request response will not
	# contain the 'settled' property. For consistency here, we create it and set
	# it to false.

	if(!isset($invoice->settled)){
		$invoice->settled = false;
	}

	if($invoice->settled){
		echo "Settled \n";
	}else{
		echo "Unsettled \n";
	}

}catch (Exception $e){
   	echo 'Caught exception: ',  $e->getMessage(), "\n";
}
