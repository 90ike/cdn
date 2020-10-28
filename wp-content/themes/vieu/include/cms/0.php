

<?php 
	$i=0;
	while (have_posts()) : the_post();
	$i++;
?>
<?php if($i==1){ ?>
    
        <article class="excerpt cms0_excerpt<?php echo get_wow_1(); ?>">
   <a  class="focus" <?php echo _post_target_blank();?> href="<?php the_permalink(); ?>"><?php echo _get_post_thumbnail(400,300); ?></a>
  <div class="excerpt-post">
    <header>
      
      <h2><a <?php echo _post_target_blank();?> href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
      
    </header>
    <p class="note"><?php $contents = get_the_content(); $excerpt = wp_trim_words($contents,20);  echo $excerpt.new_excerpt_more('阅读全文');?></p>
    <p class="meta">
      <span class="pv">
        <i class="fa fa-eye"></i> <?php echo _get_post_views() ?></span>
      <span class="pc">
        <i class="fa fa-comments-o"></i> <?php echo _get_post_comments() ?></span>
      <span class="time">
        <i class="fa fa-clock-o"></i> <?php echo get_the_time('Y-m-d')?></span>
    </p>
  
  </div>
</article>
   
<?php }else{ ?>
   
        <li class="excerpt_cms0 cms-title<?php echo get_wow_1(); ?>">
            
                <strong>[<?php echo get_the_time('Y-m-d'); ?>]</strong>
                   
                    <a <?php echo _post_target_blank();?> href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
                
            
        </li>

<?php } ?>
<?php endwhile;?>

