<?php
	$record_group = ($menu_active == "convert") ? "active" : "";
	$create_group = ($menu_active == "create") ? "active" : "";
	$signout_group = ($menu_active == "signout") ? "active" : "";
	$password_group = ($menu_active == "password") ? "active" : "";
?>

<aside class="main-sidebar">
  <section class="sidebar">
    <ul class="sidebar-menu">
      	<li class="<?= $record_group ?> treeview">
        	    <a href="<?= base_url("user") ?>/convert"><i class="fa fa-file-video-o"></i> <?php echo lang("convert_mov"); ?></a>
      	</li>

	<li class="<?= $create_group ?> treeview">
                    <a href="<?= base_url("user") ?>/create"><i class="fa fa-file-image-o"></i> <?php echo lang("create_mov"); ?></a>
        </li>
	
	<li class="<?= $password_group ?> treeview">
                    <a href="<?= base_url("user") ?>/change_password"><i class="fa fa-key"></i> <?php echo lang("change_password"); ?></a>
        </li>

	<li class="<?= $signout_group ?> treeview">
                    <a href="<?= base_url("user") ?>/logout"><i class="fa fa-sign-out"></i> <?php echo lang("logout"); ?></a>
        </li>
    </ul>
  </section>
</aside>
