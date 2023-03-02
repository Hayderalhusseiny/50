<?php

require __DIR__.'/lib/autoload.php';
require __DIR__.'/system/update_funds.php';


$secret = "testtt";
$method = 16;
$method_name = "lemon";
$payload = file_get_contents('php://input');
$hash = hash_hmac('sha256', $payload, $secret);
$signature = $_SERVER['HTTP_X_SIGNATURE'] ?? null;
$event = $_SERVER['HTTP_X_EVENT_NAME'] ?? null;
if($hash !== $signature) {
    
	die("signature error");
	
}

$data = json_decode($payload);

$orderId = $data->data->id;
$status = $data->data->attributes->status;

$email = $data->data->attributes->user_email;
$subtotal_usd = $data->data->attributes->subtotal_usd;
$price = ($subtotal_usd / 100);

if($status == "paid") {
    $client = $conn->prepare("SELECT * FROM clients WHERE email=:email");
    $client->execute(array("email"=> $email));
    $client = $client->fetch(PDO::FETCH_ASSOC);
    
	$payment = $conn->prepare("SELECT * FROM payments INNER JOIN clients ON clients.client_id=payments.client_id WHERE payments.client_id=:clientid and payments.payment_amount=:amount and payment_delivery=1");
	$payment->execute(array("clientid"=> $client["client_id"], "amount" => $price));
	$payment = $payment->fetch(PDO::FETCH_ASSOC);
	
    if($payment) {
        var_dump($payment);
    	$payment_bonus  = $conn->prepare("SELECT * FROM payments_bonus WHERE bonus_method=:method && bonus_from<=:from ORDER BY bonus_from DESC LIMIT 1 ");
    	$payment_bonus  -> execute(array("method"=>$method,"from"=>$payment["payment_amount"]));
    	$payment_bonus  = $payment_bonus->fetch(PDO::FETCH_ASSOC);
    	if($payment_bonus):
    		$amount = ($payment["payment_amount"]+($payment["payment_amount"]*$payment_bonus["bonus_amount"]/100));
    	else:
    		$amount = $payment["payment_amount"];
    	endif;
    	$conn->beginTransaction();
    	$update   = $conn->prepare("UPDATE payments SET client_balance=:balance, payment_status=:status, payment_delivery=:delivery WHERE payment_id=:id ");
    	$update   = $update->execute(array("balance"=>$payment["balance"],"status"=>3,"delivery"=>2,"id"=>$payment["payment_id"]));
    	$balance  = $conn->prepare("UPDATE clients SET balance=:balance WHERE client_id=:id ");
    	$balance  = $balance->execute(array("id"=>$payment["client_id"],"balance"=>$payment["balance"]+$amount));
    	$insert= $conn->prepare("INSERT INTO client_report SET client_id=:c_id, action=:action, report_ip=:ip, report_date=:date ");
    				
    	if( $payment_bonus ):
    		$insert= $insert->execute(array("c_id"=>$payment["client_id"],"action"=>$method_name." API aracılığıyla %".$payment_bonus["bonus_amount"]." bonus dahil ".$amount." TL tutarında bakiye yüklendi","ip"=>GetIP(),"date"=>date("Y-m-d H:i:s") ));
    	else:
    		$insert= $insert->execute(array("c_id"=>$payment["client_id"],"action"=>$method_name." API aracılığıyla ".$amount." TL tutarında bakiye yüklendi","ip"=>GetIP(),"date"=>date("Y-m-d H:i:s") ));
    	endif;
    	if( $update && $balance ):
    		$conn->commit();
    	else:
    		$conn->rollBack();
    	endif;
    }
}