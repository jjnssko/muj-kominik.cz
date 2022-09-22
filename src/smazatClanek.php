<?php
include("pripojenislatte.php");
include("session.php");


function createElementSelectOptions($sqlConn, $nazevTabulky) {
  $sql = "SELECT id,nadpis FROM $nazevTabulky WHERE NOT id=1 AND NOT id=2";
  $result = $sqlConn->query($sql);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $nadpisy[]=array($row["id"],$row["nadpis"]);
    }
  }
  echo "<option value='default'>Výběr článku</option>";
  foreach($nadpisy as $nadpis) {
    echo "<option value='" . $nadpis[0] . "'>" . $nadpis[1] . "</option>";
  }
}

function minusRow($sqlConn, $nazevTabulky, $id) {
  $targetDir = "../img/";

  $sql = "SELECT foto FROM $nazevTabulky WHERE id = $id";
  $result = $sqlConn->query($sql);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $fotoName=$row["foto"];
    }
  }
  $targetFilePath = $targetDir . $fotoName;

  if (!file_exists($targetFilePath)) {
    return "Nelze odstranit " . strtoupper($fotoName) . ", soubor neexistuje";
  }
  unlink($targetFilePath);
  $sql = "DELETE FROM $nazevTabulky WHERE id = $id";
  $result = $sqlConn->query($sql);
  if ($sqlConn->query($sql) === TRUE) {
    return "Smazání článku z kategorie " . strtoupper($nazevTabulky) . " proběhlo úspěšně.";
  } else {
    return "Chyba: " . $sql . "<br>" . $sqlConn->error;
  }
  header("Location: smazatClanek.php");
}



$kategorie = $_REQUEST["kategorie"];
$id = $_REQUEST["articleID"];
if(isset($kategorie)) {
  switch ($kategorie) {
    case 'cisteni':
    createElementSelectOptions($sqlConn, "cisteni");
    break;

    case 'sanace':
    createElementSelectOptions($sqlConn, "sanace");
    if(isset($_POST["smazatClanek"])) {
      minusRow($sqlConn, "sanace", $id);
    }
    break;

    case 'vystavba':
    createElementSelectOptions($sqlConn, "vystavba");
    if(isset($_POST["smazatClanek"])) {
      minusRow($sqlConn, "vystavba", $id);
    }
    break;

    case 'default':
    echo "<option value='default'>Výběr článku</option>";
    break;
  }
}
if ($kategorie) {
} elseif($obsah) {
} else {
  $params = [
  ];
  $latte->render('../template/smazatClanek.latte', $params);
}
?>
