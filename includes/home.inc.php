<?php
   
  session_start();
  require_once('db.php');
  require_once('../functions/general-func.php');
  require_once('../functions/session-func.php');
  require '../vendor/autoload.php'; 
  require_once('../functions/mail-func.php');

  
  //to make student login
  if(isset($_POST['id']) && isset($_POST['password'])){

    $id = strtoupper(escape_char($_POST['id']));
    $pass =escape_char($_POST['password']);
    $query = "SELECT * FROM student_info WHERE stu_id = ?";

    $stmt = mysqli_stmt_init($conn);
    if(mysqli_stmt_prepare($stmt, $query)){
      mysqli_stmt_bind_param($stmt, "s", $id);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      if(mysqli_num_rows($result) == 1){
        $row = mysqli_fetch_assoc($result);
        $real_password = $row['password'];
        if(password_verify($pass, $real_password)){
            set_student_session($row['stu_id'], "student");
            $ip = get_client_ip();
            $date=get_date(1);
            $query = "UPDATE student_info set last_login='$date', ip_address='$ip' where stu_id = '$id'";
            mysqli_query($conn, $query);
            echo "<script type='text/javascript'>window.location.href = 'student/home.php';</script>";
        }else{
          echo "<script>error_display('Invalid ID or Password', '1');</script>";
        }
      }else{
        echo "<script>error_display('Invalid ID number', '1');</script>";
      }
      
    }
  }
  //to make admin login
  else if(isset($_POST['admin_email']) && isset($_POST['password'])){

    $email = strtoupper(escape_char($_POST['admin_email']));
    $pass =escape_char($_POST['password']);
    $query = "SELECT * FROM admins WHERE email = ?";

    $stmt = mysqli_stmt_init($conn);
    if(mysqli_stmt_prepare($stmt, $query)){
      mysqli_stmt_bind_param($stmt, "s", $email);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      if(mysqli_num_rows($result) == 1){
        $row = mysqli_fetch_assoc($result);
        $real_password = $row['password'];
        if(password_verify($pass, $real_password)){
          set_admin_session($row['email'], $row['user_type'], $row['admin_id']);
          $ip = get_client_ip();
          $date=get_date(1);
          $query = "UPDATE admins SET last_login='$date', ip_address='$ip' where email='$row[email]'";
          mysqli_query($conn, $query);
          echo "<script type='text/javascript'>window.location.href = 'index.php';</script>";
        }else{
          echo "<script>error_display('Invalid Email or Password', '1');</script>";
        }
      }else{
        echo "<script>error_display('Invalid Email id', '1');</script>";
      }
      
    }
  }
 

  //to send otp for register mobile num
  else if(isset($_POST['f_pass_id'])){
    
    $id = escape_char(strtoupper($_POST['f_pass_id']));
    $query = "SELECT * FROM student_info where stu_id =  ?";
    $stmt = mysqli_stmt_init($conn);
    if(mysqli_stmt_prepare($stmt, $query)){
      mysqli_stmt_bind_param($stmt,  "s", $id);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      if(mysqli_num_rows($result) == 1){

        $row = mysqli_fetch_assoc($result);
        $email = $row['email'];
        $short_name = get_short_name($row['stu_name']);
        $otp = mt_rand(100000,999999);
        $subject = "OTP for Password reset";
        $body = 'Hello '.$short_name.' <br>'.'<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$otp.'</b>'.' is the OTP for password reset. It is valid for next 20 minutes';

        //sending mail to student
        $mail = send_mail($email, $subject, $body);
        if($mail){
          $date = get_date(1);
          $query ="UPDATE student_info SET otp = '$otp' , otp_sent_time = '$date' WHERE stu_id='$id'";
          mysqli_query($conn, $query);

          echo "<script>$('.otp-box').css('display', 'block');$('.pass-box').css('display', 'block');$('.get-otp-box').css('display', 'none');$('.pass-change-box').css('display', 'block');f_pass_error_display('OTP sent of your email',1);</script>";

        }else{
          echo "<script>f_pass_error_display('Unable to sent OTP, please try agian later!',1)</script>";
        }

      }else{
        echo "<script>f_pass_error_display('Invalid ID number!!',1)</script>";
        exit();
      }
      
    }
  }

  //to update the new password
  else if(isset($_POST['update_id']) && isset($_POST['otp']) && isset($_POST['new_pass'])){
    $id = escape_char($_POST['update_id']);
    $new_pass = escape_char($_POST['new_pass']);
    $user_otp = escape_char($_POST['otp']);
    $date = get_date(1);
    $query = "SELECT * FROM student_info where stu_id =  ?";
    $stmt = mysqli_stmt_init($conn);
    if(mysqli_stmt_prepare($stmt, $query)){ 
      mysqli_stmt_bind_param($stmt,  "s", $id);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      if(mysqli_num_rows($result) == 1){
        $row = mysqli_fetch_assoc($result);
        $sent_otp = $row['otp'];
        $otp_sent_time = $row['otp_sent_time'];
        $diff = minutes_diff($date, $otp_sent_time);
        if($diff>20){
          echo "<script>f_pass_error_display('OTP expired',1)</script>";
          exit();
        }else{
          if($user_otp !=$sent_otp){
            echo "<script>f_pass_error_display('Invalid OTP',1)</script>";
            exit();
          }else{
            $new_pass=password_hash($new_pass, PASSWORD_DEFAULT);
            $query = "UPDATE student_info set password = '$new_pass' where stu_id = '$id'";
            mysqli_query($conn, $query);
            echo "<script>$('.otp-box').css('display', 'none');$('.pass-box').css('display', 'none');$('.get-otp-box').css('display', 'block');$('.pass-change-box').css('display', 'none');f_pass_error_display('Password Updated. Login with new password',1);</script>";
            exit();
          }
        }
        
      }
    }

  }
  

  
?>