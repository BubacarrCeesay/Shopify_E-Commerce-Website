<?php
session_start();
include("../connection.php");

?>

<?php

if(isset($_POST['signup'])){

    $fname=$_POST['fname'];
    $lname=$_POST['lname'];
    $email=$_POST['email'];
    $pass=$_POST['password'];
    $contact=$_POST['contact'];
    $address=$_POST['address'];
    $pincode=$_POST['pincode'];
    $gen=$_POST['gender'];
    $ip=getIPAddress();

    $cq="select * from customer where email='$email'";

    $cr=mysqli_query($con,$cq);

    if(mysqli_num_rows($cr)>0){
        $_SESSION['alert_info']="emailerror";
    }else{

        if(isset($_FILES['prof']) && $_FILES['prof']['error'] == 0){

            $prof = uniqid() . basename($_FILES['prof']['name']);

            $qry="INSERT INTO customer(firstname, lastname, email, password, profile, address,pincode, gender, contact, ip_address) VALUES('$fname','$lname','$email','$pass','$prof','$address',$pincode,'$gen','$contact','$ip')";

            $res=mysqli_query($con,$qry);

            if($res){
                move_uploaded_file($_FILES['prof']['tmp_name'], "profileimg/$prof");
                $_SESSION['alert_info']="success";
            }else{
                $_SESSION['alert_info']="notsuccess";
            }

        }else{
            $_SESSION['alert_info']="errorimg";
        }

    }

    header("Location: signup.php");
    exit();

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SHOPIFY | User Sign Up</title>
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
                <a><h4>Contact</h4></a>
                <a><h4>About</h4></a>
            </span>


        </div>

    </header>

    <main>
      <section class="frmup">
        <h1>SIGN UP FORM</h1>
        <p>** All Fields Are <span>Required</span> **</p>
      </section>

      <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
        <section class="frmdown">
          <div class="field">
            <label>First Name :</label>
            <p>
              <i class="fa-solid fa-user"></i>
              <input type="text" name="fname" autocomplete="off" required/>
            </p>
          </div>

          <div class="field">
            <label>Last Name :</label>
            <p>
              <i class="fa-solid fa-image-portrait"></i>
              <input type="text" name="lname" autocomplete="off" required/>
            </p>
          </div>

          <div class="field">
            <label>Email :</label>
            <p>
              <i class="fa-regular fa-envelope"></i>
              <input type="email" name="email" required/>
            </p>
          </div>

          <div class="field">
            <label>Password :</label>
            <p>
              <i class="fa-solid fa-lock"></i>
              <input type="password" name="password" required/>
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
            <label>Gender :</label>
            <p>
              <i class="fa-solid fa-person-half-dress"></i>
              <select name="gender" required>
                <option value="">Select Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
              </select>
            </p>
          </div>

          <div class="field">
            <label>Profile Picture :</label>
            <p>
              <i class="fa-regular fa-file"></i>
              <input type="file" name="prof" required/>
            </p>
          </div>

          <div class="field">
            <label>Address :</label>
            <p>
              <textarea name="address" placeholder="Enter Address" required></textarea>
            </p>
          </div>

          <div class="field">
          </div>

          <div class="field">
            <label>PinCode :</label>
            <p>
              <input type="text" name="pincode" placeholder="Enter Address PinCode" required/>
            </p>
          </div>

        </section>

        <p class="sbtfrm">
          <input type="submit" value="Sign Up" name="signup" />
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
                echo "showAlert('✅ Sign Up Successful');";
    
            }

            else if (isset($_SESSION['alert_info']) && $_SESSION['alert_info']=="notsuccess") {
                unset($_SESSION['alert_info']);
                echo "showAlert('⚠️ Error In Signing Up');";

            }

            else if (isset($_SESSION['alert_info']) && $_SESSION['alert_info']=="errorimg") {
                unset($_SESSION['alert_info']);
                echo "showAlert('⚠️ Error In Uploading Profile Picture');";

            }

            else if (isset($_SESSION['alert_info']) && $_SESSION['alert_info']=="emailerror") {
                unset($_SESSION['alert_info']);
                echo "showAlert('⚠️ Email Account Already Exist');";

            }
            
            ?>

            
        };
    </script>

</html>