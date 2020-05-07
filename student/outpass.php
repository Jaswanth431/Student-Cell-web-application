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
              <h1 class="heading-primary heading-underline"><i class="fa fa-hand-o-right" aria-hidden="true"></i> Request Outpass</h1>
              <div class="error-box"><p></p></div>
              <div class="response-box"></div>

              <div class="outpass-box">
                <form class="outpass-form" action="outpass.php" method="POST">
                      <textarea type="text" id="outing-reason" class="input-element margin-right" placeholder="Describe your issue here... "/></textarea>
                      <input type="date" id="outing-date" class="input-element margin-right" min="<?php echo get_date(0); ?>" max="<?php echo add_days(get_date(0), 1, 0,0); ?>"/>
                      <button type="button" class="btn-full" id="request-outpass-btn" name="request-outpass-btn">Request Outpass</button>
                </form>
              </div>
              <h1 class="heading-primary heading-underline"><i class="fa fa-hand-o-right" aria-hidden="true"></i>Recent Outpass</h1>
              <div class="table-box">

              <?php
                  $id = $_SESSION['user'];
                  $total_approved = $total_rejected = $total_not_responded = $total_pending =0;
                  $total_outpass_details = "";
                  $output = "<table>
                            <tr>
                              <th>OP No</th>
                              <th>OP reason</th>
                              <th>Date of Request</th>
                              <th>Date of Approved/Rejected</th>
                              <th>OP status</th></th>
                              <th>Out time</th>
                              <th>In time</th>
                              <th>Requested outdate</th>
                              <th>Number of days</th>
                              <th>approved by</th>

                            </tr>";
                  $query = "SELECT * FROM outpass WHERE stu_id = ? ORDER BY id DESC ";
                  $stmt = mysqli_stmt_init($conn); 
                  if(mysqli_stmt_prepare($stmt, $query)){
                    mysqli_stmt_bind_param($stmt,  "s", $id);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    for($i=1;$row=mysqli_fetch_assoc($result); $i++){
                    
                      $op_id = $row['id'];
                      $reason = $row['reason'];
                      $request_date  = get_date_from_datetime($row['request_time']);
                      if($row['approved_time'] != "")$approved_date = get_date_from_datetime($row['approved_time']);
                      else $approved_date = replace_empty($row['approved_time']);
                      $today_date = get_date(0);
                      $outing_date = $row['outing_date'];
                      $approved = "";
                      if($row['approved'] == "yes"){
                        $approved = "Approved";
                        $total_approved++;
                      }
                      else if($row['approved'] == "no"){
                        
                        $approved = "Rejected";
                        $total_rejected++;
                      }
                      else if($row['approved'] == "pending" && $today_date>$outing_date){
                        $approved = "Not responded";
                        $total_not_responded++;
                      }
                      else if($row['approved'] == "pending"){
                        $approved = "Pending";
                        $total_pending++;
                      }

                      $out_time = replace_empty($row['out_from_campus']);
                      $in_time = replace_empty($row['in_to_campus']);
                      $requesed_outdate = $row['outing_date'];
                      $requested_days = $row['requested_days'];
                      $approved_by = replace_empty($row['approved_by']);
                     

                      $output.="<tr>
                                  
                                  <td>".$op_id."</td>
                                  <td>".$reason."</td>
                                  <td>".$request_date."</td>
                                  <td>".$approved_date."</td>
                                  <td>".$approved."</td></td>
                                  <td>".$out_time."</td>
                                  <td>".$in_time."</td>
                                  <td>".$requesed_outdate."</td>
                                  <td>".$requested_days."</td>
                                  <td>".$approved_by."</td>

                                </tr>";

                      $total_outpass_details = " <div class='details-box'>
                      <h2 class='details-heading'>Total outpasses:".$i."</h2>
                      <h2 class='details-heading'>Total approved:".$total_approved."</h2>
                      <h2 class='details-heading'>Total rejected:".$total_rejected."</h2>
                      <h2 class='details-heading'>Total pending:".$total_pending."</h2>
                      <h2 class='details-heading'>Total Not responded:".$total_not_responded."</h2>
                      </div>";

                    }
             
                    $output.="</table>";
                    echo $total_outpass_details;
                    echo $output;
                  
                  }

              ?>
               
              </div>

           </div>
        </main>
        
        <?php require_once('../footer.php');?>
    <script src="js/script.js"></script>
    <script src="js/ajax_calls.js"></script>

    </body>
</html>
