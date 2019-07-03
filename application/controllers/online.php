<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once("home.php");

class Online extends Home {


	function __construct()
	{
		parent::__construct();		

	}


	function index()
	{		
		$this->application(); 		
	}


	function applicant_login() // login panel for applicants
	{

		
		if($this->session->userdata('app_logged_in')==1)
		redirect('applicant/index','location');

		$this->form_validation->set_rules('username', '<b>'.$this->lang->line('Username').'</b>', 'trim|required|xss_clean');
		$this->form_validation->set_rules('password', '<b>'.$this->lang->line('Password').'</b>', 'trim|required|xss_clean');
				
		if ($this->form_validation->run() == FALSE)
		$this->load->view('online_admission/page/login'); //if validation test becomes false,reloads it
		
		else
		{	
			$username=$_POST['username'];
			$password=md5($_POST['password']);

			$table='view_applicant_info';
			$where_simple=array('username'=>$username,'password'=>$password,'status'=>"1","deleted"=>"0");
			$where=array('where'=>$where_simple);		
			$select = array('users.*');
			$info=$this->basic->get_data($table,$where,$select='',$join='',$limit='',$start='',$order_by='',$group_by='',$num_rows=1);		
			$count=$info['extra_index']['num_rows'];
			// echo $this->db->last_query();
			if($count==0)
			{
				$this->session->set_flashdata('app_login_msg',$this->lang->line('invalid username or password'));
				redirect(uri_string());
			}
			else
			{
				unset($info['extra_index']);			
				
				foreach($info as $row)
				{
					$applicant_id=$row['id'];
					$admission_roll=$row['admission_roll'];
					$username=$row['username'];
					$name=$row['name'];
					$image=$row['image'];
					$class_id=$row['class_id'];
					$dept_id=$row['dept_id'];
					$session_id=$row['session_id'];
				}

				$this->session->set_userdata('app_logged_in',1);
				$this->session->set_userdata('app_id',$applicant_id);
				$this->session->set_userdata('app_admission_roll',$admission_roll);
				$this->session->set_userdata('app_username',$username);
				$this->session->set_userdata('app_real_name',$name);
				$this->session->set_userdata('app_pro_pic',$image);
				$this->session->set_userdata('app_class_id',$class_id);
				$this->session->set_userdata('app_dept_id',$dept_id);
				$this->session->set_userdata('app_session_id',$session_id);
				
				if($this->session->userdata('app_logged_in')==1)
				redirect('applicant/index','location');									
			}			
		}			
	}


	function applicant_logout() 
	{		
		$this->session->sess_destroy();
		redirect('online/applicant_login','location');		
	}


	public function application()
	{
		$data['body']='online_admission/page/application';
		$data['page_title']= $this->lang->line("online admission");
		$data['quota_info']=$this->get_quotas();
		$data['class_info']=$this->get_classes_online();
		$data['shift_info']=$this->get_shifts();		
		$data['default_shift'] = $this->get_default_shift();
		$data['religion_info']=$this->religion_generator();
		$data['exam_version_info']=$this->get_exam_versions();
		$data['session_info']=$this->get_sessions_online();
		// $data['district_info']=$this->get_districts();
		$this->_front_viewcontroller($data);
	}

	public function application_action() 
	{		
		if($_SERVER['REQUEST_METHOD'] === 'GET') 
		redirect('home/access_forbidden','location');


		if($_POST)
		{
			$this->form_validation->set_rules('student_name','<b>'.$this->lang->line("applicant\'s name").'</b>', 'trim|required');	
			// $this->form_validation->set_rules('student_name_ben','<b>'.$this->lang->line("applicant\'s name (bengali)").'</b>', 'trim|required');	
			$this->form_validation->set_rules('father_name','<b>'.$this->lang->line("father\'s name").'</b>', 'trim|required');	
			// $this->form_validation->set_rules('father_name_ben','<b>'.$this->lang->line("father\'s name").'</b>', 'trim');	
			$this->form_validation->set_rules('mother_name','<b>'.$this->lang->line("mother\'s name").'</b>', 'trim|required');	
			// $this->form_validation->set_rules('mother_name_ben','<b>'.$this->lang->line("mother\'s name").'</b>', 'trim|required');	
			$this->form_validation->set_rules('date_of_birth','<b>'.$this->lang->line("date of birth").'</b>', 'trim|required');	
			// $this->form_validation->set_rules('birth_certificate_no','<b>'.$this->lang->line("birth certificate no.").'</b>', 'trim|required|is_unique[applicant_info.birth_certificate_no]');	
			$this->form_validation->set_rules('gender','<b>'.$this->lang->line("gender").'</b>', 'trim|required');	
			$this->form_validation->set_rules('religion','<b>'.$this->lang->line("religion").'</b>', 'trim|required');	
			$this->form_validation->set_rules('mobile','<b>'.$this->lang->line("mobile").'</b>', 'trim|xss_clean');	
			$this->form_validation->set_rules('email','<b>'.$this->lang->line("email").'</b>', 'trim|xss_clean|valid_email');	
			$this->form_validation->set_rules('gurdian_name','<b>'.$this->lang->line("gurdian\'s name").'</b>', 'trim|required');	
			$this->form_validation->set_rules('gurdian_relation','<b>'.$this->lang->line("relation with gurdian").'</b>', 'trim|required');	
			$this->form_validation->set_rules('gurdian_occupation','<b>'.$this->lang->line("occupation").'</b>', 'trim|required');	
			$this->form_validation->set_rules('gurdian_income','<b>'.$this->lang->line("yearly income").'</b>', 'trim|required');	
			$this->form_validation->set_rules('gurdian_mobile','<b>'.$this->lang->line("mobile").'</b>', 'trim|required|xss_clean');	
			$this->form_validation->set_rules('gurdian_email','<b>'.$this->lang->line("email").'</b>', 'trim|xss_clean|valid_email');
			$this->form_validation->set_rules('previous_institute','<b>'.$this->lang->line("previous institute").'</b>', 'trim');	
			// $this->form_validation->set_rules('exam_version','<b>'.$this->lang->line("exam version").'</b>', 'trim');	
			$this->form_validation->set_rules('session_id','<b>'.$this->lang->line("session").'</b>', 'trim|required');	
			$this->form_validation->set_rules('shift_id','<b>'.$this->lang->line("shift").'</b>', 'trim|required');	
			$this->form_validation->set_rules('class_id','<b>'.$this->lang->line("class").'</b>', 'trim|required');	
			$this->form_validation->set_rules('dept_id','<b>'.$this->lang->line("group/dept.").'</b>', 'trim|required');	
			$this->form_validation->set_rules('username','<b>'.$this->lang->line("username").'</b>', 'trim|required|is_unique[users.username]');	
			$this->form_validation->set_rules('password','<b>'.$this->lang->line("password").'</b>', 'trim|required');	
			$this->form_validation->set_rules('confirm_password','<b>'.$this->lang->line("confirm password").'</b>', 'trim|required|matches[password]');				
			// $this->form_validation->set_rules('quota','<b>'.$this->lang->line("quota").'</b>', 'trim');				
			// $this->form_validation->set_rules('quota_description','<b>'.$this->lang->line("quota description").'</b>', 'trim');				
			$this->form_validation->set_rules('present_district','<b>'.$this->lang->line("present district").'</b>', 'trim|required');	
			$this->form_validation->set_rules('present_thana','<b>'.$this->lang->line("present thana").'</b>', 'trim|required');	
			$this->form_validation->set_rules('present_post','<b>'.$this->lang->line("present post").'</b>', 'trim|required');	
			$this->form_validation->set_rules('present_village','<b>'.$this->lang->line("permanent village").'</b>', 'trim|required');	
			$this->form_validation->set_rules('permanent_district','<b>'.$this->lang->line("permanent district").'</b>', 'trim|required');	
			$this->form_validation->set_rules('permanent_thana','<b>'.$this->lang->line("permanent thana").'</b>', 'trim|required');	
			$this->form_validation->set_rules('permanent_post','<b>'.$this->lang->line("permanent post").'</b>', 'trim|required');	
			$this->form_validation->set_rules('permanent_village','<b>'.$this->lang->line("permanent village").'</b>', 'trim|required');	
									
									
			if ($this->form_validation->run() == FALSE)
			{
				$this->application(); 
			}
			else
			{
				
				$student_name = $this->input->post('student_name');
				// $student_name_ben = $this->input->post('student_name_ben');
				$father_name = $this->input->post('father_name');
				// $father_name_ben = $this->input->post('father_name_ben');
				$mother_name = $this->input->post('mother_name');
				// $mother_name_ben = $this->input->post('mother_name_ben');
				$date_of_birth = $this->input->post('date_of_birth');
				$birth_date = date('Y-m-d', strtotime($date_of_birth));
				// $birth_certificate_no = $this->input->post('birth_certificate_no');
				$gender = $this->input->post('gender');
				$religion = $this->input->post('religion');
				// $quota_id = $this->input->post('quota');
				// $quota_description = $this->input->post('quota_description');
				$previous_institute = $this->input->post('previous_institute');
				$mobile = $this->input->post('mobile');
				$email = $this->input->post('email');
				$gurdian_name = $this->input->post('gurdian_name');
				$gurdian_relation = $this->input->post('gurdian_relation');
				$gurdian_mobile = $this->input->post('gurdian_mobile');
				$gurdian_occupation = $this->input->post('gurdian_occupation');
				$gurdian_income = $this->input->post('gurdian_income');
				$gurdian_mobile = $this->input->post('gurdian_mobile');
				$gurdian_email = $this->input->post('gurdian_email');
				// $exam_version = $this->input->post('exam_version');
				$shift_id = $this->input->post('shift_id');
				$class_id = $this->input->post('class_id');
				$dept_id = $this->input->post('dept_id');
				$session_id = $this->input->post('session_id');
				$courses = $this->input->post('course_id');
				$types = $this->input->post('type');
				$username = $this->input->post('username');
				$password = $this->input->post('password');
				$password_encode=md5($password);				
				$present_district = $this->input->post('present_district');
				$present_thana = $this->input->post('present_thana');
				$present_post = $this->input->post('present_post');
				$present_village = $this->input->post('present_village');
				$permanent_district = $this->input->post('permanent_district');
				$permanent_thana = $this->input->post('permanent_thana');
				$permanent_post = $this->input->post('permanent_post');
				$permanent_village = $this->input->post('permanent_village');

				$photo_name = '';
				if($_FILES['photo']['size'] != 0)
				{
					$ext=array_pop(explode('.',$_FILES['photo']['name']));
					$photo = time().".".$ext;
					$config = array
					(
						"allowed_types" => "jpg|png|jpeg",
						"upload_path" => "./upload/applicant/",
						"max_size"=>200,
						"file_name" => $photo
					);
					$this->load->library('upload', $config);
					if($this->upload->do_upload('photo'))
					$photo_name = $photo;						
					else
					{
						$this->session->set_userdata('application_upload_error',$this->upload->display_errors());	
						return $this->application();

					}
				}
				else
				{
					$this->session->set_userdata('application_upload_error',"<b>".$this->lang->line('Photo').'</b> '.$this->lang->line("is required."));
					return $this->application();

				}


				$this->db->trans_start();

				$form_price=0;
				$payment_status='0';
				$send_sms_after_application='0';
				$config_results=$this->basic->get_data("online_admission_configure",array('where'=>array('dept_id'=>$dept_id,'class_id'=>$class_id,'session_id'=>$session_id))); 
				foreach($config_results as $val)
				{
					$form_price = $val['form_price']; 
					$send_sms_after_application=$val['send_sms_after_application']; 
					break;			
				}
				if($form_price==0) $payment_status='1';

				$data = array(
				'name' => $student_name,
				// 'name_bangla' => $student_name_ben,
				'father_name' => $father_name,
				// 'father_name_bangla' => $father_name_ben,
				'mother_name' => $mother_name,
				// 'mother_name_bangla' => $mother_name_ben,
				'gurdian_name' => $gurdian_name,
				'gurdian_relation' => $gurdian_relation,
				'gurdian_occupation' => $gurdian_occupation,
				'gurdian_income' => $gurdian_income,
				'gurdian_present_district'=>$present_district,
				'gurdian_present_thana'=>$present_thana,
				'gurdian_present_post'=>$present_post,
				'gurdian_present_village'=>$present_village,
				'gurdian_permanent_district'=>$permanent_district,
				'gurdian_permanent_thana'=>$permanent_thana,
				'gurdian_permanent_post'=>$permanent_post,
				'gurdian_permanent_village'=>$permanent_village,
				'gurdian_mobile' => $gurdian_mobile,
				'religion' => $religion,
				// 'quota_id' => $quota_id,
				// 'quota_description' => $quota_description,
				'previous_institute' => $previous_institute,
				'mobile'=>$mobile,
				'class_id' => $class_id,
				'dept_id' => $dept_id,
				'shift_id' => $shift_id,
				'session_id' => $session_id,
				'birth_date' => $birth_date,
				// 'birth_certificate_no' => $birth_certificate_no,
				'gender' => $gender,
				'payment_status' => $payment_status,
				'registered_at'=>date("Y-m-d G:i:s"),	
				// 'exam_version'=>$exam_version,
				'username'=>$username,
				'password' => $password_encode,
				'image'=>$photo_name
				);			
				if($email != '') $data['email'] = $email;		
				if($gurdian_email != '') $data['gurdian_email'] = $gurdian_email;		
				
				$admission_roll=$this->_generate_admission_roll($dept_id,$class_id,$session_id);
				if($admission_roll != '') $data['admission_roll'] = $admission_roll;

				$this->basic->insert_data('applicant_info',$data);
				$applicant_id = $this->db->insert_id();

				for($i=0;$i<count($courses);$i++)
				{
					if($types[$i] != 2 )  //2 means Not Interested course
					{
						$data1 = array
						(
							'applicant_id' => $applicant_id,
							'class_id' => $class_id,
							'course_id' => $courses[$i],
							'dept_id' => $dept_id,
							'session_id' => $session_id
						);
						if($types[$i] == 1)	$data1['type'] = '1'; // 1 means chosen as mandatory
						if($types[$i] == 0)	$data1['type'] = '0'; // 0 means chosen as optioal

						$this->basic->insert_data('applicant_course',$data1);
					} // end if				
				} //end for
				$this->db->trans_complete();

				if ($this->db->trans_status() === FALSE)										
				{
					$this->session->set_flashdata('application_error',$this->lang->line("something went wrong. please try again."));
					return $this->application();
				}	
				else	
				{
					
					$app_suc=$this->lang->line("your application has been received successfully.");
					$app_suc.="<h3 class='red'>".$this->lang->line('applicant id')." : ".$applicant_id;
					if($admission_roll!="") $app_suc.="<br/>".$this->lang->line('admission roll')." : ".$admission_roll;
					$app_suc.="</h3>";
					if($form_price>0) $app_suc.=$this->lang->line("Log in with your username")." &amp; ". $this->lang->line('password to pay the fees of admission form (BDT.')." .$form_price.".") ".$this->lang->line('and')." ".$this->lang->line('finalize your application.');				
					$app_suc.=" ".$this->lang->line('visit your applicant panel and stay updated.');				
					$this->session->set_userdata('application_success',$app_suc);

					
						$message=$this->lang->line("Congratulations").", ".$student_name."! " .$this->lang->line('your applicant id')." : ".$applicant_id;
						if($admission_roll!="") $message.=" ".$this->lang->line('and')." ".$this->lang->line('admission roll')." : ".$admission_roll;
						$message.='.';
						$subject=$this->config->item('institute_address1')." | ".$this->lang->line('online admission application');
						$this->_mail_sender($from=$this->config->item('institute_email'),$to=$email,$subject,$message,$mask=$this->config->item('institute_address1'));
						$this->_mail_sender($from=$this->config->item('institute_email'),$to=$gurdian_email,$subject,$message,$mask=$this->config->item('institute_address1'));
						
						if($send_sms_after_application=='1') 
						$this->_sms_sender($message,$mobile);
						

					redirect('online/applicant_login','location');	
				}
			} //end else
		} //end if	
	}

	function _generate_admission_roll($dept_id=0,$class_id=0,$session_id=0)
	{
		$student_admission_roll="";

		if($dept_id==0 || $class_id==0 || $session_id==0)
		return $student_admission_roll;


		$usable_admission_roll_array=$this->basic->get_data("online_admission_configure",array('where'=>array('dept_id'=>$dept_id,'class_id'=>$class_id,'session_id'=>$session_id))); 
		$usable_admission_roll="";
		foreach($usable_admission_roll_array as $val)
		{
			$usable_admission_roll = $val['usable_admission_roll']; //admission roll to be used
			$auto_id=$val['id']; //primary key of online_admission_configure
			break;			
		}		 

		
		 if($usable_admission_roll!="") 
		 {		 	
		 	$next_admission_roll=$usable_admission_roll+1; 
		 	$next_admission_roll=str_pad($next_admission_roll,4,"0",STR_PAD_LEFT);		 	
			$this->basic->update_data('online_admission_configure',array("id"=>$auto_id),array('usable_admission_roll'=>$next_admission_roll));
			$student_admission_roll=str_pad($session_id,2,"0",STR_PAD_LEFT).str_pad($class_id,2,"0",STR_PAD_LEFT).str_pad($dept_id,2,"0",STR_PAD_LEFT).$next_admission_roll;
		 }
		
		 return $student_admission_roll;
	}

	



	public function ajax_get_dept_based_on_class()
	{
		$class_id = $this->input->post('class_id');
		$session_id = $this->input->post('session_id');

		// get the dept/groups with valid expire date that are configured for online admission 
		$table2='online_admission_configure';		
		$select2=array('distinct(dept_id)');	
		$where2=array('where'=>array('class_id'=>$class_id,'session_id'=>$session_id,'is_admission_open'=>'1','application_last_date >='=>date('Y-m-d')));
		$results2=$this->basic->get_data($table2,$where2,$select2);		
		$configured_depts=array();
		foreach($results2 as $row) 
		{
			$configured_depts[]=$row['dept_id'];
		}

		// get all dept/groups of the class
		$where['where'] = array('class_id' => $class_id);
		$select = array('id','dept_name');
		$depts = $this->basic->get_data('department',$where,$select);
		$str = '<select name="dept_id" class="form-control" id="department_id" onchange="get_course()">
				<option value="">'.$this->lang->line('group / dept.').'</option>';
		foreach($depts as $dept)
		{
			if(in_array($dept['id'],$configured_depts)) // show only configured classes with valid expire date for online admission 
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

        echo "<pre>";
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
	        		echo '<option value="1">'.$this->lang->line('Mandatory').'</option>';
	        		if($course['type']!="1") 
	        		{
	        			echo '<option selected value="2">Not Interested</option>';
	        			echo '<option value="0">'.$this->lang->line('Optional').'</option>';
	        		}
	        	echo '</select>';
        	echo "</td>";
        	echo "</tr>";
        } 
        echo "</table>";
        echo "</div>"; 
        echo "</pre>"; 
       
	}
		
}
