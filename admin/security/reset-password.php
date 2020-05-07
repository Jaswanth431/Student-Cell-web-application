<?php
     session_start();
     ob_start();
     require_once('../../includes/db.php');
     require_once('../../functions/general-func.php');
     require_once('../../functions/session-func.php');
     require_once('../../functions/get-data-func.php');
     if(!if_security_logged())redirect_to("../index.php");

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <title>Student Cell IIIT ONGOLE</title>
        <link rel="shortcut icon" href="../../img/favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
        <link rel="stylesheet" href="../structure.css"/>
        <script
            src="https://code.jquery.com/jquery-3.4.1.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
            crossorigin="anonymous"
        ></script> 
    </head>
    <body>
        <?php require_once('../header.php');?>
        <main>
            <?php require_once('../side-navigation.php');?>
            <div class="content-box">
                <h1 class="heading-primary heading-underline"><i class="fa fa-hand-o-right" aria-hidden="true"></i> Reset Passowrd</h1>
                <div class="display-error-box">
                   <?php 
                    if(isset($_POST['reset-password-btn'])){
                        $pass1 = escape_char($_POST['password1']);
                        $pass2 =escape_char($_POST['password2']);
                        if($pass1 == "" || $pass2==""){
                            echo "<p>All feilds are required!</p>";
                        }else if($pass1 != $pass2){
                            echo "<p>Passwords do not match</p>";
                            
                        }else{
                            $password = password_hash($pass1, PASSWORD_DEFAULT);
                            $email = $_SESSION['user'];
                            $query = "UPDATE admins SET password = '$password' WHERE email='$email' ";
                            if(mysqli_query( $conn, $query)){

                                echo "<p>Password changed successfully</p>";
                            }else{
                                echo "<p>Please try again later</p>";
                            }
                        }
                    }
                   ?>
                </div>
                <div class="reset-password-box">
                <form action="reset-password.php" method="POST">
                    <input type="password" name="password1" class="input-element margin-right mb-1" placeholder="Enter Password.."/>
                    <input type="password" name="password2" class="input-element margin-right mb-1" placeholder="Re Enter Password.."/>
                    <button class="btn-full btn-reset" name="reset-password-btn">Change Password</button>
                </form>
            </div>   
            </div>
                   
        </main>
        <?php require_once('../../footer.php');?>
    <script src="../js/script.js"></script>
    </body>
</html>
