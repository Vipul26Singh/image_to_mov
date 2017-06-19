<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php
    require_once("incld/menu_incld.php");
  ?>

<div class="content-wrapper">	
	<section class="content">
		<div>
          		<div class="box box-info">
            			<div class="box with-border">
              				<h3 class="box-title"><?php echo lang('manage_setting');?></h3>
            			</div>
				<?php echo form_open('admin/settings', array('class' => 'form-horizontal')); ?>
              				<div class="box-body">
						<br>
						<div class="box-header with-border">
                                        		<h3 class="box-title"><?php echo lang('general_setting');?></h3>
                                		</div>

						<div class="form-group has-warning">
                                                        <label for="secret_key" class="col-sm-2 control-label"></label>
                                                        <div class="col-sm-10">
                                                        <span class="help-block"><i class="fa fa-bell-o"><?php echo lang('jvzoo_secret_key_msg')?></i></span>
                                                        </div> 
                                                </div>

                				<div class="form-group">
                  					<label for="secret_key" class="col-sm-2 control-label"><?php echo lang('jvzoo_secret_key');?></label>

                  					<div class="col-sm-10">
                    						<input type="text" class="form-control" id="jvzoo_secret_key" name="jvzoo_secret_key" value="<?php echo $jvzoo_secret_key?>">
                  					</div>
                				</div>

						<div class="form-group has-warning"> 
							<label for="secret_key" class="col-sm-2 control-label"></label>
							<div class="col-sm-10">
							<span class="help-block"><i class="fa fa-bell-o"><?php echo lang('ipn_message')?></i></span>
							</div> 
						</div>

						<div class="form-group">
                                                        <label for="ipn_url" class="col-sm-2 control-label"><?php echo lang('jvzoo_ipn_url');?></label>

                                                        <div class="col-sm-10">
                                                                <input type="text" class="form-control" id="jvzoo_ipn_url" name="jvzoo_ipn_url" value="<?php echo base_url().$jvzoo_ipn_url;?>" readonly="true">
                                                        </div>
                                                </div>


						<div class="form-group has-warning">
                                                        <label for="secret_key" class="col-sm-2 control-label"></label>
                                                        <div class="col-sm-10">
                                                        <span class="help-block"><i class="fa fa-bell-o"><?php echo lang('jvzoo_product_msg')?></i></span>
                                                        </div> 
                                                </div>
						<div class="form-group">
                                                        <label for="product_url" class="col-sm-2 control-label"><?php echo lang('jvzoo_product_url');?></label>

                                                        <div class="col-sm-10">
                                                                <input type="text" class="form-control" id="jvzoo_product_url" name="jvzoo_product_url" value="<?php echo $jvzoo_product_url?>">
                                                        </div>
                                                </div>

						<div class="form-group has-warning">
                                                        <label for="secret_key" class="col-sm-2 control-label"></label>
                                                        <div class="col-sm-10">
                                                        <span class="help-block"><i class="fa fa-bell-o"><?php echo lang('file_size_limit_msg')?></i></span>
                                                        </div>
                                                </div>
                                                <div class="form-group">
                                                        <label for="product_url" class="col-sm-2 control-label"><?php echo lang('file_size_limit');?></label>

                                                        <div class="col-sm-10">
                                                                <input type="text" class="form-control" id="jvzoo_product_url" name="file_size_limit" value="<?php echo $file_size_limit?>">
                                                        </div>
                                                </div>

						<br>
                                                <div class="box-header with-border">
                                                        <h3 class="box-title"><?php echo lang('user_setting');?></h3>
                                                </div>
							
						<div class="form-group">
                                                        <label for="product_url" class="col-sm-2 control-label"><?php echo lang('admin_email');?></label>

                                                        <div class="col-sm-10">
                                                                <input type="text" class="form-control" id="admin_email" name="admin_email" value="<?php echo $admin_email?>">
                                                        </div>
                                                </div>

						<div class="form-group">
                                                        <label for="product_url" class="col-sm-2 control-label"><?php echo lang('admin_new_password');?></label>

                                                        <div class="col-sm-10">
                                                                <input type="text" class="form-control" id="admin_password" name="admin_password" value="">
                                                        </div>
                                                </div>

              				</div>
              
					<div class="box-footer">
                				<button type="submit" class="btn btn-info btn-lg"><?php echo lang('update');?></button>
              				</div>
            			</form>
          		</div>
		</div>
	</section>
</div>

  <?php
    require_once("incld/footer_incld.php");
    require_once("incld/sidebar_incld.php");
  ?>

</div>

