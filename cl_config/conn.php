<?php
error_reporting(E_ERROR | E_PARSE);
session_start();
$_SESSION['timeout'] = time();
/*if(isset($_SESSION["company_code"]))
{*/

    $servername = "127.0.0.1";
    $username = "root";
    $password = "pass$123";
    $dbname = "beta01studin";
	$port="3506";

// Create connection
    $conn = new mysqli($servername, $username, $password, $dbname,$port);

// Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);

    }
	
	
	
	
	
	   // Begin Vault (this is in a vault, not actually hard-coded)
    $host="localhost";
    $username="root";
    $password="pass$123";
    $dbname="beta01studin";
    $port="3506";
    // End Vault

    try {
       $conn_pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $username, $password);
        $conn_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //echo "I am connected.<br/>";

        // ... continue with your code

        // PDO closes connection at end of script
    } catch (PDOException $e) {
        echo 'PDO Exception: ' . $e->getMessage();
       // exit();
    }
	

    $sql_details = array(
        'user' => 'root',
        'pass' => 'pass$123',
        'db'   => 'beta01studin',
        'host' => '127.0.0.1',
		'port' => '3506'
    );

    function clix_sql_error($sql_query,$php_page)
    {
        $txt = "ON '".date("d-m-Y H:i:s")."' The Query :- '".$sql_query."' :- has failed in :- '".$php_page."' ;";
        $myfile = file_put_contents('clix_error_log.txt', $txt.PHP_EOL , FILE_APPEND | LOCK_EX);
        die("error...");
    }


?>