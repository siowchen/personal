{include file="header.tpl"}

<h2>Fund Raising</h2>

{$msg}

<form name="contact_us" action="fund-raising.php" method="post"><table border="0" cellpadding="0" cellspacing="0" width="100%">
      <tbody>
      <tr>
        <td><img src="{$images}pixel_trans.gif" alt="" border="0" height="10" width="100%"></td>

      </tr>
      <tr>
        <td><table class="infoBox" border="0" cellpadding="2" cellspacing="1" width="100%">
          <tbody><tr class="infoBoxContents">
            <td><table border="0" cellpadding="2" cellspacing="0" width="100%">
              <tbody><tr>
                <td class="main" colspan="2">{$lang.full_name}:</td>
              </tr>
              <tr>
              <td> Your Earnings : ${$stat.earnings}</td>
              <td> Your Commission amount : ${$com}</td>
                
              </tr>
              <tr>
                <td class="main"  colspan="2"><input name="com" type="text" value="{$form.com}"></td>
              </tr>
            </tbody></table></td>

          </tr>
        </tbody></table></td>
      </tr>
      <tr>
        <td><img src="{$images}pixel_trans.gif" alt="" border="0" height="10" width="100%"></td>
      </tr>
      <tr>
        <td><table class="infoBox" border="0" cellpadding="2" cellspacing="1" width="100%">
          <tbody><tr class="infoBoxContents">

            <td><table border="0" cellpadding="2" cellspacing="0" width="100%">
              <tbody><tr>
                <td width="10"><img src="{$images}pixel_trans.gif" alt="" border="0" height="1" width="10"></td>
                <td align="right"><input src="{$images}button_continue.gif" alt=" {$lang.continue} " title=" {$lang.continue} " border="0" type="image"></td>
                <td width="10"><img src="{$images}pixel_trans.gif" alt="" border="0" height="1" width="10"></td>
              </tr>
            </tbody></table></td>
          </tr>
        </tbody></table></td>

      </tr>
    </tbody></table>
	<input type="hidden" name="fund" value="1" />
</form>

{include file="footer.tpl"}
