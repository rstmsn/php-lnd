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

	if($response->error){
		echo $response->error;
	}

}catch (Exception $e){
   	echo 'Caught exception: ',  $e->getMessage(), "\n";
}