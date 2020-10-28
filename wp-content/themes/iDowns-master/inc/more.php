<?php

/*-----------------------------------------------------------------------------------*/

/* 创客云最新wordpress企业主题 */

/*-----------------------------------------------------------------------------------*/

function more_themes_page(){

?>
<div style="border:1px solid #ddd; background:#fff; margin:20px 0; width:95%;">
	<h2 style="border-bottom:1px solid #ddd; padding:0 15px 10px; height:36px; line-height:36px; font-family:'Microsoft Yahei';">创客云最新模板<em style="color:#f00; font-size:12px;"></em></h2>
	<?php // Get RSS Feed(s)
		include_once(ABSPATH . WPINC . '/feed.php');
		$rss = fetch_feed('https://www.22vd.com/feed');	
        // Of the RSS is failed somehow.
        if (is_wp_error($rss) ) {
            $error = $rss->get_error_code();
            if($error == 'simplepie-error') {
                //Simplepie Error
                echo "<div class='updated fade'><p>An error has occured with the RSS feed. (<code>". $error ."</code>)</p></div>";
            }
            return;
         }
	?>
	<div style="padding:15px;">		
		<form id="search" method="get" action="https://www.22vd.com/" target="_blank">
			<input type="text" class="text" name="s" id="textfield" onblur="if (this.value == '') {this.value = '输入关键词搜索...';}" onfocus="if (this.value == '输入关键词搜索...') {this.value = '';}" value="输入关键词搜索..." size="60"/>
			<input type="submit" id="submit" style="border:none; background:#000; color:#fff; cursor:pointer;" value="搜索" />
		</form>
	</div>
	<?php
		$maxitems = $rss->get_item_quantity(30); 
		$items = $rss->get_items(0, 30);		
	?>
	<ul style="padding:15px 20px; line-height:2em;">
	<?php if (empty($items)) echo '<li>No items</li>';
        else
			foreach ( $items as $item ) : ?>
			<li class="theme">
				<a href='<?php echo esc_url( $item->get_permalink() ); ?>' title='<?php echo $item->get_title(); ?>' target='_blank'><?php echo esc_html( $item->get_title() ); ?></a>
			</li>
	<?php endforeach; ?>
			<li><a href="https://www.22vd.com" target="_blank">More...</a></li>
	</ul>
	<div style="border-top:1px solid #ddd; padding:5px 15px; color:#777;">
		CopyRight &copy 2016-<?php echo date('Y');?> <b>请购买 <a href="https://www.22vd.com" target="_blank">创客云</a> 官方正版主题，我们为正版用户提供免费安装调试，免费技术支持，永久免费更新升级等售后服务！</b>
	</div>
</div>
<?php } if (!function_exists('more_themes_recommend_page')):
	function leonhere_more_themes() {
		add_menu_page("模板动态", "<strong>更多模板</strong>", "administrator", 'leonhere', 'more_themes_page',get_bloginfo('template_url').'/include/new.png');
	}
	add_action('admin_menu', 'leonhere_more_themes');
	endif;
?>