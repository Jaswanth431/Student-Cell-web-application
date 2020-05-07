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
              <h1 class="heading-primary heading-underline">
                <i class="fa fa-hand-o-right" aria-hidden="true"></i>Faculty Survery
              </h1>
              <div class="error-box">
                  <p></p>
              </div>
              <div class="survey-box">
                <div class="survey-info-box">
                    <select  id="subject_name" class="select-element margin-right">
                        <?php
                            $student_info = student_data($_SESSION['user']);
                            $year = $student_info['year'];
                            $branch = $student_info['branch'];
                            $query = "SELECT * FROM sem_subjects where branch = ? AND year = ? ";
                            $stmt = mysqli_stmt_init($conn);
                            if(mysqli_stmt_prepare($stmt, $query)){
                                mysqli_stmt_bind_param($stmt,  "ss", $branch, $year);
                                mysqli_stmt_execute($stmt);
                                $result = mysqli_stmt_get_result($stmt);
                                if(mysqli_num_rows($result) == 0){
                                    echo "<option value=''>Select Subject</option><option value=''>No subjects available</option>";
                                }else{
                                    $output = "<option value=''>Select Subject</option>";
                                    while($row = mysqli_fetch_assoc($result)){
                                        $output.="<option value='".$row['sub_code']."'>".$row['sub_name']."</option>";
                                    }
                                    echo $output;
                                }
                            }
                        ?>
                    </select>
                    <select id="faculty_name"  class="select-element margin-right">
                                <option value="">Select Faculty</option>
                    </select>
                    <button class="btn-full" id="get-survey-questions">Get Survey</button> 
                </div>
                <div class="survey-questions-box">
                   
                </div>
              </div>
            </div>
        </main>
        <?php require_once('../footer.php');?>

    <script src="js/ajax_calls.js"></script>
    <script src="js/script.js"></script>
    </body>
</html>
