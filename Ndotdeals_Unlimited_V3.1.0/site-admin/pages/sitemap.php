<?php
is_login(DOCROOT."admin/login/"); //checking whether admin logged in or not.
$xml_content = '<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9    http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';

	$queryString = "select coupon_id,coupon_name,coupon_description,coupon_startdate,coupon_enddate,coupon_image,coupon_realvalue from coupons_coupons where coupon_status = 'A' AND coupon_enddate > now() order by coupon_id desc";

	$result = mysql_query($queryString);
	while($row = mysql_fetch_array($result))
	{
		$xml_content .= "	
				<url>
				  <loc>".DOCROOT."deals/".friendlyURL(html_entity_decode($row["coupon_name"]))."_".$row["coupon_id"].".html</loc>
				  <priority>0.5</priority>
				  <changefreq>daily</changefreq>
		    </url>";
	}
	//add the category url
	$queryString = "select * from coupons_category where status='A' order by category_name asc";

	$result = mysql_query($queryString);
	while($row = mysql_fetch_array($result))
	{
		$xml_content .= "	
				<url>
				  <loc>".DOCROOT."deals/category/".html_entity_decode($row["category_url"]).".html</loc>
				  <priority>0.5</priority>
				  <changefreq>daily</changefreq>
		    </url>";
	}


	$xml_content .="</urlset>";
	$filename = DOCUMENT_ROOT.'/sitemap.xml';
	$somecontent = $xml_content;

                // Let's make sure the file exists and is writable first.
                if (is_writable($filename)) {

                    // In our example we're opening $filename in append mode.
                    // The file pointer is at the bottom of the file hence 
                    // that's where $somecontent will go when we fwrite() it.
                    if (!$handle = fopen($filename, 'w')) {
                         echo "Cannot open file ($filename)";
                         exit;
                    }

                    // Write $somecontent to our opened file.
                    if (fwrite($handle, $somecontent) === FALSE) {
                        echo "Cannot write to file ($filename)";
                        exit;
                    }
                    
                   //echo "Success, wrote ($somecontent) to file ($filename)";
                    
                    fclose($handle);

                }
                else 
                {
                    echo "The file $filename is not writable";
                    exit; 
                }
		set_response_mes(1,$admin_language['googlesitemapcreated']); 
		url_redirect($_SERVER['HTTP_REFERER']);
			
?>
