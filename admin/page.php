<?php


$do=isset($_GET['do'])?$_GET['do']:"Manage";




/*
$do='';
if(isset($_GET['do'])){

	$do = $_GET['do'];

}
else{

	$do ="Manage";

}
*/
if ($do=="Manage"){

 echo "Welcome You are In Manage category Page";

}elseif($do=="add"){

	echo "Welcome You are In add category Page";
}elseif($do="insert"){
	echo "Welcome You are In insert category page";
}
else{
	echo 'Error There\'s no page with this name';
}