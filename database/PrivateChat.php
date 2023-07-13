<?php
//PrivateChat.php
class PrivateChat
{
	private $chat_message_id;
	private $to_user_id;
	private $from_user_id;
	private $chat_message;
	private $timestamp;
	private $status;
	protected $connect;
	
	public function __construct()
	{
		require_once('Database_connection.php');
		$db = new Database_connection();
		
		$this->connect = $db->connect();
	}
	
	function setChatMessageId($chat_message_id){
	$this->chat_message_id = $chat_message_id;
	}
	
	function getChatMessageId()
	{
		return $this->chat_message_id;
	}
	
	function setToUserId($to_user_id)
	{
		$this->to_user_id = $to_user_id;
	}
	
	function getToUserId()
	{
		return $this->to_user_id;
	}
	
	function setFromUserId($from_user_id)
	{
		$this->from_user_id = $from_user_id;
	}
	
	function getFromUserId()
	{
		return $this->from_user_id;
	}
	
	function setChatMessage($chat_message)
	{
		$this->chat_message = $chat_message;
	}
	
	
	function getChatMessage()
	{
		return $this->chat_message;
	}
	
	
	function setTimestamp($timestamp)
	{
		$this->timestamp = $timestamp;
	}
	
	
	function getTimestamp()
	{
		return $this->timestamp;
	}
	
	
	function setStatus($status)
	{
		$this->status = $status;
	}
	
	
	function getStatus()
	{
		return $this->status;
	}
	
	
	
	function get_all_chat_data()
	{
		
		$query="select a.username as from_user_name,b.user_name as to_user_name , chat_message,time_stamp,status,to_user_id,from_user_id from (chat_message 
		inner join chat_user_table a on chat_message.from_user_id = a.user_id) inner join chat_user_table b on chat_message.to_user_id = b.user_id 
		where (chat_message.from_user_id = :from_user_id and chat_message.to_user_id = :to_user_id) or 
		(chat_message.from_user_id = :to_user_id and chat_message.to_user_id = :from_user_id)";
		
		
		$statement = $this->connect->prepare($query);
		$statement->bindParam('from_user_id',$this->from_user_id);
		$statement->bindParam('to_user_id',$this->to_user_id);
		$statement->execute();
		return $statement->fetchAll(PDO::FETCH_ASSOC);
		
	}
	
	function save_chat()
	{
		$query="insert into chat_message (to_user_id,from_user_id,chat_message,timestamp,status) 
		values (:to_user_id,:from_user_id,:chat_message,UTC_TIMESTAMP,:status)";
		
		$statement = $this->connect->prepare($query);
		
		$statement->bindParam(':to_user_id',$this->to_user_id);
		
		$statement->bindParam(':from_user_id',$this->from_user_id);
		
		$statement->bindParam(':chat_message',$this->chat_message);
		
		//$statement->bindParam(':timestamp',$this->timestamp);
		
		$statement->bindParam(':status',$this->status);
		
		$statement->execute();
		
		return $this->connect->lastInsertId();
	}
	
	function update_chat_status()
	{
		$query="update chat_message set status = :status where chat_message_id = :chat_message_id";
		
		$statement = $this->connect->prepare($query);
		
		$statement->bindParam(':status',$this->status);
		
		$statement->bindParam(':chat_message_id',$this->chat_message_id);
		
		$statement->execute();
		
		
	}
	
	
}
?>