<?php

class Authentication_model extends CI_Model{

	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function authenticate($email, $password, $user_profile){

		$this->db->select('*');
		$this->db->from('user');
		$this->db->where('email', $email);
		$this->db->where('password', sha1($password));
		$this->db->limit('1');

		$this->db->join('profile', 'fk_profile_id=profile_id');

		if($user_profile){
			$this->db->where('profile_id <=', $user_profile);
		}

		if($user_profile!=1){	
			$this->db->where('payment_status', '1');
		}

		$query = $this->db->get();
                $result = $query->row_array();


		if(!isset($result)){
			throw new Exception(lang('err_unauthorised_credentials'));
		}
		return $result;
	}

}


?>
