<?php ob_start();
/******************************************
* @Created on March, 2011 * @Package: Ndotdeals unlimited v2.2 
* @Author: NDOT
* @URL : http://www.ndot.in
********************************************/
 
?>
<?php
 
    include "pagination.class.php";
    $url_arr = explode("/",$_SERVER["REQUEST_URI"]);
    
    /*important in install*/
    function decrypt_string($input)
    {
          $input_count = strlen($input);
          $dec = explode(".", $input);// splits up the string to any array
          $x = count($dec);
          $y = $x-1;// To get the key of the last bit in the array
          $calc = $dec[$y]-50;
          $randkey = chr($calc);// works out the randkey number
          $i = 0;
           while ($i < $y)
          {
            $array[$i] = $dec[$i]+$randkey; // Works out the ascii characters actual numbers
            $real .= chr($array[$i]); //The actual decryption
            $i++;
          };
          $input = $real;
    return $input;
    }

    function getCouponEndDate()
    {
    
			$queryString = "SELECT DATE_ADD(now(), INTERVAL 60 MINUTE) as date"; //add 1 hour with the coupon end date
			$resultset = mysql_query($queryString);
	          if($row = mysql_fetch_array($resultset)){
	              return $row['date'];
	          }
    }
    
    function getCouponExpDate()
    {
    
			$queryString = "SELECT DATE_ADD(now(), INTERVAL 1 DAY) as date"; //add 1 hour with the coupon end date
			$resultset = mysql_query($queryString);
	          if($row = mysql_fetch_array($resultset)){
	              return $row['date'];
	          }
    }

    function payment_list()
    {
	$queryString = "select c.coupon_name,c.coupon_realvalue,c.coupon_offer,u.firstname,u.lastname,p.coupon_purchaseddate,p.Coupon_amount_Status from coupons_purchase p left join coupons_coupons c on p.couponid=c.coupon_id left join coupons_users u on p.coupon_userid=u.userid";

		//pagination
			
		
        $pages = new Paginator;
	$pages->mid_range = 5; // Number of pages to display. Must be odd and > 3
	$pages->paginate($queryString);
	$resultSet = $pages->rspaginate;
		
	if(mysql_num_rows($resultSet) > 0)
	{
		echo '<p style="color:#666;width:100%;" class="fwb txtcenter">* Note: T - Amount Transfered, C - Payment Failed.</p>';
			
	?>
                        
	<table cellpadding="0" cellspacing="0" class="">
	<tr class="fwb">
	<td>User Name</td>
	<td>Description</td>
	<td>Amount</td>
	<td>Status</td>	
	<td>Purchased Date</td>
	</tr>
		<?php
		while($result = mysql_fetch_array($resultSet))
		{
		?>

		<tr>
		<td><?php echo ucfirst(html_entity_decode($result["firstname"], ENT_QUOTES)); ?></td>
		<td><?php 
		if(strlen($result['coupon_name'])>50)
			echo 'Pay of '.ucfirst(html_entity_decode(substr($result['coupon_name'],0,50), ENT_QUOTES)).'...'; 
		else
			echo 'Pay of '.ucfirst(html_entity_decode($result['coupon_name'], ENT_QUOTES)); 		
		
		?></td>
		<td>
		<?php
			$coupons_realvalue = $result["coupon_realvalue"];
			$coupon_offer = $result["coupon_offer"];
			$offer_amount = (($coupons_realvalue * $coupon_offer)/100); 
			$paid_amount = $coupons_realvalue - $offer_amount;
			echo CURRENCY.$paid_amount;
		?>
		</td>
		<td><?php if($result['Coupon_amount_Status']) { echo $result['Coupon_amount_Status']; } else { echo 'C'; } ?></td>		
		<td><?php echo $result['coupon_purchaseddate']; ?></td>
		</tr>

		<?php
		}
		?>

	</table>
	<?php
                        if($pages->rspaginateTotal>20) {   
			echo '<table border="0" width="650" align="center" cellpadding="10">';
			echo '<tr><td align="center"><div class="pagenation">';
         		echo $pages->display_pages();
			echo '</div></td></tr>';
			echo '</table>';	
         }
	}else{
	
			   echo '<div class="nodata">No Data Available.</div>';	
	
	}


    }

    function get_saved_money()
    {
	$result = mysql_query("select * from coupons_purchase_status");
	return $result; 
    }
	
    function get_random_coopon($default_city_id = '',$limit = '')
    {
        $query = "select * from coupons_coupons c left join coupons_cities cty on cty.cityid = c.coupon_city where ";
			//add the city condition
			if($default_city_id)
			{
				$query .= " coupon_city = '$default_city_id' AND ";
			}
			  if($limit)
			  {
			  	$query .= " c.coupon_status='A' and c.side_deal='1' and c.coupon_startdate <= now() and c.coupon_enddate > now() order by c.coupon_enddate asc limit 0,$limit";
			  }
			  else
			  {
			  	$query .= " c.coupon_status='A' and c.side_deal='1' and c.coupon_startdate <= now() and c.coupon_enddate > now() order by c.coupon_enddate asc limit 0,3";
			  }
              $result = mysql_query($query);
              return $result;
    }
    
    function get_cityname()
    {
        $query = "select * from coupons_cities where cityid='".$_SESSION['defaultcityId']."'";
              $result = mysql_query($query);
              return $result;
    }
  
  
    function get_subcategory()
    {
        $query = "select * from coupons_category where status='A' order by category_name";
              $result = mysql_query($query);
              return $result;
    }
    
    function add_subscriber($email='',$city='')
    {
             
                
	        $check_exist = mysql_query("select * from newsletter_subscribers where email='$email'  AND city_id='$city'");

	        //newletter unsubscriber also can subscribe if he want it again
	        
		$check_block = mysql_query("select * from newsletter_subscribers where email='$email'  AND city_id='$city' AND status ='D'");  
		  if(mysql_num_rows($check_exist) == 0)
		  {
			  $query = "insert into newsletter_subscribers(email,city_id)values('$email','$city')";
			  $result = mysql_query($query);
			  return $result;
		  }
		  elseif(mysql_num_rows($check_block) == 1)
		  {
		          $query = "update newsletter_subscribers set status ='A' where email='$email'  AND city_id='$city' AND status ='D'";
			  $result = mysql_query($query);
			  return $result;
		  } 
		  else{
		  	return '';
		  }
    }

    
    function add_mobilesubscriber($mobileno='',$city='')
    {
    
	      $check_exist = mysql_query("select * from mobile_subscribers where mobileno='$mobileno' AND city_id='$city' ");
		  
		  if(mysql_num_rows($check_exist) == 0)
		  {
			  $query = "insert into mobile_subscribers(mobileno,city_id)values('$mobileno','$city')";
			  $result = mysql_query($query);
			  return $result;
		  }else{
		  	return '';
		  }
    }
    
    //get the coupen information
    function get_coupon_code($c_id)
    {
            $query = "select * from coupons_coupons where coupon_id='$c_id'";
            $resultset = mysql_query($query);
            return $resultset;
    }

    function getRoleId($name)
    {
    
    $queryString = "select roleid from coupons_roles where role_name='".$name."'";
    $resultset = mysql_query($queryString);
                    if($role = mysql_fetch_array($resultset)){
                        return $role['roleid'];
                    }
    }
    
    
    // Function to insert coupon menbers
    
    function insertMember($user_id,$coupon_id,$date)
    {
        $member_count = getMenbersCount($coupon_id);
        if($member_count>50)
        $queryString = "insert into coupon_members(user_id,coupon_id,status,applied_time) values ('$user_id','$coupon_id','0','$date')";
        $result = mysql_query($querystring);
    }

    // Function to manage coupon members and their payment status
    
    function manageMembers($coupon_id)
    {
        $queryString = "select count(*) as count from coupon_members where coupon_id='$coupon_id'";
        $member_count = mysql_query($querystring);
    }
    
    // Function to reterive menbers count for each coupon
    
    function getMembersCount($coupon_id)
    {
           $queryString = "select count(*) as count from coupons_purchase where couponid='$coupon_id' and  Coupon_amount_Status='T' ";
	//$queryString = "select count(*) as count from coupons_purchase where couponid='$coupon_id'";        
        $result = mysql_query($queryString);
        $row = mysql_fetch_object($result);
        return $row->count;
    }	
    
    
    // Function to reterive coupon maxusers and minusers
    
    function getCouponUsersLimit($coupon_id)
    {
        $queryString = "select coupon_minuserlimit as minuser,coupon_maxuserlimit as maxuser  from coupons_coupons where coupon_id='$coupon_id'";
        $resultSet = mysql_query($queryString);
        while ($row = mysql_fetch_object($resultSet)) 
        {
            $limit[min] = $row->minuser;
            $limit[max] = $row->maxuser;
        }
        return $limit;
    }	
    
    function maxUserId()
    {
    
    $queryString = "select max(userid) as id from coupons_users";
    $resultset = mysql_query($queryString);
                    if($userid = mysql_fetch_array($resultset)){
                        return $userid['id'];
                    }
    }
    

    function loginCheck($uname,$password,$admin_language = '')
    {
			session_start();
			$uname = htmlentities($uname, ENT_QUOTES);
			$queryString = "SELECT * FROM coupons_users where username ='".$uname."' and password='".$password."'";
            $resultSet = mysql_query($queryString);
            if(mysql_num_rows($resultSet)>0)
            {
                          if($values=mysql_fetch_array($resultSet))
                           {
                            if($values['user_status']!="A")
                             { 
                                 return "Blocked";
                             } 
                             else
                		  {
                                
					if($values['login_type']==1 || $values['login_type']==2) //fb and twitter users
					{
						    $_SESSION["username"] = html_entity_decode($values['firstname'], ENT_QUOTES);
						    $_SESSION["logintype"] = 'connect';
					}
					else
					{
						    $_SESSION["username"] = html_entity_decode($values['username'], ENT_QUOTES);	
						    $_SESSION["logintype"] = 'normal';
					}					                          	
                    
				       $_SESSION["userid"] = $values['userid'];
				       $_SESSION["userrole"] = $values['user_role'];
				       $_SESSION["userstatus"] = $values['user_status'];
				       $_SESSION["cityid"] = $values['city'];
		       		       $_SESSION["countryid"] = $values['country'];
				       $_SESSION["user_shopid"] = $values['user_shopid'];		       
				       $_SESSION["savedamt"] = '0';
				       $_SESSION["emailid"] = $values['email'];
				       $_SESSION["site_admin_language"] = $admin_language;
						 
					 // to get total amt saved during user purchase
					 getsavingamt();
					 return "Success";
					 
                }
             }
                  }
            else
            {
                         return "Failed"; 
            }
    
    }
	
    function checknull($input,$alt){
    if(is_null($input) || strlen($input)<1 || $input ==""){
        $input = $alt;
    }
    return $input;
    }
    
    function couponUpload()
    {
	    include "docroot.php";
	    include "config.php";

	    $cname = htmlentities($_POST['couponname'], ENT_QUOTES);
            $deal_permalink = htmlentities($_POST['deal_permalink'], ENT_QUOTES);
	    $cdesc = htmlentities($_POST['cdesc'], ENT_QUOTES);
	    $cfineprints = htmlentities($_POST['cfineprints'], ENT_QUOTES);
	    $chighlights = htmlentities($_POST['chighlights'], ENT_QUOTES);
	    $cenddate = htmlentities($_POST['cenddate']);
	    $cstartdate = htmlentities($_POST['cstartdate']);
	    $cexpdate = htmlentities($_POST['cexpdate']);
	    $climit = htmlentities($_POST['climit']);
	    $cterms = htmlentities($_POST['cterms']);
	    $cdiscountvalue = htmlentities($_POST['cdiscountvalue']);
	    $cminuser = htmlentities($_POST['minlimit']);
	    $cmaxuser = htmlentities($_POST['maxlimit']);
	    $crealvalue = htmlentities($_POST['crealvalue']);

	    //unneccessary input fields are removed		
	    $cperson = ''; //htmlentities($_POST['cperson'], ENT_QUOTES);
	    $phonenum = ''; //htmlentities($_POST['phonenum']);
	    $address = ''; //htmlentities($_POST['address'], ENT_QUOTES);

		$meta_keywords = htmlentities($_POST['meta_keywords'], ENT_QUOTES);
		$meta_description = htmlentities($_POST['meta_description'], ENT_QUOTES);
		$termscondition = htmlentities($_POST['termscondition'], ENT_QUOTES);

		if($_POST['max_dealpurchase'] > 0){
		        $max_dealpurchase = htmlentities($_POST['max_dealpurchase']);
		}else{
		        $max_dealpurchase = 0;
		}

		if($_POST['couponname']=='' || $_POST['cdesc']=='' || $_POST['crealvalue']=='' || $_POST['crealvalue']==0)
		{
			$redirect_url = DOCROOT."admin/couponsupload/";
			set_response_mes(1,'All fields are mandatory.'); 	
			url_redirect($redirect_url);
		}
     
	    $uid=$_SESSION["userid"];
	    $shopid=$_POST['shop'];
	    $csubtype=$_POST['csubtype'];
	    $ctype=$_POST['ctype'];
	    $country = $_POST['country'];
	    $city=$_POST['city'];

	    if($_POST['sidedeal'])
		    $sidedeal=1;
	    else
  		    $sidedeal=0;
            
            if($_POST['maindeal'])
		    $maindeal=1;
	    else
  		    $maindeal=0;
  		    
            if($_POST['instant_deal'])
		    $instant_deal=1;
	    else
  		    $instant_deal=0;
  		    
            $is_video = $_POST['is_video'];
            $embed_code = htmlentities($_REQUEST['embed_code'], ENT_QUOTES);
            
            
	    $randomvalue=ranval();
	    
	// get the image width and hight for the current theme
	$val= $ImageSize[DEFAULT_CURRENT_THEME];
	if($val)
	{
		$width_val=$val['width'];
		$height_val=$val['hight'];
	}
	else
	{
		$width_val=420;
		$height_val=282;
	}
	$imageTypeFormats = array("image/jpeg","image/jpg","image/gif","image/png","image/pjpeg");
   
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
      
			
		$status="A";

        if($_SESSION['userrole']=='3')
        {
            $status="D";
        }
    
	    $queryString = "insert into coupons_coupons
	    (coupon_name,deal_url,coupon_description,coupon_enddate,coupon_image,coupon_createdby,coupon_createddate,coupon_value,coupon_status,coupon_minuserlimit,coupon_maxuserlimit,coupon_realvalue,coupon_category,coupon_country,coupon_city,coupon_person,coupon_phoneno,coupon_address,  	coupon_shop,coupon_fineprints,coupon_highlights,side_deal,meta_keywords,meta_description,terms_and_condition,main_deal,coupon_expirydate,coupon_startdate,is_video, embed_code,max_deal_purchase,instant_deal) values ('$cname','$deal_permalink','$cdesc',STR_TO_DATE('$cenddate','%Y-%m-%d %H:%i:%s'),'$imgurl','$uid',now(),'$cdiscountvalue','$status','$cminuser','$cmaxuser','$crealvalue','$ctype','$country','$city', '$cperson', '$phonenum', '$address','$shopid','$cfineprints','$chighlights','$sidedeal','$meta_keywords','$meta_description','$termscondition','$maindeal','$cexpdate','$cstartdate','$is_video', '$embed_code','$max_dealpurchase','$instant_deal')";
	    
	    $resultset = mysql_query($queryString) or die(mysql_error());
	    $last_insert_id=mysql_insert_id();
	    if($maindeal == 1)
	    {
	        $maindealQuery = "update coupons_coupons set main_deal=0 where coupon_city='$city' and coupon_id!='$last_insert_id'";
	        $maindealResult = mysql_query($maindealQuery);
	    }
   
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
                    $newwidthX=$width_val;
	                 	
				$newheight = $width_val;
                                $newwidth = $height_val;

                    $thumb=imagecreatetruecolor($newwidth,$newheight);
        
                    ImageCopyResampled($thumb,$im,0,0,0,0,$newwidth,$newheight,ImageSX($im),ImageSY($im));

                                    
                    ImagejpeG($thumb,DOCUMENT_ROOT."/uploads/slider_images/".$last_insert_id."_1.jpg");
                                    $imgurl="uploads/slider_images/".$last_insert_id."_1.jpg";
                                    $slide1_image_name=$last_insert_id."_1".".jpg";
            
			//slide show images                
		    $query = "insert into slider_images(coupon_id,imagename) values('$last_insert_id','$slide1_image_name')";
		    $result=mysql_query($query) or die(mysql_error());
    
            }
                catch(Exception $e)
                {
                }
            
        }
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

                                    
                    ImagejpeG($thumb,DOCUMENT_ROOT."/uploads/slider_images/".$last_insert_id."_2.jpg");
                                    $imgurl="uploads/slider_images/".$last_insert_id."_2.jpg";
                                    $slide2_image_name=$last_insert_id."_2".".jpg";
                                    
		    $query="insert into slider_images(coupon_id,imagename) values('$last_insert_id','$slide2_image_name')";
		    $result=mysql_query($query) or die(mysql_error());
    
            }
                catch(Exception $e)
                {
                }
            
        }
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
                     $newwidthX=$width_val;	               
                        
                        $newheight = $width_val;
                        $newwidth = $height_val;

                    $thumb=imagecreatetruecolor($newwidth,$newheight);
        
                    ImageCopyResampled($thumb,$im,0,0,0,0,$newwidth,$newheight,ImageSX($im),ImageSY($im));

                                    
                    ImagejpeG($thumb,DOCUMENT_ROOT."/uploads/slider_images/".$last_insert_id."_3.jpg");
                                    $imgurl="uploads/slider_images/".$last_insert_id."_3.jpg";
                                    $slide3_image_name=$last_insert_id."_3".".jpg";
                                    
		    $query="insert into slider_images(coupon_id,imagename) values('$last_insert_id','$slide3_image_name')";
		    $result=mysql_query($query) or die(mysql_error());
    
            }
                catch(Exception $e)
                {
                }
            
        }
    }	
                // include admin language file
                $admin_lang = $_SESSION["site_admin_language"];
		if($admin_lang)
		{
			include(DOCUMENT_ROOT."/system/language/admin_".$admin_lang.".php");
		}
		else
		{
			include(DOCUMENT_ROOT."/system/language/admin_en.php");
		}
		
	        // get current date and time
	        $cdate = date("Y-m-d H:i:s");
		//update the deal url into facebook and twitter
		if($last_insert_id)
		{

			$url = 'deals/'.$deal_permalink.'_'.$last_insert_id.'.html'; 
			$share_link = DOCROOT.$url;
			$Status_Message = $share_link;			
					
			if($cstartdate <= $cdate)
			{
			
			//Twitter share 			
			include($_SERVER["DOCUMENT_ROOT"].'/system/modules/twitter/update.php');
						
			include($_SERVER["DOCUMENT_ROOT"].'/system/modules/facebook/function.php');			
					
			facebook_status_update($Status_Message);			
			}
			
		}
		
		$redirect_url = DOCROOT."admin/couponsupload/";
		set_response_mes(1,$admin_language['couponcreated']); 	

		if(($_FILES["cpicture"]["size"] > $uploadimageSize['deal_pic']) || ($_FILES["slide1"]["size"] > $uploadimageSize['deal_pic']) || ($_FILES["slide2"]["size"] > $uploadimageSize['deal_pic']) || ($_FILES["slide3"]["size"] > $uploadimageSize['deal_pic']))
		{
			$size = round($uploadimageSize['profile_pic']/1024000);
			$img_err2 = "Image file size should lesser than ".$size.'MB';
			set_response_mes(1,$admin_language['couponcreated'].$img_err2);
		}

		url_redirect($redirect_url);

    
    }
    
    
    
  
    function ranval($length = 8)
    { 

	for($j=1; $j<=3; $j++){
		$alpha = '0123456789ABCDEFGHJKLMNPQRSTUVWXYZ';
		$alpha = str_split($alpha, 1);
		$max = count($alpha) - 1;
		$str = '';
		for ($i = 0; $i < $length; $i++)
		{
			$str .= $alpha[mt_rand(0, $max)];
		}
		 $record = mysql_query("select coupon_validityid from coupons_purchase where coupon_validityid='".$str."'");
		 if(count($record) == 0){
		 	return $str;
		 }
	}
	return $str;            
            
    }
    

    function referral_ranval($length = 8)
    { 
	   
	for($j=1; $j<=3; $j++){
			$alpha = '0123456789ABCDEFGHJKLMNPQRSTUVWXYZ';
			$alpha = str_split($alpha, 1);
			$max = count($alpha) - 1;
			$str = '';
			for ($i = 0; $i < $length; $i++)
			{
				$str .= $alpha[mt_rand(0, $max)];
			}
			 $record = mysql_query("select referral_id from coupons_users where referral_id='".$str."'");
			 if(count($record) == 0){
			 	return $str;
			 }
	}
	return $str;           
 
    }
    
	//add the twitter account 
	function updateTWuser($oauth_request_token = '',$oauth_request_token_secret = '',$twitter_userid = '',$username='')
	{
               
		if($_SESSION["userrole"] == 1)
		{ 
				$userid = $_SESSION["userid"];
				$image_path = "http://a1.twimg.com/sticky/default_profile_images/default_profile_2_normal.png";
				$oauth_request_token = htmlentities($oauth_request_token, ENT_QUOTES);
				$oauth_request_token_secret = htmlentities($oauth_request_token_secret, ENT_QUOTES);
				
				$check_account_exist = mysql_query("select * from social_account where account_user_id = '$twitter_userid' ");
				
				if(mysql_num_rows($check_account_exist) == 0)
				{
					$update_users_fb = mysql_query("insert into social_account(first_name,image_url,account_user_id,access_token,access_token_secret,userid,type)values('$username','$image_path','$twitter_userid','$oauth_request_token','$oauth_request_token_secret','$userid','2')");
					$_SESSION["mes"] = "Twitter account has been added";
				}
				else
				{
					$_SESSION["emes"] = "Twitter account already exist";
				}
		}
		return;

	}
	
	/*
    function updateFBuser($userid = "", $image = "", $access_token = "", $FB_user_id = "")
	{
		if($access_token && $FB_user_id){
			$update_users_fb = mysql_query("update coupons_users set facebook_userid='$FB_user_id', fb_access_token='$access_token' where userid='$userid'");
			$_SESSION["facebook_userid"] = $FB_user_id;
			$_SESSION["fb_access_token"] = $access_token;
			if($image){
				$img = DOCUMENT_ROOT.'/uploads/profile_images/'.$userid.'.jpg';
				$user_img = file_get_contents($image);
				file_put_contents($img, $user_img);
			}
		}
		return;
	}
	*/
    
    function getcoupons($type = '',$val = '',$default_city_id = '')
    {
		
		if($type=="H")
		{ 	//select hot deals
			
			$queryString = "select *,TIMEDIFF(coupons_coupons.coupon_enddate,now())as timeleft,( SELECT count( p.coupon_purchaseid ) FROM coupons_purchase p WHERE p.couponid = coupons_coupons.coupon_id and p.Coupon_amount_Status='T' ) AS pcounts from coupons_coupons left join coupons_shops on coupons_coupons.coupon_shop = coupons_shops.shopid left join coupons_cities on coupons_shops.shop_city = coupons_cities.cityid left join coupons_country on coupons_shops.shop_country = coupons_country.countryid where ";
			
			//add the city condition
			if($default_city_id)
			{
				$queryString .= " coupons_coupons.coupon_city = '$default_city_id' AND ";
			}
			
			$queryString .= " coupons_coupons.coupon_status = 'A' and coupons_coupons.coupon_startdate <= now() and coupons_coupons.coupon_enddate > now() order by coupons_coupons.coupon_id desc";
		

		}
		else if($type=="P")
		{ 
		
		//select past deals		
		$queryString = "select *,TIMEDIFF(coupons_coupons.coupon_enddate,now())as timeleft,( SELECT count( p.coupon_purchaseid ) FROM coupons_purchase p WHERE p.couponid = coupons_coupons.coupon_id and p.Coupon_amount_Status='T' ) AS pcounts from coupons_coupons left join coupons_shops on coupons_coupons.coupon_shop = coupons_shops.shopid left join coupons_cities on coupons_shops.shop_city = coupons_cities.cityid left join coupons_country on coupons_shops.shop_country = coupons_country.countryid where ";
			
		//add the city condition
		if($default_city_id)
		{
	
			$queryString .= "(coupons_coupons.coupon_city = '$default_city_id' AND (coupons_coupons.coupon_enddate between DATE_SUB(now(), INTERVAL 10 DAY) and now() and coupons_coupons.coupon_status in ('A'))) or (coupons_coupons.coupon_city = '$default_city_id' AND coupons_coupons.coupon_status='C') order by coupons_coupons.coupon_id desc";

		}
		else
		{
	
			$queryString .= "(coupons_coupons.coupon_enddate between DATE_SUB(now(), INTERVAL 10 DAY) and now() and coupons_coupons.coupon_status in ('A')) or coupons_coupons.coupon_status='C' order by coupons_coupons.coupon_id desc";


		}
		//echo $queryString ;	

		}
		else if($type=="T")
		{
			//select today deals
			$queryString = "select TIMEDIFF(coupons_coupons.coupon_enddate,now())as timeleft, coupon_id,coupon_name,deal_url,coupon_description,coupon_startdate,coupon_enddate,coupon_image,coupon_realvalue,coupon_value from coupons_coupons where ";
			//add the city condition
			if($default_city_id)
			{
				$queryString .= " coupon_city = '$default_city_id' AND ";
			}
			
			$current_startdate = date("Y-m-d").' 00:00:00';
			$current_enddate = date("Y-m-d").' 23:59:59';
						
			$queryString .= " coupon_enddate between '$current_startdate' and '$current_enddate' AND coupon_status = 'A'  order by coupon_id desc";

		}
		else if($type=="C")
		{
			//select hot deals
			$queryString = "select *,TIMEDIFF(coupons_coupons.coupon_enddate,now())as timeleft,( SELECT count( p.coupon_purchaseid ) FROM coupons_purchase p WHERE p.couponid = coupons_coupons.coupon_id and p.Coupon_amount_Status='T' ) AS pcounts from coupons_coupons left join coupons_shops on coupons_coupons.coupon_shop = coupons_shops.shopid left join coupons_cities on coupons_shops.shop_city = coupons_cities.cityid left join coupons_country on coupons_shops.shop_country = coupons_country.countryid where ";
			
			//add the city condition
			if($default_city_id)
			{
				$queryString .= " coupon_city = '$default_city_id' AND ";
			}
			
			$queryString .= " coupon_category = '$val' AND coupon_status = 'A'  and coupon_startdate <= now() and coupon_enddate > now() order by coupon_id desc ";

		}
		else if($type=="S")
		{
			//select hot deals
			$queryString = "select TIMEDIFF(coupons_coupons.coupon_enddate,now())as timeleft, coupon_id,coupon_name,deal_url,coupon_description,coupon_startdate,coupon_enddate,coupon_image,coupon_realvalue,coupon_value from coupons_coupons where ";
			
			//add the city condition
			if($default_city_id)
			{
				$queryString .= " (coupon_city = '$default_city_id') AND ";
			}
			
			$queryString .= " (coupon_name like '%$val%' || coupon_description like '%$val%')  AND (coupon_status = 'A')   and coupon_enddate > now()  order by coupon_id desc";
			
		}
		else
		{
			//select deals
			$queryString = "select TIMEDIFF(coupons_coupons.coupon_enddate,now())as timeleft, coupon_id,coupon_name,deal_url,coupon_description,coupon_startdate,coupon_enddate,coupon_image,coupon_realvalue,coupon_value from coupons_coupons where coupon_startdate <= now() and coupon_enddate > now() order by coupon_id desc";


		}

	include(DOCUMENT_ROOT."/themes/".CURRENT_THEME."/pages/getcoupons.php"); //include the remaining content		
		
   }
    
 
    //get the random products
    function random_coopens($coupons_subtype)
    {
     include "docroot.php";
    $turl_arr = explode("/",$_SERVER["REQUEST_URI"]);
    // to show the list of subtypes in the selected type 
    if($coupons_subtype!='')
    {
            $query = "select * ,TIMEDIFF(coupon_enddate,now())as timeleft from coupons_coupons where coupon_status='A' and coupon_enddate > now() and coupons_subtype='$coupons_subtype' order by RAND() limit 0,25";
    }
    else
    {
            $query = "select * ,TIMEDIFF(coupon_enddate,now())as timeleft from coupons_coupons where coupon_status='A' and coupon_enddate > now() order by RAND() limit 0,25";
    }       
            $result = mysql_query($query);
            $coupons_subtype='';
    
    
    if($turl_arr[1]=='index.php' || $turl_arr[1]=='')
    {
    
            if(mysql_num_rows($result)>0)
            {
            ?>
    <div class="h_bbox fl mt20"  id="makeMeScrollable"> 
    <div class="h_slide fl">
            <div class="scrollingHotSpotLeft "></div>
            <div class="scrollingHotSpotRight "></div> 
            <div class="random_coopens3"><h3>Featured Coopons:</h3></div>
            <div class="scrollWrapper fl ">
            <div class="random_coopens scrollableArea" onMouseOver="javascript: stopscroll();" onMouseOut="javascript: startscroll();">
    
            <?php 
                    while($data = mysql_fetch_array($result) )
                    {
            if($data['timeleft'] > 0) 
            {           
                            ?>
    
                            <div class="random_items mt20 fl">
    
                            <a href=' <?php echo $docroot; ?>user/icoopon/<?php echo $data['coupon_outsideurl'];?>' title="<?php echo html_entity_decode(ucfirst($data['couponname']), ENT_QUOTES);?>">
                            <?php if($data['coupon_image']){ ?>
                            <img src="<?php echo $docroot; ?>imaging.php/image-name.jpg?width=100&height=100&cropratio=1:1&noimg=100&image=<?php echo $docroot.$data['coupon_image']; ?>" title="<?php echo html_entity_decode(ucfirst($data['couponname']), ENT_QUOTES);?>" alt="<?php echo html_entity_decode(ucfirst($data['couponname']), ENT_QUOTES);?>" >
                            <?php }else{ ?>
                            <img src="<?php echo $docroot; ?>imaging.php/image-name.jpg?width=100&height=100&cropratio=1:1&image=<?php echo $docroot; ?>images/nothing.jpg" title="<?php echo html_entity_decode(ucfirst($data['couponname']), ENT_QUOTES);?>" alt="<?php echo html_entity_decode(ucfirst($data['couponname']), ENT_QUOTES);?>" >
                            <?php } ?>
                            </a> <br>
                            
                            <a href=' <?php echo $docroot; ?>user/icoopon/<?php echo $data['coupon_outsideurl'];?>' title="<?php echo html_entity_decode(ucfirst($data['couponname']), ENT_QUOTES);?>">
                            <?php if(strlen(html_entity_decode($data['couponname'], ENT_QUOTES))>12) { echo substr(html_entity_decode(ucfirst($data['couponname']), ENT_QUOTES),0,12)."..."; } else { echo html_entity_decode(ucfirst($data['couponname']), ENT_QUOTES); }?>
                            </a>
                            </div>
                            
                            <?php 
                    } 
                    }?>
            </div>
            </div>
      
    </div>
    </div>
     
            
                    <?php 
       
       }
       }
       
    else
    {
    
            if(mysql_num_rows($result)>0)
            {
            ?>
    <div class="h_bbox2 fl mt20 ml5"  id="makeMeScrollable"> 
    <div class="h_slide2 fl">
            
            <div class="scrollingHotSpotLeft "></div>
            <div class="scrollingHotSpotRight "></div> 
            <div class="random_coopens3"><h3>Featured Coopons:</h3></div>
            <div class="scrollWrapper fl ">
    
            <div class="random_coopens scrollableArea" onMouseOver="javascript: stopscroll();" onMouseOut="javascript: startscroll();">
                    
            <?php 
                    while($data = mysql_fetch_array($result) )
                    {
            if($data['timeleft'] > 0) 
            {           
                            ?>
    
                            <div class="random_items2">
    
                            <a href=' <?php echo $docroot; ?>user/icoopon/<?php echo $data['coupon_outsideurl'];?>' title="<?php echo html_entity_decode(ucfirst($data['couponname']), ENT_QUOTES);?>">
                            <?php if($data['coupon_image']){ ?>
                            <img src="<?php echo $docroot; ?>imaging.php/image-name.jpg?width=100&height=100&cropratio=1:1&noimg=100&image=<?php echo $docroot.$data['coupon_image']; ?>" title="<?php echo html_entity_decode(ucfirst($data['couponname']), ENT_QUOTES);?>" alt="<?php echo html_entity_decode(ucfirst($data['couponname']), ENT_QUOTES);?>" >
                            <?php }else{ ?>
                            <img src="<?php echo $docroot; ?>imaging.php/image-name.jpg?width=100&height=100&cropratio=1:1&image=<?php echo $docroot; ?>images/nothing.jpg" title="<?php echo html_entity_decode(ucfirst($data['couponname']), ENT_QUOTES);?>" alt="<?php echo html_entity_decode(ucfirst($data['couponname']), ENT_QUOTES);?>" >
                            <?php } ?>
                            </a> <br>
                            <a href=' <?php echo $docroot; ?>user/icoopon/<?php echo $data['coupon_outsideurl'];?>' title="<?php echo html_entity_decode(ucfirst($data['couponname']), ENT_QUOTES);?>">
                            <?php if(strlen(html_entity_decode($data['couponname'], ENT_QUOTES))>12) { echo substr(html_entity_decode(ucfirst($data['couponname']), ENT_QUOTES),0,12)."..."; } else { echo html_entity_decode(ucfirst($data['couponname']), ENT_QUOTES); }?>
                            </a>
                            </div>
                            
                            <?php 
                    } 
                    }?>
            </div>
            </div>
      
    </div>
    </div>
     
            
                    <?php 
       
       }
       }
     
    }

     function easyRegister($userid,$firstname,$lastname,$email,$image,$login_type)
    {

            if($login_type == '2')
            {
            $queryString = "select username,password from coupons_users where username='".$userid."' ";
            }
            else
            {
              $queryString = "select username,password from coupons_users where email='".$email."' and login_type='".$login_type."'";
            }
        
     
            $resultSet = mysql_query($queryString);
            if(mysql_num_rows($resultSet)>0)
            {   
                         $noticia = mysql_fetch_array($resultSet);
                         loginCheck($noticia['username'],$noticia['password']);
                       
            }
            else
            {

		    if(!empty($email))
		    {
		            $query_email = "select email from coupons_users where email='".$email."'";
		            $result_email = mysql_query($query_email);
		            
		            if(mysql_num_rows($result_email)>0)
		            {   
		                       
		                        set_response_mes(-1,'Email Already Exist'); 	
					?><script type="text/javascript">
					window.opener.location = '/';  
					window.close();
					</script>
					<?php   
					exit; 
					                    
		                       
		            }
		    }

                $roleid=4;
                $uid=maxUserId()+1;
                $ranval = referral_ranval();
		$firstname = htmlentities($firstname, ENT_QUOTES);
		$lastname = htmlentities($lastname, ENT_QUOTES);

                $queryString = "insert into coupons_users
                         (username,password,email,user_role,created_by,created_date,user_status,firstname,lastname,referral_id,login_type) values
                         ('$userid','798449d5cc26268f9a3aaa356b639ca6','$email',$roleid,$uid,now(),'A','$firstname','$lastname','$ranval','$login_type')";
                $resultset = mysql_query($queryString) or die(mysql_error());
                $insert_id = mysql_insert_id();
                $img = DOCUMENT_ROOT.'/uploads/profile_images/'.$insert_id.'.jpg';
                $user_img = file_get_contents($image);
                file_put_contents($img, $user_img);
                loginCheck($userid,'798449d5cc26268f9a3aaa356b639ca6');
           }
    }
    
    function report($type)
    {

    include "docroot.php";
    $lang = $_SESSION["site_language"];
    if($lang)
    {
        include(DOCUMENT_ROOT."/system/language/".$lang.".php");
    }
    else
    {
        include(DOCUMENT_ROOT."/system/language/en.php");
    }
	
    if($type=='coupons')
    {
    
     $queryString = "SELECT (
    
    SELECT count( p.coupon_purchaseid )
    FROM coupons_purchase p
    WHERE p.couponid = c.coupon_id and p.Coupon_amount_Status='T'
    ) AS pcounts, c.coupon_id, c.coupon_name, DATE_FORMAT( c.coupon_startdate, '%d %M %Y' ) AS startdate, DATE_FORMAT( c.coupon_enddate, '%d %M %Y' ) AS enddate, c.coupon_createdby,u.firstname,u.lastname,c.coupon_status,c.coupon_minuserlimit as minuserlimit,c.coupon_maxuserlimit as maxuserlimit
    FROM coupons_coupons c, coupons_users u  where u.userid=c.coupon_createdby and c.coupon_status in ('A','D') and c.coupon_enddate > now()";

		
        $pages = new Paginator;
	$pages->mid_range = 5; // Number of pages to display. Must be odd and > 3
	$pages->paginate($queryString);
	$resultSet = $pages->rspaginate;

            if(mysql_num_rows($resultSet)>0)
            {
    
                         echo '<table cellpadding="0" cellspacing="0">';
    		     echo '<tr class="fwb"><td>Coupon Name</td><td>Start Date</td> <td>End Date</td><td>Created By</td><td>Min User</td><td>Max User</td><td>Purchase Count</td>';
    
			  if($_SESSION['userrole']=='1') {
			  echo '<td width="15%">&nbsp;</td>';
			  }
    
	    	     echo '</tr>';
                while($noticia=mysql_fetch_array($resultSet))
                { 
                    echo '<tr><td>'.ucfirst(html_entity_decode($noticia['coupon_name'], ENT_QUOTES)).'</td><td>'.html_entity_decode($noticia['startdate'], ENT_QUOTES).'</td><td>'.html_entity_decode($noticia['enddate'], ENT_QUOTES).'</td><td>'.ucfirst(html_entity_decode($noticia['firstname'], ENT_QUOTES)).'</td><td>'.html_entity_decode($noticia['minuserlimit'], ENT_QUOTES).'</td><td>'.html_entity_decode($noticia['maxuserlimit'], ENT_QUOTES).'</td><td>'.$noticia['pcounts'].'</td>';
                    
                    if($_SESSION['userrole']=='1') {
                    echo '<td><a href="'.$docroot.'edit/coupon/'.$noticia['coupon_id'].'/" class="edit_but" title="Edit"></a>';
                    
                    if($noticia['coupon_status']=="D")
                    {
			echo '<a href="javascript:;" onclick="updatecoupon(\'A\',\''.$noticia["coupon_id"] .'\');" class="unblock" title="Unblock"></a>';
                    }
                    else{
	                    echo '<a href="javascript:;" onclick="updatecoupon(\'D\',\''.$noticia["coupon_id"] .'\');" class="block" title="Block"></a>';
		}                    

                    echo '<a href="javascript:;" onclick="javascript:deletecoupon('.$noticia["coupon_id"].');" class="delete"></a></td>';
                   
                    }
                    
                    if($noticia['pcounts'] > 0)
                    {
                    echo '<td><a href="'.$docroot.'coupon/code/'.$noticia['coupon_id'].'">Start Offer</a></td>';
                    }
                                        
                    echo '</tr>';
    
                }
                        echo '</table>';
                if($pages->rspaginateTotal>20) {  
                echo '<table border="0" width="650" align="center" cellpadding="10">';
		echo '<tr><td align="center"><div class="pagenation">';
		echo $pages->display_pages();
		echo '</div></td></tr>';
		echo '</table>';

               }
             }
            else
            {
                          echo '<p class="nodata">No Deals Available</p>';
            }

            
    }
    
    else if($type=="shops")
    {
        $cityid = $_SESSION['city'];
         $queryString = "SELECT *, DATE_FORMAT('shop_createddate', '%D %b %y' ) AS cdate ,s.shop_status as status
                    FROM coupons_shops s
                    LEFT JOIN coupons_users ON shop_createdby = userid
                    LEFT JOIN coupons_country ON countryid = shop_country
                    LEFT JOIN coupons_cities ON cityid = shop_city
                    WHERE shop_status in ('A','D')";
    
            if($_SESSION['userrole']==2)
                 $queryString .=	" AND shop_city = '$cityid'";
                 
		
 
        $pages = new Paginator;
	$pages->mid_range = 5; // Number of pages to display. Must be odd and > 3
	$pages->paginate($queryString);
	$resultSet = $pages->rspaginate;
            
            if(mysql_num_rows($resultSet)>0)
            {
		echo '<table cellpadding="0" cellspacing="0" class="coupon_report">';
		echo '<tr class="fwb"><td>Shop Name</td><td>Created Date</td>';
		if( $_SESSION['userrole']=='1') {
		echo '<td>City</td><td>Country</td>';
		}
		
		if($_SESSION['userrole']=='2' || $_SESSION['userrole']=='1') {
		echo '<td>&nbsp;</td>';
		}
		echo '</tr>';
                while($noticia=mysql_fetch_array($resultSet))
                { 
                    echo '<tr><td>'.ucfirst(html_entity_decode($noticia['shopname'], ENT_QUOTES)).'</td><td>'.$noticia['shop_createddate'].'</td>';
                    if( $_SESSION['userrole']=='1') {
                    echo '<td>'.ucfirst(html_entity_decode($noticia['cityname'], ENT_QUOTES)).'</td><td>'.ucfirst(html_entity_decode($noticia['countryname'], ENT_QUOTES)).'</td>';
                    }

                    if($_SESSION['userrole']=='2' || $_SESSION['userrole']=='1') {
                    echo '<td><a href="'.$docroot.'edit/shop/'.$noticia['shopid'].'/" class="edit_but" title="Edit"></a>';


                    if($noticia['status']=="D")
                    {
	                    echo '<a href="javascript:;" onclick="updateshop(\'A\',\''.$noticia["shopid"] .'\');" class="unblock" title="Unblock"></a>';
                    }else{
	                    echo '<a href="javascript:;" onclick="updateshop(\'D\',\''.$noticia["shopid"] .'\');" class="block" title="Block"></a>';                    
                    }

	                    echo '<a href="javascript:;" onclick="javascript:deleteshop('.$noticia["shopid"].');" class="delete" title="Delete"></a></td>';                    
                    
                    }
                    echo '</tr>';
    
                }
                        echo '</table>';
    
                if($pages->rspaginateTotal>20) {    
                echo '<table border="0" width="650" align="center" cellpadding="10">';
		echo '<tr><td align="center"><div class="pagenation">';
		echo $pages->display_pages();
		echo '</div></td></tr>';
		echo '</table>';
		
               }
               }               
            else
            {
                          echo '<p class="nodata">No Merchant Accounts Available</p>';
            }
    
    }
        
    else if($type=='users')
    {
    $queryString = "select u.userid,u.username,u.firstname,u.lastname,u.email,u.mobile,u.user_role,r.role_name,u.created_by,u.user_status
      from coupons_users u,coupons_roles r where r.roleid=u.user_role and u.user_status in ('A','D') ";
            
		
        $pages = new Paginator;
	$pages->mid_range = 5; // Number of pages to display. Must be odd and > 3
	$pages->paginate($queryString);
	$resultSet = $pages->rspaginate;
 
            if(mysql_num_rows($resultSet)>0)
            {
		echo '<p style="color:#666;width:100%;" class="fwb txtcenter">* Note: AD - Admin, DM - Demo Admin.<br/>CM - City Manager, SA - Store Administrator, G - General User.</p>';
                        echo '<table cellpadding="0" cellspacing="0" class="">';
		    echo '<tr class="fwb"><td>User Name</td><td>Role</td><td>Mobile</td><td>Created By</td><td width="15%" >&nbsp;</td>';  
    echo '</tr>';
    
                while($noticia=mysql_fetch_array($resultSet))
                { 
    
                    echo '<tr><td>'.ucfirst(html_entity_decode($noticia['firstname'], ENT_QUOTES)).'</td><td>'.$noticia['role_name'].'</td><td>'.html_entity_decode($noticia['mobile'], ENT_QUOTES).'</td>
					<td>'.ucfirst(html_entity_decode($noticia['firstname'], ENT_QUOTES)).'</td>
					<td><a href="'.$docroot.'admin/edit/'.$noticia['role_name'].'/'.$noticia['userid'].'/" class="edit_but" title="Edit"></a>';
                    

                  
		          if($noticia['user_status']=="D")
		          {
		          echo '<a href="javascript:;" onclick="updateuser(\'A\',\''.$noticia["userid"] .'\');" class="block" title="Block"></a>';
		          }
		          else
		          {
		          echo '<a href="javascript:;" onclick="updateuser(\'D\',\''.$noticia["userid"] .'\');" class="unblock" title="Unblock"></a>';
		          }

		          echo '<a href="javascript:;" onclick="javascript:deleteuser('.$noticia["userid"].');" class="delete" title="Delete"></a>';
                    
		
                    echo '</td></tr>';
                            }
                        echo '</table>';
                    if($pages->rspaginateTotal>20) {
                    echo '<table border="0" width="650" align="center" cellpadding="10">';
		echo '<tr><td align="center"><div class="pagenation">';
		echo $pages->display_pages();
		echo '</div></td></tr>';
		echo '</table>';
		 }   
               }
               
            else
            {
                          echo '<p class="nodata">No City Managers Available</p>';
            }
    }
    
    else if($type=='closecoupon')
    {
       $queryString =" SELECT c.coupon_id, (select username from coupons_users where userid = p.coupons_acceptedby) as coupons_acceptedby ,u.firstname, u.lastname, u.mobile, p.coupon_purchaseid,p.couponid,c.coupon_name,p.coupon_userid,p.coupon_validityid,p.coupon_validityid_date,p.coupon_validityid_createdby,p.coupons_userstatus  FROM coupons_purchase p,coupons_users u,coupons_coupons c where p.coupon_status='C' and u.userid=p.coupon_userid and c.coupon_id=p.couponid";
    
		
	$pages = new Paginator;
	$pages->mid_range = 5; // Number of pages to display. Must be odd and > 3
	$pages->paginate($queryString);
	$resultSet = $pages->rspaginate;
   
    
            if(mysql_num_rows($resultSet)>0)
            {

                        echo '<p style="color:#666;width:100%;" class="fwb txtcenter">* Note: UN-User Yet to Use this Offer in the Shop. <br/> U-User Used this Offer in the Shop. </p>';
                        echo '<table cellpadding="0" cellspacing="0">';
                        echo '<tr class="fwb"><td>User Name</td><td>Coupon Name</td> <td>Validated By</td><td>Mobile</td><td>Validated Date</td><td>Status</td><td width="5%">&nbsp;</td><td width="10%">&nbsp;</td></tr>';
                while($noticia=mysql_fetch_array($resultSet))
                { 
                    echo '<tr><td>'.ucfirst(html_entity_decode($noticia['firstname'], ENT_QUOTES)).'</td><td>'.ucfirst(html_entity_decode($noticia['coupon_name'], ENT_QUOTES)).'</td><td>';
                    
                    if($noticia['coupons_acceptedby']!="")
	                    echo ucfirst($noticia['coupons_acceptedby']);
                    else
	                    echo '-';
                    
                    echo '</td> <td>'.html_entity_decode($noticia['mobile'], ENT_QUOTES).'</td><td>'.$noticia['coupon_validityid_date'].'</td>
					<td>'.$noticia['coupons_userstatus'].'</td>
    <td><a href="'.$docroot.'admin/viewclosedcoupon/'.$noticia['coupon_id'].'/" class="edit_but" title="View"></a></td>';
    
    if($noticia['coupons_userstatus']=="UN")
    echo '<td><a href="javascript:;" onclick=" getPid(\''.$noticia['coupon_validityid'].'\')" title="Close Offer">Close Offer</a></td>';
    
    echo '</tr>';
                            }
    
                        echo '</table>';

               if($pages->rspaginateTotal>20) {
                    echo '<table border="0" width="650" align="center" cellpadding="10">';
		echo '<tr><td align="center"><div class="pagenation">';
		echo $pages->display_pages();
		echo '</div></td></tr>';
		echo '</table>';
                }
               }
               
            else
            {
                          echo '<p class="nodata">No Deals Available</p>';
            }
    
    }
    
    else if($type=="mycoupon")
    {
        
          $queryString ="SELECT (
if( LENGTH( concat( u.firstname, u.lastname ) ) =0, u.username, concat( u.firstname, u.lastname ) )
) AS name, u.mobile, p.coupon_purchaseid, p.coupon_purchaseddate, p.couponid,transaction_details.CAPTURED, c.coupon_status, c.coupon_name, c.coupon_enddate, c.coupon_expirydate, c.coupon_image, p.coupon_userid, p.coupon_validityid, p.coupon_validityid_date, p.coupon_validityid_createdby, p.coupons_userstatus,p.gift_recipient_id
FROM coupons_purchase p LEFT JOIN coupons_users u ON u.userid = p.coupon_userid LEFT JOIN coupons_coupons c ON c.coupon_id = p.couponid LEFT JOIN transaction_details on p.transaction_details_id=transaction_details.ID WHERE p.Coupon_amount_Status = 'T' AND p.coupon_userid = '".$_SESSION['userid']."' ORDER BY p.coupon_purchaseid DESC";
    
		
        $pages = new Paginator;
	$pages->mid_range = 5; // Number of pages to display. Must be odd and > 3
	$pages->paginate($queryString);
	$resultSet = $pages->rspaginate;

            if(mysql_num_rows($resultSet)>0)
            {
                if($_SESSION["userrole"] == 4)
                {

			include(DOCUMENT_ROOT."/themes/".CURRENT_THEME."/pages/my-coupons-details.php"); //include the remaining content		

                }
                else
                {
				?>
				<div style="color:#666;width:100%;" class="fwb txtcenter">
				<?php echo $language['note']; ?>: UN - <?php echo $language['user_yet_to_use']; ?> <br/> U - <?php echo $language['user_used']; ?><br/> <?php echo $language['validityid']; ?> - <?php echo $language['validityid_generated']; ?> <br/><?php echo $language['validated_date']; ?> - <?php echo $language['coupon_validated_date']; ?></div>
				
				<table cellpadding="5" cellspacing="5" class="fl clr">
				<tr class="fwb"><td><?php echo $language['coupon_name']; ?></td> <td><?php echo $language['validityid']; ?></td><td><?php echo $language['validated_date']; ?></td><td><?php echo $language['status']; ?></td></tr>
                
				<?php         
                while($noticia=mysql_fetch_array($resultSet))
                { 
				?>
                    <tr><td><?php echo ucfirst(html_entity_decode($noticia['coupon_name'], ENT_QUOTES)); ?></td><td>
					
					<?php 
                    if($noticia['coupon_validityid']!='')
	                    echo $noticia['coupon_validityid'];
                    else
	                    echo '-';
                    ?>
                    </td> 
					
					<td>
                    <?php 
                    if($noticia['coupon_validityid_date']!='')
	                    echo $noticia['coupon_validityid_date'];
                    else
	                    echo '-';
	                 ?>   
                    </td><td><?php $noticia['coupons_userstatus'];?></td>
					</tr>
                    
                      <?php 
					        }
    ?>
			</table>

              <?php 
			if($pages->rspaginateTotal>20) {?>

		<table border="0" width="650" align="center" cellpadding="10">
		<tr><td align="center">
        <div class="pagenation">
		<?php echo $pages->display_pages(); ?>
        </div>
		</td></tr>
		</table>

		<?php 
                  }
                }
               }
                   else
                    {
                        echo '<p class="nodata" style="margin-left:10px;">'.$language['no_coupons_purchased'].'</p>';
                    }
    
    }
    
    elseif($type=='cmcitycoupon')
    {
    
    $queryString = "SELECT (
    
    SELECT count( p.coupon_purchaseid )
    FROM coupons_purchase p
    WHERE p.couponid = c.coupon_id and p.Coupon_amount_Status='T'
    ) AS pcounts, c.coupon_id, c.coupon_name, DATE_FORMAT( c.coupon_startdate, '%d %M %Y' ) AS startdate, DATE_FORMAT( c.coupon_enddate, '%d %M %Y' ) AS enddate, c.coupon_createdby, u.firstname, u.lastname,c.coupon_status,c.coupon_minuserlimit as minuserlimit,c.coupon_maxuserlimit as maxuserlimit
    FROM coupons_coupons c, coupons_users u  where u.userid=c.coupon_createdby and c.coupon_status in ('A','D') and c.coupon_city = ".$_SESSION['city'];
    
		

        $pages = new Paginator;
	$pages->mid_range = 5; // Number of pages to display. Must be odd and > 3
	$pages->paginate($queryString);
	$resultSet = $pages->rspaginate;

            
            if(mysql_num_rows($resultSet)>0)
            {
                         echo '<table cellpadding="0" cellspacing="0"   class="coupon_report">';

		    echo '<tr class="fwb"><td>Coupon Name</td><td>Start Date</td> <td>End Date</td><td>Created By</td><td>Min User</td><td>Max User</td><td>Purchase Count</td><td  width="15%">&nbsp;</td><td  width="10%">&nbsp;</td></tr>';

    
                while($noticia=mysql_fetch_array($resultSet))
                { 
                    echo '<tr><td>'.ucfirst(html_entity_decode($noticia['coupon_name'], ENT_QUOTES)).'</td><td>'.html_entity_decode($noticia['startdate'], ENT_QUOTES).'</td> <td>'.html_entity_decode($noticia['enddate'], ENT_QUOTES).'</td><td>'.ucfirst(html_entity_decode($noticia['firstname'], ENT_QUOTES)).' '.ucfirst(html_entity_decode($noticia['firstname'], ENT_QUOTES)).'</td><td>'.html_entity_decode($noticia['minuserlimit'], ENT_QUOTES).'</td><td>'.html_entity_decode($noticia['maxuserlimit'], ENT_QUOTES).'</td><td>'.$noticia['pcounts'].'</td><td><a class="edit_but" title="Edit" href="'.$docroot.'edit/coupon/'.$noticia['coupon_id'].'/"></a>';
                    
                    if($noticia['coupon_status']=="D")
                    {
			echo '<a href="javascript:;" title="Unblock" class="unblock" onclick="updatecoupon(\'A\',\''.$noticia["coupon_id"] .'\');"></a>';
                    }
                    else{
	                    echo '<a href="javascript:;" class="block" title="Block" onclick="updatecoupon(\'D\',\''.$noticia["coupon_id"] .'\');"></a>';
		}                    

                    echo '<a href="javascript:;" class="delete" title="Delete" onclick="javascript:deletecoupon('.$noticia["coupon_id"].');"></a></td>';
                    
                    
                    if($noticia['pcounts'] > 0)
                    {
                    echo '<td><a href="'.$docroot.'coupon/code/'.$noticia['coupon_id'].'">Start Offer</a></td>';
                    }
                    echo '</tr>';
    
                }
                        echo '</table>';
                if($pages->rspaginateTotal>20) {
                    echo '<table border="0" width="650" align="center" cellpadding="10">';
		echo '<tr><td align="center"><div class="pagenation">';
		echo $pages->display_pages();
		echo '</div></td></tr>';
		echo '</table>';              
                 }       
               }
               
            else
            {
                          echo '<p class="nodata">No Data Available</p>';
            }
    }
    
    elseif($type=='cmcityclosecoupon')
    {
       $queryString =" SELECT  (select username from coupons_users where userid = p.coupons_acceptedby) as coupons_acceptedby ,u.firstname, u.lastname, u.mobile,c.coupon_id,  p.coupon_purchaseid,p.couponid,c.coupon_name,p.coupon_userid,p.coupon_validityid,p.coupon_validityid_date,p.coupon_validityid_createdby,p.coupons_userstatus FROM coupons_purchase p,coupons_users u,coupons_coupons c where p.coupon_status='C' and u.userid=p.coupon_userid and c.coupon_id=p.couponid and c.coupon_city = " .$_SESSION['city'];
    
		

        $pages = new Paginator;
	$pages->mid_range = 5; // Number of pages to display. Must be odd and > 3
	$pages->paginate($queryString);
	$resultSet = $pages->rspaginate;
    
            if(mysql_num_rows($resultSet)>0)
            {

                        echo '<p style="color:#666;width:100%;" class="fwb txtcenter">* Note: UN - User Yet to Use this Offer in the Shop. <br />U - User Used this Offer in the Shop. </p>';
                        echo '<table cellpadding="0" cellspacing="0"   class="coupon_report" >';
                        
		    echo '<tr class="fwb"><td>User Name</td><td>Coupon Name</td> <td>Validated By</td><td>Mobile</td><td>Validated Date</td><td>Status</td><td width="5%">View</td><td width="10%">Close</td></tr>';

    
                while($noticia=mysql_fetch_array($resultSet))
                { 
                    echo '<tr><td>'.ucfirst(html_entity_decode($noticia['firstname'], ENT_QUOTES)).'</td><td>'.ucfirst(html_entity_decode($noticia['coupon_name'], ENT_QUOTES)).'</td><td>'.ucfirst($noticia['coupons_acceptedby']).'</td> <td>'.html_entity_decode($noticia['mobile'], ENT_QUOTES).'</td><td>'.$noticia['coupon_validityid_date'].'</td><td>'.$noticia['coupons_userstatus'].'</td><td><a href="'.$docroot.'admin/viewclosedcoupon/'.$noticia['coupon_id'].'/">View</a></td>';
    
    if($noticia['coupons_userstatus']=="UN")
    echo '<td><a href="javascript:;" onclick=" getPid(\''.$noticia['coupon_validityid'].'\')">Close Offer</a></td>';
    
    echo '</tr>';
                            }
                        echo '</table>';
                   if($pages->rspaginateTotal>20) {
                    echo '<table border="0" width="650" align="center" cellpadding="10">';
		echo '<tr><td align="center"><div class="pagenation">';
		echo $pages->display_pages();
		echo '</div></td></tr>';
		echo '</table>';
                }
    
               }
               
            else
            {
                          echo '<p class="nodata">No Coupons Available</p>';
            }
    
    }
    
    elseif($type=='all')
    {}
    
    
    }
    
	//valid url format 
    function valid_url($message)
    {
        return ( ! preg_match('/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i', $message)) ? FALSE : TRUE;
    }
    
    function email($to,$subject,$message)
    {

	    $from = "demo@ndot.in";
	    $header = "Content-Type: text/html"."\r\n"."From: $from";
	    $result = valid_url($message);
		    if($result == '1')
		    {
		    $message = file_get_contents($message);
		    }

	    $result = mail($to,$subject,$message,$header);

    }
    
    function getTypes($val)
    {
    $queryString = "select s.subtypename,t.typename,s.subtypeid from coupons_subtypes s,coupons_types t where t.typeid=s.typeid and t.typename='".str_replace("_"," ",$val)."'";
    
            $resultSet = mysql_query($queryString);
            if(mysql_num_rows($resultSet)>0)
            {
                
                while($noticia=mysql_fetch_array($resultSet))
                { 
                               $types1=$noticia['typename'];
                               $typesvalues=$typesvalues."+".$noticia['subtypename'];
                               
                }
                               $types1=$types1."+".$typesvalues;
            }
          return $types1;
    }
    
    function getCurDate()
    {
    
    $queryString = "select now() as date";
    $resultset = mysql_query($queryString);
                    if($row = mysql_fetch_array($resultset)){
                        return $row['date'];
                    }
    }
    
    //get the feedbacks
    function get_feedbacks($cid)
    {
            $query = "select *, feedbacks.id as fid,date_format(feedbacks.cdate,'%b-%d-%y') as cdate from feedbacks left join coupons_users on feedbacks.uid=coupons_users.userid where  feedbacks.cid= '$cid' order by feedbacks.id desc";
            $result = mysql_query($query);
            return $result;
    }
    
    //post the feedbacks
    function post_feedbacks($cid='',$message='',$userid='')
    {
            $message = htmlspecialchars($message);
            $query = "insert into feedbacks (uid,message,cid,cdate) values ('$userid','$message','$cid',now())";
            $resultset = mysql_query($query);
         
            $_SESSION["response"] = "Recommendation has been posted.";
          
    }
    
    function get_coopen_feedbacks($coupon_outsideurl)
    {
    
            $query = "select coupons_coupons.coupon_status,feedbacks.id as fid,message,couponname,couponid,coupon_outsideurl,username from feedbacks, coupons_coupons, coupons_users 
    where feedbacks.cid=coupons_coupons.couponid and feedbacks.uid = coupons_users.userid and coupons_coupons.coupon_status ='A' and coupons_coupons.coupon_enddate > now() AND 
    coupons_coupons.coupon_outsideurl = '$coupon_outsideurl' order by rand() limit 0,1";
            $result = mysql_query($query);
            return $result;
    }
    
    function get_coopen_feedbacks_usrrecommend($coupon_outsideurl,$fid)
    {
        
            $query = "select coupons_coupons.coupon_status,feedbacks.id as fid,message,couponname,couponid,coupon_outsideurl,username from feedbacks, coupons_coupons, coupons_users 
    where feedbacks.cid=coupons_coupons.couponid and feedbacks.uid = coupons_users.userid and coupons_coupons.coupon_status ='A' and coupons_coupons.coupon_enddate > now() AND 
    coupons_coupons.coupon_outsideurl = '$coupon_outsideurl' and feedbacks.id = '$fid'";
            $result = mysql_query($query);
            return $result;
    }
    
    // to get overall savings amount by the user thru purchase
    function getsavingamt()
    {
                $userid = $_SESSION['userid'];
                $value = '0';
                $queryString = "SELECT c.coupon_value,c.coupon_realvalue FROM coupons_purchase p , coupons_coupons c  where p.couponid = c.coupon_id  and p.coupon_userid = '$userid'";
                $resultSet = mysql_query($queryString) or die(mysql_error());		
				while($row = mysql_fetch_array($resultSet))
				{
					$realvalue = html_entity_decode($row['coupon_realvalue'], ENT_QUOTES);				
					$coupon_value = html_entity_decode($row['coupon_value'], ENT_QUOTES);
					$value = $value + ($realvalue-$coupon_value);
				}
            
            $_SESSION["savedamt"] = $value;
    
    }
    
    function getlastaddedcoopen()
    {
    $queryString2 = "select * from coupons_coupons order by couponid desc limit 0,1";
    $resultset2 = mysql_query($queryString2);
    if($row = mysql_fetch_array($resultset2)) 
    {
    $coupon_outsideurl = $row['coupon_outsideurl'];
    }
    return $coupon_outsideurl;
    }
    
    function getusrpurchaseddetails($cid)
    {
    $userid = $_SESSION['userid'];
    $queryString = "select * from coupons_purchase where couponid='$cid' and coupon_userid='$userid' and coupons_userstatus ='UN'";
    $resultSet = mysql_query($queryString);
    return $rs = mysql_num_rows($resultSet);
    }
    
    // to check weather user voted for the coopon or not
    function checkvotestatus($fid,$uid)
    {
    $queryString = "select * from vote where uid='$uid' and fid='$fid'";
    $resultSet = mysql_query($queryString);
    return $resultSet2 = mysql_num_rows($resultSet);
    }
    
    function getclosedcoopondetails()
    {
    include "docroot.php";
    $turl_arr = explode("/",$_SERVER["REQUEST_URI"]);
    
    $queryString = "SELECT (select category_name from coupons_category where category_id = c.coupon_category) as couponstype,coupon_minuserlimit,coupon_maxuserlimit,coupon_realvalue,coupon_description,coupon_id, coupon_name, DATE_FORMAT( coupon_startdate, '%d %M %Y' ) AS startdate, DATE_FORMAT( coupon_enddate, '%d %M %Y' ) AS enddate, coupon_image, coupon_createdby,(
    if( LENGTH( concat( u.firstname, u.lastname ) ) =0, u.username, concat( u.firstname, u.lastname ) )
    ) AS name, DATE_FORMAT( coupon_createddate, '%d %M %Y' ) AS createddate, coupon_offer, coupon_status,TIMEDIFF(coupon_enddate,now())as timeleft,DATEDIFF(date_format(coupon_enddate,'%Y-%m-%d'),date_format(now(),'%Y-%m-%d'))as dayleft,(
    
    SELECT count( p.coupon_purchaseid )
    FROM coupons_purchase p
    WHERE p.couponid = c.coupon_id and p.Coupon_amount_Status='T' 
    ) AS pcounts
    ,c.coupon_startdate as coupon_startdate,c.coupon_enddate as coupon_enddate
    FROM coupons_coupons c, coupons_users u
    WHERE coupon_createdby = u.userid and coupon_id='".$turl_arr[3]."' ";
    
            $resultSet = mysql_query($queryString)or die(mysql_error());
    
            if(mysql_num_rows($resultSet)>0)
            {     
              $i=0;
              
                if($cdetails=mysql_fetch_array($resultSet))
                { 
    
    echo '<h1 class="inner_title fwb" style="padding:5px;">'.html_entity_decode($cdetails["coupon_name"], ENT_QUOTES).'!</h1>'; 
    echo '<div  class=" full_page_content">';
    echo '<div  class="vclosed_coopen mt10">';
    
    echo '<div class="fontbold mb10" style="margin-left:5px;" >';
    echo '<i class="fwb color666">';
    echo "Category --- ".$cdetails["couponstype"];
    echo '</i>';
    echo '</div>';  
    echo '<div class="mt10 fl" style="width:770px;">';   
	    if($cdetails["coupon_image"]!='')
	    {
		    echo '<img class="clr  borderE3E3E3" src="'.$docroot.$cdetails["coupon_image"].'"/>';
	    }
	    else
	    {
		    echo '<img src="'.$docroot.'themes/'.CURRENT_THEME.'/images/no_image.jpg" style="margin-top:20px;" />';
	    }
	    

    echo '<p class="fl p5 w300" style="width:500px;">'.html_entity_decode($cdetails["coupon_description"], ENT_QUOTES).'<br /></p>';
        echo '<p class="fl p5 w300 color344F86 font18" style="width:500px;text-align:center;">Coupon Purchased Count: '.$cdetails["pcounts"].'<br /></p>';
    echo '</div>';  	        
    ?>
                                  <div class="discount_value" style="margin-left:5px;">
                                          <div class="timetop">
                                              <div class="value">
                                              <span class="color333 font12">Value</span><br /><span class="color344F86 font18"><?php echo CURRENCY;?><?php echo html_entity_decode($cdetails["coupon_realvalue"], ENT_QUOTES); ?></span>
                                              </div>
                                              
                                              <div class="Discount">
                                              <span class="color333 font12">Discount</span><br /><span class="color344F86 font18"><?php echo html_entity_decode($cdetails["coupon_offer"], ENT_QUOTES); ?>%</span>
                                              </div>
                                              
                                              <div class="Save">
                                              <span class="color333 font12">You Save</span><br /><span class="color344F86 font18"><?php echo CURRENCY;?><?php echo ((html_entity_decode($cdetails["coupon_realvalue"], ENT_QUOTES) * html_entity_decode($cdetails["coupon_offer"], ENT_QUOTES)) / 100); ?></span>
                                              </div>
                                          </div>
                                   </div>
                                       
    <?php
                             
    echo'</div >';echo'</div >';	
                }
                }
                else
                {
                                  echo '<p class="nodata">No Deals Available</p>';
                    }
    }
	
	//email
	function send_email($from ='',$to = '', $subject = '',$msg = '',$name = '')
	{
	 
	        include "docroot.php";
             
	        $logo = DOCROOT."site-admin/images/logo.png";
	        //$docroot = DOCROOT;
	   
	        if(empty($name))
	   	        $name='Customer';

                $message = '<div style="border:1px solid #A32F7A; width:660px;float:left;">
			<div style="background:#A32F7A;width:650px;height:100px;padding:5px;">
			<a href="'.$docroot.'" target="_blank" style="color:#fff;text-decoration:none;margin-left:20px;padding-top:40px;">
			<img src="'.$logo.'" border="0" />
			</a>
			</div>
			
			<div style="color:#000; font-family:Arial, Helvetica, sans-serif; font-size:12px; margin:10px;">
			<p style="font-size:16px; margin-left:20px;"><strong>Dear '.ucfirst($name).',</strong></p>
			<p style="margin-left:20px; line-height:20px; margin-bottom:10px;">'.ucfirst($msg).'</p>
			</div>
			</div>';


     		// To send HTML mail, the Content-type header must be set
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		
		
		// Additional headers
		$headers .= 'From: '.$from.'' . "\r\n";

        mail($to, $subject,$message, $headers);

               
	}
	
	//set the response message
	function set_response_mes($type = '', $mes = '')
	{
		if($type == 1)
		{
			$_SESSION["mes"] = $mes;
		}
		else
		{
			$_SESSION["emes"] = $mes;
		}
		
	}
	
	//is login function => checks whether user logged or not
	
	function is_login($url='')
	{
	
		if(empty($_SESSION['userid']))
		{ 
			$_SESSION['ref'] = $_SERVER['HTTP_REFERER'];
			$_SESSION['msg'] = 'Please login to proceed further...';
			header("Location:$url");
			die();
		}
		
	}
	
	//url redirect
	function url_redirect($url)
	{
		if($url)
		{
			header("Location:$url");
			die();
		}
	}
	
	function success_mes()
	{
		if($_SESSION["mes"])
		{
	 ?>
	 	<script type="text/javascript">
	    $(document).ready(function () {
			if($('#messagedisplay')){
			  $('#messagedisplay').animate({opacity: 1.0}, 10000)
			  $('#messagedisplay').fadeOut('slow');
			}

			});
	 	</script>
					 
		  <div id="messagedisplay" class="success">
		  <div class="inner_top2"></div>
			<div class="inner_center2">	
			  <p class="tick1"><?php echo $_SESSION["mes"]; ?></p>
		  </div>
		  <div class="inner_bottom2"></div>
		  </div>
		
		 <?php 
		 $_SESSION["mes"] = "";
		}
		 
	}
	
	//failed response message
	function failed_mes()
	{
		if($_SESSION["emes"])
		{
	 ?>
	 	<script type="text/javascript">
	    $(document).ready(function () {
			if($('#error_messagedisplay')){
			  $('#error_messagedisplay').animate({opacity: 1.0}, 10000)
			  $('#error_messagedisplay').fadeOut('slow');
			}

			});
	 	</script>
		  <div id="error_messagedisplay" class="failed">
		  <div class="inner_top2"></div>
		  	<div class="inner_center2">	
			  <p class="into"><?php echo $_SESSION["emes"]; ?></p>
		  </div>
		  <div class="inner_bottom2"></div>
		  </div>
		 <?php 
		 $_SESSION["emes"] = "";
		}
		 
	}


	function manage($type='')
	{
	include 'docroot.php';
	if($type=="country")
	{
			$queryString = "select * from coupons_country order by countryname";

			
   	$pages = new Paginator;
	$pages->mid_range = 5; // Number of pages to display. Must be odd and > 3
	$pages->paginate($queryString);
	$resultSet = $pages->rspaginate;
	  
		  if(mysql_num_rows($resultSet)>0)
		  {

		          echo '<table cellpadding="0" cellspacing="0" class="coupon_report">';
			      echo '<tr class="fwb"><td>Country Name</td><td>Manage</td>';
			      echo '</tr>';
			      while($noticia=mysql_fetch_array($resultSet))
			      { 
				echo '<tr><td width="50%">'.ucfirst(html_entity_decode($noticia['countryname'], ENT_QUOTES)).'</td><td width="50%">';
		          
		          echo '<a href="'.$docroot.'edit/country/'.$noticia['countryid'].'/" class="edit_but" title="Edit" style="margin:5px 0 0 145px;"></a>';
		          
		          
		          if($noticia["status"]=='D'){
		          
			          echo '<a href="javascript:;" onclick="updatecountry(\'A\',\''.$noticia["countryid"] .'\');" class="unblock" title="Unblock"></a>';
		          }else{

		          echo '<a href="javascript:;" onclick="updatecountry(\'D\',\''.$noticia["countryid"] .'\');" class="block" title="Block"></a>';		          
		          }

		          echo '<a href="javascript:;" onclick="javascript:deletecountry('.$noticia["countryid"].');" class="delete" title="Delete"></a>';		          
		          
		          echo '</td></tr>';
		          	    
			      }
		                echo '</table>';
	    
	    
	   		//pagination
			 if($pages->rspaginateTotal>20) 
			{		 
				echo '<table border="0" width="650" align="center" cellpadding="10">';
				echo '<tr><td align="center"><div class="pagenation">';
				echo $pages->display_pages();
				echo '</div></td></tr>';
				echo '</table>';
			}
		
		  }
		     
		  else
		  {
		                echo '<p class="nodata">No Country Available</p>';
		  }
	}
	else if($type=="city")
	{
		$queryString = "select coupons_cities.cityid, coupons_cities.cityname, coupons_cities.countryid, coupons_cities.status, coupons_country.countryname  from coupons_cities left join coupons_country on coupons_cities.countryid = coupons_country.countryid order by coupons_cities.cityname";

		
	$pages = new Paginator;
	$pages->mid_range = 5; // Number of pages to display. Must be odd and > 3
	$pages->paginate($queryString);
	$resultSet = $pages->rspaginate;
	  
		  if(mysql_num_rows($resultSet)>0)
		  {

		          echo '<table cellpadding="5" cellspacing="5" class="coupon_report">';
			      echo '<tr class="fwb"><td>City Name</td><td>Country Name</td><td>Manage</td>';
			      echo '</tr>';
			      while($noticia=mysql_fetch_array($resultSet))
			      { 
					echo '<tr><td width="33%">'.ucfirst(html_entity_decode($noticia['cityname'], ENT_QUOTES)).'</td><td>'.ucfirst(html_entity_decode($noticia['countryname'], ENT_QUOTES)).'</td>';
		          
		          	echo '<td width="33%"><a href="'.$docroot.'edit/city/'.$noticia['cityid'].'/" class="edit_but" title="Edit" style="margin:5px 0 0 80px;"></a>';
		          
		          if($noticia["status"]=='D'){
		          
			          echo '<a href="javascript:;" onclick="updatecity(\'A\',\''.$noticia["cityid"] .'\');" class="unblock" title="Unblock"></a>';
		          }else{
			          echo '<a href="javascript:;" onclick="updatecity(\'D\',\''.$noticia["cityid"] .'\');" class="block" title="Block"></a>';		          
		          }


		          echo '<a href="javascript:;" onclick="javascript:deletecity('.$noticia["cityid"].');" class="delete" title="Delete"></a>';

		          
		          echo '</td></tr>';
		          		          	    
			      }
		                echo '</table>';
	    
	    
	   		//pagination
			if($pages->rspaginateTotal>20) 
			{		   
				echo '<table border="0" width="650" align="center" cellpadding="10">';
				echo '<tr><td align="center"><div class="pagenation">';
				echo $pages->display_pages();
				echo '</div></td></tr>';
				echo '</table>';
			}
		
		  }
		     
		  else

		  {
		                echo '<p class="nodata">No City Available</p>';
		  }
	}
	else if($type=="subscriber")
	{
			//manage subscriber list
			$queryString = "select * from newsletter_subscribers left join coupons_cities on newsletter_subscribers.city_id = coupons_cities.cityid order by newsletter_subscribers.id";

			
        $pages = new Paginator;
	$pages->mid_range = 5; // Number of pages to display. Must be odd and > 3
	$pages->paginate($queryString);
	$resultSet = $pages->rspaginate;
	  
		  if(mysql_num_rows($resultSet)>0)
		  {
									echo '<div style="float:left;width:770px;clear:both;"><div  class="fr p5 mr-8">
										 <a href="'.DOCROOT.'site-admin/pages/export.php?type='.$type.'" title="Export All">Export All</a>
										 </div></div>';
				  echo '<table cellpadding="5" cellspacing="5" class="coupon_report">';
			      echo '<tr class="fwb"><td>Email</td><td>City</td><td>Manage</td>';
			      echo '</tr>';
			      while($noticia=mysql_fetch_array($resultSet))
			      { 
					echo '<tr><td width="40%">'.ucfirst(html_entity_decode($noticia['email'], ENT_QUOTES)).'</td><td width="40%">'.ucfirst(html_entity_decode($noticia['cityname'], ENT_QUOTES)).'</td>';
		          
		         	echo '<td width="20%"><a href="javascript:;" onclick="javascript:delete_subscriber('.$noticia["id"].');" class="delete" style="margin-left:60px !important;" ></a>';
		          
		          	echo '</td></tr>';
		          		          	    
			      }
		                echo '</table>';
	    
		   		//pagination
				if($pages->rspaginateTotal>20) 
				{		 
					echo '<table border="0" width="650" align="center" cellpadding="10">';
					echo '<tr><td align="center"><div class="pagenation">';
					echo $pages->display_pages();
					echo '</div></td></tr>';
					echo '</table>';
				}
		
		  }
		     
		  else
		  {
		                echo '<p class="nodata">No Newsletter Subscribers Available</p>';
		  }
	}
	else if($type=="mobile-subscriber")
	{
			//manage subscriber list
			$queryString = "select * from mobile_subscribers left join coupons_cities on mobile_subscribers.city_id = coupons_cities.cityid order by mobile_subscribers.id";

			
                       
        $pages = new Paginator;
	$pages->mid_range = 5; // Number of pages to display. Must be odd and > 3
	$pages->paginate($queryString);
	$resultSet = $pages->rspaginate;
	  
		  if(mysql_num_rows($resultSet)>0)
		  {
                              echo '<div style="float:left;width:770px;clear:both;"><div class="fr p5 mr-8">
			                                 <a href="'.DOCROOT.'site-admin/pages/export.php?type='.$type.'" title="'.$admin_language['exportall'].'">Export All</a>
			                                 </div></div>';
		              echo '<table cellpadding="5" cellspacing="5" class="coupon_report">';
			      echo '<tr class="fwb"><td>Mobile No</td><td>City</td><td>Manage</td>';
			      echo '</tr>';
			      while($noticia=mysql_fetch_array($resultSet))
			      { 
					echo '<tr><td>'.ucfirst(html_entity_decode($noticia['mobileno'], ENT_QUOTES)).'</td><td>'.ucfirst(html_entity_decode($noticia['cityname'], ENT_QUOTES)).'</td>';
		          
		         	echo '<td  width="20%"><a href="javascript:;" onclick="javascript:delete_mobile_subscriber('.$noticia["Id"].');" class="delete" style="margin-left:60px !important;"></a>';
		          
		          	echo '</td></tr>';
		          		          	    
			      }
		                echo '</table>';
	    
				//pagination
				 if($pages->rspaginateTotal>20) 
				{		 	    
						echo '<table border="0" width="650" align="center" cellpadding="10">';
						echo '<tr><td align="center"><div class="pagenation">';
						echo $pages->display_pages();
						echo '</div></td></tr>';
						echo '</table>';
				}
		
		  }
		     
		  else
		  {
		                echo '<p class="nodata">No Mobile Subscriber Available</p>';
		  }
	}
	else if($type=="category")
	{
		$queryString = "select * from coupons_category order by category_name";

			
        $pages = new Paginator;
	$pages->mid_range = 5; // Number of pages to display. Must be odd and > 3
	$pages->paginate($queryString);
	$resultSet = $pages->rspaginate;
	  
		  if(mysql_num_rows($resultSet)>0)
		  {

		              echo '<table cellpadding="5" cellspacing="5" class="coupon_report">';
			      echo '<tr class="fwb"><td>Category Name</td><td>Manage</td>';
			      echo '</tr>';
			      while($noticia=mysql_fetch_array($resultSet))
			      { 
				echo '<tr><td width="50%">'.ucfirst(html_entity_decode($noticia['category_name'], ENT_QUOTES)).'</td>';
		          
		          echo '<td width="50%"><a href="'.$docroot.'edit/category/'.$noticia['category_id'].'/" class="edit_but" title="Edit" style="margin:5px 0 0 145px;"></a>';
		          

		          
		          if($noticia["status"]=='D'){
		          
			          echo '<a href="javascript:;" onclick="updatecategory(\'A\',\''.$noticia["category_id"] .'\');" class="unblock" title="Unblock"></a>';
		          }else
		          {
			          echo '<a href="javascript:;" onclick="updatecategory(\'D\',\''.$noticia["category_id"] .'\');" class="block" title="Block"></a>';		          
		          }

		          echo '<a href="javascript:;" onclick="javascript:deletecategory('.$noticia["category_id"].');" class="delete" title="Delete"></a>';
		          		          	
		          echo '</td></tr>';		          	    
			      }
		                echo '</table>';
	    
	   		//pagination
			 if($pages->rspaginateTotal>20) 
			{
				echo '<table border="0" width="650" align="center" cellpadding="10">';
				echo '<tr><td align="center"><div class="pagenation">';
				echo $pages->display_pages();
				echo '</div></td></tr>';
				echo '</table>';
			}
		
		  }
		     
		  else
		  {
		                echo '<p class="nodata">No Category Available</p>';
		  }
	}
	else if($type=="pages")
	{
		
	    $queryString = "select * from pages order by id desc";

		
	$pages = new Paginator;
	$pages->mid_range = 5; // Number of pages to display. Must be odd and > 3
	$pages->paginate($queryString);
	$resultSet = $pages->rspaginate;

			  
		  if(mysql_num_rows($resultSet)>0)
		  {
		?>
		          <table cellpadding="5" cellspacing="0" class="coupon_report" border="0">
			      <tr class="fwb"><td>Title</td><td>URL</td><td>Manage</td>
			      </tr>
				  <?php 
			      while($noticia=mysql_fetch_array($resultSet))
			      { 
				  ?>
					<tr><td> <?php echo ucfirst(html_entity_decode($noticia['title'], ENT_QUOTES));?></td>
					<td>
					<?php echo DOCROOT."pages/".$noticia["title_url"].".html";?>
					</td>
		          
   					<td width="25%"><a href="<?php echo $docroot;?>edit/page/<?php echo $noticia['id'] ;?>/" class="edit_but" title="Edit"  style="margin:5px 0 0 70px;"></a>
		          
				    <a href="javascript:;" onclick="javascript:deletepage('<?php echo $noticia["id"];?>');" class="delete" title="Delete"></a>
		          		          	
					</td></tr>
			      <?php } ?>
					</table>
	    
					<div class="fr mr-20 mt-10 ">	
					    
					<?php if($pages->rspaginateTotal>20) {
					 echo $pages->display_pages(); 
					 } ?> 
					</div>
		
		<?php 
		  }
		  else
		  {
		                echo '<p class="nodata">No Data Available</p>';
		                //echo '<p class="nodata">No Pages Available</p>';
		  }
	
	}	
  
  }
	
    //data format
    function change_time($time) 
    {
        $time = strtotime($time);
        $c_time = time() - $time;
        if ($c_time < 60) {
            return '0 minute ago';
        } else if ($c_time < 120) {
            return '1 minute ago';
        } else if ($c_time < (45 * 60)) {
            return floor($c_time / 60) . ' minutes ago';
        } else if ($c_time < (90 * 60)) {
            return '1 hour ago.';
        } else if ($c_time < (24 * 60 * 60)) {
            return floor($c_time / 3600) . ' hours ago';
        } else if ($c_time < (48 * 60 * 60)) {
            return '1 day ago.';
        } else {
            return floor($c_time / 86400) . ' days ago';
        }
     }


	//review
	function get_deal_comment($deal_id = '')
	{
	
		$list_comment = mysql_query("select discussion_id,deal_id,discussion_text,firstname,lastname,cdate,user_id,email from discussion left join coupons_users on discussion.user_id = coupons_users.userid where discussion.deal_id = '$deal_id' and discussion.status='A'");
		
		$total_result = mysql_num_rows($list_comment);

		if(file_exists(DOCUMENT_ROOT."/themes/".CURRENT_THEME."/pages/deal_discussion.php")) {
				include(DOCUMENT_ROOT."/themes/".CURRENT_THEME."/pages/deal_discussion.php"); 
		}
		else {
				include(DOCUMENT_ROOT."/themes/_base_theme/pages/deal_discussion.php"); 
		}

	}
?>		


<?php

  // Set timezone
  // date_default_timezone_set("UTC");
 
  // Time format is UNIX timestamp or
  // PHP strtotime compatible strings
  function dateDiff($time1, $time2, $precision = 6) {
    // If not numeric then convert texts to unix timestamps
    if (!is_int($time1)) {
      $time1 = strtotime($time1);
    }
    if (!is_int($time2)) {
      $time2 = strtotime($time2);
    }
 
    // If time1 is bigger than time2
    // Then swap time1 and time2
    if ($time1 > $time2) {
      $ttime = $time1;
      $time1 = $time2;
      $time2 = $ttime;
    }
 
    // Set up intervals and diffs arrays
    $intervals = array('year','month','day','hour','minute','second');
    $diffs = array();
 
    // Loop thru all intervals
    foreach ($intervals as $interval) {
      // Set default diff to 0
      $diffs[$interval] = 0;
      // Create temp time from time1 and interval
      $ttime = strtotime("+1 " . $interval, $time1);
      // Loop until temp time is smaller than time2
      while ($time2 >= $ttime) {
	$time1 = $ttime;
	$diffs[$interval]++;
	// Create new temp time from time1 and interval
	$ttime = strtotime("+1 " . $interval, $time1);
      }
    }
 
    $count = 0;
    $times = array();
    // Loop thru all diffs
    foreach ($diffs as $interval => $value) {
      // Break if we have needed precission
      if ($count >= $precision) {
	break;
      }
      // Add value and interval 
      // if value is bigger than 0
      if ($value > 0) {
	// Add s if value is not 1
	if ($value != 1) {
	  $interval .= "s";
	}
	// Add value and interval to times array
	$times[$interval] = $value;
	$count++;
      }
    }
 
    // print_r($times);
    // Return string with times
    // return implode(", ", $times);
	return $times;
  }

function get_discount_value($realvalue='',$dealvalue='')
{

	$value = $realvalue - $dealvalue;
	$value = ($value/$realvalue)*100;
	return $value;

}
  
  ?>
<?php ob_flush(); ?>
