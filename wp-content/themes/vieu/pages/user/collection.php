<?php

  
    

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$args=array(
'meta_value' =>  get_current_user_id(),
'meta_key' => 'shoucang',
'showposts' => 12,
'paged' => $paged,
);

?>
<div class="masonry">
<?php  query_posts($args);  while (have_posts()) : the_post(); 
 $meta = get_post_meta($id,'shoucang',false);
    $user = get_current_user_id();
    if(in_array($user,$meta)){ 

?>
<div class="shoucang-card">
                           <a class="thumbnail" <?php echo _post_target_blank();?> href="<?php the_permalink(); ?>"><?php echo _get_post_thumbnail(); ?></a>
                            <div class="card-block text-center">
                                
                                <h3><a <?php echo _post_target_blank();?> href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
                                <a class="shoucang-list btn btn-primary btn-md btn-rounded" data-id="<?php the_ID();?>" href="javascript:;">取消收藏</a>
                               
                                <div class="row">
								
                                    <div class="col-lg-4 col-md-4 m-t-20">
                                        <h4 class="m-b-0 font-light"><?php echo get_the_time('Y-m-d'); ?></h4><small><i class="fa fa-clock-o"></i></small></div>
                                    <div class="col-lg-4 col-md-4 m-t-20">
                                        <h4 class="m-b-0 font-light"><?php  echo '<a class="pc" href="'.get_comments_link().'"> 评论：'.get_comments_number('0', '1', '%').'</a>';?></h4><small><i class="fa fa-comments-o"></i></small></div>
                                    <div class="col-lg-4 col-md-4 m-t-20">
                                        <h4 class="m-b-0 font-light"><?php echo _get_post_views() ?></h4><small><i class="fa fa-eye"></i></small></div>
                                </div>
                            </div>
                        </div>

	<?php } endwhile;  ?>
 </div>
<?php _moloader('mo_paging');
 wp_reset_query();


 ?>
