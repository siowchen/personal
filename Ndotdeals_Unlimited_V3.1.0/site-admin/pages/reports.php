<?php session_start();
is_login(DOCROOT."admin/login/"); //checking whether admin logged in or not.
require_once(DOCUMENT_ROOT.'/site-admin/pages/delete.php');
require_once(DOCUMENT_ROOT.'/site-admin/pages/update.php');

$type = $url_arr[3];
$type = explode('?',$type);
$url_arr[3] = $type = $type[0];

?>

<?php 
if($url_arr[3]=='shopadmin' || $url_arr[3]=='shops')
{?>
	<script type="text/javascript">
	$(document).ready(function(){
	$(".toggleul_99").slideToggle();
	document.getElementById("left_menubutton_99").src = "<?php echo DOCROOT; ?>site-admin/images/minus_but.png";
	});
	</script>
<?php
}
else if($url_arr[3]=='citymgr')
{
?>
	<script type="text/javascript">
	$(document).ready(function(){
	$(".toggleul_103").slideToggle();
	document.getElementById("left_menubutton_103").src = "<?php echo DOCROOT; ?>site-admin/images/minus_but.png";
	});
	</script>
<?php
}
else if($url_arr[3]=='all' || $url_arr[3]=='admin' || $url_arr[3]=='fb_users' || $url_arr[3]=='tw_users' || $url_arr[3]=='general')
{
?>
	<script type="text/javascript">
	$(document).ready(function(){
	$(".toggleul_101").slideToggle();
	document.getElementById("left_menubutton_101").src = "<?php echo DOCROOT; ?>site-admin/images/minus_but.png";
	});
	</script>
<?php
}
?>

<script type="text/javascript">
function deleteuser(id,refid)
{	
	var sure=confirm("Are you sure want to delete this User?");
	if(sure)
	{
		window.location='<?php echo DOCROOT; ?>site-admin/pages/delete.php?userid='+id+'&refid='+refid;
	}

}

function updateuser(status,id,refid)
{
		window.location='<?php echo DOCROOT; ?>site-admin/pages/update.php?userid='+id+'&status='+status+'&refid='+refid;
}

function deleteshop(id,refid)
{	
	var sure=confirm("Are you sure want to delete this Shop?");
	if(sure)
	{
		window.location='<?php echo DOCROOT; ?>site-admin/pages/delete.php?shopid='+id+'&refid='+refid;
	}

}

function updateshop(status,id,refid)
{
		window.location='<?php echo DOCROOT; ?>site-admin/pages/update.php?shopid='+id+'&status='+status+'&refid='+refid;
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
				$search_emailkey = addslashes(urldecode($val[0]));
				$searchkey = htmlentities(addslashes(urldecode($val[0])), ENT_QUOTES);
			}
	}
?>

<script type="text/javascript">
/* validation */
$(document).ready(function(){ $("#usrsearch").validate();});
</script>

<div style="width:779px;" class="fl ml10">
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
		<td><span class="color666 fwb"><?php if($url_arr[3]=='shopadmin') { echo $admin_language['search_bymerchantusr']; } else { echo $admin_language['search_byctyusr']; } ?></span></td>
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
	if($type == "all")
	{
	    $queryString = "select u.referral_earned_amount,u.login_type,u.userid,u.username,u.firstname,u.lastname,u.email,u.mobile,u.user_role,r.role_name,u.created_by,u.user_status,(select sum(AMT) from transaction_details where transaction_details.USERID = u.userid) as purchased_amt
	      from coupons_users u,coupons_roles r where r.roleid=u.user_role and u.user_status in ('A','D') and user_role != 1 ";

		if(!empty($searchkey)) {
			$queryString .=	"and (u.email like '%".$search_emailkey."%' or u.username like '%".$searchkey."%')"; }

	}
	else if($type == "admin")
	{
	    $queryString = "select u.referral_earned_amount,u.login_type,u.userid,u.username,u.firstname,u.lastname,u.email,u.mobile,u.user_role,r.role_name,u.created_by,u.user_status,(select sum(AMT) from transaction_details where transaction_details.USERID = u.userid) as purchased_amt
	      from coupons_users u,coupons_roles r where r.roleid=u.user_role and u.user_status in ('A','D') and user_role=1 ";

		if(!empty($searchkey)) {
			$queryString .=	"and (u.email like '%".$search_emailkey."%' or u.username like '%".$searchkey."%')"; }

	}
	else if($type == "general")
	{
	    $queryString = "select u.referral_earned_amount,u.login_type,u.userid,u.username,u.firstname,u.lastname,u.email,u.mobile,u.user_role,r.role_name,u.created_by,u.user_status,(select sum(AMT) from transaction_details where transaction_details.USERID = u.userid) as purchased_amt
	      from coupons_users u,coupons_roles r where r.roleid=u.user_role and u.user_status in ('A','D') and u.user_role = '4' ";

		if(!empty($searchkey)) {
			$queryString .=	"and (u.email like '%".$search_emailkey."%' or u.username like '%".$searchkey."%')"; }

	}
	else if($type == "fb_users")
	{
	    $queryString = "select u.referral_earned_amount,u.login_type,u.userid,u.username,u.firstname,u.lastname,u.email,u.mobile,u.user_role,r.role_name,u.created_by,u.user_status,(select sum(AMT) from transaction_details where transaction_details.USERID = u.userid) as purchased_amt
	      from coupons_users u,coupons_roles r where r.roleid=u.user_role and u.user_status in ('A','D') and login_type=1 ";

		if(!empty($searchkey)) {
			$queryString .=	"and (u.email like '%".$search_emailkey."%' or u.username like '%".$searchkey."%')"; }

	}
	else if($type == "tw_users")
	{
	    $queryString = "select u.referral_earned_amount,u.login_type,u.userid,u.username,u.firstname,u.lastname,u.email,u.mobile,u.user_role,r.role_name,u.created_by,u.user_status,(select sum(AMT) from transaction_details where transaction_details.USERID = u.userid) as purchased_amt
	      from coupons_users u,coupons_roles r where r.roleid=u.user_role and u.user_status in ('A','D') and login_type=2 ";

		if(!empty($searchkey)) {
			$queryString .=	"and (u.email like '%".$search_emailkey."%' or u.username like '%".$searchkey."%')"; }

	}
	else if($type == "shopadmin")
	{
	    if($_SESSION['userrole'] == '1')
	    {
                
		$queryString = "select s.shop_status as status, s.shopid,u.referral_earned_amount,s.shopname,s.shop_address,u.login_type,u.userid,u.username,u.firstname,u.lastname,u.email,u.mobile,u.user_role,r.role_name,u.created_by,u.user_status
		from coupons_users u,coupons_roles r,coupons_shops s where r.roleid=u.user_role and u.user_status in ('A','D') and user_role=3 and s.shopid=u.user_shopid";

	    }
	    else if($_SESSION['userrole'] == '2')
	    {
	        $userid = $_SESSION['userid'];
		$queryString = "select s.shop_status as status, s.shopid,u.referral_earned_amount,s.shopname,s.shop_address,u.login_type,u.userid,u.username,u.firstname,u.lastname,u.email,u.mobile,u.user_role,r.role_name,u.created_by,u.user_status
		from coupons_users u,coupons_roles r,coupons_shops s where r.roleid=u.user_role and u.user_status in ('A','D') and user_role=3 and s.shopid=u.user_shopid and u.created_by='$userid'";

	    }

		if(!empty($searchkey)) {
			$queryString .=	" and (u.email like '%".$search_emailkey."%' or u.username like '%".$searchkey."%' or s.shopname like '%".$searchkey."%' or s.shop_address like '%".$searchkey."%')"; }

	}
	else if($type == "citymgr")
	{
	    $queryString = "select u.referral_earned_amount,u.login_type,u.userid,u.username,u.firstname,u.lastname,u.email,u.mobile,u.user_role,r.role_name,u.created_by,u.user_status
	      from coupons_users u,coupons_roles r where r.roleid=u.user_role and u.user_status in ('A','D') and user_role=2";

		if(!empty($searchkey)) {
			$queryString .=	" and (u.email like '%".$search_emailkey."%' or u.username like '%".$searchkey."%')"; }

	}
	else if($type == "shops")
	{
		$cityid = $_SESSION['city'];
		$queryString = "SELECT *, DATE_FORMAT('shop_createddate', '%D %b %y' ) AS cdate ,s.shop_status as status
		FROM coupons_shops s
		LEFT JOIN coupons_users ON shop_createdby = userid
		LEFT JOIN coupons_country ON countryid = shop_country
		LEFT JOIN coupons_cities ON cityid = shop_city
		WHERE shop_status in ('A','D')";

		if($_SESSION['userrole']==2)
			$queryString .=	" AND shop_city = '$cityid'";
	}

//echo $queryString;

	$pages = new Paginator;
	$pages->mid_range = 5; // Number of pages to display. Must be odd and > 3
	$pages->paginate($queryString);
	$resultSet = $pages->rspaginate;

	if($type == "shops")
	{

            if(mysql_num_rows($resultSet)>0)
			{
					echo '<table cellpadding="0" cellspacing="0" class="coupon_report">';
					echo '<tr class="fwb"><td>Shop Name</td><td>Created Date</td>';
			
					if( $_SESSION['userrole']=='1') {
						echo '<td>City</td><td>Country</td>';
					}
					
					if($_SESSION['userrole']=='2' || $_SESSION['userrole']=='1') {
						echo '<td>&nbsp;</td>';
					}
					echo '</tr>';
			
							while($noticia=mysql_fetch_array($resultSet))
							{ 
								echo '<tr><td>'.ucfirst(html_entity_decode($noticia['shopname'], ENT_QUOTES)).'</td><td>'.$noticia['shop_createddate'].'</td>';
			
								if( $_SESSION['userrole']=='1') {
								echo '<td>'.ucfirst(html_entity_decode($noticia['cityname'], ENT_QUOTES)).'</td><td>'.ucfirst(html_entity_decode($noticia['countryname'], ENT_QUOTES)).'</td>';
								}
			
								if($_SESSION['userrole']=='2' || $_SESSION['userrole']=='1') {
								echo '<td><a href="'.$docroot.'edit/shop/'.$noticia['shopid'].'/" class="edit_but" title="Edit"></a>';
			
			
								if($noticia['status']=="D")
								{?>
			
									<a href="javascript:;" onclick="updateshop('A','<?php echo $noticia["shopid"];?>','<?php echo urlencode(DOCROOT.substr($_SERVER["REQUEST_URI"],1)); ?>');" class="unblock" title="<?php echo $admin_language['unblock']; ?>"></a>
			
								<?php }else{ ?>
			
									<a href="javascript:;" onclick="updateshop('D','<?php echo $noticia["shopid"];?>','<?php echo urlencode(DOCROOT.substr($_SERVER["REQUEST_URI"],1)); ?>');" class="block" title="<?php echo $admin_language['block']; ?>"></a>
			
							   <?php } ?>
			
										<a href="javascript:;" onclick="deleteshop('<?php echo $noticia["shopid"];?>','<?php echo urlencode(DOCROOT.substr($_SERVER["REQUEST_URI"],1)); ?>');" class="delete" title="<?php echo $admin_language['delete']; ?>"></a></td>                    
								
								<?php }
			
								echo '</tr>';
				
							}
									echo '</table>';
				         if($pages->rspaginateTotal>20) {
					echo '<table border="0" width="400" align="center">';
					echo '<tr><td align="center">';
					echo $pages->display_pages();
					echo '</td></tr>';
					echo '</table>';
					}
			}
               
            else
            {
                          echo '<p class="nodata">'.$admin_language['nodata'].'</p>';
            }

	}
	else //else part starts here
	{	

            
            if(mysql_num_rows($resultSet)>0)
            { 
					?>
					 <div class="fr p5 mr-8">
			 <a href="<?php echo DOCROOT;?>site-admin/pages/export.php?type=users&format=<?php echo $type;?>&searchkey=<?php echo $searchkey; ?>" title="<?php echo $admin_language['exportall']; ?>"><?php echo $admin_language['exportall']; ?></a>
			 </div>
			 
					<?php 
                echo '<fieldset class="field1" style="margin-left:10px;">';         
                echo '<legend class="legend1">'.$admin_language['user_details'].'</legend>';
		echo '<table cellpadding="0" cellspacing="0" class="inner_table">';
		echo '<tr class="fwb"><td>'.$admin_language['username'].'</td>';

		if($type == "shopadmin") {
		echo '<td>'.$admin_language['shopdetails'].'</td>';
		}

		echo '<td>'.$admin_language['email'].'</td><td>'.$admin_language['mobileno'].'</td>';

		if($type != "shopadmin" && $type != "citymgr") {
					echo '<td>'.$admin_language['purchasedamount'].'('.CURRENCY.')</td>';
		} 
                if($type != "shopadmin" && $type != "citymgr") {
		        echo '<td>'.$admin_language['referalamount'].' ('.CURRENCY.')</td>';
		}
		echo '<td width="15%" >'.$admin_language['manage'].'</td></tr>';

			while($noticia=mysql_fetch_array($resultSet))
			{ 

				echo '<tr><td>';
				
				if($noticia['login_type']==1 || $noticia['login_type']==2)
				{
					?><a href="<?php echo DOCROOT; ?>admin/user-profile/<?php echo $noticia['userid']?>"><?php echo ucfirst(html_entity_decode($noticia['username'], ENT_QUOTES));	?></a><?php			
				}
				else
				{
					?><a href="<?php echo DOCROOT; ?>admin/user-profile/<?php echo $noticia['userid']?>"><?php echo ucfirst(html_entity_decode($noticia['username'], ENT_QUOTES));	?></a><?php
				}
				
				echo '</td>';


				if($type == "shopadmin") {
					echo '<td>';
					echo ucfirst(html_entity_decode($noticia['shopname'], ENT_QUOTES)).',<br/>';	
					echo ucfirst(html_entity_decode($noticia['shop_address'], ENT_QUOTES));
					echo '</td>';
				}


				if(!empty($noticia['email'])) {
					echo '<td><a href="mailto:'.html_entity_decode($noticia['email'], ENT_QUOTES).'" title="Email">'.html_entity_decode($noticia['email'], ENT_QUOTES).'</a></td>'; 
				}
				else {
					echo '<td>-</td>';
				}

				if(!empty($noticia['mobile'])) {
					echo '<td>'.html_entity_decode($noticia['mobile'], ENT_QUOTES).'</td>';
				}
				else {
					echo '<td>-</td>';
				}
					if($type != "shopadmin" && $type != "citymgr") {
						echo '<td>'.round($noticia['purchased_amt'],2).'</td>';
					}
                                        if($type != "shopadmin" && $type != "citymgr") {
					        echo '<td>'.round($noticia['referral_earned_amount'],2).'</td>';
                                        }
					echo '<td><a href="'.$docroot.'admin/edit/'.$noticia['role_name'].'/'.$noticia['userid'].'/" class="edit_but" title="Edit"></a>';

// 08-Aug-11 shop admin block bug fix start 
					if($type == "shopadmin") {

							if($noticia['status']=="D")
							{?>

								<a href="javascript:;" onclick="updateshop('A','<?php echo $noticia["shopid"];?>','<?php echo urlencode(DOCROOT.substr($_SERVER["REQUEST_URI"],1)); ?>');" class="unblock" title="<?php echo $admin_language['unblock']; ?>"></a>

							<?php }else{ ?>

								<a href="javascript:;" onclick="updateshop('D','<?php echo $noticia["shopid"];?>','<?php echo urlencode(DOCROOT.substr($_SERVER["REQUEST_URI"],1)); ?>');" class="block" title="<?php echo $admin_language['block']; ?>"></a>

						   	<?php } 

					}else{

							if($noticia['user_status']=="D")
							{
							?>
								<a href="javascript:;" onclick="updateuser('A','<?php echo $noticia["userid"];?>','<?php echo urlencode(DOCROOT.substr($_SERVER["REQUEST_URI"],1)); ?>');" class="unblock" title="<?php echo $admin_language['unblock']; ?>"  ></a>
							<?php }
							else
							{?>
								<a href="javascript:;" onclick="updateuser('D','<?php echo $noticia['userid'];?>','<?php echo urlencode(DOCROOT.substr($_SERVER['REQUEST_URI'],1)); ?>');" class="block" title="<?php echo $admin_language['block']; ?>" ></a>


							<?php }

					} // 08-Aug-11 shop admin block bug fix end 
					?>

						<a href="javascript:;" onclick="deleteuser('<?php echo $noticia["userid"];?>','<?php echo urlencode(DOCROOT.substr($_SERVER["REQUEST_URI"],1)); ?>');" class="delete" title="<?php echo $admin_language['delete']; ?>"></a>

				<?php
				echo '</td></tr>';
			}
echo '</table>';
echo '</fieldset>';

?>

		<?php 
			 if($pages->rspaginateTotal>20) { ?>

			<table border="0" width="650" align="center" cellpadding="5">
				<tr>
				<td align="center">
                <div class="pagenation">
				<?php echo $pages->display_pages(); ?>
                </div>
				</td>
				</tr>
			</table>

			<?php } ?>


		 <?php      
	   }
	   else
	   {
		  echo '<p class="nodata">'.$admin_language['nodata'].'</p>';
	   }

	} //else part ends here
?>

</div>


