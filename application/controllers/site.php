<?php 
require_once("home.php");

class Site extends Home {

	function __construct()
	{
		parent::__construct();		
		
	}


	public function index()
	{		
		$this->_public_viewcontroller();
	}

	public function students()
	{
		if(isset($_POST['search']))   
		{
			 $student_name=$this->input->post('student_name');
			 $class_id=$this->input->post('class_id');
			 $dept_id=$this->input->post('dept_id');
			 $session_id=$this->input->post('session_id');
			 
			 //setting search info to session variables so that search query don't lost
			 $this->session->set_userdata('public_st_student_name',$student_name);
			 $this->session->set_userdata('public_st_class_id',$class_id);
			 $this->session->set_userdata('public_st_dept_id',$dept_id);
			 $this->session->set_userdata('public_st_session_id',$session_id);
			 $this->session->set_userdata('public_st_search',1);			 
		}

		//retriving search session variables			
		$student_name= $this->session->userdata('public_st_student_name');
		$class_id= $this->session->userdata('public_st_class_id');
		$dept_id= $this->session->userdata('public_st_dept_id');
		$session_id= $this->session->userdata('public_st_session_id');

		$status="1";
		$deleted="0";		


		// finding latest session
		$latest_session_array=$this->get_latest_session();
		foreach ($latest_session_array as $key=>$row) 
		{
			$latest_session_name=$row;
			$latest_session_id=$key;
			break;
		}
		// finding latest session
		

		
		$total_rows = 0;
		$per_page=20;	
		$uri_segment=3;		
		$page = ($this->uri->segment($uri_segment)) ? $this->uri->segment($uri_segment) : 0;

		if($this->session->userdata('public_st_search')!=1)
		{
			// default search
			$where=$where=array("where"=>array("status"=>$status,"deleted"=>$deleted,"session_id"=>$latest_session_id));
			$student_info= $this->basic->get_data($table="view_student_info",$where,$select="",$join='',$limit=$per_page,$start=$page,$order_by='name ASC');
			$total_rows_array=$this->basic->count_row($table="view_student_info",$where);
			$total_rows=$total_rows_array[0]['total_rows'];			
		}
		else
		{
			$where=array("where"=>array("status"=>$status,"deleted"=>$deleted));

			if($student_name!="") 	$where['where']['name like ']="%".$student_name."%";
			if($class_id!="") 		$where['where']['class_id']=$class_id;
			if($dept_id!="") 		$where['where']['dept_id']=$dept_id;
			if($session_id!="") 	$where['where']['session_id']=$session_id;

			$student_info= $this->basic->get_data($table="view_student_info",$where,$select='',$join='',$limit=$per_page,$start=$page,$order_by='name ASC',$group_by='',$num_rows=0);
			$total_rows_array=$this->basic->count_row($table="view_student_info",$where);
			$total_rows=$total_rows_array[0]['total_rows'];
		}	
			
		$config['total_rows']	= 	$total_rows;			
		$config['base_url'] 	= 	site_url("site/students");	
		$config['per_page'] 	= 	$per_page; // row per page
		$config["uri_segment"] 	= 	$uri_segment;  //depth of pagination link,here 3 (Ex- site/students/2)
		$config['next_link'] 	= 	'>>';
		$config['prev_link'] 	= 	'<<';
		$config['num_links'] 	= 	5;		
		$this->pagination->initialize($config);
		$data['pages']=$this->pagination->create_links();			
			
		$data['class_info']=$this->get_classes();
		$data['session_info']=$this->get_sessions();
		$data['student_info']=$student_info;

		if($this->session->userdata('public_st_search')==1)
		$data['dept_info']=$this->get_dept_info($this->session->userdata('public_st_dept_id'));
		$data["body"] = "public/students";

		$this->_public_viewcontroller($data);
	}

	public function teachers()
	{
		if(isset($_POST['search']))   
		{
			 $teacher_name=$this->input->post('teacher_name');
			 $rank_id=$this->input->post('rank_id');
			 
			 //setting search info to session variables so that search query dont lost
			 $this->session->set_userdata('public_tr_teacher_name',$teacher_name);
			 $this->session->set_userdata('public_tr_rank_id',$rank_id);
			 $this->session->set_userdata('public_tr_search',1);			 
		}

		//retriving search session variables			
		$teacher_name= $this->session->userdata('public_tr_teacher_name');
		$rank_id= $this->session->userdata('public_tr_rank_id');
		
		$total_rows = 0;
		$per_page=20;	
		$uri_segment=3;		
		$page = ($this->uri->segment($uri_segment)) ? $this->uri->segment($uri_segment) : 0;

		if($this->session->userdata('public_tr_search')!=1)
		{
			// default search
			$select=array("teacher_info.*","rank.rank_name");
			$join=array('rank'=>"teacher_info.rank_id=rank.id,left");
			
			$teacher_info= $this->basic->get_data($table="teacher_info",$where="",$select,$join,$limit=$per_page,$start=$page,$order_by='teacher_name ASC');
			$total_rows_array=$this->basic->count_row($table="teacher_info",$where="",$count='teacher_info.id',$join);
			$total_rows=$total_rows_array[0]['total_rows'];			
		}
		else
		{
			$select=array("teacher_info.*","rank.rank_name");
			$join=array('rank'=>"teacher_info.rank_id=rank.id,left");
			$where=array();
			if($teacher_name!="") 	$where['where']['teacher_name like ']="%".$teacher_name."%";
			if($rank_id!="") 		$where['where']['rank_id']=$rank_id;

			$teacher_info= $this->basic->get_data($table="teacher_info",$where,$select,$join,$limit=$per_page,$start=$page,$order_by='teacher_name ASC');
			$total_rows_array=$this->basic->count_row($table="teacher_info",$where,$count='teacher_info.id',$join);
			$total_rows=$total_rows_array[0]['total_rows'];
		}	
					
			
		$config['total_rows']	= 	$total_rows;			
		$config['base_url'] 	= 	site_url("site/teachers");	
		$config['per_page'] 	= 	$per_page; // row per page
		$config["uri_segment"] 	= 	$uri_segment;  //depth of pagination link,here 3 (Ex- site/students/2)
		$config['next_link'] 	= 	'>>';
		$config['prev_link'] 	= 	'<<';
		$config['num_links'] 	= 	5;		
		$this->pagination->initialize($config);
		$data['pages']=$this->pagination->create_links();			
			
		$data['rank_info']=$this->get_ranks($for="Teacher",$type="Academic");	
		$data['teacher_info']=$teacher_info;
		$data["body"] = "public/teachers";

		$this->_public_viewcontroller($data);
	}

	public function teacher_profile($id=0)
	{		
		if($id==0)
		{
			echo "<div class='alert alert-danger text-center'><h3>".$this->lang->line('No data found.')."</h3></div>";
			exit();
		}

		// teacher Basic Information.
		$where['where']=array('teacher_info.id'=>$id); 
		$select=array("teacher_info.*","rank.rank_name","district.district_name");
		$join=array('rank'=>"teacher_info.rank_id=rank.id,left",'district'=>"teacher_info.home_district=district.id,left");  //For getting rank of the teacher from rank table.
		$teacher_info=$this->basic->get_data("teacher_info",$where,$select,$join);
		$data['teacher_info']=$teacher_info[0];
		
		// teacher educational Information
		$where['where']=array('teacher_id'=>$id); 
		$teacher_education_info=$this->basic->get_data("teacher_education_info",$where);
		$data['teacher_education_info']=$teacher_education_info;

		// teacher training Information.
		$where['where']=array('teacher_id'=>$id); 
		$teacher_training_info=$this->basic->get_data("teacher_training_info",$where);
		$data['teacher_training_info']=$teacher_training_info;
		
		$data['body']='public/teacher_profile';
		$this->_public_viewcontroller($data);
	}

	public function routines()
	{
		$data["form_error"]="";		
		if(isset($_POST['search']))   
		{
			 $class_id=$this->input->post('class_id');
			 $dept_id=$this->input->post('dept_id');
			 $shift_id=$this->input->post('shift_id');
			 $section_id=$this->input->post('section_id');
			 $session_id=$this->input->post('session_id');

			 if($class_id=="" || $dept_id=="" || $shift_id=="" || $section_id=="")
			 $data["form_error"]="All fields are mandatory.";
			 
			 //setting search info to session variables so that search query dont lost
			 $this->session->set_userdata('public_rt_class_id',$class_id);
			 $this->session->set_userdata('public_rt_dept_id',$dept_id);
			 $this->session->set_userdata('public_rt_shift_id',$shift_id);
			 $this->session->set_userdata('public_rt_section_id',$section_id);
			 $this->session->set_userdata('public_rt_session_id',$session_id);
			 $this->session->set_userdata('public_rt_search',1);			 
		}

		//retriving search session variables			
		$class_id= $this->session->userdata('public_rt_class_id');
		$dept_id= $this->session->userdata('public_rt_dept_id');
		$shift_id= $this->session->userdata('public_rt_shift_id');
		$section_id= $this->session->userdata('public_rt_section_id');
		$session_id= $this->session->userdata('public_rt_session_id');

		$data['period']= $this->get_periods();	
		$count=count($data['period']);
		$data['count']=$count;	

		$period_id_only=array();
		foreach($data['period'] as $row)
		{
			$period_id_only[]=$row['period_id'];
		}
		$where['where'] = array('session_id'=>$session_id,"class_id"=>$class_id,"dept_id"=>$dept_id,"section_id"=>$section_id,"shift_id"=>$shift_id);
		$where['where_in'] = array('period_id'=>$period_id_only);
		$temp=$this->basic->get_data("view_class_routine",$where);
		$output=array();
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

			$output[$day_id][$row['period_id']]=$row['course_name']."<br/>(".$row['teacher_name'].")";
		}

		if(count($output)>0)
		ksort($output);

		$data["output"] = $output;
		$data['class_info']=$this->get_classes();
		$data['shift_info']=$this->get_shifts();		
		$data['session_info']=$this->get_sessions();
		$data['section_info']=$this->get_sections();

		if($this->session->userdata('public_rt_search')==1)
		$data['dept_info']=$this->get_dept_info($this->session->userdata('public_rt_dept_id'));

		$data['body']='public/routines';
		$this->_public_viewcontroller($data);
	}

	public function staffs()
	{
		if(isset($_POST['search']))   
		{
			 $staff_name=$this->input->post('staff_name');
			 $rank_id=$this->input->post('rank_id');
			 
			 //setting search info to session variables so that search query dont lost
			 $this->session->set_userdata('public_staff_staff_name',$staff_name);
			 $this->session->set_userdata('public_staff_rank_id',$rank_id);
			 $this->session->set_userdata('public_staff_search',1);			 
		}

		//retriving search session variables			
		$staff_name= $this->session->userdata('public_staff_staff_name');
		$rank_id= $this->session->userdata('public_staff_rank_id');
		
		$total_rows = 0;
		$per_page=20;	
		$uri_segment=3;		
		$page = ($this->uri->segment($uri_segment)) ? $this->uri->segment($uri_segment) : 0;

		if($this->session->userdata('public_tr_search')!=1)
		{
			// default search
			$select=array("staff_info.*","rank.rank_name",'rank2.rank_name as job_class');
			$join=array('rank'=>"staff_info.rank_id=rank.id,left",'rank as rank2'=>"rank2.id = staff_info.job_class_id,left");
			
			$staff_info= $this->basic->get_data($table="staff_info",$where="",$select,$join,$limit=$per_page,$start=$page,$order_by='staff_name ASC');
			$total_rows_array=$this->basic->count_row($table="staff_info",$where="",$count='staff_info.id',$join);
			$total_rows=$total_rows_array[0]['total_rows'];			
		}
		else
		{
			$select=array("staff_info.*","rank.rank_name",'rank2.rank_name as job_class');
			$join=array('rank'=>"staff_info.rank_id=rank.id,left",'rank as rank2'=>"rank2.id = staff_info.job_class_id,left");
			$where=array();
			if($staff_name!="") 	$where['where']['staff_name like ']="%".$staff_name."%";
			if($rank_id!="") 		$where['where']['rank_id']=$rank_id;

			$staff_info= $this->basic->get_data($table="staff_info",$where,$select,$join,$limit=$per_page,$start=$page,$order_by='staff_name ASC');
			$total_rows_array=$this->basic->count_row($table="staff_info",$where,$count='staff_info.id',$join);
			$total_rows=$total_rows_array[0]['total_rows'];
		}	
					
			
		$config['total_rows']	= 	$total_rows;			
		$config['base_url'] 	= 	site_url("site/staffs");	
		$config['per_page'] 	= 	$per_page; // row per page
		$config["uri_segment"] 	= 	$uri_segment;  //depth of pagination link,here 3 (Ex- site/students/2)
		$config['next_link'] 	= 	'>>';
		$config['prev_link'] 	= 	'<<';
		$config['num_links'] 	= 	5;		
		$this->pagination->initialize($config);
		$data['pages']=$this->pagination->create_links();			
			
		$data['rank_info']=$this->get_ranks($for="Employee",$type="Academic");	
		$data['staff_info']=$staff_info;
		$data["body"] = "public/staffs";

		$this->_public_viewcontroller($data);
	}


	public function staff_profile($id=0)
	{		
		if($id==0)
		{
			echo "<div class='alert alert-danger text-center'><h3>".$this->lang->line("no data found.")."</h3></div>";
			exit();
		}

		// teacher Basic Information.
		$where['where']=array('staff_info.id'=>$id); 
		$select=array("staff_info.*","rank.rank_name","district.district_name");
		$join=array('rank'=>"staff_info.rank_id=rank.id,left",'district'=>"staff_info.home_district=district.id,left");  //For getting rank of the teacher from rank table.
		$staff_info=$this->basic->get_data("staff_info",$where,$select,$join);
		$data['staff_info']=$staff_info[0];
		
		// teacher educational Information
		$where['where']=array('staff_id'=>$id); 
		$staff_education_info=$this->basic->get_data("staff_education_info",$where);
		$data['staff_education_info']=$staff_education_info;

		// teacher training Information.
		$where['where']=array('staff_id'=>$id); 
		$staff_training_info=$this->basic->get_data("staff_training_info",$where);
		$data['staff_training_info']=$staff_training_info;
		
		$data['body']='public/staff_profile';
		$this->_public_viewcontroller($data);
	}


	public function books()
	{
		if(isset($_POST['search']))   
		{
			 $title=$this->input->post('title');
			 $author=$this->input->post('author');
			 $category_name=$this->input->post('category_name');
			 
			 //setting search info to session variables so that search query dont lost
			 $this->session->set_userdata('public_lb_title',$title);
			 $this->session->set_userdata('public_lb_author',$author);
			 $this->session->set_userdata('public_lb_category_name',$category_name);
			 $this->session->set_userdata('public_lb_search',1);			 
		}

		//retriving search session variables			
		$title= $this->session->userdata('public_lb_title');
		$author= $this->session->userdata('public_lb_author');
		$category_name= $this->session->userdata('public_lb_category_name');
		
		$total_rows = 0;
		$per_page=20;	
		$uri_segment=3;		
		$page = ($this->uri->segment($uri_segment)) ? $this->uri->segment($uri_segment) : 0;

		$join = array("library_category"=>"library_book_info.category_id=library_category.id,left");

		if($this->session->userdata('public_lb_search')!=1)
		{	
			
			// default search		
			$book_info= $this->basic->get_data($table="library_book_info",$where="",$select="",$join,$limit=$per_page,$start=$page,$order_by='title ASC');
			$total_rows_array=$this->basic->count_row($table="library_book_info",$where="",$count='library_book_info.id',$join="");
			$total_rows=$total_rows_array[0]['total_rows'];			
		}
		else
		{
			$where=array();
			if($title!="") 		   $where['where']['title like ']="%".$title."%";
			if($author!="") 	   $where['where']['author like']="%".$author."%";
			if($category_name!="") $where['where']['category_name like']="%".$category_name."%";

			$book_info= $this->basic->get_data($table="library_book_info",$where,$select="",$join,$limit=$per_page,$start=$page,$order_by='title ASC');
			$total_rows_array=$this->basic->count_row($table="library_book_info",$where,$count='library_book_info.id',$join="");
			$total_rows=$total_rows_array[0]['total_rows'];
		}	
		

		$config['total_rows']	= 	$total_rows;			
		$config['base_url'] 	= 	site_url("site/books");	
		$config['per_page'] 	= 	$per_page; // row per page
		$config["uri_segment"] 	= 	$uri_segment;  //depth of pagination link,here 3 (Ex- site/students/2)
		$config['next_link'] 	= 	'>>';
		$config['prev_link'] 	= 	'<<';
		$config['num_links'] 	= 	5;		
		$this->pagination->initialize($config);
		$data['pages']=$this->pagination->create_links();				
			
		$data['book_info']=$book_info;
		$data["body"] = "public/books";

		$this->_public_viewcontroller($data);
	}


	public function result_sheet(){
		// ################################################# ///
		$data['classes'] = $this->get_classes();
		$data['sessions'] = $this->get_sessions();
		$data['page_title'] = $this->lang->line('student result');
		$data['body'] = 'public/results';
		$this->_public_viewcontroller($data);
	}

	public function get_individual_result(){

		$class_id = $this->input->post('class_id');
		$exam_id = $this->input->post('exam_name');
		$session_id = $this->input->post('session_id');
		$student_id = $this->input->post('student_id');

		$where_exam_type['where'] = array('id'=>$exam_id);
		$select_exam_type = array('result_type');
		$exam_type = $this->basic->get_data('result_exam_name',$where_exam_type,$select_exam_type);
		
		if(!empty($exam_type)) $data['gpa_cgpa'] = $exam_type[0]['result_type'];		

		$where['where'] = array(
			'class_id' => $class_id,
			'exam_id' => $exam_id,
			'session_id' => $session_id,
			'student_id' => $student_id
			);
		$data['student_result'] = $this->basic->get_data('view_result_marks',$where,$select='');


		$where1['where'] = array(
			'student_id' => $student_id,
			'exam_id' => $exam_id
			);
		$data['student_total_result'] = $this->basic->get_data('result',$where1,$select1='');
		$data['classes'] = $this->get_classes();
		$data['sessions'] = $this->get_sessions();
		$data['page_title'] = 'Student Result';
		$data['body'] = 'public/results';
		$this->_public_viewcontroller($data);
	}


	public function get_exam_name_for_result(){


		$class_id = $this->input->post('class_id');
		$session_id = $this->input->post('session_id');

		$where['where'] = array(
			'class_id' => $class_id,
			'session_id' => $session_id,
			'is_complete' => 1
			);
		$exam_info = $this->basic->get_data('result_exam_name',$where,$select='');

		if(empty($exam_info))
			echo '';
		else{
			$str = '<label for="exam_name" class="col-xs-3 control-label" >'.$this->lang->line('Exam Name').'</label>';
	        $str .= '<div class="col-xs-9"><select name="exam_name" id="exam_name" class="form-control">';
	        $str .= '<option value="">'.$this->lang->line('exam name').'</option>';
	        foreach($exam_info as $exam){
	        	$str .= '<option value="'.$exam['id'].'">'.$exam['exam_name'].'</option>';
	        }
	        $str .= '</select></div>';
	        echo $str;
		}			
	}

	// function to show statistics
	public function show_stat_course()
	{
		if(isset($_POST['search']))   
		{
			 $session_id=$this->input->post('session_id');
			 $this->session->set_userdata('public_cr_session_id',$session_id);
			 $this->session->set_userdata('public_cr_search',1);			 
		}

		//retriving search session variables			
		$session_id= $this->session->userdata('public_cr_session_id');

		if($session_id=="")
		{
			// finding latest session
			$latest_session_array=$this->get_latest_session();
			foreach ($latest_session_array as $key=>$row) 
			{
				$latest_session_name=$row;
				$latest_session_id=$key;
				break;
			}
			$session_id=$latest_session_id;
			// finding latest session
		}

		
		$data['body'] = "public/show_stat_course";
		$where['where'] = array("course.session_id" => $session_id);		
		

		$result1 = $this->basic->get_data("class");	

		$data['result1'] = $result1;	

		$i = 0;
		foreach ($result1 as $value)
		{
			$select =  array('department.dept_name','course.course_code','course.course_name','course.marks');
			$join = array("department"=>"department.id=course.dept_id,left");
			$where['where'] = array("course.class_id"=>$value['id'], "course.session_id" => $session_id);

			$temp = $this->basic->get_data("course",$where,$select,$join);
			//$temp[0]['class_name'] = $value['class_name'];
			$info[$i] = $temp;
			$i++;	
		}
		$data['info'] = $info;	
		$data['session_info']=$this->get_sessions();

		$this->_public_viewcontroller($data);
	}


	public function dept_seat()
	{
		if(isset($_POST['search']))   
		{
			 $session_id=$this->input->post('session_id');
			 $this->session->set_userdata('public_seat_session_id',$session_id);
			 $this->session->set_userdata('public_seat_search',1);			 
		}

		//retriving search session variables			
		$session_id= $this->session->userdata('public_seat_session_id');

		if($session_id=="")
		{
			// finding latest session
			$latest_session_array=$this->get_latest_session();
			foreach ($latest_session_array as $key=>$row) 
			{
				$latest_session_name=$row;
				$latest_session_id=$key;
				break;
			}
			$session_id=$latest_session_id;
			// finding latest session
		}


	    $join= array('class'=>"department.class_id=class.id,left");
		$info = $this->basic->get_data('department',$where='',$select='',$join);

		$table = 'view_student_info';
		
		$i=0;
		foreach ($info as $key => $value) 
		{

			$class_id = $value['class_id'];
			$dept_name= $value['dept_name'];
			$where['where'] = array('class_id'=>$class_id , 'dept_name'=>$dept_name,'deleted'=>'0','status'=>'1','session_id'=>$session_id);
			$result =  $this->basic->count_row($table,$where,$count='id',$join='',$group_by='');			
			$info[$i]['num_student'] = $result[0]['total_rows'];
			$i++;
		}
		$data['info'] = $info;		
		$data['session_info']=$this->get_sessions();
		$data['page_title'] = $this->lang->line('no. of seats');
		$data['body'] = 'public/student_stats';
		$this->_public_viewcontroller($data);		

	}

	public function daily_attendance_counter()
	{
		if(isset($_POST['search']))   
		{
			 $session_id=$this->input->post('session_id');
			 $attendance_date=$this->input->post('attendance_date');
			 $this->session->set_userdata('public_att_session_id',$session_id);
			 $this->session->set_userdata('public_att_attendance_date',$attendance_date);
			 $this->session->set_userdata('public_att_search',1);			 
		}

		//retriving search session variables			
		$session_id= $this->session->userdata('public_att_session_id');
		$attendance_date= $this->session->userdata('public_att_attendance_date');

		if($session_id=="")
		{
			// finding latest session
			$latest_session_array=$this->get_latest_session();
			foreach ($latest_session_array as $key=>$row) 
			{
				$latest_session_name=$row;
				$latest_session_id=$key;
				break;
			}
			$session_id=$latest_session_id;
			// finding latest session
		}

		if($attendance_date=="")
		$attendance_date=date("Y-m-d");
		
		
		$where['where'] = array(
			'student_attendence.attendance_date'=>$attendance_date,
			'student_attendence.status' => '1',
			'session_id' => $session_id
			);
		$select = array('class_id','shift_id','section_id','count(status) as present_number');
		$join = array('class'=>'student_attendence.class_id=class.id,left');
		$order_by = 'class.ordering asc';
		$group_by = 'class_id,shift_id,section_id';
		$present_student = $this->basic->get_data('student_attendence',$where,$select,$join,$limit='',$start=NULL,$order_by,$group_by);
		
		$where1['where'] = array(
			'session_id' => $session_id,
			'status' => '1',
			'deleted' => '0'
			);
		$select1 = array('class_id','shift_id','section_id','count(student_id) as total_student');
		$group_by = 'class_id,shift_id,section_id';
		$total_student = $this->basic->get_data('student_info',$where1,$select1,$join='',$limit='',$start=NULL,$order_by='',$group_by);

		foreach ($total_student as $student){
			$total_student_counter[$student['class_id']][$student['shift_id']][$student['section_id']]['total_student'] = $student['total_student'];
		}

		if(!empty($present_student)){

			$i = 0;
			foreach($present_student as $p_student){
				if(isset($total_student_counter[$p_student['class_id']][$p_student['shift_id']][$p_student['section_id']]['total_student']))
				{
					$total = $total_student_counter[$p_student['class_id']][$p_student['shift_id']][$p_student['section_id']]['total_student'];
					$present = $p_student['present_number'];
					$absent = $total-$present;
					$attendance_counter[$p_student['class_id']][$p_student['shift_id']][$p_student['section_id']]['present_student'] = $p_student['present_number'];
					$attendance_counter[$p_student['class_id']][$p_student['shift_id']][$p_student['section_id']]['absent_student'] = $absent;
					$i++;
				}
			}

			$data['attendance_counter'] = $attendance_counter;
		}
		else $data['attendance_counter'] = '';

		$data['session_info'] = $this->get_sessions();
		$data['page_title'] = $this->lang->line('student daily attendance');
		$data['body'] = 'public/student_attendance';
		$this->_public_viewcontroller($data);	

	}



}
