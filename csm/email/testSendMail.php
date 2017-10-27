<?php
include '../common/phpmailer.php';
$mail = new PHPMailer();
$body = "aaaaaaa";

                    
  $mail->CharSet = "utf-8";                         
  $mail->Host = "cpanel03wh.bkk1.cloud.z.com"; // SMTP server
  $mail->Port = 587;                 // set the SMTP port for the GMAIL server
  $mail->Username = "forgotpassword@expwebdesign.com";     // SMTP server username
  $mail->Password = "forgotpassword" ;            // SMTP server password 
  $mail->From = "noreply@expwebdesign.com";
  $mail->FromName = "NAGIEOS";
  $mail->Subject = "NAGIEOS : FORGOT PASSWORD";
  $mail->MsgHTML($body);
  $mail->AddAddress("numkangg12@gmail.com");
 
  echo $mail->Send();
?>