<?php
/********************************************
 * @Created on March, 2011 * @Package: Ndotdeals unlimited v2.2 
 * @Author: NDOT
 * @URL : http://www.ndot.in
 ********************************************/

$gProtected = TRUE;

require_once('header.php');

$com_id = (INT)$_GET['id']; // id commission

if(!$com_id)
{
	$items = (int)$_GET['items'];
	$items = $items ? $items : 5 ;

	define(ITEMS_PER_PAGE, $items);

	$page = (int)$_GET['page'];
	$page = ($page < 1) ? 1 : $page;
	$start = ($page - 1) * ITEMS_PER_PAGE;

	$ctype = $_GET['type'];
	if(!$ctype)
	$ctype = 'pending';
	//$_POST['fund'] = " ";$_POST['com']=" ";
	
	//echo $ctype;

	switch($ctype)
	{
		case 'pending':
			$commissions = $gXpDb->getCommissionsByStatus($aff['id'], 1, $start, ITEMS_PER_PAGE);
			$total = $gXpDb->getCommissionsByStatus(0);
			$url = "commission-details.php?type=pending";
			break;
		case 'approved':
			//$commissions = $gXpDb->getCommissionsByStatus($aff['id'], 2, $start, ITEMS_PER_PAGE);
			//$total = $gXpDb->getCommissionsByStatus(2);

			$commissions = $gXpDb->getCommissionsByStatusUpdated($aff['id'], 2, $start, ITEMS_PER_PAGE); //function added to get commission details
			$total = $gXpDb->getCommissionsByStatusUpdated($aff['id']); //function added to get commission details

			if ($_POST['fund'] )
                                { 
                                         //$commissions = $gXpDb->getCommissionsRFByStat($aff['id'], 2, $start, ITEMS_PER_PAGE);

					 $commissions = $gXpDb->getCommissionsRFByStatUpdated($aff['id'], 2, $start, ITEMS_PER_PAGE, $_POST['com']); //function added to get commission details

                                         $count = count($commissions);
                                         if($count>1)
                                         {
                                                  	for($i=0;$i<=count($commissions);$i++)
                                                        {
                                                                $comm_tot[] = $commissions[$i]['payout'];
                                                                $sales_tot[] = $commissions[$i]['payment'];
                                                        }
                                                        $commiss_total  = array_sum($comm_tot);
                                                        $sales_total  = array_sum($sales_tot);
                                          }
                                          else
                                          {
                                                
                                                        $commiss_total  = $commissions[0]['payout'];
                                                        $sales_total  = $commissions[0]['payment'];
                                          }

                                         if(count($_POST['com']) > 0)
                                         {
		                                if(count($_POST['com'])<= $count)
		                                {
		                                        if($count>1)
		                                        {
		                                                for($i=0;$i<count($_POST['com']);$i++)
		                                                {
		                                                        $comm[] = $commissions[$i]['payout'];
		                                                        $sales[] = $commissions[$i]['payment'];
		                                                }
		                                                 $commiss  = array_sum($comm);
		                                                 $sales  = array_sum($sales);
		                                        }
		                                        else
		                                        {
		                                        
		                                                $commiss  = $commissions[0]['payout'];
		                                                $sales  = $commissions[0]['payment'];
		                                        }
		                                        
		                                        $gXpDb->addFund($aff['id'],$commiss,$sales,$commiss_total,$sales_total,$_POST['com']);

							$gXpDb->updateFundRequested($_POST['com']);		                                        

		                                        //$gXpDb->addFundUpdated($aff['id'],$commiss,$sales,$commiss_total,$sales_total,$_POST['com']);

				                       // $msg = "<li>Your fund request are submitted admin.</li>";
				                       $msg = 1;
				                        header("Location:commission-details.php?msg=".$msg);
		                                       
		                                }
		                                else
		                                {
				                        // $msg = "<li>Your fund request are greater the your commission .</li>";
				                        $msg = 0;
				                         header("Location:commission-details.php?msg=".$msg);
		                                }
                                       }
                                       else
                                       {
                                                 $msg = 2;
		                                header("Location:commission-details.php?msg=".$msg);
                                       }
	
                                }
			$url = "commission-details.php?type=approved";
			
			break;
			//case 'paid': $commissions = $gXpDb->getPaidCommissions();
	}

	$title = $gXpLang['site_title'].' - '.$gXpLang['commission_details'];

	$navigation = navigation(count($total), $start, count($commissions), $url, ITEMS_PER_PAGE);

	$gXpSmarty->assign_by_ref('commissions', $commissions);
	$gXpSmarty->assign_by_ref('navigation', $navigation);
	$gXpSmarty->assign_by_ref('ctype', $ctype);
}
elseif($com_id > 0 && is_array($aff) and $aff['id']>0)
{
	$percent = $gXpConfig['payout_percent']/100;
	$commission = $gXpDb->getCommissionsById($aff['id'], $com_id);
	$gXpSmarty->assign_by_ref('percent', $percent);
	$gXpSmarty->assign_by_ref('commission', $commission);
}

$description = $gXpLang['desc_commission_details'];
$keywords = $gXpLang['keyword_commission_details'];
$gXpSmarty->assign_by_ref('msg', $_REQUEST['msg']);
$gXpSmarty->assign_by_ref('description', $description);
$gXpSmarty->assign_by_ref('keywords', $keywords);
$gXpSmarty->assign_by_ref('title', $title);

$gXpSmarty->display("comission-details.tpl");

?>
