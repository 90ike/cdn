<?php
header("Content-type:text/html;character=utf-8");
ob_start();
require_once dirname(__FILE__) . "/../../../../wp-load.php";
ob_end_clean();
ini_set('display_errors', 'Off');
ini_set('error_reporting', E_ALL);
global $wpdb, $wppay_table_name;
_moloader('mo_get_user_reg', false) ;
_moloader('mo_get_user_login', false) ;
$url = mo_get_user_login();
$postId = isset($_GET['pid']) ? $_GET['pid'] : 0;
if (is_user_logged_in()) {


// 用户已经登录 并且是会员 满足下载次数限制要求 下载次数非常严格 切勿重复点击

    $user_id  = get_current_user_id();
    $vip_type = vip_type($user_id);
    $sql_ispay = $wpdb->get_var($wpdb->prepare("SELECT id FROM {$wppay_table_name} WHERE   post_id = %d AND status = 1  AND user_id = %d", $postId, $user_id));
    if ($vip_type > 0 && empty($sql_ispay)) {
		if (isset($_COOKIE['unlock_down_time'])) {
	
	exit("<script language='javascript'>alert('您的下载太频繁，请一分钟后再试。切勿重复短时间内下载相同资源，以免被扣除下载次数！');window.location.replace(document.referrer);</script>");
   
} else {
    $endtime = 60; // 发送一个 60秒过期的 cookie
    setcookie("unlock_down_time", time(), time() + $endtime);
}
		
        // 满足下载限制
        $this_vip_downum = this_vip_downum($user_id);
        if ($this_vip_downum['is_down']) {
            update_user_meta($user_id, 'this_vip_downum', $this_vip_downum['today_down_num'] + 1); //更新+1
          
  
    $file = get_post_meta($postId , 'download_url', true);  
	$name = get_post_meta($postId , 'down_name', true);
	$file_name=$name.'.'.getExt($file);
    $file = @ fopen($file,"r");  
  
    if (!$file) exit("<script language='javascript'>alert('文件丢失！请联系管理员！');window.location.replace(document.referrer);</script>");  
    else {  
        Header("Content-type: application/octet-stream");  
        Header("Content-Disposition: attachment; filename=" . $file_name);  
        while (!feof ($file)) {  
            echo fread($file,60000);  
        }  
        fclose ($file);  
    }	
            exit();
        } else {
			exit("<script language='javascript'>alert('今日下载次数已经用完！');window.location.replace(document.referrer);</script>");
           
        }
    }
}elseif(!is_user_logged_in()){
	header("Location:".$url);
	exit();
}

exit("<script language='javascript'>alert('抱歉！您没有下载权限！请开通会员');window.location.replace(document.referrer);</script>");
