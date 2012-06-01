<?php
/******************************************
* @Created on March, 2011 * @Package: Ndotdeals unlimited v2.2
* @Author: NDOT
* @URL : http://www.NDOT.in
********************************************/
?>
<script type="text/javascript">

var win2;
function fbconnect(docroot){

  win2 = window.open(docroot+'facebook-connect.html',null,'width=650,location=0,status=0,height=400');
  checkChild();  
    
}

function checkChild() {
	  if (win2.closed) {
		window.location.reload(true);
	  } else setTimeout("checkChild()",1);
}


</script>
<ul>
<li><a href="/" title="<?php echo $language['home']; ?>"><?php echo $language['home']; ?> </a></li>
<li><span class="right_arrow"></span></li>
<li><a href="javascript:;" title="<?php echo $language['referral']; ?>"><?php echo $language['referral']; ?></a></li>    
</ul>

<h1><?php //echo $page_title; ?></h1>


<?php
if($_SESSION['userid']!='')
{
?>						 
<div class="refer_content">
<?php
}
else{

$_SESSION["ref"] = DOCROOT.substr($_SERVER['REQUEST_URI'],1);
?>
<div class="referal_bg_sign">
<?php
}?>
	<p class="ref_desc"><?php echo $language['get']; ?> <?php echo CURRENCY;?><?php echo REF_AMOUNT;?> <?php echo $language['referral_flow']; ?></p>
	
	<div class="referal_head"><?php echo $language['refer_earn']; ?></div>

<?php
if($_SESSION['userid']!='')
{
	$userid = $_SESSION['userid'];
	$queryString = "SELECT * FROM coupons_users where userid='$userid'";
	$resultSet = mysql_query($queryString);
		if(mysql_num_rows($resultSet) > 0)
		{
			while($row = mysql_fetch_array($resultSet))
			{
				$referral_id = $row['referral_id'];
			}
		}	
?>                        
	    <script type="text/javascript">
		function SelectAll(id)
		{
			document.getElementById(id).focus();
			document.getElementById(id).select();
		}
		</script>


	    <div class="referal_right">
	    	<div class="referal_link"><?php echo $language['share_link']; ?></div>
	    	<input type="text" id="share_link" value="<?php echo DOCROOT.'ref.html?id='.$referral_id; ?>" onClick="SelectAll('share_link');" class="referal_text" />

	        <!--<a href="mailto:?body=<?php echo urlencode("Checkout daily deals & huge discounts on the coolest stuff in your city. ".DOCROOT."ref.html?id=".$referral_id);?>&subject=<?php echo urlencode("I think you will get best deals");?>" class="mail_it"><?php echo $language['mail_it']; ?></a>-->

	        <a href="mailto:?body=Checkout daily deals and huge discounts on the coolest stuff in your city<?php echo urlencode(DOCROOT.'ref.html?id='.$referral_id);?>&subject=I think you will get best deals" class="mail_it"><?php echo $language['mail_it']; ?></a>
			
	        <a href="http://www.facebook.com/share.php?u=<?php echo DOCROOT.'ref.html?id='.$referral_id; ?>&t=I think you will get best deals" title="<?php echo $language['share_fb']; ?>" class="share_it" target="_blank"><?php echo $language['share_fb']; ?></a>

	        <a href="http://twitter.com/share?url=<?php echo urlencode(DOCROOT."ref.html?id=".$referral_id);?>&text=<?php echo urlencode("I think you will get best deals");?>" title="<?php echo $language['share_tweet']; ?>" class="tweet_it" target="_blank"><?php echo $language['share_tweet']; ?></a>

	    </div>
		    			
<?php
}else{
?>


                      <div class="referal_right_logout">
					  
					  <p>
					  <a href="<?php echo DOCROOT;?>login.html" title="<?php echo $language['sign_in']; ?>"><?php echo $language['sign_in']; ?></a>
					   or <a href="<?php echo DOCROOT;?>registration.html" title="<?php echo $language['setup_account']; ?>"><?php echo $language['setup_account']; ?></a> <?php echo $language['refer_signin_text']; ?>
					   
					  <a href="javascript:;" onclick="return fbconnect('<?php echo DOCROOT; ?>');" title="facebook" class="ref_right_facebook">
						<img src="<?php echo DOCROOT;?>/themes/<?php echo CURRENT_THEME; ?>/images/bg_facebook.png" /></a>
						
					  </p>
		   </div> 
		   
<?php
}?>

	
</div>


