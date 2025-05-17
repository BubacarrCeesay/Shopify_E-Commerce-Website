<?php

session_start();

include("../connection.php");
include("header.php");

$user=$_SESSION['user'];

?>


<?php

    $alloutput="";

    $qry="Select * from order_info where order_status='Delivered' and customer_id='$user' order by order_date desc";
    $res=mysqli_query($con,$qry);

    if(mysqli_num_rows($res)>0){
        while($val=mysqli_fetch_array($res)){
            $oid=$val['order_id'];
            $invoice=$val['invoice_no'];
            $tp=$val['total_product'];
            $amt=$val['amount'];
            $date=$val['order_date'];
            $del_date=$val['delivery_date'];
            $status=$val['order_status'];
            $mthd=$val['payment_method'];
            $msg=$val['order_msg'];

            $date=substr($date,0,16);

            $del_date=substr($del_date,0,16);

            $alloutput.="
                                <tr id='trup'>
                                    <td>$oid</td>
                                    <td>$invoice</td>
                                    <td>$tp</td>
                                    <td>$date</td>
                                    <td>$del_date</td>
                                    <td>$$amt</td>
                                    <td>$mthd</td>
                                    <td>$status</td>
                                    <td><a href='ordered_items.php?oid=$oid'><i class='fa-solid fa-cart-shopping'></i></a></td>
                                </tr>
    
            ";
        }
    }else{
        $alloutput.="
                                <tr>
                                    <td colspan='9'><p style='text-align:center;'>No Previous Order Found</p></td>
                                </tr>      
        ";
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SHOPIFY | Past Orders </title>
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
                <br/><br/><br/>
                <h3>Past Orders</h3>

                <div class="info">

                    <table border="1">
                        <thead>
                            <tr>
                                <td>Order ID</td>
                                <td>Invoice No.</td>
                                <td>Total Product</td>
                                <td>Order Date</td>
                                <td>Delivered Date</td>
                                <td>Total Amount</td>
                                <td>Payment Method</td>
                                <td>Order Status</td>
                                <td>Action</td>
                            </tr>
                        </thead>
                        <tbody>
                                <?php echo $alloutput; ?>
                        </tbody>
                    </table>

                </div>
                <br/>
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
            
            ?>

            
        };
    </script>

    <script src="../Admin/admjsfile.js"></script>

</html>