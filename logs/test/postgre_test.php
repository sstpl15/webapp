<?php
$dbuser = 'postgres';
$dbpass = '123456';
$host = 'localhost';
$dbname='postgres';
$dbh = new PDO("pgsql:host=$host;dbname=$dbname", $dbuser, $dbpass, array(
PDO::ATTR_PERSISTENT => true));	


?>
