<?php 
/********************************************
 * @Created on March, 2011 * @Package: Ndotdeals unlimited v2.2
 * @Author: NDOT
 * @URL : http://www.NDOT.in
 ********************************************/
?>
<?php 
	if($_SESSION["userid"])
	{ 
		//facebook connect
		if(CATEGORY == 1)
		{ ?>
			<div class="content_right1 mb-10">
			<?php 
			if(file_exists(DOCUMENT_ROOT.'/themes/'.CURRENT_THEME.'/common/favorite_category.php'))
			{ 
				require_once(DOCUMENT_ROOT.'/themes/'.CURRENT_THEME.'/common/favorite_category.php'); 

			}
			else
			{ 
				require_once(DOCUMENT_ROOT.'/themes/_base_theme/common/favorite_category.php'); 
			}
			?>
			</div>
		<?php 

		}
	}
	else
	{
		//facebook connect
		if(FACEBOOK_CONNECT == 1)
		{
			if(file_exists(DOCUMENT_ROOT.'/themes/'.CURRENT_THEME.'/common/right_facebook_connect.php'))
			{ 
				require_once(DOCUMENT_ROOT.'/themes/'.CURRENT_THEME.'/common/right_facebook_connect.php'); 

			}
			else
			{ 
				require_once(DOCUMENT_ROOT.'/themes/_base_theme/common/right_facebook_connect.php'); 
			}

		}

		//Twitter connect
		if(TWITTER_CONNECT == 1)
		{
			if(file_exists(DOCUMENT_ROOT.'/themes/'.CURRENT_THEME.'/common/right_twitter_connect.php'))
			{ 
				require_once(DOCUMENT_ROOT.'/themes/'.CURRENT_THEME.'/common/right_twitter_connect.php'); 

			}
			else
			{ 
				require_once(DOCUMENT_ROOT.'/themes/_base_theme/common/right_twitter_connect.php'); 
			}
		}
	} ?>


	<?php 
	//featured deals
	if(FEATURED_DEAL == 1)
	{
	?>
		<div class="content_right1 mb-10">
			<?php 
			if(file_exists(DOCUMENT_ROOT.'/themes/'.CURRENT_THEME.'/common/random_coupon.php'))
			{ 
				require_once(DOCUMENT_ROOT.'/themes/'.CURRENT_THEME.'/common/random_coupon.php'); 

			}
			else
			{ 
				require_once(DOCUMENT_ROOT.'/themes/_base_theme/common/random_coupon.php'); 
			}
			?>
		</div>
	<?php

	} 

	?>

	<?php 
	//Twitter Search  details
	if(TWEETS_AROUND_CITY == 1)
	{
	?>
		<div class="content_right1 mb-10">
			<?php 
			if(file_exists(DOCUMENT_ROOT.'/themes/'.CURRENT_THEME.'/common/twitter_around.php'))
			{ 
				require_once(DOCUMENT_ROOT.'/themes/'.CURRENT_THEME.'/common/twitter_around.php'); 

			}
			else
			{ 
				require_once(DOCUMENT_ROOT.'/themes/_base_theme/common/twitter_around.php'); 
			}
			?>
		</div>

	<?php

	} 

	?>
