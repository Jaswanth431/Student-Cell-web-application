<?php
  session_start();
  require_once('../../includes/db.php');
  require_once('../../functions/get-data-func.php');
  require_once('../../functions/general-func.php');

  
  if(empty($_POST) || empty($_FILES))return;

$filename = $_FILES['file']['name'];
$filesize = $_FILES['file']['size'];
$filetype = $_FILES['file']['type'];
$fileerror =  $_FILES['file']['error'];
$filetmp =  $_FILES['file']['tmp_name'];

$file_data = explode(".", $filename);
$extension = $file_data[count($file_data) - 1];

$allowed_extensions = ["jpg", "jpeg", "png"];

if(!in_array($extension, $allowed_extensions))
{   echo "<script>error_display('Only JPG, JPEG, PNG Imgae types are allowed', 1);$('.edit-student-data').scrollTop(0);</script>";
  return;
}

if($filesize >100000){
  echo "<script>error_display('Maximum Image size of 100KB is allowed', 1);$('.edit-student-data').scrollTop(0);</script>";
  return;
}

if($fileerror > 0 ){
  echo "<script>error_display('This Image cannot be processed, select another Image!', 1);$('.edit-student-data').scrollTop(0);</script>";
  return;
}


$name = escape_char(strtoupper($_POST['name']));
$id = escape_char($_SESSION['user']);
$email  = escape_char($_POST['email']);
$ht= escape_char($_POST['hall_ticket']);
$dob = escape_char($_POST['dob']);
$gender =escape_char( $_POST['gender']);
$year =escape_char( $_POST['year']);
$branch = escape_char($_POST['branch']);
$section =escape_char( $_POST['section']);
$hostel =escape_char( $_POST['hostel_room']);
$mother_name =escape_char( $_POST['mother_name']);
$father_name =escape_char( $_POST['father_name']);
$guardian_name =escape_char( $_POST['guardian_name']);
$p_mob = escape_char($_POST['parent_mobile']);
$s_mob = escape_char($_POST['stu_mobile']);
$address =escape_char( $_POST['address']);
$new_filename = $id.".".$extension;

if(move_uploaded_file($filetmp, "../profile_photos/".$new_filename)){

  $query = "UPDATE student_info SET stu_name = '$name', email = '$email' , hall_ticket = '$ht',dob = '$dob', gender = '$gender', year = '$year', branch='$branch', section='$section', hostel_room = '$hostel',mother_name = '$mother_name',father_name = '$father_name',guardian_name = '$guardian_name', parent_mobile_num = '$p_mob', stu_mobile_num = '$s_mob', address='$address', profile_img= '$new_filename' WHERE stu_id = '$id' ";
  $result = mysqli_query($conn, $query);
  if($result){
    echo "<script>error_display('Student Profile updated successfully', 1);$('.edit-student-data').scrollTop(0);</script>";
    return;
  }
}else{
  echo "<script>error_display('Student profile not updated! Try again!', 1);$('.edit-student-data').scrollTop(0);</script>";
  return;
}


?>