<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?= $title; ?></h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-10">

                    <?= $this->session->flashdata('message'); ?>

                    <div class="card">
                        <div class="card-header">
                            Role : <?= $role['role']; ?>
                        </div>

                        <div class="card-body p-0">
                            <table class="table table-hover table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Menu</th>
                                        <th scope="col">Submenu</th>
                                        <th scope="col">Submenu Url</th>
                                        <th scope="col">Access</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    $a = 1;
                                    $y = 1;
                                    ?>
                                    <?php foreach ($menu as $m) : ?>
                                        <tr>
                                            <th scope="row"><?= $i; ?></th>
                                            <td colspan="3"><strong><?= $m['name'] . ' / ' . $m['menu']; ?></strong></td>
                                            <td>
                                                <div class="icheck-primary d-inline">
                                                    <input class="checkmenu" type="checkbox" id="checkboxUtama<?= $i; ?>" <?= check_access($role['id'], $m['id']); ?> data-role="<?= $role['id']; ?>" data-menu="<?= $m['id']; ?>">
                                                    <label for="checkboxUtama<?= $i; ?>">

                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php
                                        $no = 'A';

                                        $sub_menu = $this->db->get_where('user_sub_menu', array('menu_id' => $m['id']))->result_array();
                                        foreach ($sub_menu as $sm) :
                                        ?>
                                            <tr>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td><?= $sm['title']; ?></td>
                                                <td><?= $sm['url']; ?></td>
                                                <td>

                                                    <div class="icheck-primary d-inline">
                                                        <input class="checksubmenu" type="checkbox" id="checkboxPrimary<?= $y; ?>" <?= check_access_submenu($role['id'], $m['id'], $sm['id']); ?> data-submenu="<?= $sm['id']; ?>" data-role="<?= $role['id']; ?>" data-menu="<?= $m['id']; ?>">
                                                        <label for="checkboxPrimary<?= $y; ?>">

                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php $no++;
                                            $y++;
                                        endforeach; ?>
                                        <?php $i++; ?>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
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

<!-- Modal Add -->
<div class="modal" id="newRoleModal" tabindex="-1" role="dialog" aria-labelledby="newRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newRoleModalLabel">Add New Role</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/role'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="role" name="role" placeholder="Role name">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>