<?php
session_start();
$errors = array();

include 'database.php';
$db = mysqli_connect('localhost', 'root', '', 'computacaoNuvem');

require_once 'PHPMailer/class.phpmailer.php';
$mail = new PHPMailer();
$mail->IsSMTP();
$mail->SMTPSecure = "tls";
$mail->Host       = "smtp.gmail.com";
$mail->SMTPAuth = true;
$mail->Username = "computacaonuvem3@gmail.com";
$mail->Password = "computacao_nuvem7";
$mail->Port       = 587;
$mail->Timeout = 120;
$mail->SMTPDebug = 0;

$mail->FromName = "Games r us";

$mail->IsHTML(true);

