<?php

require_once("classes/lnd.class.php");

$lnd = new lnd();
$lnd->setHost('86.122.84.24:8080');
$lnd->loadMacaroon('../../admin.macaroon');

/*
 * Generate a new Lightning Payment Request / Invoice
 * Also generates a QR Code Payment Request Representation using Googles Chart API
 */

$invoiceOptions = array("memo"	=> "1 Starblocks Coffee",
			"value"	=> "480000");

try {
	$request = $lnd->request('invoices',$invoiceOptions);

	$paymentReq = $request->payment_request;
	$paymentHash = $request->r_hash;

	echo $paymentReq;
	echo "<img src=\"https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=" . $paymentReq . "\">";

}catch (Exception $e){
   	echo 'Caught exception: ',  $e->getMessage(), "\n";
}
