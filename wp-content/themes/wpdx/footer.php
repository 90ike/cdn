<footer id="footer" class="row-fluid" role="contentinfo">
    <?php if( has_nav_menu( 'foot-menu' ) ): ?>
        <div class="span12 footer-nav">
            <ul>
                <?php wp_nav_menu(array('container' => false, 'items_wrap' => '%3$s', 'theme_location' => 'foot-menu', 'fallback_cb' => 'cmp_nav_fallback')); ?>
            </ul>
        </div>
    <?php endif; ?>
    <div class="span12 footer-info"><?php echo htmlspecialchars_decode(cmp_get_option('footer_code')); ?></div>
</footer>
<?php wp_footer(); ?>
<div class="returnTop" title="<?php _e('Return top','wpdx'); ?>">
    <span class="s"></span>
    <span class="b"></span>
    <?php _e('Return top','wpdx'); ?>
</div>
</div>
</body>
</html>