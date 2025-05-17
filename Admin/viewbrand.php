
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

$qry="Select * from brand";
$res=mysqli_query($con,$qry);

if(mysqli_num_rows($res)>0){

    while($val=mysqli_fetch_array($res)){
        $bid=$val['brand_id'];
        $bname=$val['name'];

        $output.="
                        <tr>
                            <td>$bid</td>
                            <td>$bname</td>
                            <td>
                                <a href='editbrand.php?brand=$bid' id='edit'><i class='fa-solid fa-pen-to-square'></i></a> 
                                <a href='#' id='delete'><i class='fa-solid fa-trash'></i></a>
                            </td>
                        </tr>              
        ";
    }

}else{

    $output.="
        <tr><td colspan='3'><h3 style='text-align:center;'>No Brand Found</h3></td></tr>
    ";
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SHOPIFY | Admin - View Brand</title>
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

    <section class="contents">
        
        <section class="viewprd">

            <h3>VIEW BRANDS</h3>

            <div class="tablesec">
                <table border="1">
                    <thead>
                        <tr>
                            <td>Brand ID</td>
                            <td>Brand Name</td>
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