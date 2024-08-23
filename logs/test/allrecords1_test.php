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
  $email="'".trim($_GET['email'])."'";
  $product="'".trim($_GET['product'])."'" ;

  $sql =<<<EOF
      SELECT RowId,* from Records where email= $email and product= $product ;
EOF;
 //  echo $sql;


	 if(isset($_GET['from']) && isset($_GET['to']) )
  {
	  $from="'".trim($_GET['from'])."'";
	  $to="'".trim($_GET['to'])."'";
	  $sql =<<<EOF
      SELECT RowId,* from Records where email= $email and product= $product and time between $from AND $to ;
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
      SELECT RowId,* from Records where email= $email and product= $product;
EOF;

   } 
   
	if(isset($_GET["val"]))
	{
		$i = $_GET['val'];
		$sql =<<<EOF
      SELECT RowId,* from Records where email= $email and product= $product order by $i ;
	EOF;
		
		
	}
    else {

  $sql =<<<EOF
      SELECT RowId,* from Records where email= $email and product= $product;
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

	<?php /*
	$nm=  ('<script>window.onload=function(){
   return document.getElementById("myTable").rows[1].cells[0].innerHTML;
}; </script>');
	echo $nm;  */
	?>
	
    <title>User Record</title>

</head>
<body>
    <div class="topnav" style="background-color:orange">
 
   <a  href="lcd_test.php" >LCD System</a> 
  
   <a  href="addrecord_test.php">Add Product</a>
   <a  class="active" href="allrecords_test.php">LCD Users</a>
   <a href="login_test.php" style="float:right">Log Out</a>
</div>
 
  <?php $link1= 'allrecords1_test.php?email='.$_GET['email'] .'& product='. $_GET['product'] ;?>
    
    <div>
        <center>
            <p><b>Search</b></p>
            <form action="allrecords1_test.php?email=rj@gmail.com & product=LPG Sensor" >
                From:
                <input type="date" name="from" style="width:270px">
                &nbsp;&nbsp;
                To:
                <input type="date" name="to" style="width:270px">
				
				<input type="text" name="email" value="<?php echo $_GET['email'] ?>" hidden>
				<input type="text" name="product" value="<?php echo $_GET['product'] ?>" hidden>
                <input type="submit">
            </form>
        </center>
    </div><hr/> <br/><br/>
    <div class="table-responsive">
        <table class="table table-striped" id="myTable">
            <thead>

                <tr>

					<th><a href="allrecords1_test.php?val=name&email=<?php echo $_GET['email'];?>&product=<?php echo $_GET['product'];?>"><font style="color:white">Name</font></a></th>
					<th><a href="allrecords1_test.php?val=email&email=<?php echo $_GET['email'];?>&product=<?php echo $_GET['product'];?>"><font style="color:white">Email</font></a></th>
				<!--//	<th><a href="allrecords1.php?val=pass&email=<?php echo $_GET['email'];?>&product=<?php echo $_GET['product'];?>">Password</a></th> -->
					<th><a href="allrecords1_test.php?val=product&email=<?php echo $_GET['email'];?>&product=<?php echo $_GET['product'];?>"><font style="color:white">Product</font></a></th>
				<!--//	<th><a href="allrecords1.php?val=phone&email=<?php echo $_GET['email'];?>&product=<?php echo $_GET['product'];?>">Phone</a></th>  -->
                                         <th><a href="allrecords1_test.php?val=product_id&email=<?php echo $_GET['email'];?>&product=<?php echo $_GET['product_id'];?>"><font style="color:white">Product Id</font></a></th>
					<th><a href="allrecords1_test.php?val=product_address&email=<?php echo $_GET['email'];?>&product=<?php echo $_GET['product'];?>"><font style="color:white">Product Address</font></a></th>
                                       
					<th><a href="allrecords1_test.php?val=product_type&email=<?php echo $_GET['email'];?>&product=<?php echo $_GET['product'];?>"><font style="color:white">Product Type</font></a></th>
					<th><a href="allrecords1_test.php?val=activate&email=<?php echo $_GET['email'];?>&product=<?php echo $_GET['product'];?>"><font style="color:white">Activate</font></a></th>
					<th><a href="allrecords1_test.php?val=key&email=<?php echo $_GET['email'];?>&product=<?php echo $_GET['product'];?>"><font style="color:white"> Key</font></a></th>
					<th><a href="allrecords1_test.php?val=time&email=<?php echo $_GET['email'];?>&product=<?php echo $_GET['product'];?>"><font style="color:white">Time</font></a></th>

                </tr>
            </thead>
            <tbody>
			<?php	
				
				
			
     	       while($row = $ret->fetchArray(SQLITE3_ASSOC) ) {
   
			?>
                    <tr>
						
                        <td><?php echo $row['name']; ?></td> 
                        <td><?php echo $row['email'] ?></td>
                  <!--//      <td><?php echo $row['pass'] ?> </td>  -->
				 <td><?php echo $row['product'] ?> </td> 
				<!--//		<td><?php echo $row['phone'] ?> </td>   -->
                                                <td><?php echo $row['product_id'] ?> </td>
						<td><?php echo $row['product_address'] ?> </td>
						<td><?php echo $row['product_type'] ?> </td>
						<td><?php $t=($row['activate']==1? "Activated":"Deactivated" ) ;echo $t;?> </td>
						<td><?php echo $row['key'] ?> </td>
						<td><?php echo $row['time'] ?> </td>
					
						
					<?php	
						if($row['requested']==1) 
								{ $enbl= "disabled";} else { $enbl ="enabled"; } 
				   
				if($row['activate']==1) 
								{ $var= "DEACTIVATE";} else { $var ="ACTIVATE"; } ?>
						<td><a href="allrecords1_test.php?id=<?php echo $row['rowid'] ?>&email=<?php echo trim($_GET['email']) ?>&product=<?php echo trim($_GET['product']) ?>" style="text-decoration:none"><input type="submit" value="<?php echo $var ?>" style="width:150px" <?php echo $enbl ?>/> </a></td>
                  
						<td><a href="viewhistory_test.php?addrs=<?php echo $row['product_address'] ;?>"> View History </a></td>
                    </tr>
          <?php     } $db->close();  ?>
				
            </tbody>
        </table>
</div>



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <script>window.jQuery || document.write('<script src="script/js/jquery.min.js"><\/script>')</script>
    <script src="script/js/bootstrap.min.js"></script>

    <script src="script/js/vendor/holder.min.js"></script>

    <script src="script/js/ie10-viewport-bug-workaround.js"></script>

</body>
</html>
