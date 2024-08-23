-

<h2>Add Record</h2>
<p><span class="error">* required field.</span></p>



<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
  
 Name: <input type="text" name="name" value="<?php echo $name;?>">
	<span class="error">* <?php echo $nameErr;?></span>
  <br><br>
 E-mail: <input type="text" name="email" value="<?php echo $email;?>">
  <span class="error">* <?php echo $emailErr;?></span>
  <br><br>
 Password: <input type="password" name="password" value="<?php echo $pass;?>">
	<span class="error">* <?php echo $passErr;?></span>
  <br><br>
 Product: <input type="text" name="product" value="<?php echo $product;?>">
	<span class="error">* <?php echo $productErr;?></span>
  <br><br>

 Phone: <input type="text" name="phone" value="<?php echo $phone;?>">
	<span class="error">* <?php echo $phoneErr;?></span>
 <br><br>

 Product Address: <input type="text" name="product_address" value="<?php echo $product_address;?>">
	<span class="error">* <?php echo $product_addressErr;?></span>

	<br><br>
 Product Type : <select name="product_type">
  <option ><?php echo $product_type;?> </option>
  <option value="classA">class A</option>
  <option value="classB">class B</option>
  <option value="classC">class C</option>
</select>
  <span class="error">* <?php echo $product_typeErr;?></span>
 <br><br>
      Activate:
  <input type="radio" name="activate" <?php if (isset($activate) && $activate== 1) echo "checked";?> value=1>Activate
  <input type="radio" name="activate" <?php if (isset($activate) && $activate== 0) echo "checked";?> value=0>Activate Later
  <span class="error"> <?php echo $activateErr;?></span>
  <br><br>  

  
  
 Key : <input type="text" name="key" value="<?php echo $key  ;?>" readonly/> 
  &nbsp;&nbsp;
 
  <input type="submit" name="submit" value="Generate">   <br/><br/>
  
</form>

<form  action="/allrecords.php">  
<input type="submit" name="continue" value="Continue >>" /> 
</form>



</body>
</html>
