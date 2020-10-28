<?php 

//创建专题分类法
add_action( 'init', 'create_redvine_topic_taxonomy', 0 );
function create_redvine_topic_taxonomy() {
    //添加分类分类法
    $labels = array(
        'name'              => __( '专题', 'qux' ),
        'singular_name'     => __( '专题', 'qux' ),
        'search_items'      => __( '搜索专题','qux' ),
        'all_items'         => __( '所有专题','qux' ),
        'parent_item'       => __( '父级专题','qux' ),
        'parent_item_colon' => __( '父级专题：','qux' ),
        'edit_item'         => __( '编辑专题','qux' ), 
        'update_item'       => __( '更新专题','qux' ),
        'add_new_item'      => __( '添加专题','qux' ),
        'new_item_name'     => __( '新的专题','qux' ),
        'menu_name'         => __( '专题','qux' ),
    );     

    //注册分类法
    register_taxonomy('tcat',array('post'), array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'show_in_rest'      => true,
        'rewrite'           => array( 'slug' => 'tcat' )
    ));

}

function topic_add_style() {
    echo '<style type="text/css" media="screen">
        th.column-thumb {width:60px;}
        .form-field img.taxonomy-image {border:1px solid #eee;max-width:300px;max-height:300px;}
        .inline-edit-row fieldset .thumb label span.title {width:48px;height:48px;border:1px solid #eee;display:inline-block;}
        .column-thumb span {width:48px;height:48px;border:1px solid #eee;display:inline-block;}
        .inline-edit-row fieldset .thumb img,.column-thumb img {width:48px;height:48px;}
        .topic-screenshot{width: 235px;overflow: hidden;padding: 3px;margin-top: 5px;border: 1px solid #ccc;}
    </style>';
}

add_action('tcat_add_form_fields', 'topic_add_texonomy_field');
add_action('tcat_edit_form_fields', 'topic_edit_texonomy_field');
add_filter('manage_edit-tcat_columns', 'topic_taxonomy_columns' );
add_filter('manage_tcat_custom_column', 'topic_taxonomy_column', 10, 3 );

// add image field in add form
function topic_add_texonomy_field() {
    if (get_bloginfo('version') >= 3.5)
        wp_enqueue_media();
    else {
        wp_enqueue_style('thickbox');
        wp_enqueue_script('thickbox');
    }
    
    echo '<div class="form-field">
        <label for="taxonomy_image">' . __('图片', 'categories-images') . '</label>
        <input type="text" name="taxonomy_image" id="taxonomy_image" style="width:80%" value="" />
        <button class="topic_upload_image_button button">' . __('选择图片', 'categories-images') . '</button>
    </div>'.topic_script();
}

// add image field in edit form
function topic_edit_texonomy_field($taxonomy) {
    if (get_bloginfo('version') >= 3.5)
        wp_enqueue_media();
    else {
        wp_enqueue_style('thickbox');
        wp_enqueue_script('thickbox');
    }
    
    if (topic_taxonomy_image_url( $taxonomy->term_id, NULL, TRUE ) == IMAGE_PLACEHOLDER) 
        $image_url = "";
    else
        $image_url = topic_taxonomy_image_url( $taxonomy->term_id, NULL, TRUE );
    echo '<tr class="form-field">
        <th scope="row" valign="top"><label for="taxonomy_image">' . __('图片', 'qux') . '</label></th>
        <td><input type="text" name="taxonomy_image" id="taxonomy_image" style="width:70%" value="'.$image_url.'" />
        <button class="topic_upload_image_button button">' . __('选择图片', 'qux') . '</button>
        <button class="topic_remove_image_button button">' . __('删除图片', 'qux') . '</button>
        <div class="topic-screenshot"><img class="taxonomy-image" style="width:100%;"src="' . topic_taxonomy_image_url( $taxonomy->term_id, 'medium', TRUE ) . '"/></idv>
        </td>
    </tr>'.topic_script();
}

// upload using wordpress upload
function topic_script() {
    return '<script type="text/javascript">
        jQuery(document).ready(function($) {
            var wordpress_ver = "'.get_bloginfo("version").'", upload_button;
            $(".topic_upload_image_button").click(function(event) {
                upload_button = $(this);
                var frame;
                if (wordpress_ver >= "3.5") {
                    event.preventDefault();
                    if (frame) {
                        frame.open();
                        return;
                    }
                    frame = wp.media();
                    frame.on( "select", function() {
                        // Grab the selected attachment.
                        var attachment = frame.state().get("selection").first();
                        frame.close();
                        if (upload_button.parent().prev().children().hasClass("tax_list")) {
                            upload_button.parent().prev().children().val(attachment.attributes.url);
                            upload_button.parent().prev().prev().children().attr("src", attachment.attributes.url);
                        }
                        else
                            $("#taxonomy_image").val(attachment.attributes.url);
                    });
                    frame.open();
                }
                else {
                    tb_show("", "media-upload.php?type=image&amp;TB_iframe=true");
                    return false;
                }
            });
            
            $(".topic_remove_image_button").click(function() {
                $(".taxonomy-image").attr("src", "'.IMAGE_PLACEHOLDER.'");
                $("#taxonomy_image").val("");
                $(this).parent().siblings(".title").children("img").attr("src","' . IMAGE_PLACEHOLDER . '");
                $(".inline-edit-col :input[name=\'taxonomy_image\']").val("");
                return false;
            });
            
            if (wordpress_ver < "3.5") {
                window.send_to_editor = function(html) {
                    imgurl = $("img",html).attr("src");
                    if (upload_button.parent().prev().children().hasClass("tax_list")) {
                        upload_button.parent().prev().children().val(imgurl);
                        upload_button.parent().prev().prev().children().attr("src", imgurl);
                    }
                    else
                        $("#taxonomy_image").val(imgurl);
                    tb_remove();
                }
            }
            
            $(".editinline").click(function() { 
                var tax_id = $(this).parents("tr").attr("id").substr(4);
                var thumb = $("#tag-"+tax_id+" .thumb img").attr("src");

                if (thumb != "' . IMAGE_PLACEHOLDER . '") {
                    $(".inline-edit-col :input[name=\'taxonomy_image\']").val(thumb);
                } else {
                    $(".inline-edit-col :input[name=\'taxonomy_image\']").val("");
                }
                
                $(".inline-edit-col .title img").attr("src",thumb);
            });
        });
    </script>';
}

// save our taxonomy image while edit or save term
add_action('edit_term','topic_save_taxonomy_image');
add_action('create_term','topic_save_taxonomy_image');
function topic_save_taxonomy_image($term_id) {
    if(isset($_POST['taxonomy_image']))
        update_option('z_taxonomy_image'.$term_id, $_POST['taxonomy_image'], NULL);
}

// get attachment ID by image url
function topic_get_attachment_id_by_url($image_src) {
    global $wpdb;
    $query = $wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid = %s", $image_src);
    $id = $wpdb->get_var($query);
    return (!empty($id)) ? $id : NULL;
}

// get taxonomy image url for the given term_id (Place holder image by default)
function topic_taxonomy_image_url($term_id = NULL, $size = 'full', $return_placeholder = FALSE) {
    if (!$term_id) {
        if (is_category())
            $term_id = get_query_var('cat');
        elseif (is_tag())
            $term_id = get_query_var('tag_id');
        elseif (is_tax()) {
            $current_term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
            $term_id = $current_term->term_id;
        }
    }
    
    $taxonomy_image_url = get_option('z_taxonomy_image'.$term_id);
    if(!empty($taxonomy_image_url)) {
        $attachment_id = topic_get_attachment_id_by_url($taxonomy_image_url);
        if(!empty($attachment_id)) {
            $taxonomy_image_url = wp_get_attachment_image_src($attachment_id, $size);
            $taxonomy_image_url = $taxonomy_image_url[0];
        }
    }
    $random = mt_rand(1, 15);
	$first_img = get_stylesheet_directory_uri();
	$first_img .= '/img/rand/'.$random.'.jpg';

    if ($return_placeholder)
        return ($taxonomy_image_url != '') ? $taxonomy_image_url : IMAGE_PLACEHOLDER;
    else
        return ($taxonomy_image_url != '') ? $taxonomy_image_url : $first_img;
}

function topic_quick_edit_custom_box($column_name, $screen, $name) {
    if ($column_name == 'thumb') 
        echo '<fieldset>
        <div class="thumb inline-edit-col">
            <label>
                <span class="title"><img src="" alt="Thumbnail"/></span>
                <span class="input-text-wrap"><input type="text" name="taxonomy_image" value="" class="tax_list" /></span>
                <span class="input-text-wrap">
                    <button class="topic_upload_image_button button">' . __('添加图片', 'qux') . '</button>
                    <button class="topic_remove_image_button button">' . __('移除', 'qux') . '</button>
                </span>
            </label>
        </div>
    </fieldset>';
}

// Change 'insert into post' to 'use this image'
function topic_change_insert_button_text($safe_text, $text) {
    return str_replace("Insert into Post", "Use this image", $text);
}

// Style the image in category list
if ( strpos( $_SERVER['SCRIPT_NAME'], 'edit-tags.php' ) > 0 || strpos( $_SERVER['SCRIPT_NAME'], 'term.php' ) > 0) {
    add_action('admin_head', 'topic_add_style' );
    add_action('quick_edit_custom_box', 'topic_quick_edit_custom_box', 10, 3);
    add_filter("attribute_escape", "topic_change_insert_button_text", 10, 2);
}


/**
 * Thumbnail column added to category admin.
 *
 * @access public
 * @param mixed $columns
 * @return void
 */
function topic_taxonomy_columns( $columns ) {
    $new_columns = array();
    $new_columns['cb'] = $columns['cb'];
    $new_columns['thumb'] = __('图片', 'qux');

    unset( $columns['cb'] );

    return array_merge( $new_columns, $columns );
}

/**
 * Thumbnail column value added to category admin.
 *
 * @access public
 * @param mixed $columns
 * @param mixed $column
 * @param mixed $id
 * @return void
 */
function topic_taxonomy_column( $columns, $column, $id ) {
    if ( $column == 'thumb' )
        $columns = '<span><img src="' . topic_taxonomy_image_url($id, 'thumbnail', TRUE) . '" alt="' . __('图片', 'qux') . '" class="wp-post-image" /></span>';
    
    return $columns;
}

// display taxonomy image for the given term_id
function topic_taxonomy_image($term_id = NULL, $size = 'full', $attr = NULL, $echo = TRUE) {
    if (!$term_id) {
        if (is_category())
            $term_id = get_query_var('cat');
        elseif (is_tag())
            $term_id = get_query_var('tag_id');
        elseif (is_tax()) {
            $current_term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
            $term_id = $current_term->term_id;
        }
    }
    
    $taxonomy_image_url = get_option('z_taxonomy_image'.$term_id);
    if(!empty($taxonomy_image_url)) {
        $attachment_id = topic_get_attachment_id_by_url($taxonomy_image_url);
        if(!empty($attachment_id))
            $taxonomy_image = wp_get_attachment_image($attachment_id, $size, FALSE, $attr);
        else {
            $image_attr = '';
            if(is_array($attr)) {
                if(!empty($attr['class']))
                    $image_attr .= ' class="'.$attr['class'].'" ';
                if(!empty($attr['alt']))
                    $image_attr .= ' alt="'.$attr['alt'].'" ';
                if(!empty($attr['width']))
                    $image_attr .= ' width="'.$attr['width'].'" ';
                if(!empty($attr['height']))
                    $image_attr .= ' height="'.$attr['height'].'" ';
                if(!empty($attr['title']))
                    $image_attr .= ' title="'.$attr['title'].'" ';
            }
            $taxonomy_image = '<img src="'.$taxonomy_image_url.'" '.$image_attr.'/>';
        }
    }
    else{
        $taxonomy_image = '';
    }

    if ($echo)
        echo $taxonomy_image;
    else
        return $taxonomy_image;
}