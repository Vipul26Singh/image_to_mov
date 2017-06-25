<?php
    require_once("dropzone.php");
  ?>

<body class="skin-blue">

<div class="wrapper">

  <?php
 
    require_once("incld/menu_incld.php");
  ?>

<div class="content-wrapper">	
	<section class="content">

	<div class="box-body">
                <?php
                        $this->load->view('include_error');
                ?>
        </div>


	<form action="<?php echo base_url('user/change_password'); ?>" method="post">


		<div class="form-group">
    			<label for="pwd"><?php echo lang('element_password');?></label>
    			<input type="password" class="form-control" id="new_pass" name="new_pass">
  		</div>

		<div class="form-group">
                        <label for="pwd"><?php echo lang('retype_password');?></label>
                        <input type="password" class="form-control" id="conf_pass" name="conf_pass">
                </div>
          	<button type="submit" class="btn btn-success"><?php echo lang('submit'); ?></button>
        </form>		

	</section>
</div>

  <?php
    require_once("incld/footer_incld.php");
    require_once("incld/sidebar_incld.php");
  ?>
</div>
