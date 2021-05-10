<?php //include 'index.php';
session_start();

if(!isset($_SESSION['user_data']))
{
	header('location:index.php');
}
// new code
include_once("cl_config/conn.php");

require('database/ChatUser.php');

require('database/ChatRooms.php');
// old code

date_default_timezone_set('Asia/Kolkata');
?>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--base href="../../"-->
    
    <title>Online Campuslife</title>
    <meta name="description" content="Aside light theme example" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="canonical" href="https://onlinecampuslife.com"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <link href="public/assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
    <link href="public/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="public/assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
    <link href="public/assets/css/perfect-scrollbar.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="public/assets/css/custom.css">
    <link rel="stylesheet" href="public/assets/media/logos/favicon-new.ico" />
    <link rel="stylesheet" href="public/plugins/custom/jquery-ui/jquery-ui.min.css" />
   <link rel="stylesheet" type="text/css" href="public/app-assets/css/components.css">
    <link rel="stylesheet" type="text/css" href="public/app-assets/fonts/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="public/app-assets/fonts/feather/style.min.css">
	
	<link rel="stylesheet" type="text/css" href="cl_css/clix_logic.css">

    <script src="public/assets/plugins/global/plugins.bundle.js"></script>
    <script src="public/assets/js/scripts.bundle.min.js"></script>
    <script src="public/assets/js/perfect-scrollbar.js"></script>
    <!-- common js -->
    <script src="public/app-assets/vendors/js/extensions/moment.min.js"></script>
    <script src="public/plugins/custom/jquery-ui/jquery-ui.min.js"></script>
   <script src="public/assets/js/typeahead.bundle.min.js"></script>
   <script src="js/plugin/jquery-validate/jquery.validate.min.js"></script>
   <script src="js/plugin/jquery-form/jquery-form.min.js"></script>
<script src="https://vadimsva.github.io/waitMe/waitMe.min.js"></script>
</head>
<style type="text/css">
	.attachments .nav-link span {
		width: 40px;
		overflow: hidden;
		white-space: nowrap;
		text-overflow: ellipsis;
	}

	.scroll.ps>.ps__rail-y>.ps__thumb-y:hover,
	.scroll.ps>.ps__rail-y>.ps__thumb-y:focus {
		background: #8950FC !important;
	}

	.scroll.ps>.ps__rail-y>.ps__thumb-y {
		background: #8950FC !important;
	}
	.twitter-typeahead,
	.typeahead{
		width: 100% !important;
		border: 1px solid #E4E6EF !important;
		height: calc(1.5em + 1.3rem + 2px) !important;
	}
	
	
	
	
	
</style>

<div class="card card-custom">
	<div class="row">
		<div class="col-md-4" id="tt-left">
			<div class="card card-custom pt-4">
				<div class="d-flex align-items-center justify-content-between px-4">
					<div class="btn-group dropleft d-flex">
						<button class="btn btn-info btn-lg font-weight-bolder dropdown-toggle-split dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<span class="sr-only">Toggle Dropdown</span><img src="public/app-assets/images/icons/collaboration.png" class="d-lg-none d-md-none d-block">
						</button>
						<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
							<a class="dropdown-item px-1 d-flex align-items-center py-1" href="javascript:void(0)" data-toggle="modal"><img src="public/app-assets/images/icons/icons8-external-link-64.png" style="width:25px;"> <span class="font-size-sm font-weight-bold text-info">&nbsp; Lorem </span></a>
							<a class="dropdown-item px-1 d-flex align-items-center py-1" href="javascript:void(0)"><img src="public/app-assets/images/icons/icons8-upload-64.png" style="width:25px;"> <span class="font-size-sm font-weight-bold text-info">&nbsp; Lorem </span></a>
							<a class="dropdown-item px-1 d-flex align-items-center py-1" href="javascript:void(0)"><img src="public/app-assets/images/icons/icons8-link-64.png" style="width:25px;"> <span class="font-size-sm font-weight-bold text-info">&nbsp; Lorem </span></a>
						</div>
						<button type="button" class="btn btn-info d-lg-block d-md-block d-none" data-toggle="dropdown">Action Deck</button>
					</div>
					<a href="#" class="btn btn-info font-weight-bolder px-5" data-toggle="modal" data-target="#invite_friend">Invite New Friends</a>
				</div>
				<div class="d-flex align-items-center px-2">
					<div class="py-2">
						<nav>
							<div class="nav nav-tabs friend-tab" id="nav-tab" role="tablist">
								<a class="nav-item nav-link active" id="friends-tab" data-toggle="tab" href="#friends" role="tab" aria-controls="nav-docs" aria-selected="false">Friends</a>
								<a class="nav-item nav-link" id="inviteto-tab" data-toggle="tab" href="#inviteto" role="tab" aria-controls="nav-docs" aria-selected="false">Invites Sent<span class="font-size-xs" id="count_invite_sent">(10)</span></a>
								<a class="nav-item nav-link" id="invitefrom-tab" data-toggle="tab" href="#invitefrom" role="tab" aria-controls="nav-docs" aria-selected="false">Invites Received <span class="font-size-xs" id="count_invite_received">(10)</span></a>
							</div>
						</nav> 
					</div>
				</div>
				<div class="tab-content" id="tabContent">
					<div class="tab-pane active" id="friends" role="tabpanel" aria-labelledby="friends-tab">
						<div class="card-header d-flex align-items-center py-4">
							<!-- search_toggle -->
							<div class="dropdown w-100" id="kt_quick_search_toggle">
								<div class="dropdown-menu p-0 m-0 dropdown-menu-right dropdown-menu-anim-up search-friend w-100 dropdown-menu-md">
									<div class="quick-search quick-search-dropdown" id="kt_quick_search_dropdown">
										<form method="get" class="quick-search-form w-100 m-0" action="javascript:void(0)">
											<div class="input-group">
												<input type="text" id="search_keyword" class="form-control" onkeyup="search_friend_from_friend_list(this.value)" placeholder="Search friend">
												<div class="input-group-append" style="cursor: pointer;" id="search_icon">
													<span class="input-group-text" >
														<span class="svg-icon svg-icon-lg">
															<svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
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
							
							
							<?php
							//start new code
		/*$login_user_id="";
		$token='';
		foreach($_SESSION['user_data'] as $key => $value){*/
			
			$login_user_id = $_SESSION['userid'];
			
			$token = $value['token'];
			?>
			<input type="hidden" name="login_user_id" id="login_user_id" value="<?=$login_user_id?>"/>
			
			<input type="hidden" name="is_active_chat" id="is_active_chat" value="No"/>
			
			<?php
		//}
		//end new code
		?>
						</div>
						<div class="scroll scroll-pull ps mr-0 pr-0 common-digital-lhs lhs-wrapper" data-scroll="true" style="height: 500px; overflow: hidden;">
							<ul class="nav flex-column nav-pills question-lhs doc-lhs" id="friend_list">
								<!-- Friend list will appear here  -->
								<!-- End Friend list will appear here  -->
							</ul>
							<div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; right: -2px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div></div>
							</div>
						</div>
						
						<!-- requested friend will appear here -->
						<div class="tab-pane" id="inviteto" role="tabpanel" aria-labelledby="inviteto-tab">
							<div class="scroll scroll-pull ps mr-0 pr-0 common-digital-lhs lhs-wrapper" data-scroll="true" style="height: 500px; overflow: hidden;">
								<ul class="nav flex-column nav-pills question-lhs doc-lhs" id="invited_friend_list">
									
									
									
								</ul>
								<div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; right: -2px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div></div>
								</div>
							</div>
							
							
							<!-- requested friend will appear here -->
							
							
							<div class="tab-pane" id="invitefrom" role="tabpanel" aria-labelledby="invitefrom-tab">
								<div class="scroll scroll-pull ps mr-0 pr-0 common-digital-lhs lhs-wrapper" data-scroll="true" style="height: 500px; overflow: hidden;">
									<ul class="nav flex-column nav-pills question-lhs doc-lhs" id="received_friend_request_list">
										<!-- Friend request from other will appear here -->
									</ul>
									<div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; right: -2px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div></div></div>
								</div>
							</div>
						</div>
					</div>
					<!-- RHS -->
					<div class="col-md-8" id="tt-right">
						<div class="card card-custom">
							<div class="card-body p-0">
								<div class="tab-content" id="post-tabcontent">
									<div class="tab-pane show active" role="tabpanel" aria-labelledby="friend-one-tab" id="friend-one">
										<div class="card-header p-2 header-card">
											<div class="row px-2">
												<div class="col-lg-2 px-lg-1 d-flex align-items-center justify-content-center">
													<div class="symbol symbol-100 symbol-circle">
														<img id="friend_profile_image" src="" class="img-fluid">
													</div>
												</div>
												<div class="col-lg-6">
												<input type="hidden" name="friend_id_for_wall" id="friend_id_for_wall" value=""/>
													<h4 class="font-weight-bolder my-2 font-size-md text-center" id="friend_fullname"></h4>
													<div class="mb-1 d-flex justify-content-between">
														<span class="font-weight-bolder">Email:</span>
														<a href="#" class="text-hover-info text-dark font-weight-bolder text-right" id="friend_email"></a>
													</div>
													<div class="mb-1 d-flex justify-content-between">
														<span class="font-weight-bolder">Phone:</span>
														<a href="#" class="text-hover-info text-dark font-weight-bolder text-right" id="friend_phonenumber"></a>
													</div>
													<div class="mb-1 d-flex justify-content-between">
														<span class="font-weight-bolder">Location:</span>
														<a href="#" class="text-hover-info text-dark font-weight-bolder text-right" id="friend_location"></a>
													</div>
													<div class="d-flex">
														<span class="font-weight-bold mr-5" id="friend_school_college">School / collage Name</span>
														<span class="font-weight-bold" id="friend_term_year">Term / Year</span>
													</div>
												</div>
												<div class="col-lg-4">
													<span class="text-right my-2 d-block">
														<i class="fas fa-cog icon-md text-info d-block"></i>
													</span>
													<span class="font-weight-bolder text-center d-block mb-2">Common Friends</span>
													<div class="card-toolbar ml-lg-0 ml-md-1 ml-2">
														<div class="dropdown dropdown-inline w-100">
															<button type="button" class="d-block w-100 border-0 bg-white" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">	<div class="symbol-group symbol-hover d-flex justify-content-center">
														<div class="symbol symbol-30 symbol-circle" data-toggle="tooltip" title="Profile Name" data-original-title="">
															<img alt="Pic" src="public/app-assets/images/icons/group.jpg">
														</div>
														<div class="symbol symbol-30 symbol-circle" data-toggle="tooltip" title="Profile Name" data-original-title="">
															<img alt="Pic" src="public/app-assets/images/icons/group1.jpg">
														</div>
														<div class="symbol symbol-30 symbol-circle" data-toggle="tooltip" title="Profile Name" data-original-title="">
															<img alt="Pic" src="public/app-assets/images/icons/group2.jpg">
														</div>
														<div class="symbol symbol-30 symbol-circle" data-toggle="tooltip" title="Profile Name" data-original-title="">
															<img alt="Pic" src="public/app-assets/images/icons/group3.jpg">
														</div>
														<div class="symbol symbol-30 symbol-circle symbol-light">
															<span class="symbol-label font-weight-bold">5+</span>
														</div>
													</div>
															</button>
															<div class="dropdown-menu dropdown-menu-sm dropdown-menu-left p-2" x-placement="bottom-end">
																<ul class="nav nav-pills">
																	<li class="nav-item mb-2">
																		<div class="d-flex align-items-center w-100">
																			<div class="symbol symbol-60 symbol-circle symbol-xl-30 mr-3">
																				<img class="img-fluid" src="public/app-assets/images/icons/group.jpg" alt="">
																			</div>
																			<div class="w-100">
																				<div class="d-flex align-items-center justify-content-between w-100">
																					<span class="font-weight-bolder text-info font-size-md d-block" title="">Mark Stone</span>
																				</div>
																			</div>
																		</div>
																	</li>
																	<li class="nav-item mb-2">
																		<div class="d-flex align-items-center w-100">
																			<div class="symbol symbol-60 symbol-circle symbol-xl-30 mr-3">
																				<img class="img-fluid" src="public/app-assets/images/icons/group1.jpg" alt="">
																			</div>
																			<div class="w-100">
																				<div class="d-flex align-items-center justify-content-between w-100">
																					<span class="font-weight-bolder text-info font-size-md d-block" title="">Charlie Stone</span>
																				</div>
																			</div>
																		</div>
																	</li>
																	<li class="nav-item mb-2">
																		<div class="d-flex align-items-center w-100">
																			<div class="symbol symbol-60 symbol-circle symbol-xl-30 mr-3">
																				<img class="img-fluid" src="public/app-assets/images/icons/group2.jpg" alt="">
																			</div>
																			<div class="w-100">
																				<div class="d-flex align-items-center justify-content-between w-100">
																					<span class="font-weight-bolder text-info font-size-md d-block" title="">Luca Doncic</span>
																				</div>
																			</div>
																		</div>
																	</li>
																	<li class="nav-item mb-2">
																		<div class="d-flex align-items-center w-100">
																			<div class="symbol symbol-60 symbol-circle symbol-xl-30 mr-3">
																				<img class="img-fluid" src="public/app-assets/images/icons/group3.jpg" alt="">
																			</div>
																			<div class="w-100">
																				<div class="d-flex align-items-center justify-content-between w-100">
																					<span class="font-weight-bolder text-info font-size-md d-block" title="">Nick Mana</span>
																				</div>
																			</div>
																		</div>
																	</li>
																	<li class="nav-item mb-2">
																		<div class="d-flex align-items-center w-100">
																			<div class="symbol symbol-60 symbol-circle symbol-xl-30 mr-3">
																				<img class="img-fluid" src="public/app-assets/images/icons/group4.jpg" alt="">
																			</div>
																			<div class="w-100">
																				<div class="d-flex align-items-center justify-content-between w-100">
																					<span class="font-weight-bolder text-info font-size-md d-block" title="">Teresa Fox</span>
																				</div>
																			</div>
																		</div>
																	</li>
																</ul>
															</div>
														</div>
													</div>
												
												</div>
											</div>
										</div>
										<div class="card-body p-2">
											<div class="tab-content" id="post-tabcontent">
												<div class="tab-pane show active" role="tabpanel" aria-labelledby="friend-one-tab" id="friend-one">
													<div class="row">
														<div class="col-lg-8">
															<!-- <nav>
																<div class="nav nav-tabs friend-tab" id="nav-tab" role="tablist">
																	<a class="nav-item nav-link active" id="time-line-tab" data-toggle="tab" href="#time-line" role="tab" aria-controls="" aria-selected="false">Time Line</a>
																	<a class="nav-item nav-link" id="shared-resources-tab" data-toggle="tab" href="#shared-resources" role="tab" aria-controls="" aria-selected="false">Shared digital resources</a>
																	<a class="nav-item nav-link" id="shared-Objects-tab" data-toggle="tab" href="#shared-Objects" role="tab" aria-controls="" aria-selected="false">Shared academic objects</a>
																</div>
															</nav> 
															<hr class="m-0"> -->
															<div class="tab-content" id="post-tabcontent1">
												<div class="tab-pane show active" role="tabpanel" aria-labelledby="time-line-tab" id="time-line">
															<div class="card-header p-4">
																<div class="row">
																	<div class="col-lg-2 col-md-4 col-2 d-flex justify-content-center">
																		<div class="symbol symbol-60 symbol-circle symbol-xl-50">
																			<img class="img-fluid" src="profile_pictures/<?=$_SESSION['profileimage']?>" id="user_profile_picture" alt="">
																		</div>
																</div>
																<div class="col-lg-10 col-md-8 col-10">
																	<!-- search_toggle -->
									<div class="dropdown w-100" id="kt_quick_search_toggle">
										<div class="dropdown-menu p-0 m-0 dropdown-menu-right dropdown-menu-anim-up search-friend w-100 dropdown-menu-md">
											<div class="quick-search quick-search-dropdown" id="kt_quick_search_dropdown">
												<form method="get" class="quick-search-form w-100 m-0" action="javascript:void(0)">
													<div class="input-group">
													
													<span class="form-control" data-toggle="modal" data-target="#text_post">What is in the mind ! <?=$_SESSION['fullname']?></span>
														<div class="input-group-append" style="cursor: pointer;" id="search_icon">
															<span class="input-group-text">
															<span class="svg-icon svg-icon-md"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-02-01-052524/theme/html/demo1/dist/../src/media/svg/icons/Communication/Write.svg--><svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <rect x="0" y="0" width="24" height="24"/>
        <path d="M12.2674799,18.2323597 L12.0084872,5.45852451 C12.0004303,5.06114792 12.1504154,4.6768183 12.4255037,4.38993949 L15.0030167,1.70195304 L17.5910752,4.40093695 C17.8599071,4.6812911 18.0095067,5.05499603 18.0083938,5.44341307 L17.9718262,18.2062508 C17.9694575,19.0329966 17.2985816,19.701953 16.4718324,19.701953 L13.7671717,19.701953 C12.9505952,19.701953 12.2840328,19.0487684 12.2674799,18.2323597 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.701953, 10.701953) rotate(-135.000000) translate(-14.701953, -10.701953) "/>
        <path d="M12.9,2 C13.4522847,2 13.9,2.44771525 13.9,3 C13.9,3.55228475 13.4522847,4 12.9,4 L6,4 C4.8954305,4 4,4.8954305 4,6 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,13 C20,12.4477153 20.4477153,12 21,12 C21.5522847,12 22,12.4477153 22,13 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,6 C2,3.790861 3.790861,2 6,2 L12.9,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
    </g>
</svg><!--end::Svg Icon--></span>
															</span>
															</div>
															</div>
												</form>
		<div class="quick-search-wrapper scroll ps" data-scroll="true" data-height="325" data-mobile-height="200" style="height: 325px; overflow: hidden;"><div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div></div><div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div></div></div>
											</div>
										</div>
									</div>
									<!-- search_toggle -->
											<div class="align-items-center mt-lg-4 mt-md-2 mt-2  flex-wrap" style="display: inline-flex;">
											<a data-toggle="modal" data-target="#image_modal" id="image_modal_link" style="display:none"></a>
												<span class="d-flex align-items-center mr-lg-3 mr-md-2 mr-2" id="upload_link">
																			<i class="fas fa-camera icon-md text-info d-block mr-1"></i>Image
																		</span>
																		
																		
																		<a data-toggle="modal" data-target="#video_modal" id="video_modal_link" style="display:none"></a>
																		<span class="d-flex align-items-center mr-lg-3 mr-md-2 mr-2" id="upload_video_link">
																		
																			<i class="fas fa-video icon-md text-info d-block mr-1" ></i>Video
																		</span>
																		<span class="d-flex align-items-center mr-lg-3 mr-md-2 mr-1" data-toggle="modal" data-target="#digital_resources">
																			<img src="public/app-assets/images/icons/icons8-stack-overflow-32.png" style="width:20px;" class="mr-1">Digital Resources
																		</span>
																		<span class="d-flex align-items-center mr-lg-3 mr-md-2 mr-1" data-toggle="modal" data-target="#academic_objects">
																			<i class="fas fa-graduation-cap icon-md text-info d-block mr-1"></i>Academic Objects
																		</span>
																	</div>
																</div>
															</div>
														</div>
														<div class="post-wrapp scroll scroll-pull ps ps--active-y mr-0 pr-0" id="post_div_limit" data-scroll="true" data-mobile-height="350">
														<div id="post_div">
														<!-- single post -->
														
														<!-- single post -->
														</div>
														<div id="load_data_message"></div>
													</div> <!-- post div ends here -->
													
														</div>
															
														</div>
													</div>
													
													<!-- start chat area -->
													
													<!-- Start new code -->
													<div class="col-lg-4"  id="chat_area">
														
																</div>
																<!-- Start new code -->
															</div>
															
															<!-- start chat area End -->
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

		<!-- </div> -->
		
		<!-- Write comment reply -->
		
				<form id="comment_reply_post_form" method="post" name="comment_reply_post_form" action="">
		<div class="modal" id="comment_post_reply" tabindex="-1" role="dialog" aria-modal="true">
			<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
			
					<div class="modal-content">
						<div class="select-resource">
							<div class="modal-header bg-info white min-h-50px py-0">
								<h4 class="modal-title text-white d-block text-center w-100">Reply Comment
								</h4>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
							</div>
							<div class="modal-body p-0">
								<div class="card card-custom">
									
									<div class="card-body py-2 step-1">
										
										<div class="separator separator-solid my-2"></div>
										<div class="bs-callout-info callout-border-left p-1 resource-mini">
											<div class="card py-2 border-0">
												<nav>
												
												<div class="input-group">
												
												<input type="hidden" id="post_reply_id" name="post_reply_id"/>
												
												<input type="hidden" id="comment_reply_id" name="comment_reply_id"/>
												
													<textarea class="form-control" rows="10" name="comment_post_reply_desc" id="comment_post_reply_desc" placeholder="Reply comment ! <?=$_SESSION['fullname']?>"></textarea>
														
															</div>
													<!--div class="nav nav-tabs justify-content-between common-tabs bg-light-info" id="nav-tab" role="tablist">
														
														<input id="upload" name="upload_image" type="file" style="display:none"/>
														<input id="video_upload" type="file" style="display:none"/>
														<img id="blah" src="#" class="w-100 img-fluid" alt="your image" />

													</div-->
												</nav>
											</div>
										</div>

														</div>
													</div>
												</div>
											</div>

											<!-- selected files -->
											<div class="selected-files step-2">
												<div class="card card-custom">
													<div class="card-header d-flex justify-content-end align-items-center min-h-50px">
													<button type="submit" class="btn btn-info text-white font-weight-bolder mr-2" >Submit</button>
														<button type="button" class="btn btn-warning text-white font-weight-bolder mr-2" id="close_post_comment_reply_modal" data-dismiss="modal" aria-label="Close">Cancel</button>
														
													</div>

												</div>
											</div>
										</div>
										
										
								</div>
							</div>
						</form>
		
		<!-- End write comment reply -->
		<!-- write comment -->
		
		
		<form id="comment_post_form" method="post" name="comment_post_form" action="">
		<div class="modal" id="comment_post" tabindex="-1" role="dialog" aria-modal="true">
			<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
			
					<div class="modal-content">
						<div class="select-resource">
							<div class="modal-header bg-info white min-h-50px py-0">
								<h4 class="modal-title text-white d-block text-center w-100">Comment
								</h4>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
							</div>
							<div class="modal-body p-0">
								<div class="card card-custom">
									
									<div class="card-body py-2 step-1">
										
										<div class="separator separator-solid my-2"></div>
										<div class="bs-callout-info callout-border-left p-1 resource-mini">
											<div class="card py-2 border-0">
												<nav>
												
												<div class="input-group">
												
												<input type="hidden" id="post_id" name="post_id"/>
													<textarea class="form-control" rows="10" name="comment_post_desc" id="comment_post_desc" placeholder="Write a comment ! <?=$_SESSION['fullname']?>"></textarea>
														
															</div>
													<!--div class="nav nav-tabs justify-content-between common-tabs bg-light-info" id="nav-tab" role="tablist">
														
														<input id="upload" name="upload_image" type="file" style="display:none"/>
														<input id="video_upload" type="file" style="display:none"/>
														<img id="blah" src="#" class="w-100 img-fluid" alt="your image" />

													</div-->
												</nav>
											</div>
										</div>

														</div>
													</div>
												</div>
											</div>

											<!-- selected files -->
											<div class="selected-files step-2">
												<div class="card card-custom">
													<div class="card-header d-flex justify-content-end align-items-center min-h-50px">
													<button type="submit" class="btn btn-info text-white font-weight-bolder mr-2" >Submit</button>
														<button type="button" class="btn btn-warning text-white font-weight-bolder mr-2" id="close_post_comment_modal" data-dismiss="modal" aria-label="Close">Cancel</button>
														
													</div>

												</div>
											</div>
										</div>
										
										
								</div>
							</div>
						</form>
		
		
		
		<!-- write comment -->
		
		
		
		<!-- Text Post -->
		<form id="text_post_form" method="post" name="text_post_form" action="">
		<div class="modal" id="text_post" tabindex="-1" role="dialog" aria-modal="true">
			<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
			
					<div class="modal-content">
						<div class="select-resource">
							<div class="modal-header bg-info white min-h-50px py-0">
								<h4 class="modal-title text-white d-block text-center w-100">Create Post
								</h4>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
							</div>
							<div class="modal-body p-0">
								<div class="card card-custom">
									
									<div class="card-body py-2 step-1">
										
										<div class="separator separator-solid my-2"></div>
										<div class="bs-callout-info callout-border-left p-1 resource-mini">
											<div class="card py-2 border-0">
												<nav>
												
												<div class="input-group">
													<textarea class="form-control" rows="10" name="text_post_title" id="text_post_title" placeholder="What is in the mind ! <?=$_SESSION['fullname']?>"></textarea>
														
															</div>
													<!--div class="nav nav-tabs justify-content-between common-tabs bg-light-info" id="nav-tab" role="tablist">
														
														<input id="upload" name="upload_image" type="file" style="display:none"/>
														<input id="video_upload" type="file" style="display:none"/>
														<img id="blah" src="#" class="w-100 img-fluid" alt="your image" />

													</div-->
												</nav>
											</div>
										</div>

														</div>
													</div>
												</div>
											</div>

											<!-- selected files -->
											<div class="selected-files step-2">
											
											<div class="align-items-center mt-lg-4 mt-md-2 mt-2  flex-wrap" style="display: inline-flex;">
											<span class="d-flex align-items-center mr-lg-3 mr-md-2 mr-2" id="upload_link1">
																			<i class="fas fa-camera icon-md text-info d-block mr-1"></i>Image
											</span>
											
											<span class="d-flex align-items-center mr-lg-3 mr-md-2 mr-2" id="upload_video_link1">
																		
																			<i class="fas fa-video icon-md text-info d-block mr-1" ></i>Video
																		</span>
															</div>			
												<div class="card card-custom">
													<div class="card-header d-flex justify-content-end align-items-center min-h-50px">
													<button type="submit" class="btn btn-info text-white font-weight-bolder mr-2" >Submit</button>
														<button type="button" class="btn btn-warning text-white font-weight-bolder mr-2" id="close_text_modal" data-dismiss="modal" aria-label="Close">Cancel</button>
														
													</div>

												</div>
											</div>
										</div>
										
										
								</div>
							</div>
						</form>
						
						<!-- End Text Post -->
						
						
		<!--image modal-->
		
<form id="image_upload_form" method="post" name="image_upload_form" action="">
		<div class="modal" id="image_modal" tabindex="-1" role="dialog" aria-modal="true">
			<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
			
					<div class="modal-content">
						<div class="select-resource">
							<div class="modal-header bg-info white min-h-50px py-0">
								<h4 class="modal-title text-white d-block text-center w-100">Create Post
								</h4>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
							</div>
							<div class="modal-body p-0">
								<div class="card card-custom">
									
									<div class="card-body py-2 step-1">
										
										<div class="separator separator-solid my-2"></div>
										<div class="bs-callout-info callout-border-left p-1 resource-mini">
											<div class="card py-2 border-0">
												<nav>
												
												<div class="input-group">
													<textarea class="form-control" rows="3" name="image_post_title" id="image_post_title" placeholder="What is in the mind ! <?=$_SESSION['fullname']?>"></textarea>
														
															</div>
													<div class="nav nav-tabs justify-content-between common-tabs bg-light-info" id="nav-tab" role="tablist">
														
														<input id="upload" name="upload_image" type="file" style="display:none"/>
														<input id="video_upload" type="file" style="display:none"/>
														<img id="blah" src="#" class="w-100 img-fluid" alt="your image" />

													</div>
												</nav>
											</div>
										</div>

														</div>
													</div>
												</div>
											</div>

											<!-- selected files -->
											<div class="selected-files step-2">
											
											
											<div class="align-items-center mt-lg-4 mt-md-2 mt-2  flex-wrap" style="display: inline-flex;">
											<span class="d-flex align-items-center mr-lg-3 mr-md-2 mr-2" id="upload_link2">
																			<i class="fas fa-camera icon-md text-info d-block mr-1"></i>Image
											</span>
											
											<span class="d-flex align-items-center mr-lg-3 mr-md-2 mr-2" id="upload_video_link2">
																		
																			<i class="fas fa-video icon-md text-info d-block mr-1" ></i>Video
																		</span>
															</div>
											
											
												<div class="card card-custom">
													<div class="card-header d-flex justify-content-end align-items-center min-h-50px">
													<button type="submit" class="btn btn-info text-white font-weight-bolder mr-2" >Submit</button>
														<button type="button" class="btn btn-warning text-white font-weight-bolder mr-2" id="close_image_modal" data-dismiss="modal" aria-label="Close">Cancel</button>
														
													</div>

												</div>
											</div>
										</div>
										
										
								</div>
							</div>
						</form>	
							
		<!-- image modal -->
		
		
		<!--video modal-->
		<form id="video_upload_form" method="post" name="image_upload_form" action="">
		<div class="modal" id="video_modal" tabindex="-1" role="dialog" aria-modal="true">
			<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="select-resource">
							<div class="modal-header bg-info white min-h-50px py-0">
								<h4 class="modal-title text-white d-block text-center w-100">Create Post
								</h4>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
							</div>
							<div class="modal-body p-0">
								<div class="card card-custom">
									
									<div class="card-body py-2 step-1">
										
										<div class="separator separator-solid my-2"></div>
										<div class="bs-callout-info callout-border-left p-1 resource-mini">
											<div class="card py-2 border-0">
												<nav>
												
												<div class="input-group">
													<textarea class="form-control" rows="3" name="video_post_title" placeholder="What is in the mind ! <?=$_SESSION['fullname']?>"></textarea>
														
															</div>
													<div class="nav nav-tabs justify-content-between common-tabs bg-light-info" id="nav-tab" role="tablist">
														
														<input type="file" accepts="video/*" name="upload_video" id="upload_video" style="display:none">
														
														<div id="show_video" ></div>
														

													</div>
												</nav>
											</div>
										</div>

														</div>
													</div>
												</div>
											</div>

											<!-- selected files -->
											<div class="selected-files step-2">
											
											<div class="align-items-center mt-lg-4 mt-md-2 mt-2  flex-wrap" style="display: inline-flex;">
											<span class="d-flex align-items-center mr-lg-3 mr-md-2 mr-2" id="upload_link3">
																			<i class="fas fa-camera icon-md text-info d-block mr-1"></i>Image
											</span>
											
											<span class="d-flex align-items-center mr-lg-3 mr-md-2 mr-2" id="upload_video_link3">
																		
																			<i class="fas fa-video icon-md text-info d-block mr-1" ></i>Video
																		</span>
															</div>
											
												<div class="card card-custom">
													<div class="card-header d-flex justify-content-end align-items-center min-h-50px">
													<button type="submit" class="btn btn-info text-white font-weight-bolder mr-2" >Submit</button>
														<button type="button" class="btn btn-warning text-white font-weight-bolder mr-2" id="close_video_modal" data-dismiss="modal" aria-label="Close">Cancel</button>
														
													</div>

												</div>
											</div>
										</div>
								</div>
							</div>
							</form>
		<!-- video modal -->

		<!-- digital resource popup -->
		<div class="modal" id="digital_resources" tabindex="-1" role="dialog" aria-modal="true">
			<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="select-resource">
							<div class="modal-header bg-info white min-h-50px py-0">
								<h4 class="modal-title text-white d-block text-center w-100">Share Digital Resources
								</h4>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
							</div>
							<div class="modal-body p-0">
								<div class="card card-custom">
									<div class="card-header d-flex align-items-center min-h-50px py-0">
										<div class="d-flex align-items-center">
											<span id="subtitle" class="text-info font-size-h5 font-weight-bolder">Select digital resources</span>
										</div>
									</div>
									<div class="card-body py-2 step-1">
										<div class="row align-items-center">
											<div class="col-lg-6 col-md-6 col-5">
												<div class="d-flex align-items-center justify-content-between">
													<span class="font-weight-bolder">Digital Resource Library</span>
												</div>
											</div>
											<div class="col-lg-6 col-md-6 col-7 text-right">
												<button type="button" class="btn btn-warning text-white font-weight-bolder mr-5" data-dismiss="modal">Cancel</button>
												<button type="button" class="btn btn-info text-white font-weight-bolder allocatebtn">Next</button>

											</div>
										</div>
										<div class="separator separator-solid my-2"></div>
										<div class="bs-callout-info callout-border-left p-1 resource-mini">
											<div class="card py-2 border-0">
												<nav>
													<div class="nav nav-tabs justify-content-between common-tabs bg-light-info" id="nav-tab" role="tablist">
														<a class="nav-item nav-link p-0 flex-column active" id="nav-docs-tab" data-toggle="tab" href="#znav-docs" role="tab" aria-controls="nav-docs" aria-selected="true">
															<div class="fonticon-wrap mb-2">
																<img src="publicapp-assets/images/icons/icons8-document-64.png" class="w-10" style="width: 50px;">
															</div>
															<label class="fonticon-classname m-0 font-size-sm">Docs
																<span class="font-weight-bolder font-size-xs" id="doc_count">
																	(0)
																</span>
															</label>
														</a>
														<a class="nav-item nav-link p-0 flex-column" id="nav-videos-tab" data-toggle="tab" href="#znav-videos" role="tab" aria-controls="nav-videos" aria-selected="true">
															<div class="fonticon-wrap mb-1">
																<img src="publicapp-assets/images/icons/icons8-video-64.png" style="width: 50px;">
															</div>
															<label class="fonticon-classname m-0">Video
																<span class="font-weight-bolder font-size-sm" id="video_count">
																	(0)
																</span>
															</label>
														</a>
														<a class="nav-item nav-link p-0 flex-column" id="nav-images-tab" data-toggle="tab" href="#znav-images" role="tab" aria-controls="nav-images" aria-selected="false">
															<div class="fonticon-wrap mb-1">
																<img src="publicapp-assets/images/icons/icons8-image-file-64.png" style="width: 50px;">
															</div>
															<label class="fonticon-classname m-0">Images
																<span class="font-weight-bolder font-size-sm" id="img_count">
																	(0)
																</span>
															</label>
														</a>
														<a class="nav-item nav-link p-0 flex-column" id="nav-urls-tab" data-toggle="tab" href="#znav-urls" role="tab" aria-controls="nav-urls" aria-selected="true">
															<div class="fonticon-wrap mb-2">
																<img src="publicapp-assets/images/icons/external-link-64.png" style="width: 50px;">
															</div>
															<label class="fonticon-classname m-0">Web-Link
																<span class="font-weight-bolder font-size-sm" id="web_count">
																	(0)
																</span>
															</label>
														</a>

														<a class="nav-item nav-link p-0 flex-column" id="nav-question-tab" data-toggle="tab" href="#znav-question" role="tab" aria-controls="nav-question" aria-selected="true">
															<div class="fonticon-wrap mb-2">
																<img src="publicapp-assets/images/icons/icons8-qna-64.png" style="width: 50px;">
															</div>
															<label class="fonticon-classname m-0">Q &amp; A
																<span class="font-weight-bolder font-size-sm" id="qa_count">
																	(0)
																</span>
															</label>
														</a>
														<a class="nav-item nav-link p-0 flex-column" id="nav-notes-tab" data-toggle="tab" href="#znav-notes" role="tab" aria-controls="nav-notes" aria-selected="true">
															<div class="fonticon-wrap mb-2">
																<img src="publicapp-assets/images/icons/icons8-note-64.png" style="width: 50px;">
															</div>
															<label class="fonticon-classname m-0">Notes
																<span class="font-weight-bolder font-size-sm" id="note_count">
																	(0)
																</span>
															</label>
														</a>
														<a class="nav-item nav-link p-0 flex-column" id="nav-others-tab" data-toggle="tab" href="#znav-others" role="tab" aria-controls="nav-others" aria-selected="true">
															<div class="fonticon-wrap mb-2">
																<img src="publicapp-assets/images/icons/icons8-document-64.png" class="w-10" style="width: 50px;">
															</div>
															<label class="fonticon-classname m-0">Other
																<span class="font-weight-bolder font-size-sm" id="other_count">
																	(0)
																</span>
															</label>
														</a>
													</div>
												</nav>
											</div>
										</div>
										<div class="tab-content p-5" id="nav-tabContent">
											<div class="tab-pane fade" id="znav-images" role="tabpanel" aria-labelledby="nav-images-tab">
												<div class="scroll scroll-pull ps ps--active-y" data-scroll="true" data-wheel-propagation="true" style="height: 100px; overflow: hidden;">                                        </div>
												</div>

												<div class="tab-pane fade" id="znav-videos" role="tabpanel" aria-labelledby="nav-videos-tab">
													<div class="scroll scroll-pull ps ps--active-y" data-scroll="true" data-wheel-propagation="true" style="height: 100px; overflow: hidden;">
													</div>
													</div>

													<div class="tab-pane fade" id="znav-question" role="tabpanel" aria-labelledby="nav-question-tab">
														<div class="scroll scroll-pull ps ps--active-y" data-scroll="true" data-wheel-propagation="true" style="height: 100px; overflow: hidden;">                                        </div>
														</div>

														<div class="tab-pane fade" id="znav-notes" role="tabpanel" aria-labelledby="nav-notes-tab">
														<div class="scroll scroll-pull ps ps--active-y" data-scroll="true" data-wheel-propagation="true" style="height: 100px; overflow: hidden;">     
														</div>
															</div>

															<div class="tab-pane fade" id="znav-others" role="tabpanel" aria-labelledby="nav-others-tab">
																<div class="scroll scroll-pull ps ps--active-y" data-scroll="true" data-wheel-propagation="true" style="height: 100px; overflow: hidden;">
																	<h1 class="font-weight-bolder font-size-h6" id="other_title"></h1>
																	</div>   
																</div>

																<div class="tab-pane fade active show" id="znav-docs" role="tabpanel" aria-labelledby="nav-docs-tab">
																	<div class="scroll scroll-pull ps ps--active-y" data-scroll="true" data-wheel-propagation="true" style="height: 100px; overflow: hidden;">
																		<h1 class="font-weight-bolder font-size-h6" id="doc_title"></h1>
																	</div>
																</div>

																<div class="tab-pane fade" id="znav-urls" role="tabpanel" aria-labelledby="nav-urls-tab">
																	<div class="scroll scroll-pull ps ps--active-y" data-scroll="true" data-wheel-propagation="true" style="height: 100px; overflow: hidden;">
																		<h1 class="font-weight-bolder font-size-h6" id="web_title"></h1>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>

											<!-- selected files -->
											<div class="selected-files step-2">
												<div class="card card-custom">
													<div class="card-header d-flex justify-content-end align-items-center min-h-50px">
														<button type="button" class="btn btn-warning text-white font-weight-bolder mr-2" >Prev</button>
														<button type="button" class="btn btn-info text-white font-weight-bolder mr-2" >Finish</button>
													</div>
													<div class="card-body p-0">
														<div class="attachments">
															<ul id="SelectedItems" class="nav nav-active-bordered-pill">
																<li class="nav-item"><a class="nav-link flex-column" href="" data-toggle="tooltip" data-placement="top" data-original-title="3943_001.pdf"><i class="fa fa-file-pdf-o fa-3x text-info" aria-hidden="true"></i><span class="text-dark mt-2">lorem</span></a></li>
															</ul>
														</div>
													</div>
												</div>
											</div>
										</div>
								</div>
							</div>


		<!-- Academic Objects popup -->
		<div class="modal" id="academic_objects" tabindex="-1" role="dialog" aria-modal="true">
			<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="select-resource">
						<div class="modal-header bg-info white min-h-50px py-0">
							<h4 class="modal-title text-white d-block text-center w-100">Share Academic Objects</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
						</div>
						<div class="modal-body p-0">
							<div class="allocate-to step-3">
								<div class="card card-custom">
									<div class="card-header d-flex align-items-center min-h-50px py-0">
										<div class="d-flex align-items-left">
											<span class="text-warning font-size-h1 font-weight-bold">To</span>
										</div>
										<div class="d-flex align-items-center">
											<div class="card-header py-2 justify-content-end d-flex border-0 min-h-40px">
												<button type="button" class="btn btn-warning text-white font-weight-bolder mr-3" data-dismiss="modal">Cancel
												</button>
												<button type="button" class="btn btn-info text-white font-weight-bolder">Save
												</button>
											</div>
										</div>
									</div>

									<div>
										<div class="card-header py-2 px-lg-7 d-flex align-items-center justify-content-between min-h-40px allocate-header">
											<div class="allocate-wrap">
												<span class="font-weight-bolder d-block d-flex align-items-center">
													<input type="checkbox" name="" value="">
													<span class="ml-2">Institute Name</span>
												</span>
											</div>
											<div class="allocate-wrap">
												<span class="font-weight-bolder d-block d-flex align-items-center">
													<input type="checkbox" name="" value="">
													<span class="ml-2">Program Name</span>
												</span>
											</div>
											<div class="allocate-wrap">
												<span class="font-weight-bolder d-block d-flex align-items-center">
													<input type="checkbox" name="" value="">
													<span class="ml-2">Academic Year</span>
												</span>
											</div>
											<div class="allocate-wrap">
												<span class="font-weight-bolder d-block d-flex align-items-center">
													<input type="checkbox" name="" value="">
													<span class="ml-2">Academic Term / session</span>
												</span>
											</div>
										</div>
										<div class="card-body p-4">
											<div class="row">
												<div class="col-xl-6 col-lg-6 col-md-5 col-12">
													<img src="public/app-assets/images/icons/popup_img/allocate_resource.png" alt="" class="img-fluid d-lg-block d-md-block d-none m-auto ">
												</div>
												<div class="col-xl-6 col-lg-6 col-md-7 col-12">
													<div class="card-body py-2 px-4 w-100">
														<div class="accordion accordion-solid accordion-toggle-plus" id="allocate-resource">
															<div class="card mb-2">
																<div class="card-header bg-info max-h-35px" id="headingOne">
																	<div class="card-title bg-info max-h-35px font-size-sm py-lg-3 py-md-3 py-1" data-toggle="collapse" data-target="#subject-collapse" aria-controls="collapse" aria-expanded="true">
																		<span class="title-name text-white">Subject</span> 
																	</div>
																</div>
																<div id="subject-collapse" class="collapse show" data-parent="#allocate-resource">
																	<div class="card-body py-0">
																		<div class="scroll scroll-pull ps ps--active-y allocate-card" data-scroll="true" style="height: 170px; overflow:auto !important;"><span class="font-weight-bolder d-block mt-3"><input type="checkbox" name="subjects[]" value="052d3049-2f19-4967-ad78-7937a7e19207"> Computer Programmiing</span>
																			<span class="font-weight-bolder d-block mt-3"><input type="checkbox" name="subjects[]" value="3eb3c1cc-e828-4761-a0bb-a140db8759a4"> CAD</span>
																			<span class="font-weight-bolder d-block mt-3"><input type="checkbox" name="subjects[]" value="7cbbbc94-9914-4822-8c61-d51456862275"> Chemical Engineering</span>
																			<span class="font-weight-bolder d-block mt-3"><input type="checkbox" name="subjects[]" value="7e0209b5-553c-43a5-87b6-fc39bca1a360"> Math</span>
																			<span class="font-weight-bolder d-block mt-3"><input type="checkbox" name="subjects[]" value="cf05bac9-d85f-4961-9caf-8c639d92610d"> Engineering Drawing</span>
																		</div>
																	</div>
																</div>
															</div>
															<div class="card mb-2">
																<div class="card-header bg-info max-h-35px" id="headingTwo">
																	<div class="card-title bg-info collapsed max-h-35px" data-toggle="collapse" data-target="#assignment-collapse" aria-expanded="false"><span class="title-name text-white"> Assignments</span>
																	</div>
																</div>
																<div id="assignment-collapse" class="collapse" data-parent="#allocate-resource">
																	<div class="card-body py-0">
																		<div class="scroll scroll-pull ps ps--active-y allocate-card" data-scroll="true" style="height: 170px; overflow:auto !important;"><span class="font-weight-bolder d-block mt-3"><input type="checkbox" name="assignments[]" value="36891527-5eac-4563-95d5-8b02d613231c"> Physics Assignment</span>
																			<span class="font-weight-bolder d-block mt-3"><input type="checkbox" name="assignments[]" value="3c429223-0179-4d9a-8f10-f3cbb64fc857"> Assignment for Engineering Drawing</span>
																			<span class="font-weight-bolder d-block mt-3"><input type="checkbox" name="assignments[]" value="41b18cd4-35f6-4b4e-88bc-2c3a2e84163e"> Math Assignment</span>
																			<span class="font-weight-bolder d-block mt-3"><input type="checkbox" name="assignments[]" value="4afdabb8-16b1-4ff9-bde3-4f595a82e171"> test-100</span>
																			<span class="font-weight-bolder d-block mt-3"><input type="checkbox" name="assignments[]" value="679cf6b1-6507-4106-b56a-d1cff3020191"> Assignment for Electricals</span>
																			<span class="font-weight-bolder d-block mt-3"><input type="checkbox" name="assignments[]" value="9602b477-c240-4157-abc4-f7810cd6a143"> demo assignment</span>
																		</div>
																	</div>
																</div>
															</div>

															<div class="card mb-2">
																<div class="card-header bg-info max-h-35px" id="headingThree">
																	<div class="card-title bg-info collapsed max-h-35px" data-toggle="collapse" data-target="#project-collapse" aria-expanded="false"> <span class="title-name text-white"> Projects</span> 
																	</div>
																</div>
																<div id="project-collapse" class="collapse" data-parent="#allocate-resource">
																	<div class="card-body py-0">
																		<div class="scroll scroll-pull ps ps--active-y allocate-card" data-scroll="true" style="height: 170px; overflow:auto !important;"><span class="font-weight-bolder d-block mt-3"><input type="checkbox" name="projects[]" value="62defa31-1964-4554-a920-cb7018303fec"> project test 2</span>
																			<span class="font-weight-bolder d-block mt-3"><input type="checkbox" name="projects[]" value="837f1274-9a2c-4a7a-ad15-0df6aefbe11f"> Sem Chem Project</span>
																			<span class="font-weight-bolder d-block mt-3"><input type="checkbox" name="projects[]" value="db1f3906-db82-42bb-aa77-a5c07e2ecc9e"> project on Chemical engineering</span>
																			<span class="font-weight-bolder d-block mt-3"><input type="checkbox" name="projects[]" value="fbd4e9b6-2ce4-4223-9ee3-d883025eb750"> Project for Sem-1 Physic</span>
																			<span class="font-weight-bolder d-block mt-3"><input type="checkbox" name="projects[]" value="ff782ba2-0c28-4a5d-969e-7571955ecde9"> Physic Project</span>
																		</div>
																	</div>
																</div>
															</div>
															<div class="card mb-2">
																<div class="card-header bg-info max-h-35px" id="headingFour">
																	<div class="card-title bg-info collapsed max-h-35px" data-toggle="collapse" data-target="#exam-collapse" aria-expanded="false"> <span class="title-name text-white">Exams </span> 
																	</div>
																</div>
																<div id="exam-collapse" class="collapse" data-parent="#allocate-resource">
																	<div class="card-body py-0">
																		<div class="scroll scroll-pull ps ps--active-y allocate-card" data-scroll="true" style="height: 170px; overflow:auto !important;">
																			<span class="font-weight-bolder d-block mt-3"><input type="checkbox" name="exams[]" value="7f4ee662-e3b0-4401-b8b9-8bdeb018ee4d"> test6678</span>
																			<span class="font-weight-bolder d-block mt-3"><input type="checkbox" name="exams[]" value="a4a50894-4f9e-44d3-84d8-404619f11350"> F.Y.B.E SAM-1 Physic Exam</span>
																			<span class="font-weight-bolder d-block mt-3"><input type="checkbox" name="exams[]" value="a9b1d5a6-50cc-427c-bfe1-4e683a6a85fe"> SAM-1  Exam</span>
																			<span class="font-weight-bolder d-block mt-3"><input type="checkbox" name="exams[]" value="d71a1800-9bce-47d4-b984-94b108d26033"> new exam123</span>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Invite Friends -->
		<div class="modal" id="invite_friend" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header bg-info white">
						<h4 class="modal-title text-white text-center d-block w-100">Invite Friends</span>
						</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
					</div>
					<div class="modal-body subject-modal py-2 px-3">
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-5 col-12">
								<label for="common-lable font-weight-bolder text-dark-75 font-size-lg">Enter Email to invite</label>
								<div class="input-group mb-2">
									<input type="text" class="form-control" placeholder="Enter Email..." id="unregistered_frient_email">
									<div class="input-group-append">
										<button class="btn btn-info" type="button" onclick="send_invitation_to_unregistered_frnd();">Invite</button>
									</div>
								</div>
								<img src="public/app-assets/images/icons/friends.png" alt="" class="img-fluid d-lg-block d-md-block d-none m-auto">
							</div>
							<div class="col-xl-6 col-lg-6 col-md-7 col-12">
								<form action="javascript:void(0)">
									<div class="modal-body p-1">
										<div class="form-body">
											<div class="row">
												<div class="col-md-12">
													<label for="common-lable font-weight-bolder text-dark-75 font-size-lg">Enter Name to search and invite</label>
													<div class="input-group mb-2">
															<input type="text" id="search_friend_sent_frnd_req" class="form-control" placeholder="Enter Name..." onkeyup="search_friend_list_to_send_invitation(this.value)">
															<div class="input-group-append">
																<button class="btn btn-info" type="button"><i class="fas fa-search text-white icon-md"></i></button>
															</div>
														</div>
													<div class="friend-list card card-custom p-2 border" id="get_searched_friend_list">
														
													</div>
												</div>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
			</div>
			<!-- End Invite Friends -->

<script type="text/javascript">





	$(document).ready(function(){
	    
	    //start new code
	    if (location.protocol !== 'http:') {
    location.replace(`http:${location.href.substring(location.protocol.length)}`);
}
//end new code


		$(".comment-div").hide();
		$("#comment").click(function () {
		$(".comment-div").show("slow");
		});
// on click class change
		$('.user-invite').click(function() {
			$(this).removeClass('fa-user-plus');
			$(this).addClass('fa-check');
		});

	});



	$(function(){
$("#upload_link,#upload_link1,#upload_link2,#upload_link3").on('click', function(e){
    e.preventDefault();
	$('#close_text_modal').click();
	$('#close_video_modal').click();
	$('#close_image_modal').click();
    $("#upload:hidden").trigger('click');
	
	//$("#video_modal_link").trigger('click');
});
});

$("#upload").change(function(){
         //submit the form here
		 readURL(this);
		 $("#image_modal_link").trigger('click');
		 
 });
 
 
 function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    
    reader.onload = function(e) {
      $('#blah').attr('src', e.target.result);
    }
    
    reader.readAsDataURL(input.files[0]); // convert to base64 string
  }
}

/*$("#imgInp").change(function() {
  
});*/


$(function(){
$("#upload_video_link,#upload_video_link1,#upload_video_link2,#upload_video_link3").on('click', function(e){
    e.preventDefault();
	$('#close_text_modal').click();
	$('#close_video_modal').click();
	$('#close_image_modal').click();
    $("#upload_video:hidden").trigger('click');
	
	//$("#video_modal_link").trigger('click');
});
});

document.querySelector("input[name=upload_video]")
  .onchange = function(event) {
    var files = event.target.files;
    for (var i = 0; i < files.length; i++) {
      var f = files[i];
      // Only process video files.
      if (!f.type.match('video.*')) {
        continue;
      }

      var source = document.createElement('video'); //added now

      //source.width = 280;

      //source.height = 240;
	  
	  source.className = "w-100 img-fluid h-100";

      source.controls = true;

      source.src = URL.createObjectURL(files[i]);

      //document.body.appendChild(source); // append `<video>` element
$('#show_video').append(source);  
$("#video_modal_link").trigger('click');
    }
  }
  
  
  function search_friend_list_to_send_invitation(searched_key)
  {
	  
	  //alert(1);
	  if(searched_key.length>2 || searched_key=='')
	  {
	  
	  $.ajax({
        url: 'cl_ajax/collaboration-ajax.php',
        method: 'POST',
        dataType: 'text',
        data: {
            key: 'get_searched_frient_list',
            searched_key : searched_key
        }, success: function (response) {
			
			
			
		$("#get_searched_friend_list").html(response);
			
        }
    });
	
  }
	  
  }
  
  
  
  function send_fried_request(friend_id)
  {
	  //alert(friend_id);
	  
	  
	  
	  
	  
	  	  $.ajax({
        url: 'cl_ajax/collaboration-ajax.php',
        method: 'POST',
        dataType: 'text',
        data: {
            key: 'send_registered_frient_request',
            req_friend_id : friend_id
        }, success: function (response) {
			
			
			
		//$("#get_searched_friend_list").html(response);
		
		$("#change_invite_link_"+friend_id).removeClass("fas fa-user-plus text-info user-invite");
		$("#change_invite_link_"+friend_id).addClass("fas text-info user-invite fa-check");
		
		if(response=='A')
		{
			alert("Friend Request Sent");
			getExistingDataFriendList();
		}
		else{
			alert("Error");
			getExistingDataFriendList();
		}
		
			
        }
    });
	  
	  
	  
  }
  
  
  
  
  
  
  
  
  
  	

    $.validator.addMethod("clix_onlyCharNumRegex", function (value, element) {
        return this.optional(element) || /^[a-z0-9.]+$/i.test(value);
    }, "login id must contain only letters, numbers, or dashes.");
	
     $.validator.addMethod("clix_onlyCharNumRegex1", function (value, element) {
        return this.optional(element) || /^[a-z\s]+$/i.test(value);
    }, "Username must contain only letters, numbers, or dashes.");
	
	$.validator.addMethod("clix_onlyCharNumRegex2", function (value, element) {
        return this.optional(element) || /^[a-z0-9]+$/i.test(value);
    }, "password must contain only letters and numbers.");
	
	
	jQuery.validator.addMethod(
    "laxEmail",
     function(value, element) {
         if (this.optional(element)) // return true on optional element 
             return true;
         var emails = value.split(/[;,]+/); // split element by , and ;
         valid = true;
         for (var i in emails) {
             value = emails[i];
             valid = valid &&
                     jQuery.validator.methods.email.call(this, $.trim(value), element);
         }
         return valid;
     },

    jQuery.validator.messages.email
);


jQuery.validator.addMethod("phone_no_limit", function(value, element) {
  // allow any non-whitespace characters as the host part
  
  if(value.toString().length==10)
  {
	  return true;
  }
  else{
	  return false;
  }
  //return this.optional( element ) || /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@(?:\S{1,63})$/.test( value );
}, 'Please enter a valid Phone Number.');

jQuery.validator.addMethod("pin_validation", function(value, element) {
  // allow any non-whitespace characters as the host part
  
  if(value.toString().length==6)
  {
	  return true;
  }
  else{
	  return false;
  }
  //return this.optional( element ) || /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@(?:\S{1,63})$/.test( value );
}, 'Please enter a valid Phone Number.');

    var errorClass = 'invalid';
    var errorElement = 'em';

//---------------------- jquery validation for v_id start

    var $orderForm = $("#image_upload_form").validate({

        framework: 'bootstrap',
        excluded: ':disabled',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        ignore: [],
        errorClass: errorClass,
        errorElement: errorElement,
        highlight: function (element) {
            $(element).parent().removeClass('state-success').addClass("state-error");
            $(element).removeClass('valid');
        },
        unhighlight: function (element) {
            $(element).parent().removeClass("state-error").addClass('state-success');
            $(element).addClass('valid');
        },
        // Rules for form validation
        rules: {
            note_task_date: {
                required: true,
                //clix_onlyCharNumRegex: true,

            },
			
			
				note_task_time:{
					required: true,
					
				},
				
				note_task_type:{
					required: true,
				},
				
				note_task_priority:{
					required: true,
				},
				
				note_detail:{
					required: true,
				},
				
				
				
				

        },


        // Messages for form validation
        messages: {
            note_task_date: {
                required: '<span style="color:red;">Please Select Date......</span>',
                //clix_onlyCharNumRegex: '<span style="color:red;">branch no. must contain only letters and numbers......</span>',
            },


			note_task_time: {
                required: '<span style="color:red;">Please Select Time......</span>',
				

            },
			note_task_type: {
                required: '<span style="color:red;">Please Write Something......</span>',

            },
			note_task_priority: {
                required: '<span style="color:red;">Please Write Something......</span>',

            },
			note_detail: {
                required: '<span style="color:red;">Please Write Something......</span>',

            }
			

        },

        // Do not change code below
        errorPlacement: function (error, element) {
            error.insertAfter(element.parent());
            //	error.insertAfter(element);
        },

        submitHandler: function (form) {

            var options = {
                //url: 'clix_modal/aj_modal_mst_branch_add_edit_edit.php',
                url: 'cl_ajax/collaboration-ajax.php',
                beforeSubmit: showRequest,  // pre-submit callback
                data: {
                    key: 'PostImage',
					friend_id_for_wall_post:$("#friend_id_for_wall").val(),
					//my_editor3:editor.getData(),
					//detail_data : CKEDITOR.instances.editor_call.getData();
                },
                error: function () {
                    alert("hi! error...  contact system admin");
                    $('.form-footer').removeClass('progress');
                },
                success: showResponse,  // post-submit callback
            };

            $('#image_upload_form').ajaxSubmit(options);

        }

    });

    function showRequest(formData, jqForm, options) {
        $('#image_upload_form').waitMe({
            effect: 'rotateplane',
            text: '',
            bg: 'rgba(255,255,255,0.7)',
            color: '#000',
            maxSize: '',
            textPos: 'vertical',
            fontSize: '',
            source: ''
        });
        return true;
    }

    function showResponse(responseText, statusText, xhr, $form) {
        $('#image_upload_form').waitMe("hide");

       // my_array_of_return_values = responseText.split('~~~');
	  // alert(responseText);
        if (responseText == 'A') {
//getExistingData();
            //------- change selected value after record added start
            //$("#user_code").append("<option value='" + my_array_of_return_values['1'] + "' selected='selected'>" + my_array_of_return_values['2'] + "</option>");
           // $("#select2-user_code-container").html('<span class="select2-selection__clear"></span>' + my_array_of_return_values['2']);
            //------- change selected value after record added end


// ---- append new row to the top
            //$('#datatable_fixed_column tbody').prepend(my_array_of_return_values["3"]);
			//alert(1);
            /*$.smallBox({
                title: "Success!",
                content: "<i class='fa fa-clock-o'></i> <i>Task Created...</i>",
                color: "#659265",
                iconSmall: "fa fa-check fa-2x fadeInRight animated",
                timeout: 1600
            });*/
        } else {

            if (responseText == 'U') {
//getExistingData();
                //var my_value = my_array_of_return_values["1"];
                // ---- insert updated row and remove old row
                //$(my_array_of_return_values["3"]).insertBefore($("input[name='v_id'][value='" + my_value + "']").parents("tr"));
                //$("input[name='v_id'][value='" + my_value + "'][clixdelnext='next']").closest("tr").next("tr").remove();
                //  $(selector).removeAttr(attribute)
                //$("input[name='v_id'][value='" + my_value + "'][clixdelnext='next']").removeAttr(clixdelnext);
                //$("input[name='leave_id'][value='" + my_value + "']").parents("tr").replaceWith(my_array_of_return_values["3"]);

                /*$.smallBox({
                    title: "Success!",
                    content: "<i class='fa fa-clock-o'></i> <i>Leave Request updated...</i>",
                    color: "#659265",
                    iconSmall: "fa fa-check fa-2x fadeInRight animated",
                    timeout: 4000
                });*/
            } else {
                /*$.smallBox({
                    title: "Fail!",
                    content: "<i class='fa fa-clock-o'></i> <i>Task Creation Failed...</i>",
                    color: "#C46A69",
                    iconSmall: "fa fa-times fa-2x fadeInRight animated",
                    timeout: 4000
                });*/
            }
        }

$('#close_image_modal').click();
$('#post_div').html("");

getExistingData($("#friend_id_for_wall").val(),2,0);
//get_activity_data();
        /*     else{
             $.smallBox({
                 title : "Fail!",
                 content : "<i class='fa fa-clock-o'></i> <i>branch Add process failed...</i>",
                 color : "#C46A69",
                 iconSmall : "fa fa-times fa-2x fadeInRight animated",
                 timeout : 1600
             });
             }
        */

       /* var delay = 2000; //1 seconds
        setTimeout(function () {

            $('#clix_myModal_remote').modal('toggle');

        }, delay);*/

    }
	
	
	
	
	
	
	


    var errorClass = 'invalid';
    var errorElement = 'em';

//---------------------- jquery validation for v_id start

    var $orderForm = $("#video_upload_form").validate({

        framework: 'bootstrap',
        excluded: ':disabled',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        ignore: [],
        errorClass: errorClass,
        errorElement: errorElement,
        highlight: function (element) {
            $(element).parent().removeClass('state-success').addClass("state-error");
            $(element).removeClass('valid');
        },
        unhighlight: function (element) {
            $(element).parent().removeClass("state-error").addClass('state-success');
            $(element).addClass('valid');
        },
        // Rules for form validation
        rules: {
            note_task_date: {
                required: true,
                //clix_onlyCharNumRegex: true,

            },
			
			
				note_task_time:{
					required: true,
					
				},
				
				note_task_type:{
					required: true,
				},
				
				note_task_priority:{
					required: true,
				},
				
				note_detail:{
					required: true,
				},
				
				
				
				

        },


        // Messages for form validation
        messages: {
            note_task_date: {
                required: '<span style="color:red;">Please Select Date......</span>',
                //clix_onlyCharNumRegex: '<span style="color:red;">branch no. must contain only letters and numbers......</span>',
            },


			note_task_time: {
                required: '<span style="color:red;">Please Select Time......</span>',
				

            },
			note_task_type: {
                required: '<span style="color:red;">Please Write Something......</span>',

            },
			note_task_priority: {
                required: '<span style="color:red;">Please Write Something......</span>',

            },
			note_detail: {
                required: '<span style="color:red;">Please Write Something......</span>',

            }
			

        },

        // Do not change code below
        errorPlacement: function (error, element) {
            error.insertAfter(element.parent());
            //	error.insertAfter(element);
        },

        submitHandler: function (form) {

            var options = {
                //url: 'clix_modal/aj_modal_mst_branch_add_edit_edit.php',
                url: 'cl_ajax/collaboration-ajax.php',
                beforeSubmit: showRequest1,  // pre-submit callback
                data: {
                    key: 'PostVideo',
					friend_id_for_wall_post:$("#friend_id_for_wall").val(),
					//my_editor3:editor.getData(),
					//detail_data : CKEDITOR.instances.editor_call.getData();
                },
                error: function () {
                    alert("hi! error...  contact system admin");
                    $('.form-footer').removeClass('progress');
                },
                success: showResponse1,  // post-submit callback
            };

            $('#video_upload_form').ajaxSubmit(options);

        }

    });

    function showRequest1(formData, jqForm, options) {
        $('#video_upload_form').waitMe({
            effect: 'rotateplane',
            text: '',
            bg: 'rgba(255,255,255,0.7)',
            color: '#000',
            maxSize: '',
            textPos: 'vertical',
            fontSize: '',
            source: ''
        });
        return true;
    }

    function showResponse1(responseText, statusText, xhr, $form) {
        $('#video_upload_form').waitMe("hide");

       // my_array_of_return_values = responseText.split('~~~');
	  // alert(responseText);
        if (responseText == 'A') {
//getExistingData();
            //------- change selected value after record added start
            //$("#user_code").append("<option value='" + my_array_of_return_values['1'] + "' selected='selected'>" + my_array_of_return_values['2'] + "</option>");
           // $("#select2-user_code-container").html('<span class="select2-selection__clear"></span>' + my_array_of_return_values['2']);
            //------- change selected value after record added end


// ---- append new row to the top
            //$('#datatable_fixed_column tbody').prepend(my_array_of_return_values["3"]);
			//alert(1);
            /*$.smallBox({
                title: "Success!",
                content: "<i class='fa fa-clock-o'></i> <i>Task Created...</i>",
                color: "#659265",
                iconSmall: "fa fa-check fa-2x fadeInRight animated",
                timeout: 1600
            });*/
        } else {

            if (responseText == 'U') {
//getExistingData();
                //var my_value = my_array_of_return_values["1"];
                // ---- insert updated row and remove old row
                //$(my_array_of_return_values["3"]).insertBefore($("input[name='v_id'][value='" + my_value + "']").parents("tr"));
                //$("input[name='v_id'][value='" + my_value + "'][clixdelnext='next']").closest("tr").next("tr").remove();
                //  $(selector).removeAttr(attribute)
                //$("input[name='v_id'][value='" + my_value + "'][clixdelnext='next']").removeAttr(clixdelnext);
                //$("input[name='leave_id'][value='" + my_value + "']").parents("tr").replaceWith(my_array_of_return_values["3"]);

                /*$.smallBox({
                    title: "Success!",
                    content: "<i class='fa fa-clock-o'></i> <i>Leave Request updated...</i>",
                    color: "#659265",
                    iconSmall: "fa fa-check fa-2x fadeInRight animated",
                    timeout: 4000
                });*/
            } else {
                /*$.smallBox({
                    title: "Fail!",
                    content: "<i class='fa fa-clock-o'></i> <i>Task Creation Failed...</i>",
                    color: "#C46A69",
                    iconSmall: "fa fa-times fa-2x fadeInRight animated",
                    timeout: 4000
                });*/
            }
        }

$('#close_video_modal').click();
$('#post_div').html("");

getExistingData($("#friend_id_for_wall").val(),2,0);
//get_activity_data();
        /*     else{
             $.smallBox({
                 title : "Fail!",
                 content : "<i class='fa fa-clock-o'></i> <i>branch Add process failed...</i>",
                 color : "#C46A69",
                 iconSmall : "fa fa-times fa-2x fadeInRight animated",
                 timeout : 1600
             });
             }
        */

       /* var delay = 2000; //1 seconds
        setTimeout(function () {

            $('#clix_myModal_remote').modal('toggle');

        }, delay);*/

    }
	
	
	
	
	
	/*Text Post modal*/
	    var errorClass = 'invalid';
    var errorElement = 'em';

//---------------------- jquery validation for v_id start

    var $orderForm = $("#text_post_form").validate({

        framework: 'bootstrap',
        excluded: ':disabled',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        ignore: [],
        errorClass: errorClass,
        errorElement: errorElement,
        highlight: function (element) {
            $(element).parent().removeClass('state-success').addClass("state-error");
            $(element).removeClass('valid');
        },
        unhighlight: function (element) {
            $(element).parent().removeClass("state-error").addClass('state-success');
            $(element).addClass('valid');
        },
        // Rules for form validation
        rules: {
            text_post_title: {
                required: true,
                //clix_onlyCharNumRegex: true,

            },
			
			
				
				
				
				
				

        },


        // Messages for form validation
        messages: {
            text_post_title: {
                required: '<span style="color:red;">Please Type something......</span>',
                //clix_onlyCharNumRegex: '<span style="color:red;">branch no. must contain only letters and numbers......</span>',
            },


			

        },

        // Do not change code below
        errorPlacement: function (error, element) {
            error.insertAfter(element.parent());
            //	error.insertAfter(element);
        },

        submitHandler: function (form) {

            var options = {
                //url: 'clix_modal/aj_modal_mst_branch_add_edit_edit.php',
                url: 'cl_ajax/collaboration-ajax.php',
                beforeSubmit: showRequest2,  // pre-submit callback
                data: {
                    key: 'PostText',
					friend_id_for_wall_post:$("#friend_id_for_wall").val(),
					//my_editor3:editor.getData(),
					//detail_data : CKEDITOR.instances.editor_call.getData();
                },
                error: function () {
                    alert("hi! error...  contact system admin");
                    $('.form-footer').removeClass('progress');
                },
                success: showResponse2,  // post-submit callback
            };

            $('#text_post_form').ajaxSubmit(options);

        }

    });

    function showRequest2(formData, jqForm, options) {
        $('#text_post_form').waitMe({
            effect: 'rotateplane',
            text: '',
            bg: 'rgba(255,255,255,0.7)',
            color: '#000',
            maxSize: '',
            textPos: 'vertical',
            fontSize: '',
            source: ''
        });
        return true;
    }

    function showResponse2(responseText, statusText, xhr, $form) {
        $('#text_post_form').waitMe("hide");

       // my_array_of_return_values = responseText.split('~~~');
	  // alert(responseText);
        if (responseText == 'A') {
//getExistingData();
            //------- change selected value after record added start
            //$("#user_code").append("<option value='" + my_array_of_return_values['1'] + "' selected='selected'>" + my_array_of_return_values['2'] + "</option>");
           // $("#select2-user_code-container").html('<span class="select2-selection__clear"></span>' + my_array_of_return_values['2']);
            //------- change selected value after record added end


// ---- append new row to the top
            //$('#datatable_fixed_column tbody').prepend(my_array_of_return_values["3"]);
			//alert(1);
            /*$.smallBox({
                title: "Success!",
                content: "<i class='fa fa-clock-o'></i> <i>Task Created...</i>",
                color: "#659265",
                iconSmall: "fa fa-check fa-2x fadeInRight animated",
                timeout: 1600
            });*/
        } else {

            if (responseText == 'U') {
//getExistingData();
                //var my_value = my_array_of_return_values["1"];
                // ---- insert updated row and remove old row
                //$(my_array_of_return_values["3"]).insertBefore($("input[name='v_id'][value='" + my_value + "']").parents("tr"));
                //$("input[name='v_id'][value='" + my_value + "'][clixdelnext='next']").closest("tr").next("tr").remove();
                //  $(selector).removeAttr(attribute)
                //$("input[name='v_id'][value='" + my_value + "'][clixdelnext='next']").removeAttr(clixdelnext);
                //$("input[name='leave_id'][value='" + my_value + "']").parents("tr").replaceWith(my_array_of_return_values["3"]);

                /*$.smallBox({
                    title: "Success!",
                    content: "<i class='fa fa-clock-o'></i> <i>Leave Request updated...</i>",
                    color: "#659265",
                    iconSmall: "fa fa-check fa-2x fadeInRight animated",
                    timeout: 4000
                });*/
            } else {
                /*$.smallBox({
                    title: "Fail!",
                    content: "<i class='fa fa-clock-o'></i> <i>Task Creation Failed...</i>",
                    color: "#C46A69",
                    iconSmall: "fa fa-times fa-2x fadeInRight animated",
                    timeout: 4000
                });*/
            }
        }

$('#close_text_modal').click();
$('#post_div').html("");

getExistingData($("#friend_id_for_wall").val(),2,0);
//get_activity_data();
        /*     else{
             $.smallBox({
                 title : "Fail!",
                 content : "<i class='fa fa-clock-o'></i> <i>branch Add process failed...</i>",
                 color : "#C46A69",
                 iconSmall : "fa fa-times fa-2x fadeInRight animated",
                 timeout : 1600
             });
             }
        */

       /* var delay = 2000; //1 seconds
        setTimeout(function () {

            $('#clix_myModal_remote').modal('toggle');

        }, delay);*/

    }
	
	
	
	
	/*Text post modal form*/
	
	
	/*Post Comment form*/
	
		/*Text Post modal*/
	    var errorClass = 'invalid';
    var errorElement = 'em';

//---------------------- jquery validation for v_id start

    var $orderForm = $("#comment_post_form").validate({

        framework: 'bootstrap',
        excluded: ':disabled',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        ignore: [],
        errorClass: errorClass,
        errorElement: errorElement,
        highlight: function (element) {
            $(element).parent().removeClass('state-success').addClass("state-error");
            $(element).removeClass('valid');
        },
        unhighlight: function (element) {
            $(element).parent().removeClass("state-error").addClass('state-success');
            $(element).addClass('valid');
        },
        // Rules for form validation
        rules: {
            comment_post_desc: {
                required: true,
                //clix_onlyCharNumRegex: true,

            },
			
			
				
				
				
				
				

        },


        // Messages for form validation
        messages: {
            comment_post_desc: {
                required: '<span style="color:red;">Please Type something......</span>',
                //clix_onlyCharNumRegex: '<span style="color:red;">branch no. must contain only letters and numbers......</span>',
            },


			

        },

        // Do not change code below
        errorPlacement: function (error, element) {
            error.insertAfter(element.parent());
            //	error.insertAfter(element);
        },

        submitHandler: function (form) {

            var options = {
                //url: 'clix_modal/aj_modal_mst_branch_add_edit_edit.php',
                url: 'cl_ajax/collaboration-ajax.php',
                beforeSubmit: showRequest3,  // pre-submit callback
                data: {
                    key: 'PostComment',
					friend_id_for_wall_post:$("#friend_id_for_wall").val(),
					//my_editor3:editor.getData(),
					//detail_data : CKEDITOR.instances.editor_call.getData();
                },
                error: function () {
                    alert("hi! error...  contact system admin");
                    $('.form-footer').removeClass('progress');
                },
                success: showResponse3,  // post-submit callback
            };

            $('#comment_post_form').ajaxSubmit(options);

        }

    });

    function showRequest3(formData, jqForm, options) {
        $('#comment_post_form').waitMe({
            effect: 'rotateplane',
            text: '',
            bg: 'rgba(255,255,255,0.7)',
            color: '#000',
            maxSize: '',
            textPos: 'vertical',
            fontSize: '',
            source: ''
        });
        return true;
    }

    function showResponse3(responseText, statusText, xhr, $form) {
		
		//alert(22);
        $('#comment_post_form').waitMe("hide");

        my_array_of_return_values = responseText.split('~~~');
	  // alert(responseText);
        if (my_array_of_return_values[0] == 'A') {
//getExistingData();
            //------- change selected value after record added start
            //$("#user_code").append("<option value='" + my_array_of_return_values['1'] + "' selected='selected'>" + my_array_of_return_values['2'] + "</option>");
           // $("#select2-user_code-container").html('<span class="select2-selection__clear"></span>' + my_array_of_return_values['2']);
            //------- change selected value after record added end


// ---- append new row to the top
            //$('#datatable_fixed_column tbody').prepend(my_array_of_return_values["3"]);
			//alert(1);
            /*$.smallBox({
                title: "Success!",
                content: "<i class='fa fa-clock-o'></i> <i>Task Created...</i>",
                color: "#659265",
                iconSmall: "fa fa-check fa-2x fadeInRight animated",
                timeout: 1600
            });*/
        } else {

            if (responseText == 'U') {
//getExistingData();
                //var my_value = my_array_of_return_values["1"];
                // ---- insert updated row and remove old row
                //$(my_array_of_return_values["3"]).insertBefore($("input[name='v_id'][value='" + my_value + "']").parents("tr"));
                //$("input[name='v_id'][value='" + my_value + "'][clixdelnext='next']").closest("tr").next("tr").remove();
                //  $(selector).removeAttr(attribute)
                //$("input[name='v_id'][value='" + my_value + "'][clixdelnext='next']").removeAttr(clixdelnext);
                //$("input[name='leave_id'][value='" + my_value + "']").parents("tr").replaceWith(my_array_of_return_values["3"]);

                /*$.smallBox({
                    title: "Success!",
                    content: "<i class='fa fa-clock-o'></i> <i>Leave Request updated...</i>",
                    color: "#659265",
                    iconSmall: "fa fa-check fa-2x fadeInRight animated",
                    timeout: 4000
                });*/
            } else {
                /*$.smallBox({
                    title: "Fail!",
                    content: "<i class='fa fa-clock-o'></i> <i>Task Creation Failed...</i>",
                    color: "#C46A69",
                    iconSmall: "fa fa-times fa-2x fadeInRight animated",
                    timeout: 4000
                });*/
            }
        }
//alert(1);
$('#close_post_comment_modal').click();
$('#comment_post_desc').val('');
//alert(2);
$('#image_comment_'+my_array_of_return_values[2]).append(my_array_of_return_values[1]);
//getExistingData($("#friend_id_for_wall").val());
//get_activity_data();
        /*     else{
             $.smallBox({
                 title : "Fail!",
                 content : "<i class='fa fa-clock-o'></i> <i>branch Add process failed...</i>",
                 color : "#C46A69",
                 iconSmall : "fa fa-times fa-2x fadeInRight animated",
                 timeout : 1600
             });
             }
        */

       /* var delay = 2000; //1 seconds
        setTimeout(function () {

            $('#clix_myModal_remote').modal('toggle');

        }, delay);*/

    }
	
	
	/*End Post Comment form*/
	
	/*Post Comment Reply form*/
	
	var $orderForm = $("#comment_reply_post_form").validate({

        framework: 'bootstrap',
        excluded: ':disabled',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        ignore: [],
        errorClass: errorClass,
        errorElement: errorElement,
        highlight: function (element) {
            $(element).parent().removeClass('state-success').addClass("state-error");
            $(element).removeClass('valid');
        },
        unhighlight: function (element) {
            $(element).parent().removeClass("state-error").addClass('state-success');
            $(element).addClass('valid');
        },
        // Rules for form validation
        rules: {
            comment_post_reply_desc: {
                required: true,
                //clix_onlyCharNumRegex: true,

            },
			
			
				
				
				
				
				

        },


        // Messages for form validation
        messages: {
            comment_post_reply_desc: {
                required: '<span style="color:red;">Please Type something......</span>',
                //clix_onlyCharNumRegex: '<span style="color:red;">branch no. must contain only letters and numbers......</span>',
            },


			

        },

        // Do not change code below
        errorPlacement: function (error, element) {
            error.insertAfter(element.parent());
            //	error.insertAfter(element);
        },

        submitHandler: function (form) {

            var options = {
                //url: 'clix_modal/aj_modal_mst_branch_add_edit_edit.php',
                url: 'cl_ajax/collaboration-ajax.php',
                beforeSubmit: showRequest4,  // pre-submit callback
                data: {
                    key: 'PostCommentReply',
					friend_id_for_wall_post:$("#friend_id_for_wall").val(),
					//my_editor3:editor.getData(),
					//detail_data : CKEDITOR.instances.editor_call.getData();
                },
                error: function () {
                    alert("hi! error...  contact system admin");
                    $('.form-footer').removeClass('progress');
                },
                success: showResponse4,  // post-submit callback
            };

            $('#comment_reply_post_form').ajaxSubmit(options);

        }

    });

    function showRequest4(formData, jqForm, options) {
        $('#comment_reply_post_form').waitMe({
            effect: 'rotateplane',
            text: '',
            bg: 'rgba(255,255,255,0.7)',
            color: '#000',
            maxSize: '',
            textPos: 'vertical',
            fontSize: '',
            source: ''
        });
        return true;
    }

    function showResponse4(responseText, statusText, xhr, $form) {
        $('#comment_reply_post_form').waitMe("hide");

        my_array_of_return_values = responseText.split('~~~');
	  // alert(responseText);
        if (my_array_of_return_values[0] == 'A') {
//getExistingData();
            //------- change selected value after record added start
            //$("#user_code").append("<option value='" + my_array_of_return_values['1'] + "' selected='selected'>" + my_array_of_return_values['2'] + "</option>");
           // $("#select2-user_code-container").html('<span class="select2-selection__clear"></span>' + my_array_of_return_values['2']);
            //------- change selected value after record added end


// ---- append new row to the top
            //$('#datatable_fixed_column tbody').prepend(my_array_of_return_values["3"]);
			//alert(1);
            /*$.smallBox({
                title: "Success!",
                content: "<i class='fa fa-clock-o'></i> <i>Task Created...</i>",
                color: "#659265",
                iconSmall: "fa fa-check fa-2x fadeInRight animated",
                timeout: 1600
            });*/
        } else {

            if (responseText == 'U') {
//getExistingData();
                //var my_value = my_array_of_return_values["1"];
                // ---- insert updated row and remove old row
                //$(my_array_of_return_values["3"]).insertBefore($("input[name='v_id'][value='" + my_value + "']").parents("tr"));
                //$("input[name='v_id'][value='" + my_value + "'][clixdelnext='next']").closest("tr").next("tr").remove();
                //  $(selector).removeAttr(attribute)
                //$("input[name='v_id'][value='" + my_value + "'][clixdelnext='next']").removeAttr(clixdelnext);
                //$("input[name='leave_id'][value='" + my_value + "']").parents("tr").replaceWith(my_array_of_return_values["3"]);

                /*$.smallBox({
                    title: "Success!",
                    content: "<i class='fa fa-clock-o'></i> <i>Leave Request updated...</i>",
                    color: "#659265",
                    iconSmall: "fa fa-check fa-2x fadeInRight animated",
                    timeout: 4000
                });*/
            } else {
                /*$.smallBox({
                    title: "Fail!",
                    content: "<i class='fa fa-clock-o'></i> <i>Task Creation Failed...</i>",
                    color: "#C46A69",
                    iconSmall: "fa fa-times fa-2x fadeInRight animated",
                    timeout: 4000
                });*/
            }
        }

$('#close_post_comment_reply_modal').click();
$('#comment_post_reply_desc').val('');
$('#post_comment_reply_'+my_array_of_return_values[2]+'_'+my_array_of_return_values[3]).append(my_array_of_return_values[1]);
//getExistingData($("#friend_id_for_wall").val());
//get_activity_data();
        /*     else{
             $.smallBox({
                 title : "Fail!",
                 content : "<i class='fa fa-clock-o'></i> <i>branch Add process failed...</i>",
                 color : "#C46A69",
                 iconSmall : "fa fa-times fa-2x fadeInRight animated",
                 timeout : 1600
             });
             }
        */

       /* var delay = 2000; //1 seconds
        setTimeout(function () {

            $('#clix_myModal_remote').modal('toggle');

        }, delay);*/

    }
	
	
	/*End Post Comment reply form*/
	
	
	
	
	
	
	
	
	
	$(document).ready(function () {
		
		        /*getExistingData(function () {
            //--  alert ('get date success');

            clixPageOnload();
        });*/
		
		
		
		
		
		var limit = 2;
 var start = 0;
 var action = 'inactive';
 window.getExistingData = function(friend_id_for_wall1,limit, start1)
 {
     var friend_id_for_wall = 0;
     if(friend_id_for_wall1>0)
     {
         friend_id_for_wall = friend_id_for_wall1;
     }
     else
     {
	    friend_id_for_wall = $('#friend_id_for_wall').val();
     }
	 //alert(friend_id_for_wall);
	 //alert(start);
	 //alert(limit);
	 
  $.ajax({
   url:"cl_ajax/collaboration-ajax.php",
   method:"POST",
   data:{key: 'getExistingPostedData',
				frnd_wall_id : friend_id_for_wall,
				limit:limit,
				start:start1
				},
   //cache:false,
   success:function(data)
   {
	   //alert(data);
    $('#post_div').append(data);
    if(data == '')
    {
     $('#load_data_message').html("<label style='margin-left: 45%;' class='label-info'>No Post Found...</label>");
     action = 'active';
    }
    else
    {
     $('#load_data_message').html("<img src='images/loading_symbol_2.gif' width='15%' height='15%' style='margin-left: 45%;'>");
     action = "inactive";
    }
   }
  });
  
  start=start1;
 }

 if(action == 'inactive')
 {
	 
	
  action = 'active';
  getExistingData(0,limit, start);
 }
 $("#post_div_limit").scroll(function(){
     //alert(1);
	 
  if($("#post_div_limit").scrollTop() + $("#post_div_limit").height() > $("#post_div").height() && action == 'inactive')
  {
   action = 'active';
   start = start + limit;
   setTimeout(function(){
    getExistingData(0,limit, start);
   }, 1000);
  }
 });
		
		
		
		
		
		
		
		
		
		
		//getExistingData1(0,2,0);
		
		friend_wall_additional_details(0);
		
		getExistingDataFriendList();
		
		search_friend_list_to_send_invitation('');
		
		get_chat_area(0,'',0);
		
		});
		
		
		function getExistingData1(friend_id_for_wall,limit,start)
		{
			 //var limit = 7;
			//var start = 0;
			receiver_userid = friend_id_for_wall;
			
				        $.ajax({
            url: 'cl_ajax/collaboration-ajax.php',
            method: 'POST',
            dataType: 'text',
            data: {
                key: 'getExistingPostedData',
				frnd_wall_id : friend_id_for_wall,
				limit:limit,
				start:start
                //lead_id: atob(c)
            }, success: function (response) {
				
				
                $("#post_div").append(response);
				
				
				    if(response == '')
    {
     $('#load_data_message').html("<button type='button' class='btn btn-info'>No Data Found</button>");
     action = 'active';
    }
    else
    {
     $('#load_data_message').html("<button type='button' class='btn btn-warning'>Please Wait....</button>");
     action = "inactive";
    }
				
				
            }
        });
		
		
	
		}
		
		
		
		
		function getExistingDataFriendList()
		{
				        $.ajax({
            url: 'cl_ajax/collaboration-ajax.php',
            method: 'POST',
            dataType: 'text',
            data: {
                key: 'get_frient_list',
                //lead_id: atob(c)
            }, success: function (response) {
				
				
                $("#friend_list").html(response);
            }
        });


$.ajax({
            url: 'cl_ajax/collaboration-ajax.php',
            method: 'POST',
            dataType: 'text',
            data: {
                key: 'get_invited_friend_list',
                //lead_id: atob(c)
            }, success: function (response) {
				
				response1 = response.split('~~~');
				
				$("#count_invite_sent").html('&nbsp('+response1[0]+')');
				
                $("#invited_friend_list").html(response1[1]);
            }
        });
		
		
		
		
		$.ajax({
            url: 'cl_ajax/collaboration-ajax.php',
            method: 'POST',
            dataType: 'text',
            data: {
                key: 'get_friend_requested_friend_list',
                //lead_id: atob(c)
            }, success: function (response) {
				
				response2 = response.split('~~~');
				
				$("#count_invite_received").html('&nbsp('+response2[0]+')');
				
                $("#received_friend_request_list").html(response2[1]);
            }
        });

	
		}
		
		function friend_wall_additional_details(friend_id_for_wall)
		{
			
			
			//alert(1);
			
			
			$.ajax({
        url: 'cl_ajax/collaboration-ajax.php',
        method: 'POST',
        dataType: 'json',
        data: {
            key: 'GeFriendWallAdditionalData',
            frnd_wall_id : friend_id_for_wall
        }, success: function (response) {
			
			
			/*$("#lead_title").val(response.lead_title);
			$("#slider_title1").html("Lead");
			$("#stage").html(response.get_stage_option);
			$("#account_type").html(response.get_account_type_option);
			$("#slider_title").html("Deal");
			$("#lead_date").val(response.lead_dt);*/
			$("#friend_id_for_wall").val(response.friend_id_for_wall);
			$("#friend_fullname").html(response.friend_fullname);
			$("#friend_email").html(response.friend_email);
			$("#friend_phonenumber").html(response.friend_phonenumber);
			$("#friend_location").html(response.friend_state+'/'+response.friend_country);
			
			 document.getElementById("friend_profile_image").src = "profile_pictures/"+response.friend_profileimage;
			 
			 $("#friend_school_college").html(response.friend_institutename);
			$("#friend_term_year").html(response.friend_term+'/'+response.friend_acca_year);

			receiver_userid = response.friend_id_for_wall;
			
        }
    });
			
			
			
			
		}
		
		
		function change_wall_details(friend_id_for_wall)
		{
		    
		    //alert(friend_id_for_wall);
			$('#post_div').html("");
			
			getExistingData(friend_id_for_wall,2,0);
			friend_wall_additional_details(friend_id_for_wall);
		}
		
		
		function get_post_details(post_id)
		{
			var post_id_arr = post_id.split('_');
			//alert(post_id_arr[2]);
			$("#post_id").val(post_id_arr[2]);
			//alert(post_id);
		}
		
		function get_post_reply_details(post_id_comment_id)
		{
			var post_id_comment_id_arr = post_id_comment_id.split('_');
			
			//alert(post_id_comment_id_arr[3]);//post_id
			//alert(post_id_comment_id_arr[4]);//comment_id
			$("#post_reply_id").val(post_id_comment_id_arr[3]);
			$("#comment_reply_id").val(post_id_comment_id_arr[4]);
			
		}
		
		
		function frnd_req_accept_reject(requested_from_friend,action_type,frnd_request_id)
		{
			//alert(requested_from_friend);
			//alert(action_type);
			
					$.ajax({
            url: 'cl_ajax/collaboration-ajax.php',
            method: 'POST',
            dataType: 'text',
            data: {
                key: 'friend_req_accept_reject',
				requested_from_friend_id:requested_from_friend,
				action_type:action_type,
				frnd_request_id:frnd_request_id
                //lead_id: atob(c)
            }, success: function (response) {
				
				if(response=='Y')
				{
					if(action_type=='A')
					{
						alert('Success Fully Accepted');
					}
					
					else{
						alert('Success Fully Rejected');
					}
                getExistingDataFriendList();
				change_wall_details();
				
				
				}
				else{
					alert("Failed.Please Try again");
				}
            }
        });
			
			
		}
		
		
		function send_invitation_to_unregistered_frnd()
		{
							        $.ajax({
            url: 'cl_ajax/collaboration-ajax.php',
            method: 'POST',
            dataType: 'text',
            data: {
                key: 'send_unregistered_frient_request',
				unregistered_frient_email: $("#unregistered_frient_email").val(),
                //lead_id: atob(c)
            }, success: function (response) {
				
				if(response=='Y')
				{
					$('#unregistered_frient_email').val('');
					getExistingDataFriendList();
					alert('Invitation sent successfully');
				}
				else{
					alert('Something went wrong please try again');
				}
                //$("#friend_list").html(response);
            }
        });
		}
		
		
		
		  function resend_invitation(friend_id)
  {
	  //alert(friend_id);
	  
	  
	  
	  
	  
	  	  $.ajax({
        url: 'cl_ajax/collaboration-ajax.php',
        method: 'POST',
        dataType: 'text',
        data: {
            key: 'resend_registered_frient_request',
            req_friend_id : friend_id
        }, success: function (response) {
			
			
		
			
        }
    });
	  
	  
	  
  }
  
  
  function resend_invitation_unregfrnd(email_id)
  {
	 // alert(email_id);
	  
	  
	  							        $.ajax({
            url: 'cl_ajax/collaboration-ajax.php',
            method: 'POST',
            dataType: 'text',
            data: {
                key: 're_send_unregistered_frient_request',
				unregistered_frient_email: email_id,
                //lead_id: atob(c)
            }, success: function (response) {
				
				if(response=='Y')
				{
					//$('#unregistered_frient_email').val('');
					//getExistingDataFriendList();
					alert('Invitation sent successfully');
				}
				else{
					alert('Something went wrong please try again');
				}
                //$("#friend_list").html(response);
            }
        });
  }
  
  
  function cancel_invite_frnd(invite_id)
  {
	  $.ajax({
            url: 'cl_ajax/collaboration-ajax.php',
            method: 'POST',
            dataType: 'text',
            data: {
                key: 'delete_frnd_invitation',
				invite_id: invite_id,
                //lead_id: atob(c)
            }, success: function (response) {
				
				if(response=='Y')
				{
					//$('#unregistered_frient_email').val('');
					getExistingDataFriendList();
					alert('Invitation deleted successfully');
				}
				else{
					alert('Something went wrong please try again');
				}
                //$("#friend_list").html(response);
            }
        });
  }
  
  
  function search_friend_from_friend_list(search_keyword)
  {
	  //alert(search_keyword);
	 
	  $.ajax({
            url: 'cl_ajax/collaboration-ajax.php',
            method: 'POST',
            dataType: 'text',
            data: {
                key: 'get_frient_list',
                search_keyword: search_keyword
            }, success: function (response) {
				
				
                $("#friend_list").html(response);
            }
        });
  
  }
  
  
  
  
  
  
  
  
  /*start new code*/
  
  
  
  
  /*Chat Section*/
  
  //var limit_chat = 2;
 //var start_chat = 0;
 //var action = 'inactive';
  		function get_chat_area(friend_id_for_wall,full_name,max_chat_id){
			
			//$("#to_user_id").val()
			//receiver_userid = friend_id_for_wall;
			
			//var from_user_id=$('#login_user_id').val();
			
			var receiver_user_name = full_name;
			
			//alert(receiver_user_name);
			//$('.select_user.active').removeClass('active');
			
			//$(this).addClass('active');
			
			//make_chat_area(receiver_user_name);
			
			//alert(friend_id_for_wall);
			
			$('#is_active_chat').val('Yes');
			
			//alert(max_chat_id);
			//alert(full_name);
			$.ajax({
				url:"cl_ajax/collaboration-ajax.php",
				method:"POST",
				data:{key:'fetch_chat', to_user_id:friend_id_for_wall,max_chat_id:max_chat_id},
				dataType:"text",
				success:function(data)
				{
				    
					//alert(data);
					//alert(max_chat_id);
					if(max_chat_id>0)
					{
					
					
					//var firstMsg = $('#message_area_div:first');
					//alert(firstMsg);
				//	var current_top_element = $('#message_area').children().first();
				var previous_height = $("#message_area").height();
					$("#message_area").prepend(data);
					//alert(data);
				/*	var previous_height = 0;
current_top_element.prevAll().each(function() {
  previous_height += $(this).outerHeight();
});*/
if(data!='')
{
$('#message_area_div').scrollTop(previous_height);
}
            //$('body').prepend(firstMsg.clone());
            //$('#message_area_div').scrollTop(data.offset().top);
					}
					else
					{
					    //alert(1);
					    $("#chat_area").html(data);
					    $('#message_area_div').scrollTop($('#message_area_div')[0].scrollHeight);
					}
					
					
					/*if(data.length > 0)
					{
						var html_data= '';
						
						for(var count = 0;count < data.length; count++)
						{
							var row_class='';
							var background_class='';
							var user_name='';
							if(data[count].from_user_id == from_user_id)
							{
								row_class='row justify-content-start';
								
								background_class = 'alert-primary';
								
								user_name = 'Me';
							}
							else{
								
								row_class='row justify-content-end';
								
								background_class = 'alert-success';
								
								user_name = data[count].from_user_name;
								
							}
							
							//alert(user_name);
							
							html_data +='<div class="'+row_class+'"><div class="col-sm-10"><div class="shadow alert '+background_class+'"><b>'+user_name+'</b><br/>'+data[count].chat_message+'<br/><div class="text-right"><small><i>'+data[count].timestamp+'</i></small></div></div></div></div>';
							
							//alert(html_data);
						}
						//alert(html_data);
						$('#userid_'+receiver_user_id).html('');
						
						$('#message_area').html(html_data);
						
						$('#message_area').scrollTop($('#message_area')[0].scrollHeight);
					}*/
					
					
				//alert(data);
					
					
					
				}
			})
			
			
			};
			
			
			 
			
			
			
				$(document).ready(function(){
		
		var receiver_user_id='';

		var conn = new WebSocket('ws://localhost:8080');
		conn.onopen = function(event) {
		    console.log("Connection established!");
		};
		
		conn.onopen = function(event)
		{
			console.log('Connection Established');
		};
		
		conn.onmessage=function(event)
		{
			
			
			var data = JSON.parse(event.data);
			var row_class = '';
			var background_class = '';
			
			if(data.from == 'Me')
			{
				row_class = 'row justify-content-start';
				background_class = 'alert-primary';
			}
			
			else{
				
				row_class = 'row justify-content-end';
				background_class = 'alert-success';
				
			}
			
			if(receiver_userid == data.userId || data.from == 'Me')
			{
				
				//alert(receiver_userid);
				
				//alert(data.userId);
				
				//alert(data.from);
				
				
				//alert(data.queryyyy);
				
				if(data.from == 'Me')
				{
					
					var profile_image_me = '<?php echo $_SESSION["profileimage"];?>';
					var html_data = '<div class="d-flex flex-column mb-5 align-items-end"><div class="d-flex align-items-center"><div><span class="text-muted font-size-sm">'+datetime+'</span><a href="#" class="text-dark-75 text-hover-primary font-weight-bold font-size-md">You</a></div><div class="symbol symbol-circle symbol-40 ml-3"><img alt="Pic" src="profile_pictures/'+profile_image_me+'"></div></div><div class="mt-2 rounded p-5 bg-light-primary text-dark-50 font-weight-bold font-size-sm text-right max-w-400px">'+data.msg+'</div></div>';
				}
				else{
					var profile_image_to_user=$("#to_profile_image_for_chat").val();
					var to_user_name_for_chat=$("#to_user_name_for_chat").val();
					datetm = '<?php echo date("Y-m-d H:i:s"); ?>';
					
					var html_data = '<div class="d-flex flex-column mb-5 align-items-start"><div class="d-flex align-items-center"><div class="symbol symbol-circle symbol-40 mr-3"><img alt="Pic" src="profile_pictures/'+profile_image_to_user+'"></div><div><a href="#" class="text-dark-75 text-hover-primary font-weight-bold font-size-md">'+to_user_name_for_chat+'</a><span class="text-muted font-size-sm">'+datetm+'</span></div></div><div class="mt-2 rounded p-5 bg-light-success text-dark-50 font-weight-bold font-size-sm text-left max-w-400px">'+data.msg+'</div></div>';
				
				}
				
				
				/*if($('#is_active_chat').val() == 'Yes')
				{
					var html_data = '<div class="'+row_class+'"><div class="col-sm-10"><div class="shadow alert '+background_class+'"><b>'+data.from+'</b><br/>'+data.msg+'<br/><div class="text-right"><small><i>'+data.datetime+'</i></small></div></div></div></div>';
					
					//alert(data.datetime);
					
					
					$('#message_area').append(html_data);
					
					$('#message_area').scrollTop($('#message_area')[0].scrollHeight);
					
					$('chat_message').val("");
				}*/
				
				//alert($('chat_message').val());
				$('#message_area').append(html_data);
				
				$('#message_area_div').scrollTop($('#message_area_div')[0].scrollHeight);
			}
			

			
		};
		
		conn.onclose = function(event)
		{
			console.log('connection close');
		};
			
			
						$(document).on('submit','#chat_form',function(event){
				
				event.preventDefault();
				
				//alert($('#chat_message').val());
					var user_id = $('#login_user_id').val();
					var message = $('#chat_message').val();
					datetime = '<?php echo date("Y-m-d H:i:s"); ?>';
					
					var data={
						userId: user_id,
						msg: message,
						receiver_userid:receiver_userid,
						datetime:datetime,
						command:'private'
					};
				
				$('#chat_message').val('');
				conn.send(JSON.stringify(data));
				
				//ajax call
				//alert($('chat_message').val());
				//alert(message);
				$.ajax({
				url:"cl_ajax/collaboration-ajax.php",
				method:"POST",
				data:{key:'save_chat',user_id:user_id,msg: message,receiver_userid:receiver_userid,datetime:datetime,},
				dataType:"text",
				success:function(data)
				{
				    //alert($('chat_message').val());
					//alert(data);
				}
			});
				
				
				//ajax call
				
				
				
			});
  
  	});
  /*Chat Section*/
	  /*end new code*/	
</script>



