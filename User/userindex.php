<?php

session_start();

include("../connection.php");
include("header.php");

$user=$_SESSION['user'];

?>


<?php

    $user=$_SESSION['user'];

    $output="";

    $qry="Select * from order_info where customer_id=$user and order_status='pending' order by order_date";
    $res=mysqli_query($con,$qry);

    if(mysqli_num_rows($res)>0){
        while($val=mysqli_fetch_array($res)){
            $oid=$val['order_id'];
            $tp=$val['total_product'];
            $amt=$val['amount'];
            $date=$val['order_date'];
            $mthd=$val['payment_method'];
            $msg=$val['order_msg'];

            $date=substr($date,0,16);

            $output.="
                                <tr id='trup'>
                                    <td>$oid</td>
                                    <td>$tp</td>
                                    <td>$date</td>
                                    <td>$$amt</td>
                                    <td>$mthd</td>
                                    <td><a href='order_detail.php?oid=$oid'><i class='fa-solid fa-cart-shopping'></i></a> 
                                    <a href='userindex.php?cancel=$oid' style='background-color:red; margin-left:5px;'><i class='fa-solid fa-xmark'></i></a></td>
                                </tr>
                                <tr>
                                    <td colspan='7'><p>$msg</p></td>
                                </tr>

                                <tr>
                                    <td colspan='7'><p></p></td>
                                </tr>        
            ";
        }
    }else{
        $output.="
                                <tr>
                                    <td colspan='7'><p style='text-align:center;'>No Pending Order</p></td>
                                </tr>      
        ";
    }

?>


<?php 

    if(isset($_GET['cancel'])){

        $cid=$_GET['cancel'];

        $qry="update order_info set order_status='Cancel' , cancel_date=NOW() where order_id=$cid";
        $rs=mysqli_query($con,$qry);

        if($rs){
            $_SESSION['alert_info']="cancel";
        }else{
            $_SESSION['alert_info']="notcancel";
        }

        header("Location: userindex.php");
        exit();
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SHOPIFY | Pending Orders</title>
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

                <h3>Pending Orders</h3>

                <div class="info">

                    <table border="1">
                        <thead>
                            <tr>
                                <td>Order ID</td>
                                <td>Total Product</td>
                                <td>Order Date</td>
                                <td>Amount</td>
                                <td>Payment Method</td>
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

            if (isset($_SESSION['alert_info']) && $_SESSION['alert_info']=="order") {
                unset($_SESSION['alert_info']);
                echo "showAlert('✅ Order Placed Successfully');";
    
            }

            else if (isset($_SESSION['alert_info']) && $_SESSION['alert_info']=="cancel") {
                unset($_SESSION['alert_info']);
                echo "showAlert('✅ Order Cancel Successfully');";
    
            }

            else if (isset($_SESSION['alert_info']) && $_SESSION['alert_info']=="notcancel") {
                unset($_SESSION['alert_info']);
                echo "showAlert('⚠️ Error In Cancelling Order');";
    
            }
            
            ?>

            
        };
    </script>

    <script src="../Admin/admjsfile.js"></script>

</html>