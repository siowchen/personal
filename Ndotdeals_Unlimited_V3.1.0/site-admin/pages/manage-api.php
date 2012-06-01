<?php session_start();
is_login(DOCROOT."admin/login/"); //checking whether admin logged in or not.

?>
	<script type="text/javascript">
	$(document).ready(function(){ 
	$(".toggleul_4").slideToggle(); 
	document.getElementById("left_menubutton_4").src = "<?php echo DOCROOT; ?>site-admin/images/minus_but.png"; 
	});
	</script>

<script type="text/javascript">
function delete_api(del_id)
{	
	var sure=confirm("Are you sure want to delete it?");
	if(sure)
	{
		window.location='<?php echo DOCROOT; ?>site-admin/pages/delete.php?del_id='+del_id;
	}

}

function update_api(id,status)
{		
	window.location='<?php echo DOCROOT; ?>site-admin/pages/update.php?api_id='+id+'&api_status='+status;
}
</script>


<div class="deals_desc1">      

<?php 
		
		$queryString = "select username,api_client_details.userid,api_key,website_url,reason,api_client_details.status,DATE_FORMAT(api_cdate, '%b %d %Y %H:%i:%s') as api_cdate,api_client_details.id from api_client_details left join coupons_users on api_client_details.userid = coupons_users.userid";
		
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

				 <table cellpadding="0" cellspacing="0"   class="coupon_report" border="1">
				 <tr>
				 <th><?php echo $admin_language['username']; ?></th>
				 <th><?php echo $admin_language['apikey']; ?></th>
				 <th><?php echo $admin_language['description']; ?></th>
				 <th><?php echo $admin_language['date']; ?></th>
				 <th>Manage</th>
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
				   
				   <td>
				   <?php echo $noticia['username'];?>
				   </td>

				   <td>
				   <?php echo $noticia['api_key'];?>
				   </td>
				   <td>
				   <?php   echo html_entity_decode($noticia["reason"]); ?> <br />
				   <?php   echo $noticia["website_url"]; ?>
				   </td> 
				   <td>
				   <?php   echo $noticia["api_cdate"]; ?>
				   </td>
				 

				   <td>
					<div class="fl">
					<?php
		            if($noticia['status'] != 1)
		            {?>
				    <span class="fl clr"><a href="javascript:;" onclick="update_api('<?php echo $noticia['id']; ?>','1')" class="unblock" title="Unblock">
					</a>
					</span>
		            <?php }
		            else { ?>
				    <span class="fl clr">
					<a href="javascript:;" onclick="update_api('<?php echo $noticia['id']; ?>','0')" class="block" title="Block"></a></span>
			    <?php } ?>

				    <span class="fl clr">
					<a href="javascript:;" onclick="delete_api('<?php echo $noticia['id']; ?>')" class="delete" title="Delete"></a></span>
                   
                   
				   </div>
				   </td>

		</tr>
  
        <?php } ?>
      </table>
		<?php 
		$api_manage_result = mysql_query($queryString);		
			if($pages->rspaginateTotal>20) { ?>

			<table border="0" width="650" align="center" style="padding:5px;" class="mt5" cellpadding="5">
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
					  echo '<p class="nodata">'.$admin_language['noapi'].'</p>';
	   }
    
?>
</div>

