<?php 
if(_hui('is_shoping')){
global $wpdb, $wppay_table_name, $current_user;

		
	
$user_id = $current_user->ID;
$list = $wpdb->get_results("SELECT * FROM $wppay_table_name WHERE user_id=$user_id ORDER BY create_time DESC");
?>
<!-- # deft order page... -->
<div class="info-wrap">
	<?php if ($list) { ?>
		<ul class="order-row">
			<?php
			foreach($list as $value){
				if ($value->order_type == 1) {
					$title = get_the_title($value->post_id);
				}elseif ($value->order_type == 2) {
					$title = '月费会员';
				}elseif ($value->order_type == 3) {
					$title = '年费会员';
				}elseif ($value->order_type == 4) {
					$title = '终身会员';
				}else{

				}
				echo '<li class="order-item">';
				echo '<span>订单号：'.$value->order_num.'</span>';
				echo '<h2>'.$title.'</h2>';
				if ($value->status == 1) {
					
					echo '<h4 style="color: #18c127;"><b>¥ '.$value->order_price.'</b> <i class="fa fa-check-circle"></i> 已付款</h4>';
					
					echo '<time>'.date('Y-m-d H:i:s',$value->create_time).'<a target="_blank" class="btn btn-primary btn-sm" href="'.get_permalink($value->post_id).'">查看</a></time>';
					
					
				}else{
					
					echo '<h4><b>¥ '.$value->order_price.'</b> <i class="fa fa-exclamation-circle"></i> 已失效</h4>';
					echo '<time>'.date('Y-m-d H:i:s',$value->create_time).'<button class="btn btn-danger btn-sm" onclick="delOrder('.$value->order_num.')" ><i class="fa fa-trash"></i></button>';
					
				}
				
				
				echo '</li>';
			}
			?>
		</ul>
	<?php }else{ ?>
	<h1 style=" text-align: center; padding: 60px; ">您还没有购买过任何资源</h1>
	<?php } ?>

</div>
<?php } ?>