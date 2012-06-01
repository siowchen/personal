<?php 
/********************************************
 * @Created on March, 2011 * @Package: Ndotdeals unlimited v2.2
 * @Author: NDOT
 * @URL : http://www.NDOT.in
 ********************************************/
?>
<?php //side bar system/plugins//featured deals
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

                     
