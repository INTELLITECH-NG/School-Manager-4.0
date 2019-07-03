<?php

require_once("home.php");

class Student extends Home 

{
	function __construct()
	{
		parent::__construct();					// calling parent class methods explicity.
		$this->load->helper("url");				// loading url helper
		$this->load->library("pagination");		// calling pagination library for pagination
		$this->load->helper("form");
		
		if($this->session->userdata('type_details')!='Student')
		redirect('home/login','location');
	}		

	public function index()
	{	

		/* $id is the id of student login. primary key	*/ 
		$id = $this->session->userdata('reference_id');		

		$data['body'] = 'student/profile';	// view page location

		$table = 'view_student_info';

		/* using $where_simple function from codeigniter. */
		$where_simple = array("id" => $id);		
		
		$where = array('where'=> $where_simple);	

		$result = $this->basic->get_data($table, $where);	
				
		$data['info'] = $result;	

		// passing data to the method _student_viewcontroller for displaying on view page	
		$this->_student_viewcontroller($data);

}	
	// method for showing routine
	public function routine()
	{
		$id=$this->session->userdata('reference_id');
		$data['body']='student/routine';   // view page location

		$where['where'] = array('id'=>$id);

		$temp = $this->basic->get_data('student_info',$where);

		$class_id = $temp[0]['class_id'];

		$data['period']= $this->get_periods();	 // fetching number of periods
		$count = count($data['period']);
		$data['count']= $count;	

		/** initialize the output as an empty array **/
		$output=array();
		
		$student_data=$this->basic->get_data("view_student_info",array("where"=>array("id"=>$id)));
		$session_id=$student_data[0]['session_id'];
		$data['session_name']=$student_data[0]['session_name'];

		$period_id_only=array();
		foreach($data['period'] as $row)
		{
			$period_id_only[]=$row['period_id'];
		}
		$where['where'] = array('class_id'=>$class_id,'session_id'=>$session_id);
		$where['where_in'] = array('period_id'=>$period_id_only);
		$temp = $this->basic->get_data("view_class_routine",$where);

		// creating a froeach loop, where day 1 is sat, day 2 is sun and so on.
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

		$this->_student_viewcontroller($data);		
	}


	/* 	crating a public method to show and download the course_id and course material */
	public function my_course_material()
	{		

		$id = $this->session->userdata('reference_id');			

		$data['body'] = 'student/my_course_material';		// view page location			
		$table = 'view_student_info';
		
		$where_simple = array(	"id" => $id );
		
		$where = array( 'where'=> $where_simple );
		
		$result     = $this->basic->get_data($table, $where);			

		$class_id   = $result[0]['class_id'];
		$dept_id    = $result[0]['dept_id'];
		$session_id = $result[0]['session_id'];

		$where_simple1 = array(
			'student_id'    => $id,
			'class_id'      => $class_id,
			'dept_id'       => $dept_id,
			'session_id'    => $session_id			
			);

		$where1 = array('where'=> $where_simple1);

		$result3     = $this->basic->get_data('student_course', $where1);	
		
		/* extracting course ids from result array by running a foreach loop. $course_ids is an array and diffrent from 
		course_id. name of the variable is $course_ids and it is an array. here $result3 as $course. and the body of the loop
		will be $course_id[] (an array) and this equal to the variable $course["course_id"]. */

		$course_ids = array();
		foreach ($result3 as $course)
		{
			$course_ids[]=$course['course_id'];
		}

		/* creating two where variables. these are arrays. the key of the array is tableName.keyName in database and value is the
		variable names. we want to pull data by these variables from table. */
		$where_simple2 = array("course_material.course_id" =>  $course_ids); 
		$where_simple3 = array("course_material.session_id" => $session_id, "course_material.dept_id" => $dept_id);


		/* creating an array where2 which contains keys 'where_in' and 'where' and the values are arrays
		$where_simple2 and $where_simple3. */
		$where2 = array(
			'where_in' => $where_simple2,
			'where'=>$where_simple3
			);

		/* creating a variable select2. we want to select all keys from our final table(course_material) and some variable from other tables. */
		$select2 = array(
			"course_material.*", 
			"course.course_name",
			"course.course_code",
			"teacher_info.teacher_name",
			"course.dept_id"
			);

		/* creating a join. join will be an array whose keys are table name of other tables(course, teacher_info). and the values are the other tables name followed by
		a '.' and primary key of the corresponding tables which is equal to the final table name.desired key(course_material.course_id) of the corresponding table.
		and finally a left keyword */

		$join2 = array(
			'course'=>"'course.id=course_material.course_id,left",
			'teacher_info'=>"'teacher_info.id=course_material.teacher_id,left"		
			);		
		
		$total_rows_array= $this->basic->count_row("course_material",$where2,"id"); // fetching total rows of course material table
		$total_result=$total_rows_array[0]['total_rows'];	
		
		$config = array();
        $config["base_url"] = site_url() . "student/my_course_material";
        $config["total_rows"] = $total_result;
        $config["per_page"] = 10;
        $config["uri_segment"] = 3;
		$config['prev_link'] = '<<';
        $config['next_link'] = '>>';
		$config['num_links'] = 5;

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;


        $data['info'] = $this->basic->get_data('course_material',
		$where2,$select2,$join2,$limit=$config["per_page"],
		$start=$page,
		$order_by='course_material.id DESC'
		);       
       
        $data["links"] = $this->pagination->create_links(); // creating links for pagination
        
		$this->_student_viewcontroller($data);

	
	}



    // creating a public function for showing attendence
	public function show_my_attendence()
	{		
		 	
		$id = $this->session->userdata('reference_id');	

		$data['body'] = 'student/show_my_attendence';		
		
		$table = 'view_student_info';		

		$where_simple = array(	"id" => $id );	

		$where = array('where'=> $where_simple);			
		
		$result     = $this->basic->get_data("view_student_info", $where);			

		$class_id   = $result[0]['class_id'];
		$dept_id    = $result[0]['dept_id'];
		$session_id = $result[0]['session_id'];

		$where_simple1 = array(
			'student_id'    => $id,
			'class_id'      => $class_id,
			'dept_id'       => $dept_id,
			'session_id'    => $session_id			
			);

		$where1 = array('where'=> $where_simple1);

		$result3     = $this->basic->get_data('student_course', $where1);	

		$course_ids = array();
		foreach ($result3 as $course)

		{
			$course_ids[]=$course['course_id'];
		}

		$where_simple2 = array(
			"view_student_attendence.course_id" => $course_ids, 
			"view_student_attendence.student_info_id" => $id
			);

		$where_simple3 = array(
			"view_student_attendence.session_id" => $session_id,
			"view_student_attendence.student_info_id" => $id
			);

		$where2 = array(
			'where_in' => $where_simple2,
			'where'=> $where_simple3
			);

		$select2=array(	"view_student_attendence.*");


		$data['info'] = $this->basic->get_data(
			'view_student_attendence', 
			$where2,
			$select2,
			$join2="",
			$limit='',
			$start=NULL,
			$order_by='view_student_attendence.course_id DESC'
			);
	
		$this->_student_viewcontroller($data);
	}	


	/* Creating a method to show student transaction history. */
	public function transaction_history()
	{		
        $id = $this->session->userdata('reference_id');	 

		$data['body'] = 'student/transaction_history';

		$table = 'view_student_info';

		$where_simple = array(	"id" => $id );	

		$where = array('where'=> $where_simple);		
		$result     = $this->basic->get_data("view_student_info", $where);	

		$where_simple1 = array(
			'transaction_history.student_info_id'  => $id			
			);	

		$where1 = array('where'=> $where_simple1);	
		$where2 = array();
		$where2['where'] = array('transaction_history.student_info_id'=> $id);	

		$select2=array(
			"transaction_history.*",
			"payment_method.payment_method_name",
			"class.class_name"			
			);			
		$join=array('payment_method'=>"payment_method.id = transaction_history.payment_method_id,left",
			"class" => "class.id = transaction_history.student_info_id,left" );

		$student_info_id = $id;
		$table = 'transaction_history';
		
		$total_rows_array= $this->basic->count_row("transaction_history",$where2,"id");
		$total_result=$total_rows_array[0]['total_rows'];
		

		$config = array();
        $config["base_url"] = site_url() . "student/transaction_history";
        $config["total_rows"] = $total_result;
        $config["per_page"] = 10;
        $config["uri_segment"] = 3;
		$config['prev_link'] = '<<';
        $config['next_link'] = '>>';
		$config['num_links'] = 5;

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
       
        $data['info'] = $this->basic->get_data('transaction_history',$where2,$select2,$join,

			$limit=$config["per_page"],
			$start=$page,
			$order_by='',
			$group_by="",
			$num_rows=0,
			$csv=""
			);       
       
        $data["links"] = $this->pagination->create_links();

		$this->_student_viewcontroller($data);		
	}


	

	public function details_notification($id=0)
	{
		if($id==0)
		redirect('home/access_forbidden','location');	

		// marked as viewed
		$this->basic->update_data($table="sms_email_history",$where=array("id"=>$id,"student_info_id" => $this->session->userdata('reference_id')),$update_data=array("viewed"=>"1"));

		$select=array("sms_email_history.id","sms_email_history.title","sms_email_history.message","DATE_FORMAT(sms_email_history.sent_at, '%d/%m/%y %l:%m %p') as sent_at","sms_email_history.type");
		$data['query_data']=$this->basic->get_data($table="sms_email_history",$where=array('where'=>array("sms_email_history.id"=>$id,"student_info_id" => $this->session->userdata('reference_id'))),$select);
		$data['body']="student/details_notification";
		$data['page_title']="Details Notification";
		$this->_student_viewcontroller($data);
	}

	// creating a method to sent message.
	public function student_query()
	{
		$id = $this->session->userdata('reference_id');	
		$data['body'] = 'student/view_queries';		

		$student_info_id = $id;
		$table = 'student_query';
		$where['where'] = array('student_info_id' => $id);
		$total_rows_array= $this->basic->count_row($table,$where,"id");
		$total_result=$total_rows_array[0]['total_rows'];

		$config = array();
        $config["base_url"] = site_url() . "student/student_query";
        $config["total_rows"] = $total_result;
        $config["per_page"] = 10;  
        $config["uri_segment"] = 3;
		$config['prev_link'] = '<<';
        $config['next_link'] = '>>';
		$config['num_links'] = 5;

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
       
        $data['info'] = $this->basic->get_data($table,$where,$select='',$join='',$limit=$config["per_page"],$start=$page,$order_by='',$group_by='',$num_rows=0,$csv='');
       
        $data["links"] = $this->pagination->create_links();

		$this->_student_viewcontroller($data);
	}	


	public function details_query($id=0)
	{
		if($id==0)
		redirect('home/access_forbidden','location');	

		// marked as viewed if replied
		if($this->basic->is_exist($table="student_query",$where=array("id"=>$id,"replied"=>"1","student_info_id" => $this->session->userdata('reference_id')),$select="id"))
		$this->basic->update_data($table="student_query",$where=array("id"=>$id),$update_data=array("reply_viewed"=>"1"));

		$select=array("student_query.id as primary_key","student_query.message_subject","student_query.message_body","DATE_FORMAT(student_query.sent_at, '%d/%m/%y %l:%m %p') as sent_at","DATE_FORMAT(student_query.reply_at, '%d/%m/%y %l:%m %p') as reply_at","student_query.replied","student_query.reply_message");
		$data['query_data']=$this->basic->get_data($table="student_query",$where=array('where'=>array("student_query.id"=>$id,"student_info_id" => $this->session->userdata('reference_id'))),$select);
		$data['body']="student/details_query";
		$data['page_title']="Details Query / Complain";
		$this->_student_viewcontroller($data);
	}

	// creating a function for show form for inserting complain.
	public function send_query_form()
	{		
		$data['body']="student/send_complain";		
		$this->_student_viewcontroller($data);
	}

	// creating a function to send complain
	public function send_query_action()
	{
		$id = $this->session->userdata('reference_id');	

		if($_POST)
		{
			$this->form_validation->set_rules('message_subject', '<b>'.$this->lang->line('Subject').'</b>','trim|required');	
			$this->form_validation->set_rules('message_body', 	 '<b>'.$this->lang->line('Message').'</b>','trim|required');			
			// $this->form_validation->set_rules('ward', 		 '<b>Ward</b>',							'required');			

			if ($this->form_validation->run() == FALSE)
				{
					$this->send_query_form(); 
				}

			else
			{
				$sent_at=date("Y-m-d H:i:s");
				$message_subject=$this->input->post('message_subject');
				$message_body=$this->input->post('message_body');

				$data = array(
				'student_info_id' => $this->session->userdata('reference_id'),
				'message_subject' => $message_subject,
				'message_body'    => $message_body,
				'sent_at' 		  => $sent_at
				);				

				if($this->basic->insert_data('student_query',$data)) 
				{							
					$this->session->set_flashdata('success_message',1);
					redirect('student/student_query','location');					
			  	}				
			}
		}	
    }

    public function sms_history()
    {
    	$id = $this->session->userdata('reference_id');	
		$data['body'] = 'student/sms_history';
		

		$student_info_id = $id;
		$table = 'sms_email_history';
		$where['where'] = array('student_info_id' => $id);
		$total_rows_array= $this->basic->count_row($table,$where,"id");
		$total_result=$total_rows_array[0]['total_rows'];


		$config = array();
        $config["base_url"] = site_url() . "student/sms_history";
        $config["total_rows"] = $total_result;
        $config["per_page"] = 10;
        $config["uri_segment"] = 3;
		$config['prev_link'] = '<<';
        $config['next_link'] = '>>';
		$config['num_links'] = 5;

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
       
        $data['info'] = $this->basic->get_data($table,$where,$select='',$join='',$limit=$config["per_page"],$start=$page,$order_by='',$group_by='',$num_rows=0,$csv='');
       
        $data["links"] = $this->pagination->create_links();

		$this->_student_viewcontroller($data);
    }


	// a method to show marks of student
	public function show_marks_home()
	{
		$id = $this->session->userdata('reference_id');	 

		$data['body'] = 'student/show_marks_home';

		// first we need to fetch unique id of student from view_student_info table
		$table = 'view_student_info';

		// setting student_id(unique id) as id in where array 
		$where_simple = array("view_student_info.id" => $id );	
		$where = array('where'=> $where_simple);		

		$result = $this->basic->get_data("view_student_info", $where);

		// matching id for view result marks table
		$id = $result[0]["student_id"];

		$where['where'] = array('student_id'=>$id);
		$result2 = $this->basic->get_data('view_result_marks',$where);

		// picking up $class name variable from view_result_marks table
		$class_name = $result2[0]['class_name'];

		// setting condition "result_exam_name.is_complete"=>"1" to fetch only complete result for student
		$where['where'] = array(
			'result.student_id'=>$id,
			"result_exam_name.is_complete"=>"1");

		// creating a join with result_exam_name table
		$join = array('result_exam_name'=>'result_exam_name.id=result.exam_id,left',);
		$result3 = $this->basic->get_data('result',$where,$select='',$join);

		$data['info']  = $result;
		$data['info2'] = $result2;
		$data['info3'] = $result3;		
		$data['info4'] = $class_name;

		// send output to view
		$this->_student_viewcontroller($data);
		
	}


	// creating a method to show detail of published results
	public function show_marks_details($id = 0)
	{
		$id1 = $this->session->userdata('reference_id');		

		// first we need to fetch unique id of student from view_student_info table
		$table = 'view_student_info';

		// setting student_id(unique id) as id in where array 
		$where_simple = array("view_student_info.id" => $id1 );	
		$where = array('where'=> $where_simple);		

		$result = $this->basic->get_data("view_student_info", $where);		

		$id2 = $result[0]['student_id'];			

		$where2["where"] = array(
			"view_result_marks.student_id" => $id2,
			"view_result_marks.exam_id" => $id
			);

		$result2 = $this->basic->get_data("view_result_marks",$where2);		

		$data['info'] = $result2;
		$data['body'] = 'student/show_marks_details';
		$this->_student_viewcontroller($data);
	}


	//// library functions

	public function library(){

		 $this->member_book_list();
	}

	public function member_book_list()
    {
        $data['category_info'] = $this->get_book_category();
        $data['body']          = 'member/member_book_list';
        $data['page_title'] = $this->lang->line('book list');
        $this->_student_viewcontroller($data);
    }


    public function member_book_list_data()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            redirect('home/access_forbidden', 'location');
        }

        // setting variables for pagination
        $page    = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows    = isset($_POST['rows']) ? intval($_POST['rows']) : 15;
        $sort    = isset($_POST['sort']) ? strval($_POST['sort']) : 'title';
        $order    = isset($_POST['order']) ? strval($_POST['order']) : 'ASC';
        $order_by_str = $sort." ".$order;

        // setting properties for search
        $book_id    = trim($this->input->post('book_id', true));
        $isbn        = trim($this->input->post('isbn', true));
        $title        = trim($this->input->post('title', true));
        $author    = trim($this->input->post("author", true));
        $category    = trim($this->input->post('category_id', true));

        // setting a new properties for $is_searched to set session if search occured
        $is_searched = $this->input->post('is_searched', true);

        if ($is_searched) {
            // if search occured, saving user input data to session. name of method is important before field
            $this->session->set_userdata('member_book_list_book_id', $book_id);
            $this->session->set_userdata('member_book_list_isbn', $isbn);
            $this->session->set_userdata('member_book_list_title', $title);
            $this->session->set_userdata('member_book_list_author', $author);
            $this->session->set_userdata('member_book_list_category', $category);
        }

        // saving session data to different search parameters
        $search_book_id  = $this->session->userdata('member_book_list_book_id');
        $search_isbn     = $this->session->userdata('member_book_list_isbn');
        $search_title     = $this->session->userdata('member_book_list_title');
        $search_author   = $this->session->userdata('member_book_list_author');
        $search_category = $this->session->userdata('member_book_list_category');

        // creating a blank where_simple array
        $where_simple=array();

        // trimming data
        if ($search_book_id) {
            $where_simple['id'] = $search_book_id;
        }

        if ($search_isbn) {
            $where_simple['isbn like '] = "%".$search_isbn."%";
        }

        if ($search_title) {
            $where_simple['title like '] = "%".$search_title."%";
        }

        if ($search_author) {
            $where_simple['author like '] = "%".$search_author."%";
        }

        // FIND_IN_SET is used to find one single value from many values. here multiple category exists
        if ($search_category) {
            $this->db->where("FIND_IN_SET('$search_category', category_id) !=", 0);
        }

        // $where_simple['deleted'] = 0 means we will show only availabe books
        $where_simple['deleted'] = "0";
        $where = array('where' => $where_simple);

        $offset = ($page-1)*$rows;

        $table = "library_book_info";
        // getting data from table
        $info = $this->basic->get_data($table, $where, $select = '', $join = '', $limit = $rows, $start = $offset, $order_by = $order_by_str);

        $total_rows_array = $this->basic->count_row($table, $where, $count = "library_book_info.id");
        $total_result = $total_rows_array[0]['total_rows'];

        echo convert_to_grid_data($info, $total_result);    // convert to grid data
    }

    public function view_details($id = 0)
    {
        $data["body"] = "member/view_details";
        $data['page_title'] = $this->lang->line('book details');

        $table = "library_book_info";
        $where['where'] = array('library_book_info.id' => $id);

        $result_book_info = $this->basic->get_data($table, $where, $select = '', $join = '', $limit = "", $start = "", $order_by = "");

        $result_category = $this->basic->get_data("library_category", $where = "", $select = '', $join = '', $limit = '', $start = null, $order_by = '');

        $cat_string = $result_book_info[0]['category_id'];    // extracting category id from data array
        $temp = explode(",", $cat_string);    // creating array from a string through explode function

        $data['info'] = $result_book_info;

        $data['all_category'] = $result_category;

        $data['existing_category'] = $temp;

        $this->_student_viewcontroller($data);
    }


    public function member_circulation()
    {
        $data['body'] = 'member/circulation';
        $data['page_title'] = $this->lang->line('circulation');
        $this->_student_viewcontroller($data);
    }


    public function member_circulation_data()
    {
        /*if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            redirect('home/access_forbidden', 'location');
        }*/

        $id = $this->session->userdata('member_id');

        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 15;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'issue_date';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'DESC';
        $order_by_str = $sort." ".$order;

        // setting properties for search
        // $member_name = $this->input->post('name');

        $book_title    = trim($this->input->post('book_title', true));
        $author          = trim($this->input->post("author", true));
        $return_status  = trim($this->input->post("return_status", true));

        $from_date = $this->input->post('from_date', true);

        if ($from_date !='') {
            $from_date    = date('Y-m-d', strtotime($from_date));
        }

        $to_date = $this->input->post('to_date', true);

        if ($to_date!='') {
            $to_date = date('Y-m-d', strtotime($to_date));
        }

        // setting a new properties for $is_searched to set session if search occured
        $is_searched = $this->input->post('is_searched', true);

        /***Fix the date format**/

        if ($is_searched) {
            // if search occured, saving user input data to session. name of method is important before field
            // $this->session->set_userdata('book_list_name', 		  $member_name);
            $this->session->set_userdata('personal_circulation_book_title', $book_title);
            $this->session->set_userdata('personal_circulation_author', $author);
            $this->session->set_userdata('personal_circulation_from_date', $from_date);
            $this->session->set_userdata('personal_circulation_to_date', $to_date);
            $this->session->set_userdata('personal_circulation_status', $return_status);
        //	$this->session->set_userdata('book_list_category', $category_id);
        }

        // saving session data to different search parameter variables
        // $search_member_name = $this->session->userdata('book_list_name');
        $search_book_title = $this->session->userdata('personal_circulation_book_title');
        $search_author     = $this->session->userdata('personal_circulation_author');
        $search_to_date    = $this->session->userdata('personal_circulation_to_date');
        $search_from_date  = $this->session->userdata('personal_circulation_from_date');
        $search_status     = $this->session->userdata('personal_circulation_status');
    //	$search_category=$this->session->userdata('book_list_category');

        // creating a blank where_simple array
        $where_simple = array();

        if ($search_status) {
            if ($search_status == 'returned') {
                $where_simple['is_returned'] = '1';
            }

            if ($search_status == 'expired_returned') {
                $where_simple['is_returned'] = '1';
                $where_simple['is_expired'] = '1';
            }

            if ($search_status == 'expired_not_returned') {
                $where_simple['is_returned'] = '0';
                $where_simple['is_expired'] = '1';
            }
        }

        // trimming data
        // if($search_member_name) $where_simple['member.name like'] = "%".$search_member_name."%";
        if ($search_book_title) {
            $where_simple['library_book_info.title like'] = "%".$search_book_title."%";
        }

        if ($search_author) {
            $where_simple['library_book_info.author like']    = "%".$search_author."%";
        }

        if ($search_from_date != '') {
            $where_simple['circulation.issue_date >='] = $search_from_date;
        }

        if ($search_to_date != '') {
            $where_simple['circulation.issue_date <='] = $search_to_date;
        }

        $where_simple['member_id'] = $id;
        $where  = array('where' => $where_simple);
        $offset = ($page-1)*$rows;
        $result = array();

        $join = array(
            "student_info" => "student_info.id = circulation.member_id, left",
            "library_book_info" => "library_book_info.id = circulation.book_id, left"
            );

        $table = 'circulation';

        $info = $this->basic->get_data($table, $where, $select = '', $join, $limit = $rows, $start = $offset, $order_by = $order_by_str);

        $total_rows_array = $this->basic->count_row($table, $where, $count = "circulation.id", $join);
        $total_result = $total_rows_array[0]['total_rows'];

        echo convert_to_grid_data($info, $total_result);
    }
}
