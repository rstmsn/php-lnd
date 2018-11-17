<?php

require_once("classes/lnd.class.php");

$lnd = new lnd();
$lnd->setHost('86.122.84.24:8080');
$lnd->loadMacaroon('../../admin.macaroon');

/*
 * Generate a new on-chain bitcoin wallet address
 * Also display a QR Code address representation using Google Charts API
 */

try {
	$address = $lnd->request('newaddress')->address;

	echo $address . "<br />";
	echo "<img src=\"https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=" . $address . "\">";

}catch (Exception $e){
   	echo 'Caught exception: ',  $e->getMessage(), "\n";
}