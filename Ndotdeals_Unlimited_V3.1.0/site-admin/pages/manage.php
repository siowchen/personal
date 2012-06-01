<?php session_start();
is_login(DOCROOT."admin/login/"); //checking whether admin logged in or not.
$url_value = explode('/',$_SERVER['REQUEST_URI']);
require_once(DOCUMENT_ROOT.'/site-admin/pages/delete.php');
require_once(DOCUMENT_ROOT.'/site-admin/pages/update.php');
?>

<?php 
$arrType = $url_arr[2];
$arrType = explode('?',$arrType);

if($url_value[2]=='country' || $url_value[2]=='city' || $url_value[2]=='category' || $url_value[2]=='pages' || $url_arr[2]=="discussions" || $arrType[0]=="discussions")
{?>
	<script type="text/javascript">
	$(document).ready(function(){
	$(".toggleul_4").slideToggle();
	document.getElementById("left_menubutton_4").src = "<?php echo DOCROOT; ?>site-admin/images/minus_but.png";
	});
	</script>
<?php
}
?>

<script type="text/javascript">
function deletecountry(id)
{	
	var sure=confirm("Are you sure want to delete this Country and its Cities?");
	if(sure)
	{
		window.location='<?php echo DOCROOT; ?>site-admin/pages/delete.php?countryid='+id;
	}

}
function deletecity(id)
{	
	var sure=confirm("Are you sure want to delete this City?");
	if(sure)
	{
		window.location='<?php echo DOCROOT; ?>site-admin/pages/delete.php?cityid='+id;
	}

}

function deletecategory(id,categoryimage)
{	
	var sure=confirm("Are you sure want to delete this Category?");
	if(sure)
	{
		window.location='<?php echo DOCROOT; ?>site-admin/pages/delete.php?categoryid='+id;
	}

}
//delete page
function deletepage(id)
{	
	var sure=confirm("Are you sure want to delete it?");
	if(sure)
	{
		window.location='<?php echo DOCROOT; ?>site-admin/pages/delete.php?page_id='+id;
	}

}

//delete subscriber
function delete_subscriber(id)
{
	var sure=confirm("Are you sure want to delete it?");
	if(sure)
	{
		window.location='<?php echo DOCROOT; ?>site-admin/pages/delete.php?subscriber_id='+id;
	}
}

//delete mobile subscriber
function delete_mobile_subscriber(id)
{
	var sure=confirm("Are you sure want to delete it?");
	if(sure)
	{
		window.location='<?php echo DOCROOT; ?>site-admin/pages/delete.php?mobile_subscriber_id='+id;
	}
}


function updatecountry(status,id)
{
		window.location='<?php echo DOCROOT; ?>site-admin/pages/update.php?countryid='+id+'&status='+status;
}
function updatecity(status,id)
{	
		window.location='<?php echo DOCROOT; ?>site-admin/pages/update.php?cityid='+id+'&status='+status;
}
function updatecategory(status,id)
{	
		window.location='<?php echo DOCROOT; ?>site-admin/pages/update.php?categoryid='+id+'&status='+status;
}

function updatediscussion(status,id,refid)
{
		window.location='<?php echo DOCROOT; ?>site-admin/pages/update.php?discussionid='+id+'&status='+status+'&refid='+refid;
}
</script>


<span style="color:red" id="reportstatus"></span>

<?php

	if($url_arr[2]=="discussions" || $arrType[0]=="discussions")
	{

		if($_GET)
		{
			$url = $_SERVER['REQUEST_URI'];
			$arr = explode('=',$url); //print_r($arr);
			$arr2 = explode('?',$url); //print_r($arr2);
			$value = substr($arr2[1],0,5);
				if(!empty($arr[1]) && $value!='page=') {
					$val = explode('&page',$arr[1]); 
					$searchkey_txt = $val[0] = trim(str_replace('+',' ',$val[0]));
					$searchkey = htmlentities($val[0], ENT_QUOTES);
				}
		}
	?>

		<script type="text/javascript">
		/* validation */
		$(document).ready(function(){ $("#usrsearch").validate();});
		</script>

		<div class="fl ml10">
			<form method="get" name="usrsearch" id="usrsearch" action="" class="fl clr">
				<table>
				<tr>
				<td style="padding-top:8px;" valign="top"><?php echo $admin_language['search']; ?></td>
				<td>
				<input type="text" name="searchkey" class="required" title="<?php echo $admin_language['enteryoursearchkey']; ?>" value="<?php if(!empty($searchkey_txt)) { echo urldecode($searchkey_txt); } ?>" />
				</td>
				</tr>
				<tr>
				<td></td>
				<td><span class="color666 fwb"><?php echo $admin_language['search_bydisname']; ?></span></td>
				</tr>
				<tr>
				<td></td>
				<td><input type="submit" value="<?php echo $admin_language['submit']; ?>"/></td>
				</tr>
				</table>
			</form>
		</div>

<?php }
?>

<div class="deals_desc1">
<?php 

	if($url_arr[2]=="discussions"  || $arrType[0]=="discussions")
	{

	    $queryString = "select c.coupon_enddate,c.coupon_id,c.deal_url,c.coupon_status,d.status,d.discussion_id,c.coupon_name,u.username,u.userid,d.discussion_text,d.cdate from discussion d left join coupons_coupons c on c.coupon_id = d.deal_id left join coupons_users u on d.user_id = u.userid ";


		if(!empty($searchkey)) {
			$queryString .= " where (u.username like '%".$searchkey."%') or (c.coupon_name like '%".$searchkey."%') or (d.discussion_text like '%".$searchkey."%') "; 
		}

		$queryString .= " order by discussion_id desc";

		/*$pagination = new pagination();
		$pagination->createPaging($queryString,20);
		$resultSet = $pagination->resultpage;
		*/
		$pages = new Paginator;
		$pages->mid_range = 5; // Number of pages to display. Must be odd and > 3
		$pages->paginate($queryString);
		$resultSet = $pages->rspaginate;
			  
		  if(mysql_num_rows($resultSet)>0)
		  {
		?>
		          <table cellpadding="5" cellspacing="0" class="mt-10 coupon_report" border="0">
			      <tr class="fwb"><th>Deal Name</th><th>Username</th><th>Comment</th><th>Created Date</th><th>Manage</th>
			      </tr>
				  <?php 
			      while($noticia=mysql_fetch_array($resultSet))
			      {
				  ?>

					<tr>
					<td>


						  <?php if($noticia['coupon_status']=="A") {?>

							  <?php if($noticia['coupon_enddate'] > date("Y-m-d H:i:s")) { ?>
									<p class="ml10 fl clr"><a href="<?php echo DOCROOT;?>deals/<?php echo html_entity_decode($noticia["deal_url"]);?>_<?php echo $noticia["coupon_id"];?>.html" title="<?php echo html_entity_decode($noticia["coupon_name"], ENT_QUOTES);?>"><?php echo html_entity_decode($noticia["coupon_name"], ENT_QUOTES);?></a></p>
							 <?php } else { ?>
									<p class="ml10 fl clr"><a href="<?php echo DOCROOT;?>deals/past/<?php echo html_entity_decode($noticia["deal_url"]);?>_<?php echo $noticia["coupon_id"];?>.html" title="<?php echo html_entity_decode($noticia["coupon_name"], ENT_QUOTES);?>"><?php echo html_entity_decode($noticia["coupon_name"], ENT_QUOTES);?></a></p>
							 <?php } ?>

						   <?php } else if($noticia['coupon_status']=="C" || $noticia['coupon_status']=="D") { ?>

								<p class="ml10 fl clr"><a href="<?php echo DOCROOT;?>deals/past/<?php echo html_entity_decode($noticia["deal_url"]);?>_<?php echo $noticia["coupon_id"];?>.html" title="<?php echo html_entity_decode($noticia["coupon_name"], ENT_QUOTES);?>"><?php echo html_entity_decode($noticia["coupon_name"], ENT_QUOTES);?></a></p>

						   <?php } ?>


					</td>

					<td>
					<a href="<?php echo DOCROOT.'admin/user-profile/'.$noticia['userid']; ?>" title="<?php echo ucfirst(html_entity_decode($noticia['username'], ENT_QUOTES)); ?>"><?php echo ucfirst(html_entity_decode($noticia['username'], ENT_QUOTES)); ?></a>
					</td>

					<td>
					<?php echo ucfirst(nl2br(html_entity_decode($noticia['discussion_text'], ENT_QUOTES))); ?>
					</td>

					<td>
					<?php echo $noticia['cdate']; ?>
					</td>
		          
   					<td>

					<a href="<?php echo $docroot;?>edit/discussion/<?php echo $noticia['discussion_id'] ;?>/" class="edit_but" title="Edit"></a>
		          
					<?php
					  if($noticia["status"]=='D'){ ?>
					  
						  <a href="javascript:;" onclick="updatediscussion('A','<?php echo $noticia["discussion_id"]; ?>','<?php echo urlencode(DOCROOT.substr($_SERVER["REQUEST_URI"],1)); ?>')" class="unblock" title="Unblock"></a>

					<?php
					  }else{ ?>
					  
						  <a href="javascript:;" onclick="updatediscussion('D','<?php echo $noticia["discussion_id"]; ?>','<?php echo urlencode(DOCROOT.substr($_SERVER["REQUEST_URI"],1)); ?>')" class="block" title="Block"></a>

					  <?php
					  } ?>
		          		          	
					</td></tr>
			      <?php } ?>
					</table>
	    
			<?php if($pages->rspaginateTotal>20) { ?>
			<table border="0" width="650" class="mt-10" align="center" cellpadding="5">
				<tr>
				<td align="center">
                <div class="pagenation">
				<?php echo $pages->display_pages(); ?>
                </div>
				</td>
				</tr>
			</table>

		
		<?php
                   } 
		  }
		  else
		  {
		                echo '<p class="nodata">No Discussion Available</p>';
		  }
	
	}
	else
	{
		echo manage($url_arr[2]); 
	}
?>
</div>
