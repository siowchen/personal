<?php ob_start();
session_start();
require_once($_SERVER['DOCUMENT_ROOT']."/system/includes/library.inc.php");

        //check the deal, whether its expired or closed
	function is_deal_expired($couponid='')
	{
	
		// Include language file
		$lang = $_SESSION["site_language"];
		if($lang)
		{
			include(DOCUMENT_ROOT."/system/language/".$lang.".php");
		}
		else
		{
			include(DOCUMENT_ROOT."/system/language/en.php");
		}
	
		$queryString = "SELECT coupon_status as couponstatus FROM `coupons_coupons` WHERE coupon_status ='C' and coupon_enddate > now() and  coupon_id='$couponid'";
			
		$deal_expired = mysql_query($queryString);
		while($deal_expired_value = mysql_fetch_object($deal_expired)) 
		{
		    $coupon_status = $deal_expired_value->couponstatus;
		    if($coupon_status == 'C')
		    {	
		    set_response_mes(-1, $language['sorry_your_deal_expired']);
		    url_redirect(DOCROOT);	    	    
		    }
		      
		}
	}
	function check_max_deal_purchase($cid='',$friendname='',$friendemail='',$cquantity='',$uid='')
	{
	       // Include language file
		$lang = $_SESSION["site_language"];
		if($lang)
		{
			include(DOCUMENT_ROOT."/system/language/".$lang.".php");
		}
		else
		{
			include(DOCUMENT_ROOT."/system/language/en.php");
		}	        

		//get deal min user limit
		$queryString = "select coupon_minuserlimit as minuser,coupon_maxuserlimit as maxuser,max_deal_purchase from coupons_coupons where coupon_id='$cid'";
		$resultSet = mysql_query($queryString);
			while($row = mysql_fetch_object($resultSet)) 
			{
			    $minuserlimit = $row->minuser;
			    $maxuserlimit = $row->maxuser;
			    $max_deal_purchase = $row->max_deal_purchase;
			}

		//check max purchase limit to an user
		if($max_deal_purchase > 0)
		{

				//get the deal purchased count 
				$queryString = "select sum(L_QTY0) as total from transaction_details where COUPONID = '$cid' and USERID = '$uid'";
				$result = mysql_query($queryString);
					if(mysql_num_rows($result))
					{
						$rs = mysql_fetch_array($result);
					}
				$deal_purchased_count = $rs['total'];

				$pquantity = $deal_purchased_count + $cquantity;

				if($pquantity > $max_deal_purchase)
				{

					$available_deals = $max_deal_purchase - $deal_purchased_count;

					if($available_deals==0)
					{
						if($friendname!='' && $friendemail!='')
						{
							set_response_mes(-1, $language['sorry_you_had_crossed_the_purchase_limit']);
							url_redirect(DOCROOT."purchase.html?cid=".$cid."&type=gift");
						}
						else
						{
							set_response_mes(-1, $language['sorry_you_had_crossed_the_purchase_limit']);
							url_redirect(DOCROOT."purchase.html?cid=".$cid);
						}
					}

					if($friendname!='' && $friendemail!='')
					{

						if($available_deals > 0)
							set_response_mes(-1, $language['sorry'].$available_deals.$language['deals_only_available_purchase']);
						else
							set_response_mes(-1, $language['sorry_you_had_crossed_the_purchase_limit']);

						url_redirect(DOCROOT."purchase.html?cid=".$cid."&type=gift");
					}
					else
					{

						if($available_deals > 0)
							set_response_mes(-1, $language['sorry'].$available_deals.$language['deals_only_available_purchase']);
						else
							set_response_mes(-1, $language['sorry_you_had_crossed_the_purchase_limit']);

						url_redirect(DOCROOT."purchase.html?cid=".$cid);
					}


				}

		}

	}


	function check_deal_quantity($cid='',$friendname='',$friendemail='',$cquantity='',$mobile_pay='')
	{

		// Include language file
		$lang = $_SESSION["site_language"];
		if($lang)
		{
			include(DOCUMENT_ROOT."/system/language/".$lang.".php");
		}
		else
		{
			include(DOCUMENT_ROOT."/system/language/en.php");
		}
		
		//get the deal purchased count 
		$queryString = "select sum(L_QTY0) as total from transaction_details where COUPONID = '$cid'";
		$result = mysql_query($queryString);
			if(mysql_num_rows($result))
			{
				$result = mysql_fetch_array($result);
			}
		$purchased_ccount = $result['total'];

		//get deal min user limit
		$queryString = "select coupon_minuserlimit as minuser,coupon_maxuserlimit as maxuser from coupons_coupons where coupon_id='$cid'";
		$resultSet = mysql_query($queryString);
			while($row = mysql_fetch_object($resultSet)) 
			{
			    $minuserlimit = $row->minuser;
			    $maxuserlimit = $row->maxuser;
			}

			$available_deals = $maxuserlimit - $purchased_ccount;

			if($purchased_ccount == $maxuserlimit){
				$query = "update coupons_coupons set coupon_status ='C' where coupon_id='$cid'";
				$result = mysql_query($query) or die(mysql_error());
			}
		
			//check deal availability
			if($available_deals<$cquantity)
			{

				if($available_deals > 0) {
					set_response_mes(-1, $language['sorry'].$available_deals.$language['deals_only_available_purchase']); }
				else {
					set_response_mes(-1, $language['sorry_all_the_deals_purchased']); 
				}
				
				if(empty($mobile_pay))
				{
					if($friendname!='' && $friendemail!='')
					{
						url_redirect(DOCROOT."purchase.html?cid=".$cid."&type=gift");
					}
					else
					{
						url_redirect(DOCROOT."purchase.html?cid=".$cid);
					}
				}
				else
				{
					return -1; // -1 => no deals available
				}

			}

			//add gift list
			if($friendname!='' && $friendemail!='')
			{
				$friendname = htmlentities($friendname, ENT_QUOTES);
				$query = "insert into gift_recipient_details(name,email) values('$friendname','$friendemail')";
				$result = mysql_query($query) or die(mysql_error());
				$_SESSION['gift_recipient_id'] = mysql_insert_id();
			}

	}

	function update_gift_recipient($coupons_purchase_id='')
	{
		  $count = count($coupons_purchase_id); 
		  $value ='';
			  for($i=0;$i<$count;$i++)
			  {
			     $val = $coupons_purchase_id[$i];
			     $value.= $val.',';
			  }
		  $value = substr($value,0,strlen($value)-1);

		mysql_query("update coupons_purchase set gift_recipient_id='$gift_recipient_id' where coupon_purchaseid in ($value) ") or die(mysql_error());

	}

	function check_deal_status($cid='')
	{
		//get the deal purchased count 
		$queryString = "select sum(L_QTY0) as total from transaction_details where COUPONID = '$cid'";
		$result = mysql_query($queryString);
			if(mysql_num_rows($result))
			{
				$result = mysql_fetch_array($result);
			}
		$purchased_ccount = $result['total'];

		//get deal min user limit
		$queryString = "select coupon_minuserlimit as minuser,coupon_maxuserlimit as maxuser from coupons_coupons where coupon_id='$cid'";
		$resultSet = mysql_query($queryString);
			while($row = mysql_fetch_object($resultSet)) 
			{
			    $minuserlimit = $row->minuser;
			    $maxuserlimit = $row->maxuser;
			}

			if($purchased_ccount >= $maxuserlimit){
				$query = "update coupons_coupons set coupon_status ='C' where coupon_id='$cid'";
				$result = mysql_query($query) or die(mysql_error());
			}

	}

ob_flush();    
?>
