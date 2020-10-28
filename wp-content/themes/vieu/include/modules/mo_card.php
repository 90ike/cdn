
<?php 
	$i=0;
	while (have_posts()&&$i<8) : the_post();
	$r = fmod($i,3)+1;$i++;
?>
    <article class="excerpt-page excerpt-c4<?php echo get_wow_1(); ?>">
					<a class="thumbnail" <?php echo _post_target_blank();?> href="<?php the_permalink(); ?>"><?php echo _get_post_thumbnail(); ?></a>
					<h2><a <?php echo _post_target_blank();?> href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
					<footer>
					<strong><i class="fa fa-clock-o"></i>  <?php echo get_the_time('Y-m-d'); ?></strong>
					<strong><?php  echo '<a class="pc" href="'.get_comments_link().'"><i class="fa fa-comments-o"></i> 评论('.get_comments_number('0', '1', '%').')</a>';?></strong>
					<p class="like">
                     <?php if( _hui('post_plugin_like') ){ echo hui_get_post_like($class='post-like');} ?></p>
					</footer></article>
<?php endwhile;?>