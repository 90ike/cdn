<?php
           //pc login
		   echo'<div class="wel">';
		   	$current_url = home_url(add_query_arg(array(),$wp->request));
			 if( is_user_logged_in() ): global $current_user;
				_moloader('mo_get_user_page', false) ;
				if( _hui('user_page_s') ){
					if(_hui('is_shoping')){ echo'<div class="wel-item">
			
					<a href="'.mo_get_user_page().'?action=tuiguang"><i class="fa fa-jpy"></i> 分销赚钱</a></div>';}
				    echo'<div class="wel-item has-sub-menu">
					<a href="#">
					'. _get_the_avatar($user_email=$current_user->user_email, true).'					
					<span class="wel-name">'.$current_user->display_name .'</span>
					</a>
					<div class="sub-menu">
					<ul>			
					<li><a href="'.mo_get_user_page().'?action=index">用户中心</a></li>				
					<li><a href="'.mo_get_user_page().'#info">修改资料</a></li>';
					if(_hui('is_shoping')){echo'<li><a href="'.mo_get_user_page().'?action=order">我的订单</a></li>';}
					if(_hui('shoucang_s')){echo'<li><a href="'.mo_get_user_page().'?action=collection">我的收藏</a></li>';}
					if( is_super_admin() ){ 
					echo'<li><a target="_blank" href="'.site_url('/wp-admin/') .'">后台管理</a></li>';
				 } 
					echo'<li><a href="'.wp_logout_url($current_url).'">退出</a></li>
					</ul>
					</div>
				</div>';
				 } ?>
			<?php elseif( _hui('user_page_s') ): 
				echo _moloader('mo_get_user_rp', false) ;
					echo'<div class="wel-item">'; if (!_hui('ligin_off')){echo'<a href="javascript:;" id="loginbtn">登录</a>'; }else{ echo' <a href="javascript:;" class="user-login"  data-sign="0">登录</a>';} 
					echo'</div><div class="wel-item wel-item-btn">';
					if(get_option('users_can_register')==1){ echo'<a href="javascript:;" class="user-reg" data-sign="1">我要注册</a>';}else{ 
					echo'<a href="javascript:;" id="zhucebtn">我要注册</a>'; } echo'</div>';
	            endif; 
				//menu
			echo'</div>
            <div class="site-navbar">
		<ul>';echo _the_menu('nav');echo'</ul>
	</div>';
	//phone login
		if( _hui('m_navbar') ){ 
		 if( is_user_logged_in() ){
			 		echo'<div class="m-wel">
				<header>
			       '. _get_the_avatar($user_email=$current_user->user_email, true).'<h4>'.$current_user->display_name .'</h4>
					<h5>'. $current_user->user_email .'</h5>
				</header>
				<div class="m-wel-content">
					<ul>					
					    <li><a href="'. mo_get_user_page().'?action=index">用户中心</a></li>';
						 if(_hui('is_shoping')){echo'<li><a href="'. mo_get_user_page().'?action=vip">会员特权</a></li>
						 <li><a href="'. mo_get_user_page().'?action=order">我的订单</a></li>';
						 if(_hui('tuiguang_s')){ echo '<li><a style="color: #f60;" href="'.mo_get_user_page().'?action=tuiguang">分销赚钱</a></li>';} }
					    if(_hui('shoucang_s')){ echo '<li><a href="'.mo_get_user_page().'?action=collection">我的收藏</a></li>';}
						if( _hui('tougao_s') ){ echo'<li><a href="'.mo_get_user_page().'#post-new">我要投稿</a></li>';} 
					    echo'<li><a href="'. mo_get_user_page().'#posts/all">我的文章</a></li>
						<li><a href="'.mo_get_user_page().'#info">修改资料</a></li>
						<li><a href="'.mo_get_user_page().'#comments">评论管理</a></li>
						<li><a href="'.mo_get_user_page().'#password">修改密码</a></li>';
						if( is_super_admin() ){ 
					    echo'<li><a target="_blank" href="'.site_url('/wp-admin/') .'">后台管理</a></li>';
				 } 
					echo'</ul>
				</div>
				<footer>
					<a href="'.wp_logout_url($current_url).'">退出当前账户</a>
				</footer>
			</div>'; }
		}
?>       
         <script type="text/javascript">
             $(function(){
               $('#zhucebtn').click(function(){
                alert('抱歉！管理员关闭了注册！您可以使用QQ或微博直接登陆！');
            });
			   $('#loginbtn').click(function(){
                alert('抱歉！管理员关闭了登录，请稍后重试！');
            })
            })
            </script>