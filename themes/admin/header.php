<!DOCTYPE html>
<html lang='tr'>
<head>
<base href='<?=site_url()?>'>
<meta charset='utf-8'>
<meta http-equiv='X-UA-Compatible' content='IE=edge'>
<meta name='viewport' content='width=device-width, initial-scale=1'>
<title><?php

if(route(2) == 1 || route(2) == 'read' || route(1) == 'payment'){
echo title2('tr',route(1));    
}elseif(route(2) == 'payments' && route(1) == 'reports' ){
echo title2('tr',route(1));    
}elseif(route(2) == 'orders' && route(1) == 'reports' ){
echo title2('tr',route(1));    
}elseif(route(2)){
echo title2('tr',route(1),route(2));
}else{
echo title2('tr',route(1));
}
?>
</title>

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
<script src='https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js'></script>
<script src='https://oss.maxcdn.com/respond/1.4.2/respond.min.js'></script>
<![endif]-->  
<link href='/css/admin/custom.css' rel='stylesheet'>
<link rel='stylesheet' href='/css/admin/bootstrap.css'>
<link rel='stylesheet' href='/css/admin/style.css'>
<link rel='stylesheet' href='/css/admin/toastDemo.css'>
<link rel='stylesheet' href='/js/datepicker/css/bootstrap-datepicker3.min.css'>
<link rel='stylesheet' href='css/admin/tinytoggle.min.css' rel='stylesheet'>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.7.5/css/bootstrap-select.min.css'>
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css">



</head>
<body class='<?php if($user['admin_theme'] == 2){ echo 'dark-mode'; } ?>'>
<nav  class='navbar navbar-fixed-top navbar-default'>
<div class='container-fluid'>
<div class='navbar-header'>
<button type='button' class='navbar-toggle collapsed' data-toggle='collapse' data-target='#bs-navbar-collapse'>
<span class='sr-only'>Toggle navigation</span>
<span class='icon-bar'></span>
<span class='icon-bar'></span>
<span class='icon-bar'></span>
</button>
</div>
<div class='collapse navbar-collapse' data-nav='navbar-priority' id='bs-navbar-collapse'>
<ul id='navResponsive' class='nav navbar-nav navbar-left-block'>
<?php if( $user['access']['admin_access']  && $_SESSION['neira_adminlogin']  ): ?>
<?php if( $user['access']['users'] ): ?>
<li class='<?php if( route(1) == 'clients' ): echo 'active'; endif; ?>'><a href='<?php echo site_url('admin/clients') ?>'>Users</a></li>
<?php endif; ?>  
<?php if( $user['access']['orders'] ): ?>    
<li class='<?php if( route(1) == 'orders' ): echo 'active'; endif; ?>'><a href='<?php echo site_url('admin/orders') ?>'>Orders</a></li>
<?php endif; ?>
<?php if( $user['access']['subscriptions'] ): 

$a1 = countRow(['table'=>'services','where'=>['service_package'=>11]]);
$a2 = countRow(['table'=>'services','where'=>['service_package'=>12]]);
$a3 = countRow(['table'=>'services','where'=>['service_package'=>13]]);
$a4 = countRow(['table'=>'services','where'=>['service_package'=>14]]);
$a5 = countRow(['table'=>'services','where'=>['service_package'=>15]]);?>  

<?php if($a1>0 || $a2>0 || $a3>0 || $a4>0 || $a5>0):	?>
<li class='<?php if( route(1) == 'subscriptions' ): echo 'active'; endif; ?>'><a href='<?php echo site_url('admin/subscriptions') ?>'>Subscriptions</a></li>
<?php endif; endif; ?>
<?php if( $user['access']['dripfeed'] ): ?>  
<?php if(countRow(['table'=>'services','where'=>['service_dripfeed'=>2]])>0):	?>
<li class='<?php if( route(1) == 'dripfeeds' ): echo 'active'; endif; ?>'><a href='<?php echo site_url('admin/dripfeeds') ?>'> Drip-feed</a></li>
<?php endif; endif; ?>

<?php if( $user['access']['tasks'] ): ?>       
<?php if( countRow(['table'=>'tasks'])): ?>
<li class='<?php if( route(1) == 'tasks' ): echo 'active'; endif; ?>'><a href='<?php echo site_url('admin/tasks') ?>'>Tasks 
<?php if( countRow(['table'=>'tasks','where'=>['task_status'=>'pending']]) ): ?> 
<span class='badge' style='background-color: #6d47bb'><?=countRow(['table'=>'tasks','where'=>['task_status'=>'pending']]);?></span>
<?php endif; ?> 
</a></li> 
<?php endif; ?>
<?php endif; ?>


<?php if( $user['access']['services'] ): ?>    
<li class='<?php if( route(1) == 'services' ): echo 'active'; endif; ?>'><a href='<?php echo site_url('admin/services') ?>'>Services</a></li>
<?php endif; ?>  
<?php if( $user['access']['payments'] ): ?>
<li class='<?php if( route(1) == 'payments' ): echo 'active'; endif; ?>'><a href='<?php echo site_url('admin/payments') ?>'> Payments <?php if(countRow(['table'=>'payments','where'=>['payment_method'=>7,'payment_status'=>1]])): ?><span class='badge' style='background-color: #6d47bb'><?=countRow(['table'=>'payments','where'=>['payment_method'=>7,'payment_status'=>1]]);?></span> <?php endif; ?></a></li>
<?php endif; ?>     
<?php if( $user['access']['tickets'] ): ?>       
<li class='<?php if( route(1) == 'tickets' ): echo 'active'; endif; ?>'><a href='<?php echo site_url('admin/tickets') ?>'>Support <?php if( countRow(['table'=>'tickets','where'=>['client_new'=>2]]) ): ?> <span class='badge' style='background-color: #6d47bb'><?=countRow(['table'=>'tickets','where'=>['client_new'=>2]]);?></span><?php endif; ?> </a></li>
<?php endif; ?>

<?php if( $settings['panel_selling'] == 2 || countRow(['table'=>'child_panels','where'=>['panel_status'=>'active']])): ?>
<li class='<?php if( route(1) == 'child-panels' ): echo 'active'; endif; ?>'><a href='<?php echo site_url('admin/child-panels') ?>'>Child Panels 

<?php if( countRow(['table'=>'child_panels','where'=>['panel_status'=>'pending']]) ): ?> 

<span class='badge' style='background-color: #6d47bb'><?=countRow(['table'=>'child_panels','where'=>['panel_status'=>'pending']]);?></span>

<?php endif; ?> 
</a></li> 
<?php endif; ?>
<?php if( $user['access']['reports'] ): ?>
<li class='<?php if( route(1) == 'reports' ): echo 'active'; endif; ?>'><a href='<?php echo site_url('admin/reports') ?>'>Statistics</a></li> 
<?php endif; ?>          
<li class='<?php if( route(1) == 'appearance' ): echo 'active'; endif; ?>'><a href='<?php echo site_url('admin/appearance') ?>'>Appearance</a></li> 

<li class='<?php if( route(1) == 'settings' ): echo 'active'; endif; ?>'><a href='<?php echo site_url('admin/settings') ?>'>Settings</a></li>

<?php if( $user['access']['logs'] ): ?>
<li class='<?php if( route(1) == 'logs' || route(1) == 'provider_logs' || route(1) == 'guard_logs' ): echo 'active'; endif; ?>'><a href='<?php echo site_url('admin/logs') ?>'>logs <?php if(countRow(['table'=>'guard_log'])): ?>
<span class='badge' style='background-color: #6d47bb'><?=countRow(['table'=>'guard_log']);?></span>
<?php endif; ?></a></li> 
<?php endif; ?>
<?php endif; ?>

</ul>  
<ul id='w4' class='nav navbar-nav navbar-right'>
<?php 

if( $user['admin_theme'] == 2 ):
    echo "<li><a href='' data-toggle='modal' ><img src='https://d.top4top.io/p_2300sztz71.png' width='20' height='20'></a></li>";
else:
    echo "<li><a href='' data-toggle='modal' ><img src='https://d.top4top.io/p_2300sztz71.png' width='20' height='20'></a></li>";
endif;

$e = route(1);

if( $user['admin_theme'] == 2 ):
echo "<li class='nav-dark-mode'><a href='/admin?theme=1&refer=".$e."'><i class='fa fa-sun'></i></a></li>";
else:
echo "<li class='nav-dark-mode'><a href='/admin?theme=2&refer=".$e."'><i class='fa fa-moon'></i></a></li>";
endif;
?>

<li class='<?php if( route(1) == 'account' ): echo 'active'; endif; ?>'><a href='<?php echo site_url('admin/account') ?>'>Hesabım</a></li>      
<li><a href='<?php echo site_url('logout') ?>'>Çıkış Yap </a></li></ul>        
</div>
</div>
</nav>

<?php if($updateDetails['current'] != $updateDetails['last']): ?>
<script>alert('A new update is available! You need to update from the S icon on the admin panel menu.')</script>
<div class="col-md-12">
    <div class="alert alert-danger">
    A new update is available! You need to update from the S icon on the admin panel menu
    </div>
</div>
<?php endif; ?>  