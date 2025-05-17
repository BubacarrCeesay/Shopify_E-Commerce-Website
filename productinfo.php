<?php
session_start();
include("connection.php");

?>

<?php

if(isset($_GET['product'])){
    $prdinfo=intval($_GET['product']);
    $_SESSION['product_info']=$prdinfo;
}else{
    $prdinfo=intval($_SESSION['product_info']);
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

$save="false";

$cs="select * from save_product where product_id='$prdinfo' and customer_id='$user'";

$rs=mysqli_query($con,$cs);

if(mysqli_num_rows($rs)>0){
    $save="true";
}


?>


<?php

    $prd=intval($_SESSION['product_info']);

    $pq="select * from product where product_id=$prd";

    $prs=mysqli_query($con,$pq);

    if(mysqli_num_rows($prs)==1){
        while($val=mysqli_fetch_array($prs)){
            $pid=$val['product_id'];
            $pname=$val['name'];
            $brd=$val['brand'];
            $cat=$val['category'];
            $img1=$val['img1'];
            $img2=$val['img2'];
            $img3=$val['img3'];
            $price=$val['price'];
            $discount=$val['discount'];
            $size=$val['size'];
            $instock=$val['in_stock'];

            $desc=$val['description'];

            $output="";

            $deli=",";

            $array=explode($deli,$size);
            $len=count($array);
            for($i=0;$i<$len;$i++){
                $str=trim($array[$i]);
                $output.="
                <option value='$str'>$str</option>
                ";
            }

            $acp= round($price-($discount / 100 * $price));

            $bq="select * from brand where brand_id=$brd";
            $brs=mysqli_query($con,$bq);

            if(mysqli_num_rows($brs)>0){
                while($bval=mysqli_fetch_array($brs)){
                    $brand=$bval['name'];
                }
            }
        }
    }
?>

<?php


    $out="";

    $pqr="select * from product where category=$cat and product_id !=$prd ORDER BY RAND() limit 5";

    $prsr=mysqli_query($con,$pqr);

    if(mysqli_num_rows($prsr)>0){
        while($valr=mysqli_fetch_array($prsr)){
            $pidr=$valr['product_id'];
            $pnamer=$valr['name'];
            $brdr=$valr['brand'];
            $img1r=$valr['img1'];
            $pricer=$valr['price'];
            $discountr=$valr['discount'];

            $acpr= round($pricer-($discountr / 100 * $pricer));

            $bqr="select * from brand where brand_id=$brdr";
            $brsr=mysqli_query($con,$bqr);

            if(mysqli_num_rows($brsr)>0){
                while($bvalr=mysqli_fetch_array($brsr)){
                    $brandr=$bvalr['name'];
                }
            }

            $out.="
                    <div class='container'>
                        <a href='productinfo?product=$pidr'><img src='productImgs/$img1r'/>
                        <p id='brand'> $brandr </p>
                        <p id='desc'> $pnamer </p>
                        <div class='prices'><span id='currentp'>$$acpr</span><span id='actualp'>$$pricer</span> <span id='disc'>$discountr% off</span></div>
                        </a>
                    </div>        
            
            ";


        }
    }else{
        $out.="<h3>No Related Product Found ... </h3>";
    }

?>

<?php

    if(isset($_POST['add'])){

        $sz=$_POST['selectedsize'];
        
        if(!isset($_SESSION['user'])){
            $user=getIPAddress();
        }else{
            $user=$_SESSION['user'];
        }

        if($instock!="Yes"){

            $_SESSION['alert_info']="outstock";

        }else{
            $cq="select * from cart where product_id='$prdinfo' and user='$user'";

            $cr=mysqli_query($con,$cq);

            if(mysqli_num_rows($cr)>0){
                $_SESSION['alert_info']="incart";
            }else{

                $iq="insert into cart (product_id,user,size) values('$prdinfo','$user','$sz')";

                $ir=mysqli_query($con,$iq);

                if($ir){
                    $_SESSION['alert_info']="added";
                }else{
                    $_SESSION['alert_info']="notadded";
                }
            }
        }

        header("Location: productinfo.php");
        exit();
        
    }


    
    if(isset($_GET['save'])){
        
        if(!isset($_SESSION['user'])){
            header("Location: User/login.php");
            exit();
        }else{

            $user=$_SESSION['user'];

            $qry="INSERT INTO save_product(customer_id, product_id) VALUES ($user,$prdinfo)";
            $rs=mysqli_query($con,$qry);

            if($rs){
                $_SESSION['alert_info']="saved";
            }else{
                $_SESSION['alert_info']="notsaved";
            }

            header("Location: productinfo.php");
            exit();
        }

    }

    if(isset($_GET['unsave'])){
        
        if(!isset($_SESSION['user'])){
            header("Location: User/login.php");
            exit();
        }else{

            $user=$_SESSION['user'];

            $qry="DELETE FROM save_product WHERE customer_id=$user and product_id=$prdinfo";
            $rs=mysqli_query($con,$qry);

            if($rs){
                $_SESSION['alert_info']="unsaved";
            }else{
                $_SESSION['alert_info']="notunsaved";
            }

            header("Location: productinfo.php");
            exit();
        }

    }
?>


<?php 

    $outrate="";

    $qry="select * from rating where product_id=$prd";
    $sql=mysqli_query($con,$qry);

    $rt=0;
    $cnt=0;

    if(mysqli_num_rows($sql)>0){
        while($vl=mysqli_fetch_array($sql)){
            $rate=$vl['rate'];
            $rev=$vl['review'];
            $cus=$vl['customer_id'];

            $rt=$rt + intval($rate);
            $cnt=$cnt+1;

            $cq="select * from customer where customer_id=$cus";
            $rc=mysqli_query($con,$cq);

            while($vlc=mysqli_fetch_array($rc)){
                $name=$vlc['firstname']." ".$vlc['lastname'];
            }

            if(intval($rate)==5){
                $rtval="<i class='fa-solid fa-star'></i> <i class='fa-solid fa-star'></i> <i class='fa-solid fa-star'></i> <i class='fa-solid fa-star'></i> <i class='fa-solid fa-star'></i>";
            }else if(intval($rate)==4){
                $rtval="<i class='fa-solid fa-star'></i> <i class='fa-solid fa-star'></i> <i class='fa-solid fa-star'></i> <i class='fa-solid fa-star'></i>";                
            }else if(intval($rate)==3){
                $rtval="<i class='fa-solid fa-star'></i> <i class='fa-solid fa-star'></i> <i class='fa-solid fa-star'></i> ";                
            }else if(intval($rate)==2){
                $rtval="<i class='fa-solid fa-star'></i> <i class='fa-solid fa-star'>";                
            }else if(intval($rate)==1){
                $rtval="<i class='fa-solid fa-star'></i> ";                
            }

            $outrate.="
                            <div>
                                <p id='up'> <i class='fa-solid fa-circle-user'></i> <span> $name </span> </p>
                                <p id='md'> $rtval </p>

                                <p id='dw'> $rev </p>
                            </div>
                            <hr>            
            ";

            
        }

        $rt=round($rt/$cnt,2);
    }else{
        $outrate.="";
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

    <div id="customAlert">
        <p id="alertMessage"></p>
    </div>
    
    <main>

        <section class="details">

            <div class="left">
                <div class="pics">
                    <p onclick="imgone('productImgs/<?php echo $img1 ?>')"><?php echo"<img src='productImgs/$img1'>";?></p>
                    <p onclick="imgtwo('productImgs/<?php echo $img2 ?>')"><?php echo"<img src='productImgs/$img2'>";?></p>
                    <p onclick="imgthree('productImgs/<?php echo $img3 ?>')"><?php echo"<img src='productImgs/$img3'>";?></p>
                </div>

                <div class="frame">
                    <?php echo"<img id='frameimg' src='productImgs/$img1'>";?>
                </div>

                <?php
                
                    if($save=="false"){
                        echo"<a href='productinfo.php?save=$prdinfo'><i class='fa-regular fa-bookmark'></i></a>";
                    }else{
                        echo"<a href='productinfo.php?unsave=$prdinfo'><i class='fa-solid fa-bookmark'></i></a>";
                    }
                
                ?>
            </div>

            <div class="right">
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                    <p id="brand"><?php echo $brand;?></p>
                    <p id="name"><?php echo $pname;?></p>
                    <p id="special">Special Price</p>

                    <p id="prices"><span id="acp">$<?php echo $acp;?></span><span id="rp">$<?php echo $price;?></span><span id="dis"><?php echo $discount;?>% off</span></p>

                    <p id="size">Available Sizes</p>
                    <p><select name="selectedsize" required>
                            <option value="">Size</option>
                            <?php echo $output;?>
                        </select>
                    </p>

                    <p id="desc">Description</p>
                    <p id="msg"><?php echo $desc;?></p>

                    <p id="size">In Stock ? <span id="stock"><?php echo $instock?></span></p>
                    <p id="desc">Rating & Review </p>

                    <p><span id="rate"> 
                        
                        <?php 
                            if ($rt!==0) {
                                echo "$rt <i class='fa-solid fa-star'></i> 
                                </span> <span id='review'> See Reviews <i class='fas fa-caret-down arrow'></i>
                            ";}
                            else{
                                echo "<span style='font-weight: lighter; font-size: small;'>No Rating So Far</span>";
                            }
                            ?>
                        </span>
                    </p>

                    <input type="submit" id="sbmtbtn"  value="Add to Cart" name="add">

                    <div class="reviews hidden">
                        <h4><?php if($outrate!=""){echo "Reviews";}?></h4>

                        <div class="item">
                            <?php echo $outrate; ?>
                        </div>
                    </div>

                    </div>
                </form>
            </div>
        </section>

        <h3 id="relatedheader">Related Products</h3>
        <section class="related">
            <?php echo $out; ?>          
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


        const rev = document.querySelector(".reviews");

        const btn = document.getElementById("review");

        btn.addEventListener("click", function () {
            rev.classList.toggle("hidden");
        });

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

            if (isset($_SESSION['alert_info']) && $_SESSION['alert_info']=="added") {
                unset($_SESSION['alert_info']);
                echo "showAlert('✅ Item Added to Cart');";
            }

            else if (isset($_SESSION['alert_info']) && $_SESSION['alert_info']=="notadded") {
                unset($_SESSION['alert_info']);
                echo "showAlert('⚠️ Error In Adding Item to Cart!');";

            }

            else if (isset($_SESSION['alert_info']) && $_SESSION['alert_info']=="incart") {
                unset($_SESSION['alert_info']);
                echo "showAlert('❗Item Is Already In Cart');";

            }


            else if (isset($_SESSION['alert_info']) && $_SESSION['alert_info']=="saved") {
                unset($_SESSION['alert_info']);
                echo "showAlert('✅ Product Saved');";
            }

            else if (isset($_SESSION['alert_info']) && $_SESSION['alert_info']=="notsaved") {
                unset($_SESSION['alert_info']);
                echo "showAlert('⚠️ Error In Saving Product!');";

            }

            else if (isset($_SESSION['alert_info']) && $_SESSION['alert_info']=="unsaved") {
                unset($_SESSION['alert_info']);
                echo "showAlert('✅ Product Unsaved');";
            }

            else if (isset($_SESSION['alert_info']) && $_SESSION['alert_info']=="notsaved") {
                unset($_SESSION['alert_info']);
                echo "showAlert('⚠️ Error In Unsaving Product!');";

            }

            else if (isset($_SESSION['alert_info']) && $_SESSION['alert_info']=="outstock") {
                unset($_SESSION['alert_info']);
                echo "showAlert('⚠️ This Product Is Out Of Stock!');";

            }
            
            ?>

            
        };
    </script>
</html>