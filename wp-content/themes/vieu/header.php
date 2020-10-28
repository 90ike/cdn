<!DOCTYPE HTML>
<html lang="zh-CN">
<head>
<meta charset="UTF-8">
<link rel="dns-prefetch" href="//apps.bdimg.com">
<meta http-equiv="X-UA-Compatible" content="IE=11,IE=10,IE=9,IE=8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
<meta name="apple-mobile-web-app-title" content="<?php echo get_bloginfo('name') ?>">
<meta http-equiv="Cache-Control" content="no-siteapp">
<title><?php echo _title(); ?></title>
<?php wp_head(); ?>
<link rel="shortcut icon" href="<?php echo _hui_img('ico_src'); ?>">
<!--[if lt IE 9]><script src="<?php echo get_stylesheet_directory_uri() ?>/js/libs/html5.min.js"></script><![endif]-->
<?php tb_xzh_head_var() ?>
</head>
<body <?php body_class(_bodyclass()); ?>>
<?php echo '<style type="text/css">'._hui('csscode').'</style>'; ?>
<?php echo '<script type="text/javascript">'._hui('headcode').'</script>'; ?>
<?php echo tb_xzh_render_head();
 global $current_user;
$banner_style = _hui('banner_style');
if( _hui('focusslide_s') && $banner_style=='qiye'){
	$head='header';
	}else if(!_hui('focusslide_s' || $banner_style=='oldtb')){
	$head='oldtb';
	echo '<style type="text/css">body {padding-top: 66px;}.container-page{margin-top: 81px;}@media (max-width: 720px){body {padding-top: 48px;}.container-page {margin-top: 0px;}.usertitle{ margin-top: 0px;}</style>';
	}
	if(!_hui('focusslide_s')){echo'<style type="text/css">.home-firstitems{margin-top: 15px;}</style>';} ?>
<header class="<?php echo $head; ?>">

<section class="container">
		<?php echo _the_logo();   ?>	
        <?php _moloader('mo_navbar', false);?>        
                  <div class="m-navbar-start"><i class="fa fa-bars m-icon-nav"></i></div>
				  <div class="m-navbar-right">
				  <li class="search-i"><a href="javascript:;" class="search-show active"><i class="fa fa-search"></i></a></li>
				  <?php if( is_user_logged_in() ){
				  echo'<li class="m-wel-start"><a class="m-user" href="javascript:;">'. _get_the_avatar($user_email=$current_user->user_email, true).'</a></li>';}else{echo'<li class="m-wel-start"><a href="javascript:;" class="user-login"  data-sign="0"><i class="fa fa-login"></i></a></li>';}?>
				</div>
                 <div class="site-search">
	
		<?php  
			if( _hui('search_baidu') && _hui('search_baidu_code') ){
				echo '<form class="site-search-form"><input id="bdcsMain" class="search-input" type="text" placeholder="输入关键字"><button class="search-btn" type="submit"><i class="fa fa-search"></i></button></form>';
				echo _hui('search_baidu_code');
			}else{
				echo '
            <div class="sb-search">
                <form action="'.esc_url( home_url( '/' ) ).'">
                    <input class="sb-search-input" placeholder="输入关键字 Enter键搜索..."  type="text"  name="s" type="text" value="'.htmlspecialchars($s).'">
                  
                </form>
            </div>';
			}
		?>

</div>
</section>
</header>