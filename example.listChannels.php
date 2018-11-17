<?php

require_once("classes/lnd.class.php");

$lnd = new lnd();
$lnd->setHost('86.122.84.24:8080');
$lnd->loadMacaroon('../../admin.macaroon');

/*
 * Fetch all open channels
 */

try {
	$channels = $lnd->request('channels')->channels;

	foreach($channels as $channel){
		echo $channel->active 		. "\n";
		echo $channel->remote_pubkey 	. "\n";
		echo $channel->channel_point 	. "\n";
		echo $channel->chan_id 		. "\n";
		echo $channel->capacity 	. "\n";
		echo $channel->local_balance 	. "\n";
		echo $channel->remote_balance 	. "\n";
		echo $channel->commit_fee	. "\n";
		echo $channel->commit_weight 	. "\n";
		echo $channel->fee_per_kw 	. "\n";
		echo $channel->num_updates 	. "\n";
		echo $channel->csv_delay	. "\n";
	}

}catch (Exception $e){
   	echo 'Caught exception: ',  $e->getMessage(), "\n";
}
