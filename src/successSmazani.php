<?php
include("pripojenislatte.php");
include("session.php");

$nazevTabulky = $_POST["kategorie"];
$id = $_POST["articleID"];
$statusMsg;
$targetDir = "../img/";

$sql = "SELECT foto FROM $nazevTabulky WHERE id = $id";
$result = $sqlConn->query($sql);
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $fotoName=$row["foto"];
  }
}
$targetFilePath = $targetDir . $fotoName;
unlink($targetFilePath);
$sql = "DELETE FROM $nazevTabulky WHERE id = $id";
$result = $sqlConn->query($sql);
if ($sqlConn->query($sql) === TRUE) {
  $statusMsg = "Smazání článku z kategorie " . strtoupper($nazevTabulky) . " proběhlo úspěšně.";
} else {
  $statusMsg = "Chyba: " . $sql . "<br>" . $sqlConn->error;
}
header("refresh:2.5; smazatClanek.php");

$params = [
  'statusMsg' => $statusMsg,
];
$latte->render('../template/successSmazani.latte', $params);
?>
