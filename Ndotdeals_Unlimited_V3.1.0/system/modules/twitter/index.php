<?php ob_start(); ?>
<?php //session_start();
// require twitterOAuth lib
$url_arr = explode("/",$_SERVER['REQUEST_URI']);

require_once('twitterOAuth.php');
//Compatible for both sign-up and sign-in twitter
include($_SERVER["DOCUMENT_ROOT"].'/system/includes/library.inc.php');

/* Sessions are used to keep track of tokens while user authenticates with twitter */

/* Consumer key from twitter */
$consumer_key = TWITTER_API;
/* Consumer Secret from twitter */
$consumer_secret = TWITTER_SECRET;

/* Set up placeholder */
$content = NULL;
/* Set state if previous session */
$state = $_SESSION['oauth_state'];
/* Checks if oauth_token is set from returning from twitter */
$session_token = $_SESSION['oauth_request_token'];
/* Checks if oauth_token is set from returning from twitter */
$oauth_token = $_REQUEST['oauth_token'];
/* Set section var */
$section = $_REQUEST['section'];

if($_REQUEST['oauth_token']!="")
$_SESSION['oauth_token']=$_REQUEST['oauth_token'];

/* If oauth_token is missing get it */

if ($_REQUEST['oauth_token']!= NULL && $_SESSION['oauth_state'] === 'start') {
  $_SESSION['oauth_state'] = $state = 'returned';
}

/*
 * Switch based on where in the process you are
 *
 * 'default': Get a request token from twitter for new user
 * 'returned': The user has authorize the app on twitter
 */
//echo $state; exit;
//print_r($_SESSION);exit;
switch ($state) {/*{{{*/
  default:
    /* Create TwitterOAuth object with app key/secret */
      
    $to = new TwitterOAuth($consumer_key, $consumer_secret);
    /* Request tokens from twitter */
    $tok = $to->getRequestToken();

    /* Save tokens for later */
    $_SESSION['oauth_request_token'] = $token = $tok['oauth_token'];
    $_SESSION['oauth_request_token_secret'] = $tok['oauth_token_secret'];
    $_SESSION['oauth_state'] = "start";
   
    /* Build the authorization URL */
    $request_link = $to->getAuthorizeURL($token);
   
    /* Build link that gets user to twitter to authorize the app */
    //$content = 'Click on the link to go to twitter to authorize your account.';
    //$content .= '<a href="'.$request_link.'"><img src="/images/twitter.jpg" alt="twitter" border="0" title="twitter" /></a>';

?>

			<script>
				window.location= '<?php echo $request_link; ?>';
			</script>

<?php 
    //die();
    break;
  case 'returned':
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

    /* Create TwitterOAuth with app key/secret and user access key/secret */
    $to = new TwitterOAuth($consumer_key, $consumer_secret, $_SESSION['oauth_access_token'], $_SESSION['oauth_access_token_secret']);
    /* Run request on twitter API as user. */
    $content = $to->OAuthRequest('https://twitter.com/account/verify_credentials.xml', array(), 'GET');

    //$content = $to->OAuthRequest('https://twitter.com/statuses/update.xml', array('status' => 'twitter'), 'POST');
    //$content = $to->OAuthRequest('https://twitter.com/statuses/replies.xml', array(), 'POST');
	
	
	
    break;
}
?>

<?php 

	if(!isset($_GET["oauth_token"]))
	{
	 ?><?php echo $content; ?><?php
	}
	else
	{

	//response from twitter
	$aa=array();

	$xml = new SimpleXmlElement($content);

	foreach($xml->children() as $val)
	{
		$aa[]=$val;
	}

	//print_r($aa); exit;

	$username="TW".$aa[0];
	$firstname=$aa[1];
	    $img_url = $aa[5];


        //add the twitter information
	if($_SESSION["userrole"] == 1)
	{ 

			updateTWuser($_SESSION['oauth_access_token'],$_SESSION['oauth_access_token_secret'],$tok["user_id"],$firstname); 				
			url_redirect(DOCROOT."admin/social-media-account/");	
	} 
	
	//login function
	easyRegister($username,$firstname,"","",$img_url,2);

		/*
			$content1=$to->OAuthRequest('http://twitter.com/statuses/friends.xml?user_id='.$aa[0], array(), 'GET');
			$content2=$to->OAuthRequest('http://twitter.com/statuses/followers.xml?user_id='.$aa[0], array(), 'GET');
			$db = readDatabase($content1);
			$db1= readDatabase($content2);
			$_SESSION['friends']=$db;
			$_SESSION['followers']=$db1;
		*/

	$redirect_url = DOCROOT.'profile.html';
?>

			<script>
				window.location= '<?php echo $redirect_url; ?>';
			</script>

<?php
	}

?>

<?php
 class AminoAcid {
    var $id;  // aa name
    var $name;    // three letter symbol
    
    
    function AminoAcid ($aa) 
    {
        foreach ($aa as $k=>$v)
            $this->$k = $aa[$k];
    }
}

function readDatabase($filename) 
{
    // read the XML database of aminoacids

    $data = $filename;
    $parser = xml_parser_create();
    xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
    xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
    xml_parse_into_struct($parser, $data, $values, $tags);
    xml_parser_free($parser);

    // loop through the structures
    foreach ($tags as $key=>$val) {
        if ($key == "user") {
            $molranges = $val;
            // each contiguous pair of array entries are the 
            // lower and upper range for each molecule definition
            for ($i=0; $i < count($molranges); $i+=2) {
                $offset = $molranges[$i] + 1;
                $len = $molranges[$i + 1] - $offset;
                $tdb[] = parseMol(array_slice($values, $offset, $len));
            }
        } else {
            continue;
        }
    }
    return $tdb;
}

function parseMol($mvalues) 
{
    for ($i=0; $i < count($mvalues); $i++) {
        $mol[$mvalues[$i]["tag"]] = $mvalues[$i]["value"];
    }
    return $mol;
}
?>
<?php ob_flush(); ?>
