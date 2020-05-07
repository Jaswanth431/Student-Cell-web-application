<?php
  session_start();
  require_once('../../includes/db.php');
  require_once('../../functions/get-data-func.php');
  require_once('../../functions/general-func.php');
if(isset($_POST['reason']) && isset($_POST['date'])){
  $reason = escape_char($_POST['reason']);
  $date = escape_char($_POST['date']);
  $id = $_SESSION['user'];
  $d_war_id = "";
  $w_id = "";
  $c_w_id = "";
  $current_time = get_date(1);
  $approved ="pending";

  //getting deputy warden details
  $query = "SELECT * FROM `student-warden` WHERE stu_id =  ?";
  $stmt = mysqli_stmt_init($conn); 
  if(mysqli_stmt_prepare($stmt, $query)){
    mysqli_stmt_bind_param($stmt,  "s", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if(mysqli_num_rows($result) == 0){
      echo "<script>error_display('Your warden details not found. Contact student welfare office', 1);</script>";
      return;
    }

    $row = mysqli_fetch_assoc($result);
    $d_war_id = $row['deputy_warden_id'];
    $w_id = $row['warden_id'];
    $c_w_id = $row['chief_warden_id'];
    
  }

  $name = student_data($id)['stu_name'];

//inserting outpass data
  $query = "INSERT INTO outpass (stu_name,stu_id, reason, request_time, outing_date, approved, deputy_warden_id, warden_id, chief_warden_id) VALUES(?,?,?,?,?,?,?,?,?)";
  $stmt = mysqli_stmt_init($conn); 
  if(mysqli_stmt_prepare($stmt, $query)){
    mysqli_stmt_bind_param($stmt,  "sssssssss", $name, $id, $reason,$current_time, $date, $approved, $d_war_id, $w_id, $c_w_id );
    mysqli_stmt_execute($stmt);
      echo "<script>alert('Outpass request forwarded. Contact warden for approval');</script>";
      echo "<script>location.reload();</script>";
      return;
  }else{
    echo "hoo";
  }
  

}


?>