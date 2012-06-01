
        <div class="menu">
        <?php include("pages/admin_left.php");?>
        </div>
        

        <div class="container_rgt ">
        
        	<div class="container_rgt_head"><h1><?php echo $page_title; ?></h1>
            
            </div>

	 <div class="container_content ">

		  	<div class="bread_crumb">
				<a href="<?php echo DOCROOT; ?>admin/profile/" title="<?php echo $admin_language['home']; ?>"><?php echo $admin_language['home']; ?> <span class="fwn">&#155;&#155;</span></a>
				<p><?php echo $page_title; ?></p>
		          </div>
		          
		  	<div class="cont_container mt15 ">

		          <div class="content_top "><div class="top_left"></div><div class="top_center"></div><div class="top_rgt"></div></div>

		          <div class="content_middle "><?php include(DOCUMENT_ROOT.'/'.$current_file);?>
			</div>
		          
		          <div class="content_bottom"><div class="bot_left"></div><div class="bot_center"></div><div class="bot_rgt"></div></div>
		          
	 </div>

           
        </div>
        </div>
