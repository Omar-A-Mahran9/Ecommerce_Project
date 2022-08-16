<?php
$dsn='mysql:host=localhost;dbname=shop';
$user='root';
$pass='';
$option=
array(
	PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
);

try{
$db = new PDO($dsn,$user,$pass,$option);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//echo "YOU ARE CONNECTED!";
}
catch(PDOException $e){
	echo 'Failed to connect'. $e->getMessage();
}