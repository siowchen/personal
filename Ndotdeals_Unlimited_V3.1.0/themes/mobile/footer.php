<?php
$url_arr = explode('/',$_SERVER['REQUEST_URI']);

if($url_arr[1] == 'today-deals.html')
{
        $today_deals = 'active';
}
else if($url_arr[1] == 'hot-deals.html')
{
        $hot_deals = 'active';
}
else if($url_arr[1] == 'past-deals.html' || $url_arr[2] == 'past')
{
        $past_deals = 'active';
}
else if($url_arr[1] == 'how-it-works.html')
{
        $how_it_works = 'active';
}
else if($url_arr[1] == 'contactus.html')
{
        $contactus = 'active';
}
else
{
        $home = 'active';
}
?>
 <div class="high_menu2">
                    	<ul>
			    <li><a href="<?php echo DOCROOT;?>" class="<?php echo $today_deals; ?>"><?php echo strtoupper($language["today"]); ?></a></li>
			    <li><a href="<?php echo DOCROOT;?>hot-deals.html"  class="<?php echo $hot_deals; ?>"><?php echo strtoupper($language["hot"]); ?></a></li>
			    <li><a href="<?php echo DOCROOT;?>past-deals.html"  class="<?php echo $past_deals; ?>"><?php echo strtoupper($language["past_deals"]); ?></a></li>
			    <li><a href="<?php echo DOCROOT;?>contactus.html"  class="<?php echo $contactus; ?>"><?php echo strtoupper($language["contact_us"]); ?></a></li>
                        </ul>
                </div>
