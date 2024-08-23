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
     DELETE  from Records where email in ('email')  ;
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
    <div class="topnav" style="background-color:orange">
  <a href="addrecord_test.php">Add Product</a>
  <a class="active" href="allrecords_test.php">LCD Users</a>
  <a  href="lcd_test.php" >LCD System</a> 
  <a href="login_test.php" style="float:right">Log Out</a>
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

 <div>



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <script>window.jQuery || document.write('<script src="script/js/jquery.min.js"><\/script>')</script>
    <script src="script/js/bootstrap.min.js"></script>

    <script src="script/js/vendor/holder.min.js"></script>

    <script src="script/js/ie10-viewport-bug-workaround.js"></script>

</body>
</html>
