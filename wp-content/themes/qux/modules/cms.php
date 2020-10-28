<?php 

if(_hui('home_cms_cat') && is_array(_hui('home_cms_cat'))){
    
    $tps = array();
    $notinhome = array();
    $index = 0;
    $cats_count = count(_hui('home_cms_cat'));
    foreach(_hui('home_cms_cat') as $cms){
        $tps[] = $cms['type'];
    }
	foreach(_hui('home_cms_cat') as $cms){
	    $index++;
		$args = array(
		    'cat'=> $cms['category'],
			'post_status' => 'publish',
			'posts_per_page' => -1
		);
		
		if(get_option('sticky_posts')){
		    $args['post__not_in'] = $notinhome = get_option('sticky_posts');
		}
		
		if( _hui('notinhome_post') ){
			$pool = _hui('notinhome_post');
			$args['post__not_in'] = array_merge($notinhome,explode("\n", $pool));
		}
		
		query_posts($args);
		$category = get_category( $cms['category'] );
		
		$tp = $tps[$index-1];
        if ($index == 1 || $end_wrap) {
            $start_wrap = true;
        } else {
            $start_wrap = false;
        }
        if ($index == $cats_count || $tp != 'catlist_bar_0' || !$start_wrap || $tps[$index] != 'catlist_bar_0') {
            $end_wrap = true;
        } else {
            $end_wrap = false;
        }
		
        if($cms['type'] != 'catlist_bar_0'){ ?>
            <div class="catlist-<?php echo $category->cat_ID;?> cat-container clearfix">
                <h2 class="home-heading clearfix">
                   <span class="heading-text"><?php echo $category->cat_name;?></span><a href="<?php echo get_category_link( $category->cat_ID ); ?>">更多<i class="fa fa-angle-right"></i></a>
                </h2>
                <div class="cms-cat cms-cat-s<?php echo substr($cms['type'],-1); ?>">
                    <?php get_template_part('modules/cms/'.$cms['type']); ?>	
                </div>                            
            </div>	
		<?php  
        }else{ 
            if ($start_wrap) echo '<div class="catlist clr cat-container clearfix ">';  ?>
            <div class="catlist-<?php echo $category->cat_ID;?> cat-col-1_2">
			    <div class="cat-container clearfix">
				    <h2 class="home-heading clearfix">
					    <span class="heading-text"><?php echo $category->cat_name;?></span><a href="<?php echo get_category_link( $category->cat_ID ); ?>">更多<i class="fa fa-angle-right"></i></a>
					</h2>
					<div class="cms-cat cms-cat-s<?php echo substr($tp,-1); ?>">
					    <?php get_template_part('modules/cms/catlist_bar_0'); ?>	
					</div>  
				</div>		
            </div>
            <?php if ($end_wrap) echo '</div>'; 
        }
	}
	wp_reset_query();
}else{
    echo '<div class="no-post">请前往主题设置 - 首页 - 首页CMS模块 增加模块</div>';
}
?>