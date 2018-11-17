<?php

require_once("classes/lnd.class.php");

$lnd = new lnd();
$lnd->setHost('86.122.84.24:8080');
$lnd->loadMacaroon('../../admin.macaroon');

/*
 * Fetch general information about our remote LND node
 */

try {
	$info = $lnd->request('getinfo');

	echo $info->identity_pubkey	      . "\n";
	echo $info->alias                 . "\n";
	echo $info->num_active_channels	  . "\n";
	echo $info->num_peers             . "\n";
	echo $info->block_height          . "\n";
	echo $info->block_hash            . "\n";
	echo $info->synced_to_chain	      . "\n";
	echo $info->testnet	              . "\n";
	echo $info->synced_to_chain       . "\n";
	echo $info->best_header_timestamp . "\n";
	echo $info->version	              . "\n";

	foreach($info->chains as $chain){
		echo $chain . "\n";
	}

}catch (Exception $e){
   	echo 'Caught exception: ',  $e->getMessage(), "\n";
}