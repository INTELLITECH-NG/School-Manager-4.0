<?php

require_once("home.php");

class Admin_config extends Home 

{
	public function __construct()
	{
		parent::__construct();

		if($this->session->userdata('logged_in')!=1)
		redirect('home/login','location');

		if($this->session->userdata('user_type')!='Operator')
		redirect('home/login','location');

		if(!in_array(32,$this->role_modules))  
		redirect('home/access_forbidden','location');	

	}

	// to show the config form
	public function index()
	{
		$this->configuration();
	}
	   
    public function configuration()
    {		
		$data['body'] = "admin/admin_config/edit_config";
	    $this->_viewcontroller($data); 
	}
	
  
    public function edit_config()
    {    	        	
		if($_POST)
		{	
			// validation
			$this->form_validation->set_rules('institute_name', 	'<b>'.$this->lang->line('institute name').'</b>',  	 'trim|required|xss_clean');	
			$this->form_validation->set_rules('institute_address', 	'<b'.$this->lang->line('institute address').'</b>',  'trim|required|xss_clean');	
			$this->form_validation->set_rules('institute_email', 	'<b>'.$this->lang->line('institute email').'</b>',   'trim|required|xss_clean');	
			$this->form_validation->set_rules('institute_mobile', 	'<b>'.$this->lang->line('institute mobile').'</b>',  'trim|required|xss_clean');
			$this->form_validation->set_rules('language',           '<b>'.$this->lang->line('languag').'</b>',           'trim|required|xss_clean');		

			// go to config form page if validation wrong
			if ($this->form_validation->run() == FALSE)
			{
				return $this->configuration();  
			}
			
			else
			{	
				// assign			
				$institute_name=addslashes(strip_tags($this->input->post('institute_name',true)));
				$institute_address=addslashes(strip_tags($this->input->post('institute_address',true)));
				$institute_email=addslashes(strip_tags($this->input->post('institute_email',true)));
				$institute_mobile=addslashes(strip_tags($this->input->post('institute_mobile',true)));				              
                $language=addslashes(strip_tags($this->input->post('language', true)));

				$base_path = FCPATH.'/'.'assets/images/';

    			if($_FILES['logo']['size'] != 0){
					$photo = "favicon.png";
					$config = array(
						"allowed_types" => "png",
						"upload_path" => $base_path,
						"overwrite" => TRUE,
						"file_name" => $photo,
						'max_size' => '32',
						'max_width' => '32',
						'max_height' => '100'
						);
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if(!$this->upload->do_upload('logo'))
					{
						$this->session->set_userdata('logo_error',$this->upload->display_errors());
						return $this->configuration();
					}
				}

				if($_FILES['logo_name']['size'] != 0){
					$photo = "logo_name.png";
					$config = array(
						"allowed_types" => "png",
						"upload_path" => $base_path,
						"overwrite" => TRUE,
						"file_name" => $photo,
						'max_size' => '200',
						'max_width' => '600',
						'max_height' => '300'
						);
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if(!$this->upload->do_upload('logo_name'))
					{
						$this->session->set_userdata('logo_name_error',$this->upload->display_errors());
						return $this->configuration();
					}
				}

				// writing application/config/my_config	             
	             
	              $app_my_config_data="<?php ";
	              $app_my_config_data.="\n\$config['default_page_url']='".$this->config->item('default_page_url')."';\n";
	              $app_my_config_data.="\$config['product_name']='".$this->config->item('product_name')."';\n";
	              $app_my_config_data.="\$config['product_short_name']='".$this->config->item('product_short_name')."' ;\n";
	              $app_my_config_data.="\$config['product_version']='".$this->config->item('product_version')." ';\n";
	              $app_my_config_data.="\$config['product_slogan']='".$this->config->item('product_slogan')."';\n";
	              $app_my_config_data.="\$config['institute_address1']='$institute_name';\n";
	              $app_my_config_data.="\$config['institute_address2']='$institute_address';\n";
	              $app_my_config_data.="\$config['institute_email']='$institute_email';\n";
	              $app_my_config_data.="\$config['institute_mobile']='$institute_mobile';\n\n";
	              $app_my_config_data.="\$config['admin_role_id'] =".$this->config->item('admin_role_id').";\n";
				  $app_my_config_data.="\$config['student_role_id'] =".$this->config->item('student_role_id').";\n";
	              $app_my_config_data.="\$config['teacher_role_id'] =".$this->config->item('teacher_role_id')." ;\n";
				  $app_my_config_data.="\$config['staff_role_id'] = ".$this->config->item('staff_role_id').";\n";
	              $app_my_config_data.="\$config['offline_method_id'] = ".$this->config->item("offline_method_id").";\n";
	              $app_my_config_data.="\$config['paypal_method_id'] = ".$this->config->item("paypal_method_id").";\n";
	              $app_my_config_data.="\$config['stripe_method_id'] = ".$this->config->item("stripe_method_id").";\n";
	              $app_my_config_data.="\$config['bank_method_id'] = ".$this->config->item("bank_method_id").";\n";
	              $app_my_config_data.="\$config['character_certificate_id'] = ".$this->config->item('character_certificate_id').";\n";
	              $app_my_config_data.="\$config['testimonial_certificate_id'] = ".$this->config->item('testimonial_certificate_id').";\n";
	              $app_my_config_data.="\$config['transfer_certificate_id'] = ".$this->config->item('transfer_certificate_id').";\n";
	              $app_my_config_data.="\$config['appeared_certificate_id'] = ".$this->config->item('appeared_certificate_id').";\n";
	              $app_my_config_data.="\$config['studentship_certificate_id'] = ".$this->config->item('studentship_certificate_id').";\n\n";
	              $app_my_config_data.= "\$config['language'] = '$language';\n";
	               $app_my_config_data.="\$config['currency']='".$this->config->item('currency')."';\n";
	              $app_my_config_data.="\$config['sess_use_database']	= TRUE;\n";
	              $app_my_config_data.="\$config['sess_table_name']		= 'ci_sessions';\n";

				  //writting  application/config/my_config
				  file_put_contents(APPPATH.'config/my_config.php', $app_my_config_data,LOCK_EX);
					
				$this->session->set_flashdata('success_message',1);
				redirect('admin_config/configuration','location');					
			  					
			}
		} else return $this->configuration();		
    } 
}
	






