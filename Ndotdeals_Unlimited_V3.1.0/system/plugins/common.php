<?php 
		//make seo url
	function friendlyURL($string)
	{
		$string = preg_replace("`\[.*\]`U","",$string);
		$string = preg_replace('`&(amp;)?#?[a-z0-9]+;`i','-',$string);
		$string = htmlentities($string, ENT_COMPAT, 'utf-8');
		$string = preg_replace( "`&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);`i","\\1", $string );
		$string = preg_replace( array("`[^a-z0-9]`i","`[-]+`") , "-", $string);
		return strtolower(trim($string, '-'));
	}

    //social media commenting system
    function social_media_comment()
    {
        ?>
         <script type="text/javascript">
         var ndotkey =[];ndotkey.push(['dee4d18dff576c93f7ad40adc0ffe3efd3f8297c'],'');
         </script>  
         <script src="http://www.ndotsocial.com/v1/js/nDotShare.js" type="text/javascript" ></script>
         <div id="ndotshare_comments" class="ndotshare_comments" ></div>
  
        <?php 
    }
	
	//facebook fan page
    function fanpage($url='')
    {
        ?>

        <iframe src="http://www.facebook.com/plugins/likebox.php?href=<?php echo $url; ?>&amp;width=190&amp;colorscheme=light&amp;show_faces=true&amp;stream=false&amp;header=yes&amp;height=310" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:210px; height:310px; margin-left:10px;" allowTransparency="true"></iframe>
        
        <?php 
    }
	//social media share icons
    function social_share($url = '',$title = '')
	{
	
			#-------------------------------------------------------------------------------
			# language file included here
			#-------------------------------------------------------------------------------
			$lang = $_SESSION["site_language"];
			if($lang)
			{
					include(DOCUMENT_ROOT."/system/language/".$lang.".php");
			}
			else
			{
					include(DOCUMENT_ROOT."/system/language/en.php");
			}


			$host = $_SERVER['HTTP_HOST'];
			$share_link = urlencode("http://".$host."/".$url);

		?>
		<ul>
        <li><div class="share"><?php echo $language['share']; ?></div></li>
        <li><a href="http://twitter.com/home?status=<?php echo $share_link;?>" title="twitter" target="_blank">
        <img src="/themes/<?php echo CURRENT_THEME; ?>/images/twitter_icon.png" alt="twitter" border="0"/>
        </a></li>
        
        <li>
        <a href="http://www.facebook.com/sharer.php?u=<?php echo $share_link;?>&amp;t=<?php echo $title; ?>" title="facebook" target="_blank">
        <img src="/themes/<?php echo CURRENT_THEME; ?>/images/link4.png" alt="facebook" border="0"/>
        </a></li>
        
        <li><a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo $share_link; ?>&amp;title=<?php echo urlencode($title); ?>&amp;summary=<?php echo urlencode($title); ?>&amp;source=<?php echo urlencode('http://'.$host);?>" title="linkedin" target="_blank">
        <img src="/themes/<?php echo CURRENT_THEME; ?>/images/link5.png" alt="linkedin" border="0" />
        </a></li>
        
        <?php /* <li><a href="http://www.google.com/buzz/post?message=<?php echo $title;?>&amp;url=<?php echo $share_link;?>" title="Google Buzz" target="_blank">
        <img src="/themes/<?php echo CURRENT_THEME; ?>/images/buzz_icon.png" alt="Google Buzz" border="0" />
        </a></li> */ ?>
        
        <li>
      
<iframe src="http://www.facebook.com/plugins/like.php?href=<?php echo $share_link; ?>&amp;layout=button_count&amp;show_faces=true&amp;width=450&amp;action=like&amp;font=arial&amp;colorscheme=light&amp;height=80" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:80px; height:25px; overflow:hidden; margin-left:10px;margin-top:2px;float:left; " allowTransparency="true"></iframe>
        </li>
	    </ul>
	<?php 
	}

       //social media share icons
       function social_share_1($url = '',$title = '')
	{
			$host = $_SERVER['HTTP_HOST'];
			$share_link = urlencode("http://".$host."/".$url);
			

		?>
		<ul>
        <li><a href="http://twitter.com/?status=<?php echo $share_link;?>" title="twitter" target="_blank">
        <img src="/themes/<?php echo CURRENT_THEME; ?>/images/twitter_icon.png" alt="twitter" border="0" />
        </a></li>
        
        <li>
        <a href="http://www.facebook.com/sharer.php?u=<?php echo $share_link;?>&amp;t=<?php echo $title;?>" title="facebook" target="_blank">
        <img src="/themes/<?php echo CURRENT_THEME; ?>/images/link4.png" alt="facebook" border="0" />
        </a></li>
        
        <li><a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo $share_link; ?>&amp;title=<?php echo urlencode($title); ?>&amp;summary=<?php echo urlencode($title); ?>&amp;source=<?php echo urlencode('http://'.$host);?>" title="linkedin" target="_blank">
        <img src="/themes/<?php echo CURRENT_THEME; ?>/images/link5.png" alt="linkedin" border="0" />
        </a></li>
        
        <?php /* <li><a href="http://www.google.com/buzz/post?message=<?php echo $title;?>&amp;url=<?php echo $share_link;?>" title="Google Buzz" target="_blank">
        <img src="/themes/<?php echo CURRENT_THEME; ?>/images/buzz_icon.png" alt="google buzz" border="0" />
        </a></li> */  ?>
        
        <li>
           
<iframe src="http://www.facebook.com/plugins/like.php?href=<?php echo $share_link; ?>&amp;layout=button_count&amp;show_faces=true&amp;width=450&amp;action=like&amp;font=arial&amp;colorscheme=light&amp;height=80" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:80px; height:25px; overflow:hidden; margin-left:10px;margin-top:2px;float:left; " allowTransparency="true"></iframe>

        </li>
	    </ul>
	<?php 
	}
	
	//social media share icons for users logged in 
        function social_share_user($url = '',$title = '')
	 {
			#-------------------------------------------------------------------------------
			# language file included here
			#-------------------------------------------------------------------------------
			$lang = $_SESSION["site_language"];
			if($lang)
			{
					include(DOCUMENT_ROOT."/system/language/".$lang.".php");
			}
			else
			{
					include(DOCUMENT_ROOT."/system/language/en.php");
			}


			$host = $_SERVER['HTTP_HOST'];
			$share_link = urlencode("http://".$host."/".$url);
			
			$host = $_SERVER['HTTP_HOST'];
			$share_link = urlencode("http://".$host."/".$url);
			$userid = $_SESSION['userid'];
	                $queryString = "SELECT * FROM coupons_users where userid='$userid'";
	                $resultSet = mysql_query($queryString);
		        if(mysql_num_rows($resultSet) > 0)
		        {
			        while($row = mysql_fetch_array($resultSet))
			        {
				        $referral_id = $row['referral_id'];
			        }
		        }

		        ?>
		<ul>
        <li><div class="share"><?php echo $language['share']; ?></div></li>
        <li><a href="http://twitter.com/share?url=<?php echo $share_link;?>" title="twitter" target="_blank">
        <img src="/themes/<?php echo CURRENT_THEME; ?>/images/twitter_icon.png" alt="twitter share" border="0" />
        </a></li>        
        <li>
        <a href="http://www.facebook.com/sharer.php?u=<?php echo $share_link;?>&amp;t=<?php echo $title.' '.urlencode(DOCROOT.'ref.html?id='.$referral_id); ?>" title="facebook" target="_blank">
        <img src="/themes/<?php echo CURRENT_THEME; ?>/images/link4.png" alt="facebook" border="0" />
        </a></li>
        
        <li><a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo $share_link; ?>&amp;title=<?php echo urlencode($title.' '.DOCROOT.'ref.html?id='.$referral_id); ?>&amp;summary=<?php echo urlencode($title); ?>&amp;source=<?php echo urlencode('http://'.$host);?>" title="linkedin" target="_blank">
        <img src="/themes/<?php echo CURRENT_THEME; ?>/images/link5.png" alt="linkedin" border="0" />
        </a></li>
        
       <?php /* <li><a href="http://www.google.com/reader/link?title=<?php echo $title.urlencode(DOCROOT.'ref.html?id='.$referral_id);?>&amp;url=<?php echo $share_link;?>" title="Google Buzz" target="_blank">
        <img src="/themes/<?php echo CURRENT_THEME; ?>/images/buzz_icon.png" alt="Google Buzz" border="0"/>
        </a></li> */ ?>
        
        <li>
            
<iframe src="http://www.facebook.com/plugins/like.php?href=<?php echo $share_link; ?>&amp;layout=button_count&amp;show_faces=true&amp;width=450&amp;action=like&amp;font=arial&amp;colorscheme=light&amp;height=80" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:80px; height:25px; overflow:hidden; margin-left:10px;margin-top:2px;float:left; " allowTransparency="true"></iframe>

        </li>
	    </ul>
	<?php 
	}
	
	//find the urls in string
	function make_links($str) 
	{
    $reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
    $urls = array();
    $urlsToReplace = array();
    if(preg_match_all($reg_exUrl, $str, $urls)) {
        $numOfMatches = count($urls[0]);
        $numOfUrlsToReplace = 0;
        for($i=0; $i<$numOfMatches; $i++) {
            $alreadyAdded = false;
            $numOfUrlsToReplace = count($urlsToReplace);
            for($j=0; $j<$numOfUrlsToReplace; $j++) {
                if($urlsToReplace[$j] == $urls[0][$i]) {
                    $alreadyAdded = true;
                }
            }
            if(!$alreadyAdded) {
                array_push($urlsToReplace, $urls[0][$i]);
            }
        }
        $numOfUrlsToReplace = count($urlsToReplace);
        for($i=0; $i<$numOfUrlsToReplace; $i++) 
		{
            //$str = str_replace($urlsToReplace[$i], "<a href=\"".$urlsToReplace[$i]."\">".$urlsToReplace[$i]."</a> ", $str);
			$str = $urlsToReplace[$i];
        }
		
        return $str;
    } else {
        return;
    }
	}
?>
