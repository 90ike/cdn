
<div class="pageside">
	<div class="pagemenus">
		<ul class="pagemenu">
			<?php  
	$pagemenus = _hui('page_menu');
	$menus = '';
	
	if( $pagemenus ){
		$pageURL = curPageURL();
		foreach ($pagemenus as $key => $value) {
			
			if( $value ) {
				$purl = get_permalink($value);
				$menus .= '<li '.($purl==$pageURL?'class="active"':'').'><a href="'.$purl.'">'.get_post($value)->post_title.'</a></li>';
			}
		}
	}
  echo $menus;
?>
		</ul>
	</div>
</div>