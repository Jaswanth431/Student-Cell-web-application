<?php
     session_start();
     ob_start();
     require_once('../../includes/db.php');
     require_once('../../functions/general-func.php');
     require_once('../../functions/session-func.php');
     require_once('../../functions/get-data-func.php');
     require_once('../../functions/upload-data-func.php');
     if(!if_deanacademics_logged())redirect_to("../index.php");
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
                    <i class="fa fa-hand-o-right" aria-hidden="true"></i>  Current SEM subjects
                </h1>
                <div class="display-error-box">
                  <?php

                    if(isset($_POST['subjects-upload-btn'])){
                      $file_name = $_FILES['subjects_file']['name'];
                      $file_error = $_FILES['subjects_file']['error'];
                      $tmp_name = $_FILES['subjects_file']['tmp_name'];

                      if(empty($file_name)){
                          echo "<p>All feilds are required!!</p>";
                      }else if(!endswith($file_name, ".csv") || $file_error != UPLOAD_ERR_OK){
                              echo "<p>Please select a valid CSV file </p>";
                      }else{
                          subjects_data_upload($tmp_name);
                          echo "<p>SEM subjects uploaded</p>";
                      }
                    }
                  ?>
                </div>
              <div class="subjects-upload-box">
                      <form action="upload-sem-data.php" method="POST" enctype="multipart/form-data">
                            <div class="file-box">
                                <input type="file" name="subjects_file" class="custom-file-input" accept=".csv"/>                            </div>
                            <button class="btn-full " name="subjects-upload-btn">Upload</button>
                      </form>
              </div>
              <h1 class="heading-primary heading-underline">
                  <i class="fa fa-hand-o-right" aria-hidden="true"></i>  Current SEM Faculty
              </h1>
              <div class="display-error-box">
                  <?php

                    if(isset($_POST['faculty-upload-btn'])){
                      $file_name = $_FILES['faculty_file']['name'];
                      $file_error = $_FILES['faculty_file']['error'];
                      $tmp_name = $_FILES['faculty_file']['tmp_name'];

                      if(empty($file_name)){
                          echo "<p>All feilds are required!!</p>";
                      }else if(!endswith($file_name, ".csv") || $file_error != UPLOAD_ERR_OK){
                              echo "<p>Please select a valid CSV file </p>";
                      }else{
                          faculty_data_upload($tmp_name);
                          echo "<p>Faculty data uploaded </p>";
                      }
                    }
                  ?>
                </div>
              <div class="faculty-upload-box">
                      <form action="upload-sem-data.php" method="POST" enctype="multipart/form-data">
                            <div class="file-box">
                                <input type="file" name="faculty_file" class="custom-file-input" accept=".csv"/>                            </div>
                            <button class="btn-full " name="faculty-upload-btn">Upload</button>
                      </form>
              </div>
            </div>
        </main>
        <?php require_once('../../footer.php');?>
    <script src="../js/script.js"></script>
    </body>
</html>
