<?php 

require_once("home.php");

class Teacher extends Home {


	function __construct()
	{
		parent::__construct();
		$this->load->helper("url");
       // $this->load->model("Countries");
        $this->load->library("pagination");
        
		if($this->session->userdata('type_details')!='Teacher')
		redirect('home/login','location');
	}


	public function index()
	{		
		
		$id=$this->session->userdata('reference_id');
		$data['body']='teacher/teacher_profile';

		//For teacher Basic Information.

		$where['where']=array('teacher_info.id'=>$id); 
		$select=array("teacher_info.*","rank.rank_name","district.district_name");
		$join=array('rank'=>"teacher_info.rank_id=rank.id,left",'district'=>"teacher_info.home_district=district.id,left");  //For getting rank of the teacher from rank table.
		$teacher_info=$this->basic->get_data("teacher_info",$where,$select,$join);
		$data['teacher_info']=$teacher_info[0];

		//For teacher educational Information
		$where['where']=array('teacher_id'=>$id); 
		$teacher_education_info=$this->basic->get_data("teacher_education_info",$where);
		$data['teacher_education_info']=$teacher_education_info;

		//For teacher training Information.
		$where['where']=array('teacher_id'=>$id); 
		$teacher_training_info=$this->basic->get_data("teacher_training_info",$where);
		$data['teacher_training_info']=$teacher_training_info;


			
		$this->_teacher_viewcontroller($data);
	}

	public function teacher_profile()
	{
		$this->index();
	}


	public function edit_teacher()
	{


		$id=$this->session->userdata('reference_id');
		$data['body']='teacher/edit_teacher';

		$where['where']=array('teacher_info.id'=>$id); 
		$select=array("teacher_info.*","rank.rank_name","district.district_name");
		$join=array('rank'=>"teacher_info.rank_id=rank.id,left",'district'=>"teacher_info.home_district=district.id,left");  //For getting rank of the teacher from rank table.
		$teacher_info=$this->basic->get_data("teacher_info",$where,$select,$join);
		$data['teacher_info']=$teacher_info[0];

		//For teacher educational Information
		$where['where']=array('teacher_id'=>$id); 
		$teacher_education_info=$this->basic->get_data("teacher_education_info",$where);
		$data['teacher_education_info']=$teacher_education_info;

		//For teacher training Information.
		$where['where']=array('teacher_id'=>$id); 
		$teacher_training_info=$this->basic->get_data("teacher_training_info",$where);
		$data['teacher_training_info']=$teacher_training_info;

		$data['academic_rank'] = $this->get_ranks();

		$data['administrative_rank'] = $this->get_ranks('Teacher','Administrative');

		$data['district'] = $this->get_districts();

		$data['religion'] = $this->religion_generator(); 
		

		$this->_teacher_viewcontroller($data);
	}

	public function edit_teacher_action()
	{
		$id=$this->session->userdata('reference_id');		

		if($_SERVER['REQUEST_METHOD'] === 'GET') 
		redirect('home/access_forbidden','location');	
	
		$mobile_no=$this->input->post('mobile');
		$employee_no=$this->input->post('employee_no');
		$email = $this->input->post('email');

		$email_val = "teacher_info.email.".$id;
		$mobile_val = "teacher_info.mobile.".$id;
		$teacher_no_val = "teacher_info.teacher_no.".$id;

		
		
		$this->form_validation->set_rules('name', 			'<b>'.$this->lang->line('name').'</b>', 			 'trim|required');	
		$this->form_validation->set_rules('fathers_name', 	'<b>'.$this->lang->line('father\'s name').'</b>', 'trim|required');	
		$this->form_validation->set_rules('rank', 			'<b>'.$this->lang->line('rank').'</b>',  		 'trim|required');	
		$this->form_validation->set_rules('email', 			'<b>'.$this->lang->line('email').'</b>',  		 "trim|required|is_unique[$email_val]");
		$this->form_validation->set_rules('mobile', 		'<b>'.$this->lang->line('mobile').'</b>',  		 "trim|required|is_unique[$mobile_val]");
		$this->form_validation->set_rules('employee_no', 	'<b>'.$this->lang->line('teacher id').'</b>',  	 "trim|required|is_unique[$teacher_no_val]");


		if ($this->form_validation->run() == FALSE)
		{
			$this->edit_teacher(); 
		}

		else
		{			
			$exam=array();
			$institute=array();
			$year=array();
			$result=array();
			$t_exam=array();
			$t_institute=array();
			$t_year=array();
			$t_result=array();

			$exam=$this->input->post('exam');
			$institute=$this->input->post('institute');
			$year=$this->input->post('year');
			$result=$this->input->post('result');
			$t_exam=$this->input->post('t_exam');
			$t_institute=$this->input->post('t_institute');
			$t_year=$this->input->post('t_year');
			$t_result=$this->input->post('t_result');

			// echo "<pre>";
			// print_r($exam);
			// print_r($institute);
			// print_r($year);
			// print_r($result);
			// print_r($t_exam);
			// print_r($t_institute);
			// print_r($t_year);
			// print_r($t_result);
			// exit();

			
			$name=$this->input->post('name');
			$fathers_name=$this->input->post('fathers_name');
			$national_id_no=$this->input->post('national_id');
			$birth_date = $this->input->post('dob');
			$date_of_birth = date('Y-m-d', strtotime($birth_date));				
			$religion=$this->input->post('religion');
			$gender=$this->input->post('gender');
			$rank=$this->input->post('rank');
			$administrative_rank=$this->input->post('administrative_rank');
			$address=$this->input->post('address');
			$home_district=$this->input->post('home_district');
			
			// photo upload		
				
			$config['upload_path'] = './upload/teacher/';
			$config['allowed_types'] = 'jpg|png';
			$config['max_size']	= 200;
			$config['file_name']	= $mobile_no.'.jpg';
			$config['overwrite'] = TRUE;

			$this->load->library('upload', $config);

			$is_uploaded=1;
			if ($_FILES['photo']['size'] != 0 && !$this->upload->do_upload("photo")) 
			//if any photo selected and if photo upload error occurs then reload form and show upload error 
			{
				$is_uploaded=0;
				$error = array('error' => $this->upload->display_errors());
				$this->session->set_flashdata('photo_error',$error);
				$this->add_teacher(); 
			}	
					
			$image="";
			if($is_uploaded==1)  // forming image name
			$image=$mobile_no.'.jpg';
			
			$data=array
				(
					 'teacher_name'=>$name,				 
					 'date_of_birth'=>$date_of_birth, 
					 'religion'=>$religion, 
					 'gender'=>$gender, 
					 'rank_id'=>$rank, 
					 'administrative_rank'=>$administrative_rank,
					 'father_name'=>$fathers_name,
					 'mobile'=>$mobile_no,
					 'email'=>$email,
					 'home_district'=>$home_district,
					 'address'=>$address,					 
					 'teacher_no'=>$employee_no
				);	
			if($image!="") $data['image']=$image;
			if($national_id_no!="") $data['national_id']=$national_id_no;
			
			$this->db->trans_start();
			$where=array('teacher_info.id'=>$id);
			$this->basic->update_data('teacher_info',$where,$data);
			//$teacher_id=$this->db->insert_id();

			$where=array('teacher_education_info.teacher_id'=>$id);
			$this->basic->delete_data("teacher_education_info", $where);
			for($i=0;$i<count($exam);$i++)
			{
				if(array_key_exists($i,$exam) && $exam[$i]!="") // if exam name exist then data will be inserted
				{
					if(!array_key_exists($i,$institute) || $institute[$i]=="")  $institute[$i]="N/A";
					if(!array_key_exists($i,$year) 		|| $year[$i]=="") 		$year[$i]="N/A";
					if(!array_key_exists($i,$result) 	|| $result[$i]=="") 	$result[$i]="N/A";

					$edu_data=array
					(
						"teacher_id"=>$id,
						"level"=>$exam[$i],
						"institute"=>$institute[$i],
						"duration"=>$year[$i],
						"result"=>$result[$i]
					);
					
					$this->basic->insert_data('teacher_education_info',$edu_data);
				}
			}	
			$where=array('teacher_training_info.teacher_id'=>$id);
			$this->basic->delete_data("teacher_training_info", $where);

			for($i=0;$i<count($t_exam);$i++)
			{
				if(array_key_exists($i,$t_exam) && $t_exam[$i]!="") // if training name exist then data will be inserted
				{
					
					if(!array_key_exists($i,$t_institute)   || $t_institute[$i]=="")  $t_institute[$i]="N/A";
					if(!array_key_exists($i,$t_year) 		|| $t_year[$i]=="") 	  $t_year[$i]="N/A";
					if(!array_key_exists($i,$t_result) 	    || $t_result[$i]=="") 	  $t_result[$i]="N/A";

					$training_data=array
					(
						"teacher_id"=>$id,
						"training_name"=>$t_exam[$i],
						"institute_name"=>$t_institute[$i],
						"duration"=>$t_year[$i],
						"remarks"=>$t_result[$i]
					);
					
					$this->basic->insert_data('teacher_training_info',$training_data);
				}
			}	
			$this->db->trans_complete();
	    
			if ($this->db->trans_status() === FALSE)										
			$this->session->set_flashdata('error_message',1);	
			else	
			$this->session->set_flashdata('success_message',1);		
			redirect('teacher/teacher_profile','location');					
		}
	}



    public function routine()
	{
		if(isset($_POST['search']))   
		{
			 $session_id=$this->input->post('session_id');
			 $this->session->set_userdata('teacher_panel_rt_session_id',$session_id);
			 $this->session->set_userdata('teacher_panel_rt_search',1);			 
		}

		//retriving search session variables			
		$session_id= $this->session->userdata('teacher_panel_rt_session_id');

		if($session_id=="")
		{
			// finding latest session
			$latest_session_array=$this->get_latest_session();
			foreach ($latest_session_array as $key=>$row) 
			{
				$latest_session_id=$key;
				break;
			}
			$session_id=$latest_session_id;
			// finding latest session
		}
		$session_info_array=$this->get_session_info($session_id);
		foreach ($session_info_array as $key=>$row) 
		{
			$session_name=$row;
			break;
		}

		$data['session_name']=$session_name;

		$id=$this->session->userdata('reference_id');
		$data['session_info']=$this->get_sessions();
		$data['body']='teacher/classes';
		$data['period']= $this->get_periods();	
		$count=count($data['period']);
		$data['count']=$count;	

		/** initialize the output as empty array**/
		$output=array();		

		$period_id_only=array();
		foreach($data['period'] as $row)
		{
			$period_id_only[]=$row['period_id'];
		}
		$where['where'] = array('teacher_id'=>$id,'session_id'=>$session_id);
		$where['where_in'] = array('period_id'=>$period_id_only);
		$temp=$this->basic->get_data("view_class_routine",$where);

		foreach($temp as $row)
		{
			$day_string=$row['day'];
			if(stristr($day_string, 'Sat'))
			$day_id=1;
			else if(stristr($day_string, 'Sun'))
			$day_id=2;
			else if(stristr($day_string, 'Mon'))
			$day_id=3;
			else if(stristr($day_string, 'Tue'))
			$day_id=4;
			else if(stristr($day_string, 'Wed'))
			$day_id=5;
			else if(stristr($day_string, 'Thu'))
			$day_id=6;
			else if(stristr($day_string, 'Fri'))
			$day_id=7;

			$day_array=array();

			$output[$day_id][$row['period_id']]=$row['course_name']."<br/>".$row['class_name']."<br/>(".$row['teacher_name'].")";
		}

		if(count($output)>0)
				ksort($output);

		$data["output"] = $output;

		$this->_teacher_viewcontroller($data);
	}

	
	


	public function sms_history_paginition()
	{
		$id = $this->session->userdata('reference_id');	
		$data['body'] = 'teacher/sms_history_paginition';
		

		$table = 'sms_email_history';
		$where['where'] = array('teacher_id' => $id);
		$total_rows_array= $this->basic->count_row($table,$where,"id");
		$total_result=$total_rows_array[0]['total_rows'];


		$config = array();
        $config["base_url"] = site_url() . "teacher/sms_history_paginition";
        $config["total_rows"] = $total_result;
        $config["per_page"] = 5;
        $config["uri_segment"] = 3;
		$config['prev_link'] = '<<';
        $config['next_link'] = '>>';
		$config['num_links'] = 10;

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
       
        $data['info'] = $this->basic->get_data($table,$where,$select='',$join='',$limit=$config["per_page"],$start=$page,$order_by='',$group_by='',$num_rows=0,$csv='');
       
        $data["links"] = $this->pagination->create_links();

		$this->_teacher_viewcontroller($data);

	}


	public function details_notification($id=0)
	{
		if($id==0)
		redirect('home/access_forbidden','location');	

		// marked as viewed
		$this->basic->update_data($table="sms_email_history",$where=array("id"=>$id,"teacher_id" => $this->session->userdata('reference_id')),$update_data=array("viewed"=>"1"));

		$select=array("sms_email_history.id","sms_email_history.title","sms_email_history.message","DATE_FORMAT(sms_email_history.sent_at, '%d/%m/%y %l:%m %p') as sent_at","sms_email_history.type");
		$data['query_data']=$this->basic->get_data($table="sms_email_history",$where=array('where'=>array("sms_email_history.id"=>$id)),$select);
		$data['body']="teacher/details_notification";
		$data['page_title']="Details Notification";
		$this->_teacher_viewcontroller($data);
	}

	// creating a method to sent message.
	public function course_materials()
	{		
		$id = $this->session->userdata('reference_id');	 		
		$data['body'] = 'teacher/course_materials';		
		$table = 'course_material';		
		$select=array("financial_year.name as session","class.class_name","course.course_code","course.course_name","DATE_FORMAT(course_material.uploaded_at, '%d/%m/%y %l:%m %p') as uploaded_at","course_material.title","course_material.document_url");
		$join=array('financial_year'=>"financial_year.id=course_material.session_id,left",'course'=>"'course.id=course_material.course_id,left",'class'=>"'class.id=course_material.class_id,left");
		$where_simple = array("course_material.teacher_id" => $id);				
		$where = array('where'=> $where_simple);				
		$result = $this->basic->get_data($table, $where,$select, $join, $limit='', $start=NULL,$order_by='course_material.uploaded_at DESC');	
		$data['info'] = $result;				
		$this->_teacher_viewcontroller($data);	
	}	


	public function upload_material()
	{		
		$data['body']="teacher/upload_material";			
		$data['class_info']=$this->get_classes();
		$data['session_info']=$this->get_sessions();	
		$this->_teacher_viewcontroller($data);
	}

	public function upload_material_action()
	{
		$id = $this->session->userdata('reference_id');	

		if($_POST)
		{
			
			$uploaded_at=date("Y-m-d H:i:s");
			$session_id=$this->input->post('session_id');
			$class_id=$this->input->post('class_id');
			$dept_id=$this->input->post('dept_id');
			$course_id=$this->input->post('course_id');
			$title=$this->input->post('title');

			$file_name=$_FILES['document_url']['name'];
			$ext_array=explode('.',$file_name);
			$pos=count($ext_array)-1;
			$ext=$ext_array[$pos];

			$upload_file_name=time().$this->session->userdata('user_id').".".$ext;

			$config['upload_path'] = './upload/material/';
			$config['file_name']	= $upload_file_name;
			$config['allowed_types'] = "*";
			$this->load->library('upload', $config);

			if($this->upload->do_upload("document_url"))
			{
				$data = array(
				'teacher_id' 	  => $id,
				'course_id' 	  => $course_id,
				'class_id'    	  => $class_id,
				'dept_id'    	  => $dept_id,
				'title'    	  	  => $title,
				'document_url'    => $upload_file_name,
				'session_id'      => $session_id,
				'uploaded_at' 	  => $uploaded_at
				);				

				if($this->basic->insert_data('course_material',$data)) 											
				$this->session->set_flashdata('success_message',1);
				else $this->session->set_flashdata('error_message',1);
				redirect('teacher/course_materials','location');				  	
			}			
		}	
    }

	public function ajax_get_dept_based_on_class()
	{
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

	public function ajax_get_student_course()
	{
		$class_id = $this->input->post('class_id');
		$dept_id = $this->input->post('dept_id');
		$session_id = $this->input->post('session_id');
		$where['where'] = array(
			'class_id' => $class_id,
			'dept_id' => $dept_id,
			'session_id' => $session_id
			);
		$select = array('id','course_name','course_code','type');
		$courses = $this->basic->get_data('course',$where,$select);
		
	   	$str="<select name='course_id' id='course_id' class='form-control' required>";
	   	$str.="<option value=''>".$this->lang->line('course')."</option>";
	    foreach($courses as $course)
	    {
	    	$str.="<option  value='".$course['id']."'>".$course['course_name']." ".$course['course_code']."</option>";
	    }  
	   	$str.="</select>";
	    echo $str;
	}


	public function reset_password_form(){
		$data['title'] = $this->lang->line('password reset');
		$data['body'] = 'teacher/theme_teacher/password_reset_form';
		$this->_teacher_viewcontroller($data);

	}

	public function reset_password_action(){
		if($_SERVER['REQUEST_METHOD'] === 'GET') 
		redirect('defaults/access_forbidden','location');

		$this->form_validation->set_rules('old_password', '<b>'.$this->lang->line('old password').'</b>', 'trim|required|xss_clean');
		$this->form_validation->set_rules('new_password', '<b>'.$this->lang->line('new password').'</b>', 'trim|required|xss_clean');
		$this->form_validation->set_rules('confirm_new_password', '<b>'.$this->lang->line('confirm new password').'</b>', 'trim|required|xss_clean|matches[new_password]');
		if($this->form_validation->run() == FALSE){
			$this->reset_password_form();
		}
		else{
			$user_id = $this->session->userdata('user_id');
			$password = $this->input->post('old_password');
			$new_password = $this->input->post('new_password');
			$table = 'users';
			$where['where'] = array(
				'id' => $user_id,
				'password' => md5($password)
				);
			$select = array('username');
			if($this->basic->get_data($table,$where,$select)){
				$where = array(
					'id' => $user_id,
					'password' => md5($password)
					);
				$data = array('password' => md5($new_password));
				$this->basic->update_data($table,$where,$data);
				$this->session->set_userdata('logged_in',0);
				$this->session->set_flashdata('reset_success',$this->lang->line('please login with new password'));
				redirect('home/login','location');
				// echo $this->session->userdata('reset_success');exit();
			}
			else{
				$this->session->set_userdata('error',$this->lang->line('the old password you have given is wrong!'));
				$this->reset_password_form();
			}
		}

	}
	
	public function marks_entry()
	{
		echo $this->lang->line("mark entry here");
		exit();
	}		
}
