<?php

class widget_ui_viads extends WP_Widget {
	/*function widget_ui_viads() {
		$widget_ops = array( 'classname' => 'widget_ui_viads', 'description' => '显示一个广告(包括富媒体)' );
		$this->WP_Widget( 'widget_ui_viads', 'D-特殊广告', $widget_ops );
	}*/

	function __construct(){
		parent::__construct( 'widget_ui_viads', 'Vi-特色广告', array( 'classname' => ''.get_wow_3().'' ) );
	}

	function widget( $args, $instance ) {
		extract( $args );

		$title = apply_filters('widget_name', $instance['title']);
		$tag     = isset($instance['tag']) ? $instance['tag'] : '';
		$img     = isset($instance['img']) ? $instance['img'] : '';
		$content = isset($instance['content']) ? $instance['content'] : '';
		$link    = isset($instance['link']) ? $instance['link'] : '';
		$style   = isset($instance['style']) ? $instance['style'] : '';
		$blank   = isset($instance['blank']) ? $instance['blank'] : '';
		$lank = '';
		if( $blank ) $lank = ' target="_blank"';
		echo $before_widget;
		echo '<div class="widget_pilot"><div class="module-wrap">
<div class="pilot-cell"><h1>'.$title.'</h1>';
		echo '<p>'.$content.'</p>';
		echo '<a class="alibutton" href="'.$link.'"'.$lank.'>'.$tag.'';
		echo '</a></div><div id="'.$style.'" style="background-image: url(&quot;'.$img.'&quot;);"></div>
</div>
</div>';
		echo $after_widget;
	}

	function form($instance) {
		$defaults = array( 
			'title' => '唯爱资源网', 
			'tag' => ' 立即前往', 
			'blank' => 'on', 
			'content' => '专注于网络资源搜集共享 - www.relzz.com', 
			'link' => 'http://www.relzz.com',
			'style' => 'pilot-box5',
			'img' => 'http://viapi.oss-cn-hangzhou.aliyuncs.com/update/img/music.gif'
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
?>

	
	<p>
	<label>
				名称：
				<input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $instance['title']; ?>" class="widefat" />
			</label>
		</p>
		
		<p>
			<label>
				描述：
				<textarea id="<?php echo $this->get_field_id('content'); ?>" name="<?php echo $this->get_field_name('content'); ?>" class="widefat" rows="3"><?php echo $instance['content']; ?></textarea>
			</label>
		</p>
		<p>
			<label>
				按钮名称：
				<input id="<?php echo $this->get_field_id('tag'); ?>" name="<?php echo $this->get_field_name('tag'); ?>" type="text" value="<?php echo $instance['tag']; ?>" class="widefat" />
			</label>
		</p>

		<p>
			<label>
				链接：
				<input style="width:100%;" id="<?php echo $this->get_field_id('link'); ?>" name="<?php echo $this->get_field_name('link'); ?>" type="url" value="<?php echo $instance['link']; ?>" size="24" />
			</label>
		</p>			<p>
			<label>
				背景图片：
				<input style="width:100%;" id="<?php echo $this->get_field_id('img'); ?>" name="<?php echo $this->get_field_name('img'); ?>" type="url" value="<?php echo $instance['img']; ?>" size="24" />
			</label>
		</p>
	<p>
			<label>
				图片不透明度：
				<select style="width:100%;" id="<?php echo $this->get_field_id('style'); ?>" name="<?php echo $this->get_field_name('style'); ?>" style="width:100%;">
					<option value="pilot-box1" <?php selected('pilot-box1', $instance['style']); ?>>10%</option>
					<option value="pilot-box2" <?php selected('pilot-box2', $instance['style']); ?>>20%</option>
					<option value="pilot-box3" <?php selected('pilot-box3', $instance['style']); ?>>30%</option>
					<option value="pilot-box4" <?php selected('pilot-box4', $instance['style']); ?>>40%</option>
					<option value="pilot-box5" <?php selected('pilot-box5', $instance['style']); ?>>50%</option>
					<option value="pilot-box6" <?php selected('pilot-box6', $instance['style']); ?>>60%</option>
					<option value="pilot-box7" <?php selected('pilot-box7', $instance['style']); ?>>70%</option>
					<option value="pilot-box8" <?php selected('pilot-box8', $instance['style']); ?>>80%</option>
					<option value="pilot-box9" <?php selected('pilot-box9', $instance['style']); ?>>90%</option>
					<option value="pilot-box10" <?php selected('pilot-box10', $instance['style']); ?>>100%</option>
				</select>
				
			</label>
		</p>
	
		<p>
			<label>
				<input style="vertical-align:-3px;margin-right:4px;" class="checkbox" type="checkbox" <?php checked( $instance['blank'], 'on' ); ?> id="<?php echo $this->get_field_id('blank'); ?>" name="<?php echo $this->get_field_name('blank'); ?>">新打开浏览器窗口
			</label>
		</p>
<?php
	}
}





