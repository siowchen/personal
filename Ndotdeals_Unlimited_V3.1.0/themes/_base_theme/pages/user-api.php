<?php
is_login(DOCROOT."login.html"); //checking whether user logged in or not. 
include("profile_submenu.php"); ?>
<h1><?php echo $page_title; ?></h1>

<?php
$user_id = $_SESSION['userid'];
$result = mysql_query("select * from api_client_details where userid='$user_id'");
if(mysql_num_rows($result)>0)
{
        ?><h1><?php  echo $language["your_api_key"]; ?></h1><?php
        while($row = mysql_fetch_array($result))
        {
                $api_key = $row["api_key"];
                $api_status = $row["status"];
                if($api_status == '1')
                {
                        ?>
                        <div class="work_bottom">
	                        <h2><?php echo $api_key; ?></h2>
                        </div>
                        <?php
                }
                else
                {
                        ?>
                        <div class="work_bottom4">
	                        <h2><?php  echo $language["your_request_waiting_for_approval"]; ?></h2>
                        </div>
                        <?php
                }
        }
}
else
{
        include("api-registration.php");
}


?>
