<?php
     session_start();
     ob_start();
     require_once('../../includes/db.php');
     require_once('../../functions/general-func.php');
     require_once('../../functions/session-func.php');
     require_once('../../functions/get-data-func.php');
     require_once('../../functions/upload-data-func.php');
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
                <h1 class="heading-primary heading-underline">
                <i class="fa fa-hand-o-right" aria-hidden="true"></i> Add students
                </h1>
                <div class="display-error-box">
                    <!-- <p>Results are uploaded</p> -->
                    <?php
                        if(isset($_POST['student-data-upload-btn'])){
                            
                            $file_name = $_FILES['student_file']['name'];
                            $file_error = $_FILES['student_file']['error'];
                            $tmp_name = $_FILES['student_file']['tmp_name'];

                            if(empty($file_name)){
                                echo "<p>All feilds are required!!</p>";
                            }else if(!endswith($file_name, ".csv") || $file_error != UPLOAD_ERR_OK){
                                    echo "<p>Please select a valid CSV file </p>";
                            }else{
                                student_data_upload($tmp_name);
                                echo "<p>Student data uploaded </p>";
                            }
                        }
                    ?>
                </div>
                <div class="student-box">
                        <form action="add-users.php" method="POST" enctype="multipart/form-data">
                            <div class="file-box">
                                <input type="file" name="student_file" class="custom-file-input" accept=".csv"/>                            </div>
                            <button class="btn-full " name="student-data-upload-btn">Upload</button>
                        </form>
                        
                </div>
                <h1 class="heading-primary heading-underline">
                <i class="fa fa-hand-o-right" aria-hidden="true"></i> Add Admins
                </h1>
                <div class="display-error-box">
                    <!-- <p>Results are uploaded</p> -->
                    <?php
                        if(isset($_POST['add-admin-btn'])){
                            $name =  strtoupper($_POST['admin_name']);
                            $admin_type= $_POST['admin_type'];
                            $admin_email = $_POST['admin_email'];
                            $password = password_hash("rgukt123", PASSWORD_DEFAULT);
                            if($name == "" || $admin_type=="" || $admin_email==""){
                                echo "<p>All Feilds are required!</p>";
                            }else{
                                $query = "INSERT INTO admins (admin_name, email,user_type, password) VALUES (?,?,?,?)";
                                $stmt = mysqli_stmt_init($conn);
                                if(mysqli_stmt_prepare($stmt, $query)){
                                  mysqli_stmt_bind_param($stmt, "ssss", $name, $admin_email, $admin_type,$password );
                                  mysqli_stmt_execute($stmt);
                                  $result = mysqli_stmt_get_result($stmt);
                                  echo "<p>Admin added!</p>";
                                }
                            }
                        }
                    ?>
                </div>
                <div class="admin-box">
                <form action="add-users.php" method="POST" enctype="multipart/form-data">
                        <input type="text" name="admin_name" class="input-element margin-right mb-1" placeholder="Enter admin Name"/>
                        <select name="admin_type"  class="select-element margin-right  mb-1">
                            <option value="">Select Admin Type</option>
                            <option value="student_welfare">Student Welfare</option>
                            <option value="it_infra">IT Infra</option>
                            <option value="dean_academics">Dean Academics</option>
                            <option value="exam_cell">Exam Cell</option>
                            <option value="security">Security</option>
                        </select>
                        <input type="text" name="admin_email" class="mb-1 input-element margin-right" placeholder="Enter email"/>
                            <button class="btn-full " name="add-admin-btn">Add Admin</button>
                        </form>
                </div>
            </div>
          
        </main>
        <?php require_once('../../footer.php');?>
    <script src="../js/script.js"></script>
    </body>
</html>
