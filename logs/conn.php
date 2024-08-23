<?php
$con=mysqli_connect("localhost","sstpl","Sstpl@123","SSTPL_UPLINK");
#$con2=mysqli_connect("192.168.0.185","ubuntu","Admin@123!","SSTPL_UPLINK");
// Check connection
if (mysqli_connect_errno())
  {
//echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

mysqli_select_db($con,"SSTPL_UPLINK");

//echo "Connection Established ! ";

?>
