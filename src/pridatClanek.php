<?php
include("pripojenislatte.php");
include("session.php");
function ulozeniDoDB($sqlConn, $kategorie, $nadpis, $popis){
  // Cesta kam se nahraje soubor
  $targetDir = "../img/";
  $fileName = basename($_FILES["img"]["name"]);
  $targetFilePath = $targetDir . $fileName;
  $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
  if(!isset($_POST["pridatClanek"]) || empty($_FILES["img"]["name"])) {
    return 'Je zapotřebí vybrat soubor k nahrání.';
  }
  if (file_exists($targetFilePath)) {
    return "Soubor ". strtoupper($fileName) ." již existuje.";
  }
  // Formáty fotky, které lze nahrát
  $allowTypes = array('jpg','png','jpeg','gif');
  if(!in_array($fileType, $allowTypes)) {
    return "Jsou povolené pouze soubory typu JPG, JPEG, PNG a GIF.";
  }
  // Nahrání fotky s její názvem pomocí cesty, kterou jsme si předdefinovali
  if(!move_uploaded_file($_FILES["img"]["tmp_name"], $targetFilePath)) {
    return "Nastal problém při nahrávání fotky " . strtoupper($fileName) . " v kategorii " . strtoupper($kategorie) . ".";
  }
  // Nahrání všech dat z formuláře do databáze vč. cesty k souboru
  $sql = "INSERT INTO $kategorie (nadpis, popis, foto) VALUES ('$nadpis', '$popis', '$fileName')";
  if ($sqlConn->query($sql) === TRUE) {
    return "Přidání článku do kategorie " . strtoupper($kategorie) . " proběhlo v pořádku";
  } else {
    return "Chyba: " . $sql . "<br>" . $sqlConn->error;
  }
}
$pridatClanek = isset($_POST['pridatClanek']);
if ($pridatClanek) {
  $kategorie=$_POST["articleCategory"];
  $nadpis=$_POST["articleName"];
  $popis=$_POST["articleContent"];
  switch ($kategorie) {
    case 'cisteni':
    $statusMsg = ulozeniDoDB($sqlConn, $kategorie, $nadpis, $popis);
    break;
    case 'sanace':
    $statusMsg = ulozeniDoDB($sqlConn, $kategorie, $nadpis, $popis);
    break;
    case 'vystavba':
    $statusMsg = ulozeniDoDB($sqlConn, $kategorie, $nadpis, $popis);
    break;
  }
}
$params = [
  'statusMsg' => $statusMsg,
];
$latte->render('../template/pridatClanek.latte', $params);
?>
