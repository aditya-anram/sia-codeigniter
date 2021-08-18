<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mahasiswa extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //buat fungsi sendiri helper
        is_logged_in();
        $this->load->model('Mahasiswa_model');
        
    }

    //read
    public function index()
    {
        //jumlah mahasiswa
        $jumlah = $this->db->get('mahasiswa');
        $jumlahMhs = $jumlah->num_rows();
        $data['jumlah'] = $jumlahMhs;

        //Jumlah mahasiswa pria
        $mPria = $this->db->get_where('mahasiswa', ['gender' => 'pria']);
        $data['mPria'] = $mPria->num_rows();

        //Jumlah mahasiswa wanita
        $mWanita = $this->db->get_where('mahasiswa', ['gender' => 'wanita']);
        $data['mWanita'] = $mWanita->num_rows();
       
        $data['title'] = "Data Mahasiswa";
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['mhs'] = $this->db->get('mahasiswa')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('mahasiswa/index', $data);
        $this->load->view('templates/footer');
    }

    //create
    public function tambahDataMhs(){
        $data['title'] = "Data Mahasiswa";
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['mhs'] = $this->Mahasiswa_model->dataMhs();

        $nim = $this->input->post('nim');
        $nama = $this->input->post('nama');
        $gender = $this->input->post('gender');
        $agama = $this->input->post('agama');
        $tempat_lahir = $this->input->post('tempat_lahir');
        $tgl_lahir = $this->input->post('tanggal_lahir');
        $alamat = $this->input->post('alamat');

        $data = [
            'nim' => $nim,
            'nama' => $nama,
            'gender' => $gender,
            'agama' => $agama,
            'tgl_lahir' => $tgl_lahir,
            'tempat_lahir' => $tempat_lahir,
            'alamat' => $alamat
        ];

       
        $dataNim = $this->db->get_where('mahasiswa', ['nim' => $nim])->row_array();

            if($dataNim['nim'] < 1){
                $tambah = $this->Mahasiswa_model->tambahDataMhs('mahasiswa',$data);

                $this->session->set_flashdata('pesan', '
            <div class="alert alert-success" role="alert">
                Data berhasil ditambahkan
            </div>');
              
            
            }else{
                $this->session->set_flashdata('pesan', '
                <div class="alert alert-danger" role="alert">
                    Data gagal ditambahkan, Nim sudah ada
                </div>');
            }

        redirect('mahasiswa');
    }

    //delete
    public function deleteMhs($idMhs)
    {   
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $where = array('id' => $idMhs);
        $delete = $this->Mahasiswa_model->hapusDataMhs('mahasiswa',$where);
        
        if(!$delete){
            $this->session->set_flashdata('pesan', '
            <div class="alert alert-success" role="alert">
                Data berhasil dihapus
            </div>');
        }else{
            $this->session->set_flashdata('pesan', '
            <div class="alert alert-danger" role="alert">
                Data gagal dihapus
            </div>');
        }

        redirect('mahasiswa');
    }

    public function edit($id){

        $data['title'] = "Edit Data Mahasiswa";
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

		$data['mhs'] = $this->db->get_where('mahasiswa', ['id' => $id] )->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('mahasiswa/edit', $data);
        $this->load->view('templates/footer');
    }

    public function update(){
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $id = $this->input->post('id');
        $nim = $this->input->post('nim');
        $nama = $this->input->post('nama');
        $gender = $this->input->post('gender');
        $agama = $this->input->post('agama');
        $tempat_lahir = $this->input->post('tempat_lahir');
        $tgl_lahir = $this->input->post('tanggal_lahir');
        $alamat = $this->input->post('alamat');

        $data = [
            'nim' => $nim,
            'nama' => $nama,
            'gender' => $gender,
            'agama' => $agama,
            'tgl_lahir' => $tgl_lahir,
            'tempat_lahir' => $tempat_lahir,
            'alamat' => $alamat
        ];

        $where = array('id' => $id);
        $update = $this->Mahasiswa_model->update($where,$data,'mahasiswa');

        if(!$update){
            $this->session->set_flashdata('pesan', '
            <div class="alert alert-success" role="alert">
                Data berhasil di update
            </div>');
        }else{
            $this->session->set_flashdata('pesan', '
            <div class="alert alert-danger" role="alert">
                Data gagal di update
            </div>');
        }
        
        redirect('mahasiswa');
    }

}