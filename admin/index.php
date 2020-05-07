<?php
    session_start();
    ob_start();
    require_once('../functions/general-func.php');
    require_once('../functions/session-func.php');
    if(if_logged() && !if_student_logged()){
        if($_SESSION['user_type'] == "exam_cell")redirect_to("examcell/home.php");
        else if($_SESSION['user_type'] == "it_infra")redirect_to("itinfra/home.php");
        else if($_SESSION['user_type'] == "student_welfare")redirect_to("studentwelfare/home.php");
        else if($_SESSION['user_type'] == "dean_academics")redirect_to("deanacademics/home.php");
        else if($_SESSION['user_type'] == "warden")redirect_to("warden/home.php");
        else if($_SESSION['user_type'] == "security")redirect_to("security/home.php");
    }
    if(if_student_logged())redirect_to("../index.php");
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
        
        <link rel="stylesheet" href="../css/style.css" />
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    </head>
    <body class="preload">
        <?php require_once('../header.php');?>
        <main class="admin-main">
            <div class="admin-login-box">
                <h1>Login</h1>
                <div class="error-box">
                    <p></p>
                </div>
                <div class="response-data"></div>
                <form>
                    <div class="input-group">
                        <label for="#admin_email">Email Id:</label>
                        <span class="input-icon">
                            <i class="fa fa-id-card" aria-hidden="true"></i>
                        </span>
                        <input type="text" id="admin_email" placeholder="Enter your Email.." />
                    </div>
                    <div class="input-group">
                        <label for="#admin_pass">Password:</label>
                        <span class="input-icon">
                            <i class="fa fa-key" aria-hidden="true"></i>
                        </span>
                        <input type="password" autocomplete="on" id="admin_pass" placeholder="Enter your password" />
                    </div>
                    <div class="input-group">
                        <button type="button" class="login-btn" id="admin-login-btn">Login</button>
                    </div>
                </form>
            </div>
        </main >
        <?php require_once('../footer.php');?>
        <script src="../js/home.js"></script>
        <script src="../js/login.js"></script>
    </body>
</html>
