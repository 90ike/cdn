<?php

	echo "<div class='wpfp-span'>";

	if ($favorite_post_ids) {

		$user_favorite_count = count($favorite_post_ids);
        echo '<div class="post-count">'.sprintf(__("You have favorited %s posts",'wpdx'), $user_favorite_count).'</div>';
	
			$favorite_post_ids = array_reverse($favorite_post_ids);
			$post_per_page = WPFavoritePostsAdminPageFramework::getOption( 'WPFavoritePosts', array( 'display_options', 'post_per_page' ), 'default' );
			
			$page = intval(get_query_var('paged'));

			$qry = array('post__in' => $favorite_post_ids, 'posts_per_page'=> $post_per_page, 'orderby' => 'post__in', 'paged' => $page, 'ignore_sticky_posts' => true);
			// custom post type support can easily be added with a line of code like below.
			$qry['post_type'] = array('post','download','page','dwqa-question');
			query_posts($qry);
			
			echo '<table class="wpuf-table post" cellpadding="0" cellspacing="0">
					<thead>
					<tr>
					<th class="uf-title">'.__( 'Title', 'wpdx' ).'</th>
					<th class="uf-options">'.__( 'Options', 'wpdx' ).'</th>
					</tr>
					</thead>
					<tbody>';
			while ( have_posts() ) : the_post();
					echo '<tr><td class="p-title">';
					echo '<a href="'.get_permalink().'" title="'. get_the_title() .'"><img src="'.post_thumbnail_src(45,45).'" alt="'. get_the_title().'" width="45" height="45" />'.get_the_title() . '</a></td>
					<td>';
					wpfp_remove_favorite_link(get_the_ID());
					echo "</td></tr>";
			endwhile;
			echo "</tbody></table>";

			//echo wpfp_clear_list_link();
			wpfp_cookie_warning();

			echo '<div class="navigation">';
					if(function_exists('cmp_pagenavi') ) { cmp_pagenavi(); } else {
						echo '<div class="alignleft">' . next_posts_link( __( '&larr; Previous Entries', 'wpdx' ) ) . '</div>';
						echo '<div class="alignright">' . previous_posts_link( __( 'Next Entries &rarr;', 'wpdx' ) ) . '</div>';
					}
			echo '</div>';

			wp_reset_query();
	} else {
			$favorites_empty = WPFavoritePostsAdminPageFramework::getOption( 'WPFavoritePosts', array( 'label_options', 'favorites_empty' ), 'default' );
			echo "$favorites_empty";
	}
	
echo "</div>";