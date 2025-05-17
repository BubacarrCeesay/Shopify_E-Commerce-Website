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

if($cart_num>0){
    while($cv=mysqli_fetch_array($rct)){
        $prd=$cv['product_id'];
        $qnt=$cv['quantity'];

        $qp="select * from product where product_id=$prd";

        $rp=mysqli_query($con,$qp);

        while($pv=mysqli_fetch_array($rp)){
            $prs=$pv['price'];
            $dis=$pv['discount'];

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
    <title>SHOPIFY | E-Commerce Website</title>
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

    <div id="customAlert">
        <p id="alertMessage"></p>
    </div>

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
                    <h5> || $<?php echo $cart_amt; ?> /-</h5>
                </div>
                </a>
                
        

            </div>


            <div class="right">

                <span>
                    <a href="index.php"><h4>Home</h4></a>
                    <a href="contact.php"><h4>Contact</h4></a>
                    <a href="about.php"><h4>About</h4></a>
                </span>

                <div>
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <form action="index.php" method="post">
                        <input id="textinp" type="text" placeholder="Search for Products, Brands and More..." name="searchinfo" required>
                        <input id="sbmtbtn" type="submit" value="Search" name="search">
                    </form>
                </div>
            </div>

        </header>

        <section class="policy">

            <h2>About Us</h2>

            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nesciunt ratione minima quia magnam, ullam itaque eius corporis cumque velit harum amet provident, soluta dolorem deleniti consequuntur tenetur explicabo. Ab, reiciendis. Lorem ipsum dolor sit amet consectetur adipisicing elit. Omnis minima iste expedita nihil maxime! Rem vel maiores placeat, voluptate architecto repudiandae fugit beatae quas ullam veniam aspernatur adipisci ipsa minus.</p>

            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Omnis minima iste expedita nihil maxime! Rem vel maiores placeat, voluptate architecto repudiandae fugit beatae quas ullam veniam aspernatur adipisci ipsa minus. Lorem ipsum dolor sit amet consectetur adipisicing elit. Omnis minima iste expedita nihil maxime! Rem vel maiores placeat, voluptate architecto repudiandae fugit beatae quas ullam veniam aspernatur adipisci ipsa minus.</p>


            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nesciunt ratione minima quia magnam, ullam itaque eius corporis cumque velit harum amet provident, soluta dolorem deleniti consequuntur tenetur explicabo. Ab, reiciendis. Lorem ipsum dolor sit amet consectetur adipisicing elit. Omnis minima iste expedita nihil maxime! Rem vel maiores placeat, voluptate architecto repudiandae fugit beatae quas ullam veniam aspernatur adipisci ipsa minus.</p>

            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Omnis minima iste expedita nihil maxime! Rem vel maiores placeat, voluptate architecto repudiandae fugit beatae quas ullam veniam aspernatur adipisci ipsa minus. Lorem ipsum dolor sit amet consectetur adipisicing elit. Omnis minima iste expedita nihil maxime! Rem vel maiores placeat, voluptate architecto repudiandae fugit beatae quas ullam veniam aspernatur adipisci ipsa minus.</p>



            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nesciunt ratione minima quia magnam, ullam itaque eius corporis cumque velit harum amet provident, soluta dolorem deleniti consequuntur tenetur explicabo. Ab, reiciendis. Lorem ipsum dolor sit amet consectetur adipisicing elit. Omnis minima iste expedita nihil maxime! Rem vel maiores placeat, voluptate architecto repudiandae fugit beatae quas ullam veniam aspernatur adipisci ipsa minus.</p>

            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Omnis minima iste expedita nihil maxime! Rem vel maiores placeat, voluptate architecto repudiandae fugit beatae quas ullam veniam aspernatur adipisci ipsa minus. Lorem ipsum dolor sit amet consectetur adipisicing elit. Omnis minima iste expedita nihil maxime! Rem vel maiores placeat, voluptate architecto repudiandae fugit beatae quas ullam veniam aspernatur adipisci ipsa minus.</p>



            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nesciunt ratione minima quia magnam, ullam itaque eius corporis cumque velit harum amet provident, soluta dolorem deleniti consequuntur tenetur explicabo. Ab, reiciendis. Lorem ipsum dolor sit amet consectetur adipisicing elit. Omnis minima iste expedita nihil maxime! Rem vel maiores placeat, voluptate architecto repudiandae fugit beatae quas ullam veniam aspernatur adipisci ipsa minus.</p>

            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Omnis minima iste expedita nihil maxime! Rem vel maiores placeat, voluptate architecto repudiandae fugit beatae quas ullam veniam aspernatur adipisci ipsa minus. Lorem ipsum dolor sit amet consectetur adipisicing elit. Omnis minima iste expedita nihil maxime! Rem vel maiores placeat, voluptate architecto repudiandae fugit beatae quas ullam veniam aspernatur adipisci ipsa minus.</p>

        </section>


    </main>

    <footer>
        <div class="up">

            <div class="abt">
                <h4>Quick Links : </h4>
                <hr>
                <a href="contact.php"><p>Contact Us</p></a>
                <hr>
                <a href="about.php"><p>About Us</p></a>
                <hr>
                <a href="policy.php"><p>Our Policy</p></a>
                <hr>
                <a href="ourpayments.php"><p>Payments</p></a>
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

            if (isset($_SESSION['alert_info']) && $_SESSION['alert_info']=="send") {
                unset($_SESSION['alert_info']);
                echo "showAlert('✅ Message Sent Successfully');";
    
            }

            else if (isset($_SESSION['alert_info']) && $_SESSION['alert_info']=="notsend") {
                unset($_SESSION['alert_info']);
                echo "showAlert('⚠️ Error Sending Message');";
    
            }
            
            ?>

            
        };
    </script>
</html>