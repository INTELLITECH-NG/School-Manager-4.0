<?php 
require_once("home.php");

class Admin_staff extends Home {


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
		$this->staffs();

	}

	public function staffs()
	{	
		if(!in_array(24,$this->role_modules))  
		redirect('home/access_forbidden','location');

		$data['body']='admin/staff/staffs';
		$this->_viewcontroller($data);	
	}

	public function staffs_data()
	{

		if(!in_array(24,$this->role_modules))  
		redirect('home/access_forbidden','location');

		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 5;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'staff_name';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'ASC';
		$order_by_str=$sort." ".$order;
		
		$staff_name=$this->input->post('staff_name');
		$is_searched= $this->input->post('is_searched');
		
		if($is_searched)
		{		
			$this->session->set_userdata('staffs_staff_name',$staff_name);
		}

		$search_staff_name=$this->session->userdata('staffs_staff_name');			

		$where_simple=array();
		
		if($search_staff_name)
			$where_simple['staff_name like ']="%".$search_staff_name."%";

		$where=array('where'=>$where_simple);			
		$offset = ($page-1)*$rows;
		$result = array();		

		
		$table='staff_info';
		$select=array
		(
			'staff_info.*',
			'rank.rank_name as rank',
			'rank2.rank_name as job_class'
		);		
		$join=array('rank'=>"rank.id = staff_info.rank_id,left",'rank as rank2'=>"rank2.id = staff_info.job_class_id,left");			
		$info=$this->basic->get_data($table,$where,$select,$join,$limit=$rows,$start=$offset,$order_by=$order_by_str);
		$total_rows_array=$this->basic->count_row($table,$where,$count="staff_info.id",$join);
		$total_result=$total_rows_array[0]['total_rows'];

		echo convert_to_grid_data($info,$total_result);

	}

	public function add_staff()

	{	
		if(!in_array(24,$this->role_modules))  
		redirect('home/access_forbidden','location');

		$data['body']='admin/staff/add_staff';

		$data['academic_rank'] = $this->get_ranks($for="Employee",$type="Academic");		

		$data['religion'] = $this->religion_generator(); 

				
		$this->_viewcontroller($data);

	}

	public function add_staff_action()
	{
		if(!in_array(24,$this->role_modules))  
		redirect('home/access_forbidden','location');		
		if(!in_array(2,$this->role_module_accesses_24))
		redirect('home/access_forbidden','location');

		if($_SERVER['REQUEST_METHOD'] === 'GET') 
		redirect('home/access_forbidden','location');	

		$this->form_validation->set_rules('name', 			'<b>'.$this->lang->line('name').'</b>', 			 'trim|required');	
		$this->form_validation->set_rules('fathers_name', 	'<b>'.$this->lang->line("father\'s name").'</b>', 'trim|required');	
		$this->form_validation->set_rules('rank', 			'<b>'.$this->lang->line('designation').'</b>',  		 'trim|required');		
		$this->form_validation->set_rules('mobile', 		'<b>'.$this->lang->line('mobile').'</b>',  		 'trim|required|is_unique[staff_info.mobile]');
		$this->form_validation->set_rules('employee_no', 	'<b>'.$this->lang->line('staff id').'</b>',  	 'trim|required|is_unique[staff_info.staff_no]');


		if ($this->form_validation->run() == FALSE)
		{
			$this->add_staff(); 
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

			$name=$this->input->post('name');
			$fathers_name=$this->input->post('fathers_name');
			$national_id_no=$this->input->post('national_id');
			$birth_date = $this->input->post('dob');
			$date_of_birth = date('Y-m-d', strtotime($birth_date));				
			$religion=$this->input->post('religion');
			$gender=$this->input->post('gender');
			$rank=$this->input->post('rank');			
			$address=$this->input->post('address');
			$home_district=$this->input->post('home_district');
			$mobile_no=$this->input->post('mobile');
			$employee_no=$this->input->post('employee_no');
			$email = $this->input->post('email');

				
			// photo upload		
				
			$config['upload_path'] = './upload/teacher/';
			$config['allowed_types'] = 'jpg|png';
			$config['max_size']	= 200;
			$config['file_name']	= $mobile_no.'.jpg';
			$config['overwrite']	= TRUE;			

			$this->load->library('upload', $config);

			$is_uploaded=1;
			if ($_FILES['photo']['size'] != 0 && !$this->upload->do_upload("photo")) 
			//if any photo selected and if photo upload error occurs then reload form and show upload error 
			{
				$is_uploaded=0;
				$error = array('error' => $this->upload->display_errors());
				$this->session->set_flashdata('photo_error',$error);
				$this->add_staff(); 
			}	
					
			$image="";
			if($is_uploaded==1)  // forming image name
			$image=$mobile_no.'.jpg';
			
			$data=array
				(
					 'staff_name'=>$name,				 
					 'date_of_birth'=>$date_of_birth, 
					 'religion'=>$religion, 
					 'gender'=>$gender, 
					 'rank_id'=>$rank,					 
					 'father_name'=>$fathers_name,
					 'mobile'=>$mobile_no,
					 'email'=>$email,
					 'home_district'=>$home_district,
					 'address'=>$address,					 
					 'staff_no'=>$employee_no
				);	
			if($image!="") $data['image']=$image;
			if($national_id_no!="") $data['national_id']=$national_id_no;

			$this->db->trans_start();
			$this->basic->insert_data('staff_info',$data);
			$teacher_id=$this->db->insert_id();


			
			for($i=0;$i<count($exam);$i++)
			{
				if(array_key_exists($i,$exam) && $exam[$i]!="") // if exam name exist then data will be inserted
				{
					if(!array_key_exists($i,$institute) || $institute[$i]=="")  $institute[$i]="N/A";
					if(!array_key_exists($i,$year) 		|| $year[$i]=="") 		$year[$i]="N/A";
					if(!array_key_exists($i,$result) 	|| $result[$i]=="") 	$result[$i]="N/A";

					$edu_data=array
					(
						"staff_id"=>$teacher_id,
						"level"=>$exam[$i],
						"institute"=>$institute[$i],
						"duration"=>$year[$i],
						"result"=>$result[$i]
					);
					$this->basic->insert_data('staff_education_info',$edu_data);
				}
			}	
			for($i=0;$i<count($t_exam);$i++)
			{
				if(array_key_exists($i,$t_exam) && $t_exam[$i]!="") // if training name exist then data will be inserted
				{
					
					if(!array_key_exists($i,$t_institute)   || $t_institute[$i]=="")  $t_institute[$i]="N/A";
					if(!array_key_exists($i,$t_year) 		|| $t_year[$i]=="") 	  $t_year[$i]="N/A";
					if(!array_key_exists($i,$t_result) 	    || $t_result[$i]=="") 	  $t_result[$i]="N/A";

					$training_data=array
					(
						"staff_id"=>$teacher_id,
						"training_name"=>$t_exam[$i],
						"institute_name"=>$t_institute[$i],
						"duration"=>$t_year[$i],
						"remarks"=>$t_result[$i]
					);
					$this->basic->insert_data('staff_training_info',$training_data);
				}
			}	

			
			
			$this->db->trans_complete();
						
	    
			if ($this->db->trans_status() === FALSE)										
			$this->session->set_flashdata('error_message',1);	
			else	
			$this->session->set_flashdata('success_message',1);		
			redirect('admin_staff/staffs','location');	
										
				
		}

	}


	public function view_details($id = 0){		

		if(!in_array(24,$this->role_modules))  
		redirect('home/access_forbidden','location');		
		if(!in_array(1,$this->role_module_accesses_24))
		redirect('home/access_forbidden','location');

		$data['body']='admin/staff/view_details';

		//For teacher Basic Information.

		/*$where['where']=array('staff_info.id'=>$id); 
		$join=array('rank'=>"staff_info.rank_id=rank.id,left",'district'=>"staff_info.home_district=district.id,left");  //For getting rank of the teacher from rank table.
		$select=array("staff_info.*","rank.rank_name","district.district_name");
		$staff_info=$this->basic->get_data("staff_info",$where,$select,$join);
		$data['staff_info']=$staff_info[0];*/

		$where['where']=array('staff_info.id'=>$id); 
		$select=array("staff_info.*","rank.rank_name","district.district_name");
		$join=array('rank'=>"staff_info.rank_id=rank.id,left",'district'=>"staff_info.home_district=district.id,left");  //For getting rank of the teacher from rank table.
		$staff_info=$this->basic->get_data("staff_info",$where,$select,$join);
		$data['staff_info']=$staff_info[0];



		//For teacher educational Information

		$where['where']=array('staff_id'=>$id); 
		$staff_education_info=$this->basic->get_data("staff_education_info",$where);
		$data['staff_education_info']=$staff_education_info;



		//For teacher training Information.

		$where['where']=array('staff_id'=>$id); 
		$staff_training_info=$this->basic->get_data("staff_training_info",$where);
		$data['staff_training_info']=$staff_training_info;

		

		$this->_viewcontroller($data);
	}

	public function edit_profile($id=0)
	{
		if(!in_array(24,$this->role_modules))  
		redirect('home/access_forbidden','location');

		$data['body']='admin/staff/edit_profile';

		//For teacher Basic Information.

		$where['where']=array('staff_info.id'=>$id); 
		$select=array("staff_info.*","rank.rank_name","district.district_name");
		$join=array('rank'=>"staff_info.rank_id=rank.id,left",'district'=>"staff_info.home_district=district.id,left");  //For getting rank of the teacher from rank table.
		$staff_info=$this->basic->get_data("staff_info",$where,$select,$join);
		$data['staff_info']=$staff_info[0];



		//For teacher educational Information

		$where['where']=array('staff_id'=>$id); 
		$staff_education_info=$this->basic->get_data("staff_education_info",$where);
		$data['staff_education_info']=$staff_education_info;
		$data['id'] = $id;



		//For teacher training Information.

		$where['where']=array('staff_id'=>$id); 
		$staff_training_info=$this->basic->get_data("staff_training_info",$where);
		$data['staff_training_info']=$staff_training_info;

		$data['academic_rank'] = $this->get_ranks($for="Employee",$type="Academic");		

		$data['religion'] = $this->religion_generator(); 

		$this->_viewcontroller($data);
	}

	public function edit_profile_action()
	{

		if(!in_array(24,$this->role_modules))  
		redirect('home/access_forbidden','location');		
		if(!in_array(3,$this->role_module_accesses_24))
		redirect('home/access_forbidden','location');

		if($_SERVER['REQUEST_METHOD'] === 'GET') 
		redirect('home/access_forbidden','location');	

		$id=$this->input->post('staff_id');
		$mobile_no=$this->input->post('mobile');
		$employee_no=$this->input->post('employee_no');
		$email = $this->input->post('email');

		$email_val = "staff_info.email.".$id;
		$mobile_val = "staff_info.mobile.".$id;
		$teacher_no_val = "staff_info.staff_no.".$id;

		
		
		$this->form_validation->set_rules('name', 			'<b>'.$this->lang->line("name").'</b>', 			 'trim|required');	
		$this->form_validation->set_rules('fathers_name', 	'<b>'.$this->lang->line("father\'s name").'</b>', 'trim|required');	
		$this->form_validation->set_rules('rank', 			'<b>'.$this->lang->line("designation").'</b>',  		 'trim|required');		
		$this->form_validation->set_rules('mobile', 		'<b>'.$this->lang->line("mobile").'</b>',  		 "trim|required|is_unique[$mobile_val]");
		$this->form_validation->set_rules('employee_no', 	'<b>'.$this->lang->line("staff id").'</b>',  	 "trim|required|is_unique[$teacher_no_val]");


		if ($this->form_validation->run() == FALSE)
		{
			$this->edit_profile(); 
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

			if($this->input->post('exam'))$exam=$this->input->post('exam');
			if($this->input->post('institute'))$institute=$this->input->post('institute');
			if($this->input->post('year'))$year=$this->input->post('year');
			if($this->input->post('result'))$result=$this->input->post('result');
			if($this->input->post('t_exam'))$t_exam=$this->input->post('t_exam');
			if($this->input->post('t_institute'))$t_institute=$this->input->post('t_institute');
			if($this->input->post('t_year'))$t_year=$this->input->post('t_year');
			if($this->input->post('t_result'))$t_result=$this->input->post('t_result');

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
			$address=$this->input->post('address');
			$home_district=$this->input->post('home_district');
			
			
			

			// photo upload		
				
			$config['upload_path'] = './upload/teacher/';
			$config['allowed_types'] = 'jpg|png';
			$config['max_size']	= 200;
			$config['overwrite'] = TRUE;

			$config['file_name']	= $mobile_no.'.jpg';

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
					 'staff_name'=>$name,	
					 'national_id'=>$national_id_no,			 
					 'date_of_birth'=>$date_of_birth, 
					 'religion'=>$religion, 
					 'gender'=>$gender, 
					 'rank_id'=>$rank, 					 
					 'father_name'=>$fathers_name,
					 'mobile'=>$mobile_no,
					 'email'=>$email,
					 'home_district'=>$home_district,
					 'address'=>$address,					 
					 'staff_no'=>$employee_no					 
				);	

			if($image!="") $data['image']=$image;
			if($data['national_id']=="") $data['national_id']='NULL';

			$this->db->trans_start();
			$where=array('staff_info.id'=>$id);
			$this->basic->update_data('staff_info',$where,$data);
			//$teacher_id=$this->db->insert_id();

		$this->basic->delete_data("staff_education_info",$where=array("staff_id"=>$id));			

			for($i=0;$i<count($exam);$i++)
			{
				if(array_key_exists($i,$exam) && $exam[$i]!="") // if exam name exist then data will be inserted
				{
					if(!array_key_exists($i,$institute) || $institute[$i]=="")  $institute[$i]="N/A";
					if(!array_key_exists($i,$year) 		|| $year[$i]=="") 		$year[$i]="N/A";
					if(!array_key_exists($i,$result) 	|| $result[$i]=="") 	$result[$i]="N/A";

					$edu_data=array
					(
						"staff_id"=>$id,
						"level"=>$exam[$i],
						"institute"=>$institute[$i],
						"duration"=>$year[$i],
						"result"=>$result[$i]
					);

					$where=array('staff_education_info.staff_id'=>$id);
					$this->basic->insert_data('staff_education_info',$edu_data);
				}
			}



		$this->basic->delete_data("staff_training_info",$where=array("staff_id"=>$id));
			for($i=0;$i<count($t_exam);$i++)
			{
				if(array_key_exists($i,$t_exam) && $t_exam[$i]!="") // if training name exist then data will be inserted
				{
					
					if(!array_key_exists($i,$t_institute)   || $t_institute[$i]=="")  $t_institute[$i]="N/A";
					if(!array_key_exists($i,$t_year) 		|| $t_year[$i]=="") 	  $t_year[$i]="N/A";
					if(!array_key_exists($i,$t_result) 	    || $t_result[$i]=="") 	  $t_result[$i]="N/A";

					$training_data=array
					(
						"staff_id"=>$id,
						"training_name"=>$t_exam[$i],
						"institute_name"=>$t_institute[$i],
						"duration"=>$t_year[$i],
						"remarks"=>$t_result[$i]
					);
					$where=array('staff_training_info.staff_id'=>$id);
					$this->basic->insert_data('staff_training_info',$training_data);
				}
			}	
			$this->db->trans_complete();


			if ($this->db->trans_status() === FALSE)										
			$this->session->set_flashdata('error_message',1);	
			else	
			$this->session->set_flashdata('success_message',1);		
			redirect('admin_staff/staffs','location');					
		}
	}
}