<?php

//Database_connection.php

class Database_connection
{
	function connect()
	{
		$connect = new PDO("mysql:host=localhost:3506; dbname=beta01studin", "root", "pass$123");

		return $connect;
	}
}

?>