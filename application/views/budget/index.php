<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?= $title; ?></h1>
                </div>
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">

            <?= $this->session->flashdata('message'); ?>

            <!-- budget proposal -->
            <div class="row">

                <div class="col-md-12">
                    <div class="card card-primary card-outline card-outline-tabs">
                        <div class="card-header p-0 pt-1">
                            <ul class="nav nav-tabs budgetproposal" id="custom-tabs-two-tab" role="tablist">
                                <li class="pt-2 px-3">
                                    <h3 class="card-title">Budget Proposal</h3>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" id="custom-tabs-two-home-tab" data-toggle="pill" href="#opex" role="tab" aria-controls="opex" aria-selected="false">Opex</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-two-profile-tab" data-toggle="pill" href="#capex" role="tab" aria-controls="capex" aria-selected="false">Capex</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-two-tabContent">
                                <!-- table budget proposal -->
                                <table class="table table-striped table-bordered" id="table_budgetproposal">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>COA</th>
                                            <th>Budget Name</th>
                                            <th>Location</th>
                                            <th>Year</th>
                                            <th>Dept</th>
                                            <th>Proposal Budget</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                </table>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
            <!-- /.row -->

            <!-- initial budget -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline card-outline-tabs">
                        <div class="card-header p-0 pt-1">
                            <ul class="nav nav-tabs initialbudget" id="custom-tabs-two-tab" role="tablist">
                                <li class="pt-2 px-3">
                                    <h3 class="card-title">Initial Budget</h3>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" id="custom-tabs-two-home-tab" data-toggle="pill" href="#Opex-acc" role="tab" aria-controls="Opex-acc" aria-selected="false">Opex</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-two-profile-tab" data-toggle="pill" href="#Capex-acc" role="tab" aria-controls="Capex-acc" aria-selected="false">Capex</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-two-tabContent">
                                <!-- table initial budget -->
                                <table class="table table-bordered table-striped" id="table_initialbudget">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>COA</th>
                                            <th>Budget Name</th>
                                            <th>PIC</th>
                                            <th>Location</th>
                                            <th>Year</th>
                                            <th>Dept</th>
                                            <th>Proposal Budget</th>
                                            <th>Fixed Budget</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Modal confirm delete -->
<div class="modal" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Delete Budget: <span id="kode"></span> </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" id="form_deleteModal">
                <div class="modal-body">
                    Jika Anda melanjutkan, Anda akan kehilangan data ini!
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(function() {
        // budgetproposal
        datatable('opex');

        function datatable(type) {
            $('#table_budgetproposal').DataTable({
                // 'responsive': true,
                "processing": true,
                "serverSide": true,
                "order": [],
                "ajax": {
                    "url": "<?php echo base_url('budget/budgetproposal/') ?>" + type,
                    "type": "POST",
                    "data": {
                        'jenis': 'budget'
                    }
                },
                "columnDefs": [{
                    "targets": [0, 1, 2, 3, 4, 5, 6, 7],
                    "orderable": false,
                }, ],
                "bDestroy": true,
                "deferRender": true,
                "lengthMenu": [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],
                "pageLength": 10,
            });
        }

        $('.budgetproposal a').on('shown.bs.tab', function(event) {
            var tab_target = $(event.target).text();
            // console.log(tab_target);
            switch (tab_target) {
                case 'Capex':
                    // loadTableRencana(tab_target);
                    datatable(tab_target.toLowerCase());
                    break;
                case 'Opex':
                    datatable(tab_target.toLowerCase());
                    // loadTableRencana(tab_target);
                    break;
            }
        });

        // initial budget
        datatable_fix('opex');

        // datatable_fix rencana
        function datatable_fix(type) {
            let table = $('#table_initialbudget').DataTable({
                'responsive': true,
                "processing": true,
                "serverSide": true,
                "order": [],
                "ajax": {
                    "url": "<?php echo base_url('budget/initialbudget/') ?>" + type,
                    "type": "POST",
                    // "data": {
                    // 	'jenis': 'budget_acc'
                    // },
                    "data": function(data) {
                        data.filter_tahun = $('#tahun').val();
                        data.filter_pic = $('#pic').val();
                        data.filter_kategori = type,
                            data.jenis = 'budget_acc'
                    }
                },
                "columnDefs": [{
                    "targets": [0, 1, 2, 3, 4, 5, 6, 7],
                    "orderable": false,
                }, ],
                "bDestroy": true,
                "deferRender": true,
                "lengthMenu": [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],
                "pageLength": 10,
            });

            $('#btn-filter').click(function() { //button filter event click
                table.ajax.reload(); //just reload table
            });

            $('#btn-reset').click(function() { //button reset event click
                $('#form-filter')[0].reset();
                $('.select2').val(null).trigger('change');
                table.ajax.reload(); //just reload table
            });

        };


        $('.initialbudget a').on('shown.bs.tab', function(event) {
            var tab_target = $(event.target).text();
            // console.log(tab_target);
            switch (tab_target) {
                case 'Capex':
                    datatable_fix(tab_target.toLowerCase());
                    break;
                case 'Opex':
                    datatable_fix(tab_target.toLowerCase());
                    break;
            }
        });

        // aksi modal delete
        $(document).on('click', '.btn_delete', function(e) {
            e.preventDefault();
            const budgetname = $(this).data('ket');
            const href = $(this).attr('href');

            $('#form_deleteModal').attr('action', href);

            $('#kode').text(budgetname);

            $('#deleteModal').modal({
                show: true,
            });
        });
    });
</script>