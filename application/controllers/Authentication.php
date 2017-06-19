<?php

class Authentication extends CI_Controller {


	public function __construct()
	{
		parent::__construct();
		$this->load->helper('language');
		$this->load->library('form_validation');
	}

	public function admin(){
		$data=array();
		$data['errors'] = array();

		if($this->session->userdata('logged_in')==TRUE){
			redirect('Admin/dashboard');
		}

		$this->load->library('form_validation');
                $this->form_validation->set_rules('admin_email', lang('element_email'), 'required|valid_email', array('required'=>'%s '.lang('err_required'), 'valid_email'=>lang('Invalid').' %s'));
                $this->form_validation->set_rules('admin_password', lang('element_password'), 'required', array('required'=>'%s '.lang('err_required')));


		if($this->form_validation->run() != FALSE){
			$this->load->model('Authentication_model');
	
			$email = $this->input->post('admin_email');
                        $password = $this->input->post('admin_password');
                        $email = $this->security->xss_clean($email);
                        $password = $this->security->xss_clean($password);

			try{
				$user_data = $this->Authentication_model->authenticate($email, $password, 1);
				$this->set_user_session($user_data);		
				redirect('admin/dashboard');
			}catch(Exception $e){
				$data['errors'][] = $e->getMessage();
			}
		}

		$this->load->view('header');
		$this->load->view('authentication/admin_login', $data);
		$this->load->view('footer');
	}

	public function user(){
                $data=array();
                $data['errors'] = array();

                if($this->session->userdata('logged_in')==TRUE){
                        redirect('User/convert');
                }

                $this->load->library('form_validation');
                $this->form_validation->set_rules('user_email', lang('element_email'), 'required|valid_email', array('required'=>'%s '.lang('err_required'), 'valid_email'=>lang('Invalid').' %s'));
                $this->form_validation->set_rules('user_password', lang('element_password'), 'required', array('required'=>'%s '.lang('err_required')));


                if($this->form_validation->run() != FALSE){
                        $this->load->model('Authentication_model');

                        $email = $this->input->post('user_email');
                        $password = $this->input->post('user_password');
                        $email = $this->security->xss_clean($email);
                        $password = $this->security->xss_clean($password);

                        try{
                                $user_data = $this->Authentication_model->authenticate($email, $password, 2);
                                $this->set_user_session($user_data);
				redirect('User');
                        }catch(Exception $e){
                                $data['errors'][] = $e->getMessage();
                        }
                }

                $this->load->view('header');
                $this->load->view('authentication/user_login', $data);
                $this->load->view('footer');
        }

	public function user_registration(){
                $data=array();
                $data['errors'] = array();

                $this->load->library('form_validation');
                $this->form_validation->set_rules('email', lang('element_email'), 'required|valid_email', array(
                												'required'      => '%s '.lang('err_required'),
														'valid_email'	=> lang('invalid').' %s'
       			)
		);

                $this->form_validation->set_rules('password', lang('element_password'), 'required', array(
                                                                                                                'required'      => '%s '.lang('err_required')
                        )
		);

		$this->form_validation->set_rules('retype_password', lang('retype_password'), 'required|matches[password]', array(
                                                                                                                'required'      => '%s '.lang('err_required'),
														'matches'	=> lang('err_password_mismatch')
                        )
		);

		$this->form_validation->set_rules('name', 'Name', 'required',  array( 'required'      => '%s '.lang('err_required')));


                if($this->form_validation->run() != FALSE){
                        $this->load->model('User_model');
			$this->load->model('Config_model');

			$name = $this->input->post('name');
                        $email = $this->input->post('email');
                        $password = $this->input->post('password');
                        $email = $this->security->xss_clean($email);
                        $password = $this->security->xss_clean($password);
			$name = $this->security->xss_clean($name);
			$model_data['name'] = $name;
			$model_data['email'] = $email;
			$model_data['password'] = sha1($password);
			$model_data['fk_profile_id'] = 2;
			$model_data['payment_status'] = 0;
			$model_data['creation_time'] = date('Y-m-d H:i:s');

                        try{
                                $user_data = $this->User_model->register_user($model_data);
                                $this->set_user_session($user_data);
				$redirect_url = $this->Config_model->get_config(JVZOO_PRODUCT_URL);

				if(isset($redirect_url)){
                                	redirect($redirect_url, 'refresh');
				}else{
					$data['errors'][] = lang('err_db_configuration');
				}
                        }catch(Exception $e){
                                $data['errors'][] = $e->getMessage();
                        }
                }

                $this->load->view('header');
                $this->load->view('authentication/user_register', $data);
                $this->load->view('footer');
        }


	public function authenticate_payment(){
		if(!isset($_POST['ctransaction'])){
			die('unathorized access.');
		}		

		if($this->jvzipnVerification($_POST) == 1)
		{
			if($_POST['ctransaction'] == 'SALE')
			{
				$this->load->model('User_model');
				if($this->User_model->set_payment($this->session->userdata('user_id'))){
					$this->update_session_data('logged_in', TRUE);
					redirect('User');	
				}else{
					echo lang('err_payment_not_verified');
				}
			}
		}
	}

	private function jvzipnVerification($data) {
		$this->load->model('Config_model');
		$secretKey = $this->Config_model->get_config(JVZOO_SECRET_KEY);
		$pop = "";
		$ipnFields = array();
		foreach ($data AS $key => $value) {
			if ($key == "cverify") {
				continue;
			}
			$ipnFields[] = $key;
		}
		sort($ipnFields);
		foreach ($ipnFields as $field) {
			$pop = $pop . $data[$field] . "|";
		}

		$pop = $pop . $secretKey;
		$calcedVerify = sha1(mb_convert_encoding($pop, "UTF-8"));
		$calcedVerify = strtoupper(substr($calcedVerify,0,8));
		return $calcedVerify == $data["cverify"];
	}
	


	private function set_user_session($user_data){
		$this->session->set_userdata('session_id', uniqid('id', true));
		$this->session->set_userdata('email', $user_data['email']);
		$this->session->set_userdata('profile_id', $user_data['fk_profile_id']);
		$this->session->set_userdata('user_name', $user_data['user_name']);
		$this->session->set_userdata('user_id', $user_data['user_id']);
		$this->session->set_userdata('imageSequence', "1");
		
		if($user_data['fk_profile_id']!=1){
			$this->session->set_userdata('logged_in', FALSE);
		}else{
			$this->session->set_userdata('logged_in', TRUE);
		}
	}

	private function update_session_data($key, $value){
                $this->session->set_userdata($key, $value);
        }

	public function logout(){
		$this->session->sess_destroy();
		redirect('user/convert');
	}
}
?>
