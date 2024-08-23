<html lang="en">
<head>
  <title>Filter Form</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container">
     <div class= "row">
       <div class="form-inline">
        <center>
                <p style="margin-top: 30px; font: italic small-caps bold 25px Georgia, sans-serif;"><b>Search</b></p>
                <form action="" method ="POST" style="padding-top: 15px;" >
                   
                   <div class="form-group">
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

                    <input type="submit" class="btn btn-success" name= "submit" style="width: 100px;">
                </div>
         </center>
        </div>
      </div>
    </div>

<hr/>

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
  if(isset($_POST['submit'])){
    $Device_Address=$_POST['Device_Address'];
    $Mac_Address=$_POST['Mac_Address'];
    $from=$_POST['from'];
    $to=$_POST['to'];
   

   if ((!empty($_POST['from']) && ($_POST['to'])) && (!empty($_POST['Mac_Address'])) && (!empty($_POST['Device_Address']))) 
                     {
                        echo "multi";
                        
                        $sql =<<<EOF
              SELECT * FROM SSTPL_UP_Data WHERE  Time BETWEEN '$from' AND '$to'
                                                 AND (MAC like '%$Mac_Address%')
                                                 AND (Address like '%$Device_Address%');
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



elseif((!empty($_POST['from']) && !empty($_POST['to'])) && (!empty($_POST['Mac_Address'])) || (!empty($_POST['Device_Address']))) 
                     {
                        echo "multi2";
                        
                        $sql =<<<EOF
              SELECT * FROM SSTPL_UP_Data WHERE  Time BETWEEN '$from' AND '$to'
                                                 AND (MAC like '%$Mac_Address%')
                                                 OR (Address like '%$Device_Address%');
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


elseif( (!empty($_POST['Mac_Address'])) && (!empty($_POST['Device_Address']))) 
                     {
                        echo "works";
                        
                        $sql =<<<EOF
              SELECT * FROM SSTPL_UP_Data WHERE  
                                                 MAC like '%$Mac_Address%'
                                                 AND (Address like '%$Device_Address%');
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


   elseif(strlen($_POST['Mac_Address']) >0)
   { 
   // echo "mac";
    
    $sql =<<<EOF
    SELECT * FROM SSTPL_UP_Data WHERE MAC like '%$Mac_Address%'; 
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





                       elseif (strlen($_POST['Device_Address']) > 0 ) {
                       // echo "device";
                       
                         $sql =<<<EOF
    SELECT * FROM SSTPL_UP_Data WHERE  Address like '%$Device_Address%'; 
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

                       elseif (!empty($_POST['from']) && !empty($_POST['to'])) {
                       // echo "date";
                 
                $sql =<<<EOF
    SELECT * FROM SSTPL_UP_Data WHERE Time BETWEEN '$from' AND '$to'; 
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
                          #code
                       }
                   
  }
                   ?>
                        
                    </tbody>
        </table>

<!-- <script type="text/javascript">
  

var dis1 = document.getElementById("Device_Address");
dis1.onchange = function () {
   if (this.value != "" || this.value.length > 0) {
      document.getElementById("Mac_Address").disabled = true;
     
   }
}
   var dis2=document.getElementById("Mac_Address");
   dis2.onchange = function () {

   if (this.value != "" || this.value.length > 0) {
      document.getElementById("Device_Address").disabled = true;
     
   }

}

</script> -->
</body>
</html>

