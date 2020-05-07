<?php

  session_start();
  require_once('../../includes/db.php');
  require_once('../../functions/get-data-func.php');
  require_once('../../functions/general-func.php');

function get_sub_name($sub_code){
  global $conn;
  $query = "SELECT * FROM sem_subjects WHERE sub_code = ? LIMIT 1";
  $stmt = mysqli_stmt_init($conn);
  if(mysqli_stmt_prepare($stmt, $query)){
      mysqli_stmt_bind_param($stmt,  "s", $sub_code);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      $row = mysqli_fetch_assoc($result);
      return $row['sub_name'];
  }
}

function check_survey_exits_for_subject($sub_code){
  global $conn;
  $id = $_SESSION['user'];
  $query = "SELECT * FROM faculty_survey WHERE clg_id=? AND sub_code = ?";
  $stmt = mysqli_stmt_init($conn);
  if(mysqli_stmt_prepare($stmt, $query)){
      mysqli_stmt_bind_param($stmt,  "ss", $id, $sub_code);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      if(mysqli_num_rows($result)> 0){
        return 1;
      }else{
        return 0;
      }
  }
  
}
//to get faculty data
if(isset($_POST['sub_code'])){
  $sub_code = $_POST['sub_code'];
  $query = "SELECT * FROM `sem_faculty` WHERE sub_code= ? ";
  $stmt = mysqli_stmt_init($conn);
  if(mysqli_stmt_prepare($stmt, $query)){
      mysqli_stmt_bind_param($stmt,  "s", $sub_code);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      if(mysqli_num_rows($result) == 0){
          echo "<option value=''>Select Faculty</option><option value=''>No Data avalaible</option>";
          exit();
      }else{
          $output = "<option value=''>Select Faculty</option>";
          while($row = mysqli_fetch_assoc($result)){
            print_r($row);
              $output.="<option value='".$row['faculty_name']."'>".$row['faculty_name']."</option>";
          }
          echo $output;
      }
  }else{
    echo "<option value=''>Data base error</option>";
  }
}

//to get survey questions
else if(isset($_POST['subject_code'])){
    $sub_code = $_POST['subject_code'];
    $subject_exists = check_survey_exits_for_subject($sub_code);
    if($subject_exists){
        $sub = get_sub_name($sub_code);
        echo "<script>error_display('You have already submitted  feedback for ".$sub." ', 1);</script>";
        exit();
    }else{
        $questions = [
          "1. Whether the Syllabus and the Lecture Plan are provided at beginning of the course?",
          "2. Is instructor punctual & regular to the class?",
          "3. Level of Instructor’s Preparedness to the class",
          "4. Level of Instructor’s Communication and Presentation",
          "5. Level of Instructor’s Effectiveness in organizing the class",
          "6. Level of Instructor’s subject depth",
          "7. Whether the instructor covered entire syllabus?",
          "8. Whether the instructor discussed topics beyond syllabus?",
          "9. Level of Instructor’s availability to the students outside the class room",
          "10. Overall quality in delivery of the course"
        ];
        $options = ["VERY GOOD(5 POINTS)","GOOD(4 POINTS)","FAIR(3 POINTS)","POOR(2 POINTS)","VERY POOR(1 POINTS)" ];
        $options_value = ["very_good", "good","fair","poor","very_poor"];
        $output = "";

        for( $i=0;$i<10;$i++){
          $x = $i+1;
          $output .= "<div class='question-box'><h1 class='question-heading'>".$questions[$i]."</h1>";
          $output .="<select  id='q".$x."' required>";
          $output .= "<option value='' selected>Please select Rating points</option>";
          for($j=0;$j<5;$j++){
            $output.="<option value='".$options_value[$j]."'>".$options[$j]."</option>";
          }
          $output .="</select></div>";
        }

        $output .= "<div class='question-box'><h1 class='question-heading'>11. Comments</h1><input  id='q11' class='input-element comment-box' required placeholder='Share Your Review via Comment On The Faculty'></div><div class='question-box'><button id='submit_survey' onclick='submit_survey()' class='btn-full'>Submit Survey</button></div>";

        echo $output;
    }
}

else if( isset($_POST['s_code']) && isset($_POST['f_name']) && isset($_POST['q1']) && isset($_POST['q2']) && isset($_POST['q3']) && isset($_POST['q4']) && isset($_POST['q5']) && isset($_POST['q6']) && isset($_POST['q7']) && isset($_POST['q8']) && isset($_POST['q9']) && isset($_POST['q10']) && isset($_POST['q11']) ){
  $sub_code = $_POST['s_code'];
  $faculty_name = $_POST['f_name'];
  $q1 = $_POST['q1'];
  $q2 = $_POST['q2'];
  $q3 = $_POST['q3'];
  $q4 = $_POST['q4'];
  $q5 = $_POST['q5'];
  $q6 = $_POST['q6'];
  $q7 = $_POST['q7'];
  $q8 = $_POST['q8'];
  $q9 = $_POST['q9'];
  $q10 = $_POST['q10'];
  $q11= $_POST['q11'];
  $id = $_SESSION['user'];
  $student_info = student_data();
  $year = $student_info['year'];
  $sub_name = get_sub_name($sub_code);
    $points = ["very_good"=>5,"good"=>4,"fair"=>3,"poor"=>2, "very_poor"=>1];
    $avg = ($points[$q1] + $points[$q2] +$points[$q3] +$points[$q4] +$points[$q5] +$points[$q6] +$points[$q7] +$points[$q8] +$points[$q9] +$points[$q10])/10;

    $date  = get_date(1);

    $query = "INSERT INTO faculty_survey (clg_id,sub_name,sub_code,faculty,q1,q2,q3,q4,q5,q6,q7,q8,q9,q10,comments,avg,year,time) VALUES ('$id','$sub_name','$sub_code','$faculty_name', '$q1','$q2','$q3','$q4','$q5','$q6','$q7','$q8','$q9','$q10','$q11','$avg','$year','$date')";

    $result = mysqli_query($conn,$query);
    if($result){
      echo"<script>error_display('Faculty feedback for ".$sub_name." is subbmitted!!',1);$('.survey-questions-box').html('');</script>";
        exit();
    }else{
      echo "<script>error_display('database error', 1)</script>";
    }

  

}
?>