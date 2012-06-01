<?php ob_start();
session_start();
require_once($_SERVER['DOCUMENT_ROOT'].'/system/includes/docroot.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/system/includes/dboperations.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/system/includes/config.php');
$lang = $_SESSION["site_language"];
if($lang)
{
		include(DOCUMENT_ROOT."/system/language/".$lang.".php");
}
else
{
		include(DOCUMENT_ROOT."/system/language/en.php");
}

$userid = $_SESSION["userid"];
$sub2 = explode('=',$_SERVER['REQUEST_URI']);
$split =  explode('_',$sub2[1]);
$couponid = $split[0];
$purchase_id = $split[1];
//echo "dealid".$couponid."pid".$purchase_id;
//exit;
if(is_numeric($couponid) && is_numeric($purchase_id))
{
	//select the deal
	 $query = "select *,TIMEDIFF(coupons_coupons.coupon_enddate,now())as timeleft,( SELECT count( p.coupon_purchaseid ) FROM coupons_purchase p WHERE p.couponid = coupons_coupons.coupon_id and p.Coupon_amount_Status='T' ) AS pcounts from coupons_coupons left join coupons_shops on coupons_coupons.coupon_shop = coupons_shops.shopid left join coupons_cities on coupons_shops.shop_city = coupons_cities.cityid left join coupons_country on coupons_shops.shop_country = coupons_country.countryid left join coupons_purchase on coupons_purchase.couponid=coupons_coupons.coupon_id left join coupons_users on coupons_purchase.coupon_userid=coupons_users.userid left join transaction_details on transaction_details.ID=coupons_purchase.transaction_details_id where coupon_id = '$couponid' AND coupons_purchase.coupon_purchaseid='$purchase_id' AND coupon_expirydate > now() and coupons_purchase.coupon_userid='$userid' and transaction_details.CAPTURED=1";
	
//echo "if ";exit;	
$result = mysql_query($query);

}
else
{
//echo "else";exit;
	$url = DOCROOT."my-coupons.html";
	$_SESSION["emes"] = $language['cannot_download'];
	header("Location:$url");
	die();
}
	
if(mysql_num_rows($result)>0)
{
	$noticia = mysql_fetch_array($result);
	$friendid = $noticia['gift_recipient_id']; 
	$friendquery = mysql_query("select * from gift_recipient_details where id ='".$friendid."'");
	if(mysql_num_rows($friendquery)>0)
	{
		while($rowfriend = mysql_fetch_array($friendquery))
		{
			$check = '1'; 
			$friendname = $rowfriend['name'];
			$friendemail = $rowfriend['email']; 
		}
	}   
}
else
{
	$url = DOCROOT."my-coupons.html";	
	$_SESSION["mes"] = $language['coupon_expired'];
	header("Location:$url");
	die();
}

			require_once('system/modules/tcpdf_5_9_088/config/lang/eng.php');
			require_once('system/modules/tcpdf_5_9_088/tcpdf.php');

			
			// create new PDF document
                        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

			$dealname = ucfirst(html_entity_decode($noticia['coupon_name'], ENT_QUOTES));

			$dealname = preg_replace("`\[.*\]`U","",$dealname);
			$dealname = preg_replace('`&(amp;)?#?[a-z0-9]+;`i','-',$dealname);
			$dealname = htmlentities($dealname, ENT_COMPAT, 'utf-8');
			$dealname = preg_replace( "`&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);`i","\\1", $dealname );
			$dealname = preg_replace( array("`[^a-z0-9]`i","`[-]+`") , "-", $dealname);
			$dealname = strtolower(trim($dealname, '-'));

                        // set document information
                        $pdf->SetCreator(PDF_CREATOR);
                        $pdf->SetAuthor(SITE_NAME);
                        $pdf->SetTitle($dealname);
                        $pdf->SetSubject(SITE_NAME);
                        $pdf->SetKeywords('PDF');

                        // remove default header/footer
                        $pdf->setPrintHeader(false);
                        $pdf->setPrintFooter(false);

                        // set default monospaced font
                        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

                        //set margins
                        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

                        //set auto page breaks
                        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

                        //set image scale factor
                        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

                        //set some language-dependent strings
                        $pdf->setLanguageArray($l);

                        // -----TCPDF ERROR: Some data has already been output, can't send PDF file

                        // set font
                        $pdf->SetFont('dejavusans', '', 10);

                        // add a page
                        $pdf->AddPage();


// PDF content
//$coupon_name = friendlyurl(html_entity_decode($noticia['coupon_name']));

                    if(file_exists($noticia["coupon_image"]))
                    {
                         $src= '/'.$noticia["coupon_image"];
                    }
                    else
                    {
                        $src= "/themes/".CURRENT_THEME."/images/no_image.jpg";
                    }     

$logo = "/themes/".CURRENT_THEME."/images/logo.jpg"; 
            

$html = '<div class="work_bottom mt10" style="width:500px;">
                        <div class="mt10" id="print_coupon">
				<table width="300px">
				<tr><td width="50%" valign="top">
                                <div class="fl">
                                        <img src="'.$logo.'" width="150px" height="100px"/>
                                </div>
				</td><td valign="top" width="50%">
<br/>				</td></tr></table>
				<table width="400px">
				        <tr><td>
                                         '.$language['cust_name'].': <span class="color333"> '.ucfirst($noticia["firstname"]).' '.ucfirst($noticia["lastname"]).'</span>
				        </td></tr>
				        <tr><td>
                                                '.$language['expires'].': '.$noticia["coupon_expirydate"].'
				        </td></tr>
				        <tr><td>
                                       '.$language['coupon_code'].': <span class="font18 color333"> '. $noticia["coupon_validityid"].'</span></td></tr>';
                                       
                                       if($check == '1')
                                       { 
                                        $html .= '<tr><td>
                                        
                                       '.$language['giftto'].': <br /></td></tr>
                                       
                                        <tr><td>
                                       '.$friendname.' <span class="font18 color333"> '. $friendemail.'</span></td></tr>';
                                       }

				$html .= '</table><hr/>
				<table width="100%" border="0px">
				        <tr><td>&nbsp;</td></tr></table>
				        <table width="100%">
				        <tr>
				        <td colspan=2>
				        <span style="padding:10px;">'.$language['deal'].': <font> '.ucfirst(strip_tags(html_entity_decode($noticia["coupon_name"]))).'</font></span>				
				        </td>
				        </tr>
				        <tr>
				        <td width="50%"  valign="top">
                                        <img src="'.$src.'" title="" width="320px" />
				        </td>
				        <td valign="top">
                                                <span class="font14 color333"><span>'.$language['description'].': </span>'.ucfirst(strip_tags(html_entity_decode($noticia["coupon_description"],ENT_QUOTES))).'<br/></span>
				        </td>
				        </tr>
				</table><hr/>
				<table width="100%" border="0px">
				        <tr><td>&nbsp;</td></tr>
				</table>
				<table>
				<tr>
				        <td width="50%"  valign="top"><span class="font14 color333"><span>'.$language['fine_print'].': </span>'.ucfirst(strip_tags(html_entity_decode($noticia["coupon_fineprints"],ENT_QUOTES))).'<br/></span></td>
				        <td valign="top"><span class="font14 color333"><span>'.$language['terms_and_condition'].': </span>'.ucfirst(strip_tags(html_entity_decode($noticia["terms_and_condition"],ENT_QUOTES))).'<br/></span></td>
				</tr>
				</table><hr/>
				<table width="100%" border="0px"><tr><td>&nbsp;</td></tr></table>
				<table>
				        <tr>
				        <td>
				         <span class="font14 color333">'.$language['thanks'].',</span>
				        </td>
				        </tr>
				        <tr>
				        <td>
                                        '.ucfirst(strip_tags(html_entity_decode($noticia["shopname"],ENT_QUOTES))).'
				        </td>
				        </tr>
				        <tr>
				        <td>
                                        '.ucfirst(strip_tags(html_entity_decode($noticia["shop_address"],ENT_QUOTES))).'
				        </td>
				        </tr>
					<tr>
				        <td>
                                        '.ucfirst(strip_tags(html_entity_decode($noticia["cityname"],ENT_QUOTES))).'
				        </td>
				        </tr>
					<tr>
				        <td>
                                        '.ucfirst(strip_tags(html_entity_decode($noticia["countryname"],ENT_QUOTES))).'
				        </td>
				        </tr>
				</table>
                        </div>
                </div>';

//echo $html; exit;
        $pdf->writeHTML($html, true, false, true, false, '');

        //Close and output PDF document
        $pdf->Output('Voucher.pdf', 'D');

//die();
//============================================================+
// END OF FILE                                                
//============================================================+
//ob_flush();

