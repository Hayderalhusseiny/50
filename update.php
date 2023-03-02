<?php

require __DIR__.'/lib/autoload.php';
require __DIR__.'/system/update_funds.php';
 
  error_reporting(1);
  
  $index1 = $conn->prepare("ALTER TABLE `orders` ADD INDEX(`client_id`)");
  $index1  -> execute(array());
  $index2 = $conn->prepare("ALTER TABLE `orders` ADD INDEX(`service_id`)");
  $index2  -> execute(array());
  $index3 = $conn->prepare("ALTER TABLE `orders` ADD INDEX(`api_orderid`)");
  $index3  -> execute(array());  
  $index4 = $conn->prepare("ALTER TABLE `orders` ADD INDEX(`order_api`)");
  $index4  -> execute(array());  
  $index5 = $conn->prepare("ALTER TABLE `orders` ADD INDEX(`api_serviceid`)");
  $index5  -> execute(array());  
  $index6 = $conn->prepare("ALTER TABLE `payments` ADD INDEX(`client_id`)");
  $index6  -> execute(array());
  $index7 = $conn->prepare("ALTER TABLE `payments` ADD INDEX(`client_balance`)");
  $index7  -> execute(array()); 
  $index8 = $conn->prepare("ALTER TABLE `payments` ADD INDEX(`payment_amount`)");
  $index8  -> execute(array());   
  $index9 = $conn->prepare("ALTER TABLE `payments` ADD INDEX(`payment_method`)");
  $index9  -> execute(array());   
  $index10 = $conn->prepare("ALTER TABLE `payments` ADD INDEX(`payment_status`)");
  $index10  -> execute(array());   

  unlink("error_log");
  header("Location: /admin/");