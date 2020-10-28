<?php 
/**
 * Template name: 联系我们
 * Description:   一个邮件发送表单页面
 */
 
get_header();
$name = '';
$mail = '';
if(is_user_logged_in()){
    global $current_user;
    $name = $current_user->display_name;
    $mail = !empty($current_user->user_email) ? $current_user->user_email : '';
}

?>
<section class="container container-no-sidebar">
      <!-- breadcrumb -->
    <div class="breadcrumb">
    <?php echo '<a href="'.get_bloginfo('url').'"><i class="fa fa-home"></i>首页</a> / '.get_the_title(); ?>
    </div>
	<div class="content">
	    <?php while (have_posts()) : the_post(); ?>
	    <header class="article-header">
			<h1 class="article-title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h1>
		</header>
		<?php the_content(); ?>
	<div id="mailmessage">
		<form method="post" id="mailmessage-form">
		    <div class="mailmessage-box-txt">
				<textarea name="t-comment" id="t-comment" rows="8" class="text_input long" placeholder="<?php _e('投诉举报内容...','ming'); ?>" tabindex='11'></textarea>
			</div>
			<div class="mailmessage-box">
				<label for="t-name"><i class="fa fa-user"></i></label>
				<input name="t-name" type="text" id="t-name" class="text_input" size="24" value="<?php echo $name; ?>" tabindex='8' placeholder="<?php _e('你的称呼','ming'); ?>" />
			</div>
			<div class="mailmessage-box">
				<label for="t-email"><i class="fa fa-envelope"></i></label>
				<input name="t-email" type="text" id="t-email" class="text_input" size="24" value="<?php echo $mail; ?>" tabindex='9'    placeholder="<?php _e('你的邮件地址','ming'); ?>" /><br/>
			</div>
			<div class="mailmessage-box">
				<?php $num1=rand(0,50);	$num2=rand(0,50); ?>
				<label for='math'><i class="fa fa-key"></i></label>
				<input type='text' name='sum' id='captcha2' class='math_textfield' value='' size='22' tabindex='10' placeholder="<?php echo $num1.'+'.$num2.'= ?'; ?>"/>
				<input type='hidden' id='t-num1' name='num1' value="<?php echo $num1; ?>"/>
				<input type='hidden' id='t-num2' name='num2' value="<?php echo $num2; ?>"/>
			</div>
			<p class="err"></p>
            <div class="mailmessage-box-txt">
			<input id="submit-mail" name="submit" type="submit" value="<?php _e('发   送','ming'); ?>" tabindex='12' />
            </div>
		</form>
	</div>
	<?php endwhile;  ?>
	</div>
</section>
<?php get_footer(); ?>