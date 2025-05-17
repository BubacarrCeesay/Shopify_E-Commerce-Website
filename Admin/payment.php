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

if(isset($_GET['pid'])){

    $ord=$_GET['pid'];

    $qr="delete from payment where payment_id=$ord";
    $rs=mysqli_query($con,$qr);

    if($rs){
        $_SESSION['alert_info'] = "updated";
    }else{
        $_SESSION['alert_info'] = "notupdated";
    }

    header("Location: payment.php");
    exit();

}


?>

<?php

$output="";

$qry="Select * from payment order by date desc";

$res=mysqli_query($con,$qry);

if(mysqli_num_rows($res)>0){

    while($val=mysqli_fetch_array($res)){
        $pid=$val['payment_id'];
        $oid=$val['order_id'];
        $amt=$val['amount'];
        $date=$val['date'];
        $mthd=$val['payment_method'];
        $tid=$val['transaction_id'];

        $date=substr($date,0,16);

        $output.="
                            <tr id='trup'>
                                <td>$pid</td>
                                <td>$oid</td>
                                <td>$$amt</td>
                                <td>$date</td>
                                <td>$mthd</td>
                                <td>$tid</td>
                                <td style='display:flex;'><a href='allorder.php?payord=$oid'><i class='fa-solid fa-arrow-up-right-from-square'></i></a>
                                <a href='payment.php?pid=$pid' style='background-color:red; margin-left:5px'><i class='fa-solid fa-trash'></i></a>
                            </tr>
   
        ";
    }
}else{
    $output.="
                            <tr>
                                <td colspan='6'><p style='text-align:center;'>No Order Found</p></td>
                            </tr>      
    ";
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SHOPIFY | Admin - Payments</title>
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

                <h3>PAYMENTS</h3>

                <div class="info">

                    <table border="1">
                        <thead>
                            <tr>
                                <td>Payment ID</td>
                                 <td>Order ID</td>
                                <td>Amount</td>
                                <td>Payment Date</td>
                                <td>Payment Method</td>
                                <td>Transaction ID</td>
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
                echo "showAlert('✅ Payment Deleted Successfully');";
    
            }

            else if (isset($_SESSION['alert_info']) && $_SESSION['alert_info']=="notupdated") {
                unset($_SESSION['alert_info']);
                echo "showAlert('⚠️ Error In Deleting Payment');";

            }
            
            ?>

            
        };
    </script>

    <script src="admjsfile.js"></script>
</html>