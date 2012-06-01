<?php 
/********************************************
 * @Created on March, 2011 * @Package: Ndotdeals unlimited v2.2
 * @Author: NDOT
 * @URL : http://www.NDOT.in
 ********************************************/
?>
<?php 
	//API top right menu file
	if(file_exists(DOCUMENT_ROOT.'/themes/'.CURRENT_THEME.'/common/api_right.php'))
	{
		require_once(DOCUMENT_ROOT.'/themes/'.CURRENT_THEME.'/common/api_right.php');
	}
	else
	{
		require_once(DOCUMENT_ROOT.'/themes/_base_theme/common/api_right.php');
	}

	//API bottom right menu file
	if(file_exists(DOCUMENT_ROOT.'/themes/'.CURRENT_THEME.'/common/api_document_menu.php'))
	{
		require_once(DOCUMENT_ROOT.'/themes/'.CURRENT_THEME.'/common/api_document_menu.php');
	}
	else
	{
		require_once(DOCUMENT_ROOT.'/themes/_base_theme/common/api_document_menu.php');
	}

?>
