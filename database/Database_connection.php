<?php

//Database_connection.php

class Database_connection
{
	function connect()
	{
		$connect = new PDO("mysql:host=localhost:3306; dbname=dev-ocl", "root", "MySQL123@");

		return $connect;
	}
}

?>
