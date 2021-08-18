<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-lg-6">
            <?= $this->session->flashdata('pesan'); ?>
        </div>
    </div>

    <!-- Card -->
    <div class="card mb-3 p-4" style="max-width: 540px;">
        <div class="row no-gutters">
            <div class="col-md-4 mr-2">
                <img src="<?= base_url('assets/img/profile/') . $user['image']; ?>" class="card-img">
            </div>
            <div class="col-md-7">
                <div class="card-body">
                    <h5 class="h4 card-title text-dark"><?= $user['name']; ?></h5>
                    <p class="card-text text-dark"><?= $user['email']; ?></p>
                    <p class="card-text "><small class="text-dark">Bergabung sejak : <?= date('d F Y', $user['date_created']); ?></small></p>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->