<?php
include('config.php');
include('header.php');
if(!isset($_SESSION["logged_in"])) header("Location: ../Progetto_SAW/login.php");
function retriveData($db){

    $select = $db->prepare("SELECT nome, cognome, username, user_email FROM users_bd WHERE username = ?");
    $select->bind_param("s", $_SESSION["username"]);
    $select->execute();
    $result = $select->get_result();
    $row = $result->fetch_assoc();

    exit(json_encode($row)); 
}

function checkpassword($db){
    $select = $db->prepare("SELECT user_password FROM users_bd where username = ?");
    $user = $_SESSION["username"];
    $select->bind_param('s', $user);
    $select->execute();
    $result = $select->get_result();
    if($result->num_rows == 1){
        $row = $result->fetch_row();
        $password = md5($_POST['passwordlol']);
        if($row[0] == $password) exit("ok");
    }
    exit("no");    
}

function updateuser($db){
$user = $_SESSION["username"];
$select = $db->prepare("UPDATE users_bd SET nome = ?,cognome = ?, username = ?, user_email = ? WHERE username = ? ");
    $select->bind_param("sssss", $_POST["nomelol"], $_POST["cognomelol"], $_POST['usernamelol'],$_POST['emaillol'],$user);
    $select->execute();
    if($select->affected_rows <= 0) exit("no");
    $_SESSION["username"] = $_POST["usernamelol"];
    exit("ok");
}



if (isset($_POST['action']) && !empty($_POST['action'])) {
    switch ($_POST['action']) {
        case 'retrive': retriveData($db);
            break;
        case 'check' : checkpassword($db);
            break;
        case 'update' : updateuser($db);
            break;
        default : die('request error');
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Profile</title>
    <link rel="stylesheet" href="profile-style.css">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>


</head>
<body>
<h2>Profile</h2>
    <div class='Profile'>
        <form action="#"id="formModifica">
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
                <input name='email' placeholder='E-Mail Address' type='email' id="id-email" required>
            </div>
            <br>
            <button type="submit" id="id-conferma" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Conferma</button>
            <input type="button" class="btn btn-info btn-lg"id="id-cambiapassword"value="Cambia Password">
        </form>
    </div>
    


        <form action="#" id = "formSave">
        <div class="container">
  <!-- Trigger the modal with a button -->
 

  <!-- Modal -->
  <div class="modal fade" id="myModal">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header text-center">
          <button type="button" class="close" data-dismiss="modal">&times;</button>

        </div>
        <div class="modal-body">

            <div>

                    <i class="fas fa-lock"></i>
                    <input name='pswmodal' placeholder='Password' type='password' id="id-modalpassword">

            </div>

        </div>
        <div class="modal-footer">
          <input type="submit"  value="Save">
         

        </div>

      </div>
      
    </div>
  </div>
  
    </div>
    </form>





    



    
    <script>
        $(document).ready(function(){
            var form = $(this),
            url = form.attr("action");

            var ret =$.post(url,{action: "retrive"});
            ret.done(function (data)
            {
                var result =JSON.parse(data);
                $("#id-nome").val(result.nome);
                $("#id-cognome").val(result.cognome);
                $("#id-username").val(result.username);
                $("#id-email").val(result.user_email);
 
            });
        });

        $("#formSave").submit(function(event){
            event.preventDefault();


            var nome = $("#id-nome").val();
            var cognome = $("#id-cognome").val();
            var username = $("#id-username").val();
            var password = $("#id-modalpassword").val();
            var email = $("#id-email").val();


            var control = $.post("profile.php",{action: "check",passwordlol: password});

            control.done(function(response){
                if(response == "ok"){
                    $("#myModal").modal("hide");
                    var update = $.post("profile.php",{action: "update",nomelol: nome,cognomelol: cognome,usernamelol: username,emaillol: email})
                    update.done(function(resp){
                        alert(resp);
                        if(resp == "no"){
                            alert("ok")        
                        }
                    });
                }else{
                    $("#myModal").animate({ "left": "+=50px" }, 100 );
                    $("#myModal").animate({ "left": "-=50px" }, 100 );
                    $("#myModal").animate({ "left": "-=50px" }, 100 );
                    $("#myModal").animate({ "left": "+=50px" }, 100 );
                    $("#id-modalpassword").val("");
                    $("#id-modalpassword").focus();
                    
                }
            });           
        });

        $("#id-cambiapassword").click(function(event){
            event.preventDefault();
            window.location = "cambia-password.php";

        });
        $("#id-conferma").click(function(event){
            event.preventDefault();

        });

      /*  $(document).ready(function(){ //da cambiare
        $("#id-register").on("click", function(){

            if(username =="" || email == "" || nome == "" || congnome == "")
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
        });*/
  </script>
</body>
</html>