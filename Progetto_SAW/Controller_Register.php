<?php
    require "Registrazione_User.php";
    require "Connection_Db.php";

        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $username = $_POST['username'];
        $email =  $_POST['email'];
        $password = $_POST['password'];
        $connector = new connector_DB();
        $connection = $connector->getConnection();

        $control = new UserRegister();

        if($control->validUsername($username) && $control->validEmail($email) && $control->validName($name) && $control->validPassword($password) && $control->validSurname($surname)){
            if($control->check_user($email, $connection)){
                if($control->insertUser($name, $surname, $email, $username, $password, $connection))
                header("Location: ../Progetto_SAW/Login.html");
            }
        }
        die("qualcosa è andato storto");



    


    



































?>