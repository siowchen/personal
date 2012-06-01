<?php 
/********************************************
 * @Created on March, 2011 * @Package: Ndotdeals unlimited v2.2
 * @Author: NDOT
 * @URL : http://www.NDOT.in
 ********************************************/
?>

<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'].'/system/includes/library.inc.php');
if(isset($_SESSION['defaultcityId']))
{
	$month = 2592000 + time();
	setcookie("defaultcityId", "");	
	setcookie("defaultcityId", $_SESSION['defaultcityId'], $month);	

}else
{
	if(isset($_COOKIE['defaultcityId']))
	{
		$_SESSION['defaultcityId'] = $_COOKIE['defaultcityId'];
	}
}
?>
<?php 
$reqUrl = $_SERVER["REQUEST_URI"];
//remove first slash from url
$docrootUrl = substr($reqUrl,1);
?>


<script type="text/javascript">
function citySelect(docroot,theme,id,city_name,city_url)
{
	window.location=docroot+'themes/'+theme+'/city/setcity.php?cityid='+id+'&cityname='+city_name+'&city_url='+city_url;
}
</script>

<?php
if(!empty($_SESSION['defaultcityId']))
{
?>
                <?php $result = get_cityname();
                        if(mysql_num_rows($result) > 0)
                        {?>

			<ul>
				<?php
                                while($row = mysql_fetch_array($result))
                                {
					$_SESSION['cityname'] = ucfirst(html_entity_decode($row['cityname'], ENT_QUOTES));
				?>
									

				  <li><a href="<?php echo DOCROOT;?>city.html"><?php echo ucfirst(html_entity_decode($row['cityname'], ENT_QUOTES)); ?><img src="<?php echo DOCROOT; ?>themes/<?php echo CURRENT_THEME; ?>/images/city_round.png" width="25" height="25" alt="go" border="0" align="right" /></a></li>


			<?php
                                }?>
		        </ul>

		<?php
                        }else{
			        ?><a href="<?php echo DOCROOT;?>city.html" class="">
				<span title="<?php echo $language['cities']; ?>" class="fontbold "><?php echo $language['cities']; ?></span></a>
			<?php
			}
}
else
{
?>
	<a href="<?php echo DOCROOT;?>city.html" class="">
		<span title="<?php echo $language['cities']; ?>" class="fontbold "><?php echo $language['cities']; ?></span>
	</a>
<?php
}?>

