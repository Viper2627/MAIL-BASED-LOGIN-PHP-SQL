<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';
 
require_once "config.php";
 
// Define variables and initialize with empty values

if(isset($_POST['submit']))
{
    $user_id = $_POST['user_id'];
    $result = mysqli_query($link,"SELECT * FROM users where mail='" . $_POST['user_id'] . "'");
    $row = mysqli_fetch_assoc($result);
	
	$email_id=$row['mail'];
	$password=$row['password'];
	if($user_id==$email_id) {
        echo 'right';
        $token = md5($email_id).rand(10,9999);

        $expFormat = mktime(
        date("H"), date("i"), date("s"), date("m") ,date("d")+1, date("Y")
        );
   
       $expDate = date("Y-m-d H:i:s",$expFormat);
   
       $update = mysqli_query($link,"UPDATE users set  password='" . $password . "', reset_link_token='" . $token . "' ,exp_date='" . $expDate . "' WHERE mail='" . $email_id . "'");
   
       $links = "<a href='localhost/login/reset-passwords.php?key=".$email_id."&token=".$token."'>Click To Reset password</a>";
				$mail = new PHPMailer(true);
                $mail->SMTPSecure = 'ssl';
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username='rameshviperrko007@gmail.com';
                $mail->Password="typstrooebbxfjur";
                $mail->Port = 465;
                $mail->setFrom('rameshviperrko007@gmail.com');
                $mail->addAddress($email_id);
                $mail->isHTML(true);
                $mail->Subject = "HI";
                $mail->Body = $links;
                $mail->send();

                echo
                "<script>alert('sent')</scrtip>";

			}
				else{
					echo 'invalid userid';
				}
}
?>
<!DOCTYPE HTML>
<html>
<head>
<style type="text/css">
 input{
 border:1px solid olive;
 border-radius:5px;
 }
 h1{
  color:darkgreen;
  font-size:22px;
  text-align:center;
 }

</style>
</head>
<body>
<h1>Forgot Password<h1>
<form action='' method='post'>
<table cellspacing='5' align='center'>
<tr><td>user id:</td><td><input type='text' name='user_id'/></td></tr>
<tr><td></td><td><input type='submit' name='submit' value='Submit'/></td></tr>
</table>
</form>
</body>
</html>