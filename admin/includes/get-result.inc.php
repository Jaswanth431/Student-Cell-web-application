<?php
session_start();
require_once('../../includes/db.php');
require_once('../../functions/get-data-func.php');
require_once('../../functions/general-func.php');


//to get student marks

if(isset($_POST['sem_type']) && isset($_POST['stu_id'])){
  $id = escape_char(strtoupper($_POST['stu_id']));
  $sem_type = $_POST['sem_type'];
  $result = get_sem_result($id, $sem_type);
  if($result == NULL){
    echo "<h1>No results found</h1>";
  }else{
    $output = "<table><tr><th>Sub name</th><th>Sub Code</th><th>MID1</th></th><th>MID2</th><th>MID3</th><th>BO2</th> <th>WAT</th><th>GRADE</th><th>Update</th></tr>";
    $i=0;
    while($row = mysqli_fetch_assoc($result)){
       
        $output .="<tr id='".$i++."'><td class='sub_name'>".$row['subname']."</td><td >".$row['subcode']."</td><td contenteditable='true' class='mid1'>".$row['mid1']."</td></td><td class='mid2' contenteditable='true'>".$row['mid2']."</td><td class='mid3' contenteditable='true'>".$row['mid3']."</td><td contenteditable='true' class='bo2'>".$row['BO2']."</td> <td class='wat' contenteditable='true'>".$row['wat']."</td><td contenteditable='true' class='grade'>".$row['grade']."</td><td><button class='update-btn'><i class='fa fa-check-square .tick-icon' aria-hidden='true'></i></button></td></tr>";
    }
    $output.="</table>";
    echo $output;
  }
}


//to update marks of student
if(isset($_POST['tb_name']) && isset($_POST['mid1']) && isset($_POST['mid2']) && isset($_POST['mid3']) && isset($_POST['wat']) && isset($_POST['grade']) && isset($_POST['bo2']) && isset($_POST['id']) && isset($_POST['sub_code'])){
  $mid1 =$_POST['mid1'];
  $mid2 = $_POST['mid2'];
  $mid3=$_POST['mid3'];
  $wat = $_POST['wat'];
  $grade = $_POST['grade'];
  $bo2 = $_POST['bo2'];
  $table_name = $_POST['tb_name'];
  $id = strtoupper($_POST['id']);
  $sub_code = $_POST['sub_code'];
  $sub_name = $_POST['sub_name'];
  echo $sub_name;
  $query = "UPDATE ".$table_name." SET mid1=?, mid2=?, mid3=?, wat=?, grade=?, BO2=? WHERE  (clg_id = ? AND  subname = ?)";
  $stmt = mysqli_stmt_init($conn);
  if(mysqli_stmt_prepare($stmt, $query)){
    mysqli_stmt_bind_param($stmt,  "ssssssss", $mid1, $mid2, $mid3, $wat, $grade, $bo2, $id,  $sub_name);
    mysqli_stmt_execute($stmt);
    echo "updated";
  }else{
      echo "DB error";
  }

}


//to display all sems data
if(isset($_POST['clg_id'])){
    $id = strtoupper(escape_char($_POST['clg_id']));
    show_academic_result($id, "p1__sem1");
    show_academic_result($id, "p1__sem2");
    show_academic_result($id, "p2__sem1");
    show_academic_result($id, "p2__sem2");
    show_academic_result($id, "e1__sem1");
    show_academic_result($id, "e1__sem2");
    show_academic_result($id, "e2__sem1");
    show_academic_result($id, "e2__sem2");
    show_academic_result($id, "e3__sem1");
    show_academic_result($id, "e3__sem2");
    show_academic_result($id, "e4__sem1");
    show_academic_result($id, "e4__sem2");
}
?>