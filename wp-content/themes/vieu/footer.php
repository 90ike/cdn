<?php  
	if( _hui('footer_brand_s') ){
		_moloader('mo_footer_brand', false);
	}
	global $post;
	$shop=get_post_meta($post->ID,'mall_push',true);

?>
<footer class="footer">
   <style>

   .copy-text {
    float: left;
    text-align: initial;
}
   </style>
	<div class="container">
        <div class="content-wrap">
        
            
         <?php if( _hui('flinks_s') && _hui('flinks_cat') && ((_hui('flinks_home_s')&&is_home()) || (!_hui('flinks_home_s')) ) ){ ?>
			<div class="flinks">
				<?php 
					wp_list_bookmarks(array(
						'category'         => _hui('flinks_cat'),
						'category_orderby' => 'slug',
						'category_order'   => 'ASC',
						'orderby'          => 'rating',
						'order'            => 'DESC',
						'show_description' => false,
						'between'          => '',
						'title_before'     => '<div class="footer-links">',
    					'title_after'      => '</div>',
						'category_before'  => '',
						'category_after'   => ''
					));
				?>
			</div>
		<?php } ?>
	<div class="footer-copyright">
     
                <div class="footer-ocpy">
                    <div class="copy-text">
					
					&copy; <?php echo date('Y'); ?> <a href="<?php echo home_url() ?>"><?php echo get_bloginfo('name') ?></a> 
					&nbsp; Theme by Vieu. &nbsp;本次查询请求：<?php echo get_num_queries(); ?> &nbsp;页面生成耗时： <?php timer_stop(1); ?>s  &nbsp;<?php echo _hui('footer_seo') ?> &nbsp; <?php echo _hui('trackcode');?>		</div>
                </div>
                <?php if( _hui('fcode') ){ ?><div class="footer-ocpy-right">
                 <?php echo _hui('fcode') ?></div><?php } ?>
            </div>
        </div>
    </div>
</footer>
<?php if(is_single() && $shop && _hui('is_shoping')){echo _moloader('mo_menubar_shop');}else{echo _moloader('mo_menubar');} echo _moloader('mo_tgimg'); ?>
<?php if(_hui('all_fonts')) { ?>
<style>
body{
font-family: xmlt,Microsoft Yahei; }
</style>
<?php } ?>
<?php if( is_single() && _hui('bigger-share_s')) { _moloader('mo_shareimg', false); }  ?>

<?php if( (is_single() && _hui('post_rewards_s')) && ( _hui('post_rewards_alipay') || _hui('post_rewards_wechat') ) ){ ?>
	<div class="rewards-popover-mask" data-event="rewards-close"></div>
	<div class="rewards-popover">
		<h3><?php echo _hui('post_rewards_title') ?></h3>
		<?php if( _hui('post_rewards_alipay') ){ ?>
		<div class="rewards-popover-item">
			<h4>支付宝扫一扫打赏</h4>
			<img src="<?php echo _hui_img('post_rewards_alipay') ?>">
		</div>
		<?php } ?>
		<?php if( _hui('post_rewards_wechat') ){ ?>
		<div class="rewards-popover-item">
			<h4>微信扫一扫打赏</h4>
			<img src="<?php echo _hui_img('post_rewards_wechat') ?>">
		</div>
		<?php } ?>
		<span class="rewards-popover-close" data-event="rewards-close"><i class="fa fa-close"></i></span>
	</div>
<?php } ?>
<?php 
     
     if(_hui('minicat_s')){ 
		if( _hui('minicat_home_s')  ){
				echo is_home()?_moloader('mo_minicat'):'';
				$minicat=is_home()?1:0;
		}else{
			_moloader('mo_minicat');
			$minicat=_hui('minicat_s')?1:0;
		}
}
	  
	$roll = '';
	if( is_home() && _hui('sideroll_index_s') ){
		$roll = _hui('sideroll_index');
	}else if( (is_category() || is_tag() || is_search()) && _hui('sideroll_list_s') ){
		$roll = _hui('sideroll_list');
	}else if( is_single() && _hui('sideroll_post_s') ){
		$roll = _hui('sideroll_post');
	}
	if( $roll ){
		$roll = json_encode(explode(' ', $roll));
	}else{
		$roll = json_encode(array());
	}
	
	if( _hui('sideroll_m_s') ){
		echo '<style>@media (max-width: 720px) {.sidebar {display: block;float: none;width: auto;margin: 10px;clear: both;}}</style>';
	}

	_moloader('mo_get_user_rp'); 
	$is_alpay = _hui('alpay') ? 1 : 0;
    $is_weixinpay = _hui('weixinpay') ? 1 : 0;
	?>
<!---底部均为重要文件，请勿修改，如修改损坏本站概不负责--->
<script>
window.jsui={
	www: '<?php echo home_url() ?>',
	uri: '<?php echo get_stylesheet_directory_uri() ?>',
	ver: '<?php echo THEME_VERSION ?>',
	roll: <?php echo $roll ?>,
	ajaxpager: '<?php echo _hui("ajaxpager") ?>',
	get_wow: '<?php echo _hui('the_wow_s')?1:0; ?>',
	url_rp: '<?php echo mo_get_user_rp() ?>',
	wintip_s: '<?php echo _hui('wintip_srollbar_s')?1:0; ?>',
	wintip_time: '<?php echo _hui('wintip_time') ?>',
	minicat_s: '<?php echo $minicat; ?>',
	minicat_time: '<?php echo _hui('minicat_time') ?>',
	collapse_title: '<?php echo _hui('collapse_title') ?>',
	wintip_m: '<?php echo _hui('wintip_m')?1:0; ?>',
    is_alpay: '<?php echo $is_alpay ?>',
    is_weixinpay: '<?php echo $is_weixinpay ?>',
	post_id: '<?php echo is_single()?get_the_ID():1;?>'
};
</script>
<?php if (_hui('lightbox_s') && is_single()) { ?>
<script>
  (function() {

	function setClickHandler(id, fn) {
	  document.getElementById(id).onclick = fn;
	}

	setClickHandler('image_container', function(e) {
	  e.target.tagName === 'IMG' && BigPicture({
		el: e.target,
		imgSrc: e.target.src.replace('_thumb', '')
	  });
	});

  })();
</script>
<?php } ?>

<script type="text/javascript">
var ajax_sign_object = <?php echo ajax_sign_object(); ?>;
</script>
<?php echo _hui('footcode');?>
<?php _moloader('mo_wintips', false);?>
<?php wp_footer(); ?>
</body>
</html>