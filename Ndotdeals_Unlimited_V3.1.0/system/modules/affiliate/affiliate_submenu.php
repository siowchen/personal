<?php
/********************************************
 * @Created on March, 2011 * @Package: Ndotdeals unlimited v2.2 
 * @Author: NDOT
 * @URL : http://www.ndot.in
 ********************************************/ 
$uri = end(explode("/",$_SERVER['REQUEST_URI']));
$uri1 = explode(".",$uri);
$uri2 = explode("&",$uri1[1]);
$uri3 = explode("=",$uri2[1]);
$uri4 = explode("?",$uri2[0]);
$my_coupons = $profile = $edit = $password = $referral_list = $api_client = $fund_request ='';

if($uri == "statistics.php" || $uri == "")
{
	$statistics = "profile_vscurr";
}
else if($uri == "payments.php")
{
	$payments = "profile_vscurr";
}
else if($uri == "commission-details.php" || $uri == "commission-details.php?type=approved" || $uri == "commission-details.php?type=pending" || $uri3[0] == "id")
{
	$commission = "profile_vscurr";
}
else if($uri == "edit-account.php")
{
	$account = "profile_vscurr";
}
else if($uri == "deals.php" || $uri1[0] == "deal-details")
{
	$deals = "profile_vscurr";
}

else
{
	$statistics = "profile_vscurr";
}
?>

<div class="profile_asubmenu">
<ul class="profile_asubmenu">
<li><a href="<?php echo DOCROOT;?>system/affiliate/statistics.php" title="Statistics" class="<?php echo $statistics; ?>">Statistics</a></li>
<li><a href="<?php echo DOCROOT;?>system/affiliate/payments.php" title="Payments" class="<?php echo $payments; ?>">Payments</a></li>
<li><a href="<?php echo DOCROOT;?>system/affiliate/commission-details.php" title="Commissions" class="<?php echo $commission; ?>">Commissions</a></li>
<li><a href="<?php echo DOCROOT;?>system/affiliate/edit-account.php" title="My Accounts" class="<?php echo $account; ?>" >My Accounts</a></li>
<li><a href="<?php echo DOCROOT;?>system/affiliate/deals.php" title="Deals" class="<?php echo $deals; ?>" >Deals</a></li>
<li><a href="<?php echo DOCROOT;?>system/affiliate/logout.php?action=logout" title="Logout" class="<?php echo $logout; ?>" >Logout</a></li>
</ul>
</div>
