<?php 
require_once("home.php");

class Promotion extends Home {


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
		$this->promotion_student();
	}

	public function promotion_student()
	{
		$data['class_info']=$this->get_classes();
		$data['session_info']=$this->get_sessions();
		$data['shift_info']=$this->get_shifts();
		$data['section_info']=$this->get_sections();
		$data['page_title'] = $this->lang->line('student promotion');
		$data['body'] = 'admin/promotion/promotion';
		$this->_viewcontroller($data);
	}


	public function promotion_student_data(){
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


	public function promotion_student_form($id,$name){
		$this->session->set_userdata('promotion_student_id',$id);
		$this->session->set_userdata('promotion_student_name',$name);
		$data['name'] = urldecode($name);

		$data['default_shift'] = $this->get_default_shift();
		$data['default_section'] = $this->get_default_section();
		$data['class_info']=$this->get_classes();
		$data['session_info']=$this->get_sessions();
		$data['shift_info']=$this->get_shifts();
		$data['section_info']=$this->get_sections();

		$data['page_title'] = 'Student Promotion';
		$data['body'] = 'admin/promotion/promotion_form';
		$this->_viewcontroller($data);
	}


	public function promotion_student_form_action(){

		$id = $this->session->userdata('promotion_student_id');
		$name = $this->session->userdata('promotion_student_name');

		$this->form_validation->set_rules('class_id','<b>'.$this->lang->line('class').'</b>', 'trim|required');	
		$this->form_validation->set_rules('dept_id','<b>'.$this->lang->line('group/dept.').'</b>', 'trim|required');	
		$this->form_validation->set_rules('financial_year_id','<b>'.$this->lang->line('session').'</b>', 'trim|required');

		if($this->form_validation->run() == FALSE){
			$this->promotion_student_form($id,$name);
		}

		else{
			$class_id = $this->input->post('class_id');
			$dept_id = $this->input->post('dept_id');
			$session_id = $this->input->post('financial_year_id');
			$courses = $this->input->post('course_id');			
			$shift_id = $this->input->post('shift_id');
			$section_id = $this->input->post('section_id');
			$types = $this->input->post('type');

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

			$this->db->trans_start();
		//update student info table ******************************************************************
			$data = array('dept_id' => $dept_id,
				'section_id' => $section_id,
				'shift_id' => $shift_id,
				'session_id' => $session_id,
				'class_id' => $class_id,
				'status' => '1',
				'payment_status' => '1');

			$where = array('id'=>$id);
			

		$this->basic->update_data('student_info',$where,$data);
		
		//end of update student info *****************************************************************	

		//update student course table ****************************************************************

		$this->basic->delete_data('student_course',$where=array('student_id'=>$id));
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

		// end of update student course table ****************************************************************


		//update of transaction table**************************************************************************	
			if($fees == '1'){
				$data3 = array(
					'user_id' => $id,
					'slip_id' => $slip_id,
					'payment_type' => $payment_type,
					'payment_method'=> 'Offline',
					'paid_amount' => $total_amount,
					'payment_date' => date('Y-m-d')
					);
				$this->basic->insert_data('transaction_history',$data3);
			}

		//end of update of transaction table*******************************************************************	

			$where_student['where'] = array('id'=>$id);
			$select_student_id = array('student_id');

			$student_id_info = $this->basic->get_data('student_info',$where_student,$select_student_id);
			$student_id = $student_id_info[0]['student_id'];


			$where_student_view_info['where'] = array('student_id'=>$student_id);

			$student_info = $this->basic->get_data('view_student_info',$where_student_view_info);



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
			
				$mpdf->writetext(67,86,     $student_info[0]['name']);
				$mpdf->writetext(67,97,    $student_info[0]['father_name']);
				$mpdf->writetext(67,107.5,     $student_info[0]['mother_name']);
				$mpdf->writetext(67,117.5,   $student_info[0]['class_name']);
				$mpdf->writetext(67,128,     $student_info[0]['class_roll']);
				$mpdf->writetext(67,138,   $student_info[0]['student_id']);
				$mpdf->writetext(67,149,   $total_amount);
				$mpdf->writetext(67,159.5,   $student_info[0]['student_id']);				
				$mpdf->SetFont("","",10);				
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

			if ($this->db->trans_status() === FALSE)										
				 $this->session->set_flashdata('error_message',1);

			else{
				 $this->session->set_flashdata('student_added',$this->lang->line('1 student has been Promoted successfully.'));
				$this->session->set_userdata('link',$name_of_file);				
			}	
			redirect('promotion/index','location');
			
		}
	}


	


}