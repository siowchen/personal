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

<script type="text/javascript">

var win2;
function fbconnect(docroot){

  win2 = window.open(docroot+'facebook-connect.html',null,'width=650,location=0,status=0,height=400');
  checkChild();  
    
}

function checkChild() {
	  if (win2.closed) {
		window.location.reload(true);
	  } else setTimeout("checkChild()",1);
}


</script>

<?php 

if($_SESSION["userid"])
{
	url_redirect(DOCROOT."profile.html");
}

if($_POST)
{

	$username = $_POST["username"];

	if($username==$language['valid_username'] || $_POST["password"]==$language['valid_password']){

			set_response_mes(-1,'All fields are mandatory');
			url_redirect(DOCROOT."login.html");	

	}

	$password = md5($_POST["password"]);
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
	else
	{
		set_response_mes(-1,$language['password_incorrect']);
		url_redirect(DOCROOT."login.html");	
	}
}



?>

    <div class="mobile_content">
	<form action="" name="login" id="login" method="post">
	      <div class="sign">
		<ul>
		  <li>
		    <input class="required" type="text" name="username" title="<?php echo $language['valid_username']; ?>" />
		  </li>
		  <li>
		    <input class="required" type="password" name="password" title="<?php echo $language['valid_password']; ?>" />
		  </li>
		  <li class="facebook1"><a href="javascript:;" onclick="return fbconnect('<?php echo DOCROOT; ?>');" title="facebook connect"><img src="<?php echo DOCROOT; ?>themes/<?php echo CURRENT_THEME; ?>/images/facebook.png" width="38" height="32" alt="face" border="0" class="fl" /><span href="javascript:;" onclick="return fbconnect('<?php echo DOCROOT; ?>');" title="facebook connect" class="facebook">Login with Facebook</span></a></li>
		  
		  <li class='twitter1'><a href="<?php echo DOCROOT;?>system/modules/twitter/index.php" title="twitter connect"><img src="<?php echo DOCROOT; ?>themes/<?php echo CURRENT_THEME; ?>/images/twit_ico.png" width="38" height="32" alt="face" border="0" class="fl"/>  	
         	 <span href="<?php echo DOCROOT;?>system/modules/twitter/index.php" title="twitter connect" class="twitter">Login with twitter</span></a></li>
		</ul>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" class="sign_btn">
		  <tr>
		    <td><input name="" type="submit" value="SIGN IN"/>
		      <!--<a href="<?php echo DOCROOT;?>registration.html">SIGN UP</a>-->
		      <input name="" type="button" value="SIGN UP" onclick="window.location='<?php echo DOCROOT;?>registration.html'"/>
		      <input name="" type="button" value="CANCEL" onclick="window.location='<?php echo DOCROOT;?>'"/></td>
		  </tr>
		</table>
	      </div>
	</form>
    </div>

<script type="text/javascript">
$('input[type="text"],input[type="password"]').each(function(){
 
    this.value = $(this).attr('title');
    $(this).addClass('text-label');
 
    $(this).focus(function(){
        if(this.value == $(this).attr('title')) {
            this.value = '';
            $(this).removeClass('text-label');
        }
    });
 
    $(this).blur(function(){
        if(this.value == '') {
            this.value = $(this).attr('title');
            $(this).addClass('text-label');
        }
    });
});

</script>
