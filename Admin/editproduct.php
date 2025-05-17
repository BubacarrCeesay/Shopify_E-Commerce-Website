
<?php
session_start();
include("header.php");
include("../connection.php");

if(isset($_GET['product'])){
    $pid=$_GET['product'];
    $_SESSION['product']=$pid;
}else{
    $pid=$_SESSION['product'];
}

?>

<?php 

$qry="select * from product where product_id=$pid";
$res=mysqli_query($con,$qry);

while($val=mysqli_fetch_array($res)){
    $pname=$val['name'];
    $desc=$val['description'];
    $size=$val['size'];
    $price=$val['price'];
    $disc=$val['discount'];
    $img1=$val['img1'];
    $img2=$val['img2'];
    $img3=$val['img3'];
    $brand=$val['brand'];
    $category=$val['category'];
    $instock=$val['in_stock'];

    $bq="Select * From brand where brand_id=$brand";

    $br=mysqli_query($con,$bq);

        while($vl=mysqli_fetch_array($br)){
            $bnme=$vl['name'];
        }

    $cq="Select * From category where category_id=$category";

    $cr=mysqli_query($con,$cq);

        while($vl=mysqli_fetch_array($cr)){
            $cnme=$vl['name'];
        }
}


$coutput="";
$boutput="";

$query="Select * From category where category_id!=$category";

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

$qry="Select * From brand where brand_id!=$brand";

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
    $instck=$_POST['instock'];

    $uq="Update product set name='$name',description='$desc',category=$cat,brand=$brd,size='$size',price=$price,discount=$discount, in_stock='$instck' where product_id=$pid";

    $ru=mysqli_query($con,$uq);

    if($ru){
        $_SESSION['alert_info'] = "updated";
    }else{
        $_SESSION['alert_info'] = "notupdated";
    }

    header("Location: editproduct.php");
    exit();  

}

if(isset($_POST['updfirst'])){
    
    if(isset($_FILES['pimg1']) && $_FILES['pimg1']['error'] == 0){

        $img1 = uniqid() . basename($_FILES['pimg1']['name']);

        $qu="Update product set img1='$img1' where product_id=$pid";
        $ru=mysqli_query($con,$qu);

        if($ru){
            move_uploaded_file($_FILES['pimg1']['tmp_name'], "../productImgs/$img1");
            $_SESSION['alert_info'] = "updated";
        }else{
            $_SESSION['alert_info'] = "notupdated";
        }

        header("Location: editproduct.php");
        exit();  
    }
}

if(isset($_POST['updsec'])){
    
    if(isset($_FILES['pimg2']) && $_FILES['pimg2']['error'] == 0){

        $img2 = uniqid() . basename($_FILES['pimg2']['name']);

        $qu="Update product set img2='$img2' where product_id=$pid";
        $ru=mysqli_query($con,$qu);

        if($ru){
            move_uploaded_file($_FILES['pimg2']['tmp_name'], "../productImgs/$img2");
            $_SESSION['alert_info'] = "updated";
        }else{
            $_SESSION['alert_info'] = "notupdated";
        }

        header("Location: editproduct.php");
        exit();  
    }
}

if(isset($_POST['updthrd'])){
    
    if(isset($_FILES['pimg3']) && $_FILES['pimg3']['error'] == 0){

        $img3 = uniqid() . basename($_FILES['pimg3']['name']);

        $qu="Update product set img3='$img3' where product_id=$pid";
        $ru=mysqli_query($con,$qu);

        if($ru){
            move_uploaded_file($_FILES['pimg3']['tmp_name'], "../productImgs/$img3");
            $_SESSION['alert_info'] = "updated";
        }else{
            $_SESSION['alert_info'] = "notupdated";
        }

        header("Location: editproduct.php");
        exit();  
    }
}

if(isset($_GET['del'])){
    $rid=$_GET['del'];

    $dq="delete from rating where rating_id=$rid";
    $rd=mysqli_query($con,$dq);

    if($rd){
        $_SESSION['alert_info'] = "deleted";
    }else{
            $_SESSION['alert_info'] = "notdeleted";
    }

    header("Location: editproduct.php");
    exit();  
}

?>

<?php 

    $outrate="";

    $sql="select * from rating where product_id= $pid";
    $rz=mysqli_query($con,$sql);

    if(mysqli_num_rows($rz)>0){
        while($vl=mysqli_fetch_array($rz)){
            $rid=$vl['rating_id'];
            $cus=$vl['customer_id'];
            $rate=$vl['rate'];
            $rev=$vl['review'];

            $cq="select * from customer where customer_id=$cus";
            $rc=mysqli_query($con,$cq);

            while($vlc=mysqli_fetch_array($rc)){
                $cusname=$vlc['firstname']." ".$vlc['lastname'];
            }
            
            $outrate.="
                            <tr>
                                <td>$cusname</td>
                                <td>$rate</td>
                                <td>$rev</td>
                                <td> 
                                    <a href='editproduct.php?del=$rid' id='delete'><i class='fa-solid fa-trash'></i></a>
                                </td>
                            </tr>              
            ";
        }
    }else{
    $outrate.="
        <tr><td colspan='4'><h3 style='text-align:center;'>No Rating So Far ...</h3></td></tr>
    ";       
    }

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SHOPIFY | Admin - Edit Product</title>
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
        
        <section class="insertprd">

            <h3>EDIT PRODUCT</h3>

                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">

                <label>
                    <span>Product Name : </span><br><input type="text" name="pname" value="<?php echo $pname?>" autocomplete="off"/>
                </label>

                <label>
                    <span>Description : </span> <br><textarea type="text" name="desc" autocomplete="off"><?php echo $desc?></textarea>
                </label>

                <label>
                    <span>Category : </span> <br>
                    <select name="category">
                        <option value="<?php echo $category?>"> <?php echo $cnme?> </option>
                        <?php echo $coutput; ?>
                    </select>
                </label>

                <label>
                    <span>Brand : </span> <br>
                    <select name="brand">
                        <option value="<?php echo $brand?>"> <?php echo $bnme?> </option>
                        <?php echo $boutput; ?>
                    </select>
                </label>

                <label>
                    <span>Size : </span><br><input type="text" name="size" value="<?php echo $size?>" autocomplete="off"/>
                </label>

                <label>
                    <span>Price : </span><br><input type="number" name="price" value="<?php echo $price?>" autocomplete="off"/>
                </label>

                <label>
                    <span>Discount (%) : </span><br><input type="number" name="discount" value="<?php echo $disc?>" autocomplete="off"/>
                </label>

                <label>
                    <span>In Stock : </span> <br>
                    <select name="instock">
                        <option value="<?php echo $instock?>"> <?php echo $instock?> </option>
                        <?php
                            if($instock=="Yes"){
                                echo"<option value='No'> No </option>";
                            }else{
                                echo"<option value='Yes'> Yes </option>";
                            }
                        ?>
                    </select>
                </label>

                <p><input type="submit" name="add" value="Update Product" /></p>

                </form>

            <h4>Product Images</h4>
            <div class="prdimgs">
                <div class="prd">
                    <h5>Image 1(Main)</h5>
                    <img src="../productImgs/<?php echo $img1;?>" />
                    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                        <label>
                            <span>Select Photo : </span><br><input type="file" name="pimg1" required/>
                            <p><input type="submit" name="updfirst" value="Update Image" /></p>
                        </label>
                    </form>
                </div>

                <div class="prd">
                    <h5>Image 2</h5>
                    <img src="../productImgs/<?php echo $img2;?>" />
                    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                        <label>
                            <span>Select Photo : </span><br><input type="file" name="pimg2" required/>
                            <p><input type="submit" name="updsec" value="Update Image" /></p>
                        </label>
                    </form>
                </div>

                <div class="prd">
                    <h5>Image 3</h5>
                    <img src="../productImgs/<?php echo $img3;?>" />
                    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                        <label>
                            <span>Select Photo : </span><br><input type="file" name="pimg3" required/>
                            <p><input type="submit" name="updthrd" value="Update Image" /></p>
                        </label>
                    </form>
                </div>
            </div>

        </section>
        <br><br>
        <section class="viewprd">

            <h3>RATINGS</h3>

            <div class="tablesec">
                <table border="1">
                    <thead>
                        <tr>
                            <td>Customer Name</td>
                            <td>Rating</td>
                            <td>Review</td>
                            <td>Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php echo $outrate; ?>
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
            
          }


            window.onload = function() {

            <?php

            if (isset($_SESSION['alert_info']) && $_SESSION['alert_info']=="updated") {
                unset($_SESSION['alert_info']);
                echo "showAlert('✅ Product Updated Successfully');";
    
            }

            else if (isset($_SESSION['alert_info']) && $_SESSION['alert_info']=="notupdated") {
                unset($_SESSION['alert_info']);
                echo "showAlert('⚠️ Error In Updating Product');";

            }

            else if (isset($_SESSION['alert_info']) && $_SESSION['alert_info']=="deleted") {
                unset($_SESSION['alert_info']);
                echo "showAlert('✅ Rating Deleted');";
    
            }

            else if (isset($_SESSION['alert_info']) && $_SESSION['alert_info']=="notdeleted") {
                unset($_SESSION['alert_info']);
                echo "showAlert('⚠️ Error In Deleting Rating');";

            }
            
            ?>

            
        };
    </script>

    <script src="admjsfile.js"></script>
</html>