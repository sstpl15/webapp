<?php


$i=1;



   class MyDB extends SQLite3 {
      function __construct() {
       $this->open('/home/richa/database/Ssptl_UPLINK.db');
		

      }
   }

   


 if(isset($_GET['from']) && isset($_GET['to']) && isset($_GET['address']))
  {
	  $from="'".trim($_GET['from'])."'";
	  $to="'".trim($_GET['to'])."'";
	  $address="'".trim($_GET['address'])."'";
	  $sql =<<<EOF
     SELECT  Address as Address,rowid as rowid ,sms_sent as sms_sent , PAYLOAD as PAYLOAD ,DATE(Time) as Date,TIME(Time) as Time,(select max(rowid) from SSTPL_UP_Data where Address=$address ) as max from SSTPL_UP_Data where Address=$address and time >= $from AND time <= $to ;
EOF;
	//  echo $sql;
  }



if(isset($_GET['page'] ) )
   {
	$var=$_GET['page'];
	$i = ($var == 0) ? 1 : $var;
   }

   $db = new MyDB();
   if(!$db) {
      echo $db->lastErrorMsg();
   } else {
    //  echo "Opened database successfully\n";
   }

 if(isset($_GET['dev'])) { 
	 
	 $addr="'".$_GET['dev']."'"; 

  $sql =<<<EOF
      SELECT Address as Address,rowid as rowid ,sms_sent as sms_sent , PAYLOAD as PAYLOAD ,DATE(Time) as Date,TIME(Time) as Time,(select max(rowid) from SSTPL_UP_Data where Address=$addr ) as max from SSTPL_UP_Data where Address=$addr order by rowid DESC ;
EOF;
 //echo $sql;
						 }
   
 if (isset($_GET['id']) && is_numeric($_GET['id']))
   {
	   $i = $_GET['id'];
	     $sql =<<<EOF
        update Records set requested = 1 where rowid=$i;
EOF;
	   $ret = $db->query($sql);
	   
	   $sql =<<<EOF
      SELECT RowId,* from Records;
EOF;

   } 
   
 
   
	if(isset($_GET["val"]))
	{
		$i = $_GET['val'];
		$sql =<<<EOF
      SELECT RowId,* from Records order by $i;
	EOF;
		
		
	}
    else {

  $sql =<<<EOF
      SELECT RowId,* from SSTPL_UP_Data;
EOF;
   }

 //  echo 'to test ..';

	$ret = $db->query($sql);

				
?>

<!DOCTYPE html>
<html>
<head>
       <meta http-equiv="refresh" content="3" >
  
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	
    <link href="scripts/css/bootstrap.min.css" rel="stylesheet">

    <link href="scripts/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <link href="scripts/css/dashboard.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script>

var colors = ['red','pink'];
var currentIndex = 0;
setInterval(function () {
   $('div').css({
     backgroundColor: colors[currentIndex]
   });
   if (!colors[currentIndex]) {
       currentIndex = 0;
   } else {
       currentIndex++;
   }
}, 100);

</script>
	
	<style>


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
  color: orange;
}

.topnav a.active {
    background-color: #4CAF50;
    color: white;
}
div {
  transition: 100ms ease;
}
</style>


-
    <title>User Record</title>

</head>
<body>
  <nav class="topnav" style="background-color:orange">
 
  <a href="login_test.php" style="float:right">Log Out</a>
   <a class="active" href="lcd_test.php" >LCD System</a> 
  
   <a  href="addrecord_test.php">Add Product</a>
   <a  href="allrecords_test.php">LCD Users</a>
</nav>
    <h3 class="sub-header">
		<center> LCD System Record </center>
    </h3>

  
    <div1 style="border:dotted">
        <center>
            <p><b>Search</b></p>
            <form action=" " >
                From:
                <input type="date" name="from" style="width:270px">
                &nbsp;&nbsp;
                To:
                <input type="date" name="to" style="width:270px">
				
				<input type="text" name="address" value="<?php echo $_GET['dev']; ?>" hidden>
				
                <input type="submit">
            </form>
        </center>

    </div1>
	

    <div1 class="table-responsive">
        <table class="table table-striped table">
            <thead>

                <tr>

				
					
      	 <th>Device Address</th>
					<th style="padding-left: 2cm">Alert</center></th>
        <th>Action</th>
			<th>Time</th>
			<th>Date</th>

                </tr>
            </thead>
            <tbody>
			<?php	
				
				
			
     	       while($row = $ret->fetchArray(SQLITE3_ASSOC) ) {
				
				   
				   if($row['PAYLOAD'] =='0000'&& $row['rowid'] == $row['max'])
				   {
					  // echo $row['sms_sent'] ;
   
			?>
                    <tr class="danger">
						
						<!-- //<td><b><?php echo $row['PAYLOAD'] ?></b> </td> -->
						<?php $var= ($row['PAYLOAD'] =='0000') ? "disabled": "enabled" ?>
						
						<td><b><?php echo $row['Address'];?><b></td>	
						<td><b><div id="div1" style="width:200px" enabled><center><font style="color:white"><b>LCD OFF<b></font></center></div></b></td>
						
							<td><b>Power Off</b></td>
	
							<td><b><?php echo $row['Time'];?><b></td>					
							<td><b><?php echo $row['Date'];?><b></td>	
			
                  
                    </tr>
							
							<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
							
							
          <?php if($row['sms_sent']!=1) 
					{  
						// echo "inside if";
						
						//include "sms.php";         //////////////////////////  SEND SMS //////////////////////////////////////
					}  
				   } 
				   else if($row['PAYLOAD'] =='0101' && $row['rowid'] == $row['max'])  
				   {
					   
					   ?>
					   <tr class="warning">
						
						<!--  // <td><b><?php echo $row['PAYLOAD'] ?> </b></td>  -->
						<?php $var= ($row['PAYLOAD'] =='0000') ? "disabled": "enabled" ?>
						   
							<td><b><?php echo $row['Address'];?><b></td>
						   <td><b><div1 style="background-color:lightgreen;width:200px"><font style="color:black">LCD ON </font></div1><b></td>
						
        			  <td><b>Power ON<b></td>
					 <td><b><?php echo $row['Time'];?><b></td>	
						 <td><b><?php echo $row['Date'];?><b></td>
												
					<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
			
                  
                    </tr>
			<?php	   }  
					   
					    if($row['PAYLOAD'] =='0000' && $row['rowid'] < $row['max'])
				   {
   
			?>
                    <tr class="danger">
						
						<!-- //<td><b><?php echo $row['PAYLOAD'] ?></b> </td> -->
						<?php $var= ($row['PAYLOAD'] =='0000') ? "disabled": "enabled" ?>
						
							<td><b><?php echo $row['Address'];?><b></td>
						
						<td><b><div1 style="background-color:#FFB6C1;width:200px" enabled><b>LCD OFF<b></div1></b></td>
						
							<td><b>Power Off</b></td>
	
							<td><b><?php echo $row['Time'];?><b></td>	
								<td><b><?php echo $row['Date'];?><b></td>
							
			
                  
							</tr> 
							
							
          <?php   } else 
					   if($row['PAYLOAD'] =='0101' && $row['rowid'] < $row['max'])  
				   {
					   
					   ?>
					   <tr class="warning">
						
						<!--  // <td><b><?php echo $row['PAYLOAD'] ?> </b></td>  -->
						<?php $var= ($row['PAYLOAD'] =='0000') ? "disabled": "enabled" ?>
						   
						 	<td><b><?php echo $row['Address'];?><b></td>	
						   <td><b><div1 style="background-color:lightgreen;width:200px"><font style="color:black">LCD ON</font></div1><b></td>
						
        			  <td><b>Power ON<b></td>
	
					<td><b><?php echo $row['Time'];?><b></td>	
						<td><b><?php echo $row['Date'];?><b></td>
					
			
                  
                    </tr>
			<?php	   }  
					   
					   
					   
					   } $db->close();  ?>
				
            </tbody>
        </table>

       


  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <script>window.jQuery || document.write('<script src="script/js/jquery.min.js"><\/script>')</script>
    <script src="script/js/bootstrap.min.js"></script>

    <script src="script/js/vendor/holder.min.js"></script>

    <script src="script/js/ie10-viewport-bug-workaround.js"></script>

</body>
</html>

