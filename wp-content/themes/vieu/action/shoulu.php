<?php
error_reporting(0);
header("Access-Control-Allow-Origin:*");
header("Content-Type: application/json;charset=utf-8");
if(isset($_GET['url'])){
	$hansurl="https://www.baidu.com/s?ie=utf-8&mod=1&isbd=1&isid=3E1D52F4B7A56477&ie=UTF-8&wd=".$_GET['url']."&rsv_sid=1423_21099_30210_30495_30473_26350_30498&_ss=1&clist=&hsug=&f4s=1&csor=31&_cr1=13512".$_GET['url'];
	$ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $hansurl);
    // curl_setopt($ch, CURLOPT_REFERER, "https://www.baidu.com/s?ie=UTF-8&wd=site%3Ahan8.net");
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.79 Safari/537.36");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	$output = curl_exec($ch);
	curl_close($ch);
	if(strstr($output,'百度为您找到相关结果约0个')||strstr($output,'没有找到该URL。')){
		$result=array("success" =>true,"url"=>$_GET['url'],"message"=>"该网址未被收录");
	}else{
		$result=array("success" =>true,"url"=>$_GET['url'],"message"=>"该网址已被收录");
	}
	exit(json_encode($result,JSON_UNESCAPED_UNICODE));
}else{
	$result=array("success" =>false,"message"=>"参数输入不完整");
	exit(json_encode($result,JSON_UNESCAPED_UNICODE));
}
?>