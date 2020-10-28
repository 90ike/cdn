<?php 
/**
 * [mo_posts_related description]
 * @param  string  $title [description]
 * @param  integer $limit [description]
 * @return html         [description]
 */
function mo_posts_related($title='相关阅读', $limit=6){
    global $post;

    $exclude_id = $post->ID; 
    $posttags = get_the_tags(); 
    $i = 0;
    $thumb_s = _hui('post_related_style');
    
    echo '<div class="'.$thumb_s,get_wow_2();if( _hui('related_m')) { echo ' relates-m';} echo'"><h3>'.$title.'</h3><ul>';
    if ( $i < $limit ) { 
        $cats = ''; foreach ( get_the_category() as $cat ) $cats .= $cat->cat_ID . ',';
        $args = array(
            'category__in'        => explode(',', $cats), 
            'post__not_in'        => explode(',', $exclude_id),
            'ignore_sticky_posts' => 1,
            'orderby'             => 'comment_date',
            'posts_per_page'      => $limit - $i
        );
        query_posts($args);
        while( have_posts() ) { the_post();
            echo '<li class="'.get_wow_4().'">';
            echo '<a href="'.get_permalink().'">'._get_post_thumbnail();
            echo '<h4>'.get_the_title().get_the_subtitle().'</h4><time> '.get_the_time('Y-m-d').'</time></a></li>';
            $i ++;
        };
        wp_reset_query();
    }
    if ( $i == 0 ){
        echo '<li style="padding-left: 20px;">暂无文章</li>';
    }
    
    echo '</ul></div>';
}