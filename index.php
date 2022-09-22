<?php
require_once("vendor/autoload.php");
$latte = new Latte\Engine;

$latte->setTempDirectory('temp');

include "config.php";

$sqlConn = new mysqli(DBSERVERNAME, DBUSERNAME, DBPASSWORD, DBNAME);

// SQL dotaz nastavující kódovou stránku pro komunikaci s DB serverem
$sql = "SET CHARACTER SET UTF8";
$sqlConn->query($sql);

if ($sqlConn->connect_error) {
  die("Připojení selhalo: " . $sqlConn->connect_error);
}



$sql = "SELECT nazev,popis FROM sluzby";
$result = $sqlConn->query($sql);

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $sluzba[]=array($row["nazev"],$row["popis"]);
  }
}

$sql = "SELECT foto FROM fotogalerie";
$result = $sqlConn->query($sql);

//$foto = $result->fetch_assoc();

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $foto[]=$row["foto"];
  }
}

$sql = "SELECT osobe,kominictvi,foto FROM omne";
$result = $sqlConn->query($sql);

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $omne[]=array($row["osobe"],$row["kominictvi"],$row["foto"]);
  }
}

$sql = "SELECT JmenoPrijmeni,Ulice,PSC,Telefon,Email,ico FROM kontakt";
$result = $sqlConn->query($sql);

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $kontakt[]=array($row["JmenoPrijmeni"],$row["Ulice"],$row["PSC"],$row["Telefon"],$row["Email"],$row["ico"]);
  }
}

$params = [
  'sluzba' => $sluzba,
  'foto' => $foto,
  'omne' => $omne,
  'kontakt' => $kontakt,
];
  $latte->render('template/index.latte', $params);
?>
