<?php

session_start();

include("../connection.php");
include("header.php");

$user=$_SESSION['user'];

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SHOPIFY | Messages </title>
        <link rel="website icon" type="" href="Logo.png" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
      integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <link rel="stylesheet" href="userstyle.css" />
</head>
<body>
    
    <main>

        <div id="customAlert">
            <p id="alertMessage"></p>
        </div>


    </main>

</body>

  <script>

          function showAlert(message) {
            var alertBox = document.getElementById("customAlert");
            var alertMessage = document.getElementById("alertMessage");

            alertMessage.textContent = message;
            alertBox.style.display = "block";

            setTimeout(closeAlert,2500);

          }

          function closeAlert() {
            var alertBox = document.getElementById("customAlert");
            alertBox.style.display = "none";
            
          }


            window.onload = function() { 

            <?php

            if (isset($_SESSION['alert_info']) && $_SESSION['alert_info']=="deleted") {
                unset($_SESSION['alert_info']);
                echo "showAlert('✅ Product Unsaved');";

            }

            else if (isset($_SESSION['alert_info']) && $_SESSION['alert_info']=="notdeleted") {
                unset($_SESSION['alert_info']);
                echo "showAlert('⚠️ Error In Unsaving Product');";

            }
            
            ?>

            
        };
    </script>

    <script src="../Admin/admjsfile.js"></script>

</html>