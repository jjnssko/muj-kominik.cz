<?php
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

define ("DBSERVERNAME", $_ENV["DB_HOST"]);
define ("DBUSERNAME", $_ENV['DB_USER']);
define ("DBPASSWORD", $_ENV['DB_PASS']);
define ("DBNAME", $_ENV['DB_NAME']);

/* Pokus o pripojení se k MySQL databázi */
$link = mysqli_connect(DBSERVERNAME, DBUSERNAME, DBPASSWORD, DBNAME);

// Kontrola pripojení
if($link === false){
    die("ERROR: Nelze se pripojit. " . mysqli_connect_error());
}
?>
