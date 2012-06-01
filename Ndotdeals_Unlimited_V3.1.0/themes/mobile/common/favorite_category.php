<div class="great_deals mb-10">
<div class="great_top">
<h1>My Favorite Lists</h1>
</div>
<div class="great_center">
    
    <div class="width240 fl clr borderF2F mb20">
        <div class="brows fl">

	<?php
	 $sub_category  = mysql_query("select * from coupons_favorite left join coupons_category on coupons_favorite.favorite_id = coupons_category.category_id where coupons_favorite.user_id = '$userid' "); 
	 if(mysql_num_rows($sub_category)>0)
	 {
	        while($row = mysql_fetch_array($sub_category))
	        { ?>
				<span class="category_list"> <a href="<?php echo DOCROOT;?>deals/category/<?php echo html_entity_decode($row['category_url']); ?>_<?php echo $row['category_id']; ?>.html" title="<?php echo ucfirst(html_entity_decode($row['category_name'], ENT_QUOTES)); ?>"><?php echo ucfirst(html_entity_decode($row['category_name'], ENT_QUOTES)); ?></a></span>
	    	<?php 	
	        }
	}else
	{ ?>
		<div style="color:#333;font-size:14px;" class="fl clr">No Favorites Selected.</div>
	<?php 
	}	
	?>

    </div>
    </div>
</div>
<div class="great_bottom"></div>
</div>
