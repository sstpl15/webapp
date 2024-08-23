	<?php
    $password = 'SStpl@21012015';
	$user= 'admin';
	$data = array('password' => $password, 'username' => $user);
 
	// Send the POST request with cURL
	$ch = curl_init('https://localhost:8080/api/nodes/0000000000000004/frames?limit=1&offset=0');
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	$response = curl_exec($ch);
	curl_close($ch);
	
	// Process your response here
	 echo $response;


curlPost('google.com', [
    'username' => 'admin',
    'password' => '12345',
]);

?>