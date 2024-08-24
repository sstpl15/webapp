<!DOCTYPE html>
<html>
	<head>
		<title>JSCL -Gateway Status</title>
   <script type="text/javascript">
window.setTimeout(function () {
  window.location.reload();
}, 10000);
  </script>
		<meta charset="UTF-8">
		<meta name="description" content="end devices, sensor integration on deives eg parking, environment  meassuring, fire, industrial, smart home">
		<meta name="keywords" content="parking sensor, fire sensor, smart meter, assert tracking, environment monitoring, sensor integration, end device, gateway, smart agriculture, smart home">
		<meta name="author" content="Aksh Optifibre Limited">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,600" rel="stylesheet">		
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
	

	</head>
	<style type="text/css">
	html {
	  min-height: 100%;
	  position: relative;
	}
	body{
	background-color: #f0f3f5;
	font-size: 15px;
	 margin-bottom: 60px;
	font-family: "Poppins", Helvetica, Arial, sans-serif;
	}
	.navbar-brand{
	height: 70px;
	width: 80px;
	margin-top: -5px;
	}
	html #footer {
	bottom: 0;
	width: 100%;
	position: absolute;
	height: 60px;
	background-color: #f5f5f5;
	}
	html #footer .footer-block {
	margin: 20px 0;
	}
	.card{
		background-color: #f39c12;
		height: 120px;		
	} 
	.row{
		margin :0px 5px;
	}
	.bg-danger{
		background-color: #e74c3c;
	}
	.bg-success{
		background-color: #1abc9c;
	}
	</style>
	<body>
		<nav class="navbar navbar-expand-lg navbar-light bg-white">
			<!-- <a class="navbar-brand" href="#">
				<img src="vendor/img/logo.png" class="img-fluid">
			</a> -->
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNavDropdown">
				<ul class="navbar-nav mx-auto">
					<li class="nav-item active" >
						<a class="nav-link text-center text-muted" href="#">
							<h5 >JSCL Gateway Panel</h5>
							<span>(Live Instance)</span> 
							<!-- <h6>Sehaj Synergy Technologies Pvt. Ltd. (Jaipur)</h6>	 -->
						</a>
					</li>									
				</ul>
			</div>
			<!-- <a href="index.html" class="font-weight-bold">Home <i class="fa fa-home"></i></a> --> 
		</nav>
		<div class="container-fluid">
			<div class="row mx-auto mt-4">
				<?php

require('/var/www/html/vendor/include/postgres.php');
require_once('/var/www/html/vendor/phpmailer/class.smtp.php');
require '/var/www/html/vendor/phpmailer/PHPMailerAutoload.php'; 
require('/var/www/html/vendor/include/mysql.php');
				
				$arrRecords= array();
				$queryGatewayAll=pg_query($db,"select * from gateway order by mac");
				while ($rows=pg_fetch_assoc($queryGatewayAll)) {
					$mac= substr($rows['mac'], 2) ;
					// echo "string".$mac."hhhhhhhhh";
					$lastseen=$rows['last_seen_at'];
					// echo "Last Seen1:".$lastseen."<br>";
					$descript=$rows['name'];

					$mac1[]=$mac;
					$last1[]=$lastseen;
					$des[]=$descript;
									}

// echo count($mac1)."<br>";
// var_dump($mac1);

$list=array("506f980000000143","506f98000000013c","506f98000000012b","506f98000000012a","506f98000000011c","506f98000000012d","506f980000000122","506f980000000131","506f98000000012f","506f98000000012e","506f980000000124","506f980000000134","506f980000000030","506f980000000125","506f980000000121","506f980000000001");
// echo "<br>";
// var_dump($list);
// echo "<br>";
				for ($i=0; $i < count($mac1); $i++) { 			
					$lastSeen= $last1[$i];
					// echo "Last Seen:".$last1[$i]."<br>";
					date_default_timezone_set('Asia/kolkata');
					// echo date('Y-m-d H:i:s'); 
					$strlastSeen=strtotime($lastSeen);
					$timeNow=date('Y-m-d H:i:s');					
					$timeDiff=(strtotime($timeNow) - strtotime($last1[$i]));
				// //Debug	
				// echo $timeDiff."<br> ".strtotime($lastSeen)."<br>".strtotime($timeNow)."<br>";
				// 	// echo "<br> lastseen".$lastseen."<br> ";
				
				$istlastseen=date('Y-m-d H:i:s',$strlastSeen);
				
				// 	//$istTime=date('Y-m-d H:i:s',strtotime($lastSeen));
				// $istlastseen->setTimezone(new DateTimeZone('IST'));
				// //IST & UTC	
					
				// 	 echo "<br>string".$listlastseen."<br>";
					if(in_array($mac1[$i],$list,TRUE)){
						// echo "<br> MAC ".$mac1co[$i]."   Time Difference: ". $timeDiff."<br>";
					  if ($timeDiff > 60) {
					  	if($lastSeen==0) {$lastSeen="Never communicated"; }else{ $lastSeen=$istlastseen; }
							  echo '<div class="col-sm-2 mt-2 text-center text-white" title="description" data-toggle="popover" data-trigger="hover" data-content="'.$des[$i].'">
									 		 <div class="card bg-danger border-0 text-white mx-1">
												<p class="py-2 ">MAC: <b>'.$mac1[$i].'</b></p> 
												<p class="">Down Since: '.$lastSeen.'</p>
											 </div>	
										 </div>';
					  } else{
							echo '<div class="col-sm-2 mt-2 text-center text-white" title="description" data-toggle="popover" data-trigger="hover" data-content="'.$des[$i].'">
							 		 <div class="card bg-success border-0 mx-1">
										<p class="py-2 ">MAC:  <b>'.$mac1[$i].' </b></p> 
										<p class="">Last seen: '.$istlastseen.'</p>
									 </div>	
								 </div>';
						 }	
				 }}
				?>
			</div>
		</div>
		<!-- <div id="footer">
			<div class="container text-center text-muted">
				<p class="footer-block">© 2015-2020, sstpl.in, Inc. or its affiliates<br>
				Head-office: J-9,J-7/3, 3rd Floor, Opp Swage Farm Power House, Bhagwan Marg, Swage Farm Rd, Sodala, Jaipur, Rajasthan 302019</p>
			</div>
		</div> -->
	</body>
	<script type="text/javascript">
		$(document).ready(function(){
  $('[data-toggle="popover"]').popover();   
});
	</script>
</html>

