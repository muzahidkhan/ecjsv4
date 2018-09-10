<!DOCTYPE HTML>  
<html>
<head>
<style>
.error {color: #FF0000;}
</style>
</head>
<body>



<?php
session_start();

function gen_id() 
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


function payload()
{
$currency=$_GET['currency'];
$shipping=$_GET['shipping'];
$handling_fee=$_GET['handling'];
$shipping_discount=$_GET['shipping_discount'];
$insurance=$_GET['insurance'];
$tax=$_GET['tax'];
$subtotal=$_GET['subtotal'];

srand((double)microtime()*10000); 

 

$invoice_id = gen_id(); 


// $tax="0.07";
// $shipping="0.03";
// $handling_fee="1.00";
// $shipping_discount="-1.00";
// $insurance="0.01";
// $subtotal="30.00";
$total=$subtotal + $tax + $shipping + $handling_fee + $shipping_discount + $insurance;

echo "Currency is : ".$currency."<BR>";
echo "Sub Total=".$subtotal."<BR>";
echo "Total=".$total."<BR><BR><BR><BR><BR><BR>";

$pay_load="{
    transactions: [{
      amount: {
        total: '30.11',
        currency: '".$currency."',
        details: {
          subtotal: '".$subtotal."',
          tax: '".$tax."',
          shipping: '".$shipping."',
          handling_fee: '".$handling_fee."',
          shipping_discount: '".$shipping_discount."',
          insurance: '".$insurance."'
        }
      },
      description: 'The payment transaction description.',
      custom: '90048630024435',
      //invoice_number: '".$invoice_id."', Insert a unique invoice number
      payment_options: {
        allowed_payment_method: 'INSTANT_FUNDING_SOURCE'
      },
      soft_descriptor: 'ECHI5786786',
      item_list: {
        items: [
        {
          name: 'hat',
          description: 'Brown hat.',
          quantity: '5',
          price: '3',
          tax: '0.01',
          sku: '1',
          currency: '".$currency."'
        },
        {
          name: 'handbag',
          description: 'Black handbag.',
          quantity: '1',
          price: '15',
          tax: '0.02',
          sku: 'product34',
          currency: '".$currency."'
        }],
        shipping_address: {
          recipient_name: 'Brian Robinson',
          line1: '4th Floor',
          line2: 'Unit #34',
          city: 'San Jose',
          country_code: 'US',
          postal_code: '95131',
          phone: '011862212345678',
          state: 'CA'
        }
      }
    }],
    note_to_payer: 'Contact us for any questions on your order.'
  })";



return $pay_load;

}

?>