<?php 
	$i=0;
	while (have_posts()) : the_post();
	$i++;
?>
<?php if($i==1){ ?>
   <div class="cms_right">
        <article class="excerpt_cms2<?php echo get_wow_1(); ?>">
            <div class="cms-thumb">
                <a <?php echo _post_target_blank();?> href="<?php the_permalink(); ?>"><?php echo _get_post_thumbnail(400,300); ?></a>
            </div>
            <div class="cms-detail">
                <h3 class="cms-title">
                    <a <?php echo _post_target_blank();?> href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a> 
                </h3>
                <div class="cms-meta">
                    <span class="datetime text-muted"><i class="fa fa-clock-o"></i><?php echo get_the_time('Y-m-d')?></span>
                    <span class="views-count text-muted"><i class="fa fa-eye"></i><?php echo _get_post_views() ?></span>
                    <span class="comments-count text-muted"><i class="fa fa-comments"></i><?php echo _get_post_comments() ?></span>
                </div>
                <p class="cms-excerpt"><?php $contents = get_the_content(); $excerpt = wp_trim_words($contents,120);  echo $excerpt.new_excerpt_more('阅读全文');?></p>
				 <?php if( _hui('single_tags')){echo the_tags('<div class="single_tags">标签：','','</div>');} ?>
            </div>
        </article>    <?php $module_catcms = _hui( 'catcms' ); foreach ($module_catcms as $key => $value) { ?> <?php echo $value['bar_3_asb']? '<div class="cms-asb'. get_wow_1() .'">'.$value['bar_3_asb'] .'</div>' :''; ?><?php } ?>	
   </div>
<?php }else{ ?>
<?php if($i==2){echo '<div class="cms_left"> ';} ?>    


              <article class="excerpt_cms1<?php echo get_wow_1(); ?>">
                   
                          <a class="focus" <?php echo _post_target_blank();?> href="<?php the_permalink(); ?>"><?php echo _get_post_thumbnail(); ?></a>
					
                    <div class="cmstop-detail">
                        <h3 class="cmstop-title">
                            <a <?php echo _post_target_blank();?> href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
                        </h3>
						<p class="cmstop-excerpt"><?php $contents = get_the_content(); $excerpt = wp_trim_words($contents,35);  echo $excerpt.new_excerpt_more('阅读全文');?></p>
                        <div class="cmstop-meta">
                            <span class="datetime text-muted"><i class="fa fa-clock-o"></i> <?php echo get_the_time('Y-m-d')?></span>

                            <?php if ( comments_open()) {?>
                            <span class="comments-count text-muted"><i class="fa fa-comments"></i> 评论<?php echo get_comments_number('0', '1', '%') ?></span>
					        <?php }?>
                        </div>
                    </div>
                </article>

<?php } ?>
<?php endwhile;?>
<?php if($i>1) echo '</div>'; ?>