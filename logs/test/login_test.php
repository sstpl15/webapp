<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Signin</title>

    <!-- Bootstrap core CSS -->
    <link href="scripts/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="scripts/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="scripts/css/signin.css" rel="stylesheet">



    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	
	<style>
form {
    border: 3px solid #f1f1f1;
}

input[type=text], input[type=password] {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    box-sizing: border-box;
}

button {
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    cursor: pointer;
    width: 100%;
}

button:hover {
    opacity: 0.8;
}

.cancelbtn {
    width: auto;
    padding: 10px 18px;
    background-color: #f44336;
}

.imgcontainer {
    text-align: center;
    margin: 24px 0 12px 0;
}

img.avatar {
    width: 40%;
    border-radius: 50%;
}

.container {
    padding: 16px;
}

span.psw {
    float: right;
    padding-top: 16px;
}

/* Change styles for span and cancel button on extra small screens */
@media screen and (max-width: 300px) {
    span.psw {
       display: block;
       float: none;
    }
    .cancelbtn {
       width: 100%;
    }
}
</style>
</head>


<body>
    <div class="container">
        	<center><h2> Welcome to SSTPL </h2></center> <br/>
       <?php


                       
                         $result = " ";
                         $selectQueryString=" ";
		
			class MyDB extends SQLite3 {
      					function __construct() {
      								 $this->open('/home/richa/database/Ssptl_UPLINK.db');

     										   }
  									   }

		
                        if ($_SERVER["REQUEST_METHOD"] == "POST")
                        {
							$db = new MyDB();
							 if(!$db) {
     									 echo $db->lastErrorMsg();
  										} else {
   											 //  echo "Opened database successfully\n";
 												}
							
							 		 $email= '"'.$_POST["email"] .'"';
									 $pass = '"'.$_POST["password"].'"' ;
							
							
							
										$sql = "
     										 SELECT * from admin where email= ".$email ." and pass= ".$pass ."";
										
									echo $sql;
							//var query = (db.QuerySingle(selectQueryString)); 
							
							$ret = $db->query($sql);
							
							//echo $ret ;
							$row = $ret->fetchArray(SQLITE3_ASSOC) ;
							
							//echo "row :" . $row;
                             $result = (empty($row) ? "false" : "true");
                          //  mail = @row.email_id;
                          //  pass = @row.password;
                          //  id = (@query.id==null?0: @query.id);
                          //  $result = $row;
						    echo $result ;
                       
                           if($result == "false")
                           {
                               $sql = "
                                 SELECT * from Records where email= ".$email ." and pass= ".$pass ."";   
                              echo $sql;
								
			      $ret = $db->query($sql);
							
							
			      $row = $ret->fetchArray(SQLITE3_ASSOC) ;
                              $result_user = (empty($row) ? "false" : "true");
                           }
                           $db->close();
                        }

                        else				
                        {   ?>
		
              	 <center> 
					 <form  method="post" action =" " >
						 
						 
				<div class="imgcontainer">
    <img src="img_avatar2.png" alt="Avatar" class="avatar" style="width:500px;height:500px">
  </div>
                    
						 
				 <div class="container">
   
				 <label for="inputEmail" ><b>Email address</b></label>

                 <input type="email" name="email" value="" id="inputEmail"  placeholder="Email address" style="width:250px" required autofocus/><br/>
					 
				 <label for="inputPassword" ><b>Password</b></label>

                    <input type="password" name="password" value="" id="inputPassword"  placeholder="Password" style="width:250px" required/><br/>
                     <button type="submit" style="width:100px">Login</button> <br/>
						 </div>
                </form></center>
         <?php   }  
		
		
            if ($result == "true")
            {
				header("Location: lcd_test.php");
				exit();
                
              //  Response.Redirect(@Href("~/dashboard1", row.id));
            }
            if ($result == "false")
            {
                  if ($result_user == "true")
                    {
				header("Location: lcd_test.php");
				exit();
                    }   
                  if ($result_user == "false")
                    {
				header("Location: login_test.php ");
				exit();
                    	}    
               // Response.Redirect(@Href("~/Default"));
            }
		
            ?>
    </div>

    <script src="scripts/js/ie10-viewport-bug-workaround.js"></script>

</body>
</html>

