<?php
/*
Plugin Name: Baidu Xiongzhang
Plugin URI: https://www.wpdaxue.com/
Description: Baidu Xiongzhang plugin
Author: Changmeng Hu
Version: 1.1.1
Author URI: ttps://www.wpdaxue.com
*/

function cmp_baidu_xiongzhang_js(){
    if(!cmp_get_option('baidu_xiongzhang_appid') || cmp_get_option('baidu_xiongzhang_appid') == '') return;
    $appid = trim(cmp_get_option('baidu_xiongzhang_appid'));
    if( is_single() || is_singular("download")){
        if(get_post_meta(get_the_ID(), "_cmp_seo_title", true)){
            $title = strip_tags(trim(get_post_meta(get_the_ID(), "_cmp_seo_title", true)));
        }else{
            $title = strip_tags(get_the_title());
        }
        
        echo '<script src="//msite.baidu.com/sdk/c.js?appid='.$appid.'"></script>';
        echo '<script type="application/ld+json">{
            "@context": "https://ziyuan.baidu.com/contexts/cambrian.jsonld",
            "@id": "'.get_the_permalink().'",
            "appid": "'.$appid.'",
            "title": "'.$title.'",
            "images": ["'.cmp_get_post_imgs().'"],
            "description": "'.cmp_get_excerpt().'",
            "pubDate": "'.get_the_time('Y-m-d\TH:i:s').'"}</script>';

    }
}
add_action('wp_head', 'cmp_baidu_xiongzhang_js',999);

/**
* 主动推送到百度
*/
if(!function_exists('cmp_baidu_submit')){
    function cmp_baidu_submit($post_ID) {
        //没有填写百度熊掌号ID和Token将不执行
        if(!cmp_get_option('baidu_xiongzhang_appid') || cmp_get_option('baidu_xiongzhang_appid') == '' || !cmp_get_option('baidu_xiongzhang_token') || cmp_get_option('baidu_xiongzhang_token') =='') return;
        //已成功推送的文章不再推送
        if( empty($post_ID) || get_post_meta($post_ID,'Baidusubmit',true) == 1) return;
        $appid = trim(cmp_get_option('baidu_xiongzhang_appid'));
        $token = trim(cmp_get_option('baidu_xiongzhang_token'));

        $url = get_permalink($post_ID);
        $api = 'http://data.zz.baidu.com/urls?appid='.$appid.'&token='.$token.'&type=realtime';
        // $request = new WP_Http;
        // $result = $request->request( $api , array( 'method' => 'POST', 'body' => $url , 'headers' => 'Content-Type: text/plain') );
        // $result = json_decode($result['body'],true);
        $ch  = curl_init();
        $options =  array(
            CURLOPT_URL => $api,
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => $url,
            CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
        );
        curl_setopt_array($ch, $options);
        $result = json_decode(curl_exec($ch),true);
        
        //如果推送成功则在文章新增自定义栏目Baidusubmit，值为1
        if (array_key_exists('success',$result)) {
            add_post_meta($post_ID, 'Baidusubmit', 1, true);
        }
    }
    add_action('publish_post', 'cmp_baidu_submit', 9);
    if(class_exists('Easy_Digital_Downloads')){
        add_action('publish_download', 'cmp_baidu_submit', 9);
    }
}
/**
 * 在文章内容底部添加百度熊掌号关注
 * @return [type] [description]
 */
function cmp_add_baidu_xiongzhang_follow(){
    //没有填写百度熊掌号ID将不执行
    if(!cmp_get_option('baidu_xiongzhang_appid') || cmp_get_option('baidu_xiongzhang_appid') == '') return;
    if(cmp_get_option('baidu_xiongzhang_follow') && cmp_get_option('baidu_xiongzhang_follow') !== 'none'){
        if(cmp_get_option('baidu_xiongzhang_follow') == 'body') echo '<div class="baidu-xiongzhang">';
        echo '<script>cambrian.render("'.cmp_get_option('baidu_xiongzhang_follow').'")</script>';
        if(cmp_get_option('baidu_xiongzhang_follow') == 'body') echo '</div>';
    }
}
add_action('single_content_bottom','cmp_add_baidu_xiongzhang_follow');
/**
 * 获取文章摘要
 * @param  integer $len [description]
 * @return [type]       [description]
 */
function cmp_get_excerpt($len=220){
    if ( is_single() || is_singular("download") ){
        global $post;
        if(get_post_meta($post->ID, "_cmp_seo_description", true)){
            $excerpt = strip_tags(trim(get_post_meta($post->ID, "_cmp_seo_description", true)));
        } elseif ($post->post_excerpt) {
            $excerpt  = $post->post_excerpt;
        } else {
            if(preg_match('/<p>(.*)<\/p>/iU',trim(strip_tags($post->post_content,"<p>")),$result)){
                $post_content = $result['1'];
            } else {
                $post_content_r = explode("\n",trim(strip_tags($post->post_content)));
                $post_content = $post_content_r['0'];
            }
            $excerpt = preg_replace('#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,0}'.'((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$len.'}).*#s','$1',$post_content);
        }
        return str_replace(array("\r\n", "\r", "\n"), "", $excerpt);
    }
}
/**
 * 获取文章图片
 * @return [type] [description]
 */
function cmp_get_post_imgs(){
    global $post;
    $src = '';
    $content = $post->post_content;  
    preg_match_all('/<img .*?src=[\"|\'](.+?)[\"|\'].*?>/', $content, $strResult, PREG_PATTERN_ORDER);  
    $n = count($strResult[1]);  
    if($n >= 3){
        $src = $strResult[1][0].'","'.$strResult[1][1].'","'.$strResult[1][2];
    }elseif($n >= 1){
        $src = $strResult[1][0];
    }else{
        if(has_post_thumbnail()){
            $src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'full');
            $src = $src[0];
        } 
    }
    return $src;
}

