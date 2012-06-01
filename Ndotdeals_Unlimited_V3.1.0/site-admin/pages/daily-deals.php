<?php session_start();
is_login(DOCROOT."admin/login/"); //checking whether admin logged in or not.

$queryString1 = "select * from cron_time_settings where id=1 ";
$resultSet1 = mysql_query($queryString1);
$resultSet2 = mysql_query($queryString1);

if($_POST)
{
        $min = $_POST['min'];
        $hour = $_POST['hour'];
        $day = $_POST['day'];
        $month = $_POST['month'];
        $day_week = $_POST['day_week'];
        $queryString = "update cron_time_settings set minute='$min',hour='$hour',day_month='$day',month='$month',day_week='$day_week' where id=1";
        $resultSet = mysql_query($queryString);
        set_response_mes(1, 'Cron settings have been saved'); 		 
	$redirect_url = DOCROOT.'admin/daily-deals/';
	url_redirect($redirect_url);        
}

?>
<script type="text/javascript">
$(document).ready(function(){
$(".toggleul_12").slideToggle();
document.getElementById("left_menubutton_12").src = "<?php echo DOCROOT; ?>site-admin/images/minus_but.png";
});
</script>
<div class="form">
<div class="form_top"></div>
      <div class="form_cent">  
<p>
You have to add the lines to Cron tab execute the email sending newsletter automatically .. Please contact your server administrator if you are not running GNU-Linux/Unix or if you need help installing the job.
</p><p>
This is the line that has to be added to your list of cron tasks:
</p>

<textarea cols ="100" rows="1" style=" width:580px; background:#ddd;" >
5 6 * * * wget -q -O /dev/null "<?php echo DOCROOT; ?>cron.html?api_key=<?php echo SITE_LICENSE_KEY;?>" > /dev/null 2>&1
</textarea>
<p>
If you use cPanel for adding cron task, use this command:</p>
<textarea cols ="100" rows="1" style=" width:580px; background:#ddd;" >
wget -q -O /dev/null "<?php echo DOCROOT; ?>cron.html?api_key=<?php echo SITE_LICENSE_KEY;?>" > /dev/null 2>&1
</textarea>


<div style="clear:both;">
<strong>Crontab syntax</strong>

<div class="p5">
	<pre>
	<code>
	*     *     *     *     *  command to be executed
	-     -     -     -     -
	|     |     |     |     |
	|     |     |     |     +----- day of week (0 - 6) (Sunday=0)
	|     |     |     +------- month (1 - 12)
	|     |     +--------- day of month (1 - 31)
	|     +----------- hour (0 - 23)
	+------------- min (0 - 59)
	</code>
	</pre>
</div> 


<!--<a href="<?php echo DOCROOT; ?>admin/daily_mails/" title="<?php echo $admin_language['dailymail']; ?>"><?php echo $admin_language['clickhere']; ?></a> <?php echo $admin_language['senddailydealmail']; ?>-->
<a href="<?php echo DOCROOT; ?>admin/daily_mails/" title="<?php echo $admin_language['dailymail']; ?>" class="mt-10"><img src="<?php echo DOCROOT; ?>site-admin/images/run_email.jpg"/></a>
</div>
</div>
<div class="form_bot"></div>
</div>

