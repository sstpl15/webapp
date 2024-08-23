<!DOCTYPE html>
<html>
	<head>
		<title>Mac Address</title>
		<link rel="icon" type="image/png" href="1.ico"/>
		<meta http-equiv='refresh' content="10">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	</head>
	<style type="text/css">
		thead th{
			font-size: 15px;
			font-family: cursive;
		}
		tbody td{
			font-size: 14px;
			font-family: cursive;
		}
	.fa-input {
	font-family: FontAwesome, 'Helvetica Neue', Helvetica, Arial, sans-serif;
	}
	body{
		background-color: linear-gradient(#05FBFF, #1D62F0 ) fixed;
	}

	ul li a{
    border: 1px solid  #5bc0de;
    margin-left: 1%;
}

	ul li a:hover {  
    text-decoration: none;
}

	</style>
	<body>
		<form class="form-horizontal" action="" method="POST">
			<img src="img_avatar2.png" style="height: 70px; width: 80px;">
		
			<input type="submit" name="back" class="btn fa-input btn btn-primary pull-right" value="Search-More &#xf08b;" style="margin-top: 1.6%;">

			<div class="container-fluid">
				<div class="row">

						<div class="col-sm-3" style=" margin-left: 30%;">

			<input type="text" name="Address" class="form-control" <?php $inpvalue=""; echo $inpvalue; ?>>
			<input type="submit" class="btn btn-success" value="Download" name= "download" id="tablelink" style="width: 100px; margin-top: 4px; ">
			
			<input type="submit" name="sAddress" value="Search" class="btn btn-info pull-right" style="margin-top: 4px;">

		</div>
					<?php


						



					session_start();

					require_once('conn.php');
						$mac= $_SESSION['Mac'];
						echo "MAC Address".$mac;


						$limit =20;  
						if (isset($_GET["page"])) 
						  { 
						   $page  = $_GET["page"]; 
						} 
						else { 
						   $page=1;
						 }

						$start_from = ($page-1) * $limit;  

							$show=2;



  if($mac != '506f980000000018')
  {
						$sql="SELECT id, Address, MAC, Time, freq, Modulation, Data_Rate, Code_Rate, RSSI, LORA_SNR, PAYLOAD FROM SSTPL_UP_Data WHERE MAC='".$mac." order by id desc LIMIT $start_from, $limit";
						// echo "<br>".$sql."HIIIIIIIIhhhh<br>GGGGGGGGGG";
							$exec=mysqli_query($con, $sql);

}



					if (isset($_POST['sAddress'])) {	
						 	$addr=$_POST['Address'];
						 	//echo "Address".$addr;
						 	$_SESSION['addr']=$addr;
						 	$show1=1;
						 	$_SESSION['show']=$show1;
						 	$inpvalue=$_SESSION['addr'];						 	
						 }

					
						 if(isset($_POST['download']) )
{							//$addr=$_POST['Address'];
							//$MAC = $_POST['MAC'];
							header('Location: mac-report.php?MAC='.$mac.'');

   								 }
						 


						 if ($_SESSION['show']=='1') {

						 		$sql1="SELECT id, Address, MAC, Time, freq, Modulation, Data_Rate, Code_Rate, RSSI, LORA_SNR, PAYLOAD FROM SSTPL_UP_Data WHERE MAC='".$mac."' order by id desc LIMIT $start_from, $limit";
						 		echo "<br>".$sql1."HIIIIIIIIhhhh<br>GGGGGGGGGG";
					$exec1=mysqli_query($con, $sql1);


							

						 	echo '<table class="table" style="margin-top: 10px;">
						<thead class="thead-light">
							<tr>
								<th>DevEUI</th>
								<th>Gateway Mac</th>
								<th>Time</th>
								<th>Freq &nbsp; (Hz)</th>
								<th>Application Name</th>
								<th>Data Rate</th>
								<th>fCnt</th>
								<th>RSSI (dBm)</th>
								<th>SNR</th>
								<th>Payload</th>
								
							</tr>
						</thead>
						<tbody>';
		
									
							while($row1=mysqli_fetch_assoc($exec1)){
					

						 	echo '<tr>
								<td> '.$row1['Address'].'</td>
								<td>'.$row1['MAC'].'</td>
								<td>'.$row1['Time'].' </td>
								<td>'.$row1['freq'].' </td>
								<td>'.$row1['Modulation'].'</td>
								<td>'.$row1['Data_Rate'].' </td>
								<td>'.$row1['Code_Rate'].' </td>
								<td>'.$row1['RSSI'].' </td>
								<td>'.$row1['LORA_SNR'].' </td>
								<td>'.$row1['PAYLOAD'].'  </td>
								
							</tr>';
							
							}
						}
					

					else{
							
						

							echo '<table class="table" style="margin-top: 10px;">
						<thead class="thead-light">
							<tr>
								<th>DevEUI</th>
								<th>Gateway Mac</th>
								<th>Time</th>
								<th>Freq &nbsp; (Hz)</th>
								<th>Application Name</th>
								<th>Data Rate</th>
								<th>fCnt</th>
								<th>RSSI (dBm)</th>
								<th>SNR</th>
								<th>Payload</th>
								
							</tr>
						</thead>
						<tbody>';
									
									
									while($row=mysqli_fetch_assoc($exec)){
					

						 	echo '<tr>
								<td> '.$row['Address'].' </td>
								<td>'.$row['MAC'].' </td>
								<td>'.$row['Time'].'</td>
								<td>'.$row['freq'].' </td>
								<td>'.$row['Modulation'].'  </td>
								<td>'.$row['Data_Rate'].' </td>
								<td>'.$row['Code_Rate'].' </td>
								<td>'.$row['RSSI'].'  </td>
								<td>'.$row['LORA_SNR'].'  </td>
								<td>'.$row['PAYLOAD'].'  </td>
								
							</tr>';
						}
						}
					echo $_SESSION['show'];
					?>	
									
					
						</tbody>
					</table>
							<?php
							

if ($_SESSION['show']=='1') {

$total_records=array();
$sql2 ="select COUNT(id) as cnt,Address,MAC,Time,freq,Modulation,Data_Rate,Code_Rate,RSSI,LORA_SNR,PAYLOAD from SSTPL_UP_Data where MAC='".$mac."'";

$ret2 = mysqli_query($con, $sql2);
$row2 = mysqli_fetch_assoc($ret2);

$total_records = $row2['cnt'];  
$total_pages = ceil($total_records / $limit);   

echo "<ul class='pagination' style='margin-left:40%;'>";
echo "<li><a href='MacAddress.php?page=".($page-1)."' class='button'>Previous</a></li>"; 
 

echo "<li><a href='MacAddress.php?page=".($page+1)."' class='button'>NEXT</a></li>";
echo "</ul>";
	
}

else {

$total_records=array();
$sql2 ="select COUNT(id) as cnt,Address,MAC,Time,freq,Modulation,Data_Rate,Code_Rate,RSSI,LORA_SNR,PAYLOAD from SSTPL_UP_Data where MAC='".$mac."' AND Address='".$_SESSION['addr']."'";

$ret2 = mysqli_query($con, $sql2);
$row2 = mysqli_fetch_assoc($ret2);

$total_records = $row2['cnt'];  
$total_pages = ceil($total_records / $limit);   

echo "<ul class='pagination' style='margin-left:40%;'>";
echo "<li><a href='MacAddress.php?page=".($page-1)."' class='button'>Previous</a></li>"; 
 

echo "<li><a href='MacAddress.php?page=".($page+1)."' class='button'>NEXT</a></li>";
echo "</ul>";

}



if (isset($_POST['back'])) {
	session_destroy();
	session_destroy();
	header('Location: MacFilter.php');
}
  ?>
						</form>
					</div>
				</div>
				
			</body>
		</html>
	</body>
</html>
