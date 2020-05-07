<?php
    session_start();
    ob_start();
    require_once('includes/db.php');
    require_once('functions/general-func.php');
    require_once('functions/session-func.php');
    if(if_student_logged())redirect_to("student/home.php");
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <title>Student Cell IIIT ONGOLE</title>
        <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
        <link rel="stylesheet" href="css/style.css" />
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    </head>
    <body class="preload">
        <?php require_once('header.php');?>
        <main class="student-main">
            <div class="login-box">
                <h1>Login</h1>
                <div class="error-box">
                    <p></p>
                </div>
                <div class="response-data"></div>
                <form >
                <div class="input-group">
                        <label for="#student_id">ID Number:</label>
                        <span class="input-icon">
                            <i class="fa fa-id-card" aria-hidden="true"></i>
                        </span>
                        <input type="text" id="student_id" placeholder="Enter your id.." required />
                    </div>
                    <div class="input-group">
                        <label for="#student_pass">Password:</label>
                        <span class="input-icon">
                            <i class="fa fa-key" aria-hidden="true"></i>
                        </span>
                        <input type="password" autocomplete="on" id="student_pass" placeholder="Enter your password" required/>
                    </div>
                    <div class="input-group">
                        <button  type="button" class="login-btn" id="student-login-btn">Login</button>
                    </div>
                    <div class="input-group">
                        <a class="forget-password-link" id="forget-password-btn" href="#">Forget your Password?</a>
                    </div>
                </form>
                    

            </div>
            <div class="news-box">
                <h1>News && Updates</h1>
                <div class="news-box-content">
                <?php
                    $query = "SELECT * FROM news_updates ORDER BY date DESC LIMIT 20";
                    $result = mysqli_query($conn, $query);
                    if(mysqli_num_rows($result) > 0){
                        $month = [1=>"Jan", 2=>"Feb", 3=>"Mar", 4=>"Apr", 5=>"May", 6=>"June", 7=>"July", 8=>"Aug", 9=>"Sep", 10=>"Oct", 11=>"Nov", 12=>"Dec"];
                        while($row = mysqli_fetch_assoc($result)){
                            $date = $row['date'];
                            $date_arr = explode("-", $date);
                            $text = $row['news_text'];
                            $link = ($row['file_name'] == ""?"#":"notify_files/" . $row['file_name']);
                            echo "<div class='news-box-group'><p class='date'><span class='date-mem'>".$date_arr[2]."</span><span class='date-mem'>".$month[(int)$date_arr[1]]."</span><span class='date-mem'>".$date_arr[0]."</span></p><a  href='".$link."' target='_blank' class='news-data'
                                >".$text."</a></div>";
                        }
                    }
                ?>
                
                    
                </div>
            </div>
        </main>
        <?php require_once('footer.php');?>

        <div class="forget-password-box">
            <div class="login-box data-box">
                    <div class="btn-close" id="close-password-box">
                        <i class="fa fa-times" aria-hidden="true"></i>
                    </div>
                    <h1 class="f-pass-heading">Reset Password</h1>
                    <div class="f-pass-error-box">
                        <p></p>
                    </div>
                    <div class="f-pass-response-data"></div>
                        <form>
                            <div class="input-group id-box">
                                <label for="forget-id">ID Number:</label>
                                <span class="input-icon">
                                    <i class="fa fa-id-card" aria-hidden="true"></i>
                                </span>
                                <input type="text" id="forget-id" placeholder="Enter your id.." required />
                            </div>

                            <div class="input-group otp-box">
                                <label for="otp">Enter OTP</label>
                                <span class="input-icon">
                                    <i class="fa fa-lock" aria-hidden="true"></i>
                                </span>
                                <input type="text" id="otp" placeholder="Enter OTP sent to mail.." required />
                            </div>

                            <div class="input-group pass-box">
                                <label for="new_pass">New Password:</label>
                                <span class="input-icon">
                                    <i class="fa fa-key" aria-hidden="true"></i>
                                </span>
                                <input type="password" autocomplete="on" id="new_pass" placeholder="Enter new password" required/>
                            </div>

                            <div class="input-group get-otp-box">
                                <button type="button" class="login-btn btn-cneter" id="get-otp-btn">Get OTP</button>
                            </div>
                            <div class="input-group pass-change-box">
                                <button type="button" class="login-btn btn-cneter" id="password-change-btn">Update Password</button>
                            </div>

                        </form>
                    
                </div>
        </div>
    </body>
    <script type="text/javascript" src="js/home.js"></script>
    <script type="text/javascript" src="js/login.js"></script>
</html>
