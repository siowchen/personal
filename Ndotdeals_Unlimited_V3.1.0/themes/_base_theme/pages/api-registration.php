<?php
$validation_msg = '';
$dataArray['api_use'] = array();
if($_POST)
{
        if($_POST['terms'] == 1)
        {

		$usenumbers = $useupper = 1;        
                $charset = "abcdefghijklmnopqrstuvwxyz"; 
                $charset .= "ABCDEFGHIJKLMNOPQRSTUVWXYZ"; 
                $charset .= "0123456789"; 
                //$charset .= "~@#$%^*()_+-={}|][";   // Note: using all special characters this reads: "~!@#$%^&*()_+`-={}|\\]?[\":;'><,./"; 
                $length = mt_rand (30, 35); 
                for ($i=0; $i<$length; $i++) $key .= $charset[(mt_rand(0,(strlen($charset)-1)))]; 
                $validation_msg = '';
                $user_id = $_SESSION['userid'];
                $website = htmlentities($_POST["website_url"], ENT_QUOTES);
                $reason = htmlentities($_POST["reason"], ENT_QUOTES);
                if(is_array($_POST['api_use']))
                        $api_use = implode(',',$_POST['api_use']);
                else
                        $api_use = $_POST['api_use'];
                $_SESSION['user_data'] = '';
                $result = mysql_query("insert into api_client_details(userid, api_key, website_url, reason, api_use) values('$user_id', '$key', '$website', '$reason', '$api_use')");
                url_redirect(DOCROOT.'users/api-client.html');
        }
        else
        {
                $_SESSION['user_data'] = $_POST;
                $validation_msg = $language['api_accept'];
        }
        
}
?>
<script type="text/javascript">
/* validation */
$(document).ready(function(){ $("#api_reg").validate();});
</script>

<div class="work_bottom4">
       <p style="margin-left:5px;"> <?php echo $language['api_desc']; ?>
        <?php
                if(!empty($validation_msg))
                        echo '<p class="" style="color:red;">'.$validation_msg.'</p>';
                $dataArray = $_SESSION['user_data'];
        ?></p>

        <form action="" method="post" id="api_reg" name="api_reg">
		<table cellpadding="5" cellspacing="5">
                <label class="errorvalid"></label>
				<tr><td><label class="clr fl"><?php echo $language['api_your_web_url']; ?></label></td></tr>
                <tr>
				<td>
                <input name="website_url" type="text" class="required url" title="<?php echo $language['api_title_web_url']; ?>" value="<?php echo $dataArray['website_url']; ?>"/>
				</td>
				</tr>
				
                <tr><td><label><?php echo $language['api_usage_plan']; ?>?</label></td></tr>
				<tr><td>
                <textarea class="required" name="reason" title="<?php echo $language['api_title_usage_plan']; ?>" rows="10"><?php echo $dataArray['reason']; ?></textarea>
				</td>
				</tr>
				<tr><td>
                <label class="clr fl"><?php echo $language['api_usage_mode']; ?></label>
				</td>
				</tr>
				<tr><td>
                <span><input type="checkbox" name="api_use[]" value="1" title="<?php echo $language['api_website']; ?>"/><?php echo $language['api_website']; ?></span>
                <span><input type="checkbox" name="api_use[]" value="2" title="<?php echo $language['api_blog']; ?>"/><?php echo $language['api_blog']; ?></span>
                <span><input type="checkbox" name="api_use[]" value="3" title="<?php echo $language['api_mobile']; ?>"/><?php echo $language['api_mobile']; ?></span>
				</td></tr>
				<tr height="50">
				<td class="terms_error" width="100%">
				                <input type="checkbox" name="terms" class="required fl" value="1" title="<?php echo $language['api_title_terms_condn']; ?>"/><span class="fl"><?php echo $language['api_terms_condn']; ?></span>

				</td>
				</tr>
				<tr><td>
                <span class="submit"><input type="submit" value="<?php echo $language['login']; ?>" name="submit" class="bnone"/></span>
				</td>
				</tr>
		</table>
        </form>

		
</div>
