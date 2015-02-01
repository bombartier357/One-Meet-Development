<?php
include('blockchainClass.php');
$blockchain = new blockChainClass();
$balance = $blockchain->get_balance();
echo $balance;
?>
