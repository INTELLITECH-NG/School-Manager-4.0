<?php 
require_once("home.php");

class Admin_routine extends Home {


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
		if(!in_array(23,$this->role_modules))  
		redirect('home/access_forbidden','location');

		$data['class_info']=$this->get_classes();
		$data['session_info']=$this->get_sessions();
		$data['shift_info']=$this->get_shifts();
		$data['section_info']=$this->get_sections();
		$data['page_title'] = $this->lang->line('assign class');
		$data['body']='admin/routine/routine';
		
		$data["form_error"]="";		
		if($_POST){
			 $class_id=$this->input->post('class_id');
			 $dept_id=$this->input->post('dept_id');
			 $shift_id=$this->input->post('shift_id');
			 $section_id=$this->input->post('section_id');
			 $session_id=$this->input->post('financial_year_id'); // its session actually not financial year
			 
			 if($class_id=="" || $dept_id=="" || $shift_id=="" || $section_id=="")
			 $data["form_error"]="All fields are mandatory.";
			 
			 //setting search info to session variables so that search query dont lost
			 $this->session->set_userdata('admin_rt_class_id',$class_id);
			 $this->session->set_userdata('admin_rt_dept_id',$dept_id);
			 $this->session->set_userdata('admin_rt_shift_id',$shift_id);
			 $this->session->set_userdata('admin_rt_section_id',$section_id);
			 $this->session->set_userdata('admin_rt_search',1);
			 $this->session->set_userdata('admin_rt_session_id',$session_id);
			 	
		}	
		
		//retriving search session variables			
		$class_id= $this->session->userdata('admin_rt_class_id');
		$dept_id= $this->session->userdata('admin_rt_dept_id');
		$shift_id= $this->session->userdata('admin_rt_shift_id');
		$section_id= $this->session->userdata('admin_rt_section_id');
		$data['is_search']=$this->session->userdata('admin_rt_search');
		$session_id=$this->session->userdata('admin_rt_session_id');
		

		$data['period']= $this->get_periods();	
		$count=count($data['period']);
		$data['count']=$count;	

		if(!isset($session_id)) $session_id="";

		// finding active session
		$active_session_array=$this->get_session_info($session_id);
		foreach($active_session_array as $key=>$row) 
		{
			$active_session_name=$row;
			$active_session_id=$key;
			break;
		}
		
		if(!isset($active_session_name)) $active_session_name="";	
		if(!isset($active_session_id)) $active_session_id="";
		
		// finding active session
		$data['active_session']=$active_session_name;

		$period_id_only=array();
		foreach($data['period'] as $row)
		{
			$period_id_only[]=$row['period_id'];
		}
		$where['where'] = array('session_id'=>$active_session_id,"class_id"=>$class_id,"dept_id"=>$dept_id,"section_id"=>$section_id,"shift_id"=>$shift_id);
		$where['where_in'] = array('period_id'=>$period_id_only);
		$temp=$this->basic->get_data("view_class_routine",$where);
		
		
		$output=array();
		$output_id=array();
		
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
			$output[$day_id][$row['period_id']]=$row['course_name']."<br/>(".$row['teacher_name'].")<br/>X";
			/**For initializing the autoincrement id of the table**/
			$output_id[$day_id][$row['period_id']]=$row['id'];
		}

		if(count($output)>0)
		ksort($output);
		ksort($output_id);
		
		/**** Get Period Info ****/
		$period_info=$this->get_periods();
		foreach($period_info as $period){
			$period_infos[$period['period_id']]=$period['period_name'];
		}
		
		$data['course_info']=$this->get_course($dept_id,$class_id,$session_id);
		
		$data['teacher_info']=$this->get_teacher();
		
		$data['period_info']=$period_infos;
		$data["output"] = $output;
		$data["output_id"] = $output_id;
		$data['class_info']=$this->get_classes();
		$data['shift_info']=$this->get_shifts();
		$data['section_info']=$this->get_sections();	
		$this->_viewcontroller($data);
	}
	
	function add_routine()
	{
		if(!in_array(23,$this->role_modules))  
		redirect('home/access_forbidden','location');		
		if(!in_array(2,$this->role_module_accesses_23))
		redirect('home/access_forbidden','location');
	
		$period_id=$this->input->post('period_id',TRUE);
		$teacher_id=$this->input->post('teacher_id',TRUE);
		$day_id=$this->input->post('day_id',TRUE);
		$course_id=$this->input->post('course_id',TRUE);
		$start_time=$this->input->post('start_time',TRUE);
		$end_time=$this->input->post('end_time',TRUE);
		
		
		$class_id= $this->session->userdata('admin_rt_class_id');
		$dept_id= $this->session->userdata('admin_rt_dept_id');
		$shift_id= $this->session->userdata('admin_rt_shift_id');
		$section_id= $this->session->userdata('admin_rt_section_id');
		$session_id=$this->session->userdata('admin_rt_session_id');
		
		/*** insert information into database ***/
				$insert_data=array(
								'class_id'=>$class_id,
								'course_id'=>$course_id,
								'period_id'=>$period_id,
								'day'	=>$day_id,
								'start_time'=>$start_time,
								'end_time'=>$end_time,
								'teacher_id'=>$teacher_id,
								'section_id'=>$section_id,
								'dept_id'=>$dept_id,
								'shift_id'=>$shift_id,
								'session_id'=>$session_id
				);
			$this->basic->insert_data('class_routine',$insert_data);
	}
	
	
	function delete_routine()
	{
		if(!in_array(23,$this->role_modules))  
		redirect('home/access_forbidden','location');		
		if(!in_array(4,$this->role_module_accesses_23))
		redirect('home/access_forbidden','location');

		$id=$this->input->post('id');
		$where = array('id' => $id);
		$table="class_routine";
		$this->basic->delete_data($table,$where);
	}
}
