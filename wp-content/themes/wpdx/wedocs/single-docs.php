<?php
/**
* The template for displaying a single doc
*
* To customize this template, create a folder in your current theme named "wedocs" and copy it there.
*
* @package weDocs
*/

$skip_sidebar = ( get_post_meta( $post->ID, 'skip_sidebar', true ) == 'yes' ) ? true : false;

get_header(); ?>
<div id="content-header">
    <?php cmp_breadcrumbs();?>
</div>
<?php //wedocs_breadcrumbs(); ?>
<div class="container-fluid">
    <?php get_template_part('includes/ad-top' );?>
    <div class="row-fluid wedocs-single-wrap">

    <?php if ( ! $skip_sidebar ) { ?>
        <?php wedocs_get_template_part( 'docs', 'sidebar' ); ?>
    <?php } ?>
        <div class="span8">
            <?php do_action( 'wedocs_before_main_content' ); ?>

            <?php while ( have_posts() ) : the_post(); ?>

                

                <div class="wedocs-single-content widget-box">
                    <article id="post-<?php the_ID(); ?>" <?php post_class('widget-content single-post'); ?> >
                        <header id="post-header">
                            <?php the_title( '<h1 class="page-title">', '</h1>' ); ?>
                            <?php if ( wedocs_get_option( 'print', 'wedocs_settings', 'on' ) == 'on' ): ?>
                                <a href="#" class="wedocs-print-article wedocs-hide-print wedocs-hide-mobile" title="<?php echo esc_attr( __( 'Print this article', 'wpdx' ) ); ?>"><i class="wedocs-icon wedocs-icon-print"></i></a>
                            <?php endif; ?>
                        </header>

                        <div class="entry">
                            <?php
                            the_content( sprintf(
                                /* translators: %s: Name of current post. */
                                wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'wpdx' ), array( 'span' => array( 'class' => array() ) ) ),
                                the_title( '<span class="screen-reader-text">"', '"</span>', false )
                            ) );

                            wp_link_pages( array(
                                'before' => '<div class="page-links">' . esc_html__( 'Docs:', 'wpdx' ),
                                'after'  => '</div>',
                            ) );

                            $children = wp_list_pages("title_li=&order=menu_order&child_of=". $post->ID ."&echo=0&post_type=" . $post->post_type);

                            if ( $children ) {
                                echo '<div class="article-child well">';
                                echo '<h3>' . __( 'Articles', 'wpdx' ) . '</h3>';
                                echo '<ul>';
                                echo $children;
                                echo '</ul>';
                                echo '</div>';
                            }

                            $tags_list = wedocs_get_the_doc_tags( $post->ID, '', ', ' );

                            if ( $tags_list ) {
                                printf( '<span class="tags-links"><span class="screen-reader-text">%1$s </span>%2$s</span>',
                                    _x( 'Tags', 'Used before tag names.', 'wpdx' ),
                                    $tags_list
                                );
                            }
                            ?>
                            <?php if ( wedocs_get_option( 'helpful', 'wedocs_settings', 'on' ) == 'on' ): ?>
                                <?php wedocs_get_template_part( 'content', 'feedback' ); ?>
                            <?php endif; ?>
                        </div><!-- .entry -->
                        <footer class="entry-footer wedocs-entry-footer">
                            <?php if ( wedocs_get_option( 'email', 'wedocs_settings', 'on' ) == 'on' ): ?>
                                <span class="wedocs-help-link wedocs-hide-print wedocs-hide-mobile">
                                    <i class="wedocs-icon wedocs-icon-envelope"></i>
                                    <?php printf( '%s <a id="wedocs-stuck-modal" href="%s">%s</a>', __( 'Still stuck?', 'wpdx' ), '#', __( 'How can we help?', 'wpdx' ) ); ?>
                                </span>
                            <?php endif; ?>

                            <div class="wedocs-article-author" itemprop="author" itemscope itemtype="https://schema.org/Person">
                                <meta itemprop="name" content="<?php echo get_the_author(); ?>" />
                                <meta itemprop="url" content="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" />
                            </div>

                            <meta itemprop="datePublished" content="<?php echo get_the_time( 'c' ); ?>"/>
                            <time itemprop="dateModified" datetime="<?php echo esc_attr( get_the_modified_date( 'c' ) ); ?>"><?php printf( __( 'Updated on %s', 'wpdx' ), get_the_modified_date() ); ?></time>
                        </footer>
                        <?php wedocs_doc_nav(); ?>
                    </article><!-- #post-## -->
                </div><!-- .wedocs-single-content -->


                <?php if ( wedocs_get_option( 'email', 'wedocs_settings', 'on' ) == 'on' ): ?>
                    <?php wedocs_get_template_part( 'content', 'modal' ); ?>
                <?php endif; ?>

                <?php if ( wedocs_get_option( 'comments', 'wedocs_settings', 'off' ) == 'on' ): ?>
                    <?php if ( comments_open() || get_comments_number() ) : ?>
                    <div class="wedocs-comments-wrap widget-box">
                        <section class="widget-content">
                            <?php comments_template(); ?>
                        </section>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

        <?php endwhile; ?>

        <?php do_action( 'wedocs_after_main_content' ); ?>
    </div>

</div>
</div>
</div>
<?php get_footer(); ?>
