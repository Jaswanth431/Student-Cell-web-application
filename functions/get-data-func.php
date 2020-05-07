<?php
  //to get student data
  function student_data($student_id){
    global $conn;
    $id = $student_id;
    $query = "SELECT * FROM student_info WHERE stu_id =  ?";
    $stmt = mysqli_stmt_init($conn); 
    if(mysqli_stmt_prepare($stmt, $query)){
      mysqli_stmt_bind_param($stmt,  "s", $id);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      if(mysqli_num_rows($result)>=1){
        $row = mysqli_fetch_assoc($result);
        return $row;
      }else{
        return -1;
      }
      
    }
  }


  //to get admin data
  function admin_data($id){
    global $conn;
    $query = "SELECT * FROM admins WHERE email =  ?";
    $stmt = mysqli_stmt_init($conn);
    if(mysqli_stmt_prepare($stmt, $query)){
      mysqli_stmt_bind_param($stmt,  "s", $id);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      $row = mysqli_fetch_assoc($result);
      return $row;
    }
  }

  //to get sem result
  function get_sem_result($id, $sem_type){
    global $conn;
    $query = "SELECT * FROM ".$sem_type." WHERE clg_id =  ? ";
    $stmt = mysqli_stmt_init($conn);
    if(mysqli_stmt_prepare($stmt, $query)){
      mysqli_stmt_bind_param($stmt,  "s", $id);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      if(mysqli_num_rows($result) > 0){
          return $result;
      }else{
        return NULL;
      }
    }else{
        echo "DB error";
    }
  }

  //to get academic result sem wise
  function show_academic_result($id,$sem_type ){
    $result = get_sem_result($id, $sem_type);
    if(isset($result)){
      $sem_data = explode("__", $sem_type);
      $output = "<h3 class='sem-type'>SEM:".strtoupper($sem_data[0])." ". strtoupper($sem_data[1])."</h3>";
      $output.="<table><tbody><tr><th>Sub name</th><th>Sub Code</th><th>MID1</th><th>MID2</th><th>MID3</th><th>BO2</th> <th>WAT</th><th>GRADE</th></tr>";
      while($row = mysqli_fetch_assoc($result)){
        $output .="<tr ><td >".$row['subname']."</td><td >".$row['subcode']."</td><td >".$row['mid1']."</td><td >".$row['mid2']."</td><td >".$row['mid3']."</td> <td>".$row['BO2']."</td><td >".$row['wat']."</td><td>".$row['grade']."</<td></tr>";
      }

      $output .= "</tbody></table>";
      echo $output;
    }

  }


  //to display student profile
  function show_profile($id){
    $id = strtoupper($id);
    $row = student_data($id);
    if($row == -1)return;
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

    $profile_img= $row['profile_img'];
    $path = "male-temp.png";
    if($profile_img == "" && $gender == "M")$path = "male-temp.png";
    else if($profile_img == "" && $gender == "F")$path = "female-temp.png";
    else $path = $profile_img;



    global $folder_path;
    $path = $folder_path.$path;
    $output = "<div class='profile-img-box'>
                        <img src='".$path."' alt='Profile img'>
                  </div>
                  <div class='student-data'>
                    <div class='details-box'>
                      <h2 class='details-heading'>Name</h2>
                      <h2 class='details-data'>".$name."</h2>
                      
                    </div>
                    
                    <div class='details-box'>
                        <h2 class='details-heading'>College ID</h2>
                      <h2 class='details-data'>".$id."</h2>
                    </div>
                    <div class='details-box'>
                        <h2 class='details-heading'>Email</h2>
                      <h2 class='details-data'>".$email."</h2>
                    </div>
                    <div class='details-box'>
                        <h2 class='details-heading'>Hallticket</h2>
                      <h2 class='details-data'>".$ht."</h2>
                    </div>
                    <div class='details-box'>
                        <h2 class='details-heading'>Date of Birth</h2>
                      <h2 class='details-data'>".$dob."</h2>
                    </div>
                    <div class='details-box'>
                        <h2 class='details-heading'>Gender</h2>
                      <h2 class='details-data'>".$gender."</h2>
                    </div>
                    <div class='details-box'>
                        <h2 class='details-heading'>Year</h2>
                      <h2 class='details-data'>".$year."</h2>
                    </div>
                    <div class='details-box'>
                        <h2 class='details-heading'>Branch</h2>
                      <h2 class='details-data'>".$branch."</h2>
                    </div>
                    <div class='details-box'>
                        <h2 class='details-heading'>Section</h2>
                      <h2 class='details-data'>".$section."</h2>
                    </div>
                    <div class='details-box'>
                        <h2 class='details-heading'>Hostel Room</h2>
                      <h2 class='details-data'>".$hostel_room."</h2>
                    </div>
                    <div class='details-box'>
                        <h2 class='details-heading'>Mother Name</h2>
                      <h2 class='details-data'>".$mother_name."</h2>
                      
                    </div>
                    <div class='details-box'>
                        <h2 class='details-heading'>Father Name</h2>
                        <h2 class='details-data'>".$father_name."</h2>
                       </div>
                    <div class='details-box'>
                        <h2 class='details-heading'>Guardian Name</h2>
                      <h2 class='details-data'>".$guardian_name."</h2>
                    </div>
                    <div class='details-box'>
                        <h2 class='details-heading'>Parent Mobile Number</h2>
                      <h2 class='details-data'>".$parent_mobile_num."</h2>
                    </div>
                    <div class='details-box'>
                        <h2 class='details-heading'>Student Mobile Number</h2>
                      <h2 class='details-data'>".$stu_mobile_num."</h2>
                    </div>
                    
                    <div class='details-box'>
                        <h2 class='details-heading'>Address</h2>
                      <h2 class='details-data'>".$address."</h2>
                    </div> 
                  </div>
        ";

          echo $output;
   }
?>


                            