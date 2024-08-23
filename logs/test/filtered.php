<?php

session_start();
ob_start();

 if (isset($_POST['back'])) 
 {

session_start();
session_destroy();
$_SESSION = array();

header('location: alldevicelog.php');
 }
  else
  {
    
  }
?>

<!DOCTYPE html>
<html>
<head>
    
    <meta http-equiv="refresh" content="10">
    <link href="scripts/css/bootstrap.min.css" rel="stylesheet">
    <link href="scripts/css/Dashboard.css" rel="stylesheet">

    <link href="scripts/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <link href="scripts/css/dashboard.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>


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
        <a  class="alldevicelog" href="alldevicelog.php">All Device Log</a>  
         <a  class="active" href="Filtered.php">Filtered Records</a> 
        <a  href="gasdevice.php">LPG Alarm System</a>   
        <a  href="meter_reading_log.php">Meter Reading Log</a>
        <a  href="lcd.php">LCD System</a> 
        <a  href="login.php" style="float:right">Log Out</a>
    </div>
  
 <div class="container">
     <div class= "row">
       <div class="form-inline">
        
                <!-- <p style="margin-top: 10px; font: italic small-caps bold 24px Georgia, sans-serif;"><b>Results</b></p> -->
                <form action="" method ="POST" >
                   
  <!--                  <div class="form-group">
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
                </div> -->

               

&laquo;&laquo;<input type="submit" class="btn btn-link" name="back" value="Go back" style="font-style: italic; font-size: 16px; ">

           </form>
        
       </div>
    </div>
      </div>


      <div style="margin-left: 45%; margin-bottom: 15px;">
        <select style="width: 150px;" id="purpose" class="btn btn-info" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
            <option>Data Records</option>
            <option value="Filtered.php">Filtered Records</option>
            <option value="alldevicelog.php">All Records</option>
        </select>
    </div>

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
     //  echo  "DB Connected Successfully";
}

 
    $Device_Address=$_SESSION['Device'];
    $Mac_Address=$_SESSION['Mac'];
    $from=$_SESSION['from'] ;
    $to=$_SESSION['to'];


    $from=$_SESSION['from'] ;
    $to=$_SESSION['to'];

   // header("Refresh:50");

   ?>
    
    <div id="table1">

   
<?php 

   if((!empty($_SESSION['from']) && !empty($_SESSION['to'])) && (strlen($_SESSION['Mac'])) > 0 && (strlen($_SESSION['Device']) > 0)) 
                     {
                     
                        
                        $sql =<<<EOF
              SELECT * FROM SSTPL_UP_Data WHERE  Time BETWEEN '$from' AND '$to'
                                                 AND (MAC like '%$Mac_Address%')
                                                 AND (Address like '%$Device_Address%') ORDER BY
 Time DESC;
EOF;

                                        $ret1 = $db->query($sql);

?>
               <table class="table table-striped">
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
                        
                           while($row = $ret1->fetchArray(SQLITE3_ASSOC) ) { 
                            
            
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
                }


   elseif((strlen($_SESSION['Mac'])) > 0 && strlen($_SESSION['Device']) ==0 && (empty($_SESSION['from']) && empty($_SESSION['to'])))
   { 
    
    
    $sql =<<<EOF
    SELECT * FROM SSTPL_UP_Data WHERE MAC like '%$Mac_Address%' ORDER BY
 Time DESC; 
EOF;
     $ret1 = $db->query($sql);
 ?>
    
        <table class="table table-striped">
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
                        
                         while($row = $ret1->fetchArray(SQLITE3_ASSOC) ) { 
                            
            
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
                       }


                       elseif(strlen($_SESSION['Device']) > 0 && empty($_SESSION['from']) && empty($_SESSION['to']) && (strlen($_SESSION['Mac'])) == 0) {  

                       
                         $sql =<<<EOF
    SELECT * FROM SSTPL_UP_Data WHERE  Address ='$Device_Address' ORDER BY
 Time DESC; 
EOF;
     $ret1 = $db->query($sql);

            ?>
            
                <table class="table table-striped">
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
                        
                           while($row = $ret1->fetchArray(SQLITE3_ASSOC) ) { 
                            
            
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
                             
                             }

                       elseif (!empty($_SESSION['from']) && !empty($_SESSION['to']) && empty($_SESSION['Mac']) && empty($_SESSION['Device'])) {
                        
                $sql =<<<EOF
    SELECT * FROM SSTPL_UP_Data WHERE Time BETWEEN '$from' AND '$to' ORDER BY
 Time DESC; 
EOF;
     $ret1 = $db->query($sql);


   ?>
    
                  <table class="table table-striped">
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
                        
                           while($row = $ret1->fetchArray(SQLITE3_ASSOC) ) { 
                            
            
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
                     
                       }


elseif((empty($_SESSION['from']) && empty($_SESSION['to']))  && strlen($_SESSION['Device']) > 0 && strlen($_SESSION['Mac']) > 0)
   { 

    $sql =<<<EOF
    SELECT * FROM SSTPL_UP_Data WHERE MAC like '%$Mac_Address%'
                         AND Address like '%$Device_Address%' ORDER BY
 Time DESC; 

EOF;

     $ret1 = $db->query($sql);

  ?>
    
                <table class="table table-striped">
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
                        
                           while($row = $ret1->fetchArray(SQLITE3_ASSOC) ) { 
                            
            
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
                       }



elseif(strlen($_SESSION['Device']) == 0 && strlen($_SESSION['Mac']) > 0 && !empty($_SESSION['from']) && !empty($_SESSION['to'])) 
                     {

              $sql =<<<EOF
              SELECT * FROM SSTPL_UP_Data WHERE  Time BETWEEN '$from' AND '$to'
                                                AND (MAC like '%$Mac_Address%') ORDER BY
 Time DESC;
                                                 
EOF;

                                        $ret1 = $db->query($sql);

?>
                                         <table class="table table-striped">
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
                        
                           while($row = $ret1->fetchArray(SQLITE3_ASSOC) ) { 
                            
            
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
                }


elseif((!empty($_SESSION['from']) && !empty($_SESSION['to']) && strlen($_SESSION['Device']) > 0))
                     {
                        
              $sql =<<<EOF
              SELECT * FROM SSTPL_UP_Data WHERE  Time BETWEEN '$from' AND '$to'
                                                 AND (Address like '%$Device_Address%') ORDER BY Time DESC;


EOF;

            $ret1 = $db->query($sql);

?>




                 <table class="table table-striped">
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
                        
                           while($row = $ret1->fetchArray(SQLITE3_ASSOC) ) { 
                            
            
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
                }



                   else{
                    echo $_SESSION['error'] ;


           }


                   ?>

                        
            </tbody>
          </table>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <script>window.jQuery || document.write('<script src="script/js/jquery.min.js"><\/script>')</script>
    <script src="script/js/bootstrap.min.js"></script>

    <script src="script/js/vendor/holder.min.js"></script>

    <script src="script/js/ie10-viewport-bug-workaround.js"></script>

        </div> 
        
<!-- <script>
    setTimeout(function(){
       window.location.href = 'Filtered.php';
    }, 5000);

</script>
 -->

</body>
</html>

