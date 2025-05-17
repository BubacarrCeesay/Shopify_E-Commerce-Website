<?php

session_start();

include("../connection.php");
include("header.php");

if(isset($_GET['prd'])){

    $pid=$_GET['prd'];

    $_SESSION['product']=$pid;

}


?>

<?php

if(isset($_POST['submit'])){

    $rate=intval($_POST['rating']);

    $rev=$_POST['review'];

    if($rev==""){
        $rev="NA";
    }

    $user=intval($_SESSION['user']);

    $prd=intval($_SESSION['product']);

    $sql="INSERT INTO rating(customer_id, product_id, rate, review) VALUES ('$user','$prd',$rate,'$rev')";

    $qry=mysqli_query($con,$sql);

    if($qry){
        $_SESSION['alert_info']="success";
    }else{
        $_SESSION['alert_info']="notsuccess";
    }

    header("Location: ordered_items.php");
    exit();

}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SHOPIFY | Rate Product </title>
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

            <section class="rate">

                <div class="info">
                    <h2>Product Rating</h2>

                    <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">

                        <label>
                            <input type="radio" name="rating" value="5" required> 5 - <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i> <i class="fa-solid fa-star"></i> <i class="fa-solid fa-star"></i> <i class="fa-solid fa-star"></i>
                        </label>
                        <label>
                            <input type="radio" name="rating" value="4" required> 4 - <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i> <i class="fa-solid fa-star"></i> <i class="fa-solid fa-star"></i>
                        </label>
                        <label>
                            <input type="radio" name="rating" value="3" required> 3 - <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"> </i> <i class="fa-solid fa-star"></i>
                        </label>

                        <label>
                            <input type="radio" name="rating" value="2" required> 2 - <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </label>

                        <label>
                            <input type="radio" name="rating" value="1" required> 1 - <i class="fa-solid fa-star"></i>
                        </label>

                        <label>
                            <textarea name="review" maxlength="100" placeholder="Type Review (Max 100 Characters)"></textarea>
                        </label>

                        <span><input type="submit" name="submit" value="Submit"></span>

                    </form>

                </div>

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