<?php 
require_once("home.php");

class Teacher_attendance extends Home {


	function __construct()
	{
		parent::__construct();
		if($this->session->userdata('logged_in')!=1)
		redirect('home/login','location');

		if($this->session->userdata('type_details')!='Teacher')
		redirect('home/login','location');

		// if(!in_array(30,$this->role_modules))  
		// redirect('home/access_forbidden','location');	
	}


	public function index()
	{		
		$this->_teacher_viewcontroller();
	}


	public function attendance_percentage(){
		// ################################################# ///
		$id = $this->session->userdata('reference_id');
		$date = date('l');
		$day = substr($date, 0,3);
		$sql = "SELECT distinct(class_id) FROM class_routine WHERE teacher_id = ".$id;
		$classes = $this->basic->execute_query($sql);
		if(!empty($classes)){
			$class_ids = array();
			foreach($classes as $class)
				$class_ids[] = $class['class_id'];
			$where_in_1 = array('id' => $class_ids);
			$data['classes'] = $this->basic->get_data('class',$where=array('where_in'=>$where_in_1),$select='');
		}
		else
			$data['classes'] = 0;
		

		
		$sql_1 = "SELECT distinct(shift_id) FROM class_routine WHERE teacher_id = ".$id;
		$shifts = $this->basic->execute_query($sql_1);
		if(!empty($shifts)){
			$shift_ids = array();
			foreach($shifts as $shift)
				$shift_ids[] = $shift['shift_id'];
			$where_in_2 = array('id' => $shift_ids);
			$data['shifts'] = $this->basic->get_data('class_shift',$where=array('where_in'=>$where_in_2),$select='');
		}
		else
			$data['shifts'] = 0;
		



		$sql_2 = "SELECT distinct(section_id) FROM class_routine WHERE teacher_id = ".$id;
		$sections = $this->basic->execute_query($sql_2);
		if(!empty($sections)){
			$section_ids = array();
			foreach($sections as $section)
				$section_ids[] = $section['section_id'];
			$where_in_3 = array('id' => $section_ids);
			$data['sections'] = $this->basic->get_data('class_section',$where=array('where_in'=>$where_in_3),$select='');
		}
		else
			$data['shifts'] = 0;
		
		$data['sessions'] = $this->get_sessions();
		// ################################################# ///
		$data['page_title'] = $this->lang->line('attendence perecentage');
		$data['body'] = 'teacher/attendance/attendance_percentage';
		$this->_teacher_viewcontroller($data);
	}

	public function get_attendance_percentage(){
		$class_id = $this->input->post('class_id');
		$shift_id = $this->input->post('shift_id');
		$section_id = $this->input->post('section_id');
		$department_id = $this->input->post('dept_id');
		$session_id = $this->input->post('session_id');

		$select1 = array('id','course_name');
		$where1['where'] = array(
			'class_id' => $class_id,
			'dept_id' => $department_id,
			'session_id' => $session_id
			);
		$courses = $this->basic->get_data('course',$where1,$select1);

		$where2['where'] = array(
			'class_id' => $class_id,
			'shift_id' => $shift_id,
			'section_id' => $section_id,
			'dept_id' => $department_id,
			'session_id' => $session_id
			);
		$select2 = array('student_id','name');
		$students = $this->basic->get_data('student_info',$where2,$select2);

		
		$select3 = array('student_id','course_id','present_percentage');
		$where3['where'] = array(
			'class_id' => $class_id,
			'shift_id' => $shift_id,
			'section_id' => $section_id,
			'dept_id' => $department_id,
			'session_id' => $session_id
			);
		$percentage = $this->basic->get_data('view_student_attendence',$where3,$select3);
		// print_r($percentage);exit();

		$data['courses'] = $courses;
		$data['students'] = $students;
		$data['percentage'] = $percentage;
		// ################################################# ///
		$id = $this->session->userdata('reference_id');
		$date = date('l');
		$day = substr($date, 0,3);
		$sql = "SELECT distinct(class_id) FROM class_routine WHERE teacher_id = ".$id." AND day LIKE '%$day%'";
		$classes = $this->basic->execute_query($sql);
		if(!empty($classes)){
			$class_ids = array();
			foreach($classes as $class)
				$class_ids[] = $class['class_id'];
			$where_in_1 = array('id' => $class_ids);
			$data['classes'] = $this->basic->get_data('class',$where=array('where_in'=>$where_in_1),$select='');
		}
		else{
			$data['classes'] = 0;
		}
		

		$sql_1 = "SELECT distinct(shift_id) FROM class_routine WHERE teacher_id = ".$id." AND day LIKE '%$day%'";
		$shifts = $this->basic->execute_query($sql_1);
		if(!empty($shifts)){
			$shift_ids = array();
			foreach($shifts as $shift)
				$shift_ids[] = $shift['shift_id'];
			$where_in_2 = array('id' => $shift_ids);
			$data['shifts'] = $this->basic->get_data('class_shift',$where=array('where_in'=>$where_in_2),$select='');
		}
		else{
			$data['shifts'] = 0;
		}


		
		$sql_2 = "SELECT distinct(section_id) FROM class_routine WHERE teacher_id = ".$id." AND day LIKE '%$day%'";
		$sections = $this->basic->execute_query($sql_2);
		if(!empty($sections)){
			$section_ids = array();
			foreach($sections as $section)
				$section_ids[] = $section['section_id'];
			$where_in_3 = array('id' => $section_ids);
			$data['sections'] = $this->basic->get_data('class_section',$where=array('where_in'=>$where_in_3),$select='');
		}
		else{
			$data['sections'] = 0;
		}
		
		
		$data['sessions'] = $this->get_sessions();
		// ################################################# ///

		$data['page_title'] = $this->lang->line('attendence perecentage');
		$data['body'] = 'teacher/attendance/attendance_percentage';
		$this->_teacher_viewcontroller($data);

	}


	public function attendnace_sheet(){
		// ################################################# ///
		$id = $this->session->userdata('reference_id');
		$date = date('l');
		$day = substr($date, 0,3);
		$sql = "SELECT distinct(class_id) FROM class_routine WHERE teacher_id = ".$id." AND day LIKE '%$day%'";
		$classes = $this->basic->execute_query($sql);
		if(!empty($classes)){
			$class_ids = array();
			foreach($classes as $class)
				$class_ids[] = $class['class_id'];
			$where_in_1 = array('id' => $class_ids);
			$data['classes'] = $this->basic->get_data('class',$where=array('where_in'=>$where_in_1),$select='');
		}
		else{
			$data['classes'] = 0;
		}
		

		$sql_1 = "SELECT distinct(shift_id) FROM class_routine WHERE teacher_id = ".$id." AND day LIKE '%$day%'";
		$shifts = $this->basic->execute_query($sql_1);
		if(!empty($shifts)){
			$shift_ids = array();
			foreach($shifts as $shift)
				$shift_ids[] = $shift['shift_id'];
			$where_in_2 = array('id' => $shift_ids);
			$data['shifts'] = $this->basic->get_data('class_shift',$where=array('where_in'=>$where_in_2),$select='');
		}
		else{
			$data['shifts'] = 0;
		}


		
		$sql_2 = "SELECT distinct(section_id) FROM class_routine WHERE teacher_id = ".$id." AND day LIKE '%$day%'";
		$sections = $this->basic->execute_query($sql_2);
		if(!empty($sections)){
			$section_ids = array();
			foreach($sections as $section)
				$section_ids[] = $section['section_id'];
			$where_in_3 = array('id' => $section_ids);
			$data['sections'] = $this->basic->get_data('class_section',$where=array('where_in'=>$where_in_3),$select='');
		}
		else{
			$data['sections'] = 0;
		}
		
		
		$data['sessions'] = $this->get_sessions();
		// ################################################# ///

		$data['page_title'] = $this->lang->line('student attendance');
		$data['body'] = 'teacher/attendance/attendance_input_form';
		$this->_teacher_viewcontroller($data);
	}

	public function get_students(){
		$class_id = $this->input->post('class_id');
		$shift_id = $this->input->post('shift_id');
		$section_id = $this->input->post('section_id');
		$department_id = $this->input->post('dept_id');
		$course_id = $this->input->post('course_id');
		$session_id = $this->input->post('session_id');
		$attendance_date = $this->input->post('attendance_date');
		$attendance_date = date('Y-m-d', strtotime($attendance_date));
		$data['class_id'] = $class_id;
		$data['shift_id'] = $shift_id;
		$data['section_id'] = $section_id;
		$data['department_id'] = $department_id;
		$data['course_id'] = $course_id;
		$data['session_id'] = $session_id;
		$data['attendance_date'] = $attendance_date;

		$where_attendance = array(
			'class_id' => $class_id,
			'shift_id' => $shift_id,
			'section_id' => $section_id,
			'dept_id' => $department_id,
			'course_id' => $course_id,
			'session_id' => $session_id,
			'attendance_date' => $attendance_date
			);
		$has_attendance = $this->basic->get_data('student_attendence',$where= array('where'=>$where_attendance),$select=array('id','student_id','status'));
		if(!empty($has_attendance)){
			$data['attendance_status'] = $has_attendance;
			foreach($has_attendance as $has_attendance){
				$student_ids_with_attendance[] = $has_attendance['student_id'];
			}
			$student_infos_with_attendance = $this->basic->get_data('student_info',$where=array('where_in'=>array('student_id'=>$student_ids_with_attendance)),$select=array('id','student_id','name'));
			$data['students_info'] = $student_infos_with_attendance;

		}
		else{
			$where['where'] = array(
				'class_id' => $class_id,
				'shift_id' => $shift_id,
				'section_id' => $section_id,
				'dept_id' => $department_id,
				'session_id' => $session_id
				);
			$select = array('id','student_id','name');
			$data['students_info'] = $this->basic->get_data('student_info',$where,$select);
		}

		// ################################################# ///
		$id = $this->session->userdata('reference_id');
		$date = date('l');
		$day = substr($date, 0,3);
		$sql = "SELECT distinct(class_id) FROM class_routine WHERE teacher_id = ".$id." AND day LIKE '%$day%'";
		$classes = $this->basic->execute_query($sql);
		if(!empty($classes)){
			$class_ids = array();
			foreach($classes as $class)
				$class_ids[] = $class['class_id'];
			$where_in_1 = array('id' => $class_ids);
			$data['classes'] = $this->basic->get_data('class',$where=array('where_in'=>$where_in_1),$select='');
		}
		else{
			$data['classes'] = 0;
		}
		

		$sql_1 = "SELECT distinct(shift_id) FROM class_routine WHERE teacher_id = ".$id." AND day LIKE '%$day%'";
		$shifts = $this->basic->execute_query($sql_1);
		if(!empty($shifts)){
			$shift_ids = array();
			foreach($shifts as $shift)
				$shift_ids[] = $shift['shift_id'];
			$where_in_2 = array('id' => $shift_ids);
			$data['shifts'] = $this->basic->get_data('class_shift',$where=array('where_in'=>$where_in_2),$select='');
		}
		else{
			$data['shifts'] = 0;
		}


		
		$sql_2 = "SELECT distinct(section_id) FROM class_routine WHERE teacher_id = ".$id." AND day LIKE '%$day%'";
		$sections = $this->basic->execute_query($sql_2);
		if(!empty($sections)){
			$section_ids = array();
			foreach($sections as $section)
				$section_ids[] = $section['section_id'];
			$where_in_3 = array('id' => $section_ids);
			$data['sections'] = $this->basic->get_data('class_section',$where=array('where_in'=>$where_in_3),$select='');
		}
		else{
			$data['sections'] = 0;
		}
		
		
		$data['sessions'] = $this->get_sessions();
		// ################################################# ///

		$sql = "SELECT course_name FROM course WHERE id =".$course_id;
		$course_name = $this->basic->execute_query($sql);
		$data['course_name'] = $course_name[0]['course_name'];

		$data['body'] = 'teacher/attendance/attendance_input_form';
		$this->_teacher_viewcontroller($data);
	}

	public function attendance_input(){
		$class_id = $this->input->post('class_id');
		$course_id = $this->input->post('course_id');
		$section_id = $this->input->post('section_id');
		$session_id = $this->input->post('session_id');
		$shift_id = $this->input->post('shift_id');
		$department_id = $this->input->post('department_id');
		$student_ids = $this->input->post('student_id');

		$student_info_ids = $this->input->post('student_info_id');
		// print_r($student_ids);exit();
		$student_names = $this->input->post('student_name');
		$status = $this->input->post('status');
		$attendance_date = $this->input->post('attendance_date_input');
		$what_to_do = $this->input->post('delete_insert');
		$teacher_id = $this->session->userdata('reference_id');

		for($i=0;$i<count($student_ids);$i++){
			if(!isset($status[$student_ids[$i]]))
				$status_input = 0;
			else
				$status_input = 1;
			$data = array(
				'student_id' => $student_ids[$i],
				'course_id' => $course_id,
				'class_id' => $class_id,
				'dept_id' => $department_id,
				'shift_id' => $shift_id,
				'section_id' => $section_id,
				'session_id' => $session_id,
				'status' => $status_input,
				'attendance_date' => $attendance_date,
				'student_info_id' => $student_info_ids[$i],
				'teacher_id' => $teacher_id
				);
			if($what_to_do == 'delete'){
				$this->basic->delete_data('student_attendence',$where=array('student_id'=>$student_ids[$i],'attendance_date'=>$attendance_date));
				$this->basic->insert_data('student_attendence',$data);
			}
			else{
				$this->basic->insert_data('student_attendence',$data);
			}
			
		}
		$this->session->set_userdata('success',$this->lang->line('your data has been successfully added to database'));
		$this->attendnace_sheet();
	}


		
}
