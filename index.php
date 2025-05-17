<?php

session_start();
include("connection.php");

?>

<?php

    // Fetch adverts from the database
    $qry = "SELECT * FROM advert ORDER BY advert_id ASC";
    $res = mysqli_query($con, $qry);

    $adverts = [];
    while ($row = mysqli_fetch_assoc($res)) {
        $adverts[] = [
            'image' => $row['image'], // Store image path
            'link' => $row['link']    // Store URL link
        ];
    }

    // Get the total number of adverts
    $totalAdverts = count($adverts);
?>

<?php

    $query="select * from category order by name";

    $cres=mysqli_query($con,$query);

    $coutp="";

    if(mysqli_num_rows($cres)>0){
        while($val=mysqli_fetch_array($cres)){
            $id=$val['category_id'];
            $coutp.="
            <a href='index.php?category=$id'><h4>".$val['name']."</h4></a>
            ";
        }
    }

    $qry="select * from brand order by name";

    $bres=mysqli_query($con,$qry);

    $boutp="";

    if(mysqli_num_rows($bres)>0){
        while($vl=mysqli_fetch_array($bres)){
            $id=$vl['brand_id'];
            $boutp.="
            <a href='index.php?brand=$id'><h4>".$vl['name']."</h4></a>
            ";
        }
    }

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

<?php

    $output="";

    $pq="select * from product ORDER BY RAND()";

    $prs=mysqli_query($con,$pq);

    if(mysqli_num_rows($prs)>0){
        while($val=mysqli_fetch_array($prs)){
            $pid=$val['product_id'];
            $pname=$val['name'];
            $brd=$val['brand'];
            $img1=$val['img1'];
            $price=$val['price'];
            $discount=$val['discount'];
            $instock=$val['in_stock'];

            $acp= round($price-($discount / 100 * $price));

            $bq="select * from brand where brand_id=$brd";
            $brs=mysqli_query($con,$bq);

            if(mysqli_num_rows($brs)>0){
                while($bval=mysqli_fetch_array($brs)){
                    $brand=$bval['name'];
                }
            }

            if($instock=="Yes"){
                $output.="
                        <div class='container'>
                            <a href='productinfo?product=$pid'><img src='productImgs/$img1'/>
                            <p id='brand'> $brand </p>
                            <p id='desc'> $pname </p>
                            <div class='prices'><span id='currentp'>$$acp</span><span id='actualp'>$$price</span> <span id='disc'>$discount% off</span></div>
                            </a>
                        </div>        
                
                ";
            }else{

                    $output.="
                            <div class='container outstock'>
                                <a href='productinfo?product=$pid'><img src='productImgs/$img1'/>
                                <p id='brand'> $brand </p>
                                <p id='desc'> $pname </p>
                                <div class='prices'><span id='currentp'>$$acp</span><span id='actualp'>$$price</span> <span id='disc'>$discount% off</span></div>
                                </a>
                            </div>        
                    
                    ";            
            }


        }
    }

    if(isset($_GET['category'])){

        $ctg=$_GET['category'];


        $output="";

        $pq="select * from product where category=$ctg ORDER BY RAND()";

        $prs=mysqli_query($con,$pq);

        if(mysqli_num_rows($prs)>0){
            while($val=mysqli_fetch_array($prs)){
                $pid=$val['product_id'];
                $pname=$val['name'];
                $brd=$val['brand'];
                $img1=$val['img1'];
                $price=$val['price'];
                $discount=$val['discount'];
                $instock=$val['in_stock'];

                $acp= round($price-($discount / 100 * $price));

                $bq="select * from brand where brand_id=$brd";
                $brs=mysqli_query($con,$bq);

                if(mysqli_num_rows($brs)>0){
                    while($bval=mysqli_fetch_array($brs)){
                        $brand=$bval['name'];
                    }
                }

            if($instock=="Yes"){
                $output.="
                        <div class='container'>
                            <a href='productinfo?product=$pid'><img src='productImgs/$img1'/>
                            <p id='brand'> $brand </p>
                            <p id='desc'> $pname </p>
                            <div class='prices'><span id='currentp'>$$acp</span><span id='actualp'>$$price</span> <span id='disc'>$discount% off</span></div>
                            </a>
                        </div>        
                
                ";
            }else{

                    $output.="
                            <div class='container outstock'>
                                <a href='productinfo?product=$pid'><img src='productImgs/$img1'/>
                                <p id='brand'> $brand </p>
                                <p id='desc'> $pname </p>
                                <div class='prices'><span id='currentp'>$$acp</span><span id='actualp'>$$price</span> <span id='disc'>$discount% off</span></div>
                                </a>
                            </div>        
                    
                    ";            
            }


            }
        }else{
            $output.="<h3 style='color:red;'>No Category Product Found</h3>";
        }



    }

    if(isset($_GET['brand'])){

        $brnd=$_GET['brand'];


        $output="";

        $pq="select * from product where brand=$brnd ORDER BY RAND()";

        $prs=mysqli_query($con,$pq);

        if(mysqli_num_rows($prs)>0){
            while($val=mysqli_fetch_array($prs)){
                $pid=$val['product_id'];
                $pname=$val['name'];
                $brd=$val['brand'];
                $img1=$val['img1'];
                $price=$val['price'];
                $discount=$val['discount'];
                $instock=$val['in_stock'];

                $acp= round($price-($discount / 100 * $price));

                $bq="select * from brand where brand_id=$brd";
                $brs=mysqli_query($con,$bq);

                if(mysqli_num_rows($brs)>0){
                    while($bval=mysqli_fetch_array($brs)){
                        $brand=$bval['name'];
                    }
                }


            if($instock=="Yes"){
                $output.="
                        <div class='container'>
                            <a href='productinfo?product=$pid'><img src='productImgs/$img1'/>
                            <p id='brand'> $brand </p>
                            <p id='desc'> $pname </p>
                            <div class='prices'><span id='currentp'>$$acp</span><span id='actualp'>$$price</span> <span id='disc'>$discount% off</span></div>
                            </a>
                        </div>        
                
                ";
            }else{

                    $output.="
                            <div class='container outstock'>
                                <a href='productinfo?product=$pid'><img src='productImgs/$img1'/>
                                <p id='brand'> $brand </p>
                                <p id='desc'> $pname </p>
                                <div class='prices'><span id='currentp'>$$acp</span><span id='actualp'>$$price</span> <span id='disc'>$discount% off</span></div>
                                </a>
                            </div>        
                    
                    ";            
            }



            }
        }else{
            $output.="<h3 style='color:red;'>No Brand Product Found</h3>";
        }



    }

    if(isset($_POST['search'])){

        $srch=$_POST['searchinfo'];


        $output="";

        $pq="select * from product where name LIKE '%$srch%' OR description LIKE '%$srch%'  ORDER BY RAND()";

        $prs=mysqli_query($con,$pq);

        if(mysqli_num_rows($prs)>0){
            while($val=mysqli_fetch_array($prs)){
                $pid=$val['product_id'];
                $pname=$val['name'];
                $brd=$val['brand'];
                $img1=$val['img1'];
                $price=$val['price'];
                $discount=$val['discount'];
                $instock=$val['in_stock'];

                $acp= round($price-($discount / 100 * $price));

                $bq="select * from brand where brand_id=$brd";
                $brs=mysqli_query($con,$bq);

                if(mysqli_num_rows($brs)>0){
                    while($bval=mysqli_fetch_array($brs)){
                        $brand=$bval['name'];
                    }
                }
            if($instock=="Yes"){
                $output.="
                        <div class='container'>
                            <a href='productinfo?product=$pid'><img src='productImgs/$img1'/>
                            <p id='brand'> $brand </p>
                            <p id='desc'> $pname </p>
                            <div class='prices'><span id='currentp'>$$acp</span><span id='actualp'>$$price</span> <span id='disc'>$discount% off</span></div>
                            </a>
                        </div>        
                
                ";
            }else{

                    $output.="
                            <div class='container outstock'>
                                <a href='productinfo?product=$pid'><img src='productImgs/$img1'/>
                                <p id='brand'> $brand </p>
                                <p id='desc'> $pname </p>
                                <div class='prices'><span id='currentp'>$$acp</span><span id='actualp'>$$price</span> <span id='disc'>$discount% off</span></div>
                                </a>
                            </div>        
                    
                    ";            
            }


            }
        }else{
            $output.="<h3 style='color:red;'>No Searched Product Found</h3>";
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
                
                <i id="navShow" class="fa-solid fa-magnifying-glass"></i>

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

        <section class="front">
            

            <a id="advertLink" href="<?php echo $adverts[0]['link']; ?>">
                <img id="advertImg" src="imgs/<?php echo $adverts[0]['image']; ?>" />
            </a>
            
            <button id="frtprev"><i class="fa-solid fa-chevron-left"></i></button>
            <button id="frtnext"><i class="fa-solid fa-chevron-right"></i></button>
            
            <?php foreach ($adverts as $index => $advert) { ?>
                <input type="hidden" class="advert-data" data-index="<?php echo $index; ?>" data-img="imgs/<?php echo $advert['image']; ?>" data-link="<?php echo $advert['link']; ?>">
            <?php } ?>
        </section>
        
        <h2 id="phead"> Our Store Products </h2>

        <section class="products">
            <div class="left">

                <?php echo $output; ?>

            </div>

            <i id="sidenavShow" class="fa-solid fa-bars"></i>

            <div class="nvicon"> <i class="fa-solid fa-list"></i> </div>

            <div class="right rightsd">
                <div class="up">
                    <div>
                    <h3> BRANDS </h3>
                    </div>

                    <?php echo $boutp; ?>

                </div>

                <div class="down">
                    <div>
                    <h3> CATEGORIES </h3>
                    </div>

                    <?php echo $coutp; ?>

                </div>
            </div>
        </section>

    </main>

    <footer>
        <div class="up">

            <div class="abt">
                <h4>Quick Links : </h4>
                <hr>
                <a href="adminlogin.php"><p>Admin Login</p></a>
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

            if (isset($_SESSION['alert_info']) && $_SESSION['alert_info']=="login") {
                unset($_SESSION['alert_info']);
                echo "showAlert('✅ Login Successful');";
    
            }

            else if (isset($_SESSION['alert_info']) && $_SESSION['alert_info']=="logout") {
                unset($_SESSION['alert_info']);
                echo "showAlert('✅ Logout Successful');";
    
            }
            
            ?>

            
        };
    </script>

<script>
    let currentIndex = 0;
    const totalAdverts = <?php echo $totalAdverts; ?>;
    const adverts = document.querySelectorAll(".advert-data");

    const advertImg = document.getElementById("advertImg");
    const advertLink = document.getElementById("advertLink");

    document.getElementById("frtnext").addEventListener("click", function() {
        currentIndex = (currentIndex + 1) % totalAdverts;
        updateAdvert();
    });

    document.getElementById("frtprev").addEventListener("click", function() {
        currentIndex = (currentIndex - 1 + totalAdverts) % totalAdverts;
        updateAdvert();
    });

    function updateAdvert() {
        const selectedAdvert = adverts[currentIndex];
        advertImg.src = selectedAdvert.getAttribute("data-img");
        advertLink.href = selectedAdvert.getAttribute("data-link");
    }


    let upnv= document.getElementById("navShow");
    let rghtnv= document.querySelector(".right");

    upnv.addEventListener("click", function(){
        rghtnv.classList.toggle("rightupnav");

    });


    let sdnv=document.querySelector(".nvicon");
    let rghtsd = document.querySelector(".rightsd");

    sdnv.addEventListener("click",function(){
        console.log("clicked")
        rghtsd.classList.toggle("rghtsdnv");
    });

</script>
</html>