<?php

if( ( isset($_SERVER['PHP_AUTH_USER'] ) && ( $_SERVER['PHP_AUTH_USER'] == "android" ) ) AND
( isset($_SERVER['PHP_AUTH_PW'] ) && ( $_SERVER['PHP_AUTH_PW'] == "12345" )) )
{   

	ActionSection();

  }
else
{//Send headers to cause a browser to request
header("WWW-Authenticate: " .
"Basic realm=\"User Protected Area\"");
header("HTTP/1.0 401 Unauthorized");
print("Invalid credentials!");
}


function ActionSection()
{
	require "conn.php";
//require "alldevicelog.php)";
$limit =35;  
$start_from=1;

$start_from = ($page-1) * $limit;  
// products array
    $products_arr=array();
    $products_arr["records"]=array();

$sql ="SELECT id,Address,MAC,Time,freq,Modulation,Data_Rate,Code_Rate,RSSI,LORA_SNR,PAYLOAD FROM SSTPL_UP_Data WHERE MAC !='506f980000000018' ORDER BY id DESC LIMIT 100";  

$ret = mysqli_query($con, $sql);

date_default_timezone_set('ASIA/Kolkata');
$time=date('H:i:s');



while($row =  mysqli_fetch_array($ret)  ) { 
	 
              $product_item=array(
            "id" => $row['id'],
            "time" => $row['Time'],
             "Address" => $row['Address'],
             "freq" => $row['freq'],
             "Modulation" => $row['Modulation'],
              "Date_Rate" => $row['Data_Rate'],
             "Code_Rate" => $row['Code_Rate'],
            "RSSI" => $row['RSSI'],
           "LORA_SNR" => $row['LORA_SNR'],
          "PAYLOAD" =>  $row['PAYLOAD'],
            "MAC" => $row['MAC']
        );
          array_push($products_arr["records"], $product_item);                  
     
   // var_dump($product_item) ;
                       } 
                  
  
                   

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
// set response code - 200 OK
    http_response_code(200);
  
    // show products data in json format
 echo json_encode($products_arr);

}
?>