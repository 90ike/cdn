<?php

get_header();
$thelayout = the_layout();
global $wp_query;
$curauth = $wp_query->get_queried_object();

?>
<style>.sidebar{margin-top: 95px;}</style>
<div class="focusslide_bottom"></div>
<section class="container">
	<div class="content-wrap">
	 <?php echo $thelayout == 'index-card' || (_hui('shuangpai_s') && $thelayout == 'index-blog')?'<div class="content vist">':'<div class="content">';?>
		<?php 
		$pagedtext = '';
		if( $paged && $paged > 1 ){
			$pagedtext = ' <small>第'.$paged.'页</small>';
		}


		// echo '<div class="pagetitle"><h1>'.$curauth->display_name.'的文章</h1>'.$pagedtext.'</div>';

		echo '<div class="authorleader'.get_wow_1().'">';
			echo _get_the_avatar($curauth->ID, $curauth->user_email);
			echo '<h1>'.$curauth->display_name.'的文章</h1>';
			echo '<div class="authorleader-desc">'.get_the_author_meta('description', $curauth->ID).'</div>';
		echo '</div>';
		 
				if($thelayout == 'index-card'){
					get_template_part( 'include/modules/mo_card' ); 
				 }else{
					get_template_part( 'excerpt' );
				}
				_moloader('mo_paging');
		
		?>
	</div>
	</div>
	<?php echo $thelayout == 'index-card' || (_hui('shuangpai_s') && $thelayout == 'index-blog')?'':get_sidebar();?>
</section>

<?php get_footer(); ?>