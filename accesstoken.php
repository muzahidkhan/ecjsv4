<?php

$curl = curl_init();
$username="AbbffcE40zN4jTzseb_MEfzEmSHUGJQecC5ei9PNdE4bnft3mpOoTEc35JAkcuANnq5JU70yeUsTtAId";
$password="EHh1enq26E2Y2kWx1JL9yDKGZLo0z8BaeHXbcIHWhCL79SJzlxqiXLmeEuzljwzGx6Tz0VcpcO7RqAdE";

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.sandbox.paypal.com/v1/oauth2/token",
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
  echo $accesstoken."<BR>";
  
  $authorization = "Authorization: Bearer ".$accesstoken;
  
}
//$pfields= "{\r\n  \"intent\": \"sale\",\r\n  \"payer\": {\r\n    \"payment_method\": \"paypal\"\r\n  },\r\n  \"transactions\": [\r\n    {\r\n      \"amount\": {\r\n        \"total\": \"30.11\",\r\n        \"currency\": \"INR\",\r\n        \"details\": {\r\n          \"subtotal\": \"30.00\",\r\n          \"tax\": \"0.07\",\r\n          \"shipping\": \"0.03\",\r\n          \"handling_fee\": \"1.00\",\r\n          \"shipping_discount\": \"-1.00\",\r\n          \"insurance\": \"0.01\"\r\n        }\r\n      },\r\n      \"description\": \"This is the payment transaction description.\",\r\n      \"custom\": \"EBAY_EMS_90048630024435\",\r\n      \"invoice_number\": \"48787589663\",\r\n      \"payment_options\": {\r\n        \"allowed_payment_method\": \"INSTANT_FUNDING_SOURCE\"\r\n      },\r\n      \"soft_descriptor\": \"ECHI5786786\",\r\n      \"item_list\": {\r\n        \"items\": [\r\n          {\r\n            \"name\": \"hat\",\r\n            \"description\": \"Brown color hat\",\r\n            \"quantity\": \"5\",\r\n            \"price\": \"3\",\r\n            \"tax\": \"0.01\",\r\n            \"sku\": \"1\",\r\n            \"currency\": \"INR\"\r\n          },\r\n          {\r\n            \"name\": \"handbag\",\r\n            \"description\": \"Black color hand bag\",\r\n            \"quantity\": \"1\",\r\n            \"price\": \"15\",\r\n            \"tax\": \"0.02\",\r\n            \"sku\": \"product34\",\r\n            \"currency\": \"INR\"\r\n          }\r\n        ],\r\n        \"shipping_address\": {\r\n          \"recipient_name\": \"Hello World\",\r\n          \"line1\": \"4thFloor\",\r\n          \"line2\": \"unit#34\",\r\n          \"city\": \"SAn Jose\",\r\n          \"country_code\": \"US\",\r\n          \"postal_code\": \"95131\",\r\n          \"phone\": \"011862212345678\",\r\n          \"state\": \"CA\"\r\n        }\r\n      }\r\n    }\r\n  ],\r\n  \"note_to_payer\": \"Contact us for any questions on your order.\",\r\n  \"redirect_urls\": {\r\n    \"return_url\": \"http://192.168.64.2/restv1/execute_payment.php\",\r\n    \"cancel_url\": \"http://192.168.64.2/restv1/cancel_payment.php\"\r\n  }\r\n}",
  

// $paymentsfields={
// 
// 
// "intent": "sale",
// "payer": {"payment_method":"paypal" }
// "transactions":{
// "amount":{
//             "total": "30.11",
//             "currency":"INR",
//             "details": {
//                       "subtotal":"30.00",
//                       "tax":"0.07","shipping":"0.03",
//                       "handling_fee":"1.00","shipping_discount": "-1.00",
//                       "insurance": "0.01"
//                        }
//         },
// "description":"This is the payment transaction description",
// "custom": "MY_Custom_90048630024435",
// "invoice_number": "48787589663",
// "payment_options": 
// 		{
// 			"allowed_payment_method": "INSTANT_FUNDING_SOURCE"
// 		},
// "soft_descriptor": "meri dukaan",
// "item_list": 
// 	{
// 	     "items":[
// 	                {
// 	                     "name":"hat",
// 	                     "description":"Brown color hat",
// 	                     "quantity":"5",
// 	                     "price":"3",
// 	                     "tax": "0.01",
// 	                     "sku": "1",
// 	                     "currency": "INR"
// 	                },
// 	                {
// 	                "name":"handbag",
// 	                "description":"Black color hand bag",
// 	                "quantity":"1",
// 	                "price":"15",
// 	                "tax": "0.02",
// 	                "sku": "product34",
// 	                "currency": "INR"
// 	                }
// 	            ],
// 	    "shipping_address": 
// 	           {
// 	                   "recipient_name": "Hello World",
// 	                   "line1": "4thFloor",
// 	                   "line2": "unit#34",
// 	                   "city": "San Jose",
// 	                   "country_code": "US",
// 	                   "postal_code": "95131",
// 	                   "phone":"011862212345678",
// 	                   "state":"CA"
// 	            }
// 	}
//     }
//     ],
//     "note_to_payer":"Contact us for any questions on your order.",
//     "redirect_urls":
//      {
//           "return_url": "http://192.168.64.2/restv1/execute_payment.php",
//           "cancel_url": "http://192.168.64.2/restv1/cancel_payment.php"  
//     }
// };
//   
//}
session_start();
$_SESSION['atoken']=$accesstoken;
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.sandbox.paypal.com/v1/payments/payment",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS =>   "{\r\n  \"intent\": \"sale\",\r\n  \"payer\": {\r\n    \"payment_method\": \"paypal\"\r\n  },\r\n  \"transactions\": [\r\n    {\r\n      \"amount\": {\r\n        \"total\": \"30.11\",\r\n        \"currency\": \"INR\",\r\n        \"details\": {\r\n          \"subtotal\": \"30.00\",\r\n          \"tax\": \"0.07\",\r\n          \"shipping\": \"0.03\",\r\n          \"handling_fee\": \"1.00\",\r\n          \"shipping_discount\": \"-1.00\",\r\n          \"insurance\": \"0.01\"\r\n        }\r\n      },\r\n      \"description\": \"This is the payment transaction description.\",\r\n      \"custom\": \"EBAY_EMS_90048630024435\",\r\n      \"invoice_number\": \"48787589663\",\r\n      \"payment_options\": {\r\n        \"allowed_payment_method\": \"INSTANT_FUNDING_SOURCE\"\r\n      },\r\n      \"soft_descriptor\": \"ECHI5786786\",\r\n      \"item_list\": {\r\n        \"items\": [\r\n          {\r\n            \"name\": \"hat\",\r\n            \"description\": \"Brown color hat\",\r\n            \"quantity\": \"5\",\r\n            \"price\": \"3\",\r\n            \"tax\": \"0.01\",\r\n            \"sku\": \"1\",\r\n            \"currency\": \"INR\"\r\n          },\r\n          {\r\n            \"name\": \"handbag\",\r\n            \"description\": \"Black color hand bag\",\r\n            \"quantity\": \"1\",\r\n            \"price\": \"15\",\r\n            \"tax\": \"0.02\",\r\n            \"sku\": \"product34\",\r\n            \"currency\": \"INR\"\r\n          }\r\n        ],\r\n        \"shipping_address\": {\r\n          \"recipient_name\": \"Hello World\",\r\n          \"line1\": \"4thFloor\",\r\n          \"line2\": \"unit#34\",\r\n          \"city\": \"SAn Jose\",\r\n          \"country_code\": \"US\",\r\n          \"postal_code\": \"95131\",\r\n          \"phone\": \"011862212345678\",\r\n          \"state\": \"CA\"\r\n        }\r\n      }\r\n    }\r\n  ],\r\n  \"note_to_payer\": \"Contact us for any questions on your order.\",\r\n  \"redirect_urls\": {\r\n    \"return_url\": \"http://192.168.64.2/restv1/execute_payment.php\",\r\n    \"cancel_url\": \"http://192.168.64.2/restv1/cancel_payment.php\"\r\n  }\r\n}",  
CURLOPT_HTTPHEADER => array(
    "Cache-Control: no-cache",
    "Content-Type: application/json",
    $authorization
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  $url=json_decode($response,TRUE);
  
  //print_r($url);
  
  $paylinks=$url['links']['0']['href'];
  $redirect=$url['links']['1']['href'];
  $execute=$url['links']['2']['href'];
  echo $paylinks.'<br>'.$execute.'<br>';
  echo '<a href="'.$redirect.'">'.$redirect.' </a>';
   
}

?>