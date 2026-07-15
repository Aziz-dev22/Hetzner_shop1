<?php

require_once "config/config.php";

require_once "classes/Database.php";
require_once "classes/Logger.php";
require_once "classes/Hetzner.php";

require_once "app/ServerManager.php";
require_once "app/SubscriptionManager.php";



$db =
Database::getInstance();


$logger =
new Logger();



$hetzner =
new Hetzner(
HETZNER_TOKEN
);



$servers =
new ServerManager(
    $hetzner,
    $logger
);



$subscription =
new SubscriptionManager(
    $db,
    $servers,
    $logger
);



$subscription->checkExpired();


echo "Cron completed";
