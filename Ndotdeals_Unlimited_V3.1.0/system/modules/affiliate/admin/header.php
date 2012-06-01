<?php
ob_start();
/********************************************
 * @Created on March, 2011 * @Package: Ndotdeals unlimited v2.2 
 * @Author: NDOT
 * @URL : http://www.ndot.in
 ********************************************/

require_once('../classes/XpAdmin.php');
require_once('util.php');
require_once('security.php');
require_once ($_SERVER['DOCUMENT_ROOT'].'/system/includes/library.inc.php');
$url = $_SERVER['REQUEST_URI'];
	         $aff_url=end(explode('/',$url));
	         $aff_url1=explode('.',$aff_url); 

$_SESSION['CURRENCY'] = CURRENCY;
if(preg_match("/index\.php/i", $_SERVER['PHP_SELF']))
{
	require_once('stat.php');
}
$admin_lang = $_SESSION["site_admin_language"];

if($admin_lang)
{
        include(DOCUMENT_ROOT."/system/language/admin_".$admin_lang.".php");
}
else
{

        include(DOCUMENT_ROOT."/system/language/admin_en.php");
}

?>

<?php 
  include($_SERVER["DOCUMENT_ROOT"]."/system/modules/affiliate/language/affiliate_en.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="description" content="<?php echo APP_DESC;?>" />
  <meta name="keywords" content="<?php echo APP_KEYWORDS;?>" />

  <title><?php echo ucfirst(str_replace('-',' ',$aff_url1[0])); ?> | <?php echo APP_NAME;?> </title>
  <?php 
	if($admin_lang)
	{ ?>
			  <link rel="stylesheet" type="text/css" href="<?php echo DOCROOT; ?>site-admin/css/admin_<?php echo $admin_lang;?>_style.css" />
	<?php 
	}
	else
	{
	?>
		<link rel="stylesheet" type="text/css" href="<?php echo DOCROOT; ?>site-admin/css/admin_en_style.css" />
	<?php } ?>
  <link rel="shortcut icon" href="<?php echo DOCROOT;?>site-admin/images/favicon.jpg" type="image/x-icon" />  
  <script type="text/javascript" src="<?php echo DOCROOT; ?>site-admin/scripts/jquery.js" /></script>
  <script type="text/javascript" src="<?php echo DOCROOT; ?>site-admin/scripts/jquery.validate.js" /></script>
  <script type="text/javascript" src="<?php echo DOCROOT; ?>site-admin/scripts/common.js" /></script>
	
	
	<script type="text/javascript" src="js/tooltip.js"></script>
	<script type="text/javascript" src="js/dbx.js"></script>	
	<script type="text/javascript" src="js/functions.js"></script>	
	<script type="text/javascript" src="../includes/js/xp.javascript.js"></script>

	<script type="text/javascript" src="js/JSCookMenu/JSCookMenu.js"></script>
	<script type="text/javascript" src="js/JSCookMenu/ThemeOffice2003/theme.js"></script>
	<link rel="stylesheet" href="js/JSCookMenu/ThemeOffice2003/theme.css" type="text/css" />	
	<!--[if IE]>
		<link rel="stylesheet" href="css/iehack.css" type="text/css" />
	<![endif]-->
<?php
if(preg_match("/index\.php/i", $_SERVER['PHP_SELF']))
{?>	
	<link rel="stylesheet" type="text/css" media="screen" href="js/jsgraph/canvaschart.css" />
	<script type="text/javascript" src="js/jsgraph/excanvas.js"></script>
    <script type="text/javascript" src="js/jsgraph/wz_jsgraphics.js"></script>
	<script type="text/javascript" src="js/jsgraph/chart.js"></script>
	<script type="text/javascript" src="js/jsgraph/canvaschartpainter.js"></script>
	<script type="text/javascript" src="js/jsgraph/jgchartpainter.js"></script>
	<script type="text/javascript">
	function chartShow() {
		var c1 = new Chart(document.getElementById('chart1'));
		c1.setDefaultType(CHART_LINE);
		c1.setGridDensity(<?php echo count($salesDate)+2;?>, <?php echo (max($salesNum)>20? 20 : max($salesNum)+1); ?>);
		c1.setHorizontalLabels(['','<?php echo implode("', '",$salesDate)?>','']);
		c1.setShowLegend(false);
		c1.add('Sales', '#8080FF', [0, <?php echo "'".implode("', '",$salesNum)."'"; ?>,0]);
		<?php
		if(array_sum($salesNum)==0)
		{
			?>c1.add('', '#FFFFFF', ['1', <?php echo "'".implode("', '",$salesNum)."'"; ?>,'0']);
			<?php
		}
		?>
		c1.draw();

		var c2 = new Chart(document.getElementById('chart2'));
		c2.setDefaultType(CHART_LINE);
		c2.setGridDensity(<?php echo count($trackingDate)+2;?>,<?php echo (max($trackingNum)>20? 20 : max($trackingNum)+1); ?>);
		c2.setHorizontalLabels(['','<?php echo implode("', '",$trackingDate)?>','']);
		c2.setShowLegend(false);
		c2.add('Tracking', '#FF00FF', [0, <?php echo implode(", ",$trackingNum)?>,0]);
		<?php
		if(array_sum($trackingNum)==0)
		{
			?>c2.add('', '#FFFFFF', ['1', <?php echo implode(", ",$trackingNum)?>,'0']);
			<?php
		}
		?>
		c2.draw();
	}
	</script>
<?php
}?>	
</head>

<body <?php if(preg_match("/index.php/i", $_SERVER['PHP_SELF'])){?>onload="chartShow();"<?php }?>>

<div class="container_outer ">

<div class="header">

	<div class="header_in">
	
		<div class="fl">
		<a href="<?php echo DOCROOT; ?>" target="_blank" title="<?php echo SITE_NAME;?>" class="logo">
		<img src="<?php echo DOCROOT; ?>site-admin/images/logo.png" alt="<?php echo SITE_NAME;?>" /></a>
		</div>
		
		<?php if($_SESSION["userid"]) { ?>
		<div class="fr live_link">
			<div class="go_lft fl"></div>
            <a href="<?php echo DOCROOT; ?>" target="_blank" title="<?php echo SITE_NAME;?>" class="fl">
		<?php echo $admin_language['gotolive']; ?>
		</a>
        <div class="go_rgt fl"></div>
		</div>   
			
			<!-- coupon code valdate -->
			<?php if($_SESSION["userrole"] == 3) { ?>
			<div class="fr live_link mr-10">
				<div class="go_lft fl"></div>
				<a href="<?php echo DOCROOT; ?>admin/couponvalidate"  title="<?php echo $admin_language['validate_coupon_code']; ?>" class="fl">
			<?php echo $admin_language['validate_coupon_code']; ?>
			</a>
			<div class="go_rgt fl"></div>
			</div> 
			<?php } ?>  
		
		<?php } ?>
	
	</div> 
	
</div>

<div class="container ">
		<?php
			success_mes(); //display success message
			failed_mes();  //display failure message
		?>
<div class="menu">
        <?php include(DOCUMENT_ROOT."/site-admin/pages/admin_left.php");?>
        </div>
        

        <div class="container_rgt ">
        
        	<div class="container_rgt_head"><h1><?php echo ucfirst(str_replace('-',' ',$aff_url1[0])); ?></h1>
            
            </div>
            
            
             <div class="container_content ">

		  	<div class="bread_crumb">
				<a href="<?php echo DOCROOT; ?>admin/profile/" title="Home">Home <span class="fwn">&#155;&#155;</span></a>
				<p><?php echo ucfirst(str_replace('-',' ',$aff_url1[0])); ?></p>
		          </div>
		          
		  	<!-- TOOLBAR STARTS-->

	<table width="99%" class="menubar" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<!--<td width="40%">
			<h2 style="color: #5F5435;"><?php echo $gDesc;?></h2>
		</td>-->
		<td  align="right">

		<?php print_toolbar($buttons);?>
		
		</td>
	</tr>
	</table>
		
	<!-- TOOLBAR ENDS -->

		
	<!-- TOOLBAR ENDS -->
		
<div class="cont_container mt15 ">

		          <div class="content_top "><div class="top_left"></div><div class="top_center"></div><div class="top_rgt"></div></div>

		          <div class="content_middle ">
	<?php ob_start();
	if(preg_match("/index.php/i", $_SERVER['PHP_SELF']))
	{
		$getNumAccounts = $gXpAdmin->getNumAccounts(1);
		$getNumCommissions = $gXpAdmin->getNumCommissions(1);
	?>
	<strong><?php echo $gXpLang['date_today']; ?> :</strong> <?php echo date('M d, Y')?><br /><br />
	<strong><?php echo $gXpLang['pending_approval_accounts']; ?> :</strong> <?php if($getNumAccounts>0){ ?><a href="approval-accounts.php"><?php } echo $getNumAccounts; if($getNumAccounts>0){ ?></a><?php } ?><br /><br />
	<strong><?php echo $gXpLang['pending_approval_commissions']; ?> :</strong> <?php if($getNumCommissions>0){ ?><a href="commissions.php"><?php } echo $getNumCommissions; if($getNumCommissions>0){ ?></a><?php } ?><br /><br />
	<br />
	<strong style="color:#335B92"><?php echo $gXpLang['last_days_commission']; ?> :</strong><br />
	<div id="chart1" class="chart" style="height: 200px; display:block;"></div><br /><br />
	<strong style="color:#335B92"><?php echo $gXpLang['last_days_traffic']; ?> :</strong><br />
	<div id="chart2" class="chart" style="height: 200px; display:block;"></div><br />
	<?php
	}?>
	
