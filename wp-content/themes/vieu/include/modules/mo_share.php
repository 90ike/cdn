<?php
/**
 * [mo_share description]
 * @param  string $stop [description]
 * @return html       [description]
 */
 

 
function mo_share($stop=''){
	 $qzone='https://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url=';
	 $weibo='http://service.weibo.com/share/share.php?title=';
	 $qq='http://connect.qq.com/widget/shareqq/index.html?url=';
	 $qrcode=get_stylesheet_directory_uri().'/action/qrcode.php?text=';
    if( _hui('share_s') ){
        echo ' 
		<div class="xshare">
        <span class="xshare-title">分享到：</span>
        <a href="javascript:;"  class="share-weixin"><i class="fa fa-weixin"></i>
		<span class="share-popover">
		<span class="share-popover-inner" id="weixin-qrcode">
		<img src="'.$qrcode.get_permalink().'" modal="zoomImg"  data-tag="bdshare">
		</span></span></a>
		<a target="_blank" href="'.$qzone,get_permalink().'&title='.get_the_title().'&desc=&summary='._get_excerpt().'&site=zeshlife&pics='.get_post_img_url(true).'" 
		class="share-qzone"><i class="fa fa-qzone"></i></a>
		<a target="_blank" href="'.$weibo,get_the_title().'&url='.get_permalink().'&source='._get_excerpt().'&pic='.get_post_img_url(true).'" class="share-weibo"><i class="fa fa-weibo"></i></a>
		<a target="_blank" href="'.$qq,get_permalink().'&desc='._get_excerpt().'&summary='.get_the_title().'&site=zeshlife&pics='.get_post_img_url(true).'" class="share-qq"><i class="fa fa-qq"></i></a>
		</div>';

}

  return;
}
 
 
?>