<?php
$d = $_GET['docroot'];
if(file_exists($d.'system/includes/dboperations.php'))
{ 
	include_once '../system/includes/dboperations.php';
	$link = mysql_connect($hostname, $muser, $pass) or die('Could not connect: ' . mysql_error());
	$tablename= $prefix.'general_settings';
	$tables = mysql_list_tables($db);
	$num_tables = @mysql_numrows($tables);
	$i = 0;
	$exist = 0;
	while($i < $num_tables)
	{
	$tablename = mysql_tablename($tables, $i);
	if ($tablename=='table_search') $exist=1;
	$i++;
	}
	if ($exist==0)
	{
		//if the table does not exist
		$e=$_SERVER['REQUEST_URI'];
		$e = trim($e,"install.php.");
		header("Location: $e");
	}
	else 
	{
	//the table exist
		$docroot=$_SERVER['REQUEST_URI'].'process.php';
	?>
        <script type="text/javascript">
        window.location = "<?php echo $docroot; ?>";
        </script>
        <?php
		exit;
	}
	mysql_close($connect);

}

	//Second Request Start Here
	if(isset($_POST['step2']))
	{
	
		/*Database Information*/
		$host  = trim($_POST['host']);
		$db  = trim($_POST['db']);
		$user   = trim($_POST['user']);
		$pass = trim($_POST['pass']);
		//$prefix  = trim($_POST['prefix']);
		$table = trim($_POST['table']);
		$docroot = trim($_POST['docroot']);
		
		/* data base connection */
		$link = mysql_connect($host, $user, $pass);
		if($link)
		{
			$url="";
		}
		else
		{
			$url = $_SERVER['REQUEST_URI'];
			$msg1 = '1';
			?>
<script type="text/javascript">
			window.location = "<?PHP echo "?docroot=$docroot&msg1=$msg1"; ?>";			 
			</script>
<?php exit;
		}
		
		/* db select */
		$select = mysql_select_db($db);
		if($select)
		{
		        
			$url='';
		
		
		}
		else
		{   
			$url = $_SERVER['REQUEST_URI'];
			$msg2 = '2';
			?>
<script type="text/javascript">
			window.location = "<?PHP echo $url."?docroot=$docroot&msg2=$msg2"; ?>";			 
			</script>
<?php 
		exit;
                }

		$perm = substr(sprintf('%o', fileperms('../system/includes')), -4);
		$perm2 = substr(sprintf('%o', fileperms('../uploads')), -4);
		$perm3 = substr(sprintf('%o', fileperms('../system/plugins')), -4);

		if($perm!="0777" || $perm2!="0777" || $perm3!="0777")
		{
		    $msg3=''; $msg4=''; $msg5='';

		       if($perm!="0777")
	 			$msg3 = '3';
		       if($perm2!="0777")
	 			$msg4 = '4';
		       if($perm3!="0777")
	 			$msg5 = '5';

			?>
<script type="text/javascript">
			window.location = "<?PHP echo "?docroot=$docroot&msg3=$msg3&msg4=$msg4&msg5=$msg5"; ?>";			 
			</script>
<?php
		}
		else
		{
				$str='<?php 
				$docroot="yourserverpath"; 
				
				define("DOCROOT", $docroot); 
		
                                $docroot_aff = $docroot."system/affiliate/";

                                define("DOCROOT_A", $docroot_aff);
				?>';
				$str=str_replace('yourserverpath',$docroot,$str);
		        $fp=fopen('../system/includes/docroot.php','w');
		        
			fwrite($fp,$str,strlen($str));
			fclose($fp);
			
			//$str=implode("",file($d.'includes/sample-dboperations.php'));	
			$str= '<?php 
			$hostname = "yourhostname";
	                $pass = "yourmysqlpassword";
	                $muser	  = "yourmysqlusername";
	                $dbconn = mysql_connect($hostname, $muser, $pass);
	                $db ="yourdbname";
	                mysql_select_db($db);
	                ?>';	
			/*Config File Writing Starts here*/
			$str=str_replace('yourhostname',$host,$str);
			$str=str_replace('yourdbname',$db,$str);
			$str=str_replace('yourmysqlusername',$user,$str);
			$str=str_replace('yourmysqlpassword',$pass,$str);
			
			$fp=fopen('../system/includes/dboperations.php','w');
			fwrite($fp,$str,strlen($str));
			fclose($fp);
	                	
		        $url1 = $_SERVER['REQUEST_URI'];
		        ?>
<script type="text/javascript">
		        window.location = "<?php echo $url."process.php"; ?>";
		        </script>
<?php
		}
      
		
			/*Installation Step:1 Ends Here*/
	}/*First Request Process Ends here*/
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="Content-Style-Type" content="text/css">
<title>NDOT Deals Installation Step 1</title>
<link rel="stylesheet" href="style.css" type="text/css">
</head>
<style type="text/css">
body,td {
	width: 100% !important;
	margin: 0 auto;
	font-family: sans-serif;
	font-size: 11px;
}
#tests table {
	border-collapse: collapse;
	width: 100%;
}
#tests table th, #tests table td {
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
    <th width="500" class="colorblue" align="left"> <h3 align="center">NDOT DEALS Unlimited Version 3.1 Installation...</h3></th>
  </tr>
  <tr>
    <td colspan="2" id="ready_image"><a href="http://www.ndot.in/products/ndotdeals-opensource-groupon-clone" target="_blank" title="Groupon clone"> <img src="images/install.png" alt="NDOT DEALS" border="0" height="190" width="698" style="margin-top:10px;"></a></td>
  </tr>
  <tr>
    <td>&nbsp;
    <h2 style="border-bottom:1px solid #ddd; background:#ececec; padding:5px;">STEP 1 of 2</h2>
	<!--<div align="center" > For installation instructions <a href="readme.txt" target="_blank" title="NDOT">Readme.txt</a></div>-->
    
      <p>
        <?php  $d = trim($_SERVER['SCRIPT_FILENAME'],"install.php");
	if(isset($_GET['msg1']))
	{
		$msg1=$_GET['msg1'];
	if($msg1==1)
		echo '<font color="red">The given information is not correct please re-enter!</font>';
	}


	if(isset($_GET['msg2']))
	{
		$msg2=$_GET['msg2'];
	if($msg2==2)
		echo '<font color="red">The database is not correct please re-enter!</font>';
	}

	if(isset($_GET['msg3']))
	{
		$msg3=$_GET['msg3'];
			if($msg3==3)
			{
			echo '<font color="red">The /system/includes folder does not have write permission please set "777" permission!</font><br/>';
			}
	}
        if(isset($_GET['msg5']))
	{
		$msg5=$_GET['msg5'];
			if($msg5==5)
			{
			echo '<font color="red">The /system/plugins folder does not have write permission please set "777" permission!</font><br/>';
			}
	}
	if(isset($_GET['msg4']))
	{
		$msg4=$_GET['msg4'];
			if($msg4==4)
			{
			echo '<font color="red">The /uploads folder does not have write permission please set "777" permission!</font><br/>';
			}
	}

	
?>
        <script type="text/javascript">

$(document).ready(function(){$("#install").validate();});

</script>
        <?php $docroot = $_GET["docroot"]; ?>
<form action="" method="post" name="install_form" id="install" >
  <input name="docroot" value="<?php echo $docroot; ?>" type="hidden">
  <table border="0" align="center" cellpadding="5" cellspacing="5"  class="table2">
    <tr>
      <td width="414"><div align="center">
          <table width="422" border="0" >
            <tr>
              <td width="100px">Host Name
              <td width="10">
              <td width="10">:</td>
              <td width="201"><input type="text" name="host" class="required" title="Enter your hostname"/></td>
            </tr>
            <tr>
              <td>Database Name
              <td>
              <td>:</td>
              <td><input type="text" name="db" class="required" title="Enter your database name correctly"/></td>
            </tr>
            <tr>
              <td>DB Username
              <td>
              <td>:</td>
              <td><input type="text" name="user" class="required" title="Enter your database user name"/></td>
            </tr>
            <tr>
              <td>DB Password
              <td>
              <td>:</td>
              <td><input type="password" name="pass" class="" title="Enter your database password"/></td>
            </tr>
          </table>
        </div></td>
      <td width="10"></td>
  </table>
  <table width="722" border="0">
    <tr>
      <td><div align="right">
          <input name="step2" type="submit" value="" class="next" cursor:pointer;/>
        </div></td>
    </tr>
  </table>
  </td>
  </tr>
  </table>
  &nbsp;
</form>
<div align="center" > Copyright &copy; 2011 <a href="http://www.ndot.in" target="_blank" title="NDOT">NDOT</a></div>
<br/>
  </td>
  </tr>
  </tbody>
  </table>
</body>
</html>
