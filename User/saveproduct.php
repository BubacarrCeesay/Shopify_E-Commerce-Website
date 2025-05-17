<?php

session_start();

include("../connection.php");
include("header.php");

$user=$_SESSION['user'];

?>


<?php

$qct="select * from save_product where customer_id='$user'";

$rct=mysqli_query($con,$qct);

$cart_num=mysqli_num_rows($rct);

$output="";

if($cart_num>0){

    while($cv=mysqli_fetch_array($rct)){
        $prd=$cv['product_id'];
        $sid=$cv['s_id'];

        $qp="select * from product where product_id=$prd";

        $rp=mysqli_query($con,$qp);

        while($pv=mysqli_fetch_array($rp)){
            $prs=$pv['price'];
            $dis=$pv['discount'];
            $size=$pv['size'];
            $img=$pv['img1'];
            $pname=$pv['name'];

            $pz=round($prs-($dis / 100 * $prs));


        }

        $output.="

                    <tr>
                        <td><a href='../productinfo?product=$prd'><img src='../productImgs/$img' alt='product'/></a></td>
                        <td><a href='../productinfo?product=$prd'>$pname</a></td>
                        <td><span id='desc'>-$dis% </span> <span id='price'>$$pz </span></td>
                        <td> <span id='size'>$size</span></td>
                        <td><a href='saveproduct.php?remove=$sid'><i class='fa-solid fa-trash'></i></a></td>
                    </tr>
                    <tr><td colspan='5'><hr></td></tr>'
        
        ";
    }
}else{
    $output.="
    <tr><td colspan='5'> <h4 style='color:red;'>No Saved Products</h4></td></tr>
    <tr><td colspan='5'><hr></td></tr>
    ";
}

?>

<?php 


if(isset($_GET['remove'])){

    $sid=$_GET['remove'];

    $dq="delete from save_product where s_id='$sid'";

    $rd=mysqli_query($con,$dq);

    if($rd){
        $_SESSION['alert_info']="deleted";
    }else{
        $_SESSION['alert_info']="notdeleted";
    }

    header("Location: saveproduct.php");
    exit();
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SHOPIFY | Saved Products</title>
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


            <section class="orders">

                <h3>Saved Products</h3>

                <section class="carttable">
                    <table border="0">
                        <thead>
                            <tr>
                                <td>Product Image</td>
                                <td>Product Name</td>
                                <td>Price</td>
                                <td>Sizes</td>
                                <td>Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td colspan="5"><hr></td></tr>
                             <?php echo $output; ?>
                        </tbody>
                    </table>

                </section>

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