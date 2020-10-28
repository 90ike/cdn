<?php

	$indicators = '';
	$inner = '';
	$focusslide = _hui('focusslide_src');
	$focusslide_old = _hui('focusslide_old_src');
	$banner_style = _hui('banner_style');
    $i = 0;
	if($focusslide && $banner_style=='qiye'){
     foreach ($focusslide as $key => $value) {
         $btn =  $value['btn']; 
		 $btn_bg='';
		 if($btn){
          foreach ($btn as $key => $value_1) {
			 
			  $btn_bg.='<a '.($value_1['btn_bank']?' target="_blank"':'').' href="'.$value_1['btn_url'].'" class="btn btn-'.$value_1['btn_color'].' btn-slider">'.$value_1['btn_title'].'</a>';
		  }
		 }
	        $indicators .= '<li data-target="focusslide" data-slide-to="'.$i.'"'.(!$i?' class="active"':'').'></li>';
			if($value['style']=='center'){
				
				$inner .= '<div class="item'.(!$i?' active':'').'"  style="background-image: url('.$value['background']['url'].');">
			<div class="cd-main-content">
			<div class="cd-product-box wow fadeInLeft animated">
			<h2 style="color:'.$value['title_color'].';font-size:'.$value['title_size'].'px;">'.$value['title'].'</h2>
			<p style="color:'.$value['desc_color'].';font-size:'.$value['desc_size'].'px;">'.$value['desc'].'</p>
			<div class="button">
			'.$btn_bg.'
			</div>
			</div>
			</div>
			</div>';
			 $i++;
			}elseif($value['style']=='left'){
				
			
            $inner .= '<div class="item'.(!$i?' active':'').'"  style="background-image: url('.$value['background']['url'].');">
			<div class="cd-main-content">
			<div class="cd-product-intro intright wow fadeInLeft animated">
			<h2 style="color:'.$value['title_color'].';font-size:'.$value['title_size'].'px;">'.$value['title'].'</h2>
			<p style="color:'.$value['desc_color'].';font-size:'.$value['desc_size'].'px;">'.$value['desc'].'</p>
			<div class="button">
			'.$btn_bg.'
			</div>
			</div>
			<div class="cd-image-container imgright wow fadeInRight animated">
			<div class="img" style="background-image: url('.$value['background_left']['url'].');"></div>
			</div>
			</div>
			</div>';
            $i++;
				
				
			}elseif($value['style']=='right'){
				
				$inner .= '<div class="item'.(!$i?' active':'').'"  style="background-image: url('.$value['background']['url'].');">
			<div class="cd-main-content">
			<div class="cd-product-intro intleft wow fadeInLeft animated">
			<h2 style="color:'.$value['title_color'].';font-size:'.$value['title_size'].'px;">'.$value['title'].'</h2>
			<p style="color:'.$value['desc_color'].';font-size:'.$value['desc_size'].'px;">'.$value['desc'].'</p>
			<div class="button">
			'.$btn_bg.'
			</div>
			</div>
			<div class="cd-image-container imgleft wow fadeInRight animated">
			<div class="img" style="background-image: url('.$value['background_right']['url'].');"></div>
			</div>
			</div>
			</div>';
            $i++;
				
			}elseif($value['style']=='no'){
			$inner .= '
			
		<a '.($value['bank_no']?' target="_blank"':'').' class="item'.(!$i?' active':'').'"  style="background-image: url('.$value['background']['url'].');" href="'.$value['url_no'].'"></a>
			';
            $i++;
			}
    
	 }
	echo '<div id="focusslide" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">'.$indicators.'</ol>
        <div class="carousel-inner" role="listbox">'.$inner.'</div>
        <a class="left carousel-control" href="#focusslide" role="button" data-slide="prev">
                <i class="fa fa-angle-double-left"></i>
        </a>
        <a class="right carousel-control" href="#focusslide" role="button" data-slide="next">
                <i class="fa fa-angle-double-right"></i>
        </a>
</div>
	';
	}elseif($focusslide_old && $banner_style=='oldtb'){
		foreach ($focusslide_old as $key => $value) {
            $link.=
            $indicators .= '<li data-target="#focusslide" data-slide-to="'.$i.'"'.(!$i?' class="active"':'').'></li>';
            $inner .= '<a '.($value['old_bank']?' target="_blank"':'').' href="'.$value['old_url'].'" class="item'.(!$i?' active':'').'"  style="background-image: url('.$value['old_background']['url'].');">
				<div class="swiper-post">
                        <h3 style="color:'.$value['old_title_color'].';font-size:'.$value['old_title_size'].'px;">'.$value['old_title'].'</h3>
                        <p style="color:'.$value['old_desc_color'].';font-size:'.$value['old_desc_size'].'px;" class="description">
                         '.$value['old_desc'].'
                    </div>
			</a>';
            $i++;
        
    }
	echo '
	<div class="oldtbcontent">
      
                <div id="focusslide" class="oldbanner carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">'.$indicators.'</ol>
                        <div class="carousel-inner" role="listbox">'.$inner.'</div>
                        <a class="left carousel-control" href="#focusslide" role="button" data-slide="prev">
                                <i class="fa fa-angle-left"></i>
                        </a>
                        <a class="right carousel-control" href="#focusslide" role="button" data-slide="next">
                                <i class="fa fa-angle-right"></i>
                        </a>
                </div>
       
</div>
	';
	}elseif(!$focusslide || !$focusslide_old ){
		echo '<h3>请在后台添加焦点图</h3>';
	}
