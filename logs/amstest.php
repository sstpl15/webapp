

<?php
session_start();
ob_start();


$user=$_SESSION['user'];
$pswd=$_SESSION['credential'];

if (!empty($user) && !empty($pswd)) {


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
  
$sql ="SELECT id,Address,MAC,Time,freq,Modulation,Data_Rate,Code_Rate,RSSI,LORA_SNR,PAYLOAD FROM SSTPL_UP_Data WHERE Modulation ='Neev_streetlight_controller_production' ORDER BY id DESC LIMIT $start_from, $limit";  

$ret = mysqli_query($con, $sql);
date_default_timezone_set('ASIA/Kolkata');
$time=date('H:i:s');
		
?>

<!DOCTYPE html>
<html>
<head>
    
    <meta http-equiv="refresh" content="60">
    <link rel="icon" type="image/png" href="1.ico"/>
    <meta http-equiv="refresh" content="10">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.2/moment.min.js"></script>
</head>
<style>
            table {
      border-collapse: collapse;
      width: 100%;
    }

th{

background-color: #0066CC;
color: #fff;

}
    body {
margin-top:-20px;
background-image:url(devicelog.jpg); 
-webkit-background-size: cover;
-moz-background-size: cover;
-o-background-size: cover;
background-size: cover;


    }

    .topnav {
    overflow: hidden;
    background-color: #333;
    }

    .topnav a {
    float: left;
    display: block;
    color: #f2f2f2;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
    font-size: 17px;
    }

    .topnav a:hover {
    background-color: #ddd;
    color: black;
    }

    .topnav a.active {
    background-color: #4CAF50;
    color: white;
    }

    table {
    border-collapse: collapse;
    }


    p{

background-color: #AFABAB;

    }

    #ct{
    	
    	font-family: sans-serif;
    	 font-size: 20px; 
    	 margin-left: 14%;
    	}

 </style>
    <title>User Record</title>
<script type="text/javascript"> 
function display_c(){
var refresh=1000; // Refresh rate in milli seconds
mytime=setTimeout('display_ct()',refresh)
}

function display_ct() {
var x = new Date();
var newtime=moment().format('ddd MMM DD YYYY hh:mm:ss');
document.getElementById('ct').innerHTML = newtime;
tt=display_c();
 }

</script>
</head>



<body onload=display_ct();>

<p>
<h2 style="color: #FF5733; background-color: grey;"><img src="img_avatar2.png" style="height: 100px; width: 120px;">SSTPL All Device Monitoring</h2>
  
  <form action="" method="post">
    <input type="submit" class="btn btn-info SettingsBtn" value="Search By Mac-Address" name="MacAddress" style="margin-left:30%;" >
  <input type="submit" class="btn btn-info SettingsBtn" value="Search By Node" name="filter" style="margin-left: 0.2%;" >
   <input type="submit" class="btn btn-info " value="Logout" name="logout" >
   <span id='ct' ></span>
  </form>         
</p>
   

	
        <table class="table table-striped" style="visibility:visible">
            <thead>
              <tr>

        					<th>DeviceEUI</th>
        					<th>Gateway Mac Address</th>
        					<th>Time</th>
        					<th>Freq &nbsp; (Hz)</th>
        					<th>Application Name</th>
        					<th>Spreading Factor</th>
        					<th>fcnt</th>
        					<th>RSSI (dBm)</th>
        					<th>SNR</th>
        					
        					<th>Payload</th>
                  
        					

               </tr>
            </thead>

                 <tbody>
        		     	<?php	
        				
        				
        			
                 	       while($row =  mysqli_fetch_array($ret)  ) { 
            
        			    ?>
        			
                            <tr>
        							          <td><?php echo $row['Address'] ?></td>
                                <td><?php echo $row['MAC'] ?></td>
                                <td><?php echo $row['Time'] ?> </td>
                      					<td><?php echo $row['freq'] ?> </td>
                      					<td><?php echo $row['Modulation'] ?> </td>
                      					<td><?php echo 'SF'.$row['Data_Rate'] ?> </td>
                      					<td><?php echo $row['Code_Rate'] ?> </td>
                      					<td><?php echo $row['RSSI'] ?> </td>
                      					<td><?php echo $row['LORA_SNR'] ?> </td>
                      				  <td><?php echo $row['PAYLOAD'] ?> </td>
                                
                            </tr>
                  <?php     
                       } 
                  
  
                   ?>
        				
                    </tbody>
        </table>

<?php  

if (isset($_POST['filter'])) {

  header('Location:alldevicelogfilter.php');
 
}


if (isset($_POST['MacAddress'])) {

  header('Location:MacFilter.php');
 
}

if (isset($_POST['logout'])) {

  session_unset();
  session_destroy();
  header('Location:login.php');
}



$total_records=array();
$sql1 ="select COUNT(id) as cnt,Address,MAC,Time,freq,Modulation,Data_Rate,Code_Rate,RSSI,LORA_SNR,PAYLOAD from SSTPL_UP_Data";

$ret1 = mysqli_query($con, $sql1);
$row = mysqli_fetch_assoc($ret1);

$total_records = $row['cnt'];  
$total_pages = ceil($total_records / $limit);   

echo "<ul class='pagination' style='margin-left:40%;'>";
echo "<li><a href='alldevicelog.php?page=".($page-1)."' class='button'>Previous</a></li>"; 
 

echo "<li><a href='alldevicelog.php?page=".($page+1)."' class='button'>NEXT</a></li>";
echo "</ul>"; 

?>
  </body>
      

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <script>window.jQuery || document.write('<script src="script/js/jquery.min.js"><\/script>')</script>
   
 <script>
    setTimeout(function(){
       window.location.href = 'alldevicelog.php';
    }, 50000);




</script>

</body>
</html>
<?php

}
else
{
header('location:login.php');
}


?>

