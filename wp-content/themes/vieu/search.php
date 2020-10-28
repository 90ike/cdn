<?php 
get_header();
$thelayout = the_layout();
if( !have_posts() ){
	get_template_part( 'content-404' ); 
	get_footer();
	exit;
}
?>
<section class="container">	

			<div class="pagetitle"><h1><?php echo $s; ?> 的搜索结果</h1></div>
	<div class="content-wrap">

		 <?php echo $thelayout == 'index-card' || (_hui('shuangpai_s') && $thelayout == 'index-blog')?'<div class="content vist">':'<div class="content">';?>
			
			<?php 
				if($thelayout == 'index-card'){
					get_template_part( 'include/modules/mo_card' ); 
				 }else{
					get_template_part( 'excerpt' );
				}
				_moloader('mo_paging');
			?>
			<?php _the_ads($name='ads_search_01', $class='asb-search asb-search-01') ?>
		</div>
	</div>
	<?php echo $thelayout == 'index-card' || (_hui('shuangpai_s') && $thelayout == 'index-blog')?'':get_sidebar();?>
</section>

<?php get_footer(); ?>