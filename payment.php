<?php

$user=$_SESSION['user'];


$qct="select * from cart where user='$user'";

$rct=mysqli_query($con,$qct);

$cart_num=mysqli_num_rows($rct);

$cart_amt=0;

$totalp=0;


if($cart_num>0){

    while($cv=mysqli_fetch_array($rct)){
        $prd=$cv['product_id'];
        $qnt=$cv['quantity'];
        $size=$cv['size'];

        $qp="select * from product where product_id=$prd";

        $rp=mysqli_query($con,$qp);

        while($pv=mysqli_fetch_array($rp)){
            $prs=$pv['price'];
            $dis=$pv['discount'];
            $img=$pv['img1'];
            $pname=$pv['name'];
            $totalp=$totalp + ($prs * $qnt);

            $pz=round($prs-($dis / 100 * $prs));

            $cart_amt= $cart_amt + ($pz * $qnt);


        }

    }
}


?>

<?php

if(isset($_POST['submit'])){

    $select=$_POST['payment'];

    if($select=="cash"){
        cashOrder();
    }

    else if($select=="paypal"){
        header("Location: paypal.php");
        exit();
    }

    else if($select=="upi"){
        upiPayment();
    }
}

    
function cashOrder(){

    $user=$_SESSION['user'];

    $method="Cash On Delivery";

    global $con;

    $invoice_no=mt_rand();

    $qct="select * from cart where user='$user'";

    $rct=mysqli_query($con,$qct);

    $cart_num=mysqli_num_rows($rct);

    $cart_amt=0;

    $totalp=0;

    $product_ids="";

    if($cart_num>0){

        while($cv=mysqli_fetch_array($rct)){
            $prd=$cv['product_id'];
            $qnt=$cv['quantity'];
            $size=$cv['size'];

            $product_ids.=",".$prd."($qnt:$size)";

            $qp="select * from product where product_id=$prd";

            $rp=mysqli_query($con,$qp);

            while($pv=mysqli_fetch_array($rp)){

                $prs=$pv['price'];
                $dis=$pv['discount'];

                $totalp=$totalp + ($prs * $qnt);

                $pz=round($prs-($dis / 100 * $prs));

                $cart_amt= $cart_amt + ($pz * $qnt);

            }
        }

    }

    $product_ids=substr($product_ids,1);

    $qry="INSERT INTO order_info(customer_id, amount, invoice_no, total_product, product_id, order_date,payment_method) VALUES ('$user',$cart_amt,'$invoice_no',$cart_num,'$product_ids',NOW(),'$method')";

    $res=mysqli_query($con,$qry);

    $suc="success";

    if($res){
        header("Location: successord.php");
        exit();

    }else{
        $_SESSION['alert_info']=="notorder";

        header("Location: payment.php");
        exit();
    }

}

function upiPayment(){
    global $user;
    global $cart_amt;
    $rps=$cart_amt * 83;

    $merchantId = 'PGTESTPAYUAT';
    $apiKey="099eb0cd-02cf-4e2a-8aca-3e6c6aff0399";
    $keyIndex=1;

    $txid= uniqid();

    $paymentData = array(
        'merchantId' => $merchantId,
        'merchantTransactionId' => $txid,
        "merchantUserId"=>"MUID123",
        'amount' => $rps,
        'redirectUrl'=>"http://localhost/E-Commerce/successord.php",
        'redirectMode'=>"POST",
        'callbackUrl'=>"http://localhost/E-Commerce/successord.php",
        "merchantOrderId"=> "UPI".$txid,
    "mobileNumber"=>"9999999999",
    "message"=>"Payment Of $$cart_amt (Rs. $rps)",
    "email"=>"testPay@gmail.com",
    "shortName"=>"CUSTMER ".$user,
    "paymentInstrument"=> array(    
        "type"=> "PAY_PAGE",
    )
    );

 
    $jsonencode = json_encode($paymentData);
    $payloadMain = base64_encode($jsonencode);

 
    $payload = $payloadMain . "/pg/v1/pay" . $apiKey;
    $sha256 = hash("sha256", $payload);
    $final_x_header = $sha256 . '###' . $keyIndex;
    $request = json_encode(array('request'=>$payloadMain));

    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => "https://api-preprod.phonepe.com/apis/pg-sandbox/pg/v1/pay",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $request,
        CURLOPT_HTTPHEADER => [
            "Content-Type: application/json",
            "X-VERIFY: " . $final_x_header,
            "accept: application/json"
        ],
    ]);

    
    $response = curl_exec($curl);
    $err = curl_error($curl);
    
    curl_close($curl);
    
    if ($err) {
    echo "cURL Error #:" . $err;
    } else {
    $res = json_decode($response);
    print_r($res);
    if(isset($res->success) && $res->success=='1'){
    $paymentCode=$res->code;
    $paymentMsg=$res->message;
    $payUrl=$res->data->instrumentResponse->redirectInfo->url;
    
    //header('Location:'.$payUrl) ;
    }
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SHOPIFY | Payment Methods </title>
        <link rel="website icon" type="" href="Logo.png" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
      integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    
    <main>

        <header>

            <div class="left">
                <a href="index.php"><img src="Logo.png" alt="Logo"/></a>
                <div class="login">

                </div>

                
                <i id="navShow" class="fa-solid fa-bars"></i>

            </div>


            <div class="right">

                <span>
                    <a href="index.php"><h4>Home</h4></a>
                    <a href="contact.php"><h4>Contact</h4></a>
                    <a href="about.php"><h4>About</h4></a>
                </span>


            </div>

        </header>

        <div id="customAlert">
            <p id="alertMessage"></p>
        </div>

        <section class="payment">
            <div class="info">
                <h3>Select Payment Method</h3>
                <br>
                <form method='post'>
                    <label>
                        <input type="radio" name="payment" value="cash" required><p>Cash On Delivery</p>
                    </label>

                    <label>
                        <input type="radio" name="payment" value="paypal" required><p>PayPal</p>
                    </label>

                    <label>
                        <input type="radio" name="payment" value="upi" required><p>UPI / Card Payment</p>
                    </label>
                    <br>
                    <p id="sbtbtn"><input type="submit" name="submit" value="Proceed"></p>
                </form>
            </div>

        <div id="paypal-button-container"></div>
        <p id="result-message"></p>
            
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

            if (isset($_SESSION['alert_info']) && $_SESSION['alert_info']=="success") {
                unset($_SESSION['alert_info']);
                echo "showAlert('✅ Login Successful');";
    
            }

            else if (isset($_SESSION['alert_info']) && $_SESSION['alert_info']=="notorder") {
                unset($_SESSION['alert_info']);
                echo "showAlert('⚠️ Error In Processing Order');";

            }
            
            ?>

            
        };
    </script>
</html>