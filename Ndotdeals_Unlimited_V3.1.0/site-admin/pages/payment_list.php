<?php
session_start();
is_login(DOCROOT."admin/login/"); //checking whether admin logged in or not.
echo '<div class="deals_desc1">';
payment_list();
echo '</div>';
?>

