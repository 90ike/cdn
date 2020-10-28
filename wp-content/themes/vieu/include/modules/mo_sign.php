<?php
 


 
/* AJAX登录验证
/* ------------- */
function tin_ajax_login(){
	$result	= array();
	if(isset($_POST['security']) && wp_verify_nonce( $_POST['security'], 'security_nonce' ) ){
		$creds = array();
		$creds['user_login'] = $_POST['username'];
		$creds['user_password'] = $_POST['password'];
		$creds['remember'] = ( isset( $_POST['remember'] ) ) ? $_POST['remember'] : false;
		$login = wp_signon($creds, is_ssl());
		if ( ! is_wp_error( $login ) ){
			$result['loggedin']	= 1;
		}else{
			$result['message']	= ( $login->errors ) ? strip_tags( $login->get_error_message() ) : 'ERROR: ' . esc_html__( '请输入正确用户名和密码以登录', 'tinection' );
		}
	}else{
		$result['message'] = __('安全认证失败，请重试！','tinection');
	}
	header( 'content-type: application/json; charset=utf-8' );
	echo json_encode( $result );
	exit;
 
}
add_action( 'wp_ajax_ajaxlogin', 'tin_ajax_login' );
add_action( 'wp_ajax_nopriv_ajaxlogin', 'tin_ajax_login' );
 
/* AJAX注册验证
/* ------------- */
function tin_ajax_register(){
	$result	= array();
	if(isset($_POST['security']) && wp_verify_nonce( $_POST['security'], 'user_security_nonce' ) ){
		$user_login = sanitize_user($_POST['username']);
		$user_pass = $_POST['password'];
		$user_email	= apply_filters( 'user_registration_email', $_POST['email'] );
		$authcode = strtolower($_POST['authcode']);
		$email_authcode = strtolower($_POST['email_authcode']);
		$errors	= new WP_Error();
		
		
		if( ! validate_username( $user_login ) ){
			$errors->add( 'invalid_username', __( '请输入一个有效用户名','tinection' ) );
		}elseif(username_exists( $user_login )){
			$errors->add( 'username_exists', __( '此用户名已被注册','tinection' ) );
		}elseif(email_exists( $user_email )){
			$errors->add( 'email_exists', __( '此邮箱已被注册','tinection' ) );
		}
		do_action( 'register_post', $user_login, $user_email, $errors );
		
		
		$errors = apply_filters( 'registration_errors', $errors, $user_login, $user_email );
		session_start();
		if ( $errors->get_error_code() ){
			$result['success']	= 0;
			$result['message'] 	= $errors->get_error_message();
 
		} else if ((_hui('authcode_s')=='a1' && $authcode==$_SESSION['authcode']) || (_hui('authcode_s')=='a2' && $email_authcode==$_SESSION['email_authcode'] && $user_email==$_SESSION['code_email']) || _hui('authcode_s')=='a3'){
			$user_id = wp_create_user( $user_login, $user_pass, $user_email );
			if ( ! $user_id ) {
				$errors->add( 'registerfail', sprintf( __( '无法注册，请联系管理员','tinection' ), get_option( 'admin_email' ) ) );
				$result['success']	= 0;
				$result['message'] 	= $errors->get_error_message();		
			} else{
			
				update_user_option( $user_id, 'default_password_nag', true, true ); //Set up the Password change nag.
				wp_new_user_notification( $user_id, $user_pass );	
				$result['success']	= 1;
				$result['message']	= esc_html__( '注册成功','tinection' );
				//自动登录
				wp_set_current_user($user_id);
  				wp_set_auth_cookie($user_id);
  				$result['loggedin']	= 1;
		}	
	}else if ($authcode!=$_SESSION['authcode'] || $email_authcode!=$_SESSION['email_authcode']){
		$result['message'] = __('验证码错误！','tinection');
	}elseif($user_email!=$_SESSION['code_email']){
		$result['message'] = __('请勿更改邮箱！','tinection');
	}else{
		$result['message'] = __('安全认证失败，请重试！','tinection');
	}
	
	header( 'content-type: application/json; charset=utf-8' );
	echo json_encode( $result );
	exit;	
}
}
add_action( 'wp_ajax_ajaxregister', 'tin_ajax_register' );
add_action( 'wp_ajax_nopriv_ajaxregister', 'tin_ajax_register' );

function mo_sign(){
	$current_url = home_url(add_query_arg(array(),$wp->request));
?>
<div id="sign">
    <?php if (_hui('ligin_off')){ ?><div class="part loginPart">
    <form id="login" action="<?php echo get_option('home'); ?>/wp-login.php" method="post">
     <div id="register-active" class="switch"><?php if(get_option('users_can_register')==1){ ?><i class="fa fa-toggle-on"></i>切换注册<?php } ?></div>       <h3>登录</h3>
		<p class="status"></p>
        <p>
            <label class="icon" for="username"><i class="fa fa-user"></i></label>
            <input class="input-control" id="username" type="text" placeholder="请输入用户名" name="username" required="" aria-required="true">
        </p>
        <p>
            <label class="icon" for="password"><i class="fa fa-lock"></i></label>
            <input class="input-control" id="password" type="password" placeholder="请输入密码" name="password" required="" aria-required="true">
        </p>
        <p class="safe">
           <label class="remembermetext" for="rememberme"><input name="rememberme" type="checkbox" checked="checked" id="rememberme" class="rememberme" value="forever">记住我的登录</label>
            <a class="lost" href="<?php echo mo_get_user_rp() ?>"><?php _e('忘记密码 ?','tinection'); ?></a>
        </p>
        <p>
            <input class="submit" type="submit" value="登录" name="submit">
        </p>
        <a class="close"><i class="fa fa-times"></i></a>
        <input type="hidden" id="security" name="security" value="<?php echo  wp_create_nonce( 'security_nonce' );?>">
		<input type="hidden" name="_wp_http_referer" value="<?php echo $_SERVER['REQUEST_URI']; ?>">
	</form>
	<?php if(_hui('foxlogin_s')){ ?>
        <div class="other-sign">
	      <p>您也可以使用第三方帐号快捷登录</p>
	        <div><a class="qqlogin" href="/wp-content/plugins/foxlogin/auth/qq.php?foxloginurl=<?php echo $current_url; ?>"><i class="fa fa-qq"></i><span>Q Q 登 录</span></a></div>
	  	  	  <div><a class="weibologin" href="/wp-content/plugins/foxlogin/auth/sina.php?foxloginurl=<?php echo $current_url; ?>"><i class="fa fa-weibo"></i><span>微 博 登 录</span></a></div>
	      </div>
		  <?php  } ?>
	    </div> <?php  } ?>
    <?php if(get_option('users_can_register')==1){ ?><div class="part registerPart">
     <form id="register" action="<?php bloginfo('url'); ?>/wp-login.php?action=register" method="post">
        <div id="login-active" class="switch"><i class="fa fa-toggle-off"></i>切换登录</div>
        <h3>注册</h3>    <p class="status"></p>
        <p>
            <label class="icon" for="user_name"><i class="fa fa-user"></i></label>
            <input class="input-control" id="user_name" type="text" name="user_name" placeholder="输入英文用户名" required="" aria-required="true">
        </p>
        <p>
            <label class="icon" for="user_email"><i class="fa fa-envelope"></i></label>
            <input class="input-control" id="user_email" type="email" name="user_email" placeholder="输入常用邮箱" required="" aria-required="true">
        </p>
		<?php if(_hui('authcode_s')=='a2'){ ?><p>
		<label class="icon" for="email_authcode"> <button class="go-captcha_email" type="button">发送验证码</button></label>
            <input type="text" class="input-control" name="email_authcode" id="email_authcode" placeholder="邮箱验证码">
		</p><?php } ?>
        <p>
            <label class="icon" for="user_pass"><i class="fa fa-lock"></i></label>
            <input class="input-control" id="user_pass" type="password" name="user_pass" placeholder="密码最小长度为6" required="" aria-required="true">
        </p>
        <p>
            <label class="icon" for="user_pass2"><i class="fa fa-retweet"></i></label>
            <input class="input-control" type="password" id="user_pass2" name="user_pass2" placeholder="再次输入密码" required="" aria-required="true">
        </p>
		
		
		<?php if(_hui('authcode_s')=='a1'){ ?>
		<p>
		<img title="点击刷新" src="<?php echo get_stylesheet_directory_uri(); ?>/action/captcha.php?r=<?php echo rand(); ?>" onclick="this.src='<?php echo get_stylesheet_directory_uri(); ?>/action/captcha.php?r=?'+Math.random();" style="width: 32%;max-height:42px;vertical-align:middle;border-radius: 0px;cursor: pointer;" class="img-rounded">
 <label class="icon" for="user_pass2"><i class="fa fa-italic"></i></label>
			<input class="input-control" id="authcode" type="text" style="width: 65%;float: right;" name="authcode" placeholder="验证码" required="">
				
			</p>
	<?php } ?>
       <p>        
            <input class="submit inline" type="submit" value="注册" name="submit">
        </p>
        <a class="close"><i class="fa fa-times"></i></a>	
         <input type="hidden" id="user_security" name="user_security" value="<?php echo  wp_create_nonce( 'user_security_nonce' );?>"><input type="hidden" name="_wp_http_referer" value="<?php echo $_SERVER['REQUEST_URI']; ?>"> 
    </form>
    </div>
	<?php } ?>
</div>

<?php
}
add_action('wp_footer','mo_sign');
?>
