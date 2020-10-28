 <?php 
 global $wpdb,$post;
 $set = _hui( 'left_set_s' );
 if(!$set && _hui('left_sd_s')) echo ('<h3>请在后台-主题设置-文章页设置-添加左边栏模块</h3>');
 if( _hui('left_sd_s')){
	$post_ID = get_the_ID();
    $type = get_post_meta($post_ID,'wppay_type',true);
	$price = get_post_meta($post_ID,'wppay_price',true);
	$user_id = is_user_logged_in() ? wp_get_current_user()->ID : 0;
	
	if(_hui('is_shoping')){
		$shop = new SHOP($post->ID, $user_id);
		if(!_hui('no_loginpay')){
			if($shop->is_paid()  || is_super_admin()){ 
				$pay = "<p>您已购买</p>";
				$btn='<a href="#pay" class="btn btn-primary">查看详情</a>';
			}else{
				if(is_singular()){
					$pay = "";
				    $btn='<a id="m-pay-loader" class="btn btn-primary" data-post="'.$post->ID.'" href="javascript:;"><i class="fa fa-credit-card-alt"></i> 立即购买</a>';
					
				}
			}
		}	
	}
	
	 ?>
<?php if(_hui('left_sd_s') && $set){ ?>
 <div class="leftsd"> 
  <div id="leftsd" class="left"> 
  <?php foreach ($set as $key => $value) { 
            if( _hui('single_tags') && $value['left_on']=='tag'){ 
			echo the_tags('<div class="introduce'.get_wow_3().'"><div class="product_tags"><h2><i class="fa fa-tags"></i> 热门标签</h2>',' , ','</div></div>');
			}else if($type>=1 && $price && _hui('is_shoping') && $value['left_on']=='shop'){  ?>
<div class="introduce<?php echo get_wow_3(); ?>">
<div class="product_wppay">
<div class="product_wppay_h3">
<h3>
<i class="fa fa-shopping-cart"></i> 本文包含付费资源
</h3>
</div>
<div class="product_wppay_price"><strong>￥<?php echo $price; ?></strong><?php echo $pay;?></div>
<div class="product_wppay_btn"><?php echo $btn; ?></div>
</div>
</div>
	<?php }elseif($value['left_on']=='author'){ ?>
	<div class="introduce<?php echo get_wow_3(); ?>">
			<div class="introduce_author">
 <?php echo _get_the_avatar(get_the_author_meta('ID'), get_the_author_meta('email'));?>
 <strong><?php echo'<a title="查看更多文章" href="'; echo get_author_posts_url(get_the_author_meta('ID'));echo'">'; echo get_the_author_meta('nickname');echo'</a>';?></strong>
 <p class="product_author_span">发表文章数：<span><?php echo num_of_author_posts(get_the_author_meta('ID')); ?></span></p>
 </div>
		</div>	
<?php }else if($value['left_on']=='list') { echo content_index(); } else ?>
   <?php if( $value['left_asb_s'] && $value['left_on']=='asb'){echo '<div class="textwidget'.get_wow_3().'">'.$value['left_asb_s'].'</div>';} ?>
   <?php } ?>
  </div>
  </div>
<?php }} ?>