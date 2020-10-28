 <?php global $wppay_table_name,$post;
 $post_id = $post->ID;
 if(_hui('mall_item_brand')){ ?>
        <div class="theme-item-brand">
            	<?php

	foreach ($options_categories_obj as $category) {
		$options_categories[$category->cat_ID] = $category->cat_name;
	}
	
	$category_id=$options_categories;
    $args = array(
	   'post__not_in'=> array($post_id),
        'post_type' => 'post', 
        'showposts' => 2,
		'orderby' => 'rand',	
        		
        'tax_query' => array(
            array(
                'taxonomy' => 'mall',
                'terms' => $category_id
                ),
            )
        );
		
    $my_query = new WP_Query($args);
   
        while ($my_query->have_posts()) : $my_query->the_post();
		$list = $wpdb->get_results("SELECT * FROM $wppay_table_name WHERE post_id=$id AND status=1");
		query_posts($args);
		$terms = get_the_terms( '', 'mall' );
	    $price = get_post_meta($id,'wppay_price',true);
		$prices=$price?$price:'暂无报价';
	    
	    $shop = new SHOP($id, $user_id);
			if($shop->is_paid()){ 
				$prices = "已购买";
			}
	
		
	?>
	
	<div class="theme-item-brand-asb<?php echo get_wow_3(); ?>">

     <a  class="focus" <?php echo _post_target_blank();?> href="<?php the_permalink(); ?>"><?php echo _get_post_thumbnail(400,300); ?></a>
  <div class="excerpt-mall-head">
  <p style="overflow: hidden;text-overflow:ellipsis;white-space:nowrap;padding: 8px 5px 2px;"><a <?php echo _post_target_blank();?> href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></p>
    <p style="color: #ff4641;padding:2px 0px;">￥<?php echo $prices;?></p>
      <p style="padding: 2px 0;">
        <i class="fa fa-shopping-cart"></i> <?php   echo '销量：' .count($list); ?></p>
  </div>
</div>  
        <?php   endwhile;    ?>
<?php wp_reset_query(); ?>	
			
		
        </div>
	   <?php }else{ ?>
	   <style>.theme-item-fcontent { width: 62%;}</style>
	   <?php } ?>