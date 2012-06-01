<?php 
/******************asxaasd****************************
 * @Created on March, 2011 * @Package: Ndotdeals unlimited v2.2
 * @Author: NDOT
 * @URL : http://www.NDOT.in
 ********************************************/

 $lang_list = ($_SESSION['lang_aff'])?$_SESSION['lang_aff']:$lang_list;
 $theme_name = ($_SESSION['theme'])?$_SESSION['theme']:$theme_name;
 $default_city_id= ($_SESSION['city'] )?$_SESSION['city'] :$default_city_id;
 $root_dir_path = ($_SESSION['path_root'])?$_SESSION['path_root']:$root_dir_path;
 $root_sidebar_path = ($_SESSION['path_sideroot'])?$_SESSION['path_sideroot']:$root_sidebar_path;

 	$lang = $_SESSION["site_language"];
	if($lang)
	{
		include(DOCUMENT_ROOT."/system/language/".$lang.".php");
	}
	else
	{
		include(DOCUMENT_ROOT."/system/language/en.php");
	}
 
 
 unset($_SESSION['lang_aff']) ;
 unset($_SESSION['theme']);
 unset($_SESSION['city']);
 unset($_SESSION['path_root']);
 unset($_SESSION['path_sideroot']);
 
?>
<script type="text/javascript">
function changelang(lang)
{
	window.location = '<?php echo DOCROOT; ?>system/plugins/change_language.php?lang='+lang;
}

var win2;
function fbconnect1(docroot){

  win2 = window.open(docroot+'facebook-connect.html',null,'width=650,location=0,status=0,height=400');
  checkChild();  
    
}

function checkChild1() {
	  if (win2.closed) {
		window.location.reload(true);
	  } else setTimeout("checkChild1()",1);
}


</script>
<script type="text/javascript"> 
function searchfield_focus(obj)
{
obj.style.color=""
obj.style.fontStyle=""
if (obj.value=="Search w3schools.com")
	{
	obj.value=""
	}
}
 
function show_header(n)
{
document.getElementById('headerdiv1').style.display='none';
document.getElementById('headerdiv2').style.display='none';
document.getElementById('headerdiv3').style.display='none';
document.getElementById('arrowraquo1').style.background='';
document.getElementById('arrowraquo2').style.background='';
document.getElementById('arrowraquo3').style.background='';
document.getElementById('arrowraquo1').style.color='#333333';
document.getElementById('arrowraquo2').style.color='#333333';
document.getElementById('arrowraquo3').style.color='#333333';
document.getElementById('arrowhr1').style.background='#d4d4d4';
document.getElementById('arrowhr2').style.background='#d4d4d4';
document.getElementById('arrowhr3').style.background='#d4d4d4';
document.getElementById('arrowraquo' + n).style.background='#ff0000';
document.getElementById('arrowraquo'+ n).style.color='#ffffff';
document.getElementById('arrowhr' + n).style.background='#ff4800';
document.getElementById('headerdiv' + n).style.display='block';
}
/* 
var pageTracker = _gat._getTracker("UA-3855518-1");
pageTracker._initData();
pageTracker._trackPageview();*/

</script>
<?php
// get dealsnow category url
$cat_url = $_SERVER['REQUEST_URI'];
$split_url = explode('?', $cat_url);

if($url_arr[1] == 'today-deals.html')
{
        $today_deals = 'active';
}
else if($url_arr[1] == 'hot-deals.html')
{
        $hot_deals = 'active';
}
else if($url_arr[1] == 'past-deals.html' || $url_arr[2] == 'past')
{
        $past_deals = 'active';
}
else if($url_arr[1] == 'how-it-works.html')
{
        $how_it_works = 'active';
}
else if($url_arr[1] == 'contactus.html')
{
        $contactus = 'active';
}
else if($url_arr[1] == 'nearbymap.html')
{
        $nearbymap = 'active';
}
else if($url_arr[1] == 'dealsnow.html' || $url_arr[1] == 'dealsnow.html?'.$split_url[1])
{
        $dealsnow = 'active';
}
else if(!$url_arr[2])
{
        $home = 'active';
}
?>

<div class="header_image">
  <div class="middle_head">
    <div class="header_left">
     <h1><a href="<?php echo DOCROOT;?>" title="<?php echo SITE_NAME; ?>  ">
      <img class="fl" src="<?php echo DOCROOT;?>themes/<?php echo CURRENT_THEME; ?>/images/logo.png" /> </a> </h1>
     </div>
    <div class="header_mid">
      <div class="fl ml20">
        <?php //view more cities
        require_once(DOCUMENT_ROOT.'/'.$root_sidebar_path.'city/citylist.php'); ?>
      </div>
    </div>
    
    <?php
	if($_POST['headersubbx'] == '1')
	{
	
	$email = $_POST['email'];
	$city = $_SESSION['defaultcityId'];
	
	if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$",$email))
	{
		set_response_mes(-1,$language['invalid_email']);
		url_redirect($_SERVER['REQUEST_URI']);
	} 

	if(!empty($email))
	{
		$val = add_subscriber($email,$city);
		if($val)
		{

		$to = $email;
		$From = SITE_EMAIL;
		$subject = $email_variables['subscription_subject'];	
		$description = $email_variables['subscription_thankyou'];	
		$str = implode("",file(DOCUMENT_ROOT.'/themes/_base_theme/email/email_all.html'));

		$str = str_replace("SITEURL",$docroot,$str);
		$str = str_replace("SITELOGO",$logo,$str);
		$str = str_replace("RECEIVERNAME","Subscriber",$str);
		$str = str_replace("MESSAGE",ucfirst($description),$str);
		$str = str_replace("SITENAME",SITE_NAME,$str);

		$message = $str;

		$SMTP_USERNAME = SMTP_USERNAME;
		$SMTP_PASSWORD = SMTP_PASSWORD;
		$SMTP_HOST = SMTP_HOST;
		$SMTP_STATUS = SMTP_STATUS;	

				if($SMTP_STATUS==1)
				{
	
					include(DOCUMENT_ROOT."/system/modules/SMTP/smtp.php"); //mail send thru smtp
				}
				else
				{
					// To send HTML mail, the Content-type header must be set
					$headers  = 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
					// Additional headers
					$headers .= 'From: '.$From.'' . "\r\n";
					mail($to,$subject,$message,$headers);	
				}
				set_response_mes(1,$language['subscribe_success']);
				url_redirect($_SERVER['REQUEST_URI']);
		}
		else
		{
			set_response_mes(-1,$language['email_exist']);
			url_redirect($_SERVER['REQUEST_URI']);			
		}
	}
	else
	{
		set_response_mes(-1,$language['try_again']);
		url_redirect($_SERVER['REQUEST_URI']);
	}


}
?>
    <div class="header_rgt">
      <div class="header_right fl">
      
      	<!-- top right menu list -->
        <div class="top_right fl" >
          <ul>
            <?php if($_SESSION["userrole"]==1 || $_SESSION["userrole"]==2 || $_SESSION["userrole"]==3) {?>
            <li> <a href="<?php echo DOCROOT;?>admin/profile/" title="<?php echo ucfirst($_SESSION["username"]);?>"> <?php echo ucfirst($_SESSION["username"]);?></a> </li>
            <li>|</li>
            <li> <a href="<?php echo DOCROOT;?>admin/logout/" title="Logout"><?php echo $language["logout"]; ?></a> </li>
            <?php 
            }
            else {
            if($_SESSION["userid"])
            {
            ?>
            <li> <a href="<?php echo DOCROOT;?>my-coupons.html" title="<?php echo ucfirst($_SESSION["username"]);?>"><?php echo $language["mysavings"]; ?> (<?php echo CURRENCY.$_SESSION["savedamt"]; ?>)</a> </li>
            <li>|</li>
            <li> <a href="<?php echo DOCROOT;?>profile.html" title="<?php echo ucfirst($_SESSION["username"]);?>"> <?php echo ucfirst($_SESSION["username"]);?></a> </li>
            <li>|</li>
            <li> <a href="<?php echo DOCROOT;?>logout.html" title="<?php echo $language["logout"]; ?>"><?php echo $language["logout"]; ?></a> </li>
            <?php 
            }
            else
            {
            ?>
            <li> <a href="javascript:;" onclick="return fbconnect1('<?php echo DOCROOT; ?>');" title="Facebook Connect"> <img src="<?php echo DOCROOT;?>themes/<?php echo CURRENT_THEME; ?>/images/bg_fconnect.jpg"  /> </a> </li>
            <li> <a href="<?php echo DOCROOT;?>login.html" title="<?php echo $language["signin"]; ?>"><?php echo $language["signin"]; ?></a> </li>
            <li>|</li>
            <li> <a href="<?php echo DOCROOT;?>registration.html" title="<?php echo $language["signup"]; ?>"><?php echo $language["signup"]; ?></a> </li>
            <?php } 
        } ?>
          </ul>
        </div>
        <!-- top right menu list end -->
        
      </div>
    </div>
  </div>
  
  <!-- Menu list -->
  <div class="header_menu fl clr">
    <ul>
      <li  class="<?php if($home) echo 'men_act';?> ">
        <div class="menu_left"></div>
        <div class="menu_middle"> <a href="<?php echo DOCROOT;?>" title="<?php echo strtoupper($language['home']); ?>"><?php echo strtoupper($language["today"]); ?></a> </div>
        <div class="menu_right"></div>
        <div class="<?php  if($home){ echo '' ; } else { echo 'bg_downarrow'; } ?>"> </div>
      </li>

      <li  class="<?php if($hot_deals) echo 'men_act';?> ">
        <div class="menu_left"></div>
        <div class="menu_middle"> <a href="<?php echo DOCROOT;?>hot-deals.html" title="<?php echo strtoupper($language['hot']); ?>" ><?php echo strtoupper($language["hot"]); ?></a> </div>
        <div class="menu_right"></div>
        <div class="<?php  if($hot_deals){ echo 'bottom_active' ; } else { echo 'bg_downarrow'; } ?>"> </div>
      </li>
      <li  class="<?php if($past_deals) echo 'men_act';?> ">
        <div class="menu_left"></div>
        <div class="menu_middle"> <a href="<?php echo DOCROOT;?>past-deals.html" title="<?php echo strtoupper($language['past_deals']); ?>" ><?php echo strtoupper($language["past_deals"]); ?></a> </div>
        <div class="menu_right"></div>
        <div class="<?php  if($past_deals){ echo 'bottom_active' ; } else { echo 'bg_downarrow'; } ?>"> </div>
      </li>
      <li  class="<?php if($how_it_works) echo 'men_act';?> ">
        <div class="menu_left"></div>
        <div class="menu_middle"> <a href="<?php echo DOCROOT;?>how-it-works.html" title="<?php echo strtoupper($language['how_it_works']); ?>"><?php echo strtoupper($language["how_it_works"]); ?></a> </div>
        <div class="menu_right"></div>
        <div class="<?php  if($how_it_works){ echo 'bottom_active' ; } else { echo 'bg_downarrow'; } ?>"> </div>
      </li>
      <li  class="<?php if($nearbymap) echo 'men_act';?> ">
        <div class="menu_left"></div>
        <div class="menu_middle"> <a href="<?php echo DOCROOT;?>nearbymap.html" title="<?php echo strtoupper($language['nearbymap']); ?>" > <?php echo strtoupper($language["nearbymap"]); ?></a> </div>
        <div class="menu_right"></div>
        <div class="<?php  if($nearbymap){ echo 'bottom_active' ; } else { echo 'bg_downarrow'; } ?>"> </div>
      </li>
      <li  class="<?php if($dealsnow) echo 'men_act';?> ">
        <div class="menu_left"></div>
        <div class="menu_middle"> <a href="<?php echo DOCROOT;?>dealsnow.html" title="<?php echo strtoupper($language['dealsnow']); ?>" > <?php echo strtoupper($language['dealsnow']); ?></a> </div>
        <div class="menu_right"></div>
        <div class="<?php  if($dealsnow){ echo 'bottom_active' ; } else { echo 'bg_downarrow'; } ?>"> </div>
      </li>
    </ul>
  </div>
  <!-- menu list end -->
  
</div>
