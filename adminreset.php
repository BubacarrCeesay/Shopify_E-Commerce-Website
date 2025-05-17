<?php
session_start();
include("connection.php");

?>

<?php

if(isset($_POST['reset'])){

    $email=$_POST['email'];
    $pass=$_POST['newpass'];
    $cpass=$_POST['cnewpass'];
    $contact=$_POST['contact'];

    $cq="select * from admin where email='$email' and contact='$contact'";

    $cr=mysqli_query($con,$cq);

    if(mysqli_num_rows($cr)<=0){
        $_SESSION['alert_info']="emailerror";
    }else{

        if($pass != $cpass){

            $_SESSION['alert_info']="errorpass";

        }else{
                $qry="Update admin set password='$pass'  where email='$email' and contact='$contact'";

                $res=mysqli_query($con,$qry);

                if($res){
                    $_SESSION['alert_info']="success";
                }else{
                    $_SESSION['alert_info']="notsuccess";
                }
        }

    }

    header("Location: adminreset.php");
    exit();

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SHOPIFY | Admin Reset Password </title>
        <link rel="website icon" type="" href="Logo.png" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
      integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    
    <main>

    <div id="customAlert">
        <p id="alertMessage"></p>
    </div>

    <header>

        <div class="left">
            <a href="index.php"><img src="Logo.png" alt="Logo"/></a>
            <div class="login">

            </div>

            
            <i id="navShow" class="fa-solid fa-bars"></i>

        </div>


        <div class="right">

            <span>
                <a href="index.php"><h4>Home</h4></a>
                <a href="contact.php"><h4>Contact</h4></a>
                <a href="about.php"><h4>About</h4></a>
            </span>


        </div>

    </header>

    <main>
      <section class="frmup">
        <h1>ADMIN RESET PASSWORD</h1>
        <p>** All Fields Are <span>Required</span> **</p>
      </section>

      <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
        <section class="frmdown">
          <div class="field">
            <label>Email :</label>
            <p>
              <i class="fa-solid fa-user"></i>
              <input type="email" name="email" required/>
            </p>
          </div>

          <div class="field">
            <label>Contact :</label>
            <p>
              <i class="fa-solid fa-phone"></i>
              <input type="text" name="contact" pattern="\d+" title="Only numbers are allowed" maxlength="10" minlength="10" required/>
            </p>
          </div>

          <div class="field">
            <label>New Password :</label>
            <p>
              <i class="fa-solid fa-lock"></i>
              <input type="password" name="newpass" required/>
            </p>
          </div>

          <div class="field">
            <label>Confirm Password :</label>
            <p>
              <i class="fa-solid fa-lock"></i>
              <input type="password" name="cnewpass" required/>
            </p>
          </div>

        </section>

        <p class="sbtfrm">
          <input type="submit" value="Reset" name="reset" />
        </p>
      </form>
    </main>

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
                echo "showAlert('✅ Password Reset Successful');";
    
            }

            else if (isset($_SESSION['alert_info']) && $_SESSION['alert_info']=="notsuccess") {
                unset($_SESSION['alert_info']);
                echo "showAlert('⚠️ Error In Reseting Password');";

            }

            else if (isset($_SESSION['alert_info']) && $_SESSION['alert_info']=="emailerror") {
                unset($_SESSION['alert_info']);
                echo "showAlert('⚠️ Invalid Admin Credentials');";

            }

            else if (isset($_SESSION['alert_info']) && $_SESSION['alert_info']=="errorpass") {
                unset($_SESSION['alert_info']);
                echo "showAlert('⚠️ Passwords Does Not Match');";

            }
            
            ?>

            
        };
    </script>

</html>