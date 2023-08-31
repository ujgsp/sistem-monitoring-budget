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
                <div class="col-md-8">
                    <!-- alert error -->
                    <?php if (validation_errors()) : ?>
                        <?php echo validation_errors('<div class="alert alert-danger" role="alert">', '</div>'); ?>
                        <!-- <?php echo validation_errors('<span class="error text-danger">', '</span><br>'); ?> -->
                    <?php endif; ?>

                    <?= $this->session->flashdata('message'); ?>

                    <div class="card">
                        <div class="card-header">
                            <a href="" class="btn btn-primary" data-toggle="modal" data-target="#newModal">Add New User Login</a>
                        </div>

                        <div class="card-body p-0">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Role</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($get_user as $row) : ?>
                                        <tr>
                                            <th scope="row"><?= $i; ?></th>
                                            <td>
                                                <a><?= $row['name']; ?></a>
                                                <br>
                                                <small>
                                                    Join date <?= date('Y-m-d H:i:s', $row['date_created']); ?>
                                                </small>
                                            </td>
                                            <td><?= $row['email']; ?></td>
                                            <td><?= $row['role']; ?></td>
                                            <td>
                                                <a href="<?= base_url('admin/roleedit/' . $row['id']); ?>" class="btn btn-primary btn_edit" data-rolename="<?= $row['role_id']; ?>">Edit</a>
                                                <a href="<?= base_url('admin/roledelete/' . $row['id']); ?>" class="btn btn-danger btn_delete" data-rolename="<?= $row['role_id']; ?>">Delete</a>
                                            </td>
                                        </tr>
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

<!-- Modal -->
<div class="modal" id="newModal" tabindex="-1" role="dialog" aria-labelledby="newModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newModalLabel">Add New User Login</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/userlogin'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" id="role" name="name" placeholder="name">
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" class="form-control" id="role" name="email" placeholder="email">
                    </div>

                    <div class="form-group">
                        <label>Role</label>
                        <select class="custom-select" name="role_id">
                            <option disabled selected value="">Select Role</option>
                            <?php foreach ($role as $r) : ?>
                                <option value="<?= $r['id']; ?>"><?= $r['role']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" id="role" name="password" placeholder="password">
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

<!-- Modal Edit -->
<div class="modal" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" id="form_editModal">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="rolenameedit" name="rolenameedit" placeholder=" name">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Edit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal confirm delete -->
<div class="modal" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Delete : <span id="rolekode"></span> </h5>
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

        // aksi modal edit
        $('.btn_edit').on('click', function(e) {
            e.preventDefault();
            const rolename = $(this).data('rolename');
            const href = $(this).attr('href');

            $('#form_editModal').attr('action', href);

            // console.log(href);

            $('#rolenameedit').val(rolename);

            $('#editModal').modal({
                show: true,
                keyboard: false,
            });
        });

        // aksi modal delete
        $('.btn_delete').on('click', function(e) {
            e.preventDefault();
            const rolekode = $(this).data('rolename');
            const href = $(this).attr('href');

            $('#form_deleteModal').attr('action', href);

            // // console.log(href);

            $('#rolekode').text(rolekode);

            $('#deleteModal').modal({
                show: true,
                keyboard: false,
            });
        });
    });
</script>