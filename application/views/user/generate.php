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


	 <video height="350" controls>
  		<source src="<?php echo $vid_src; ?>">
  		Your browser does not support the video tag.
	</video> 

	<form action="<?php echo base_url('user/generateMov'); ?>" method="post">
		<div class="input-group col-xs-6">
				<span class="input-group-addon"><label>Resolution</label></span>
				<input type="text" class="col-xs-2" name="res_1" id="res_1"  value="<?php echo $res_1; ?>"/><span class="col-xs-1"><label>X</label></span><input type="text" class="col-xs-2" name="res_2" id="res_2"  value="<?php echo $res_2; ?>"/>
		</div>

		<input type="text"  name="del_fol" id="del_fol"  value="NO" hidden/>

		<br>
		<div class="input-group col-xs-2">
                                <span class="input-group-addon"><label>Frame Rate</label></span>
                                <input type="text" class="form-control col-xs-2" name="fps" id="fps"  value="<?php echo $fps; ?>"/>
                </div>
		<br>
                <input type="submit" id="regenerate-mov" class="btn btn-success" value="<?php echo lang('regenrate_mov');?>" />

        </form>		
	<br>
		<form action="<?php echo base_url('user/downloadMov'); ?>" method="post">
                        <input type="submit" id="download-mov" class="btn btn-success" value="<?php echo lang('download_mov');?>" />
                </form>

	</section>
</div>

  <?php
    require_once("incld/footer_incld.php");
    require_once("incld/sidebar_incld.php");
  ?>
</div>
