<?php
     session_start();
     ob_start();
     require_once('../../includes/db.php');
     require_once('../../functions/general-func.php');
     require_once('../../functions/session-func.php');
     require_once('../../functions/get-data-func.php');
     require_once('../../functions/upload-data-func.php');
     if(!if_studentwelfare_logged())redirect_to("../index.php");

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
                <i class="fa fa-hand-o-right" aria-hidden="true"></i> Add student-warden Data
                </h1>
                <div class="display-error-box">
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
                                student_warden_data_upload($tmp_name);
                                echo "<p>Student Warden data uploaded </p>";
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
                    <?php
                        if(isset($_POST['add-warden-btn'])){
                            $name =  strtoupper($_POST['warden_name']);
                            $warden_email = $_POST['warden_email'];
                            $admin_type = "warden";
                            $warden_id = str_replace(" ", "", $_POST['warden_id']);
                            $password = password_hash("rgukt123", PASSWORD_DEFAULT);
                            if($name == "" || $warden_email == "" || $warden_id==""){
                                echo "<p>All Feilds are required!</p>";
                            }else{

                                $query = "INSERT INTO admins (admin_name, email,user_type,admin_id, password) VALUES (?,?,?,?, ?)";
                                $stmt = mysqli_stmt_init($conn);
                                if(mysqli_stmt_prepare($stmt, $query)){
                                  mysqli_stmt_bind_param($stmt, "sssss", $name, $warden_email, $admin_type,$warden_id,$password );
                                  mysqli_stmt_execute($stmt);
                                  echo "<p>Admin added!</p>";
                                }
                            }
                        }
                    ?>
                </div>
                <div class="admin-box">
                 <form action="add-users.php" method="POST" ">
                        <input type="text" name="warden_name" class="input-element margin-right mb-1" placeholder="Enter Warden Name"/>
                        <input type="text" name="warden_id" class="input-element margin-right mb-1" placeholder="Enter Warden ID"/>
                        <input type="email" name="warden_email" class="input-element margin-right mb-1" placeholder="Enter Warden email"/>
                       <button class="btn-full " name="add-warden-btn">Add Warden</button>
                 </form>
                </div>


                <h1 class="heading-primary heading-underline">
                <i class="fa fa-hand-o-right" aria-hidden="true"></i> Delete wardens
                </h1>
                <div class="display-error-box">
                    <?php
                        if(isset($_POST['delete-warden-btn'])){
                            $warden_email =  $_POST['warden_email'];
                            if( $warden_email == ""){
                                echo "<p>All Feilds are required!</p>";
                            }else{
                                $query = "DELETE FROM admins WHERE email = ?";
                                $stmt = mysqli_stmt_init($conn);
                                if(mysqli_stmt_prepare($stmt, $query)){
                                  mysqli_stmt_bind_param($stmt, "s", $warden_email);
                                  mysqli_stmt_execute($stmt);
                                  echo "<p>Warden deleted!</p>";
                                }
                            }
                        }
                        
                        $query ="SELECT * FROM admins WHERE user_type = ?";
                        $stmt = mysqli_stmt_init($conn);
                        echo mysqli_error($conn);
                        $admin_type = "warden";
                        $output = "<option value=''>Select Warden email</option>";
                        if(mysqli_stmt_prepare($stmt, $query)){
                          mysqli_stmt_bind_param($stmt, "s", $admin_type);
                          mysqli_stmt_execute($stmt);
                          $result = mysqli_stmt_get_result($stmt);
                          while($row = mysqli_fetch_assoc($result)){
                            $output .= "<option value='".$row['email']."'>".$row['email']."</option>";
                          }
                        }

                        
                    ?>
                </div>
                <div class="delete-warden-box">
                 <form action="add-users.php" method="POST" ">
                        <select  name="warden_email" class="input-element margin-right mb-1""/><?php echo $output; ?></select>
                       <button class="btn-full " name="delete-warden-btn">Delete Warden</button>
                 </form>
                </div>

            </div>
          
        </main>
        <?php require_once('../../footer.php');?>
    <script src="../js/script.js"></script>
    </body>
</html>
