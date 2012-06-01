<?php 
		ob_start();
		session_start();
		include($_SERVER['DOCUMENT_ROOT'].'/system/includes/library.inc.php');
		
		if($_GET)
		{
			$id = $_GET["id"];
			$url = urldecode($_GET["rurl"]);
			mysql_query("delete from discussion where discussion_id='$id'");
			
			// Include language files
			$lang = $_SESSION["site_language"];
			if($lang)
			{
				include(DOCUMENT_ROOT."/system/language/".$lang.".php");
			}
			else
			{
				include(DOCUMENT_ROOT."/system/language/en.php");
			}

			set_response_mes(1,$language['discussion_has_been_deleted']);
			url_redirect($url);
		}

	ob_flush();
?>
