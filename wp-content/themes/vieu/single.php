<?php 
global $post;
get_header(); 
$shop=get_post_meta($post->ID,'mall_push',true);

 if($shop && _hui('is_shoping')){
	 require_once('action/commodity.php');
	 }else{ 
	 require_once('action/article.php');
	 } ?>

<?php get_footer(); 