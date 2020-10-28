<?php

class widget_ui_product extends WP_Widget {
	/*function widget_ui_product() {
		$widget_ops = array( 'classname' => 'widget_ui_product', 'description' => '显示一个广告(包括富媒体)' );
		$this->WP_Widget( 'widget_ui_product', 'Vi-产品展示', $widget_ops );
	}*/

	function __construct(){
		parent::__construct( 'widget_ui_product', 'Vi-产品展示', array( 'classname' => ''.get_wow_3().'' ) );
	}

	function widget( $args, $instance ) {
		extract( $args );

		$name     = isset($instance['name']) ? $instance['name'] : '';
		$img     = isset($instance['img']) ? $instance['img'] : '';
		$content = isset($instance['content']) ? $instance['content'] : '';
		$link    = isset($instance['link']) ? $instance['link'] : '';
		$pricet   = isset($instance['pricet']) ? $instance['pricet'] : '';
		$price   = isset($instance['price']) ? $instance['price'] : '';
		$pricebtn   = isset($instance['pricebtn']) ? $instance['pricebtn'] : '';
		$blank   = isset($instance['blank']) ? $instance['blank'] : '';
		$lank = '';
		if( $blank ) $lank = ' target="_blank"';
		echo $before_widget;
				echo'<div class="widget_product">
            <img title="'.$name.'" src="'.$img.'">
            <div class="product_content">
                <div class="product_info">
                <h2>'.$name.'</h2>
                 <ul>'.$content.'</ul>
                </div>
				<div class="price_sale"><strong><small>￥</small>'.$price.'</strong><h2>'.$pricet.'</h2></div>
                <a'.$lank.' class="btn btn-primary" href="'.$link.'">'.$pricebtn.'</a>
            </div>
    </div>';
		echo $after_widget;
	}

	function form($instance) {
		$defaults = array( 
			'name' => 'WordPress多功能Vieu主题', 
			'pricebtn' => '立即购买', 
			'blank' => 'off', 
			'content' => '<li><i class="fa fa-check"></i> 一次购买包永久免费更新</li>
					 <li><i class="fa fa-check"></i> 承诺实现每月更新不断完善</li>
					<li><i class="fa fa-check"></i> 强大的模板群为你解决主题问题</li>
					<li><i class="fa fa-check"></i> 全部开关设置无需任何代码修改</li>', 
			'link' => 'http://www.vizyw.com/3132.html',
			'pricet' => '官方统一售价',
			'price' => '69',
			'img' => 'https://viapi.oss-cn-hangzhou.aliyuncs.com/update/img/banner_1.jpg'
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
?>

	
	<p>
	<label>
				产品标题：
				<input id="<?php echo $this->get_field_id('name'); ?>" name="<?php echo $this->get_field_name('name'); ?>" type="text" value="<?php echo $instance['name']; ?>" class="widefat" />
			</label>
		</p>
		<p>
	<label>
				产品图片：
				<input id="<?php echo $this->get_field_id('img'); ?>" name="<?php echo $this->get_field_name('img'); ?>" type="text" value="<?php echo $instance['img']; ?>" class="widefat" />
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
				售价：
				<input id="<?php echo $this->get_field_id('price'); ?>" name="<?php echo $this->get_field_name('price'); ?>" type="text" value="<?php echo $instance['price']; ?>" class="widefat" />
			</label>
		</p>
				<p>
	<label>
				售价描述：
				<input id="<?php echo $this->get_field_id('pricet'); ?>" name="<?php echo $this->get_field_name('pricet'); ?>" type="text" value="<?php echo $instance['pricet']; ?>" class="widefat" />
			</label>
		</p>
		<p>
	<label>
				购买地址：
				<input id="<?php echo $this->get_field_id('link'); ?>" name="<?php echo $this->get_field_name('link'); ?>" type="text" value="<?php echo $instance['link']; ?>" class="widefat" />
			</label>
		</p>
		<p>
			<label>
				按钮名称：
				<input id="<?php echo $this->get_field_id('pricebtn'); ?>" name="<?php echo $this->get_field_name('pricebtn'); ?>" type="text" value="<?php echo $instance['pricebtn']; ?>" class="widefat" />
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





