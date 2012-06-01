<?php 
/********************************************
 * @Created on March, 2011 * @Package: Ndotdeals unlimited v2.2
 * @Author: NDOT
 * @URL : http://www.NDOT.in
 ********************************************/
?>
<script type="text/javascript">

var win2;
function fbconnect(docroot){

  win2 = window.open(docroot+'facebook-connect.html',null,'width=650,location=0,status=0,height=400');
  checkChild();  
    
}

function checkChild() {
	  if (win2.closed) {
		window.location.reload(true);
	  } else setTimeout("checkChild()",1);
}


</script>
<div class="content_right1 mb-10">
  <div class="great_deals">
	<div class="great_top">
		<h1>Facebook Connect</h1>
	</div>
	<div class="great_center">

	<div class="contact_right fl clr">
		<p>
			<?php echo $language["already_have_account"]; ?><br /><?php echo $language["use_it"]; ?>
		</p>
		<a href="javascript:;" onclick="fbconnect('<?php echo DOCROOT; ?>');" title="facebook connect" class="bg_facebook fl clr mt15 ml10"></a>
	</div>			
	</div>   
	<div class="great_bottom"></div>
 </div>
</div>
   

