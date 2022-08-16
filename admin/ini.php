<?php

//Routes
include "connect.php";
$tbl="includes/templates/"; //templete dirictory
$lan="includes/language/"; //language directory
$fun="includes/functions/";//function directory
$css="layout/css/"; //css directory
$js="layout/js/";  //js directory


//important files
include $fun . "function.php";
include $lan . "english.php";
include $tbl . "header.php";



// all pages expect pages

if(!isset($noNavbar)){ include $tbl . "navbar.php"; }
?>
