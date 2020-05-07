<?php
     session_start();
     ob_start();
     require_once('../../includes/db.php');
     require_once('../../functions/general-func.php');
     require_once('../../functions/session-func.php');
     require_once('../../functions/get-data-func.php');
     require_once('../../functions/upload-data-func.php');
     if(!if_itinfra_logged())redirect_to("../index.php");

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
                <h1 class="heading-primary heading-underline">
                <i class="fa fa-hand-o-right" aria-hidden="true"></i>Survey Results
                </h1>
                <div class="survey-results-box">
                    <table>
                        <tr>
                            <th class='left-align'>S.No</th>
                            <th>Faculty Name</th>
                            <th>Total submitted</th>
                            <th>Rating</th>
                        </tr>
                        <?php
                           $query1 = "SELECT * FROM sem_faculty";
                           $result_faculty = mysqli_query($conn, $query1);
                           if(mysqli_num_rows($result_faculty)>0){
                               $i=0;
                                While($row = mysqli_fetch_assoc($result_faculty) ){
                                    $i=$i+1;
                                    $f_name = $row['faculty_name'];
                                    if($f_name == "")continue;
                                    $query2 = "SELECT * FROM faculty_survey WHERE faculty = '$f_name'";
                                    $result = mysqli_query($conn, $query2);
                                    $count = 0;
                                    $total_rating = 0;
                                    if(mysqli_num_rows($result)>0){
                                        while($survey = mysqli_fetch_assoc($result)){
                                            $count+=1;
                                            $total_rating += $survey['avg'];
                                        }

                                        $avg = $total_rating/$count;
                                    }else{
                                        $avg = 0;
                                    }

                                    echo "<tr><td >".$i."</td><td>".$f_name."</td><td>".$count."</td>
                                    <td>".$avg."</td></tr>";

                                }
                           }
                           
                        ?>
                    </table>    
                </div>
            </div>
          
        </main>
        <?php require_once('../../footer.php');?>
    <script src="../js/script.js"></script>
    </body>
</html>
