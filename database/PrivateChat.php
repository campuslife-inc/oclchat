<?php
//PrivateChat.php
class PrivateChat
{
	private $chat_message_id;
	private $chat_parent_id;
	private $to_user_id;
	private $from_user_id;
	private $chat_message;
	private $timestamp;
	private $status;
	protected $connect;
	private $replyMessageId;
	private $chatReplayId;
	
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

	function setReplyMessageId($replyMessageId)
	{
		$this->replyMessageId = $replyMessageId;
	}

	function setParentReplyMessageId($chatReplayId)
	{
		$this->chatReplayId = $chatReplayId;
	}

	// Getter for replyMessageId (optional, if needed)
    public function getReplyMessageId() {
        return $this->replyMessageId;
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
	
	// public function getReplyToMessage($replyMessageId) {

	// 	$query = "SELECT chat_message FROM chat_message WHERE chat_message_id = :replyMessageId LIMIT 1";
	// 	$statement = $this->connect->prepare($query);
	// 	$statement->bindParam(':replyMessageId', $replyMessageId, PDO::PARAM_INT);
	// 	$statement->execute();
	// 	$result = $statement->fetch(PDO::FETCH_ASSOC);
	// 	return !empty($result) ? $result['chat_message'] : null;
	// }

	public function getReplyToMessage($replyMessageId) {
		// First, search in chat_message table
		$query = "SELECT chat_message FROM chat_message WHERE chat_message_id = :replyMessageId LIMIT 1";
		$statement = $this->connect->prepare($query);
		$statement->bindParam(':replyMessageId', $replyMessageId, PDO::PARAM_INT);
		$statement->execute();
		$result = $statement->fetch(PDO::FETCH_ASSOC);
		
		// If a message is found in chat_message table, return it
		if (!empty($result)) {
			return $result['chat_message'];
		}
		
		// If not found, search in chat_message_replay table
		$query = "SELECT chat_message FROM chat_message_replay WHERE chat_replay_id = :replyMessageId LIMIT 1";
		$statement = $this->connect->prepare($query);
		$statement->bindParam(':replyMessageId', $replyMessageId, PDO::PARAM_INT);
		$statement->execute();
		$result = $statement->fetch(PDO::FETCH_ASSOC);
		
		// Return the result from chat_message_replay table if found, else return null
		return !empty($result) ? $result['chat_message'] : null;
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
	
	// function save_chat()
	// {
	// 	$query="insert into chat_message (to_user_id,from_user_id,chat_message,timestamp,status) 
	// 	values (:to_user_id,:from_user_id,:chat_message,UTC_TIMESTAMP,:status)";
		
	// 	$statement = $this->connect->prepare($query);
		
	// 	$statement->bindParam(':to_user_id',$this->to_user_id);
		
	// 	$statement->bindParam(':from_user_id',$this->from_user_id);
		
	// 	$statement->bindParam(':chat_message',$this->chat_message);
		
	// 	//$statement->bindParam(':timestamp',$this->timestamp);
		
	// 	$statement->bindParam(':status',$this->status);
		
	// 	$statement->execute();
		
	// 	return $this->connect->lastInsertId();
	// }

	function save_chat()
	{

		if ($this->replyMessageId === null || $this->replyMessageId === '0') {
			// Save to chat_message table
			$query = "INSERT INTO chat_message (to_user_id, from_user_id, chat_message, timestamp, status) 
					VALUES (:to_user_id, :from_user_id, :chat_message, UTC_TIMESTAMP, :status)";

			$statement = $this->connect->prepare($query);

			$statement->bindParam(':to_user_id', $this->to_user_id);
			$statement->bindParam(':from_user_id', $this->from_user_id);
			$statement->bindParam(':chat_message', $this->chat_message);
			$statement->bindParam(':status', $this->status);

			$statement->execute();

			return $this->connect->lastInsertId();
		} else {

			if ($this->chatReplayId === null || $this->chatReplayId == '') {
				$this->chatReplayId = $this->replyMessageId;
			}
			
			// Save to chat_message_replay table
			$query = "INSERT INTO chat_message_replay (chat_master_id, chat_parent_id, to_user_id, from_user_id, chat_message, timestamp, status) 
					VALUES (:chat_master_id, :chat_parent_id, :to_user_id, :from_user_id, :chat_message, UTC_TIMESTAMP, :status)";

			$statement = $this->connect->prepare($query);

			// Explicitly set type to integer
			$statement->bindParam(':chat_master_id', $this->chatReplayId, PDO::PARAM_INT);
			$statement->bindParam(':chat_parent_id', $this->replyMessageId, PDO::PARAM_INT);
			$statement->bindParam(':to_user_id', $this->to_user_id);
			$statement->bindParam(':from_user_id', $this->from_user_id);
			$statement->bindParam(':chat_message', $this->chat_message);
			$statement->bindParam(':status', $this->status);

			$statement->execute();

			return $this->connect->lastInsertId();
		}
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