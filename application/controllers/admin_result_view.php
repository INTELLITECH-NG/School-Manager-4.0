<?php 
require_once("home.php");

class Admin_result_view extends Home {

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
		$this->_viewcontroller();
	}

	public function result_sheet(){
		if(!in_array(27,$this->role_modules))  
		redirect('home/access_forbidden','location');	
		// ################################################# ///
		$data['classes'] = $this->get_classes();
		$data['sessions'] = $this->get_sessions();
		$data['sections'] = $this->get_sections();
		$data['shifts'] = $this->get_shifts();
		// ################################################# ///
		$data['page_title'] = $this->lang->line('student result');
		$data['body'] = 'admin/results/results';
		$this->_viewcontroller($data);
	}

	public function get_result_sheet(){
		if(!in_array(27,$this->role_modules))  
		redirect('home/access_forbidden','location');

		$class_id = $this->input->post('class_id');
		$data['class_id_for_result'] = $class_id;
		$shift_id = $this->input->post('shift_id');
		$data['shift_id_for_result'] = $shift_id;
		$section_id = $this->input->post('section_id');
		$data['section_id_for_result'] = $section_id;
		$department_id = $this->input->post('dept_id');
		$data['dept_id_for_result'] = $department_id;
		$session_id = $this->input->post('session_id');
		$data['session_id_for_result'] = $session_id;
		$exam_id = $this->input->post('exam_name');

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
		$students = $this->basic->get_data('view_student_info',$where2);

		//getting data for gpa system from gpa_config table
		$where_gpa['where'] = array('result_type'=>'gpa');
		$data['gpa_config'] = $this->basic->get_data('gpa_config',$where_gpa,$select_gpa=array('grade_point','grade_name'),$join='',$limit='',$start=NULL,$order_by='grade_point asc');
		//getting data for cgpa system from gpa_config table
		$where_cgpa['where'] = array('result_type'=>'cgpa');
		$data['cgpa_config'] = $this->basic->get_data('gpa_config',$where_cgpa,$select_cgpa=array('grade_point','grade_name'),$join='',$limit='',$start=NULL,$order_by='grade_point asc');
		
		// echo $this->db->last_query(); exit();
		$where3['where'] = array('exam_id' => $exam_id);
		$marks = $this->basic->get_data('result_marks',$where3,$select3='');

		$where4['where'] = array('id'=>$exam_id);
		$is_complete_exam = $this->basic->get_data('result_exam_name',$where4,$select=array('is_complete','exam_name','result_type'));
		$data['is_complete'] = $is_complete_exam[0]['is_complete'];
		$data['exam_name'] = $is_complete_exam[0]['exam_name'];
		$data['gpa_cgpa'] = $is_complete_exam[0]['result_type'];

		$data['courses'] = $courses;
		$data['students'] = $students;
		$data['marks'] = $marks;

		// ################################################# ///
		$data['classes'] = $this->get_classes();
		$data['sessions'] = $this->get_sessions();
		$data['sections'] = $this->get_sections();
		$data['shifts'] = $this->get_shifts();
		$data['exam_id'] = $exam_id;
		// ################################################# ///

		$data['page_title'] = 'Student Result';
		$data['body'] = 'admin/results/results';
		$this->_viewcontroller($data);

	}


	public function complete_result($exam_id,$class_id,$dept_id,$shift_id,$section_id,$session_id){

		if(!in_array(27,$this->role_modules))  
		redirect('home/access_forbidden','location');		
		if(!in_array(5,$this->role_module_accesses_27))
		redirect('home/access_forbidden','location');

		$this->db->trans_start();

		$where = array('id'=>$exam_id);
		$data = array('is_complete' => 1);
		$this->basic->update_data('result_exam_name',$where,$data);
		
		$where_exam_type['where'] = array('id'=>$exam_id);
		$select_exam_type = array('result_type');
		$exam_type = $this->basic->get_data('result_exam_name',$where_exam_type,$select_exam_type);
		// $student_list = explode(",",rawurldecode($student_list));

		//getting data for gpa system from gpa_config table
		$where_gpa['where'] = array('result_type'=>'gpa');
		$gpa_config = $this->basic->get_data('gpa_config',$where_gpa,$select_gpa=array('grade_point','grade_name'),$join='',$limit='',$start=NULL,$order_by='grade_point asc');
		//getting data for cgpa system from gpa_config table
		$where_cgpa['where'] = array('result_type'=>'cgpa');
		$cgpa_config = $this->basic->get_data('gpa_config',$where_cgpa,$select_cgpa=array('grade_point','grade_name'),$join='',$limit='',$start=NULL,$order_by='grade_point asc');
		

		$where1['where'] = array('exam_id' => $exam_id);
		$marks = $this->basic->get_data('result_marks',$where1,$select1='');

		$select2 = array('id','course_name');
		$where2['where'] = array(
			'class_id' => $class_id,
			'dept_id' => $dept_id,
			'session_id' => $session_id
			);
		$courses = $this->basic->get_data('course',$where2,$select2);

		foreach($marks as $mark){
          $student_marks[$mark['student_id']][$mark['course_id']]['grade_point'] = $mark['grade_point'];
          $student_marks[$mark['student_id']][$mark['course_id']]['grade'] = $mark['grade'];
          $student_marks[$mark['student_id']][$mark['course_id']]['obtained_mark'] = $mark['obtained_mark'];
        }


      $where3['where'] = array(
			'class_id' => $class_id,
			'shift_id' => $shift_id,
			'section_id' => $section_id,
			'dept_id' => $dept_id,
			'session_id' => $session_id
			);
		$select3 = array('id','student_id','name');
		$students = $this->basic->get_data('student_info',$where3,$select3);


		//getting max_grade_point lowest_grade_point for gpa from gpa_config table 
	   	$where4['where'] = array('result_type'=>'gpa');
       	$max_grade_point = get_data_helper('gpa_config',$where4,$select4=array('max(grade_point) as top_grade'),$join='',$limit='',$start='',$order_by='',$group_by='',$num_rows=1,$single_value=1);
       	$lowest_grade_point = get_data_helper('gpa_config',$where4,$select4=array('min(grade_point) as lowest_grade'),$join='',$limit='',$start='',$order_by='',$group_by='',$num_rows=1,$single_value=1);
     	
       	//checking max_grade_point and lowest_grade_point form gpa_config table for cgpa
      	$where_for_cgpa['where'] = array('result_type'=>'cgpa');
      	$cgpa_max_grade_point = get_data_helper('gpa_config',$where_for_cgpa,$select_for_cgpa=array('max(grade_point) as top_grade'),$join='',$limit='',$start='',$order_by='',$group_by='',$num_rows=1,$single_value=1);
      	$cgpa_lowest_grade_point = get_data_helper('gpa_config',$where_for_cgpa,$select_for_cgpa=array('min(grade_point) as lowest_grade'),$join='',$limit='',$start='',$order_by='',$group_by='',$num_rows=1,$single_value=1);
       
       foreach($students as $student_info){
       	 //may be not needed now
         $student_list_for_result[$student_info['student_id']] = $student_info['student_id'];
         $str = rawurlencode(implode(",",$student_list_for_result));
         //end of may be not needed now
         $where5['where'] = array('student_id'=>$student_info['id'],'type'=>'0');
         $select5 = array('course_id');
         $optional_sub = get_data_helper('student_course',$where5,$select5,$join='',$limit='',$start='',$order_by='',$group_by='',$num_rows=1,$single_value=1);
         $optional_course_id = 0;
         if(!empty($optional_sub)) $optional_course_id = $optional_sub['course_id'];

        $total = 0;
        $number_of_subject = 0;
        $optional_subject = 0;
        $fail = 0;
        $total_mark = 0;
        $total_credit = 0;
        $lost_credit = 0;

        for($i=0;$i<count($courses);$i++)
	      {
	        $where_credit['where'] = array('id'=>$courses[$i]['id']);
	        $course_credit = get_data_helper('course',$where_credit,$select_credit=array('credit'),$join='',$limit='',$start='',$order_by='',$group_by='',$num_rows=1,$single_value=1);
	        $total_credit = $total_credit+$course_credit['credit'];
	      }


        for($i=0;$i<count($courses);$i++)
        {
          $p = '';
          $where_single_credit['where'] = array('id'=>$courses[$i]['id']);
          $course_credit = get_data_helper('course',$where_single_credit,$select_single_credit=array('credit'),$join='',$limit='',$start='',$order_by='',$group_by='',$num_rows=1,$single_value=1);
          
          //if this student has optional course
          if($courses[$i]['id'] == $optional_course_id)
          {

            if(isset($student_marks[$student_info["student_id"]][$courses[$i]["id"]]['grade_point']))
            {
              //getting Optional Subject Substraction gpa
              $optional_sub_subtraction = get_data_helper('result_config',$where='',$select=array('value'),$join='',$limit='',$start='',$order_by='',$group_by='',$num_rows=1,$single_value=1);
              //getting the grade point of a student in this course
              $number = $student_marks[$student_info["student_id"]][$courses[$i]["id"]]['grade_point'];
              $optional_subject = 1;
              if($number > $optional_sub_subtraction['value'])
              {
                //getting the gpa above optional subject
                $above_optional = $number - $optional_sub_subtraction['value'];
                $where8['where'] = array('grade_point' => $optional_sub_subtraction['value']);
                //getting the mark above optional subject
                $top_mark_for_optional_course = get_data_helper('gpa_config',$where8,$select=array('end_mark'),$join='',$limit='',$start='',$order_by='',$group_by='',$num_rows=1,$single_value=1);
                //getting the mark above optional subject
                $above_optional_mark = $student_marks[$student_info["student_id"]][$courses[$i]["id"]]['obtained_mark'] - $top_mark_for_optional_course['end_mark'];
                //putting total gpa
                $total = $total+$above_optional;
                //putting total mark
                $total_mark = $total_mark+$above_optional_mark;
              }
              $p = number_format($number,2);
            }
          }
          // if this student has no optional course
          else
          {

            if(isset($student_marks[$student_info["student_id"]][$courses[$i]["id"]]['grade_point']))
            {
              if($exam_type[0]['result_type'] == 'cgpa')
               {
               	$sub_total = ($course_credit['credit']*$student_marks[$student_info["student_id"]][$courses[$i]["id"]]['grade_point'])/$total_credit;
	               $total = $total+$sub_total;
	               //putting the mark of a student in this course
	              	$marks = $student_marks[$student_info["student_id"]][$courses[$i]["id"]]['obtained_mark'];
	              	//putting total mark
	              	$total_mark = $total_mark+$marks;
	               $p = number_format($sub_total,2);
               }
               else
               {
                 //putting the grade point of a student in this course
	              $number = $student_marks[$student_info["student_id"]][$courses[$i]["id"]]['grade_point'];
	              //putting the mark of a student in this course
	              $marks = $student_marks[$student_info["student_id"]][$courses[$i]["id"]]['obtained_mark'];

	              if($number == $lowest_grade_point['lowest_grade']) $fail = 1;
	              //putting total gpa
	              $total = $total+$number;
	              //putting total mark
	              $total_mark = $total_mark+$marks;
	              $p = number_format($number,2);
               }
              
            }
          }
          if($p != '')
          {
            $number_of_subject = $number_of_subject + 1;
          }
        }//end of for loop for courses

        if($total != 0)
        {
        	   if($exam_type[0]['result_type'] == 'cgpa')
        	   {
        	   	$total_gpa = $total;
        	   }
        	   else
        	   {
        	     if(number_format(($total/($number_of_subject-$optional_subject)),2) > $max_grade_point['top_grade'])
		        {
		          $total_gpa = $max_grade_point['top_grade'];
		        }
		        else
		        {
		          $total_gpa = number_format(($total/($number_of_subject-$optional_subject)),2);
		        }
        	   }
	        
	      }
	      else
	      {
	        $total_gpa = $lowest_grade_point['lowest_grade'];
	      } 
	      $data1['obtained_gpa'] = $total_gpa;
	      $data1['total_marks'] = $total_mark;

	      if($fail == 1)
	      {
           $result_grade = $gpa_config[0]['grade_name'];
         } 
         else
         {
           $grade_name = 0;
           if($exam_type[0]['result_type'] == 'cgpa')
           {
           	 for($j=0;$j<count($cgpa_config)-1;$j++)
	           {
	             if($j == count($cgpa_config))
	               break;
	             else
	             {
	               if($total >= $cgpa_config[$j]['grade_point'] && $total < $cgpa_config[$j+1]['grade_point']){
	                 $result_grade = $cgpa_config[$j]['grade_name'];
	                 $grade_name = 1;
	                 break;
	               }
	             }
	           }
           }
           else
           {
           	 for($j=0;$j<count($gpa_config)-1;$j++)
	           {
	             if($j == count($gpa_config))
	               break;
	             else
	             {
	               if($total_gpa >= $gpa_config[$j]['grade_point'] && $total_gpa < $gpa_config[$j+1]['grade_point']){
	                 $result_grade = $gpa_config[$j]['grade_name'];
	                 $grade_name = 1;
	                 break;
	               }
	             }
	           }
           }
           
           if($grade_name == 0)
           {
           	 if($exam_type[0]['result_type'] == 'cgpa')
           	 	$result_grade = $cgpa_config[$j]['grade_name'];
           	 else
             	$result_grade = $gpa_config[$j]['grade_name'];
           }
         }

         $data1['grade_name'] = $result_grade;
         $data1['student_id'] = $student_info["student_id"];
         $data1['exam_id'] = $exam_id;
         $where6['where'] = array(
           'student_id' => $student_info["student_id"],
           'exam_id' => $exam_id
           );
         $data_in_result = $this->basic->get_data('result',$where6,$select6='');
         if(!empty($data_in_result)){
           $this->basic->delete_data('result',$where7=array('student_id'=>$student_info["student_id"],'exam_id'=>$exam_id));
           $this->basic->insert_data('result',$data1);
         }
         else
           $this->basic->insert_data('result',$data1);


       }//end of foreach

       $this->db->trans_complete();

       if($this->db->trans_status() === FALSE)
       {
       	$this->session->set_userdata('complete_result_error',$this->lang->line('an error has been encountered, please try again.'));
       }
       else
       	$this->session->set_userdata('complete_result_success',$this->lang->line('your request has been done successfully.'));

       redirect("admin_result_view/result_sheet","Location");		
	}

	public function get_exam_name_for_admin(){
		$class_id = $this->input->post('class_id');
		$dept_id = $this->input->post('department_id');
		$session_id = $this->input->post('session_id');

		$where['where'] = array(
			'class_id' => $class_id,
			'dept_id' => $dept_id,
			'session_id' => $session_id
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