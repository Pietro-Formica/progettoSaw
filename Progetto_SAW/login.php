<?php
include('config.php');
include('header.php');
//controlla se la sessione è già attiva
if(isset($_SESSION['logged_in']))
{
  header("Location: ../Progetto_SAW/Index.php");
} 
if(isset($_POST['login']))
{
  if(!empty($_POST['usernamelol']) && !empty($_POST['passwordlol']))
  {
    $psw = md5($_POST['passwordlol']);
    $select = $db->prepare("SELECT username, user_password FROM users_bd WHERE username = ? AND user_password = ?");
    $select->bind_param("ss", $_POST['usernamelol'], $psw);
    $select->execute();
    $result = $select->get_result();
    if($result->num_rows == 0){die("error_no_user");}
    $row = $result->fetch_assoc();
  }
  else die('error_empty');
  // se tutto ok effettuo il login altrimenti stampo errori
  $_SESSION['logged_in'] = 1;
  $_SESSION['username'] = $row['username']; 
  //se abbiamo spuntato il campo ricordami creo il cookie
  if(isset($_POST['switch1']) && !empty($_POST["switch1"]) && $_POST["switch1"] === "true")
  {   
    $cookie_value = $row['username'].'|'. $row['user_password'];
    setcookie($cookie_name, $cookie_value, time() + $cookie_time, $cookie_path, $cookie_domain);   
  }
  die("ok");
}

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Login</title>
    <link rel="stylesheet" href="login-style.css">
  </head>
  <body>
      <div class="login-box" >
        <h1>Login</h1>
        <div class="textbox">
        <i class="fas fa-user"></i>
          <input type="text" placeholder="Username..." name="username" id="id-username" value="">
        </div>

        <div class="textbox">
        <i class="fas fa-lock"></i>
          <input type="password" placeholder="Password..." name="psw" id="id-password" value="">
        </div>

        <div class="custom-control custom-switch">
          <br>
          <input type="checkbox" class="custom-control-input" id="switch1" name="switch1">
          <label class="custom-control-label" for="switch1">Remember me</label>
        </div>
        <br>
        <a class='forgot' href='Registration.php'>Already have an account?</a>
        <br>
        <br>
        <input class="btn" type="button" name="submit" id="id-login" value="Login">


      </div>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="crossorigin="anonymous"></script>
    <script type="text/javascript">
      $(document).ready(function(){
        $("#id-login").on("click", function(){
          var username = $("#id-username").val();
          var password = $("#id-password").val();
          var remember = $("#switch1").prop('checked');
          if(username =="" || password =="")
            alert("Pelase check your inputs.");
          else{
            $.ajax({
            type: "POST",
            url: "login.php",
            data: {
              login: 1,
              switch1: remember,
              usernamelol: username,
              passwordlol: password,
            },
            success: function(response){
              if(response == "ok"){
                window.location = "Index.php";
              }else if(response == "error_no_user"){
                alert("Invalid username or password.");
                svuota($("#id-password"));
              }else if(response == "error_empty"){
                alert("Pelase check your inputs.");
              }
            },
            dataType: "text"
          })
          }          
        });
      });
      function svuota(i1){
        i1.val("");
        i1.focus();
      }
    </script>
  </body>
</html>