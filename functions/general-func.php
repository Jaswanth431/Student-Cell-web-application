<?php
    //to escapce the special characters in the given input
    function escape_char($str){
       global $conn;
       return mysqli_real_escape_string($conn, $str);
    }

    // Function to get the client IP address
    function get_client_ip() {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

    //to get current the date and time 
    function get_date($time){
        date_default_timezone_set("Asia/Calcutta");
          if($time){
              return date("Y-m-d h:i:s");
          }else{
              return date("Y-m-d");
          }
    }

    function add_days($initail_date,$days, $months, $years ){

        // $date = get_date(0);
        $date = date_create($initail_date);
        $interval = $days." days,".$months." months,". $years." years";
        date_add($date, date_interval_create_from_date_string($interval)); 
        $date = date_format($date, "Y-m-d"); 
        return $date;
    }
    //redirect to specific url
    function redirect_to($path){
        header("Location: ".$path);
        exit();
    }

    //get short name of the student
    function get_short_name($name){
        $arr = explode(" ",$name);
        if(isset($arr[0][0]) && isset($arr[1])){
        return $arr[0][0].".".$arr[1];

        }else{
            return $name;
        }
      }
      
      //ends with function
    function endswith($string, $endString){ 
            $len = strlen($endString); 
            if ($len == 0) { 
                return true; 
            } 
            return (substr($string, -$len) === $endString); 
    } 


    //get time diff in min
    function minutes_diff($date1, $date2){
        $date1 = strtotime($date1);
        $date2 = strtotime($date2);

        return ($date1-$date2)/60;
    }

    function days_diff($date1, $date2){
        $date1 = strtotime($date1);
        $date2 = strtotime($date2);

        return ($date1-$date2)/(60 * 60 * 24);
    }
    //to escape 
    function replace_empty($val){
        return $val == ""? "-":$val;
    }


    //to get only date form date_time
    function get_date_from_datetime($date){
        $date_data = explode(" ", $date);
        return $date_data[0];
    }
    
?>