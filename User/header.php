
<?php


$user=$_SESSION['user'];

$qry="select * from customer where customer_id=$user";

$res=mysqli_query($con,$qry);

while($val=mysqli_fetch_array($res)){
    $fname=$val['firstname'];
    $prof=$val['profile'];
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="website icon" type="" href="../Logo.png" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
      integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
</head>
<body>



        <header>

            <div class="left">
                <a href="../index.php"><img src="Logo.png" alt="Logo"/></a>
                <div class="login">

                </div>

                
                <i id="navShow" class="fa-solid fa-bars"></i>

            </div>


            <div class="right">

                <span>
                    <a href="../index.php"><h4>Home</h4></a>
                    <a href="../contact.php"><h4>Contact</h4></a>
                    <a href="../about.php"><h4>About</h4></a>
                </span>


            </div>

        </header>

    <nav class="upnav">
        <div class="left">
        </div>

        <div class="right">
            <div class="lft">
                <span id="tognav"><i class="fa-solid fa-bars"></i></span>
            </div>
                
            <div class="rgh">
                <a href="../logout.php"><i class="fa-solid fa-right-from-bracket"></i></a>
            </div>
        </div>
    </nav>

    <nav class="sidenav">
        <div class="up">

            <p><i class="fa-solid fa-circle-dot"></i> Hello, <span><?php echo $fname;?></span></p>

            <?php echo"<img src='profileimg/$prof' alt='profile'/>";?>

            <hr>

        </div>

        <div class="down">
            <a href="userindex.php"><p> <i class="fa-solid fa-arrows-to-dot"></i> Pending Orders </p></a>
            <a href="pastorder.php"><p> <i class="fa-solid fa-arrows-to-dot"></i> Past Orders </p></a>
            <a href="saveproduct.php"><p> <i class="fa-solid fa-arrows-to-dot"></i> Saved Products </p></a>
            <a href="editprofile.php"><p> <i class="fa-solid fa-arrows-to-dot"></i> Edit Profile </p></a>
            <a href="resetpassword.php"><p> <i class="fa-solid fa-arrows-to-dot"></i> Reset Password </p></a>
            <a href="../logout.php"><p> <i class="fa-solid fa-arrows-to-dot"></i> Logout </p></a>
        </div>

    </nav>

</body>

</html>