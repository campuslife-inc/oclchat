<?php 
	
class ChatRooms
{
	private $chat_id;
	private $user_id;
	private $message;
	private $created_on;
	private $group_id;
	private $status;
	protected $connect;
	private $timestamp;
	private $chat_parent_id; 
	private $replyMessageId;
	private $chatReplayId;

	public function setChatId($chat_id)
	{
		$this->chat_id = $chat_id;
	}

	function getChatId()
	{
		return $this->chat_id;
	}

	function setUserId($user_id)
	{
		$this->user_id = $user_id;
	}

	function getUserId()
	{
		return $this->user_id;
	}

	function setMessage($message)
	{
		$this->message = $message;
	}

	function setReplyMessageId($replyMessageId)
	{
		$this->replyMessageId = $replyMessageId;
	}

	function setParentReplyMessageId($chatReplayId)
	{
		$this->chatReplayId = $chatReplayId;
	}

	function getMessage()
	{
		return $this->message;
	}

	function setCreatedOn($created_on)
	{
		$this->created_on = $created_on;
	}

	function getCreatedOn()
	{
		return $this->created_on;
	}

	function setGroupId($group_id)
	{
		$this->group_id = $group_id;
	}

	function getGroupId()
	{
		return $this->group_id;
	}


	function setStatus($status)
	{
		$this->status = $status;
	}

	function getStatus($status)
	{
		$this->status;
	}

	function setTimestamp($timestamp)
	{
		$this->timestamp = $timestamp;
	}
	
	function getTimestamp()
	{
		return $this->timestamp;
	}

	public function getReplyToMessage($replyMessageId) {
		// First, search in chat_message table
		$query = "SELECT chat_message FROM chat_message_group WHERE chat_message_id = :replyMessageId LIMIT 1";
		$statement = $this->connect->prepare($query);
		$statement->bindParam(':replyMessageId', $replyMessageId, PDO::PARAM_INT);
		$statement->execute();
		$result = $statement->fetch(PDO::FETCH_ASSOC);
		
		// If a message is found in chat_message table, return it
		if (!empty($result)) {
			return $result['chat_message'];
		}
		
		// If not found, search in chat_message_replay table
		$query = "SELECT chat_message FROM chat_message_group_replay WHERE chat_replay_id = :replyMessageId LIMIT 1";
		$statement = $this->connect->prepare($query);
		$statement->bindParam(':replyMessageId', $replyMessageId, PDO::PARAM_INT);
		$statement->execute();
		$result = $statement->fetch(PDO::FETCH_ASSOC);
		
		// Return the result from chat_message_replay table if found, else return null
		return !empty($result) ? $result['chat_message'] : null;
	}

	public function __construct()
	{
		require_once("Database_connection.php");

		$database_object = new Database_connection;

		$this->connect = $database_object->connect();
	}

	// function save_chat()
	// {
	// 	$query = "
	// 	INSERT INTO chat_message_group 
	// 		(to_group_id,from_user_id, chat_message, timestamp,status) 
	// 		VALUES (:groupid,:userid, :msg, UTC_TIMESTAMP ,:status)
	// 	";

	// 	$statement = $this->connect->prepare($query);

	// 	$statement->bindParam(':groupid', $this->group_id);
	// 	$statement->bindParam(':userid', $this->user_id);

	// 	$statement->bindParam(':msg', $this->message);

	// 	//$statement->bindParam(':created_on', $this->timestamp);
		
	// 	$statement->bindParam(':status', $this->status);

	// 	$statement->execute();
	// }

	function save_chat()
	{
		// Check if it's a reply message
		if ($this->replyMessageId === null || $this->replyMessageId === '0') {
			// Save a new group message (non-reply)
			$query = "
			INSERT INTO chat_message_group (to_group_id, from_user_id, chat_message, timestamp, status) 
			VALUES (:groupid, :userid, :msg, UTC_TIMESTAMP, :status)
			";

			$statement = $this->connect->prepare($query);

			$statement->bindParam(':groupid', $this->group_id);
			$statement->bindParam(':userid', $this->user_id);
			$statement->bindParam(':msg', $this->message);
			$statement->bindParam(':status', $this->status);

			$statement->execute();

			// Return the last inserted ID for further use
			return $this->connect->lastInsertId();
		} else {
			// Handle group reply case
			if ($this->chatReplayId === null || $this->chatReplayId == '') {
				$this->chatReplayId = $this->replyMessageId; // Set master ID for reply
			}

			// Save reply to group chat
			$query = "
			INSERT INTO chat_message_group_replay (chat_master_id, chat_parent_id, to_group_id, from_user_id, chat_message, timestamp, status) 
			VALUES (:chat_master_id, :chat_parent_id, :groupid, :userid, :msg, UTC_TIMESTAMP, :status)
			";

			$statement = $this->connect->prepare($query);

			// Bind parameters
			$statement->bindParam(':chat_master_id', $this->replyMessageId, PDO::PARAM_INT);  // The original message ID being replied to
			$statement->bindParam(':chat_parent_id', $this->chatReplayId, PDO::PARAM_INT);   // If it's a nested reply, the parent message ID
			$statement->bindParam(':groupid', $this->group_id);
			$statement->bindParam(':userid', $this->user_id);
			$statement->bindParam(':msg', $this->message);
			$statement->bindParam(':status', $this->status);

			$statement->execute();

			// Return the last inserted ID for further use
			return $this->connect->lastInsertId();
		}
	}

	function get_all_chat_data()
	{
		$query = "
		SELECT * FROM chat_message_group 
			INNER JOIN users 
			ON users.id = chat_message_group.from_user_id 
			INNER JOIN userprofiles upf ON upf.userid=users.id
			ORDER BY chat_message_group.chat_message_id ASC
		"; 

		$statement = $this->connect->prepare($query);

		$statement->execute();

		return $statement->fetchAll(PDO::FETCH_ASSOC);
	}

	function GetGroupMember($groupid,$fromuserid)
	{
		
		// $query = "
		// SELECT cl_group_members.group_users,upf.profileimage,users.name FROM cl_group_members 
		// 	INNER JOIN users 
		// 	ON users.id = cl_group_members.group_users 
		// 	INNER JOIN userprofiles upf ON upf.userid=users.id
		// 	WHERE cl_group_members.group_id = :groupid 
		// 	AND cl_group_members.group_users != :fromuser
		// "; 


		$query = " SELECT 
				cl_group_members.group_users,
				upf.profileimage,
				users.name 
			FROM 
				cl_group_members 
			INNER JOIN 
				users ON users.id = cl_group_members.group_users 
			INNER JOIN 
				userprofiles upf ON upf.userid = users.id
			WHERE 
				cl_group_members.group_id = :groupid 
				AND cl_group_members.group_users != :fromuser
				AND cl_group_members.removed_on IS NULL
				AND cl_group_members.removed_by_user IS NULL";


		$statement = $this->connect->prepare($query);
		$statement->bindParam(':groupid', $groupid);
		$statement->bindParam(':fromuser', $fromuserid);
		$statement->execute();

		return $statement->fetchAll(PDO::FETCH_ASSOC);

	}
}
	
?>