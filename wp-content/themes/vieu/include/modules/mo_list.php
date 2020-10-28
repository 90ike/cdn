<h4 class="h4_title"><?php wp_list_categories('include=4&title_li=&style=none'); ?></h4>
<?php query_posts('cat=4&showposts=8'); ?>
<?php while (have_posts()) : the_post();	
echo'<li class="item-'.$x++.'"><span class="label label-'.$a++.'">'._hui('index_suiji_text').'</span><span class="date">['.get_the_time('m-d').']</span>
                     <a href="'.get_permalink().'">';echo get_the_title();echo'</a></li>';
					 endwhile; ?>