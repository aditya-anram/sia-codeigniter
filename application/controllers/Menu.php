<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //buat fungsi sendiri helper
        is_logged_in();
    }

    public function index()
    {
        $data['title'] = "Menu Management";
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        // echo 'selamat' . $data['user']['name'];

        //kirim data menu
        $data['menu'] = $this->db->get('user_menu')->result_array();

        //rules
        $this->form_validation->set_rules('menu', 'Menu', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/index', $data);
            $this->load->view('templates/footer');
        } else {
            //benar
            $this->db->insert('user_menu', ['menu' => $this->input->post('menu')]);
            $this->session->set_flashdata('pesan', '
          <div class="alert alert-success" role="alert">
              Menu Add Success.
          </div>');
            redirect('menu');
        }
    }

    public function subMenu()
    {
        $data['title'] = "Sub Menu Management";
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        // $data['subMenu'] = $this->db->get('user_sub_menu')->result_array();
        //bisa pakai konstruktor
        $data['subMenu'] = $this->load->model('Menu_model', 'menu');
        $data['subMenu'] = $this->menu->getSubMenu();

        //kirim data menu combo box
        $data['menu'] = $this->db->get('user_menu')->result_array();

        //rules
        $this->form_validation->set_rules('title', 'Title', 'required');
        //rules
        $this->form_validation->set_rules('menu_id', 'Menu ID', 'required');
        //rules
        $this->form_validation->set_rules('url', 'Url', 'required');
        //rules
        $this->form_validation->set_rules('icon', 'Icon', 'required');


        if ($this->form_validation->run() == false) {

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/subMenu', $data);
            $this->load->view('templates/footer');
        } else {
            $data = [
                'title' => $this->input->post('title'),
                'menu_id' => $this->input->post('menu_id'),
                'url' => $this->input->post('url'),
                'icon' => $this->input->post('icon'),
                'is_active' => $this->input->post('is_active')

            ];

            $this->db->insert('user_sub_menu', $data);

            $this->session->set_flashdata('pesan', '
          <div class="alert alert-success" role="alert">
              Menu Add Success.
          </div>');
            redirect('menu/subMenu');
        }
    }
}
