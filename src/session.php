<?php
// Zahájení sezení
session_start();

// Kontrola jestli je uživatel přihlášen, když ne, uživatel bude přesměrován na stránku s přihlášením
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
  header("location: ../index.php");
  exit;
}
?>
