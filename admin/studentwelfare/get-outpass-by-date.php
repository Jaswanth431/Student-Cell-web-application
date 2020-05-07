<?php
     session_start();
     ob_start();
     require_once('../../includes/db.php');
     require_once('../../functions/general-func.php');
     require_once('../../functions/session-func.php');
     require_once('../../functions/get-data-func.php');
     require_once('../../functions/upload-data-func.php');
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
              <h1 class="heading-primary heading-underline"><i class="fa fa-hand-o-right" aria-hidden="true"></i> Get Oupass data</h1>
              <div class="display-error-box">
                <p>
                  <?php
                      if(isset($_POST['get_data'])){
                        $date1 = $_POST['start_date'];
                        $date2= $_POST['end_date'];
                        // echo $date1.$date2;

                        if($date1 == "" || $date2 == ""){
                          echo "All feilds are required!";
                        }else{
                          $outpass_list = "<table><tbody><tr><th>S.No</th><th>OP No</th><th>Student ID</th><th>Name</th><th>Year</th><th>Branch</th><th>Section</th><th>Outing date</th><th>IN date</th></tr>";
                          $query = "SELECT * FROM outpass WHERE (outing_date BETWEEN '$date1' AND '$date2') AND out_from_campus IS NOT NULL ";
                          $result = mysqli_query($conn, $query);
                          for($i = 1; $row = mysqli_fetch_assoc($result); $i++){
                                  $student_id = $row['stu_id'];
                                  $student_data = student_data($student_id);
                                  $outpass_list .="<tr><td>".$i."</td><td>".$row['id']."</td><td>".$student_data['stu_id']."</td><td>".$student_data['stu_name']."</td><td>".$student_data['year']."</td><td>".$student_data['branch']."</td><td>".$student_data['section']."</td><td>".$row['outing_date']."</td><td>".get_date_from_datetime($row['in_to_campus'])."</td></tr>";
                          }
                          $outpass_list .="</tbody></table>";
                          
                        }
                      }

                  ?>
                
                </p>
              </div>
              <div class="outpass-list-box">
                <form action="get-outpass-by-date.php" method="POST">
                  <input type="date" class="input-element margin-right" name="start_date" value="<?php if(isset($_POST['get_data'])) echo $_POST['start_date']; ?>">
                  <input type="date" class="input-element margin-right" name="end_date" value="<?php if(isset($_POST['get_data'])) echo $_POST['end_date']; ?>">
                  <button type="date" class="btn-full" name="get_data">Get data</button>
                </form>
                <div class="table-box">
                <?php
                    if(isset($_POST['get_data']))echo $outpass_list;
                ?>
                </div>
              </div>
            </div>
        </main>
        <?php require_once('../../footer.php');?>
    <script src="../js/script.js"></script>
    </body>
</html>
