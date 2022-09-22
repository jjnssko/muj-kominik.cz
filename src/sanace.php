<?php
include('pripojenislatte.php');

$sql = "SELECT nadpis,popis,foto FROM sanace";
$result = $sqlConn->query($sql);
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $sanace[]=array($row["nadpis"],$row["popis"],$row["foto"]);
  }
}

$pocetSanace = count($sanace);
$idSanace = 0;

include('footer.php');

$params = [
  'sanace' => $sanace,
  'pocetSanace' => $pocetSanace,
  'idSanace' => $idSanace,
  'location' => $location,
  'kontakt' => $kontakt,
];
$latte->render('../template/sanace.latte', $params);
?>
