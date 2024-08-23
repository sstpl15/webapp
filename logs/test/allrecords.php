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
      SELECT RowId,count(product_address) as count_addrs,* from Records group by email , product;
EOF;



  if(isset($_GET['from']) && isset($_GET['to']) )
  {
	  $from="'".trim($_GET['from'])."'";
	  $to="'".trim($_GET['to'])."'";
	  $sql =<<<EOF
      SELECT RowId,count(product_address) as count_addrs,* from Records where time between $from AND $to group by email , product;
EOF;
	 // echo $sql;
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
      SELECT RowId,count(product_address) as count_addrs,* from Records group by email , product order by $i;
	EOF;
		
		
	}
    else {

  $sql =<<<EOF
      SELECT RowId,count(product_address) as count_addrs,* from Records group by email , product;
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
		   
 tr:hover {
    background-color: #FFFFE0;
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
  <a class="active" href="allrecords.php">All Users</a>
<a  href="alldevicelog.php">All Device Log</a>  
<a  href="gasdevice.php">LPG Alarm System</a>  
		<a  href="meter_reading_log.php">Meter Reading Log</a>
  <a href="login.php" style="float:right">Log Out</a>
</div>
  

    <?php include ('form.php'); ?>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>

                <tr>

					<th><a href="allrecords.php?val=name"><font style="color:white">Name</font</a></th>
						<th><a href="allrecords.php?val=email"><font style="color:white">Email</font></a></th>
					
						<th><a href="allrecords.php?val=product"><font style="color:white">Product</font></a></th>
						<th><a href="allrecords.php?val=phone"><font style="color:white">Phone</font></a></th>
					
					
					
				
						<th><a href="allrecords.php?val=time"><font style="color:white">Time</font></a></th>

                </tr>
            </thead>
            <tbody>
			<?php	
				
				
			
     	       while($row = $ret->fetchArray(SQLITE3_ASSOC) ) {
				   
   
			?>    
                    <tr onclick="document.location = 'allrecords1.php?email=<?php echo $row['email'] ?> & product=<?php echo $row['product'] ?> ';">
					 	
                        <td><?php echo $row['name'] ?></td>
                        <td><?php echo $row['email'] ?></td>
                       
						<td><?php echo $row['product'] .' ('.$row['count_addrs'].' pieces)'?> </td> 
				
						<td><?php echo $row['phone'] ?> </td>
					
					
						
						
						<td><?php echo $row['time'] ?> </td>
						<td></td>
					
				
                  
				</tr> </div></a>
          <?php     } $db->close();  ?>
				
            </tbody>
        </table>
</div>
        <div class="pagination" id="footer" style="margin-left:35%">
            <a href="@Href("~/allrecord_pagination.cshtml", i-1)" class="active">&laquo; Prev</a>
        </div>
        <div class="pagination" id="footer" style="margin-left:45%">@i</div>
        <div class="pagination" id="footer" style="margin-left:50%">
            <a href="@Href("~/allrecord_pagination.cshtml",i+1)" class="active">Next &raquo;</a>
        </div>
    </div>

</div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <script>window.jQuery || document.write('<script src="script/js/jquery.min.js"><\/script>')</script>
    <script src="script/js/bootstrap.min.js"></script>

    <script src="script/js/vendor/holder.min.js"></script>

    <script src="script/js/ie10-viewport-bug-workaround.js"></script>

</body>
</html>
