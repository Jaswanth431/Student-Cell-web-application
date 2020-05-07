<?php
    function set_admin_session($user, $user_type, $user_id){
      $_SESSION['user'] = $user;
      $_SESSION['user_type'] = $user_type;
      $_SESSION['user_id'] = $user_id;
    }


    function set_student_session($user, $user_type){
      $_SESSION['user'] = $user;
      $_SESSION['user_type'] = $user_type;
    }
    function if_logged(){
      if(!(isset($_SESSION['user'])) || empty($_SESSION['user']) || !(isset($_SESSION['user_type']))|| empty($_SESSION['user_type'])){
        return 0;
      }else{
        return 1;
      }
    }
     
    function if_student_logged(){
      if(if_logged() && $_SESSION['user_type'] == 'student'){
        return 1;
      }else{
        return 0;
      }
    }

    function if_examcell_logged(){
      if(if_logged() && $_SESSION['user_type'] == 'exam_cell'){
        return 1;
      }else{
        return 0;
      }
    }

    function if_studentwelfare_logged(){
      if(if_logged() && $_SESSION['user_type'] == 'student_welfare'){
        return 1;
      }else{
        return 0;
      }
    }

    function if_deanacademics_logged(){
      if(if_logged() && $_SESSION['user_type'] == 'dean_academics'){
        return 1;
      }else{
        return 0;
      }
    }

    function if_itinfra_logged(){
      if(if_logged() && $_SESSION['user_type'] == 'it_infra'){
        return 1;
      }else{
        return 0;
      }
    }

    function if_security_logged(){
      if(if_logged() && $_SESSION['user_type'] == 'security'){
        return 1;
      }else{
        return 0;
      }
    }


    function if_warden_logged(){
      if(if_logged() && $_SESSION['user_type'] == 'warden'){
        return 1;
      }else{
        return 0;
      }
    }


?>