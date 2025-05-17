<?php

session_start();
include("connection.php");

$user=$_SESSION['user'];


$qct="select * from cart where user='$user'";

$rct=mysqli_query($con,$qct);

$cart_num=mysqli_num_rows($rct);

$cart_amt=0;

$totalp=0;

$output="";

if($cart_num>0){

    while($cv=mysqli_fetch_array($rct)){
        $prd=$cv['product_id'];
        $qnt=$cv['quantity'];
        $size=$cv['size'];

        $qp="select * from product where product_id=$prd";

        $rp=mysqli_query($con,$qp);

        while($pv=mysqli_fetch_array($rp)){
            $prs=$pv['price'];
            $dis=$pv['discount'];
            $img=$pv['img1'];
            $pname=$pv['name'];
            $totalp=$totalp + ($prs * $qnt);

            $pz=round($prs-($dis / 100 * $prs));

            $cart_amt= $cart_amt + ($pz * $qnt);


        }
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SHOPIFY | User Login</title>
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
                    <a href="contact.php"><h4>Contact</h4></a>
                    <a href="about.php"><h4>About</h4></a>
                </span>


            </div>

        </header>

        <div id="customAlert">
            <p id="alertMessage"></p>
        </div>

        <section class="payment">
            <div class="info">
                <h3><img src="imgs/paypalicon.svg"> PayPal Payment</h3>
                <form method='post' action="https://www.sandbox.paypal.com/cgi-bin/webscr">
                    <label>
                        <input type="hidden" name="business" value="sb-ue2eh27310939@business.example.com">
                        <input type="hidden" name="return" value="http://localhost/E-Commerce/successord.php">
                        <input type="hidden" name="cancel_return" value="http://localhost/E-Commerce/cart.php?error=123">
                    </label>

                    <label>
                        <input type="hidden" name="item_name" value="<?php echo $pname;?>">
                        <input type="hidden" name="cmd" value="_xclick">
                    </label>

                    <h4>Total Product Price : <span>$<?php echo $cart_amt ?></span></h4>

                    <label>
                        <input type="hidden" name="item_number" value="<?php echo $prd;?>">
                        <input type="hidden" name="no_shipping" value="1">
                    </label>
                    <label>
                        <input type="hidden" name="amount" value="<?php echo $cart_amt;?>">
                        <input type="hidden" name="currency_code" value="USD">
                    </label>



                    <p id="sbtbtn"><input type="submit" name="submit" value="Pay Now"></p>
                </form>
            </div>

        <div id="paypal-button-container"></div>
        <p id="result-message"></p>
            
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
                echo "showAlert('✅ Login Successful');";
    
            }

            else if (isset($_SESSION['alert_info']) && $_SESSION['alert_info']=="notorder") {
                unset($_SESSION['alert_info']);
                echo "showAlert('⚠️ Error In Processing Order');";

            }
            
            ?>

            
        };
    </script>
</html>