<?php
$location = $_SERVER['REQUEST_URI'];
$sql = "SELECT JmenoPrijmeni,Ulice,PSC,Telefon,Email,ico FROM kontakt";
$result = $sqlConn->query($sql);
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $kontakt[]=array($row["JmenoPrijmeni"],$row["Ulice"],$row["PSC"],$row["Telefon"],$row["Email"],$row["ico"]);
  }
}
?>
