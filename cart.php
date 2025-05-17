<?php
session_start();
include("connection.php");

if(!isset($_SESSION['user'])){
    $user=getIPAddress();
}else{
    $user=$_SESSION['user'];
}

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

        $output.="

                    <tr>
                        <td><a href='productinfo?product=$prd'><img src='productImgs/$img' alt='product'/></a></td>
                        <td><a href='productinfo?product=$prd'>$pname</a></td>
                        <td><span id='desc'>-$dis% </span> <span id='price'>$$pz </span></td>
                        <td> <span id='size'>$size</span></td>
                        <td><form method='post'><input type='hidden' name='product' value='$prd'>
                        <input id='qinput' type='number' min='1' max='10' name='quantity' value='$qnt'>
                        <input id='qbtn' type='submit' name='update' value='Update'>
                        </form></td>
                        <td><a href='cart.php?remove=$prd'><i class='fa fa-trash' aria-hidden='true'></i></a></td>
                    </tr>
                    <tr><td colspan='6'><hr></td></tr>'
        
        ";
    }
}else{
    $output.="
    <tr><td colspan='6'> <h4 style='color:red;'>Cart Is Empty</h4></td></tr>
    <tr><td colspan='6'><hr></td></tr>
    ";
}

$totaldis=$totalp-$cart_amt;

?>

<?php

if(isset($_POST['update'])){

    $product=$_POST['product'];
    $quantity=$_POST['quantity'];

    $uq="update cart set quantity=$quantity where user='$user' and product_id=$product";

    $ur=mysqli_query($con,$uq);

    if($ur){
        $_SESSION['alert_info']="updated";
    }else{
        $_SESSION['alert_info']="notupdated";
    }

    header("Location: cart.php");
    exit();

}


if(isset($_GET['remove'])){

    $product=$_GET['remove'];

    $dq="delete from cart where product_id=$product and user='$user'";

    $rd=mysqli_query($con,$dq);

    if($rd){
        $_SESSION['alert_info']="deleted";
    }else{
        $_SESSION['alert_info']="notdeleted";
    }

    header("Location: cart.php");
    exit();
}

if(isset($_GET['error'])){

    $_SESSION['alert_info']="errorpay";

    header("Location: cart.php");
    exit();
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SHOPIFY | Shopping Cart</title>
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

    <header>

        <div class="left">
            <a href="index.php"><img src="Logo.png" alt="Logo"/></a>
            <div class="login">

                <div class="up">
                    <i class="fa-regular fa-circle-user"></i>
                    <h4> Account </h4>
                    <span class="fas fa-caret-down arrow"></span>
                </div>

                <div class="lower">

                    <?php
                    if(!isset($_SESSION['user'])){
                        echo"<a href='User/login.php'><h4> Login </h4></a>";
                        echo"<a href='User/signup.php'><h4> Sign Up </h4></a>";
                    }else{
                        echo"<a href='User/userindex.php' target='_blank'><h4> My Profile </h4></a>";
                        echo"<a href='logout.php'><h4> Logout </h4></a>";                        
                    }
                    ?>

                </div>
            </div>

            <a href="cart.php">
                <div class="cart">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span><?php echo $cart_num; ?></span>
                    <h4> Cart </h4>
                </div>
            </a>
            
            <i id="navShow" class="fa-solid fa-magnifying-glass"></i>

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
    
    <main>
        
        <h3 id="cartheader">Shopping Cart</h3>

        <section class="carttable">
            <table>
                <thead>
                    <tr>
                        <td>Product Image</td>
                        <td>Product Name</td>
                        <td>Price</td>
                        <td>Size</td>
                        <td>Quantity</td>
                        <td>Action</td>
                    </tr>
                </thead>
                <tbody>
                    <tr><td colspan="6"><hr></td></tr>

                    <?php echo $output; ?>
                </tbody>
            </table>

        </section>

        <section class="cartdown">

        <?php 
        
        if($cart_num>0){
            echo"
            <div class='left'>
                <p><span id='msg'>SubTotal : </span> <span id='val'> $$cart_amt </span></p>
                <p><span id='msg'>Total Discount : </span> <span id='val'> $$totaldis </span></p>
            </div>

            <div class='right'>
                <a href='checkout.php'><button>Proceed to Checkout</button></a>
            </div>            
            ";
        }else{
            echo"
            <div class='left' style='opacity:0'>
                <p><span id='msg'>SubTotal : </span> <span id='val'> $$cart_amt </span></p>
                <p><span id='msg'>Total Discount : </span> <span id='val'> ($totalp-$cart_amt) </span></p>
            </div>

            <div class='right' style='opacity:0'>
                <a href='#'><button style='display:none'>Proceed to Checkout</button></a>
            </div>            
            ";            
        }
        
        
        ?>

        </section>

    </main>

    <footer>
        <div class="up">

            <div class="abt">
                <h4>Quick Links : </h4>
                <hr>
                <a href="contact.php"><p>Contact Us</p></a>
                <hr>
                <a href="#"><p>About Us</p></a>
                <hr>
                <a href="policy.php"><p>Our Policy</p></a>
                <hr>
                <a href="#"><p>Payments</p></a>
                <hr>


            </div>

            <div class="mail">
                <h4>Shop Address : </h4>

                <p>Se.no.25/24 Dumos Street Road<br>
                Fajikunda , Serrekunda East, <br>
                KMC - 20005, The Gambia.
                </p>
                <span>Email : <a href="mailto:shopifyem@gmail.com">shopifyem@gmail.com</a></span><br><br>
                <span>Telephone : <a href="tel:+220 3122713"> +220 3122713</a>  |  <a href="tel:+220 9926301"> +220 9926301</a></span>
            </div>

            <div class="socials">
                <h4>Socials : </h4>

                <div class="icons">
                    <a href="https://www.facebook.com/" target="_blank"><i class="fa-brands fa-facebook"></i></a>
                    <a href="https://x.com/?lang=en-in" target="_blank"><i class="fa-brands fa-x-twitter"></i></a>
                    <a href="https://www.instagram.com/" target="_blank"><i class="fa-brands fa-instagram"></i></a>
                    <a href="https://www.youtube.com/?gl=IN" target="_blank"><i class="fa-brands fa-youtube"></i></a>
                </div>
            </div>        

        </div>

        <div class="down">
            <p>&copy; 2025 - Shopify.com </p>
        </div>
    </footer>
</body>

<script>
        const frameimg=document.getElementById("frameimg");

        function imgone(url) {
            frameimg.src=url;
        }

        function imgtwo(url) {
            frameimg.src=url;
        }

        function imgthree(url) {
            frameimg.src=url;
        }
</script>

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
                echo "showAlert('✅ Cart Updated');";
            }

            else if (isset($_SESSION['alert_info']) && $_SESSION['alert_info']=="notupdated") {
                unset($_SESSION['alert_info']);
                echo "showAlert('⚠️ Error In Updating Cart');";

            }

            else if (isset($_SESSION['alert_info']) && $_SESSION['alert_info']=="deleted") {
                unset($_SESSION['alert_info']);
                echo "showAlert('✅ Cart Item Deleted');";

            }

            else if (isset($_SESSION['alert_info']) && $_SESSION['alert_info']=="notdeleted") {
                unset($_SESSION['alert_info']);
                echo "showAlert('⚠️ Error In Deleted Cart Item');";

            }

            else if (isset($_SESSION['alert_info']) && $_SESSION['alert_info']=="login") {
                unset($_SESSION['alert_info']);
                echo "showAlert('✅ Login Successful');";
    
            }

            else if (isset($_SESSION['alert_info']) && $_SESSION['alert_info']=="errorpay") {
                unset($_SESSION['alert_info']);
                echo "showAlert('Your Payment has been cancelled, Try Again!');";
    
            }
            
            ?>

            
        };
    </script>
</html>