<?php if($_POST)
	{

		ini_set('memory_limit','64M');
		set_time_limit(1600);

		$adminname = $_POST['name'];
		$adminpassword = $_POST['password'];
		$adminemail = $_POST['email'];
		/*Getting information for Db connectivity from dboperations.php file */
		include_once '../system/includes/dboperations.php';
		include_once '../system/includes/docroot.php';
		include_once '../system/includes/functions.php';
		
		/*Getting api key*/
		if(isset($_SERVER['SERVER_NAME']))
                {
                $site_url = 'http://'.$_SERVER['SERVER_NAME'];
	        }else{
	        $site_url = ''; }
	        
	        $api_code = $_POST["api_key"];
	        //$url = "http://www.ndot.in/ndot/api/?key=".$api_code."&url=".$site_url;
	        $url = "http://www.ndot.in/ndot/api/?key=".$api_code."&url=".$site_url."&pid=9";
	        
        if(function_exists('curl_init')) 
        {
	        $ch = curl_init();    // initialize curl handle
	        curl_setopt($ch, CURLOPT_URL,$url); // set url to post to
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); // return into a variable
	        curl_setopt($ch, CURLOPT_TIMEOUT, 120); // times out after 120s
	        curl_setopt($ch, CURLOPT_POSTFIELDS, $XPost); // add POST fields
	        $result = trim(curl_exec($ch)); // run the whole process
			
			//save this result to text file
			
        	$myFile = "../uploads/testFile.txt";
			$fh = fopen($myFile, 'w');
			fwrite($fh, $result);
			fclose($fh);
			
	        //$con  = mysql_connect("localhost","root","ndot");
	        //mysql_select_db("ndotdeals");
	
	        //xml parsing
	        $xml = new SimpleXmlElement($result);
	        if($xml)
	        {
	           $msg='';
	        }else{
	           
	           $msg = "There is a internet connection bandwidth problem. Try by clicking the refresh key!";
	           echo $msg;
	           exit;
	        }
	        //echo $response = $xml->response;
                //echo print_r($xml);
	        //exit;
	        	        
	        if($xml->response == "success")
	        {
		        /* foreach($xml->line as $row)
		          {     
		           $row1 = decrypt_string($row); 
			   //echo $row1.'<br><br>';
                           mysql_query($row1) or die("Could not perform query - " . mysql_error()); 
			   } */
			    for($i=0;$i<=61;$i++)
			    {
			       $row1 = $xml->line[$i];
			       $row1 = decrypt_string($row1);
			       mysql_query($row1);
			       //echo $row1.'<br><br>';
			       if(mysql_error())
			        {
			          echo "There was a unknow problem occured, While installing your application. Try to follow the instructions and install again!";
			          echo "<br />1. Before reinstalling DROP the existing tables in your dadabase.";
			          echo "<br />2. Delete the files dboprations.php and docroot.php in /system/includes folder, If it exists.";
			          exit;
			        }
			    }
			    //exit; 
	        }
	        else{
	                        echo $xml->response;
	                        exit;
	        }
	        
                       /* $str='<?php 
                        $key="yourlicensekey";  
                        define("API_KEY", $key); 
                        ?>';
                        $str=str_replace('yourlicensekey',$api_code,$str);
                        $fp=fopen('../system/includes/api_key.php','w');

                        fwrite($fp,$str,strlen($str));
                        fclose($fp);*/
			
                  srand(time());     
	          $random_letter_lcase  = chr(rand(ord("a"), ord("z"))); 
	          $random_letter_ucase  = chr(rand(ord("A"), ord("Z")));
	          $random_letter_number = chr(rand(ord("0"), ord("9")));
	          $random_letter_lcase1 = chr(rand(ord("a"), ord("z")));  
	          $random_letter_lcase2 = chr(rand(ord("a"), ord("z"))); 
	          $random_letter_ucase2 = chr(rand(ord("A"), ord("Z")));
	          $random_letter_number2= chr(rand(ord("0"), ord("9")));
	          $random_letter_lcase2 = chr(rand(ord("a"), ord("z")));  
	  
	  $randomvalue = $random_letter_lcase.$random_letter_ucase.$random_letter_number.$random_letter_lcase1.$random_letter_lcase2.$random_letter_ucase2.$random_letter_number2.$random_letter_lcase2;

	  $sql="INSERT INTO `coupons_users` (`userid`,`username`, `password`, `firstname`, `lastname`, `email`,`user_role`, `user_status`, `created_by`, `referral_id`, `created_date`) VALUES 
('1','$adminname',md5('$adminpassword'),'$adminname','$adminname','$adminemail','1','A','1','$randomvalue',now());";
	        $exe=mysql_query($sql) or die('Query failed: ' . mysql_error());
                               
                $exe1=mysql_query("update general_settings set site_license_key = '$api_code' where id = 1 ") or die('Query failed: ' . mysql_error());
                
		//****** Creating Table ends here*******//
		$docroot = DOCROOT;
		?> 
		<script type="text/javascript">
		window.location="<?php echo $docroot; ?>";
		</script>
		<?php 
		exit;
		/*Installation Ends Here*/
	}else{
	
	$_SESSION["Enable_curl"] = "Enable Curl";

	}

}//Second Request Process Ends here 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>NDOT Deals Installation: Step 2</title>
<link rel="stylesheet" href="style.css" type="text/css">
<script src="../public/js/jquery.js" type="text/javascript"></script>
<script src="../public/themes/default/js/jquery.validate.js" type="text/javascript"></script>
<script src="../public/js/jquery.validate.js" type="text/javascript"></script>
<SCRIPT language=JavaScript type=text/javascript>
function checkrequired(which) {
var pass=true;
if (document.images) {
for (i=0;i<which.length;i++) {
var tempobj=which.elements[i];
if (tempobj.name.substring(0,8)=="title" || tempobj.name.substring(0,8)=="email" || tempobj.name.substring(0,8)=="name" || tempobj.name.substring(0,8)=="password" || tempobj.name.substring(0,8)=="tbname") {
if (((tempobj.type=="text"||tempobj.type=="text"||tempobj.type=="text"||tempobj.type=="text")&&
tempobj.value=='')||(tempobj.type.toString().charAt(0)=="s"&&
tempobj.selectedIndex==0)) {
pass=false;
break;
}
}
}
}
if (!pass) {
shortFieldName=tempobj.name.substring(8,30).toUpperCase();
alert("Please enter all required fields.");
return false;
}
else
return true;
}

$(document).ready(
  function()
  {
	 // show
	   $("#yourtable").click(function()
	    {
		$("#tblshow").show("slow");
	    });
		 // hide
	   $("#ndottable").click(function()
	    {
		$("#tblshow").hide("slow");
	    }); 
  });
</script>
</head>
<body style="width:100% !important; font-size:12px;">
<table class="shell" align="center" border="0" cellpadding="5" cellspacing="5" style="margin-top:10px; border:5px solid #ddd;">
  <tbody>
    <tr>
      <th width="500" class="colorblue" align="left"> <h3 align="center">NDOT DEALS Unlimited Version 3.1 Installation...</h3></th>
    </tr>
    <tr>
      <td colspan="2" id="ready_image"><a href="http://www.ndot.in/products/ndotdeals-opensource-groupon-clone" target="_blank" title="Groupon clone"> <img src="images/install.png" alt="NDOT DEALS" border="0" height="190" width="698" style="margin-top:10px;"></a></td>
    </tr>
    <tr>
    <td>
    &nbsp;
    <h2 style="border-bottom:1px solid #ddd; background:#ececec; padding:5px;">STEP 2 of 2</h2>
    
    <?php if(isset($_SESSION["Enable_curl"])){ ?>
    <div style="text-align:center;font-size:13px; color:red; background:#ececec; padding:5px;" >Curl is not enabled in your server!</div>
    <?php } ?>
    <div align="center" > For installation instructions <a href="readme.txt" target="_blank" title="NDOT">Readme.txt</a></div>
    <?php
if(isset($_GET['msg1']))
{
$msg1=$_GET['msg1'];
if($msg1==1)
echo '<font color=red>Please enter the your Users tables correctly or the package will not work properly!</font>';


if($msg1==2)
echo '<font color=red>Users table does not exist!</font>';
}
?>
    <script type="text/javascript">

$(document).ready(function(){$("#install").validate();});

</script>
    <form action="" method="post" name="install_form" id="install" >
    
    <table border="0" align="center" cellpadding="5" cellspacing="5"  class="table2">
      <tr>
        <td width="516"><table width="506" border="0" >
            <tr>
              <td width="212">Your Application Name
              <td width="10">
              <td width="8">:</td>
              <td width="268"><input type="text" name="title" value="NDOT DEALS Unlimited Version 3.1" class="required" title="Enter your Application Name" style="width:250px;"/></td>
            </tr>
            <tr>
              <td>Admin Email id
              <td>
              <td>:</td>
              <td><input type="text" name="email" class="required" title="Enter an e-mail" style="width:250px;" /></td>
            </tr>
            <tr>
              <td>Admin Name
              <td>
              <td>:</td>
              <td><input type="text" name="name" class="required" title="Enter the admin name" style="width:250px;" /></td>
            </tr>
            <tr>
              <td>Admin Password
              <td>
              <td>:</td>
              <td><input type="password" name="password" class="required" title="Enter the password" style="width:250px;"/></td>
            </tr>
            <tr>
              <td>Your License Key
              <td>
              <td>:</td>
              <td><input type="text" name="api_key" title="Enter the API Code" style="width:250px;" /></td>
            </tr>
            <input type="hidden" name="table" value="ndottbl" id="ndottable" title="Create Ndot's User Table"/>
           
          </table>
          
          <table width="420" border="0">
            <tr>
              <td width="225" align="right"><input name="" type="reset" value="" class="reset"/>
              <td width="13">
              <td width="45"></td>
              <td width="119"><input name="" type="submit" value="" class="next"/></td>
            </tr>
          </table></td>
    </table>
    </td>
    </tr>
</table>
<br/>
<div align="center" > Copyright &copy; 2012 <a href="http://www.ndot.in" target="_blank" title="NDOT">NDOT</a></div>
<br/>
  </td>
  </tr>
  </tbody>
  </table>
</body>
</html>

