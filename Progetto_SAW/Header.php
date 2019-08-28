<?php
if($_SERVER['REQUEST_URI'] === "/Progetto_SAW/Header.php") die("Accesso Negato");
ob_start();
session_start();
//connessione database
$db = new mysqli($db_host, $db_user, $db_pass, $db_name);
if(!isset($_SESSION['logged_in'])) 
{
    //controlla cookie
    if(isset($_COOKIE[$cookie_name]))
    {
        //estrae username e password dal cookie
        list($user, $pass) = explode('|', $_COOKIE[$cookie_name]);
        //preleva username e password dal database
        $select = $db->prepare("SELECT user_password FROM users_bd where username = ?");
        $select->bind_param('s', $user);
        $select->execute();
        $result = $select->get_result();
        
        if($result->num_rows == 1)
        {
            $row = $result->fetch_row();
            //confronta i due dati e se ok apre sessione
            if($row[0] == $pass)
            {
                $_SESSION['logged_in'] = 1;
                $_SESSION['username'] = $user;
            }
        }
    }
}
?>