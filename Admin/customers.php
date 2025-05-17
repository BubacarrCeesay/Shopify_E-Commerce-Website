
<?php
session_start();
include("header.php");
include("../connection.php");

if(!isset($_SESSION['admin'])){
    header("Location: ../adminlogin.php");
    exit();     
}

?>


<?php

$output="";

$qry="Select * from customer order by customer_id";

$res=mysqli_query($con,$qry);

if(mysqli_num_rows($res)>0){

    while($val=mysqli_fetch_array($res)){
        $cid=$val['customer_id'];
        $fn=$val['firstname'];
        $ln=$val['lastname'];
        $email=$val['email'];
        $prof=$val['profile'];
        $gender=$val['gender'];
        $address=$val['address'];
        $cont=$val['contact'];
        $pincode=$val['pincode'];

        $full=$fn." ".$ln;

        $output.="
                            <tr id='trup'>
                                <td><img src='../User/profileimg/$prof' alt='productimg'/></td>
                                <td>$cid</td>
                                <td>$full</td>
                                <td>$email</td>
                                <td>$cont</td>
                                <td>$gender</td>
                                <td>$address</td>
                                <td>$pincode</td>
                                <td><a href='#' id='delete'><i class='fa-solid fa-trash'></i></a></td>
                            </tr>
   
        ";
    }
}else{
    $output.="
                            <tr>
                                <td colspan='9'><p style='text-align:center;'>No Customers Found</p></td>
                            </tr>      
    ";
}

?>

<?php

if(isset($_GET['cust'])){

    $cust=$_GET['cust'];

    $output="";

    $qry="Select * from customer where customer_id=$cust";

    $res=mysqli_query($con,$qry);

    if(mysqli_num_rows($res)>0){

        while($val=mysqli_fetch_array($res)){
            $cid=$val['customer_id'];
            $fn=$val['firstname'];
            $ln=$val['lastname'];
            $email=$val['email'];
            $prof=$val['profile'];
            $gender=$val['gender'];
            $address=$val['address'];
            $cont=$val['contact'];
            $pincode=$val['pincode'];

            $full=$fn." ".$ln;

            $output.="
                                <tr id='trup'>
                                    <td><img src='../User/profileimg/$prof' alt='productimg'/></td>
                                    <td>$cid</td>
                                    <td>$full</td>
                                    <td>$email</td>
                                    <td>$cont</td>
                                    <td>$gender</td>
                                    <td>$address</td>
                                    <td>$pincode</td>
                                    <td><a href='#' id='delete'><i class='fa-solid fa-trash'></i></a></td>
                                </tr>
    
            ";
        }
    }else{
        $output.="
                                <tr>
                                    <td colspan='9'><p style='text-align:center;'>No Customers Found</p></td>
                                </tr>      
        ";
    }

}


if(isset($_POST['search'])){

    $text=$_POST['input'];

    $text=trim($text);

    $output="";

    $qry="Select * from customer where customer_id='$text' OR firstname LIKE '%$text%' OR lastname LIKE '%$text%' OR email LIKE '%$text%'";

    $res=mysqli_query($con,$qry);

    if(mysqli_num_rows($res)>0){

        while($val=mysqli_fetch_array($res)){
            $cid=$val['customer_id'];
            $fn=$val['firstname'];
            $ln=$val['lastname'];
            $email=$val['email'];
            $prof=$val['profile'];
            $gender=$val['gender'];
            $address=$val['address'];
            $cont=$val['contact'];
            $pincode=$val['pincode'];

            $full=$fn." ".$ln;

            $output.="
                                <tr id='trup'>
                                    <td><img src='../User/profileimg/$prof' alt='productimg'/></td>
                                    <td>$cid</td>
                                    <td>$full</td>
                                    <td>$email</td>
                                    <td>$cont</td>
                                    <td>$gender</td>
                                    <td>$address</td>
                                    <td>$pincode</td>
                                    <td><a href='#' id='delete'><i class='fa-solid fa-trash'></i></a></td>
                                </tr>
    
            ";
        }
    }else{
        $output.="
                                <tr>
                                    <td colspan='9'><p style='text-align:center;'>No Searched Customer Found</p></td>
                                </tr>      
        ";
    }

}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SHOPIFY | Admin - Customers</title>
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
    </div>

    <section class="contents">
        
        <section class="viewprd">

            <h3>CUSTOMERS</h3>

                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">

                    <div class="field">
                        <input type="text" name="input" placeholder="Search by Customer ID, Name or Email" autocomplete="off" />
                    </div>

                    <div class="field">
                        <input id="sbtbtn" type="submit" name="search" value="Search Customer">
                    </div>

                </form>

            <div class="tablesec">
                <table border="1">
                    <thead>
                        <tr>
                            <td>Profile Image</td>
                            <td>Customer ID</td>
                            <td>Full Name</td>
                            <td>Email</td>
                            <td>Contact</td>
                            <td>Gender</td>
                            <td>Address</td>
                            <td>PinCode</td>
                            <td>Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php echo $output; ?>
                    </tbody>
                </table>

            </div>
            
        </section>

    </section>



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