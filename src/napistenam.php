<?php
include('pripojenislatte.php');
require 'PHPMailer/PHPMailerAutoload.php';

$jmenoaprijmeni = $_POST["name"];
$telefonnicislo = $_POST["phone"];
$emailovaadresa = $_POST["email"];
$poznamka = $_POST["note"];
$captcha = $_POST["verify"];
$location = $_POST["odkaz"];
$contactMsg = "";

$captching = "SELECT * FROM captcha";

if (!isset($_POST['name']) || !isset($_POST['phone']) || !isset($_POST['email']) || !isset($_POST['note'])) {
  $contactMsg = die('Omlouváme se, ale váš požadavek nemohl být zpracovaný, nebyly vyplněny všechna pole.');
}

if ($captcha == ($sqlConn->query($captching)->fetch_assoc())["hodnota"]) {

  $mail = new PHPMailer();

  $mail->IsSMTP();
  $mail->CharSet    = 'UTF-8';
  $mail->Host       = $_ENV["MAIL_HOST"];
  $mail->SMTPDebug  = 0;
  $mail->SMTPAuth   = true;
  $mail->SMTPSecure = 'ssl';
  $mail->Port       = 465;
  $mail->Username   = $_ENV["MAIL_USER"];
  $mail->Password   = $_ENV["MAIL_PASSWORD"];
  $mail->From       = $_ENV["MAIL_USER"];
  $mail->FromName  = $_ENV["MAIL_NAME"];
  $mail->addAddress($_ENV["MAIL_USER"], $_ENV["MAIL_NAME"]);
  $mail->Subject = 'Kontaktoval vás: ' . $jmenoaprijmeni;
  $mail->Body = "Email: " . $emailovaadresa . " - " . $jmenoaprijmeni . "<br>" . "Telefonní číslo: " . $telefonnicislo . "<br>" . "Obsah zprávy: " . $poznamka;
  $mail->isHTML(true);
  if(!$mail->send()) {
    // echo 'Message could not be sent.<br>';
    // echo 'Mailer Error: ' . $mail->ErrorInfo . '<br>';
} else {
    // echo 'Message has been sent<br>';
}

  $sql = "INSERT INTO napistenam (osoba,telefon,email,poznamka) VALUES ('$jmenoaprijmeni', '$telefonnicislo', '$emailovaadresa', '$poznamka')";

  if ($sqlConn->query($sql) === TRUE) {
    $contactMsg = "Děkujeme, že jste nám napsali!";
  } else {
    $contactMsg = "Chyba: " . $sql . "<br>" . $sqlConn->error;
  }
  echo $contactMsg;
}
header("Location: " . "http://" . $_SERVER['HTTP_HOST'] . $location);
?>
