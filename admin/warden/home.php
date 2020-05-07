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
                <h1 class="heading-primary heading-underline"><i class="fa fa-hand-o-right" aria-hidden="true"></i> Recent outpass requests</h1>
                <div class="hidden-error-box">
                    <p></p>
                </div>
                <div class="response-box"></div>
                <div class="outpass-requests-box">
                    <div class="table-box">
                        <?php
                        $date = get_date(0);
                        $date1 = add_days($date, 0, 0, 0);
                        $date2 = add_days($date, 1, 0, 0);

                        $warden_id = $_SESSION['user_id'];
                        // echo $date1.$date2.$warden_id;
                        $query = "SELECT * FROM `outpass` WHERE (outing_date BETWEEN '$date1' AND '$date2') AND (approved='pending') AND (deputy_warden_id = '$warden_id' OR warden_id = '$warden_id' OR chief_warden_id = '$warden_id') ORDER BY outing_date";
                        $result = mysqli_query($conn, $query);
                        $output="<table>
                        <tr>
                            <th>OP No</th>
                            <th>ID</th>
                            <th>OP reason</th>
                            <th>Outing date</th>
                            <th>Select reason</th>
                            <th>No of days</th> 
                            <th>Approve</th>
                            <th>Reject</th>
                        </tr>";   
                        
                        for($i=1;$row = mysqli_fetch_assoc($result); $i++){
                            $output.="<tr id='".$i."'>
                            <td class='outpass_id'>".$row['id']."</td>
                            <td class='student_id'>".$row['stu_id']."</td>

                            <td class='reason'>".$row['reason']."</td>
                            <td class='outing-date'>".$row['outing_date']."</td>
                            <td>
                            <select  class='input-element reason_type'>
                                <option value=''>Select reason type</option>
                                <option value='health'>Health</option>
                                <option value='functions'>functions</option>
                            </select>
                            </td>
                            <td><input type='number'  placeholder='Enter no of days..' class='input-element no_of_days'></td>
                            <td><button class='btn-approve outpass-approve-btn' >Approve</button></td>
                            <td><button class='btn-reject outpass-reject-btn' >Reject</button></td>
                        </tr>";
                        }

                        $output.="</table>";
                        echo $output;
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
