<?php 
/******************************************
* @Created on March, 2011 * @Package: Ndotdeals unlimited v2.2
* @Author: NDOT
* @URL : http://www.NDOT.in
********************************************/
?>
<script type = "text/javascript">
/* validation */
$(document).ready(function(){$("#login").validate();});

</script>
<?php 

if($_SESSION["userid"])
{
	url_redirect(DOCROOT."profile.html");
}

if($_POST['submit'] == $language['login'])
{ 

	 $username = $_POST["username"];
	 $password = md5($_POST["password"]);

	if($username==$language['valid_username'] || $_POST["password"]==$language['valid_password']){

			set_response_mes(-1,'All fields are mandatory');
			url_redirect(DOCROOT."login.html");	

	}

	$result = loginCheck($username,$password);

	if($result == "Success")
	{
		set_response_mes(1,$language['login_success']);
		$reference_url = $_SESSION["ref"];
		$_SESSION["ref"] = "";
		
		if($reference_url)
		{
			url_redirect($reference_url);
		}
		else
		{
			url_redirect(DOCROOT."profile.html");
		}
	}
	else if($result == "Blocked")
	{
		set_response_mes(-1,$language['loginblocked']);
		url_redirect(DOCROOT."login.html");
	}
	else
	{
		set_response_mes(-1,$language['password_incorrect']);
		url_redirect(DOCROOT."login.html");	
	}
}



?>


<div class="work_bottom1 login_area clr">
  <form action="" name="login" id="login" method="post">
    <table width="100%" border="0" cellpadding="5" cellspacing="5" class="contact_user">
      <tr>
        <td align="right" valign="middle"><label><?php echo $language['username']; ?> :</label></td>
        <td><input name="username" id="username" type="text"  class="required input_box nospecialchars" title="<?php echo $language['valid_username']; ?>" /></td>
      </tr>
      <tr>
        <td align="right" valign="middle"><label><?php echo $language['password']; ?> :</label></td>
        <td><input name="password" type="password" class="required input_box " title="<?php echo $language['valid_password']; ?>" /></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><div class="signup_now">
		 <div class="submit">		
            <input type="submit" class="bnone fl" value="<?php echo $language['login']; ?>" name="submit" />            
			</div>
			<div class="reset">
			
            <input type="reset" value="<?php echo $language['reset']; ?>" name="submit" class="bnone"/>
           
			
			</div> </div></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><a href="<?php echo DOCROOT;?>forgot-password.html" title="<?php echo $language['forgot_password']; ?>"><?php echo $language['forgot_password']; ?></a></td>
      </tr>
    </table>
  </form>
</div>
