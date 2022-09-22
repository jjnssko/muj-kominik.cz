<?php
require_once("../vendor/autoload.php");
$latte = new Latte\Engine;

$latte->setTempDirectory('../temp');

include "../config.php";

$sqlConn = new mysqli(DBSERVERNAME, DBUSERNAME, DBPASSWORD, DBNAME);

$sqlConn->set_charset("utf8");

if ($sqlConn->connect_error) {
  die("Připojení selhalo: " . $sqlConn->connect_error);
}
?>
