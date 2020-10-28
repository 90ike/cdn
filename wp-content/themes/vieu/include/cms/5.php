<?php 
	$i=0;
	while (have_posts()) : the_post();
	$r = fmod($i,2)+1;$i++;
	if($r==1)$cls='left';else $cls='right';
?>
<div class="cms_<?php echo $cls; ?>">
	 <article class="excerpt_cms5<?php echo get_wow_1(); ?>">
                   
                          <a class="focus"  <?php echo _post_target_blank();?> href="<?php the_permalink(); ?>"><?php echo _get_post_thumbnail(); ?></a>
					
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
				
				
				
				
</div>
<?php endwhile;?>
