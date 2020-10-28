<?php get_header(); ?>
<div id="content-header">
    <?php cmp_breadcrumbs();?>
</div>
<div class="container-fluid">
    <?php get_template_part('includes/ad-top' );?>
    <div class="row-fluid">
        <section class="span8 archive-list">
            <div class="widget-box" role="main">
                <header id="archive-head">
                <div class="archive-orderby">
                    <a class="<?php echo ( !isset($_GET['orderby']) || (isset($_GET['orderby']) && $_GET['orderby'] == "date" )) ? 'active' : '' ?>" href="<?php echo esc_url( add_query_arg( 'orderby', 'date', $_SERVER['REQUEST_URI'] ) ); ?>"><?php _e('By date', 'wpdx');?></a>
                    <a class="<?php echo ( isset($_GET['orderby']) && $_GET['orderby'] == "views") ? 'active' : '' ?>" href="<?php echo esc_url( add_query_arg( 'orderby', 'views', $_SERVER['REQUEST_URI'] ) ); ?>"><?php _e('By views', 'wpdx');?></a>
                </div>
                    <h1>
                        <?php echo __('Archive: ','wpdx') .trim(wp_title('',0)); ?>
                    </h1>
                </header>
                <?php get_template_part( 'loop', 'category' );?>
            </div>
        </section>
        <?php get_sidebar(); ?>
    </div>
    <?php get_template_part('includes/ad-bottom' );?>
</div>
</div>
<?php get_footer(); ?>