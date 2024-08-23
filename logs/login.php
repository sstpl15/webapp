<!DOCTYPE html>
<html>
  <head>
    <title>Alldevice Login </title>
    <link rel="icon" type="siotel.ico" href="siotel.ico" sizes="256x256"/>

    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" crossorigin="anonymous">
  
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" type="text/css" href="Login.css">
    <script type="text/javascript" src="login.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    
  </head>
  <style type="text/css">
  body{
  background-image: url('login.jpg');
  background-repeat: no-repeat;
  background-size: cover;
  }
  </style>
  <body>

    <form name="login-form" class="login-form" action="" method="post">
    <img src="sstpl.png" height="60" width="80" style="margin-left: 30%; margin-top: 3%;">
      <div class="header">  
        <h1 style="color: #FF4500; margin-top: -15%;" >Welcome to SSTPL</h1>
       </div>
      
      <div class="content" style="color: #FF4500; margin-top: -5%;">
        <input name="username" type="text" name="username" class="input username" placeholder="Username" autofocus="" required="" />
        <div class="user-icon"></div>
        <input name="password" type="password" name="password" class="input password" placeholder="Password" required="" />
        <div class="pass-icon"></div>
      </div>
      <div class="footer">
        <input type="submit" class="button" name="login" value="Login">
      </div>
      
    </form>
    <?php
    session_start();
    require "conn.php";
    ob_start();
    if(isset($_POST['login'])){
    $username=mysqli_real_escape_string($con,$_POST['username']);
    $registeredpass=mysqli_real_escape_string($con,$_POST['password']);
    $date= date("Y-m-d h:i:s");
    //echo $registeredpass;
    $sql="select email, password from admin where email= '".$username."' AND password = '".$registeredpass."'";
    $exec=mysqli_query($con, $sql) or die(mysqli_error($con));
    $result=mysqli_num_rows($exec);
    if ( $result == 1) {
    $_SESSION['user']=$username;
    $_SESSION['credential']=$registeredpass;
    header("refresh:1; url=alldevicelog.php");
    }
    else{
    echo '<span style="color: rgb(220,0,0); font-size: 22px; font-family: cursive;">Login Failed</span>';
    }
    }
    ob_flush();
    ?>
  </body>
</html>