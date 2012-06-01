<?php
/******************************************
* @Created on March, 2011 * @Package: Ndotdeals unlimited v2.2 
* @Author: NDOT
* @URL : http://www.ndot.in
********************************************/
?>
<?php
include "dboperations.php";
session_start();
$userid = $_SESSION["userid"];

# User Informations
class UserInfomation
{
var $username;
var $password;
var $firstname;
var $lastname;
var $email;
var $mobile;
var $address;
var $country;
var $ctype;

	function setusername($value)
	{
	$this->username = $value;
	}

	function getusername()
	{
	return $this->username;
	}

	function setpassword($value)
	{
	$this->password = $value;
	}

	function getpassword()
	{
	return $this->password;
	}

	function setfirstname($value)
	{
	$this->firstname = $value;
	}


	function getfirstname()
	{
	return $this->firstname;
	}

	function setlastname($value)
	{
	$this->lastname = $value;
	}

	function getlastname()
	{
	return $this->lastname;
	}

	function setemailaddr($value)
	{
	$this->email = $value;
	}

	function getemailaddr()
	{
	return $this->email;
	}

	function setmobileno($value)
	{
	$this->mobile = $value;
	}

	function getmobileno()
	{
	return $this->mobile;
	}

	function setaddress($value)
	{
	$this->address = $value;
	}

	function getaddress()
	{
	return $this->address;
	}

	function setcountry($value)
	{
	$this->country = $value;
	}

	function getcountry()
	{
	return $this->country;
	}

	function setcity($value)
	{
	$this->city = $value;
	}

	function getcity()
	{
	return $this->city;
	}

	function setusershopid($value)
	{
	$this->user_shopid = $value;
	}

	function getusershopid()
	{
	return $this->user_shopid;
	}

	function setctype($value)
	{
	$this->ctype = $value;
	}

	function getctype()
	{
	return $this->ctype;
	}

		function getuserinfomation($userid)
		{
			$queryString = "SELECT * FROM coupons_users where userid = '$userid'";
			$resultSet = mysql_query($queryString);
				if(mysql_num_rows($resultSet) > 0)
				{
					while($row = mysql_fetch_array($resultSet))
					{
						$this->username = html_entity_decode($row['username'], ENT_QUOTES);
						$this->password = $row['password'];
						$this->firstname = html_entity_decode($row['firstname'], ENT_QUOTES);
						$this->lastname = html_entity_decode($row['lastname'], ENT_QUOTES);
						$this->email = $row['email'];
						$this->mobile = html_entity_decode($row['mobile'], ENT_QUOTES);
						$this->address = html_entity_decode($row['address'], ENT_QUOTES);
						$this->country = $row['country'];
						$this->city = $row['city'];
						$this->user_shopid = $row['user_shopid'];
						$this->ctype = $row['coupontype'];
					}
				}
		}

}

# Update Admin Information
function updateAdminInformation($userid,$firstname,$lastname,$email,$mobile,$address,$country,$city)
{

	if($city=='')
	{
	$queryString = "update coupons_users set firstname = '$firstname' ,lastname = '$lastname', email = '$email', mobile = '$mobile', address = '$address', country = '$country' where userid= '$userid'";

	}
	else
	{
	$queryString = "update coupons_users set firstname = '$firstname' ,lastname = '$lastname', email = '$email', mobile = '$mobile', address = '$address', country = '$country', city ='$city' where userid= '$userid'";

	}
	
	mysql_query($queryString) or die(mysql_error());
	return 1;
}

# Update Store Admin Information
function updateStoreAdminInformation($userid,$firstname,$lastname,$email,$mobile,$address,$country,$city,$shopname)
{

	$queryString = "SELECT shop_country FROM coupons_shops where shopid='$shopname'";
	$resultSet = mysql_query($queryString);

		if($row = mysql_fetch_array($resultSet))
		{
			$rs = $row['shop_country'];
		}


		if($rs == $country)
		{
	
			if($city!='')
			{
				$queryString = "update coupons_users set firstname = '$firstname' ,lastname = '$lastname', email = '$email', mobile = '$mobile', address = '$address', user_shopid='$shopname', country = '$country', city ='$city' where userid= '$userid'";
	
			}
			else{
				$queryString = "update coupons_users set firstname = '$firstname' ,lastname = '$lastname', email = '$email', mobile = '$mobile', address = '$address', user_shopid='$shopname', country = '$country' where userid= '$userid'";
			}
		     
			mysql_query($queryString) or die(mysql_error());
			return 1;
		}
		else
		{
			return 0;
		}

}

# Update City Manager Information
function updateCityMgrInformation($userid,$firstname,$lastname,$email,$mobile,$address,$country,$city,$shopname)
{

	if($country!='' && $city=='')
	{
		$queryString = "update coupons_users set firstname = '$firstname' ,lastname = '$lastname', email = '$email', mobile = '$mobile', address = '$address',country = '$country' where userid= '$userid'";
		mysql_query($queryString) or die(mysql_error());
		return 1;
	}

	if($country!='' && $city!='')
	{
		if($shopname!='')
		{
		$queryString = "SELECT shop_city FROM coupons_shops where shopid='$shopname'";
		$resultSet = mysql_query($queryString);
			if($row = mysql_fetch_array ($resultSet))
			{
				$rs = $row['shop_city'];
			}
				if($rs == $city)
				{
					$queryString = "update coupons_users set firstname = '$firstname' ,lastname = '$lastname', email = '$email', mobile = '$mobile', address = '$address',country = '$country',city = '$city',user_shopid = '$shopname' where userid= '$userid'";
					mysql_query($queryString) or die(mysql_error());
					return 1;
				}
				else
				{
					return 0;
				}
		}
		else
		{
				$queryString = "update coupons_users set firstname = '$firstname' ,lastname = '$lastname', email = '$email', mobile = '$mobile', address = '$address',country = '$country',city = '$city',user_shopid = '$shopname' where userid= '$userid'";
				mysql_query($queryString) or die(mysql_error());
				return 1;
		}
	}

}

# Edit Coupon Details
class EditCouponDetails
{
var $name;
var $permalink;
var $desc;
var $startdate;
var $enddate;
var $expdate;
var $minuserlimit;
var $maxuserlimit;
var $terms;
var $couponvalue;
var $image;
var $realvalue;
var $ctype;
var $cperson;
var $phoneno;
var $address;
var $country;
var $city;
var $subtype;
var $shop;
var $sidedeal;
var $maindeal;
var $is_video;
var $embed_code;

        function setisvideo($value)
	{
	$this->is_video = $value;
	}
	function getisvideo()
	{
	return $this->is_video;
	}
	function setembed_code($value)
	{
	$this->embed_code= $value;
	}
	function getembed_code()
	{
	return $this->embed_code;
	}
	function setcouponname($value)
	{
	$this->name = $value;
	}
	function getcouponname()
	{
	return $this->name;
	}

	function set_permalink($value)
	{
		$this->permalink = $value;
	}
	function get_permalink()
	{
		return $this->permalink;
	}
	
	function setcoupondesc($value)
	{
	$this->desc =  $value;
	}
	function getcoupondesc()
	{
	return $this->desc;
	}
        
	function setcouponfineprints($value)
	{
	$this->fineprints = $value;
	}
	
	function getcouponfineprints()
	{
	return $this->fineprints;
	}
	
	function setcouponhighlights($value)
	{
	$this->highlights = $value;
	}
	
	function getcouponhighlights()
	{
	return $this->highlights;
	}

	function setterms_and_condition($value)
	{
	$this->terms_and_condition = $value;
	}
	
	function getterms_and_condition()
	{
	return $this->terms_and_condition;
	}

	function setstartdate($value)
	{
	$this->startdate = $value;
	}
	function getstartdate()
	{
	return $this->startdate;
	}

	function setenddate($value)
	{
	$this->enddate = $value;
	}
	function getenddate()
	{
	return $this->enddate;
	}
	
	function setexpdate($value)
	{
	$this->expdate = $value;
	}
	function getexpdate()
	{
	return $this->expdate;
	}
	

	function setminuserlimit($value)
	{
	$this->minuserlimit = $value;
	}
	function getminuserlimit()
	{
	return $this->minuserlimit;
	}

	function setmaxuserlimit($value)
	{
	$this->maxuserlimit = $value;
	}
	function getmaxuserlimit()
	{
	return $this->maxuserlimit;
	}

	function setcouponvalue($value)
	{
	$this->couponvalue = $value;
	}
	function getcouponvalue()
	{
	return $this->couponvalue;
	}

	function setimage($value)
	{
	$this->image = $value;
	}
	function getimage()
	{
	return $this->image;
	}

	function setrealvalue($value)
	{
	$this->realvalue = $value;
	}
	function getrealvalue()
	{
	return $this->realvalue;
	}

	function setctype($value)
	{
	$this->ctype = $value;
	}
	function getctype()
	{
	return $this->ctype;
	}

	function setcountry($value)
	{
	$this->country = $value;
	}
	function getcountry()
	{
	return $this->country;
	}

	function setcity($value)
	{
	$this->city = $value;
	}
	function getcity()
	{
	return $this->city;
	}

	function setcperson($value)
	{
	$this->cperson = $value;
	}
	function getcperson()
	{
	return $this->cperson;
	}

	function setphoneno($value)
	{
	$this->phoneno = $value;
	}
	function getphoneno()
	{
	return $this->phoneno;
	}

	function setaddress($value)
	{
	$this->address = $value;
	}
	function getaddress()
	{
	return $this->address;
	}

	function setshop($value)
	{
	$this->shop = $value;
	}
	function getshop()
	{
	return $this->shop;
	}

	function setsidedeal($value)
	{
		$this->sidedeal = $value;
	}
	
	
	function getsidedeal()
	{
		return $this->sidedeal;
	}
	
	function getmaindeal()
	{
		return $this->maindeal;
	}
	
	function setmaindeal($value)
	{
		$this->maindeal = $value;
	}
	
	function set_metakeywords($value)
	{
		$this->metakeywords = $value;
	}
	
	function get_metakeywords()
	{
		return $this->metakeywords;
	}

	function set_metadesc($value)
	{
		$this->metadesc = $value;
	}
	
	function get_metadesc()
	{
		return $this->metadesc;
	}

	function set_max_deal_purchase($value)
	{
		$this->max_deal_purchase = $value;
	}
	
	function get_max_deal_purchase()
	{
		return $this->max_deal_purchase;
	}

        function set_coupon_status($value)
	{
		$this->coupon_status = $value;
	}
	
	function get_coupon_status()
	{
		return $this->coupon_status;
	}
	
	function set_instant_deal($value)
	{
		$this->instant_deal = $value;
	}
	
	function get_instant_deal()
	{
		return $this->instant_deal;
	}


	function editCouponDetails($cid)
	{
		$queryString = "SELECT * FROM coupons_coupons where coupon_id='$cid'";
		$resultSet = mysql_query($queryString);
			if($row = mysql_fetch_array($resultSet))
			{

				$this->name = html_entity_decode($row['coupon_name'], ENT_QUOTES);
				$this->permalink = html_entity_decode($row['deal_url'], ENT_QUOTES);
				$this->desc = html_entity_decode($row['coupon_description'], ENT_QUOTES);
				$this->fineprints = html_entity_decode($row['coupon_fineprints'], ENT_QUOTES);
				$this->highlights = html_entity_decode($row['coupon_highlights'], ENT_QUOTES);
				$this->metakeywords = html_entity_decode($row['meta_keywords'], ENT_QUOTES);
				$this->metadesc = html_entity_decode($row['meta_description'], ENT_QUOTES);
				$this->startdate = html_entity_decode($row['coupon_startdate'], ENT_QUOTES);
				$this->enddate = html_entity_decode($row['coupon_enddate'], ENT_QUOTES);
				$this->expdate = html_entity_decode($row['coupon_expirydate'], ENT_QUOTES);
				$this->minuserlimit = html_entity_decode($row['coupon_minuserlimit'], ENT_QUOTES);
				$this->maxuserlimit = html_entity_decode($row['coupon_maxuserlimit'], ENT_QUOTES);
				$this->couponvalue = html_entity_decode($row['coupon_value'], ENT_QUOTES);
				$this->realvalue = html_entity_decode($row['coupon_realvalue'], ENT_QUOTES);
				$this->cperson = html_entity_decode($row['coupon_person'], ENT_QUOTES);
				$this->phoneno = html_entity_decode($row['coupon_phoneno'], ENT_QUOTES);
				$this->address = html_entity_decode($row['coupon_address'], ENT_QUOTES);
				$this->terms_and_condition = html_entity_decode($row['terms_and_condition'], ENT_QUOTES);	
				$this->ctype = $row['coupon_category'];
				$this->image = $row['coupon_image'];
				$this->country = $row['coupon_country'];
				$this->city = $row['coupon_city'];
				$this->shop = $row['coupon_shop'];
				$this->sidedeal = $row['side_deal'];
				$this->maindeal = $row['main_deal'];
				$this->is_video = $row['is_video'];
				$this->embed_code = $row['embed_code'];
				$this->max_deal_purchase = $row['max_deal_purchase'];
				$this->coupon_status = $row['coupon_status'];
				$this->instant_deal = $row['instant_deal'];

			}

	}

}

# Update Coupon Details
function updateCouponDetails($cid,$couponname,$deal_permalink,$cdesc,$cenddate,$minlimit,$maxlimit,$cdiscountvalue,$crealvalue,$ctype,$cpicture,$country,$city,$cperson,$phonenum,$address,$shopid,$cfineprints,$chighlights,$terms,$sidedeal,$cmeta_keywords,$cmeta_description,$maindeal,$cexpdate,$cstartdate,$is_video,$embed_code,$max_dealpurchase,$coupon_status,$instant_deal)
{

     include "config.php";

$pcount_result = mysql_query("select count(*) as pcounts,coupon_enddate from coupons_purchase left join coupons_coupons on coupons_coupons.coupon_id=coupons_purchase.couponid where coupons_coupons.coupon_id='$cid'");
	if(mysql_num_rows($pcount_result))
	{
	        while($r = mysql_fetch_array($pcount_result))
	        {
	                $pcounts = $r["pcounts"];
	        }

		$end_date = date("Y-m-d H:i:s");

		// Status check  start here
                if($coupon_status !='D')
                { 
			if($pcounts < $maxlimit && $cenddate > $end_date)
			{
			        $maindealQuery = "update coupons_coupons set coupon_status='A' where coupon_id='$cid'";
			        $maindealResult = mysql_query($maindealQuery);
			}
			else if($pcounts == $maxlimit)
			{
			        $maindealQuery = "update coupons_coupons set coupon_status='C' where coupon_id='$cid'";
			        $maindealResult = mysql_query($maindealQuery);
			}
                }  // Status check End
	}

	// get the image width and hight for the current theme
	$val = $ImageSize[DEFAULT_CURRENT_THEME];
	if($val)
	{
		$width_val = $val['width'];
		$height_val = $val['hight'];
	}
	else
	{
		$width_val = 420;
		$height_val = 285;
	}	
	
	if($_FILES['cpicture']['type'] != '')
	{

            $randomvalue = ranval();

        if(in_array(strtolower($_FILES['cpicture']['type']),$imageTypeFormats))
	{
		if(isset($_FILES['cpicture'])) 
		{


			  try 
			  {         
			      $imgData =addslashes (file_get_contents($_FILES['cpicture']['tmp_name']));
			      $size = getimagesize($_FILES['cpicture']['tmp_name']);
			      $userid = $_SESSION["userid"];
			      $imtype = $_FILES['cpicture']['type'];

				//$twidth = "420";   // Maximum Width For Thumbnail Images
				//$theight = "285";   // Maximum Height For Thumbnail Images 
				        
			      switch ($imtype)
			      {
				case 'image/gif':
				$im = imagecreatefromgif($_FILES['cpicture']['tmp_name']);
				            
				break;
				case "image/pjpeg":
				case "image/jpg":
				case 'image/jpeg':
				$im = imagecreatefromjpeg($_FILES['cpicture']['tmp_name']);
				break;
				case 'image/png':
				$im = imagecreatefrompng($_FILES['cpicture']['tmp_name']);
				break;
			      };

				$width = imagesx($im);
				$height = imagesy($im);
								     
                                        $newheight = $width_val;
                                        $newwidth = $height_val;                                          

				$thumb=imagecreatetruecolor($newwidth,$newheight);
		        
				ImageCopyResampled($thumb,$im,0,0,0,0,$newwidth,$newheight,ImageSX($im),ImageSY($im));

				                
				ImagejpeG($thumb,DOCUMENT_ROOT."/uploads/coupons/".$randomvalue.".jpg");
				                $imgurl="uploads/coupons/".$randomvalue.".jpg";
				                
		    
		    
			  }
			catch(Exception $e)
			{

			}
 		
		}

	}
	else if(isset($_FILES['cpicture']['name']))
   	{
		 $img_err = "Invalid File";
   	}

		$queryString2 = "update coupons_coupons set  coupon_name='$couponname',deal_url='$deal_permalink',coupon_description='$cdesc',coupon_enddate='$cenddate',coupon_minuserlimit='$minlimit',coupon_maxuserlimit='$maxlimit',coupon_value='$cdiscountvalue',coupon_image='$imgurl',coupon_realvalue='$crealvalue',coupon_category='$ctype',coupon_country = '$country',coupon_city= '$city',coupon_person= '$cperson',coupon_phoneno= '$phonenum',coupon_address= '$address',coupon_shop='$shopid',coupon_fineprints='$cfineprints',coupon_highlights='$chighlights',terms_and_condition='$terms',side_deal='$sidedeal',meta_keywords = '$cmeta_keywords',meta_description = '$cmeta_description',main_deal='$maindeal',coupon_expirydate='$cexpdate',coupon_startdate='$cstartdate', is_video='$is_video',embed_code='$embed_code',max_deal_purchase='$max_dealpurchase',instant_deal='$instant_deal' where coupon_id='$cid'";
		mysql_query($queryString2)  or die(mysql_error());


	}
	else
	{
		$queryString2 = "update coupons_coupons set  coupon_name='$couponname',deal_url='$deal_permalink',coupon_description='$cdesc',coupon_enddate='$cenddate',coupon_minuserlimit='$minlimit',coupon_maxuserlimit='$maxlimit',coupon_value='$cdiscountvalue',coupon_realvalue='$crealvalue',coupon_category='$ctype',coupon_country = '$country',coupon_city= '$city',coupon_person= '$cperson',coupon_phoneno= '$phonenum',coupon_address= '$address',coupon_shop='$shopid',coupon_fineprints='$cfineprints',coupon_highlights='$chighlights',terms_and_condition='$terms',side_deal='$sidedeal',meta_keywords = '$cmeta_keywords',meta_description = '$cmeta_description',main_deal='$maindeal',coupon_expirydate='$cexpdate',coupon_startdate='$cstartdate', is_video='$is_video',embed_code='$embed_code',max_deal_purchase='$max_dealpurchase',instant_deal='$instant_deal' where coupon_id='$cid'";
		mysql_query($queryString2)  or die(mysql_error());

	}
	if($maindeal == 1)
	{
	        $maindealQuery = "update coupons_coupons set main_deal=0 where coupon_city='$city' and coupon_id!='$cid'";
	        $maindealResult = mysql_query($maindealQuery);
	}

//slider images

    if(in_array(strtolower($_FILES['slide1']['type']),$imageTypeFormats))
    {

	if(isset($_FILES['slide1'])) 
	{
	    try 
	    {         
	        $imgData =addslashes (file_get_contents($_FILES['slide1']['tmp_name']));
	        $size = getimagesize($_FILES['slide1']['tmp_name']);
	        $userid = $_SESSION["userid"];
	        $imtype = $_FILES['slide1']['type'];
	        switch ($imtype)
	        {
	            case 'image/gif':
	            $im = imagecreatefromgif($_FILES['slide1']['tmp_name']);
	                        
	            break;
	            case "image/pjpeg":
	            case "image/jpg":
	            case 'image/jpeg':
	            $im = imagecreatefromjpeg($_FILES['slide1']['tmp_name']);
	            break;
	            case 'image/png':
	            $im = imagecreatefrompng($_FILES['slide1']['tmp_name']);
	            break;
	        };
	            $width = imagesx($im);
	            $height = imagesy($im);
		     
		     $newheight = $width_val;
                     $newwidth = $height_val;

	            $thumb=imagecreatetruecolor($newwidth,$newheight);
	
	            ImageCopyResampled($thumb,$im,0,0,0,0,$newwidth,$newheight,ImageSX($im),ImageSY($im));

	                        
	            ImagejpeG($thumb,DOCUMENT_ROOT."/uploads/slider_images/".$cid."_1.jpg");

		$slider_imagename = $cid.'_1.jpg';

		$result = mysql_query("select * from slider_images where coupon_id='$cid' and imagename='$slider_imagename'");

		if(mysql_num_rows($result) > 0)
		{
		    $query="delete from slider_images where coupon_id='$cid' and imagename='$slider_imagename'";
		    $result=mysql_query($query) or die(mysql_error());
		}

		    $query="insert into slider_images(coupon_id,imagename) values('$cid','$slider_imagename')";
		    $result=mysql_query($query) or die(mysql_error());
	           
	    }
	   catch(Exception $e)
	   {
	   }
	    
	}
    }	
   else if(isset($_FILES['slide1']['name']))
   {
	 $img_err = "Invalid File";
   }

    
    if(in_array(strtolower($_FILES['slide2']['type']),$imageTypeFormats))
    {
    
        if(isset($_FILES['slide2'])) 
        {
            try 
            {         
                $imgData =addslashes (file_get_contents($_FILES['slide2']['tmp_name']));
                $size = getimagesize($_FILES['slide2']['tmp_name']);
                $userid = $_SESSION["userid"];
                $imtype = $_FILES['slide2']['type'];
                switch ($imtype)
                {
                    case 'image/gif':
                    $im = imagecreatefromgif($_FILES['slide2']['tmp_name']);
                                
                    break;
                    case "image/pjpeg":
                    case "image/jpg":
                    case 'image/jpeg':
                    $im = imagecreatefromjpeg($_FILES['slide2']['tmp_name']);
                    break;
                    case 'image/png':
                    $im = imagecreatefrompng($_FILES['slide2']['tmp_name']);
                    break;
                };
                    $width = imagesx($im);
                    $height = imagesy($im);
		    
		        $newheight = $width_val;
                        $newwidth = $height_val;

                    $thumb=imagecreatetruecolor($newwidth,$newheight);
        
                    ImageCopyResampled($thumb,$im,0,0,0,0,$newwidth,$newheight,ImageSX($im),ImageSY($im));

                                    
                    ImagejpeG($thumb,DOCUMENT_ROOT."/uploads/slider_images/".$cid."_2.jpg");

			$slider_imagename = $cid.'_2.jpg';
			$result = mysql_query("select * from slider_images where coupon_id='$cid' and imagename='$slider_imagename'");

			if(mysql_num_rows($result) > 0)
			{
			    $query="delete from slider_images where coupon_id='$cid' and imagename='$slider_imagename'";
			    $result=mysql_query($query) or die(mysql_error());
			}

			    $query="insert into slider_images(coupon_id,imagename) values('$cid','$slider_imagename')";
			    $result=mysql_query($query) or die(mysql_error());
                   
            }
           catch(Exception $e)
           {
           }
            
        }
    }	
   else if(isset($_FILES['slide2']['name']))
   {
	 $img_err = "Invalid File";
   }


     if(in_array(strtolower($_FILES['slide3']['type']),$imageTypeFormats))
     {
    
        if(isset($_FILES['slide3'])) 
        {
            try 
            {         
                $imgData =addslashes (file_get_contents($_FILES['slide3']['tmp_name']));
                $size = getimagesize($_FILES['slide3']['tmp_name']);
                $userid = $_SESSION["userid"];
                $imtype = $_FILES['slide3']['type'];
                switch ($imtype)
                {
                    case 'image/gif':
                    $im = imagecreatefromgif($_FILES['slide3']['tmp_name']);
                                
                    break;
                    case "image/pjpeg":
                    case "image/jpg":
                    case 'image/jpeg':
                    $im = imagecreatefromjpeg($_FILES['slide3']['tmp_name']);
                    break;
                    case 'image/png':
                    $im = imagecreatefrompng($_FILES['slide3']['tmp_name']);
                    break;
                };
                    $width = imagesx($im);
                    $height = imagesy($im);
		       
		       $newheight = $width_val;
                       $newwidth = $height_val;
                                        
                    $thumb=imagecreatetruecolor($newwidth,$newheight);
        
                    ImageCopyResampled($thumb,$im,0,0,0,0,$newwidth,$newheight,ImageSX($im),ImageSY($im));

                                    
                    ImagejpeG($thumb,DOCUMENT_ROOT."/uploads/slider_images/".$cid."_3.jpg");

			$slider_imagename = $cid.'_3.jpg';

			$result = mysql_query("select * from slider_images where coupon_id='$cid' and imagename='$slider_imagename'");

			if(mysql_num_rows($result) > 0)
			{
			    $query="delete from slider_images where coupon_id='$cid' and imagename='$slider_imagename'";
			    $result=mysql_query($query) or die(mysql_error());
			}

			    $query="insert into slider_images(coupon_id,imagename) values('$cid','$slider_imagename')";
			    $result=mysql_query($query) or die(mysql_error());

            }
           catch(Exception $e)
           {
           }
            
        }
    }
   else if(isset($_FILES['slide3']['name']))
   {
	 $img_err = "Invalid File";
   }
//end of slider images

	if(($_FILES["cpicture"]["size"] > $uploadimageSize['deal_pic']) || ($_FILES["slide1"]["size"] > $uploadimageSize['deal_pic']) || ($_FILES["slide2"]["size"] > $uploadimageSize['deal_pic']) || ($_FILES["slide3"]["size"] > $uploadimageSize['deal_pic']))
	{
		$size = round($uploadimageSize['profile_pic']/1024000);
		$img_err2 = "Image file size should lesser than ".$size.'MB';
		return $img_err2;
	}

	/*
	if(!empty($img_err2)){
		set_response_mes(-1,$img_err2);
	}
	else if(!empty($img_err)){
		set_response_mes(-1,$img_err);
	}
	else{
		set_response_mes(1, $admin_language['changesmodified']);
	}
	*/

	return 1;

}

# Add Shop
function createShop($shopname,$shopaddress,$city,$country,$shopstatus,$shopcreatedby,$shopcreateddate,$lat,$lang)
{
	$queryString = "insert into coupons_shops (shopname,shop_address,shop_city,shop_country,shop_status,shop_latitude,shop_longitude,shop_createdby,shop_createddate) values ('$shopname','$shopaddress','$city','$country','$shopstatus','$lat','$lang','$shopcreatedby','$shopcreateddate')";
	$resultSet = mysql_query($queryString)  or die(mysql_error());
	return $resultSet;
}

# Edit Shop Informations
class EditShop
{
var $shopname;
var $shopaddress;
var $shopcity;
var $shopcountry;
var $shopstatus;
var $shopcreatedby;
var $shopcreateddate;
var $shoplatitude;
var $shoplongitude;

	function setshopname($value)
	{
	$this->shopname =$value;
	}
	function getshopname()
	{
	return $this->shopname;
	}

	function setshopaddress($value)
	{
	$this->shopaddress =$value;
	}
	function getshopaddress()
	{
	return $this->shopaddress;
	}

	function setshopcity($value)
	{
	$this->shopcity=$value;
	}
	function getshopcity()
	{
	return $this->shopcity;
	}

	function setshopcountry($value)
	{
	$this->shopcountry=$value;
	}
	function getshopcountry()
	{
	return $this->shopcountry;
	}

	function setshopstatus($value)
	{
	$this->shopstatus=$value;
	}
	function getshopstatus()
	{
	return $this->shopstatus;
	}

	function setshopcreatedby($value)
	{
	$this->shopcreatedby=$value;
	}
	function getshopcreatedby()
	{
	return $this->shopcreatedby;
	}

	function setshopcreateddate($value)
	{
	$this->shopcreateddate=$value;
	}
	function getshopcreateddate()
	{
	return $this->shopcreateddate;
	}

	function setshoplatitude($value)
	{
	$this->shoplatitude=$value;
	}
	function getshoplatitude()
	{
	return $this->shoplatitude;
	}

	function setshoplongitude($value)
	{
	$this->shoplongitude=$value;
	}
	function getshoplongitude()
	{
	return $this->shoplongitude;
	}

	function editShopDetails($shopid)
	{
		$queryString = "SELECT * FROM coupons_shops where shopid='$shopid'";
		$resultSet = mysql_query($queryString);

			if($row = mysql_fetch_array($resultSet))
			{

				$this->shopname = html_entity_decode($row['shopname'], ENT_QUOTES);
				$this->shopaddress = html_entity_decode($row['shop_address'], ENT_QUOTES);
				$this->shopcity = $row['shop_city'];
				$this->shopcountry = $row['shop_country'];
				$this->shopstatus = $row['shop_status'];
				$this->shopcreatedby = $row['shop_createdby'];
				$this->shopcreateddate = $row['shop_createddate'];
				$this->shoplatitude = html_entity_decode($row['shop_latitude'], ENT_QUOTES);
				$this->shoplongitude = html_entity_decode($row['shop_longitude'], ENT_QUOTES);
				
			}

	}

}

# Update Shop Informations
function updateShop($shopid,$userid,$shopname,$shopaddress,$city,$country,$lat,$lang)
{

	$queryString = "update coupons_shops set shopname='$shopname',shop_address='$shopaddress',shop_city='$city',shop_country='$country',shop_latitude ='$lat',shop_longitude='$lang' where shopid = '$shopid'";
	$resultSet = mysql_query($queryString);
	return $resultSet;

}

# Get User Role
function getUserRole($user_role='')
{
	$queryString2 = "SELECT * FROM coupons_roles where roleid='$user_role'";
	$resultSet2 = mysql_query($queryString2);
		while($row2 = mysql_fetch_array($resultSet2))
		{
			return $user_role = $row2['role_name'];
		}
}

# Get Location
function getLocation($id='')
{
	$queryString3 = "SELECT * FROM coupons_location where location_id='$id'";
	$resultSet3 = mysql_query($queryString3);
		while($row3 = mysql_fetch_array($resultSet3))
		{
			return $location = $row3['location'];
		}
}

# Get Country
function getCountry($id='')
{
	$queryString3 = "SELECT * FROM coupons_country where countryid='$id'";
	$resultSet3 = mysql_query($queryString3);
		while($row3 = mysql_fetch_array($resultSet3))
		{
			return html_entity_decode($row3['countryname'], ENT_QUOTES);
		}
}

# Get City
function getCity($id='')
{
	$queryString3 = "SELECT * FROM coupons_cities where cityid='$id'";
	$resultSet3 = mysql_query($queryString3);
		while($row3 = mysql_fetch_array($resultSet3))
		{
			return html_entity_decode($row3['cityname'], ENT_QUOTES);
		}
}

# Get User Name
function getUserName($id='')
{
	$queryString4 = "SELECT * FROM coupons_users where userid='$id'";
	$resultSet4 = mysql_query($queryString4);
		while($row4 = mysql_fetch_array($resultSet4))
		{
			return html_entity_decode($row4['username'], ENT_QUOTES);
		}
}

function getRoleNameUsrInfo($id='')
{

	$queryString = "select role_name from coupons_roles where roleid='".$id."'";
	$resultset = mysql_query($queryString);
				if($row = mysql_fetch_array($resultset)){
					return $row['role_name'];
				}
}

# Change Password
function updatepassword($uid='',$password='')
{
	$queryString = "update coupons_users set password = '$password' where userid='$uid'";
	$resultSet = mysql_query($queryString)  or die(mysql_error());
	return $resultSet;
}

function createCountry($countryname='')
{
	$queryString = "insert into coupons_country(countryname)  values ('$countryname')";
	$resultSet = mysql_query($queryString)  or die(mysql_error());
	return $resultSet;
}

function updateCountry($countryname='',$countryid='')
{
	$queryString = "update coupons_country set countryname = '$countryname' where countryid='$countryid'";
	$resultSet = mysql_query($queryString)  or die(mysql_error());
	return $resultSet;
}

function createCity($cityname='',$city_url='',$country='')
{
	$queryString = "insert into coupons_cities(cityname,city_url,countryid)  values ('$cityname','$city_url','$country')";
	$resultSet = mysql_query($queryString)  or die(mysql_error());
	return $resultSet;
}

function updateCity($cityname='',$city_url = '',$country='',$rep_city='')
{
	$queryString = "update coupons_cities set cityname = '$cityname',city_url = '$city_url', countryid='$country' where cityid='$rep_city'";
	$resultSet = mysql_query($queryString)  or die(mysql_error());
	return $resultSet;
}

function createCategory($categoryname='',$category_url='',$category_img='')
{
	
	 //Add category images  
         if ($_FILES['imglink']['type'] == "image/jpeg"||$_FILES['imglink']['type'] == "image/jpg"||$_FILES['imglink']['type'] == "image/gif"||$_FILES['imglink']['type'] == "image/png"||$_FILES['imglink']['type'] == "image/pjpeg")
    {
    
        if(isset($_FILES['imglink'])) 
        {
            try 
            {         
                $imgData =addslashes (file_get_contents($_FILES['imglink']['tmp_name']));
                $size = getimagesize($_FILES['imglink']['tmp_name']);
                $userid = $_SESSION["userid"];
                $imtype = $_FILES['imglink']['type'];

	
                switch ($imtype)
                {
                    case 'image/gif':
                    $im = imagecreatefromgif($_FILES['imglink']['tmp_name']);
                                
                    break;
                    case "image/pjpeg":
                    case "image/jpg":
                    case 'image/jpeg':
                    $im = imagecreatefromjpeg($_FILES['imglink']['tmp_name']);
                    break;
                    case 'image/png':
                    $im = imagecreatefrompng($_FILES['imglink']['tmp_name']);
                    break;
                };
                                              
                   $randomvalue=ranval();
                   $width = imagesx($im);
                   $height = imagesy($im);   
                   $thumb=imagecreatetruecolor($width,$height);
       
                    ImageCopyResampled($thumb,$im,0,0,0,0,$width,$height,ImageSX($im),ImageSY($im));
                                    
                    ImagejpeG($thumb,DOCUMENT_ROOT."/uploads/category/".$randomvalue.".jpg");
                                    $imgurl="uploads/category/".$randomvalue.".jpg";

                                    
    
            }
			catch(Exception $e)
			{

			}
            
        }
    }
	$queryString = "insert into coupons_category(category_name,category_url,category_image)  values ('$categoryname','$category_url','$imgurl')";
	$resultSet = mysql_query($queryString)  or die(mysql_error());
	
	 $last_insert_categoryid = mysql_insert_id();
	 //add categoryicon image 
	 if ($_FILES['categoryicon']['type'] == "image/jpeg"||$_FILES['categoryicon']['type'] == "image/jpg"||$_FILES['categoryicon']['type'] == "image/gif"||$_FILES['categoryicon']['type'] == "image/png"||$_FILES['categoryicon']['type'] == "image/pjpeg")
    {
    
        if(isset($_FILES['categoryicon'])) 
        {

            try 
            {         
                $imgData =addslashes (file_get_contents($_FILES['categoryicon']['tmp_name']));
                $size = getimagesize($_FILES['categoryicon']['tmp_name']);
                $userid = $_SESSION["userid"];
                $imtype = $_FILES['categoryicon']['type'];

	
                switch ($imtype)
                {
                    case 'image/gif':
                    $im = imagecreatefromgif($_FILES['categoryicon']['tmp_name']);
                                
                    break;
                    case "image/pjpeg":
                    case "image/jpg":
                    case 'image/jpeg':
                    $im = imagecreatefromjpeg($_FILES['categoryicon']['tmp_name']);
                    break;
                    case 'image/png':
                    $im = imagecreatefrompng($_FILES['categoryicon']['tmp_name']);
                    break;
                };
                                              
                   $width = imagesx($im);
                   $height = imagesy($im); 
   			$newwidth=16;                       
                        $newheight=16;
                    $thumb=imagecreatetruecolor($newwidth,$newheight);
       
                    ImageCopyResampled($thumb,$im,0,0,0,0,$newwidth,$newheight,ImageSX($im),ImageSY($im));
                                    
                    ImagejpeG($thumb,DOCUMENT_ROOT."/uploads/categoryicon/".$last_insert_categoryid.".jpg");
                                   
                                    
    
            }
			catch(Exception $e)
			{

			}
            
        }
    }
    
 return $resultSet;

	  

}


function updateCategory($categoryname="",$category_url="",$categoryid='',$category_img='',$categoryicon='')
{

	 if ($_FILES['imglink']['type'] == "image/jpeg"||$_FILES['imglink']['type'] == "image/jpg"||$_FILES['imglink']['type'] == "image/gif"||$_FILES['imglink']['type'] == "image/png"||$_FILES['imglink']['type'] == "image/pjpeg")
    {
    
        if(isset($_FILES['imglink'])) 
        {
            try 
            {         
                $imgData =addslashes (file_get_contents($_FILES['imglink']['tmp_name']));
                $size = getimagesize($_FILES['imglink']['tmp_name']);
                $userid = $_SESSION["userid"];
                $imtype = $_FILES['imglink']['type'];

	
                switch ($imtype)
                {
                    case 'image/gif':
                    $im = imagecreatefromgif($_FILES['imglink']['tmp_name']);
                                
                    break;
                    case "image/pjpeg":
                    case "image/jpg":
                    case 'image/jpeg':
                    $im = imagecreatefromjpeg($_FILES['imglink']['tmp_name']);
                    break;
                    case 'image/png':
                    $im = imagecreatefrompng($_FILES['imglink']['tmp_name']);
                    break;
                };
                                              
                   $randomvalue=ranval();
                   $width = imagesx($im);
                   $height = imagesy($im);   
                   $thumb=imagecreatetruecolor($width,$height);
       
                    ImageCopyResampled($thumb,$im,0,0,0,0,$width,$height,ImageSX($im),ImageSY($im));
                                    
                    ImagejpeG($thumb,DOCUMENT_ROOT."/uploads/category/".$randomvalue.".jpg");
                                    $imgurl="uploads/category/".$randomvalue.".jpg";

                                    
    
    
            }
			catch(Exception $e)
			{

			}
            
        }
    
	$queryString = "update coupons_category set category_name = '$categoryname', category_url='$category_url', category_image='$imgurl' where category_id ='$categoryid'";
	
	$resultSet = mysql_query($queryString)  or die(mysql_error());
}
else
{
	$queryString = "update coupons_category set category_name = '$categoryname', category_url='$category_url' where category_id ='$categoryid'";
		
	$resultSet = mysql_query($queryString)  or die(mysql_error());
}
	 //add categoryicon image 	 
	 if ($_FILES['categoryicon']['type'] == "image/jpeg"||$_FILES['categoryicon']['type'] == "image/jpg"||$_FILES['categoryicon']['type'] == "image/gif"||$_FILES['categoryicon']['type'] == "image/png"||$_FILES['categoryicon']['type'] == "image/pjpeg")
    {
    
        if(isset($_FILES['categoryicon'])) 
        {

            try 
            {         
                $imgData =addslashes (file_get_contents($_FILES['categoryicon']['tmp_name']));
                $size = getimagesize($_FILES['categoryicon']['tmp_name']);
                $userid = $_SESSION["userid"];
                $imtype = $_FILES['categoryicon']['type'];

	
                switch ($imtype)
                {
                    case 'image/gif':
                    $im = imagecreatefromgif($_FILES['categoryicon']['tmp_name']);
                                
                    break;
                    case "image/pjpeg":
                    case "image/jpg":
                    case 'image/jpeg':
                    $im = imagecreatefromjpeg($_FILES['categoryicon']['tmp_name']);
                    break;
                    case 'image/png':
                    $im = imagecreatefrompng($_FILES['categoryicon']['tmp_name']);
                    break;
                };
                                              
                   $width = imagesx($im);
                   $height = imagesy($im); 
   			$newwidth=16;                       
                        $newheight=16;
                        
                    $thumb=imagecreatetruecolor($newwidth,$newheight);
                    
       
                    ImageCopyResampled($thumb,$im,0,0,0,0,$newwidth,$newheight,ImageSX($im),ImageSY($im));

                    ImagejpeG($thumb,DOCUMENT_ROOT."/uploads/categoryicon/".$categoryid.".jpg");
                                   
                                    
    
            }
			catch(Exception $e)
			{

			}
            
        }
    }
	return $resultSet;
}

function updateUserInformation($userid='',$firstname='',$lastname='',$email='',$mobile='',$address='')
{
	$queryString = "update coupons_users set firstname = '$firstname' ,lastname = '$lastname', email = '$email', mobile = '$mobile', address = '$address' where userid= '$userid'";
	mysql_query($queryString) or die(mysql_error());
	return 1;
}
?>
