<?php
/*
Template Name: 无评论页面
*/
get_header();
$span = 'span8';
if(cmp_get_option('remove_page_sidebar')){
  $span = 'span12';
}
?>
<div id="content-header">
  <?php cmp_breadcrumbs();?>
</div>
<div class="container-fluid">
  <?php get_template_part('includes/ad-top' );?>
  <div class="row-fluid">
    <div class="<?php echo $span; ?>">
      <?php if ( ! have_posts() ) : ?>
        <div class="widget-box">
          <article class="widget-content single-post">
            <header class="entry-header">
              <h1 class="page-title"><?php _e( 'Not Found', 'wpdx' ); ?></h1>
            </header>
            <div class="entry">
              <p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'wpdx' ); ?></p>
              <?php get_search_form(); ?>
            </div>
          </article>
        </div>
      <?php endif; ?>

      <?php while ( have_posts() ) : the_post(); ?>
        
        <div class="widget-box">
          <article class="widget-content single-post">
            <header id="post-header">
              <h1 class="page-title"><?php the_title(); ?></h1>
            </header>
            <div class="entry">
              <?php the_content(); ?>
              <?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'wpdx' ), 'after' => '</div>' ) ); ?>
            </div>
          </article>
        </div>
      <?php endwhile;?>

    </div>
    <?php if(!cmp_get_option('remove_page_sidebar')) get_sidebar(); ?>
  </div>
  <?php get_template_part('includes/ad-bottom' );?>
</div>
</div>
<?php get_footer(); ?>