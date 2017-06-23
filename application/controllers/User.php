<?php

class User extends CI_Controller {

	private $form_id;

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('language');
		$this->form_id = "categories";

		if(!$this->session->userdata('logged_in'))
		{ 
			redirect('authentication/user');
                }else{
			if($this->session->userdata('deleteCreateFolder') == 'YES'){
				exec("rm -rf ". UPLOAD_DIRECTORY."/".$this->session->userdata('session_id')."/");	
				$this->session->set_userdata('deleteCreateFolder', 'NO');
			}
		}
	}

	public function index()
        {
		redirect('authentication/user');
        }


	public function logout(){
		exec("rm -rf ". UPLOAD_DIRECTORY."/".$this->session->userdata('session_id')."/");
		$this->session->sess_destroy();
		redirect('user');
	}

	public function downloadMov(){
		$this->session->set_userdata('deleteCreateFolder', 'YES');
		$file = FCPATH."/".UPLOAD_DIRECTORY."/".$this->session->userdata('session_id')."/preview/".$this->session->userdata('videoName').".mov";

		$file_content = file_get_contents($file);

		exec("rm -rf ". UPLOAD_DIRECTORY."/".$this->session->userdata('session_id')."/");
		 $this->load->helper('download');
		
                 force_download("out.mov", $file_content);
        }

	public function generateMov()
	{

		
		$this->session->set_userdata('videoName', uniqid());
		$this->load->model('Config_model');
                $menu_active = "create";
                $data = array(
                                'menu_active' => $menu_active
                        );

                $data['errors'] = array();
                $data['success_message'] = array();

		$input_path = UPLOAD_DIRECTORY."/".$this->session->userdata('session_id')."/create/";
		$output_path = UPLOAD_DIRECTORY."/".$this->session->userdata('session_id')."/preview/";

		exec("rm -rf ". $output_path);

		$frame_rate = 24;
		$post_data = $this->input->post();

		if(!empty($post_data['fps'])){
			$frame_rate = $post_data['fps'];		
		}

		$res_1 = "1920";
		$res_2 = "1080";
		if(!empty($post_data['res_1'])){
			$res_1 = $post_data['res_1'];
		}
		
		if(!empty($post_data['res_2'])){
                        $res_2 = $post_data['res_2'];
                }

		$resolution = "{$res_1}X{$res_2}";
		$exec_info = null;

		if(!file_exists($output_path)){
                                $oldmask = umask(0);
                                mkdir($output_path, 0777, TRUE);
                }



		$ffmpeg_path = null;
		exec("which ffmpeg 2>&1", $ffmpeg_path);	

		$ffmpeg_path = $ffmpeg_path[0];

		$cmd_1 =  "{$ffmpeg_path} -s {$resolution} -framerate {$frame_rate} -i {$input_path}%d_temp.png -vcodec png  -r {$frame_rate} {$output_path}".$this->session->userdata('videoName').".mov";
		$cmd_2 = "{$ffmpeg_path} -s {$resolution} -framerate {$frame_rate} -i {$input_path}%d_temp.png -vcodec libx264  -r {$frame_rate} {$output_path}".$this->session->userdata('videoName').".mp4";

		exec("echo y | {$cmd_1} -hide_banner 2>&1", $exec_info);

		exec("echo y | {$cmd_2}");


		$data['vid_src'] = base_url($output_path.$this->session->userdata('videoName').".mp4");
		$data['mov_src'] = base_url($output_path.$this->session->userdata('videoName').".mov");


		$data['fps'] = $frame_rate;
		$data['res_1'] = $res_1;
		$data['res_2'] = $res_2;

	
		$data['success_message'][] = "Video created successfully";


		$this->load->view('header');
		$this->load->view('user/generate', $data);
		$this->load->view('footer');
	}


	public function create()
        {
                $this->load->model('Config_model');
                $menu_active = "create";
                $data = array(
                                'menu_active' => $menu_active
                        );

		$data['errors'] = array();
                $data['success_message'] = array();

		if (!empty($_FILES)){

			$config['upload_path']          = UPLOAD_DIRECTORY."/".$this->session->userdata('session_id')."/create/";
                        $config['allowed_types']        = 'png';
                        $config['max_size']             = $this->Config_model->get_config('file_size_limit')*1024;
                        $config['file_ext_tolower']     = true;
                        $config['overwrite']            = false;
                        $config['max_filename_increment'] = 1000;
                        $config['remove_spaces']        = true; 

			if(!file_exists($config['upload_path'])){
				$this->session->set_userdata('imageSequence', "1");
                                $oldmask = umask(0);
                                mkdir($config['upload_path'], 0777, TRUE);
                        }


			$nextSequence = $this->session->userdata('imageSequence');


                        $value = $nextSequence+1;
                        $this->session->set_userdata('imageSequence', "{$value}");
			$config['file_name'] = $nextSequence."_temp.png";

			$this->load->library('upload', $config);
                        $this->upload->initialize($config);

                        if ( ! $this->upload->do_upload('file'))
			{
				$output['error'] = $this->upload->display_errors();

				http_response_code (401);
				header( 'Content-Type: application/json; charset=utf-8' );
				echo json_encode( $output );
			}
                        else
                        {
				http_response_code (200);
			}
		}else{

			$this->load->view('header');
			$this->load->view('user/create', $data);
			$this->load->view('footer');
		}
	}

        public function convert()
        {
		$this->load->model('Config_model');
		$menu_active = "convert";
                $data = array(
                                'menu_active' => $menu_active
                        );

		$this->session->set_userdata('deleteCreateFolder', 'YES');
	
		$data['errors'] = array();
		$data['success_message'] = array();

		if (!empty($_FILES['userfile']['name'])){
			$config['upload_path']          = UPLOAD_DIRECTORY."/".$this->session->userdata('session_id')."/";
			$config['allowed_types']        = 'mov';
			$config['max_size']             = $redirect_url = $this->Config_model->get_config('file_size_limit')*1024;
			$config['file_ext_tolower']	= true;
			$config['overwrite']		= false;
			$config['max_filename_increment'] = 1000;
			$config['remove_spaces']	= true;
			//$config['encrypt_name']		= true;


			if(!file_exists($config['upload_path'])){
				$oldmask = umask(0);
				mkdir($config['upload_path'], 0777, TRUE);
			}

			$this->load->library('upload', $config);
			$this->upload->initialize($config);

			if ( ! $this->upload->do_upload('userfile'))
			{
				$data['errors'][] = $this->upload->display_errors();
			}
			else
			{
				$data['success_message'][] = lang('upload_success');
				$upload_data = $this->upload->data();
				$file_name = $upload_data['file_name'];
				$file_path = $upload_data['file_path'];

				$convert_file_name = 'convert_'.$file_name;

				exec(FFMPEG_PATH."ffmpeg -i {$file_path}{$file_name} -vcodec png -acodec png {$file_path}{$convert_file_name}");


				$file_content = file_get_contents($file_path.$convert_file_name);

				chmod($file_path.$convert_file_name, 0666);
				chmod($file_path.$file_name, 0666);

				try{
					$this->rrmdir($file_path);
				}catch(Exception $e){

				}

				$this->load->helper('download');
                                force_download($convert_file_name, $file_content);
			}
		}

		$this->load->view('header');
                $this->load->view('user/convert', $data);
                $this->load->view('footer');
        }

	private function rrmdir($dir) {
		if (is_dir($dir)) {
			$objects = scandir($dir);
			foreach ($objects as $object) {
				if ($object != "." && $object != "..") {
					if (filetype($dir."/".$object) == "dir"){
						$this->rrmdir($dir."/".$object);
					}else{ 
						unlink($dir."/".$object);
					}
				}
			}
			reset($objects);
			rmdir($dir);
		}

		$this->session->set_userdata('imageSequence', "1");
	}
}
?>
