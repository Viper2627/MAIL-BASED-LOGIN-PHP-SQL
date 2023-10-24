<?php
if(isset($_POST['password']) && $_POST['reset_link_token'] && $_POST['email'])
{
  include "config.php";
  
  $emailId = $_POST['email'];

  $token = $_POST['reset_link_token'];
  
  $password = $_POST['password'];
  $param_password = password_hash($password, PASSWORD_DEFAULT);

  $query = mysqli_query($link,"SELECT * FROM `users` WHERE `reset_link_token`='".$token."' and `mail`='".$emailId."'");

   $row = mysqli_num_rows($query);

   if($row){

       mysqli_query($link,"UPDATE users set  password='" . $param_password . "', reset_link_token='" . NULL . "' ,exp_date='" . NULL . "' WHERE mail='" . $emailId . "'");

       echo '<p>Congratulations! Your password has been updated successfully.</p>';
   }else{
      echo "<p>Something goes wrong. Please try again</p>";
   }
}
?>