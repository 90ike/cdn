<?php
function get_home_scroll( $cat_data ){
global $post;
$Cat_ID = isset($cat_data['id']) ? $cat_data['id'] : '';
$Posts = $cat_data['number'];
$order = $cat_data['order'];
if($Cat_ID){
	$Box_Title = get_the_category_by_ID($Cat_ID[0]);
}
$Box_Title = $cat_data['title'] ? $cat_data['title'] : $Box_Title;
$icon = $cat_data['icon'] ? $cat_data['icon']:'fa-list';
$more_text = trim($cat_data['more_text']);
$more_url = $cat_data['more_url'];
$post_ids = '';
if($cat_data['post_ids'] && trim($cat_data['post_ids']) !='') {
	$post_ids = explode(',', $cat_data['post_ids'] );
	$args = array( 'post__in' => $post_ids ,'posts_per_page'=> $Posts , 'orderby'=>'post__in','ignore_sticky_posts' => 1 ,'no_found_rows' => 1);
}elseif($Cat_ID){
	if( $order == 'rand') {
		$args = array ( 'ignore_sticky_posts' => 1, 'posts_per_page' => $Posts , 'orderby' => 'rand', 'cat' => $Cat_ID,'no_found_rows' => 1);
	} else {
		$args = array ( 'ignore_sticky_posts' => 1, 'posts_per_page' => $Posts , 'cat' => $Cat_ID,'no_found_rows' => 1);
	}
}else{
	$args = array ( 'ignore_sticky_posts' => 1, 'posts_per_page' => $Posts , 'no_found_rows' => 1);
}
$cat_query = new WP_Query($args);
$who = $cat_data['who'];
if( ($who == 'logged' && !is_user_logged_in())  || ($who == 'anonymous' && is_user_logged_in()) ):
	// return none;
else:
?>
<section class="span12 scroll-box">
	<div class="widget-box">
		<div class="widget-title">
			<?php if($more_url && $more_text !=''): ?>
				<span class="more"><a target="_blank" href="<?php echo $more_url; ?>"><?php echo $more_text; ?></a></span>
			<?php endif; ?>
			<span class="icon"> <i class="fa <?php echo $icon; ?> fa-fw"></i> </span>
			<?php if($more_url): ?>
				<h2><a target="_blank" href="<?php echo $more_url; ?>"><?php echo $Box_Title ; ?></a></h2>
			<?php else: ?>
				<h2><?php echo $Box_Title ; ?></h2>
			<?php endif; ?>
		</div>
		<div class="widget-content pic-list">
			<?php if($cat_query->have_posts()): ?>
				<ul class="cat-scroll">
					<?php while ( $cat_query->have_posts() ) : $cat_query->the_post()?>
						<li>
								<a href="<?php the_permalink(); ?>" class="post-thumbnail" title="<?php printf( esc_attr__( 'Permalink to %s', 'wpdx' ), the_title_attribute( 'echo=0' ) ); ?>" <?php echo cmp_target_blank();?>>
									<?php cmp_post_thumbnail(330,200) ?>
								</a>
								<?php //if($show_title): ?>
								<a class="row-title" href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'wpdx' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark" <?php echo cmp_target_blank();?>><?php the_title(); ?></a>
								<?php //endif;?>
							</li>
					<?php endwhile;?>
				</ul>
				<div class="clear"></div>
			</div>
		<?php endif; ?>
	</div>
</section>
<?php
if(wp_is_mobile()){
	$min = $max = 2;
	$width = 200;
	$margin = 4;
}else{
	$min = $max = 5;
	$width = 268;
	$margin = 20;
}
echo '<script type="text/javascript">
	jQuery(function() {
		jQuery(".cat-scroll").bxSlider({
			minSlides: '.$min.',
			maxSlides: '.$max.',
			slideWidth: '.$width.',
			slideMargin: '.$margin.',
			auto: true,
			autoHover: true,
			autoDelay:2,
			pause: 6000,
			captions: false,
			controls: true,
			adaptiveHeight:true,
			pager: false';
if(cmp_get_option( 'lazyload' )){
	echo',
		onSlideAfter: function(){
			    setTimeout(function(){jQuery(window).lazyLoadXT()},1000)
			  }';
}
echo'	});
	});
</script>';
?>
<?php endif;//$who ?>
<?php } ?>