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

	public function __construct()
	{
		require_once("Database_connection.php");

		$database_object = new Database_connection;

		$this->connect = $database_object->connect();
	}

	function save_chat()
	{
		$query = "
		INSERT INTO chat_message_group 
			(to_group_id,from_user_id, chat_message, timestamp,status) 
			VALUES (:groupid,:userid, :msg, UTC_TIMESTAMP ,:status)
		";

		$statement = $this->connect->prepare($query);

		$statement->bindParam(':groupid', $this->group_id);
		$statement->bindParam(':userid', $this->user_id);

		$statement->bindParam(':msg', $this->message);

		//$statement->bindParam(':created_on', $this->timestamp);
		
		$statement->bindParam(':status', $this->status);

		$statement->execute();
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
		
		$query = "
		SELECT cl_group_members.group_users,upf.profileimage,users.name FROM cl_group_members 
			INNER JOIN users 
			ON users.id = cl_group_members.group_users 
			INNER JOIN userprofiles upf ON upf.userid=users.id
			WHERE cl_group_members.group_id = :groupid 
			AND cl_group_members.group_users != :fromuser
		"; 
		$statement = $this->connect->prepare($query);
		$statement->bindParam(':groupid', $groupid);
		$statement->bindParam(':fromuser', $fromuserid);
		$statement->execute();

		return $statement->fetchAll(PDO::FETCH_ASSOC);

	}
}
	
?>