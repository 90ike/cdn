<?php
header('Access-Control-Allow-Origin:*');
header('Content-type:application/json; charset=utf-8');
error_reporting(0);
date_default_timezone_set("PRC");
!empty($_GET['type']) ? $type = $_GET['type'] : error("请求参数错误，请刷新重试！~~");
switch ($type)
{
    case 'Getqrcode':
        echo json_encode(getqrcode());
        break;
    case 'Getresult':
        !empty($_GET['qrsig']) ? $qrsig=$_GET['qrsig'] : error("请求参数错误，缺少qrsig~~");
        echo json_encode(getresult($qrsig),JSON_UNESCAPED_UNICODE);
        break;
    default:
        echo json_encode(getqrcode());
}
/**
 * 获取二维码
 */
function getqrcode() {
    $qrcode = array();
    $api = 'https://ssl.ptlogin2.qq.com/ptqrshow?appid=549000912&e=2&l=M&s=3&d=72&v=7&t=0.1415855' . time();
    $paras['header'] = 1;
    $ret = get_curl($api, $paras);
    preg_match('/qrsig=(.*?);/', $ret, $matches);
    preg_match_all('/ (\d){3}/', $ret, $Conlen);
    $arr = explode('com;', $ret);
    $qrcode['qrsig'] = $matches[1];
    $qrcode['data'] = base64_encode(trim($arr['1']));
    return $qrcode;
}

/**
 * @param $qrsig
 * @return array
 * 获取登录状态
 */
function getresult($qrsig) {
    $ret = array();
    $api = 'https://ssl.ptlogin2.qq.com/ptqrlogin?u1=' . urlencode('https://qzs.qzone.qq.com/') . '&ptqrtoken=' . getqrtoken($qrsig) . '&ptredirect=0&h=1&t=1&g=1&from_ui=1&ptlang=2052&action=0-1-' . time() . '&js_ver=90220&js_type=1&login_sig=&pt_uistyle=40&aid=549000912&daid=5&has_onekey=1';
    $paras['cookie'] = 'qrsig=' . $qrsig . ';';
    $body = get_curl($api, $paras);
    if (preg_match("/ptuiCB\('(.*?)'\)/", $body, $arr)) {
        $r = explode("','", str_replace("', '", "','", $arr[1]));
        if ($r[0] == 0) {
            preg_match('/uin=(\d+)&/', $body, $uin);
            $ret['code'] = 1;
            $ret['data']['uin'] = $uin[1];
            $ret['msg'] = 'QQ登录成功';
        } elseif ($r[0] == 65) {
            $ret['msg'] = '登录二维码已失效，请刷新重试！';
        } elseif ($r[0] == 66) {
            $ret['msg'] = '请使用手机QQ扫码登录';
        } elseif ($r[0] == 67) {
            $ret['msg'] = '正在验证二维码...';
        } else {
            $ret['msg'] = '未知错误001，请刷新重试！';
        }
    } else {
        $ret['msg'] = '未知错误002，请刷新重试！';
    }
    return $ret;
}


function get_curl($url, $paras = array()) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    $httpheader[] = "Accept:*/*";
    $httpheader[] = "Accept-Encoding:gzip,deflate,sdch";
    $httpheader[] = "Accept-Language:zh-CN,zh;q=0.8";
    $httpheader[] = "Connection:close";
    curl_setopt($ch, CURLOPT_HTTPHEADER, $httpheader);
    if ($paras['ctime']) { // 连接超时
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT_MS, $paras['ctime']);
    }
    if ($paras['rtime']) { // 读取超时
        curl_setopt($ch, CURLOPT_TIMEOUT_MS, $paras['rtime']);
    }
    if ($paras['post']) {
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $paras['post']);
    }
    if ($paras['header']) {
        curl_setopt($ch, CURLOPT_HEADER, true);
    }
    if ($paras['cookie']) {
        curl_setopt($ch, CURLOPT_COOKIE, $paras['cookie']);
    }
    if ($paras['refer']) {
        if ($paras['refer'] == 1) {
            curl_setopt($ch, CURLOPT_REFERER, 'http://m.qzone.com/infocenter?g_f=');
        } else {
            curl_setopt($ch, CURLOPT_REFERER, $paras['refer']);
        }
    }
    if ($paras['ua']) {
        curl_setopt($ch, CURLOPT_USERAGENT, $paras['ua']);
    } else {
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3325.181 Safari/537.36");
    }
    if ($paras['nobody']) {
        curl_setopt($ch, CURLOPT_NOBODY, 1);
    }
    curl_setopt($ch, CURLOPT_ENCODING, "gzip");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $ret = curl_exec($ch);
    curl_close($ch);
    return $ret;
}


/** QQ空间Token算法*/
function getqrtoken($qrsig) {
    $len = strlen($qrsig);
    $hash = 0;
    for ($i = 0; $i < $len; $i++) {
        $hash += (($hash << 5) & 2147483647) + ord($qrsig[$i]) & 2147483647;
        $hash &= 2147483647;
    }
    return $hash & 2147483647;
}

function error($str){
    exit(json_encode([
        "code"=>-1,
        "msg"=>$str
    ],JSON_UNESCAPED_UNICODE));
}