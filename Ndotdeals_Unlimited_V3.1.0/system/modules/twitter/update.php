<?php 
	// require twitterOAuth lib
	$url_arr = explode("/",$_SERVER['REQUEST_URI']);
	
	require_once('twitterOAuth.php');
	//Compatible for both sign-up and sign-in twitter
	include($_SERVER["DOCUMENT_ROOT"].'/system/includes/library.inc.php');

    /* If the access tokens are already set skip to the API call */
    if ($_SESSION['oauth_access_token'] === NULL && $_SESSION['oauth_access_token_secret'] === NULL) {
      /* Create TwitterOAuth object with app key/secret and token key/secret from default phase */
      $to = new TwitterOAuth($consumer_key, $consumer_secret, $_SESSION['oauth_request_token'], $_SESSION['oauth_request_token_secret']);
      /* Request access tokens from twitter */
      $tok = $to->getAccessToken();

      /* Save the access tokens. Normally these would be saved in a database for future use. */
      $_SESSION['oauth_access_token'] = $tok['oauth_token'];
      $_SESSION['oauth_access_token_secret'] = $tok['oauth_token_secret'];
    }
    /* Random copy */
    $content = 'your account should now be registered with twitter. Check here:';
    $content .= '<a href="https://twitter.com/account/connections">https://twitter.com/account/connections</a>';

	/* Consumer key from twitter */
	$consumer_key = TWITTER_API;
	/* Consumer Secret from twitter */
	$consumer_secret = TWITTER_SECRET;
	
	//get the facebook userid and token id
	$get_twitter_info = mysql_query("select * from social_account where type='2' limit 0,1") or die(mysql_error());
	if(mysql_num_rows($get_twitter_info)>0)
	{
		while($twitter_val = mysql_fetch_array($get_twitter_info))
		{
			$oauth_access_token = $twitter_val["access_token"];
			$oauth_access_token_secret = $twitter_val["access_token_secret"];
		}
	}
	else
	{
		$oauth_access_token = '';
		$oauth_access_token_secret = '';
	}
		
	/* returns the shortened url */
	function get_bitly_short_url($url,$login,$appkey,$format='txt') {
	  $connectURL = 'http://api.bit.ly/v3/shorten?login='.$login.'&apiKey='.$appkey.'&uri='.urlencode($url).'&format='.$format;
	  return curl_get_result($connectURL);
	}
	/* returns a result form url */
	function curl_get_result($url) {
	  $ch = curl_init();
	  curl_setopt($ch,CURLOPT_URL,$url);
	  curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	  $data = curl_exec($ch);
	  curl_close($ch);
	  return $data;
	}
	
	//print_r($share_link);
	/* get the short url */
	$short_url = get_bitly_short_url($share_link,'kannansp','R_2c7f253e911e440093c97ca3788ebff2');			
	
	$tweet_message = "The new deal has been posted with best offer. Hurry up!!! ".$short_url;
	
    /* Create TwitterOAuth with app key/secret and user access key/secret */
    $to = new TwitterOAuth($consumer_key, $consumer_secret, $oauth_access_token, $oauth_access_token_secret);
    /* Run request on twitter API as user. */
    //$content = $to->OAuthRequest('https://twitter.com/account/verify_credentials.xml', array(), 'GET');

	$content = $to->OAuthRequest('https://twitter.com/statuses/update.xml', array('status' => $tweet_message), 'POST');

?>

