	<?php if(_hui('footer_about')){ ?>
	<section class="container-about" style="background-image: url(<?php echo _hui_img('footer_about_img');?>)">
	<div class="home-overlay"></div>
		<div class="container">
			<h3><?php echo _hui('footer_about_h3');?></h3>
			<p><?php echo _hui('footer_about_text');?></p>
			<a <?php if( _hui('footer_about_blank')){echo'target="_blank"';} ?> href="<?php echo _hui('footer_about_url'); ?>" class="btn btn-wiht"><?php echo _hui('footer_about_button'); ?></a>
		</div>
	</section><?php } ?>