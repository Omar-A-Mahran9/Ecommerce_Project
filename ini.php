<?php
//Errpr Reporting 
ini_set('display_errors','on');
error_reporting(E_ALL);

//connect data base
include "admin/connect.php";

$sesionUser=" ";
if (isset($_SESSION['User'])){
    $sesionUser=$_SESSION['User'];
}
//Routes
$tbl="includes/templates/"; //templete dirictory
$lan="includes/language/"; //language directory
$fun="includes/functions/";//function directory
$css="layout/css/"; //css directory
$js="layout/js/";  //js directory


//important files
include $fun . "function.php";
include $lan . "english.php";
include $tbl . "header.php";

?>
