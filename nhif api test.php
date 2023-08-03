<?php
$curl = curl_init();
curl_setopt_array($curl, array(
 CURLOPT_URL => "196.13.105.15/omrs/stsidentity",
 CURLOPT_RETURNTRANSFER => true,
 CURLOPT_ENCODING => "",
 CURLOPT_MAXREDIRS => 10,
 CURLOPT_TIMEOUT => 0,
 CURLOPT_FOLLOWLOCATION => true,
 CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
 CURLOPT_CUSTOMREQUEST => "POST",
 CURLOPT_POSTFIELDS =>
"grant_type=client_credentials&client_id=NHIF&password=Nhif@2020&client_secret=
fab035ac-25ae-967c-c3f6-b9c642d82be5&scope=OMRS",
 CURLOPT_HTTPHEADER => array(
 "Content-Type: application/x-www-form-urlencoded"
 ),
));
$response = curl_exec($curl);
curl_close($curl);
echo $response;