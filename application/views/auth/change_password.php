<div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-lg-5">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">

                        <div class="col-lg">
                            <div class="p-5">
                                <div class="text-center">
                                    <div class="text-center mb-3">
                                        <img src="<?= base_url('assets/img/profile/logo.png'); ?>" width="20%">
                                    </div>
                                    <div class="text-center">
                                        <h4 class="h6 text-gray-900 mb-2"><?= $page; ?></h4>
                                    </div>
                                    <h5 class="h6 font-weight-bold text-gray-900 ">Ganti password untuk akun</h5>
                                    <h5 class="mb-4"><?= $this->session->userdata('reset_email'); ?></h5>
                                </div>
                                <!-- flashdata -->
                                <?= $this->session->flashdata('pesan'); ?>
                                <form class="user" method="post" action="<?= base_url('auth/changepassword'); ?>">
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" id="password1" name="password1" placeholder="Password baru...">
                                        <?= form_error('password1', '<small class="text-danger pl-3">', '</small>'); ?>
                                    </div>

                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" id="password2" name="password2" placeholder="Ulangi Password...">
                                        <?= form_error('password2', '<small class="text-danger pl-3">', '</small>'); ?>
                                    </div>



                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        Ganti Password
                                    </button>


                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>