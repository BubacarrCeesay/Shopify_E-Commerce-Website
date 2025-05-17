
<?php
session_start();
include("header.php");
include("../connection.php");

if(!isset($_SESSION['admin'])){
    header("Location: ../adminlogin.php");
    exit();     
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SHOPIFY | Admin - Messages </title>
        <link rel="website icon" type="" href="../Logo.png" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
      integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <link rel="stylesheet" href="admstyle.css" />
</head>
<body>

    <div id="customAlert">
        <p id="alertMessage"></p>
        <button onclick="closeAlert()">OK</button>
    </div>


    </section>



</body>

  <script>

        
          function showAlert(message) {
            var alertBox = document.getElementById("customAlert");
            var alertMessage = document.getElementById("alertMessage");

            alertMessage.textContent = message;
            alertBox.style.display = "block";

            setTimeout(closeAlert,3000);

          }

          function closeAlert() {
            var alertBox = document.getElementById("customAlert");
            alertBox.style.display = "none";
            
          
            window.location.href="insertproduct.php";
          }


            window.onload = function() {

            <?php

            if (isset($_SESSION['alert_info']) && $_SESSION['alert_info']=="added") {
                unset($_SESSION['alert_info']);
                echo "showAlert('✅ Product Inserted Successfully!');";
            }

            else if (isset($_SESSION['alert_info']) && $_SESSION['alert_info']=="notadded") {
                echo "showAlert('⚠️ Error In Inserting Product!');";
                unset($_SESSION['alert_info']);

            }

            else if (isset($_SESSION['alert_info']) && $_SESSION['alert_info']=="imgerror") {
                echo "showAlert('⚠️ Error In Uploading Product Images!');";
                unset($_SESSION['alert_info']);

            }
            
            ?>

            
        };
    </script>

    <script src="admjsfile.js"></script>
</html>