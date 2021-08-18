<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //buat fungsi sendiri helper
        is_logged_in();
    }

    public function index()
    {
        $data['title'] = "My Profile";
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        // echo 'selamat' . $data['user']['name'];

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/index', $data);
        $this->load->view('templates/footer');
    }

    public function edit()
    {
        $data['title'] = "Edit Profile";
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        // echo 'selamat' . $data['user']['name'];

        //aturan form
        $this->form_validation->set_rules('name', 'Name', 'required|trim|regex_match[/^([a-z ])+$/i]', [
            'required' => 'Nama harus diisi',
            'regex_match' => 'Nama hanya bisa huruf dan spasi'
        ]);

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/edit', $data);
            $this->load->view('templates/footer');
        } else {
            $name = $this->input->post('name');
            $email = $this->input->post('email');


            //cek gambar
            $upload_image = $_FILES['image']['name'];
            // var_dump($upload_image);
            // die;

            if ($upload_image) {

                //setting
                $config['allowed_types'] = 'gif|jpg|jpeg|png';
                $config['max_size'] = '2048';
                $config['upload_path'] = './assets/img/profile/';

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('image')) {
                    //cek gambar lama
                    $old_image = $data['user']['image'];
                    if ($old_image != 'default.jpg') {
                        unlink(FCPATH . 'assets/img/profile/' . $old_image);
                    }
                    $new_image = $this->upload->data('file_name');
                    $this->db->set('image', $new_image);
                } else {
                    echo $this->upload->display_errors();
                }
            }


            $this->db->set('name', $name);
            $this->db->where('email', $email);
            $this->db->update('user');

            $this->session->set_flashdata('pesan', '
          <div class="alert alert-success" role="alert">
              Profil berhasil di update
          </div>');
            redirect('user');
        }
    }

    public function changePassword()
    {
        $data['title'] = "Change Password";
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        // echo 'selamat' . $data['user']['name'];

        $this->form_validation->set_rules('current_password', 'Current Password', 'required|trim', [
            'required' => 'Password lama harus diisi'
        ]);
        $this->form_validation->set_rules(
            'new_password1',
            'New Password',
            'required|trim|min_length[3]|max_length[12]|matches[new_password2]',
            [
                'required' => 'Password harus diisi',
                'min_length' => 'Password minimal 3',
                'max_length' => 'Password maksimal 12',
                'matches' => 'Password harus sama'
            ]
        );

        $this->form_validation->set_rules('new_password2', 'Confirm New Password', 'required|trim|min_length[3]|max_length[12]|matches[new_password1]', [
            'required' => 'Ulangi password harus diisi',
            'matches' => 'Password harus sama',
            'min_length' => 'Password minimal 3',
            'max_length' => 'Password maksimal 12'
        ]);


        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/changepassword', $data);
            $this->load->view('templates/footer');
        } else {
            $current_password = $this->input->post('current_password');
            $new_password = $this->input->post('new_password1');

            if (!password_verify($current_password, $data['user']['password'])) {
                $this->session->set_flashdata('pesan', '
          <div class="alert alert-danger" role="alert">
              Password lama salah
          </div>');
                redirect('user/changepassword');
            } else {
                if ($current_password == $new_password) {

                    $this->session->set_flashdata('pesan', '
                    <div class="alert alert-danger" role="alert">
                        Password tidak boleh sama dengan password lama
                    </div>');
                    redirect('user/changepassword');
                } else {
                    $password_hash = password_hash($new_password, PASSWORD_DEFAULT);

                    $this->db->set('password', $password_hash);
                    $this->db->where('email', $this->session->userdata('email'));
                    $this->db->update('user');

                    $this->session->set_flashdata('pesan', '
                    <div class="alert alert-success" role="alert">
                        Password berhasil diganti
                    </div>');
                    redirect('user/changepassword');
                }
            }
        }
    }
}
