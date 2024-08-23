
<?php

require "conn.php";
$mac = $_GET['MAC'];
//echo $mac;
//echo hello;
 // Filter the excel data 
function filterData(&$str){ 
    $str = preg_replace("/\t/", "\\t", $str); 
    $str = preg_replace("/\r?\n/", "\\n", $str); 
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"'; 
} 

// Excel file name for download 
$fileName = "Mac-report-24-hours-" . date('Ymd') . ".xls"; 
 
// Column names 
$fields = array('DeviceEUI','Gateway Mac Address', 'Time', 'Freq (Hz)', 'Application Name', 'Spreading Factor','fcnt','RSSI (dBm)','SNR','Payload'); 
 
//Display column names as first row 
$excelData = implode("\t", array_values($fields)) . "\n"; 


// $sql2 ="SELECT * FROM `Issue_Tracker` WHERE `Create_Date` >= '$sdate' AND `Create_Date` <= '$edate' ORDER BY `Create_Date`";
//$sql ="SELECT * FROM SSTPL_UP_Data WHERE MAC='".$mac."' AND Time >= NOW() - INTERVAL 24  order by id desc";

//SELECT * FROM `SSTPL_UP_Data` WHERE MAC ='506f9800000001f3' AND time > '2023-09-00 00:00:00'
$sql ="SELECT  * FROM SSTPL_UP_Data WHERE  MAC='".$mac."' ORDER BY id DESC limit 1000";

//$sql ="SELECT  * FROM SSTPL_UP_Data WHERE  MAC='".$mac."' AND time > '2023-09-00 00:00:00' ORDER BY id DESC limit 1000";
//$sql ="SELECT * FROM `SSTPL_UP_Data` WHERE `Time` >= '2023-09-08 00:00:00' AND  MAC like '%1f3%' ORDER BY `id` DESC";
//$sql ="SELECT * FROM `SSTPL_UP_Data` WHERE `Time` >= NOW() - INTERVAL 26 HOUR AND MAC='".$mac."' ORDER BY `id` DESC";
//echo "<br>query is ".$sql;
$ret = mysqli_query($con, $sql); 
//echo $ret2;
$i = 0;
while($row = mysqli_fetch_array($ret)) { 

$i++;
$payload = $row['PAYLOAD'];
$mr=$payload;
//$mr = hexdec($mr);
// $payload = base_convert($Payload, 16, 10);
$mr = str_split($mr, 2);
$mr = array_map('hexdec', $mr);
// Store the decimal bytes separated by spaces in a variable
$mr = implode(' ', $mr);
// Output the decimal value
//echo $decimalValue;
$rowData = array($row['Address']."'",$row['MAC'],$row['Time'],$row['freq'],$row['Modulation'],'SF'.$row['Data_Rate'],$row['Code_Rate'],$row['RSSI'],$row['LORA_SNR'],$row['PAYLOAD']); 
array_walk($rowData, 'filterData'); 
$excelData .= implode("\t", array_values($rowData)) . "\n"; 

}
header("Content-Disposition: attachment; filename=\"$fileName\""); 
header("Content-Type: application/vnd.ms-excel");
echo $excelData;

exit();
?>