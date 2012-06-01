			</div>
			</div>


       {php}
   if(CURRENT_THEME=='nightcity') 
   { {/php}

			<div class="inner_bottom cnt_btmborder"></div>

  {php} } 
   else 
   { {/php}

			<div class="content_bottom"></div>

  {php} } {/php}


                    </div>
                                   <div class="content_right">
				              
               	                        <div class="great_deals">
                                        		<div class="great_top1"></div>
                    	                        <div class="great_top">
                    	                                         {if !$login}
					                                <h1 class="miniheader">Login Form</h1>
				                                {else}
					                               <h1 class="miniheader">Affiliates</h1>
				                                {/if}</div>
                                                 <div class="login-small">
                     	                                <div class="great_center">
                                                       
				                                {if !$login}
					                                {include file="login-form.tpl"}
				                                {else}
					                                {include file="context-menu.tpl"}
					                                {include file="marketing-menu.tpl"}
				                                {/if}
				                        </div>
                     	                        <div class="great_bottom"></div>
                                                
                                                </div>
                                        </div>
                                        
			                </div>                    
                    
                    
			</div>
          </div>
      </div>
  </div>
  
  {php}
  
 
 include(DOCUMENT_ROOT."/themes/".CURRENT_THEME."/footer.php");
 {/php}

</body>

</html>
