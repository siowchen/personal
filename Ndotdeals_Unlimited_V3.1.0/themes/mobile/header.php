<?php 
/********************************************
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
</script>

<?php
//print_r($url_arr);exit;
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
else
{
        $home = 'active';
}
?>


<div class="mobile_header"><div class="head_logo"><a href="<?php echo DOCROOT; ?>" title="<?php echo SITE_NAME; ?>"> <img align="right" style="margin-right:10px;" src="<?php echo DOCROOT; ?>themes/<?php echo CURRENT_THEME; ?>/images/logo.png" /></a></div>

	<div class="header_but_cont"><?php require_once(DOCUMENT_ROOT.'/'.$root_sidebar_path.'city/citylist.php'); ?>

</div>

	<div class="header_but_cont1" >


	   <?php if($_SESSION["userrole"]==1 || $_SESSION["userrole"]==2 || $_SESSION["userrole"]==3) {?>

            <a class="right"  href="<?php echo DOCROOT;?>" title="Home"><?php echo $language["home"]; ?></a> 
           
            <a class="right"  href="<?php echo DOCROOT;?>admin/profile/" title="<?php echo ucfirst($_SESSION["username"]);?>">
            <?php echo ucfirst($_SESSION["username"]);?></a>
           
            <a class="right"  href="<?php echo DOCROOT;?>admin/logout/" title="Logout"><?php echo $language["logout"]; ?></a> 

            <?php 
            }
            else {
		    if($_SESSION["userid"])
		    {
		    ?>
			    <a class="right"  href="<?php echo DOCROOT;?>" title="Home"><?php echo $language["home"]; ?></a> 
			   
			   <a class="right"  href="<?php echo DOCROOT;?>my-coupons.html" title="<?php echo ucfirst($_SESSION["username"]);?>"><?php echo $language["mysavings"]; ?> (<?php echo CURRENCY.$_SESSION["savedamt"]; ?>)</a>
			   

			   <a class="right"  href="<?php echo DOCROOT;?>profile.html" title="<?php echo ucfirst($_SESSION['username']);?>">
			    <?php
				if(strlen($_SESSION["username"]) > 6)
				{
				echo substr(ucfirst($_SESSION["username"]),0,6),'...';
				}
				else
				{
				echo ucfirst($_SESSION["username"]);
				}
			     ?>
			  </a>
			   
			    <a class="right"  href="<?php echo DOCROOT;?>logout.html" title="<?php echo $language["logout"]; ?>"><?php echo $language["logout"]; ?></a> 

		    <?php 
		    }
		    else
		    {
		    ?>
			    <a class="right"  href="<?php echo DOCROOT;?>" title="Home"><?php echo $language["home"]; ?></a> 
			    
			    <a class="right"  href="<?php echo DOCROOT;?>login.html" title="<?php echo $language["signin"]; ?>"><?php echo $language["signin"]; ?></a>
			   
			    <a class="right"  href="<?php echo DOCROOT;?>registration.html" title="<?php echo $language["signup"]; ?>"><?php echo $language["signup"]; ?></a> 
		    <?php 
		    } 
		} ?>


 

</div>

      <div class="header_timer">

	<?php //print_r($url_arr); 

	if($url_arr[1]=='deals' || $page_title == $language["home"]) { ?>
	
	  <div class="times" id="times"></div> 
		 
	<?php } else {
	?>

		<div class="city"><?php echo $page_title; ?></div> 

	<?php } ?>

      </div>

</div>

            


