<?php
include('pripojenislatte.php');

$sql = "SELECT nadpis,popis,foto FROM vystavba";
$result = $sqlConn->query($sql);
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $vystavba[]=array($row["nadpis"],$row["popis"],$row["foto"]);
  }
}

$pocetVystavba = count($vystavba);
$idVystavba = 0;

include('footer.php');

$params = [
  'vystavba' => $vystavba,
  'pocetVystavba' => $pocetVystavba,
  'idVystavba' => $idVystavba,
  'location' => $location,
  'kontakt' => $kontakt,
];
$latte->render('../template/vystavba.latte', $params);
?>
