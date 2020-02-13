<?php

require_once("classes/lnd.class.php");

$lnd = new lnd();
$lnd->setHost('86.122.84.24:8080');
$lnd->loadMacaroon('../../admin.macaroon');

/*
 * Pay a Lightning Invoice
 */

$paymentOptions = array("payment_request" => "lntb15u1pd7mvympp5k4e3egmfrrszrgytlfdrn2anwwwrc97z89hsvsrx22ytsm59258sdq4xysyymr0vd4kzcmrd9hx7cqp2zlsxce8lqq34y9ldqfsp4atyzl4q9j6xv5g5qj733ul8k8mu3dt46y53y7c6kwe8spux4yr42wdk0g2rjlkzh2nm6zvcyd8klxadzpcq83nwhz");

try {
	$response = $lnd->request('channels/transactions',$paymentOptions);

	if(!$response->error){

		# if no error detected, output successfuly payment details
		echo $response->payment_preimage 	. "\n";
		echo $response->total_fees_msat		. "\n";
		echo $response->total_amt_msat		. "\n";

		$paymentRoute = $response->payment_route;

		echo $paymentRoute->total_amt 		. "\n";
		echo $paymentRoute->total_fees		. "\n";

		foreach($paymentRoute->hops as $hop){
			echo $hop->chan_id 		. "\n";
			echo $hop->chan_capacity 	. "\n";
			echo $hop->amt_to_forward 	. "\n";
			echo $hop->fee			. "\n";
			echo $hop->amt_to_forward_msat	. "\n";
			echo $hop->fee_msat		. "\n";
		}

	}else{
		echo $response->error;
	}

}catch (Exception $e){
   	echo 'Caught exception: ',  $e->getMessage(), "\n";
}
