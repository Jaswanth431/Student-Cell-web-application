<?php
  $student = student_data($_SESSION['user']);
  $short_name = get_short_name($student['stu_name']);
  if($student['profile_img'] == ""){
    $img = $student['gender'] == 'M'?"male-temp.png":"female-temp.png";
  }else{
    $img = $student['profile_img'];
  }
  $path = "profile_photos/".$img;
?>
<header>
            <div class="header-left-box">
                <div class="logo-box">
                    <img src="../img/rgukt.png" alt="logo" />
                </div>
                <h1>RGUKT-ONGOLE STUDENT CELL</h1>
            </div>
            <div class="header-right-box .clearfix">
              <div class="user-box logo-box">
                      <img src="<?php echo $path?>" alt="jaswanth" />
              </div>
              <h1><?php echo $short_name;?></h1>
              <div class="toggle-icon">
                  <i class="fa fa-bars" aria-hidden="true"></i>
              </div>
            </div>
</header>