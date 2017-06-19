<?php

class Config_model extends CI_Model{

	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function get_config($name){
		$this->db->select('value');
                $this->db->from('config');
                $this->db->where('name', $name);

                $query = $this->db->get();
                $result = $query->result_array();

		if(isset($result)){
			return $result[0]['value'];
		}
                return $result;
	}

	public function get_all_config(){
                $this->db->select('id, name, value');
                $this->db->from('config');

                $query = $this->db->get();
                $result = $query->result_array();

                return $result;
        }

	public function update_config($name, $value){
                $this->db->where('name', $name);
		$this->db->set('value', $value);
                $this->db->update('config');
        }


}


?>
