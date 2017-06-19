<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php
    require_once("incld/menu_incld.php");
  ?>

<div class="content-wrapper">	
	<section class="content">

	<div class="row">
        <div class="col-xs-12">

          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><?php echo lang('user_control');?></h3>
            </div>

                <div class="box-body">
                <?php
                        $this->load->view('include_error');
                ?>
                </div>

            <div class="box-body">
              <table class="table table-bordered table-striped example1">
                <thead>
                <tr>
                  <th><?php echo lang('id');?></th>
                  <th><?php echo lang('name');?></th>
		  <th><?php echo lang('element_email');?></th>
		<th><?php echo lang('profile');?></th>
                  <th><?php echo lang('payment_status');?></th>
                  <th><?php echo lang('action');?></th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach($user_list as $user){
			echo "<tr class ='delete_row'>";
                        echo "<td>".$user['user_id']."</td>";
                        echo "<td>".$user['name']."</td>";
			echo "<td>".$user['email']."</td>";
			if($user['fk_profile_id'] == 1){
                                echo "<td>".lang('admin')."</td>";
                        }else{
				echo "<td>".lang('user')."</td>";
                        }
                        if($user['payment_status'] == 1){
                                echo "<td><span class='label label-success'>".lang('paid')."</span></td>";
                        }else{
                                echo "<td><span class='label label-danger'>".lang('pending')."</span></td>";
                        }
                ?>

                        <td class="text-center">
<button type="button" class="btn btn-danger delete_category" value="<?php echo base_url('admin/delete_user/').$user['user_id'] ?>"><i class="fa fa-trash-o "> <?php echo lang('delete');?></i></button>
</a>

</td>
                <?php
                        echo "</tr>";
                }
                ?>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->


	</section>
</div>

  <?php
    require_once("incld/footer_incld.php");
    require_once("incld/sidebar_incld.php");
  ?>

</div>

