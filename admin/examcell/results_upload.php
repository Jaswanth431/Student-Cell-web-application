<?php
     session_start();
     ob_start();
     require_once('../../includes/db.php');
     require_once('../../functions/general-func.php');
     require_once('../../functions/session-func.php');
     require_once('../../functions/get-data-func.php');
     require_once('../../functions/upload-data-func.php');
     if(!if_examcell_logged())redirect_to("../index.php");
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
            <div class="result-upload">
                <h1 class="heading-primary heading-underline"><i class="fa fa-hand-o-right" aria-hidden="true"></i>
                        Academic Results</h1>
                <div class="display-error-box">
                    <!-- <p>Results are uploaded</p> -->
                    <?php
                        if(isset($_POST['sem-upload-btn'])){
                            $sem_type = $_POST['sem_type'];
                            $result_type=$_POST['result_type'];
                            $file_name = $_FILES['result_file']['name'];
                            $file_error = $_FILES['result_file']['error'];
                            $tmp_name = $_FILES['result_file']['tmp_name'];
                            // print_r($_FILES['result_file']);
                            if($sem_type == "" || $result_type == "" || empty($file_name)){
                                echo "<p>All feilds are required!!</p>";
                            }else if(!endswith($file_name, ".csv") || $file_error != UPLOAD_ERR_OK){
                                    echo "<p>Please select a valid CSV file </p>";
                            }else{
                                results_upload($tmp_name,$sem_type,$result_type);
                                echo "<p>Results are uploaded </p>";
                            }
                        }
                    ?>
                </div>
                <div class="upload-box">
                    <form action="results_upload.php" method="POST" enctype="multipart/form-data">
                        <select name="sem_type" id="" class="select-element upload-box-select">
                            <option value="">Select SEM</option>
                            <option value="p1__sem1">P1 SEM1</option>
                            <option value="p1__sem2">P1 SEM2</option>
                            <option value="p2__sem1">P2 SEM1</option>
                            <option value="p2__sem2">P2 SEM2</option>
                            <option value="e1__sem1">E1 SEM1</option>
                            <option value="e1__sem2">E1 SEM2</option>
                            <option value="e2__sem1">E2 SEM1</option>
                            <option value="e2__sem2">E2 SEM2</option>
                            <option value="e3__sem1">E3 SEM1</option>
                            <option value="e3__sem2">E3 SEM2</option>
                            <option value="e4__sem1">E4 SEM1</option>
                            <option value="e4__sem2">E4 SEM2</option>
                        </select>
                        <select name="result_type" id="" class="select-element">
                            <option value="">Select Exam</option>
                            <option value="mid1">MID1 Marks</option>
                            <option value="mid2">MID2 Marks</option>
                            <option value="mid3">MID3 Marks</option>
                            <option value="wat">WAT Marks</option>
                            <option value="sem">SEM Grades</option>
                            <option value="sgpa">SGPA</option>
                            <option value="all-results">All Marks</option>
                        </select>
                        <div class="file-upload-box">
                                <input type="file" name="result_file" class="custom-file-input " accept=".csv"/>
                        </div>
                        <button class="btn-full btn-upload" name="sem-upload-btn">Upload</button>
                    </form>
                </div>
                
            </div>
            </div>
            
        </main>
        <?php require_once('../../footer.php');?>
    <script src="../js/script.js"></script>
    </body>
</html>
