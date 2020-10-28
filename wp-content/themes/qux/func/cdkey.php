<?php

/**
 * 激活码数据表
 */
function _install_cdkey_table()
{
    global $wpdb;
    include_once ABSPATH . '/wp-admin/includes/upgrade.php';
    $table_charset = '';
    $prefix = $wpdb->prefix;
    $table = $prefix . 'um_cdkeys';
    if ($wpdb->has_cap('collation')) {
        if (!empty($wpdb->charset)) {
            $table_charset = "DEFAULT CHARACTER SET $wpdb->charset";
        }
        if (!empty($wpdb->collate)) {
            $table_charset .= " COLLATE $wpdb->collate";
        }
    }
    $sql = "CREATE TABLE $table (
        id int(11) NOT NULL auto_increment,
        code VARCHAR(100) NOT NULL UNIQUE,
        product int(11) NOT NULL,
        user_id int(11) DEFAULT 0,
        create_time datetime NOT NULL default '0000-00-00 00:00:00',
        used_time datetime NOT NULL default '0000-00-00 00:00:00',
        order_id varchar(30) DEFAULT '',
        status SMALLINT NOT NULL DEFAULT 1,
        PRIMARY KEY (id),
        INDEX status_index(status),
        INDEX uid_index(user_id)) ENGINE = MyISAM $table_charset;";
    maybe_create_table($table, $sql);
}
add_action('admin_init', '_install_cdkey_table');

/**
 * 通过激活码获取激活码记录
 *
 * @since 3.1.3
 *
 * @return array|null|object|void
 */
function _get_cdkey($code)
{
    global $wpdb;
    $prefix = $wpdb->prefix;
    $table = $prefix . 'um_cdkeys';
    $row = $wpdb->get_row(sprintf("SELECT * FROM $table WHERE `code`='%s'", $code));

    return $row;
}

/**
 * 标记激活码已被使用.
 *
 * @since 3.1.3
 *
 * @param $id
 *
 * @return false|int
 */
function _mark_cdkey_used($id, $user_id, $order_id = '')
{
    global $wpdb;
    $prefix = $wpdb->prefix;
    $table = $prefix . 'um_cdkeys';
    $update = $wpdb->update(
        $table,
        array(
            'status' => 0,
            'used_time' => date('Y-m-d H:i:s', time()),
            'user_id' => $user_id,
            'order_id' => $order_id
        ),
        array('id' => $id),
        array('%d', '%s', '%d', '%s'),
        array('%d')
    );

    return $update;
}

/**
 * 统计激活码数量.
 *
 * @since 3.1.3
 *
 * @param $in_effect
 *
 * @return int
 */
function _count_cdkeys($in_effect = false)
{
    global $wpdb;
    $prefix = $wpdb->prefix;
    $table = $prefix . 'um_cdkeys';
    if ($in_effect) {
        $sql = sprintf("SELECT COUNT(*) FROM $table WHERE `status`=1");
    } else {
        $sql = "SELECT COUNT(*) FROM $table";
    }
    $count = $wpdb->get_var($sql);

    return $count;
}

/**
 * 删除激活码记录.
 *
 * @since 3.1.3
 *
 * @param $id
 *
 * @return bool
 */
function _delete_cdkey($id)
{
    global $wpdb;
    $prefix = $wpdb->prefix;
    $table = $prefix . 'um_cdkeys';
    $delete = $wpdb->delete(
        $table,
        array('id' => $id),
        array('%d')
    );

    return (bool) $delete;
}

/**
 * 创建激活码记录
 *
 * @since 3.1.3
 *
 * @return array | bool
 */
function _add_cdkey($code, $product)
{
    global $wpdb;
    $prefix = $wpdb->prefix;
    $table = $prefix . 'um_cdkeys';
    $codes = is_array($code) ? $code : [$code];
    $unique_codes = array();
    foreach ($codes as $record) {
        if (empty(sanitize_key($record))) {
            return new WP_Error('invalid_cdkey_code', __('无效激活码', 'tt'));
        }
        $exist = _get_cdkey($record);
        if ($exist && !is_array($code)) {
            return new WP_Error('duplicated_cdkey_code', __('激活码已存在', 'tt'));
        }
        array_push($unique_codes, sanitize_key($record));
    }
    $results = array();
    foreach ($unique_codes as $record) {
        $result = $wpdb->insert(
            $table,
            array(
                'code' => $record,
                'product' => $product,
                'create_time' => date('Y-m-d H:i:s', time()),
            ),
            array('%s', '%d', '%s')
        );
        array_push($results, $result);
    }
    return $results;
}

/**
 * 获取多条激活码
 *
 * @since 3.1.3
 *
 * @param int  $limit
 * @param int  $offset
 * @param bool $in_effect
 *
 * @return array|null|object
 */
function _get_cdkeys($limit = 20, $offset = 0, $in_effect = false)
{
    global $wpdb;
    $prefix = $wpdb->prefix;
    $table = $prefix . 'um_cdkeys';
    if ($in_effect) {
        $sql = sprintf("SELECT * FROM $table WHERE `status`=1 ORDER BY id DESC LIMIT %d OFFSET %d", $limit, $offset);
    } else {
        $sql = sprintf("SELECT * FROM $table ORDER BY id DESC LIMIT %d OFFSET %d", $limit, $offset);
    }
    $results = $wpdb->get_results($sql);
    $cdkeys = array();
    $user_cache = array();
    $product_cache = array();
    foreach ($results as $item) {
        if (!isset($product_cache[$item->product])) {
            $product_cache[$item->product] = get_post($item->product);
        }
        $item->product_title = $product_cache[$item->product]->post_title;
        if (!isset($user_cache[$item->user_id])) {
            $user_cache[$item->user_id] = get_user_meta($item->user_id, 'nickname', true);
        }
        $item->username = $user_cache[$item->user_id];
        array_push($cdkeys, $item);
    }

    return $cdkeys;
}

/**
 * 下发cdkey
 */
function _issue_cdkey($order)
{
    if (get_post_meta($order->product_id, 'um_enable_cdkey', true) != 1) {
        return '';
    }
    global $wpdb;
    $prefix = $wpdb->prefix;
    $table = $prefix . 'um_cdkeys';
    $sql = sprintf("SELECT * FROM $table WHERE `status`=1 AND product=%d ORDER BY id ASC LIMIT %d", $order->product_id, $order->order_quantity);
    $results = $wpdb->get_results($sql);
    if (count($results) <= 0) {
        return '';
    }
    $cdkeys = array();
    foreach ($results as $result) {
        $select_cdkey = $result;
        _mark_cdkey_used($select_cdkey->id, $order->user_id, $order->order_id);
        array_push($cdkeys, $select_cdkey->code);
    }
    return $cdkeys;
}

/**
 * 获取订单号绑定的激活码
 */
function _get_cdkeys_by_order($order_id)
{
    global $wpdb;
    $prefix = $wpdb->prefix;
    $table = $prefix . 'um_cdkeys';
    $sql = sprintf("SELECT * FROM $table WHERE order_id=%s ORDER BY id ASC", $order_id);
    $results = $wpdb->get_results($sql);

    return array_map(function ($cdkey) {
        return $cdkey->code;
    }, $results);
}


function ajax_cdkey_delete()
{
    $id = isset($_POST['id']) ? absint($_POST['id']) : 0;
    $code = 500;
    $msg = '';
    if(current_user_can('edit_users')){
        if ($id == 0) {
            $msg = '错误的记录ID';
        }else{
            $result = _delete_cdkey($id);
            if (!$result) {
                $msg = '删除激活码失败';
            }else{
                $code = 200;
                $msg = '删除激活码成功';
            }
        }
    }else{
        $msg = '你无权操作';
    }
    echo json_encode(array('code' => $code, 'msg' => $msg));
    exit;
}
add_action('wp_ajax_cdkey_delete', 'ajax_cdkey_delete');