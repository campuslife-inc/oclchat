<?php

include_once("../cl_config/conn.php");

if (isset($_POST['key'])) {
$file_path='../post_files/';
    session_start();
	
			$login_user_userid=$_SESSION['userid'];
			$login_user_fullname=$_SESSION['fullname'];
			$login_user_email=$_SESSION['email'];
			$login_user_state=$_SESSION['state'];
			$login_user_city=$_SESSION['city'];
			$login_user_country=$_SESSION['country'];
			$login_user_phonenumber=$_SESSION['phonenumber'];
			
			
			if($_POST['key'] == 'GeFriendWallAdditionalData')
	{
		$friend_id_for_wall=$_POST['frnd_wall_id'];
		if($friend_id_for_wall==0)
		{
			$sql_get_friend_list="select *,userprofiles.email as email_id from (cl_friends inner join users on cl_friends.r_friend_userid = users.id) inner join userprofiles on users.id=userprofiles.userid
  where r_userid = $login_user_userid  
  
  union all 
  
select *,userprofiles.email as email_id from (cl_friends inner join users on cl_friends.r_userid = users.id) 

inner join userprofiles on users.id=userprofiles.userid where r_friend_userid = $login_user_userid 

order by fraindhship_date desc limit 1;";
		}
		else{
			$sql_get_friend_list="select *,userprofiles.email as email_id from users inner join userprofiles on users.id=userprofiles.userid
  where userid = $friend_id_for_wall;";
		}
		 
  
  //echo $sql_get_friend_list;
  
  $get_friend_list = $conn_pdo->prepare($sql_get_friend_list);
        $get_friend_list ->execute();
        if ($get_friend_list->rowCount() > 0) {
            //while ($data_get_stage = $get_stage->fetch_array()) {
				$row_get_friend_list=$get_friend_list->fetch();
				$friend_id_for_wall=$row_get_friend_list['userid'];
				$friend_fullname=$row_get_friend_list['fullname'];
				$friend_email=$row_get_friend_list['email'];
				$friend_phonenumber=$row_get_friend_list['phonenumber'];
				$friend_state=$row_get_friend_list['state'];
				$friend_country=$row_get_friend_list['country'];
				
				$friend_profileimage=$row_get_friend_list['profileimage'];
				
				
				

	$institutename=$row_get_friend_list['Primeinstitutename'];
	$acca_year=$row_get_friend_list['primetermname'];
	$term=$row_get_friend_list['primeacademicname'];
				
				
				
				
				        $jsonArray = array(
            'friend_id_for_wall' => $friend_id_for_wall,
            'friend_fullname' => $friend_fullname,
            'friend_email' => $friend_email,
            'friend_phonenumber' => $friend_phonenumber,
            'friend_state' => $friend_state,
            'friend_country' => $friend_country,
			'friend_profileimage' => $friend_profileimage,
			
			'friend_institutename' => $institutename,
			'friend_acca_year' => $acca_year,
			'friend_term' => $term,
            
            
        );

        exit(json_encode($jsonArray));
				
				
				
				
				
			}
		
		
		
		
		}
	
	if($_POST['key'] == 'getExistingPostedData')
	{
		$friend_id_for_wall=$_POST['frnd_wall_id'];
		$limit=$_POST['limit'];
		$start=$_POST['start'];
		if($friend_id_for_wall==0)
		{
		 $sql_get_friend_list="select *,userprofiles.email as email_id from (cl_friends inner join users on cl_friends.r_friend_userid = users.id) inner join userprofiles on users.id=userprofiles.userid
  where r_userid = $login_user_userid   
  
  
  union all 
  
select *,userprofiles.email as email_id from (cl_friends inner join users on cl_friends.r_userid = users.id) 

inner join userprofiles on users.id=userprofiles.userid where r_friend_userid = $login_user_userid 

order by fraindhship_date desc limit 1";
  
  //echo $sql_get_friend_list;
  
  $get_friend_list = $conn_pdo->prepare($sql_get_friend_list);
        $get_friend_list ->execute();
        if ($get_friend_list->rowCount() > 0) {
            //while ($data_get_stage = $get_stage->fetch_array()) {
				$row_get_friend_list=$get_friend_list->fetch();
				$friend_id_for_wall=$row_get_friend_list['userid'];
			}
		}
		
		$sql_get_data="select *,date_format(post_date,'%M %d, %Y at %H:%i') as post_dt from cl_post where r_userid_poster=$login_user_userid and r_userid_wall=$friend_id_for_wall 
		
		union all 
select *,date_format(post_date,'%M %d, %Y at %H:%i') as post_dt from cl_post
 where r_userid_poster=$friend_id_for_wall and r_userid_wall=$login_user_userid order by post_date desc limit $start,$limit";
		//echo $sql_get_data;
		$get_data = $conn_pdo->prepare($sql_get_data);
        $get_data ->execute();
        if ($get_data->rowCount() > 0) {
            //while ($data_get_stage = $get_stage->fetch_array()) {
				$row_get_data=$get_data->fetchAll();
				foreach($row_get_data as $data_get_data)
												{
													$post_id=$data_get_data['post_id'];
													$file_type=$data_get_data['file_type'];
													$post_dt=$data_get_data['post_dt'];
													$file_name=$data_get_data['file_name'];
													$post_detail=$data_get_data['post_detail'];
													$r_userid_poster=$data_get_data['r_userid_poster'];
													$sql_get_user_poster="select * from users inner join userprofiles on users.id=userprofiles.userid 
													where userprofiles.userid  = $r_userid_poster";
													$get_user_poster = $conn_pdo->prepare($sql_get_user_poster);
													$get_user_poster ->execute();
													$row_get_user_poster=$get_user_poster->fetch();
													
													$poster_fullname=$row_get_user_poster['fullname'];
													$poster_profileimage=$row_get_user_poster['profileimage'];
													
													
													
													$sql_get_user_logged_in="select * from users inner join userprofiles on users.id=userprofiles.userid 
													where userprofiles.userid  = $login_user_userid";
													$get_user_logged_in = $conn_pdo->prepare($sql_get_user_logged_in);
													$get_user_logged_in ->execute();
													$row_get_user_logged_in=$get_user_logged_in->fetch();
													
													$logged_in_fullname=$row_get_user_logged_in['fullname'];
													$logged_in_profileimage=$row_get_user_logged_in['profileimage'];
													
													
													if($file_type=='I')
													{
													
		
		$response_post .='<div class="post-section card mb-2">
															<div class="d-flex align-items-center p-4">
																<div class="symbol symbol-60 symbol-circle symbol-xl-50 mr-3">
																	<img class="img-fluid" src="profile_pictures/'.$poster_profileimage.'" alt="">
																</div>
																<div>
																	<span class="font-weight-bolder text-dark font-size-md d-block" title="">'.$poster_fullname.'</span>
																	<span class="text-dark font-weight-bold font-size-sm d-block">'.$post_dt.'</span>
																	<span class="text-dark font-weight-bolde font-size-sm d-block mb-2">'.$post_detail.'</span>
																</div>
															</div>
															<img src="post_files/'.$file_name.'" class="w-100 img-fluid h-100">
															<div id="image_comment_'.$post_id.'">';
															
															$sql_get_post_comment_details="select *,date_format(r_action_date,'%M %d, %Y at %H:%i') as comment_dt from (cl_post_action inner join cl_post_action_comment on post_action_id=r_post_action_id) inner join userprofiles on 
userid = r_action_userid where r_post_id='$post_id' and flg_action='comment' and ref_post_action_id is null order by r_action_date asc;";
													$get_post_comment_details = $conn_pdo->prepare($sql_get_post_comment_details);
													$get_post_comment_details ->execute();
													if ($get_post_comment_details->rowCount() > 0) {
													$row_get_post_comment_details=$get_post_comment_details->fetchAll();
													foreach($row_get_post_comment_details as $data_get_post_comment_details)
													{
															$parent_comment_id=$data_get_post_comment_details['post_action_id'];
															$commenter_profile_picture= $data_get_post_comment_details['profileimage'];
															$commenter_user_name= $data_get_post_comment_details['fullname'];
															$comment_dt= $data_get_post_comment_details['comment_dt'];
															$comment= $data_get_post_comment_details['comment'];
															$response_post .='<div class="d-flex align-items-center px-4 py-2">
																<div class="symbol symbol-60 symbol-circle symbol-xl-50 mr-3">
																	<img class="img-fluid" src="profile_pictures/'.$commenter_profile_picture.'" alt="">
																</div>
																<div class="w-100">
																	<div class="d-flex justify-content-between">
																		<span class="font-weight-bolder text-dark font-size-md d-block" title="">'.$commenter_user_name.'</span>
																		<span class="text-dark font-weight-bold font-size-sm d-block">'.$comment_dt.'</span>
																	</div>
																	<span class="text-dark font-weight-bolde font-size-sm d-block mb-2">'.$comment.'</span>
																	
																	
																	</div></div>
																	<div id="post_comment_reply_'.$post_id.'_'.$parent_comment_id.'" style="margin-left:10%;">';
																	
																	$sql_get_post_comment_reply="select *,date_format(r_action_date,'%M %d, %Y at %H:%i') as comment_dt from (cl_post_action inner join cl_post_action_comment on post_action_id=r_post_action_id) inner join userprofiles on 
userid = r_action_userid where r_post_id='$post_id' and flg_action='answer' and ref_post_action_id = '$parent_comment_id' order by r_action_date asc;";
																	$get_post_comment_reply = $conn_pdo->prepare($sql_get_post_comment_reply);
													$get_post_comment_reply ->execute();
													if ($get_post_comment_reply->rowCount() > 0) {
													$row_get_post_comment_reply=$get_post_comment_reply->fetchAll();
													foreach($row_get_post_comment_reply as $data_get_post_comment_reply)
													{
														
														$commenter_profile_picture_reply= $data_get_post_comment_reply['profileimage'];
															$commenter_user_name_reply= $data_get_post_comment_reply['fullname'];
															$comment_dt_reply= $data_get_post_comment_reply['comment_dt'];
															$comment_reply= $data_get_post_comment_reply['comment'];
																	$response_post .='
																	<div class="d-flex align-items-center px-4 py-2">
																<div class="symbol symbol-60 symbol-circle symbol-xl-50 mr-3">
																	<img class="img-fluid" src="profile_pictures/'.$commenter_profile_picture_reply.'" alt="">
																</div>
																<div class="w-100">
																	<div class="d-flex justify-content-between">
																		<span class="font-weight-bolder text-dark font-size-md d-block" title="">'.$commenter_user_name_reply.'</span>
																		<span class="text-dark font-weight-bold font-size-sm d-block">'.$comment_dt_reply.'</span>
																	</div>
																	<span class="text-dark font-weight-bolde font-size-sm d-block mb-2">'.$comment_reply.'</span>
																	
																</div>
															</div>
															';
													}
													}
																	
																	
																	
																	$response_post .='
																	
																
															</div>';
															$response_post .='<span style="margin-left:20%" data-toggle="modal" onclick="get_post_reply_details(this.id)" id="search_post_comment_'.$post_id.'_'.$parent_comment_id.'" data-target="#comment_post_reply" ><i class="fas fa-reply-all text-info"></i><span class="ml-2">Reply</span></span>';
													}
													}
															
															$response_post .='</div>
															<div class="d-flex align-items-center p-4">
																<div class="symbol symbol-60 symbol-circle symbol-xl-50 mr-3">
																	<img class="img-fluid" src="profile_pictures/'.$logged_in_profileimage.'" alt="">
																</div>
																<!-- search_toggle -->
																<div class="dropdown w-100" id="kt_quick_search_toggle">
																	<div class="dropdown-menu p-0 m-0 dropdown-menu-right dropdown-menu-anim-up search-friend w-100 dropdown-menu-md">
																		<div class="quick-search quick-search-dropdown" id="kt_quick_search_dropdown">
																			<form method="get" class="quick-search-form w-100 m-0" action="javascript:void(0)">
																				<div class="input-group">
																				
																				
														
														
														<span class="form-control" id="search_keyword_'.$post_id.'" data-toggle="modal" data-target="#comment_post" onclick="get_post_details(this.id)">Write a comment</span>
														
															<div class="input-group-append" style="cursor: pointer;" id="search_icon">
															<span class="input-group-text">
															<span class="svg-icon svg-icon-lg">
															<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
															<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
															<rect x="0" y="0" width="24" height="24"></rect>
															<path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
															<path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" fill="#000000" fill-rule="nonzero"></path>
															</g>
															</svg>
															</span>
															</span>
															</div>
																				</div>
																			</form>
									<div class="quick-search-wrapper scroll ps" data-scroll="true" data-height="325" data-mobile-height="200" style="height: 325px; overflow: hidden;"><div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div></div><div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div></div></div>
																		</div>
																	</div>
																</div>
																<!-- search_toggle -->
															</div>
														</div>';
												}
												
												
												
												
												
												
												else if($file_type=='V')
													{
													

		$response_post .='<div class="post-section card mb-2">
															<div class="d-flex align-items-center p-4">
																<div class="symbol symbol-60 symbol-circle symbol-xl-50 mr-3">
																	<img class="img-fluid" src="profile_pictures/'.$poster_profileimage.'" alt="">
																</div>
																<div>
																	<span class="font-weight-bolder text-dark font-size-md d-block" title="">'.$poster_fullname.'</span>
																	<span class="text-dark font-weight-bold font-size-sm d-block">'.$post_dt.'</span>
																	<span class="text-dark font-weight-bolde font-size-sm d-block mb-2">'.$post_detail.'</span>
																</div>
															</div>
															
															<video class="w-100 img-fluid h-100" controls>
																<source src="post_files/'.$file_name.'" type="video/mp4">
																<source src="post_files/'.$file_name.'" type="video/ogg">
																	Your browser does not support HTML video.
															</video>
															
															<div id="image_comment_'.$post_id.'">';
															
															$sql_get_post_comment_details="select *,date_format(r_action_date,'%M %d, %Y at %H:%i') as comment_dt from (cl_post_action inner join cl_post_action_comment on post_action_id=r_post_action_id) inner join userprofiles on 
userid = r_action_userid where r_post_id='$post_id' and flg_action='comment' and ref_post_action_id is null order by r_action_date asc;";
													$get_post_comment_details = $conn_pdo->prepare($sql_get_post_comment_details);
													$get_post_comment_details ->execute();
													if ($get_post_comment_details->rowCount() > 0) {
													$row_get_post_comment_details=$get_post_comment_details->fetchAll();
													foreach($row_get_post_comment_details as $data_get_post_comment_details)
													{
															$parent_comment_id=$data_get_post_comment_details['post_action_id'];
															$commenter_profile_picture= $data_get_post_comment_details['profileimage'];
															$commenter_user_name= $data_get_post_comment_details['fullname'];
															$comment_dt= $data_get_post_comment_details['comment_dt'];
															$comment= $data_get_post_comment_details['comment'];
															$response_post .='<div class="d-flex align-items-center px-4 py-2">
																<div class="symbol symbol-60 symbol-circle symbol-xl-50 mr-3">
																	<img class="img-fluid" src="profile_pictures/'.$commenter_profile_picture.'" alt="">
																</div>
																<div class="w-100">
																	<div class="d-flex justify-content-between">
																		<span class="font-weight-bolder text-dark font-size-md d-block" title="">'.$commenter_user_name.'</span>
																		<span class="text-dark font-weight-bold font-size-sm d-block">'.$comment_dt.'</span>
																	</div>
																	<span class="text-dark font-weight-bolde font-size-sm d-block mb-2">'.$comment.'</span>
																	
																	
																	</div></div>
																	<div id="post_comment_reply_'.$post_id.'_'.$parent_comment_id.'" style="margin-left:10%;">';
																	
																	$sql_get_post_comment_reply="select *,date_format(r_action_date,'%M %d, %Y at %H:%i') as comment_dt from (cl_post_action inner join cl_post_action_comment on post_action_id=r_post_action_id) inner join userprofiles on 
userid = r_action_userid where r_post_id='$post_id' and flg_action='answer' and ref_post_action_id = '$parent_comment_id' order by r_action_date asc;";
																	$get_post_comment_reply = $conn_pdo->prepare($sql_get_post_comment_reply);
													$get_post_comment_reply ->execute();
													if ($get_post_comment_reply->rowCount() > 0) {
													$row_get_post_comment_reply=$get_post_comment_reply->fetchAll();
													foreach($row_get_post_comment_reply as $data_get_post_comment_reply)
													{
														
														$commenter_profile_picture_reply= $data_get_post_comment_reply['profileimage'];
															$commenter_user_name_reply= $data_get_post_comment_reply['fullname'];
															$comment_dt_reply= $data_get_post_comment_reply['comment_dt'];
															$comment_reply= $data_get_post_comment_reply['comment'];
																	$response_post .='
																	<div class="d-flex align-items-center px-4 py-2">
																<div class="symbol symbol-60 symbol-circle symbol-xl-50 mr-3">
																	<img class="img-fluid" src="profile_pictures/'.$commenter_profile_picture_reply.'" alt="">
																</div>
																<div class="w-100">
																	<div class="d-flex justify-content-between">
																		<span class="font-weight-bolder text-dark font-size-md d-block" title="">'.$commenter_user_name_reply.'</span>
																		<span class="text-dark font-weight-bold font-size-sm d-block">'.$comment_dt_reply.'</span>
																	</div>
																	<span class="text-dark font-weight-bolde font-size-sm d-block mb-2">'.$comment_reply.'</span>
																	
																</div>
															</div>
															';
													}
													}
																	
																	
																	
																	$response_post .='
																	
																
															</div>';
															$response_post .='<span style="margin-left:20%" data-toggle="modal" onclick="get_post_reply_details(this.id)" id="search_post_comment_'.$post_id.'_'.$parent_comment_id.'" data-target="#comment_post_reply" ><i class="fas fa-reply-all text-info"></i><span class="ml-2">Reply</span></span>';
													}
													}
															
															$response_post .='</div>
															<div class="d-flex align-items-center p-4">
																<div class="symbol symbol-60 symbol-circle symbol-xl-50 mr-3">
																	<img class="img-fluid" src="profile_pictures/'.$logged_in_profileimage.'" alt="">
																</div>
																<!-- search_toggle -->
																<div class="dropdown w-100" id="kt_quick_search_toggle">
																	<div class="dropdown-menu p-0 m-0 dropdown-menu-right dropdown-menu-anim-up search-friend w-100 dropdown-menu-md">
																		<div class="quick-search quick-search-dropdown" id="kt_quick_search_dropdown">
																			<form method="get" class="quick-search-form w-100 m-0" action="javascript:void(0)">
																				<div class="input-group">
														
														<span class="form-control" id="search_keyword_'.$post_id.'" data-toggle="modal" data-target="#comment_post" onclick="get_post_details(this.id)">Write a comment</span>
														
															<div class="input-group-append" style="cursor: pointer;" id="search_icon">
															<span class="input-group-text">
															<span class="svg-icon svg-icon-lg">
															<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
															<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
															<rect x="0" y="0" width="24" height="24"></rect>
															<path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
															<path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" fill="#000000" fill-rule="nonzero"></path>
															</g>
															</svg>
															</span>
															</span>
															</div>
																				</div>
																			</form>
									<div class="quick-search-wrapper scroll ps" data-scroll="true" data-height="325" data-mobile-height="200" style="height: 325px; overflow: hidden;"><div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div></div><div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div></div></div>
																		</div>
																	</div>
																</div>
																<!-- search_toggle -->
															</div>
														</div>';
												}
												
												
												
												
												else if($file_type=='T')
													{
													

		$response_post .='<div class="post-section card mb-2">
															<div class="d-flex align-items-center p-4">
																<div class="symbol symbol-60 symbol-circle symbol-xl-50 mr-3">
																	<img class="img-fluid" src="profile_pictures/'.$poster_profileimage.'" alt="">
																</div>
																<div>
																	<span class="font-weight-bolder text-dark font-size-md d-block" title="">'.$poster_fullname.'</span>
																	<span class="text-dark font-weight-bold font-size-sm d-block">'.$post_dt.'</span>
																	<span class="text-dark font-weight-bolde font-size-sm d-block mb-2">'.$post_detail.'</span>
																</div>
															</div>
															
															
															
															<div id="image_comment_'.$post_id.'">';
															
															$sql_get_post_comment_details="select *,date_format(r_action_date,'%M %d, %Y at %H:%i') as comment_dt from (cl_post_action inner join cl_post_action_comment on post_action_id=r_post_action_id) inner join userprofiles on 
userid = r_action_userid where r_post_id='$post_id' and flg_action='comment' and ref_post_action_id is null order by r_action_date asc;";
													$get_post_comment_details = $conn_pdo->prepare($sql_get_post_comment_details);
													$get_post_comment_details ->execute();
													if ($get_post_comment_details->rowCount() > 0) {
													$row_get_post_comment_details=$get_post_comment_details->fetchAll();
													foreach($row_get_post_comment_details as $data_get_post_comment_details)
													{
															$parent_comment_id=$data_get_post_comment_details['post_action_id'];
															$commenter_profile_picture= $data_get_post_comment_details['profileimage'];
															$commenter_user_name= $data_get_post_comment_details['fullname'];
															$comment_dt= $data_get_post_comment_details['comment_dt'];
															$comment= $data_get_post_comment_details['comment'];
															$response_post .='<div class="d-flex align-items-center px-4 py-2">
																<div class="symbol symbol-60 symbol-circle symbol-xl-50 mr-3">
																	<img class="img-fluid" src="profile_pictures/'.$commenter_profile_picture.'" alt="">
																</div>
																<div class="w-100">
																	<div class="d-flex justify-content-between">
																		<span class="font-weight-bolder text-dark font-size-md d-block" title="">'.$commenter_user_name.'</span>
																		<span class="text-dark font-weight-bold font-size-sm d-block">'.$comment_dt.'</span>
																	</div>
																	<span class="text-dark font-weight-bolde font-size-sm d-block mb-2">'.$comment.'</span>
																	
																	
																	</div></div>
																	<div id="post_comment_reply_'.$post_id.'_'.$parent_comment_id.'" style="margin-left:10%;">';
																	
																	$sql_get_post_comment_reply="select *,date_format(r_action_date,'%M %d, %Y at %H:%i') as comment_dt from (cl_post_action inner join cl_post_action_comment on post_action_id=r_post_action_id) inner join userprofiles on 
userid = r_action_userid where r_post_id='$post_id' and flg_action='answer' and ref_post_action_id = '$parent_comment_id' order by r_action_date asc;";
																	$get_post_comment_reply = $conn_pdo->prepare($sql_get_post_comment_reply);
													$get_post_comment_reply ->execute();
													if ($get_post_comment_reply->rowCount() > 0) {
													$row_get_post_comment_reply=$get_post_comment_reply->fetchAll();
													foreach($row_get_post_comment_reply as $data_get_post_comment_reply)
													{
														
														$commenter_profile_picture_reply= $data_get_post_comment_reply['profileimage'];
															$commenter_user_name_reply= $data_get_post_comment_reply['fullname'];
															$comment_dt_reply= $data_get_post_comment_reply['comment_dt'];
															$comment_reply= $data_get_post_comment_reply['comment'];
																	$response_post .='
																	<div class="d-flex align-items-center px-4 py-2">
																<div class="symbol symbol-60 symbol-circle symbol-xl-50 mr-3">
																	<img class="img-fluid" src="profile_pictures/'.$commenter_profile_picture_reply.'" alt="">
																</div>
																<div class="w-100">
																	<div class="d-flex justify-content-between">
																		<span class="font-weight-bolder text-dark font-size-md d-block" title="">'.$commenter_user_name_reply.'</span>
																		<span class="text-dark font-weight-bold font-size-sm d-block">'.$comment_dt_reply.'</span>
																	</div>
																	<span class="text-dark font-weight-bolde font-size-sm d-block mb-2">'.$comment_reply.'</span>
																	
																</div>
															</div>
															';
													}
													}
																	
																	
																	
																	$response_post .='
																	
																
															</div>';
															$response_post .='<span style="margin-left:20%" data-toggle="modal" onclick="get_post_reply_details(this.id)" id="search_post_comment_'.$post_id.'_'.$parent_comment_id.'" data-target="#comment_post_reply" ><i class="fas fa-reply-all text-info"></i><span class="ml-2">Reply</span></span>';
													}
													}
															
															$response_post .='</div>
															<div class="d-flex align-items-center p-4">
																<div class="symbol symbol-60 symbol-circle symbol-xl-50 mr-3">
																	<img class="img-fluid" src="profile_pictures/'.$logged_in_profileimage.'" alt="">
																</div>
																<!-- search_toggle -->
																<div class="dropdown w-100" id="kt_quick_search_toggle">
																	<div class="dropdown-menu p-0 m-0 dropdown-menu-right dropdown-menu-anim-up search-friend w-100 dropdown-menu-md">
																		<div class="quick-search quick-search-dropdown" id="kt_quick_search_dropdown">
																			<form method="get" class="quick-search-form w-100 m-0" action="javascript:void(0)">
																				<div class="input-group">
														
														<span class="form-control" id="search_keyword_'.$post_id.'" data-toggle="modal" data-target="#comment_post" onclick="get_post_details(this.id)">Write a comment</span>
														
															<div class="input-group-append" style="cursor: pointer;" id="search_icon">
															<span class="input-group-text">
															<span class="svg-icon svg-icon-lg">
															<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
															<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
															<rect x="0" y="0" width="24" height="24"></rect>
															<path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
															<path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" fill="#000000" fill-rule="nonzero"></path>
															</g>
															</svg>
															</span>
															</span>
															</div>
																				</div>
																			</form>
									<div class="quick-search-wrapper scroll ps" data-scroll="true" data-height="325" data-mobile-height="200" style="height: 325px; overflow: hidden;"><div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div></div><div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div></div></div>
																		</div>
																	</div>
																</div>
																<!-- search_toggle -->
															</div>
														</div>';
												}
												
												
											/*start new code*/	
												else{
												    
												    $sql_get_resource_post="select * from sharedobjects where postid = $post_id;";
												    $get_resource_post = $conn_pdo->prepare($sql_get_resource_post);
													$get_resource_post ->execute();
												    $row_get_resource_post=$get_resource_post->fetch();
												    
												    $objecttype=$row_get_resource_post['objecttype'];
                                                    $objectdetails=$row_get_resource_post['objectdetails'];
                                                    $objectname=$row_get_resource_post['objectname'];
                                                    
                                                    $sql_get_object_type="select * from mst_sub_object_type where sub_object_type = '$objecttype';";
                                                    $get_object_type = $conn_pdo->prepare($sql_get_object_type);
													$get_object_type ->execute();
												    $row_get_object_type=$get_object_type->fetch();
												    
												    $response_post .='<div class="post-section card mb-2">
															<div class="d-flex align-items-center p-4">
																<div class="symbol symbol-60 symbol-circle symbol-xl-50 mr-3">
																	<img class="img-fluid" src="profile_pictures/'.$poster_profileimage.'" alt="">
																</div>
																<div>
																	<span class="font-weight-bolder text-dark font-size-md d-block" title="">'.$poster_fullname.'</span>
																	<span class="text-dark font-weight-bold font-size-sm d-block">'.$post_dt.'</span>
																</div>
															</div>
															<div class="d-flex align-items-center px-4 ml-lg-10">
																<div class="w-100">
																	<div class="row d-flex align-items-center mb-4">
																		<div class="col-lg-2 col-lg-2"><span class="label label-warning label-pill label-inline">Shared</span></div>
																		
																		<div class="col-lg-4 col-md-5">
																			<span class="font-weight-bolder text-dark font-size-md d-block" title="">'.$objecttype.'</span>
																		</div>
																		<div class="col-lg-6 col-md-5 d-flex align-items-center">
																			<i class="fas fa-video icon-md text-info d-block mr-3"></i>
																		<span class="font-weight-light text-dark font-size-lg d-block" title="">'.$objectname.'</span>
																		</div>
																
															</div>
															
															<div class="mb-6 d-flex align-items-center">
																	<span class="text-dark d-flex font-weight-bold font-size-sm d-block"><span class="text-muted font-weight-bold font-size-sm d-block mr-2">'.$objectdetails.'</span></span>
																	
																	</div>
																	
																	<span><i class="fas fa-download text-info"></i><span class="ml-2">Download</span></span>
																	<!--span class="ml-4" id="comment"><i class="fas fa-comment text-info"></i><span class="ml-2">Comment</span></span-->
																</div>
															</div>
															
															
															
																			<div id="image_comment_'.$post_id.'">';
															
															$sql_get_post_comment_details="select *,date_format(r_action_date,'%M %d, %Y at %H:%i') as comment_dt from (cl_post_action inner join cl_post_action_comment on post_action_id=r_post_action_id) inner join userprofiles on 
userid = r_action_userid where r_post_id='$post_id' and flg_action='comment' and ref_post_action_id is null order by r_action_date asc;";
													$get_post_comment_details = $conn_pdo->prepare($sql_get_post_comment_details);
													$get_post_comment_details ->execute();
													if ($get_post_comment_details->rowCount() > 0) {
													$row_get_post_comment_details=$get_post_comment_details->fetchAll();
													foreach($row_get_post_comment_details as $data_get_post_comment_details)
													{
															$parent_comment_id=$data_get_post_comment_details['post_action_id'];
															$commenter_profile_picture= $data_get_post_comment_details['profileimage'];
															$commenter_user_name= $data_get_post_comment_details['fullname'];
															$comment_dt= $data_get_post_comment_details['comment_dt'];
															$comment= $data_get_post_comment_details['comment'];
															$response_post .='<div class="d-flex align-items-center px-4 py-2">
																<div class="symbol symbol-60 symbol-circle symbol-xl-50 mr-3">
																	<img class="img-fluid" src="profile_pictures/'.$commenter_profile_picture.'" alt="">
																</div>
																<div class="w-100">
																	<div class="d-flex justify-content-between">
																		<span class="font-weight-bolder text-dark font-size-md d-block" title="">'.$commenter_user_name.'</span>
																		<span class="text-dark font-weight-bold font-size-sm d-block">'.$comment_dt.'</span>
																	</div>
																	<span class="text-dark font-weight-bolde font-size-sm d-block mb-2">'.$comment.'</span>
																	
																	
																	</div></div>
																	<div id="post_comment_reply_'.$post_id.'_'.$parent_comment_id.'" style="margin-left:10%;">';
																	
																	$sql_get_post_comment_reply="select *,date_format(r_action_date,'%M %d, %Y at %H:%i') as comment_dt from (cl_post_action inner join cl_post_action_comment on post_action_id=r_post_action_id) inner join userprofiles on 
userid = r_action_userid where r_post_id='$post_id' and flg_action='answer' and ref_post_action_id = '$parent_comment_id' order by r_action_date asc;";
																	$get_post_comment_reply = $conn_pdo->prepare($sql_get_post_comment_reply);
													$get_post_comment_reply ->execute();
													if ($get_post_comment_reply->rowCount() > 0) {
													$row_get_post_comment_reply=$get_post_comment_reply->fetchAll();
													foreach($row_get_post_comment_reply as $data_get_post_comment_reply)
													{
														
														$commenter_profile_picture_reply= $data_get_post_comment_reply['profileimage'];
															$commenter_user_name_reply= $data_get_post_comment_reply['fullname'];
															$comment_dt_reply= $data_get_post_comment_reply['comment_dt'];
															$comment_reply= $data_get_post_comment_reply['comment'];
																	$response_post .='
																	<div class="d-flex align-items-center px-4 py-2">
																<div class="symbol symbol-60 symbol-circle symbol-xl-50 mr-3">
																	<img class="img-fluid" src="profile_pictures/'.$commenter_profile_picture_reply.'" alt="">
																</div>
																<div class="w-100">
																	<div class="d-flex justify-content-between">
																		<span class="font-weight-bolder text-dark font-size-md d-block" title="">'.$commenter_user_name_reply.'</span>
																		<span class="text-dark font-weight-bold font-size-sm d-block">'.$comment_dt_reply.'</span>
																	</div>
																	<span class="text-dark font-weight-bolde font-size-sm d-block mb-2">'.$comment_reply.'</span>
																	
																</div>
															</div>
															';
													}
													}
																	
																	
																	
																	$response_post .='
																	
																
															</div>';
															$response_post .='<span style="margin-left:20%" data-toggle="modal" onclick="get_post_reply_details(this.id)" id="search_post_comment_'.$post_id.'_'.$parent_comment_id.'" data-target="#comment_post_reply" ><i class="fas fa-reply-all text-info"></i><span class="ml-2">Reply</span></span>';
													}
													}
															
															
															
															
															
																$response_post .='</div>
															<div class="d-flex align-items-center p-4">
																<div class="symbol symbol-60 symbol-circle symbol-xl-50 mr-3">
																	<img class="img-fluid" src="profile_pictures/'.$logged_in_profileimage.'" alt="">
																</div>
																<!-- search_toggle -->
																<div class="dropdown w-100" id="kt_quick_search_toggle">
																	<div class="dropdown-menu p-0 m-0 dropdown-menu-right dropdown-menu-anim-up search-friend w-100 dropdown-menu-md">
																		<div class="quick-search quick-search-dropdown" id="kt_quick_search_dropdown">
																			<form method="get" class="quick-search-form w-100 m-0" action="javascript:void(0)">
																				<div class="input-group">
														
														<span class="form-control" id="search_keyword_'.$post_id.'" data-toggle="modal" data-target="#comment_post" onclick="get_post_details(this.id)">Write a comment</span>
														
															<div class="input-group-append" style="cursor: pointer;" id="search_icon">
															<span class="input-group-text">
															<span class="svg-icon svg-icon-lg">
															<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
															<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
															<rect x="0" y="0" width="24" height="24"></rect>
															<path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
															<path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" fill="#000000" fill-rule="nonzero"></path>
															</g>
															</svg>
															</span>
															</span>
															</div>
																				</div>
																			</form>
									<div class="quick-search-wrapper scroll ps" data-scroll="true" data-height="325" data-mobile-height="200" style="height: 325px; overflow: hidden;"><div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div></div><div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div></div></div>
																		</div>
																	</div>
																</div>
																<!-- search_toggle -->
															</div>
														</div>';
												    
												}
												
												
												/*end new code*/	
												
												
												}
			}
			
			
		
		$response_post1 .='<div class="post-section card mb-2">
															<div class="d-flex align-items-center p-4">
																<div class="symbol symbol-60 symbol-circle symbol-xl-50 mr-3">
																	<img class="img-fluid" src="public/app-assets/images/icons/group.jpg" alt="">
																</div>
																<div>
																	<span class="font-weight-bolder text-dark font-size-md d-block" title="">User Name</span>
																	<span class="text-dark font-weight-bold font-size-sm d-block">16 February, 2021 at 16:00</span>
																</div>
															</div>
															<img src="public/app-assets/images/icons/images (1).jpg" class="w-100 img-fluid h-100px">
															<div class="d-flex align-items-center px-4 py-2">
																<div class="symbol symbol-60 symbol-circle symbol-xl-50 mr-3">
																	<img class="img-fluid" src="public/app-assets/images/icons/group1.jpg" alt="">
																</div>
																<div class="w-100">
																	<div class="d-flex justify-content-between">
																		<span class="font-weight-bolder text-dark font-size-md d-block" title="">User Name</span>
																		<span class="text-dark font-weight-bold font-size-sm d-block">16 February, 2021 at 16:00</span>
																	</div>
																	<span class="text-dark font-weight-bolde font-size-sm d-block mb-2">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</span>
																	<span><i class="fas fa-reply-all text-info"></i><span class="ml-2">Reply</span></span>
																</div>
															</div>
															<div class="d-flex align-items-center p-4">
																<div class="symbol symbol-60 symbol-circle symbol-xl-50 mr-3">
																	<img class="img-fluid" src="public/app-assets/images/icons/group.jpg" alt="">
																</div>
																<!-- search_toggle -->
																<div class="dropdown w-100" id="kt_quick_search_toggle">
																	<div class="dropdown-menu p-0 m-0 dropdown-menu-right dropdown-menu-anim-up search-friend w-100 dropdown-menu-md">
																		<div class="quick-search quick-search-dropdown" id="kt_quick_search_dropdown">
																			<form method="get" class="quick-search-form w-100 m-0" action="javascript:void(0)">
																				<div class="input-group">
														<input type="text" id="search_keyword" class="form-control" placeholder="Write a comment">
															<div class="input-group-append" style="cursor: pointer;" id="search_icon">
															<span class="input-group-text">
															<span class="svg-icon svg-icon-lg">
															<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
															<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
															<rect x="0" y="0" width="24" height="24"></rect>
															<path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
															<path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" fill="#000000" fill-rule="nonzero"></path>
															</g>
															</svg>
															</span>
															</span>
															</div>
																				</div>
																			</form>
									<div class="quick-search-wrapper scroll ps" data-scroll="true" data-height="325" data-mobile-height="200" style="height: 325px; overflow: hidden;"><div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div></div><div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div></div></div>
																		</div>
																	</div>
																</div>
																<!-- search_toggle -->
															</div>
														</div>
														<!-- single post -->
																	<!-- single post -->
														<div class="post-section card mb-2">
															<div class="d-flex align-items-center p-4">
																<div class="symbol symbol-60 symbol-circle symbol-xl-50 mr-3">
																	<img class="img-fluid" src="public/app-assets/images/icons/group.jpg" alt="">
																</div>
																<div>
																	<span class="font-weight-bolder text-dark font-size-md d-block" title="">User Name</span>
																	<span class="text-dark font-weight-bold font-size-sm d-block">16 February, 2021 at 16:00</span>
																	<span class="text-dark font-weight-bolde font-size-sm d-block mb-2">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</span>
																</div>
															</div>
															<img src="public/app-assets/images/icons/images (1).jpg" class="w-100 img-fluid h-100px">
															<div class="d-flex align-items-center px-4 py-2">
																<div class="symbol symbol-60 symbol-circle symbol-xl-50 mr-3">
																	<img class="img-fluid" src="public/app-assets/images/icons/group1.jpg" alt="">
																</div>
																<div class="w-100">
																	<div class="d-flex justify-content-between">
																		<span class="font-weight-bolder text-dark font-size-md d-block" title="">User Name</span>
																		<span class="text-dark font-weight-bold font-size-sm d-block">16 February, 2021 at 16:00</span>
																	</div>
																	<span class="text-dark font-weight-bolde font-size-sm d-block mb-2">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</span>
																	<div class="d-flex">
																		<span><i class="fas fa-reply-all text-info"></i><span class="ml-2">Reply</span></span>
																		<span class="ml-4" id="comment"><i class="fas fa-comment text-info"></i><span class="ml-2">Comment</span></span>
																	</div>
																</div>
															</div>
															<div class="comment-div">
															<div class="d-flex align-items-center p-4">
																<div class="symbol symbol-60 symbol-circle symbol-xl-50 mr-3">
																	<img class="img-fluid" src="public/app-assets/images/icons/group.jpg" alt="">
																</div>
																<!-- search_toggle -->
																<div class="dropdown w-100" id="kt_quick_search_toggle">
																	<div class="dropdown-menu p-0 m-0 dropdown-menu-right dropdown-menu-anim-up search-friend w-100 dropdown-menu-md">
																		<div class="quick-search quick-search-dropdown" id="kt_quick_search_dropdown">
																			<form method="get" class="quick-search-form w-100 m-0" action="javascript:void(0)">
																				<div class="input-group">
														<input type="text" id="search_keyword" class="form-control" placeholder="Write a comment">
															<div class="input-group-append" style="cursor: pointer;" id="search_icon">
															<span class="input-group-text">
															<span class="svg-icon svg-icon-lg">
															<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
															<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
															<rect x="0" y="0" width="24" height="24"></rect>
															<path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
															<path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" fill="#000000" fill-rule="nonzero"></path>
															</g>
															</svg>
															</span>
															</span>
															</div>
																				</div>
																			</form>
									<div class="quick-search-wrapper scroll ps" data-scroll="true" data-height="325" data-mobile-height="200" style="height: 325px; overflow: hidden;"><div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div></div><div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div></div></div>
																		</div>
																	</div>
																</div>
																<!-- search_toggle -->
															</div>
															<div class="d-flex align-items-center px-4 py-2">
																<div class="symbol symbol-60 symbol-circle symbol-xl-50 mr-3">
																	<img class="img-fluid" src="public/app-assets/images/icons/group2.jpg" alt="">
																</div>
																<div class="w-100">
																	<div class="d-flex justify-content-between">
																		<span class="font-weight-bolder text-dark font-size-md d-block" title="">User Name</span>
																		<span class="text-dark font-weight-bold font-size-sm d-block">16 February, 2021 at 16:00</span>
																	</div>
																	<span class="text-dark font-weight-bolde font-size-sm d-block mb-2">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</span>
																	<div class="d-flex">
																		<span><i class="fas fa-reply-all text-info"></i><span class="ml-2">Reply</span></span>
																	</div>
																</div>
															</div>
																<div class="d-flex align-items-center px-4 py-2">
																<div class="symbol symbol-60 symbol-circle symbol-xl-50 mr-3">
																	<img class="img-fluid" src="public/app-assets/images/icons/group3.jpg" alt="">
																</div>
																<div class="w-100">
																	<div class="d-flex justify-content-between">
																		<span class="font-weight-bolder text-dark font-size-md d-block" title="">User Name</span>
																		<span class="text-dark font-weight-bold font-size-sm d-block">16 February, 2021 at 16:00</span>
																	</div>
																	<span class="text-dark font-weight-bolde font-size-sm d-block mb-2">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</span>
																	<div class="d-flex">
																		<span><i class="fas fa-reply-all text-info"></i><span class="ml-2">Reply</span></span>
																	</div>
																</div>
															</div>
														</div>
														</div>
														<!-- single post -->
														<!-- single post -->
														<div class="post-section card mb-2">
															<div class="d-flex align-items-center p-4">
																<div class="symbol symbol-60 symbol-circle symbol-xl-50 mr-3">
																	<img class="img-fluid" src="public/app-assets/images/icons/group.jpg" alt="">
																</div>
																<div>
																	<span class="font-weight-bolder text-dark font-size-md d-block" title="">User Name</span>
																	<span class="text-dark font-weight-bold font-size-sm d-block">16 February, 2021 at 16:00</span>
																	<span class="text-dark font-weight-bolde font-size-sm d-block mb-2">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</span>
																</div>
															</div>

																	<video height="200" controls>
																<source src="http://localhost/beta01/collaboration/public/app-assets/images/icons/movie.mp4" type="video/mp4">
																	<source src="http://localhost/beta01/collaboration/public/app-assets/images/icons/movie.ogg" type="video/ogg">
																	</video>
															<div class="d-flex align-items-center px-4 py-2">
																<div class="symbol symbol-60 symbol-circle symbol-xl-50 mr-3">
																	<img class="img-fluid" src="public/app-assets/images/icons/group1.jpg" alt="">
																</div>
																<div class="w-100">
																	<div class="d-flex justify-content-between">
																		<span class="font-weight-bolder text-dark font-size-md d-block" title="">User Name</span>
																		<span class="text-dark font-weight-bold font-size-sm d-block">16 February, 2021 at 16:00</span>
																	</div>
																	<span class="text-dark font-weight-bolde font-size-sm d-block mb-2">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</span>
																	<div class="d-flex">
																		<span><i class="fas fa-reply-all text-info"></i><span class="ml-2">Reply</span></span>
																		<span class="ml-4" id="comment"><i class="fas fa-comment text-info"></i><span class="ml-2">Comment</span></span>
																	</div>
																</div>
															</div>
															<div class="comment-div">
															<div class="d-flex align-items-center p-4">
																<div class="symbol symbol-60 symbol-circle symbol-xl-50 mr-3">
																	<img class="img-fluid" src="public/app-assets/images/icons/group.jpg" alt="">
																</div>
																<!-- search_toggle -->
																<div class="dropdown w-100" id="kt_quick_search_toggle">
																	<div class="dropdown-menu p-0 m-0 dropdown-menu-right dropdown-menu-anim-up search-friend w-100 dropdown-menu-md">
																		<div class="quick-search quick-search-dropdown" id="kt_quick_search_dropdown">
																			<form method="get" class="quick-search-form w-100 m-0" action="javascript:void(0)">
																				<div class="input-group">
														<input type="text" id="search_keyword" class="form-control" placeholder="Write a comment">
															<div class="input-group-append" style="cursor: pointer;" id="search_icon">
															<span class="input-group-text">
															<span class="svg-icon svg-icon-lg">
															<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
															<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
															<rect x="0" y="0" width="24" height="24"></rect>
															<path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
															<path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" fill="#000000" fill-rule="nonzero"></path>
															</g>
															</svg>
															</span>
															</span>
															</div>
																				</div>
																			</form>
									<div class="quick-search-wrapper scroll ps" data-scroll="true" data-height="325" data-mobile-height="200" style="height: 325px; overflow: hidden;"><div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div></div><div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div></div></div>
																		</div>
																	</div>
																</div>
																<!-- search_toggle -->
															</div>
															<div class="d-flex align-items-center px-4 py-2">
																<div class="symbol symbol-60 symbol-circle symbol-xl-50 mr-3">
																	<img class="img-fluid" src="public/app-assets/images/icons/group2.jpg" alt="">
																</div>
																<div class="w-100">
																	<div class="d-flex justify-content-between">
																		<span class="font-weight-bolder text-dark font-size-md d-block" title="">User Name</span>
																		<span class="text-dark font-weight-bold font-size-sm d-block">16 February, 2021 at 16:00</span>
																	</div>
																	<span class="text-dark font-weight-bolde font-size-sm d-block mb-2">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</span>
																	<div class="d-flex">
																		<span><i class="fas fa-reply-all text-info"></i><span class="ml-2">Reply</span></span>
																	</div>
																</div>
															</div>
																<div class="d-flex align-items-center px-4 py-2">
																<div class="symbol symbol-60 symbol-circle symbol-xl-50 mr-3">
																	<img class="img-fluid" src="public/app-assets/images/icons/group3.jpg" alt="">
																</div>
																<div class="w-100">
																	<div class="d-flex justify-content-between">
																		<span class="font-weight-bolder text-dark font-size-md d-block" title="">User Name</span>
																		<span class="text-dark font-weight-bold font-size-sm d-block">16 February, 2021 at 16:00</span>
																	</div>
																	<span class="text-dark font-weight-bolde font-size-sm d-block mb-2">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</span>
																	<div class="d-flex">
																		<span><i class="fas fa-reply-all text-info"></i><span class="ml-2">Reply</span></span>
																	</div>
																</div>
															</div>
														</div>
														</div>
														<!-- single post -->
														<!-- single post -->
														<div class="post-section card mb-2">
															<div class="d-flex align-items-center p-4">
																<div class="symbol symbol-60 symbol-circle symbol-xl-50 mr-3">
																	<img class="img-fluid" src="public/app-assets/images/icons/group.jpg" alt="">
																</div>
																<div>
																	<span class="font-weight-bolder text-dark font-size-md d-block" title="">User Name</span>
																	<span class="text-dark font-weight-bold font-size-sm d-block">16 February, 2021 at 16:00</span>
																</div>
															</div>
															<!-- <img src="public/app-assets/images/icons/images (1).jpg" class="w-100 img-fluid h-100px"> -->
															<div class="d-flex align-items-center px-4 ml-lg-10">
																<div class="w-100">
																	<div class="row d-flex align-items-center">
																		<div class="col-lg-2 col-lg-2"><span class="label label-warning label-pill label-inline">Shared</span></div>
																		
																		<div class="col-lg-4 col-md-5">
																			<span class="font-weight-bolder text-dark font-size-md d-block" title="">Project</span>
																		</div>
																		<div class="col-lg-6 col-md-5 d-flex align-items-center">
																			<div class="symbol symbol-60 symbol-circle symbol-xl-25 mr-3">
																	<img class="img-fluid" src="public/app-assets/images/icons/icons8-teacher-48.png" alt="">
																		</div>
																		<span class="font-weight-light text-dark font-size-lg d-block" title="">Project Name</span>
																		</div>
																
															</div>
																	<div class="mb-6 d-flex align-items-center">
																	<span class="text-dark d-flex font-weight-bold font-size-sm d-block"><span class="text-muted font-weight-bold font-size-sm d-block mr-2">From Date:</span>16 February, 2021</span>
																	<span class="mx-2">|</span>
																	<span class="text-dark d-flex font-weight-bold font-size-sm d-block"><span class="text-muted font-weight-bold font-size-sm d-block mr-2">To Date:</span>16 February, 2021</span>
																	</div>
																	<span><i class="fas fa-download text-info"></i><span class="ml-2">Download</span></span>
																	<span class="ml-4" id="comment"><i class="fas fa-comment text-info"></i><span class="ml-2">Comment</span></span>
																</div>
															</div>
															<div class="d-flex align-items-center p-4">
																<div class="symbol symbol-60 symbol-circle symbol-xl-50 mr-3">
																	<img class="img-fluid" src="public/app-assets/images/icons/group.jpg" alt="">
																</div>
																<!-- search_toggle -->
																<div class="dropdown w-100" id="kt_quick_search_toggle">
																	<div class="dropdown-menu p-0 m-0 dropdown-menu-right dropdown-menu-anim-up search-friend w-100 dropdown-menu-md">
																		<div class="quick-search quick-search-dropdown" id="kt_quick_search_dropdown">
																			<form method="get" class="quick-search-form w-100 m-0" action="javascript:void(0)">
																				<div class="input-group">
														<input type="text" id="search_keyword" class="form-control" placeholder="Write a comment">
															<div class="input-group-append" style="cursor: pointer;" id="search_icon">
															<span class="input-group-text">
															<span class="svg-icon svg-icon-lg">
															<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
															<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
															<rect x="0" y="0" width="24" height="24"></rect>
															<path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
															<path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" fill="#000000" fill-rule="nonzero"></path>
															</g>
															</svg>
															</span>
															</span>
															</div>
																				</div>
																			</form>
									<div class="quick-search-wrapper scroll ps" data-scroll="true" data-height="325" data-mobile-height="200" style="height: 325px; overflow: hidden;"><div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div></div><div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div></div></div>
																		</div>
																	</div>
																</div>
																<!-- search_toggle -->
															</div>
														</div>
														<!-- single post -->
														<!-- single post -->
														<div class="post-section card mb-2">
															<div class="d-flex align-items-center p-4">
																<div class="symbol symbol-60 symbol-circle symbol-xl-50 mr-3">
																	<img class="img-fluid" src="public/app-assets/images/icons/group.jpg" alt="">
																</div>
																<div>
																	<span class="font-weight-bolder text-dark font-size-md d-block" title="">User Name</span>
																	<span class="text-dark font-weight-bold font-size-sm d-block">16 February, 2021 at 16:00</span>
																</div>
															</div>
															<div class="d-flex align-items-center px-4 ml-lg-10">
																<div class="w-100">
																	<div class="row d-flex align-items-center mb-4">
																		<div class="col-lg-2 col-lg-2"><span class="label label-warning label-pill label-inline">Shared</span></div>
																		
																		<div class="col-lg-4 col-md-5">
																			<span class="font-weight-bolder text-dark font-size-md d-block" title="">Digital Library</span>
																		</div>
																		<div class="col-lg-6 col-md-5 d-flex align-items-center">
																			<i class="fas fa-video icon-md text-info d-block mr-3"></i>
																		<span class="font-weight-light text-dark font-size-lg d-block" title="">video.mp4</span>
																		</div>
																
															</div>
																	<span><i class="fas fa-download text-info"></i><span class="ml-2">Download</span></span>
																	<span class="ml-4" id="comment"><i class="fas fa-comment text-info"></i><span class="ml-2">Comment</span></span>
																</div>
															</div>
															<div class="d-flex align-items-center p-4">
																<div class="symbol symbol-60 symbol-circle symbol-xl-50 mr-3">
																	<img class="img-fluid" src="public/app-assets/images/icons/group.jpg" alt="">
																</div>
																<!-- search_toggle -->
																<div class="dropdown w-100" id="kt_quick_search_toggle">
																	<div class="dropdown-menu p-0 m-0 dropdown-menu-right dropdown-menu-anim-up search-friend w-100 dropdown-menu-md">
																		<div class="quick-search quick-search-dropdown" id="kt_quick_search_dropdown">
																			<form method="get" class="quick-search-form w-100 m-0" action="javascript:void(0)">
																				<div class="input-group">
														<input type="text" id="search_keyword" class="form-control" placeholder="Write a comment">
															<div class="input-group-append" style="cursor: pointer;" id="search_icon">
															<span class="input-group-text">
															<span class="svg-icon svg-icon-lg">
															<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
															<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
															<rect x="0" y="0" width="24" height="24"></rect>
															<path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
															<path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" fill="#000000" fill-rule="nonzero"></path>
															</g>
															</svg>
															</span>
															</span>
															</div>
																				</div>
																			</form>
									<div class="quick-search-wrapper scroll ps" data-scroll="true" data-height="325" data-mobile-height="200" style="height: 325px; overflow: hidden;"><div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div></div><div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div></div></div>
																		</div>
																	</div>
																</div>
																<!-- search_toggle -->
															</div>
														</div>';
														
														echo $response_post;
	}
	
	if ($_POST['key'] == 'PostImage') {
		$image_post_title=$_POST['image_post_title'];
		$friend_id_for_wall_post=$_POST['friend_id_for_wall_post'];
		
		
		$front_image = $_FILES['upload_image']['name'];
 move_uploaded_file($_FILES['upload_image']['tmp_name'],$file_path.$front_image);
 try {
    // First of all, let's begin a transaction
    $conn_pdo->beginTransaction();
 $sql_insert_image_post="insert into cl_post 
	(r_userid_poster, 
	r_userid_wall, 
	post_detail, 
	
	post_date, 
	update_date, 
	file_name,
	flg_privatewall,
	file_type
	)
	values
	('$login_user_userid', 
	'$friend_id_for_wall_post', 
	'$image_post_title', 

	now(), 
	now(), 
	'$front_image',
	'yes',
	'I'
	);";
	//echo  $sql_insert_image_post;
	$insert_image_post = $conn_pdo->prepare($sql_insert_image_post);
	$insert_image_post->execute();
 				$conn_pdo->commit();
		 exit('A');
	}
	
	catch (Exception $e) {
    // An exception has been thrown
    // We must rollback the transaction
    $conn_pdo->rollback();
	exit("N");
}

	}
	
	
	
	
	
		if ($_POST['key'] == 'PostVideo') {
		$video_post_title=$_POST['video_post_title'];
		$friend_id_for_wall_post=$_POST['friend_id_for_wall_post'];
		
		$front_image = $_FILES['upload_video']['name'];
 move_uploaded_file($_FILES['upload_video']['tmp_name'],$file_path.$front_image);
 try {
    // First of all, let's begin a transaction
    $conn_pdo->beginTransaction();
 $sql_insert_image_post="insert into cl_post 
	(r_userid_poster, 
	r_userid_wall, 
	post_detail, 
	
	post_date, 
	update_date, 
	file_name,
	flg_privatewall,
	file_type
	)
	values
	('$login_user_userid', 
	'$friend_id_for_wall_post', 
	'$video_post_title', 

	now(), 
	now(), 
	'$front_image',
	'yes',
	'V'
	);";
	//echo  $sql_insert_image_post;
	$insert_image_post = $conn_pdo->prepare($sql_insert_image_post);
	$insert_image_post->execute();
 				$conn_pdo->commit();
		 exit('A');
	}
	
	catch (Exception $e) {
    // An exception has been thrown
    // We must rollback the transaction
    $conn_pdo->rollback();
	exit("N");
}

	}
	
	
	
	
	
			if ($_POST['key'] == 'PostText') {
		$text_post_title=$_POST['text_post_title'];
		$friend_id_for_wall_post=$_POST['friend_id_for_wall_post'];
		
		//$front_image = $_FILES['upload_video']['name'];
 //move_uploaded_file($_FILES['upload_video']['tmp_name'],$file_path.$front_image);
 try {
    // First of all, let's begin a transaction
    $conn_pdo->beginTransaction();
 $sql_insert_image_post="insert into cl_post 
	(r_userid_poster, 
	r_userid_wall, 
	post_detail, 
	
	post_date, 
	update_date, 
	
	flg_privatewall,
	file_type
	)
	values
	('$login_user_userid', 
	'$friend_id_for_wall_post', 
	'$text_post_title', 

	now(), 
	now(), 
	
	'yes',
	'T'
	);";
	//echo  $sql_insert_image_post;
	$insert_image_post = $conn_pdo->prepare($sql_insert_image_post);
	$insert_image_post->execute();
 				$conn_pdo->commit();
		 exit('A');
	}
	
	catch (Exception $e) {
    // An exception has been thrown
    // We must rollback the transaction
    $conn_pdo->rollback();
	exit("N");
}

	}
	
	/*Post comment */
				if ($_POST['key'] == 'PostComment') {
		$post_id=$_POST['post_id'];
		$comment_post_desc= $_POST['comment_post_desc'];
		
		//$front_image = $_FILES['upload_video']['name'];
 //move_uploaded_file($_FILES['upload_video']['tmp_name'],$file_path.$front_image);
 try {
    // First of all, let's begin a transaction
    $conn_pdo->beginTransaction();
 $sql_comment_on_post1="insert into cl_post_action 
	(r_post_id, 
	flg_action, 
	r_action_userid, 
	
	r_action_date
	)
	values
	('$post_id', 
	'comment', 
	'$login_user_userid', 
	
	now()
	);";
	//echo  $sql_comment_on_post1;
	$comment_on_post1 = $conn_pdo->prepare($sql_comment_on_post1);
	$comment_on_post1->execute();
	
	$sql_get_max_comment_id="select max(post_action_id) as max_post_action_id from cl_post_action where r_post_id ='$post_id'
	and flg_action = 'comment' and r_action_userid = '$login_user_userid';";
	//echo  $sql_get_max_comment_id;
	$get_max_comment_id = $conn_pdo->prepare($sql_get_max_comment_id);
	$get_max_comment_id->execute();
	$row_get_max_comment_id=$get_max_comment_id->fetch();
	
	$r_post_action_id=$row_get_max_comment_id['max_post_action_id'];
	
	
	 $sql_comment_on_post2="insert into cl_post_action_comment 
	(r_post_action_id, 
	comment
	)
	values
	('$r_post_action_id', 
	'$comment_post_desc'
	);";
	//echo  $sql_comment_on_post2;
	$comment_on_post2 = $conn_pdo->prepare($sql_comment_on_post2);
	$comment_on_post2->execute();
 				$conn_pdo->commit();
				
				
				$sql_get_post_comment_details="select *,date_format(r_action_date,'%M %d, %Y at %H:%i') as comment_dt from (cl_post_action inner join cl_post_action_comment on post_action_id=r_post_action_id) inner join userprofiles on 
userid = r_action_userid where r_post_id='$post_id' and flg_action='comment' order by r_action_date asc;";
													$get_post_comment_details = $conn_pdo->prepare($sql_get_post_comment_details);
													$get_post_comment_details ->execute();
													if ($get_post_comment_details->rowCount() > 0) {
													$row_get_post_comment_details=$get_post_comment_details->fetchAll();
													foreach($row_get_post_comment_details as $data_get_post_comment_details)
													{
															$commenter_profile_picture= $data_get_post_comment_details['profileimage'];
															$commenter_user_name= $data_get_post_comment_details['fullname'];
															$comment_dt= $data_get_post_comment_details['comment_dt'];
															$comment= $data_get_post_comment_details['comment'];
															$post_action_id= $data_get_post_comment_details['post_action_id'];
															$response_post ='<div class="d-flex align-items-center px-4 py-2">
																<div class="symbol symbol-60 symbol-circle symbol-xl-50 mr-3">
																	<img class="img-fluid" src="profile_pictures/'.$commenter_profile_picture.'" alt="">
																</div>
																<div class="w-100">
																	<div class="d-flex justify-content-between">
																		<span class="font-weight-bolder text-dark font-size-md d-block" title="">'.$commenter_user_name.'</span>
																		<span class="text-dark font-weight-bold font-size-sm d-block">'.$comment_dt.'</span>
																	</div>
																	<span class="text-dark font-weight-bolde font-size-sm d-block mb-2">'.$comment.'</span>
																	</div></div>
																	<div id="post_comment_reply_'.$post_id.'_'.$post_action_id.'" style="margin-left:10%;">
																	
															
																	
																
															</div>
															
															
															<span style="margin-left:20%" data-toggle="modal" onclick="get_post_reply_details(this.id)" id="search_post_comment_'.$post_id.'_'.$post_action_id.'" data-target="#comment_post_reply" ><i class="fas fa-reply-all text-info"></i><span class="ml-2">Reply</span></span>
																	
															</div>';
													}
													}
				
				
				
				$response='A~~~'.$response_post.'~~~'.$post_id;
				
				
		 exit($response);
	}
	
	catch (Exception $e) {
    // An exception has been thrown
    // We must rollback the transaction
    $conn_pdo->rollback();
	exit("N");
}

	}
	/*End of post comment*/
	
	
	/*POst Comment Reply*/
					if ($_POST['key'] == 'PostCommentReply') {
		$post_reply_id=$_POST['post_reply_id'];
		$comment_reply_id=$_POST['comment_reply_id'];
		$comment_post_reply_desc= $_POST['comment_post_reply_desc'];
		
		//$front_image = $_FILES['upload_video']['name'];
 //move_uploaded_file($_FILES['upload_video']['tmp_name'],$file_path.$front_image);
 try {
    // First of all, let's begin a transaction
    $conn_pdo->beginTransaction();
 $sql_comment_on_post1="insert into cl_post_action 
	(r_post_id, 
	flg_action, 
	r_action_userid, 
	ref_post_action_id,
	r_action_date
	)
	values
	('$post_reply_id', 
	'answer', 
	'$login_user_userid', 
	'$comment_reply_id',
	now()
	);";
	//echo  $sql_comment_on_post1;
	$comment_on_post1 = $conn_pdo->prepare($sql_comment_on_post1);
	$comment_on_post1->execute();
	
	$sql_get_max_comment_id="select max(post_action_id) as max_post_action_id from cl_post_action where r_post_id ='$post_reply_id'
	and ref_post_action_id ='$comment_reply_id' and flg_action = 'answer' and r_action_userid = '$login_user_userid';";
	//echo  $sql_get_max_comment_id;
	$get_max_comment_id = $conn_pdo->prepare($sql_get_max_comment_id);
	$get_max_comment_id->execute();
	$row_get_max_comment_id=$get_max_comment_id->fetch();
	
	$r_post_action_id=$row_get_max_comment_id['max_post_action_id'];
	
	
	 $sql_comment_on_post2="insert into cl_post_action_comment 
	(r_post_action_id, 
	comment
	)
	values
	('$r_post_action_id', 
	'$comment_post_reply_desc'
	);";
	//echo  $sql_comment_on_post2;
	$comment_on_post2 = $conn_pdo->prepare($sql_comment_on_post2);
	$comment_on_post2->execute();
 				$conn_pdo->commit();
				
				
				$sql_get_post_comment_reply="select *,date_format(r_action_date,'%M %d, %Y at %H:%i') as comment_dt from (cl_post_action inner join cl_post_action_comment on post_action_id=r_post_action_id) inner join userprofiles on 
userid = r_action_userid where r_post_id='$post_reply_id' and flg_action='answer' and ref_post_action_id = '$comment_reply_id' order by r_action_date asc;";
																	$get_post_comment_reply = $conn_pdo->prepare($sql_get_post_comment_reply);
													$get_post_comment_reply ->execute();
													if ($get_post_comment_reply->rowCount() > 0) {
													$row_get_post_comment_reply=$get_post_comment_reply->fetchAll();
													foreach($row_get_post_comment_reply as $data_get_post_comment_reply)
													{
														
														$commenter_profile_picture_reply= $data_get_post_comment_reply['profileimage'];
															$commenter_user_name_reply= $data_get_post_comment_reply['fullname'];
															$comment_dt_reply= $data_get_post_comment_reply['comment_dt'];
															$comment_reply= $data_get_post_comment_reply['comment'];
																	$response_post .='
																	<div class="d-flex align-items-center px-4 py-2">
																<div class="symbol symbol-60 symbol-circle symbol-xl-50 mr-3">
																	<img class="img-fluid" src="profile_pictures/'.$commenter_profile_picture_reply.'" alt="">
																</div>
																<div class="w-100">
																	<div class="d-flex justify-content-between">
																		<span class="font-weight-bolder text-dark font-size-md d-block" title="">'.$commenter_user_name_reply.'</span>
																		<span class="text-dark font-weight-bold font-size-sm d-block">'.$comment_dt_reply.'</span>
																	</div>
																	<span class="text-dark font-weight-bolde font-size-sm d-block mb-2">'.$comment_reply.'</span>
																	
																</div>
															</div>
															';
													}
													}
				
				
				
				$response='A~~~'.$response_post.'~~~'.$post_reply_id.'~~~'.$comment_reply_id;
				//$response='A~~~';
				
		 exit($response);
	}
	
	catch (Exception $e) {
    // An exception has been thrown
    // We must rollback the transaction
    $conn_pdo->rollback();
	exit("N");
}

	}
	/*End of Post Comment Reply*/
	
	
	
	
	if($_POST['key'] == 'get_frient_list')
	{
		
		$search_keyword=$_POST['search_keyword'];
		$filter_by_name="";
		if($search_keyword!='')
		{
			$filter_by_name=" and fullname like '%$search_keyword%'";
		}
		
		
		$friend_list_response ='<li class="nav-item">
									<a class="nav-link p-6 active" data-toggle="tab" href="friend-one" id="friend-one-tab">
										<div class="d-flex align-items-center w-100">
											<div class="symbol symbol-60 symbol-circle symbol-xl-50 mr-3">
												<img class="img-fluid" src="public/app-assets/images/icons/group.jpg" alt="">
												<i class="symbol-badge symbol-badge-bottom bg-success"></i>
											</div>
											<div class="w-100">
												<div class="d-flex align-items-center justify-content-between w-100">
													<span class="font-weight-bolder text-info font-size-md d-block" title="">Name of friend</span>
												</div>
												<span
												class="text-dark font-weight-bolder font-size-sm d-block">School / College name</span>
												<span class="text-muted font-weight-bolder font-size-sm">Term / Year</span>
											</div>
										</div>
									</a>
								</li>
								<li class="nav-item">
									<a class="nav-link p-6" data-toggle="tab" href="">
										<div class="d-flex align-items-center w-100">
											<div class="symbol symbol-60 symbol-circle symbol-xl-50 mr-3">
												<img class="img-fluid" src="public/app-assets/images/icons/group1.jpg" alt="">
												<i class="symbol-badge symbol-badge-bottom bg-dark"></i>
											</div>
											<div class="w-100">
												<div class="d-flex align-items-center justify-content-between w-100">
													<span class="font-weight-bolder text-info font-size-md d-block" title="">Name of friend</span>
												</div>
												<span
												class="text-dark font-weight-bolder font-size-sm d-block">School / College name</span>
												<span class="text-muted font-weight-bolder font-size-sm">Term / Year</span>
											</div>
										</div>
									</a>
								</li>
								<li class="nav-item">
									<a class="nav-link p-6" data-toggle="tab" href="">
										<div class="d-flex align-items-center w-100">
											<div class="symbol symbol-60 symbol-circle symbol-xl-50 mr-3">
												<img class="img-fluid" src="public/app-assets/images/icons/group.jpg" alt="">
												<i class="symbol-badge symbol-badge-bottom bg-dark"></i>
											</div>
											<div class="w-100">
												<div class="d-flex align-items-center justify-content-between w-100">
													<span class="font-weight-bolder text-info font-size-md d-block" title="">Name of friend</span>
												</div>
												<span
												class="text-dark font-weight-bolder font-size-sm d-block">School / College name</span>
											<span class="text-muted font-weight-bolder font-size-sm"> [Year] / [Term] </span>
											</div>
										</div>
									</a>
								</li>';
								
								$friend_list_response ='';
								
								$sql_get_friend_list="select *,userprofiles.email as email_id from (cl_friends inner join users on 
								cl_friends.r_friend_userid = users.id) inner join userprofiles on users.id=userprofiles.userid
  where r_userid = $login_user_userid $filter_by_name 
  
  union all 
  
select *,userprofiles.email as email_id from (cl_friends inner join users on cl_friends.r_userid = users.id) 

inner join userprofiles on users.id=userprofiles.userid where r_friend_userid = $login_user_userid $filter_by_name 

order by fraindhship_date desc";
  //echo $sql_get_friend_list;
  $get_friend_list = $conn_pdo->prepare($sql_get_friend_list);
        $get_friend_list ->execute();
        if ($get_friend_list->rowCount() > 0) {
            //while ($data_get_stage = $get_stage->fetch_array()) {
				$row_get_friend_list=$get_friend_list->fetchAll();
				$i=1;
				foreach($row_get_friend_list as $data_get_friend_list)
												{
													$tab_active='';
													if($i==1)
													{
														$tab_active='active';
													}
													
								
													
													
													
								$fullname=$data_get_friend_list['fullname'];
								$profileimage=$data_get_friend_list['profileimage'];
								$friend_id_for_wall=(int)$data_get_friend_list['userid'];
								
								$institutename=$data_get_friend_list['Primeinstitutename'];
	$acca_year=$data_get_friend_list['primetermname'];
	$term=$data_get_friend_list['primeacademicname'];
	
								$friend_list_response .='<li class="nav-item">
									<a class="nav-link p-6 '.$tab_active.'" data-toggle="tab" href="friend-one" id="friend-one-tab" onclick="change_wall_details('.$friend_id_for_wall.');get_chat_area('.$friend_id_for_wall.',\''.$fullname.'\',0)">
										<div class="d-flex align-items-center w-100">
											<div class="symbol symbol-60 symbol-circle symbol-xl-50 mr-3">
												<img class="img-fluid" src="profile_pictures/'.$profileimage.'" alt="">
												<i class="symbol-badge symbol-badge-bottom bg-success"></i>
											</div>
											<div class="w-100">
												<div class="d-flex align-items-center justify-content-between w-100">
													<span class="font-weight-bolder text-info font-size-md d-block" title="">'.$fullname.'</span>
												</div>
												<span
												class="text-dark font-weight-bolder font-size-sm d-block">'.$institutename.'</span>
												<span class="text-muted font-weight-bolder font-size-sm">'.$term.' / '.$acca_year.'</span>
											</div>
										</div>
									</a>
								</li>';
								$i++;
												}
			}
								
								echo $friend_list_response;
	}
	
	if($_POST['key'] == 'get_searched_frient_list')
	{
		$searched_key=$_POST['searched_key'];
		
		if($searched_key=='')
		{
		
		$response_get_friend_list=' 					<div class="my-3">
															<span class="font-weight-bolder text-dark font-size-md d-block" title="">Type to Search.....</span>
														</div>';
		}
		else{
			
			/*$sql_search_frn_send_frnd_req="select *,userid,fullname from ((users inner join userprofiles on users.id=userprofiles.userid) left join cl_friends on r_userid='$login_user_userid' and 
r_friend_userid=userprofiles.userid)  left join cl_friends opp_cl_friends on opp_cl_friends.r_userid=userprofiles.userid and 
opp_cl_friends.r_friend_userid='$login_user_userid'
where cl_friends.friend_id is null and opp_cl_friends.friend_id is null and userprofiles.userid<>'$login_user_userid' and userprofiles.fullname like '%$searched_key%' ;";*/
			
			$sql_search_frn_send_frnd_req="select *,userid,fullname from 
((((users inner join userprofiles on users.id=userprofiles.userid) 
left join cl_friends on r_userid='$login_user_userid' and r_friend_userid=userprofiles.userid) 
left join cl_friends opp_cl_friends on opp_cl_friends.r_userid=userprofiles.userid and 
opp_cl_friends.r_friend_userid='$login_user_userid') 

left join cl_friend_request cl_friend_req1 on 
cl_friend_req1.r_userid='$login_user_userid' and cl_friend_req1.r_userid_request = userprofiles.userid and cl_friend_req1.flg_action in ('0','accept')

) 

left join cl_friend_request cl_friend_req2 on 
cl_friend_req2.r_userid_request='$login_user_userid' and cl_friend_req2.r_userid = userprofiles.userid and cl_friend_req2.flg_action in ('0','accept')


 where cl_friends.friend_id is null and opp_cl_friends.friend_id is null and 
cl_friend_req1.friend_request_id is null and cl_friend_req2.friend_request_id is null and userprofiles.userid<>'$login_user_userid' and userprofiles.fullname like '%$searched_key%' ;";

//echo $sql_search_frn_send_frnd_req;

			/*$response_get_friend_list='<div class="d-flex align-items-center w-100 justify-content-between my-3">
															<div class="d-flex align-items-center">
																<div class="symbol symbol-60 symbol-circle symbol-xl-20 mr-3">
																	<img class="img-fluid" src="public/app-assets/images/icons/group.jpg" alt="">
																</div>
																<div class="d-flex align-items-center justify-content-between w-100">
																	<span class="font-weight-bolder text-info font-size-md d-block" title="">Mark Stone</span>
																</div>
															</div>
															<div>
																<a href="javascript:void()">
																<i class="fas fa-user-plus text-info user-invite" data-toggle="tooltip" title="Invite Friend"></i>
																</a>
															</div>
														</div>
														<hr class="m-0">
														<div class="d-flex align-items-center w-100 justify-content-between my-3">
															<div class="d-flex align-items-center">
																<div class="symbol symbol-60 symbol-circle symbol-xl-20 mr-3">
																	<img class="img-fluid" src="public/app-assets/images/icons/group1.jpg" alt="">
																</div>
																<div class="d-flex align-items-center justify-content-between w-100">
																	<span class="font-weight-bolder text-info font-size-md d-block" title="">Charlie Stone</span>
																</div>
															</div>
															<div>
																<a href="javascript:void()">
																<i class="fas fa-user-plus text-info user-invite" data-toggle="tooltip" title="Invite Friend"></i>
																</a>
															</div>
														</div>
														<hr class="m-0">
														<div class="d-flex align-items-center w-100 justify-content-between my-3">
															<div class="d-flex align-items-center">
																<div class="symbol symbol-60 symbol-circle symbol-xl-20 mr-3">
																	<img class="img-fluid" src="public/app-assets/images/icons/group2.jpg" alt="">
																</div>
																<div class="d-flex align-items-center justify-content-between w-100">
																	<span class="font-weight-bolder text-info font-size-md d-block" title="">Luca Doncic</span>
																</div>
															</div>
															<div>
																<a href="javascript:void()">
																<i class="fas fa-user-plus text-info user-invite" data-toggle="tooltip" title="Invite Friend"></i>
																</a>
															</div>
														</div>
														<hr class="m-0">
														<!--div class="my-3">
															<span class="font-weight-bolder text-dark font-size-md d-block" title="">View All</span>
														</div-->';*/
													$search_frn_send_frnd_req=$conn_pdo->prepare($sql_search_frn_send_frnd_req);	
									 $search_frn_send_frnd_req ->execute();
        if ($search_frn_send_frnd_req->rowCount() > 0) {
            
				$row_search_frn_send_frnd_req=$search_frn_send_frnd_req->fetchAll();
				
				foreach($row_search_frn_send_frnd_req as $data_search_frn_send_frnd_req)
												{
														$response_get_friend_list='<div class="d-flex align-items-center w-100 justify-content-between my-3">
															<div class="d-flex align-items-center">
																<div class="symbol symbol-60 symbol-circle symbol-xl-20 mr-3">
																	<img class="img-fluid" src="profile_pictures/'.$data_search_frn_send_frnd_req['profileimage'].'" alt="">
																</div>
																<div class="d-flex align-items-center justify-content-between w-100">
																	<span class="font-weight-bolder text-info font-size-md d-block" title="">'.$data_search_frn_send_frnd_req['fullname'].'</span>
																</div>
															</div>
															<div>
																<a href="#" onclick="send_fried_request('.(int)$data_search_frn_send_frnd_req['userid'].')">
																<i class="fas fa-user-plus text-info user-invite" id="change_invite_link_'.(int)$data_search_frn_send_frnd_req['userid'].'" data-toggle="tooltip" title="Invite Friend"></i>
																</a>
															</div>
														</div>
														<hr class="m-0">
													';
												}
			}
			
			else{
				
				$response_get_friend_list=' 					<div class="my-3">
															<span class="font-weight-bolder text-dark font-size-md d-block" title="">No Friend found by the name.....</span>
														</div>';
				
			}
		}
		
		
		echo $response_get_friend_list;
		
	}
	
	
	
		if($_POST['key'] == 'send_registered_frient_request')
	{
		$req_friend_id=$_POST['req_friend_id'];
		
		
		 try {
    // First of all, let's begin a transaction
    $conn_pdo->beginTransaction();
		$sql_insert_to_sent_frnd_req="insert into cl_friend_request 
	(r_userid, 
	r_userid_request, 
	
	flg_send_receive, /*send/receive*/
	request_date
	)
	values
	('$login_user_userid', 
	'$req_friend_id', 
	
	'send', 
	now()
	);";
		
		$insert_to_sent_frnd_req=$conn_pdo->prepare($sql_insert_to_sent_frnd_req);	
		$insert_to_sent_frnd_req ->execute();
		
		$conn_pdo->commit();
		
		//$mydate = date('d/m/Y');

    $mysubject = " Friend Request Pending In Collaboration";
	
	
	$sql_send_friend_request_detail="select * from users inner join userprofiles on users.id=userprofiles.userid 
	where userprofiles.userid  = $req_friend_id";
	$send_friend_request_detail = $conn_pdo->prepare($sql_send_friend_request_detail);
	$send_friend_request_detail ->execute();
	$row_send_friend_request_detail=$send_friend_request_detail->fetch();
	
		$to_mail_id_req=$row_send_friend_request_detail['email'];
		
		$sql_get_email_body="select * from cl_email_type where email_type_id=1;";
		$get_email_body = $conn_pdo->prepare($sql_get_email_body);
	$get_email_body ->execute();
	$row_get_email_body=$get_email_body->fetch();
		
		 $email_body = "<html><body>";
		$email_body .= "<br /><p>Dear ".$row_send_friend_request_detail['fullname'].",</p>


<p>".$row_get_email_body['email_body'].".</p>

<p>Request received from ".$login_user_fullname."</p>

<p>From,</p>

<p>Collaboration</p>
<p><img src='' alt='LOGO'></p>";


        


    $email_body .= "</body></html>";
		
		$from="clixlogictms.com";
		$reply_to="";
		$cc_to="";
		$bcc_to="";
		
		$bound_text = md5(uniqid(rand(), true));
    $bound = "--" . $bound_text . "\r\n";
    $bound_last = "--" . $bound_text . "--\r\n";

    $headers = "From: " . $from . "\r\n"
        . "Reply-To: " . $from . "\r\n"
        . "Return-Path: " . $reply_to . "\r\n"
        . "CC: " . $cc_to . "\r\n"
        . "BCC: " . $bcc_to . "\r\n"
        . "MIME-Version: 1.0\r\n"
        . "Content-Type: multipart/mixed; boundary=\"$bound_text\"";

    $message =  "Sorry, your client doesn't support MIME types.\r\n"
        . "Contact " . $from . " for tech support.\r\n"
        . $bound;

    $message .= "Content-Type: text/html; charset=\"iso-8859-1\"\r\n"
        . "Content-Transfer-Encoding: 7bit\r\n\r\n"
        . $email_body . "\r\n"
        . $bound;

   

   mail($to_mail_id_req, $mysubject, $message, $headers);
		
		
		
		
		exit("A");
		 }
		 
		 	catch (Exception $e) {
    // An exception has been thrown
    // We must rollback the transaction
    $conn_pdo->rollback();
	exit("N");
}
		
		
	}
	
	
	
	
	if($_POST['key'] == 'get_invited_friend_list')
	{
		
		/*$sql_get_invited_friend_list="select *,date_format(request_date,'%M %d, %Y at %H:%i') as request_dt from (cl_friend_request inner join  users on cl_friend_request.r_userid_request=users.id) inner join userprofiles on users.id=userprofiles.userid 
					where cl_friend_request.r_userid  = $login_user_userid and flg_action = '0';";*/
					
					
					$sql_get_invited_friend_list="select *,date_format(request_date,'%M %d, %Y at %H:%i') as request_dt from 
(cl_friend_request inner join  users on cl_friend_request.r_userid_request=users.id) 
inner join userprofiles on users.id=userprofiles.userid 
					where cl_friend_request.r_userid  = $login_user_userid and flg_action = '0'

union all

select *,date_format(request_date,'%M %d, %Y at %H:%i') as request_dt from 
(cl_friend_request left join  users on cl_friend_request.cl_friend_request_emails=users.email) 
left join userprofiles on users.id=userprofiles.userid 
					where cl_friend_request.r_userid  = $login_user_userid and cl_friend_request.r_userid_request is null
 and flg_action = '0';";
					$get_invited_friend_list=$conn_pdo->prepare($sql_get_invited_friend_list);	
									 $get_invited_friend_list ->execute();
        if ($get_invited_friend_list->rowCount() > 0) {
            
				$row_get_invited_friend_list=$get_invited_friend_list->fetchAll();
				
				foreach($row_get_invited_friend_list as $data_get_invited_friend_list)
												{
													
													
	$institutename=$data_get_invited_friend_list['Primeinstitutename'];
	$acca_year=$data_get_invited_friend_list['primetermname'];
	$term=$data_get_invited_friend_list['primeacademicname'];
	$r_userid_request = $data_get_invited_friend_list['r_userid_request'];
	
	$cl_friend_request_emails = $data_get_invited_friend_list['cl_friend_request_emails'];
	
	$friend_request_id = $data_get_invited_friend_list['friend_request_id'];
		
		if($r_userid_request>0)
		{
		$reponse_invited_friend_list.='<li class="nav-item">
										<a class="nav-link p-6" data-toggle="tab" href="">
											<div class="d-flex align-items-center w-100">
												<div class="symbol symbol-60 symbol-circle symbol-xl-50 mr-3">
													<img class="img-fluid" src="profile_pictures/'.$data_get_invited_friend_list['profileimage'].'" alt="">
													<!--i class="symbol-badge symbol-badge-bottom bg-white"></i-->
												</div>
												<div class="w-100">
												<div class="d-flex align-items-center justify-content-between w-100">
													<span class="font-weight-bolder text-info font-size-md d-block" title="">'.$data_get_invited_friend_list['fullname'].'</span>
													<div class="card-toolbar ml-lg-0 ml-md-1 ml-2">
														<div class="dropdown dropdown-inline">
															<button type="button" class="btn btn-hover-light-primary btn-icon btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
																<i class="ki ki-bold-more-hor "></i>
															</button>
															<div class="dropdown-menu dropdown-menu-sm dropdown-menu-right" x-placement="bottom-end">
																<span class="dropdown-item font-size-md text-info font-weight-bold py-1" href="javascript:void(0)" onclick="resend_invitation('.(int)$data_get_invited_friend_list['r_userid'].')"> Re-send Invite</span>
																<span class="dropdown-item font-size-md text-info font-weight-bold py-1" href="javascript:void(0)" onclick="cancel_invite_frnd('.(int)$friend_request_id.')">Cancel Invite</span>
															</div>
														</div>
													</div>
												</div>
												<span
												class="text-dark font-weight-bolder font-size-sm d-block">'.$institutename.'</span>
												<span class="text-muted font-weight-bolder font-size-sm">'.$term.' / '.$acca_year.'</span>
												<span class="text-dark-75 font-weight-bolder d-block font-size-sm font-weight-bolder"><span class="text-muted  font-size-sm mr-2">Invite sent on</span>'.$data_get_invited_friend_list['request_dt'].'</span>
											</div>
											</div>
										</a>
									</li>';
		}
		else{
									$reponse_invited_friend_list.='<li class="nav-item">
									<a class="nav-link p-6" data-toggle="tab" href="">
										<div class="d-flex align-items-center w-100">
											<div class="symbol symbol-60 symbol-circle symbol-xl-50 mr-3">
												<img class="img-fluid" src="profile_pictures/download.png" alt="">
												<!--i class="symbol-badge symbol-badge-bottom bg-dark"></i-->
											</div>
											<div class="w-100">
												<div class="d-flex align-items-center justify-content-between w-100">
													<span class="font-weight-bolder text-info font-size-md d-block" title="">'.$cl_friend_request_emails.'</span>
													<div class="card-toolbar ml-lg-0 ml-md-1 ml-2">
														<div class="dropdown dropdown-inline">
															<button type="button" class="btn btn-hover-light-primary btn-icon btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
																<i class="ki ki-bold-more-hor "></i>
															</button>
															<div class="dropdown-menu dropdown-menu-sm dropdown-menu-right" x-placement="bottom-end">
																<span class="dropdown-item font-size-md text-info font-weight-bold py-1" href="javascript:void(0)" onclick="resend_invitation_unregfrnd(\''.$cl_friend_request_emails.'\')"> Re-send Invite</span>
																<span class="dropdown-item font-size-md text-info font-weight-bold py-1" href="javascript:void(0)" onclick="cancel_invite_frnd('.(int)$friend_request_id.')">Cancel Invite</span>
															</div>
														</div>
													</div>
												</div>
												<!--span
												class="text-dark font-weight-bolder font-size-sm d-block">School / College name</span>
												<span class="text-muted font-weight-bolder font-size-sm">Term / Year</span-->
											</div>
										</div>
									</a>
								</li>';
		}
												}
		}
								echo $get_invited_friend_list->rowCount().'~~~'.$reponse_invited_friend_list;
	}
	
	
	if($_POST['key'] == 'get_friend_requested_friend_list')
	{
		
		$sql_get_received_request_friend_list="select *,date_format(request_date,'%M %d, %Y at %H:%i') as request_dt from (cl_friend_request inner join  users on cl_friend_request.r_userid=users.id) inner join userprofiles on users.id=userprofiles.userid 
					where cl_friend_request.r_userid_request = $login_user_userid and flg_action ='0' ;";
		//echo $sql_get_received_request_friend_list;
		$get_received_request_friend_list=$conn_pdo->prepare($sql_get_received_request_friend_list);	
									 $get_received_request_friend_list ->execute();
        if ($get_received_request_friend_list->rowCount() > 0) {
            
				$row_get_received_request_friend_list=$get_received_request_friend_list->fetchAll();
				
				foreach($row_get_received_request_friend_list as $data_get_received_request_friend_list)
												{
													
													$from_frnd_id=(int)$data_get_received_request_friend_list['r_userid'];
													$friend_request_id=(int)$data_get_received_request_friend_list['friend_request_id'];
													
													
													$extradetail_user_id=$data_get_received_request_friend_list['userid'];
													$institutename=$data_get_received_request_friend_list['Primeinstitutename'];
	$acca_year=$data_get_received_request_friend_list['primetermname'];
	$term=$data_get_received_request_friend_list['primeacademicname'];
	
		$response_received_friend_request.='<li class="nav-item">
											<a class="nav-link p-6" data-toggle="tab" href="">
												<div class="d-flex align-items-center w-100">
													<div class="symbol symbol-60 symbol-circle symbol-xl-50 mr-3">
														<img class="img-fluid" src="profile_pictures/'.$data_get_received_request_friend_list['profileimage'].'" alt="">
														<!--i class="symbol-badge symbol-badge-bottom bg-success"></i-->
													</div>
													<div class="w-100">
												<div class="d-flex align-items-center justify-content-between w-100">
													<span class="font-weight-bolder text-info font-size-md d-block" title="">'.$data_get_received_request_friend_list['fullname'].'</span>
													<div class="card-toolbar ml-lg-0 ml-md-1 ml-2">
														<div class="dropdown dropdown-inline">
															<button type="button" class="btn btn-hover-light-primary btn-icon btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
																<i class="ki ki-bold-more-hor "></i>
															</button>
															<div class="dropdown-menu dropdown-menu-sm dropdown-menu-right" x-placement="bottom-end">
																<span class="dropdown-item font-size-md text-info font-weight-bold py-1" onclick="frnd_req_accept_reject('.$from_frnd_id.',\'A\','.$friend_request_id.');"> Accept Invite</span>
																<span class="dropdown-item font-size-md text-info font-weight-bold py-1" onclick="frnd_req_accept_reject('.$from_frnd_id.',\'R\','.$friend_request_id.');">Reject Invite</span>
																<!--span class="dropdown-item font-size-md text-info font-weight-bold py-1" href="javascript:void(0)">Block Invite</span-->
															</div>
														</div>
													</div>
												</div>
												<span
												class="text-dark font-weight-bolder font-size-sm d-block">'.$institutename.'</span>
												<span class="text-muted font-weight-bolder font-size-sm">'.$term.' / '.$acca_year.'</span>
												<span class="text-dark-75 font-weight-bolder d-block font-size-sm font-weight-bolder"><span class="text-muted  font-size-sm mr-2">Invite received on</span>'.$data_get_received_request_friend_list['request_dt'].'</span>
											</div>
												</div>
											</a>
										</li>';
												}
		}
										
										
										echo $get_received_request_friend_list->rowCount().'~~~'.$response_received_friend_request;
	}
	
	
	if($_POST['key'] == 'friend_req_accept_reject')
	{
		$requested_from_friend_id=$_POST['requested_from_friend_id'];
		$action_type=$_POST['action_type'];
		$frnd_request_id=$_POST['frnd_request_id'];
		
		 try {
    // First of all, let's begin a transaction
    $conn_pdo->beginTransaction();
		if($action_type=='A')
		{
			$sql_update="update cl_friend_request 
	set
	
	
	flg_action = 'accept' , 
	action_date = now() 
	
	where
	friend_request_id = '$frnd_request_id' ;";

$update=$conn_pdo->prepare($sql_update);	
									 $update ->execute();

$sql_insert="insert into cl_friends 
	(r_userid, 
	r_friend_userid, 
	fraindhship_date 
	
	)
	values
	('$requested_from_friend_id', 
	'$login_user_userid', 
	now()
	);";
	
	$insert=$conn_pdo->prepare($sql_insert);	
									 $insert ->execute();
		}
		
		else if($action_type=='R')
		{
			$sql_update="update cl_friend_request 
	set
	
	
	flg_action = 'reject' , 
	action_date = now() 
	
	where
	friend_request_id = '$frnd_request_id' ;";
	$update=$conn_pdo->prepare($sql_update);	
									 $update ->execute();
									 
									 $sql_send_friend_request_detail_from_user="select * from users inner join userprofiles on users.id=userprofiles.userid 
	where userprofiles.userid  = $requested_from_friend_id";
	$send_friend_request_detail_from_user = $conn_pdo->prepare($sql_send_friend_request_detail_from_user);
	$send_friend_request_detail_from_user ->execute();
	$row_send_friend_request_detail_from_user=$send_friend_request_detail_from_user->fetch();
	$to_mail_id=$row_send_friend_request_detail_from_user['email'];
									 
									 
									 
									 $sql_get_email_body="select * from cl_email_type where email_type_id=3;";
		$get_email_body = $conn_pdo->prepare($sql_get_email_body);
	$get_email_body ->execute();
	$row_get_email_body=$get_email_body->fetch();
		
		
		$mysubject = " Friend Request Rejected";
		
		
		 $email_body = "<html><body>";
		$email_body .= "<br /><p>Dear ".$row_send_friend_request_detail_from_user['fullname'].",</p>


<p>".$row_get_email_body['email_body'].".</p>

<p>Rejected by ".$login_user_fullname."</p>

<p>From,</p>

<p>Collaboration</p>
<p><img src='' alt='LOGO'></p>";


        


    $email_body .= "</body></html>";
		
		$from="clixlogictms.com";
		$reply_to="";
		$cc_to="";
		$bcc_to="";
		$bound_text = md5(uniqid(rand(), true));
    $bound = "--" . $bound_text . "\r\n";
    $bound_last = "--" . $bound_text . "--\r\n";

    $headers = "From: " . $from . "\r\n"
        . "Reply-To: " . $from . "\r\n"
        . "Return-Path: " . $reply_to . "\r\n"
        . "CC: " . $cc_to . "\r\n"
        . "BCC: " . $bcc_to . "\r\n"
        . "MIME-Version: 1.0\r\n"
        . "Content-Type: multipart/mixed; boundary=\"$bound_text\"";

    $message =  "Sorry, your client doesn't support MIME types.\r\n"
        . "Contact " . $from . " for tech support.\r\n"
        . $bound;

    $message .= "Content-Type: text/html; charset=\"iso-8859-1\"\r\n"
        . "Content-Transfer-Encoding: 7bit\r\n\r\n"
        . $email_body . "\r\n"
        . $bound;

   

   mail($to_mail_id, $mysubject, $message, $headers);
									 
									 
									 
									 
									 
	
		}
		
		$conn_pdo->commit();
		exit("Y");
		 }
		 
		 		 	catch (Exception $e) {
    // An exception has been thrown
    // We must rollback the transaction
    $conn_pdo->rollback();
	exit("N");
}
		
		
		
		
	}
	
	
	if($_POST['key'] == 'send_unregistered_frient_request')
	{
		$unregistered_frient_email=$_POST['unregistered_frient_email'];
		
		
		$sql_already_registered_or_not="select * from users inner join userprofiles on users.id=userprofiles.userid 
	where userprofiles.email= '$unregistered_frient_email'";
	
	$already_registered_or_not=$conn_pdo->prepare($sql_already_registered_or_not);	
									 $already_registered_or_not ->execute();
        if ($already_registered_or_not->rowCount() > 0) {
            
				$row_get_received_request_friend_list=$already_registered_or_not->fetch();
				
				$if_registered_user_id=$row_get_received_request_friend_list['userid'];
				$flg_already_registered='yes';
				
				
				try {
    // First of all, let's begin a transaction
    $conn_pdo->beginTransaction();
		$sql_insert_to_sent_frnd_req="insert into cl_friend_request 
	(r_userid, 
	r_userid_request, 
	
	flg_send_receive, /*send/receive*/
	request_date
	)
	values
	('$login_user_userid', 
	'$if_registered_user_id', 
	
	'send', 
	now()
	);";
		//echo $sql_insert_to_sent_frnd_req;
		$insert_to_sent_frnd_req=$conn_pdo->prepare($sql_insert_to_sent_frnd_req);	
		$insert_to_sent_frnd_req ->execute();
		
		$conn_pdo->commit();
		
		
		
		
		$mysubject = " Friend Request Pending In Collaboration";
	
	
	$sql_send_friend_request_detail="select * from users inner join userprofiles on users.id=userprofiles.userid 
	where userprofiles.userid  = $if_registered_user_id";
	$send_friend_request_detail = $conn_pdo->prepare($sql_send_friend_request_detail);
	$send_friend_request_detail ->execute();
	$row_send_friend_request_detail=$send_friend_request_detail->fetch();
	
		$to_mail_id_req=$row_send_friend_request_detail['email'];
		
		$sql_get_email_body="select * from cl_email_type where email_type_id=1;";
		$get_email_body = $conn_pdo->prepare($sql_get_email_body);
	$get_email_body ->execute();
	$row_get_email_body=$get_email_body->fetch();
		
		 $email_body = "<html><body>";
		$email_body .= "<br /><p>Dear ".$row_send_friend_request_detail['fullname'].",</p>


<p>".$row_get_email_body['email_body'].".</p>

<p>Request received from ".$login_user_fullname."</p>

<p>From,</p>

<p>Collaboration</p>
<p><img src='' alt='LOGO'></p>";


        


    $email_body .= "</body></html>";
		
		$from="clixlogictms.com";
		$reply_to="";
		$cc_to="";
		$bcc_to="";
		
		$bound_text = md5(uniqid(rand(), true));
    $bound = "--" . $bound_text . "\r\n";
    $bound_last = "--" . $bound_text . "--\r\n";

    $headers = "From: " . $from . "\r\n"
        . "Reply-To: " . $from . "\r\n"
        . "Return-Path: " . $reply_to . "\r\n"
        . "CC: " . $cc_to . "\r\n"
        . "BCC: " . $bcc_to . "\r\n"
        . "MIME-Version: 1.0\r\n"
        . "Content-Type: multipart/mixed; boundary=\"$bound_text\"";

    $message =  "Sorry, your client doesn't support MIME types.\r\n"
        . "Contact " . $from . " for tech support.\r\n"
        . $bound;

    $message .= "Content-Type: text/html; charset=\"iso-8859-1\"\r\n"
        . "Content-Transfer-Encoding: 7bit\r\n\r\n"
        . $email_body . "\r\n"
        . $bound;

   

   mail($to_mail_id_req, $mysubject, $message, $headers);
		
		
		
		
		$resp="Y";
				}
				
						 	catch (Exception $e) {
    // An exception has been thrown
    // We must rollback the transaction
    $conn_pdo->rollback();
	exit("N");
}
				
				
				
		}
		else{
			
			
			
		 try {
    // First of all, let's begin a transaction
    $conn_pdo->beginTransaction();
		$sql_insert_unregistered="insert into cl_friend_request 
	(r_userid, 
	cl_friend_request_emails, 
	
	flg_send_receive, 
	request_date
	
	)
	values
	('$login_user_userid', 
	'$unregistered_frient_email', 
	
	'send', 
	now()
	);";
	
	//echo $sql_insert_unregistered;
		$insert_unregistered=$conn_pdo->prepare($sql_insert_unregistered);	
									 $insert_unregistered ->execute();
									 
									 $conn_pdo->commit();
									 
									 
$mysubject = " Friend Invitation";
		$sql_get_email_body="select * from cl_email_type where email_type_id=2;";
		$get_email_body = $conn_pdo->prepare($sql_get_email_body);
	$get_email_body ->execute();
	$row_get_email_body=$get_email_body->fetch();
		
		 $email_body = "<html><body>";
		$email_body .= "<br /><p>Dear Patron,</p>


<p>".$row_get_email_body['email_body'].".</p>

<p><a href='#'> click here </a> to accept it.</p>

<p>know more about campuslife.</p>

<p><img src='' alt='LOGO'></p>";


        


    $email_body .= "</body></html>";
		
		$from="clixlogictms.com";
		$reply_to="";
		$cc_to="";
		$bcc_to="";
		
		$bound_text = md5(uniqid(rand(), true));
    $bound = "--" . $bound_text . "\r\n";
    $bound_last = "--" . $bound_text . "--\r\n";

    $headers = "From: " . $from . "\r\n"
        . "Reply-To: " . $from . "\r\n"
        . "Return-Path: " . $reply_to . "\r\n"
        . "CC: " . $cc_to . "\r\n"
        . "BCC: " . $bcc_to . "\r\n"
        . "MIME-Version: 1.0\r\n"
        . "Content-Type: multipart/mixed; boundary=\"$bound_text\"";

    $message =  "Sorry, your client doesn't support MIME types.\r\n"
        . "Contact " . $from . " for tech support.\r\n"
        . $bound;

    $message .= "Content-Type: text/html; charset=\"iso-8859-1\"\r\n"
        . "Content-Transfer-Encoding: 7bit\r\n\r\n"
        . $email_body . "\r\n"
        . $bound;

   

   mail($unregistered_frient_email, $mysubject, $message, $headers);
		 }
		 
		 		 		 	catch (Exception $e) {
    // An exception has been thrown
    // We must rollback the transaction
    $conn_pdo->rollback();
	exit("N");
}




		}
		

		
		exit('Y');
		
	}
	
	
	
	
	
	
	
	
	
			if($_POST['key'] == 'resend_registered_frient_request')
	{
		$req_friend_id=$_POST['req_friend_id'];
		
		//$mydate = date('d/m/Y');

    $mysubject = "Pending Friend Request Pending In Collaboration";
	
	
	$sql_send_friend_request_detail="select * from users inner join userprofiles on users.id=userprofiles.userid 
	where userprofiles.userid  = $req_friend_id";
	$send_friend_request_detail = $conn_pdo->prepare($sql_send_friend_request_detail);
	$send_friend_request_detail ->execute();
	$row_send_friend_request_detail=$send_friend_request_detail->fetch();
	
		$to_mail_id_req=$row_send_friend_request_detail['email'];
		
		$sql_get_email_body="select * from cl_email_type where email_type_id=1;";
		$get_email_body = $conn_pdo->prepare($sql_get_email_body);
	$get_email_body ->execute();
	$row_get_email_body=$get_email_body->fetch();
		
		 $email_body = "<html><body>";
		$email_body .= "<br /><p>Dear ".$row_send_friend_request_detail['fullname'].",</p>


<p>".$row_get_email_body['email_body'].".</p>

<p>Request received from ".$login_user_fullname."</p>

<p>From,</p>

<p>Collaboration</p>
<p><img src='' alt='LOGO'></p>";


        


    $email_body .= "</body></html>";
		
		$from="clixlogictms.com";
		$reply_to="";
		$cc_to="";
		$bcc_to="";
		
		$bound_text = md5(uniqid(rand(), true));
    $bound = "--" . $bound_text . "\r\n";
    $bound_last = "--" . $bound_text . "--\r\n";

    $headers = "From: " . $from . "\r\n"
        . "Reply-To: " . $from . "\r\n"
        . "Return-Path: " . $reply_to . "\r\n"
        . "CC: " . $cc_to . "\r\n"
        . "BCC: " . $bcc_to . "\r\n"
        . "MIME-Version: 1.0\r\n"
        . "Content-Type: multipart/mixed; boundary=\"$bound_text\"";

    $message =  "Sorry, your client doesn't support MIME types.\r\n"
        . "Contact " . $from . " for tech support.\r\n"
        . $bound;

    $message .= "Content-Type: text/html; charset=\"iso-8859-1\"\r\n"
        . "Content-Transfer-Encoding: 7bit\r\n\r\n"
        . $email_body . "\r\n"
        . $bound;

   

   mail($to_mail_id_req, $mysubject, $message, $headers);
		
		
		
		
		exit("A");

		
		
	}
	
	
	
	
	
	
		if($_POST['key'] == 're_send_unregistered_frient_request')
	{
		$unregistered_frient_email=$_POST['unregistered_frient_email'];
		
									 
									 
$mysubject = " Friend Invitation";
		$sql_get_email_body="select * from cl_email_type where email_type_id=2;";
		$get_email_body = $conn_pdo->prepare($sql_get_email_body);
	$get_email_body ->execute();
	$row_get_email_body=$get_email_body->fetch();
		
		 $email_body = "<html><body>";
		$email_body .= "<br /><p>Dear Patron,</p>


<p>".$row_get_email_body['email_body'].".</p>

<p><a href='#'> click here </a> to accept it.</p>

<p>know more about campuslife.</p>

<p><img src='' alt='LOGO'></p>";


        


    $email_body .= "</body></html>";
		
		$from="clixlogictms.com";
		$reply_to="";
		$cc_to="";
		$bcc_to="";
		
		$bound_text = md5(uniqid(rand(), true));
    $bound = "--" . $bound_text . "\r\n";
    $bound_last = "--" . $bound_text . "--\r\n";

    $headers = "From: " . $from . "\r\n"
        . "Reply-To: " . $from . "\r\n"
        . "Return-Path: " . $reply_to . "\r\n"
        . "CC: " . $cc_to . "\r\n"
        . "BCC: " . $bcc_to . "\r\n"
        . "MIME-Version: 1.0\r\n"
        . "Content-Type: multipart/mixed; boundary=\"$bound_text\"";

    $message =  "Sorry, your client doesn't support MIME types.\r\n"
        . "Contact " . $from . " for tech support.\r\n"
        . $bound;

    $message .= "Content-Type: text/html; charset=\"iso-8859-1\"\r\n"
        . "Content-Transfer-Encoding: 7bit\r\n\r\n"
        . $email_body . "\r\n"
        . $bound;

   

   mail($unregistered_frient_email, $mysubject, $message, $headers);

		

		
		exit('Y');
		
	}
	
	
	
	
	
	
	
		if($_POST['key'] == 'delete_frnd_invitation')
	{
		$invite_id=$_POST['invite_id'];
		
		 try {
    // First of all, let's begin a transaction
    $conn_pdo->beginTransaction();

		$sql_delete_frnd_invitation="delete from cl_friend_request where friend_request_id=$invite_id;";
		$delete_frnd_invitation = $conn_pdo->prepare($sql_delete_frnd_invitation);
	$delete_frnd_invitation ->execute();
		
		$conn_pdo->commit();
		exit("Y");
		 }
		 
		 		 	catch (Exception $e) {
    // An exception has been thrown
    // We must rollback the transaction
    $conn_pdo->rollback();
	exit("N");
}
		
		
		
		
	}
	
	
	/*start new code*/
	
	if($_POST['key'] == 'fetch_chat')
	{
		
		$to_user_id=$_POST['to_user_id'];
		
		$from_user_id=$login_user_userid;
		
		if($to_user_id==0)
		{
			
			$friend_id_for_wall=$_POST['frnd_wall_id'];
		
		 $sql_get_friend_list="select *,userprofiles.email as email_id from (cl_friends inner join users on cl_friends.r_friend_userid = users.id) inner join userprofiles on users.id=userprofiles.userid
  where r_userid = $login_user_userid   
  
  
  union all 
  
select *,userprofiles.email as email_id from (cl_friends inner join users on cl_friends.r_userid = users.id) 

inner join userprofiles on users.id=userprofiles.userid where r_friend_userid = $login_user_userid 

order by fraindhship_date desc limit 1";
  
  //echo $sql_get_friend_list;
  
  $get_friend_list = $conn_pdo->prepare($sql_get_friend_list);
        $get_friend_list ->execute();
        if ($get_friend_list->rowCount() > 0) {
            //while ($data_get_stage = $get_stage->fetch_array()) {
				$row_get_friend_list=$get_friend_list->fetch();
				$to_user_id=$row_get_friend_list['userid'];
			}
			
			
		}
		
	    $last_id=$_POST['max_chat_id'];
	    $where_chat_max_id="";
	    
	    if($last_id>0)
	    {
	    $where_chat_max_id=" and chat_message_id < $last_id ";
	    }
	    
	    
		
		$sql_get_chat_data="select * from 
		(select chat_message_id,a.fullname as from_user_name,b.fullname as to_user_name , chat_message,timestamp,chat_message.status as msg_status,to_user_id,
		from_user_id,a.profileimage as from_profile_image,b.profileimage  as to_profile_image
		from (chat_message 
		inner join userprofiles a on chat_message.from_user_id = a.userid) inner join userprofiles b on chat_message.to_user_id = b.userid 
		where ((chat_message.from_user_id = $from_user_id and chat_message.to_user_id = $to_user_id) or 
		(chat_message.from_user_id = $to_user_id and chat_message.to_user_id = $from_user_id)) $where_chat_max_id order by timestamp desc limit 10) t order by t.timestamp asc ;";
		//echo $sql_get_chat_data;
		$get_chat_data = $conn_pdo->prepare($sql_get_chat_data);
		//$get_chat_data->bindParam('from_user_id',$from_user_id);
		//$get_chat_data->bindParam('to_user_id',$to_user_id);
		$get_chat_data->execute();
		
		
		$sql_get_to_user="select * from userprofiles where userid=$to_user_id";
		$get_to_user = $conn_pdo->prepare($sql_get_to_user);
		$get_to_user->execute();
		$row_get_to_user=$get_to_user->fetch();
		
		$chat_response='';
		if($last_id==0)
		{
		
		$chat_response='<div class="card card-custom border">';
		$chat_response.='<input type="hidden" name="to_user_id_for_chat" id="to_user_id_for_chat" value="'.$to_user_id.'"/>
		<input type="hidden" name="to_profile_image_for_chat" id="to_profile_image_for_chat" value="'.$row_get_to_user['profileimage'].'"/>
		<input type="hidden" name="to_user_name_for_chat" id="to_user_name_for_chat" value="'.$row_get_to_user['fullname'].'"/>';
															$chat_response.='<div class="px-4 py-3">
																<span class="d-flex align-items-center">
																	<span class="font-size-h5 font-weight-bolder mr-2">Chat</span><i class="fas fa-comments icon-md text-info d-block mr-2"></i>
																</span>
																<hr class="m-0">
															</div>
															<div class="card-body p-2">
																<div class="scroll scroll-pull ps ps--active-y mr-0 pr-0 chat-wrap" data-scroll="true" data-mobile-height="350" id="message_area_div">
																	<div class="messages" id="message_area">';
		}
																	
			if ($get_chat_data->rowCount() > 0) 
			{
            
				$row_get_chat_data=$get_chat_data->fetchAll();
				foreach($row_get_chat_data as $data_get_chat_data)
				{
																		$chat_message_id=$data_get_chat_data['chat_message_id'];
																		$to_user_id_chat=$data_get_chat_data['to_user_id'];
																		$from_user_id_chat=$data_get_chat_data['from_user_id'];
																		$chat_message=$data_get_chat_data['chat_message'];
																		$timestamp=$data_get_chat_data['timestamp'];
																		$status=$data_get_chat_data['msg_status'];
																		
																		$fullname=$data_get_chat_data['fullname'];
																		
																		$from_profile_image=$data_get_chat_data['from_profile_image'];
																		
																		$to_profile_image=$data_get_chat_data['to_profile_image'];
																		
																		$to_user_name=$data_get_chat_data['to_user_name'];
																		
																		$from_user_name=$data_get_chat_data['from_user_name'];
																		
																		$chat_message_id=$data_get_chat_data['chat_message_id'];
																		$chat_response.='<input type="hidden" class="get_max_chat_id" value="'.$chat_message_id.'"/>';
				if($from_user_id_chat==$from_user_id)
					{
						$chat_response.='<div class="d-flex flex-column mb-5 align-items-end">
																			<div class="d-flex align-items-center">
																				<div>
																					<span class="text-muted font-size-sm">'.$timestamp.'</span>
																					<a href="#" class="text-dark-75 text-hover-primary font-weight-bold font-size-md">You</a>
																				</div>
																				<div class="symbol symbol-circle symbol-40 ml-3">
																					<img alt="Pic" src="profile_pictures/'.$from_profile_image.'">
																				</div>
																			</div>
																			<div class="mt-2 rounded p-5 bg-light-primary text-dark-50 font-weight-bold font-size-sm text-right max-w-400px">'.$chat_message.'</div>
																		</div>';
				}
			else{
					$chat_response.='<div class="d-flex flex-column mb-5 align-items-start">
																			<div class="d-flex align-items-center">
																				<div class="symbol symbol-circle symbol-40 mr-3">
																					<img alt="Pic" src="profile_pictures/'.$from_profile_image.'">
																				</div>
																				<div>
																					<a href="#" class="text-dark-75 text-hover-primary font-weight-bold font-size-md">'.$from_user_name.'</a>
																					<span class="text-muted font-size-sm">'.$timestamp.'</span>
																				</div>
																			</div>
																			<div class="mt-2 rounded p-5 bg-light-success text-dark-50 font-weight-bold font-size-sm text-left max-w-400px">'.$chat_message.'</div>
																		</div>';
				}
			}
		}																	
		if($last_id==0)
		{
			$chat_response.='</div>
																		<div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; height: 17px; right: -2px;"><div class="ps__thumb-y" tabindex="0" style="top: -23px; height: 40px;"></div></div>
																		</div>
																	</div>
																	<form id="chat_form" method="POST">
																	<div class="card-footer align-items-center">
																		<textarea class="form-control border-0 p-0" rows="1" name="chat_message" id="chat_message" placeholder="Write here.."></textarea>
																		<div class="d-flex align-items-center justify-content-between">
																			<div class="mr-3">
																				<!--a href="#" class="btn btn-clean btn-icon btn-md mr-1">
																					<i class="flaticon2-photograph icon-lg"></i>
																				</a>
																				<a href="#" class="btn btn-clean btn-icon btn-md">
																					<i class="flaticon2-photo-camera icon-lg"></i>
																				</a-->
																			</div>
																			<div>
																				<button type="submit" class="btn btn-info btn-md text-uppercase font-weight-bold chat-send py-2 px-6">Send</button>
																			</div>
																		</div>
																	</div>
																	</form>
																	
																	<script>
																	$("#message_area_div").scroll(function(){
			     
						//alert(1);
			
		//if($("#message_area_div").scrollTop() + $("#message_area_div").height() > $("#message_area").height())
		if( $("#message_area_div").scrollTop() ==0 )
		{
			//alert($("#message_area_div").height());
			//alert($("#message_area_div").scrollTop());
			//alert($("#message_area").height());
			var inputs = $(".get_max_chat_id");
			var arr_chat_id=[];
		
			for(var i = 0; i < inputs.length; i++){
				arr_chat_id.push($(inputs[i]).val());
			}	

			//alert(arr_chat_id);

			var max_chat_id = Math.min.apply(Math,arr_chat_id);

			//alert('.$last_id.');
			//alert(max_chat_id);
			if(max_chat_id != '.$last_id.' ){
				setTimeout(function(){
					//getExistingData(0,limit, start);
				get_chat_area('.$to_user_id.',"",max_chat_id);
					//alert(max_chat_id);
				}, 1000);
				
				}
				}
				});
			</script>';
		}
		echo $chat_response;	
	}
		
	if($_POST['key']=='save_chat')
	{
		
		$user_id=$_POST['user_id'];
		$msg=$_POST['msg'];
		$receiver_userid=$_POST['receiver_userid'];
		$datetime=$_POST['datetime'];
		$status = 'Yes';
	
	
		$query="insert into chat_message (to_user_id,from_user_id,chat_message,timestamp,status) 
		values ($receiver_userid,$user_id,'$msg',now(),'$status')";
		echo $query;
		$statement = $conn_pdo->prepare($query);
		
		/*$statement->bindParam(':to_user_id',$receiver_userid);
		
		$statement->bindParam(':from_user_id',$user_id);
		
		$statement->bindParam(':chat_message',$msg);
		
		$statement->bindParam(':timestamp',$datetime);
		
		$statement->bindParam(':status',$status);*/
		
		$statement->execute();
		echo $conn_pdo->lastInsertId();
	}
	/*end new code*/
	
	
	}