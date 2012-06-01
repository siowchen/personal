<?php
/******************************************
* @Created on March, 2011 * @Package: Ndotdeals unlimited v2.2
* @Author: NDOT
* @URL : http://www.NDOT.in
********************************************/
?>
<script type = "text/javascript">
/* validation */

$(document).ready(function(){$("#suggest").validate();});

</script>



<ul>
<li><a href="/" title="Home"><?php echo $language["home"]; ?> </a></li>
<li><span class="right_arrow"></span></li>
<li><a href="javascript:;" title="<?php echo $language["suggest"]; ?>"><?php echo $language["suggest"]; ?></a></li>    
</ul>
<?php
//get the cist
	$business_city = mysql_query("select * from coupons_cities where status='A' order by cityname asc");
	$business_type = mysql_query("select * from coupons_category where status='A' order by category_name asc");

	if($_POST)
	{
		$to = SITE_EMAIL;
		$business_name = $_POST["business_name"];
		$name = $_POST["business_name"];
		$business_website = $_POST["business_website"];
		$from = $_POST["email"];
		$business_city = $_POST["business_city"];
		$business_type = $_POST["business_type"];
		$description = $_POST["description"];
		$subject = $language["suggest"];
		$logo = DOCROOT."site-admin/images/logo.png";
		
		$mes = "<p> Business Name:".$business_name."</p><p>Business website:".$business_website."</p><p>Business city:".$business_city."</p><p>Business type:".$business_type."</p>"."<p>".$description."</p>";
		//send_email($email,$to,$subject,$mes); //call email function
		
		$str = implode("",file(DOCUMENT_ROOT.'/themes/_base_theme/email/email_all.html'));
                
                $str = str_replace("SITEURL",$docroot,$str);
                $str = str_replace("SITELOGO",$logo,$str);
                $str = str_replace("RECEIVERNAME",'Admin',$str);
                $str = str_replace("MESSAGE",ucfirst($mes),$str);
                $str = str_replace("SITENAME",SITE_NAME,$str);        
                
                $message = $str;
        	$SMTP_USERNAME = SMTP_USERNAME;
	        $SMTP_PASSWORD = SMTP_PASSWORD;
	        $SMTP_HOST = SMTP_HOST;
	        $SMTP_STATUS = SMTP_STATUS;	
		if($SMTP_STATUS==1)
		{
	
			include(DOCUMENT_ROOT."/system/modules/SMTP/smtp.php"); //mail send thru smtp
		}
		else
		{
			// To send HTML mail, the Content-type header must be set
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			// Additional headers
			$headers .= 'From: '.$from.'' . "\r\n";
			$headers .= 'Bcc: '.$to.'' . "\r\n";
			mail($to,$subject,$message,$headers);	
		}
		
		$lang = $_SESSION["site_language"];
                if($lang)
                {
                        include(DOCUMENT_ROOT."/system/language/".$lang.".php");
                }
                else
                {
                        include(DOCUMENT_ROOT."/system/language/en.php");
                }
		//set_response_mes(1,"Thank you for your interest with us. We will contact you soon...");
		set_response_mes(1,$language['thank_you_for_your_interest']);
		
		url_redirect(DOCROOT.'business.html');
	}
?>

<div class="work_bottom contactus">
<form action="" name="suggest" id="suggest" method="post">
<table width="100%" border="0" cellpadding="5" cellspacing="5" class="contact_user ml10">

<tr>
<td align="right"><label><?php echo $language['business_name']; ?> :</label></td> 
<td><input name="business_name" type="text" class="required input_box" title="<?php echo $language['name_error']; ?>" /></td>
</tr>

<tr>
<td align="right"><label><?php echo $language['business_website']; ?> :</label></td>
<td><input name="business_website" type="text" class="required url input_box" title="<?php echo $language['website_error']; ?>" /></td>
</tr>

<tr>
<td align="right"><label><?php echo $language["e-mail"]; ?> :</label></td>
<td><input name="email" type="text" class="required email input_box" title="<?php echo $language['valid_email']; ?>" /></td>
</tr>

<tr>
<td align="right"><label><?php echo $language['city']; ?> :</label></td>
<td><select name="business_city" id="business_city" class="input_box p3 required borderccc" title="<?php echo $language['city_error']; ?>">
<?php 
if(mysql_num_rows($business_city)>0)
{
	while($row = mysql_fetch_array($business_city))
	{
		?>
		<option value="<?php echo $row["cityname"];?>"><?php echo $row["cityname"];?></option>		
		<?php 
	}
}
?>
</select>
</td>
</tr>

<tr>
<td align="right"><label><?php echo $language['business_type']; ?> :</label></td>
<td><select name="business_type" id="business_type" class="input_box p3 required borderccc" title="<?php echo $language['type_error']; ?>">
<?php 
if(mysql_num_rows($business_type)>0)
{
	while($row = mysql_fetch_array($business_type))
	{
		?>
		<option value="<?php echo $row["category_name"];?>"><?php echo $row["category_name"];?></option>		
		<?php 
	}
}
?>
</select>
</td>
</tr>

<tr>
<td valign="top" align="right"><label><?php echo $language['business_message']; ?> :</label> </td>
<td><textarea name="description" cols="60" rows="7" class="borderccc required" title="<?php echo $language['valid_message']; ?>"></textarea></td>
</tr>

<tr>
<td>&nbsp;</td>
 <td><span class="submit fl" style="text-align:center; float:left;"><input type="submit" name="submit" class="bnone" value="<?php echo $language['post']; ?>" /></span></td>
</tr>
</table>
</form>
</div>
