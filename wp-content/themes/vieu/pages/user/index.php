<?php 
global $wpdb, $wppay_table_name, $current_user;
_hui('is_shoping')?$user_downData = this_vip_downum():'';
$user_id = $current_user->ID;
$list = $wpdb->get_results("SELECT * FROM $wppay_table_name WHERE user_id=$user_id ORDER BY create_time DESC");
?>



<section class="author-card col-xl-6 col-sm-6 mb-6">
            <div class="inner">
                <?php echo _get_the_avatar($user_email=$current_user->user_email, true); ?>              
				<div class="card-text">
                    <div class="display-name"><?php echo $current_user->display_name; ?>&nbsp;&nbsp;<?php echo _hui('is_shoping')?vip_type_name():'';?></div>
					<?php if(_hui('is_shoping')){ ?><div class="display-down">下载信息：<span>已下<?php echo $user_downData['today_down_num']; ?></span>
					<span>剩余<?php echo $user_downData['over_down_num']; ?></span></div><?php } ?>
                    <div class="register-time"><?php if ( is_user_logged_in() ) { user_registered_date();} ?></div>
                    
                       <section class="info-basis">
            <header><h2>基本信息</h2></header>
            <div class="info-group clearfix">
                <label class="col-md-3 control-label">昵称</label>
                <p class="col-md-9"><?php echo $current_user->display_name; ?></p>
            </div>
                            <div class="info-group clearfix">
                    <label class="col-md-3 control-label">邮箱</label>
                    <p class="col-md-9"><?php echo $current_user->user_email; ?></p>
                </div>
                        <div class="info-group clearfix">
                <label class="col-md-3 control-label">网页</label>
                <p class="col-md-9"><?php echo $current_user->user_url; ?></p>
            </div>
            <div class="info-group clearfix">
                <label class="col-md-3 control-label">个人描述</label>
                <p class="col-md-9"><?php echo get_user_meta( $user_ID, 'text', true )?get_user_meta( $user_ID, 'text', true ):'这家伙很懒，啥都没有留下。'; ?></p>
            </div>
			
        </section>                 			
                </div>
            </div>
        </section>
<div class="row col-xl-6 col-sm-6 mb-6">
<ul>
    <li class="user-card">
	   
			<p class="card-body"><?php global $user_ID; echo count_user_posts($user_ID,'post',true); ?>篇文章</p>
			<p class="card-footer"><a class="card-footer" href="<?php echo mo_get_user_page();?>#posts/all">查看详情<i class="fa fa-angle-right"></i></a></p>
	</li>
	
	<li class="user-card">
	     
			<p class="card-body"><?php echo get_comments('count=true&user_id='.$user_ID); ?>条评论</p>
			<p class="card-footer"><a class="card-footer" href="<?php echo mo_get_user_page();?>#comments">查看详情<i class="fa fa-angle-right"></i></a></p>
	</li>
<?php if(_hui('is_shoping')){ ?>
	   <li class="user-card">
	     
			<p class="card-body"><?php echo count($list);?>个订单</p>
			<p class="card-footer"><a class="card-footer" href="<?php echo mo_get_user_page();?>?action=order">查看详情<i class="fa fa-angle-right"></i></a></p>
	      </li>
<?php } ?>
		</ul>
      </div>
       
		
		
		
