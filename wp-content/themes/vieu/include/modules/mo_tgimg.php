<?php global $post;
$user_id = is_user_logged_in() ? wp_get_current_user()->ID : 0;
	$tuiguang_price = get_post_meta($post->ID,'tuiguang_price',true);
	if($tuiguang_price>0 && _hui('tuiguang_s') && is_single()){ //如果开启分销和仅购买后推广	?>

<div class="modal-dialog-haibao" style="display: none;">
            <div class="tg-img"><img id="tg-img" src="<?php echo get_stylesheet_directory_uri() ?>/static/img/imgload.gif"></div>
         
          <div class="modal-footer-haibao">
		  
           <p>保存图片或复制链接，发给好友或分享</p>
		    <p>每邀请1位用户购买，您也可以获得<b><?php echo $tuiguang_price; ?></b>元的佣金</p>
			<p>推广链接：<span id="copy-tuiguang"><?php echo get_permalink().'?uid='.$user_id;?></span> <a id="copy-tg" onclick="copy();"><i class="fa fa-clipboard"></i> 复制</a></p>
          </div>
        </div><!-- /.modal-content -->
	<?php } ?>