<?php get_header(); 
$thelayout = the_layout();
?>


<section class="container">
<?php echo '<div class="pagetitle"><h1>标签：', single_tag_title(), '</h1>'.$pagedtext.'</div>'; ?>
	<div class="content-wrap">
	 <?php echo $thelayout == 'index-card' || (_hui('shuangpai_s') && $thelayout == 'index-blog')?'<div class="content vist">':'<div class="content">';?>
		<?php 
		$pagedtext = '';
		if( $paged && $paged > 1 ){
			$pagedtext = ' <small>第'.$paged.'页</small>';
		}

	
				if($thelayout == 'index-card'){
					get_template_part( 'include/modules/mo_card' ); 
				 }else{
					get_template_part( 'excerpt' );
				}
				_moloader('mo_paging');
			
	
		echo  _the_ads($name='ads_tag_01', $class='asb-tag asb-tag-01');
		?>
	</div>
	</div>
	<?php echo $thelayout == 'index-card' || (_hui('shuangpai_s') && $thelayout == 'index-blog')?'':get_sidebar();?>
</section>


<?php get_footer(); ?>