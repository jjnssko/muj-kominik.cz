<?php
require("vendor/autoload.php");

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$dotenv->required(['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS']);

define ("DBSERVERNAME", $_ENV["DB_HOST"]);
define ("DBUSERNAME", $_ENV['DB_USER']);
define ("DBPASSWORD", $_ENV['DB_PASS']);
define ("DBNAME", $_ENV['DB_NAME']);

?>