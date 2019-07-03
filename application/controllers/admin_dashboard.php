<?php 
require_once("home.php");

class Admin_dashboard extends Home {


	function __construct()
	{
		parent::__construct();

		if($this->session->userdata('logged_in')!=1)
		redirect('home/login','location');

		if($this->session->userdata('user_type')!='Operator')
		redirect('home/login','location');

		if(!in_array(16,$this->role_modules))  
		redirect('admin/index','location');

		$this->important_feature();
        $this->periodic_check();
	}

	public function index(){
		$data['page_title'] = $this->lang->line('admin dashboard');
		$data['body']='admin/dashboard/dashboard';
		
		$today=date('Y-m-d');
		/***Get Today's Admitted Student***/
		$where=array( "where"=> array(
										"date_format(admitted_at,'%Y-%m-%d')"=>$today,
										"deleted"=>'0',
										"status"=>'1'
										)
					);
					
		$select1=array("count(id) as new_students")	;
		$today_students=$this->basic->get_data('student_info',$where,$select1,$join1='',$limit1='',$start1='',$order_by1='',$group_by1='',$num_rows1=1);
		$data['todat_new_students']=$today_students[0]['new_students'];
		
		/******** Get today's Total Collection *************/
		$where=array( "where"=> array(
										"date_format(payment_date,'%Y-%m-%d')"=>$today
										)
					);
					
		$select1=array("Sum(paid_amount) as paid_amount")	;
		$today_payments=$this->basic->get_data('transaction_history',$where,$select1,$join1='',$limit1='',$start1='',$order_by1='',$group_by1='',$num_rows1=1);
		$data['total_amount']=(int) $today_payments[0]['paid_amount'];
		
		
		
		/******	Today's Notification Statistics *********/
		$where=array( "where"=> array(
										"date_format(sent_at,'%Y-%m-%d')"=>$today
									)
					);
					
		$select1=array("type,count(id) as total_notification");
		$data['today_notifications']=$this->basic->get_data('sms_email_history',$where,$select1,$join1='',$limit1='',$start1='',$order_by1='',$group_by1='type',$num_rows1=0);
		
		
	/*================================================================================================*/
	
		/****This Year Report********/
		
		$this_year=date('Y');
		/***Get this year Admitted Student***/
		$where=array( "where"=> array(
										"date_format(admitted_at,'%Y')"=>$this_year,
										"deleted"=>'0',
										"status"=>'1'
										)
					);
					
		$select1=array("count(id) as new_students")	;
		$this_year_students=$this->basic->get_data('student_info',$where,$select1,$join1='',$limit1='',$start1='',$order_by1='',$group_by1='',$num_rows1=1);
		$data['this_year_students']=$this_year_students[0]['new_students'];
		
		/******** Get this Year Total Collection *************/
		$where=array( "where"=> array(
										"date_format(payment_date,'%Y')"=>$this_year
										)
					);
					
		$select1=array("Sum(paid_amount) as paid_amount")	;
		$this_year_payments=$this->basic->get_data('transaction_history',$where,$select1,$join1='',$limit1='',$start1='',$order_by1='',$group_by1='',$num_rows1=1);
		$data['this_year_amount']=(int) $this_year_payments[0]['paid_amount'];
		
		
		
		/******	This Year Notification Statistics *********/
		$where=array( "where"=> array(
										"date_format(sent_at,'%Y')"=>$this_year
									)
					);
					
		$select1=array("type,count(id) as total_notification");
		$data['this_year_notifications']=$this->basic->get_data('sms_email_history',$where,$select1,$join1='',$limit1='',$start1='',$order_by1='',$group_by1='type',$num_rows1=0);


		$male_info_student = $this->db->query("SELECT COUNT(id) as id FROM `view_student_info` WHERE gender = 'male'")->row();
		$number_of_male_student = $male_info_student->id;

		$female_info_student = $this->db->query("SELECT COUNT(id) as id FROM `view_student_info` WHERE gender = 'female'")->row();
		$number_of_female_student = $female_info_student->id;

		$table = "teacher_info";
		$where = array('where' => array('gender' => 'male'));
		$select = array('count(id) as id');
		$male_info_teacher = $this->basic->get_data($table,$where,$select);
		$number_male_teacher = $male_info_teacher[0]['id'];

		$where = array('where' => array('gender' => 'female'));
		$select = array('count(id) as id');
		$female_info_teacher = $this->basic->get_data($table,$where,$select);
		$number_female_teacher = $female_info_teacher[0]['id'];

		$male_female_student = array(
		    0 => array(
		        "value" => $number_of_male_student,
		        "color" => "#19DD89",
		        "highlight" => "#19DD89",
		        "label" => "Male Students",
		        ),
		    1 => array(
		        "value" => $number_of_female_student,
		        "color" => "#F5A196",
		        "highlight" => "#F5A196",
		        "label" => "Female Students",
		        )
		    );
		$data['male_female_student'] = json_encode($male_female_student);



		$male_female_teacher = array(
		    0 => array(
		        "value" => $number_male_teacher,
		        "color" => "#0099CC",
		        "highlight" => "#0099CC",
		        "label" => "Male Teachers",
		        ),
		    1 => array(
		        "value" => $number_female_teacher,
		        "color" => "#FFFF66",
		        "highlight" => "#FFFF66",
		        "label" => "Female Teachers",
		        )
		    );
		$data['male_female_teacher'] = json_encode($male_female_teacher);



		$where=array( "where"=> array(
									"deleted"=>'0',
									"status"=>'1'
									)
					);
					
		$select1=array("session_name as session,gender,count(id) as total_student");
		$student_info=$this->basic->get_data('view_student_info',$where,$select1,$join1='',$limit1='',$start1='',$order_by1='',$group_by1='session_name,gender',$num_rows1=0);

		
		$session_wise_student = array();
		$temp_array = array();
		$i = 0;
		foreach($student_info as $info){
			$temp_array[$info['session']][$info['gender']] = $info['total_student'];
		}

		foreach($temp_array as $key=>$value)
		{
			$session_wise_student[$i]['session'] = $key;

			if(isset($value['Male']))
				$session_wise_student[$i]['male'] = $value['Male'];
			else
				$session_wise_student[$i]['male'] = 0;

			if(isset($value['Female']))		
				$session_wise_student[$i]['female'] = $value['Female'];
			else
				$session_wise_student[$i]['female'] = 0;

			$i++;
		}

		$data['session_wise_data'] = json_encode($session_wise_student);


		// library information ************************************************************************


		//Start of Section(total_book): For calculation Total number of Books.
        $table_total_book = 'library_book_info';
        $where_total_book['where'] = array('deleted'=>'0');
        $info_total_book = $this->basic->get_data($table_total_book, $where_total_book);
        $data['num_of_book'] = count($info_total_book);

           //End of Section(total_book).

           //Start of Section(circulation): For calculation Total number of Issued Books.

        $table_circulation = 'circulation';
        $info_ciculation = $this->basic->get_data($table_circulation, $where_circulation='');
        $num_issue_book = count($info_ciculation);

            // echo "num_issue_book: ".$num_issue_book."<br/>";
        $data['num_issue_book'] = $num_issue_book;

           //End of Section(circulation).


           //Start of Section(add_book today).

        $table_add_book_today = 'library_book_info';
        $today_date = date('Y-m-d');
        $where_add_book_today['where'] = array('deleted'=>'0',"Date_Format(add_date,'%Y-%m-%d')"=>$today_date);
        $info_add_book_today = $this->basic->get_data($table_add_book_today, $where_add_book_today);
        $num_add_book_today = count($info_add_book_today);
            // echo "num_add_book_today: ".$num_add_book_today."<br/>";
        $data['num_add_book_today'] = $num_add_book_today;
           //End of Section(add_book today).



           //Start Section(today_issue & today_return).
        $table_today_issue_return = 'circulation';
        $where_today_issue['where'] = array('issue_date'=>$today_date);
        $where_today_return['where'] = array('return_date'=>$today_date);

        $info_today_issue = $this->basic->get_data($table_today_issue_return, $where_today_issue);
        $info_today_return = $this->basic->get_data($table_today_issue_return, $where_today_return);

        $num_today_issue_book = count($info_today_issue);
            // echo "num_today_issue_book: ".$num_today_issue_book."<br/>";
        $data['num_today_issue_book'] = $num_today_issue_book;


        $num_today_return_book = count($info_today_return);
            // echo "num_today_return_book: ".$num_today_return_book."<br/>";
        $data['num_today_return_book'] = $num_today_return_book;
           //End Section(today_issue & today_return).


            //Start of Section(add_book this_month).

        $table_add_book_this_month = 'library_book_info';
        $first_day_this_month = date('Y-m-01');
        $num_days_this_month = date('t');
        $last_day_this_month  = date("Y-m-$num_days_this_month");
        $where_add_book_this_month['where'] = array('deleted'=>'0',"Date_Format(add_date,'%Y-%m-%d') >="=>$first_day_this_month,"Date_Format(add_date,'%Y-%m-%d') <= "=>$last_day_this_month);
        $info_add_book_this_month = $this->basic->get_data($table_add_book_this_month, $where_add_book_this_month);
        $num_add_book_this_month = count($info_add_book_this_month);
            // echo "num_add_book_this_month: ".$num_add_book_this_month."<br/>";
        $data['num_add_book_this_month'] = $num_add_book_this_month;

           //End of Section(add_book this_month).

           //Start of Section(issue_book_this_month).

        $table_issue_return_book_this_month = 'circulation';
        $first_day_this_month = date('Y-m-01');
        $num_days_this_month = date('t');
        $last_day_this_month  = date("Y-m-$num_days_this_month");

        $where_issue_book_this_month['where'] = array("issue_date >="=>$first_day_this_month,"issue_date <= "=>$last_day_this_month);
        $info_issue_book_this_month = $this->basic->get_data($table_issue_return_book_this_month, $where_issue_book_this_month);
        $num_issue_book_this_month = count($info_issue_book_this_month);
            // echo "num_issue_book_this_month: ".$num_issue_book_this_month."<br/>";
        $data['num_issue_book_this_month'] = $num_issue_book_this_month;

        $where_return_book_this_month['where'] = array("return_date >="=>$first_day_this_month,"return_date <= "=>$last_day_this_month,'is_returned'=>'1');
        $info_return_book_this_month = $this->basic->get_data($table_issue_return_book_this_month, $where_return_book_this_month);
        $num_return_book_this_month = count($info_return_book_this_month);
            // echo "num_return_book_this_month: ".$num_return_book_this_month."<br/>";
        $data['num_return_book_this_month'] = $num_return_book_this_month;

           //Start of Section(issue_book_this_month).



            // bar chart
        $year = date('Y')-1;
        $last_issue_year = date("$year-m-d");

        $where['where'] = array('issue_date >=' => $last_issue_year);
        $order_by = "issue_date ASC";
        $results = $this->basic->get_data('circulation', $where, $select='', $join='', $limit='', $start=null, $order_by);

        $issued = 0;
        $returned = 0;

        $month_year_array=array();

        foreach ($results as $result) {
            $issue_month = date('M', strtotime($result['issue_date']));
            $issue_year = date('Y', strtotime($result['issue_date']));

            $return_month = date('M', strtotime($result['return_date']));
            $return_year = date('Y', strtotime($result['return_date']));

            if (isset($issue[$issue_month][$issue_year])) {
                $issue[$issue_month][$issue_year] += 1;
            } else {
                $issue[$issue_month][$issue_year]=1;
            }



            if ($result['is_returned']==1) {
                if (isset($return[$return_month][$return_year])) {
                    $return[$return_month][$return_year] += 1;
                } else {
                    $return[$return_month][$return_year]=1;
                }

                if (isset($issue[$return_month][$return_year])) {
                    $issue[$return_month][$return_year] += 0;
                } else {
                    $issue[$return_month][$return_year]=0;
                }
            } else {
                if (isset($return[$return_month][$return_year])) {
                    $return[$return_month][$return_year] += 0;
                } else {
                    $return[$return_month][$return_year]=0;
                }
            }
        }

        $chart_array=array();

        $cur_year=date('Y');
        $cur_month=date('m');
        $cur_month=(int)$cur_month;
        $months_name = array(1=>'Jan', 2=>'Feb', 3=>'Mar', 4=>'Apr', 5=>'May', 6=>'Jun', 7=>'Jul', 8=>'Aug', 9=>'Sep', 10=>'Oct', 11=>'Nov', 12=>'Dec');
        $months_name_full = array(1=>'January', 2=>'February', 3=>'March', 4=>'April', 5=>'May', 6=>'June', 7=>'July', 8=>'August', 9=>'September', 10=>'October', 11=>'November', 12=>'December');

        for ($i=0;$i<=11;$i++) {
            $m=$months_name[$cur_month];
            $m_dis=$this->lang->line("cal_".strtolower($months_name_full[$cur_month]));
            $chart_array[$i]['year']=$m_dis."-".$cur_year;

            if (isset($issue[$m][$cur_year])) {
                $chart_array[$i]['total_issue']=$issue[$m][$cur_year];
            } else {
                $chart_array[$i]['total_issue']=0;
            }
            if (isset($return[$m][$cur_year])) {
                $chart_array[$i]['total_return']=$return[$m][$cur_year];
            } else {
                $chart_array[$i]['total_return']=0;
            }

            $cur_month=$cur_month-1;
            if ($cur_month==0) {
                $cur_month=12;
                $cur_year=$cur_year-1;
            }
        }

        $chart_array=array_reverse($chart_array);


            //data for circle chart
        $data['total_issued'] = $this->basic->get_data('circulation', $where='', $select=array('count(id) as total_issued'));
        $data['not_returned'] = $this->basic->get_data('circulation', $where=array('where'=>array('is_expired'=>'1')), $select=array('count(id) as not_returned'));

        $data['chart_bar'] = $chart_array;

		
		$this->_viewcontroller($data);
		
	}
	
	




}
