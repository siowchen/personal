<?php
/******************************************
* @Created on March, 2011 * @Package: Ndotdeals unlimited v2.2
* @Author: NDOT
* @URL : http://www.NDOT.in
********************************************/
?>
<script type = "text/javascript">
/* validation */

$(document).ready(function(){$("#contactus").validate();});

</script>

<h1 class="page_tit"><?php echo $page_title; ?></h1>

<?php
	if($_POST)
	{
		$to = SITE_EMAIL;
		$name = $_POST["name"];
		$email = $_POST["email"];
		$phone = $_POST["phone"];
		$location = $_POST["location"];
		$subject = $_POST["subject"];
		
		$mes = "<p> Name:".$name."</p><p>Phone:".$phone."</p><p>Location:".$location."</p>"."<p>".$_POST["description"]."</p>";
		send_email($email,$to,$subject,$mes); //call email function
		set_response_mes(1,"Thank you for your enquiry. We will contact you soon.");
		url_redirect(DOCROOT.'contactus.html');
	}
?>




    <div class="mobile_content">
	<form action="" name="contactus" id="contactus" method="post">
	      <div class="sign">
    
        <ul>
          <li>
            <input name="name" type="text" class="required input_box" title="<?php echo $language['valid_name']; ?>" />
          </li>
          <li>
            <input name="email" type="text" class="required email input_box" title="<?php echo $language['valid_email']; ?>" />
          </li>
           <li>
            <input name="phone" type="text" id="phone" class="required input_box" title="Enter mobile number" />
          </li>
           <li>
            <input name="location" type="text" id="location" class="required input_box" title="<?php echo $language['valid_location']; ?>" />
          </li>
           <li>
            <input name="subject" type="text" id="subject" class="required input_box" title="<?php echo $language['valid_subject']; ?>" />
          </li>
           <li>
		<textarea name="description" cols="15" rows="5" class="required" title="<?php echo $language['valid_message']; ?>"><?php echo $language['valid_message']; ?></textarea>
          </li>
        </ul>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" class="sign_btn">
          <tr>
            <td><input name="" type="submit" value="POST"/>
	        <input name="" type="button" value="CANCEL" onclick="window.location='<?php echo DOCROOT;?>'"/>
	    </td>
          </tr>
        </table>

	      </div>
	</form>

    </div>


<script type="text/javascript">
$('input[type="text"],textarea').each(function(){
 
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
