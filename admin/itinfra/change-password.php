<?php
     session_start();
     ob_start();
     require_once('../../includes/db.php');
     require_once('../../functions/general-func.php');
     require_once('../../functions/session-func.php');
     require_once('../../functions/get-data-func.php');
     if(!if_itinfra_logged())redirect_to("../index.php");

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
                <h1 class="heading-primary heading-underline"><i class="fa fa-hand-o-right" aria-hidden="true"></i> Change Student Password</h1>
                <div class="display-error-box">
                    <?php
                        if(isset($_POST['change_student_password'])){
                            $id = strtoupper($_POST['student_id']);
                            $password = password_hash("rgukt123", PASSWORD_DEFAULT);
                            if($id == ""){
                                echo "<p>All feilds are required!</p>";
                            }else{
                                $query = "SELECT * FROM student_info WHERE stu_id ='$id' ";
                                $result = mysqli_query($conn, $query);
                                if(mysqli_num_rows($result) == 1){
                                    $query = "UPDATE student_info SET password = '$password' WHERE stu_id = '$id'";
                                    $result = mysqli_query($conn, $query);
                                    if($result){
                                        echo "<p>Password Updated</p>";
                                    }else{
                                        echo "<p>Please try again later</p>";
                                    }
                                }else{
                                    echo "<p>Invalid ID number</p>";
                                }
                                
                            }
                        }

                    ?>
                </div>
                <div class="student-box">
                    <form action="change-password.php" method="POST" >
                        <input type="text" name="student_id" class="input-element student_id mb-1" placeholder="Enter student ID"/>
                        <button class="btn-full" name="change_student_password">Change password</button>
                    </form>
                </div>
                <h1 class="heading-primary heading-underline"><i class="fa fa-hand-o-right" aria-hidden="true"></i> Change Admin Password</h1>
                <div class="display-error-box">
                    <?php
                        if(isset($_POST['change_admin_password'])){
                            $email = $_POST['admin_email'];
                            $password = password_hash("rgukt123", PASSWORD_DEFAULT);
                            if($email== ""){
                                echo "<p>All feilds are required!</p>";
                            }else{
                                $query = "SELECT * FROM admins WHERE email ='$email' ";
                                $result = mysqli_query($conn, $query);
                                if(mysqli_num_rows($result) == 1){
                                    $query = "UPDATE admins SET password = '$password' WHERE email = '$email'";
                                    $result = mysqli_query($conn, $query);
                                    if($result){
                                        echo "<p>Password Updated</p>";
                                    }else{
                                        echo "<p>Please try again later</p>";
                                    }
                                }else{
                                    echo "<p>Invalid Email ID</p>";
                                }
                            }
                        }

                    ?>
                </div>
                <div class="admin-box">
                    <form action="change-password.php" method="POST" >
                        <input type="text" name="admin_email" class="input-element admin_email mb-1" placeholder="Enter admin email"/>
                        <button class="btn-full" name="change_admin_password">Change password</button>
                    </form>
                </div>
            </div>
          
        </main>
        <?php require_once('../../footer.php');?>
    <script src="../js/script.js"></script>
    </body>
</html>
