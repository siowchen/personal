<?php 
/********************************************
 * @Created on March, 2011 * @Package: Ndotdeals unlimited v2.2
 * @Author: NDOT
 * @URL : http://www.NDOT.in
 ********************************************/
 ?>
 
<div class="category fl">
  <div class="cate_top">
    <h1><?php echo $language['categories'];?></h1>
  </div>
  <div class="cate_middle">
    <ul>
      <?php
        $sub_category  = get_subcategory(); 
         if(mysql_num_rows($sub_category)>0)
         {
                while($row = mysql_fetch_array($sub_category))
                { ?>
	<li>
		<a class="cate_menu" href="<?php echo DOCROOT;?>deals/category/<?php echo html_entity_decode($row['category_url']); ?>_<?php echo $row['category_id']; ?>.html" title="<?php echo ucfirst(html_entity_decode($row['category_name'], ENT_QUOTES)); ?>">
			<span class="cate">
			<?php 
			if(file_exists('uploads/categoryicon/'.$row['category_id'].'.jpg'))
			{			
			 ?>
				<img src="<?php echo DOCROOT;?>uploads/categoryicon/<?php echo $row['category_id'];?>.jpg" />
			<?php
			}
			else
			{
			?>
			<img src="<?php echo DOCROOT;?>themes/<?php echo CURRENT_THEME; ?>/images/no_icon.jpg" />
			<?php
			}
			?>
			</span>	
			
			<span>			
				<?php echo ucfirst(html_entity_decode($row['category_name'], ENT_QUOTES)); ?>
			</span>
		</a>
	</li>
      <?php 	
                }
        }	
        ?>
    </ul>
  </div>
  <div class="cate_bot fl"></div>
</div>
