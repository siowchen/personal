<?php 
/********************************************
 * @Created on March, 2011 * @Package: Ndotdeals unlimited v2.2
 * @Author: NDOT
 * @URL : http://www.NDOT.in
 ********************************************/
?>
<?php 

$url = $_SERVER['REQUEST_URI'];
$last_uri = end(explode('/',$url)); 
$last_uri = current(explode('.',$last_uri)); 
$last_uri = explode('_',$last_uri);

//select the deal
$query = "select * from coupons_category where category_id = '$last_uri[1]' ";
$result = mysql_query($query);

if(mysql_num_rows($result) == 1)
{
	while($row = mysql_fetch_array($result))
	{

	?>	
        <ul>
        <li><a href="/" title="Home"><?php echo $language["home"]; ?> </a></li>
        <li><span class="right_arrow"></span></li>
        <li><a href="javascript:;" title="<?php echo ucfirst($row["category_name"]);?>">
		<?php echo ucfirst($row["category_name"]);?></a></li>    
        </ul>
        
        <h1><?php echo $page_title;?></h1>
        
	<?php 
	//get the hot deals by category
	getcoupons('C',$row["category_id"],$default_city_id);
	}
}
?>
