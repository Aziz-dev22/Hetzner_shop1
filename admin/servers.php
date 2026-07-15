<?php

require_once "../config/config.php";

require_once "../classes/Hetzner.php";


session_start();


if(!isset($_SESSION['admin'])){

    exit;

}


$hetzner = new Hetzner(
    HETZNER_TOKEN
);



$result =
$hetzner->list();



echo "<h2>Hetzner Servers</h2>";



if(
isset($result['body']['servers'])
){

foreach(
$result['body']['servers']
as $server
){


$id =
$server['id'];


$name =
$server['name'];


$ip =
$server['public_net']['ipv4']['ip'];


$status =
$server['status'];



echo "

<hr>

<b>ID:</b> $id

<br>

<b>Name:</b> $name

<br>

<b>IP:</b> $ip

<br>

<b>Status:</b> $status

<br><br>


<a href='action.php?poweron=$id'>
روشن
</a>


&nbsp;


<a href='action.php?poweroff=$id'>
خاموش
</a>


&nbsp;


<a href='action.php?delete=$id'>
حذف
</a>


";

}

}
