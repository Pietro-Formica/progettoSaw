<?php
include('config.php');
include('header.php');
//controlla se la sessione è già attiva
if(!isset($_SESSION['logged_in']))
{
  header("Location: ../Progetto_SAW/Index.php");
} 
if(isset($_POST['opsw']))
{
    if(!empty($_POST['opsw']) && !empty($_POST['npsw']) && !empty($_POST['rpsw'])){
      if($_POST['npsw'] != $_POST['rpsw']) exit('error_psw_mismatch');
      $user = $_SESSION["username"];
      $select = $db->prepare("SELECT user_password FROM users_bd where username = ?");
      $select->bind_param("s", $user);
      $select->execute();
      $result = $select->get_result();
      if($result->num_rows == 0) die('error_user_not_exist');
      $row = $result->fetch_assoc();
      $pass = md5($_POST['opsw']);
      if($row['user_password'] == $pass){
        $pass = md5($_POST['npsw']);
        $select = $db->prepare("UPDATE users_bd SET user_password = ? WHERE username = ? ");
        $select->bind_param("ss", $pass, $user);
        $select->execute();
        if($select->affected_rows <= 0) exit("no");
        exit('ok');
      }
      exit('pass_error');
    }
    exit('input_error');
}

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Cambia Password</title>
    <link rel="stylesheet" href="login-style.css">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  </head>
  <body>
    <form action="cambia-password.php" method="POST" id='form-cambiapassword'>
    <div class="login-box" >
        <h1>Modifica</h1>

        <div class="textbox">
        <i class="fas fa-lock"></i>
          <input type="password" placeholder="Password..." name="opsw" id="id-oldpassword" value="">
        </div>

        <div class="textbox">
        <i class="fas fa-lock"></i>
          <input type="password" placeholder="New Password..." name="npsw" id="id-newpassword" value="">
        </div>

        <div class="textbox">
        <i class="fas fa-lock"></i>
          <input type="password" placeholder="repeat Password..." name="rpsw" id="id-repitnewpassword" value="">
        </div>

        <br>
            <input class="btn" type="submit" name="submit" id="id-save" value="Save">
    </div>     
    </form>
    <script>
    $('#form-cambiapassword').submit(function(event){
      event.preventDefault();
      var inputs = $('#form-cambiapassword').serialize();
      var postring = $.post('cambia-password.php',inputs);
      postring.done(function(response){
        alert(response);
      });

    });
  </script>
  </body>

</html>
