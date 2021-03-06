<?php
     session_start();
     ob_start();
     require_once('../../includes/db.php');
     require_once('../../functions/general-func.php');
     require_once('../../functions/session-func.php');
     require_once('../../functions/get-data-func.php');
     if(!if_security_logged())redirect_to("../index.php");
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
                
                <h1 class="heading-primary heading-underline"><i class="fa fa-hand-o-right" aria-hidden="true"></i>Approve OUT</h1>
                <div class="response-box">
                </div>
                <div class="outpass-list-box">
                    <input type="text" id="student_id" class="input-element" placeholder="Enter student ID...">
                </div>

                <div class="outpass-list">
                   
                </div>
            </div>
        </main>
        <?php require_once('../../footer.php');?>
    <script src="../js/script.js"></script>
    <script src="../js/ajax-calls.js"></script>

    </body>
</html>
