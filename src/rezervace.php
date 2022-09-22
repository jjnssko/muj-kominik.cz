<?php
require('pripojenislatte.php');
require 'PHPMailer/PHPMailerAutoload.php';

$rezervovat = isset($_POST["rezervovat"]);
$jmenoprijmeni = $_POST["JmenoPrijmeni"];
$email = $_POST["email"];
$datum = $_POST["checkIn"];

if(!empty($jmenoprijmeni) && !empty($email) && !empty($datum) && empty($rezervovat)) {

  $sql = "INSERT INTO rezervace (JmenoPrijmeni, email, datum) VALUES ('$jmenoprijmeni', '$email', '$datum')";
  if ($sqlConn->query($sql) === TRUE) {
    $rezervaceMsg = "Děkujeme za rezervaci.";
  } else {
    $rezervaceMsg = "Chyba: " . $sql . "<br>" . $sqlConn->error;
  }

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
  $mail->Subject = 'Rezervace termínu od: ' . $jmenoprijmeni;
  $mail->Body = "Email: " . $email . " - " . $jmenoprijmeni . "<br>" . "Datum: " . $datum;
  $mail->isHTML(true);
  if(!$mail->send()) {
    // echo 'Message could not be sent.<br>';
    // echo 'Mailer Error: ' . $mail->ErrorInfo . '<br>';
} else {
    // echo 'Message has been sent<br>';
}

} else {
  $rezervaceMsg = "Některá pola nebyla vyplněna";
}
echo $rezervaceMsg;
?>
