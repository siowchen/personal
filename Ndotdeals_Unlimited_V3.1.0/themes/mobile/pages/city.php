<?php
/******************************************
* @Created on March, 2011 * @Package: Ndotdeals unlimited v2.2
* @Author: NDOT
* @URL : http://www.NDOT.in
********************************************/
?>

    <div class="mobile_content">
      <div class="city_inner">

        
                <?php $result = mysql_query("select * from coupons_cities where status='A' order by cityname asc") or die(mysql_error());
                        if(mysql_num_rows($result) > 0)
                        {?>

			<ul>
				<?php 
                                while($city_row = mysql_fetch_array($result))
                                {
				?>
									

				  <li><a href="javascript:;" title="<?php echo ucfirst(html_entity_decode($city_row['cityname'], ENT_QUOTES)); ?>" onclick="javascript:citySelect('<?php echo DOCROOT; ?>','<?php echo CURRENT_THEME; ?>','<?php echo $city_row['cityid']; ?>','<?php echo html_entity_decode($city_row['cityname'], ENT_QUOTES); ?>','<?php echo html_entity_decode($city_row['city_url'], ENT_QUOTES); ?>');" ><?php echo ucfirst(html_entity_decode($city_row['cityname'], ENT_QUOTES)); ?><img src="<?php echo DOCROOT; ?>themes/<?php echo CURRENT_THEME; ?>/images/city_round.png" width="25" height="25" alt="go" border="0" align="right" /></a></li>


			<?php
                                }?>
		        </ul>
		<?php }
		?>

      </div>
    </div>

