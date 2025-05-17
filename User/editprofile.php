<?php

session_start();

include("../connection.php");
include("header.php");

$user=$_SESSION['user'];

$qry="select * from customer where customer_id=$user";
$res=mysqli_query($con,$qry);

while($val=mysqli_fetch_array($res)){
    $fname=$val['firstname'];
    $lname=$val['lastname'];
    $contact=$val['contact'];
    $address=$val['address'];
    $pincode=$val['pincode'];
}

?>

<?php

if(isset($_POST['update'])){

    $fn=$_POST['fname'];
    $ln=$_POST['lname'];
    $cnt=$_POST['contact'];
    $add=$_POST['address'];
    $pnc=$_POST['pincode'];

    if(isset($_FILES['prof']) && $_FILES['prof']['error'] == 0){

         $prf = uniqid() . basename($_FILES['prof']['name']);

         $upq="Update Customer set firstname='$fn', lastname='$ln', contact='$cnt', address='$add', pincode='$pnc', profile='$prf' where customer_id=$user";

        $upr=mysqli_query($con,$upq);

        if($upr){
            move_uploaded_file($_FILES['prof']['tmp_name'], "profileimg/$prf");

            $_SESSION['alert_info']="success";
        }
        else{
             $_SESSION['alert_info']="notsuccess";
        }

    }else{

         $upq="Update Customer set firstname='$fn', lastname='$ln', contact='$cnt', address='$add', pincode='$pnc' where customer_id=$user";

         $upr=mysqli_query($con,$upq);

        if($upr){

            $_SESSION['alert_info']="success";
        }
        else{
             $_SESSION['alert_info']="notsuccess";
        }


    }

    header("Location: editprofile.php");
    exit();    

}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SHOPIFY | Edit Profile</title>
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

                <h3>Edit Profile</h3>

                <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
                    <section class="frmdown">
                    <div class="field">
                        <label>First Name :</label>
                        <p>
                        <i class="fa-solid fa-user"></i>
                        <input type="text" name="fname" value="<?php echo $fname;?>" autocomplete="off"/>
                        </p>
                    </div>

                    <div class="field">
                        <label>Last Name :</label>
                        <p>
                        <i class="fa-solid fa-image-portrait"></i>
                        <input type="text" name="lname" value="<?php echo $lname;?>" autocomplete="off"/>
                        </p>
                    </div>

                    <div class="field">
                        <label>Contact :</label>
                        <p>
                        <i class="fa-solid fa-phone"></i>
                        <input type="text" name="contact" pattern="\d+" title="Only numbers are allowed" maxlength="10" minlength="10" value="<?php echo $contact;?>"/>
                        </p>
                    </div>

                    <div class="field">
                        <label>Profile Picture :</label>
                        <p>
                        <i class="fa-regular fa-file"></i>
                        <input type="file" name="prof"/>
                        </p>
                    </div>

                    <div class="field">
                        <label>Address :</label>
                        <p>
                        <textarea name="address" required><?php echo $address;?></textarea>
                        </p>
                    </div>

                    <div class="field">
                        <label>PinCode :</label>
                        <p>
                        <input type="text" name="pincode" value="<?php echo $pincode;?>"/>
                        </p>
                    </div>

                    </section>

                    <p class="sbtfrm">
                    <input type="submit" value="Update" name="update" />
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
                echo "showAlert('✅ Profile Updated Successfully');";
    
            }

            else if (isset($_SESSION['alert_info']) && $_SESSION['alert_info']=="notsuccess") {
                unset($_SESSION['alert_info']);
                echo "showAlert('⚠️ Error In Updating Profile');";

            }

            else if (isset($_SESSION['alert_info']) && $_SESSION['alert_info']=="errorimg") {
                unset($_SESSION['alert_info']);
                echo "showAlert('⚠️ Error In Uploading Profile Picture');";

            }
            
            ?>

            
        };
    </script>

<script src="../Admin/admjsfile.js"></script>
</html>