<?php 
if ((!$paged || $paged===1)) { 
$module_catcms = _hui( 'catcms' );
error_reporting(E_ALL^E_NOTICE^E_WARNING);
if(!$module_catcms) echo ('<h3>请在后台-功能布局-模式风格-添加CMS模块</h3>');

?>
	<?php foreach ($module_catcms as $key => $value) { $category_id= $value['cms_cat_id']; $category_link = get_category_link( $category_id ); ?>
			<?php if ($value['cms_cat_id']) { ?>
		<section class="<?php echo !$value['cms_style']=='0'?'cms-box':'cms-row-up'; ?>">
		<div class="<?php echo !$value['cms_style']=='0'?'section-info':''; echo get_wow_1(); ?>">
        
           <h3 class="vieuttitle"><?php echo $value['cms_title'] ?> <?php echo $value['cms_style']=='0'?'<a '._post_target_blank().' class="excerpt_cms0_btn'. get_wow_1().'" href="'.$category_link.'"><i class="fa fa-plus"></i> 更多</a>':'';?>
		   </h3>
		    <div class="vieu-description"><?php echo $value['cms_subtitle'] ?></div>
		     </div>
				<?php 
				 	
					$cms_args = array(
						 'cat'      => $category_id,
						 'ignore_sticky_posts' => 1,
						 'showposts' => $value['cms_cat_num']
						 );
					query_posts($cms_args);
						get_template_part('include/cms/'.$value['cms_style']);
				   
				    wp_reset_query();
				?>
			</section>
			<?php  echo !$value['cms_style']=='0'?'<div class="pagination"><a class="btn btn-primary'.get_wow_1().'" href="'.$category_link.'">'.$value['cms_btn'].'</a></div>':''; } ?>	
	<?php } ?>		
<?php } ?>

