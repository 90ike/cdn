<?php
// load script and style
add_action('wp_enqueue_scripts', '_load_scripts');
function _load_scripts() {
	if (!is_admin()) {
		wp_deregister_script('jquery');

		// delete l10n.js
		wp_deregister_script('l10n');

		$purl = get_stylesheet_directory_uri();

		// common css
		_cssloader(array('bootstrap' => $purl.'/static/css/bootstrap.min.css', 'fontawesome' => $purl.'/static/css/font-awesome.min.css', 'main' => 'main'));

		// page css
		if (is_page_template('pages/user.php')) {
			_cssloader(array('user' => 'user'));
			wp_enqueue_script( 'salvattore.min', get_template_directory_uri() . '/static/js/libs/jquery.form.js', array( 'jquery' ), THEME_VERSION, true );
			//wp_deregister_script('salvattore.min');
			//_cssloader(array('base' => 'base'));
		}

		$jss = array(
            'no' => array(
                'jquery' => $purl.'/static/js/libs/jquery.min.js',
                'bootstrap' => $purl . '/static/js/libs/bootstrap.min.js'
            ),
            'baidu' => array(
                'jquery' => '//apps.bdimg.com/libs/jquery/1.9.1/jquery.min.js',
                'bootstrap' => '//apps.bdimg.com/libs/bootstrap/3.2.0/js/bootstrap.min.js'
            ),
            'sanliul' => array(
                'jquery' => '//lib.baomitu.com/jquery/1.9.1/jquery.min.js',
                'bootstrap' => '//lib.baomitu.com/twitter-bootstrap/3.2.0/js/bootstrap.min.js'
            ),
            'he' => array(
                'jquery' => '//code.jquery.com/jquery-1.9.1.min.js',
                'bootstrap' => '//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js'
            )
        );
        wp_register_script( 'jquery', _hui('js_outlink') ? $jss[_hui('js_outlink')]['jquery'] : $purl.'/static/js/libs/jquery.min.js', false, THEME_VERSION, (_hui('jquery_bom')?true:false) );
        wp_enqueue_script( 'bootstrap', _hui('js_outlink') ? $jss[_hui('js_outlink')]['bootstrap'] : $purl . '/static/js/libs/bootstrap.min.js', array('jquery'), THEME_VERSION, true );
		_jsloader(array('loader'));
		
        // wp_enqueue_script( '_main', $purl . '/js/main.js', array(), THEME_VERSION, true );


	}
}

function myScripts() {
if (!is_admin()) {	
    wp_enqueue_script( 'sign', get_template_directory_uri() . '/static/js/sign.js', array( 'jquery' ), THEME_VERSION, true );
   if(_hui('the_wow_s')){ wp_enqueue_script( 'wow', 'https://lib.baomitu.com/wow/1.1.2/wow.js', array( 'jquery' ), THEME_VERSION, true );
      wp_enqueue_style( 'animate', get_template_directory_uri() . '/static/css/wow.css' ); }
	 if(_hui('lightbox_s')){ wp_enqueue_script( 'Lightbox', get_template_directory_uri() . '/static/js/Lightbox.js', array( 'jquery' ), THEME_VERSION, true ); }
       wp_enqueue_script( 'cookie', get_template_directory_uri() . '/static/js/libs/jquery.cookie.js', array( 'jquery' ), THEME_VERSION, true );
	   wp_enqueue_script( 'commentImg', get_template_directory_uri() . '/static/js/commentImg.js', array( 'jquery' ), THEME_VERSION, true );
	   wp_enqueue_script( 'popup.min', get_template_directory_uri() . '/static/js/popup.min.js', array( 'jquery' ), THEME_VERSION, true );
	   
}
	 
}  
add_action( 'init', 'myScripts' );  


// require no-category
if( _hui('no_categoty') && !function_exists('no_category_base_refresh_rules') ){

	register_activation_hook(__FILE__, 'no_category_base_refresh_rules');
	add_action('created_category', 'no_category_base_refresh_rules');
	add_action('edited_category', 'no_category_base_refresh_rules');
	add_action('delete_category', 'no_category_base_refresh_rules');
	function no_category_base_refresh_rules() {
	    global $wp_rewrite;
	    $wp_rewrite -> flush_rules();
	}

	register_deactivation_hook(__FILE__, 'no_category_base_deactivate');
	function no_category_base_deactivate() {
	    remove_filter('category_rewrite_rules', 'no_category_base_rewrite_rules');
	    // We don't want to insert our custom rules again
	    no_category_base_refresh_rules();
	}

	// Remove category base
	add_action('init', 'no_category_base_permastruct');
	function no_category_base_permastruct() {
	    global $wp_rewrite, $wp_version;
	    if (version_compare($wp_version, '3.4', '<')) {
	        // For pre-3.4 support
	        $wp_rewrite -> extra_permastructs['category'][0] = '%category%';
	    } else {
	        $wp_rewrite -> extra_permastructs['category']['struct'] = '%category%';
	    }
	}

	// Add our custom category rewrite rules
	add_filter('category_rewrite_rules', 'no_category_base_rewrite_rules');
	function no_category_base_rewrite_rules($category_rewrite) {
	    //var_dump($category_rewrite); // For Debugging

	    $category_rewrite = array();
	    $categories = get_categories(array('hide_empty' => false));
	    foreach ($categories as $category) {
	        $category_nicename = $category -> slug;
	        if ($category -> parent == $category -> cat_ID)// recursive recursion
	            $category -> parent = 0;
	        elseif ($category -> parent != 0)
	            $category_nicename = get_category_parents($category -> parent, false, '/', true) . $category_nicename;
	        $category_rewrite['(' . $category_nicename . ')/(?:feed/)?(feed|rdf|rss|rss2|atom)/?$'] = 'index.php?category_name=$matches[1]&feed=$matches[2]';
	        $category_rewrite['(' . $category_nicename . ')/page/?([0-9]{1,})/?$'] = 'index.php?category_name=$matches[1]&paged=$matches[2]';
	        $category_rewrite['(' . $category_nicename . ')/?$'] = 'index.php?category_name=$matches[1]';
	    }
	    // Redirect support from Old Category Base
	    global $wp_rewrite;
	    $old_category_base = get_option('category_base') ? get_option('category_base') : 'category';
	    $old_category_base = trim($old_category_base, '/');
	    $category_rewrite[$old_category_base . '/(.*)$'] = 'index.php?category_redirect=$matches[1]';

	    //var_dump($category_rewrite); // For Debugging
	    return $category_rewrite;
	}

	// For Debugging
	//add_filter('rewrite_rules_array', 'no_category_base_rewrite_rules_array');
	//function no_category_base_rewrite_rules_array($category_rewrite) {
	//  var_dump($category_rewrite); // For Debugging
	//}

	// Add 'category_redirect' query variable
	add_filter('query_vars', 'no_category_base_query_vars');
	function no_category_base_query_vars($public_query_vars) {
	    $public_query_vars[] = 'category_redirect';
	    return $public_query_vars;
	}

	// Redirect if 'category_redirect' is set
	add_filter('request', 'no_category_base_request');
	function no_category_base_request($query_vars) {
	    //print_r($query_vars); // For Debugging
	    if (isset($query_vars['category_redirect'])) {
	        $catlink = trailingslashit(get_option('home')) . user_trailingslashit($query_vars['category_redirect'], 'category');
	        status_header(301);
	        header("Location: $catlink");
	        exit();
	    }
	    return $query_vars;
	}

}
