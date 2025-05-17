
<?php
session_start();
include("header.php");
include("../connection.php");

if(!isset($_SESSION['admin'])){
    header("Location: ../adminlogin.php");
    exit();     
}

$coutput="";
$boutput="";

$query="Select * From category order by name";

$res=mysqli_query($con,$query);

if(mysqli_num_rows($res)>0){
    while($val=mysqli_fetch_array($res)){
        $cid=$val['category_id'];
        $cname=$val['name'];
        $coutput.="
            <option value='$cid'> $cname </option>
        ";
    }
}

$qry="Select * From brand order by name";

$rs=mysqli_query($con,$qry);

if(mysqli_num_rows($rs)>0){
    while($vl=mysqli_fetch_array($rs)){
        $bid=$vl['brand_id'];
        $bname=$vl['name'];
        $boutput.="
            <option value='$bid'> $bname </option>
        ";
    }
}


?>

<?php

$output="";

$qry="Select * from product";
$res=mysqli_query($con,$qry);

if(mysqli_num_rows($res)>0){

    while($val=mysqli_fetch_array($res)){
        $pid=$val['product_id'];
        $pname=$val['name'];
        $img=$val['img1'];
        $prc=$val['price'];
        $dis=$val['discount'];
        $instock=$val['in_stock'];

        $output.="
                        <tr>
                            <td>$pid</td>
                            <td>$pname</td>
                            <td><img src='../productImgs/$img' alt='productimg'/></td>
                            <td>$$prc</td>
                            <td>$dis%</td>
                            <td>$instock</td>
                            <td style='min-width:90px;'>
                                <a href='editproduct.php?product=$pid' id='edit'><i class='fa-solid fa-pen-to-square'></i></a> 
                                <a href='viewproduct.php?del=$pid' id='delete'><i class='fa-solid fa-trash'></i></a>
                            </td>
                        </tr>              
        ";
    }

}else{

    $output.="
        <tr><td colspan='7'><h3 style='text-align:center;'>No Product Found</h3></td></tr>
    ";
}

?>

<?php 

if(isset($_POST['filter'])){

    if(isset($_POST['brand']) && $_POST['brand']!="" && isset($_POST['category']) && $_POST['category']!=""){


        $brand=$_POST['brand'];
        $cat=$_POST['category'];

        $output="";

        $qry="Select * from product where brand=$brand and category=$cat";
        $res=mysqli_query($con,$qry);

        if(mysqli_num_rows($res)>0){

            while($val=mysqli_fetch_array($res)){
                $pid=$val['product_id'];
                $pname=$val['name'];
                $img=$val['img1'];
                $prc=$val['price'];
                $dis=$val['discount'];

                $output.="
                                <tr>
                                    <td>$pid</td>
                                    <td>$pname</td>
                                    <td><img src='../productImgs/$img' alt='productimg'/></td>
                                    <td>$$prc</td>
                                    <td>$dis%</td>
                                    <td>True</td>
                                    <td>
                                        <a href='editproduct.php?product=$pid' id='edit'><i class='fa-solid fa-pen-to-square'></i></a> 
                                        <a href='#' id='delete'><i class='fa-solid fa-trash'></i></a>
                                    </td>
                                </tr>              
                ";
            }

        }else{

            $output.="
                <tr><td colspan='7'><h3 style='text-align:center;'>No Product Found</h3></td></tr>
            ";
        }

       

    }

    else if(isset($_POST['brand']) && $_POST['brand']!=""){

        $brand=$_POST['brand'];

        $output="";

        $qry="Select * from product where brand=$brand";
        $res=mysqli_query($con,$qry);

        if(mysqli_num_rows($res)>0){

            while($val=mysqli_fetch_array($res)){
                $pid=$val['product_id'];
                $pname=$val['name'];
                $img=$val['img1'];
                $prc=$val['price'];
                $dis=$val['discount'];

                $output.="
                                <tr>
                                    <td>$pid</td>
                                    <td>$pname</td>
                                    <td><img src='../productImgs/$img' alt='productimg'/></td>
                                    <td>$$prc</td>
                                    <td>$dis%</td>
                                    <td>True</td>
                                    <td>
                                        <a href='editproduct.php?product=$pid' id='edit'><i class='fa-solid fa-pen-to-square'></i></a> 
                                        <a href='#' id='delete'><i class='fa-solid fa-trash'></i></a>
                                    </td>
                                </tr>              
                ";
            }

        }else{

            $output.="
                <tr><td colspan='7'><h3 style='text-align:center;'>No Product Found</h3></td></tr>
            ";
        }

    }

    else if(isset($_POST['category']) && $_POST['category']!=""){

        $cat=$_POST['category'];

        $output="";

        $qry="Select * from product where category=$cat";
        $res=mysqli_query($con,$qry);

        if(mysqli_num_rows($res)>0){

            while($val=mysqli_fetch_array($res)){
                $pid=$val['product_id'];
                $pname=$val['name'];
                $img=$val['img1'];
                $prc=$val['price'];
                $dis=$val['discount'];

                $output.="
                                <tr>
                                    <td>$pid</td>
                                    <td>$pname</td>
                                    <td><img src='../productImgs/$img' alt='productimg'/></td>
                                    <td>$$prc</td>
                                    <td>$dis%</td>
                                    <td>True</td>
                                    <td>
                                        <a href='editproduct.php?product=$pid' id='edit'><i class='fa-solid fa-pen-to-square'></i></a> 
                                        <a href='#' id='delete'><i class='fa-solid fa-trash'></i></a>
                                    </td>
                                </tr>              
                ";
            }

        }else{

            $output.="
                <tr><td colspan='7'><h3 style='text-align:center;'>No Product Found</h3></td></tr>
            ";
        }


    }

}


if(isset($_GET['del'])){

    $id=$_GET['del'];

        $addq="delete from product where product_id=$id";

        $addres=mysqli_query($con,$addq);

        if($addres){

            $_SESSION['alert_info'] = "deleted";

        }else{
            $_SESSION['alert_info'] = "notdeleted";
        }


            header("Location: viewproduct.php");
            exit();  
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SHOPIFY | Admin - View Product</title>
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
        <button onclick="closeAlert()">OK</button>
    </div>

    <section class="contents">
        
        <section class="viewprd">

            <h3>VIEW PRODUCTS</h3>

            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">

                <div class="field">
                    <select name="brand">
                        <option value="">Select Brand</option>
                        <?php echo $boutput;?>
                    </select>
                </div>

                <div class="field">
                    <select name="category">
                        <option value="">Select Category</option>
                        <?php echo $coutput;?>
                    </select>
                </div>

                <div class="field">
                    <input id="sbtbtn" type="submit" name="filter" value="Filter Products">
                </div>

            </form>

            <div class="tablesec">
                <table border="1">
                    <thead>
                        <tr>
                            <td>Product ID</td>
                            <td>Product Name</td>
                            <td>Product Image</td>
                            <td>Price</td>
                            <td>Discount</td>
                            <td>In-Stock</td>
                            <td>Action</td>
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

            setTimeout(closeAlert,3000);

          }

          function closeAlert() {
            var alertBox = document.getElementById("customAlert");
            alertBox.style.display = "none";
            
          
            window.location.href="insertproduct.php";
          }


            window.onload = function() {

            <?php

            if (isset($_SESSION['alert_info']) && $_SESSION['alert_info']=="added") {
                unset($_SESSION['alert_info']);
                echo "showAlert('✅ Product Inserted Successfully!');";
            }

            else if (isset($_SESSION['alert_info']) && $_SESSION['alert_info']=="notadded") {
                echo "showAlert('⚠️ Error In Inserting Product!');";
                unset($_SESSION['alert_info']);

            }

            else if (isset($_SESSION['alert_info']) && $_SESSION['alert_info']=="imgerror") {
                echo "showAlert('⚠️ Error In Uploading Product Images!');";
                unset($_SESSION['alert_info']);

            }

    
            else if (isset($_SESSION['alert_info']) && $_SESSION['alert_info']=="deleted") {
                unset($_SESSION['alert_info']);
                echo "showAlert('✅ Product Deleted Successfully!');";
            }

            else if (isset($_SESSION['alert_info']) && $_SESSION['alert_info']=="notdeleted") {
                echo "showAlert('⚠️ Error In Deleting Product!');";
                unset($_SESSION['alert_info']);

            }
            
            ?>

            
        };
    </script>

    <script src="admjsfile.js"></script>
</html>