<?php
/******************************************
* @Created on March, 2011 * @Package: Ndotdeals unlimited v2.2
* @Author: NDOT
* @URL : http://www.NDOT.in
********************************************/

$file_name_list = array("hot-deals");

if(in_array($file_name,$file_name_list)){

	include('template_4.php');

}else{
?>

<div class="content">
  <!-- content left start -->
  <div class="content_left">
    <div class="left1 fl clr">
      <div class="content_top">
	  <div class="con_top_top"></div>
	  <div class="con_top_mid"><h1><?php echo $page_title; ?></h1>
     </div>
	  </div>
      <div class="content_center">
        <?php 
			if(file_exists($left)){
				include($left);
			}else{
				include($left_default);
			}
			 ?>
      </div>
      <div class="content_bottom"></div>
    </div>
  </div>
  <!-- content left end -->
  <!-- content right start -->
  <div class="content_right">
    <?php include($right); ?>
  </div>
  <!-- content right end -->
</div>

<?php } ?>
