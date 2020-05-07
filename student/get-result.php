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
        <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" /> -->
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
                <div class="results-box">
                            <h1 class="heading-primary heading-underline"><i class="fa fa-hand-o-right" aria-hidden="true"></i>
                            Academic Results</h1>
                        <div class="results-display-box">
                            <select  id="sem_type" class="select-element">
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
                            <select id="result_type"  class="select-element">
                                    <option value="">Select Exam</option>
                                    <option value="mid">MID Marks</option>
                                    <option value="wat">WAT Marks</option>
                                    <option value="sem">SEM Grades</option>
                                    <option value="compact_view">Compact veiw</option>
                            </select>
                            <button class="btn-full get-result-btn" id="get-result-btn">Get Result</button> 
                        </div>
                        <div class="error-box">
                            <p></p>
                        </div>
                        
                        <div class="results-table">
                    
                        
                        </div>
                        
                            
                </div>
            </div>
            
        </main>
        <?php require_once('../footer.php');?>
    <script src="js/script.js"></script>
    <script src="js/ajax_calls.js"></script>

    </body>
</html>
