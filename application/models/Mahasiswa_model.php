<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mahasiswa_model extends CI_Model
{
    //read
    public function dataMhs()
    {
        return $this->db->get('mahasiswa')->result_array();
        
    }

    //create
    public function tambahDataMhs($table,$data){
        return $this->db->insert($table, $data);
    }

    //delete
    public function hapusDataMhs($table,$where){
        $this->db->where($where);
	    $this->db->delete($table);
    }

    //tampil edit
    function edit($table,$where)
	{		
		return $this->db->get_where($table,$where);
	}

    //update
	function update($where,$data,$table){
		$this->db->where($where);
		$this->db->update($table,$data);
	}	
    
}
