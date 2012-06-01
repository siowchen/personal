<?php
/******************************************
* @Created on March, 2011 * @Package: Ndotdeals unlimited v2.2
* @Author: NDOT
* @URL : http://www.NDOT.in
********************************************/
?>

<div class="content">
  <?php 
    if(file_exists($left)){
    include($left);
    }else{
    include($left_default);
    }
    ?>
  <!-- content right start -->
  <div class="content_right">
    <?php include($right); ?>
  </div>
  <!-- content right end -->
</div>
