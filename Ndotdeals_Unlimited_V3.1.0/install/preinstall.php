<?php /*
  $content = @file_get_contents($_GET['docroot']."/modcheck.php");
  if ($content == 1) { 
	//print "The apache module mod_rewrite is enabled"; 
	$mod_rewrite_permission = 1; 
	} 
  else {
	print "<p style='color:red;width:500px;margin-top:20px;font-weight:bold;'>The apache module mod_rewrite is NOT enabled. You must have to enable, apache module mod_rewrite to proceed the Installation.</p>";
	$mod_rewrite_permission = 0;
  }
*/
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="Content-Style-Type" content="text/css">
<title>Welcome to the NDOT DEALS Unlimited Version 3.1 Installation Wizard</title>
<link rel="stylesheet" href="style.css" type="text/css">
</head>
<style type="text/css">
body{ width:100% !important; }
body,td {
	margin: 0 auto;
	font-family: sans-serif;
	font-size: 12px;
}
#tests table {
	border-collapse: collapse;
	width: 100%;
}
#tests table th,  #tests table td {
	padding: 0.2em 0.4em;
	text-align: left;
	vertical-align: top;
}
#tests table th {
	width: 12em;
	font-weight: normal;
	font-size: 1.2em;
}
 #tests table tr:nth-child(odd) {
background: #eee;
}
#tests table td.pass {
	color: #003300;
}
#tests table td.fail {
	color: #911;
}
#tests #results {
	color: #fff;
}
#tests #results p {
	padding: 0.2em 0.4em;
}
#tests #results p.pass {
	background: #003300;
}
#tests #results p.fail {
	background: #911;
}
.style1 {
	font-size: 14px;
	font-weight: bold;
}
.install_footer {
	margin-bottom:10px;
	text-align:right;
	color:#333;
}
.install_footer a {
	text-decoration:none;
	color:#333;
}
.install_footer a:hover {
	text-decoration:underline;
}
</style>
<body>
<?php $docroot = $_GET["docroot"]; ?>
<form action="install.php?docroot=<?php echo $docroot; ?>" method="post" name="form" id="form">
  <table class="shell" align="center" border="0" cellpadding="5" cellspacing="5" style="margin-top:10px; border:5px solid #ddd;">
    <tbody>
      <tr>
        <th width="500" class="colorblue" align="left"> <h3>Welcome to the NDOT DEALS Unlimited Version 3.1 Installation Page</h3></th>
      </tr>
      <tr><td>
      <p style="background:#fffa00; border:1px solid #ff6600; padding:5px;">Read the installation instructions & documentations carefully to setup the application !</p>
	<!--<div align="center" > For installation instructions <a href="readme.txt" target="_blank" title="NDOT">Readme.txt</a></div>-->
      
      </td></tr>
      <tr>
        <td colspan="2" id="ready_image"><a href="http://www.ndot.in/products/ndotdeals-opensource-groupon-clone" target="_blank" title="Groupon clone"> <img src="images/install.png" alt="NDOT DEALS" border="0" height="190" width="698" style="margin-top:10px;"></a></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" id="ready" class="font12 colorblue"><strong>Are you ready to install?</strong> </td>
      </tr>
      <tr>
        <td colspan="2"><p class="color999"><strong>Please
            read the following important information before proceeding with the
            installation. The information will help you to determine whether 
            you are ready to install the application at this time.</strong></p>
          <table class="Welcome" border="0" cellpadding="0" width="100%">
            <tbody>
              <tr>
                <th align="left"> <span style="cursor: pointer;"><span id="adv_sys_comp" style="display: none;"> <img src="install.php_files/advanced_search.gif" border="0"> </span>&nbsp;<span class="font12 colorblue">Required System Components</span> </span> </th>
              </tr>
              <tr>
                <td><div id="sys_comp" class="color999"> Before you begin, please be sure that you have the supported versions of the following system components:<br>
                    <ul>
                      <li>MySQL (version 5 or higher) </li>
                      <li>PHP (version 5.2+ ) </li>
                      <li>Apache (version 2.2+ ) </li>
                      <li>Curl (<?php
if(function_exists('curl_init')) {
echo '<span style="font-color:green;">Enabled!</span>';
}else{
echo '<span style="font-color:red;">Must be Enabled!</span>';
}
?>)</li>
                      <li>.htaccess and mod_rewrite should be enabled in your web server</li>
                    </ul>
                    <br>
                  </div></td>
              </tr>
            </tbody>
          </table>
          </ul>
          </li>
          </div>
  <table class="Welcome" border="0" cellpadding="0" width="100%">
    <tbody>
      <tr>
        <th align="left"><span style="cursor: pointer;">
        <span id="adv_installType" style="display: none;"><img src="install.php_files/advanced_search.gif" border="0"></span>&nbsp;
        <span class="font12 colorblue">Install Process Flow by steps</span> </span></th>
      </tr>
      <tr>
        <td><div id="installType" class="font12">
            <p class="pge6 p5"><strong>Step:1</strong></p>
            <p>If all the Initial system check has passed then give next in the bottom of this page.</p>
            <p>1. Given the host name correctly. For example. &quot;localhost&quot;.</p>
            <p>2. Give the database details - User, Password and DB name correctly. If database has not created yet then first create the database.</p>
            <p class="pge6 p5"><strong>Step:2</strong></p>
            <p>1. Give your site title and admin email id and password.</p>
            <p>2. If there is any problem while installation contact us for clearification.<br>
              <br>
          </div></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </tbody>
  </table>

      <input name="current_step" value="0" type="hidden">
      <table class="stdTable" border="0" cellpadding="0" cellspacing="0">
        <tbody>
          <tr>
            <td><input name="goto" value="Back" type="hidden"></td>
            <td><input class="next"  value="" type="submit"/></td>
          </tr>
        </tbody>
      </table>  
          </td>
      </tr>
    </tbody>
  </table>
  <br/>
<div align="center" > Copyright &copy; 2011 <a href="http://www.ndot.in" target="_blank" title="NDOT">NDOT</a></div>

  </td>
  </tr>
  </tbody>
  </table>
</form>
</body>
</html>
