<?php
global $post;
$related_no = cmp_get_option('related_number') ? cmp_get_option('related_number') : 4;
$query_type = cmp_get_option('related_query');

$args = array(
	'post__not_in' => array($post->ID),
	'ignore_sticky_posts' => 1,
	'posts_per_page'=> $related_no,
	'no_found_rows' => 1
);
if( $query_type == 'author' ){
	$args['author'] = get_the_author_meta( 'ID' );
}elseif( $query_type == 'tag' ){
	$tags = wp_get_post_tags($post->ID);
	$tags_ids = array();
	foreach($tags as $individual_tag) $tags_ids[] = $individual_tag->term_id;
	$args['tag__in'] = $tags_ids;
}elseif( $query_type == 'rand' ){
	$args['orderby'] = 'rand';
}else{
	$categories = get_the_category($post->ID);
	$category_ids = array();
	foreach($categories as $individual_category) $category_ids[] = $individual_category->term_id;
	$args['category__in'] = $category_ids;
}

$related_query = new WP_Query( $args );

if( $query_type !== 'rand' && !$related_query->have_posts() ) {
	$args['orderby'] = 'rand';
	$related_query = new WP_Query( $args );
}

$i=1;
if( $related_query->have_posts() ) { ?>
<section id="related-posts" class="widget-box related-box">
	<h3><?php if(cmp_get_option('title_related')) echo cmp_get_option('title_related'); else _e( 'Related Articles' , 'wpdx' ); ?></h3>
	<div class="widget-content">
		<?php while ( $related_query->have_posts() ) : $related_query->the_post()?>
			<?php if(cmp_get_option('related_style') == 'small_thumb' ): ?>
				<div class="related-item widget-thumb">
					<a class="post-thumbnail" href="<?php the_permalink(); ?>" title="<?php printf( __( 'Permalink to %s', 'wpdx' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
						<?php cmp_post_thumbnail(75,45) ?>
					</a>
					<a href="<?php the_permalink(); ?>" title="<?php printf( __( 'Permalink to %s', 'wpdx' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
					<span class="date"><?php cmp_get_time() ?></span>
				</div>
			<?php elseif(cmp_get_option('related_style') == 'title_only' ): ?>
				<div class="related-item only-title">
					<a href="<?php the_permalink(); ?>" title="<?php printf( __( 'Permalink to %s', 'wpdx' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
				</div>
			<?php else: ?>
				<div class="related-item">
					<div class="post-thumbnail">
						<a href="<?php the_permalink(); ?>" title="<?php printf( __( 'Permalink to %s', 'wpdx' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
							<?php cmp_post_thumbnail(330,200) ?>
						</a>
					</div>
					<a href="<?php the_permalink(); ?>" title="<?php printf( __( 'Permalink to %s', 'wpdx' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
					<p class="post-meta"><?php cmp_get_time() ?></p>
				</div>
				<?php if($i % 4 == 0) echo '<div class="clear"></div>'; elseif($i % 2 == 0) echo '<div class="clear2"></div>';?>
			<?php endif; ?>
			<?php $i++; endwhile;?>
			<div class="clear"></div>
		</div>
	</section>
<?php }
wp_reset_query();
