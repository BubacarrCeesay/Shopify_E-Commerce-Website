
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

$qry="Select * from advert";
$res=mysqli_query($con,$qry);

if(mysqli_num_rows($res)>0){

    while($val=mysqli_fetch_array($res)){
        $aid=$val['advert_id'];
        $link=$val['link'];
        $img=$val['image'];

        $output.="
                        <tr>
                            <td><img src='../imgs/$img' alt='#'/></td>
                            <td>$link</td>
                            <td>
                                <a href='advandcon.php?adel=$aid' id='delete'><i class='fa-solid fa-trash'></i></a>
                            </td>
                        </tr>              
        ";
    }

}else{

    $output.="
        <tr><td colspan='3'><h3 style='text-align:center;'>Advert Is Empty</h3></td></tr>
    ";
}


$outputmsg="";

$qry="Select * from contact";
$res=mysqli_query($con,$qry);

if(mysqli_num_rows($res)>0){

    while($val=mysqli_fetch_array($res)){
        $cid=$val['id'];
        $name=$val['name'];
        $email=$val['email'];
        $msg=$val['message'];
        $date=$val['date'];

        $date=substr($date,0,16);

        $outputmsg.="
                        <tr>
                            <td>$name</td>
                            <td>$email</td>
                            <td>$msg</td>
                            <td>$date</td>
                            <td>
                                <a href='advandcon.php?msgdel=$cid' id='delete'><i class='fa-solid fa-trash'></i></a>
                            </td>
                        </tr>              
        ";
    }

}else{

    $outputmsg.="
        <tr><td colspan='3'><h3 style='text-align:center;'>Contact Is Empty</h3></td></tr>
    ";
}




?>

<?php

if(isset($_POST['add'])){

    $link=$_POST['link'];

    if( isset($_FILES['img']) && $_FILES['img']['error'] == 0){

        $img = uniqid() . basename($_FILES['img']['name']);

        $addq="INSERT INTO advert(image, link) VALUES('$img','$link')";

        $addres=mysqli_query($con,$addq);

        if($addres){

            move_uploaded_file($_FILES['img']['tmp_name'], "../imgs/$img");

            $_SESSION['alert_info'] = "added";


        }else{
            $_SESSION['alert_info'] = "notadded";
        }

    }
    else{
        $_SESSION['alert_info'] = "imgerror";
    }

}

if(isset($_GET['adel'])){

    $id=$_GET['adel'];

        $addq="delete from advert where advert_id=$id";

        $addres=mysqli_query($con,$addq);

        if($addres){

            $_SESSION['alert_info'] = "deleted";

        }else{
            $_SESSION['alert_info'] = "notdeleted";
        }


            header("Location: advandcon.php");
            exit();  
}

if(isset($_GET['msgdel'])){

    $id=$_GET['msgdel'];

        $addq="delete from contact where id=$id";

        $addres=mysqli_query($con,$addq);

        if($addres){

            $_SESSION['alert_info'] = "deletedmsg";

        }else{
            $_SESSION['alert_info'] = "notdeletedmsg";
        }


            header("Location: advandcon.php");
            exit();  
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SHOPIFY | Admin - Adverts and Contact </title>
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

            <h3>INSERT ADVERT</h3>

                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">

                <label>
                    <span>Advert Image : </span><br><input type="file" name="img" required/>
                </label>

                <label>
                    <span>Link : </span><br><input type="text" name="link" placeholder="Enter Advert Link" autocomplete="off" required/>
                </label>

                <p><input type="submit" name="add" value="Add Advert" /></p>

                </form>

        </section>
        <br><br><br>
        <section class="viewprd">

            <h3>VIEW ADVERTS</h3>

            <div class="tablesec">
                <table border="1">
                    <thead>
                        <tr>
                            <td>Advert Image</td>
                            <td>Link</td>
                            <td>Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php echo $output; ?>
                    </tbody>
                </table>

            </div>
            
        </section>

        <br><br><br>
        <section class="viewprd">

            <h3>WEBSITE CONTACT FORM</h3>

            <div class="tablesec">
                <table border="1">
                    <thead>
                        <tr>
                            <td>Name</td>
                            <td>Email</td>
                            <td>Message</td>
                            <td>Date</td>
                            <td>Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php echo $outputmsg; ?>
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
            
          
            window.location.href="advandcon.php";
          }


            window.onload = function() {

            <?php

            if (isset($_SESSION['alert_info']) && $_SESSION['alert_info']=="added") {
                unset($_SESSION['alert_info']);
                echo "showAlert('✅ Advert Inserted Successfully!');";
            }

            else if (isset($_SESSION['alert_info']) && $_SESSION['alert_info']=="notadded") {
                echo "showAlert('⚠️ Error In Inserting Advert!');";
                unset($_SESSION['alert_info']);

            }



            else if (isset($_SESSION['alert_info']) && $_SESSION['alert_info']=="imgerror") {
                echo "showAlert('⚠️ Error In Uploading Advert Images!');";
                unset($_SESSION['alert_info']);

            }

            else if (isset($_SESSION['alert_info']) && $_SESSION['alert_info']=="deleted") {
                unset($_SESSION['alert_info']);
                echo "showAlert('✅ Advert Deleted Successfully!');";
            }

            else if (isset($_SESSION['alert_info']) && $_SESSION['alert_info']=="notdeleted") {
                echo "showAlert('⚠️ Error In Deleting Advert!');";
                unset($_SESSION['alert_info']);

            }

            else if (isset($_SESSION['alert_info']) && $_SESSION['alert_info']=="deletemsg") {
                unset($_SESSION['alert_info']);
                echo "showAlert('✅ Message Deleted Successfully!');";
            }

            else if (isset($_SESSION['alert_info']) && $_SESSION['alert_info']=="notdeletedmsg") {
                echo "showAlert('⚠️ Error In Deleting Message!');";
                unset($_SESSION['alert_info']);

            }
            
            ?>

            
        };
    </script>

    <script src="admjsfile.js"></script>
</html>