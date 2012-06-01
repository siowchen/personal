<?php
/********************************************
 * @Created on March, 2011 * @Package: Ndotdeals unlimited v2.2 
 * @Author: NDOT
 * @URL : http://www.ndot.in
 ********************************************/

$s = ob_get_clean();
box('box', $gPage, $s, '','margin-bottom: 10px;');

?>
                     </div>
		          
		          <div class="content_bottom"><div class="bot_left"></div><div class="bot_center"></div><div class="bot_rgt"></div></div>
		          
	 </div>           

	</td>
</tr>
</table>



</div>

</div>
<div class="login_footer ">
      <p> Copyright &copy; <?php echo date("Y"); ?> Ndot.in. All Rights Reserved.</p>
</div>
<script type="text/javascript">
$(document).ready(function()
{
	ajaxLoaderPosition();

	$("#ajax-loader").ajaxStart(function()
	{
		$(this).show();
	});
	$("#ajax-loader").ajaxStop(function()
	{
		$(this).hide();
	});

	initAdminState();

	$("div.dbx-handle a").each(function()
	{
		$(this).bind('click',function(){
			toggleBox($(this).attr('id'),this);
		});
	});

	$(".striped tr:even").addClass("tr");

	// Docking Boxes starter
	dbxer();
});
</script>

</body>
</html>
