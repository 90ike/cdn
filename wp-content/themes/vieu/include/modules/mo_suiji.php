<?php echo
    '<section class="container"><div class="content-wrap"><div class="section-info"> 
		<h3 class="vieuttitle">'._hui('index_suiji_h3').'</h3> 
		<div class="vieu-description">'._hui('index_suiji_text').'</div> 
	</div>
          <div class="excerpts-wrapper">
             <div class="excerpts"> ';
			 $args = array('numberposts' => _hui('index_suiji_item') , 'orderby' => 'rand', 'post_status' => 'publish');
                    $rand_posts = get_posts($args);
                    foreach ($rand_posts as $post): 		
                    echo '<article class="excerpt-page excerpt-c4'.get_wow_1().'">
					<a class="thumbnail" href="'.get_permalink().'">'._get_post_thumbnail().'</a>
					<h2><a href="'.get_permalink().'" title="'.get_the_title().'">'.get_the_title().'</a></h2>
					<footer>
					<strong><i class="fa fa-clock-o"></i>  '.get_the_time('m-d').'</strong>
					<strong>评论(' . get_comments_number('0', '1', '%'). ')</strong>
					</footer></article>';
     				endforeach; 
		   echo'</div> </div></div>';
     echo'</section>';  ?>