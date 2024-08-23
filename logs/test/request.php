<?php
   class MyDB extends SQLite3 {
      function __construct() {
       $this->open('/home/richa/database/Ssptl_UPLINK.db');

      }
   }

   
   $db = new MyDB();
   if(!$db) {
      echo $db->lastErrorMsg();
   } else {
    //  echo "Opened database successfully\n";
   }

  $sql =<<<EOF
      SELECT RowId,* from Records where requested=1;
EOF;


  if(isset($_GET['from']) && isset($_GET['to']) )
  {
	  $from="'".trim($_GET['from'])."'";
	  $to="'".trim($_GET['to'])."'";
	  $sql =<<<EOF
      SELECT RowId,* from Records where requested=1 and time >= $from AND time <= $to ;
EOF;
	 // echo $sql;
  }

   
   if (isset($_GET['id']) && is_numeric($_GET['id']))
   {
	   $i = $_GET['id'];
	   
	   	   $sql =<<<EOF
      SELECT RowId,* from Records where rowid=$i;
EOF;
	   
	   $ret = $db->query($sql);
	   $row = $ret->fetchArray(SQLITE3_ASSOC) ;
	   
	   if($row["activate"]==0)
	   {
        $sql =<<<EOF
        update Records set requested = 0 , activate =1  where rowid= $i;
EOF;
	   }
	   else  if($row["activate"]==1)
		 {
        $sql =<<<EOF
        update Records set requested = 0 , activate =0  where rowid= $i;
EOF;
	   }
	   $ret = $db->query($sql);
	   
	   $sql =<<<EOF
      SELECT RowId,* from Records where requested=1;
EOF;

   }

  if(isset($_GET["val"]))
	{
		$i = $_GET['val'];
		$sql =<<<EOF
      SELECT RowId,* from Records where requested=1 order by $i ;
	EOF;
		
		
	}
    else {

  $sql =<<<EOF
       SELECT RowId,* from Records where requested=1 ;
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
  <a class="active" href="request.php">Requests</a>
  <a href="addrecord.php">Add Product</a>
  <a href="allrecords.php">All Users</a>
  <a  href="alldevicelog.php">All Device Log</a>  
  <a  href="gasdevice.php">LPG Alarm System</a>  
		<a  href="meter_reading_log.php">Meter Reading Log</a>
  <a href="login.php" style="float:right">Log Out</a>
</div>
	
   

<?php include ('form.php'); ?> <br/><br/>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>

                <tr>

					<th><a href="request.php?val=name"><font style="color:white">Name</font></a></th>
					<th><a href="request.php?val=email"><font style="color:white">Email</font></a></th>
					<th><a href="request.php?val=pass"><font style="color:white">Password</font></a></th>
					<th><a href="request.php?val=product"><font style="color:white">Product</font></a></th>
					<th><a href="request.php?val=phone"><font style="color:white">Phone</font></a></th>
					<th><a href="request.php?val=product_address"><font style="color:white">Product Address</font></a></th>
					<th><a href="request.php?val=product_type"><font style="color:white">Product Type</font></a></th>
					<th><a href="request.php?val=activate"><font style="color:white">Activate</font></a></th>
					<th><a href="request.php?val=key"> <font style="color:white">Key</font></a></th>
					<th><a href="request.php?val=time"><font style="color:white">Time</font></a></th>
					<th>Request</th>
					<th>Approve</th>

                </tr>
            </thead>
            <tbody>
			<?php	
				
				
			
     	       while($row = $ret->fetchArray(SQLITE3_ASSOC) ) {
   
			?>
                    <tr>
						
                        <td><?php echo $row['name'] ?></td>
                        <td><?php echo $row['email'] ?></td>
                        <td><?php echo $row['pass'] ?> </td>
						<td><?php echo $row['product'] ?> </td>
						<td><?php echo $row['phone'] ?> </td>
						<td><?php echo $row['product_address'] ?> </td>
						<td><?php echo $row['product_type'] ?> </td>
						<td><?php echo $row['activate'] ?> </td>
						<td><?php echo $row['key'] ?> </td>
						<td><?php echo $row['time'] ?> </td>
					
						
					<?php	
						if($row['requested']==1) 
								{ $enbl= "disabled";} else { $enbl ="enabled"; } 
				   
				if($row['activate']==1) 
								{ $var= "DEACTIVATE";} else { $var ="ACTIVATE"; } ?>
						<td> <?php echo $var ?> </td>
                        
						<td><a href="request.php?id=<?php echo $row['rowid'] ?>" style="text-decoration:none"> <input type="submit" value="OK" style="width:150px"/></a></td>
                    </tr>
          <?php     } $db->close();  ?>
				
            </tbody>
        </table>

        <div class="pagination" id="footer" style="margin-left:35%">
            <a href="@Href("~/allrecord_pagination.cshtml", i-1)" class="active">&laquo; Prev</a>
        </div>
        <div class="pagination" id="footer" style="margin-left:45%">@i</div>
        <div class="pagination" id="footer" style="margin-left:50%">
            <a href="@Href("~/allrecord_pagination.cshtml",i+1)" class="active">Next &raquo;</a>
        </div>
    </div>




    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <script>window.jQuery || document.write('<script src="script/js/jquery.min.js"><\/script>')</script>
    <script src="script/js/bootstrap.min.js"></script>

    <script src="script/js/vendor/holder.min.js"></script>

    <script src="script/js/ie10-viewport-bug-workaround.js"></script>

</body>
</html>
