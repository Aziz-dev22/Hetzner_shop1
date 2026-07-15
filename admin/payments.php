<?php

require_once "../config/config.php";

require_once "../classes/Database.php";


session_start();


if(!isset($_SESSION['admin'])){

exit;

}



$db=Database::getInstance();



$result=$db->query(
"SELECT * FROM payments ORDER BY id DESC"
);



echo "<h2>Payments</h2>";



while($p=$result->fetch_assoc()){


echo "

<hr>

Order:
{$p['order_id']}

<br>

User:
{$p['user_id']}

<br>

Amount:
{$p['amount']}

<br>

Method:
{$p['method']}

<br>

Currency:
{$p['currency']}

<br>

TXID:
{$p['txid']}

<br>

Status:
{$p['status']}

<br>


<a href='action.php?approve={$p['order_id']}'>
Approve
</a>


";

}
