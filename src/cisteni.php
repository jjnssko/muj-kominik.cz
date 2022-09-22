<?php
include('pripojenislatte.php');

$sql = "SELECT nadpis,popis,foto FROM cisteni";
$result = $sqlConn->query($sql);
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $cisteni[]=array($row["nadpis"],$row["popis"],$row["foto"]);
  }
}

$pocetCisteni = count($cisteni);
$idCisteni = 0;

$sql = "SELECT JmenoPrijmeni,Ulice,PSC,Telefon,Email,ico FROM kontakt";
$result = $sqlConn->query($sql);

include('footer.php');

$params = [
  'cisteni' => $cisteni,
  'pocetCisteni' => $pocetCisteni,
  'idCisteni' => $idCisteni,
  'location' => $location,
  'kontakt' => $kontakt,
];
$latte->render('../template/cisteni.latte', $params);
?>
