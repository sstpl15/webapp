

<?php
session_start();
ob_start();
$i=1;



   class MyDB extends SQLite3 {
      function __construct() {
       $this->open('/home/richa/database/Ssptl_UPLINK.db');
		

      }
   }

   

if(isset($_GET['page']) )
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
    
	  SELECT RowId, (select max(rowid) from SSTPL_UP_Data) as MAX , Address,MAC,Time,freq,Modulation,Data_Rate,Code_Rate,RSSI,LORA_SNR,Frame_length,PAYLOAD,Fcnt from SSTPL_UP_Data where rowid between MAX-($i*50)-50 AND MAX-($i*50) order by Time DESC ;
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
    
    <meta http-equiv="refresh" content="30">
    <link href="scripts/css/bootstrap.min.css" rel="stylesheet">
    <link href="scripts/css/Dashboard.css" rel="stylesheet">

    <link href="scripts/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <link href="scripts/css/dashboard.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>


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
        <a  href="request.php">Requests</a>
        <a  href="addrecord.php">Add Product</a>
        <a  href="allrecords.php">All Users</a>
        <a  class="active" href="alldevicelog.php">All Device Log</a>  
         <a  class="Filtered.php" href="Filtered.php">Filtered Records</a> 
        <a  href="gasdevice.php">LPG Alarm System</a>  	
      	<a  href="meter_reading_log.php">Meter Reading Log</a>
      	<a  href="lcd.php">LCD System</a> 
        <a  href="login.php" style="float:right">Log Out</a>
  	</div>
  
 <div class="container">
     <div class= "row">
       <div class="form-inline">
        <center>
                <p style="margin-top: 30px; font: italic small-caps bold 25px Georgia, sans-serif;"><b>Search</b></p>
                <form action="" method ="POST" style="padding-top: 15px;" >
                   
                   <div class="form-group">
                        <input type="text" class="form-control" id ="Device_Address" name ="Device_Address" placeholder="Search by Device Address">
                   </div>&nbsp;
                    OR &nbsp;
                      <div class="form-group">
                           <input type="text" class="form-control" id ="Mac_Address" name ="Mac_Address"" placeholder="Search by Mac Address">
                      </div>&nbsp;
                   OR  &nbsp;
                    <div class="form-group">
                       <label for="from">From</label>
                          <input type="date" class="form-control" id="date1" name ="from" >
                    </div>
                    
                   <div class="form-group">
                       <label for="to">To</label>
                         <input type="date" class="form-control" id="date2" name ="to" >
                   </div>&nbsp;&nbsp;

                    <input type="submit" class="btn btn-success" name= "submit" id="tablelink" style="width: 100px;">
                </div>
         </center>
       </div>
    </div>
      </div>


      <div style="margin-left: 40%; margin-top: 3%;">
        <select style="width: 150px;" id="purpose" class="btn btn-info" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
            <option>Data Records</option>
            <option value="filtered.php">Filtered Records</option>
            <option value="alldevicelog.php">All Records</option>
        </select>
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


 if(isset($_POST['submit']) )
{

$_SESSION['Device'] = $_POST['Device_Address']; 
$_SESSION['Mac'] = $_POST['Mac_Address']; 
$_SESSION['from'] = $_POST['from']; 
$_SESSION['to'] = $_POST['to']; 


// Redirect to login 
header('location: filtered.php');

}

?>

    <div class="table-responsive" id="table2">
		
			<?php	
				
				$sql1 =<<<EOF
       select count( distinct Address) as cnt from SSTPL_UP_Data where date(Time) =(select date(DATETIME('now','localtime')) from SSTPL_UP_Data  order by rowid desc limit 1 );
EOF;
		//	echo $sql1;
		
				$ret1 = $db->query($sql1);
     	       $row1 = $ret1->fetchArray(SQLITE3_ASSOC)  ; 
   
			?>
		
			&nbsp;&nbsp;Total Devices Live Today:&nbsp;&nbsp;<tr1><td><?php echo $row1['cnt']; ?></td></tr1>
		

		
        <table class="table table-striped" style="visibility:visible">
            <thead>
              <tr>

        					<th>Device Address</th>
        					<th>Gateway Mac Address</th>
        					<th>Time</th>
        					<th>Freq &nbsp; (Hz)</th>
        					<th>Modulation</th>
        					<th>Data Rate</th>
        					<th>Code Rate</th>
        					<th>RSSI (dBm)</th>
        					<th>SNR</th>
        					<th>Payload Length</th>
        					<th>Payload</th>
                  <th>Fcnt</th>
        					<th>View Log</th>

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
                      					<td><?php echo 'SF'.$row['Data_Rate'] ?> </td>
                      					<td><?php echo $row['Code_Rate'] ?> </td>
                      					<td><?php echo $row['RSSI'] ?> </td>
                      					<td><?php echo $row['LORA_SNR'] ?> </td>
                      					<td><?php echo $row['Frame_length'] ?> </td>
                      				  <td><?php echo $row['PAYLOAD'] ?> </td>
                                <td><?php echo $row['Fcnt'] ?> </td>
                      					<td><a href="viewhistory.php?addrs=<?php echo $row['Address'] ;?>" style="text-decoration:none"> log </a></td>
                            </tr>
                  <?php     
                       } 
  
                   ?>
        				
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


 <script>
    setTimeout(function(){
       window.location.href = 'alldevicelog.php';
    }, 50000);

</script>

</body>
</html>


