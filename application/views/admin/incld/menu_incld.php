<?php
	$user_group = ($menu_active == "user_view") ? "active" : "";
	$setting_group = ($menu_active == "settings" ) ? "active" : "";
	$logout_group = ($menu_active == "logout") ? "active" : "";
?>

<aside class="main-sidebar">
  <section class="sidebar">
    <ul class="sidebar-menu">
      	<li class="<?= $user_group ?> treeview">
        	    <a href="<?= base_url("admin") ?>/dashboard"><i class="fa fa-user"></i> <?php echo lang("users"); ?></a>
      	</li>

	<li class="<?= $setting_group ?> treeview">
                    <a href="<?= base_url("admin") ?>/settings"><i class="fa fa-cog"></i> <?php echo lang("settings"); ?></a>
        </li>
	
	<li class="treeview">
                    <a href="<?= base_url("admin") ?>/user_mode"><i class="fa fa-toggle-on"></i> <?php echo lang("switch_user"); ?></a>
        </li>
	
	<li class="<?= $logout_group ?> treeview">
                    <a href="<?= base_url("admin") ?>/logout"><i class="fa fa-sign-out"></i> <?php echo lang("logout"); ?></a>
        </li>
    </ul>
  </section>
</aside>
