<?php 
/********************************************
 * @Created on March, 2011 * @Package: Ndotdeals unlimited v2.2
 * @Author: NDOT
 * @URL : http://www.NDOT.in
 ********************************************/
?>

<?php 

//category list
if(CATEGORY == 1)
{
	if(file_exists(DOCUMENT_ROOT.'/themes/'.CURRENT_THEME.'/common/category_list.php'))
	{
		require_once(DOCUMENT_ROOT.'/themes/'.CURRENT_THEME.'/common/category_list.php');
	}
	else
	{
		require_once(DOCUMENT_ROOT.'/themes/_base_theme/common/category_list.php');
	}

}

//side bar system/plugins//featured deals
if(FEATURED_DEAL == 1)
{
	if(file_exists(DOCUMENT_ROOT.'/themes/'.CURRENT_THEME.'/common/random_coupon.php'))
	{
		require_once(DOCUMENT_ROOT.'/themes/'.CURRENT_THEME.'/common/random_coupon.php');
	}
	else
	{
		require_once(DOCUMENT_ROOT.'/themes/_base_theme/common/random_coupon.php');
	}
	
}


//refer friends
require_once(DOCUMENT_ROOT.'/themes/'.CURRENT_THEME.'/common/refer_friends_side.php');
//newsletter
if(NEWSLETTER == 1)
{
	if(file_exists(DOCUMENT_ROOT.'/themes/'.CURRENT_THEME.'/common/subscriber.php'))
	{
		require_once(DOCUMENT_ROOT.'/themes/'.CURRENT_THEME.'/common/subscriber.php');
	}
	else
	{
		require_once(DOCUMENT_ROOT.'/themes/_base_theme/common/subscriber.php');
	}

}


//mobile subscribe
if(MOBILE_SUBSCRIPTION == 1)
{
	if(file_exists(DOCUMENT_ROOT.'/themes/'.CURRENT_THEME.'/common/sms_subscriber.php'))
	{
		require_once(DOCUMENT_ROOT.'/themes/'.CURRENT_THEME.'/common/sms_subscriber.php');
	}
	else
	{
		require_once(DOCUMENT_ROOT.'/themes/_base_theme/common/sms_subscriber.php');
	}
	
}


//fan page
if(FANPAGE == 1)
{
	if(file_exists(DOCUMENT_ROOT.'/themes/'.CURRENT_THEME.'/common/facebook_fanpage.php'))
	{
		require_once(DOCUMENT_ROOT.'/themes/'.CURRENT_THEME.'/common/facebook_fanpage.php');
	}
	else
	{
		require_once(DOCUMENT_ROOT.'/themes/_base_theme/common/facebook_fanpage.php');
	}
	
}

//Twitter search  list
if(TWEETS_AROUND_CITY == 1)
{
	if(file_exists(DOCUMENT_ROOT.'/themes/'.CURRENT_THEME.'/common/twitter_around.php'))
	{
		require_once(DOCUMENT_ROOT.'/themes/'.CURRENT_THEME.'/common/twitter_around.php');
	}
	else
	{
		require_once(DOCUMENT_ROOT.'/themes/_base_theme/common/twitter_around.php');
	}
	
}

?>
<div class="featured_business">
  <div class="great_top2">
    <h1><?php echo $language['feature_your_business'];?></h1>
  </div>
  <div class="featured_mid"> <a href="<?php echo DOCROOT;?>business.html"><img class="fl" src="<?php echo DOCROOT;?>themes/<?php echo CURRENT_THEME; ?>/images/feature.png" /></a>
   
  </div>
  <div class="featured_bottom"> <p><?php echo $language['feature_business_aboutus'];?><a style="font:bold 12px arial;color:#000;margin-left:5px;text-decoration:underline;" href="<?php echo DOCROOT;?>business.html"><?php echo $language['find_out_how'];?></a></p></div>
</div>
<!--<div class="visit_mobile">
  <div class="great_top">
    <h1><?php echo $language['visit_us_on_your_mobile'];?></h1>
  </div>
  <div class="visit_center"> <a class="visit_mid" href="<?php echo DOCROOT;?>access/mobile"></a> </div>
</div>-->
<div class="featured">
  <div class="great_top2">
    <h1><?php echo $language['featured_on'];?></h1>
  </div>
  <div class="great_center"> <img style="margin-left:10px;" class="fl" src="<?php echo DOCROOT;?>themes/<?php echo CURRENT_THEME; ?>/images/featured_mid.png" /></div>
  <div class="great_bottom">
 
  </div>
</div>
