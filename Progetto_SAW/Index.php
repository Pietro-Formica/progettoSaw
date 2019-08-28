<?php
include('config.php');
include('header.php');
if(isset($_SESSION['logged_in']))
    if(isset($_GET['question']))
    exit('yes');
/*<img src="http://phpstack-180429-745585.cloudwaysapps.com/unitedpets/img/slider/slide1-parallax.jpg" style="z-index: 1" alt="">
        */ 

?>




<!DOCTYPE html>
<html>
    <head>
        <title>Shop Maurizio</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
        <link rel="stylesheet" href="index-style.css">
    </head>
    <body>
        <nav class = "navbar bg-dark navbar-light">
            <i class="fas fa-wine-bottle" style="font-size:4em; color : white"></i>
            <div class = "float-right">
            <a class="button"  href="login.php" style="font-size:2em; color : white; padding:15px;"><i class="fas fa-sign-in-alt" id = "myBtn"></i></a>  
            <a class="button" href="Logout.php" style="font-size:2em; color : white; padding:15px;"><i class="fas fa-sign-out-alt"></i></a>
            <a class="button" href="profile.php" style="font-size:2em; color : white; padding:15px;"><i class="fas fa-user" id="omino"></i></a>           
            </div>
        </nav>


        <img id="cani" class='img-fluid d-block mx-auto'style='margin-top:5%;width:75%;' src="http://phpstack-180429-745585.cloudwaysapps.com/unitedpets/img/slider/slide1-element.png" alt="cani">







        
        

        <script>
    $(document).ready(function(){
        $.get('index.php',{question: 'login'},function(result){
            if(result == 'yes')
            $('#omino').css('color','#09f840');
        });
    });
</script>




    </body>
</html>

