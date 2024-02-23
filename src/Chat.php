<?php
//Chat.php

namespace MyApp{
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
require dirname(__DIR__) . "/database/ChatUser.php";
require dirname(__DIR__) . "/database/ChatRooms.php";

require dirname(__DIR__) . "/database/PrivateChat.php";
use GuzzleHttp;

date_default_timezone_set('Asia/Kolkata');
class Chat implements MessageComponentInterface {
    protected $clients;

    public $weburl = "https://apiprod.onlinecampuslife.com";
   

    public function __construct() {
        $this->clients = new \SplObjectStorage;
        echo 'Server Started';
    }

    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection to send messages to later
        echo 'Server Started';
        $this->clients->attach($conn);
		
		
		$querystring = $conn->httpRequest->getUri()->getQuery();
		
		parse_str($querystring,$queryarray);
		
		$user_object = new \ChatUser;
		
		//$user_object->setUserToken($queryarray['token']);

		$user_object->setUserId($queryarray['userid']);

		$user_object->setUserConnectionId($conn->resourceId);
		
		$user_object->update_user_connection_id();

        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $numRecv = count($this->clients) - 1;
        echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n"
            , $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');

            $DEFAULTPROFILEICON = 'https://onlinecampuslife.com/app-assets/images/user2.png';
            $PROFILEIMAGEPATH = 'https://onlinecampuslife.com/storage/profile_pictures/';
	    $weburl = "https://onlinecampuslife.com";

            $data = json_decode($msg, true);
		
		if($data['command']=='Private')
		{
			//private chat
			
			$private_chat_object = new \PrivateChat;
			
			$private_chat_object->setToUserId($data['receiver_userid']);
			
			$private_chat_object->setFromUserId($data['userId']);
			
			$private_chat_object->setChatMessage($data['msg']);
			
			$timestamp=date('Y-m-d h:i:s');
			
			$private_chat_object->setTimestamp($timestamp);
			
			$private_chat_object->setStatus('Yes');
			
			$chat_message_id = $private_chat_object->save_chat();
			
			$user_object =new  \ChatUser;
			
			$user_object->setUserId($data['userId']);
			
			$sender_user_data = $user_object->get_user_data_by_id();
			
			$user_object->setUserId($data['receiver_userid']);
			
			$receiver_user_data = $user_object->get_user_data_by_id();
			
			//$sender_user_name = $sender_user_data['user_name'];
            $sender_user_name = $sender_user_data['name'];
			
			$data['datetime']=$timestamp;
			
			$receiver_user_connection_id = $receiver_user_data['user_connection_id'];
			//$receiver_user_connection_id = $data['receiver_userid'];
            
			echo sprintf($receiver_user_connection_id);
			
			foreach($this->clients as $client){
				
				if($from==$client)
				{
					$data['from']='Me';
                    if( !empty($receiver_user_data['profileimage']) || $receiver_user_data['profileimage'] !=""  )
                    {
                        $data['profileimageicon'] =  $PROFILEIMAGEPATH.$receiver_user_data['profileimage'];
                    }
                    else
                    {
                        $data['profileimageicon'] =  $DEFAULTPROFILEICON;
                    }
				}
				else{
					$data['from'] = $sender_user_name;
                    if( !empty($sender_user_data['profileimage']) || $sender_user_data['profileimage'] !="" )
                    {
                        $data['profileimageicon'] =  $PROFILEIMAGEPATH.$sender_user_data['profileimage'];
                    }
                    else
                    {
                        $data['profileimageicon'] =  $DEFAULTPROFILEICON;
                    }
                   
				}
				
				if($client->resourceId==$receiver_user_connection_id || $from == $client)
				{
					$client->send(json_encode($data));
                    $userarry[] = $data['receiver_userid'];
                    $notifydata['users'] = $userarry;
                    $notifydata['title'] =  'Chat Message From: '. $sender_user_name ;
                    $notifydata['body'] = $private_chat_object->getChatMessage();
                    $notifydata['icon'] = $weburl .'/public/app-assets/images/about/cl-logo.jpg';
                    $notifydata['image'] = $weburl .'/public/app-assets/images/about/cl-logo.jpg';
                   // $notifydata['sound'] = ' ';
                    $notifydata['clickAction'] = $weburl ."/collaboration_1//".$sender_user_data['id']."/f" ; 
                    $notifydata['additionalData']['modulename'] = 'collaboration';
                    $notifydata['additionalData']['transaction_code'] ='ind_chat';
                    $notifydata['additionalData']['from_userid'] = $sender_user_data['id'] ; 
                    $notifydata['additionalData']['to_userid'] = $receiver_user_data['id']; 
                    $notifydata['additionalData']['notification_type'] = 'navigate';
                    $notifydata['additionalData']['object_id'] = $chat_message_id;
                    $notifydata['additionalData']['from_user_name'] = $sender_user_data['name'] ;
                    $notifydata['additionalData']['from_profileurl'] =  $data['profileimageicon'];
                    $notifydata['additionalData']['to_username'] = $receiver_user_data['name'] ;
                    $notifydata['additionalData']['to_profileurl'] =  $data['profileimageicon'];
                    $this->pushNotification($notifydata);
                 
				}
				else{
					$private_chat_object->setStatus('No');
					$private_chat_object->setChatMessageId($chat_message_id);
					$private_chat_object->update_chat_status();

                    
				}
				
			}
			
			
			
		}
		
		
		else{
			//group chat
		
        $chat_object = new \ChatRooms;

        $chat_object->setUserId($data['userId']);
        $chat_object->setGroupId($data['groupId']);
        $chat_object->setMessage($data['msg']);
        $chat_object->setStatus('Yes');

        $chat_object->setCreatedOn(date("Y-m-d h:i:s"));
        $chat_object->$timestamp=date('Y-m-d h:i:s');
        
        $chat_object->save_chat();

        $user_object = new \ChatUser;

        $user_object->setUserId($data['userId']);

        $user_data = $user_object->get_user_data_by_id();

        $user_name = $user_data['name'];
        $profileimage =  $user_data['profileimage'];
        $data['poster_user_picture'] =  $profileimage;

        if(empty($profileimage)|| $profileimage ==null )
        {
            $data['profileimageicon'] = $DEFAULTPROFILEICON;
            
        }
        else
        {
            $data['profileimageicon'] = $PROFILEIMAGEPATH.$profileimage;
        }
        
        $data['dt'] = date("d-m-Y h:i:s");

        foreach ($this->clients as $client) {
            /*if ($from !== $client) {
                // The sender is not the receiver, send to each client connected
                $client->send($msg);
            }*/

            if($from == $client)
            {
                $data['from'] = 'Me';
            }
            else
            {
                $data['from'] = $user_name;
                $data['poster_user_fullname'] = $user_name;
                
            }

                   $client->send(json_encode($data));
                  
        }
            $grpuser = [];
            $GroupMembers = $chat_object->GetGroupMember($data['groupId'],$data['userId']);
            foreach ($GroupMembers as $key => $groupuser) {
                $grpuser[] = $groupuser['group_users'];
            }

            $notifydata['users'] = $grpuser;
            $notifydata['title'] =  'Group Chat Message From: '.  $user_name;
            $notifydata['body'] = $data['msg'];
            $notifydata['icon'] = $weburl .'/public/app-assets/images/about/cl-logo.jpg';
            $notifydata['image'] = $weburl .'/public/app-assets/images/about/cl-logo.jpg';
        // $notifydata['sound'] = ' ';
            $notifydata['clickAction'] = $weburl ."/collaboration_1//".$data['groupId']."/g" ; 
            $notifydata['additionalData']['modulename'] = 'collaboration';
            $notifydata['additionalData']['transaction_code'] ='group_chat';
            $notifydata['additionalData']['from_userid'] = $data['groupId']; 
            $notifydata['additionalData']['to_userid'] = $data['receiver_userid']; 
            $notifydata['additionalData']['notification_type'] = 'navigate';
            $notifydata['additionalData']['object_id'] = '';
            $notifydata['additionalData']['from_user_name'] = $data['from'] ;
            $notifydata['additionalData']['from_profileurl'] =  $profileimage;
            $notifydata['additionalData']['to_username'] = $receiver_user_data['name'] ;
            $notifydata['additionalData']['to_profileurl'] =  $data['profileimageicon'];
            $this->pushNotification($notifydata);
	}
    }

    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove it, as we can no longer send it messages
        $user_object = new \ChatUser;
        $user_object->user_disconnected($conn->resourceId);
        $this->clients->detach($conn);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }

    function pushNotification($data)
    {
        $requestUrl = "https://onlinecampuslife.com/api/v1/send_push_notification";
    
        $response = $this->post($requestUrl, $data);

        return json_decode($response->getBody()->getContents(), true);
    }

    public static function post($url,$body) {
        $client = new GuzzleHttp\Client();
        $response = $client->post($url, ['form_params' => $body]);
        return $response;
    }
}
}
?>
