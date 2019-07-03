<?php 
require_once("home.php");

class Admin_sms_email extends Home {


	function __construct()
	{
		parent::__construct();
		if($this->session->userdata('logged_in')!=1)
		redirect('home/login','location');

		if($this->session->userdata('user_type')!='Operator')
		redirect('home/login','location');
	}

	public function index()
	{
		$this->students();
	}

	public function students()
	{		
		if(!in_array(18,$this->role_modules))  
		redirect('home/access_forbidden','location');

		$data['class_info']=$this->get_classes();
		$data['session_info']=$this->get_sessions();
		$data['shift_info']=$this->get_shifts();
		$data['section_info']=$this->get_sections();
		$data['page_title'] = $this->lang->line('send notification');
		$data['body'] = 'admin/sms_email/students';
		$this->_viewcontroller($data);
	}


	public function students_data()
	{	
		if(!in_array(18,$this->role_modules))  
		redirect('home/access_forbidden','location');	

		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'view_student_info.student_id';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'ASC';
		$order_by_str=$sort." ".$order;
		
		$student_name=$this->input->post('student_name');
		// $student_id=$this->input->post('student_id');
		$class_id=$this->input->post('class_id');
		$financial_year_id=$this->input->post('financial_year_id');
		$dept_id=$this->input->post('department_id');
		$shift_id=$this->input->post('shift_id');
		$section_id=$this->input->post('section_id');
		$course_id = $this->input->post('course_id');

		$from_date = $this->input->post('from_date');
		$from_date = date('Y-m-d',strtotime($from_date));
		$to_date = $this->input->post('to_date');
		$to_date = date('Y-m-d',strtotime($to_date));

		$attendance_status = $this->input->post('attendance_status');
		$is_searched= $this->input->post('is_searched');
		
		if($is_searched)
		{		
			$this->session->set_userdata('send_sms_student_name',$student_name);
			// $this->session->set_userdata('send_sms_student_id',$student_id);
			$this->session->set_userdata('send_sms_class_id',$class_id);
			$this->session->set_userdata('send_sms_financial_year_id',$financial_year_id);
			$this->session->set_userdata('send_sms_dept_id',$dept_id);
			$this->session->set_userdata('send_sms_shift_id',$shift_id);
			$this->session->set_userdata('send_sms_section_id',$section_id);
			$this->session->set_userdata('send_sms_course_id',$course_id);
			$this->session->set_userdata('send_sms_from_date',$from_date);
			$this->session->set_userdata('send_sms_to_date',$to_date);
			$this->session->set_userdata('send_sms_attendance_status',$attendance_status);
		}
				
		$search_student_name=$this->session->userdata('send_sms_student_name');			
		// $search_student_id=$this->session->userdata('send_sms_student_id');			
		$search_class_id=$this->session->userdata('send_sms_class_id');			
		$search_financial_year_id=$this->session->userdata('send_sms_financial_year_id');			
		$search_dept_id=$this->session->userdata('send_sms_dept_id');			
		$search_shift_id=$this->session->userdata('send_sms_shift_id');			
		$search_section_id=$this->session->userdata('send_sms_section_id');			
		$search_course_id=$this->session->userdata('send_sms_course_id');			
		$search_from_date=$this->session->userdata('send_sms_from_date');			
		$search_to_date=$this->session->userdata('send_sms_to_date');			
		$search_attendance_status=(int)$this->session->userdata('send_sms_attendance_status');
		// $status = '';
		// if($search_attendance_status == 1)
		// 	$status = 0;
		// if($search_attendance_status == 2)
		// 	$status = 1;			
			
		$where_simple=array();
		
		if($search_student_name)
		$where_simple['view_student_info.name like ']='%'.$search_student_name.'%';
		// if($search_student_id)
		// $where_simple['view_student_info.student_id']=$search_student_id;
		if($search_class_id)
		$where_simple['view_student_info.class_id']=$search_class_id;
		if($search_financial_year_id)
		$where_simple['view_student_info.session_id']=$search_financial_year_id;
		if($search_dept_id)
		$where_simple['view_student_info.dept_id']=$search_dept_id;
		if($search_shift_id)
		$where_simple['view_student_info.shift_id']=$search_shift_id;
		if($search_section_id)
		$where_simple['view_student_info.section_id']=$search_section_id;

		if($search_course_id)
		$where_simple['student_attendence.course_id']=$search_course_id;
		// if($status != '')
		// $where_simple['student_attendence.status'] = $status;
		if($search_from_date){
			if($search_from_date != '1970-01-01')
			$where_simple['student_attendence.attendance_date >=']= $search_from_date;
		}
		if($search_to_date){
			if($search_to_date != '1970-01-01')
			$where_simple['student_attendence.attendance_date <=']=$search_to_date;
		}

		$where_simple['view_student_info.deleted']="0";
		$where_simple['view_student_info.status']="1";

		$where=array('where'=>$where_simple);			
		$offset = ($page-1)*$rows;
		$result = array();					
		
		$join = array('student_attendence' => 'view_student_info.id=student_attendence.student_info_id,left');
		$select = array('view_student_info.*');
					
		$info=$this->basic->get_data('view_student_info',$where,$select,$join,$limit=$rows,$start=$offset,$order_by=$order_by_str,$group_by='view_student_info.student_id',$num_rows=1);			
		
		$total_rows_array=$this->basic->count_row($table="view_student_info",$where,$count="view_student_info.id",$join,$group_by='view_student_info.student_id');
		
		$total_result=$total_rows_array[0]['total_rows'];	
		
		echo convert_to_grid_data($info,$total_result);

	}

	// send sms / email to guardian / student
	function student_send_sms_email()
	{	
		$student_or_gurdian= $this->input->post('student_or_gurdian'); 
		$subject= $this->input->post('subject');
		$content= $this->input->post('content');
		$type= $this->input->post('type');
		$info=$this->input->post('info');
		$info=json_decode($info,TRUE);
		$count=0;
				
		if($type=='SMS') //send sms if type is selected as "sms"
		{
			foreach($info as $student)
			{				
				if($student_or_gurdian=="student")
				$mobile=$student['mobile'];
				else $mobile=$student['gurdian_mobile'];

				$student_id=$student['id'];
				
				$message=$content;

				if($message=="" || $mobile=="") continue;

				if($this->_sms_sender($message,$mobile))
				{
					$count++;
					//insert into database
					$insert_data=array(
						"student_info_id"=>$student_id,
						"title"=>$subject,
						"message"=>$message,
						"type"	=>$type,
						"sent_at"=>date('Y-m-d H:i:s')	
					);			
					$this->basic->insert_data('sms_email_history',$insert_data);
				}
		  }
		  echo "<b>".$this->lang->line('sms report')." : ".$count." / ".count($info)."," .$this->lang->line('sms sent successfully')."</b>";
		}
		
		else if($type=='Email') //send Email if type is selected as "Email"
		{
			foreach($info as $student)
			{				
				if($student_or_gurdian=="student")
				$email=$student['email'];
				else $email=$student['gurdian_email'];

				$student_id=$student['id'];
				
				$message=$content;
				$from=$this->config->item('institute_email');
				$to=$email;
				$mask=$this->config->item('product_name');
				
				if($message=="" || $from=="" || $to=="" || $subject=="") continue;

				if($this->_mail_sender($from,$to,$subject,$message,$mask))
				{
					$count++;
					//insert into database
					$insert_data=array(
						"student_info_id"=>$student_id,
						"title"=>$subject,
						"message"=>$message,
						"type"	=>$type,
						"sent_at"=>date('Y-m-d H:i:s')	
					);			
					$this->basic->insert_data('sms_email_history',$insert_data);
				}
		  }
			
			echo "<b>".$this->lang->line('email report')." : ".$count." / ".count($info)."," .$this->lang->line('email sent successfully')."</b>";
		}

		else  // only notification
		{
			foreach($info as $student)
			{				
				$student_id=$student['id'];				
				$message=$content;
				$count++;
				//insert into database
				$insert_data=array(
					"student_info_id"=>$student_id,
					"title"=>$subject,
					"message"=>$message,
					"type"	=>$type,
					"sent_at"=>date('Y-m-d H:i:s')	
				);			
				$this->basic->insert_data('sms_email_history',$insert_data);				
		  }
		  
		  echo "<b>".$this->lang->line('notification report')." : ".$count." / ".count($info)."," .$this->lang->line('notificattion sent successfully')."</b>";
		}
	}	


	public function teachers()
	{		
		if(!in_array(18,$this->role_modules))  
		redirect('home/access_forbidden','location');	

		$data['rank_info']=$this->get_ranks();
		$data['page_title'] = $this->lang->line('send notification');
		$data['body'] = 'admin/sms_email/teachers';
		$this->_viewcontroller($data);
	}


	public function teachers_data()
	{	
		if(!in_array(18,$this->role_modules))  
		redirect('home/access_forbidden','location');	

		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'teacher_name';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'ASC';
		$order_by_str=$sort." ".$order;
		
		$teacher_name=$this->input->post('teacher_name');
		$rank_id=$this->input->post('rank_id');
		$is_searched= $this->input->post('is_searched');
		
		if($is_searched)
		{		
			$this->session->set_userdata('send_sms_teacher_name',$teacher_name);
			$this->session->set_userdata('send_sms_rank_id',$rank_id);
		}
				
		$search_teacher_name=$this->session->userdata('send_sms_teacher_name');			
		$search_rank_id=$this->session->userdata('send_sms_rank_id');			
			
		$where_simple=array();		
		
		if($search_teacher_name)
		$where_simple['teacher_name like ']='%'.$search_teacher_name.'%';
		
		if($search_rank_id)
		$where_simple['rank_id']=$search_rank_id;
		
		$where=array('where'=>$where_simple);	

		$select=array("teacher_info.*","rank.rank_name");
		$join=array('rank'=>"teacher_info.rank_id=rank.id,left");

		$offset = ($page-1)*$rows;
		$result = array();	
					
		$info=$this->basic->get_data('teacher_info',$where,$select,$join,$limit=$rows,$start=$offset,$order_by=$order_by_str,$group_by='',$num_rows=1);

		$total_rows_array=$this->basic->count_row($table="teacher_info",$where,$count="teacher_info.id",$join);
		$total_result=$total_rows_array[0]['total_rows'];
			
		echo convert_to_grid_data($info,$total_result);

	}

	// send sms / email to teacher
	function teacher_send_sms_email()
	{	
		$subject= $this->input->post('subject');
		$content= $this->input->post('content');
		$type= $this->input->post('type'); 
		$info=$this->input->post('info');
		$info=json_decode($info,TRUE);
		$count=0;
				
		if($type=='SMS') //send sms if type is selected as "sms"
		{
			foreach($info as $teacher)
			{				
				$mobile=$teacher['mobile'];
				$teacher_id=$teacher['id'];				
				$message=$content;

				if($message=="" || $mobile=="") continue;

				if($this->_sms_sender($message,$mobile))
				{					

					$count++;
					//insert into database
					$insert_data=array(
						"teacher_id"=>$teacher_id,
						"title"=>$subject,
						"message"=>$message,
						"type"	=>$type,
						"sent_at"=>date('Y-m-d H:i:s')	
					);		
					
				$this->basic->insert_data('sms_email_history',$insert_data);
				}

		  }


		   echo "<b>".$this->lang->line('sms report')." : ".$count." / ".count($info)."," .$this->lang->line('sms sent successfully')."</b>";
		}
		
		else if($type=='Email') //send Email if type is selected as "Email"
		{
			foreach($info as $teacher)
			{				
				$email=$teacher['email'];
				$teacher_id=$teacher['id'];				
				$message=$content;
				$from=$this->config->item('copyright_to_email');
				$to=$email;
				$mask=$this->config->item('copyright_to');
				
				if($message=="" || $from=="" || $to=="" || $subject=="") continue;

				if($this->_mail_sender($from,$to,$subject,$message,$mask))
				{
					$count++;
					//insert into database
					$insert_data=array(
						"teacher_id"=>$teacher_id,
						"title"=>$subject,
						"message"=>$message,
						"type"	=>$type,
						"sent_at"=>date('Y-m-d H:i:s')	
					);			
					$this->basic->insert_data('sms_email_history',$insert_data);
				}
		  }
			echo "<b>".$this->lang->line('email report')." : ".$count." / ".count($info)."," .$this->lang->line('email sent successfully')."</b>";
		}

		else  // only notification
		{
			foreach($info as $teacher)
			{				
				$teacher_id=$teacher['id'];				
				$message=$content;
				$count++;
				//insert into database
				$insert_data=array(
					"teacher_id"=>$teacher_id,
					"title"=>$subject,
					"message"=>$message,
					"type"	=>$type,
					"sent_at"=>date('Y-m-d H:i:s')	
				);			
				$this->basic->insert_data('sms_email_history',$insert_data);				
		  }
		 
		  echo "<b>".$this->lang->line('notification report')." : ".$count." / ".count($info)."," .$this->lang->line('notificattion sent successfully')."</b>";
		}
	}	


	public function sms_email_history()
	{		
		if(!in_array(18,$this->role_modules))  
		redirect('home/access_forbidden','location');

		$data['rank_info']=$this->get_ranks();
		$data['page_title'] = $this->lang->line('send/ email history');
		$data['body'] = 'admin/sms_email/sms_email_history';
		$this->_viewcontroller($data);
	}


	public function sms_email_history_data()
	{	
		if(!in_array(18,$this->role_modules))  
		redirect('home/access_forbidden','location');	

		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'sent_at';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'DESC';
		$order_by_str=$sort." ".$order;

		$type=$this->input->post('type');
		$is_searched= $this->input->post('is_searched');
		
		if($is_searched)
		{		
			$this->session->set_userdata('send_sms_message_type',$type);
		}
				
		$search_type=$this->session->userdata('send_sms_message_type');			
			
		$where_simple=array();		
		
		if($search_type)
		$where_simple['type']=$search_type;		
		$year=date("Y");	
		$where_simple['sent_at like ']='%'.$year.'%';	
		$where=array('where'=>$where_simple);
		
		$select=array("sms_email_history.title","sms_email_history.message","DATE_FORMAT(sms_email_history.sent_at, '%d/%m/%y %l:%m %p') as sent_at","sms_email_history.type","student_info.name as student_name","student_info.student_id","student_info.id as student_info_id","teacher_info.id as teacher_info_id","teacher_info.teacher_name","teacher_info.teacher_no as teacher_id");
		$join=array('student_info'=>"sms_email_history.student_info_id=student_info.id,left",'teacher_info'=>"sms_email_history.teacher_id=teacher_info.id,left");

		$offset = ($page-1)*$rows;
		$result = array();	
					
		$info=$this->basic->get_data('sms_email_history',$where,$select,$join,$limit=$rows,$start=$offset,$order_by=$order_by_str,$group_by='',$num_rows=1);

		$total_rows_array=$this->basic->count_row($table="sms_email_history",$where,$count="sms_email_history.id",$join);
		$total_result=$total_rows_array[0]['total_rows'];	

		echo convert_to_grid_data($info,$total_result);

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

        $str = '<select name="course_id" class="form-control small_select" id="course_id">
				<option value="">'.$this->lang->line('course').'</option>';
		foreach($courses as $course)
		{
			$str .= '<option value="'.$course["id"].'">'.$course["course_name"].'</option>';
		}
		$str .= '</select>';
		echo $str;
       
	}

	public function ajax_get_dept_based_on_class()
	{
		$class_id = $this->input->post('class_id');

		// get all dept/groups of the class
		$where['where'] = array('class_id' => $class_id);
		$select = array('id','dept_name');
		$depts = $this->basic->get_data('department',$where,$select);
		$str = '<select name="dept_id" class="form-control small_select" id="department_id" onchange="get_course()">
				<option value="">'.$this->lang->line('Group / Dept.').'</option>';
		foreach($depts as $dept)
		{
			$str .= '<option value="'.$dept["id"].'">'.$dept["dept_name"].'</option>';
		}
		$str .= '</select>';
		echo $str;
	}
}