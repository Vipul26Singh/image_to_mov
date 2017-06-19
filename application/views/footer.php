</div>

<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
<script src="<?= base_url("assets/admin") ?>/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="<?= base_url("assets/admin") ?>/plugins/jQuery/jquery-ui.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?= base_url("assets/admin") ?>/bootstrap/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="<?= base_url("assets/admin") ?>/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url("assets/admin") ?>/plugins/datatables/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="<?= base_url("assets/admin") ?>/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?= base_url("assets/admin") ?>/plugins/fastclick/fastclick.js"></script>
<script src="<?= base_url("assets/admin") ?>/dist/js/app.min.js"></script>
<script src="<?= base_url("assets/admin") ?>/dist/js/user_defined.js"></script> 
 <script src="<?= base_url("assets/admin") ?>/dist/js/sweetalert.min.js"></script>
<script src="<?= base_url("assets/admin") ?>/dist/js/demo.js"></script>
<!-- page script -->
<script>
  $(function () {
    $(".example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
  });
</script>

<script src="<?= base_url("assets/admin") ?>/plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%'
    });
  });

</script>

</body>
</html>
