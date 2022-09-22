<?php
include("pripojenislatte.php");
include("session.php");

$kategorie = $_POST["kategorie"];
$id = $_POST["articleID"];
$foto = isset($_POST["img"]);

$sql = "SELECT nadpis,popis,foto FROM $kategorie WHERE id = $id";
$result = $sqlConn->query($sql);
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $radek[]=array($row["nadpis"],$row["popis"],$row["foto"]);
  }
}
$params = [
  'kategorie' => $kategorie,
  'id' => $id,
  'radek' => $radek,
];
$latte->render('../template/editable.latte', $params);
?>
