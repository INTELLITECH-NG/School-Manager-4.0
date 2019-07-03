<?php 
require_once("home.php");

class Admin_student extends Home {


	function __construct()
	{
		parent::__construct();
		if($this->session->userdata('logged_in')!=1)
		redirect('home/login','location');

		if($this->session->userdata('user_type')!='Operator')
		redirect('home/login','location');
		$this->upload_path = realpath( APPPATH . '../upload/student');
	}


	public function index()
	{	
		if(!in_array(19,$this->role_modules))  
		redirect('home/access_forbidden','location');

		$data['class_info']=$this->get_classes();
		$data['session_info']=$this->get_sessions();
		$data['shift_info']=$this->get_shifts();
		$data['section_info']=$this->get_sections();
		$data['page_title'] = $this->lang->line('student admission');
		$data['body'] = 'admin/student/students';
		$this->_viewcontroller($data);
	}


	public function students_data()
	{			
		if(!in_array(19,$this->role_modules))  
		redirect('home/access_forbidden','location');

		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'student_id';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'DESC';
		$order_by_str=$sort." ".$order;
		
		$student_id=$this->input->post('student_id');
		$student_name=$this->input->post('student_name');
		$class_id=$this->input->post('class_id');
		$financial_year_id=$this->input->post('financial_year_id');
		$dept_id=$this->input->post('dept_id');
		$shift_id=$this->input->post('shift_id');
		$section_id=$this->input->post('section_id');
		$is_searched= $this->input->post('is_searched');
		
		if($is_searched)
		{		
			$this->session->set_userdata('offline_student_id',$student_id);
			$this->session->set_userdata('offline_student_name',$student_name);
			$this->session->set_userdata('offline_class_id',$class_id);
			$this->session->set_userdata('offline_financial_year_id',$financial_year_id);
			$this->session->set_userdata('offline_dept_id',$dept_id);
			$this->session->set_userdata('offline_shift_id',$shift_id);
			$this->session->set_userdata('offline_section_id',$section_id);
		}
				
		$search_student_id=$this->session->userdata('offline_student_id');			
		$search_student_name=$this->session->userdata('offline_student_name');			
		$search_class_id=$this->session->userdata('offline_class_id');			
		$search_financial_year_id=$this->session->userdata('offline_financial_year_id');			
		$search_dept_id=$this->session->userdata('offline_dept_id');			
		$search_shift_id=$this->session->userdata('offline_shift_id');			
		$search_section_id=$this->session->userdata('offline_section_id');			
			
		$where_simple=array();
		
		if($search_student_id)
		$where_simple['student_id']=$search_student_id;
		if($search_student_name)
		$where_simple['name like'] = "%".$search_student_name."%";
		if($search_class_id)
		$where_simple['class_id']=$search_class_id;
		if($search_financial_year_id)
		$where_simple['session_id']=$search_financial_year_id;
		if($search_dept_id)
		$where_simple['dept_id']=$search_dept_id;
		if($search_shift_id)
		$where_simple['shift_id']=$search_shift_id;
		if($search_section_id)
		$where_simple['section_id']=$search_section_id;

		$where_simple['deleted']="0";		
				
		$where=array('where'=>$where_simple);			
		$offset = ($page-1)*$rows;
		$result = array();	
					
		$info=$this->basic->get_data('view_student_info',$where,$select='',$join='',$limit=$rows,$start=$offset,$order_by=$order_by_str,$group_by='',$num_rows=1);

		$total_rows_array=$this->basic->count_row($table="view_student_info",$where,$count="view_student_info.id",$join='');
		$total_result=$total_rows_array[0]['total_rows'];
		echo convert_to_grid_data($info,$total_result);

	}


	public function add_student()
	{		
		if(!in_array(19,$this->role_modules))  
		redirect('home/access_forbidden','location');		
		if(!in_array(2,$this->role_module_accesses_19))
		redirect('home/access_forbidden','location');

		$data['religion'] = $this->religion_generator(); 
		$data['default_shift'] = $this->get_default_shift();
		$data['default_section'] = $this->get_default_section();
		$data['class_info']=$this->get_classes();
		$data['session_info']=$this->get_sessions();
		$data['shift_info']=$this->get_shifts();
		$data['section_info']=$this->get_sections();
		$data['page_title'] = $this->lang->line('student admission');	
		$data['body']='admin/student/add_student';
		$this->_viewcontroller($data);
	}

	public function add_student_action() 
	{		
		if($_SERVER['REQUEST_METHOD'] === 'GET') 
		redirect('home/access_forbidden','location');

		if(!in_array(19,$this->role_modules))  
		redirect('home/access_forbidden','location');		
		if(!in_array(2,$this->role_module_accesses_19))
		redirect('home/access_forbidden','location');

		$this->form_validation->set_rules('student_name','<b>'.$this->lang->line('student name').'</b>', 'trim|required');	
		$this->form_validation->set_rules('student_email','<b>'.$this->lang->line('student email').'</b>', 'trim|xss_clean|valid_email');	
		$this->form_validation->set_rules('gurdian_email','<b>'.$this->lang->line('gurdian email').'</b>', 'trim|xss_clean|valid_email');	
		$this->form_validation->set_rules('student_mobile','<b>'.$this->lang->line('student mobile').'</b>', 'trim|xss_clean');	
		$this->form_validation->set_rules('date_of_birth','<b>'.$this->lang->line('student date of birth').'</b>', 'trim|required');	
		$this->form_validation->set_rules('gender','<b>'.$this->lang->line('gender').'</b>', 'trim|required');	
		$this->form_validation->set_rules('religion','<b>'.$this->lang->line('religion').'</b>', 'trim|required');	
		$this->form_validation->set_rules('father_of_student','<b>'.$this->lang->line('father name').'</b>', 'trim|required');	
		$this->form_validation->set_rules('mother_of_student','<b>'.$this->lang->line('mother name').'</b>', 'trim|required');	
		$this->form_validation->set_rules('gurdian_of_student','<b>'.$this->lang->line('guardian name').'</b>', 'trim|required');	
		$this->form_validation->set_rules('relation_with_student','<b>'.$this->lang->line('relation').'</b>', 'trim|required');	
		$this->form_validation->set_rules('gurdian_mobile','<b>'.$this->lang->line('guardian mobile').'</b>', 'trim|required|xss_clean');	
		$this->form_validation->set_rules('class_id','<b>'.$this->lang->line('class').'</b>', 'trim|required');	
		$this->form_validation->set_rules('dept_id','<b>'.$this->lang->line('group/dept.').'</b>', 'trim|required');	
		$this->form_validation->set_rules('financial_year_id','<b>'.$this->lang->line('session').'</b>', 'trim|required');	
		// $this->form_validation->set_rules('shift_id','<b>b>', 'strim|required');	
		// $this->form_validation->set_rules('section_id','<b>Section</b>', 'trim|required');	

		if($this->form_validation->run() == FALSE){
			$this->add_student();
		}
		else{
			$name = $this->input->post('student_name');
			$email = $this->input->post('student_email');
			$mobile = $this->input->post('student_mobile');
			$gender = $this->input->post('gender');

			$date_of_birth = $this->input->post('date_of_birth');
			$birth_date = date('Y-m-d', strtotime($date_of_birth));

			$religion = $this->input->post('religion');
			$father_name = $this->input->post('father_of_student');
			$mother_name = $this->input->post('mother_of_student');
			$gurdian_name = $this->input->post('gurdian_of_student');
			$relation_with_gurdian = $this->input->post('relation_with_student');
			$gurdian_mobile = $this->input->post('gurdian_mobile');
			$gurdian_email = $this->input->post('gurdian_email');
			$class_id = $this->input->post('class_id');
			$dept_id = $this->input->post('dept_id');
			$session_id = $this->input->post('financial_year_id');
			$courses = $this->input->post('course_id');
			$types = $this->input->post('type');
			$shift_id = $this->input->post('shift_id');
			$section_id = $this->input->post('section_id');

			$total_amount = $this->input->post('total_amount');
			$slip_id = $this->input->post('slip_id');
			$payment_type = $this->input->post('payment_type');
			if(isset($_POST['fees']))
				$fees = '1';
			else
				$fees = '0';

			if(isset($_POST['print_slip']))
				$print_slip = '1';
			else
				$print_slip = '0';

			//transaction start here
			$this->db->trans_start();
			
			$student_info = $this->_get_student_id($session_id,$dept_id,$shift_id);

			$photo_name = '';
			if($_FILES['userfile']['size'] != 0){
				$photo = $student_info['student_id'].".jpg";
				$config = array(
					"allowed_types" => "jpg|png|jpeg",
					"upload_path" => $this->upload_path,
					"overwrite" => TRUE,
					"file_name" => $photo
					);
				$this->load->library('upload', $config);
				if($this->upload->do_upload('userfile')){
					$photo_name = $photo;
				}	
				else{
					$this->session->set_flashdata('upload_error',$this->upload->display_errors());
					// redirect("admin_student/add_student",'location');
					return $this->add_student();
				}
			}

			$data = array(
				'student_id' => $student_info['student_id'],
				'name' => $name,
				'father_name' => $father_name,
				'mother_name' => $mother_name,
				'gurdian_name' => $gurdian_name,
				'gurdian_relation' => $relation_with_gurdian,
				'gurdian_mobile' => $gurdian_mobile,
				'gurdian_email' => $gurdian_email,
				'class_roll' => $student_info['class_roll'],
				'class_id' => $class_id,
				'religion' => $religion,
				'dept_id' => $dept_id,
				'section_id' => $section_id,
				'shift_id' => $shift_id,
				'session_id' => $session_id,
				'birth_date' => $birth_date,
				'gender' => $gender,
				'status' => '1',
				'payment_status' => '1'
				);
			if($mobile != '') $data['mobile'] = $mobile;			
			if($email != '') $data['email'] = $email;			
			if($photo_name != '') $data['image'] = $photo_name;	
			// if($total_amount) $data['amount'] = $total_amount;
			$this->basic->insert_data('student_info',$data);

			$student_info_id = $this->db->insert_id();


			for($i=0;$i<count($courses);$i++){
				if($types[$i] != 2 ){
					$data1 = array(
						'student_id' => $student_info_id,
						'class_id' => $class_id,
						'course_id' => $courses[$i],
						'dept_id' => $dept_id,
						'session_id' => $session_id
						);
					if($types[$i] == 1)
						$data1['type'] = '1';
					if($types[$i] == 0)
						$data1['type'] = '0';

					$this->basic->insert_data('student_course',$data1);
				}
				
			}

			$password = $this->_random_number_generator();
			$data2 = array(
				'username' => $student_info['student_id'],
				'password' => md5($student_info['student_id']),
				'role_id' => $this->config->item('student_role_id'),
				'user_type' => 'Individual',
				'type_details' => 'Student',
				'reference_id' => $student_info_id
				);
			if($email != '') $data2['email'] = $email;
			$this->basic->insert_data('users',$data2);


			if($fees == '1'){
				$data3 = array(
					'user_id' => $student_info_id,
					'slip_id' => $slip_id,
					'class_id' => $class_id,
					'student_info_id' => $student_info_id,
					'date_time' => date('Y-m-d H:i:s'),
					'payment_type' => $payment_type,
					'payment_method'=> 'Offline',
					'payment_method_id'=> $this->config->item("offline_method_id"),
					'paid_amount' => $total_amount,
					'payment_date' => date('Y-m-d H:i:s')
					);
				$this->basic->insert_data('transaction_history',$data3);
			}

			
			
			$name_of_file = '';
			if($print_slip == '1'){
				$where4['where'] = array('id' => $class_id);
				$select = array('class_name');
				$class_name = $this->basic->get_data('class',$where4,$select);
				//mpdf starts here for generating admission confirmation slip
				include("mpdf/mpdf.php");
				ini_set("memory_limit", "-1");
				set_time_limit(0);


				$mpdf = new mpdf("","A4",16,"");
				$mpdf->ignore_invalid_utf8 = true;
				$mpdf->SetDisplayMode("fullpage");
				$mpdf->SetImportUse();
				$pagecount = $mpdf->SetSourceFile("templates/slip.pdf");
				$tplid = $mpdf->ImportPage($pagecount);
				$mpdf->SetPageTemplate($tplid);
				$mpdf->AddPage();
				$page_no = 0;
				$html = "";

				$institute_name = $this->config->item('institute_address1');
			
				$mpdf->writetext(67,86,     $name);
				$mpdf->writetext(67,97,    $father_name);
				$mpdf->writetext(67,107.5,      $mother_name);
				$mpdf->writetext(67,117.5,   $class_name[0]['class_name']);
				$mpdf->writetext(67,128,     $student_info['class_roll']);
				$mpdf->writetext(67,138,   $student_info['student_id']);
				$mpdf->writetext(67,149,   $total_amount);
				$mpdf->writetext(67,159.5,   $student_info['student_id']);
				$mpdf->writetext(67,175.5,   $student_info['student_id']);
				$mpdf->SetFont("","",10);
				$mpdf->writetext(67,190,       "Log in @ ".base_url()."home/login");
				$mpdf->writetext(67,195,       "We recommend to change your password when you log in.");
				$mpdf->SetFont("","",20);
				$mpdf->writetext(67,40, $institute_name);
				$mpdf->SetFont("","",16);
				$temp_name = $class_name[0]['class_name']."_".$student_info['class_roll']."_".$student_info['student_id'];
				// $temp_name = 'dsfkjlkdfj';
				$hash_name = md5($temp_name);
				$name_of_file = "download/applicant/admission_confirmation_slip/".$hash_name.".pdf";
				$mpdf->output($name_of_file);
				// exit();
				//end of mpdf
			}
			

			$this->db->trans_complete();
			//transaction ends here

			if ($this->db->trans_status() === FALSE)										
				$this->session->set_flashdata('error_message',1);	
			else{
				$this->session->set_flashdata('student_added',$this->lang->line('1 student has been added successfully').'.');
				$this->session->set_userdata('link',$name_of_file);
			}	
			redirect('admin_student/add_student','location');

		}

	}

	public function get_dept_based_on_class(){
		$class_id = $this->input->post('class_id');
		$where['where'] = array(
			'class_id' => $class_id
			);
		$select = array('id','dept_name');
		$depts = $this->basic->get_data('department',$where,$select);
		$str = '<select name="dept_id" class="form-control" id="department_id" required onchange="get_course()">
				<option value="">'.$this->lang->line('group / dept.').'</option>';
		foreach($depts as $dept){
			$str .= '<option value="'.$dept["id"].'">'.$dept["dept_name"].'</option>';
		}
		$str .= '</select>';
		echo $str;
	}

	public function get_dept_for_student_edit(){
		$class_id = $this->input->post('class_id');
		$dept_id = $this->input->post('dept_id');
		$where['where'] = array(
			'class_id' => $class_id
			);
		$select = array('id','dept_name');
		$depts = $this->basic->get_data('department',$where,$select);
		$str = '<select name="dept_id" class="form-control" id="department_id" required onchange="get_course()">
				<option value="">'.$this->lang->line('group / dept.').'</option>';
		foreach($depts as $dept){
			if($dept['id'] == $dept_id)
				$str .= '<option value="'.$dept["id"].'" selected >'.$dept["dept_name"].'</option>';
			else
				$str .= '<option value="'.$dept["id"].'">'.$dept["dept_name"].'</option>';
		}
		$str .= '</select>';
		echo $str;
	}

	public function get_student_course(){
		$class_id = $this->input->post('class_id');
		$dept_id = $this->input->post('dept_id');
		$session_id = $this->input->post('session_id');
		$where['where'] = array(
			'class_id' => $class_id,
			'dept_id' => $dept_id,
			'session_id' => $session_id
			);
		$select = array('id','course_name','type');
		$courses = $this->basic->get_data('course',$where,$select);
		$str = '<div class="dropdown">
            <button class="btn btn-default dropdown-toggle" type="button" id="search_primary_buttom" data-toggle="dropdown" aria-expanded="true">
                Courses
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu" aria-labelledby="search_primary_buttom" id="search_primary_ul">';

        foreach($courses as $course){
        	if($course['type'] == 1)
        		$str .= '<li role="presentation"><a role="menuitem" tabindex="-1" href="#"><label class="checkbox-inline"><input readonly checked="checked" type="checkbox" name="courses[]" value="'.$course['id'].'">  '.$course['course_name'].'</label></a></li>';
        	else
        		$str .= '<li role="presentation"><a role="menuitem" tabindex="-1" href="#"><label class="checkbox-inline"><input type="checkbox" name="courses[]" value="'.$course['id'].'">  '.$course['course_name'].'</label></a></li>';
        }  
        $str .= '<li role="presentation" id="search_primary_done"><a role="menuitem" tabindex="-1" href="#"><center><input class="btn btn-success" style="border-radius:10px !important;" value="done" /></center></a></li>
            </ul>
        </div>';
        echo $str;

	}

	public function get_course_for_edit_student(){
		$class_id = $this->input->post('class_id');
		$dept_id = $this->input->post('dept_id');
		$session_id = $this->input->post('session_id');
		$id = $this->input->post('id');

		$where['where'] = array
		(
			'class_id' => $class_id,
			'dept_id' => $dept_id,
			'session_id' => $session_id
		);
		$select = array('id','course_code','course_name','type');
		$courses = $this->basic->get_data('course',$where,$select);

		$where2['where'] = array('student_id' => $id);
		$select2 = array('course_id','type');
		$student_courses = $this->basic->get_data('student_course',$where2,$select2);
		$student_course_ids = array();
		foreach($student_courses as $student_course){
			$st_crs[$student_course['course_id']] = $student_course['type'];
			$student_course_ids[] = $student_course['course_id'];
		}

		echo "<div class='table-responsive'>";
        echo "<table width='100%'>";
        foreach($courses as $course)
        {
        	echo "<tr>";
        	echo "<td style='padding-top:10px !important;'>";
	        	echo "<input type='hidden' name='course_id[]' value='".$course['id']."'/>";
	        	echo $course['course_name'].' '.$course['course_code'];
	        echo "</td>";
	        echo "<td style='padding-top:10px !important;'>";
	        	$disabled="";        	
	        	echo '<select name="type[]"  required class="form-control" style="display:inline !important;">';
	        		if($course['type']=="1"){
        				echo '<option value="1">'.$this->lang->line('mandatory').'</option>';
        			}
        			if($course['type']=="0" && $st_crs[$course['id']]=="0"){
        				echo '<option value="1">'.$this->lang->line('mandatory').'</option>';
        				echo '<option selected value="0">'.$this->lang->line('optional').'</option>';
        				echo '<option value="2">'.$this->lang->line('not interested').'</option>';
        			}
        			if($course['type']=="0" && $st_crs[$course['id']]=="1"){
        				echo '<option selected value="1">'.$this->lang->line('mandatory').'</option>';
        				echo '<option value="0">'.$this->lang->line('optional').'</option>';
        				echo '<option value="2">'.$this->lang->line('not interested').'</option>';
        			}
        			if(!in_array($course['id'], $student_course_ids)){
        				echo '<option value="1">'.$this->lang->line('mandatory').'</option>';
        				echo '<option value="0">'.$this->lang->line('optional').'</option>';
        				echo '<option selected value="2">'.$this->lang->line('not interested').'</option>';
        			}
	        	echo '</select>';
        	echo "</td>";
        	echo "</tr>";
        } 
        echo "</table>";
        echo "</div>"; 

		
	}


	public function edit_student_profile($id=0)
	{		
		if(!in_array(19,$this->role_modules))  
		redirect('home/access_forbidden','location');		
		if(!in_array(3,$this->role_module_accesses_19))
		redirect('home/access_forbidden','location');

		if($id==0)
		redirect('home/access_forbidden','location');

		$data['religion'] = $this->religion_generator(); 
		$data['default_shift'] = $this->get_default_shift();
		$data['default_section'] = $this->get_default_section();
		$data['class_info']=$this->get_classes();
		$data['session_info']=$this->get_sessions();
		$data['shift_info']=$this->get_shifts();
		$data['section_info']=$this->get_sections();

		$data['body']='admin/student/update_student';

		$table='student_info';	
		$where['where'] = array('id'=>$id);
		$data['student_info']=$this->basic->get_data($table,$where,$select='');

		$this->_viewcontroller($data);
	}


	public function edit_student_profile_action() 
	{		
		if($_SERVER['REQUEST_METHOD'] === 'GET') 
		redirect('home/access_forbidden','location');

		if(!in_array(19,$this->role_modules))  
		redirect('home/access_forbidden','location');		
		if(!in_array(3,$this->role_module_accesses_19))
		redirect('home/access_forbidden','location');

		$id = $this->input->post('student_id');
		$email = $this->input->post('student_email');
		$mobile = $this->input->post('student_mobile');

		$email_val = "student_info.email.".$id;
		$mobile_val = "student_info.mobile.".$id;


		$this->form_validation->set_rules('student_name','<b>'.$this->lang->line('student name').'</b>', 'trim|required');	
		$this->form_validation->set_rules('student_email','<b>'.$this->lang->line('student email').'</b>', "trim|is_unique[$email_val]");	
		$this->form_validation->set_rules('gurdian_email','<b>'.$this->lang->line('gurdian email').'</b>', 'trim|xss_clean|valid_email');	
		$this->form_validation->set_rules('student_mobile','<b>'.$this->lang->line('student mobile').'</b>', "trim|xss_clean");	
		$this->form_validation->set_rules('date_of_birth','<b>'.$this->lang->line('student date of birth').'</b>', 'trim|required');	
		$this->form_validation->set_rules('gender','<b>'.$this->lang->line('gender').'</b>', 'trim|required');	
		$this->form_validation->set_rules('religion','<b>'.$this->lang->line('religion').'</b>', 'trim');	
		$this->form_validation->set_rules('father_of_student','<b>'.$this->lang->line('father name').'</b>', 'trim|required');	
		$this->form_validation->set_rules('mother_of_student','<b>'.$this->lang->line('mother name').'</b>', 'trim|required');	
		$this->form_validation->set_rules('gurdian_of_student','<b>'.$this->lang->line('guardian name').'</b>', 'trim|required');	
		$this->form_validation->set_rules('relation_with_student','<b>'.$this->lang->line('relation').'</b>', 'trim|required');	
		$this->form_validation->set_rules('gurdian_mobile','<b>'.$this->lang->line('guardian mobile').'</b>', 'trim|required|xss_clean');	
		$this->form_validation->set_rules('class_id','<b>'.$this->lang->line('class').'</b>', 'trim|required');	
		$this->form_validation->set_rules('dept_id','<b>'.$this->lang->line('group/dept.').'</b>', 'trim|required');	
		$this->form_validation->set_rules('financial_year_id','<b>'.$this->lang->line('session').'</b>', 'trim|required');	
		// $this->form_validation->set_rules('shift_id','<b>b>', 'strim|required');	
		// $this->form_validation->set_rules('section_id','<b>Section</b>', 'trim|required');	

		

		if($this->form_validation->run() == FALSE){
			$this->edit_student_profile($id);
		}
		else{
			$name = $this->input->post('student_name');
			$email = $this->input->post('student_email');
			$mobile = $this->input->post('student_mobile');
			$gender = $this->input->post('gender');

			$date_of_birth = $this->input->post('date_of_birth');
			$birth_date = date('Y-m-d', strtotime($date_of_birth));

			$religion = $this->input->post('religion');
			$father_name = $this->input->post('father_of_student');
			$mother_name = $this->input->post('mother_of_student');
			$gurdian_name = $this->input->post('gurdian_of_student');
			$relation_with_gurdian = $this->input->post('relation_with_student');
			$gurdian_mobile = $this->input->post('gurdian_mobile');
			$gurdian_email = $this->input->post('gurdian_email');
			$class_id = $this->input->post('class_id');
			$dept_id = $this->input->post('dept_id');
			$session_id = $this->input->post('financial_year_id');
			// $courses = $this->input->post('courses');
			$courses = $this->input->post('course_id');
			$types = $this->input->post('type');
			$shift_id = $this->input->post('shift_id');
			$section_id = $this->input->post('section_id');

			$where['where'] = array('id'=>$id);
			$student_info = $this->basic->get_data('student_info',$where,$select=array('student_id'));
			$photo_name = '';
			if($_FILES['userfile']['size'] != 0){
				$photo = $student_info[0]['student_id'].".jpg";
				$config = array(
					"allowed_types" => "jpg|png|jpeg",
					"upload_path" => $this->upload_path,
					"overwrite" => TRUE,
					"file_name" => $photo
					);
				$this->load->library('upload', $config);
				if($this->upload->do_upload('userfile')){
					$photo_name = $photo;
				}	
				else{
					$this->session->set_flashdata('upload_error',$this->upload->display_errors());
					redirect("admin_student/edit_student_profile/$id",'location');
				}
			}


			$this->db->trans_start();//transaction start here

			$data = array(
				'student_id' => $student_info[0]['student_id'],
				'name' => $name,
				'father_name' => $father_name,
				'mother_name' => $mother_name,
				'gurdian_name' => $gurdian_name,
				'gurdian_relation' => $relation_with_gurdian,
				'gurdian_mobile' => $gurdian_mobile,
				'gurdian_email' => $gurdian_email,
				'class_id' => $class_id,
				'religion' => $religion,
				'dept_id' => $dept_id,
				'section_id' => $section_id,
				'shift_id' => $shift_id,
				'session_id' => $session_id,
				'birth_date' => $birth_date,
				'gender' => $gender,
				'mobile' => NULL,
				'email' => NULL,
				'image' => NULL
				);
			if($mobile != '') $data['mobile'] = $mobile;			
			if($email != '') $data['email'] = $email;			
			if($photo_name != '') $data['image'] = $photo_name;	
			$where = array('id' => $id);
			$this->basic->update_data('student_info',$where,$data);
			// $student_info_id = $this->db->insert_id();

			$this->basic->delete_data('student_course',$where=array('student_id'=>$id));

			// for($i=0;$i<count($courses);$i++){
			// 	$data1 = array(
			// 		'student_id' => $id,
			// 		'class_id' => $class_id,
			// 		'course_id' => $courses[$i],
			// 		'dept_id' => $dept_id,
			// 		'session_id' => $session_id
			// 		);
			// 	$this->basic->insert_data('student_course',$data1);
			// }

			for($i=0;$i<count($courses);$i++){
				if($types[$i] != 2 ){
					$data1 = array(
						'student_id' => $id,
						'class_id' => $class_id,
						'course_id' => $courses[$i],
						'dept_id' => $dept_id,
						'session_id' => $session_id
						);
					if($types[$i] == 1)
						$data1['type'] = '1';
					if($types[$i] == 0)
						$data1['type'] = '0';

					$this->basic->insert_data('student_course',$data1);
				}
				
			}


			// $data2 = array(
			// 	'username' => $student_info[0]['student_id'],
			// 	'password' => md5($student_info[0]['student_id']),
			// 	'role_id' => $this->config->item('student_role_id'),
			// 	'user_type' => 'Individual',
			// 	'type_details' => 'Student',
			// 	'reference_id' => $id
			// 	);
			// if($email != '') $data2['email'] = $email;
			// $this->basic->update_data('users',$where=array('username' => $student_info[0]['student_id']),$data2);
			
			$this->db->trans_complete();//transaction ends here

			if ($this->db->trans_status() === FALSE)										
				$this->session->set_flashdata('error_message',1);	
			else	
				$this->session->set_flashdata('success_message',1);
			redirect("admin_student/index",'location');

		}

	}	


	public function delete_student($id=0){
		if($id==0)
		redirect('home/access_forbidden','location');

		if(!in_array(19,$this->role_modules))  
		redirect('home/access_forbidden','location');		
		if(!in_array(4,$this->role_module_accesses_19))
		redirect('home/access_forbidden','location');

		$where['where'] = array('id'=>$id);
		$student_info = $this->basic->get_data('student_info',$where,$select=array('student_id'));

		$this->db->trans_start();//transaction start here

		$where2 = array('id'=>$id);
		$data2 = array('deleted'=>'1');
		$this->basic->update_data('student_info',$where2,$data2);

		$where3 = array('username'=>$student_info[0]['student_id']);
		$data3 = array('status'=>'0');
		$this->basic->update_data('users',$where3,$data3);

		$this->db->trans_complete();//transaction ends here

		if ($this->db->trans_status() === FALSE)										
			$this->session->set_flashdata('delete_error_message',1);	
		else	
			$this->session->set_flashdata('delete_success_message',1);
		redirect("admin_student/index",'location');
	}

	public function student_queries()
	{		
		if(!in_array(21,$this->role_modules))  
		redirect('home/access_forbidden','location');

		$data['title'] = $this->lang->line('student query/complain');
		$data['body'] = 'admin/student/student_queries';
		$this->_viewcontroller($data);
	}


	public function student_queries_data()
	{			
		if(!in_array(21,$this->role_modules))  
		redirect('home/access_forbidden','location');

		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'replied';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'ASC';
		$order_by_str=$sort." ".$order;

		$is_searched= $this->input->post('is_searched');	
		$replied=$this->input->post('replied');
		
		if($is_searched)
		{		
			$this->session->set_userdata('student_queries_replied',$replied);
		}
		
				
		$search_replied=$this->session->userdata('student_queries_replied');		
		$where_simple=array();
		
		
		if($search_replied)
		$where_simple['replied']=$search_replied;
		else $where_simple['replied']="0";		

		$where=array('where'=>$where_simple);			
		$offset = ($page-1)*$rows;
		
		$select=array("student_query.message_subject","student_query.id as primary_key","student_query.student_info_id","student_query.message_body","DATE_FORMAT(student_query.sent_at, '%d/%m/%y %l:%m %p') as sent_at","DATE_FORMAT(student_query.reply_at, '%d/%m/%y %l:%m %p') as reply_at","student_query.replied","student_query.reply_message","student_info.name as student_name","student_info.student_id");
		$join=array('student_info'=>"student_query.student_info_id=student_info.id,left");		
					
		$info=$this->basic->get_data('student_query',$where,$select,$join,$limit=$rows,$start=$offset,$order_by=$order_by_str);
		$total_rows_array=$this->basic->count_row($table="student_query",$where,$count="student_query.id",$join);
		$total_result=$total_rows_array[0]['total_rows'];		
		echo convert_to_grid_data($info,$total_result);

	}


	public function details_query($id=0)
	{
		if($id==0)
		redirect('home/access_forbidden','location');	

		if(!in_array(21,$this->role_modules))  
		redirect('home/access_forbidden','location');

		$select=array("student_query.id as primary_key","student_query.message_subject","student_query.message_body","DATE_FORMAT(student_query.sent_at, '%d/%m/%y %l:%m %p') as sent_at","DATE_FORMAT(student_query.reply_at, '%d/%m/%y %l:%m %p') as reply_at","student_query.replied","student_query.reply_message","student_query.student_info_id","student_info.name as student_name");
		$join=array('student_info'=>"student_query.student_info_id=student_info.id,left");	
		$data['query_data']=$this->basic->get_data($table="student_query",$where=array('where'=>array("student_query.id"=>$id)),$select,$join);
		$data['body']="admin/student/details_query";
		$data['page_title']="Details Query / Complain";
		$this->_viewcontroller($data);
	}

	public function reply_query($id=0)
	{
		if($id==0)
		redirect('home/access_forbidden','location');

		if(!in_array(21,$this->role_modules))  
		redirect('home/access_forbidden','location');	

		$select=array("student_query.id as primary_key","student_query.message_subject","student_query.message_body","DATE_FORMAT(student_query.sent_at, '%d/%m/%y %l:%m %p') as sent_at","DATE_FORMAT(student_query.reply_at, '%d/%m/%y %l:%m %p') as reply_at","student_query.replied","student_query.reply_message","student_query.student_info_id","student_info.name as student_name");
		$join=array('student_info'=>"student_query.student_info_id=student_info.id,left");	
		$data['query_data']=$this->basic->get_data($table="student_query",$where=array('where'=>array("student_query.id"=>$id)),$select,$join);
		$data['body']="admin/student/reply_query";
		$data['page_title']="Reply Query / Complain";
		$this->_viewcontroller($data);
	}

	public function reply_query_action()
	{
		if($_SERVER['REQUEST_METHOD'] === 'GET') 
		redirect('home/access_forbidden','location');	

		if(!in_array(21,$this->role_modules))  
		redirect('home/access_forbidden','location');

		$id=$this->input->post('student_query_id');
		$reply_message=$this->input->post('reply');

		$update_data=array("reply_message"=>$reply_message,"replied"=>"1","reply_at"=>date("Y-m-d H:i:s"));
		if($this->basic->update_data($table="student_query",$where=array("id"=>$id),$update_data))
		$this->session->set_flashdata('success_message',1);
		else $this->session->set_flashdata('error_message',1);
		redirect('admin_student/student_queries','location');	
	}

	public function student_profile($id=0)
	{			
		if($id==0)
		redirect('home/access_forbidden','location');

		$data['body'] = 'student/profile';
		$table = 'view_student_info';
		$where_simple = array("id" => $id);				
		$where = array('where'=> $where_simple);	
		$result = $this->basic->get_data($table, $where);
		$data['info'] = $result;	
		// passing data to the method _student_viewcontroller for displaying on view page	
		$this->_viewcontroller($data);
	}


	public function ajax_get_dept_based_on_class()
	{
		$class_id = $this->input->post('class_id');

		// get all dept/groups of the class
		$where['where'] = array('class_id' => $class_id);
		$select = array('id','dept_name');
		$depts = $this->basic->get_data('department',$where,$select);
		$str = '<select name="dept_id" class="form-control" id="department_id" onchange="get_course()">
				<option value="">'.$this->lang->line('group / dept.').'</option>';
		foreach($depts as $dept)
		{
			$str .= '<option value="'.$dept["id"].'">'.$dept["dept_name"].'</option>';
		}
		$str .= '</select>';
		echo $str;
	}

	public function ajax_get_student_course()
	{
		$class_id = $this->input->post('class_id');
		$dept_id = $this->input->post('dept_id');
		$session_id = $this->input->post('session_id');
		$where['where'] = array
		(
			'class_id' => $class_id,
			'dept_id' => $dept_id,
			'session_id' => $session_id
		);
		$select = array('id','course_code','course_name','type');
		$courses = $this->basic->get_data('course',$where,$select);

        echo "<div class='table-responsive'>";
        echo "<table width='100%'>";
        foreach($courses as $course)
        {
        	echo "<tr>";
        	echo "<td style='padding-top:10px !important;'>";
	        	echo "<input type='hidden' name='course_id[]' value='".$course['id']."'/>";
	        	echo $course['course_name'].' '.$course['course_code'];
	        echo "</td>";
	        echo "<td style='padding-top:10px !important;'>";
	        	$disabled="";        	
	        	echo '<select name="type[]"  required class="form-control" style="display:inline !important;">';
	        		echo '<option value="1">'.$this->lang->line('mandatory').'</option>';
	        		if($course['type']!="1"){
	        			echo '<option selected value="2">'.$this->lang->line('not interested').'</option>';
	        			echo '<option value="0">'.$this->lang->line('optional').'</option>';
	        		} 
	        			
	        	echo '</select>';
        	echo "</td>";
        	echo "</tr>";
        } 
        echo "</table>";
        echo "</div>"; 
       
	}


	public function ajax_get_student_payment_info(){
		$class_id = $this->input->post('class_id');
		$dept_id = $this->input->post('dept_id');
		$session_id = $this->input->post('session_id');
		$where['where'] = array
		(
			'class_id' => $class_id,
			'dept_id' => $dept_id,
			'financial_year_id' => $session_id,
			'slip_type' => 'Admission'
		);
		$payment_info = $this->basic->get_data('slip',$where,$select='');
		if(!empty($payment_info)){
			echo '<div class="form-group">
		              <input type="hidden" name="total_amount" value="'.$payment_info[0]["total_amount"].'" />
		              <input type="hidden" name="slip_id" value="'.$payment_info[0]["id"].'" />
		              <input type="hidden" name="payment_type" value="'.$payment_info[0]["slip_type"].'" />
		              <label for="fees">Pay Fees:    &nbsp&nbsp<input type="checkbox" name="fees" id="fees" value="1"/></label>
		            </div>
		            <div class="form-group">
		              <label for="print_slip">Download Slip:    &nbsp&nbsp<input type="checkbox" name="print_slip" id="print_slip" /></label>
		            </div>';
		}
		else{
			echo "";
		}
	}


	public function certificates(){
		if(!in_array(20,$this->role_modules))  
		redirect('home/access_forbidden','location');

		$data['class_info']=$this->get_classes();
		$data['session_info']=$this->get_sessions();
		$data['shift_info']=$this->get_shifts();
		$data['section_info']=$this->get_sections();
		$data['page_title'] = $this->lang->line('student admission');
		$data['body'] = 'admin/student/certificates';
		$this->_viewcontroller($data);

	} 

	public function certificates_data(){
		if(!in_array(20,$this->role_modules))  
		redirect('home/access_forbidden','location');	

		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'student_id';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'ASC';
		$order_by_str=$sort." ".$order;
		
		$student_id=$this->input->post('student_id');
		$class_id=$this->input->post('class_id');
		$financial_year_id=$this->input->post('financial_year_id');
		$dept_id=$this->input->post('dept_id');
		$shift_id=$this->input->post('shift_id');
		$section_id=$this->input->post('section_id');
		$is_searched= $this->input->post('is_searched');
		
		if($is_searched)
		{		
			$this->session->set_userdata('certificates_student_id',$student_id);
			$this->session->set_userdata('certificates_class_id',$class_id);
			$this->session->set_userdata('certificates_financial_year_id',$financial_year_id);
			$this->session->set_userdata('certificates_dept_id',$dept_id);
			$this->session->set_userdata('certificates_shift_id',$shift_id);
			$this->session->set_userdata('certificates_section_id',$section_id);
		}
				
		$search_student_id=$this->session->userdata('certificates_student_id');			
		$search_class_id=$this->session->userdata('certificates_class_id');			
		$search_financial_year_id=$this->session->userdata('certificates_financial_year_id');			
		$search_dept_id=$this->session->userdata('certificates_dept_id');			
		$search_shift_id=$this->session->userdata('certificates_shift_id');			
		$search_section_id=$this->session->userdata('certificates_section_id');			
			
		$where_simple=array();
		
		if($search_student_id)
		$where_simple['student_id']=$search_student_id;
		if($search_class_id)
		$where_simple['class_id']=$search_class_id;
		if($search_financial_year_id)
		$where_simple['session_id']=$search_financial_year_id;
		if($search_dept_id)
		$where_simple['dept_id']=$search_dept_id;
		if($search_shift_id)
		$where_simple['shift_id']=$search_shift_id;
		if($search_section_id)
		$where_simple['section_id']=$search_section_id;

		$where_simple['deleted']="0";
				
		$where=array('where'=>$where_simple);			
		$offset = ($page-1)*$rows;
		$result = array();		
				
		
					
		$info=$this->basic->get_data('view_student_info',$where,$select='',$join='',$limit=$rows,$start=$offset,$order_by=$order_by_str,$group_by='',$num_rows=1);

		$total_rows_array=$this->basic->count_row($table="view_student_info",$where,$count="view_student_info.id",$join='');
		$total_result=$total_rows_array[0]['total_rows'];
			
		echo convert_to_grid_data($info,$total_result);
	}

	public function certificate_download($type_id=0, $id=0){
		// setting id as student entry id in database.
		$id = $id;			

		$table = 'view_student_info';

		/* using $where_simple function from codeigniter. */
		$where_simple = array("id" => $id);		
		$where = array('where'=> $where_simple);	

		$result = $this->basic->get_data($table, $where);					
		$data['info'] = $result;	

		

		// passing data to the method _student_viewcontroller for displaying on view page	
		// $this->_student_viewcontroller($data);	


       $NAME 		 =  $result[0]["name"]; 
       $FATHER  	 =  $result[0]["father_name"];
       $MOTHER_NAME  =  $result[0]["mother_name"];
  //   $VILLAGE	 	 =  $result[0]["guardian_present_village"];
  //   $POST_1	 	 =  $result[0]["guardian_present_post"];
  //   $THANA		 =  $result[0]["guardian_present_thana"];
  //   $DISTRICT	 =  $result[0]["guardian_present_district"];
       $STUDENT_ID   =  $result[0]["student_id"];
       $ROLL		 =  $result[0]["class_roll"];
       $SESSION_1	 =  $result[0]["session_id"];
       $CLASS        =  $result[0]["class_id"];
       $GROUP_DEPT	 =  $result[0]["dept_id"];
       $SECTION      =  $result[0]["section_id"];
       $SHIFT		 =  $result[0]["shift_id"];		 	

       
        $table1 = "certificate_template";

        $where_simple = array("id" => $type_id);		
		
		$where = array('where'=> $where_simple);	

		$result1 = $this->basic->get_data($table1, $where);						

		$CONTENT = $result1[0]["content"];
		
		// remember this format of html script. otherwise error will occer
		$html = eval("return<<<END\n$CONTENT\nEND;\n");

		include("mpdf/mpdf.php");
		// setting memory limit to -1 for not seeing any error in case of large file.
		ini_set("memory_limit", "-1");
		set_time_limit(0);

		// instanciate mpdf class
		$mpdf = new mpdf("","Letter",9,"");

		$mpdf->ignore_invalid_utf8 = true;
		$mpdf->SetDisplayMode("fullpage");
		$mpdf->SetImportUse();
		// setting pagecount to original form template
		// $pagecount = $mpdf->SetSourceFile("form.pdf");
		// $tplid = $mpdf->ImportPage($pagecount);
		// $mpdf->SetPageTemplate($tplid);
		// add page is important. without it WriteText wiil not work
		$mpdf->AddPage();
		$page_no = 0;		
		
		$pdfFileName = "download/student/certificate/".$STUDENT_ID.".pdf";
		$mpdf->WriteHTML($html);
		$mpdf->output($pdfFileName);

		$data['file_name'] = $pdfFileName;
		$this->load->view('page/download',$data);

	}
}