<?php session_start(); 
is_login(DOCROOT."admin/login/"); //checking whether admin logged in or not.
require(DOCUMENT_ROOT.'/system/language/en.php');
?>

<script type="text/javascript">
$(document).ready(function()
	{ 
		//for create form validation
		$("#sms").validate();
	});
</script>
<script type="text/javascript">
$(document).ready(function(){
$(".toggleul_12").slideToggle();
document.getElementById("left_menubutton_12").src = "<?php echo DOCROOT; ?>site-admin/images/minus_but.png";
});
</script>
<?php
if($_POST)
{

	
	 $city = $_POST['city'];
	 if($city)
	 {
	 	$resultSet = mysql_query("select * from mobile_subscribers where city_id='$city'");
		if(mysql_num_rows($resultSet) >0)
		{
			$mobile_list='';
			while($row=mysql_fetch_array($resultSet))
			{
				if($row['mobileno']!='')
				{
					$mobile_list.=$row['mobileno'].',';
				}
			}
		}
		else
		{
			$redirect_url = DOCROOT."admin/profile/";
			set_response_mes(-1, $admin_language['nomobilesubscriber']); 	
			url_redirect(DOCROOT.'admin/sendsms/');		
		}

	 }
	 
	 $to1 = $mobile_list;
	 $to = substr($to1,0,strlen($to1)-1);
	
	 $message=$_POST['message'];
	 
	if($city=='' || $message=='')
	{ 
		$redirect_url = DOCROOT."admin/profile/";
		set_response_mes(-1, $admin_language['fieldmandatory']); 	
		url_redirect(DOCROOT.'admin/sendsms/');
	}

	//free sms url with the arguments

        $result = file_get_contents("http://s1.freesmsapi.com/messages/send?skey=b5cedd7a407366c4b4459d3509d4cebf&message=".urlencode($message)."&senderid=NAJIK&recipient=$to");

        if($result)
        {
                set_response_mes(1, $result); 		 
                $redirect_url = DOCROOT.'admin/sendsms/';
                url_redirect($redirect_url);
        }

}

//get the categpry list
$city_list = mysql_query("select * from coupons_cities  order by cityname");

?>
 <fieldset class="field" style="margin-left:10px;">         
        <legend class="legend"><?php echo $admin_language['sendsms']; ?></legend>

<form name="sms" id="sms" action="" method="post" >	
<table border="0"  cellpadding="5" align="left" class="p5">

<tr><td align="right"><label><?php echo $admin_language['city']; ?></label></td><td>
<select title="<?php echo $admin_language['choosethecity']; ?>" name="city" id="city" class="required fl m15">
<option value="">--<?php echo $admin_language['select']; ?>--</option>
<?php while($city_row = mysql_fetch_array($city_list)) { ?>
<option value="<?php echo $city_row["cityid"];?>" title="<?php echo html_entity_decode($city_row["cityname"], ENT_QUOTES); ?>"><?php echo html_entity_decode($city_row["cityname"], ENT_QUOTES); ?></option>
<?php } ?>
</select>
</td>
</tr>

<tr><td valign="top" align="right"><label><?php echo $admin_language['message']; ?></label></td><td><textarea name="message" rows="7"  class="required width400" title="<?php echo $admin_language['enteryourmessage']; ?>" ></textarea></td></tr>

<tr><td>&nbsp;</td><td><input type="submit" value="<?php echo $admin_language['send']; ?>" class="button_c" /></td></tr>
</table>
</form>
 </fieldset>

