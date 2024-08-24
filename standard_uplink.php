
<?php
ini_set('display_errors', 0);
 // $postdata='{"applicationID":"3","applicationName":"OMS","deviceName":"node_506F980000012318","devEUI":"UG+YAAABIxg=","rxInfo":[{"gatewayID":"UG+YAAAAAVw=","time":null,"timeSinceGPSEpoch":null,"rssi":-33,"loRaSNR":7.2,"channel":0,"rfChain":0,"board":0,"antenna":0,"location":{"latitude":0,"longitude":0,"altitude":0,"source":"UNKNOWN","accuracy":0},"fineTimestampType":"NONE","context":"OFHwXA==","uplinkID":"tlxE5wWMSeyAqZcpmKMMAQ==","crcStatus":"CRC_OK"}],"txInfo":{"frequency":865062500,"modulation":"LORA","loRaModulationInfo":{"bandwidth":125,"spreadingFactor":12,"codeRate":"4/5","polarizationInversion":false}},"adr":true,"dr":0,"fCnt":1,"fPort":2,"data":"U1NUUEz/////AQAE","objectJSON":"","tags":{},"confirmedUplink":true,"devAddr":"AAEjGA==","publishedAt":"2022-08-17T07:49:50.328259649Z","deviceProfileID":"a61048ba-04ea-4c94-9cc3-b29fc4188aac","deviceProfileName":"class_c_abp"}';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$connection=mysqli_connect("localhost","Nexcity","DBp@ssisthis","SSTPL_UPLINK") or die("could not connect");
date_default_timezone_set('Asia/kolkata');
$Time=date('Y-m-d H:i:s');
if($connection){ echo"connected <br>"; }
$postdata = file_get_contents('php://input');
if(!empty($postdata)){
function hex_to_base64($hex){
$return = '';
foreach(str_split($hex, 2) as $pair){   $return .= chr(hexdec($pair));}
return base64_encode($return);
                                }
file_put_contents('data.txt',$Time." | ".$postdata.PHP_EOL, FILE_APPEND);

$jObj = json_decode($postdata);
if($jObj !== null){
$keysList = array_keys($jObj);
if (in_array("data", $keysList)) {
$app_name=$jObj->applicationName;
$table_name=$app_name;
$data = $jObj ->data;
$data1 = bin2hex(base64_decode($data));
// $data1="323635332e3437333330373534362e343737360000000300060000000000000000000000";
echo "data 1 is ".$data1;
$devEUI = bin2hex(base64_decode($jObj ->devEUI)); 
echo $devEUI;
$gw_mac = bin2hex(base64_decode($jObj ->rxInfo[0]->gatewayID));
echo "ggggggggggggggggg".$gw_mac;
$rssi = $jObj ->rxInfo[0]->rssi;
$loRaSNR = $jObj ->rxInfo[0]->loRaSNR;
$Freq = $jObj ->txInfo->frequency;
$Data_Rate = $jObj ->txInfo->loRaModulationInfo->spreadingFactor;
$data_rate=$Data_Rate;

$Time2=date('Y-m-d H:i:s');
    switch ($Data_Rate) {
        case '0':       $Data_Rate=12;  break;
        case '1':       $Data_Rate=11;  break;
        case '2':       $Data_Rate=10;  break;
        case '3':       $Data_Rate=9;   break;
        case '4':       $Data_Rate=8;   break;
        case '5':       $Data_Rate=7;   break;
        default:        $Data_Rate=$Data_Rate;  break;
    }
// $Data_Rate= "DR".$data_rate." | SF".$Data_Rate;
$Data_Rate="SF".$Data_Rate;
$fcnt =$jObj->fCnt;
$strfcnt= $fcnt;
if (!empty($table_name) && strlen($table_name) > 1) {

         $sql =  mysqli_query($connection, "INSERT INTO SSTPL_UP_Data(Address,MAC,Time,freq,Modulation,Data_Rate,fcnt,RSSI,LORA_SNR,PAYLOAD) VALUES ('$devEUI','$gw_mac','$Time','$Freq','$table_name','$Data_Rate','$fcnt','$rssi','$loRaSNR','$data1')");

         

            $sql="SHOW TABLES LIKE '$table_name'";
            if ($result=mysqli_query($connection,$sql))
            {
            $rowcount=mysqli_num_rows($result);
            if ($rowcount > 0) { // if table exists in database then below code will execute
                    $sql =  mysqli_query($connection,"INSERT INTO ".$table_name." (device_eui,gateway_mac,freq,app_name,data_rate,fcnt,time,payload,rssi,snr)
                    VALUES ('$devEUI','$gw_mac','$Freq','$app_name','$Data_Rate','$fcnt','$Time','$data1','$rssi','$loRaSNR')");
               
          }
        else{

        // if table does not exist in database then below code will execute
            $create = "CREATE TABLE ".$table_name." (
            id int(11) NOT NULL PRIMARY KEY,
            device_eui text NOT NULL,
            gateway_mac text,
            time datetime DEFAULT NULL,
            freq int(11) DEFAULT NULL,
            app_name text,
            data_rate text,
            fcnt text,
            rssi int(11) DEFAULT NULL,
            snr float DEFAULT NULL,
            payload text
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
            $results = mysqli_query($connection, $create) or die (mysqli_error($connection));
            $IDincrement="ALTER TABLE ".$table_name." MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1";
            $runQuery=mysqli_query($connection, $IDincrement);
            // file_put_contents('apisql.txt',$sql.PHP_EOL, FILE_APPEND);
            if ($results==true) {
                $sql = "INSERT INTO ".$table_name." (device_eui,gateway_mac,freq,app_name,data_rate,fcnt,time,payload,rssi,snr)
                VALUES ('$devEUI','$gw_mac','$Freq','$app_name','$Data_Rate','$fcnt','$Time','$data1','$rssi','$loRaSNR')";
                if ($connection->query($sql) === TRUE) {                



                } else {
                echo "Error: " . $sql . "<br>" . $connection->error;
                }
                $connection->close();
            }
        }
        }


$data_header=$data1;
$data_cmd=$data1;
$data_tmp=$data1;
$header=substr($data_header, 0,10);
$std_header="535354504c";//ASCII= SSTPL
$send_flag=0;
$final_verified=0;
$reactivate_flag=0;
echo $header;

$ch = curl_init("www.qinntech.com/lora/datacapture.php");
//curl_setopt($ch, CURLOPT_URL, "https://tggreports.com/sstplapi/api");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
$output = curl_exec($ch);
$ch_error= curl_error($ch);
                //echo $ch_error;
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$info = curl_getinfo($ch);
curl_close($ch);
file_put_contents("responseoms.txt", $Time2." | ".$output .PHP_EOL, FILE_APPEND);
file_put_contents("erroroms.txt", $Time2." | ".$ch_error .PHP_EOL, FILE_APPEND);

$ch = curl_init("http://testing.siotel.in/oms.php");
//curl_setopt($ch, CURLOPT_URL, "https://tggreports.com/sstplapi/api");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
$output = curl_exec($ch);
$info = curl_getinfo($ch);
curl_close($ch);
file_put_contents("responsetestingoms.txt", $Time2." | ".$output .PHP_EOL, FILE_APPEND);

// }
 }


else{
 echo "post is empty";
}
}
}
}
?>
