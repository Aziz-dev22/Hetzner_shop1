<?php

require_once "../config/config.php";

require_once "../classes/Database.php";
require_once "../classes/Logger.php";
require_once "../app/UserManager.php";
require_once "../app/PaymentManager.php";
require_once "../classes/Hetzner.php";


$hetzner =
new Hetzner(
HETZNER_TOKEN
);



if(isset($_GET['poweron'])){


$hetzner->powerOn(
$_GET['poweron']
);


}



if(isset($_GET['poweroff'])){


$hetzner->powerOff(
$_GET['poweroff']
);


}



if(isset($_GET['delete'])){


$hetzner->delete(
$_GET['delete']
);


}



header(
"Location: servers.php"
);

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
