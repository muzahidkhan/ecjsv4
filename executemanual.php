<?php

session_start();
//https://www.amazon.com/?paymentId=PAY-1V3883595B687150PLOJDDCY&token=EC-9Y579957DF990620U&PayerID=JCYYE85S5ABDA

$pID=$_GET["paymentId"];
$payerID=$_GET["PayerID"];
$ectoken=$_GET["token"];
$atoken=$_SESSION['atoken'];

echo $atoken."<br>";
//href : "https://api.sandbox.paypal.com/v1/payments/payment/PAY-76J37599YT873092RLOJBSXY/execute"

$executeURL="https://api.sandbox.paypal.com/v1/payments/payment/".$pID."/execute";

$curl = curl_init();
$authorization = "Authorization: Bearer ".$atoken;
echo $executeURL."<br>";
echo $payerID."<br>";

$payfield='{
  "payer_id": "'.$payerID.'"
}';

curl_setopt_array($curl, array(
  CURLOPT_URL => $executeURL,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => $payfield,
  CURLOPT_HTTPHEADER => array(
    $authorization,
    "Cache-Control: no-cache",
    "Content-Type: application/json"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}


?>