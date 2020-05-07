<?php
     session_start();
     ob_start();
     require_once('../../includes/db.php');
     require_once('../../functions/general-func.php');
     require_once('../../functions/session-func.php');
     require_once('../../functions/get-data-func.php');
     require_once('../../functions/upload-data-func.php');
     if(!if_examcell_logged())redirect_to("../index.php");
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
        <link rel="stylesheet" href="../structure.css" />
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
                    <i class="fa fa-hand-o-right" aria-hidden="true"></i> Edit Exam result
                </h1>
                <div class="hidden-error-box"><p></p></div>
                <div class="edit-results-box margin-top-2">
                    <input type="text" id="stu_id" class="input-element margin-right mb-1" placeholder="Enter student ID" />
                    <select id="sem_type" class="select-element margin-right mb-1">
                        <option value="">Select SEM</option>
                        <option value="p1__sem1">P1 SEM1</option>
                        <option value="p1__sem2">P1 SEM2</option>
                        <option value="p2__sem1">P2 SEM1</option>
                        <option value="p2__sem2">P2 SEM2</option>
                        <option value="e1__sem1">E1 SEM1</option>
                        <option value="e1__sem2">E1 SEM2</option>
                        <option value="e2__sem1">E2 SEM1</option>
                        <option value="e2__sem2">E2 SEM2</option>
                        <option value="e3__sem1">E3 SEM1</option>
                        <option value="e3__sem2">E3 SEM2</option>
                        <option value="e4__sem1">E4 SEM1</option>
                        <option value="e4__sem2">E4 SEM2</option>
                    </select>
                    <button class="btn-full btn-reset" id="stu-result-get-btn">Get Result</button>
                </div>

                <div class="table-box results-edit-table"></div>
            </div>
        </main>
        <?php require_once('../../footer.php');?>
        <script src="../js/script.js"></script>
        <script src="../js/ajax-calls.js"></script>
    </body>
</html>
