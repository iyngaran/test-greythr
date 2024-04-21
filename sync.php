<?php
$id = "6051f64b-02d8-4e31-a5e5-dcdd22c55ca7";//API ID generated from greytHR in API details page
$swipes = file_get_contents("./attendance/swipes.txt");//Batch of swipes, one swipe per line

$private_key = file_get_contents("./attendance/6051f64b-02d8-4e31-a5e5-dcdd22c55ca7.pem");
/*
echo($swipes);
echo(">>>>>>>>>>>>>");
echo($private_key);
*/
$pkeyid = openssl_pkey_get_private($private_key);//Private Key generated from greytHR in API details page

openssl_sign($swipes, $signature, $pkeyid, OPENSSL_ALGO_SHA1);

$data = array(
"id" => $id,
"swipes" => $swipes,
"sign" => base64_encode($signature)
);

$curl = curl_init();
curl_setopt_array($curl, array(
CURLOPT_URL => "http://tousifapisso.greythr.com/v2/attendance/asca/swipes",
CURLOPT_RETURNTRANSFER => true,
CURLOPT_HEADER => true,
CURLOPT_POST => true,
CURLOPT_POSTFIELDS => $data,
CURLOPT_HTTPHEADER => array(
"X-Requested-With: XMLHttpRequest"
)
));

$response = curl_exec($curl);
//Need to test for status 200(Ok) to make sure the request was successful

$err = curl_error($curl);
print_r($response);
print_r($err);
curl_close($curl);
die();
?>