<?php

  //to check subejct data already exists
  function check_subject_already_exists($id, $sub_code, $sem_type){
    global $conn;
    
    $query = "SELECT * FROM ".$sem_type." WHERE clg_id = ? AND subcode = ?";
    $stmt = mysqli_stmt_init($conn);
    if(mysqli_stmt_prepare($stmt, $query)){
      mysqli_stmt_bind_param($stmt, "ss", $id, $sub_code);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      $row = mysqli_fetch_assoc($result);
      if(mysqli_num_rows($result)>0){
        return 1;
      }else{
        return 0;
      }
     }
     else{
       return 0;
     }
  }

  //to upload sem results
function results_upload($file, $sem_type, $exam_type){
    global $conn;
    if($exam_type == "mid1" || $exam_type == "mid2" || $exam_type == "wat"){
        $file = fopen($file, "r");
        while($row = fgetcsv($file)){
            $id = str_replace(" ", "", $row[0]);
            $sub_code = str_replace(" ", "", $row[1]);

            $exists = check_subject_already_exists($id, $sub_code, $sem_type);
            $time = get_date(1);
            $updated_by  = $_SESSION['user'];
            if($exists){
              $query = "UPDATE ".$sem_type." SET ".$exam_type." = ?, updated_date= ?,updated_by= ? WHERE clg_id = ? AND subcode=?";
              $stmt = mysqli_stmt_init($conn);
              if(mysqli_stmt_prepare($stmt, $query)){
                mysqli_stmt_bind_param($stmt, "sssss", $row[3],$time, $updated_by,$id, $sub_code);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
              }
              
            }else{
              $query = "INSERT INTO ".$sem_type." (clg_id, subcode, subname,".$exam_type.",credits, updated_date,updated_by) VALUES (?,?,?,?,?,?,?)";
              $stmt = mysqli_stmt_init($conn);
              if(mysqli_stmt_prepare($stmt, $query)){
                mysqli_stmt_bind_param($stmt, "sssssss", $id, $sub_code,$row[2],$row[3],$row[4], $time, $updated_by);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
              }
            }  
        }
    }elseif($exam_type == "mid3"){
          $file = fopen($file, "r");
          while($row = fgetcsv($file)){
            $id = str_replace(" ", "", $row[0]);
            $sub_code = str_replace(" ", "", $row[1]);

            $time = get_date(1);
            $updated_by  = $_SESSION['user'];

            $exists = check_subject_already_exists($id, $sub_code, $sem_type);

            if($exists){
              $query = "UPDATE ".$sem_type." SET mid3 = ?, BO2 = ?, updated_date = ?,updated_by = ? WHERE clg_id = ? AND subcode=? ";
              $stmt = mysqli_stmt_init($conn);
              if(mysqli_stmt_prepare($stmt, $query)){
                mysqli_stmt_bind_param($stmt, "ssssss",$row[3],$row[5],$time,$updated_by, $id, $sub_code);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
              }
              
            }else{
              $query = "INSERT INTO ".$sem_type." (clg_id, subcode, subname,mid3,credits, BO2,updated_by,updated_date) VALUES (?,?,?,?,?,?,?,?)";
              $stmt = mysqli_stmt_init($conn);
              if(mysqli_stmt_prepare($stmt, $query)){
                mysqli_stmt_bind_param($stmt, "ssssssss", $id, $sub_code,$row[2],$row[3],$row[4],$row['5'],$updated_by,$time);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
              }
          }  
        }
    }elseif($exam_type == "sem"){
      $file = fopen($file, "r");
      while($row = fgetcsv($file)){
        $id = str_replace(" ", "", $row[0]);
        $sub_code = str_replace(" ", "", $row[1]);

        $time = get_date(1);
        $updated_by  = $_SESSION['user'];

        $exists = check_subject_already_exists($id, $sub_code, $sem_type);

        if($exists){
          $query = "UPDATE ".$sem_type." SET grade = ?, sem_passed = ?, updated_date = ?,updated_by = ? WHERE clg_id = ? AND subcode=? ";
          $stmt = mysqli_stmt_init($conn);
          if(mysqli_stmt_prepare($stmt, $query)){
            mysqli_stmt_bind_param($stmt, "ssssss",$row[3],$row[5],$time,$updated_by, $id, $sub_code);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
          }
          
        }else{
          $query = "INSERT INTO ".$sem_type." (clg_id, subcode, subname,grade,credits, sem_passed,updated_by,updated_date) VALUES (?,?,?,?,?,?,?,?)";
          $stmt = mysqli_stmt_init($conn);
          if(mysqli_stmt_prepare($stmt, $query)){
            mysqli_stmt_bind_param($stmt, "ssssssss", $id, $sub_code,$row[2],$row[3],$row[4],$row[5],$updated_by,$time);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
          }
      }  
    }
    }elseif($exam_type == "all-results"){
          $file = fopen($file, "r");
          while($row = fgetcsv($file)){
            $id = str_replace(" ", "", $row[0]);
            $sub_code = str_replace(" ", "", $row[1]);

            $time = get_date(1);
            $updated_by  = $_SESSION['user'];

            $exists = check_subject_already_exists($id, $sub_code, $sem_type);

            if($exists){
              $query = "UPDATE ".$sem_type." SET wat=?,mid1=?,mid2=?,mid3=?,BO2=?,grade=?,credits=?,sem_passed=?,upadated_date=?,updated_by=? WHERE clg_id = ? AND subcode=? ";
              $stmt = mysqli_stmt_init($conn);
              if(mysqli_stmt_prepare($stmt, $query)){
                mysqli_stmt_bind_param($stmt, "ssssssssssss",$row[3],$row[4],$row[5],$row[6],$row[7],$row[8],$row[9],$row[10],$time,$updated_by, $id, $sub_code);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
              }
              
            }else{
              $query = "INSERT INTO ".$sem_type." (clg_id, subcode, subname,wat,mid1,mid2,mid3,BO2,grade,credits, sem_passed,updated_by,updated_date) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
              $stmt = mysqli_stmt_init($conn);
              if(mysqli_stmt_prepare($stmt, $query)){
                mysqli_stmt_bind_param($stmt, "sssssssssssss", $id, $sub_code,$row[2],$row[3],$row[4],$row[5],$row[6],$row[7],$row[8],$row[9],$row[10],$updated_by,$time);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
              }
          }  
        }
    }elseif($exam_type == "sgpa"){
          $file = fopen($file, "r");
          while($row = fgetcsv($file)){
            
            $id = str_replace(" ", "", $row[0]);

            $time = get_date(1);
            $updated_by  = $_SESSION['user'];

            $sem_data = explode("__", $sem_type);
            $table = $sem_data[0]."__points";
            $sem = $sem_data[1];

            $query = "INSERT INTO ".$table." (clg_id,sgpa,sem_type,updated_by,updated_date) VALUES (?,?,?,?,?)";
            $stmt = mysqli_stmt_init($conn);
            if(mysqli_stmt_prepare($stmt, $query)){

              mysqli_stmt_bind_param($stmt, "sssss", $id, $row[1], $sem,$updated_by,$time);
              mysqli_stmt_execute($stmt);
              $result = mysqli_stmt_get_result($stmt);
            }
        }  
    }
}
  //To upload new students data
  function student_data_upload($file){
    global $conn;
    $file = fopen($file, "r");
    while($row = fgetcsv($file)){
      $id=strtoupper(str_replace(" ","",$row[0]));
      $name =strtoupper($row[1]);
      $email = str_replace(" ","",$row[2]);
      $hall_ticket = str_replace(" ","",$row[3]);
      $gender = strtoupper(str_replace(" ","",$row[4]));
      $branch = strtoupper(str_replace(" ","",$row[5]));
      $year = str_replace(" ","",$row[6]);
      $password = password_hash($hall_ticket, PASSWORD_DEFAULT);

      $query = "INSERT INTO student_info (stu_id, stu_name, email, hall_ticket, gender, branch, year, password) VALUES (?,?,?,?,?,?,?,?)";
      $stmt = mysqli_stmt_init($conn);
      if(mysqli_stmt_prepare($stmt, $query)){
        mysqli_stmt_bind_param($stmt, "ssssssss", $id, $name, $email, $hall_ticket,$gender, $branch, $year, $password);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
      }
    }
  }


//to check wether student and corresponding warden alreay exists in database
function check_student_already_exists($id){
  global $conn;
  
  $query = "SELECT * FROM  `student-warden` WHERE stu_id = ? ";
  $stmt = mysqli_stmt_init($conn);
  if(mysqli_stmt_prepare($stmt, $query)){
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    if(mysqli_num_rows($result)>0){
      return 1;

    }else{
      return 0;
    }
   }
   else{
     return 0;
   }
}

  //to upload students and their corresponding warden
  function student_warden_data_upload($file){
    global $conn;
    $file = fopen($file, "r");
    while($row = fgetcsv($file)){
      $id=strtoupper(str_replace(" ","",$row[0]));
      $deputy_warden_name =strtoupper($row[1]);
      $deputy_warden_id = str_replace(" ","",$row[2]);
      $warden_name = strtoupper($row[3]);
      $warden_id = str_replace(" ","",$row[4]);
      $chief_warden_name = strtoupper($row[5]);
      $chief_warden_id = str_replace(" ","",$row[6]);

      $table_name = "student-warden";
      $student_exists = check_student_already_exists($id, $table_name);
      echo $student_exists;
      if($student_exists){
        $query = "UPDATE `student-warden` SET deputy_warden_name=?, deputy_warden_id=?, warden_name = ?, warden_id=?,chief_warden_name=?, chief_warden_id=? WHERE stu_id=?";
        $stmt = mysqli_stmt_init($conn);
        if(mysqli_stmt_prepare($stmt, $query)){
          mysqli_stmt_bind_param($stmt, "sssssss", $deputy_warden_name, $deputy_warden_id, $warden_name, $warden_id, $chief_warden_name, $chief_warden_id, $id);
          mysqli_stmt_execute($stmt);
        }
      }else{
        $query = "INSERT INTO `student-warden` (stu_id, deputy_warden_name, deputy_warden_id, warden_name, warden_id,chief_warden_name, chief_warden_id) VALUES (?,?,?,?,?,?,?)";
        $stmt = mysqli_stmt_init($conn);
        if(mysqli_stmt_prepare($stmt, $query)){
          mysqli_stmt_bind_param($stmt, "sssssss", $id, $deputy_warden_name, $deputy_warden_id, $warden_name, $warden_id, $chief_warden_name, $chief_warden_id);
          mysqli_stmt_execute($stmt);
        }
      }
     
    }
  }

  //to upload sem subjects
    //To upload new students data
    function subjects_data_upload($file){
      global $conn;
      //deleting all existing data from the table
      mysqli_query($conn, "TRUNCATE TABLE sem_subjects");

      //inserting new data
      $file = fopen($file, "r");
      while($row = fgetcsv($file)){
        $sub_name = $row[0];
        $sub_code=str_replace(" ","",$row[1]);
        $branch = $row[2];
        $year = $row[3];
        
  
        $query = "INSERT INTO sem_subjects (sub_name, sub_code, branch, year) VALUES (?,?,?,?)";
        $stmt = mysqli_stmt_init($conn);
        if(mysqli_stmt_prepare($stmt, $query)){
          mysqli_stmt_bind_param($stmt, "ssss",$sub_name, $sub_code, $branch, $year);
          mysqli_stmt_execute($stmt);
          $result = mysqli_stmt_get_result($stmt);
        }
      }
    }

    //to upload faculty data
    function faculty_data_upload($file){
      global $conn;
      //deleting all existing data from the table
      mysqli_query($conn, "TRUNCATE TABLE sem_faculty");

      //inserting new data
      $file = fopen($file, "r");
      while($row = fgetcsv($file)){
        $faculty_name = $row[0];;
        $sub_name = $row[1];
        $sub_code=str_replace(" ","",$row[2]);

        $query = "INSERT INTO sem_faculty (faculty_name,sub_name, sub_code) VALUES (?,?,?)";
        $stmt = mysqli_stmt_init($conn);
        if(mysqli_stmt_prepare($stmt, $query)){
          mysqli_stmt_bind_param($stmt, "sss",$faculty_name,$sub_name, $sub_code);
          mysqli_stmt_execute($stmt);
          $result = mysqli_stmt_get_result($stmt);
        }
      }
    }


?>