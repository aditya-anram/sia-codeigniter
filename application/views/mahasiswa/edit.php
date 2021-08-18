<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>


    <div class=" row">
        <div class="card col-lg-7 col-sm-12 p-4">

    <div class="row m-2">
    <div class="card col-lg-12 border  p-4">
    <form action="<?= base_url('mahasiswa/update'); ?>" method="post">
                <div class="modal-body">

                    
                <div class="form-group">
                        <input type="hidden" class="form-control" id="id" name="id" value="<?= $mhs['id']; ?>" required>
                        
                    </div>

                    <div class="form-group">
                    <label for="nim">NIM</label>
                        <input type="text" class="form-control" id="nim" name="nim" value="<?= $mhs['nim']; ?>" required readonly>
                        
                    </div>
                    <div class="form-group">
                    <label for="nama">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="<?= $mhs['nama']; ?>"required>
                    </div>
                    <div class="form-group">
                    <label for="jenis_kelamin">Jenis Kelamin</label>
                        <div class="ml-5 custom-control custom-control-inline">
                        <input type="radio" id="gender" name="gender" value="pria" <?php if($mhs['gender'] == 'pria') echo 'checked' ?>>
                        <label class="ml-1" for="gender">Pria</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="gender" name="gender" value="wanita" <?php if($mhs['gender'] == 'wanita') echo 'checked' ?>>
                        <label class="ml-1" for="gender">Wanita</label>
                        </div>
                    </div>
                    <div class="form-group">
                    <label for="agama">Agama</label>
                            <select class="custom-select" name="agama" required>
                            <option value="islam" <?php if($mhs['agama'] == 'Islam') echo 'selected'?>>Islam</option>
                            <option value="kristen" <?php if($mhs['agama'] == 'Kristen') echo 'selected'?>>Kristen</option>
                            <option value="hindu" <?php if($mhs['agama'] == 'Hindu') echo 'selected'?>>Hindu</option>
                            <option value="budha" <?php if($mhs['agama'] == 'Budha') echo 'selected'?>>Budha</option>
                            <option value="konghucu" <?php if($mhs['agama'] == 'Konghucu') echo 'selected'?>>Konghucu</option>
                            </select>
                    </div>
                    <div class="form-group">
                    <label for="tempat_lahir">Tempat Lahir</label>
                    <input class="form-control" type="text" name="tempat_lahir" id="tempat_lahir" value="<?= $mhs['tempat_lahir']; ?>">
                    </div>
                    
                    <div class="form-group">
                    <label for="tanggal_lahir">Tanggal Lahir</label>
                    <input type="date" class="form-control" id="tanggal_lahir" value="<?= $mhs['tgl_lahir']; ?>" name="tanggal_lahir" required>
                    </div>
                    <div class="form-group">
                    <label for="tempat_lahir">Alamat</label>
                    <input class="form-control" type="text" name="alamat" id="alamat" value="<?= $mhs['alamat']; ?>">
                    </div>

                </div>
                <div class="modal-footer">
                   
                    <button type="Submit" class="btn btn-primary" onclick="return confirm('Yakin akan mengupdate?');">Update</button>
                </div>

            </form>
    </div></div>
        

  
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->


<!-- modal -->

<!-- Button trigger modal -->
<!-- Modal -->