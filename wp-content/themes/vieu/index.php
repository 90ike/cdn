<?php 
	get_header(); 
	$thelayout = the_layout();
	//$fd_st= _hui('banner_style');
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	$banner_style = _hui('banner_style');//获取焦点图模式
	$index_s = _hui('index-s');
	function mo_tools(){//首页小工具
		if(_hui('index_tool_s')){
		echo'<div class="home-firstitems'.get_wow_1().'"><div class="container"><ul>';
	$index_tool = _hui( 'index_tool' );
	if($index_tool){
		foreach ($index_tool as $key => $value) {
		
		$bank_tool=$value['_bank']?' target="_blank"':'';
     echo '<li>
			<a href="'.$value['_url'].'"'.$bank_tool.'>
                <i class="'.$value['_ico'].'"></i>
                <strong>'.$value['_title'].'</strong>
                <p>'.$value['_subtitle'].'</p>
				<span class="btn btn-primary">'.$value['_btn'].'</span>
				</a>
            </li>
	 ';
		
	}}else{echo('<h3>请在后台-功能布局-添加小工具模块</h3>');}
	echo '</ul></div></div>';
		}
	}
	?>
	<?php if( $paged==1 && $banner_style=='qiye' && _hui('focusslide_s')){ //企业模式 ?>
	<?php echo _moloader('mo_slider', false);  ?>
	<style type="text/css">.header{background-color: transparent;}@media (max-width: 720px){.focusslide_bottom{margin-bottom: 10px;}}</style>
	<?php echo mo_tools();} ?>
				<?php if( $paged>=2){ ?><style type="text/css">body {padding-top: <?php echo $banner_style!='oldtb'?'88px':'66px';?> ;}.section-info { text-align: left;}@media (max-width: 720px){body {padding-top: 48px;}}</style>	<?php } //分页样式 ?>
				
    <section class="container">		
    
	<div class="content-wrap">
	<div class="content<?php echo ( $index_s=='index-card' || (($index_s=='index-cms' && !_hui('layout')) || (($index_s=='index-blog' && _hui('shuangpai_s')) || ($index_s=='index-blog' && !_hui('layout')))))?' vist':'';?>">
	<?php if( $paged==1 && $banner_style=='oldtb' && _hui('focusslide_s')){ //经典模式 ?>
	<style type="text/css">
	<?php if( $paged==1 && $banner_style=='oldtb') { echo'.sidebar {margin-top: 0px !important;}'; }?>
	body {padding-top: 76px;}.header{background-color: transparent;}.home-firstitems{margin-top: 15px;}@media (max-width: 720px){body {padding-top: 48px;}}</style>
	<?php echo _moloader('mo_slider', false); ?> 
	<?php echo mo_tools(); }elseif(!_hui('focusslide_s') || ( $paged==1 && $banner_style=='oldtb')){echo mo_tools();} //未开启焦点图默认经典模式 ?>
	 <?php 

			 //分页
			   if( $paged==1 && _hui('mall_index_s')) { echo _moloader('mo_mall', false);}
			   echo get_template_part( 'include/modules/mo_hots' );
			$pagedtext = ''; 
			if( $paged > 1 ){
				$pagedtext = ' <small>第'.$paged.'页</small>';
			}
			$title=_hui('index_list_title') ? _hui('index_list_title') : '最新发布';
			$title_r=_hui('index_list_title_r')?'<div class="vieu-description">'._hui('index_list_title_r').'</div>':'';
			$title_h3= '<div class="section-info'.get_wow_1().'"><h3 class="vieuttitle">'.$title.$pagedtext.'</h3>'.$title_r.'</div>'; 
			  
		?>
		
		
		
  <?php    echo _the_ads($name='ads_index_01', $class='asb-index asb-index-01') ; ?>
      
			

   <?php 
   //置顶和文章展示
   echo $title_h3;
   $pagenums = get_option( 'posts_per_page', 10 );
			$offsetnums = 0;
			$stickyout = 0;
			$sticky_ids = get_option('sticky_posts');
			if( _hui('home_sticky_s') && in_array(_hui('home_sticky_n'), array('1','2','3','4','5')) && $pagenums>_hui('home_sticky_n') && count($sticky_ids)>0 ){
				if( $paged <= 1 ){
					$pagenums -= count($sticky_ids);
					rsort( $sticky_ids );
					$args = array(
						'post__in'            => $sticky_ids,
						'showposts'           => _hui('home_sticky_n'),
						'ignore_sticky_posts' => 1
					);
					query_posts($args);
					get_template_part( 'excerpt' );
					wp_reset_query();
				}else{
					$offsetnums = _hui('home_sticky_n');
				}
				$stickyout = get_option('sticky_posts');
			}


			$args = array(
				'post__not_in'        => array(),
				'ignore_sticky_posts' => 1,
				'showposts'           => $pagenums,
				'paged'               => $paged
			);
			if( $offsetnums ){
				$args['offset'] = $pagenums*($paged-1) - $offsetnums;
			}
			if( _hui('notinhome') ){
				$pool = array();
				foreach (_hui('notinhome') as $key => $value) {
					if( $value ) $pool[] = $value;
				}
				if( $pool ) $args['cat'] = '-'.implode($pool, ',-');
			}
			if( _hui('notinhome_post') ){
				$pool = _hui('notinhome_post');
				$args['post__not_in'] = explode("\n", $pool);
			}
			if( $stickyout ){
				$args['post__not_in'] = array_merge($stickyout, $args['post__not_in']);
			}
		
   
   
   
   if($thelayout == 'index-cms'){//CMS模式
			echo '<style>.sidebar{margin-top: 15px;}</style>';
				if(_hui('index_cms_new')){
					
					
			query_posts($args);
			get_template_part( 'excerpt' ); 
			_moloader('mo_paging');
			wp_reset_query();
					} 
					get_template_part( 'include/modules/mo_cms' ); 
		 }else if($thelayout == 'index-card'){//CARD模式
		 echo '<style>.sidebar{margin-top: 15px;}</style>';
			
			query_posts($args);
			get_template_part( 'include/modules/mo_card' ); 
			_moloader('mo_paging');
			wp_reset_query();
		  }else{//博客模式
			  
		  echo '<style>.sidebar{margin-top: 15px;}</style>';
			
		         query_posts($args);
		        get_template_part( 'excerpt' );
				_moloader('mo_paging');
				 wp_reset_query();
				} 
   
   
  
			
				   
		?>
	
	     
	<?php _the_ads($name='ads_index_02', $class='asb-index asb-index-02') ?>
	</div>
		</div>
		<?php echo $thelayout == 'index-card' || (_hui('shuangpai_s') && $thelayout == 'index-blog')?'':get_sidebar();?>
		
		</section>

    <?php  if($paged==1 ){ echo get_template_part( 'include/modules/mo_about' );} ?>
	<?php if(_hui('home_vip_s') && $paged==1) { echo get_template_part( 'include/modules/mo_vip' ); } ?>

	
<?php get_footer();  