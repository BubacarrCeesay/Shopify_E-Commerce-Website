<?php

session_start();

if(isset($_SESSION['user']))
{
    unset($_SESSION['user']);
    $_SESSION['alert_info']="logout";
      header("Location: index.php");
      exit();
}

?>