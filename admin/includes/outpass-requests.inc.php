<?php
session_start();
require_once('../../includes/db.php');
require_once('../../functions/get-data-func.php');
require_once('../../functions/general-func.php');
require '../../vendor/autoload.php';
require_once('../../functions/mail-func.php');



if(isset($_POST['reason_type']) && isset($_POST['no_of_days']) && isset($_POST['outpass_id'])){
  $reason = $_POST['reason_type'];
  $no_of_days = $_POST['no_of_days'];
  $op_id = $_POST['outpass_id'];
  $stu_id = $_POST['stu_id'];
  $row= student_data($stu_id);
  $student_mail = $row['email'];

  $date = get_date(1);
  $row = admin_data($_SESSION['user']);
  $admin_name = $row['admin_name'];
  $approved = "yes";
  $subject = "Your request for outpass is approved";
  $body = "Your requested outpass is approved by ".$admin_name;
  $query = "UPDATE outpass SET requested_days=?, reason_type=?, approved_time=?,approved=?, approved_by=? WHERE id=?";
  $stmt = mysqli_stmt_init($conn);
  if(mysqli_stmt_prepare($stmt, $query)){
      mysqli_stmt_bind_param($stmt,  "ssssss", $no_of_days, $reason, $date,$approved, $admin_name, $op_id);
      mysqli_stmt_execute($stmt);
      send_mail($student_mail, $subject, $body);
      echo "<script>alert('Outpass approval successful!');location.reload();</script>";
  }

}else if(isset($_POST['reject_op_id']) && isset($_POST['reject_stu_id'])){
  $op_id = $_POST['reject_op_id'];
  $stu_id = $_POST['reject_stu_id'];
  $row= student_data($stu_id);
  $student_mail = student_data($stu_id)['email'];

  $date = get_date(1);
  $row = admin_data($_SESSION['user']);
  $admin_name = $row['admin_name'];
  $approved = "no";
  $student_mail = student_data($stu_id)['email'];
  $subject = "Your request for outpass is Rejected";
  $body = "Your requested outpass is rejected by ".$admin_name;
  $query = "UPDATE outpass SET  approved_time=?,approved=? WHERE id=?";
  $stmt = mysqli_stmt_init($conn);
  if(mysqli_stmt_prepare($stmt, $query)){
      mysqli_stmt_bind_param($stmt,  "sss",  $date,$approved, $op_id);
      mysqli_stmt_execute($stmt);
      send_mail($student_mail, $subject, $body);
      // echo "<script>alert('Outpass rejection successfull!');location.reload();</script>";
  }
}

?>