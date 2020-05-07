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
              <h1 class="heading-primary heading-underline"><i class="fa fa-hand-o-right" aria-hidden="true"></i> Add notifications</h1>
              <div class="display-error-box">
                  <p>
                  <?php
                     if(isset($_POST['add-notification-btn'])){
                         $news_text = escape_char($_POST['news_text']);
                         $file_name = $_FILES['notification_file']['name'];
                         $file_error = $_FILES['notification_file']['error'];
                         $tmp_name = $_FILES['notification_file']['tmp_name'];

                         if($news_text == ""){
                             echo "Notification must not be empty!";
                         }else{
                             $date = get_date(0);
                             $user = $_SESSION['user'];
                             $user_type = $_SESSION['user_type'];
                             if(empty($file_name)){
                                $file_name = "";
                             }

                             $query = "INSERT INTO news_updates (news_text, date, file_name, added_by, news_related_to) VALUES (?,?,?,?,?)";
                             $stmt = mysqli_stmt_init($conn);
                            if(mysqli_stmt_prepare($stmt, $query)){
                                mysqli_stmt_bind_param($stmt, "sssss",$news_text, $date,$file_name, $user, $user_type);
                                mysqli_stmt_execute($stmt);

                                if($file_name != ""){
                                    $target_file_name = "../../notify_files/". basename($file_name);
                                   
                                    move_uploaded_file($tmp_name, $target_file_name);
                                }
                                echo "Notification added";
                            }
                             
                         }
                     }
                  ?>
                  </p>
              </div>
              <div class="notification-box">
                <form action="add-news.php" method="POST"  enctype="multipart/form-data">
                    <input type="text" name="news_text" class="input-element mb-1" placeholder="Enter notification info"/>
                    <div class="notification-file-upload">
                                    <input type="file" name="notification_file" class="custom-file-input"/>
                    </div>
                    <button class="btn-full" name="add-notification-btn">Add notification</button>
                </form>
                    
              </div>


            </div>
          
        </main>
        <?php require_once('../../footer.php');?>
    <script src="../js/script.js"></script>
    </body>
</html>
