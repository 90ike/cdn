<style>.article-header {
    padding-top: 40px;
}.single-content{margin-top:20px;}.leftsd .left{margin-top:20px;top:0;}.article-meta,.article-meta .item a{color:#f2f2f2}@media (max-width: 720px){<?php $banner_style = _hui('banner_style'); echo $banner_style=='qiye' && _hui('focusslide_s')?'body{top: 48px !important;}':'';?>}</style>
<?php  $meta = get_post_meta($id,'shoucang',false);
    $user = get_current_user_id(); ?>
<section class="article-focusbox bgimg-fixed" id="focsbox-true" style="background-image: url(<?php echo singele_background();?>)">
       <header class="article-header">
        <h1 class="article-title"><?php if(_hui('shoucang_s')){ if(get_current_user_id() && in_array($user,$meta)){
			echo '<style>.shoucang:after {content: "\53d6\6d88\6536\85cf";}.shoucang:hover {width: 100px;}.shoucang:hover span {padding-right: 70px;}</style>';
		}?>
		
		<a class="shoucang<?php if(get_current_user_id() && in_array($user,$meta)){echo ' on';}?>" data-id="<?php the_ID();?>" href="javascript:;">
            <span><i class="fa <?php echo get_current_user_id() && in_array($user,$meta)?'fa-star':'fa-star-o';?>"></i> </span>
		</a><?php } ?><?php echo the_title(); echo get_the_subtitle();?></h1>
         <div class="article-meta">
            <span class="item"><i class="fa fa-clock-o"></i> <?php echo tb_xzh_is_original() ? get_the_time('Y-m-d H:i:s') : get_the_time('Y-m-d'); ?></span>
			<?php if( _hui('post_plugin_view') ){ ?><span class="item"><?php echo _get_post_views() ?></span><?php } ?>
            <span class="item"><?php echo '分类：';the_category(' / '); ?></span>
            <?php if(_hui('baidu_shoulu_s')){ ?><span class="item item-4"><?php echo baidu_shoulu();?></span><?php } ?>
            <span class="item"><?php edit_post_link('[编辑]'); ?></span>
        </div>
    </header>
	<?php _moloader('mo_post_prevnext'); ?>
</section>