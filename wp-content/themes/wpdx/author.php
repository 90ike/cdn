<?php
$author = get_user_by( 'slug', get_query_var( 'author_name' ) );
if(!$author) $author = get_user_by( 'ID', get_query_var( 'author' ) );
$current_user = wp_get_current_user();
$user_posts_list_id = cmp_get_page_id_by_shortcode('cmpuser-post-list');
if( function_exists('wpuf_autoload')){
	$user_posts_list_id = cmp_get_page_id_by_shortcode('wpuf_dashboard');
}
$user_posts_list_url = get_permalink($user_posts_list_id);
if( cmp_get_option('redirect_author_uc') && $current_user->ID == $author->ID){
	wp_safe_redirect( $user_posts_list_url ); exit;
}
get_header(); ?>
<div id="content-header">
	<?php cmp_breadcrumbs();?>
</div>
<div class="container-fluid">
	<?php get_template_part('includes/ad-top' );?>
	<div class="row-fluid">
		<div class="span12">
			<div class="widget-box user-center">
				<div id="user-left">
					<div class="user-avatar">
						<?php echo get_avatar( $author->user_email, 100 ).'<p>'.$author->nickname.'</p>'; ?>
						<?php if( cmp_get_option( 'author_bio' ) && get_the_author_meta( 'description' )): ?>
						<p class="author-bio"><?php echo get_the_author_meta( 'description' ); ?></p>
					<?php endif; ?>
					<?php if(class_exists("Fep_Message")){
						$pm_id = cmp_get_page_id_by_shortcode('front-end-pm');
						echo '<p class="user-pm"><a href="'.get_permalink($pm_id).'?fepaction=newmessage&to='.$author->user_login.'" ><i class="fa fa-paper-plane-o"></i> '.__('Send a message','wpdx').'</a></p>';
					}
					?>
				</div>
				<ul id="user-menu">
					<li class="current-menu-item"><a href="<?php echo get_author_posts_url( $author->ID ); ?>"><i class="fa fa-book fa-fw"></i><?php _e('His/Her Posts','wpdx') ?></a></li>
				</ul>
			</div>
			<div class="widget-content" id="user-right">
				<header id="archive-head">
					<h1>
						<?php echo sprintf(__("%s's Posts",'wpdx'), $author->nickname); ?>
						<?php if( cmp_get_option( 'author_rss' ) ): ?>
							<a class="rss-cat-icon" title="<?php _e( 'Subscribe to this author', 'wpdx' ); ?>"  href="<?php echo get_author_feed_link( $author->ID ); ?>"><i class="fa fa-rss fa-fw"></i></a>
						<?php endif; ?>
					</h1>
				</header>
				<div class="entry">
					<?php
					if(count_user_posts( $author->ID ) != '0'){
						printf(__('<div class="post-count"> %s has published %s posts</div>','wpdx'), $author->nickname , count_user_posts( $author->ID ) ) ;
					}else{
						printf(__('<div class="post-count"> %s has not yet published any post, you can read the following wonderful posts</div>','wpdx'), $author->nickname ) ;
					}
					?>
					<table class="wpuf-table post" cellpadding="0" cellspacing="0">
						<thead>
							<tr>
								<th class="uf-title"><?php _e( 'Title', 'wpdx' );?></th>
								<th class="uf-options"><?php _e( 'Date', 'wpdx' );?></th>
								<th class="uf-views"><?php _e( 'Views', 'wpdx' );?></th>
							</tr>
						</thead>
						<tbody>
							<?php if(have_posts()) : ?>
								<?php while ( have_posts() ) : the_post(); ?>
									<tr>
										<td class="p-title">
											<a href="<?php the_permalink()?>" title="<?php the_title(); ?>">
												<?php if(cmp_get_option('author_archive_style') == 'small_thumb'): ?>
													<img src="<?php echo post_thumbnail_src(45,45); ?>" alt="<?php the_title(); ?>" width="45" height="45" />
												<?php endif; ?>
												<?php the_title(); ?>
											</a>
										</td>
										<td><span><i class="fa fa-clock-o fa-fw"></i><?php cmp_get_time();?></span></td>
										<td>
											<?php if(function_exists('the_views')) : ?>
												<span><i class="fa fa-eye fa-fw"></i><?php the_views(); ?></span>
												<?php elseif( function_exists('cmp_the_views')) : ?>
													<span><i class="fa fa-eye fa-fw"></i><?php cmp_the_views(); ?></span>
												<?php endif; ?>
											</td>
										</tr>
									<?php endwhile; ?>
									<?php else: ?>
										<?php $rand_posts = get_posts('numberposts=10&orderby=rand');  foreach( $rand_posts as $post ) : ?>
										<tr>
											<td class="p-title">
												<a href="<?php the_permalink()?>" title="<?php the_title(); ?>">
													<?php if(cmp_get_option('author_archive_style') == 'small_thumb'): ?>
														<img src="<?php echo post_thumbnail_src(45,45); ?>" alt="<?php the_title(); ?>" width="45" height="45" />
													<?php endif; ?>
													<?php the_title(); ?>
												</a>
											</td>
											<td><span><i class="fa fa-clock-o fa-fw"></i><?php cmp_get_time();?></span></td>
											<td>
												<?php if(function_exists('the_views')) : ?>
													<span><i class="fa fa-eye fa-fw"></i><?php the_views(); ?></span>
													<?php elseif( function_exists('cmp_the_views')) : ?>
														<span><i class="fa fa-eye fa-fw"></i><?php cmp_the_views(); ?></span>
													<?php endif; ?>
												</td>
											</tr>
										<?php endforeach; ?>
									<?php endif; ?>
								</tbody>
							</table>
							<?php if ($wp_query->max_num_pages > 1) cmp_pagenavi(); ?>
						</div>
					</div>
					<div class="clear"></div>
				</div>
			</div>
		</div>
		<?php get_template_part('includes/ad-bottom' );?>
	</div>
</div>
<?php get_footer(); ?>