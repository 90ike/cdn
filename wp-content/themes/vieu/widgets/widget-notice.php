<?php

class widget_ui_notice extends WP_Widget {
	/*function widget_ui_notice() {
		$widget_ops = array( 'classname' => 'widget_ui_notice', 'description' => '显示一个广告(包括富媒体)' );
		$this->WP_Widget( 'widget_ui_notice', 'D-产品展示', $widget_ops );
	}*/

	function __construct(){
		parent::__construct( 'widget_ui_notice', 'Vi-关于我们+统计', array( 'classname' => ''.get_wow_3().'' ) );
	}

	function widget( $args, $instance ) {
		extract( $args );

		global $wpdb;
        $count_posts = wp_count_posts();
        $comments = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->comments");
        $users = $wpdb->get_var("SELECT COUNT(ID) FROM $wpdb->users");
        $last = $wpdb->get_results("SELECT MAX(post_modified) AS MAX_m FROM $wpdb->posts WHERE (post_type = 'post' OR post_type = 'page') AND (post_status = 'publish' OR post_status = 'private')");$last = date('Y-n-j H:i', strtotime($last[0]->MAX_m));
		$title     = isset($instance['title']) ? $instance['title'] : ''; //标题
		$img     = isset($instance['img']) ? $instance['img'] : ''; //时间背景
		$content = isset($instance['content']) ? $instance['content'] : ''; //描述
		$alt    = isset($instance['alt']) ? $instance['alt'] : ''; //关键字
	    $stat   = isset($instance['stat']) ? $instance['stat'] : ''; //统计
		$times   = isset($instance['times']) ? $instance['times'] : ''; //时间
		$infinity   = isset($instance['infinity']) ? $instance['infinity'] : ''; 
		$rand = rand(1,4000);
		$infinity_img = 'https://wallpaper.infinitynewtab.com/wallpaper/'.$rand.'.jpg';
		echo $before_widget; 
		if($times){echo'<script>
          function getTimes(){
               
                var date = new Date();
                
                var hours = date.getHours();
				var iMinute=date.getMinutes();
	            var iSecond=date.getSeconds();
                var hour=document.getElementById("vi-hour");
                var minute=document.getElementById("vi-minute");
                var second=document.getElementById("vi-second");
                hour.innerHTML = AddZero(hours);
				minute.innerHTML = AddZero(iMinute);
				second.innerHTML = AddZero(iSecond);
            }
           
            setInterval("getTimes()",1000);
           function AddZero(n){
	         if(n<10){
		      return "0"+n;
	        }
	       return ""+n;
           }
	  </script>';}
    echo '<div class="widget_about">';
    if ($times) {
        echo '<ul class="countdown">
    <li>
      <span id="vi-hour" class="hours">00</span>
      <p class="hours_ref">hours</p></li>
    <li class="seperator">:</li>
    <li>
      <span id="vi-minute" class="minutes">00</span>
      <p class="minutes_ref">minutes</p></li>
    <li class="seperator">:</li>
    <li>
      <span id="vi-second" class="seconds">00</span>
      <p class="seconds_ref">seconds</p></li>
  </ul>';
    }
    echo '<section class="about">';
    if ($times) { if ($infinity){echo '<img src="'.$infinity_img.'" alt="'.$title.'">';}else{echo '<img src="'.$img.'" alt="'.$title.'">';}}
    echo '<h3>'.$title.'</h3>';
    echo '<span>'.$alt.'</span>';
    echo '<div class="excerpt"><p>'.$content.'</p>';
    echo'</div>';
    if ($stat) {
        echo '<ul class="layout_ul">
      <li class="layout_li">
        <span>文章</span>
        <b>' . $count_posts->publish . '</b>
      </li>
      <li class="layout_li">
        <span>评论</span>
        <b>' . $comments . '</b>
      </li>
      <li class="layout_li">
        <span>标签</span>
        <b>' . wp_count_terms('post_tag') . '</b>
      </li>
      <li class="layout_li">
        <span>用户</span>
        <b>' . $users . '</b>
      </li>
    </ul>';
    }
    echo '</section>
</div>';
		echo $after_widget;
	}

	function form($instance) {
		$defaults = array( 
			'title' => '关于唯爱资源网', 
			'alt' => '专注于网络资源搜集共享与发布！', 
			'content' => '本站从2014年开始至今始终坚持免费搜集分享各种网络资源，现如今本站已发展形成网站源码、主题模板、WordPress教程、破解软件、电脑软件、操作系统、经验教程、影视资源等各个领域的资源！', 
			'stat' => 'off', 
			'times' => 'off', 
			'infinity' => 'off', 
			'img' => get_template_directory_uri() . '/static/img/about_bg.png'
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
?>

	
	
	<label>
	<p>
			<label>
				<input style="vertical-align:-3px;margin-right:4px;" class="checkbox" type="checkbox" <?php checked( $instance['stat'], 'on' ); ?> id="<?php echo $this->get_field_id('stat'); ?>" name="<?php echo $this->get_field_name('stat'); ?>">站点统计
			</label>
		</p>
		<p>
			<label>
				<input style="vertical-align:-3px;margin-right:4px;" class="checkbox" type="checkbox" <?php checked( $instance['times'], 'on' ); ?> id="<?php echo $this->get_field_id('times'); ?>" name="<?php echo $this->get_field_name('times'); ?>">显示时间
			</label>
		</p>
		<p>
			<label>
				<input style="vertical-align:-3px;margin-right:4px;" class="checkbox" type="checkbox" <?php checked( $instance['infinity'], 'on' ); ?> id="<?php echo $this->get_field_id('infinity'); ?>" name="<?php echo $this->get_field_name('infinity'); ?>">infinity时间背景
			</label>
		or
			<label>
				自定义背景：
				<input style="width:100%;" id="<?php echo $this->get_field_id('img'); ?>" name="<?php echo $this->get_field_name('img'); ?>" type="url" value="<?php echo $instance['img']; ?>" size="24" />
			</label>
		</p><p>
				标题：
				<input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $instance['title']; ?>" class="widefat" />
			</label>
		</p>
		<p>
			<label>
				关键字：
				<input id="<?php echo $this->get_field_id('alt'); ?>" name="<?php echo $this->get_field_name('alt'); ?>" type="text" value="<?php echo $instance['alt']; ?>" class="widefat" />
			</label>
		</p>
		<p>
			<label>
				描述：
				<textarea id="<?php echo $this->get_field_id('content'); ?>" name="<?php echo $this->get_field_name('content'); ?>" class="widefat" rows="3"><?php echo $instance['content']; ?></textarea>
			</label>
		</p>
		
		
		
<?php
	}
}
