<?php
  use PHPMailer\PHPMailer\PHPMailer; 
  use PHPMailer\PHPMailer\Exception; 
  

  function send_mail($email, $subject, $body){

        $mail = new PHPMailer(true); 

        try { 
          $mail->SMTPDebug = 0;									 
          $mail->isSMTP();											 
          
            
           $mail->Host = 'localhost';
           $mail->SMTPAuth = false;
           $mail->SMTPAutoTLS = false; 
           $mail->Port = 25; 
           $mail->Username = 'studentcell@rguktong.ac.in';				 
           $mail->Password = 'NandI@123';

          $mail->setFrom('studentcell@rguktong.ac.in', 'Student Cell::RGUKT ONGOLE');		 
          $mail->addAddress($email);
          
          $mail->isHTML(true);								 
          $mail->Subject = $subject; 
          $mail->Body = $body; 
          // $mail->AltBody = 'Body in plain text for non-HTML mail clients'; 
          if($mail->send())return 1;
          else{
            return 0;
          }
        }catch (Exception $e) { 
            return 0;
        }   
        
  }

?>