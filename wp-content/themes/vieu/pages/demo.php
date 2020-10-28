<?php
/*
Template Name: 在线演示‘demo’
*/
 $pid = $_GET['pid'];
 $download = get_post_meta($pid, 'download', true);
   $values = $download['demo_url'];
   $down_name=$download['title'];
   $down_size=$download['size'];
   /*$rand1=get_post_meta($pid, 'down_rand1', true);
   $rand2=get_post_meta($pid, 'down_rand2', true);*/
   //$key=$rand1+$rand2;
     if(empty($values)){
       Header('Location:/');
     }else{$yanshi = $values;
} ?>
<!DOCTYPE html>


<html> 
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="description" content="" />
    <meta name="keywords" content="演示" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<link type="text/css" href="https://lib.baomitu.com/twitter-bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://lib.baomitu.com/jquery/1.7.2/jquery.min.js"></script>
	    <script type="text/javascript">var calcHeight = function() {
        var headerDimensions = $('#header-bar').height();
        $('#demo-frame').height($(window).height() - headerDimensions);
      }
      $(document).ready(function() {
        calcHeight();
      });
      $(window).resize(function() {
        calcHeight();
      }).load(function() {
        calcHeight();
      });</script>
	<link type="text/css" href="<?php echo get_stylesheet_directory_uri() ?>/static/css/device.css" rel="stylesheet">
    <title>Demo：<?php echo get_the_title($pid); ?>–<?php echo get_bloginfo( 'name') ?></title>
  
  </head>
  
  <body id="by">
  
  <div id="header-bar" class="navbar navbar-default" role="navigation">
 <div class="navbar-header">
    <a class="navbar-brand" href="<?php echo get_permalink($pid); ?>"><span class="glyphicon glyphicon-chevron-left"></span> 返回文章</a>
	<p class="navbar-text"><small class="text-muted text-sm"><em>文件名称 ：<?php echo $down_name;?></em></small></p>
	<p class="navbar-text"><small class="text-muted text-sm"><em>大小 ：<?php echo $down_size;?></em></small></p>
	
  </div>  
  <div class="nav navbar-nav navbar-default demo-button">
	        <li class="device-monitor">
              <a href="javascript:">
                <div class="icon-monitor active"></div>
              </a>
            </li>
            <li class="device-mobile">
              <a href="javascript:">
                <div class="icon-tablet"></div>
              </a>
            </li>
            <li class="device-mobile">
              <a href="javascript:">
                <div class="icon-mobile-1"></div>
              </a>
            </li>
            <li class="device-mobile-2">
              <a href="javascript:">
                <div class="icon-mobile-2"></div>
              </a>
            </li>
            <li class="device-mobile-3">
              <a href="javascript:">
                <div class="icon-mobile-3"></div>
              </a>
            </li>
	  	  	  </div>

  <div class="collapse navbar-collapse">
      <ul class="nav navbar-nav navbar-right">
	  <li><a href="<?php echo get_bloginfo('url');?>"><span class="glyphicon glyphicon-home"></span> 首页</a></li>
	  <!---- <li><a href="<?php echo get_bloginfo('url').'/down/?pid='.$pid.'&key='.$key; ?>"><span class="glyphicon glyphicon-cloud-download"></span> 附件下载</a></li>--->
	   <li class="active"><a href="#"><span class="glyphicon glyphicon-eye-open"></span> 在线演示</a></li> 
	  <li><a href="<?php echo 'http://wpa.qq.com/msgrd?v=3&uin='._hui('qq').'&site=qq&menu=yes';?>" target="_blank"><span class="glyphicon glyphicon-comment"></span> 联系客服</a></li>
	  	  	  </ul>
  </div>
  
   

</div>
 
  <iframe id="demo-frame" src="<?php echo $yanshi; ?>" name="demo-frame" frameborder="0" class="demo-frame" noresize="noresize"></iframe>
<script type="text/javascript">var theme_list_open = false;
$(document).ready(function() {
    function fixHeight() {
        var headerHeight = $("#switcher").height();
        $("#iframe").attr("height", $(window).height() - 84 + "px")
    }
    $(window).resize(function() {
        fixHeight()
    }).resize();
    $('.icon-monitor').addClass('active');
	$(".navbar-nav li").on("click", function() {
			     $(this).toggleClass("active").siblings().removeClass("active")
			});

    $(".icon-mobile-3").click(function() {
        $("#by").css("overflow-y", "auto");
        $('#demo-frame').removeClass('full-width').removeClass('tablet-width').removeClass('mobile-width').removeClass('mobile-width-2').removeClass('demo-frame').addClass('mobile-width-3');
        $('.icon-tablet,.icon-mobile-1,.icon-monitor,.icon-mobile-2,.icon-mobile-3').removeClass('active');
        $(this).addClass('active');
        return false
    });
    $(".icon-mobile-2").click(function() {
        $("#by").css("overflow-y", "auto");
        $('#demo-frame').removeClass('full-width').removeClass('tablet-width').removeClass('mobile-width').removeClass('mobile-width-3').removeClass('demo-frame').addClass('mobile-width-2');
        $('.icon-tablet,.icon-mobile-1,.icon-monitor,.icon-mobile-2,.icon-mobile-3').removeClass('active');
        $(this).addClass('active');
        return false
    });
    $(".icon-mobile-1").click(function() {
        $("#by").css("overflow-y", "auto");
        $('#demo-frame').removeClass('full-width').removeClass('tablet-width').removeClass('mobile-width-2').removeClass('mobile-width-3').removeClass('demo-frame').addClass('mobile-width');
        $('.icon-tablet,.icon-mobile,.icon-monitor,.icon-mobile-2,.icon-mobile-3').removeClass('active');
        $(this).addClass('active');
        return false
    });
    $(".icon-tablet").click(function() {
        $("#by").css("overflow-y", "auto");
        $('#demo-frame').removeClass('full-width').removeClass('mobile-width').removeClass('mobile-width-2').removeClass('mobile-width-3').removeClass('demo-frame').addClass('tablet-width');
        $('.icon-tablet,.icon-mobile-1,.icon-monitor,.icon-mobile-2,.icon-mobile-3').removeClass('active');
        $(this).addClass('active');
        return false
    });
    $(".icon-monitor").click(function() {
        $("#by").css("overflow-y", "hidden");
        $('#demo-frame').removeClass('full-width').removeClass('tablet-width').removeClass('mobile-width').removeClass('mobile-width-2').removeClass('mobile-width-3').addClass('demo-frame');
        $('.icon-tablet,.icon-mobile-1,.icon-monitor,.icon-mobile-2,.icon-mobile-3').removeClass('active');
        $(this).addClass('active');
        return false
    })
});</script>
</body>

</html>





