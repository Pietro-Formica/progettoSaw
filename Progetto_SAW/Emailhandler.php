<?php
if($_SERVER['REQUEST_URI'] === "/Progetto_SAW/Emailhandler.php") die("Accesso Negato");
use PHPMailer\PHPMailer\PHPMailer;
include('config.php');
include('./src/PHPMailer.php');
include('./src/SMTP.php');
include('./src/Exception.php');

$mail = new PHPMailer(false);
$mail->IsSMTP();
$mail->CharSet="UTF-8";
$mail->SMTPSecure = 'tls';
$mail->Host = 'smtp.gmail.com';
$mail->Port = 587;
$mail->Username = 'armatore.saw@gmail.com';
$mail->Password = 'sto cazzo12';
$mail->SMTPAuth = true;
$mail->setFrom('armatore.saw@gmail.com', 'Maurizio_Fuoco_e_Fiamme');

$db = new PDO('mysql:host='.$db_host.';dbname='. $db_name, $db_user, $db_pass);
$select = $db->prepare("SELECT user_email FROM users_bd");
$select->execute();
$row = $select->fetchAll();
$mail->Subject = 'Nuova Aria';
$mail->Body = 'Sono presenti nuove Fragranze';
foreach ($row as $userEmail)
{
    $mail->ClearAddresses();
    $mail->addAddress($userEmail[0]); 
    $mail->send();
} 	
?>