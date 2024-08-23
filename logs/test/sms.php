<?php

  //echo "inside sms.php";

	// Account details
	$apiKey = urlencode('33evHkAR1zY-krzaIPwGlK0Zos4vUQdly7ZO9Muv8E');
	
	// Message details
	$numbers = array(8171189589,9001694400);
	$sender = urlencode('TXTLCL');
	$message = rawurlencode('SSTPL GAS LEAK ALERT . Power CUT TEMPORARILY');
 
	$numbers = implode(',', $numbers);
 
	// Prepare data for POST request
	$data = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message);
 
	// Send the POST request with cURL
	$ch = curl_init('https://api.textlocal.in/send/');
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$response = curl_exec($ch);
	curl_close($ch);
	
	// Process your response here
	// echo $response;
	

	$db->exec('update SSTPL_UP_Data
				set sms_sent = 1
				where rowid='.$row['max']);
	// echo $row['sms_sent'];
	
?>
