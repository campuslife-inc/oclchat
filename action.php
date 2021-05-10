<?php

//action.php

session_start();

require_once('database/Database_connection.php');
		$db = new Database_connection();
		
		$connect =$db->connect();
		
		//$this->connect = $db->connect();

if(isset($_POST['action']) && $_POST['action'] == 'leave')
{
	require('database/ChatUser.php');

	$user_object = new ChatUser;

	$user_object->setUserId($_POST['user_id']);

	$user_object->setUserLoginStatus('Logout');

	if($user_object->update_user_login_data())
	{
		unset($_SESSION['user_data']);

		session_destroy();

		echo json_encode(['status'=>1]);
	}
}


if(isset($_POST['action']) && $_POST['action']=='fetch_chat'){
	
	//require 'database/privateChat.php';
	
	//$private_chat_object= new PrivateChat;
	
	$to_user_id=$_POST['to_user_id'];
	
	$from_user_id=$_POST['from_user_id'];
	
	
	$query="select a.user_name as from_user_name,b.user_name as to_user_name , chat_message,timestamp,status,to_user_id,from_user_id from (chat_message 
		inner join chat_user_table a on chat_message.from_user_id = a.user_id) inner join chat_user_table b on chat_message.to_user_id = b.user_id 
		where (chat_message.from_user_id = :from_user_id and chat_message.to_user_id = :to_user_id) or 
		(chat_message.from_user_id = :to_user_id and chat_message.to_user_id = :from_user_id)";
		
		
		$statement = $connect->prepare($query);
		$statement->bindParam('from_user_id',$from_user_id);
		$statement->bindParam('to_user_id',$to_user_id);
		$statement->execute();
		//return $statement->fetchAll(PDO::FETCH_ASSOC);
	
	echo json_encode($statement->fetchAll(PDO::FETCH_ASSOC));
}

if(isset($_POST['action']) && $_POST['action']=='save_chat'){
	
	$user_id=$_POST['user_id'];
	$msg=$_POST['msg'];
	$receiver_userid=$_POST['receiver_userid'];
	$datetime=$_POST['datetime'];
	$status = 'Yes';
	
	
			$query="insert into chat_message (to_user_id,from_user_id,chat_message,timestamp,status) 
		values (:to_user_id,:from_user_id,:chat_message,:timestamp,:status)";
		
		$statement = $connect->prepare($query);
		
		$statement->bindParam(':to_user_id',$receiver_userid);
		
		$statement->bindParam(':from_user_id',$user_id);
		
		$statement->bindParam(':chat_message',$msg);
		
		$statement->bindParam(':timestamp',$datetime);
		
		$statement->bindParam(':status',$status);
		
		$statement->execute();
	
	
	echo $connect->lastInsertId();
}

?>