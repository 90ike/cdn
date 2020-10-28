

<?php
 /*
    Template Name: mall商城)
    */ 
	if(!(_hui('mall_s') && _hui('is_shoping'))){
		 Header('Location:/');
	}
	global $wpdb, $wppay_table_name, $current_user;
	get_header();
	$user_id = is_user_logged_in() ? wp_get_current_user()->ID : 0;
	$options_categories = array();
	$ulist = $wpdb->get_results("SELECT * FROM $wppay_table_name WHERE user_id=$user_id ORDER BY create_time DESC");
	$plist = $wpdb->get_results("SELECT * FROM $wppay_table_name WHERE user_id=$user_id AND status=1");
	
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	$options_categories_obj = get_categories();
	$current_url = home_url(add_query_arg(array(),$wp->request));
	$mall=_hui('mall_settings');
	$user_downData = this_vip_downum();
	$vip_type = get_user_meta($user_id, 'vip_type', true);
	$imagepath =  get_template_directory_uri() . '/static/img/';
    $vip_time  = get_user_meta($user_id, 'vip_time', true);
    $timestamp = intval($vip_time) - time();
    if ($timestamp > 0) {
        if (intval($vip_type) == 31) {
            $vip = '<img src="'.$imagepath.'/vip1.png" style="width: 25px;">';
        } elseif (intval($vip_type) == 365) {
            $vip = '<img src="'.$imagepath.'/vip2.png" style="width: 25px;">';
        } elseif (intval($vip_type) == 3600) {
            $vip = '<img src="'.$imagepath.'/vip3.png" style="width: 25px;">';
        }
    } else {
        $vip = '';
    }
	
	?>
	<style type="text/css">body{padding-top: 86px;}@media(max-width:720px) {body{padding-top: 48px;} <?php if($mall['m_mall_sidebar_s']){ echo'#mallmenu{display: block;}';} ?>}</style>
	<?php if($mall['mall_header_s']){ ?>	
	<div class="mall_header" style="background: center top url(<?php echo $mall['backgroud']['url'];?>);">
        <section class="container">
                <h1><?php echo $mall['title'];?></h1>
               <?php echo $mall['desc'];?>
                </section>
    </div>
<?php } ?>

<?php if($mall['mall_tuijian_s']){ ?>	
<div class="mall_box white_bg"><section class="container">
   
        <div class="mall_img_left intright wow fadeInLeft animated animated">
		<div class="bookBox"><img src="<?php echo $mall['zdbg']['url'];?>" alt="<?php echo $mall['zdtitle'];?>" title="<?php echo $mall['zdtitle'];?>"> </div>
		</div>
        <div class="mall_text_right imgright wow fadeInRight animated animated">
            <h2><?php echo $mall['zdtitle'];?></h2>
            <p class="zddescsub"><?php echo $mall['zddescsub'];?></p>
			<p><?php echo $mall['zddesc'];?></p>
            <p class="zdbtn"><?php 
		 $btn =  $mall['zdbtn']; 
		 $btn_bg='';
		 if($btn){
          foreach ($btn as $key => $value) {
			  $btn_bg.='<a '.($value['btn_bank']?' target="_blank"':'').' href="'.$value['btn_url'].'" class="btn btn-'.$value['btn_color'].' btn-slider">'.$value['btn_title'].'</a>';
		  }
		 }
			echo $btn_bg;
			?>
			</p>
			</div>
    </section>
</div>
<?php } ?>
<?php $mallargs = array(
	'orderby'            => 'slug', 
	'order'              => 'ASC', 
	'hide_empty'         => 0,
	'taxonomy'           => 'mall', 
	'walker'             => null 
); ?>
	<section class="container">
	<div class="content-wrap">	
	<?php if($mall['mall_sidebar_s']){ ?>	
	<div class="mallmenu" id="mallmenu">
	
	<?php 
		 $sidebar =  $mall['mall_sidebar']; 
		 $sidebar_bg='';
		 if($sidebar){
          foreach ($sidebar as $key => $value) {
			 if($value['type']=='menu'){
				  $categories=get_categories($mallargs);
                   echo ' <ul class="mall-ul'.get_wow_3().'"><li '.(!$_GET['category']? 'class="active"':'').'><a href="'.$current_url.'">商城首页</a></li>';
	               foreach( $categories as $term ){
                   $name = $term->name;
                   $link = $current_url.'?category='.$term->term_id  ;
				
                echo ' <li '.($_GET['category']==$term->term_id? 'class="active"':'').'><a href="'.$link.'">'.$name.'</a><i>'. $term->count.'个商品</i></li>';
           } echo' </ul>';
			 }else if($value['type']=='contact'){
				 echo '<div class="mall-ul'.get_wow_3().'">
				
				 <div class="tanc_ico">
				               ';
							  echo $value['wechat'] && $value['qrcode']['url']?'<p class="lianxi_p"><a class="sns-wechat" href="javascript:;" title="'.__('微信号', 'haoui').'“'.$value['wechat'].'”" data-src="'.$value['qrcode']['url'].'"><span class="fa fa-weixin"></span>微信客服</a></p>':'';
							   echo $value['qq']?'<p class="lianxi_p"><span class="fa fa-qq"></span><a target="_blank" href="http://wpa.qq.com/msgrd?v=3&amp;uin='.$value['qq'].'&amp;site=qq&amp;menu=yes">'.$value['qq'].'</a></p>':'';
							  echo' </div></div>';
			 }else if($value['type']=='reco'){
				 if( _hui('left_asb_s')){echo '<div class="textwidget'.get_wow_3().'">'._hui('left_asb_s').'</div>';}
			 }else if($value['type']=='user'){
				if(is_user_logged_in()){
					 echo '<div class="mall-user'.get_wow_3().'"><div class="mall_top">
					 '._get_the_avatar($user_id=$current_user->ID, $user_email=$current_user->user_email, true).'
					 <h4>'.$current_user->display_name .' '.$vip.'</h4>
				 <h5>'. $current_user->user_email .'</h5></div>
				 <div class="mall_foot">
				    <li class="layout_li">
                       <span>我的订单</span>
                       <b>'.count($ulist).'</b>
                    </li>
					<li class="layout_li">
                       <span>已购资源</span>
                       <b>'.count($plist).'</b>
                    </li>
					<li class="layout_li">
                       <span>今日下载</span>
                       <b>'.$user_downData['today_down_num'].'</b>
                    </li>
					<li class="layout_li">
                       <span>剩余下载</span>
                       <b>'.$user_downData['over_down_num'].'</b>
                    </li>';
			echo'</div>
			</div>';}else{
					echo'<div class="mall-ul'.get_wow_3().'" style="text-align: center;"><h4>您还未登陆！</h4><a href="javascript:;" class="user-login btn btn-primary" data-sign="0">登陆/注册</a></div>';
			}
			 }else if($value['type']=='asb'){
				 echo '<div class="mall-user'.get_wow_3().'">'.$value['asb'].'</div>';
			 }
		  }
		 }
			
			?>  
	  </div>
	  <?php } ?>
	  <div class="mall-content"><ul class="excerpt-mall-row">
	<?php

	foreach ($options_categories_obj as $category) {
		$options_categories[$category->cat_ID] = $category->cat_name;
	}
	
	if(isset($_GET['category'])) {
	
	$category_id=$_GET['category'];
	}else{
	$category_id=$options_categories;
	}
    $args = array(
        'post_type' => 'post', 
        'showposts' => _hui('mall_list'),
        'paged'               => $paged,		
        'tax_query' => array(
            array(
                'taxonomy' => 'mall',
                'terms' => $category_id
                ),
            )
        );
		
    $my_query = new WP_Query($args);
   
        while ($my_query->have_posts()) : $my_query->the_post();
		query_posts($args);
		$terms = get_the_terms( '', 'mall' );
		$post_ID = get_the_ID();
		$list = $wpdb->get_results("SELECT * FROM $wppay_table_name WHERE post_id=$post_ID AND status=1");
		//$type = get_post_meta($post_ID,'wppay_type',true);
		$vip=get_post_meta($post_ID,'wppay_vip_auth',true);
		$vip_price=get_post_meta($post_ID,'wppay_price_disc',true);
		
	    $price = get_post_meta($post_ID,'wppay_price',true);
		$prices=$price?$price:'暂无报价';
	    
	    $shop = new SHOP($post->ID, $user_id);
		$pay = "";
			if($shop->is_paid()){ 
				$pay = "已购买";
			}else{
				if($vip==1){$pay = "月费会员免费";}
				elseif($vip==2){$pay = "年费会员免费";}
				elseif($vip==3){$pay = "终身会员免费";}
				elseif($vip==4){$pay = "月费会员价￥".$vip_price;}
				elseif($vip==5){$pay = "年费会员价￥".$vip_price;}
				elseif($vip==6){$pay = "终身会员价￥".$vip_price;}
			}
			
	
		
	?>
       
	   <li class="excerpt-mall<?php echo get_wow_3(); ?>">
	   <?php  
      if( !empty( $terms ) ){
	  echo '<span class="mall-cat-category">';
	    foreach( $terms as $term ){
                $name = $term->name;
                $link = $current_url.'?category='.$term->term_id  ;
                echo " <a href='$link'>".$name."</a>";
           }
 
echo '</span>';
}?>
<?php echo $pay?'<span class="mall-cat-category-cat">'.$pay.'</span>':'';?>
   <a  class="focus" <?php echo _post_target_blank();?> href="<?php the_permalink(); ?>"><?php echo _get_post_thumbnail(400,300); ?></a>
  <div class="excerpt-mall-head">
    <header>
      
      <h2><a <?php echo _post_target_blank();?> href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
      
    </header>
    <p class="mall-price"><b>￥<?php echo $prices;?></b></p>
    <p class="meta">
      <span class="pv">
        <i class="fa fa-shopping-cart"></i> <?php   echo '销量：' .count($list); ?></span>
       &nbsp;&nbsp;&nbsp;
      <span class="time">
        <i class="fa fa-clock-o"></i> <?php echo get_the_time('Y-m-d')?></span>
    </p>
  
  </div>
</li>
   
        
        <?php   endwhile;    ?></ul>
<?php _moloader('mo_paging'); wp_reset_query(); ?>		
	   </div>
	   
	   </div>
	   </section>

<?php if($mall['mall_sidebar_s']){ ?>	
<script type="text/javascript">
var mallmenu=document.getElementById("mallmenu");    
    var T=0,iE6;    
    var E=mallmenu;    
    while(E){T+=E.offsetTop;E=E.offsetParent};    
    iE6=window.ActiveXObject&&!window.XMLHttpRequest;    
    if(!iE6){    
        window.onscroll=function()    
        {    
            var s=document.body.scrollTop||document.documentElement.scrollTop;   

            if(s>(T-84)){
			mallmenu.className="mallmenu affix";
			if(iE6){mallmenu.style.top=(s-T)+"px";} } else{	mallmenu.className="mallmenu";    
        }    
    }    
	}
</script>
   
<?php } ?> 
	   
	   <?php

get_footer();