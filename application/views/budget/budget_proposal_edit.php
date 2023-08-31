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
            <div class="row">
                <!-- /.col-md-6 -->
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Edit</h3>
                        </div>


                        <form class="form-horizontal" method="POST" action="<?php base_url('budget/edit/' . $this->uri->segment(3)); ?>">
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Budget ID</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" value="<?= $get_data_by_id['kode_budget']; ?>" readonly>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">COA</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" value="<?= $get_data_by_id['account_name'] . ' / ' . $get_data_by_id['account_number']; ?>" readonly>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Budget Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" value="<?= $get_data_by_id['keterangan']; ?>" readonly>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Location</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" value="<?= strtoupper($get_data_by_id['lokasi']); ?>" readonly>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Year</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" value="<?= $get_data_by_id['tahun']; ?>" readonly>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Departement</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" value="<?= $get_data_by_id['departement']; ?>" readonly>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Budget Proposal</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" value="<?= number_format($get_data_by_id['total_budget_referensi'], 0, ',', '.'); ?>" readonly>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Initial Budget</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control number" autocomplete="off" autofocus name="initialbudget">
                                        <?php echo form_error('initialbudget', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">PIC</label>
                                    <div class="col-sm-9">
                                        <select class="custom-select" name="pic_id">
                                            <option selected disabled value="">Select Option</option>
                                            <?php foreach ($pic as $p) : ?>
                                                <option value="<?= $p['id']; ?>"><?= $p['name']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <?php echo form_error('pic_id', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <a href="<?= base_url('budget'); ?>" class="btn btn-default">Cancel</a>
                                <button type="submit" class="btn btn-primary float-right">Edit</button>
                            </div>

                        </form>
                    </div>
                </div>
                <!-- /.col-md-6 -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->