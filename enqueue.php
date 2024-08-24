<?php
// ini_set("display_errors", 1);
if( ( isset($_SERVER['PHP_AUTH_USER'] ) && ( $_SERVER['PHP_AUTH_USER'] == "testuser" ) ) AND
( isset($_SERVER['PHP_AUTH_PW'] ) && ( $_SERVER['PHP_AUTH_PW'] == "xe69GP7k" )) )
{ActionSection();}else
{//Send headers to cause a browser to request
header("WWW-Authenticate: " .
"Basic realm=\"User Protected Area\"");
header("HTTP/1.0 401 Unauthorized");
print("Invalid credentials!");
}
function ActionSection(){ 
date_default_timezone_set('Asia/kolkata');
$downlink_time=date('Y-m-d H:i:s');
$dt = $_GET['data'];
echo "$dt";
if (!empty($dt)) {
require('/var/www/html/conn.php');
require('/var/www/html/loraserverhost.php');
// $token=json_decode(file_get_contents('/var/www/html/token.txt'));
$conn =mysqli_connect("localhost","Nexcity","DBp@ssisthis","SSTPL_UPLINK") or die("could not connect");
$pieces = explode("|", $dt);
$devEUI=$pieces[0];                             //piece[0] is DevEUI
$command=$pieces[1];                            //piece[1] is command
$port=$pieces[2];                               //piece[2] is port
$client_id=$pieces[3];                          //$pieces[3] is Client ID
$pay=str_replace(' ', '', $pieces[1]);
function hex_to_base64($hex){
  $return = '';
  foreach(str_split($hex, 2) as $pair){
    $return .= chr(hexdec($pair));
  }
  return base64_encode($return);
}
if(empty($port)){$port=7;}
 $payload= hex_to_base64($pay);
 // echo "encoded command is : ".$payload; 
 if ($client_id=='qinntech') {
$sql = "INSERT INTO sstpl_downdata(client_id, time, deveui, command) VALUES ('$client_id','$downlink_time','$devEUI','$command')";
 //var_dump($sql);
$exec=mysqli_query($conn, $sql);
echo "data inserted <br>";
$str='';
// if ($exec==true) { 
                
    echo "Command Accepted";


                                $url = 'http://localhost:8080/api/internal/login';
        $jsonString = json_encode(array( "password" => "admin","email" => "admin"  ));
        $ch = curl_init();
        $timeout = 0;
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonString);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Accept: application/json',)
        );
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $jwtk = curl_exec($ch);
        $ch_error = curl_error($ch);
        if ($ch_error) {
        // echo "cURL Error: $ch_error";
        //     die('error');
        } else {
         // echo $jwtk;
        }
        $token = json_decode($jwtk);
        curl_close($ch);

                                $url = 'http://localhost:8080/api/devices/'.$devEUI.'/queue';
                              //  echo $url;
                                $jsonString = json_encode(array(
                                "deviceQueueItem"=>array(
                                "confirmed"=> true,
                                "data"=> $payload,
                                "devEUI"=> $devEUI,
                                "fCnt"=> 0,
                                "fPort"=> $port
                                )
                                ));
                                $ch = curl_init();
                                $timeout = 0; // Set 0 for no timeout.
                                        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                                curl_setopt($ch, CURLOPT_URL, $url);
                                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                                curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonString);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                                'Content-Type: application/json',
                                'Accept: application/json',
                                "Grpc-Metadata-Authorization:$token->jwt",)
                                );
                                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
                                $jwt = curl_exec($ch);
                                $ch_error = curl_error($ch);
                                if ($ch_error) {
                                echo "cURL Error: $ch_error";
                                }
                                else {  
                                 // echo $jwt;
                                                }

                                curl_close($ch);

// }//exec condition
// else{
//     echo "connection error";
// }
}//client_id check
else{echo "Invalid Client ID";}
}//EMPTY $dt 
else{
     echo "Data value empty or not valid!!!";
}

}
    ?>
