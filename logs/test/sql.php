<?php

$dsn = 'dblib:host=192.168.67.10;dbname=SSTPL_UP_Data';
$user = 'SA';
$password = 'Sstpl@21012015';

try
{
    $pdo_object = new PDO($dsn, $user, $password);
}
catch (PDOException $e)
{
    echo 'Connection failed: ' . $e->getMessage();
}

/*
$sql = "SELECT * from <some table>";
$pdo_statement_object = $pdo_object->prepare($sql);
$pdo_statement_object->execute();
// $result = $pdo_statement_object->fetch(PDO::FETCH_ASSOC);
$result = $pdo_statement_object->fetchAll();
print_r($result);
*/
?>
