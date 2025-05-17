<?php
session_start();
include("connection.php");

?>

<?php

if(isset($_POST['login'])){
  
  $email=$_POST['email'];
  $pass=$_POST['password'];

  $qry="select * from admin where email='$email' and password='$pass'";

  $res=mysqli_query($con,$qry);

  if(mysqli_num_rows($res)>0){

    while($val=mysqli_fetch_array($res)){
      $aid=$val['id'];
    }

    $_SESSION['admin']=$aid;

    header("Location: Admin/adminindex.php");
    exit();

  }else{
    $_SESSION['alert_info']="notlogin";
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SHOPIFY | Admin Login</title>
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


    <header>

        <div class="left">
            <a href="index.php"><img src="Logo.png" alt="Logo"/></a>
            <div class="login">

            </div>


        </div>


        <div class="right">

            <span>
                <a href="index.php"><h4>Home</h4></a>
                <a href="contact.php"><h4>Contact</h4></a>
                <a href="about.php"><h4>About</h4></a>
            </span>


        </div>

    </header>

    <div id="customAlert">
        <p id="alertMessage"></p>
    </div>

    <main>
      <section class="logup">
        <h1>ADMIN LOGIN</h1>

        <p>** All Fields Are <span>Required</span> **</p>

        <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
          <div class="field">
            <label>Email :</label>
            <div>
              <i class="fa-solid fa-user"></i>
              <input type="text" name="email"  placeholder="Enter Email" required autocomplete="off"/>
            </div>
          </div>

          <div class="field">
            <label>Password :</label>
            <div>
              <i class="fa-solid fa-lock"></i>
              <input type="password" name="password" placeholder="Enter Password" required autocomplete="off"/>
            </div>
          </div>

          <h2><input type="submit" value="LOGIN" name="login" /></h2>

        </form>
        <h3>Forget Password? <a href="#" target="_blank"><button>Reset</button></a></h3>
        <h3 style="text-align:left; margin-left:30px;">Forget Password? <a href="adminreset.php"><button>Reset</button></a></h3>
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

            if (isset($_SESSION['alert_info']) && $_SESSION['alert_info']=="logout") {
                unset($_SESSION['alert_info']);
                echo "showAlert('✅ Logout Successful');";
    
            }

            else if (isset($_SESSION['alert_info']) && $_SESSION['alert_info']=="notlogin") {
                unset($_SESSION['alert_info']);
                echo "showAlert('⚠️ Invalid Login Credentials');";

            }
            
            ?>

            
        };
    </script>

</html>