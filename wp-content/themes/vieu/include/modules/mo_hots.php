 <?php if($paged < 2 && (_hui('index_hots_s') || _hui('index_suiji_s'))){ 
         echo'<section class="hot_posts'.get_wow_1().'">';
		 
		 if(_hui('index_suiji_s')){echo '<div class="suiji">
           <h3>'._hui('index_suiji_h3').'</h3>
              <ul class="layout_ul">';
				           $args = array('numberposts' => _hui('index_suiji_item') , 'orderby' => 'rand', 'post_status' => 'publish');
                            $rand_posts = get_posts($args);
                            foreach ($rand_posts as $post): 
							
							echo'<li class="layout_li"><strong>['.get_the_time('m-d').']</strong><a href="'.get_permalink().'" title="'.get_the_title().'">';
							if (_hui('latest_visit_st') == 'default'){
							echo'<span>'._hui('index_suiji_text').'</span>';}
							elseif (_hui('latest_visit_st') == 'img'){echo _get_post_thumbnail();}
							elseif (_hui('latest_visit_st') == 'no'){}
							echo get_the_title().'</a></li>';
     					  endforeach; 
			echo'</ul>
		 </div>'; }?>
	<?php if(_hui('index_hots_s')){echo'<div class="hots">	
              <h3>'._hui('index_rem_h3').'</h3>	
			<ul class="layout_ul">';
			if(_hui('index_hots_set')=='views'){
				echo get_most_viewed_format(_hui('index_rem_month'), _hui('index_rem_item'));
				}elseif(function_exists('most_comm_posts') && _hui('index_hots_set')=='comment'){
				echo most_comm_posts( _hui('index_rem_date'), _hui('index_rem_item')); 
			}
			
			
     echo'</ul>
	</div>';}?>
	<?php if(_hui('index_hots_s') && _hui('index_suiji_s')){ ?>
		<style type="text/css">.hot_posts .hots, .hot_posts .suiji{width:50%;}.hot_posts .hots{padding-left: 10px;} .hot_posts .suiji{padding-right: 10px;}</style>
	<?php } ?>
	
	
<?php echo'</section>';  } ?>
 