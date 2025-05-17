<?php

session_start();

include("../connection.php");
include("header.php");

$user=$_SESSION['user'];

?>

<?php

if(isset($_POST['update'])){

    $old=$_POST['oldpass'];
    $new=$_POST['newpass'];
    $cnf=$_POST['cnewpass'];

    $qr="select * from customer where customer_id=$user";
    $rs=mysqli_query($con,$qr);

    while($val=mysqli_fetch_array($rs)){
        $pass=$val['password'];
    }

    if($old == $pass){

        if($new == $cnf){
            $upq="Update Customer set password='$new' where customer_id=$user";

            $upr=mysqli_query($con,$upq);

            if($upr){
                $_SESSION['alert_info']="success";
            }
            else{
                $_SESSION['alert_info']="notsuccess";
            }
        }else{
            $_SESSION['alert_info']="passnotequal";
        }
        
    }else{
        $_SESSION['alert_info']="notequal";
    }

    header("Location: resetpassword.php");
    exit();    

}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SHOPIFY | Reset Password</title>
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

        <section class="contents">

            <section class="editprof">

                <h3>Reset Password</h3>

                <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
                    <section class="frmdown">
                    <div class="field">
                        <label>Old Password :</label>
                        <p>
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" name="oldpass" autocomplete="off" required/>
                        </p>
                    </div>

                    <div class="field">
                        <label>New Password :</label>
                        <p>
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" name="newpass" autocomplete="off" required/>
                        </p>
                    </div>

                    <div class="field">
                        <label>Confirm New Password :</label>
                        <p>
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" name="cnewpass" autocomplete="off" required/>
                        </p>
                    </div>

                    </section>

                    <p class="sbtfrm">
                    <input type="submit" value="Reset" name="update" />
                    </p>
                </form>
            </section>

        </section>

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

            if (isset($_SESSION['alert_info']) && $_SESSION['alert_info']=="success") {
                unset($_SESSION['alert_info']);
                echo "showAlert('✅ Password Reset Successfully');";
    
            }

            else if (isset($_SESSION['alert_info']) && $_SESSION['alert_info']=="notsuccess") {
                unset($_SESSION['alert_info']);
                echo "showAlert('⚠️ Error In Resetting Password');";

            }

            else if (isset($_SESSION['alert_info']) && $_SESSION['alert_info']=="notequal") {
                unset($_SESSION['alert_info']);
                echo "showAlert('⚠️ Incorrect Old Password');";

            }

            else if (isset($_SESSION['alert_info']) && $_SESSION['alert_info']=="passnotequal") {
                unset($_SESSION['alert_info']);
                echo "showAlert('⚠️ Password Does not March');";

            }
            
            ?>

            
        };
    </script>

<script src="../Admin/admjsfile.js"></script>
</html>