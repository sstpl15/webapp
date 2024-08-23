<?php
header('location:login.php');
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Filter Mac</title>
		<link rel="icon" type="image/png" href="1.ico"/>
		<meta http-equiv='refresh' content="10">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Raleway" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	</head>
	<style type="text/css">
	.form-inline a{
		  border-color: #2196F3;
  			color: dodgerblue;
	}

	.form-inline a:hover {
  background: #2196F3;
  color: white;
}
	</style>
	<body>
		<div class="container">
			<div class= "row">
				<form action="" method="post">
					<div class="form-inline">
						<center>
							<a href="alldevicelog.php" style="margin-top: 1.6%;" class="pull-left"><i class="fa fa-arrow-left"></i> Homepage</a>
						<p style="margin-top: 30px; font: italic small-caps bold 25px Georgia, sans-serif;"><b>Search</b></p>				
						<div class="form-group">
								
							<input type="text" class="form-control" name ="Mac_Address" placeholder="Search by Device Address" maxlength="16" required="required">
						</div>&nbsp;
						<input type="submit" class="btn btn-success" name= "submit" id="tablelink" style="width: 100px;">
						</center>
					</div>
				</form>
			</div>
		</div>
	</div>
	<?php
			session_start();
			if(isset($_POST['submit'])) {

			   $Mac=$_POST['Mac_Address'];
			   $_SESSION['Mac'] =$Mac;
			   header('Location:MacAddress.php');
				
			}


	?>
</body>
</html>