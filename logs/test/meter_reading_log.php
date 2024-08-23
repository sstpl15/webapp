  <?php

$i=1;



   class MyDB extends SQLite3 {
      function __construct() {
       $this->open('/home/richa/database/Ssptl_UPLINK.db');
		

      }
   }

   

if(isset($_GET['page'] ) )
   {
	$var=$_GET['page'];
	$i = ($var <= 0) ? 1 : $var;
   }
else $i=0;


if(isset($_GET['page_first'] ) )
   {
	$var=$_GET['page'];
	$i = ($var == 0) ? 1 : $var;
   }


if(isset($_GET['page_last'] ) )
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

 /*   $sql =<<<EOF
    
	  SELECT RowId, Address,MAC,Time,freq,Modulation,Data_Rate,Code_Rate,RSSI,LORA_SNR,Frame_length,PAYLOAD from SSTPL_UP_Data order by Time DESC LIMIT 50 ;
EOF;  */
  $sql =<<<EOF
    
	  SELECT RowId, (select max(rowid) from SSTPL_UP_Data) as MAX , Address,MAC,Time,freq,Modulation,Data_Rate,Code_Rate,RSSI,LORA_SNR,Frame_length,PAYLOAD from SSTPL_UP_Data where  Address='13131313' AND CAST(PAYLOAD as int) !=0 order by Time DESC ;
EOF;

//echo $sql;
   
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

	$ret = $db->query($sql);

				
?>

<!DOCTYPE html>
<html>
<head>
    
    <meta http-equiv="refresh" content="5" >
    <link href="scripts/css/bootstrap.min.css" rel="stylesheet">

    <link href="scripts/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <link href="scripts/css/dashboard.css" rel="stylesheet">


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

    </style>
    <title>User Record</title>

</head>
<body>
    <div class="topnav">
   <img src="logo.jpeg" align="left" style="align:left;height:80px;width:100px"/>	
  <a  href="request.php">Requests</a>
  <a href="addrecord.php">Add Product</a>
  <a  href="allrecords.php">All Users</a>
 <a   href="alldevicelog.php">All Device Log</a>  
  <a  href="gasdevice.php">LPG Alarm System</a>  
		<a  class="active" href="meter_reading_log.php">Meter Reading Log</a>
  <a href="login.php" style="float:right">Log Out</a>
	</div>
  
<?php // include ('form.php'); ?> <br/><br/>
    <div class="table-responsive">
		
			<?php	
				
				  $sql1 =<<<EOF
    
	  SELECT RowId, (select max(rowid) from SSTPL_UP_Data) as MAX , Address,MAC,Time,freq,Modulation,Data_Rate,Code_Rate,RSSI,LORA_SNR,Frame_length,PAYLOAD from SSTPL_UP_Data where  Address='13131313' order by Time DESC ;
EOF;
			// echo $sql1;
		
				$ret1 = $db->query($sql1);
     	       $row1 = $ret1->fetchArray(SQLITE3_ASSOC)  ; 
   
			?>
		
		&nbsp;&nbsp;<th><b>Serial No</b></th>:&nbsp;&nbsp;<tr1><td><?php  echo hexdec(substr($row1['PAYLOAD'],44,4)) ?></td></tr1>
		

		
        <table class="table table-striped">
            <thead>

                <tr>
					<th>Time</th>
					<th>Frequency (Hz)</th>
					<th>Phase Voltage R (V)</th>
					<th>Phase Voltage Y (V)</th>
					<th>Phase Voltage B (V)</th>
					<th>Current L1 (Amp)</th>
					<th>Current L2 (Amp)</th>
					<th>Current L3 (Amp)</th>
					<th>KWH Total &nbsp;</th>
					<th>Reverse Temper</th>
					<th>Cover Open Temper</th>
					<th>Magnetic Temper</th>
					
					
					
                </tr>
            </thead>
            <tbody>
			<?php	
				
				
			
     	       while($row = $ret->fetchArray(SQLITE3_ASSOC) ) { 
				   
				  // echo (substr($row['PAYLOAD'],28,4)) ;
   
			?>
			
                    <tr>
						
						<td><?php echo $row['Time'] ?></td>
                        <td><?php echo ((hexdec(substr($row['PAYLOAD'],0,4))/10)==0?50:(hexdec(substr($row['PAYLOAD'],0,4))/10))  ?></td>
                        <td><?php echo hexdec(substr($row['PAYLOAD'],4,4))/10 ?></td>
                        <td><?php echo hexdec(substr($row['PAYLOAD'],8,4))/10 ?> </td>
						<td><?php echo hexdec(substr($row['PAYLOAD'],12,4))/10 ?> </td>
						<td><?php echo hexdec(substr($row['PAYLOAD'],16,4))/1000?> </td>
						<td><?php echo hexdec(substr($row['PAYLOAD'],20,4))/1000 ?> </td>
						<td><?php echo hexdec(substr($row['PAYLOAD'],24,4))/1000 ?> </td>
						<td><?php echo substr(hexdec(substr($row['PAYLOAD'],28,4))/1000,0,3) ?> </td>
						<td><?php echo hexdec(substr($row['PAYLOAD'],32,4)) ?> </td>
						<td><?php echo hexdec(substr($row['PAYLOAD'],36,4)) ?> </td>
					    <td><?php echo hexdec(substr($row['PAYLOAD'],40,4)) ?> </td>
						  <td><?php //echo hexdec(substr($row['PAYLOAD'],44,4)) ?> </td>
						
			
                  
                    </tr>
          <?php     } $db->close();  ?>
				
            </tbody>
        </table>

        <div class="pagination" id="footer" style="margin-left:35%">
            <a href="alldevicelog.php?page=<?php echo $i-1 ?>" class="active">&laquo; Prev</a>
        </div>
        <div class="pagination" id="footer" style="margin-left:45%"><?php echo $i ?></div>
        <div class="pagination" id="footer" style="margin-left:50%">
            <a href="alldevicelog.php?page=<?php echo $i+1 ?>" class="active">Next &raquo;</a>
        </div>
    </div>




    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <script>window.jQuery || document.write('<script src="script/js/jquery.min.js"><\/script>')</script>
    <script src="script/js/bootstrap.min.js"></script>

    <script src="script/js/vendor/holder.min.js"></script>

    <script src="script/js/ie10-viewport-bug-workaround.js"></script>

</body>
</html>
