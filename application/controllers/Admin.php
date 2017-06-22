<?php

class Admin extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('language');

		if(!$this->session->userdata('logged_in'))
		{ 
			redirect('authentication/admin');
		}
	}


	public function index()
        {
		redirect('authentication/admin');
        }

        public function dashboard()
        {
		$this->load->model('User_model');
                $menu_active = "user_view";
                $data = array(
                                'menu_active' => $menu_active
                        );
		$data["user_list"] = $this->User_model->get_user_list();

		$this->load->view('header');
                $this->load->view('admin/view_user', $data);
                $this->load->view('footer');
        }

	public function delete_user($user_id){
		$this->load->model("User_model");
		$this->User_model->delete_user($user_id);
		echo "success";
	}

	public function logout(){
		$this->session->sess_destroy();
                redirect('admin');
	}

	public function user_mode(){
                redirect('user');
        }

	public function settings(){
		$this->load->model('Config_model');
		$this->load->model('User_model');
		$data=array();
		$data['menu_active'] = 'settings'; 
		$data['errors'] = array();

		if(!empty($this->input->post())){
			$this->Config_model->update_config('jvzoo_product_url', $this->input->post('jvzoo_product_url'));
			$this->Config_model->update_config('file_size_limit', $this->input->post('file_size_limit'));
			$this->Config_model->update_config('jvzoo_secret_key', $this->input->post('jvzoo_secret_key'));
			
			if(!empty($this->input->post('admin_email'))){
				$this->User_model->update_admin_email($this->input->post('admin_email'));
			}
			
			if(!empty($this->input->post('admin_password'))){
				$this->User_model->update_admin_password($this->input->post('admin_password'));
			}
		}

		$temp_data = $this->Config_model->get_all_config();

                foreach($temp_data as $config){
                        $data[$config['name']] = $config['value'];
                }

                $temp_data = $this->User_model->get_admin();
                foreach($temp_data as $config){
                        $data['admin_email'] = $config['email'];
                        break;
                }

		$this->load->view('header');
		$this->load->view('admin/setting', $data);
		$this->load->view('footer');
	}
}
?>
