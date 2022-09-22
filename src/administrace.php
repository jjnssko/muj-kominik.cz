<?php
require_once("../vendor/autoload.php");
$latte = new Latte\Engine;

$latte->setTempDirectory('../temp');

// include "../config.php";
//
// $sqlConn = new mysqli(DBSERVERNAME, DBUSERNAME, DBPASSWORD, DBNAME);
//
// $sqlConn->set_charset("utf8");
//
// if ($sqlConn->connect_error) {
//   die("Připojení selhalo: " . $sqlConn->connect_error);
// }

session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../index.php");
    exit;
}


$params = [
];
$latte->render('../template/administrace.latte', $params);
?>
