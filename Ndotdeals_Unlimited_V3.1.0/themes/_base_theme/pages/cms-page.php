<?php 
/********************************************
 * @Created on March, 2011 * @Package: Ndotdeals unlimited v2.2
 * @Author: NDOT
 * @URL : http://www.NDOT.in
 ********************************************/
 	 $lang = $_SESSION["site_language"];
	if($lang)
	{
			include(DOCUMENT_ROOT."/system/language/".$lang.".php");
	}
	else
	{
			include(DOCUMENT_ROOT."/system/language/en.php");
	}
// echo $page_title;
?>
<ul>
<li><a href="/" title="<?php echo $language["home"]; ?>"><?php echo $language["home"]; ?> </a></li>
<li><span class="right_arrow"></span></li>
<li><a href="javascript:;" title="<?php echo ucfirst($page_title); ?>">
<?php 
if($page_title=="about us")
{
echo $language["about_us"];
}
else if($page_title=="FAQ")
{
echo $language["faq"];
}
else if($page_title=="privacy policy")
{
echo $language["privacy_policy"];
} 
else
{
echo $page_title;
}
?>
</a></li>    
</ul>
<h1>
<?php 


if($page_title=="about us")
{
echo $language["about_us"];
} 
else if($page_title=="FAQ")
{
echo $language["faq"];
}
else if($page_title=="privacy policy")
{
echo $language["privacy_policy"];
}
else
{
echo $page_title;
}
?>
</h1>
                        
<div class="work_bottom5">


<p class="fl clr">
<?php 
//echo "Title ".html_entity_decode($page_desc);

echo nl2br(html_entity_decode($page_desc));?>
</p>

</div>
