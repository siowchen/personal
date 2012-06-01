<?php
if($_POST["mobilesubscribe"] == $language['post'])
{
	$mobileno = $_POST['mobileno'];
	$city = $_POST['city_name'];
	
	if(!preg_match("/^(\+){0,1}(\d|\s|\(|\)|\-){5,20}$/",$mobileno))
        {
	        set_response_mes(-1,$language['invalid_mobile_number']);
	        url_redirect($_SERVER['REQUEST_URI']);
        } 
	
	if(!empty($mobileno))
	{
	
		$val = add_mobilesubscriber($mobileno,$city);
		if($val)
		{
			set_response_mes(1,$language['subscribe_success']);
			url_redirect($_SERVER['REQUEST_URI']);
		}
		else
		{
			set_response_mes(-1,$language['mobile_exits']);
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
<div class="fl clr borderF2F">
  <div class="great_deals">
    <div class="great_top">
      <h1><?php echo $language['mobile_subscription']; ?></h1>
    </div>
    <div class="great_center fl clr">
      <div class="submit_right fl clr ml5">
        <p class="ml5"><?php echo $language['subscribe_mobtext']; ?></p>
       <form action="" method="post" name="subscribe_updates1" id="subscribe_updates1">
          <select name="city_name" id="city" class="fl m15 city_sel mt10">
            <?php while($city_row = mysql_fetch_array($category_list)) { ?>
            <option value="<?php echo $city_row["cityid"];?>" <?php if($_COOKIE['defaultcityId'] == $city_row["cityid"]){ echo "selected";} ?>><?php echo html_entity_decode($city_row["cityname"], ENT_QUOTES);?></option>
            <?php } ?>
          </select>
          <input type="text" name="mobileno" id="mobileno" class="fl m15 mt10" title="<?php echo $language['valid_mobile']; ?>" value="" style="font-size:12px;" />
          <div class="fl mt10">
            <div class="submit">
		
           <input name="mobilesubscribe" type="submit" value="<?php echo $language['post']; ?>" class="" />
            </div>
          </div>
        </form>
      </div>
      <p class="mt10 fl clr ml10 width230 "> <?php echo $language['subscribe_message']; ?> </p>
    </div>
    <div class="great_bottom"> </div>
  </div>
</div>
