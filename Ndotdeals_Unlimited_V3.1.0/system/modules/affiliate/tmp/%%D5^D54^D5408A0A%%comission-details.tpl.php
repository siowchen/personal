<?php /* Smarty version 2.6.14, created on 2012-04-11 12:56:17
         compiled from comission-details.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php echo "<script type='text/javascript'>$(document).ready(function(){ $('#commission').validate();});

		function checkUncheckAll(theElement) 
		{ 
			 var theForm = theElement.form, z = 0;
			 for(z=0; z<theForm.length;z++)
			 {
				  if(theForm[z].type == 'checkbox' && theForm[z].name != 'checkall')
				  { //alert(theElement);
					theForm[z].checked = theElement.checked;
				  }
			 }
		}

		function approve_deallist()
		{

				var chks = document.getElementsByName('com[]');
				var hasChecked = false;												
				// Get the checkbox array length and iterate it to see if any of them is selected
				for (var i = 0; i < chks.length; i++)
				{
					if (chks[i].checked)
					{
							hasChecked = true;
							break;
					}
				
				}
				
				// if ishasChecked is false then throw the error message
				if (!hasChecked)
				{
						alert('Please select at least one record!');
						chks[0].focus();
						return false;
				}
				
				// if one or more checkbox value is selected then submit the form
				var booSubmit = confirm('Are you sure want to proceed?');				
				if(booSubmit == true)
				{
					document.commission.submit();

				}
			
		}


</script>"; ?>
<h2><?php echo $this->_tpl_vars['lang']['commission_details']; ?>
</h2>
<?php if (( $this->_tpl_vars['ctype'] != 'approved' && $this->_tpl_vars['msg'] != '' )): ?>
<?php if (( $this->_tpl_vars['msg'] == 1 )): ?>
Your fund request are submitted admin.
<?php elseif (( $this->_tpl_vars['msg'] == 0 )): ?>
Your fund request are greater the your commission .
<?php else: ?>
Your fund request are not valid amount .
<?php endif; ?>
<?php endif; ?>

<?php if ($this->_tpl_vars['commission']['id'] == '' && $_GET['id'] == ''): ?>
	<?php if ($this->_tpl_vars['aff']['approved'] == 2): ?>
		<div style="font-size: 13px;" class="com_dts">
		<ul class="options">
			<li><?php echo $this->_tpl_vars['lang']['commissions']; ?>
: </li>
			<li>
				<?php if (( $this->_tpl_vars['ctype'] != 'pending' )): ?>
				<a href="commission-details.php?type=pending" style="font-size: 13px;"><?php echo $this->_tpl_vars['lang']['pending_approval']; ?>
</a>
				<?php else: ?>
				<b><?php echo $this->_tpl_vars['lang']['pending_approval']; ?>
</b>
				<?php endif; ?>
			</li>
			<li>
				<?php if (( $this->_tpl_vars['ctype'] != 'approved' )): ?>
				<a href="commission-details.php?type=approved" style="font-size: 13px;"><?php echo $this->_tpl_vars['lang']['approved']; ?>
</a>
				<?php else: ?>
				<b><?php echo $this->_tpl_vars['lang']['approved']; ?>
</b>
				<?php endif; ?>
			</li>
		<!--	<li>
				<?php if (( $this->_tpl_vars['ctype'] != 'paid' )): ?>
				<a href="commission-details.php?type=paid" style="font-size: 13px;">Paid</a>
				<?php else: ?>
				<b>Paid</b>
				<?php endif; ?>
			</li>
		-->
		</ul>
		
		<div style="clear: both;"></div>
		<fieldset style="border:2px solid #e1e1e1;">
		<legend style="border:1px solid #e1e1e1;margin-left:10px;padding:3px;font:bold 12px arial;"> Commission Details</legend>
		<table cellpadding="0" cellspacing="0" class="" class="con_com" >


		<?php if (( $this->_tpl_vars['ctype'] == 'approved' && count ( $this->_tpl_vars['commissions'] ) > 0 )): ?>

		<form name="commission" id="commission" class="" action="commission-details.php?type=approved" method="post">

				<!-- My check-->
				
			<tr style="font-weight: bold;">
				<td width="10%">All</td>
				<td width="20%"><?php echo $this->_tpl_vars['lang']['sale_date']; ?>
</td>
				<td width="20%"><?php echo $this->_tpl_vars['lang']['status']; ?>
</td>
				<td width="20%"><?php echo $this->_tpl_vars['lang']['sale_amount']; ?>
</td>
				<td width="20%"><?php echo $this->_tpl_vars['lang']['action']; ?>
</td>
			</tr>

		<?php $_from = $this->_tpl_vars['commissions']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['commission']):
?>
			<tr>

				<td><input type="checkbox" value="<?php echo $this->_tpl_vars['commission']['id']; ?>
" name='com[]' style="width:30px"; /></td>
				<td><?php echo $this->_tpl_vars['commission']['date']; ?>
</td>
				<td><?php if ($this->_tpl_vars['commission']['approved']):  echo $this->_tpl_vars['lang']['approved'];  else:  echo $this->_tpl_vars['lang']['pending'];  endif; ?></td>
				<td><?php echo $this->_tpl_vars['commission']['payment']; ?>
</td>
				<td><a href="commission-details.php?<?php if ($_GET['type']): ?>type=<?php echo $_GET['type']; ?>
&<?php endif;  if ($_GET['page']): ?>page=<?php echo $_GET['page']; ?>
&<?php endif;  if ($_GET['items']): ?>items=<?php echo $_GET['items']; ?>
&<?php endif; ?>id=<?php echo $this->_tpl_vars['commission']['id']; ?>
" ><?php echo $this->_tpl_vars['lang']['small_view_details']; ?>
</a></td>
			</tr>
		<?php endforeach; endif; unset($_from); ?>

		       

<tr>   <!-- My check-->

					<td style="width:100px";><input type="checkbox" value="0" name='checkall' onclick="checkUncheckAll(this);" style="width:30px"; /></td>
					<td><label class="ml-10"> All/ None</label></td>
			<td colspan="3" align="left" style="text-align:left; padding-left:20px;">
					<select name="approve_saleslist" onchange="approve_deallist();" style="width:80px";>
					<option value="">-Choose-</option>
					<option value="1">Process</option>
					</select></td>
</tr>

                   
                      <input type="hidden" name="fund" value="1" />
		 </from>
		 <?php endif; ?>
		</table>
	</fieldset>
		<br />
		<?php echo $this->_tpl_vars['navigation']; ?>

		</div>
	<?php else: ?>
		<strong class="fl"><?php echo $this->_tpl_vars['lang']['msg_account_pending_approval']; ?>
</strong>
	<?php endif; ?>
<?php elseif ($this->_tpl_vars['commission']['id'] > 0): ?>

	<a href="commission-details.php?<?php if ($_GET['type']): ?>type=<?php echo $_GET['type'];  endif;  if ($_GET['page']): ?>&page=<?php echo $_GET['page']; ?>
&<?php endif;  if ($_GET['items']): ?>items=<?php echo $_GET['items'];  endif; ?>" class="fl clr pb10"><?php echo $this->_tpl_vars['lang']['return_go_back']; ?>
</a><br />
	<br />
	<fieldset style="border:1px solid #e1e1e1;">
		<legend style="border:1px solid #e1e1e1;margin-left:10px;padding:3px;font:bold 12px arial;"> Commission Details</legend>
	<table border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCCC" width="100%">
		<tr>
			<td width="150" bgcolor="#FFFFFF" style="padding: 2px 10px;line-height:30px;" align="right"><strong><?php echo $this->_tpl_vars['lang']['sale_date']; ?>
</strong></td>
			<td bgcolor="#FFFFFF" style="padding: 2px 10px;line-height:30px;"><?php echo $this->_tpl_vars['commission']['date']; ?>
 <?php echo $this->_tpl_vars['commission']['time']; ?>
</td>
		</tr>
		<tr>
			<td bgcolor="#FFFFFF" style="padding: 2px 10px;line-height:30px;" align="right"><strong><?php echo $this->_tpl_vars['lang']['sale_amount']; ?>
</strong></td>
			<td bgcolor="#FFFFFF" style="padding: 2px 10px;line-height:30px;"><?php echo $this->_tpl_vars['commission']['payment']; ?>
</td>
		</tr>		
		<tr>
			<td bgcolor="#FFFFFF" style="padding: 2px 10px;line-height:30px;" align="right"><strong><?php echo $this->_tpl_vars['lang']['commissions']; ?>
</strong></td>
			<td bgcolor="#FFFFFF" style="padding: 2px 10px;line-height:30px;"><?php echo $this->_tpl_vars['commission']['payout']; ?>
</td>
		</tr>
		<tr>
			<td bgcolor="#FFFFFF" style="padding: 2px 10px;line-height:30px;" align="right"><strong><?php echo $this->_tpl_vars['lang']['order_number']; ?>
</strong></td>
			<td bgcolor="#FFFFFF" style="padding: 2px 10px;line-height:30px;"><?php echo $this->_tpl_vars['commission']['order_number']; ?>
</td>
		</tr>
	</table>
    </fieldset>
<?php elseif ($_GET['id'] > 0): ?>
	<strong style="color: #FF0000"><?php echo $this->_tpl_vars['lang']['msh_incorrect_param']; ?>
</strong>
<?php endif; ?>	
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>