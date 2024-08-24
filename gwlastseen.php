<?php

require "credentials.php";
$gwid=$_GET["gwid"];
ob_end_clean();
ignore_user_abort(true);
ob_start();

$url = 'http://localhost:8080/api/internal/login';
$jsonString = json_encode(array( "password" => "$password","email" => "$username" ));
                      $ch = curl_init();
                      $Timeout = 0; // Set 0 for no Timeout.
                      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                    curl_setopt($ch, CURLOPT_URL, $url);
                      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                      curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonString);
                      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                      'Content-Type: application/json',
                      'Accept: application/json',)
                      );
                    
                      $jwtk = curl_exec($ch);
                      $ch_error = curl_error($ch);
                      if ($ch_error) { 
                          echo "cURL Error: $ch_error"; 
                      } else {
                      }
                      $token = json_decode($jwtk);
                      curl_close($ch);
$url = 'http://testing.siotel.in:8080/api/gateways/'.$gwid;
$ch = curl_init();  
 
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Accept: application/json',
        "Grpc-Metadata-Authorization:$token->jwt",)
        );
    $output=curl_exec($ch);
 $opt=json_decode($output);
$theInfo = curl_getinfo($ch);
$http_code = $theInfo['http_code'];
$inputDate = gmdate("Y-m-d H:i:s");
$lastseen = new DateTime( $opt->lastSeenAt);
$tz = new DateTimeZone('Asia/Kolkata'); // or whatever zone you're after
$lastseen->setTimezone($tz);
$error =( $opt->error);
      header('Content-Type: application/json'); 
      $age = array("LastSeen"=>$lastseen);
if ($http_code=='404') {
  echo $error;
}elseif ($http_code=='200') {
   echo json_encode($age);
}
      header("Connection: close");
      header("Content-Length: " . ob_get_length());
      ob_end_flush();
      flush();
?>