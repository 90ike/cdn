<?php
/*
Template Name: 视屏页
*/
get_header(); ?>
<style>
.video{overflow:hidden; margin: 20px auto; width:1200px;}
#video_iframe{height:650px;width:100%;frameborder:0;marginheight:0px;marginwidth:0px;background:#000000;border:0}
#video_button{margin:0 auto;width:1200px;display: block;overflow: hidden;}
#jiexi{height:44px;line-height:30px;border:1px solid #00a0e9;margin-right:10px;width:190px;display:block;float:left;border-radius:0}
#link{border:1px solid #00a0e9; width:780px; line-height:30px; padding:6px; display:block; float:left;}
#beginbtn{width:100px; line-height:40px; background-color:#00a0e9; border:1px solid #00a0e9; display:block; float:right; color:#fff;}
#closebtn{width:100px; line-height:40px; background-color:#00a0e9; border:1px solid #00a0e9; display:block; float:right; color:#fff;margin:0 10px;}
#tips{width:1200px; line-height:30px; background-color:#63b3ff; border:0; display:block; float:right; color:#fff;margin:20px auto;padding:2px 8px;}
@media (max-width:720px){
	.video{width:100%;margin:0;padding:5px}
	#video_iframe{height:222px;}
	#video_button{width:100%;padding:0 5px;}
	#jiexi{width:28%;margin:0 2% 5px 0;}
	#link{width:70%;margin:0 0 5px 0}
	#beginbtn{width:49%; margin:5px 0 5px 1%; padding:0; border:0;}
	#closebtn{width:49%; margin:5px 1% 5px 0; padding:0; border:0;}
	#tips{width:100%;margin:5px auto;padding:5px;}
}
</style>
<div id="page-video-box" class="video">
   <iframe id="video_iframe" src="https://www.qyblog.cn/wp-content/uploads/2019/01/tvshow.jpg"></iframe>
</div>
<div id="video_button">
	<select class="form-control input-lg" id="jiexi" >
    <?php
	if(_hui('video_player_from')){
		
		$typearr = explode("\n", _hui('video_player_from'));
        foreach($typearr as $p){
            if($p){
				$tmp = explode('==', $p);
				if(count($tmp)>=2){
					$value = isset($tmp[2]) ? $tmp[2] : _hui('video_player_jxapi');
					$typeoption .= '<option value="'.trim($value).'">'.trim($tmp[1]).'</option>';
				}
			}
        }
        echo $typeoption;
	}?>	
	</select> 
    <input type="text"  id="link"  placeholder="在此粘贴视频地址！" />
    <input type="submit" id="beginbtn" value="关闭视频"  onclick="Clo()" />
    <input type="submit" id="closebtn" value="提交视频地址"  onclick="Tip()" />
    <p id="tips">在上方输入视频地址后点击提交视频,选择解析接口后即可观看。</p>
</div>
<?php video_dplayer_scripts(); ?>
<?php get_footer(); ?>
<script>
var video = 'https://v.youku.com/v_show/id_XNDUxMjMxMzU1Ng==.html';
function Clo(){
	document.getElementById('page-video-box').innerHTML = '<iframe id="video_iframe" src="https://www.qyblog.cn/wp-content/uploads/2019/01/tvshow.jpg"></iframe>';  
}
function Tip(){
	var link = document.getElementById('link').value;
	var pstr = document.getElementById('jiexi').value;
	
	if(pstr == 'dplayer'){
		if(!this.dp){
			document.getElementById('page-video-box').innerHTML = '';
			this.dp = new CBPlayer({container: document.getElementById("page-video-box"),autoplay: true,hotkey: true,video: {url:unescape(link)}});
			this.dp.play();
		}else{
			this.dp.switchVideo({url:unescape(link)});
			this.dp.play();
		}
	}else if(pstr == 'dplayer_live'){
		if(!this.dp){
			document.getElementById('page-video-box').innerHTML = '';
			this.dp = new CBPlayer({container: document.getElementById("page-video-box"),autoplay: true,hotkey: true,live: true,video: {url:unescape(link)}});
			this.dp.play();
		}else{
			this.dp.switchVideo({url:unescape(link)});
			this.dp.play();
		}
	}else if(pstr == 'self'){
	    var html = '<iframe id="video_iframe" src="'+ link +'"></iframe>'
		document.getElementById("page-video-box").innerHTML = html ;
	}else{
		this.dp = false;
		pstr = pstr.replace('{vid}', link);
		document.getElementById("video_iframe").src = pstr;
	}
	//document.getElementById("video_iframe").src = pstr;
}
document.getElementById("video_iframe").src = document.getElementById('jiexi').value.replace('{vid}', video);
</script>