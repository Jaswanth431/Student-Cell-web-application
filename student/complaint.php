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
              <h1 class="heading-primary heading-underline"><i class="fa fa-hand-o-right" aria-hidden="true"></i>Add Complaint</h1>
              <div class="display-error-box">
                <p>
                  <?php
                      if(isset($_POST['add-complaint-btn'])){
                        $complaint_data = escape_char($_POST['complaint_data']);
                        $complaint_to = escape_char($_POST['complaint_to']);

                        if($complaint_data == "" || $complaint_to == ""){
                          echo "All feilds are required!";
                        }else{
                          $date = get_date(0);
                          $id = $_SESSION['user'];
                          $status = "N";
                          $query = "INSERT INTO complaints (stu_id, complaint_info, complaint_to,date, resolved )VALUES (?,?,?,?,?)";
                          $stmt = mysqli_stmt_init($conn);
                          if(mysqli_stmt_prepare($stmt, $query)){
                            mysqli_stmt_bind_param($stmt, "sssss", $id, $complaint_data,$complaint_to,$date,$status);
                            mysqli_stmt_execute($stmt);
                            echo "Complaint forwarded";                        
                          }else{
                            echo "db error";
                          }
                        }
                      }
                  ?>
                </p>
              </div>
              <div class="complaint-box">
                <form action="complaint.php" method="POST">
                      <input type="text" name="complaint_data" class="input-element" placeholder="Describe your complaint here..."/>
                      <select  name="complaint_to" class="select-element">
                            <option value="">Complaint to</option>
                            <option value="exam_cell">Exam Cell</option>
                            <option value="dean_academics">Dean Academics</option>
                            <option value="student_welfare">Dean Student welfare</option>
                            <option value="it_infra">It infra</option>
                      </select>
                      <button class="btn-full" name="add-complaint-btn">Add complaint</button>
                  </form>
              </div>
              <h1 class="heading-primary heading-underline"><i class="fa fa-hand-o-right" aria-hidden="true"></i> Recent Complaints</h1>
              <div class="table-box">

              <?php
                $id = $_SESSION['user'];
                $query = "SELECT * FROM complaints WHERE stu_id = ?";
                $stmt = mysqli_stmt_init($conn);
                if(mysqli_stmt_prepare($stmt, $query)){
                  mysqli_stmt_bind_param($stmt, "s", $id);
                  mysqli_stmt_execute($stmt);
                  $result = mysqli_stmt_get_result($stmt);
                  if(mysqli_num_rows($result)>0){
                      $output  = "<table><tr><th>Com No</th><th class='complaint_info'>Complaint</th><th>Complaint to</th><th>Date of complaint</th><th>Status</th><th>Reply</th></tr>";
                      while($row = mysqli_fetch_assoc($result)){
                        $complaint_to = "";
                        if($row['complaint_to'] == "exam_cell")$complaint_to = "EXAM CELL";
                        else if($row['complaint_to'] == "it_infra")$complaint_to = "IT INFRA";
                        else if($row['complaint_to'] == "dean_academics")$complaint_to = "DEAN ACADEMICS";
                        else if($row['complaint_to'] == "student_welfare")$complaint_to = "STUDENT WELFARE";
                        
                        $admin_reply = ($row['admin_reply'] == ""?"-":$row['admin_reply']);
                        $status = ($row['resolved'] == "N"?"Not resolved":"Resolved");
                        $output.=" <tr><td>".$row['id']."</td><td class='complaint_info'>".$row['complaint_info']."</td><td>".$complaint_to."</td><td>".$row['date']."</td><td>".$status."</td><td>".$admin_reply."</td></tr>";
                      }

                      $output.="</table>";
                      echo $output;
                  }else{
                    echo "<h2>No complaints found</h2>";
                  }
                }
              ?>
                
              </div>

           </div>
        </main>
        
        <?php require_once('../footer.php');?>
    <script src="js/script.js"></script>
    </body>
</html>
