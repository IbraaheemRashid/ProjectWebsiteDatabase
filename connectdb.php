<?php

$db_host = 'localhost';
$db_name = 'u_220070603_port3';
$username = 'u-220070603';
$password = 'HCaukO0s6aVe4rI';

try {
	$db = new PDO("mysql:host=$db_host;dbname=$db_name", $username, $password); 
	#$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $ex) {
	echo("Failed to connect to the database.<br>");
	echo($ex->getMessage());
	exit;
}
?>