<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="#"><?php echo lang('company_name') ?></a>
  </div>
  <div class="login-box-body">
    <p class="login-box-msg"><?php echo lang('sign_in_starter') ?></p>
	
	<div class="box-body">
		<?php
			$this->load->view('include_error');
		?>
	</div>

	<?php echo form_open('authentication/forgot_password')?>
      		<div class="form-group has-feedback">
        		<input type="email" class="form-control" name="user_email" id="user_email" placeholder="<?php echo lang('element_email') ?>">
        		<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      		</div>

      		<div class="row">
        		<div class="col-xs-4">
          			<button type="submit" class="btn btn-primary btn-block"><?php echo lang('submit') ?></button>
        		</div>

      		</div>
    </form>
  </div>
</div>
