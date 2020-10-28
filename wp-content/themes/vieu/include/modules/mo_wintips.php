<?php global $post;
      $shop=get_post_meta($post->ID,'mall_push',true);?>
	<div class="survey-container">
	<div class="survey-body">
        <div class="survey-content">
            <div class="survey-title">
                <span><?php echo _hui("wintip_title") ?></span>
                <img src="<?php echo _hui_img("wintip_img") ?>">
            </div>
            <div class="survey-description">
              <?php echo _hui("wintip_asb") ?>
         </div>
            <div class="survey-action">
                <a href="<?php echo _hui("wintip_url") ?>" <?php if (_hui("wintip_blank")){echo 'target="_blank"';} ?> class="btn btn-primary btn-wintips">
	<?php echo _hui("wintip_button") ?></a>
            </div>
        </div>
        <div class="survey-content-green"></div>
    </div>
	
	    <div class="rollbar"><ul>
		<?php if( is_single() && !$shop ){ ?><li class="faded"><a href="javascript:(scrollTo('#comments',-15));"><i class="fa fa-comments"></i></a><h6>去评论<i></i></h6></li><?php } ?>
		 <?php if(_hui('fweixin_s')){ ?> <li class="faded"><a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo _hui('fqq_s') ? _hui('fqq_id') : '' ?>&site=qq&menu=yes"><i class="fa fa-weixin"></i></a>
		 <div class="fweixin_s"><h4><?php echo _hui('fweixin_tip'); ?><i></i></h4><img src="<?php echo _hui_img('fweixin_src'); ?>"></div></li><?php } ?>
   <?php if(_hui('fqq_s')){ ?> <li class="faded"><a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo _hui('fqq_s') ? _hui('fqq_id') : '' ?>&site=qq&menu=yes"><i class="fa fa-qq"></i></a><h6><?php echo _hui('fqq_s') ? _hui('fqq_tip') : '' ?><i></i></h6></li><?php } ?>
    <li class="faded"><a href="javascript:(scrollTo());"><i class="fa fa-angle-up"></i></a><h6>去顶部<i></i></h6></li>
    </ul></div>
	<?php if(_hui('wintip_srollbar_s')){ ?><button class="btn-survey"><i class="fa fa-rocket"></i></button><?php } ?>
	</div>