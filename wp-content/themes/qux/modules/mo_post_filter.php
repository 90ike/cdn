<?php 
    if (_hui('is_filter_bar')) :
    $cat_ID = (is_category()) ? get_query_var('cat') : 0 ;
    $cat_orderby = _hui('is_filter_item_cat_orderby','id');
   
    $categories = get_terms('category', array('hide_empty' => 0,'parent' => 0,'orderby' =>$cat_orderby,'order' => 'DESC')); //缓存数据
    
    $pagedtext = '';
    if( $paged && $paged > 1 ){
        $pagedtext = ' <small>第'.$paged.'页</small>';
    }
    
    $description = trim(strip_tags(category_description()));
    
    $my_query = new WP_Query('cat='. $cat_ID.'&post_per_page=1');
	$post = $my_query->post;
	wp_reset_query();

	if($post){
	    $img = post_thumbnail_src($post);
	}else{
	    $img = '/wp-content/themes/qux/img/shop-bg.jpg';
	}
    
?>
<section class="crumbs-header">
    <div class="bg" style="background-image:url(<?php echo $img; ?>)"></div>
	<section class="crumbs-con">
	    <h1><?php single_cat_title(); echo $pagedtext; ?></h1>
	    <p><?php echo $description; ?></p>
	</section>
</section>
<div class="post-filter filter--content">
    <div class="container">
    <form class="mb-0" method="get" action="<?php echo home_url(); ?>">
        <input type="hidden" name="s">
        <div class="form-box search-properties mb-0">
            <?php if (_hui('is_filter_item_cat','1')) : ?>
            <div class="filter-item">
                <?php
                $content = '<ul class="filter-tag"><span><i class="fa fa-folder-open-o"></i> 分类</span>';
                foreach ($categories as $category) {
                    // 排除二级分类
                    $_oncss = ($category->term_id == $cat_ID || $category->term_id == qux_get_term_parent($cat_ID,'category')->term_id) ? 'on' : '' ;
                    $content .= '<li><a href="'.get_category_link($category->term_id).'" class="'.$_oncss.'">'.$category->name.'</a></li>';
                }
                $content .= "</ul>";
                echo $content;
                ?>
            </div>
            <?php endif; ?>
            
            <?php 
            if (is_category()) {
                //$child_categories = get_categories( array('hide_empty' => 0,'parent'=>$cat_ID) );//获取所有分类
                //if (empty($child_categories)) {
                    $root_cat = qux_get_term_parent($cat_ID,'category');
                    $child_categories = get_categories( array('hide_empty' => 0,'parent'=>$root_cat->term_id) );//获取所有分类
                //}
            }
            if (!empty($child_categories) && _hui('is_filter_item_cat2','1')) : ?>
            <div class="filter-item">
                <?php
                    $content = '<ul class="filter-tag"><span><i class="fa fa-long-arrow-right"></i> 更多</span>';
                    foreach ($child_categories as $category) {
                        $_oncss = ($category->term_id == $cat_ID) ? 'on' : '' ;
                        $content .= '<li><a href="'.get_category_link($category->term_id).'" class="'.$_oncss.'">'.$category->name.'</a></li>';
                    }
                    $content .= "</ul>";
                    echo $content;
                ?>
            </div>
            <?php endif; ?>
            
            <?php //if (_hui('is_filter_item_tags','1')){
                $cat_ID = (get_query_var('cat')) ? get_query_var('cat') : 0 ;
                $this_cat_arg = array( 'taxonomy' => 'category','taxonomy_tag' => 'post_tag', 'id' => $cat_ID);
                $tags = _get_taxonomy_tags($this_cat_arg);
                if(!empty($tags)) {
                    echo '<div class="filter-item">';
                    $content = '<ul class="filter-tag"><span><i class="fa fa-tags"></i> 标签</span>';
                      foreach ($tags as $tag) {
                        $content .= '<li><a href="'.get_tag_link($tag->term_id).'">'.$tag->name.'</a></li>';
                      }
                    $content .= "</ul>";
                    echo $content;
                    echo '</div>';
                }
           // }?>

            <?php if (_hui('is_custom_post_meta_opt', '0') && _hui('custom_post_meta_opt', '0')) {
                $custom_post_meta_opt = _hui('custom_post_meta_opt', '0');
                foreach ($custom_post_meta_opt as $filter) {
                    $opt_meta_category = (array_key_exists('meta_category',$filter)) ? $filter['meta_category'] : false ;
                    if (!$opt_meta_category || in_array($cat_ID,$opt_meta_category) ) {
                        $_meta_key = $filter['meta_ua'];
                        echo '<div class="filter-item">';
                            $is_on = !empty($_GET[$_meta_key]) ? $_GET[$_meta_key] : '';
                            $content = '<ul class="filter-tag"><span>'.$filter['meta_name'].'</span>';
                            $meta_opt_arr = array('all' => '全部');
                            $_oncssall = ($is_on == 'all') ? 'on' : '' ;
                            $content .= '<li><a href="'.add_query_arg($_meta_key,'all').'" class="'.$_oncssall.'">全部</a></li>';
                            foreach ($filter['meta_opt'] as $opt) {
                                $_oncss = ($is_on == $opt['opt_ua']) ? 'on' : '' ;
                                $content .= '<li><a href="'.add_query_arg($_meta_key,$opt['opt_ua']).'" class="'.$_oncss.'">'.$opt['opt_name'].'</a></li>';
                            }
                            $content .= "</ul>";
                            echo $content;
                        echo '</div>';
                    }
                   
                }
            }?>
            <?php //if ( (_hui('is_filter_item_price', '0') || _hui('is_filter_item_order', '0')) ) : ?>
            <div class="filter-tab">
                    <?php // if (_hui('is_filter_item_order','1')) : 
                            $is_on = !empty($_GET['order']) ? $_GET['order'] : 'date';
                            $content = '<ul class="filter-tag"><span><i class="fa fa-sort-amount-desc"></i> 排序</span>';
                            $order_arr = array('date' => '最新发布','modified' => '最近更新','comment_count' => '评论最多','rand' => '随机','hot' => '热度');
                            foreach ($order_arr as $key => $item) {
                                $_oncss = ($is_on == $key) ? 'on' : '' ;
                                $content .= '<li><a href="'.add_query_arg("order",$key).'" class="'.$_oncss.'">'.$item.'</a></li>';
                            }
                            $content .= "</ul>";
                            echo $content;
                    //endif; ?>
            </div>
            <?php //endif;?>
        </div>
    </form>
    </div>
</div>
<?php endif;?>