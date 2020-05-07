<?php
  $admin = admin_data($_SESSION['user']); 
  $name = $admin['admin_name'];
  $path = "../img/male-temp.png";
?>
<header>
            <div class="header-left-box">
                <div class="logo-box">
                    <img src="../../img/rgukt.png" alt="logo" />
                </div>
                <h1>RGUKT-ONGOLE STUDENT CELL</h1>
            </div>
            <div class="header-right-box .clearfix">
              <div class="user-box logo-box">
                      <img src="<?php echo $path?>" alt="jaswanth" />
                  </div>
                <h1><?php echo $name;?></h1>
                <div class="toggle-icon">
                    <i class="fa fa-bars" aria-hidden="true"></i>
                 </div>
            </div>
</header>