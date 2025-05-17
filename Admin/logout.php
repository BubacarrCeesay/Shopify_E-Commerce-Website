<?php

session_start();

if(isset($_SESSION['admin']))
{
    unset($_SESSION['admin']);
    $_SESSION['alert_info']="logout";
      header("Location: ../adminlogin.php");
      exit();
}

?>