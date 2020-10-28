<?php if( wp_is_mobile() && cmp_get_option( 'hide_sidebar' )):?>
  
<?php else: ?>
  <aside class="span4 sidebar-right <?php if(cmp_get_option( 'hide_sidebar' )) echo 'hide-sidebar'; ?>" role="complementary">
    <?php
    wp_reset_query();
    global $post;
    $archive_question_page = 0;
    $submit_question_page = 0; 
    if(class_exists('DW_Question_Answer')) {
      global $dwqa_general_settings;
      if(isset( $dwqa_general_settings['pages']['archive-question'] )) $archive_question_page = $dwqa_general_settings['pages']['archive-question']; 
      if(isset( $dwqa_general_settings['pages']['submit-question'] )) $submit_question_page = $dwqa_general_settings['pages']['submit-question']; 
    }
    if ( is_home() || is_404()){
      $sidebar_home = sanitize_title(cmp_get_option( 'sidebar_home' ));
      if( $sidebar_home && is_active_sidebar($sidebar_home) ){
        dynamic_sidebar( $sidebar_home );
      } elseif (is_active_sidebar('primary-widget-area')){
        dynamic_sidebar('primary-widget-area');
      } else {
        echo '<div class="the_tips">'.__('Please go to "<a target="_blank" href="/wp-admin/widgets.php"> Appearance > Widgets </a>" to set "Primary Widget Area" , Or "<a target="_blank" href="/wp-admin/admin.php?page=panel"> Theme Setting </a>" to Set [Sidebars] option .','wpdx').'</div>';
      }

    }elseif( is_page() ){

      $sidebar_page = sanitize_title(cmp_get_option( 'sidebar_page' ));

      if(
        ( has_shortcode( $post->post_content, 'dwqa-list-questions') 
          || has_shortcode( $post->post_content, 'my-dwqa-list-questions') 
          || has_shortcode( $post->post_content, 'dwqa-submit-question-form')
          || ($archive_question_page && is_page($archive_question_page))
          || ($submit_question_page && is_page($submit_question_page))
        )
        && is_active_sidebar('dwqa-widget-area')
      ){
        dynamic_sidebar('dwqa-widget-area');
      } elseif ( $sidebar_page && is_active_sidebar($sidebar_page) ){
        dynamic_sidebar( $sidebar_page );
      } elseif (is_active_sidebar('primary-widget-area')){
        dynamic_sidebar('primary-widget-area');
      } else {
        echo '<div class="the_tips">'.__('Please go to "<a target="_blank" href="/wp-admin/widgets.php"> Appearance > Widgets </a>" to set "Primary Widget Area" , Or "<a target="_blank" href="/wp-admin/admin.php?page=panel"> Theme Setting </a>" to Set [Sidebars] option .','wpdx').'</div>';
      }

    }elseif ( is_single() ){
      $sidebar_post = sanitize_title(cmp_get_option( 'sidebar_post' ));
      $post_type = get_post_type($post->ID);
      if ( $post_type == 'dwqa-question' && is_active_sidebar('dwqa-widget-area') ){
        dynamic_sidebar('dwqa-widget-area');
      } elseif ( $sidebar_post && is_active_sidebar($sidebar_post)){
        dynamic_sidebar($sidebar_post);
      } elseif (is_active_sidebar('primary-widget-area')){
        dynamic_sidebar('primary-widget-area');
      } else {
        echo '<div class="the_tips">'.__('Please go to "<a target="_blank" href="/wp-admin/widgets.php"> Appearance > Widgets </a>" to set "DWQA Widget Area".','wpdx').'</div>';
      }
    }elseif ( is_tax('dwqa-question_category') || is_tax('dwqa-question_tag') ){
      if (is_active_sidebar('dwqa-widget-area')){
        dynamic_sidebar('dwqa-widget-area');
      } elseif (is_active_sidebar('primary-widget-area')){
        dynamic_sidebar('primary-widget-area');
      } else {
        echo '<div class="the_tips">'.__('Please go to "<a target="_blank" href="/wp-admin/widgets.php"> Appearance > Widgets </a>" to set "DWQA Widget Area".','wpdx').'</div>';
      }
    }elseif ( is_category() ){
      $category_id = get_query_var('cat') ;
      $cat_sidebar = sanitize_title(cmp_get_option( 'sidebar_cat_'.$category_id )) ;
      $sidebar_archive = sanitize_title(cmp_get_option( 'sidebar_archive' ));
      if( $cat_sidebar && is_active_sidebar($cat_sidebar) ){  
        dynamic_sidebar( $cat_sidebar );
      }elseif( $sidebar_archive && is_active_sidebar($sidebar_archive) ){
        dynamic_sidebar( $sidebar_archive );
      }elseif (is_active_sidebar('primary-widget-area')){
        dynamic_sidebar('primary-widget-area');
      } else {
        echo '<div class="the_tips">'.__('Please go to "<a target="_blank" href="/wp-admin/widgets.php"> Appearance > Widgets </a>" to set "Primary Widget Area" , Or "<a target="_blank" href="/wp-admin/admin.php?page=panel"> Theme Setting </a>" to Set [Sidebars] option .','wpdx').'</div>';
      }
    }else{
      $sidebar_archive = sanitize_title(cmp_get_option( 'sidebar_archive' ));
      if( $sidebar_archive && is_active_sidebar($sidebar_archive) ){
        dynamic_sidebar( $sidebar_archive );
      } elseif (is_active_sidebar('primary-widget-area')){
        dynamic_sidebar('primary-widget-area');
      } else {
        echo '<div class="the_tips">'.__('Please go to "<a target="_blank" href="/wp-admin/widgets.php"> Appearance > Widgets </a>" to set "Primary Widget Area" , Or "<a target="_blank" href="/wp-admin/admin.php?page=panel"> Theme Setting </a>" to Set [Sidebars] option .','wpdx').'</div>';
      }
    }
    ?>
  </aside>
<?php endif;?>