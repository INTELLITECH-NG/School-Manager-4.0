<?php 
require_once("home.php");

class Admin_online_admission extends Home {


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
		if(!in_array(29,$this->role_modules))  
		redirect('home/access_forbidden','location');	

		$data['class_info']=$this->get_classes();
		$data['session_info']=$this->get_sessions();
		$data['shift_info']=$this->get_shifts();
		$data['section_info']=$this->get_sections();
		$data['page_title'] = $this->lang->line('online applicants');
		$data['body'] = 'admin/online_admission/applicants';
		$this->_viewcontroller($data);
	}


	public function online_students_data()
	{			
		if(!in_array(29,$this->role_modules))  
		redirect('home/access_forbidden','location');

		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'registered_at';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'DESC';
		$order_by_str=$sort." ".$order;
		
		$admission_roll=$this->input->post('admission_roll');
		$class_id=$this->input->post('class_id');
		$financial_year_id=$this->input->post('financial_year_id');
		$dept_id=$this->input->post('dept_id');
		$shift_id=$this->input->post('shift_id');
		// $section_id=$this->input->post('section_id');
		// $is_in_merit_list = $this->input->post('is_in_merit_list');
		$applicant_name = $this->input->post('applicant_name');
		$applicant_id = $this->input->post('applicant_id');
		$is_searched= $this->input->post('is_searched');
		
		if($is_searched)
		{		
			$this->session->set_userdata('online_students_data_admission_roll',$admission_roll);
			$this->session->set_userdata('online_students_data_class_id',$class_id);
			$this->session->set_userdata('online_students_data_financial_year_id',$financial_year_id);
			$this->session->set_userdata('online_students_data_dept_id',$dept_id);
			$this->session->set_userdata('online_students_data_shift_id',$shift_id);
			// $this->session->set_userdata('online_students_data_section_id',$section_id);
			// $this->session->set_userdata('online_students_data_is_in_merit_list',$is_in_merit_list);
			$this->session->set_userdata('online_students_data_applicant_name',$applicant_name);
			$this->session->set_userdata('online_students_data_applicant_id',$applicant_id);
		}
				
		$search_admission_roll=$this->session->userdata('online_students_data_admission_roll');			
		$search_class_id=$this->session->userdata('online_students_data_class_id');			
		$search_financial_year_id=$this->session->userdata('online_students_data_financial_year_id');			
		$search_dept_id=$this->session->userdata('online_students_data_dept_id');			
		$search_shift_id=$this->session->userdata('online_students_data_shift_id');			
		// $search_section_id=$this->session->userdata('online_students_data_section_id');			
		// $search_is_in_merit_list=$this->session->userdata('online_students_data_is_in_merit_list');	
		$search_applicant_name=$this->session->userdata('online_students_data_applicant_name');	
		$search_applicant_id=$this->session->userdata('online_students_data_applicant_id');	

			
		$where_simple=array();
		
		if($search_admission_roll)
			$where_simple['admission_roll']=$search_admission_roll;
		if($search_applicant_name)
			$where_simple['name like'] = "%".$search_applicant_name."%";
		if($search_applicant_id)
			$where_simple['id'] = $search_applicant_id;
		if($search_class_id)
			$where_simple['class_id']=$search_class_id;
		if($search_financial_year_id)
			$where_simple['session_id']=$search_financial_year_id;
		if($search_dept_id)
			$where_simple['dept_id']=$search_dept_id;
		if($search_shift_id)
			$where_simple['shift_id']=$search_shift_id;
		// if($search_section_id)
		// 	$where_simple['section_id']=$search_section_id;
		// if($search_is_in_merit_list != ''){
		// 	if($search_is_in_merit_list == '1')
		// 	$where_simple['is_in_merit_list']= '1';
		// 	if($search_is_in_merit_list == '2'){
		// 		$w = "is_in_merit_list is NULL";
		// 		$this->db->where($w);
		// 	}
			
		// }

		$where_simple['deleted']="0";
		$w = "is_in_merit_list is NULL";
		$this->db->where($w);
		// $this->db->or_where('is_in_merit_list',0);
				
		$where=array('where'=>$where_simple);			
		$offset = ($page-1)*$rows;
		$result = array();		
		// print_r($where_simple);		
					
		$info=$this->basic->get_data('view_applicant_info',$where,$select='',$join='',$limit=$rows,$start=$offset,$order_by=$order_by_str,$group_by='',$num_rows=1);

		$total_rows_array=$this->basic->count_row($table="view_applicant_info",$where,$count="view_applicant_info.id",$join='');
		$total_result=$total_rows_array[0]['total_rows'];
		echo convert_to_grid_data($info,$total_result);

	}


	public function merit_list(){
		if(!in_array(29,$this->role_modules))  
		redirect('home/access_forbidden','location');

		$data['class_info']=$this->get_classes();
		$data['session_info']=$this->get_sessions();
		$data['shift_info']=$this->get_shifts();
		$data['section_info']=$this->get_sections();
		$data['page_title'] = $this->lang->line('online applicants');
		$data['body'] = 'admin/online_admission/merit_list';
		$this->_viewcontroller($data);
	}


	public function merit_list_data(){
		if(!in_array(29,$this->role_modules))  
		redirect('home/access_forbidden','location');

		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'online_admission_merit_list.applicant_id';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'ASC';
		$order_by_str=$sort." ".$order;
		
		$admission_roll=$this->input->post('admission_roll');
		$class_id=$this->input->post('class_id');
		$financial_year_id=$this->input->post('financial_year_id');
		$dept_id=$this->input->post('dept_id');
		$shift_id=$this->input->post('shift_id');
		// $section_id=$this->input->post('section_id');
		$is_in_merit_list = $this->input->post('is_in_merit_list');
		$applicant_name = $this->input->post('applicant_name');
		$applicant_id = $this->input->post('applicant_id');
		$is_searched= $this->input->post('is_searched');
		
		if($is_searched)
		{		
			$this->session->set_userdata('merit_list_data_admission_roll',$admission_roll);
			$this->session->set_userdata('merit_list_data_class_id',$class_id);
			$this->session->set_userdata('merit_list_data_financial_year_id',$financial_year_id);
			$this->session->set_userdata('merit_list_data_dept_id',$dept_id);
			$this->session->set_userdata('merit_list_data_shift_id',$shift_id);
			// $this->session->set_userdata('merit_list_data_section_id',$section_id);
			$this->session->set_userdata('merit_list_data_is_in_merit_list',$is_in_merit_list);
			$this->session->set_userdata('merit_list_data_applicant_name',$applicant_name);
			$this->session->set_userdata('merit_list_data_applicant_id',$applicant_id);
		}
				
		$search_admission_roll=$this->session->userdata('merit_list_data_admission_roll');			
		$search_class_id=$this->session->userdata('merit_list_data_class_id');			
		$search_financial_year_id=$this->session->userdata('merit_list_data_financial_year_id');			
		$search_dept_id=$this->session->userdata('merit_list_data_dept_id');			
		$search_shift_id=$this->session->userdata('merit_list_data_shift_id');			
		// $search_section_id=$this->session->userdata('merit_list_data_section_id');			
		$search_is_in_merit_list=$this->session->userdata('merit_list_data_is_in_merit_list');	
		$search_applicant_name=$this->session->userdata('merit_list_data_applicant_name');	
		$search_applicant_id=$this->session->userdata('merit_list_data_applicant_id');	

			
		$where_simple=array();
		
		if($search_admission_roll)
			$where_simple['view_applicant_info.admission_roll']=$search_admission_roll;
		if($search_applicant_name)
			$where_simple['view_applicant_info.name like'] = "%".$search_applicant_name."%";
		if($search_applicant_id)
			$where_simple['online_admission_merit_list.applicant_id'] = $search_applicant_id;
		if($search_class_id)
			$where_simple['online_admission_merit_list.class_id']=$search_class_id;
		if($search_financial_year_id)
			$where_simple['online_admission_merit_list.session_id']=$search_financial_year_id;
		if($search_dept_id)
			$where_simple['online_admission_merit_list.dept_id']=$search_dept_id;
		if($search_shift_id)
			$where_simple['online_admission_merit_list.shift_id']=$search_shift_id;
		// if($search_section_id)
		// 	$where_simple['view_applicant_info.section_id']=$search_section_id;
		

		$where_simple['deleted']="0";
		// $where_simple['view_applicant_info.status'] = "1";
				
		$where=array('where'=>$where_simple);			
		$offset = ($page-1)*$rows;
		$result = array();		
		// print_r($where_simple);
		$join = array('view_applicant_info' => 'view_applicant_info.id=online_admission_merit_list.applicant_id,left');	

		$select = array(
			'view_applicant_info.*',
			'online_admission_merit_list.applicant_id as applicant_id',
			'online_admission_merit_list.status as merit_status'
			);	
					
		$info=$this->basic->get_data('online_admission_merit_list',$where,$select,$join,$limit=$rows,$start=$offset,$order_by=$order_by_str,$group_by='',$num_rows=1);

		$total_rows_array=$this->basic->count_row($table="online_admission_merit_list",$where,$count="online_admission_merit_list.id",$join);
		$total_result=$total_rows_array[0]['total_rows'];
		echo convert_to_grid_data($info,$total_result);
	}
	

	public function applicant_to_merit(){
		if(!in_array(29,$this->role_modules))  
		redirect('home/access_forbidden','location');

		$info=$this->input->post('info');
		$info=json_decode($info,TRUE);
		$count=count($info);
		
		$this->db->trans_start();		
		foreach($info as $student)
		{				
			$data = array(
				'session_id' => $student['session_id'],
				'class_id' => $student['class_id'],
				'dept_id' => $student['dept_id'],
				'shift_id' => $student['shift_id'],
				'applicant_id' => $student['id'],
				'status' => 1
				);
			$this->basic->insert_data('online_admission_merit_list',$data);

			// $where = array('id' => $student['id']);
			// $data2 = array('status' => '0');
			// $this->basic->update_data('applicant_info',$where,$data2);
	  	}
	  	$this->db->trans_complete();

	  	if ($this->db->trans_status() === FALSE){
	  		echo "error";
	  	}
	  	else{
	  		$this->session->set_userdata("applicant_to_merit_success",$count);
	  		echo "success";
	  	}
		
	}


	public function delete_from_merit_list($id=0){
		if(!in_array(29,$this->role_modules))  
		redirect('home/access_forbidden','location');		
		if(!in_array(4,$this->role_module_accesses_29))
		redirect('home/access_forbidden','location');

		$where = array('applicant_id' => $id);
		$this->basic->delete_data('online_admission_merit_list',$where);
		$this->session->set_userdata('delete_from_merit','1 student has been deleted from merit list.');
		redirect('admin_online_admission/merit_list','Location');
	}


	public function pay_slip_money($id=0){

		$this->db->trans_start();

		$where['where'] = array(
			'id' => $id
			);
		$applicant_info = $this->basic->get_data('view_applicant_info',$where,$select='');

		$where1 = array(
			'session_id' => $applicant_info[0]['session_id'],
			'class_id' => $applicant_info[0]['class_id'],
			'dept_id' => $applicant_info[0]['dept_id']
			);
		$select1 = array('form_price');
		$price = $this->basic->get_data('online_admission_configure',$where1,$select1);

		$data = array(
			'applicant_id' => $applicant_info[0]['id'],
			'price' => $price[0]['form_price'],
			'payment_method_id' => $this->config->item('offline_method_id'),
			'sold_by' => $this->session->userdata('user_id'),
			'sold_at' => date('Y-m-d G:i:s'),
			'paid_amount' => $price[0]['form_price']
			);
		$this->basic->insert_data('form_sell',$data);

		$where2 = array('id' => $applicant_info[0]['id'] );
		$data2 = array('payment_status' => '1');
		$this->basic->update_data('applicant_info',$where2,$data2);

		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE){
	  		$this->session->set_userdata("error_in_payment",$this->lang->line("an error occured ! please try again"));
	  		redirect('admin_online_admission/index','Location');
	  	}
	  	else{
	  		$this->session->set_userdata("success_in_payment",$this->lang->line("payment for form fees has been received successfully"));
	  		redirect('admin_online_admission/index','Location');
	  	}
	}
	

	public function merit_to_admission($id=0){
		if(!in_array(29,$this->role_modules))  
		redirect('home/access_forbidden','location');

		$this->db->trans_start();

		$default_section = $this->get_default_section();
		$where['where'] = array('id' => $id);
		$applicant_info = $this->basic->get_data('view_applicant_info',$where,$select='');

		$session_id = $applicant_info[0]['session_id'];
		$dept_id = $applicant_info[0]['dept_id'];
		$shift_id = $applicant_info[0]['shift_id'];
		$student_info = $this->_get_student_id($session_id,$dept_id,$shift_id);

			
			$data = array(
				'student_id' => $student_info['student_id'],
				'name' => $applicant_info[0]['name'],
				'father_name' => $applicant_info[0]['father_name'],
				'mother_name' => $applicant_info[0]['mother_name'],
				'gurdian_name' => $applicant_info[0]['gurdian_name'],
				'gurdian_relation' => $applicant_info[0]['gurdian_relation'],
				'gurdian_mobile' => $applicant_info[0]['gurdian_mobile'],
				'gurdian_email' => $applicant_info[0]['gurdian_email'],
				'class_roll' => $student_info['class_roll'],
				'class_id' => $applicant_info[0]['class_id'],
				'religion' => $applicant_info[0]['religion'],
				'dept_id' => $applicant_info[0]['dept_id'],
				'section_id' => $default_section['id'],
				'shift_id' => $applicant_info[0]['shift_id'],
				'session_id' => $applicant_info[0]['session_id'],
				'birth_date' => $applicant_info[0]['birth_date'],
				'gender' => $applicant_info[0]['gender'],
				'name_bangla' => $applicant_info[0]['name_bangla'],
				'father_name_bangla' => $applicant_info[0]['father_name_bangla'],
				'mother_name_bangla' => $applicant_info[0]['mother_name_bangla'],
				'gurdian_occupation' => $applicant_info[0]['gurdian_occupation'],
				'gurdian_income' => $applicant_info[0]['gurdian_income'],
				'gurdian_present_village' => $applicant_info[0]['gurdian_present_village'],
				'gurdian_present_post' => $applicant_info[0]['gurdian_present_post'],
				'gurdian_present_thana' => $applicant_info[0]['gurdian_present_thana'],
				'gurdian_present_district' => $applicant_info[0]['gurdian_present_district'],
				'gurdian_permanent_village' => $applicant_info[0]['gurdian_permanent_village'],
				'gurdian_permanent_post' => $applicant_info[0]['gurdian_permanent_post'],
				'gurdian_permanent_thana' => $applicant_info[0]['gurdian_permanent_thana'],
				'gurdian_permanent_district' => $applicant_info[0]['gurdian_permanent_district'],
				'quota_id' => $applicant_info[0]['quota_id'],
				'quota_description' => $applicant_info[0]['quota_description'],
				'previous_institute' => $applicant_info[0]['previous_institute'],
				'status' => '1',
				'payment_status' => '1'
				);
			if($applicant_info[0]['mobile'] != '') $data['mobile'] = $applicant_info[0]['mobile'];			
			if($applicant_info[0]['email'] != '') $data['email'] = $applicant_info[0]['email'];			
			if($applicant_info[0]['image'] != '') 
			{
				$ext=array_pop(explode('.',$applicant_info[0]['image']));
				$data['image'] = $applicant_info[0]['birth_certificate_no'].".".$ext;	
			}	
			if($applicant_info[0]['birth_certificate_no'] != '') $data['birth_certificate_no'] = $applicant_info[0]['birth_certificate_no'];	

			// if($total_amount) $data['amount'] = $total_amount;
			$this->basic->insert_data('student_info',$data);
			$student_info_id = $this->db->insert_id();

			//copy applicant image from applicant folder to student folder
			$image_extension = array_pop(explode('.',$applicant_info[0]['image']));
			$old_path = base_url()."upload/applicant/".$applicant_info[0]['image'];
			$new_path = "upload/student/".$applicant_info[0]['birth_certificate_no'].".".$image_extension;
			copy($old_path,$new_path);
			//end of copy applicant image from applicant folder to student folder

			$where1 = array('id' => $id);
			$data1 = array('deleted' => '1','status' => '0');
			$this->basic->update_data('applicant_info',$where1,$data1);

			$where2 = array('applicant_id' => $id);
			$this->basic->delete_data('online_admission_merit_list',$where2);

			$where3['where'] = array('applicant_id' => $id);
			$courses = $this->basic->get_data('applicant_course',$where3,$select3='');

			foreach($courses as $course){
				$data3 = array(
					'student_id' => $student_info_id,
					'class_id' => $course['class_id'],
					'course_id' => $course['course_id'],
					'dept_id' => $course['dept_id'],
					'session_id' => $course['session_id'],
					'type' => $course['type']
					);
				$this->basic->insert_data('student_course',$data3);
			}

			
			$password = $this->_random_number_generator();
			$data4 = array(
				'username' => $student_info['student_id'],
				'password' => md5($password),
				'role_id' => $this->config->item('student_role_id'),
				'user_type' => 'Individual',
				'type_details' => 'Student',
				'reference_id' => $student_info_id
				);
			if($applicant_info[0]['email'] != '') $data4['email'] = $applicant_info[0]['email'];
			$this->basic->insert_data('users',$data4);



			$where5['where'] = array(
				'class_id' => $applicant_info[0]['class_id'],
				'dept_id' => $applicant_info[0]['dept_id'],
				'financial_year_id' => $applicant_info[0]['session_id'],
				'slip_type' => 'Admission'
				);
			$slip = $this->basic->get_data('slip',$where5,$select5='');

			
			$data6 = array(
				'student_info_id' => $student_info_id,
				'slip_id' => $slip[0]['id'],
				'class_id' => $applicant_info[0]['class_id'],
				'payment_type' => $slip[0]['slip_type'],
				'total_amount' => $slip[0]['total_amount'],
				'date_time' => date('Y-m-d'),
				'payment_method_id' => $this->config->item('offline_method_id')
				);
			$this->basic->insert_data('transaction_history',$data6);
			


			$name_of_file = '';
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
		
			$mpdf->writetext(67,86,        $applicant_info[0]['name']);
			$mpdf->writetext(67,97,        $applicant_info[0]['father_name']);
			$mpdf->writetext(67,107.5,     $applicant_info[0]['mother_name']);
			$mpdf->writetext(67,117.5,     $applicant_info[0]['class_name']);
			$mpdf->writetext(67,128,       $student_info['class_roll']);
			$mpdf->writetext(67,138,       $student_info['student_id']);
			$mpdf->writetext(67,149,       $slip[0]['total_amount']);
			$mpdf->writetext(67,159.5,     $student_info['student_id']);
			$mpdf->writetext(67,175.5,     $password);
			$mpdf->SetFont("","",10);
			$mpdf->writetext(67,190,       "Log in @ ".base_url()."home/login");
			$mpdf->writetext(67,195,       "We recommend to change your password when you log in.");
			$mpdf->SetFont("","",20);
			$mpdf->writetext(67,40, $institute_name);
			$mpdf->SetFont("","",16);
			$temp_name = $applicant_info[0]['class_name']."_".$student_info['class_roll']."_".$student_info['student_id'];
			$hash_name = md5($temp_name);
			$name_of_file = "download/applicant/admission_confirmation_slip/".$hash_name.".pdf";
			$mpdf->output($name_of_file);
			//end of mpdf


			$this->db->trans_complete();
			//transaction ends here

			if ($this->db->trans_status() === FALSE){
	  			$this->session->set_userdata("error_in_admission",$this->lang->line("An error occured ! Please try again"));
	  			redirect('admin_online_admission/merit_list','Location');
		  	}
		  	else{
		  		$this->session->set_userdata("success_in_admission",$this->lang->line('1 student has been successfully admitted'));
		  		$this->session->set_userdata('link',$name_of_file);
		  		redirect('admin_online_admission/merit_list','Location');
		  	}
	}	

	public function applicant_profile($id=0)
	{			
		if($id==0)
		redirect('home/access_forbidden','location');

		if(!in_array(29,$this->role_modules))  
		redirect('home/access_forbidden','location');		
		if(!in_array(1,$this->role_module_accesses_29))
		redirect('home/access_forbidden','location');

		$data['body'] = 'admin/online_admission/profile';
		$table = 'view_applicant_info';
		$where_simple = array("id" => $id);				
		$where = array('where'=> $where_simple);	
		$result = $this->basic->get_data($table, $where);
		$data['info'] = $result;	
		// passing data to the method _student_viewcontroller for displaying on view page	
		$this->_viewcontroller($data);
	}


	public function merit_list_applicant_profile($id=0){
		if($id==0)
		redirect('home/access_forbidden','location');

		if(!in_array(29,$this->role_modules))  
		redirect('home/access_forbidden','location');		
		if(!in_array(1,$this->role_module_accesses_29))
		redirect('home/access_forbidden','location');

		$data['body'] = 'admin/online_admission/profile';
		$table = 'view_applicant_info';
		$where_simple = array("id" => $id);				
		$where = array('where'=> $where_simple);	
		$result = $this->basic->get_data($table, $where);
		$data['info'] = $result;	
		// passing data to the method _student_viewcontroller for displaying on view page	
		$this->_viewcontroller($data);
	}
}