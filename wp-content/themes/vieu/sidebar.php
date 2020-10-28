<?php if( _hui('layout') ){ 
echo'<div class="wzsid sidebar"'; if(is_single()){echo'style="margin-top:20px;"';}elseif($paged>=1) {echo'style="margin-top:30px;"';}elseif(_hui('banner_style')==1){echo'style="margin-top:0px;"';} echo'>';

	
	if (function_exists('dynamic_sidebar')){
		dynamic_sidebar('gheader'); 

		if (is_home()){
			dynamic_sidebar('home'); 
		}
		elseif (is_category()){
			dynamic_sidebar('cat'); 
		}
		else if (is_tag() ){
			dynamic_sidebar('tag'); 
		}
		else if (is_search()){
			dynamic_sidebar('search'); 
		}
		else if (is_single()){
			dynamic_sidebar('single'); 
		}

		dynamic_sidebar('gfooter');
	} 
?>
</div>
<?php } ?>