<?php
/******************************************
* @Created on March, 2011 * @Package: Ndotdeals unlimited v2.2
* @Author: NDOT
* @URL : http://www.NDOT.in
********************************************/
?>

<div class="content">
  <!-- content left start -->
  <div class="content_left">
    <div class="left1 fl clr">
      <?php 
			if(file_exists($left)){
				include($left);
			}else{
				include($left_default);
			}
			 ?>
    </div>
  </div>
  <!-- content left end -->
  <!-- content right start -->
  <div class="content_right">
    <?php include($right); ?>
  </div>
  <!-- content right end -->
</div>
