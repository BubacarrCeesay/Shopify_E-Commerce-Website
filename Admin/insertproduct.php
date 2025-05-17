
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

if(isset($_POST['add'])){

    $name=$_POST['pname'];
    $desc=$_POST['desc'];
    $cat=$_POST['category'];
    $brd=$_POST['brand'];
    $size=$_POST['size'];
    $price=$_POST['price'];
    $discount=$_POST['discount'];

    if( isset($_FILES['pimg1']) && $_FILES['pimg1']['error'] == 0 && 
        isset($_FILES['pimg2']) && $_FILES['pimg2']['error'] == 0 && 
        isset($_FILES['pimg3']) && $_FILES['pimg3']['error'] == 0){

        $img1 = uniqid() . basename($_FILES['pimg1']['name']);
        $img2 = uniqid() . basename($_FILES['pimg2']['name']);
        $img3 = uniqid() . basename($_FILES['pimg3']['name']);


        $addq="INSERT INTO product(name, description, category, brand, img1, img2, img3, size, price, discount) VALUES('$name','$desc','$cat','$brd','$img1','$img2','$img3','$size','$price','$discount')";

        $addres=mysqli_query($con,$addq);

        if($addres){

            move_uploaded_file($_FILES['pimg1']['tmp_name'], "../productImgs/$img1");
            move_uploaded_file($_FILES['pimg2']['tmp_name'], "../productImgs/$img2");
            move_uploaded_file($_FILES['pimg3']['tmp_name'], "../productImgs/$img3");

            $_SESSION['alert_info'] = "added";


        }else{
            $_SESSION['alert_info'] = "notadded";
        }

    }
    else{
        $_SESSION['alert_info'] = "imgerror";
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SHOPIFY | Admin - Insert Product</title>
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
        
        <section class="insertprd">

            <h3>INSERT PRODUCT</h3>

                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">

                <label>
                    <span>Product Name : </span><br><input type="text" name="pname" placeholder="Enter Product Name" autocomplete="off" required/>
                </label>

                <label>
                    <span>Description : </span> <br><textarea type="text" name="desc" placeholder="Enter Product Description" autocomplete="off" required></textarea>
                </label>

                <label>
                    <span>Category : </span> <br>
                    <select name="category" required>
                        <option value=""> Select Category </option>

                        <?php echo $coutput; ?>

                    </select>
                </label>

                <label>
                    <span>Brand : </span> <br>
                    <select name="brand">
                        <option value=""> Select Brand </option>

                        <?php echo $boutput; ?>

                    </select>
                </label>

                <label>
                    <span>Product Image - 1 (Main) : </span><br><input type="file" name="pimg1" required/>
                </label>

                <label>
                    <span>Product Image - 2 : </span><br><input type="file" name="pimg2" required/>
                </label>

                <label>
                    <span>Product Image - 3 : </span><br><input type="file" name="pimg3" required/>
                </label>

                <label>
                    <span>Size : </span><br><input type="text" name="size" placeholder="Enter Product Size" autocomplete="off" required/>
                </label>

                <label>
                    <span>Price : </span><br><input type="number" name="price" placeholder="Enter Product Price" autocomplete="off" required/>
                </label>

                <label>
                    <span>Discount (%) : </span><br><input type="number" name="discount" placeholder="Enter Product Discount" autocomplete="off" required/>
                </label>

                <p><input type="submit" name="add" value="Add Product" /></p>

                </form>

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
            
            ?>

            
        };
    </script>

    <script src="admjsfile.js"></script>
</html>