<?php
    session_start();
    ob_start();
    require_once('../includes/db.php');
    require_once('../functions/session-func.php');
    require_once('../functions/general-func.php');
    require_once('../functions/get-data-func.php');
    if(!if_student_logged())redirect_to("../index.php");
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <title>Student Cell IIIT ONGOLE</title>
        <link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
        <link rel="stylesheet" href="structure.css"/>
        <script
            src="https://code.jquery.com/jquery-3.4.1.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
            crossorigin="anonymous"
        ></script> 
    </head>
    <body>
         <?php require_once('header.php');?>
        <main>
            <?php require_once('side-navigation.php');?>
            <div class="content-box">
              <h1 class="heading-primary heading-underline"><i class="fa fa-hand-o-right" aria-hidden="true"></i> Student Profile</h1>
              <div class="profile-box">
                <div class="student-profile">
                  <?php
                  $folder_path = "profile_photos/";
                    show_profile($_SESSION['user']);
                  ?>
                </div>
                <div class="edit-student-data-box">
                  
                  <form class="edit-student-data" method="POST" enctype="multipart/form-data">
                    <div class="btn-close" id="close-window-btn">
                          <i class="fa fa-times" aria-hidden="true"></i>
                      </div>
                    <h1 class="heading-primary heading-underline flex-child-full-width"><i class="fa fa-hand-o-right" aria-hidden="true"></i> Edit Student Profile</h1>
                    <div class="error-box mb-2">
                      <p >hii</p>
                    </div>
                    <div class="response-box"></div>

                    <?php
                        $id = strtoupper($_SESSION['user']);
                        $row = student_data($id);
                        $name = replace_empty($row['stu_name']);
                        $email = replace_empty($row['email']);
                        $ht = replace_empty($row['hall_ticket']);
                        $dob = replace_empty($row['dob']);
                        $gender=   replace_empty($row['gender']);
                        $year = replace_empty($row['year']);
                        $branch = replace_empty($row['branch']);
                        $section = replace_empty($row['section']);
                        $hostel_room = replace_empty($row['hostel_room']);

                        $father_name = replace_empty($row['father_name']);
                        $mother_name = replace_empty($row['mother_name']);
                        $guardian_name = replace_empty($row['guardian_name']);
                        $stu_mobile_num = replace_empty($row['stu_mobile_num']);
                        $parent_mobile_num = replace_empty($row['parent_mobile_num']);
                        $address = replace_empty($row['address']);

                        $years = ['P1','P2','E1','E2','E3','E4'];

                        $genders = ['M', "F"];

                        $branches = ['CSE', 'CHE', 'CVE', 'ME', 'MME', 'ECE', 'PUC'];

                        $years_output = "";
                        if($year == "-") $years_output.="<option selected value=''>Select year</option>";
                        for($i=0;$i<count($years);$i++){
                          if($years[$i] == $year){
                            $years_output.="<option selected value='".$years[$i]."'>".$years[$i]."</option>";
                          }else{
                            $years_output.="<option  value='".$years[$i]."'>".$years[$i]."</option>";
                          }
                        }


                        $genders_output = "";
                        if($gender == "-") $genders_output.="<option selected value=''>Select Gender</option>";
                        for($i=0;$i<count($genders);$i++){
                          if($genders[$i] == $gender){
                            $genders_output.="<option selected value='".$genders[$i]."'>".$genders[$i]."</option>";
                          }else{
                            $genders_output.="<option  value='".$genders[$i]."'>".$genders[$i]."</option>";
                          }
                        }


                        $branches_output = "";
                        if($branch == "-") $branches_output.="<option selected value=''>Select branch</option>";
                        for($i=0;$i<count($branches);$i++){
                          if($branches[$i] == $branch){
                            $branches_output.="<option selected value='".$branches[$i]."'>".$branches[$i]."</option>";
                          }else{
                            $branches_output.="<option  value='".$branches[$i]."'>".$branches[$i]."</option>";
                          }
                        }


                        echo "<div class='details-box'>
                        <h2 class='details-heading'>Name</h2>
                        <input type='text' class='details-input' id='name' name='name' value='".$name."'>
                      </div>
                      
                      <div class='details-box'>
                          <h2 class='details-heading'>College ID</h2>
                        <input type='text'  class='details-input' id='id' name='id' value='".$id."'>
                      </div>
                      <div class='details-box'>
                          <h2 class='details-heading'>Email</h2>
                        <input type='text' class='details-input' id='email' name='email' value='".$email."'>
                      </div>
                      <div class='details-box'>
                          <h2 class='details-heading'>Hallticket</h2>
                        <input type='text' class='details-input' id='hall_ticket' name='hall_ticket' value='".$ht."'>
                      </div>
                      <div class='details-box'>
                          <h2 class='details-heading'>Date of Birth</h2>
                        <input type='date' class='details-input' id='dob' name='dob' value='".$dob."'>
                      </div>
                      <div class='details-box'>
                          <h2 class='details-heading'>Gender</h2>

                          <select class='details-input' name='gender' id='gender'>
                          ".$genders_output."
                          </select>
                      </div>
                      <div class='details-box'>
                          <h2 class='details-heading'>Year</h2>
                          <select class='details-input' name='year' id='year'>
                          ".$years_output."
                          </select>
                      </div>
                      <div class='details-box'>
                          <h2 class='details-heading'>Branch</h2>
                          <select class='details-input' name='branch' id='branch'>
                          ".$branches_output."
                          </select>
                      </div>
                      <div class='details-box'>
                          <h2 class='details-heading'>Section</h2>
                        <input type='text' class='details-input' id='section' name='section' value='".$section."'>
                      </div>
                      <div class='details-box'>
                          <h2 class='details-heading'>Hostel Room</h2>
                        <input type='text' class='details-input' id='hostel_room' name='hostel_room' value='".$hostel_room."'>
                      </div>
                      <div class='details-box'>
                          <h2 class='details-heading'>Mother Name</h2>
                        <input type='text' class='details-input' id='mother_name' name='mother_name' value='".$mother_name."'>
                      </div>
                      <div class='details-box'>
                          <h2 class='details-heading'>Father Name</h2>
                        <input type='text' class='details-input' id='father_name' name='father_name' value='".$father_name."'>
                      </div>
                      <div class='details-box'>
                          <h2 class='details-heading'>Guardian Name</h2>
                        <input type='text' class='details-input' id='guardian_name' name='guardian_name' value='".$guardian_name."'>
                      </div>
                      
                      <div class='details-box'>
                          <h2 class='details-heading'>Student mobile number</h2>
                        <input type='text' class='details-input' id='stu_mobile' name='stu_mobile' value='".$stu_mobile_num."'>
                      </div>
                      <div class='details-box'>
                          <h2 class='details-heading'>Parent mobile number</h2>
                        <input type='text' class='details-input' id='parent_mobile' name='parent_mobile' value='".$parent_mobile_num."'>
                      </div>
                      
                      <div class='details-box'>
                          <h2 class='details-heading'>Address</h2>
                        <input type='text' class='details-input' id='address' name='address' value='".$address."'>
                      </div>";
                    ?>
                      
                      <div class="file-upload-box">
                                  <input type="file" name="file" id="file" class="custom-file-input "/>
                      </div>

                      <button type="button" class="update-details btn-full" id="update-student-details-btn">Update Details</button>
                    
                  </form>
                </div>

                <button type="button" id ="profile-edit-btn" class='profil btn-full'><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit Details</button>
              </div>
          </div>
        </main>
        <?php require_once('../footer.php');?>
    <script src="js/script.js"></script>
    <script src="js/ajax_calls.js"></script>
    </body>
</html>
