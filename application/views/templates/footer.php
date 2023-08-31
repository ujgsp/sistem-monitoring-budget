<!-- Main Footer -->
<footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
        Anything you want
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2023 <a href="#"><?= $this->config->item('config_title'); ?></a>.</strong> All rights reserved.
</footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<!-- <script src="<?= base_url('assets/vendor/AdminLTE-3.2.0/') ?>plugins/jquery/jquery.min.js"></script> -->
<!-- Bootstrap 4 -->
<script src="<?= base_url('assets/vendor/AdminLTE-3.2.0/') ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url('assets/vendor/AdminLTE-3.2.0/') ?>dist/js/adminlte.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="<?= base_url('assets/vendor/AdminLTE-3.2.0/') ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url('assets/vendor/AdminLTE-3.2.0/') ?>plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url('assets/vendor/AdminLTE-3.2.0/') ?>plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url('assets/vendor/AdminLTE-3.2.0/') ?>plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?= base_url('assets/vendor/AdminLTE-3.2.0/') ?>plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?= base_url('assets/vendor/AdminLTE-3.2.0/') ?>plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?= base_url('assets/vendor/AdminLTE-3.2.0/') ?>plugins/jszip/jszip.min.js"></script>
<script src="<?= base_url('assets/vendor/AdminLTE-3.2.0/') ?>plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?= base_url('assets/vendor/AdminLTE-3.2.0/') ?>plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?= base_url('assets/vendor/AdminLTE-3.2.0/') ?>plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?= base_url('assets/vendor/AdminLTE-3.2.0/') ?>plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?= base_url('assets/vendor/AdminLTE-3.2.0/') ?>plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<!-- morrisjs -->
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

<!-- bootstrap-datetpicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>

</body>
<script>
    $(function() {

        $('#table').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });
</script>

<script>
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });

    $(document).on('input', '.number', function(event) {
        if (event.which >= 37 && event.which <= 40) return;

        this.value = this.value.replace(/\D/g, '')
            .replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    });

    $('.checkmenu').on('click', function() {
        const menuId = $(this).data('menu');
        const roleId = $(this).data('role');

        $.ajax({
            url: "<?= base_url('admin/changeaccess'); ?>",
            type: 'post',
            data: {
                menuId: menuId,
                roleId: roleId
            },
            success: function() {
                document.location.href = "<?= base_url('admin/roleaccess/'); ?>" + roleId;
            }
        });

    });

    $('.checksubmenu').on('click', function() {
        const subMenuId = $(this).data('submenu');
        const roleId = $(this).data('role');
        const menuId = $(this).data('menu');

        // console.log('submenu id: ' + subMenuId);
        // console.log('menu id: ' + menuId);
        // console.log('role id: ' + roleId);

        $.ajax({
            url: "<?= base_url('admin/changeaccesssubmenu'); ?>",
            type: 'post',
            data: {
                menuId: menuId,
                roleId: roleId,
                subMenuId: subMenuId,
            },
            success: function() {
                document.location.href = "<?= base_url('admin/roleaccess/'); ?>" + roleId;
            }
        });

    });
</script>

</html>