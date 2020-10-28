<?php
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
	  
	  ?>
	  <style>.sidebar{top:50px;}@media(max-width:720px) {<?php $banner_style = _hui('banner_style'); echo $banner_style=='qiye' && _hui('focusslide_s')?'body{top: 48px !important;}':'';?>}</style>
<section class="article-focusbox bgimg-fixed" id="focsbox-true" style="background-image: url(<?php echo singele_background();?>)">
<?php _moloader('mo_post_prevnext'); ?>
</section>
   <section class="container container-single">
<div class="nav<?php echo get_wow_1(); ?>">
		<div class="nav-content">

			<header class="article-header">
        <h1 class="article-title">
		<?php if(_hui('shoucang_s')){ if(get_current_user_id() && in_array($user,$meta)){
			echo '<style>.shoucang:after {content: "\53d6\6d88\6536\85cf";}.shoucang:hover {width: 100px;}.shoucang:hover span {padding-right: 70px;}</style>';
		}?>
		
		<a class="shoucang<?php if(get_current_user_id() && in_array($user,$meta)){echo ' on';}?>" data-id="<?php the_ID();?>" href="javascript:;">
            <span><i class="fa <?php echo get_current_user_id() && in_array($user,$meta)?'fa-star':'fa-star-o';?>"></i> </span>
		</a><?php } ?>
       <?php echo the_title(); echo get_the_subtitle();?></h1>
        <div class="article-meta">
            <span class="item"><i class="fa fa-clock-o"></i> <?php echo tb_xzh_is_original() ? get_the_time('Y-m-d H:i:s') : get_the_time('Y-m-d'); ?></span>
			<?php if ( comments_open() && _hui('post_plugin_comm') ) { ?>
			<span class="item"><a class="pc" href="javascript:(scrollTo('#comments',-15));"><i class="fa fa-comments-o"></i> 评论：<?php echo get_comments_number('0', '1', '%'); ?></a></span>
            <?php } if( _hui('post_plugin_view') ){ ?><span class="item"><?php echo _get_post_views() ?></span><?php } ?>
            <span class="item"><?php echo '分类：';the_category(' / '); ?></span>
            <?php if(_hui('baidu_shoulu_s')){ ?><span class="item item-4"><?php echo baidu_shoulu();?></span><?php } ?>
            <span class="item"><?php edit_post_link('[编辑]'); ?></span>
        </div>
    </header>
	
	<?php if(_hui('singele_avatar_s')) { ?>
	<style>.container-single .nav-content{padding: 30px 315px 30px 30px;}</style>
	<div class="button-header"> 
	
	<div class="product_author" style="background-image: url(<?php echo _hui_img('singele_avatar_bg');?>);">
 <?php echo _get_the_avatar(get_the_author_meta('ID'), get_the_author_meta('email'));?>
 <strong><?php echo'作者：<a title="查看更多文章" href="'; echo get_author_posts_url(get_the_author_meta('ID'));echo'">'; echo get_the_author_meta('nickname');echo'</a>';?>
 <span class="product_author_span">发表文章数：<?php echo num_of_author_posts(get_the_author_meta('ID')); ?></span></strong>
 </div>
 <div class="product_social">
<ul class="social-menu">
            <?php  if(_hui('wechat')){ echo '<li> <a class="sns-wechat" href="javascript:;" title="'.__('关注', 'haoui').'“'._hui('wechat').'”" data-src="'._hui_img('wechat_qr').'"><i class="fa fa-weixin"></i></a></li>'; } ?>
			 <?php  if(_hui('weibo')){ echo ' <li><a target="_blank" nofollow" href="'._hui('weibo').'"><i class="fa fa-weibo"></i></a></li>'; } ?>
			 <?php  if(_hui('qq')){ echo ' <li><a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin='._hui('qq').'&site=qq&menu=yes"><i class="fa fa-qq"></i></a></li>'; } ?>
			 <?php if(( is_single() && _hui('bigger-share_s')) || ($tuiguang_price>0 && _hui('tuiguang_s'))) {echo '<li>'. $wpaytg .'</li>';}?>

</ul><?php
$shoucang1 = explode(',',get_post_meta(get_the_ID(),'shoucang',true));
$shoucang = array_filter($shoucang1);
$user = get_current_user_id();
?>

</div>
 
 </div>
 
	<?php } ?>
		</div>
	</div>
	</section>