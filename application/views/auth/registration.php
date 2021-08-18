<div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5 col-lg-5 mx-auto">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg">
                    <div class="p-5">
                        <div class="text-center mb-3">
                        <img src="<?= base_url('assets\img\favicon\logo.png'); ?>" width="20%">
                        </div>
                        <div class="text-center">
                            <h4 class="h6 text-gray-900 mb-2"><?= $page; ?></h4>
                        </div>
                        <div class="text-center">
                            <h4 class="h6 font-weight-bold text-gray-900 mb-2"><?= $sub_page; ?></h4>
                        </div>
                        <form class="user" method="post" action="<?= base_url('auth/registration'); ?>">
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="name" name="name" value="<?= set_value('name'); ?>"" placeholder=" Nama Lengkap...">
                                <?= form_error('name', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                            <div class="form-group">
                                <input type="text" id="email" name="email" value="<?= set_value('email'); ?>" class="form-control form-control-user" id="exampleInputEmail" placeholder="Email...">
                                <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="password" id="password1" name="password1" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password...">
                                    <?= form_error('password1', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <div class="col-sm-6">
                                    <input type="password" id="password2" name="password2" class="form-control form-control-user" id="exampleRepeatPassword" placeholder="Ulangi Password...">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-user btn-block">
                                Daftar
                            </button>

                        </form>
                        <hr>
                        <div class="text-center">
                            <a class="small" href="<?= base_url('auth/forgotpassword'); ?>">Lupa Password?</a>
                        </div>
                        <div class="text-center">
                            <a class="small" href="<?= base_url('auth/index'); ?>">Sudah punya akun? Login!</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>