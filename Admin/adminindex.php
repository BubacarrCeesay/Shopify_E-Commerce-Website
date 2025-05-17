
<?php

include("../connection.php");
include("header.php");

?>

<?php 

    $qcus="select * from customer";
    $rcus=mysqli_query($con,$qcus);
    $totalcus=mysqli_num_rows($rcus);

    $qprd="select * from product";
    $rprd=mysqli_query($con,$qprd);
    $totalprd=mysqli_num_rows($rprd);

    $qbrd="select * from brand";
    $rbrd=mysqli_query($con,$qbrd);
    $totalbrd=mysqli_num_rows($rbrd);

    $qcat="select * from category";
    $rcat=mysqli_query($con,$qcat);
    $totalcat=mysqli_num_rows($rcat);

    $qord="select * from order_info where order_status='pending'";
    $rord=mysqli_query($con,$qord);
    $totalord=mysqli_num_rows($rord);

    $cord="select * from order_info where order_status='Cancel'";
    $cnord=mysqli_query($con,$cord);
    $totalcn=mysqli_num_rows($cnord);

    $qpy="select * from payment";
    $rpy=mysqli_query($con,$qpy);
    $totalpy=0;

    while($val=mysqli_fetch_array($rpy)){
        $amt=$val['amount'];
        $totalpy=$totalpy + $amt;
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SHOPIFY | Admin - Dashboard</title>
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

    <section class="contents">
        <h1>DASHBOARD</h1>

        <section class="dashboard">
            <div class="info" id="job">
                <div class="num">
                    <a href="resetpassword.php">
                    <h1>
                        <?php echo""; ?>
                    </h1>
                    <br>
                    <h3>Profile</h3>
                </div>
                <div class="icon">
                    <img src="icons/profileicon.jpg" alt=""></a>
                </div>
            </div>
            <div class="info" id="dis">
                <div class="num">
                    <a href="customers.php">
                    <h1>
                        <?php echo"$totalcus"; ?>
                    </h1>
                    <h3> Customers </h3>
                </div>
                <div class="icon">
                    <img src="icons/customersicon.png" alt=""> </a>
                </div>
            </div>
            <div class="info" id="admin">
                <div class="num">
                    <a href="viewproduct.php">
                    <h1>
                        <?php echo"$totalprd"; ?>
                    </h1>
                    <h3>Products</h3>
                </div>
                <div class="icon">
                    <img src="icons/producticon.jpeg" alt=""></a>
                </div>
            </div>
            <div class="info" id="doctor">
                <div class="num">
                    <a href="viewbrand.php">
                    <h1>
                        <?php echo"$totalbrd"; ?>
                    </h1>
                    <h3>Brands</h3>
                </div>
                <div class="icon">
                    <img src="icons/brandicon.jpeg" alt=""></a>
                </div>
            </div>
            <div class="info" id="report">
                <div class="num">
                    <a href="viewcategory.php">
                    <h1>
                        <?php echo"$totalcat"; ?>
                    </h1>
                    <h3>Categories</h3>
                </div>
                <div class="icon">
                    <img src="icons/categoryicon.jpeg" alt=""></a>
                </div>
            </div>
            <div class="info" id="income">
                <div class="num">
                    <a href="payment.php">
                    <h1>
                        <?php echo"$$totalpy"; ?>
                    </h1>
                    <h3>Payments</h3>
                </div>
                <div class="icon">
                <img src="icons/feesicon.png" alt=""></a>
                </div>
            </div>
            <div class="info" id="msg">
                <div class="num">
                    <a href="pendingorder.php">
                    <h1>
                        <?php echo"$totalord"; ?>
                    </h1>
                    <h3>Pending Orders</h3>
                </div>
                <div class="icon">
                    <img src="icons/ordericon.jpeg" alt=""></a>
                </div>
            </div>
            <div class="info" id="dis">
                <div class="num">
                        <a href="cancelorder.php">
                    <h1>
                        <?php echo"$totalcn"; ?>
                    </h1>
                    <h3>Cancel Orders</h3>
                </div>
                <div class="icon">
                    <img src="icons/cancelorder.jpg" alt=""></a>
                </div>
            </div>

        </section>

    </section>


</body>
    <script src="admjsfile.js"></script>
</html>