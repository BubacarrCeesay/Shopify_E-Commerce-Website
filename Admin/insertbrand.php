
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

$output="";
$cnt=1;

$query="Select * From brand order by name";

$res=mysqli_query($con,$query);

if(mysqli_num_rows($res)>0){
    while($val=mysqli_fetch_array($res)){
        $output.="
        <tr>
            <td>$cnt.</td>
            <td> ".$val['name']."</td>
        </tr>
        ";
        $cnt=$cnt + 1;
    }
}else{
        $output.="
        <tr>
            <td colspan=2>Brand Is Empty</td>
        </tr>
        ";    
}

?>

<?php

if(isset($_POST['add'])){

    $name=ucfirst($_POST['name']);

    $cq="select * from brand";

    $cr=mysqli_query($con,$cq);

    if(mysqli_num_rows($cr)>0){

        $pr=1;

        while($cval=mysqli_fetch_array($cr)){
            if($cval['name'] == $name){
                $pr=0;
            }
        }

        if($pr==0){
            $_SESSION['alert_info'] = "present";
        }else{

            $qr="Insert into brand (name) values ('$name')";

            $rs=mysqli_query($con,$qr);

            if($rs){
                $_SESSION['alert_info'] = "added";
        
            }else{
                $_SESSION['alert_info'] = "notadded";
            }

        }

    } else{

        $qr="Insert into brand (name) values ('$name')";

        $rs=mysqli_query($con,$qr);

        if($rs){
            $_SESSION['alert_info'] = "added";
    
        }else{
            $_SESSION['alert_info'] = "notadded";
        }


    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SHOPIFY | Admin - Insert Brand</title>
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
        
        <section class="insert">

            <div class="left">
                <h3>INSERT BRAND </h3>

                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">

                <label>
                    <span>Brand : </span><input type="text" name="name" placeholder="Enter Brand Name" autocomplete="off"/>
                </label>

                <p><input type="submit" name="add" value="Add Brand" /></p>

                </form>
            </div>

            <div class="right">
                <h3> Current Brands </h3>

                <table border="1">
                    <thead>
                        <tr>
                            <td>Sr. No.</td>
                            <td> Name </td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php echo $output; ?>
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
            
            window.location.href="insertbrand.php";

          }


            window.onload = function() {

            <?php

            if (isset($_SESSION['alert_info']) && $_SESSION['alert_info']=="added") {
                unset($_SESSION['alert_info']);
                echo "showAlert('✅ Brand Inserted Successfully!');";
            }

            else if (isset($_SESSION['alert_info']) && $_SESSION['alert_info']=="notadded") {
                echo "showAlert('⚠️ Error In Inserting Brand!');";
                unset($_SESSION['alert_info']);

            }

            else if (isset($_SESSION['alert_info']) && $_SESSION['alert_info']=="present") {
                echo "showAlert('⚠️ Brand name already exist!');";
                unset($_SESSION['alert_info']);

            }
            
            ?>

            
        };
    </script>
    <script src="admjsfile.js"></script>
</html>