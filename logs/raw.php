
<?php


require "conn.php";

$limit =35;  
if (isset($_GET["page"])) 
  { 
   $page  = $_GET["page"]; 
} 
else { 
   $page=1;
 }

$start_from = ($page-1) * $limit;  
  
$sql ="SELECT id,Address,MAC,Time,freq,Modulation,Data_Rate,Code_Rate,RSSI,LORA_SNR,PAYLOAD FROM SSTPL_UP_Data WHERE MAC !='506f980000000018' ORDER BY id DESC LIMIT $start_from, $limit";  

$ret = mysqli_query($con, $sql);
date_default_timezone_set('ASIA/Kolkata');
$time=date('H:i:s');

$row =  mysqli_fetch_array($ret);
var_dump($ret);

echo "heeeeeeeeeeeeeeeeeeeeeeeeeeeelloooooooooooooooooooooooooooooo";
?>

