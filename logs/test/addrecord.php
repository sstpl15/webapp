<?php
   class MyDB extends SQLite3 {
      function __construct() {
         $this->open('/home/richa/database/Ssptl_UPLINK.db');
      }
   }
   

  
?>


<?php
// define variables and set to empty values
$nameErr = $emailErr = $genderErr = $passErr = $productErr = $phoneErr = $product_addressErr =$product_type=$key="";
$name = $email = $gender = $comment = $pass= $product = $phone =$product_address= $product_typeErr = $activateErr ="";
$flag="true";
$activate= 0;
$enable = "disabled";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
  if (empty($_POST["name"])) {
    $nameErr = "Name is required";
	  $falg="false";
  } else {
    $name = test_input($_POST["name"]);

    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
      $nameErr = "Only letters and white space allowed"; 
    }
  }


  if (empty($_POST["email"])) {
    $emailErr = "Email is required";
	  $falg="false";
	 
  } else {
    $email = test_input($_POST["email"]);
	
	
    // check if e-mail address is well-formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Invalid email format"; 
		
    }
  }

  if (empty($_POST["password"])) {
    $passErr = "Password is required";
	  $falg="false";
  } else {
    $pass = test_input($_POST["password"]);
   
    }
	
	 if (empty($_POST["product"])) {
    $productErr = "Product is required";
		 $falg="false";
  } else {
    $product = test_input($_POST["product"]);
		
    
    }
	
	if (empty($_POST["phone"])) {
    $phoneErr = "phone is required";
		$falg="false";
  } else {
    $phone = test_input($_POST["phone"]);
		
    
    }
	
	if (empty($_POST["product_address"])) {
    $product_addressErr = "Product Address is required";
		$falg="false";
  } else {
    $product_address = test_input($_POST["product_address"]);
	
    $key =  bin2hex(openssl_random_pseudo_bytes ( 6 ) ) . $product_address ;
    
    }
	
	if (empty($_POST["product_type"])) {
    $product_typeErr = "Product Type is required";
		$falg="false";
  } else {
    $product_type = test_input($_POST["product_type"]);
    
    }
  
   if (empty($_POST["activate"])) {
    $activateErr = " ";
  } else {
    $activate = test_input($_POST["activate"]);
	  
  }
  
    
  if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($flag) &&!empty($_POST["name"]) && !empty($email) && !empty($pass) && !empty($product) && !empty($phone) && !empty($product_address) && !empty($product_type)  )
{
   
  $db = new MyDB();
  
  $sql =
  "INSERT INTO Records (name,email,pass,product,phone,product_address,product_type,key,activate ) values (' ".$name."','".$email."','".$pass."','".$product."',".$phone.",'".$product_address."','".$product_type."','".$key."',".$activate.")";
	
	//echo $sql;


  
  $ret = $db->exec($sql);
   if(!$ret) {
      echo $db->lastErrorMsg();
   } else {
    //  echo "Records created successfully\n";
   }
   $db->close();
	
	$enable =" ";
}
  

}    




function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Record</title>
    <style type="text/css">
        label {
            float: left;
            width: 8em;
            text-align: right;
            margin-right: 0.5em;
        }

        fieldset {
            padding: 1em;
            border: 1px solid;
            width: 50em;
        }

        legend {
            padding: 2px 4px;
            border: 1px solid;
            font-weight: bold;
        }

        .validation-summary-errors {
            font-weight: bold;
            color: red;
            font-size: 11pt;
        }
    </style>
</head>
<body>
    <h1>Add New Record</h1>

 

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
        <fieldset>
            <legend>Add Record</legend>
            <div>
                <label>Product:</label>
                <input type="text" name="product" value="<?php echo $product;?>">
 						 <span class="error">* <?php echo $productErr;?></span>
				<br/><br/>
            </div>
            <div>
                <label>name:</label>
               <input type="text" name="name" value="<?php echo $name;?>">
 			   <span class="error">* <?php echo $nameErr;?></span>
				<br/><br/>
            </div>
            <div>
                <label>email:</label>
                <input type="text" name="email" value="<?php echo $email;?>">
  				<span class="error">* <?php echo $emailErr;?></span>
				<br/><br/>
            </div>
            <div>
                <label>Password:</label>
                <input type="password" name="password" value="<?php echo $pass;?>">
 				<span class="error">* <?php echo $passErr;?></span>
				<br/><br/>
            </div>
            <div>
                <label>Phone:</label>
                <input type="text" name="phone" value="<?php echo $phone;?>">
 				<span class="error">* <?php echo $phoneErr;?></span>
				<br/><br/>
            </div>
            <div>
                <label>Product Address:</label>
                <input type="text" name="product_address" value="<?php echo $product_address;?>">
  				<span class="error">* <?php echo $product_addressErr;?></span>
				<br/><br/>
            </div>
			   <div>
                <label> Product Type :</label>
                <select name="product_type">
  <option ><?php echo $product_type;?> </option>
  <option value="classA">class A</option>
  <option value="classB">class B</option>
  <option value="classC">class C</option>
</select>
  <span class="error">* <?php echo $product_typeErr;?></span>
				   <br/><br/>
            </div>
			 <div>
                <label> Activate:</label>
                <input type="radio" name="activate" <?php if (isset($activate) && $activate== 1) echo "checked";?> value=1>Activate
  <input type="radio" name="activate" <?php if (isset($activate) && $activate== 0) echo "checked";?> value=0>Activate Later
  <span class="error"> <?php echo $activateErr;?></span>
				 <br/><br/>
  
            </div>
			
			 <div>
                <label> Key :</label>
                <input type="text" name="key" value="<?php echo $key  ;?>" readonly/> 
          &nbsp;&nbsp;
                <input type="submit" value="Generate" class="submit" />
                <lable>&nbsp;</lable><br/><br/>
				
                
                <a href="allrecords.php">Cancel</a>
            </div>
        </fieldset>
    </form><br/>
	<form  action="single_record.php">  
<input type="submit" name="continue" value="Continue >>" <?php echo $enable;?>/> 
</form>
</body>
</html>
