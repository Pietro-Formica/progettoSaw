<?php
include('config.php');
include('header.php');
if(!isset($_SESSION['logged_in']))
{
header("Location: ../Progetto_SAW/Index.php");
}
else
{
setcookie($cookie_name, '', time() - 1, $cookie_path, $cookie_domain);
session_destroy();
header("Location: ../Progetto_SAW/Index.php");
}
?>

