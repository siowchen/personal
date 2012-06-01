<?php session_start();
is_login(DOCROOT."admin/login/"); //checking whether admin logged in or not.

$type = $url_arr[3];
$type = explode('?',$type);
$url_arr[3] = $type = $type[0];

?>

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
		<td><input type="submit" value="<?php echo $admin_language['submit']; ?>"/></td>
		</tr>
		</table>
	</form>
</div>

<div class="deals_desc1">

<?php 

	    $queryString = "SELECT (select firstname from coupons_users u where u.userid=r.reg_person_userid) as registeredperson, (select firstname from coupons_users u where u.userid=r.referred_person_userid) as referredperson,(select referral_earned_amount from coupons_users where coupons_users.userid =r.referred_person_userid ) as referral_earned_amount, deal_bought_count FROM referral_list r left join coupons_users u on u.userid=r.reg_person_userid";

		if(!empty($searchkey)) {
			$queryString .=	" where u.firstname like '%".$searchkey."%' "; }

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

                echo '<fieldset class="field1" style="margin-left:10px;">';         
                echo '<legend class="legend1">'.$admin_language['referraldetail'].'</legend>';
		echo '<table cellpadding="0" cellspacing="0" class="inner_table">';
		echo '<tr class="fwb"><td>'.$admin_language['Name'].'</td>';
		echo '<td>'.$admin_language['referedby'].'('.CURRENCY.' Referred Amount)</td><td>'.$admin_language['dealboughtcount'].'</td>';

			while($noticia=mysql_fetch_array($resultSet))
			{ 

				echo '<tr><td>';
				echo ucfirst($noticia['registeredperson']);
				echo '</td>';

				echo '<td>';
				echo ucfirst($noticia['referredperson']);
				echo " ( ".ucfirst($noticia['referral_earned_amount'])." )";								
				echo '</td>';

				echo '<td>';
				echo $noticia['deal_bought_count'];
				echo '</td></tr>';

			}

		echo '</table>';
		echo '</fieldset>';

			$result = mysql_query($queryString);
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

?>

</div>


