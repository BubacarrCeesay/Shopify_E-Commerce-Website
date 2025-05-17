
<?php
session_start();
include("header.php");
include("../connection.php");

if(isset($_GET['category'])){
    $bid=$_GET['category'];
    $_SESSION['category']=$bid;
}else{
    $bid=$_SESSION['category'];
}
?>

<?php

$qry="Select * from category where category_id=$bid";
$res=mysqli_query($con,$qry);

if(mysqli_num_rows($res)>0){

    while($val=mysqli_fetch_array($res)){
        $bname=$val['name'];
    }

}

?>

<?php 

if(isset($_POST['update'])){
    $newnm=$_POST['bname'];

    $qr="update category set name='$newnm' where category_id=$bid";
    $rs=mysqli_query($con,$qr);

    if($rs){
        $_SESSION['alert_info'] = "updated";
    }else{
        $_SESSION['alert_info'] = "notupdated";
    }

    header("Location: editcategory.php");
    exit();    
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SHOPIFY | Admin - Edit Category</title>
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
        
        <section class="editbc">

            <h3>EDIT CATEGORY</h3>

            <div>

                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">

                    <label>
                        <p>Category Name : </p><input type="text" value="<?php echo $bname;  ?>" name="bname" autocomplete="off">
                    </label>

                    <input id="sbmtbtn" type="submit" name="update" value="Save Changes"/>

                </form>

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
                echo "showAlert('✅ Category Updated Successfully');";
    
            }

            else if (isset($_SESSION['alert_info']) && $_SESSION['alert_info']=="notupdated") {
                unset($_SESSION['alert_info']);
                echo "showAlert('⚠️ Error In Updating Category');";

            }
            
            ?>

            
        };
    </script>

    <script src="admjsfile.js"></script>
</html>