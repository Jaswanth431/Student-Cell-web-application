   <ul class="navigation-list">
   <?php
   if(if_examcell_logged()){
      
   ?>

   <li class="navigation-items"><a href="home.php" class="navigation-links active"><i class="fa fa-home" aria-hidden="true"></i> Home</a></li>
      <li class="navigation-items"><a href="results_upload.php" class="navigation-links"><i class="fa fa-upload" aria-hidden="true"></i>
      Resluts Upload</a></li>
      <li class="navigation-items"><a href="edit-results.php" class="navigation-links"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>
   Edit Result</a></li>
   <li class="navigation-items"><a href="add-news.php" class="navigation-links"><i class="fa fa-plus" aria-hidden="true"></i>
   Notifications</a></li>
   <li class="navigation-items"><a href="get-complaints.php" class="navigation-links"><i class="fa fa-send-o" aria-hidden="true"></i>
   Complaints</a></li>
      <li class="navigation-items"><a href="reset-password.php" class="navigation-links"><i class="fa fa-wrench" aria-hidden="true"></i>

   Reset Password</a></li>
   <li class="navigation-items"><a href="../../includes/logout.inc.php?user=admin" class="navigation-links"><i class="fa fa-sign-out" aria-hidden="true"></i>
   Logout</a></li>

  <?php }else if(if_studentwelfare_logged()){ ?>

   <li class="navigation-items"><a href="#" class="navigation-links active"><i class="fa fa-home" aria-hidden="true"></i> Home</a></li>
      <li class="navigation-items"><a href="get-student-profile.php" class="navigation-links"><i class="fa fa-user" aria-hidden="true"></i>
   Student profile</a></li>
   <li class="navigation-items"><a href="get-outpass-by-date.php" class="navigation-links"><i class="fa fa-calendar-check-o" aria-hidden="true"></i>
   Recent outpasses</a></li>
   <li class="navigation-items"><a href="add-news.php" class="navigation-links"><i class="fa fa-plus" aria-hidden="true"></i>
   Notifications</a></li>
      <li class="navigation-items"><a href="add-users.php" class="navigation-links"> <i class="fa fa-forward" aria-hidden="true"></i> Add users</a></li>

   <li class="navigation-items"><a href="reset-password.php" class="navigation-links"><i class="fa fa-wrench" aria-hidden="true"></i>
   Reset Password</a></li>

   <li class="navigation-items"><a href="../../includes/logout.inc.php?user=admin" class="navigation-links"><i class="fa fa-sign-out" aria-hidden="true"></i>
   Logout</a></li>

   <?php }else if(if_deanacademics_logged()){ ?>

      <li class="navigation-items"><a href="home.php" class="navigation-links active"><i class="fa fa-home" aria-hidden="true"></i> Home</a></li>
      <li class="navigation-items"><a href="upload-sem-data.php" class="navigation-links"><i class="fa fa-upload aria-hidden="true"></i>
   Upload Sem data</a></li>
   <li class="navigation-items"><a href="get-student-profile.php" class="navigation-links"><i class="fa fa-user" aria-hidden="true"></i>
   Student profile</a></li>
   <li class="navigation-items"><a href="add-news.php" class="navigation-links"><i class="fa fa-plus" aria-hidden="true"></i>
   Notifications</a></li>
   <li class="navigation-items"><a href="#" class="navigation-links"><i class="fa fa-send-o" aria-hidden="true"></i>
   Complaints</a></li>
   <li class="navigation-items"><a href="reset-password.php" class="navigation-links"><i class="fa fa-wrench" aria-hidden="true"></i>
   Reset Password</a></li>

   <li class="navigation-items"><a href="../../includes/logout.inc.php?user=admin" class="navigation-links"><i class="fa fa-sign-out" aria-hidden="true"></i>
   Logout</a></li>

   <?php }else if(if_itinfra_logged()){ ?>  

      <li class="navigation-items"><a href="home.php" class="navigation-links active"><i class="fa fa-home" aria-hidden="true"></i> Home</a></li>
      <li class="navigation-items"><a href="add-users.php" class="navigation-links">
      <i class="fa fa-user" aria-hidden="true"></i> Add Users</a></li>
      <li class="navigation-items"><a href="get-student-profile.php" class="navigation-links"><i class="fa fa-user" aria-hidden="true"></i>
   Student profile</a></li>
      <li class="navigation-items"><a href="change-password.php" class="navigation-links">
      <i class="fa fa-wrench" aria-hidden="true"></i> Change Password</a></li>

      <li class="navigation-items"><a href="faculty-survey.php" class="navigation-links">
      <i class="fa fa-list-alt" aria-hidden="true"></i> Survey Results</a></li>
      <li class="navigation-items"><a href="reset-password.php" class="navigation-links">
      <i class="fa fa-key" aria-hidden="true"></i> Reset Password</a></li>
      <li class="navigation-items"><a href="add-news.php" class="navigation-links"><i class="fa fa-plus" aria-hidden="true"></i>
   Notifications</a></li>

   <li class="navigation-items"><a href="../../includes/logout.inc.php?user=admin" class="navigation-links"><i class="fa fa-sign-out" aria-hidden="true"></i>
   Logout</a></li>

   <?php }else if(if_warden_logged()){ ?>  

      <li class="navigation-items"><a href="home.php" class="navigation-links active"><i class="fa fa-home" aria-hidden="true"></i> Home</a></li>
      <li class="navigation-items"><a href="student-statistics.php" class="navigation-links "><i class="fa fa-bar-chart" aria-hidden="true"></i> Statistics</a></li>
      <li class="navigation-items"><a href="outpass-history.php" class="navigation-links "><i class="fa fa-history" aria-hidden="true"></i> Outpass History</a></li>

      <li class="navigation-items"><a href="reset-password.php" class="navigation-links">
      <i class="fa fa-key" aria-hidden="true"></i> Reset Password</a></li>
      <li class="navigation-items"><a href="../../includes/logout.inc.php?user=admin" class="navigation-links"><i class="fa fa-sign-out" aria-hidden="true"></i>
      Logout</a></li>


      <?php }else if(if_security_logged()){ ?>  

      <li class="navigation-items"><a href="home.php" class="navigation-links active"><i class="fa fa-home" aria-hidden="true"></i> Home</a></li>
      <li class="navigation-items"><a href="approve-in.php" class="navigation-links"><i class="fa fa-check" aria-hidden="true"></i> Approve in</a></li>
      <li class="navigation-items"><a href="reset-password.php" class="navigation-links">
      <i class="fa fa-key" aria-hidden="true"></i> Reset Password</a></li>
      <li class="navigation-items"><a href="../../includes/logout.inc.php?user=admin" class="navigation-links"><i class="fa fa-sign-out" aria-hidden="true"></i>
      
      Logout</a></li>


   <?php } ?>
  
  </ul>