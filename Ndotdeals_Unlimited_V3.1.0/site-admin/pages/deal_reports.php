<?php session_start();
is_login(DOCROOT."admin/login/"); //checking whether admin logged in or not.
require_once(DOCUMENT_ROOT.'/site-admin/pages/delete.php');
require_once(DOCUMENT_ROOT.'/site-admin/pages/update.php');

$type = $url_arr[4];
$type = explode('?',$type);
$url_arr[4] = $type = $type[0];

?>

<?php 
if($url_arr[4]=='all' || $url_arr[4]=='active' || $url_arr[4]=='closed' || $url_arr[4]=='rejected' || $url_arr[4]=='pending' || $url_arr[4]=='shopadmin')
{
?>
<script type="text/javascript">
$(document).ready(function(){
$(".toggleul_104").slideToggle();
document.getElementById("left_menubutton_104").src = "<?php echo DOCROOT; ?>site-admin/images/minus_but.png";
});
</script>
<?php
}
?>

<script type="text/javascript">
function deletecoupon(id,refid)
{	
	var sure=confirm("Are you sure want to delete this Coupon?");
	if(sure)
	{
		window.location='<?php echo DOCROOT; ?>site-admin/pages/delete.php?couponid='+id+'&refid='+refid;
	}

}

function forceclosecoupon(id,refid)
{	
	var sure=confirm("Are you sure want to close this Coupon?");
	if(sure)
	{
		window.location='<?php echo DOCROOT; ?>site-admin/pages/force_coupon_close.php?couponid='+id+'&refid='+refid;
	}

}

function updatecoupon(status,id,refid)
{		
	window.location='<?php echo DOCROOT; ?>site-admin/pages/update.php?couponid='+id+'&status='+status+'&refid='+refid;
}
</script>

<?php

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

<div style="width:765px;" class="fl ml10">
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
		<td><span class="color666 fwb"><?php echo $admin_language['search_bydealname']; ?></span></td>
		</tr>

		<tr>
		<td></td>
		<td><input type="submit" value="<?php echo $admin_language['submit']; ?>"/></td>
		</tr>
		</table>
	</form>
</div>

<div class="deals_desc1">      

<?php
	
        $user_role = $_SESSION["userrole"];

	//To get the admin user id
	//========================
	/* $couponcratedbyid =mysql_query("SELECT * FROM coupons_users u left join coupons_coupons c on c.coupon_id=u.userid left join coupons_shops sh on sh.shopid=u.userid where u.userid='".$_SESSION['userid']."' and u.user_role='$user_role'");
	
	if(mysql_num_rows($couponcratedbyid)>0)
            {
		while($row_cratedbyid = mysql_fetch_array($couponcratedbyid))
		{ 
			$ccratedbyid = $row_cratedbyid['created_by'];

		}
	    }
 */
	if($type == "all")
	{
		
		$queryString = "SELECT c.coupon_id, s.shopid,u.userid,c.coupon_enddate,(
		
		SELECT count( p.coupon_purchaseid )
		FROM coupons_purchase p
		WHERE p.couponid = c.coupon_id  and p.Coupon_amount_Status='T'
		) AS pcounts, u.firstname, u.lastname, c.coupon_id, c.coupon_name,c.deal_url, DATE_FORMAT( c.coupon_startdate, '%d %M %Y' ) AS startdate, DATE_FORMAT( c.coupon_enddate, '%d %M %Y' ) AS enddate, c.coupon_createdby,(
		if( LENGTH( concat( u.firstname, u.lastname ) ) =0, u.username, concat( u.firstname, u.lastname ) )
		) AS name,c.coupon_status,c.coupon_minuserlimit as minuserlimit,c.coupon_maxuserlimit as maxuserlimit
		,c.coupon_realvalue,c.coupon_value,c.coupon_image,force_coupon_closed FROM coupons_coupons c left join coupons_shops s on c.coupon_shop=s.shopid left join coupons_users u on u.user_shopid=s.shopid";
		
		//checking whether user is not admin
		
		if($user_role !=1)
		{
		     $queryString .= " where (u.userid='".$_SESSION['userid']."' or u.created_by='".$_SESSION['userid']."') or (coupon_createdby='".$_SESSION['userid']."')";

		}
		
		/* if($user_role == 2)
		{
		     $queryString .= " where c.coupon_createdby ='".$_SESSION['userid']."'";
		}*/

		if(!empty($searchkey))
		{
		        if($user_role == 1)
		        {
		                $queryString .= " where c.coupon_name like '%".$searchkey."%'";
		        }
		        else
		        {
		               $queryString .= " and c.coupon_name like '%".$searchkey."%'";
		        }
		}
		$queryString .= ' order by c.coupon_id desc';

	}
        else if($type == "active")
	{

		$queryString = "SELECT c.coupon_id, s.shopid,u.userid,c.coupon_enddate,(
		
		SELECT count( p.coupon_purchaseid )
		FROM coupons_purchase p
		WHERE p.couponid = c.coupon_id  and p.Coupon_amount_Status='T'
		) AS pcounts, u.firstname, u.lastname, c.coupon_id, c.coupon_name,c.deal_url, DATE_FORMAT( c.coupon_startdate, '%d %M %Y' ) AS startdate, DATE_FORMAT( c.coupon_enddate, '%d %M %Y' ) AS enddate, c.coupon_createdby,(
		if( LENGTH( concat( u.firstname, u.lastname ) ) =0, u.username, concat( u.firstname, u.lastname ) )
		) AS name,c.coupon_status,c.coupon_minuserlimit as minuserlimit,c.coupon_maxuserlimit as maxuserlimit
		,c.coupon_realvalue,c.coupon_value,c.coupon_image,force_coupon_closed FROM coupons_coupons c left join coupons_shops s on c.coupon_shop=s.shopid left join coupons_users u on u.user_shopid=s.shopid where c.coupon_status='A' and c.coupon_enddate >= now()";
		
		//checking whether user is not admin
		if($user_role !=1)
		{
		     $queryString .= " and (u.userid='".$_SESSION['userid']."' or u.created_by='".$_SESSION['userid']."') or (coupon_createdby='".$_SESSION['userid']."')";

		}

		if(!empty($searchkey)) {
		$queryString .= " and c.coupon_name like '%".$searchkey."%'";
		}

		$queryString .= ' order by c.coupon_id desc';

    
	}
        else if($type == "rejected")
	{
		$queryString = "SELECT c.coupon_id, s.shopid,u.userid,c.coupon_enddate,(
		
		SELECT count( p.coupon_purchaseid )
		FROM coupons_purchase p
		WHERE p.couponid = c.coupon_id  and p.Coupon_amount_Status='T'
		) AS pcounts, u.firstname, u.lastname, c.coupon_id, c.coupon_name,c.deal_url, DATE_FORMAT( c.coupon_startdate, '%d %M %Y' ) AS startdate, DATE_FORMAT( c.coupon_enddate, '%d %M %Y' ) AS enddate, c.coupon_createdby,(
		if( LENGTH( concat( u.firstname, u.lastname ) ) =0, u.username, concat( u.firstname, u.lastname ) )
		) AS name,c.coupon_status,c.coupon_minuserlimit as minuserlimit,c.coupon_maxuserlimit as maxuserlimit
		,c.coupon_realvalue,c.coupon_value,c.coupon_image,force_coupon_closed FROM coupons_coupons c left join coupons_shops s on c.coupon_shop=s.shopid left join coupons_users u on u.user_shopid=s.shopid where c.coupon_status='R'";
		
		//checking whether user is not admin
		if($user_role !=1)
		{
		     $queryString .= " and (u.userid='".$_SESSION['userid']."' or u.created_by='".$_SESSION['userid']."') or (coupon_createdby='".$_SESSION['userid']."')";

		}
		
		if(!empty($searchkey)) {
		$queryString .= " and c.coupon_name like '%".$searchkey."%'";
		}

		$queryString .= ' order by c.coupon_id desc';

    
	}
        else if($type == "pending")
	{
		$queryString = "SELECT c.coupon_id, s.shopid,u.userid,c.coupon_enddate,(
		
		SELECT count( p.coupon_purchaseid )
		FROM coupons_purchase p
		WHERE p.couponid = c.coupon_id  and p.Coupon_amount_Status='T'
		) AS pcounts, u.firstname, u.lastname, c.coupon_id, c.coupon_name,c.deal_url, DATE_FORMAT( c.coupon_startdate, '%d %M %Y' ) AS startdate, DATE_FORMAT( c.coupon_enddate, '%d %M %Y' ) AS enddate, c.coupon_createdby,(
		if( LENGTH( concat( u.firstname, u.lastname ) ) =0, u.username, concat( u.firstname, u.lastname ) )
		) AS name,c.coupon_status,c.coupon_minuserlimit as minuserlimit,c.coupon_maxuserlimit as maxuserlimit
		,c.coupon_realvalue,c.coupon_value,c.coupon_image,force_coupon_closed FROM coupons_coupons c left join coupons_shops s on c.coupon_shop=s.shopid left join coupons_users u on u.user_shopid=s.shopid where ((c.coupon_status='D' and c.coupon_enddate > now()) or c.coupon_startdate > now())";
		
		//checking whether user is not admin
		if($user_role !=1)
		{
		     $queryString .= " and (u.userid='".$_SESSION['userid']."' or u.created_by='".$_SESSION['userid']."') or (coupon_createdby='".$_SESSION['userid']."')";

		}
		
		if(!empty($searchkey)) {
		$queryString .= " and c.coupon_name like '%".$searchkey."%'";
		}

		$queryString .= ' order by c.coupon_id desc';

    
	}
    else if($type == "closed")
	{
		$queryString = "SELECT c.coupon_id, s.shopid,u.userid,c.coupon_enddate,(
		
		SELECT count( p.coupon_purchaseid )
		FROM coupons_purchase p
		WHERE p.couponid = c.coupon_id  and p.Coupon_amount_Status='T'
		) AS pcounts, u.firstname, u.lastname, c.coupon_id, c.coupon_name,c.deal_url, DATE_FORMAT( c.coupon_startdate, '%d %M %Y' ) AS startdate, DATE_FORMAT( c.coupon_enddate, '%d %M %Y' ) AS enddate, c.coupon_createdby,(
		if( LENGTH( concat( u.firstname, u.lastname ) ) =0, u.username, concat( u.firstname, u.lastname ) )
		) AS name,c.coupon_status,c.coupon_minuserlimit as minuserlimit,c.coupon_maxuserlimit as maxuserlimit
		,c.coupon_realvalue,c.coupon_value,c.coupon_image,force_coupon_closed FROM coupons_coupons c left join coupons_shops s on c.coupon_shop=s.shopid left join coupons_users u on u.user_shopid=s.shopid where (c.coupon_status='C' or c.coupon_enddate < now())";
		
		//checking whether user is not admin
		if($user_role !=1)
		{
		     $queryString .= " and (u.userid='".$_SESSION['userid']."' or u.created_by='".$_SESSION['userid']."') or (coupon_createdby='".$_SESSION['userid']."')";

		}
		
		if(!empty($searchkey)) {
		$queryString .= " and c.coupon_name like '%".$searchkey."%'";
		}

		$queryString .= ' order by c.coupon_id desc';

    
	}
	else if($type == "shopadmin")
	{
		$userid = $_SESSION['userid'];
		$queryString = "SELECT c.coupon_enddate,(
		
		SELECT count( p.coupon_purchaseid )
		FROM coupons_purchase p
		WHERE p.couponid = c.coupon_id  and p.Coupon_amount_Status='T'
		) AS pcounts, u.firstname, u.lastname, c.coupon_id, c.coupon_name,c.deal_url, DATE_FORMAT( c.coupon_startdate, '%d %M %Y' ) AS startdate, DATE_FORMAT( c.coupon_enddate, '%d %M %Y' ) AS enddate, c.coupon_createdby,(
		if( LENGTH( concat( u.firstname, u.lastname ) ) =0, u.username, concat( u.firstname, u.lastname ) )
		) AS name,c.coupon_status,c.coupon_minuserlimit as minuserlimit,c.coupon_maxuserlimit as maxuserlimit
		,c.coupon_realvalue,c.coupon_value,c.coupon_image,force_coupon_closed FROM coupons_coupons c left join coupons_users u  on u.userid=c.coupon_createdby where c.coupon_createdby =(select userid from coupons_users where created_by = '$userid' and user_role = 3)  order by c.coupon_id desc";
    
	}

		/*$pagination = new pagination();
		$pagination->createPaging($queryString,20);
		$resultSet = $pagination->resultpage;
                */
        $pages = new Paginator;
	$pages->mid_range = 5; // Number of pages to display. Must be odd and > 3
	$pages->paginate($queryString);
	$resultSet = $pages->rspaginate;
 
            
            if(mysql_num_rows($resultSet)>0)
            { ?>

			  <div class="fl p5 ml10">
			  <strong><?php echo $admin_language['note']; ?></strong> <?php echo $admin_language['a-active']; ?>,  <?php echo $admin_language['c-closed']; ?>, <?php echo $admin_language['d-deactive']; ?>
			 </div>
			 <br />
			 
			 <div style="width:100px;text-align:center;" class="fr p5 mr-8">
			 <a href="<?php echo DOCROOT;?>site-admin/pages/export.php?type=deals&format=<?php echo $type;?>&searchkey=<?php echo $searchkey; ?>" title="<?php echo $admin_language['exportall']; ?>"><?php echo $admin_language['exportall']; ?></a>
			 </div>

				 <table cellpadding="0" cellspacing="0"   class="coupon_report  mt20" border="1">
				 			 
				 <tr>
				 <th rowspan="2"><?php echo $admin_language['dealname']; ?></th>				
				 <th rowspan="2"><?php echo $admin_language['originalprice']; ?>(<?php echo CURRENCY;?>)</th> 
				 <th rowspan="2"><?php echo $admin_language['discountprice']; ?>(<?php echo CURRENCY;?>)</th> 
				 <th colspan="2"><?php echo $admin_language['quantity']; ?></th> 
				 <th colspan="2"><?php echo $admin_language['amount']; ?></th> 						 
				 <th rowspan="2"><?php echo $admin_language['commissionaccount']; ?>(<?php echo CURRENCY;?>)</th> 			
				 <th rowspan="2"><?php echo $admin_language['status']; ?></th>
				<?php if($_SESSION['userrole']=='1') { ?> 			
				 <th rowspan="2"><?php echo $admin_language['manage']; ?></th>
				<?php } ?> 			
				 </tr>

				 <tr>
				 <th><?php echo $admin_language['target']; ?></th>
				 <th><?php echo $admin_language['achieved']; ?></th>
				 <th><?php echo $admin_language['target']; ?></th>
				 <th><?php echo $admin_language['achieved']; ?></th>
				 </tr>
				
				<?php 
  
	                                $countrow = 0;
                while($noticia = mysql_fetch_array($resultSet))
                { 
	                              
	                                $countrow += 1;
	                                if($countrow % 2 == 1 ){
		                                echo '<tr style=" background:#EDEDED;">';
	                                }else{
		                                echo '<tr>';
	                                }
	                                 ?>
				   
				   <td><div style="width:200px;float:left;">
						<?php
						if(!empty($noticia["coupon_image"]))
						{ 
						        if(file_exists($_SERVER["DOCUMENT_ROOT"].'/'.$noticia["coupon_image"])) 
						        { 
						        ?>
						<div style="float:left;width:57px;"><a href="<?php echo $docroot.'admin/deal_report_view/'.$noticia['coupon_id'];?>">
							<img src="<?php echo DOCROOT; ?>system/plugins/imaging.php?width=50&height=50&cropratio=1:1&noimg=100&image=<?php echo urlencode(DOCROOT.$noticia["coupon_image"]); ?>" alt="<?php echo $noticia["coupon_name"];?>" title="<?php echo html_entity_decode($noticia["coupon_name"], ENT_QUOTES);?>" /></div>
						</a>
							<?php 
							}
							else
							{ ?>
							
							<a href="<?php echo $docroot.'admin/deal_report_view/'.$noticia['coupon_id'];?>">
							<img src="<?php echo DOCROOT; ?>system/plugins/imaging.php?width=50&height=50&cropratio=1:1&noimg=100&image=<?php echo urlencode(DOCROOT.'themes/'.CURRENT_THEME.'/images/no_image.jpg'); ?>" alt="<?php echo $noticia["coupon_name"];?>" title="<?php echo html_entity_decode($noticia["coupon_name"], ENT_QUOTES);?>" />
							</a>
							
							<?php
							 }
						}
						else
						{ ?>
							
							<a href="<?php echo $docroot.'admin/deal_report_view/'.$noticia['coupon_id'];?>">
							<img src="<?php echo DOCROOT; ?>system/plugins/imaging.php?width=50&height=50&cropratio=1:1&noimg=100&image=<?php echo urlencode(DOCROOT.'themes/'.CURRENT_THEME.'/images/no_image.jpg'); ?>" alt="<?php echo $noticia["coupon_name"];?>" title="<?php echo html_entity_decode($noticia["coupon_name"], ENT_QUOTES);?>" />
							</a>
							
						<?php }?>
							
					<div style="float:left;width:130px;margin-left:10px;"><a href="<?php echo $docroot.'admin/deal_report_view/'.$noticia['coupon_id'];?>">
				   <?php echo ucfirst(html_entity_decode($noticia['coupon_name'], ENT_QUOTES));?>
				   </a></div>

			  <?php if($noticia['coupon_status']=="A") {?>
                                  
				  <?php if($noticia['coupon_enddate'] > date("Y-m-d H:i:s")) { ?>
						<div style="float:left;clear:both;width:200px;text-align:center;"><p class="ml10 fl clr"><a href="<?php echo DOCROOT;?>deals/<?php echo html_entity_decode($noticia["deal_url"]);?>_<?php echo $noticia["coupon_id"];?>.html" title="<?php echo html_entity_decode($noticia["coupon_name"], ENT_QUOTES);?>"><?php echo $admin_language['previewinlivesite']; ?></a></p></div>
				 <?php } else { ?>
						<div style="float:left;clear:both;width:200px;text-align:center;"><p class="ml10 fl clr"><a href="<?php echo DOCROOT;?>deals/past/<?php echo html_entity_decode($noticia["deal_url"]);?>_<?php echo $noticia["coupon_id"];?>.html" title="<?php echo html_entity_decode($noticia["coupon_name"], ENT_QUOTES);?>"><?php echo $admin_language['previewinlivesite']; ?></a></p></div>
				 <?php } ?>

			   <?php } else if($noticia['coupon_status']=="C" || $noticia['coupon_status']=="D") { ?>

					<div style="float:left;clear:both;width:200px;text-align:center;"><p class="ml10 fl clr"><a href="<?php echo DOCROOT;?>deals/past/<?php echo html_entity_decode($noticia["deal_url"]);?>_<?php echo $noticia["coupon_id"];?>.html" title="<?php echo html_entity_decode($noticia["coupon_name"], ENT_QUOTES);?>"><?php echo $admin_language['previewinlivesite']; ?></a></p>

			   <?php } ?></div></div>

				   </td>
				   <td>
				   <?php echo $noticia['coupon_realvalue'];?>
				   </td>
				   <td>
				   <?php 
				   $discount = $noticia["coupon_value"];
				   echo $discount;
				   ?>
				   </td> 
				   <td>
				   <?php echo $noticia["minuserlimit"]; ?>
				   </td>
				   <td><?php echo $noticia['pcounts'];?></td>
				   
				   <td><?php echo ($noticia["coupon_value"]*$noticia["minuserlimit"]);?></td>
				   <td>
				   <?php 
				   $achieved = ($noticia["coupon_value"]*$noticia['pcounts']);
				   echo $achieved;
				   ?>
				   </td>
				   <td>
				   <?php 
				   $commission = ($achieved * (ADMIN_COMMISSION/100));
				   echo ($commission); ?></td>

				   <td><?php if(($type == 'closed') || ($noticia['coupon_enddate'] < date("Y-m-d H:i:s"))) { echo 'C'; } else { echo $noticia["coupon_status"];}?></td>

				<?php
				if($_SESSION['userrole']=='1') 
				{
				?>
				<td class="">
				<div class="fl">
					<?php		
					     if($noticia['force_coupon_closed'] != 'FC')
					     {
					     ?>                             
					    <span class="fl clr"><a href="<?php echo $docroot.'edit/coupon/'.$noticia['coupon_id'].'/';?>" class="edit_but" title="Edit"></a></span>
					    <?php
					     }
					    if($noticia['coupon_status']=="D")
					    {?>
						    <span class="fl clr"><a href="javascript:;" onclick="updatecoupon('A','<?php echo $noticia['coupon_id']; ?>','<?php echo urlencode(DOCROOT.substr($_SERVER['REQUEST_URI'],1)); ?>')" class="unblock" title="Unblock"></a></span>
					    <?php }
					    else { ?>
						    <span class="fl clr"><a href="javascript:;" onclick="updatecoupon('D','<?php echo $noticia['coupon_id']; ?>','<?php echo urlencode(DOCROOT.substr($_SERVER['REQUEST_URI'],1)); ?>')" class="block" title="Block"></a></span>
					    <?php } ?>

						    <span class="fl clr"><a href="javascript:;" onclick="deletecoupon('<?php echo $noticia['coupon_id']; ?>','<?php echo urlencode(DOCROOT.substr($_SERVER['REQUEST_URI'],1)); ?>')" class="delete" title="Delete"></a></span>


				<?php if($noticia['pcounts'] > 0 && ($noticia['pcounts'] < $noticia["minuserlimit"]) && $noticia['coupon_status']=='A' && $_SESSION['userrole']=='1') { ?>

						    <span class="fl clr"><a href="javascript:;" onclick="forceclosecoupon('<?php echo $noticia['coupon_id']; ?>','<?php echo urlencode(DOCROOT.substr($_SERVER['REQUEST_URI'],1)); ?>')" class="close" title="Force Close"></a></span>
						    
				<?php } ?>				    
				   
				</div>
				</td>
				<?php 
				}
				?>
		</tr>
    
        <?php } ?>
    
		</table>
    

		<?php 
		$result = mysql_query($queryString);
			if($pages->rspaginateTotal>20) { ?>

					<table border="0" width="650" align="center" style="border:0px;" cellpadding="5">
					<tr><td align="center" style="border:0px;">
                    	<div class="pagenation">
				        <?php echo $pages->display_pages(); ?>
                        </div>
					</td></tr>
					</table>

			<?php } ?>

		 <?php      
	   }
	   else
	   {
					  echo '<p class="nodata">'.$admin_language['no-deals'].'</p>';
	   }
    
?>
</div>


