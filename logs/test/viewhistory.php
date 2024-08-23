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
	$i = ($var == 0) ? 1 : $var;
   }
else $i=1;

   $db = new MyDB();
   if(!$db) {
      echo $db->lastErrorMsg();
   } else {
    //  echo "Opened database successfully\n";
   }

 /*   $sql =<<<EOF
    
	  SELECT RowId, Address,MAC,Time,freq,Modulation,Data_Rate,Code_Rate,RSSI,LORA_SNR,Frame_length,PAYLOAD from SSTPL_UP_Data order by Time DESC LIMIT 50 ;
EOF;  */

if(isset($_GET['addrs']))  $addrs="'".$_GET['addrs']."'";


  $sql =<<<EOF
    
	  SELECT s.RowId as rowid, Address,MAC,s.Time as Time,freq,Modulation,Data_Rate,Code_Rate,RSSI,LORA_SNR,Frame_length,PAYLOAD from SSTPL_UP_Data as s  where s.Address=$addrs order by s.Time DESC;
EOF;


	if(isset($_GET['to']) && isset($_GET['from']) )
	{
		$to="'".$_GET['to']."'";
		$from="'".$_GET['from']."'";
		 $sql =<<<EOF
    
	  SELECT s.RowId as rowid, Address,MAC,s.Time as Time,freq,Modulation,Data_Rate,Code_Rate,RSSI,LORA_SNR,Frame_length,PAYLOAD from SSTPL_UP_Data as s   where s.Address=$addrs AND s.Time BETWEEN $from AND $to order by s.Time DESC;
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

	$ret = $db->query($sql);

				
?>

<!DOCTYPE html>
<html>
<head>
    
 
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
   

</head>
<body>
    <div class="topnav">
  <a  href="request.php">Requests</a>
  <a href="addrecord.php">Add Product</a>
  <a  href="allrecords.php">All Users</a>
 <a  class="active" href="alldevicelog.php">All Device Log</a>  
  <a  href="gasdevice.php">LPG Alarm System</a>  
		<a  href="meter_reading_log.php">Meter Reading Log</a>
  <a href="login.php" style="float:right">Log Out</a>
	</div>
    <h2 class="sub-header">
        User Records
    </h2>
	

    <div>
        <center>
            <p><b>Search</b></p>
            <form action=" " >
                From:
                <input type="date" name="from" style="width:270px">
                &nbsp;&nbsp;
                To:
                <input type="date" name="to" style="width:270px">
				<input type="text" name="addrs" value=<?php echo $_GET['addrs']; ?> style="width:270px" hidden/>
                <input type="submit">
            </form>
        </center>

    </div>
	<hr/><br/><br/>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>

                <tr>

					<th>Device Address</th>
					<th>Mac Address</th>
					<th>Time</th>
					<th>Freq</th>
					<th>Modulation</th>
					<th>Data_Rate</th>
					<th>Code_Rate</th>
					<th>RSSI</th>
					<th> LORA_SNR</th>
					<th>Frame_length</th>
					<th>PAYLOAD</th>

                </tr>
            </thead>
            <tbody>
			<?php	
				
				
			
     	       while($row = $ret->fetchArray(SQLITE3_ASSOC) ) {
   
			?>
                    <tr>
						
                        <td><?php echo $row['Address'] ?></td>
                        <td><?php echo $row['MAC'] ?></td>
                        <td><?php echo $row['Time'] ?> </td>
						<td><?php echo $row['freq'] ?> </td>
						<td><?php echo $row['Modulation'] ?> </td>
						<td><?php echo $row['Data_Rate'] ?> </td>
						<td><?php echo $row['Code_Rate'] ?> </td>
						<td><?php echo $row['RSSI'] ?> </td>
						<td><?php echo $row['LORA_SNR'] ?> </td>
						<td><?php echo $row['Frame_length'] ?> </td>
					    <td><?php echo $row['PAYLOAD'] ?> </td>
						
					
			
                  
                    </tr>
          <?php     } $db->close();  ?>
				
            </tbody>
        </table>

        <div class="pagination" id="footer" style="margin-left:35%">
           
    </div>




    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <script>window.jQuery || document.write('<script src="script/js/jquery.min.js"><\/script>')</script>
    <script src="script/js/bootstrap.min.js"></script>

    <script src="script/js/vendor/holder.min.js"></script>

    <script src="script/js/ie10-viewport-bug-workaround.js"></script>

</body>
</html>
