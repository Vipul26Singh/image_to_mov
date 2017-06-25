<?php

class User_model extends CI_Model{

	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function register_user(&$data){
		
		$this->db->trans_start();
		$this->db->insert('user', $data);	
		$data['user_id'] = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE)
                {
                        log_message("error", print_r($this->db->error(), true));
                        throw new Exception(lang('err_adding_record'));
                }

		return true;
	}

	public function set_payment($user_mail, $auth_key){
                $data['payment_status'] = 1;
                $data['auth_key'] = $auth_key;
                $this->db->where('email', $user_mail);
                if($this->db->update('user', $data)){
                        if($this->db->affected_rows()){
                                return true;
                        }
                }

                return false;

        }

	public function set_password($user_mail, $pwd){
                $data['password'] = sha1($pwd);
                $this->db->where('email', $user_mail);
                if($this->db->update('user', $data)){
                        if($this->db->affected_rows()){
                                return true;
                        }
                }

                return false;

        }

	public function get_user_payment_status($user_mail){

		$this->db->select('count(*) as count');
                $this->db->from('user');
		$this->db->where('payment_status', '1');

                $query = $this->db->get();
                $result = $query->row_array();


                return $result['count'];
	}

	public function get_user($user_mail){

                $this->db->select('count(*) as count');
                $this->db->from('user');

                $query = $this->db->get();
                $result = $query->row_array();


                return $result['count'];
        }

	public function deactivate_user($auth_key){
                $data['payment_status'] = 2;
                $this->db->where('auth_key', $auth_key);
                if($this->db->update('user', $data)){
                        if($this->db->affected_rows()){
                                return true;
                        }
                }
                return false;

        }

	public function get_user_list(){
		$this->db->select('*');
		$this->db->from('user');
		$query = $this->db->get();	
		return $query->result_array();
	}

	public function delete_user($user_id){
		$this->db->where('user_id', $user_id);
   		$this->db->delete('user');
        }

	public function get_admin(){
                $this->db->select('*');
                $this->db->from('user');
		$this->db->where('fk_profile_id', '1');
                $query = $this->db->get();
                return $query->result_array();
        }

	public function update_admin_email($email){
		$this->db->where('fk_profile_id', '1');
		$this->db->set('email', $email);
		$this->db->update('user');
	}

	public function update_admin_password($password){
                $this->db->where('fk_profile_id', '1');
                $this->db->set('password', sha1($password));
                $this->db->update('user');
        }

	public function update_password($email, $password){
                $this->db->set('password', sha1($password));
                $this->db->update('user');
        }
}


?>
