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
      SELECT * from Records;
EOF;

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
            bottom: 10%;
            width: 100%;
            height: 60px;
        }
    </style>

    <title>User Record</title>

</head>
<body>
    <div style="float:right"><a href="@Href("~/Default")">Logout</a></div>
    <h2 class="sub-header">
        User Records
    </h2>

    <?php include ('form.php'); ?>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>

                <tr>

                    <th>Name</th>
                    <th>Email</th>
                    <th>Password</th>
                    <th>Product</th>
                    <th>Phone</th>
                    <th>Product Address</th>
                    <th>Product Type</th>
                    <th>Activate</th>
                    <th> Key</th>
                    <th>Time</th>

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
						
					<?php	if($row['activate']==1) 
								{ $var= "ACTIVATE";} else { $var ="DEACTIVATE"; } ?>
						<td><input type="submit" value="<?php echo $var ?>" /> </td>
                  
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
