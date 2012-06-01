<div class="great_deals mb20 fl clr">
<div class="great_top1"></div>
<div class="great_top">

	<h1><?php echo $language['browse_category']; ?></h1>
</div>
<div class="great_center">
    
    <div class="width220 fl clr">
        <div class="brows fl">

	<?php
	$sub_category  = get_subcategory(); 
	 if(mysql_num_rows($sub_category)>0)
	 {
	        while($row = mysql_fetch_array($sub_category))
	        { ?>
				<span class="category_list"> <a href="<?php echo DOCROOT;?>deals/category/<?php echo html_entity_decode($row['category_url']); ?>_<?php echo $row['category_id']; ?>.html" title="<?php echo ucfirst(html_entity_decode($row['category_name'], ENT_QUOTES)); ?>"><?php echo ucfirst(html_entity_decode($row['category_name'], ENT_QUOTES)); ?></a></span>
	    	<?php 	
	        }
	}	
	?>
    
        

    </div>
    </div>
</div>
<div class="great_bottom"></div>
</div>
