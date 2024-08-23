
<?php
// session_start();
// ob_start();
// $user=$_SESSION['user'];
// $pswd=$_SESSION['credential'];


// header("Refresh:10");

// if (!empty($user) && !empty($pswd)) {
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Filter device page</title>
    
    <link href="scripts/css/bootstrap.min.css" rel="stylesheet">
    <link href="scripts/css/Dashboard.css" rel="stylesheet">
    <link href="scripts/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
    <link href="scripts/css/dashboard.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.2/moment.min.js"></script>
  
  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

  <![endif]-->
  <style>
  table {
  border-collapse: collapse;
  width: 100%;
  }
  th, td {
  text-align: left;
  padding: 8px;
  }
  tr:nth-child(even) {
  background-color: #f2f2f2
  }
  .pagination a {
  color: black;
  float: left;
  padding: 8px 16px;
  text-decoration: none;
  transition: background-color .3s;
  }
  .pagination a.active {
  background-color: #4CAF50;
  color: white;
  }
  .pagination a:hover:not(.active) {
  background-color: #ddd;
  }
  #footer {
  position: absolute;
  
  width: 100%;
  height: 60px;
  }
  body {margin:0;}
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
  th, td {
  border-bottom: 1px solid #ddd;
  }
  th, td {
  padding: 15px;
  text-align: left;
  }
  th {
  background-color: #4CAF50;
  color: white;
  }

    #ct{
        font-family: sans-serif;
         font-size: 20px; 
        }
  </style>

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
  <div class="topnav">
     <form action="" method ="POST" style="" >
    <a  class="active" href="alldevicelog.php">All Device Log</a>
     <a href="Logout.php" class="btn btn-danger btn-outline" style="float: right;">Logout</a>
  </div>
 
   
  <div class="container">
    <div class= "row">
      <div class="form-inline">
        <center>
        <p style="margin-top: 30px; font: italic small-caps bold 25px Georgia, sans-serif;"><b>Search</b></p>       
          
          <div class="form-group">
            <input type="text" class="form-control" id ="Device_Address" name ="Device_Address" placeholder="Search by Device Address" maxlength="16" required="">
          </div>&nbsp;
          <input type="submit" class="btn btn-success" name= "submit" id="tablelink" style="width: 100px;">
 <span id='ct' ></span>
        </center>
        </div>
      </div>
    </div>
  </div>

  <!--  <div class="btn-group" style="margin-left: 33%; margin-top: 3%;">
    <button type="button" data-toggle="dropdown" class="btn btn-info dropdown-toggle" style="width: 150px;">View Records By <span class="caret"></span></button>
    <ul class="dropdown-menu">
      <li><a href="#">All Records</a></li>
      <li class="divider"></li>
      <li><a href="#">Filtered Records </a></li>
      
    </ul>
  </div> -->
</div>
<hr/>
<?php

include "conn.php";

$limit =100;  
$dev=$_GET['addr'];
if ($dev) {
  $sql =" SELECT  * FROM SSTPL_UP_Data WHERE  Address like '%$dev%' ORDER BY id DESC limit $limit";
}else{
  $sql =" SELECT  * FROM SSTPL_UP_Data WHERE  Address = '506f980000002bd2' AND TIME > '2021-02-12 00:00:00'";
}

$get=mysqli_query($con,$sql);

$row_cnt =  mysqli_num_rows($get);

if (!empty($row_cnt)) {

?>
<table class="table table-striped">
  <thead>
    <tr>
      <th>DeviceEUI</th>
      <th>Gateway Mac Address</th>
      <th>Time</th>
      <th>Freq &nbsp; (Hz)</th>
      <th>Application</th>
      <th>Data Rate</th>
      <th>Fcnt</th>
      <th>RSSI (dBm)</th>
      <th>SNR</th>
      <th>Payload</th>
    
     
    </tr>
  </thead>
  <tbody>
    <?php
    
    while($row = mysqli_fetch_assoc($get)) {
    
    
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
    }
    else
    {echo "<span style='color:red; font-size:25px; font-family:cursive; margin-left:32%;'>Not found.. please check device Address</span>";}
    
    if(isset($_POST['submit']) )
{
$devAddr = $_POST['Device_Address'];
header('Location: alldevicelogfilter.php?addr='.$devAddr.'');

    }

    ?>     

<div  id="welcome">

</div>

   <?php
// if (isset($_POST['logout'])) {

// 	session_destroy();
// 	session_unset();
// 	}

//     }
//     else{
//     header('Location:login.php');
//     }
    
    ?>
 
 
      <script src="script/js/vendor/holder.min.js"></script>
    <script src="script/js/ie10-viewport-bug-workaround.js"></script>

<script type="text/javascript">


$('#tablelink').click(function () {
   if (this.id == 'tablelink') {
      // $("#welcome").hide();
      // alert('hidden');
      
   }
  
});
  
</script>


    <script>
$( "#Device_Address" ).focus(function() {
window.stop(); 
});
 </script>

  </body>
</html>
