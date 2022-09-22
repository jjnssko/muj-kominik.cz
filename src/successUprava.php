<?php
include("pripojenislatte.php");
include("session.php");

$kategorie = $_POST["kategorie"];
$id = $_POST["articleID"];
$sql = "SELECT nadpis,popis,foto FROM $kategorie WHERE id = $id";
$result = $sqlConn->query($sql);
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $radek[]=array($row["nadpis"],$row["popis"],$row["foto"]);
  }
}
$targetDir = "../img/";
$nadpis = $_POST["nadpis"];
$popis = $_POST["popis"];
$foto = basename($_FILES["img"]["name"]);
$fotoVdb = $targetDir . $radek[0][2];
function aktualizaceDoDB($sqlConn, $kategorie, $nadpis, $popis, $foto, $id) {
  // Cesta kam se nahraje soubor
  $targetDir = "../img/";
  $targetFilePath = $targetDir . $foto;
  $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
  if (file_exists($targetFilePath)) {
    $sql = "UPDATE $kategorie SET nadpis = '$nadpis', popis = '$popis' WHERE id = $id";
    if ($sqlConn->query($sql) === TRUE) {
      return "Aktualizování článku do kategorie " . strtoupper($kategorie) . " proběhlo v pořádku";
    } else {
      return "Chyba: " . $sql . "<br>" . $sqlConn->error;
    }
  }
  // Formáty fotky, které lze nahrát
  $allowTypes = array('jpg','png','jpeg','gif');
  if(!in_array($fileType, $allowTypes)) {
    return "Jsou povolené pouze soubory typu JPG, JPEG, PNG a GIF.";
  }
  // Nahrání fotky s její názvem pomocí cesty, kterou jsme si předdefinovali
  if(!move_uploaded_file($_FILES["img"]["tmp_name"], $targetFilePath)) {
    return "Nastal problém při nahrávání fotky " . strtoupper($foto) . " v kategorii " . strtoupper($kategorie) . ".";
  }
  // Nahrání všech dat z formuláře do databáze vč. cesty k souboru
  $sql = "UPDATE $kategorie SET nadpis = '$nadpis',popis = '$popis',foto = '$foto' WHERE id = $id";
  if ($sqlConn->query($sql) === TRUE) {
    return "Aktualizování článku do kategorie " . strtoupper($kategorie) . " proběhlo v pořádku";
  } else {
    echo "Chyba: " . $sql . "<br>" . $sqlConn->error;
  }
}
$sql = "SELECT nadpis,popis,foto FROM $kategorie WHERE id = $id";
$result = $sqlConn->query($sql);
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $radek[]=array($row["nadpis"],$row["popis"],$row["foto"]);
  }
}
if (file_exists($_FILES['img']['tmp_name']) && is_uploaded_file($_FILES['img']['tmp_name'])) {
  unlink($fotoVdb);
  $sql = "UPDATE $kategorie SET foto = '' WHERE id = $id";
  $result = $sqlConn->query($sql);
  if ($sqlConn->query($sql) === TRUE) {
  } else {
    echo "Chyba: " . $sql . "<br>" . $sqlConn->error;
  }
  $statusMsg = aktualizaceDoDB($sqlConn, $kategorie, $nadpis, $popis, $foto, $id);

} else {
  $sql = "UPDATE $kategorie SET nadpis = '$nadpis', popis = '$popis' WHERE id = $id";
  if ($sqlConn->query($sql) === TRUE) {
    $statusMsg = "Aktualizování článku do kategorie " . strtoupper($kategorie) . " proběhlo v pořádku";
  } else {
    $statusMsg = "Chyba: " . $sql . "<br>" . $sqlConn->error;
  }
}
header("refresh:2.5; upravitClanek.php");

$params = [
  'statusMsg' => $statusMsg,
];
$latte->render('../template/successUprava.latte', $params);
?>
