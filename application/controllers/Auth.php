<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    //terapkan ke semua method
    public function __construct()
    {
        parent::__construct();
        //validasi form
        $this->load->library('form_validation');
    }

    public function index()
    {
        //jika sudah masuk gakbisa ke login lagi
        if ($this->session->userdata('email')) {
            redirect('user');
        }

        //rules validasi email
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email', [
            'required' => 'Email harus diisi',
            'valid_email' => 'Email tidak valid'
        ]);

        //rules validasi password
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[3]|max_length[12]', [
            'required' => 'Password harus diisi',
            'min_length' => 'Password minimal 3 karakter',
            'max_length' => 'Password maksimal 12 karakter'
        ]);

        //jika form validasi gagal dibuka maka redirect ke login
        if ($this->form_validation->run() == false) {
            $data['title'] = "Login - Sistem Informasi Akademik";
            $data['page'] = "Sistem Informasi Akademik";
            $data['sub_page'] = "Login";
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/login');
            $this->load->view('templates/auth_footer');
        } else {
            //bikin methon private untuk menangani login masuk
            $this->_login();
        }
    }

    //method private login
    private function _login()
    {
        //jika sudah masuk gakbisa ke login lagi
        if ($this->session->userdata('email')) {
            redirect('user');
        }

        //variabel form
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        //cek apakah ada email di db
        $user = $this->db->get_where('user', ['email' => $email])->row_array();
        //coba
        // var_dump($user);
        // die;

        //user ada
        if ($user) {
            //jika user aktif
            if ($user['is_active'] == 1) {

                //cek password
                if (password_verify($password, $user['password'])) {
                    //password sama
                    //siapin database
                    $data = [
                        'email' => $user['email'],
                        'role_id' => $user['role_id']
                    ];

                    //masukan ke session
                    $this->session->set_userdata($data);
                    //Cek role_id
                    if ($user['role_id'] == 1) {
                        redirect('admin');
                    } else {
                        redirect('user');
                    }
                } else {
                    //user tidak aktif
                    //buat flash data biasanya alert
                    $this->session->set_flashdata('pesan', '
                        <div class="alert alert-danger" role="alert">
                        Password salah, klik lupa password untuk mereset password anda
                        </div>');
                    //kemablikan ke login
                    redirect('auth/index');
                }
            } else {
                //user tidak aktif
                //buat flash data biasanya alert
                $this->session->set_flashdata('pesan', '
                        <div class="alert alert-danger" role="alert">
                        Akun tidak aktif, silahkan aktifasi melalui link pada email anda
                        </div>');
                //kemablikan ke login
                redirect('auth/index');
            }
        } else {
            //buat flash data biasanya alert
            $this->session->set_flashdata('pesan', '
              <div class="alert alert-danger" role="alert">
                 Email tidak terdaftar, silahkan mendaftar akun terlebih dahulu
              </div>');
            //kemablikan ke login
            redirect('auth/index');
        }
    }

    public function registration()
    {
        //judul pages
        $data['title'] = "Buat Akun - Sistem Informasi Akademik";
        $data['page'] = "Sistem Informasi Akademik";
        $data['sub_page'] = "Buat Akun";

        //aturan form
        $this->form_validation->set_rules('name', 'Name', 'required|trim|regex_match[/^([a-z ])+$/i]', [
            'required' => 'Nama harus diisi',
            'regex_match' => 'Nama hanya bisa huruf dan spasi'
        ]);

        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', [
            'required' => 'Email harus diisi',
            'is_unique' => 'Email sudah terdaftar',
            'valid_email' => 'Email tidak valid'
        ]);
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]|matches[password2]', [
            'matches' => 'Password harus sama',
            'required' => 'Password harus diisi',
            'min_length' => 'Password minimal 3',
            'max_length' => 'Password maksimal 12'
        ]);
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');

        //cek form validation
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/registration');
            $this->load->view('templates/auth_footer');
        } else {
            $email = $this->input->post('email', true);
            //siapin data
            $data = [
                'name' => htmlspecialchars($this->input->post('name', true)),
                'email' => htmlspecialchars($email),
                //kasih gambar default
                'image' => 'default.png',
                //enkripsi
                'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                //manual
                'role_id' => 2,
                'is_active' => 0,
                //ambil waktu detik
                'date_created' => time()
            ];



            //$token = base64_encode(random_bytes(32));
            $token = base64_encode(openssl_random_pseudo_bytes(32));
            // var_dump($token);
            // die;


            $user_token = [
                'email' => $email,
                'token' => $token,
                'date_created' => time()
            ];


            //masukan ke database = tabel user dengan data $data
            $this->db->insert('user', $data);
            $this->db->insert('user_token', $user_token);

            //kirim email
            $this->_sendEmail($token, 'verify');


            //buat flash data biasanya alert
            $this->session->set_flashdata('pesan', '
            <div class="alert alert-success" role="alert">
                Selamat anda berhasil mendaftar, silahkan aktifasi akun pada tautan di ' . $email . ' sebelum 2 jam dari sekarang
            </div>');

            //redirect ke login
            redirect('auth/index');
        }
    }

    private function _sendEmail($token, $type)
    {
        //konfigurasi
        $config = [
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_user' => 'pengelola.sistem@gmail.com',
            'smtp_pass' => 'gueadmin170845',
            'smtp_port' => 465,
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'newline' => "\r\n"
        ];

        //load librari email
        $this->load->library('email', $config);
        $this->email->initialize($config);  //tambahkan baris ini

        $this->email->from('pengelola.sistem@gmail.com', 'Admin - Sistem Informasi Akademik');
        $this->email->to($this->input->post('email'));

        //untuk user aktivasi
        if ($type == 'verify') {
            $this->email->subject('Verifikasi Akun');

            $this->email->message('Hallo ' . $this->input->post('name') . ' , silahkan klik tautan untuk mengaktifasi akun anda, :  <a href="' . base_url() . 'auth/verify?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '"> Aktifasi Sekarang</a>');
        } else if ($type == 'forgot') {
            $this->email->subject('Reset Password');

            $this->email->message('Klik tautan untuk mereset password anda, :  <a href="' . base_url() . 'auth/resetpassword?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '"> Reset password </a>');
        }

        if ($this->email->send()) {
            return true;
        } else {
            // echo $this->email->print_debugger();
            // die;
            //buat flash data biasanya alert
            $this->session->set_flashdata('pesan', '
               <div class="alert alert-danger" role="alert">
                   Gagal mereset password, cek koneksi anda
               </div>');
            redirect('auth/forgotPassword');
        }
    }


    public function verify()
    {
        $email = $this->input->get('email');
        $token = $this->input->get('token');

        $user = $this->db->get_where('user', ['email' => $email])->row_array();

        if ($user) {
            $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();
            if ($user_token) {
                if (time() - $user_token['date_created'] < (60 * 60 * 2)) {
                    $this->db->set('is_active', 1);
                    $this->db->where('email', $email);
                    $this->db->update('user');

                    $this->db->delete('user_token', ['email' => $email]);

                    $this->session->set_flashdata('pesan', '
                    <div class="alert alert-success" role="alert">
                        ' . $email . ' Selamat akun berhasil teraktifasi, silahkan login
                    </div>');
                    redirect('auth/index');
                } else {
                    $this->db->delete('user', ['email' => $email]);
                    $this->db->delete('user_token', ['email' => $email]);
                    $this->session->set_flashdata('pesan', '
                    <div class="alert alert-danger" role="alert">
                        Aktifasi gagal, token sudah expired
                    </div>');
                    redirect('auth/index');
                }
            } else {
                $this->session->set_flashdata('pesan', '
          <div class="alert alert-danger" role="alert">
              Aktifasi gagal, token tidak valid
          </div>');
                redirect('auth/index');
            }
        } else {
            $this->session->set_flashdata('pesan', '
          <div class="alert alert-danger" role="alert">
              Aktifasi gagal, email tidak valid
          </div>');
            redirect('auth/index');
        }
    }


    public function logout()
    {
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role_id');
        //buat flash data biasanya alert
        $this->session->set_flashdata('pesan', '
          <div class="alert alert-success" role="alert">
              Berhasil logout
          </div>');
        redirect('auth/index');
    }

    public function blocked()
    {
        $this->load->view('auth/blocked');
    }

    public function forgotPassword()
    {

        //rules
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        if ($this->form_validation->run() == false) {
            $data['title'] = "Lupa Password - Sistem Informasi Akademik";
            $data['page'] = "Sistem Informasi Akademik";
            $data['sub_page'] = "Lupa Password";
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/forgot_password');
            $this->load->view('templates/auth_footer');
        } else {
            $email = $this->input->post('email');
            $user = $this->db->get_where('user', ['email' => $email, 'is_active' => 1])->row_array();


            if ($user) {

                $token = base64_encode(openssl_random_pseudo_bytes(32));

                $user_token = [
                    'email' => $email,
                    'token' => $token,
                    'date_created' => time()
                ];

                $this->db->insert('user_token', $user_token);
                $this->_sendEmail($token, 'forgot');

                $this->session->set_flashdata('pesan', '
                <div class="alert alert-success" role="alert">
                    Silahkan cek email anda untuk mereset password
                </div>');
                redirect('auth/forgotpassword');
            } else {
                $this->session->set_flashdata('pesan', '
                <div class="alert alert-danger" role="alert">
                    Email tidak terdaftar atau tidak teraktifasi
                </div>');
                redirect('auth/forgotpassword');
            }
        }
    }

    public function resetPassword()
    {
        $email = $this->input->get('email');
        $token = $this->input->get('token');

        $user = $this->db->get_where('user', ['email' => $email])->row_array();

        if ($user) {
            $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();

            if ($user_token) {
                $this->session->set_userdata('reset_email', $email);
                $this->changePassword();
            } else {
                $this->session->set_flashdata('pesan', '
                <div class="alert alert-danger" role="alert">
                    Token salah
                </div>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('pesan', '
                <div class="alert alert-danger" role="alert">
                    Gagal Mereset Password
                </div>');
            redirect('auth');
        }
    }

    public function changePassword()
    {
        if (!$this->session->userdata('reset_email')) {
            redirect('auth');
        };

        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]|matches[password2]', [
            'matches' => 'Password harus sama',
            'required' => 'Password harus diisi',
            'min_length' => 'Password minimal 3',
            'max_length' => 'Password maksimal 12'
        ]);
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]', [
            'matches' => 'Password harus sama',
            'required' => 'Password harus diisi',
            'min_length' => 'Password minimal 3',
            'max_length' => 'Password maksimal 12'
        ]);

        if ($this->form_validation->run() == false) {
            $data['title'] = "Ganti Password - Sistem Informasi Akademik";
            $data['page'] = "Sistem Informasi Akademik";
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/change_password');
            $this->load->view('templates/auth_footer');
        } else {
            $password = password_hash($this->input->post('password1'), PASSWORD_DEFAULT);

            $email = $this->session->userdata('reset_email');

            $this->db->set('password', $password);
            $this->db->where('email', $email);
            $this->db->update('user');
            //delete token
            $this->db->delete('user_token', ['email' => $email]);

            $this->session->unset_userdata('reset_email');

            $this->session->set_flashdata('pesan', '
                <div class="alert alert-success" role="alert">
                    Password berhasil diganti, silahkan login
                </div>');
            redirect('auth');
        }
    }
}
