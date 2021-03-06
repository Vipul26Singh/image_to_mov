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
		$data['success_message'] = array();

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

			$this->load->model('User_model');

			if($this->User_model->get_user_payment_status($this->session->userdata('email'))){
                        	redirect('User/convert');
			}else{
				$this->session->sess_destroy();
				redirect('User/convert');
			}
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
				$payment_id = $_POST['ctransreceipt'];
				$this->load->model('Payment_model');
				$this->Payment_model->add_payment($payment_id);
	
				echo lang('authenticate_url').base_url('authentication/activate_account');
			}else if($_POST['ctransaction'] == 'RFND'){
				$payment_id = $_POST['ctransreceipt'];
				$this->load->model('User_model');
                                $this->User_model->deactivate_user($payment_id);
			}
		}
	}

	public function activate_account(){
		$data['errors'] = array();
		$data['success_message'] = array();

		if(!empty($this->input->post())){
			$email = $this->input->post('user_email', TRUE);
			$auth_key = $this->input->post('user_auth_key', TRUE);

			$this->load->model('User_model');
			$this->load->model('Payment_model');

			if($this->Payment_model->get_payment($auth_key)>0){
				if($this->User_model->set_payment($email, $auth_key)){
					$this->update_session_data('logged_in', TRUE);
					$this->Payment_model->delete_payment($auth_key);
					redirect('User');       
				}else{
					 $data['errors'][] = lang('invalid_user_email');
				}
			}else{
				$data['errors'][] = lang('invalid_payment_id');
			}
		}

		$this->load->view('header');
                $this->load->view('authentication/user_activate', $data);
                $this->load->view('footer');
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

		if(!empty($user_data['user_name'])){
			$this->session->set_userdata('user_name', $user_data['user_name']);
		}
		
		$this->session->set_userdata('user_id', $user_data['user_id']);
		$this->session->set_userdata('imageSequence', "1");
		
			$this->session->set_userdata('logged_in', TRUE);

	}

	private function update_session_data($key, $value){
                $this->session->set_userdata($key, $value);
        }

	public function logout(){
		$this->session->sess_destroy();
		redirect('user/convert');
	}

	public function forgot_password() { 
		$this->load->model('User_model');
		$data['errors'] = array();
                $data['success_message'] = array();



		if(!empty($this->input->post())){
			$this->load->model('Config_model');
			$smtp_data = $this->Config_model->get_smtp_config();
			$from_email = $smtp_data['smtp_user'];


			$to_email = $this->input->post('user_email'); 


			if(!empty($to_email) && $this->User_model->get_user($to_email)){
				$newPwd = uniqid();

				if(!$this->User_model->set_password($to_email, $newPwd)){
					$data['errors'][] = lang('password_not_set');		
				}else{
					$msg = '
						<html>
						<head>
						<title>'.lang('your_password_changed').'</title>
						</head>
						<body>
						'.lang('hi').', '.$to_email.'!
						<br>
						'.lang('your_password_changed').' '.lang('element_email').': '.$to_email.', '.lang('element_password').': '.$newPwd.'
						<br>
						'.lang('visit_site_to_login').' '.base_url().' <br>
						</body>
						</html>';

					//Load email library 
					$config = NULL;
					if($smtp_data['smtp_allow']=="YES"){
						$config = Array(
								'protocol' => 'smtp',
								'smtp_host' => $smtp_data['smtp_host'],
								'smtp_port' => $smtp_data['smtp_port'],
								'smtp_user' => $from_email,
								'smtp_pass' => $smtp_data['smtp_pass'],
								'smtp_crypto'=>'ssl',               
								'mailtype'=>'html', 
								'charset'=>'utf-8',
								'validate'=>TRUE
							       );
					}else{

						$config = Array(
                                                                'mailtype'=>'html',
                                                                'charset'=>'utf-8'
                                                               );
					}
$this->load->library('email', $config);
$this->email->set_newline("\r\n");


					$this->email->from($from_email, $from_email); 
					$this->email->to($to_email);
					$this->email->subject(lang('your_password_changed')); 
					$this->email->message($msg); 

					//Send mail 
					$r = $this->email->send();
					if($r){
						$data['success_message'][] = lang('password_reset');
					}else{
						$data['errors'][] = lang('email_not_send');
						$data['errors'][] = $this->email->print_debugger();
					}	
				}

			}else{
				$data['errors'][] = lang('invalid_user_email');
			}
		}

		$this->load->view('header');
                $this->load->view('authentication/forgot_password', $data);
                $this->load->view('footer');
	} 
}
?>
