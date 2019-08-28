<?php
include('config.php');
include('header.php');

//controlla se l'utente è già loggato
if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == 1) header("Location: ../Progetto_SAW/Index.php");
if(isset($_POST['login']))
{
  // controllo dati immessi dall'utente
  if(empty($_POST['usernamelol']) || empty($_POST['emaillol']) || empty($_POST['passwordlol']) || empty($_POST['passwordlol2']))
  {
    die('error_empty');
  }
  // controllo se il nome utente è già presente nel database
  $select = $db->prepare("SELECT user_id FROM users_bd where username = ?");
  $select->bind_param("s", $_POST['usernamelol']);
  $select->execute();
  $result = $select->get_result();
  if($result->num_rows > 0) die('error_user_exist');
  $row = $result->fetch_assoc();
  
  // verifica conferma password
  if($_POST['passwordlol'] != $_POST['passwordlol2']) die('error_psw_mismatch');
  // verifica se la email è nella forma giusta
  if(!filter_var($_POST['emaillol'],FILTER_VALIDATE_EMAIL)) die('error_email');
  // registriamo l'utente nel database
  $password = md5($_POST['passwordlol']);
  $select = $db->prepare("INSERT INTO users_bd (nome, cognome, username, user_password, user_email) VALUES (?, ?, ?, ?, ?)");
  //$select = $db->prepare("INSERT INTO users_bd VALUES (DEFAULT, ?, ?, ?)");
  $select->bind_param("sssss", $_POST["nomelol"], $_POST["cognomelol"], $_POST['usernamelol'], $password, $_POST['emaillol']);
  $select->execute();
  if($db->errno != 0) die('error_insert');
  // avvisa utente
  die('ok');
  header("Location: ../Progetto_SAW/Login.php"); //mettere in js	
}
// il modulo non è stato inviato

?>

<!DOCTYPE html>
<html>
<head>
  <title>Registration</title>
  <link rel="stylesheet" href="registation-style.css">
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
</head>
<body>
  <div class='Register'>
    <h2>Register</h2>
    <div>
      <input name='nome' placeholder='Nome' type='text' id="id-nome" required>
    </div>
    
    <div>
      <input name='cognome' placeholder='Cognome' type='text' id="id-cognome" required>
    </div>
    
    <div>
      <input name='username' placeholder='Username' type='text' id="id-username" required>
    </div>
    
    <div>
      <input name='psw' placeholder='Password' type='password' id="id-password" required>
    </div>
    
    <div>
      <input name='psw-repeat' placeholder='repeat Password' type='password' id="id-password2" required>
    </div>
    
    <div>
      <input name='email' placeholder='E-Mail Address' type='email' id="id-email" required>
    </div>
    
    <br>
    <input class='animated' type='submit'name="submit" value='Register' id="id-register">
    <br>
    <a class='forgot' href='login.php'>Already have an account?</a>
  </div>
  <script>
    $(document).ready(function(){
      $("#id-register").on("click", function(){
        var nome = $("#id-nome").val();
        var cognome = $("#id-cognome").val();
        var username = $("#id-username").val();
        var password = $("#id-password").val();
        var password2 = $("#id-password2").val();
        var email = $("#id-email").val();
        if(username =="" || password =="" || password2 == "" || email == "" || nome == "" || congnome == "")
        alert("Pelase check your inputs.");
        else{
          $.ajax({
            type: "POST",
            url: "Registration.php",
            data: {
              login: 1,
              nomelol: nome,
              cognomelol: cognome,
              usernamelol: username,
              passwordlol: password,
              passwordlol2: password2,
              emaillol: email,
            },
            success: function(response){
              alert(response);
              if(response == "ok"){
                alert("Registration Success.");
                window.location = "login.php";
              }else if(response == "error_user_exist"){
                alert("Invalid username");
              }else if(response == "error_empty"){
                alert("Pelase suca");
              }
            },
            dataType: "text"
          })
        }          
      });
    });
  </script>
</body>
</html>