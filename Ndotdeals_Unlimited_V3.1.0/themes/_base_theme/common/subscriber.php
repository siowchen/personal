<style type="text/css">
.text-label {
    color: #cdcdcd;
    font-weight: bold;
}
</style>

<?php
if($_POST["subscriber"] == $language['post'])
{
	$email = $_POST['email'];
	$city = $_POST['city_name'];
	
	if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$",$email))
	{
		set_response_mes(-1,$language['invalid_email']);
		url_redirect($_SERVER['REQUEST_URI']);
	} 
	
	if(!empty($email))
	{
		$val = add_subscriber($email,$city);
		if($val)
		{
			set_response_mes(1,$language['subscribe_success']);
			url_redirect($_SERVER['REQUEST_URI']);
		}
		else
		{
			set_response_mes(-1,$language['email_exist']);
			url_redirect($_SERVER['REQUEST_URI']);			
		}
	}
	else
	{
		set_response_mes(-1,$language['try_again']);
		url_redirect($_SERVER['REQUEST_URI']);

	}
	
	
}

//get the categpry list
$category_list = mysql_query("select * from coupons_cities where status='A' order by cityname");

?>

<div class="width240 fl clr borderF2F mb20">
<div class="great_deals">
            <div class="great_top fl clr">
            	<h1><?php echo $language['subscribe_to_newsletter']; ?></h1>
            </div>
          <div class="great_center fl clr">
              
	              <div class="submit_right fl clr ml5">
				  
					  <p class="ml5"><?php echo $language['subscribe_text']; ?></p>
	                  <form action="" method="post" name="subscribe_updates" id="subscribe_updates">
					  <select name="city_name" id="city" class="fl m15 city_sel">
					  <?php while($city_row = mysql_fetch_array($category_list)) { ?>
					  <option value="<?php echo $city_row["cityid"];?>" <?php if($_COOKIE['defaultcityId'] == $city_row["cityid"]){ echo "selected";} ?>><?php echo html_entity_decode($city_row["cityname"], ENT_QUOTES);?></option>
					  <?php } ?>
					  
					  </select>


					<input type="text" name="email" id="email" class="fl m15" title="<?php echo $language['valid_email']; ?>" value="" style="font-size:10px;" />


	                      <div class="fl mt15">
	                          <input name="subscriber" type="submit" value="<?php echo $language['post']; ?>" class="" />
	                      </div>                                    
	                  </form>
	              </div>
              <p class="mt10 fl clr ml10 width230 ">
                 <?php echo $language['subscribe_message']; ?>
              </p>
          </div>
<div class="great_bottom"></div>
</div>
</div>
<script type="text/javascript">
$('input[type="text"]').each(function(){
 
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
