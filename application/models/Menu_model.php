<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu_model extends CI_Model
{
    public function getSubMenu()
    {
        //mengambil nama sub menu
        $query = "SELECT `user_sub_menu`.*, `user_menu`.`menu`
    FROM `user_sub_menu` JOIN `user_menu`
    ON `user_sub_menu`.`menu_id` = `user_menu`.`id`";

        return $this->db->query($query)->result_array();
    }

    public function getNumMenu()
    {
        $query = $this->db->get('user_menu');
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else {
            return 0;
        }
    }

    public function getNumSubMenu()
    {
        $query = $this->db->get('user_sub_menu');
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else {
            return 0;
        }
    }

    public function getMemberActive()
    {

        //query builder
        //$this->db->select('*');
        // $this->db->from('user');
        // $this->db->where('is_active', '1');
        // $query = $this->db->get();

        $query = $this->db->get_where('user', ['is_active' => 1]);

        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else {
            return 0;
        }
    }

    public function getMemberNonActive()
    {
        $query = $this->db->get_where('user', ['is_active' => 0]);

        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else {
            return 0;
        }
    }
}
