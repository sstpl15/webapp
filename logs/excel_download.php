
<?php
require 'api/conn.php'; 
$time_uid =$_GET['time_id'];



$DB_TBLName = "your_table_name"; 
$filename = "excelfilename";  //your_file_name
$file_ending = "xls";   //file_extention

header("Content-Type: application/xls");    
header("Content-Disposition: attachment; filename=$filename.'.'.$file_ending");  
header("Pragma: no-cache"); 
header("Expires: 0");

$sep = "\t";



$sql2 ="SELECT * from SSTPL_UP_Data WHERE `Time` > NOW() - INTERVAL $time_uid HOUR order by id desc";
$resultt = mysqli_query($conn, $sql2); 

while ($property = mysqli_fetch_field($resultt)) { //fetch table field name
    echo $property->name."\t";
}

print("\n");    

while($row = mysqli_fetch_row($resultt))  //fetch_table_data
{
    $schema_insert = "";
    for($j=0; $j< mysqli_num_fields($resultt);$j++)
    {
        if(!isset($row[$j]))
            $schema_insert .= "NULL".$sep;
        elseif ($row[$j] != "")
            $schema_insert .= "$row[$j]".$sep;
        else
            $schema_insert .= "".$sep;
    }
    $schema_insert = str_replace($sep."$", "", $schema_insert);
    $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
    $schema_insert .= "\t";
    print(trim($schema_insert));
    print "\n";
}
?>