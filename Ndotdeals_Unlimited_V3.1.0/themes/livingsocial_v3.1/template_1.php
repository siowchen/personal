<?php
/******************************************
* @Created on March, 2011 * @Package: Ndotdeals unlimited v2.2
* @Author: NDOT
* @URL : http://www.NDOT.in
********************************************/
$file_name_list = array("referral","pages","purchase","business","privacy","nearbymap","unsubscribe");

if(in_array($file_name,$file_name_list)){
	
		include('template_5.php');
}
elseif($file_name == 'contactus' || $file_name == 'how-it-works')
{
include('template_2.php');
}
else
{ 
?>

<div class="content">
  <div class="content_inner">
    <div class="inner_top"></div>
    <div class="inner_center">
      <?php 
			if(file_exists($left)){
				include($left);
			}else{
				include($left_default);
			}
			 ?>
    </div>
    <div class="inner_bottom"></div>
  </div>
  <div class="content_right">
    <?php  if($file_name !='business' && $file_name !='pages')
                        include($right); ?>
  </div>
</div>
<?php } ?>
