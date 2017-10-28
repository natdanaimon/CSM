<?php
include '../common/phpmailer.php';
$mail = new PHPMailer();
$body = "aaaaaaa";

                    
  $mail->CharSet = "utf-8";                         
  $mail->Host = "cpanel06wh.bkk1.cloud.z.com"; // SMTP server
  $mail->Port = 465;                 // set the SMTP port for the GMAIL server
  $mail->Username = "forgotpassword@expwebdesign.com";     // SMTP server username
  $mail->Password = "forgotpassword" ;            // SMTP server password 
  $mail->From = "noreply@horgarage.com";
  $mail->FromName = "HORGARAGE";
  $mail->Subject = "HORGARAGE : FORGOT PASSWORD";
  $mail->MsgHTML($body);
  $mail->AddAddress("natdanaimon@gmail.com");
 
  echo $mail->Send();
?>