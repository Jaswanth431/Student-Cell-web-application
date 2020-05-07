<?php
session_start();
require_once('../../includes/db.php');
require_once('../../functions/get-data-func.php');
require_once('../../functions/general-func.php');


//to get outpass list of students
if(isset($_POST['stu_id'])){
  $id = escape_char($_POST['stu_id']);
  $id = "%{$id}%";
  $output = "<div class='table-box'><table>
              <tr>
                  <th>OP No</th>
                  <th>Student ID</th>
                  <th>Student Name</th>
                  <th>Approved by</th>
                  <th>Out from campus</th>
              </tr>";

  $date = get_date(0);
  $approved="yes";
  $query = "SELECT * FROM outpass WHERE (stu_id LIKE ?) AND (outing_date=?) AND (approved=?) AND (out_from_campus IS NULL)";
  $stmt = mysqli_stmt_init($conn);
  echo mysqli_error($conn);
  if(mysqli_stmt_prepare($stmt, $query)){
    mysqli_stmt_bind_param($stmt,  "sss", $id, $date,$approved );
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if(mysqli_num_rows($result) == 0){
      echo "<h2>Outpass not found</h2>";
      return;
    }


    for($i =1;$row=mysqli_fetch_assoc($result); $i++){
      $output.="<tr id='".$i."'>
      <td class='outpass_id'>".$row['id']."</td>
      <td class='student_id' >".$row['stu_id']."</td>
      <td>".$row['stu_name']."</td>
      <td>".$row['approved_by']."</td>
      <td><button type='button' class='btn-full out-from-campus-btn'>OUT</button></td> 
      </tr>";
    }

    $output.=" </table></div>";
    echo $output;
  }else{
    echo "jasw";
  }
     
}


//to approve student to left out from cammpus
else if(isset($_POST['out_stu_id'] ) && isset($_POST['out_op_id'])){
  $stu_id = $_POST['out_stu_id'];
  $op_id = $_POST['out_op_id'];
  $date = get_date(1);
  $query = "UPDATE outpass SET out_from_campus=? WHERE id=?";
  $stmt = mysqli_stmt_init($conn);
  if(mysqli_stmt_prepare($stmt, $query)){
      mysqli_stmt_bind_param($stmt,  "ss", $date, $op_id);
      mysqli_stmt_execute($stmt);
  }

  $in_campus = "no";
  $query = "UPDATE `student-warden` SET in_campus=? WHERE stu_id=?";
  $stmt = mysqli_stmt_init($conn);
  if(mysqli_stmt_prepare($stmt, $query)){
      mysqli_stmt_bind_param($stmt,  "ss", $in_campus, $stu_id);
      mysqli_stmt_execute($stmt);
      $ele ='<i class="fa fa-check" aria-hidden="true"></i>';
      $btn = '#'.$_POST['row_id'].' '.'.out-from-campus-btn';
      echo "<script> $('".$btn."').html('".$ele."');</script>";
  }

}


//to get list students out of campus
else if(isset($_POST['out_of_campus_stu_id'])){
  $input_id = escape_char($_POST['out_of_campus_stu_id']);
  $input_id = "%{$input_id}%";
  $output = "<div class='table-box'><table>
              <tr>
                  <th>OP No</th>
                  <th>Student ID</th>
                  <th>Student Name</th>
                  <th>IN to campus</th>
              </tr>";
  $in_campus = "no";
  $query = "SELECT * FROM `student-warden` WHERE in_campus = ? AND stu_id LIKE ?";
  $stmt = mysqli_stmt_init($conn);
  echo mysqli_error($conn);
  if(mysqli_stmt_prepare($stmt, $query)){
    mysqli_stmt_bind_param($stmt,  "ss",$in_campus, $input_id );
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if(mysqli_num_rows($result) == 0){
      echo "<h2>Outpass not found</h2>";
      return;
    }


    for($i =1;$data=mysqli_fetch_assoc($result); $i++){
      $student_id = $data['stu_id'];
      $query1 = "SELECT * FROM outpass WHERE (in_to_campus = '' OR in_to_campus IS NULL) AND (out_from_campus != '' OR out_from_campus IS NOT NULL) AND (stu_id= '$student_id') ORDER BY outing_date DESC LIMIT 1";
      $result1 = mysqli_query($conn, $query1);

      if(mysqli_num_rows($result1) == 0) continue;
      $row = mysqli_fetch_assoc($result1);
      $output.="<tr id='".$i."'>
      <td class='outpass_id'>".$row['id']."</td>
      <td class='student_id' >".$row['stu_id']."</td>
      <td>".$row['stu_name']."</td>
      <td><button type='button' class='btn-full in-to-campus-btn'>IN</button></td> 
      </tr>";
    }

    $output.=" </table></div>";
    echo $output;
  }else{
    echo "jasw";
  }
     
}

//to approve student to came into from cammpus
else if(isset($_POST['in_stu_id'] ) && isset($_POST['in_op_id'])){
  $stu_id = $_POST['in_stu_id'];
  $op_id = $_POST['in_op_id'];
  $date = get_date(1);
  $query = "UPDATE outpass SET in_to_campus=? WHERE id=?";
  $stmt = mysqli_stmt_init($conn);
  if(mysqli_stmt_prepare($stmt, $query)){
      mysqli_stmt_bind_param($stmt,  "ss", $date, $op_id);
      mysqli_stmt_execute($stmt);
  }

  $in_campus = "yes";
  $query = "UPDATE `student-warden` SET in_campus=? WHERE stu_id=?";
  $stmt = mysqli_stmt_init($conn);
  if(mysqli_stmt_prepare($stmt, $query)){
      mysqli_stmt_bind_param($stmt,  "ss", $in_campus, $stu_id);
      mysqli_stmt_execute($stmt);
      $ele ='<i class="fa fa-check" aria-hidden="true"></i>';
      $btn = '#'.$_POST['row_id'].' '.'.in-to-campus-btn';
      echo "<script> $('".$btn."').html('".$ele."');</script>";
  }

}
?>