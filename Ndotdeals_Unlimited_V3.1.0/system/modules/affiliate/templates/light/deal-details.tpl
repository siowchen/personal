{include file="header.tpl"}

<h2>Deal Details</h2>

<form name="code1">
<fieldset style="border:1px solid #e1e1e1;float:left;margin-left:20px;">
                <legend style="border:1px solid #e1e1e1;font:bold 12px arial;padding:3px;margin-left:20px;">Deal Details</legend>
                <table class="banners fl" style="padding:10px;" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td valign="top" width="25%"><label>Deal Name:</label></td>
		<td valign="top" width="75%"><p>{$deal.coupon_name }</p></td>
	</tr>
	<tr>
		<td valign="top" width="25%"><label>City:</label> </td>
		<!-- <td valign="top"><p>{$deal.coupon_city} ({$city})</p></td> -->
        <td valign="top" width="75%"><p>{$city}</p></td>
	</tr>
	<tr>
		<td valign="top" width="25%"><label>Deal Discription:</label> </td>
		<td valign="top" width="75%"><p>{$deal.desc}</p></td>
	</tr>
	<tr>
		<td valign="top" width="25%"><label>Deal Image:</label> </td>
		<td valign="top" align="left" width="75%"><img src="{$deal.coupon_image}" align="left" /></td>
	</tr>
    </table>
    </fieldset>
	<table class="banners" style="padding-top: 10px;float:left:clear:both;" cellpadding="0" cellspacing="0">
	<tr>
		<td colspan="2" style="color: #5F5F5F;">{$lang.banner_code}</td>
	</tr>
	<tr>
		<td colspan="2"><textarea name="c1" style="width: 594px; height: 100px; color: #CF6600;" onfocus="this.select();">{$code}</textarea></td>
	</tr></table>
</form>

{include file="footer.tpl"}
