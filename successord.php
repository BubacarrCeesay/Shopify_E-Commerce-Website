<?php 

include('connection.php');

session_start();

if(!empty($_GET)){

    $_SESSION['txn_id'] = $_GET['tx']; 

    $user=$_SESSION['user'];

    $tid=$_SESSION['txn_id'];

    $method="PayPal";

    $invoice_no=mt_rand();

    $qct="select * from cart where user='$user'";

    $rct=mysqli_query($con,$qct);

    $cart_num=mysqli_num_rows($rct);

    $cart_amt=0;

    $totalp=0;

    $product_ids="";

    if($cart_num>0){

        while($cv=mysqli_fetch_array($rct)){
            $prd=$cv['product_id'];
            $qnt=$cv['quantity'];
            $size=$cv['size'];

            $product_ids.=",".$prd."($qnt:$size)";

            $qp="select * from product where product_id=$prd";

            $rp=mysqli_query($con,$qp);

            while($pv=mysqli_fetch_array($rp)){

                $prs=$pv['price'];
                $dis=$pv['discount'];

                $totalp=$totalp + ($prs * $qnt);

                $pz=round($prs-($dis / 100 * $prs));

                $cart_amt= $cart_amt + ($pz * $qnt);

            }
        }

    }

    $product_ids=substr($product_ids,1);

    $qry="INSERT INTO order_info(customer_id, amount, invoice_no, total_product, product_id, order_date,payment_method) VALUES ('$user',$cart_amt,'$invoice_no',$cart_num,'$product_ids',NOW(),'$method')";

    $res=mysqli_query($con,$qry);

    $suc="success";

    if($res){

        insert_payment($invoice_no,$tid);

    }else{
        $_SESSION['alert_info']=="notorder";

        header("Location: successord.php");
        exit();
    }

}

function insert_payment($inv_no,$txid){
    global $con;

    $qry="Select * from order_info where invoice_no=$inv_no";
    $res=mysqli_query($con,$qry);

    if(mysqli_num_rows($res)>0){
        while($val=mysqli_fetch_array($res)){
            $oid=$val['order_id'];
            $amt=$val['amount'];
            $mthd=$val['payment_method'];
        }

    }

    $qrp="INSERT INTO payment(order_id, amount, date, payment_method,transaction_id) VALUES ($oid,$amt,NOW(),'$mthd','$txid')";

    $rq=mysqli_query($con,$qrp);

    if($rq){
        $_SESSION['alert_info'] = "pay";
        
        header("Location: successord.php");
        exit();
    }else{
        $_SESSION['alert_info'] = "notpay";

        header("Location: successord.php");
        exit();
    }

}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SHOPIFY | Order Success </title>
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

                
                <i id="navShow" class="fa-solid fa-bars"></i>

            </div>


            <div class="right">

                <span>
                    <a href="index.php"><h4>Home</h4></a>
                    <a><h4>Contact</h4></a>
                    <a><h4>About</h4></a>
                </span>


            </div>

        </header>

        <div id="customAlert">
            <p id="alertMessage"></p>
        </div>

        <section class="payment">
            <div class="info">
                <h3 id="success">Order Placed Successfully ✅</h3>
                <h3 id="success">Thank You!</h3>
                <form id="successfrm" method='post'>

                    <a href="User/userindex.php">View Orders</a>
                    <a href="index.php">Continue Shopping</a>
                </form>
            </div>
            
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

            if (isset($_SESSION['alert_info']) && $_SESSION['alert_info']=="pay") {
                unset($_SESSION['alert_info']);
                echo "showAlert('✅ Order and Payment Processed ... ');";
    
            }

            else if (isset($_SESSION['alert_info']) && $_SESSION['alert_info']=="notpay") {
                unset($_SESSION['alert_info']);
                echo "showAlert('⚠️ Payment Not Processed...');";
    
            }

            else if (isset($_SESSION['alert_info']) && $_SESSION['alert_info']=="notorder") {
                unset($_SESSION['alert_info']);
                echo "showAlert('⚠️ Error In Processing Order');";

            }
            
            ?>

            
        };
    </script>

<script src="https://cdn.jsdelivr.net/npm/@tsparticles/confetti@3.0.3/tsparticles.confetti.bundle.min.js"></script>

<script>

function showWinAnim() {
  function randomInRange(min, max) {
    return Math.random() * (max - min) + min;
  }

  confetti({
    angle: randomInRange(55, 125),
    spread: randomInRange(50, 70),
    particleCount: randomInRange(50, 100),
    origin: { y: 0.6 },
  });
}

showWinAnim();

setInterval(showWinAnim, 3000);
</script>

</html>