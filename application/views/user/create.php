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

	<div id="dropzoneSort">
		<form action="<?php echo base_url('user/create'); ?>" class="dropzone" id="myDropzone">
		</form> 
	</div>

	<br>
	<div >
	<form action="<?php echo base_url('user/generateMov'); ?>">
		<input type="button" id="act-on-upload" class="btn btn-success" value="<?php echo lang('add_to_ws');?>" />
	 	<input type="submit" id="preview-mov" class="btn btn-success pull-right" value="<?php echo lang('preview_mov');?>" />
	</form>

	</div>

	</section>
</div>

  <?php
    require_once("incld/footer_incld.php");
    require_once("incld/sidebar_incld.php");
  ?>
</div>
