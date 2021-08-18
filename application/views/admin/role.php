<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
    <div class="col-lg-4">
    <a class="btn btn-primary mb-3" data-toggle="modal" data-target="#newRoleModal" href="">Tambahkan Role</a>
    </div></div>

    <div class=" row">
        <div class="card col-lg-7 col-sm-12 p-4">
            <?= form_error(
                'menu',
                '<div class="alert alert-danger" role="alert">',
                '</div>'
            ); ?>

            <?=
                $this->session->flashdata('pesan');
            ?>

           
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th scope="col">No.</th>
                        <th scope="col">Role</th>
                        <th scope="col">Aksi</th>

                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($role as $r) : ?>
                        <tr>
                            <th scope="row"><?= $i; ?></th>
                            <td><?= $r['role'] ?></td>
                            <td>
                                <a class="badge badge-warning" href="<?= base_url('admin/roleaccess/') . $r['id']; ?>">Acess</a>
                                <a class="badge badge-success" href="">Edit</a>
                                <a class="badge badge-danger" href="">Delete</a>
                            </td>
                        </tr>
                        <?php $i++; ?>
                    <?php endforeach; ?>

                </tbody>
            </table>
        </div>
    </div>



</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->


<!-- modal -->

<!-- Button trigger modal -->
<!-- Modal -->
<div class="modal fade" id="newRoleModal" tabindex="-1" role="dialog" aria-labelledby="newRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newRoleModalLabel">Tambahkan Role Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>


            <!-- mulai form -->
            <form action="<?= base_url('admin/role'); ?>" method="post">
                <div class="modal-body">


                    <div class="form-group">
                        <input type="text" class="form-control" id="role" name="role" placeholder="Nama Role">
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="Submit" class="btn btn-primary">Tambah</button>
                </div>

            </form>

        </div>
    </div>
</div>