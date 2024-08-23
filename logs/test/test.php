<?php
 

 
$dsn = "pgsql:host=localhost;port=5432;dbname=loraserver_ns;user=loraserver_ns;password=dbpassword";
 
try{
	// create a PostgreSQL database connection
	$conn = new PDO($dsn);
 
	// display a message if connected to the PostgreSQL successfully
	if($conn){
		echo "Connected to the database successfully!";
	}

	$sql_create_dept_tbl = <<<EOSQL
CREATE TABLE SSTPL_UP_Data(
  PAYLOAD int(11) NOT NULL AUTO_INCREMENT,
  name varchar(255) DEFAULT NULL,
  PRIMARY KEY (department_no)
) ENGINE=InnoDB
EOSQL;


}catch (PDOException $e){
	// report error message
	echo $e->getMessage();
}
