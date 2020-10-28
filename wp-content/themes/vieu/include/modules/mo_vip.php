<?php $vip_url = is_user_logged_in()?'href="'.mo_get_user_page().'?action=vip" class="btn btn-primary"':'href="javascript:;" class="user-login btn btn-primary" data-sign="0"';$desc_vip=_hui('desc_vip');?>
				
			<div class="container">
        <div class="content-wrap">		
				<div class="vip-card text-center">
				<div class="home-vip-title text-center">
                        <h2><?php echo _hui('home_vip_title'); ?></h2>
                        <p>
                           <?php echo _hui('home_vip_text'); ?>
                       </p>
                    </div>
                    <div class="col-md-4 mt-2">
                        <div class="card">
                            <div class="card-body">
                                <div class="icon-box">
                                    <div class="icon-box-inner text-primary"><i class="fa fa-diamond"></i></div>
                                </div>
                                <h3 class="card-title text-primary">包月￥<?php echo $desc_vip['vip_price_31']; ?></h3>
                                <h5 class="card-title">包月VIP</h5>
                                <div class="list-unstyled">
                                   <?php echo $desc_vip['vip_price_31_desc']; ?>
                                </div>
                                <a <?php echo $vip_url;?>>
                                    开通月费会员
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mt-2">
                        <div class="card">
                            <div class="card-body">
                                <div class="icon-box bg-primary">
                                    <div class="icon-box-inner text-white">
                                        <i class="fa fa-diamond"></i>
                                    </div>
                                </div>
                                <h3 class="card-title text-primary">包年￥<?php echo $desc_vip['vip_price_365']; ?></h3>
								<h5 class="card-title">包年VIP</h5>
                                <div class="list-unstyled">
                                    <?php echo $desc_vip['vip_price_365_desc']; ?>
                                </div>
                                  <a <?php echo $vip_url;?>>开通年费会员</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mt-2">
                        <div class="card">
                            <div class="card-body">
                                <div class="icon-box">
                                    <div class="icon-box-inner text-primary">
                                       <i class="fa fa-diamond"></i>
                                    </div>
                                </div>
                                <h3 class="card-title text-primary">终身￥<?php echo $desc_vip['vip_price_3600']; ?></h3>
                                <h5 class="card-title">终身VIP</h5>
                                <div class="list-unstyled">
                                    <?php echo $desc_vip['vip_price_3600_desc']; ?>
                                </div>
                                  <a <?php echo $vip_url;?>>
                                    开通终身会员
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
				</div>
                </div>