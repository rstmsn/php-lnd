<?php

require_once("classes/lnd.class.php");

$lnd = new lnd();
$lnd->setHost('86.122.84.24:8080');
$lnd->loadMacaroon('../../admin.macaroon');

/*
 * Fetch all peer nodes that LND is currently connected to
 */

try {
	$peers = $lnd->request('peers')->peers;

	foreach($peers as $peer){
		echo $peer->pub_key 	. "\n";
		echo $peer->address 	. "\n";
		echo $peer->bytes_sent 	. "\n";
		echo $peer->bytes_recv 	. "\n";
		echo $peer->ping_time 	. "\n";
	}

}catch (Exception $e){
   	echo 'Caught exception: ',  $e->getMessage(), "\n";
}