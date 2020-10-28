<?php 
get_header(); 
$pagedtext = '';
$thelayout = the_layout();
if( $paged && $paged > 1 ){
	$pagedtext = ' <small>第'.$paged.'页</small>';
}
?>
<section class="container">		
<div class="pagetitle"><h1><?php 
			if(is_day()) echo the_time('Y年m月j日');
			elseif(is_month()) echo the_time('Y年m月');
			elseif(is_year()) echo the_time('Y年'); 
		?>的文章</h1><?php echo $pagedtext ?></div>
	<div class="content-wrap">
	 <?php echo $thelayout == 'index-card' || (_hui('shuangpai_s') && $thelayout == 'index-blog')?'<div class="content vist">':'<div class="content">';?>

		<?php 
			get_template_part( 'excerpt' ); 
			_moloader('mo_paging');
		?>
	</div>
	</div>
	<?php echo $thelayout == 'index-card' || (_hui('shuangpai_s') && $thelayout == 'index-blog')?'':get_sidebar();?>
</section>

<?php get_footer(); ?>