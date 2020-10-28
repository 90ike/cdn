<?php
global $post;
$related_no = cmp_get_option('edd_related_number') ? cmp_get_option('edd_related_number') : 4;
$query_type = cmp_get_option('edd_related_query') ;
$taxchoice = ($query_type == 'category') ? 'download_category' : 'download_tag';
$custom_taxterms = wp_get_object_terms( $post->ID, $taxchoice, array('fields' => 'ids') );
$args = array(
	'post_type' => 'download',
	'post__not_in' => array($post->ID),
	'posts_per_page' => $related_no,
	'no_found_rows' => 1
);

if ( !empty($custom_taxterms) ){
	$args['tax_query'] = array(
		array(
			'taxonomy' => $taxchoice,
			'field' => 'id',
			'terms' => $custom_taxterms
		)
	)
}

if( $query_type == 'rand' ){
	$args['orderby'] = 'rand';
}

$related_query = new WP_Query($args);

if( $query_type !== 'rand' && !$related_query->have_posts() ) {
	$args['orderby'] = 'rand';
	$related_query = new WP_Query( $args );
}
$i=1;
if( $related_query->have_posts() ) { ?>
<section id="related-posts" class="widget-box related-box">
	<h3><?php if(cmp_get_option('edd_title_related')) echo cmp_get_option('edd_title_related'); else _e( 'Related Downloads' , 'wpdx' ); ?></h3>
	<div class="widget-content">
		<?php while ( $related_query->have_posts() ) : $related_query->the_post()?>
			<div class="related-item">
				<div class="post-thumbnail">
					<a href="<?php the_permalink(); ?>" title="<?php printf( __( 'Permalink to %s', 'wpdx' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
						<?php cmp_post_thumbnail(330,200) ?>
					</a>
				</div><!-- post-thumbnail /-->
				<a href="<?php the_permalink(); ?>" title="<?php printf( __( 'Permalink to %s', 'wpdx' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
				<p class="post-meta"><?php cmp_get_time() ?></p>
			</div>
			<?php if($i % 4 == 0) echo '<div class="clear"></div>'; elseif($i % 2 == 0) echo '<div class="clear2"></div>';?>
			<?php $i++; endwhile;?>
			<div class="clear"></div>
		</div>
	</section>
<?php }
wp_reset_query();
