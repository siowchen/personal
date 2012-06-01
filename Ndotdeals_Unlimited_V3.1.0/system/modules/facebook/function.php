<?php 
ob_start();
session_start();

	include($_SERVER["DOCUMENT_ROOT"].'/system/includes/library.inc.php');
	
	$app_id = FACEBOOK_APP_ID;
	$api_key = FACEBOOK_API;
	$app_secret = FACEBOOK_SECRET;
	$redirect_url = DOCROOT.FACEBOOK_REDIRECT_URL;

	
	/** CURL GET AND POST**/
	function curl_function($req_url = "" , $type = "", $arguments =  array())
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $req_url);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
		curl_setopt($ch, CURLOPT_TIMEOUT, 100);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		
		if($type == "POST"){
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $arguments);
		}
		
		$result = curl_exec($ch);
		curl_close ($ch);
		return $result;
	}

	/** POST STATUS UPDATE **/
	function facebook_status_update($Status_Message = "")
	{
		//get the facebook userid and token id
		$get_facebook_info = mysql_query("select * from social_account where type='1' limit 0,1") or die(mysql_error());
		if(mysql_num_rows($get_facebook_info)>0)
		{
			while($facebook_val = mysql_fetch_array($get_facebook_info))
			{
				$fb_user_id = $facebook_val["account_user_id"];
				$fb_access_token = $facebook_val["access_token"];
			}
		}
		else
		{
			$fb_user_id = '';
			$fb_access_token = '';
		}
		

		$Status_Message = "The new deal has been posted with best offer. Hurry up!!! ".$Status_Message;

		if($fb_access_token && $fb_user_id)
		{
			$Post_url = "https://graph.facebook.com/feed";	
			$post_arg = array("access_token" => $fb_access_token, "message" => $Status_Message, "id" => $fb_user_id, "method" => "post" );
			$status = curl_function($Post_url, "POST", $post_arg);
			return $status;
		}
		return;
	}

	/** POST CHECK IN **/
	
	//post_check_in('111363115605247',"i want to go");
	function post_check_in($place_id = "", $checkin_Message = "")
	{
		$fb_access_token = $_SESSION["fb_access_token"];
		$fb_user_id = $_SESSION["facebook_userid"];
		
		if($place_id && $checkin_Message && $fb_access_token && $fb_user_id){
			$checkin_data = json_decode(curl_function("https://graph.facebook.com/".$place_id));
			if(!isset($checkin_data->error)){
				$Post_url = "https://graph.facebook.com/".$fb_user_id."/checkins";	
				$post_arg = array(
								"access_token" => $fb_access_token, 
								"message" => $checkin_Message , 
								"coordinates" => json_encode(array('latitude' => $checkin_data->location->latitude, 'longitude' => $checkin_data->location->longitude)),
								'tags' => "", // friends id comma seperate
								"place" => $checkin_data->id
							);
				$status = curl_function($Post_url, "POST", $post_arg);
			}
			else{
				$status = "Invalid Place id";
			}
		}
		else{
			$status = "somthing missing";
		}
		return $status;
	}
	
	//add the facebook account
    function updateFBuser($userid = "", $image_url = "", $access_token = "", $FB_user_id = "",$first_name = "",$last_name = "",$email_id = "")
	{
		if($access_token && $FB_user_id)
		{
			$check_account_exist = mysql_query("select * from social_account where account_user_id = '$FB_user_id' ");
			if(mysql_num_rows($check_account_exist) == 0)
			{
				$update_users_fb = mysql_query("insert into social_account(first_name,last_name,image_url,email_id,account_user_id,access_token,userid,type)values('$first_name','$last_name','$image_url','$email_id','$FB_user_id','$access_token','$userid','1')");
				$_SESSION["facebook_userid"] = $FB_user_id;
				$_SESSION["fb_access_token"] = $access_token;
				$_SESSION["mes"] = "Facebook account has been added";
			}
			else
			{
				$_SESSION["emes"] = "Facebook account already exist";
			}
		}
		return;
	}

ob_flush();
?>
