<?php
if($_SERVER['REQUEST_URI'] === "/Progetto_SAW/Config.php") die("Accesso Negato");
$db_host = 'localhost';
$db_name = 'database_saw';
$db_user = 'root';
$db_pass = '';

$cookie_name = 'user_session';
$cookie_time = 3600;
$cookie_path = '/' ;
$cookie_domain = NULL;
?>