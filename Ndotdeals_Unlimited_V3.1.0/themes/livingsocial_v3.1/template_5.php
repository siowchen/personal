<?php
/******************************************
* @Created on March, 2011 * @Package: Ndotdeals unlimited v2.2
* @Author: NDOT
* @URL : http://www.NDOT.in
********************************************/
?>

<div class="content">
  <div class="content_inner1 ">
   <div class="content_top1">
	  <div class="con_top_top1"></div>
	  <div class="con_top_mid1"><h1><?php echo $page_title; ?></h1>
     </div>
	  </div>
    <!--left corner-->
    <div class="inner_center3">
      <?php 
			if(file_exists($left)){
				include($left);
			}else{
				include($left_default);
			}
			 ?>
    </div>
    <div class="inner_bottom3"></div>
  </div>
</div>
