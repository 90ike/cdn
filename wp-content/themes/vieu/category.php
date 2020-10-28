<?php 
get_header(); 
$thelayout = the_layout();
// paging
$pagedtext = '';
if( $paged && $paged > 1 ){
	$pagedtext = ' <small>第'.$paged.'页</small>';
}

_moloader('mo_is_minicat', false);

$description = trim(strip_tags(category_description()));
?>

<?php if( mo_is_minicat() ){ ?>
	<div class="container">
		<div class="section-info"> 
		<h3 class="vieuttitle"><?php single_cat_title(); echo $pagedtext; ?></h3>
		<div class="vieu-description"><?php echo $description ? $description : '去分类设置中添加分类描述吧' ?></div>
		</div>
	</div>
<?php } ?>

<section class="container">

			<?php _the_ads($name='ads_cat_01', $class='asb-cat asb-cat-01') ?>
			<?php 
				if( mo_is_minicat() ){
					echo'<div class="content-wrap"><div class="content vist ggrili">';
					while ( have_posts() ) : the_post(); 
					    echo '<article class="content-ggbox'.get_wow_1().'">'._get_the_avatar(get_the_author_meta('ID'), get_the_author_meta('email'));
							
					        
					        echo '<div class="content-gg"><div class="tag-boder">
				<div class="tag">
				</div>
			</div><h2><a'._post_target_blank().' href="'.get_permalink().'" title="'.get_the_title()._get_delimiter().get_bloginfo('name').'">'.get_the_title().'</a></h2>';
					        echo mb_strimwidth(strip_tags(apply_filters('the_content', $post->post_content)), 0, 200,"......"); echo '<time><i class="fa fa-clock-o"></i> '.get_the_time('Y-m-d').'</time></div>';
							
					    echo '</article>';

					endwhile; 
					_moloader('mo_paging');
					echo'</div></div>';
					wp_reset_query();

					

				}else{
					echo '<div class="catleader'.get_wow_1().'"><div class="section-info"> <h3 class="vieuttitle">', single_cat_title(), $pagedtext.'</h3>'.'<div class="catleader-desc">'.$description.'</div></div><div class="content-wrap">
		                     ';
					echo $thelayout == 'index-card' || (_hui('shuangpai_s') && $thelayout == 'index-blog')?'<div class="content vist">':'<div class="content">';
			 
				if($thelayout == 'index-card'){
					get_template_part( 'include/modules/mo_card' ); 
				 }else{
					get_template_part( 'excerpt' );
				}
					_moloader('mo_paging'); echo'</div> </div>';  
					echo $thelayout == 'index-card' || (_hui('shuangpai_s') && $thelayout == 'index-blog')?'':get_sidebar();}
			?>

</section>

<?php get_footer(); ?>