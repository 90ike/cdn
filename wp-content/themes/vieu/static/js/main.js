
if( !window.console ){
    window.console = {
        log: function(){}
    }
}


/*!
 * jQuery resizeend - A jQuery plugin that allows for window resize-end event handling.
 * 
 * Copyright (c) 2015 Erik Nielsen
 * 
 * Licensed under the MIT license:
 *    http://www.opensource.org/licenses/mit-license.php
 * 
 * Project home:
 *    http://312development.com
 * 
 * Version:  0.2.0
 * 
 */
!function(a){var b=window.Chicago||{utils:{now:Date.now||function(){return(new Date).getTime()},uid:function(a){return(a||"id")+b.utils.now()+"RAND"+Math.ceil(1e5*Math.random())},is:{number:function(a){return!isNaN(parseFloat(a))&&isFinite(a)},fn:function(a){return"function"==typeof a},object:function(a){return"[object Object]"===Object.prototype.toString.call(a)}},debounce:function(a,b,c){var d;return function(){var e=this,f=arguments,g=function(){d=null,c||a.apply(e,f)},h=c&&!d;d&&clearTimeout(d),d=setTimeout(g,b),h&&a.apply(e,f)}}},$:window.jQuery||null};if("function"==typeof define&&define.amd&&define("chicago",function(){return b.load=function(a,c,d,e){var f=a.split(","),g=[],h=(e.config&&e.config.chicago&&e.config.chicago.base?e.config.chicago.base:"").replace(/\/+$/g,"");if(!h)throw new Error("Please define base path to jQuery resize.end in the requirejs config.");for(var i=0;i<f.length;){var j=f[i].replace(/\./g,"/");g.push(h+"/"+j),i+=1}c(g,function(){d(b)})},b}),window&&window.jQuery)return a(b,window,window.document);if(!window.jQuery)throw new Error("jQuery resize.end requires jQuery")}(function(a,b,c){a.$win=a.$(b),a.$doc=a.$(c),a.events||(a.events={}),a.events.resizeend={defaults:{delay:250},setup:function(){var b,c=arguments,d={delay:a.$.event.special.resizeend.defaults.delay};a.utils.is.fn(c[0])?b=c[0]:a.utils.is.number(c[0])?d.delay=c[0]:a.utils.is.object(c[0])&&(d=a.$.extend({},d,c[0]));var e=a.utils.uid("resizeend"),f=a.$.extend({delay:a.$.event.special.resizeend.defaults.delay},d),g=f,h=function(b){g&&clearTimeout(g),g=setTimeout(function(){return g=null,b.type="resizeend.chicago.dom",a.$(b.target).trigger("resizeend",b)},f.delay)};return a.$(this).data("chicago.event.resizeend.uid",e),a.$(this).on("resize",a.utils.debounce(h,100)).data(e,h)},teardown:function(){var b=a.$(this).data("chicago.event.resizeend.uid");return a.$(this).off("resize",a.$(this).data(b)),a.$(this).removeData(b),a.$(this).removeData("chicago.event.resizeend.uid")}},function(){a.$.event.special.resizeend=a.events.resizeend,a.$.fn.resizeend=function(b,c){return this.each(function(){a.$(this).on("resizeend",b,c)})}}()});


/* 
 * jsui
 * ====================================================
*/
jsui.bd = $('body')
jsui.is_signin = jsui.bd.hasClass('logged-in') ? true : false;

if( $('.widget-nav').length ){
    $('.widget-nav li').each(function(e){
        $(this).hover(function(){
            $(this).addClass('active').siblings().removeClass('active')
            $('.widget-navcontent .item:eq('+e+')').addClass('active').siblings().removeClass('active')
        })
    })
}

if( $('.sns-wechat').length ){
    $('.sns-wechat').on('click', function(){
        var _this = $(this)
        if( !$('#modal-wechat').length ){
            $('body').append('\
                <div class="modal fade" id="modal-wechat" tabindex="-1" role="dialog" aria-hidden="true">\
                    <div class="modal-dialog" style="margin-top:200px;width:340px;">\
                        <div class="modal-content">\
                            <div class="modal-header">\
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>\
                                <h4 class="modal-title">'+ _this.attr('title') +'</h4>\
                            </div>\
                            <div class="modal-body" style="text-align:center">\
                                <img style="max-width:100%" src="'+ _this.data('src') +'">\
                            </div>\
                        </div>\
                    </div>\
                </div>\
            ')
        }
        $('#modal-wechat').modal()
    })
}
if( $('.carousel').length ){
    var el_carousel = $('.carousel')

    el_carousel.carousel({
        interval: 4000
    })

    tbquire(['hammer'], function(Hammer) {

        // window.Hammer = Hammer
        
        var mc = new Hammer(el_carousel[0]);

        mc.on("panleft panright swipeleft swiperight", function(ev) {
            if( ev.type == 'swipeleft' || ev.type == 'panleft' ){
                el_carousel.carousel('next')
            }else if( ev.type == 'swiperight' || ev.type == 'panright' ){
                el_carousel.carousel('prev')
            }
        });

    })
}

if( Number(jsui.ajaxpager) > 0 && ($('.excerpt').length || $('.excerpt-minic').length) ){
    tbquire(['ias'], function() {
        if( !jsui.bd.hasClass('site-minicat') && $('.excerpt').length ){
            $.ias({
                triggerPageThreshold: jsui.ajaxpager?Number(jsui.ajaxpager)+1:5,
                history: false,
                container : '.content',
                item: '.excerpt',
                pagination: '.pagination',
                next: '.next-page a',
                loader: '<div class="pagination-loading"><img src="'+jsui.uri+'/static/img/loading.gif"></div>',
                trigger: '查看更多',
                onRenderComplete: function() {
                    tbquire(['lazyload'], function() {
                        $('.excerpt .thumb').lazyload({
                            data_attribute: 'src',
                            placeholder: jsui.uri + '/static/img/thumbnail.png',
                            threshold: 400
                        });
                    });
                }
            });
        }

        if( jsui.bd.hasClass('site-minicat') && $('.excerpt-minic').length ){
            $.ias({
                triggerPageThreshold: jsui.ajaxpager?Number(jsui.ajaxpager)+1:5,
                history: false,
                container : '.content',
                item: '.excerpt-minic',
                pagination: '.pagination',
                next: '.next-page a',
                loader: '<div class="pagination-loading"><img src="'+jsui.uri+'/static/img/loading.gif"></div>',
                trigger: 'More',
                onRenderComplete: function() {
                    tbquire(['lazyload'], function() {
                        $('.excerpt .thumb').lazyload({
                            data_attribute: 'src',
                            placeholder: jsui.uri + '/static/img/thumbnail.png',
                            threshold: 400
                        });
                    });
                }
            });
        }
    });
}

    $(function(){
		$title=jsui.collapse_title;
        $(".hidecontent").hide();
        $("a").click(function(){
            var txts = $(this).parents("li");
            if ($(this).text() == $title){
                txts.find(".hidetitle").hide();
                txts.find(".hidecontent").slideToggle('show');
            }
        })
    });
/* 
 * lazyload
 * ====================================================
*/
tbquire(['lazyload'], function() {
    $('.avatar').lazyload({
        data_attribute: 'src',
        placeholder: jsui.uri + '/static/img/avatar-default.png',
        threshold: 400
    })

    $('.widget .avatar').lazyload({
        data_attribute: 'src',
        placeholder: jsui.uri + '/static/img/avatar-default.png',
        threshold: 400
    })

    $('.thumb').lazyload({
        data_attribute: 'src',
        placeholder: jsui.uri + '/static/img/thumbnail.png',
        threshold: 400
    })

    $('.widget_ui_posts .thumb').lazyload({
        data_attribute: 'src',
        placeholder: jsui.uri + '/static/img/thumbnail.png',
        threshold: 400
    })
    $('.img-share img').lazyload({
        data_attribute: 'src',
        placeholder: jsui.uri + '/static/img/thumbnail.png',
        threshold: 400
    })

})
     $wintip_srollbar=jsui.wintip_s;
	 $wintip_m=jsui.wintip_m;
/* 
 * wintips
 * ====================================================
*/

	
	if($wintip_srollbar>0){
	        
			$(function(){
			if($.cookie("isClose") != 'yes'){
			
			setTimeout(function(){	
		    $(".survey-body").addClass('is-open');
			$(".btn-survey .fa").removeClass('fa-rocket');
			$(".faded").addClass('hidden');
			$(".btn-survey").show(500);
			$(".btn-survey .fa").addClass('fa-times-circle-o');
              }, 3000);
				$(".btn-survey").click(function(){
					var date=jsui.wintip_time;
					var time=(date*60)/86400;
					$(".faded").removeClass('hidden');
					$(".survey-body").removeClass('is-open');	
					$(".btn-survey .fa").addClass('fa-rocket');
					$(".btn-survey .fa").removeClass('fa-times-circle-o');
					$(".btn-survey").hide();
					$.cookie("isClose",'yes',{ expires:time});	// 10ms 为 1/8640 24h为1 1h为1/24 10min为1/144 20min为1/72
				
				});
			}
		});
	  var width = $(window).width(); 
     if($wintip_m>0 && width < 720){$(".wintips").hide();}
	}
/* 
 * minic
 * ====================================================
*/

   
  if(jsui.minicat_s>0){
		$(function(){
			if($.cookie("minicClose") != 'yes'){
			setTimeout(function(){
            var sht=$(window).height();
            var sheight=$(".sweet-alert").height();	
			
			var i=sheight>sht?sht-200:sheight;
			var topp=(sht/2)-(i/2);
			if(sheight-topp>sht){
			$(".sweet-alert").css({top:topp,'opacity':'1','visibility':'initial','height':i+'px'});
			$(".sweet-alert .excerpt-minic").css({'overflow':'auto','height':i-113+'px'});
			}else{
			 $(".sweet-alert").css({top:topp,'opacity':'1','visibility':'initial'});
			}
			jsui.bd.css({'overflow-x':'hidden','overflow-y':'hidden'});
			 $("body").append('<div class="gg-minicat"></div>');
              }, 3000);
				$(".close-minic").click(function(){
					var date=jsui.minicat_time;
					var time=(date*60)/86400;
					 $(".sweet-alert").css({top:0,'opacity':'0','visibility':'hidden'});
					jsui.bd.css({'overflow-x':'auto','overflow-y':'auto'});
                    $("div.gg-minicat").remove();
        
					$.cookie("minicClose",'yes',{ expires:time});	
				
				});
			}
		});
  }
	


$(window).scroll(function() {
	document.documentElement.scrollTop + document.body.scrollTop > 0 ? $('.header').addClass('scrolled') : $('.header').removeClass('scrolled');
    document.documentElement.scrollTop + document.body.scrollTop > 0 ? $('.oldtb').addClass('scrolled') : $('.oldtb').removeClass('scrolled');
})

/* 
 * prettyprint
 * ====================================================
*/
$('pre').each(function(){
    if( !$(this).attr('style') ) $(this).addClass('prettyprint')
})

if( $('.prettyprint').length ){
    tbquire(['prettyprint'], function(prettyprint) {
        prettyPrint()
    })
}


$(document).ready(function(){

	var c=1;								
	$(".group-detail>ul>.card-item").mouseenter(function(){
		var e=$(this);
		c=e.data("card");
		var e=$(this);
		setTimeout(function(){
			if(c==e.data("card")){
				$(".group-detail>ul>.card-item").removeClass("active");
				e.addClass("active")
			}
		},250)
	});

});
//复制下载密码
      function copyArticle(event) {
        const range = document.createRange();
        range.selectNode(document.getElementById('down-pass'));
 
        const selection = window.getSelection();
        if(selection.rangeCount > 0) selection.removeAllRanges();
        selection.addRange(range);
        document.execCommand('copy');
		obj=document.getElementById('copy-pass');
        obj.innerHTML = '<i class="fa fa-check-circle"></i> 已复制';
		setTimeout(function() {
        obj.innerHTML = '<i class="fa fa-clipboard"></i> 复制';
    },
    2000);
      }
 if(document.getElementById("copy-pass")) { 
       document.getElementById('copy-pass').addEventListener('click', copyArticle, false);
}

function copy() {
        var text =document.getElementById("copy-tuiguang").innerText;
        var input = document.createElement('input');
        input.setAttribute('id', 'copyInput');
        input.setAttribute('value', text);
        document.getElementsByTagName('body')[0].appendChild(input);
        document.getElementById('copyInput').select();
        if (document.execCommand('copy')) {
        obj=document.getElementById('copy-tg');
        obj.innerHTML = '<i class="fa fa-check-circle"></i> 已复制';
		setTimeout(function() {
        obj.innerHTML = '<i class="fa fa-clipboard"></i> 复制';
    },
    2000)
        }
        document.getElementById('copyInput').remove();
    }

//图片转为base64
function getBase64Image(img) {  
     var canvas = document.createElement("canvas");  
     canvas.width = img.width;  
     canvas.height = img.height;  
     var ctx = canvas.getContext("2d");  
     ctx.drawImage(img, 0, 0, img.width, img.height);  
     var ext = img.src.substring(img.src.lastIndexOf(".")+1).toLowerCase();  
     var dataURL = canvas.toDataURL("image/"+ext);  
     return dataURL;  
}

//隐藏或者显示侧边栏
    jQuery(document).ready(function($) {
	var width = $(window).width();
        $('.close-sidebar').click(function() {
			if(width > 1024){
            $('.sidebar').addClass('sid-on');
			$('.leftsd').addClass('leftsd-on');
            $('.show-sidebar').show();
			$('.close-sidebar').hide();
            $('.single-content').addClass('hidebianlan');
			 $('.containercc').addClass('boxhidesd');
			}});
        $('.show-sidebar').click(function() {
		if(width > 1024){
            $('.show-sidebar').hide();
			$('.close-sidebar').show();
            $('.sidebar').removeClass('sid-on');
			$('.leftsd').removeClass('leftsd-on');
            $('.single-content').removeClass('hidebianlan');
			 $('.containercc').removeClass('boxhidesd');
	 }});
    });
	
	
	
	  $('.share-haibao,.product_haibao').click(function() {
			$('.bigger-share').addClass('haibao-on');
            $('.dialog_overlay').show();
			$('.dialog_overlay').click(function() {
			$('.bigger-share').removeClass('haibao-on');
            $('.dialog_overlay').hide();
			});
			

 
			$('#haibaoimg').attr('src',jsui.uri+'/action/haibao.php?id='+jsui.post_id);
			});
	$('.share-close').click(function() {
			$('.bigger-share').removeClass('haibao-on');
            $('.dialog_overlay').hide();
			});
	
	

$('a.shoucang,a.shoucang-list,a.shop_shoucang').click(function(){
var id = $(this).data("id");
$.ajax({
url: "/wp-admin/admin-ajax.php",
type:'post',
dataType:'json',
data:{action:'post_shoucang',id:id},
success: function(data){
alert(data.msg);
window.location.reload();
location.reload();

}
});
});
$('.tuiguang-haibao').click(function(){
$('.m-mask,.modal-dialog-haibao').show();
var id = $(this).data("id");
$.ajax({
url: "/wp-admin/admin-ajax.php",
type:'post',
dataType:'json',
data:{action:'post_haibao',id:id},
success: function(data){
	$('#tg-price-tj').html(data.price);
	$('#copy-tuiguang').html(data.url);
var image = new Image();  
image.src = data.imgurl;  
image.onload = function(){  
  var base64 = getBase64Image(image);  
  $('#tg-img').attr('src',base64);
}  
}
});
});




/* 
 * rollbar
 * ====================================================
*/
 // if($wintip_srollbar<1){

$(window).scroll(function() {
	document.documentElement.scrollTop + document.body.scrollTop > 200 ? $('.rollbar').addClass('rollbar-totop') : $('.rollbar').removeClass('rollbar-totop');
})


var _wid = $(window).width()

$(window).resize(function(event) {
    _wid = $(window).width()
});

jsui.bd.append('<div class="m-mask"></div>')



/* 
 * bootstrap
 * ====================================================
*/
$('.user-welcome').tooltip({
    container: 'body',
    placement: 'bottom'
})




    var nav2 = $('.theme-item-menubar')
	var nav3 = $('#mallsd')
    if( nav2.length ){
        nav2.affix({
            offset: {
                top: nav2.offset().top,
                bottom: 0
            }
        }),
		nav3.affix({
            offset: {
                top: nav2.offset().top-$('.theme-item-menubar').height(),
                bottom: 0
            }
        })
    }



$('.theme-item-menubar ul li').on('click', function(){
    $(this).addClass('active').siblings().removeClass('active')
    $('#'+$(this).data('id')).show().siblings('.theme-itembox').hide()


    if( $('.theme-item-menubar').hasClass('affix') ){
		
        $("html, body").scrollTop( $('.theme-item-menubar-wrap').offset().top-$('.header').height()+1 )
    }



})

if( location.hash ){
    var hash = location.hash.slice(1)
    $('[data-id='+hash+']').addClass('active').siblings().removeClass('active')
    $('#'+hash).show().siblings('.theme-itembox').hide()
}


function topMao(e){
        document.querySelector("#"+e+"-mao").scrollIntoView(true);
        var target = $("#"+e+"-mao");
        var top = target.offset().top-150;
        if(top > 0) {
            $('html,body').animate({scrollTop: top},0);
        }
}


var time=null;
var nexImg = 0;
//用于获取轮播图图片个数
var imgLength = $(".c-banner .banner .gallery dl").length;
//当时动态数据的时候使用,上面那个删除
// var imgLength =0;
if(imgLength>1){
//设置底部第一个按钮样式
$(".c-banner .jumpBtn ul li[jumpImg="+nexImg+"]").css("background-color","rgb(113, 113, 113)");

//页面加载
$(document).ready(function(){
	// dynamicData();
	//启动定时器,设置时间为3秒一次
	time =setInterval(intervalImg,5000);
});

//点击上一张
$(".preImg").click(function(){
	//清楚定时器
	clearInterval(time);
	var nowImg = nexImg;
	nexImg = nexImg-1;
	console.log(nexImg);
	if(nexImg<0){
		nexImg=imgLength-1;
	}
	//底部按钮样式设置
	$(".c-banner .jumpBtn ul li").css("background-color","white");
	$(".c-banner .jumpBtn ul li[jumpImg="+nexImg+"]").css("background-color","rgb(113, 113, 113)");

	//轮播淡入淡出
	$(".c-banner .banner .gallery dl").eq(nexImg).css("display","block");
	$(".c-banner .banner .gallery dl").eq(nexImg).stop().animate({"opacity":1},300);
	$(".c-banner .banner .gallery dl").eq(nowImg).stop().animate({"opacity":0.5},300,function(){
		$(".c-banner .gallery dl").eq(nowImg).css("display","none");
	});
	
	//启动定时器,设置时间为3秒一次
	time =setInterval(intervalImg,5000);
})

//点击下一张
$(".nexImg").click(function(){
	clearInterval(time);
	intervalImg();
	time =setInterval(intervalImg,5000);
})

//轮播图
function intervalImg(){
	if(nexImg<imgLength-1){
		nexImg++;
	}else{
		nexImg=0;
	}
	
	//将当前图片试用绝对定位,下一张图片试用相对定位
	/*$(".c-banner .banner .gallery img").eq(nexImg-1).css("position","absolute");
	$(".c-banner .banner .gallery img").eq(nexImg).css("position","relative");
	*/
	$(".c-banner .banner .gallery dl").eq(nexImg).css("display","block");
	$(".c-banner .banner .gallery dl").eq(nexImg).stop().animate({"opacity":1},500);
	$(".c-banner .banner .gallery dl").eq(nexImg-1).stop().animate({"opacity":0.2},500,function(){
		$(".c-banner .banner .gallery dl").eq(nexImg-1).css("display","none");
	});
	$(".c-banner .jumpBtn ul li").css("background-color","white");
	$(".c-banner .jumpBtn ul li[jumpImg="+nexImg+"]").css("background-color","rgb(113, 113, 113)");
}

//轮播图底下按钮
//动态数据加载的试用应放在请求成功后执行该代码,否则按钮无法使用
$(".c-banner .jumpBtn ul li").each(function(){
	//为每个按钮定义点击事件
	$(this).click(function(){
		clearInterval(time);
		$(".c-banner .jumpBtn ul li").css("background-color","white");
		jumpImg = $(this).attr("jumpImg");
		if(jumpImg!=nexImg){
			var after =$(".c-banner .banner .gallery dl").eq(jumpImg);
			var befor =$(".c-banner .banner .gallery dl").eq(nexImg);
			
			//将当前图片试用绝对定位,下一张图片试用相对定位
			$(".c-banner .banner .gallery img").eq(nexImg).css("position","absolute");
			$(".c-banner .banner .gallery img").eq(jumpImg).css("position","relative");
			
			after.css("display","block");
			after.stop().animate({"opacity":1},5000);
			befor.stop().animate({"opacity":0.5},5000,function(){
				befor.css("display","none");
			});
			nexImg=jumpImg;
		}
		$(this).css("background-color","black");
		time =setInterval(intervalImg,5000);
	});
});
}

/* 
 * single
 * ====================================================
*/



var _sidebar = $('.sidebar')
if (_wid>1024 && _sidebar.length) {//
    var h1 = 81,
        h2 = 96
    var rollFirst = _sidebar.find('.widget:eq(' + (jsui.roll[0] - 1) + ')')
    var sheight = rollFirst.height()//获取工具高度
   

    rollFirst.on('affix-top.bs.affix', function() {

        rollFirst.css({
            top: 0
        })
        sheight = rollFirst.height()

        for (var i = 1; i < jsui.roll.length; i++) {
            var item = jsui.roll[i] - 1
            var current = _sidebar.find('.widget:eq(' + item + ')')
            current.removeClass('affix').css({
                top: 0
            })
        };
    })

    rollFirst.on('affix.bs.affix', function() {

     rollFirst.css({
            top: h1
        })


        for (var i = 1; i < jsui.roll.length; i++) {
            var item = jsui.roll[i] - 1
            var current = _sidebar.find('.widget:eq(' + item + ')')
            current.addClass('affix').css({
                top:  sheight+h2+5
            })
            sheight += current.height() + 80
			
        };
    })
 
    rollFirst.affix({
        offset: {
            top: _sidebar.height(),
            bottom: $('.footer').outerHeight()
        }
    })

 
}



$('[data-event="rewards"]').on('click', function(){
    $('.rewards-popover-mask, .rewards-popover').fadeIn()
})

$('[data-event="rewards-close"]').on('click', function(){
    $('.rewards-popover-mask, .rewards-popover').fadeOut()
})


if( $('#SOHUCS').length ) $('#SOHUCS').before('<span id="comments"></span>')


/*$('.plinks a').each(function(){
    var imgSrc = $(this).attr('href')+'/favicon.ico'
    $(this).prepend( '<img src="'+imgSrc+014'">' )
})*/




    $(function(){
        $('.doubt-content').hide();
        //按钮点击事件
        $('.doubt-button').click(function(){
            if ($(this).html() == '<i class="fa fa-chevron-down"></i>'){
				var txts = $(this).parents('.doubt');
                $(this).html('<i class="fa fa-chevron-up"></i>');
                //txts.find(".doubt-tit").hide();
                txts.find('.doubt-content').show(300);
            }else{
				var txts = $(this).parents('.doubt');
                $(this).html('<i class="fa fa-chevron-down"></i>');
                //txts.find(".doubt-tit").show();
                txts.find('.doubt-content').hide(300);
            }
        })
    });




if( $('.post-like').length ){
    tbquire(['jquery.cookie'], function() {
        $('.post-like').on('click', function(){
            var _ta = $(this)
            var pid = _ta.attr('data-pid')
            if ( !pid || !/^\d{1,}$/.test(pid) ) return;

            if( !jsui.is_signin ){
                var lslike = lcs.get('_likes') || ''
                if( lslike.indexOf(','+pid+',')!==-1 ) return alert('你已赞！')

                if( !lslike ){
                    lcs.set('_likes', ','+pid+',')
                }else{
                    if( lslike.length >= 160 ){
                        lslike = lslike.substring(0,lslike.length-1)
                        lslike = lslike.substr(1).split(',')
                        lslike.splice(0,1)
                        lslike.push(pid)
                        lslike = lslike.join(',')
                        lcs.set('_likes', ','+lslike+',')
                    }else{
                        lcs.set('_likes', lslike+pid+',')
                    }
                }
            }

            $.ajax({
                url: jsui.uri + '/action/like.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    key: 'like',
                    pid: pid
                },
                success: function(data, textStatus, xhr) {
                    if (data.error) return false;
                    _ta.toggleClass('actived')
                    _ta.find('span').html(data.response)
                }
            });
        })
    })
}


/*
 *down
 *
*/
$('.down-show').click(function(){
  $('.down-up').show(300);
  $('.m-mask').show();
  $('.down-up>.down-content').css('opacity', '1');
 
});
 $('.m-mask').on('click', function(){
    $(this).hide();

    $('.down-up,.modal-dialog-haibao').hide();
     $('.down-up>.down-content').css('opacity', '0');
 });
$('.down-up .close').click(function(){
  $('.down-up').hide(300);
  $('.m-mask').hide();
   $('.down-up>.down-content').css('opacity', '0');
  
});

/* 
 * 下载
 * ====================================================
*/
$('.duli-download').click(function(){
	 var _this = $(this);
     var id = $(this).data("down");
     _this.html('<i class="fa fa-refresh fa-spin"></i> 获取中...')
      _this.attr("disabled","true");
      $('.down-url').html('');
	  $('.down-url').css({'margin-top': '0px','border': 'none', 'padding': '0'});
        setTimeout(function(){
            _this.html('<i class="fa fa-refresh"></i> 重新获取')
            _this.removeAttr("disabled");
			
			$.ajax({
             url: "/wp-admin/admin-ajax.php",
            type:'post',
            dataType:'json',
             data:{action:'post_download',id:id},
            success: function(data){
	
	     if(data.status==1){
		 $('.down-url').html('<a href="'+data.url+'" target="_blank"><i class="fa fa-cloud-download"></i> 立即下载</a>');
		 $('.down-url').css({'margin-top': '20px','border-top': 'dotted #3b3b3b 1px', 'padding-top': '15px'});
		//window.open(data.url);
	     }else if(data.status==0){
	 	alert(data.msg);
	     }else{
		alert("未知错误！");
	   }
         }
         });
			
          },1000);


});

	
/* 
 * comment
 * ====================================================
*/
if (jsui.bd.hasClass('comment-open')) {
    tbquire(['comment'], function(comment) {
        comment.init();
		
    })
}


/* 
 * page u
 * ====================================================
*/
if (jsui.bd.hasClass('page-template-pagesuser-php')) {
    tbquire(['user'], function(user) {
        user.init()
    })
}


/* 
 * page nav
 * ====================================================
*/
if( jsui.bd.hasClass('page-template-pagesnavs-php') ){

    var titles = ''
    var i = 0
    $('#navs .items h2').each(function(){
        titles += '<li><a href="#'+i+'">'+$(this).text()+'</a></li>'
        i++
    })
    $('#navs nav ul').html( titles )

    $('#navs .items a').attr('target', '_blank')

    $('#navs nav ul').affix({
        offset: {
            top: $('#navs nav ul').offset().top,
            bottom: $('.footer').height() + $('.footer').css('padding-top').split('px')[0]*2
        }
    })


    if( location.hash ){
        var index = location.hash.split('#')[1]
        $('#navs nav li:eq('+index+')').addClass('active')
        $('#navs nav .item:eq('+index+')').addClass('active')
        scrollTo( '#navs .items .item:eq('+index+')' )
    }
    $('#navs nav a').each(function(e){
        $(this).click(function(){
            scrollTo( '#navs .items .item:eq('+$(this).parent().index()+')' )
            $(this).parent().addClass('active').siblings().removeClass('active')
        })
    })
}


/* 
 * page search
 * ====================================================
*/
if( jsui.bd.hasClass('search-results') ){
    var val = $('.site-search-form .search-input').val()
    var reg = eval('/'+val+'/i')
    $('.excerpt h2 a, .excerpt .note').each(function(){
        $(this).html( $(this).text().replace(reg, function(w){ return '<b>'+w+'</b>' }) )
    })
}


/* 
 * search
 * ====================================================
*/
$('.search-show').bind('click', function(){
    $(this).find('.fa').toggleClass('fa-remove')
    jsui.bd.toggleClass('search-on')
    if( jsui.bd.hasClass('search-on') ){
        $('.site-search').find('input').focus()
        jsui.bd.removeClass('m-nav-show')
    }
})

/* 
 * phone
 * ====================================================
*/

jsui.bd.append( $('.site-navbar').clone().attr('class', 'm-navbar') )

$('.m-navbar li.menu-item-has-children').each(function(){
    $(this).append('<i class="fa fa-angle-down faa"></i>')
})

$('.m-navbar li.menu-item-has-children .faa').on('click', function(){
    $(this).parent().find('.sub-menu').slideToggle(300)
})
/*
$('.m-menubar li.menu-item-has-children').on('click', function(){
   $(this).find('.sub-menu').slideToggle(300)
	
})*/

$(".m-menubar li.menu-item-has-children").on("click", function() {
			     $(this).toggleClass("active").siblings().removeClass("active")
			});

$('.m-user').on('click', function(){
    jsui.bd.addClass('m-wel-on')
	$('.m-mask').show()
})
$('.m-mask').on('click', function(){
    $(this).hide()
    jsui.bd.removeClass('m-wel-on')
})
$('.m-wel-content ul a').on('click', function(){
    $('.m-mask').hide()
    jsui.bd.removeClass('m-wel-on')
})

$('.m-icon-nav').on('click', function(){
    jsui.bd.addClass('m-nav-show')

    $('.m-mask').show()

    jsui.bd.removeClass('search-on')
    $('.search-show .fa').removeClass('fa-remove') 
})

$('.m-mask').on('click', function(){
    $(this).hide()
    jsui.bd.removeClass('m-nav-show')
})




video_ok()
$(window).resizeend(function(event) {
    video_ok()
});

function video_ok(){
    var cw = $('.article-content').width()
    $('.article-content embed, .article-content video, .article-content iframe').each(function(){
        var w = $(this).attr('width')||0,
            h = $(this).attr('height')||0
        if( cw && w && h ){
            $(this).css('width', cw<w?cw:w)
            $(this).css('height', $(this).width()/(w/h))
        }
    })
}






/* functions
 * ====================================================
 */
function scrollTo(name, add, speed) {
    if (!speed) speed = 300
    if (!name) {
        $('html,body').animate({
            scrollTop: 0
        }, speed)
    } else {
        if ($(name).length > 0) {
            $('html,body').animate({
                scrollTop: $(name).offset().top + (add || 0)
            }, speed)
        }
    }
}


function is_name(str) {
    return /.{2,12}$/.test(str)
}
function is_url(str) {
    return /^((http|https)\:\/\/)([a-z0-9-]{1,}.)?[a-z0-9-]{2,}.([a-z0-9-]{1,}.)?[a-z0-9]{2,}$/.test(str)
}
function is_qq(str) {
    return /^[1-9]\d{4,13}$/.test(str)
}
function is_mail(str) {
    return /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/.test(str)
}


$.fn.serializeObject = function(){
    var o = {};
    var a = this.serializeArray();
    $.each(a, function() {
        if (o[this.name] !== undefined) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};

