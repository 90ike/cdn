<?php 
/**
 * template name: 用户中心(已购买记录)
 */
date_default_timezone_set('Asia/Shanghai');
if(!is_user_logged_in()){
	header("Location:/");
	exit();
}
get_header();
global $current_user;




?>
<style>.header {background-color: transparent;}.content { min-height: 600px;}</style>
<?php if( !_hui('user_page_s') ) exit('该功能需要开启！'); ?>
<div class="usertitle" style="background-image: url(<?php echo _hui_img('user_banner_bg'); ?>);">
      <section class="container">
	  <div class="user-nav-avatar">
					 <?php echo _get_the_avatar($user_email=$current_user->user_email, true); ?>  
                     <?php if(_hui('user_avatar')){ ?>					 
					<form action="<?php echo  get_stylesheet_directory_uri();?>/action/avatar.php" method="post" role="form" name="AvatarForm" id="AvatarForm"  enctype="multipart/form-data">
						<a class="btn btn-primary btn-sm upload" href="javascript:void(0)"><span id="udptips">修改头像</span>
						<input type="file" accept="image/*" mutiple="mutiple"  name="addPic" id="addPic" accept=".jpg, .gif, .png" />
						</a>
						</form>
					 <?php } ?>
				</div>
						
				<h2><?php echo $current_user->display_name.' <span>UID：'.$current_user->ID.'</span>'; ?></h2>
				<p><?php echo get_user_meta( $user_ID, 'text', true )?get_user_meta( $user_ID, 'text', true ):'这家伙很懒，啥都没有留下。'; ?></p>
				</section>
			</div>
			<section class="container">
	<div class="container-user"<?php echo is_user_logged_in()?'':' id="issignshow" style="height:500px;"' ?>>
		<?php if( is_user_logged_in() ){ global $current_user, $user_ID; ?>
		<div class="userside">
			
			<div class="usermenus">	
				<ul class="usermenu">
				
				    
					 <li class="<?php if($_GET['action'] == 'index') echo 'active';?>" ><a href="<?php echo mo_get_user_page();?>?action=index"><i class="fa fa-dashboard"></i> 用户中心</a></li>
					<?php if(_hui('tuiguang_s')){ ?> <li class="<?php if($_GET['action'] == 'tuiguang') echo 'active';?>"><a style="color: #f60;" href="<?php echo mo_get_user_page();?>?action=tuiguang" etap="tuiguang"><i class="fa fa-jpy"></i> 分销赚钱</a></li><?php } ?>
					 <?php if(_hui('shoucang_s')){ ?><li class="<?php if($_GET['action'] == 'collection') echo 'active';?>" ><a href="<?php echo mo_get_user_page();?>?action=collection"><i class="fa fa-star"></i> 我的收藏</a></li><?php } ?>
					<?php if(_hui('is_shoping')){ ?><li class="<?php if($_GET['action'] == 'vip') echo 'active';?>"><a href="<?php echo mo_get_user_page();?>?action=vip" etap="vip"><i class="fa fa-diamond"></i> 会员特权</a></li>
					<li class="<?php if($_GET['action'] == 'order') echo 'active';?>" ><a href="<?php echo mo_get_user_page();?>?action=order" etap="order"><i class="fa fa-shopping-cart"></i> 我的订单</a></li><?php } ?>
					<?php if( _hui('tougao_s') ){ ?><li class="usermenu-post-new"><a href="<?php echo mo_get_user_page();?>#post-new"><i class="fa fa-pencil-square-o"></i> 我要投稿</a></li><?php } ?>
					
					<li class="usermenu-posts"><a href="<?php echo mo_get_user_page();?>#posts/all"><i class="fa fa-file-word-o"></i> 我的文章</a></li>
					<li class="usermenu-comments"><a href="<?php echo mo_get_user_page();?>#comments"><i class="fa fa-comments"></i> 我的评论</a></li>
					<li class="usermenu-info"><a href="<?php echo mo_get_user_page();?>#info"><i class="fa fa-cogs"></i> 修改资料</a></li>
					<li class="usermenu-password"><a href="<?php echo mo_get_user_page();?>#password"><i class="fa fa-lock"></i> 修改密码</a></li>
				
					
					<li><a href="<?php echo wp_logout_url(home_url()) ?>"><i class="fa fa-sign-in fa-flip-horizontal"></i> 退出</a></li>
				</ul>
			</div>
		</div>
		<div class="content" id="contentframe"><!-- 账户信息 -->
		
			<div class="user-main">
		
		
			</div>
				<?php if( _hui('tougao_s') ){ ?>
				<div class="user-main-postnew" style="display:none">
					<form class="user-postnew-form">
					  	<ul class="user-meta user-postnew">
					  		<li><label>标题</label>
								<input type="text" class="form-control" name="post_title" placeholder="文章标题">
					  		</li>
							<li><label>来源链接</label>
								<input type="text" class="form-control" name="post_url" placeholder="文章来源链接">
					  		</li>
					  		<li><label>内容</label>
					  			<?php
								

								    
									
									$content = '';
									$editor_id = 'post_index';
									$settings = array(
										'textarea_rows' => 10,
										'editor_height' => 350,
										'media_buttons' => true,
										'quicktags' => true,
										'editor_css'    => '',
										'tinymce'       => array(
											'content_css' => get_stylesheet_directory_uri() . '/static/css/user-editor-style.css'
										),
										'teeny' => true,
									);
									wp_editor( $content, $editor_id, $settings );
								?>
					  		</li>
					  		
					  		<li>
					  			<br>
								<input type="button" evt="postnew.submit" class="btn btn-primary" name="submit" value="提交审核">
								<input type="hidden" name="action" value="post.new">
					  		</li>
					  	</ul>
					</form>
				</div>
			<?php } ?>
			<div class="user-tips"></div>
			<?php if (isset($_GET['action'])) {
			$part_action = $_GET['action'];
			get_template_part( 'pages/user/'.$part_action);
		} ?>
		</div>
		<?php } ?>
	</div>
</section>
			


<script id="temp-postnew" type="text/x-jsrender">
	
</script>
<script id="temp-postmenu" type="text/x-jsrender">
	<a href="#posts/{{>name}}">{{>title}}<small>({{>count}})</small></a>
</script>
<script id="temp-postitem" type="text/x-jsrender">
	<li>
		<img data-src="{{>thumb}}" class="thumb">
		<h2><a target="_blank" href="{{>link}}">{{>title}}</a></h2>
		<p class="note">{{>desc}}</p>
		<p class="text-muted">{{>time}} &nbsp;&nbsp; 分类：{{>cat}} &nbsp;&nbsp; 阅读({{>view}}) &nbsp;&nbsp; 评论({{>comment}}) &nbsp;&nbsp; 赞({{>like}})</p>
	</li>
</script>

<script id="temp-info" type="text/x-jsrender">
	<form>
<!-- 用户图像 -->
 
	  	<ul class="user-meta">
	  		<li><label>入门时间</label>
				{{>regtime}}
	  		</li>
	  		<li><label>用户名</label>
				<input type="input" class="form-control" disabled value="{{>logname}}">
	  		</li>
	  		<li><label>邮箱</label>
				<input type="email" class="form-control" disabled value="{{>email}}">
	  		</li>
	  		<li><label>昵称</label>
				<input type="input" class="form-control" name="nickname" value="{{>nickname}}">
	  		</li>
	  		<li><label>网址</label>
				<input type="input" class="form-control" name="url" value="{{>url}}">
	  		</li>
	  		<li><label>QQ</label>
				<input type="input" class="form-control" name="qq" value="{{>qq}}">
	  		</li>
	  		<li><label>微信号</label>
				<input type="input" class="form-control" name="weixin" value="{{>weixin}}">
	  		</li>
	  		<li><label>微博地址</label>
				<input type="input" class="form-control" name="weibo" value="{{>weibo}}">
	  		</li>
			<li><label>个人描述</label>
				<input type="input" class="form-control" name="text" value="{{>text}}">
	  		</li>
	  		<li>
				<input type="button" evt="info.submit" class="btn btn-primary" name="submit" value="确认修改资料">
				<input type="hidden" name="action" value="info.edit">
	  		</li>
			
	  	</ul>
	</form>
</script>

<script id="temp-password" type="text/x-jsrender">
	<form>
	  	<ul class="user-meta">
	  		<li><label>原密码</label>
				<input type="password" class="form-control" name="passwordold">
	  		</li>
	  		<li><label>新密码</label>
				<input type="password" class="form-control" name="password">
	  		</li>
	  		<li><label>重复新密码</label>
				<input type="password" class="form-control" name="password2">
	  		</li>
	  		<li>
				<input type="button" evt="password.submit" class="btn btn-primary" name="submit" value="确认修改密码">
				<input type="hidden" name="action" value="password.edit">
	  		</li>
	  	</ul>
	</form>
</script>

<script id="temp-commentitem" type="text/x-jsrender">
	<li>
		<time>{{>time}}</time>
		<p class="note">{{>content}}</p>
		<p class="text-muted">文章：<a target="_blank" href="{{>post_link}}">{{>post_title}}</a></p>
	</li>
</script>

<?php get_footer(); ?>