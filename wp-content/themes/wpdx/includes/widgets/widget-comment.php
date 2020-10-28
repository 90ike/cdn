<?php
//widget new_comments
add_action('widgets_init', 'cmp_new_comments');
function cmp_new_comments() {
    register_widget("new_comments");
}
class new_comments extends WP_Widget {
	public function __construct() {
        parent::__construct(
            'newcomments',
            THEME_NAME .__( ' - Recently Comments', 'wpdx' ),
            array( 'classname' => 'widget-new-comments','description' => __('Display vistor\'s recently comments(including avatar, name and comment text)','wpdx') ),
            array( 'width' => 250, 'height' => 350)
            );
    }
	public function widget($args, $instance) {
		extract($args, EXTR_SKIP);
		echo $before_widget;
		$title = apply_filters('widget_title', $instance['title']);
		$limit = $instance['limit'];
		$outer = $instance['outer'];
		$outpost = $instance['outpost'];
		if($title ){
            echo $before_title;
            echo $title;
            echo $after_title;
        }
		echo '<ul>';
		echo mod_newcomments( $limit,$outpost,$outer );
		echo '</ul>';
		echo $after_widget;
	}
	public function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['limit'] = strip_tags($new_instance['limit']);
		$instance['outer'] = strip_tags($new_instance['outer']);
		$instance['outpost'] = strip_tags($new_instance['outpost']);
		return $instance;
	}
	public function form($instance) {
		$instance = wp_parse_args( (array) $instance, array(
			'title' => __('Recently Comments','wpdx'),
			'limit' => '5',
			'outer' => '1',
			'outpost' => '1'
			)
		);
		$title = strip_tags($instance['title']);
		$limit = strip_tags($instance['limit']);
		$outer = strip_tags($instance['outer']);
		$outpost = strip_tags($instance['outpost']);
?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title : ', 'wpdx' ) ?>
				<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $instance['title']; ?>" />
			</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'limit' ); ?>"><?php _e('Number: ', 'wpdx' ) ?>
				<input class="widefat" id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="number" value="<?php echo $instance['limit']; ?>" />
			</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'outer' ); ?>"><?php _e('Exclude user(ID): ', 'wpdx' ) ?>
				<input class="widefat" id="<?php echo $this->get_field_id('outer'); ?>" name="<?php echo $this->get_field_name('outer'); ?>" type="number" value="<?php echo $instance['outer']; ?>" />
			</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'outpost' ); ?>"><?php _e('Exclude post(ID): ', 'wpdx' ) ?>
				<input class="widefat" id="<?php echo $this->get_field_id('outpost'); ?>" name="<?php echo $this->get_field_name('outpost'); ?>" type="number" value="<?php echo $instance['outpost']; ?>" />
			</label>
		</p>
<?php
	}
}
function mod_newcomments( $limit,$outpost,$outer ){
    $args = array(
        'author__not_in' => $outer,
        'post__not_in' => $outpost,
        'number' => $limit,
        'post_type' => 'post,page'
    );
    $comments = get_comments( $args ); 
    $i = 1;
    foreach ( $comments as $comment ) {
        echo '<li class="item-'.$i;
        if($i % 3 ==0) echo ' three';
        if($i % 2 ==0) echo ' two';
        echo '">'.get_avatar($comment->comment_author_email,60).'<a rel="nofollow" href="'.get_permalink($comment->comment_post_ID ).'#comment-'.$comment->comment_ID.'" title="'.sprintf( __( 'Comments on 《%s》', 'wpdx' ), $comment->post_title ).'"><span class="comment-author">'.strip_tags($comment->comment_author).'</span>：'.wp_trim_words( $comment->comment_content, 30, '...' ).'</a></li>';
        $i++;
    }
}