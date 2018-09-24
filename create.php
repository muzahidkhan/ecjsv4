<?php

include "prod_data.php";
//$pay_load=payload(); 

//echo $pay_load."<br>";
if(!isset($_COOKIE["PHPSESSID"]))
{
  session_start();
}
// generating invoice ID
srand((double)microtime()*10000); 

function gen_id1() 
{ 
    $id = 'A'; 

    for ($i=1; $i<=5; $i++) { 
        if (rand(0,1)) { 
            // letter 
            $id .= chr(rand(65, 90)); 
        } else { 
            // number; 
            $id .= rand(0, 9); 
        } 
    } 
    return $id; 

} 
$newID = gen_id1(); 
$environment="sandbox"; // or production
if ($environment=="production")
{
    $authurl="https://api.paypal.com/v1/oauth2/token";
    $payurl="https://api.paypal.com/v1/payments/payment";
    $username="AZPiB_CBu-BdClDsnw8PynpTU-_fj7nv0DJ5a4sx0Xlo_lehETNld4-P0PujZHlBBJQGt77dBofvfqDR";
    $password="ECVVxZbtAVrf2qf8Mp490DVTmit-aEd6btaA6hHO-Ik2k1g0gh6VAJcA0hOWIbZms_qPnF09VHjHzXnG";
}
else
{
    $authurl="https://api.sandbox.paypal.com/v1/oauth2/token";
    $payurl="https://api.sandbox.paypal.com/v1/payments/payment";
    $username="AbbffcE40zN4jTzseb_MEfzEmSHUGJQecC5ei9PNdE4bnft3mpOoTEc35JAkcuANnq5JU70yeUsTtAId";
    $password="EHh1enq26E2Y2kWx1JL9yDKGZLo0z8BaeHXbcIHWhCL79SJzlxqiXLmeEuzljwzGx6Tz0VcpcO7RqAdE";
}


//initiating the curl calls to get access token
$live="";
$curl = curl_init();




curl_setopt_array($curl, array(
  CURLOPT_URL => $authurl,
  CURLOPT_USERPWD=> $username.":".$password,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "grant_type=client_credentials&response_type=token&return_authn_schemes=true",
  CURLOPT_HTTPHEADER => array(
    "Cache-Control: no-cache",
    "Content-Type: application/x-www-form-urlencoded"
    
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  //echo $response;
  $data = json_decode($response, TRUE);
  $accesstoken=$data['access_token'];
  //echo $accesstoken."<BR>";
  
  $authorization = "Authorization: Bearer ".$accesstoken;
  
}

//create the payload
$soft_descriptor="My Ventures";
$intent="sale";
$currency="INR";
$shipping="0.03";
$handling_fee="1.00";
$shipping_discount="-1.00";
$insurance="0.01";
$tax="0.07";
$total="30.11";
$subtotal="30.00";
$product_name="test prod1";
$product_price="30.00";
$return_url="http://192.168.64.2/execute_payment.php";
$cancel_url="http://192.168.64.2/cancel_url.php";



$pay_load= "{\r\n  \"intent\": \"$intent\",
    \r\n  \"payer\": {\r\n    \"payment_method\": \"paypal\"\r\n  },
    \r\n  \"transactions\": [\r\n {\r\n \"amount\": {\r\n  \"total\": \"$total\",\r\n  \"currency\": \"$currency\",
     \r\n  \"details\": {\r\n \"subtotal\": \"$subtotal\",\r\n  \"tax\": \"$tax\",
     \r\n \"shipping\": \"$shipping\",\r\n  \"handling_fee\": \"$handling_fee\",
     \r\n  \"shipping_discount\": \"$shipping_discount\",\r\n   \"insurance\": \"$insurance\"\r\n }\r\n      
    },
    \r\n \"description\": \"This is the payment transaction description.\",
    \r\n \"custom\": \"My_Dukaan_90048630024435\",\r\n \"invoice_number\": \"MD-'".$newID."'\",
    \r\n \"payment_options\": {\r\n \"allowed_payment_method\": \"INSTANT_FUNDING_SOURCE\"\r\n  },
    \r\n \"soft_descriptor\": \"$soft_descriptor\",
    \r\n \"item_list\": {\r\n   \"items\": [\r\n  {\r\n \"name\": \"hat\",\r\n \"description\": \"Brown color hat\",\r\n   \"quantity\": \"5\",\r\n   \"price\": \"3\",\r\n   \"tax\": \"0.01\",\r\n  \"sku\": \"1\",\r\n \"currency\": \"$currency\"\r\n  },\r\n   {\r\n  \"name\": \"handbag\",\r\n  \"description\": \"Black color hand bag\",\r\n  \"quantity\": \"1\",\r\n   \"price\": \"15\",\r\n  \"tax\": \"0.02\",\r\n  \"sku\": \"product34\",\r\n  \"currency\": \"$currency\"\r\n  }\r\n  ],
    \r\n  \"shipping_address\": {\r\n  \"recipient_name\": \"Hello World\",\r\n \"line1\": \"4thFloor\",\r\n \"line2\": \"unit#34\",\r\n   \"city\": \"Bangalore\",\r\n \"country_code\": \"IN\",\r\n  \"postal_code\": \"562125\",\r\n \"phone\": \"011862212345678\",\r\n  \"state\": \"CA\"\r\n  }\r\n      }\r\n    }\r\n  ],
    \r\n  \"note_to_payer\": \"Contact us for any questions on your order.\",
    \r\n  \"redirect_urls\": {\r\n \"return_url\": \"http://192.168.64.2/restv1/execute_payment.php\",\r\n \"cancel_url\": \"http://192.168.64.2/restv1/cancel_payment.php\"\r\n  }\r\n}";

//initiating the create payment to get approval link
//echo $authorization."<br>";
$_SESSION['atoken']=$accesstoken;
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => $payurl,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS=> $pay_load,
  CURLOPT_HTTPHEADER => array(
    "Cache-Control: no-cache",
    "Content-Type: application/json",
    $authorization
    //"Authorization: Bearer ".$accesstoken 
  ),
));

$response = curl_exec($curl);// JSON response after create payment
$responsearr=json_decode($response,TRUE);
$payid=$responsearr['id'];
echo  '{"paymentID":"'.$payid.'"}';
$err = curl_error($curl);

curl_close($curl);

/* if ($err) {
  echo "cURL Error #:" . $err;
} else {
  $url=json_decode($response,TRUE);
  
  print_r($url);
  echo "<br><br><br><br>";
  $paylinks=$url['links']['0']['href'];
  $redirect=$url['links']['1']['href'];
  $execute=$url['links']['2']['href'];
  echo $paylinks.'<br>'.$execute.'<br>';
  echo '<a href="'.$redirect.'">'.$redirect.' </a>';
  {"paymentID":"PAY-1BT5991582373822ALOUHVTQ"}
} */

?>