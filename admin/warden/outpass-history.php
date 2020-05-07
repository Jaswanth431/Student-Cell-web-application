<?php
     session_start();
     ob_start();
     require_once('../../includes/db.php');
     require_once('../../functions/general-func.php');
     require_once('../../functions/session-func.php');
     require_once('../../functions/get-data-func.php');
     if(!if_warden_logged())redirect_to("../index.php");

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
                <h1 class="heading-primary heading-underline"><i class="fa fa-hand-o-right" aria-hidden="true"></i> Student Outpass history</h1>
                <div class="outpass-history-box">
                  <form action="outpass-history.php" method="POST">
                    <input type="text" class="input-element margin-right" placeholder="Enter student ID" name="student_id">
                    <button class="btn-full " name="get-outpass-data">Get data</button>
                    </form>
                  <div class="table-box">
                    <?php
                        if(isset($_POST['get-outpass-data'])){
                          $id = escape_char($_POST['student_id']);
                          $query = "SELECT * FROM outpass WHERE stu_id = ? AND out_from_campus IS NOT NULL";
                          $stmt = mysqli_stmt_init($conn);
                          if(mysqli_stmt_prepare($stmt, $query)){
                            mysqli_stmt_bind_param($stmt,"s", $id);
                            mysqli_stmt_execute($stmt);
                            $result = mysqli_stmt_get_result($stmt);
                            if(mysqli_num_rows($result) == 0){
                              echo "<h2>No data found</h2>";
                            }else{
                              $output = " <table>
                                <tbody>
                                <tr>
                                <th>S.No</th>
                                  <th>OP No</th>
                                  <th>Reason</th>
                                  <th>OUT Date</th>
                                  <th>IN Date</th>
                                  <th>Days approved</th>
                                  <th>Days taken</th>
                                  <th>Type</th>
                                 </tr>";
                              for($i=1; $row = mysqli_fetch_assoc($result); $i++){
                                $out_date = get_date_from_datetime($row['out_from_campus']);
                                if($row['in_to_campus'] == NULL){
                                  $in_date = "-";
                                  $days_taken = "-";
                                  $type = "-";
                                }else{
                                  $in_date = get_date_from_datetime($row['in_to_campus']);
                                  $days_taken = days_diff($in_date, $out_date);
                                  $type = $row['requested_days']>=$days_taken?"Regular":"Irregular";

                                }
                                
                                $output .= "<tr>
                                <td>".$i."</td>
                                <td>".$row['id']."</td>
                                <td>".$row['reason_type']."</td>
                                <td>".$out_date."</td>
                                <td>".$in_date."</td>
                                <td>".$row['requested_days']."</td>
                                <td>".$days_taken."</td>
                                <td>".$type."</td>
                               </tr>";

                              }

                              $output .="</tbody></table>";
                              echo $output;
                            }
                          }


                        }
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
