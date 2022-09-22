<?php
include("pripojenislatte.php");
include("session.php");
$sql = "SELECT * FROM rezervace";
$result = $sqlConn->query($sql);
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $rezervace[]=array($row["id"],$row["JmenoPrijmeni"],$row["email"],$row["datum"],$row["datumVytvoreni"]);
  }
  for ($i=0; $i < count($rezervace); $i++) {
    $rezervace[$i][3] = array(substr($rezervace[$i][3],6), substr($rezervace[$i][3],3,-5), substr($rezervace[$i][3],0,-8));
  }
}


$params = [
  'rezervace' => $rezervace,
];
$latte->render('../template/seznamRezervaci.latte', $params);
?>
