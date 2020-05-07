<?php
     session_start();
     ob_start();
     require_once('../../includes/db.php');
     require_once('../../functions/general-func.php');
     require_once('../../functions/session-func.php');
     require_once('../../functions/get-data-func.php');
     if(!if_studentwelfare_logged())redirect_to("../index.php");

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <title>Student Cell IIIT ONGOLE</title>
        <link rel="shortcut icon" href="../../img/favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
        <link rel="stylesheet" href="../structure.css"/>
        <script
            src="https://code.jquery.com/jquery-3.4.1.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
            crossorigin="anonymous"
        ></script> 
    </head>
    <body>
        <?php require_once('../header.php');?>
        <main>
            <?php require_once('../side-navigation.php');?>
            <div class="content-box">
                <h1 class="heading-primary heading-underline"><i class="fa fa-hand-o-right" aria-hidden="true"></i> Recent outpass requests</h1>
                <div class="student-statistics-box">
                  <div class="details-box">
                    <?php
                          $statistics = "";
                         $op_students = $in_campus_students = $total = 0;
                          $outpass_list = "<table><tbody><tr><th>S.No</th><th>OP No</th><th>Student ID</th><th>Name</th><th>Year</th><th>Branch</th><th>Section</th><th>Outing date</th></tr>";
                        $query = "SELECT * FROM `student-warden`";
                        $result = mysqli_query($conn, $query);
                        for($i = 1; $data = mysqli_fetch_assoc($result); $i++){
                            if($data['in_campus'] == "yes")$in_campus_students++;
                            else if($data['in_campus'] == "no"){

                                $op_students++;
                                $student_id = $data['stu_id'];
                                $query1 = "SELECT * FROM outpass WHERE (in_to_campus IS NULL) AND (out_from_campus IS NOT NULL) AND (stu_id= '$student_id') ORDER BY outing_date DESC LIMIT 1";
                                $result1 = mysqli_query($conn, $query1);
                                if(mysqli_num_rows($result1) == 0) continue;
                                $row = mysqli_fetch_assoc($result1);

                                $student_data = student_data($row['stu_id']);
                                $outpass_list .="<tr><td>".$i."</td><td>".$row['id']."</td><td>".$student_data['stu_id']."</td><td>".$student_data['stu_name']."</td><td>".$student_data['year']."</td><td>".$student_data['branch']."</td><td>".$student_data['section']."</td><td>".$row['outing_date']."</td></tr>";
                            }
                        }
                        $total = $i-1;
                        $outpass_list .="</tbody></table>";
                        
                          $statistics = "<h2 class='details-heading'>Total Students: ".$total."</h2>
                          <h2 class='details-heading'>Total Students Out of Campus: ".$op_students."</h2>
                          <h2 class='details-heading'>Total Students Inside campus: ".$in_campus_students."</h2>";

                          echo $statistics; 

                      ?>
                    

                  </div>
                  <h1 class="heading-primary heading-underline"><i class="fa fa-hand-o-right" aria-hidden="true"></i> Students out of campus</h1>
                  <div class="table-box">
                    <?php
                      echo $outpass_list;
                    ?>
                  </div>
                </div>
            </div>
        </main>
        <?php require_once('../../footer.php');?>
    <script src="../js/script.js"></script>
    <script src="../js/ajax-calls.js"></script>

    </body>
</html>
