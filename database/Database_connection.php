<?php

//Database_connection.php

class Database_connection
{
	function connect()
	{
		$connect = new PDO("mysql:host=127.0.0.1:3306; dbname=prod_ocl", "dev", "Dev@1234");

		return $connect;
	}
}

?>
