<body class="skin-blue">

<div class="wrapper">

  <?php
    require_once("incld/menu_incld.php");
  ?>

<div class="content-wrapper">	
	<section class="content">
	<?php echo form_open_multipart('user/convert');?>

		<div class="box-body">
		<?php
                	$this->load->view('include_error');
        	?>
		</div>

		<input type="file" class="btn btn-default btn-block btn-lg" name="userfile" size="20" />

		<br /><br />

		<input type="submit" class="btn btn-success" value="<?php echo lang('upload_file');?>" />

	</form>
	</section>
</div>

  <?php
    require_once("incld/footer_incld.php");
    require_once("incld/sidebar_incld.php");
  ?>
</div>

