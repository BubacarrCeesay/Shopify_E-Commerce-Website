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

$qry="Select * from order_info where order_status='pending' order by order_date desc";
$res=mysqli_query($con,$qry);

if(mysqli_num_rows($res)>0){
    while($val=mysqli_fetch_array($res)){
        $oid=$val['order_id'];
        $cid=$val['customer_id'];
        $invoice=$val['invoice_no'];
        $tp=$val['total_product'];
        $amt=$val['amount'];
        $date=$val['order_date'];
        $mthd=$val['payment_method'];
        $msg=$val['order_msg'];

        $sql="select * from customer where customer_id=$cid";
        $cus=mysqli_query($con,$sql);

        while($vl=mysqli_fetch_array($cus)){
            $name=$vl['firstname']." ".$vl['lastname'];
        }

        $date=substr($date,0,16);

        $output.="
                            <tr id='trup'>
                                <td>$oid</td>
                                <td><a style='background-color:#f0f0f0; color:black;' href='customers.php?cust=$cid'>$cid - $name</a></td>
                                <td>$invoice</td>
                                <td>$tp</td>
                                <td>$date</td>
                                <td>$$amt</td>
                                <td>$mthd</td>
                                <td><a href='order_item.php?oid=$oid'><i class='fa-solid fa-cart-shopping'></i></a>
                                <a href='editorder.php?oid=$oid' style='background-color:blue;'><i class='fa-regular fa-pen-to-square'></i></a> 
                                 - 
                                <a href='pendingorder?oid=$oid&mtd=$mthd&amt=$amt' style='background-color:green;'>Delivered</a></td>
                            </tr>
                            <tr>
                                <td colspan='8'><p>$msg</p></td>
                            </tr>

                            <tr>
                                <td colspan='8'><p></p></td>
                            </tr>        
        ";
    }
}else{
    $output.="
                            <tr>
                                <td colspan='8'><p style='text-align:center;'>No Pending Order</p></td>
                            </tr>      
    ";
}

?>

<?php

if(isset($_GET['oid']) && isset($_GET['mtd']) && isset($_GET['amt'])){

    $ord=$_GET['oid'];
    $mtd=$_GET['mtd'];
    $amnt=$_GET['amt'];

    if($mtd=='Cash On Delivery'){
        doPayment();
    }

    $qr="update order_info set order_status='Delivered', delivery_date=NOW() where order_id=$ord";
    $rs=mysqli_query($con,$qr);

    if($rs){
        $_SESSION['alert_info'] = "updated";
    }else{
        $_SESSION['alert_info'] = "notupdated";
    }

    header("Location: pendingorder.php");
    exit();   

}

function doPayment(){

    global $con;
    global $ord;
    global $mtd;
    global $amnt;

    $qrp="INSERT INTO payment(order_id, amount, date, payment_method) VALUES ($ord,$amnt,NOW(),'$mtd')";

    $rq=mysqli_query($con,$qrp);

    if($rq){
        return;
    }else{
        $_SESSION['alert_info'] = "notpay";
        header("Location: pendingorder.php");
        exit();   
    }

}

?>

<?php 

if(isset($_POST['search'])){

    $text=$_POST['input'];

    $text=trim($text);

    $output="";

    $qry="SELECT * from order_info where order_status='pending'  AND (order_id='$text' OR customer_id='$text' OR invoice_no='$text') order by order_date desc";
    $res=mysqli_query($con,$qry);

    if(mysqli_num_rows($res)>0){
        while($val=mysqli_fetch_array($res)){
            $oid=$val['order_id'];
            $cid=$val['customer_id'];
            $invoice=$val['invoice_no'];
            $tp=$val['total_product'];
            $amt=$val['amount'];
            $date=$val['order_date'];
            $mthd=$val['payment_method'];
            $msg=$val['order_msg'];

            $sql="select * from customer where customer_id=$cid";
            $cus=mysqli_query($con,$sql);

            while($vl=mysqli_fetch_array($cus)){
                $name=$vl['firstname']." ".$vl['lastname'];
            }

            $date=substr($date,0,16);

            $output.="
                                <tr id='trup'>
                                    <td>$oid</td>
                                    <td><a style='background-color:#f0f0f0; color:black;' href='customers.php?cust=$cid'>$cid $name</a></td>
                                    <td>$invoice</td>
                                    <td>$tp</td>
                                    <td>$date</td>
                                    <td>$$amt</td>
                                    <td>$mthd</td>
                                    <td><a href='order_item.php?oid=$oid'><i class='fa-solid fa-cart-shopping'></i></a>
                                    <a href='editorder.php?oid=$oid' style='background-color:blue;'><i class='fa-regular fa-pen-to-square'></i></a> 
                                    <a href='#' style='background-color:red;'><i class='fa-solid fa-xmark'></i></a> - 
                                    <a href='pendingorder?oid=$oid&mtd=$mthd&amt=$amt' style='background-color:green;'>Delivered</a></td>
                                </tr>
                                <tr>
                                    <td colspan='8'><p>$msg</p></td>
                                </tr>

                                <tr>
                                    <td colspan='8'><p></p></td>
                                </tr>        
            ";
        }
    }else{
        $output.="
                                <tr>
                                    <td colspan='8'><p style='text-align:center;'>No Searched Order Found</p></td>
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
    <title>SHOPIFY | Admin - Pending Orders</title>
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
        
            <section class="orders">

                <h3>PENDING ORDER</h3>

                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">

                    <div class="field">
                        <input type="text" name="input" placeholder="Search by Order ID, Customer ID or Invoice No. " autocomplete="off"/>
                    </div>

                    <div class="field">
                        <input id="sbtbtn" type="submit" name="search" value="Search Order">
                    </div>

                </form>

                <div class="info">

                    <table border="1">
                        <thead>
                            <tr>
                                <td>Order ID</td>
                                <td>Customer ID & Name</td>
                                <td>Invoice No.</td>
                                <td>Total Product</td>
                                <td>Order Date</td>
                                <td>Amount</td>
                                <td>Payment Method</td>
                                <td>Action</td>
                            </tr>
                        </thead>
                        <tbody>

                            <?php echo $output;?>

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

            if (isset($_SESSION['alert_info']) && $_SESSION['alert_info']=="updated") {
                unset($_SESSION['alert_info']);
                echo "showAlert('✅ Order Updated Successfully');";
    
            }

            else if (isset($_SESSION['alert_info']) && $_SESSION['alert_info']=="notupdated") {
                unset($_SESSION['alert_info']);
                echo "showAlert('⚠️ Error In Updating Order');";

            }

            else if (isset($_SESSION['alert_info']) && $_SESSION['alert_info']=="notpay") {
                unset($_SESSION['alert_info']);
                echo "showAlert('⚠️ Error In Processing Order');";

            }
            
            ?>

            
        };
    </script>

    <script src="admjsfile.js"></script>
</html>