<?php 

while (have_posts()) : the_post();
   
if(_hui('is_shoping')){ 
   $meta = get_post_meta($id,'shoucang',false);
    $user = get_current_user_id();
	$user_id = is_user_logged_in() ? wp_get_current_user()->ID : 0;
	$tuiguang_price = get_post_meta($id,'tuiguang_price',true);
	$tuiguang_pays = get_post_meta($id,'tuiguang_pays',true);
	$type = get_post_meta($id,'wppay_type',true);
	$price = get_post_meta($id,'wppay_price',true);
    $llogin=!_hui('no_loginpay') && !is_user_logged_in()?' user-login':' tuiguang-haibao'; 
	$wpayb='<a class="'.$llogin.' btn btn-primary" data-id="'.$id.'" href="javascript:;"><i class="fa fa-share-alt"></i> 生成专属海报赚'.$tuiguang_price.'元</a>';
	$shop = new SHOP($id, $user_id);
	$wpaytg = '<a class="product_haibao btn btn-primary"><i class="fa fa-qrcode"></i> 生成海报</a>';
	if($price && $type != '7' && $shop->is_paid() && $tuiguang_price>0 && $tuiguang_pays && _hui('tuiguang_s')){
			$wpaytg=$wpayb;
		}else{
			if(is_singular()){
				if($tuiguang_price>0  && !$tuiguang_pays && _hui('tuiguang_s')){//如果开启分销
			  $wpaytg=$wpayb;
		    }
		}
	}
}

?>
<style>.header{background-color: transparent;}@media (max-width: 720px){.container-single .nav-content{padding: 0;}.header{background-color: #2C3747;}}</style>
	
<?php if(_hui('single_header') == 'bottombg'){
	require_once('single/bottombg.php');
	
   }elseif(_hui('single_header') == 'topbg'){
	   require_once('single/topbg.php');
	
  } ?>
<section class="container">
	<div class="content-wrap">	
	
	
	<?php _moloader('mo_left_sidebar', false); 
    if( _hui('left_sd_s')){
		echo'<div class="single-content'.get_wow_1().'">';
		}else{
			echo'<div class="single-content'.get_wow_1().'" style="margin-left: 0;">';
			}?>
			
		<?php if(_hui('breadcrumbs_s')){ ?>
        <div class="smhb">
          <?php echo get_breadcrumb(); ?>
        </div>
		<?php } ?>
		<?php tb_xzh_render_body() ?>
		<article class="article-content"<?php if(_hui('lightbox_s')){ echo ' id="image_container"';} ?>>
		<?php if($tuiguang_price>0 && $tuiguang_pays && _hui('tuiguang_s')){ ?>
	     <div class="alert alert-info alert-dismissible tg-info" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>本文已参加分销赚钱活动</strong> 购买后可生成自己的专属海报，每邀请一位购买赚<b><?php echo $tuiguang_price;?></b>元佣金！
	        </div><?php } ?>
			<div class="<?php echo get_wow_2(); ?>"><?php _the_ads($name='ads_post_01', $class='asb-post asb-post-01') ?></div>
			<?php if(has_excerpt() && _hui('breadcrumbs_zhaiyao_s')){ ?>
			<div class="article-zhaiyao <?php echo get_wow_4(); ?>"><strong>摘要：</strong><?php echo _get_excerpt(); ?></div>
			<?php } ?>
			<?php if(_hui('is_shoping')){ shop_paid_content_show();}?>
			<?php the_content(); ?>		
			<?php wp_link_pages('link_before=<span>&link_after=</span>&before=<div class="article-paging">&after=</div>&next_or_number=number'); ?>
			<?php if (_hui('ads_post_footer_s')) {
			echo '<div class="asb-post-footer '.get_wow_2().'"><b>AD：</b><strong>【' . _hui('ads_post_footer_pretitle') . '】</strong><a'.(_hui('ads_post_footer_link_blank')?' target="_blank"':'').' href="' . _hui('ads_post_footer_link') . '">' . _hui('ads_post_footer_title') . '</a></div>';
		} ?>
                   
		<?php if( !wp_is_mobile() || (!_hui('m_post_share_s') && wp_is_mobile()) ){ ?>
			
		<?php } ?>
		 <?php if( _hui('single_tags')){echo the_tags('<div class="single_tags">标签：','','</div>');} ?>
		<?php if( _hui('post_copyright_s') ){
			echo '<div class="iash'.get_wow_2().'"><p><b>' . _hui('post_copyright') . '</b>作者:<a title="查看更多文章" href="'. get_author_posts_url(get_the_author_meta('ID')) .'">'.get_the_author_meta('nickname').'</a>，
			转载或复制请以 <a href="' . get_permalink() . '"> 超链接形式</a> 并注明出处 <a href="' . get_bloginfo('url') . '">' . get_bloginfo('name') . '</a>。<br>
			原文地址：<a href="' . get_permalink() . '" title="' . get_permalink() . '">《' . get_the_title() . '》</a>  发布于'.get_the_time('Y-m-d').'</p></div>';
		} ?><div class="article-actions"><?php _moloader('mo_share'); 
		$link = get_post_meta(get_the_ID(), 'link', true);
		if( _hui('post_like_s') || _hui('post_rewards_s') || (_hui('post_link_single_s')&&$link) ){ echo'<div class="post-actions">';
            	 if( _hui('post_like_s') ){ 
				 echo hui_get_post_like($class='post-like action action-like btn btn-danger'); 
				 } 
				 if( _hui('post_rewards_s') ){ echo'<a href="javascript:;" class="action action-rewards btn btn-danger" data-event="rewards"><i class="fa fa-jpy"></i> '. _hui('post_rewards_text').'</a>';}
				if( _hui('bigger-share_s')) {echo $wpaytg;}
           echo' </div>
		';
	
    }?></div>
		</article>

		
		<?php endwhile; ?>		
		        <?php if( _hui('post_prevnext_s') ){ ?>
            <nav class="article-nav<?php echo get_wow_2(); ?>">
                <span class="article-nav-prev"><?php previous_post_link('上一篇<br>%link'); ?></span>
                <span class="article-nav-next"><?php next_post_link('下一篇<br>%link'); ?></span>
            </nav>
        <?php } ?>
  
		<?php _the_ads($name='ads_post_02', $class='asb-post asb-post-02') ?>
		<?php 
			if( _hui('post_related_s') ){
				_moloader('mo_posts_related', false); 
				mo_posts_related(_hui('related_title'), _hui('post_related_n'));
			}
		?>
		<?php tb_xzh_render_tail() ?>
		<?php _the_ads($name='ads_post_03', $class='asb-post asb-post-03') ?>
		<?php comments_template('', true); ?>
	</div>
	</div>
	<?php 
		if( has_post_format( 'aside' )){

		}else{
			get_sidebar();
		} 
	?>
</section>
<?php if(_hui('left_sd_s')){ ?>
	 <script type="text/javascript">
	 var leftsd=document.getElementById("leftsd");    
    var H=0,iE6;    
    var Y=leftsd;    
    while(Y){H+=Y.offsetTop;Y=Y.offsetParent};    
    iE6=window.ActiveXObject&&!window.XMLHttpRequest;    
    if(!iE6){    
        window.onscroll=function()    
        {    
            var s=document.body.scrollTop||document.documentElement.scrollTop;   

            if(s>(H-84)){
			leftsd.className="left affix";
			if(iE6){leftsd.style.top=(s-H)+"px";} } else{	leftsd.className="left";    
        }    
    }    
	}
	 </script>
<?php } ?>