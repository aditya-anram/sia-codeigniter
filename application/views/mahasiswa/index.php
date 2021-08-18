<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">

    <div class="col-lg-5">
    <a class="btn btn-primary mb-3" data-toggle="modal" data-target="#tambahMhsModal" href="">Tambahkan Data</a>
    </div>

    <div class="col-lg-7">
    <div class="d-flex justify-content-end">
        <div class="card p-2">
            <span> Jumlah Mahasiswa = <?= $jumlah; ?></span>  
            <span> Jumlah Pria = <?= $mPria; ?></span>    
            <span> Jumlah Wanita= <?= $mWanita; ?></span>      
        </div>
       
    </div>
    </div>
    
        
    </div>
        </div>

        <div class="row m-2">
            <div class="col-lg-12">
            <div class="card p-2">

<?=
    $this->session->flashdata('pesan');
?>

<table class="table table-striped table-hover table-bordered">
    <thead>
        <tr>
        
            <th scope="col cla">No.</th>
            <th scope="col">NIM</th>
            <th scope="col">Nama</th>
            <th scope="col">Gender</th>
            <th scope="col">Agama</th>
            <th scope="col">Tempat Lahir</th>
            <th scope="col">Tanggal Lahir</th>
            <th scope="col">Alamat</th>
            <th scope="col">Aksi</th>


        </tr>
    </thead>

        <?php $i = 1; ?>
        <?php foreach ($mhs as $m) : ?>
            <tr>
                <th scope="row"><?= $i; ?></th>
                <td><?= $m['nim'] ?></td>
                <td><?= $m['nama'] ?></td>
                <td><?= $m['gender'] ?></td>
                <td><?= $m['agama'] ?></td>
                <td><?= $m['tgl_lahir'] ?></td>
                <td><?= $m['tempat_lahir'] ?></td>
                <td><?= $m['alamat'] ?></td>
                <td>

                   <a class="btn btn-sm btn-circle btn-primary" 
                    href="<?= base_url('mahasiswa/edit/'.$m['id']); ?>"> <i class="fas fa-pen"></i> </a>
                
                    <a class="btn btn-sm btn-circle btn-danger" 
                    href="<?= base_url('mahasiswa/deleteMhs/'.$m['id']); ?>" onclick="return confirm('Yakin akan menghapus?');"><i class="fas fa-trash"></i></a>
                    

                   

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

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->


<!-- modal -->

<!-- Button trigger modal -->
<!-- Modal -->
<div class="modal fade " id="tambahMhsModal" tabindex="-1" role="dialog" aria-labelledby="tambahMhsLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahMhsModalLabel">Tambahkan Data Mahasiswa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>


            <!-- mulai form -->
            <form action="<?= base_url('mahasiswa/tambahdatamhs'); ?>" method="post">
                <div class="modal-body">


                    <div class="form-group">
                    <label for="nim">NIM</label>
                        <input type="text" class="form-control" id="nim" name="nim" placeholder="NIM" required>
                    </div>
                    <div class="form-group">
                    <label for="nama">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama" required>
                    </div>
                    <div class="form-group">
                    <label for="jenis_kelamin">Jenis Kelamin</label>
                        <div class="ml-5 custom-control custom-radio custom-control-inline">
                        <input type="radio" id="genderp" name="gender" value="pria" class="custom-control-input">
                        <label class="custom-control-label" for="genderp">Pria</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="genderw" name="gender" value="wanita" class="custom-control-input">
                        <label class="custom-control-label" for="genderw" >Wanita</label>
                        </div>
                    </div>
                    <div class="form-group">
                    <label for="agama">Agama</label>
                            <select class="custom-select" name="agama" required>
                           
                            <option value="islam" selected>Islam</option>
                            <option value="kristen">Kristen</option>
                            <option value="hindu">Hindu</option>
                            <option value="budha">Budha</option>
                            <option value="konghucu">Konghucu</option>
                            </select>
                    </div>
                    <div class="form-group">
                    <label for="tempat_lahir">Tempat Lahir</label>
                    <textarea class="form-control" rows="5" name="tempat_lahir" id="tempat_lahir" aria-label="tempat_lahir" placeholder="Tempat Lahir" required></textarea>
                    </div>
                    <div class="form-group">
                    <label for="tanggal_lahir">Tanggal Lahir</label>
                    <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required>
                    </div>
                    <div class="form-group">
                   
                    <label for="alamat">Alamat</label>
                    <textarea class="form-control" name="alamat" id="alamat" aria-label="alamat" placeholder="Alamat Lengkap" rows="5" required></textarea>
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










