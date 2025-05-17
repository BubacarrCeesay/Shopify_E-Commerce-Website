<?php
session_start();
include("../connection.php");

?>

<?php

if(isset($_POST['login'])){
  $email=$_POST['email'];
  $pass=$_POST['password'];

  $qry="select * from customer where email='$email' and password='$pass'";

  $res=mysqli_query($con,$qry);

  if(mysqli_num_rows($res)>0){

    while($val=mysqli_fetch_array($res)){
      $cid=$val['customer_id'];
    }

    $_SESSION['user']=$cid;

    updateCart();
 

  }else{
    $_SESSION['alert_info']="notlogin";
    header("Location: login.php");
    exit();
  }
}

function updateCart(){
  global $cid;
  $ip=getIPAddress();
  global $con;

  $cq="select * from cart where user='$ip'";

  $cr=mysqli_query($con,$cq);

  if(mysqli_num_rows($cr)>0){

    $uq="update cart set user='$cid' where user='$ip'";

    $rq=mysqli_query($con,$uq);

    if($rq){

      $_SESSION['alert_info']="login";
      header("Location: ../index.php");
      exit();
    }

  }else{
      $_SESSION['alert_info']="login";
      header("Location: ../index.php");
      exit();
  }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SHOPIFY | User Login</title>
        <link rel="website icon" type="" href="Logo.png" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
      integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <link rel="stylesheet" href="../style.css" />
</head>
<body>


    <main>

    <div id="customAlert">
        <p id="alertMessage"></p>
    </div>

    <header>

        <div class="left">
            <a href="../index.php"><img src="Logo.png" alt="Logo"/></a>
            <div class="login">

            </div>


        </div>


        <div class="right">

            <span>
                <a href="../index.php"><h4>Home</h4></a>
                <a href="../contact.php"><h4>Contact</h4></a>
                <a href="../about.php"><h4>About</h4></a>
            </span>


        </div>

    </header>
    
      <section class="logup">
        <h1>USER LOGIN</h1>

        <p>** All Fields Are <span>Required</span> **</p>

        <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
          <div class="field">
            <label>Email :</label>
            <div>
              <i class="fa-solid fa-user"></i>
              <input type="text" name="email"  placeholder="Enter Email" required />
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
        <h3>New to Shopify? <a href="signup.php"><button>Sign Up</button></a></h3>
        <h3 style="text-align:left; margin-left:30px;">Forget Password? <a href="../resetpass.php"><button>Reset</button></a></h3>
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
                echo "showAlert('✅ Sign Up Successful');";
    
            }

            else if (isset($_SESSION['alert_info']) && $_SESSION['alert_info']=="notlogin") {
                unset($_SESSION['alert_info']);
                echo "showAlert('⚠️ Invalid Login Credentials');";

            }
            
            ?>

            
        };
    </script>

</html>