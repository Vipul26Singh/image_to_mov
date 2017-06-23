<?php

class Payment_model extends CI_Model{

	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function add_payment($payment_id){
		$data['payment_id'] = $payment_id;
		$data['used'] = 0;
		$data['trans_date'] = Date('Y-m-d');	
		
		$this->db->insert('payment', $data);
		
		return true;
	}

	public function delete_payment($id){
		$this->db->where('payment_id', $id);
		$this->db->delete('payment'); 
         
                return true;
        }

	public function get_payment($id){

		$this->db->select('count(*) as count');
		$this->db->where('payment_id', $id);
		$this->db->where('used', '0');
		$this->db->from('payment');

		$query = $this->db->get();
		$ret = $query->row();
		return $ret->count;
	}

}


?>
