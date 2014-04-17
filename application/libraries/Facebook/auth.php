<?php

	//Facebook Authentication part
	$user = $facebook->getUser();
	// We may or may not have this data based 
	// on whether the user is logged in.
	// If we have a $user id here, it means we know 
	// the user is logged into
	// Facebook, but we don’t know if the access token is valid. An access
	// token is invalid if the user logged out of Facebook.
	
	$loginUrl   = $facebook->getLoginUrl(
		array(
			'scope' => 'email,publish_stream,user_location,user_about_me,user_hometown'
		)
	);

	if ($user) {
		try {
			// Proceed knowing you have a logged in user who's authenticated.
			$user_profile = $facebook->api('/me');
		} catch (FacebookApiException $e) {
			//you should use error_log($e); instead of printing the info on browser
			d($e);  // d is a debug function defined at the end of this file
			$user = null;
		}
	}

	if (!$user) {
		echo "<script type='text/javascript'>top.location.href = '$loginUrl';</script>";
		exit;
	}
		
	//get user basic description
	$userInfo = $facebook->api("/$user");
		
	//get token
	$access_token = $facebook->getAccessToken();
		
	function d($d){
		echo '<pre>';
		print_r($d);
		echo '</pre>';
	}
	
?>