<?php

require_once("classes/lnd.class.php");

$lnd = new lnd();
$lnd->setHost('86.122.84.24:8080');
$lnd->loadMacaroon('../../admin.macaroon');

/*
 * Unlock remote lnd Lightning Wallet
  */

try {
	$lndPassword = base64_encode("letmein1");
	$unlockOptions = array("wallet_password" => $lndPassword);
	$response = $lnd->request('unlockwallet',$unlockOptions);

}catch (Exception $e){
   	echo 'Caught exception: ',  $e->getMessage(), "\n";
}