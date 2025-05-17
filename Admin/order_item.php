<?php

session_start();

include("../connection.php");
include("header.php");

if(!isset($_SESSION['admin'])){
    header("Location: ../adminlogin.php");
    exit();     
}

?>

<?php

$output="";

if(isset($_GET['oid'])){

    $oid=$_GET['oid'];

    $qry="select * from order_info where order_id=$oid";

    $res=mysqli_query($con,$qry);

    while($val=mysqli_fetch_array($res)){

        $prds=$val['product_id'];

    }

    $deli=",";

    $array=explode($deli,$prds);
    $len=count($array);
    for($i=0;$i<$len;$i++){
        $str=trim($array[$i]);
         $str=substr($str,0,strlen($str)-1);
        $str=str_replace("(",",",$str);
        $str=str_replace(":",",",$str);

        $arr=explode($deli,$str);

        $pid=$arr[0];
        $qnt=$arr[1];
        $sz=$arr[2];

        computeItem($pid,$qnt,$sz);
    }  
}

function computeItem($pid, $qnt, $sz){
    global $con;
    global $output;

    $qr="select * from product where product_id=$pid";

    $rs=mysqli_query($con,$qr);

    if(mysqli_num_rows($rs)>0){
        while($val=mysqli_fetch_array($rs)){
            $img=$val['img1'];
            $pname=$val['name'];

            $output.="
                            <tr>
                                <td><a href='../productinfo.php?product=$pid'><img src='../productImgs/$img' alt='#productimg' /></a></td>
                                <td>$pname</td>
                                <td>$sz</td>
                                <td>$qnt</td>
                            </tr>
                            <tr><td colspan='4'><hr></td></tr>       
            
            ";
        }
    }else{
            $output.="
                            <tr>
                            <td colspan='4'>Product Not Found, It Might Be Deleted ... </td>
                            </tr>
                            <tr><td colspan='4'><hr></td></tr>       
            
            ";        
    }

}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SHOPIFY | Order Items</title>
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


            <section class="orders">

                <h3>Order Items</h3>

                <section class="carttable">
                    <table border="0">
                        <thead>
                            <tr>
                                <td>Product Image</td>
                                <td>Product Name</td>
                                <td>Size</td>
                                <td>Quantity</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td colspan="4"><hr></td></tr>
                            
                            <?php echo $output; ?>
                        </tbody>
                    </table>

                </section>

            </section>

        </section>


    </main>

</body>

    <script src="../Admin/admjsfile.js"></script>

</html>