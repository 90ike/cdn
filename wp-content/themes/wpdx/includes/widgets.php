<?php

// require_once get_template_directory() . '/includes/widgets/widget-author.php';
// require_once get_template_directory() . '/includes/widgets/widget-custom-author.php';
require_once get_template_directory() . '/includes/widgets/widget-tag-cloud.php';
//require_once get_template_directory() . '/includes/widgets/widget-statistics.php';
require_once get_template_directory() . '/includes/widgets/widget-recently-viewed.php';

require_once get_template_directory() . '/includes/widgets/widget-posts.php';
require_once get_template_directory() . '/includes/widgets/widget-category.php';
require_once get_template_directory() . '/includes/widgets/widget-news-pic.php';
require_once get_template_directory() . '/includes/widgets/widget-text-html.php';
require_once get_template_directory() . '/includes/widgets/widget-follow-subscribe.php';

//require_once get_template_directory() . '/includes/widgets/widget-login.php';

require_once get_template_directory() . '/includes/widgets/widget-comment.php';
require_once get_template_directory() . '/includes/widgets/widget-slider.php';
require_once get_template_directory() . '/includes/widgets/widget-readers.php';

//require_once get_template_directory() . '/includes/widgets/widget-list-custom-taxonomy.php';

function remove_default_widgets() {
	if (function_exists('unregister_widget')) {
		unregister_widget( 'WP_Widget_Recent_Comments' );
		unregister_widget( 'WP_Widget_Search' );
		unregister_widget( 'WP_Widget_Tag_Cloud' );
		unregister_widget( 'WP_Widget_Text' );
	}
}
add_action('widgets_init', 'remove_default_widgets');

## Widgets
add_action( 'widgets_init', 'cmp_widgets_init' );
function cmp_widgets_init() {

	/*=================Widgets For Sidebars Right===========================*/

	$before_widget =  '<div id="%1$s" class="widget-box widget %2$s"><div class="widget-content">';
	$after_widget  =  '</div></div>';
	$before_title  =  '<div class="widget-title"><span class="icon"><i class="fa fa-list fa-fw"></i></span><h3>';
	$after_title   =  '</h3></div>';

	register_sidebar( array(
		'name' =>  __( 'Primary Widget Area', 'wpdx' ),
		'id' => 'primary-widget-area',
		'description' => __( 'The Primary widget area', 'wpdx' ),
		'before_widget' => $before_widget , 'after_widget' => $after_widget ,
		'before_title' => $before_title , 'after_title' => $after_title ,
		) );

	//Custom Sidebars
	$sidebars = cmp_get_option( 'sidebars' ) ;
	if($sidebars){
		foreach ($sidebars as $sidebar) {
			register_sidebar( array(
				'name' => $sidebar,
				'id' => sanitize_title($sidebar),
				'before_widget' => $before_widget , 'after_widget' => $after_widget ,
				'before_title' => $before_title , 'after_title' => $after_title ,
				) );
		}
	}
}