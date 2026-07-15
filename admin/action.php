<?php

require_once "../config/config.php";

require_once "../classes/Database.php";
require_once "../classes/Logger.php";
require_once "../app/UserManager.php";
require_once "../app/PaymentManager.php";


session_start();


if(!isset($_SESSION['admin'])){

exit;

}



$db=Database::getInstance();

$users=new UserManager($db);

$log=new Logger();


$payments=new PaymentManager(
$db,
$users,
$log
);



if(isset($_GET['approve'])){


$payments->approve(
$_GET['approve']
);


}



header(
"Location: payments.php"
);
