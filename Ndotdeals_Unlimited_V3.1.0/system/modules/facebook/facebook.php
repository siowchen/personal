<?php 

include($_SERVER["DOCUMENT_ROOT"].'/system/modules/facebook/function.php');

/** FACEBOOK CONNECT **/
$fb_access_token = $_SESSION["fb_access_token"];
if(!$fb_access_token){

	if($_GET["code"]){
		$token_url = "https://graph.facebook.com/oauth/access_token?client_id=".$app_id."&redirect_uri=".urlencode($redirect_url)."&client_secret=".$app_secret."&code=".$_GET["code"];
		$access_token = curl_function($token_url);			
		$FBtoken = str_replace("access_token=","", $access_token);
		$FBtoken = explode("&expires=", $FBtoken);

		if(isset($FBtoken[0])){
			if($FBtoken[0]){
			
				$profile_data_url = "https://graph.facebook.com/me?access_token=".$FBtoken[0];

				$Profile_data = json_decode(curl_function($profile_data_url));
				if(isset($Profile_data->error)){
					echo "Problem in Facebook Connect! Try again later."; exit;
				}
				else{

					$id =  $Profile_data->id;
					$fname =  $Profile_data->first_name;
					$lanme =  $Profile_data->last_name;
					$email =  $Profile_data->email;
					$image =  "http://graph.facebook.com/".$id."/picture";
					$access_token =  $FBtoken[0];
					
					/** INSERT AND UPDATE DB **/
					if($_SESSION["userid"]){

						updateFBuser($_SESSION["userid"], $image, $access_token, $id,$fname,$lname,$email);
						
					}
					else{

						easyRegister("FB".$id, $fname, $lanme, $email, $image , 1, $access_token, $id);
					}
				}	
			}	
		}
		else{
			echo "Problem in Facebook Connect! Try again later."; exit;
		}

		?>
			<script>
			window.opener.location = '/profile.html';  
                        window.close();
                        </script>
		<?php 
	}
	else{	
		$login_url = "https://www.facebook.com/dialog/oauth?client_id=".$app_id."&redirect_uri=".urlencode($redirect_url)."&scope=email,read_stream,publish_stream,publish_checkins,offline_access,friends_checkins,user_checkins&display=popup";
		header("Location:".$login_url);
		die();	
	}
}
else{
	?>
		<script>window.close();</script>
	<?php 
 }
?>
