<?php 
require_once("home.php");

class Teacher_marks_entry extends Home {


	function __construct()
	{
		parent::__construct();
		if($this->session->userdata('type_details')!='Teacher')
		redirect('home/login','location');
	}


	public function index()
	{		
		$this->_teacher_viewcontroller();
	}


	public function marks_entry_sheet()
	{
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
		else{
			$data['classes'] = 0;
		}
		

		$sql_1 = "SELECT distinct(shift_id) FROM class_routine WHERE teacher_id = ".$id;
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


		
		$sql_2 = "SELECT distinct(section_id) FROM class_routine WHERE teacher_id = ".$id;
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

		$data['page_title'] = $this->lang->line('exam marks entry');
		$data['body'] = 'teacher/marks_entry/marks_entry';
		$this->_teacher_viewcontroller($data);
	}

	public function get_students(){
		$class_id = $this->input->post('class_id');
		$shift_id = $this->input->post('shift_id');
		$section_id = $this->input->post('section_id');
		$department_id = $this->input->post('dept_id');
		$course_id = $this->input->post('course_id');
		$session_id = $this->input->post('session_id');
		// $marks_entry_date = $this->input->post('marks_entry_date');
		$exam_id = $this->input->post('exam_name');
		// $marks_entry_date = date('Y-m-d', strtotime($marks_entry_date));
		$data['class_id'] = $class_id;
		$data['shift_id'] = $shift_id;
		$data['section_id'] = $section_id;
		$data['department_id'] = $department_id;
		$data['course_id'] = $course_id;
		$data['session_id'] = $session_id;
		// $data['marks_entry_date'] = $marks_entry_date;
		$data['exam_name'] = $exam_id;

		$where['where'] = array(
			'class_id' => $class_id,
			'shift_id' => $shift_id,
			'section_id' => $section_id,
			'dept_id' => $department_id,
			'session_id' => $session_id,
			'deleted' => '0'
			);
		$select = array('id','student_id','name');
		$students_info = $this->basic->get_data('student_info',$where,$select);

		foreach($students_info as $student_info){
			$students[] = $student_info['student_id'];
		}

		$where2['where'] = array(
			'course_id' => $course_id,
			'exam_id' => $exam_id
			);
		$where2['where_in'] = array('student_id' => $students);
		$has_marks = $this->basic->get_data('result_marks',$where2,$select=array('id','student_id','obtained_mark'));
		foreach($has_marks as $marks){
			$students_marks[$marks['student_id']] = $marks['obtained_mark'];
		}
		if(!empty($has_marks)){
			$data['has_marks'] = $students_marks;
			$data['students_info'] = $students_info;
		}
		else{
			$data['students_info'] = $students_info;
		}

		// ################################################# ///
		$id = $this->session->userdata('reference_id');
		
		$sql = "SELECT distinct(class_id) FROM class_routine WHERE teacher_id = ".$id;
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
		

		$sql_1 = "SELECT distinct(shift_id) FROM class_routine WHERE teacher_id = ".$id;
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


		
		$sql_2 = "SELECT distinct(section_id) FROM class_routine WHERE teacher_id = ".$id;
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

		$data['page_title'] = $this->lang->line('exam marks entry');
		$data['body'] = 'teacher/marks_entry/marks_entry';
		$this->_teacher_viewcontroller($data);
	}

	public function marks_entry_input(){
		$class_id = $this->input->post('class_id');
		$course_id = $this->input->post('course_id');
		$section_id = $this->input->post('section_id');
		$session_id = $this->input->post('session_id');
		$shift_id = $this->input->post('shift_id');
		$department_id = $this->input->post('department_id');
		$student_ids = $this->input->post('student_id');

		// $student_info_ids = $this->input->post('student_info_id');
		// print_r($student_ids);exit();
		$student_names = $this->input->post('student_name');
		$marks = $this->input->post('marks');
		$exam_id = $this->input->post('exam_name');
		// $marks_entry_date = $this->input->post('marks_entry_date_input');
		$what_to_do = $this->input->post('delete_insert');

		//getting mark for this course
		$where_course['where'] = array('id'=>$course_id);
		$select_course = array('marks');
		$course_mark = $this->basic->get_data('course',$where_course,$select_course); 

		//getting exam type
		$where_exam_type['where'] = array('id'=>$exam_id);
		$select_exam_type = array('result_type');
		$exam_type = $this->basic->get_data('result_exam_name',$where_exam_type,$select_exam_type);

		// echo $exam_type[0]['result_type']; exit();
		for($i=0;$i<count($student_ids);$i++){
			$grade_point = '';
			$grade = '';
			$marks_input = '';
			if($marks[$i] != ''){
				$mark_for_this_course = $marks[$i];
				$result_type = 'gpa';

				if($exam_type[0]['result_type'] == 'gpa'){
					$mark_for_this_course = ($marks[$i]*100)/$course_mark[0]['marks'];
					$result_type = 'gpa';
				}

				if($exam_type[0]['result_type'] == 'cgpa'){
					$mark_for_this_course = ($marks[$i]*100)/$course_mark[0]['marks'];
					$result_type = 'cgpa';
				}

				$where['where'] = array(
					'start_mark <=' => $mark_for_this_course,
					'end_mark >=' => $mark_for_this_course,
					'result_type' => $result_type 
					);
				$gpa_config = $this->basic->get_data('gpa_config',$where,$select='');
				$marks_input = $marks[$i];
				$grade_point = $gpa_config[0]['grade_point'];
				$grade = $gpa_config[0]['grade_name'];
			}
		

			$data = array(
				'student_id' => $student_ids[$i],
				'exam_id' => $exam_id,
				'course_id' => $course_id,
				'grade' => $grade,
				'is_submit' => 1
				);
			if($marks_input != '') $data['obtained_mark'] = $marks_input;
			if($grade_point != '') $data['grade_point'] = $grade_point;
			if($what_to_do == 'delete'){
				$this->basic->delete_data('result_marks',$where2=array('student_id'=>$student_ids[$i],'exam_id'=>$exam_id,'course_id'=>$course_id));
				$this->basic->insert_data('result_marks',$data);
			}
			else{
				$this->basic->insert_data('result_marks',$data);
			}			
		}

		$this->session->set_userdata('success',$this->lang->line('Your data has been successfully added to database'));
		$this->marks_entry_sheet();
	}


	public function get_exam_name(){
		$class_id = $this->input->post('class_id');
		$dept_id = $this->input->post('department_id');
		$session_id = $this->input->post('session_id');

		$where['where'] = array(
			'class_id' => $class_id,
			'dept_id' => $dept_id,
			'session_id' => $session_id,
			'is_complete' => 0
			);
		$exam_info = $this->basic->get_data('result_exam_name',$where,$select='');

		if(empty($exam_info))
			echo '';
		else{
            $str = '<select name="exam_name" id="exam_name" class="form-control">';
            $str .= '<option value="">'.$this->lang->line('exam name').'</option>';
            foreach($exam_info as $exam){
            	$str .= '<option value="'.$exam['id'].'">'.$exam['exam_name'].'</option>';
            }
            $str .= '</select>';
            echo $str;
		}
			
	}


		
}
