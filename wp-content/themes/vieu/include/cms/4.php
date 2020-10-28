<?php 
	$i=0;
	while (have_posts()) : the_post();
	$i++;
?>
<?php if($i<4){ ?>

    <article class="excerpt_cms4<?php echo get_wow_1(); ?>">
            <div class="cms-thumb">
                <a <?php echo _post_target_blank();?> href="<?php the_permalink(); ?>"><?php echo _get_post_thumbnail(); ?></a>
            </div>
            <div class="cms-detail">
                <h3 class="cms-title">
                    <a <?php echo _post_target_blank();?> href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a> 
                </h3>
                <div class="cms-meta">
                    <span class="datetime text-muted"><i class="fa fa-clock-o"></i><?php echo get_the_time('Y-m-d')?></span>
                    <span class="views-count text-muted"><i class="fa fa-eye"></i><?php echo _get_post_views() ?></span>
                  
                </div>
                <p class="cms-excerpt"><?php $contents = get_the_content(); $excerpt = wp_trim_words($contents,80);  echo $excerpt.new_excerpt_more('阅读全文');?></p>
            </div>
    </article>

<?php }else{ ?>
<article class="excerpt_cms4_list<?php echo get_wow_1(); ?>">

	<div class="cms-detail">
		<h3>
			<a <?php echo _post_target_blank();?> href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
		</h3>
		<p class="cms-excerpt"><?php $contents = get_the_content(); $excerpt = wp_trim_words($contents,20);  echo $excerpt.new_excerpt_more('阅读全文');?></p>
		 <div class="cms-meta">
                    <span class="datetime text-muted"><i class="fa fa-clock-o"></i><?php echo get_the_time('Y-m-d')?></span>
                    <span class="views-count text-muted"><i class="fa fa-eye"></i><?php echo _get_post_views() ?></span>
                  
                </div>
	</div>
</article>
<?php } ?>
<?php endwhile;?>