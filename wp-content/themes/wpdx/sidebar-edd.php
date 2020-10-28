<?php if( wp_is_mobile() && cmp_get_option( 'hide_sidebar' )):?>
  
  <?php else: ?>
  <aside class="span4 sidebar-right <?php if(cmp_get_option( 'hide_sidebar' )) echo 'hide-sidebar'; ?>" role="complementary">
      <?php
      wp_reset_query();
      global $post;
      $post_type = get_post_type($post->ID);
      if ( is_single() && $post_type == 'download'){
        if (is_active_sidebar('edd-download-widget-area')){
          dynamic_sidebar( 'edd-download-widget-area' );
        } elseif (is_active_sidebar('edd-archive-widget-area')){
          dynamic_sidebar('edd-archive-widget-area');
        } elseif (is_active_sidebar('primary-widget-area')){
          dynamic_sidebar('primary-widget-area');
        } else {
          echo '<div class="the_tips">'.__('Please go to "<a target="_blank" href="/wp-admin/widgets.php"> Appearance > Widgets </a>" to set "EDD Single Download Widget Area".','wpdx').'</div>';
        }
      }else{
        if (is_active_sidebar('edd-archive-widget-area')){
          dynamic_sidebar('edd-archive-widget-area')
        } elseif (is_active_sidebar('primary-widget-area')){
          dynamic_sidebar('primary-widget-area');
        } else {
          echo '<div class="the_tips">'.__('Please go to "<a target="_blank" href="/wp-admin/widgets.php"> Appearance > Widgets </a>" to set "EDD Archive Widget Area".','wpdx').'</div>';
        }
      }
      ?>
  </aside>
<?php endif;?>