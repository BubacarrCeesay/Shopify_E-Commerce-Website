<?php

session_start();

include("../connection.php");
include("header.php");


if(isset($_GET['oid'])){
    $oid=$_GET['oid'];
    $_SESSION['order']=$oid;
}else{
    $oid=$_SESSION['order'];
}


?>

<?php

    $output="";

    $qry="select * from order_info where order_id=$oid";

    $res=mysqli_query($con,$qry);

    while($val=mysqli_fetch_array($res)){

        $msg=$val['order_msg'];

         $cid=$val['customer_id'];

    }

    $qy="select * from customer where customer_id=$cid";

    $rs=mysqli_query($con,$qy);

    while($val=mysqli_fetch_array($rs)){

         $addr=$val['address'];
         $pnc=$val['pincode'];

    }




?>

<?php 

if(isset($_POST['update'])){

    $newmsg=$_POST['msg'];

    $qr="update order_info set order_msg='$newmsg' where order_id=$oid";
    $rs=mysqli_query($con,$qr);

    if($rs){
        $_SESSION['alert_info'] = "updated";
    }else{
        $_SESSION['alert_info'] = "notupdated";
    }

    header("Location: editorder.php");
    exit();   

}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SHOPIFY | Edit Order</title>
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

            <section class="editbc">

                <h3>Edit Order</h3>

                <h4>Customer's Address : <span><?php echo $addr;?></span></h4>
                <h4>Pin Code : <span><?php echo $pnc;?></span></h4>

                <div>

                    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">

                        <label>
                            <p>Order Feedback : </p><input type="text" value="<?php echo $msg;  ?>" name="msg" autocomplete="off">
                        </label>

                        <input id="sbmtbtn" type="submit" name="update" value="Save Changes"/>

                    </form>

                </div>

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

            if (isset($_SESSION['alert_info']) && $_SESSION['alert_info']=="updated") {
                unset($_SESSION['alert_info']);
                echo "showAlert('✅ Order Updated Successfully');";
    
            }

            else if (isset($_SESSION['alert_info']) && $_SESSION['alert_info']=="notupdated") {
                unset($_SESSION['alert_info']);
                echo "showAlert('⚠️ Error In Updating Order');";

            }
            
            ?>

            
        };
    </script>

    <script src="../Admin/admjsfile.js"></script>

</html>