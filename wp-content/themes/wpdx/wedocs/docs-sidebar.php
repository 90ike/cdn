<div class="span4 sidebar wedocs-sidebar wedocs-hide-mobile">
    <?php
    $ancestors = [];
    $root      = $parent = false;

    if ( $post->post_parent ) {
        $ancestors = get_post_ancestors( $post->ID );
        $root      = count( $ancestors ) - 1;
        $parent    = $ancestors[$root];
    } else {
        $parent = $post->ID;
    }

    // var_dump( $parent, $ancestors, $root );
    $walker   = new WeDevs\WeDocs\Walker();
    $children = wp_list_pages( [
        'title_li'  => '',
        'order'     => 'menu_order',
        'child_of'  => $parent,
        'echo'      => false,
        'post_type' => 'docs',
        'walker'    => $walker,
    ] );
    ?>

    <div class="widget-box widget widget-docs">
        <div class="widget-content">
            <div class="widget-title">
                <span class="icon"><i class="fa fa-list fa-fw"></i></span>
                <h3><?php echo get_post_field( 'post_title', $parent, 'display' ); ?></h3>
            </div>
            <?php if ($children) { ?>
                <ul class="doc-nav-list">
                    <?php echo $children; ?>
                </ul>
            <?php } ?>
        </div>
    </div>
    <div class="widget-box widget wedocs-search-widget">
        <div class="widget-content">
            <?php if( function_exists( 'cmp_wedocs_search_form' ) ) cmp_wedocs_search_form(); ?>
        </div>
    </div>
</div>