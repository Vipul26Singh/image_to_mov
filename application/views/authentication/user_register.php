<body class="hold-transition register-page">
<div class="register-box">
  <div class="login-logo">
    <a href="#"><?php echo lang('company_name') ?></a>
  </div>

  <div class="register-box-body">
    <p class="login-box-msg"><?php echo lang('register_message') ?></p>

	<div class="box-body">
		<?php
                	$this->load->view('include_error');
        	?>
	</div>

        <?php echo form_open('authentication/user_registration')?>

      <div class="form-group has-feedback">
        <input type="text" class="form-control" id="name" name="name" value="<?php echo set_value('name'); ?>" placeholder="<?php echo lang('full_name') ?>">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>

      <div class="form-group has-feedback">
        <input type="email" name="email" id ="email" class="form-control" value="<?php echo set_value('email'); ?>" placeholder="<?php echo lang('element_email') ?>">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="password" id="password" class="form-control" placeholder="<?php echo lang('element_password') ?>">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="retype_password" id="retype_password" class="form-control" placeholder="<?php echo lang('retype_password') ?>">
        <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-6">
          <button type="submit" class="btn btn-primary btn-block btn-flat"><?php echo lang('jvzoo_pay'); ?></button>
        </div>
      </div>
    </form>

    <a href="user" class="text-center"><?php echo lang('already_member'); ?></a>
  </div>
</div>
