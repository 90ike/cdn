<?php
/**
 * @Author: Changmeng Hu
 * @Date:   2020-03-08 20:09:35
 * @Last Modified by:   Changmeng Hu
 * @Last Modified time: 2020-03-08 21:20:27
 */
if( !class_exists('WPKJ_Custom_Users_Columns') ) :
/**
 * 
 */
class WPKJ_Custom_Users_Columns{
    
    function __construct()
    {
        // store login ip
        add_action('user_register', array( $this, 'add_signup_ip'), 10);
        // store last login info
        add_action( 'wp_login', array( $this, 'insert_last_login'), 10);
        add_filter( 'manage_users_columns', array( $this, 'custom_users_columns' ), 10);
        add_action( 'manage_users_custom_column', array( $this, 'custom_users_column' ), 10, 3);
        add_action( 'pre_get_users', array( $this, 'users_pre_order_by_id'), 10 );

        //add_action('pre_user_query', array( $this, 'extend_user_search'), 10 );
    }

    public function add_signup_ip($user_id){
        $ip = $_SERVER['REMOTE_ADDR'];
        update_user_meta($user_id, 'signup_ip', $ip);
    }
    
    public function insert_last_login( $login ) {
        global $user_id;
        $user = get_user_by( 'login', $login );
        update_user_meta( $user->ID, 'last_login', current_time( 'mysql' ) );
        $last_login_ip = $_SERVER['REMOTE_ADDR'];
        update_user_meta( $user->ID, 'last_login_ip', $last_login_ip);
    }

    public function custom_users_columns( $columns ) {
        $columns['user_id'] = __( 'ID', 'wpdx' );  
        $columns['user_nickname'] = __('Nickname','wpdx');
        $columns['user_url'] = __('Website','wpdx');
        $columns['reg_time'] = __('Registration','wpdx');
        $columns['last_login'] = __('Last login','wpdx');
        unset($columns['name']);
        return $columns;
    }

    public function custom_users_column( $value, $column, $user_id ) {
        $user = get_userdata( $user_id );
        if ( 'user_id' === $column ) {
            return $user_id;
        }
        if ( 'user_nickname' == $column ){
            return $user->nickname;
        }
        if ( 'user_url' == $column ){
            return '<a href="'.$user->user_url.'" target="_blank">'.$user->user_url.'</a>';
        }
        if('reg_time' == $column ){
            return get_date_from_gmt($user->user_registered) .'<br />'.get_user_meta( $user->ID, 'signup_ip', true);
        }
        if ( 'last_login' == $column && $user->last_login ){
            return get_user_meta( $user->ID, 'last_login', 'ture' ).'<br />'.get_user_meta( $user->ID, 'last_login_ip', 'ture' );
        }
        return $value;
    }

    public function users_pre_order_by_id( $query_args ) {

        if( is_admin() && !isset($_GET['orderby']) ) {
            $query_args->query_vars['orderby'] = 'ID';
            $query_args->query_vars['order'] = 'DESC';
        }
        return $query_args;
    }
 
    public function extend_user_search( $u_query ){
        // make sure that this code will be applied only for user search
        if ( $u_query->query_vars['search'] ){
            $search_query = trim( $u_query->query_vars['search'], '*' );
            if ( $_REQUEST['s'] == $search_query ){
                global $wpdb;
    
                // let's search by users nickname
                $u_query->query_from .= " JOIN {$wpdb->usermeta} fname ON fname.user_id = {$wpdb->users}.ID AND fname.meta_key = 'nickname'";
    
                // you can add here any meta key you want to search by
                // $u_query->query_from .= " JOIN {$wpdb->usermeta} cstm ON cstm.user_id = {$wpdb->users}.ID AND cstm.meta_key = 'YOU CUSTOM meta_key'";
    
                // let's search by all the post titles, the user has been published
                //$u_query->query_from .= " JOIN {$wpdb->posts} psts ON psts.post_author = {$wpdb->users}.ID";
    
                // what fields to include in the search
                $search_by = array( 'user_login', 'user_email', 'fname.meta_value' );
    
                // apply to the query
                $u_query->query_where = 'WHERE 1=1' . $u_query->get_search_sql( $search_query, $search_by, 'both' );
            }
        }
    }

}

endif;

new WPKJ_Custom_Users_Columns();
