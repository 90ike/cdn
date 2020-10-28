<?php 
/**
 * [mo_minicat description]
 * @return html [description]
 */
function mo_minicat(){
	if( !_hui('minicat') ) return;

	$args = array(
	    'ignore_sticky_posts' => 1,
	    'showposts' => 1,
	    'cat' => _hui('minicat')
	);
	query_posts($args);
	echo '<div class="sweet-alert">';
	while ( have_posts() ) : the_post(); 
	$str     = get_post()->post_content;
    $excerpt = wp_trim_words(strip_tags($str), 300, '...');
		$category = get_the_category();
		 echo '<h2><i class="fa fa-bullhorn"></i> <a'._post_target_blank().' class="red" href="'.get_category_link($category[0]->term_id ).'">'.(_hui('minicat_home_title') ? _hui('minicat_home_title') : '网站公告').'</a> </h2>';
		 
	    echo '<article class="excerpt-minic">';
	     echo '<h3><a href="'.get_permalink().'" title="'.get_the_title().get_the_subtitle(false)._get_delimiter().get_bloginfo('name').'">'.get_the_title().get_the_subtitle().'</a> '.get_the_modified_time('Y-m-j').'</h3>';
	        echo '<p class="note">'.the_content().'</p></article>';
	    echo '<div class="minicat-btn"><a class="btn btn-primary close-minic">'._hui('minicat_btn_title').'</a></div>';
	endwhile; 
	echo '</div>';
	wp_reset_query();
}