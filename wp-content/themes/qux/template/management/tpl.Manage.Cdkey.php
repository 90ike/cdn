<?php
$paged = max( 1, get_query_var('page') );
$limit = 15; // 每页20条
$count = _count_cdkeys();
$cdkeys = _get_cdkeys($limit, ($paged - 1) * $limit);
$message = '';
if( isset($_POST['number']) && isset($_POST['select-product']) && current_user_can('edit_users') ){

	if($_POST['select-product']){
	    $codes = array();
	    for($i=0;$i<intval($_POST['number']);$i++){
	        $code = generateRandomStr(16);
	        array_push($codes,$code);
	    }
        if(_add_cdkey($codes, $_POST['select-product'])){
            $message = __('激活码添加成功！', 'um');
        }else{
            $message = __('激活码添加失败！', 'um');
        }
	}else{
	   $message = __('请选择商品归属', 'um');
	}
	$message .= ' <a href="'.um_get_current_page_url().'">'.__('点击刷新','um').'</a>';
	$count = _count_cdkeys();
	$cdkeys = _get_cdkeys($limit, ($paged - 1) * $limit);
}
$pages = ceil($count / $limit);
get_header(); 
?>
<div class="wrapper">
    <!-- 主要内容区 -->
    <div class="container pagewrapper clr" id="management-page">
            <?php include('navmenu.php'); ?>
            <div class="pagecontent">
                <div class="page-wrapper">
                    <div class="tab-content">
                        <section class="mg-cdkey clearfix">
                            <div class="page-header"><h3 id="info">添加激活码</h3></div>
                            <?php if($message) echo '<div class="alert alert-success">'.$message.'</div>'; ?>
                            <form id="cdkeyform" role="form"  method="post">
                <div class="form-group info-group clearfix">
                    <div class="form-inline">
                        <div class="form-group">
                            <div class="input-group active">
                                <div class="input-group-addon">数量</div>
                                <input class="form-control" type="number" name="number" value="" aria-required="true" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group active">
                                <div class="input-group-addon">归属商品</div>
                       <select name="select-product" class="select select-primary select-store" data-toggle="select">
                            <option value="0" >请选择</option>
                            <?php
                            $html = '';
                            $posts = get_posts('numberposts=500&post_type=store'); 
                            foreach ($posts as $post) {
                                $html .= '<option value="'.$post->ID.'">'.$post->post_title.'</option>';
                            }
                            echo $html;
                            ?>
                        </select>
                        </div>
                        </div>
                     <button class="btn btn-inverse" type="submit" id="generate-cdkeys">添加</button>
                    </div>
                </div>
                </form>
                </section>
                <section class="mg-cdkeys clearfix">
                    <div class="page-header"><h3 id="info">激活码列表</h3></div>
                    <?php if($count>0){ ?>
                    <div class="table-wrapper site-users">
                        <table class="table table-striped table-framed table-centered cdkey-table">
                            <thead>
                            <tr>
                                <th class="th-uid"><?php _e('激活码', 'um'); ?></th>
                                <th class="th-name"><?php _e('归属商品', 'um'); ?></th>
                                <th class="th-email"><?php _e('添加日期', 'um'); ?></th>
                                <th class="th-role"><?php _e('发放用户', 'um'); ?></th>
                                <th class="th-time"><?php _e('订单', 'um'); ?></th>
                                <th class="th-last"><?php _e('状态', 'um'); ?></th>
                                <th class="th-actions" style="min-width:45px;"><?php _e('操作', 'um'); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($cdkeys as $cdkey){ ?>
                                <tr id="id-<?php echo $cdkey->id; ?>">
                                    <td><?php echo $cdkey->code; ?></td>
                                    <td><?php echo $cdkey->product_title; ?></td>
                                    <td><?php echo $cdkey->create_time; ?></td>
                                    <td><?php echo $cdkey->username ? $cdkey->username : 'N/A'; ?></td>
                                    <td><?php echo $cdkey->order_id ? $cdkey->order_id : 'N/A'; ?></td>
                                    <td><?php echo $cdkey->status == 1 ? '未使用' : '已使用 发放时间：'.$cdkey->used_time; ?></td>
                                    <td><?php echo $cdkey->status == 1 ? '<a class="delete-card" href="javascript:;" data-id="'.$cdkey->id.'" title="删除激活码">删除</a>' : ''; ?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <?php echo um_pager($paged, $pages); ?>
                    <?php } ?>
                </section>
                </div>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>
