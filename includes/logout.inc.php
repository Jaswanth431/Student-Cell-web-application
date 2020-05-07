<?php
  session_start();
  require_once('../functions/general-func.php');
  session_unset();
  session_destroy();
  if(isset($_GET['user'])){
    $user = $_GET['user'];
    if($user == "admin"){
      redirect_to("../admin/index.php");
    }
  }else{
    redirect_to("../index.php");

  }
?>