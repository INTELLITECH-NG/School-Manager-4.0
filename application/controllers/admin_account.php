<?php 
require_once("home.php");

class Admin_account extends Home {


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
	$this->brief();
}


public function student_wise(){
	if(!in_array(25,$this->role_modules))  
	redirect('home/access_forbidden','location');		
	if(!in_array(1,$this->role_module_accesses_25))
	redirect('home/access_forbidden','location');

	$data['body']='admin/report/account/student_wise';

	$data['classes'] = $this->get_classes();

	$data['payment_type'] =$this->get_slip_types();
	
	if($_POST)
	{
		$search_name = $this->input->post('name');
		$search_class = $this->input->post('classes');
		$search_payment_type = $this->input->post('payment_type');
		$search_to_date = $this->input->post('to_date');
		$search_from_date = $this->input->post('from_date');
	
		$this->session->set_userdata('accounts_report_student_wise_search_name',$search_name);
		$this->session->set_userdata('accounts_report_student_wise_search_class',$search_class);
		$this->session->set_userdata('accounts_report_student_wise_search_payment_type',$search_payment_type);
		$this->session->set_userdata('accounts_report_student_wise_search_from_date',$search_from_date);
		$this->session->set_userdata('accounts_report_student_wise_search_to_date',$search_to_date);
	}

	$search_name=$this->session->userdata('accounts_report_student_wise_search_name');
	$search_class=$this->session->userdata('accounts_report_student_wise_search_class');
	$search_payment_type=$this->session->userdata('accounts_report_student_wise_search_payment_type');
	$search_from_date=$this->session->userdata('accounts_report_student_wise_search_from_date');
	$search_to_date =$this->session->userdata('accounts_report_student_wise_search_to_date');

	$where=array();

	if($search_from_date!="") {
		$search_from_date = date("Y-m-d",strtotime($search_from_date));
		$where['where']['DATE_FORMAT(date_time,"%Y-%m-%d") >=']=$search_from_date;
	}
	if($search_to_date!="") {
		$search_to_date = date("Y-m-d",strtotime($search_to_date));
		$where['where']['DATE_FORMAT(date_time,"%Y-%m-%d") <=']=$search_to_date;
	}


	if($search_name !='')
	$where['where']['name LIKE ']="%$search_name%";		

	if($search_class !='')
	$where['where']['class_id']=$search_class;	

	if($search_payment_type !='')
	$where['where']['payment_type']=$search_payment_type;	

		
	
			
	$select=array("name","heads_name","total_amount_2", "slip_amount");		

	$table = 'view_transaction_details';

	$total_rows_array= $this->basic->get_data($table,$where,$select,$join='',$limit='',$start='',$order_by='name asc',$group_by='student_info_id');

	
	$total_result=count($total_rows_array);	
	
	$config = array();
    $config["base_url"] = site_url() . "admin_account/student_wise";
    $config["total_rows"] = $total_result;
    $config["per_page"] = 30;
    $config["uri_segment"] = 3;
	$config['prev_link'] = '<<';
    $config['next_link'] = '>>';
	$config['num_links'] = 5;

    $this->pagination->initialize($config);

    $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
   
   // $data['info'] = $this->basic->get_data($table,$where,$select='',$join='',$limit=$config["per_page"],$start=$page,$order_by='date_time asc');
    $data['info_concat'] = $this->basic->get_data($table,$where,$select,$join='',$limit=$config["per_page"],$start=$page,$order_by='date_time desc',$group_by='student_info_id');
		
    $data["links"] = $this->pagination->create_links();
	$this->_viewcontroller($data);	
}


public function day_wise(){
	if(!in_array(25,$this->role_modules))  
	redirect('home/access_forbidden','location');		
	if(!in_array(1,$this->role_module_accesses_25))
	redirect('home/access_forbidden','location');

	$data['body']='admin/report/account/day_wise';

	$data['classes'] = $this->get_classes();

	$data['payment_type'] =$this->get_slip_types();
	
	if($_POST)
	{
		$search_name = $this->input->post('name');
		$search_class = $this->input->post('classes');
		$search_payment_type = $this->input->post('payment_type');
		$search_to_date = $this->input->post('to_date');
		$search_from_date = $this->input->post('from_date');
	
		$this->session->set_userdata('accounts_report_date_wise_search_name',$search_name);
		$this->session->set_userdata('accounts_report_date_wise_search_class',$search_class);
		$this->session->set_userdata('accounts_report_date_wise_search_payment_type',$search_payment_type);
		$this->session->set_userdata('accounts_report_date_wise_search_from_date',$search_from_date);
		$this->session->set_userdata('accounts_report_date_wise_search_to_date',$search_to_date);
	}

	$search_name=$this->session->userdata('accounts_report_date_wise_search_name');
	$search_class=$this->session->userdata('accounts_report_date_wise_search_class');
	$search_payment_type=$this->session->userdata('accounts_report_date_wise_search_payment_type');
	$search_from_date=$this->session->userdata('accounts_report_date_wise_search_from_date');
	$search_to_date =$this->session->userdata('accounts_report_date_wise_search_to_date');

	$where=array();

	if($search_from_date!="") {
		$search_from_date = date("Y-m-d",strtotime($search_from_date));
		$where['where']['DATE_FORMAT(date_time,"%Y-%m-%d") >=']=$search_from_date;
	}
	if($search_to_date!="") {
		$search_to_date = date("Y-m-d",strtotime($search_to_date));
		$where['where']['DATE_FORMAT(date_time,"%Y-%m-%d") <=']=$search_to_date;
	}


	if($search_name !='')
	$where['where']['name LIKE ']="%$search_name%";		

	if($search_class !='')
	$where['where']['class_id']=$search_class;	

	if($search_payment_type !='')
	$where['where']['payment_type']=$search_payment_type;	

		
	
			
	$select=array("date_time","heads_name","total_amount_2", "slip_amount");

	$table = 'view_transaction_details';

	$total_rows_array= $this->basic->get_data($table,$where,$select,$join='',$limit='',$start='',$order_by='date_time desc',$group_by='date_time');

	$total_result=count($total_rows_array);	
	
	$config = array();
    $config["base_url"] = site_url() . "admin_account/day_wise";
    $config["total_rows"] = $total_result;
    $config["per_page"] = 30;
    $config["uri_segment"] = 3;
	$config['prev_link'] = '<<';
    $config['next_link'] = '>>';
	$config['num_links'] = 5;

    $this->pagination->initialize($config);

    $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
   
   // $data['info'] = $this->basic->get_data($table,$where,$select='',$join='',$limit=$config["per_page"],$start=$page,$order_by='date_time asc');
    $data['info_concat'] = $this->basic->get_data($table,$where,$select,$join='',$limit=$config["per_page"],$start=$page,$order_by='date_time desc',$group_by='date_time');
		
    $data["links"] = $this->pagination->create_links();

	$this->_viewcontroller($data);		
}


public function brief()
{
	if(!in_array(25,$this->role_modules))  
	redirect('home/access_forbidden','location');		
	if(!in_array(1,$this->role_module_accesses_25))
	redirect('home/access_forbidden','location');

	$data['body']='admin/report/account/brief';

	$data['classes'] = $this->get_classes();

	$data['payment_type'] =$this->get_slip_types();
	
	if($_POST)
	{
		$search_name = $this->input->post('name');
		$search_class = $this->input->post('classes');
		$search_payment_type = $this->input->post('payment_type');
		$search_to_date = $this->input->post('to_date');
		$search_from_date = $this->input->post('from_date');
	
		$this->session->set_userdata('accounts_report_brief_search_name',$search_name);
		$this->session->set_userdata('accounts_report_brief_search_class',$search_class);
		$this->session->set_userdata('accounts_report_brief_search_payment_type',$search_payment_type);
		$this->session->set_userdata('accounts_report_brief_search_from_date',$search_from_date);
		$this->session->set_userdata('accounts_report_brief_search_to_date',$search_to_date);
	}

	$search_name=$this->session->userdata('accounts_report_brief_search_name');
	$search_class=$this->session->userdata('accounts_report_brief_search_class');
	$search_payment_type=$this->session->userdata('accounts_report_brief_search_payment_type');
	$search_from_date=$this->session->userdata('accounts_report_brief_search_from_date');
	$search_to_date =$this->session->userdata('accounts_report_brief_search_to_date');

	
	$where=array();

	if($search_from_date!="") {
		$search_from_date = date("Y-m-d",strtotime($search_from_date));
		$where['where']['DATE_FORMAT(date_time,"%Y-%m-%d") >=']=$search_from_date;
	}
	if($search_to_date!="") {
		$search_to_date = date("Y-m-d",strtotime($search_to_date));
		$where['where']['DATE_FORMAT(date_time,"%Y-%m-%d") <=']=$search_to_date;
	}


	if($search_name !='')
	$where['where']['name LIKE ']="%$search_name%";		

	if($search_class !='')
	$where['where']['class_id']=$search_class;	

	if($search_payment_type !='')
	$where['where']['payment_type']=$search_payment_type;	

	$table = 'view_transaction_details';

	$data['total_rows_array'] = $this->basic->get_data($table,$where,'total_amount_2');
	$total_result=count($data['total_rows_array']);

	$config = array();
    $config["base_url"] = site_url() . "admin_account/brief";
    $config["total_rows"] = $total_result;
    $config["per_page"] = 30;
    $config["uri_segment"] = 3;
	$config['prev_link'] = '<<';
    $config['next_link'] = '>>';
	$config['num_links'] = 5;

    $this->pagination->initialize($config);

    $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
   
    $data['info'] = $this->basic->get_data($table,$where,$select='',$join='',$limit=$config["per_page"],$start=$page,$order_by='');

    // echo $this->db->last_query(); exit();
  
    $data["links"] = $this->pagination->create_links();

	$this->_viewcontroller($data);	
}


public function brief_download()
{

	$search_name=$this->session->userdata('accounts_report_brief_search_name');
	$search_class=$this->session->userdata('accounts_report_brief_search_class');
	$search_payment_type=$this->session->userdata('accounts_report_brief_search_payment_type');
	$search_from_date=$this->session->userdata('accounts_report_brief_search_from_date');
	$search_to_date =$this->session->userdata('accounts_report_brief_search_to_date');

	$where=array();

	if($search_from_date!="") {
		$search_from_date = date("Y-m-d",strtotime($search_from_date));
		$where['where']['DATE_FORMAT(date_time,"%Y-%m-%d") >=']=$search_from_date;
	}
	if($search_to_date!="") {
		$search_to_date = date("Y-m-d",strtotime($search_to_date));
		$where['where']['DATE_FORMAT(date_time,"%Y-%m-%d") <=']=$search_to_date;
	}

	if($search_name !='')
	$where['where']['name LIKE ']="%$search_name%";		

	if($search_class !='')
	$where['where']['class_id']=$search_class;	

	if($search_payment_type !='')
	$where['where']['payment_type']=$search_payment_type;	

	$table = 'view_transaction_details';

	$total_rows_array = $this->basic->get_data($table,$where,'total_amount_2');
	$total_result=count($total_rows_array);
   
    $data['info'] = $this->basic->get_data($table,$where,$select='',$join='',$limit='',$start='',$order_by='');
    

      $fp=fopen("download/report/brief_report.csv","w");
      $head=array("SL","NAME","CLASS","ACCOUNTS HEADS","AMOUNT","TOTAL AMOUNT","PAYMENT TYPE","DATE");
      fputcsv($fp,$head);
      $write_info=array();

        $sum = 0; 
        $serial_count =0;                       
         foreach ($data['info'] as  $value) 
             {
               $serial_count++;
               $count =$this->uri->segment(3);
               $sl = $count + $serial_count; 
              
              for($i=0;$i<=$count;$i++){
                   $sum = $sum + $total_rows_array[$i]['total_amount_2'];
                  }

                      $write_info['sl'] = $sl;
                      $write_info['name'] = $value['name'];
                      $write_info['class_name'] = $value['class_name'];
                      $write_info['heads_name'] = $value['heads_name'];
                      $write_info['total_amount_2'] = $value['total_amount_2'];
                      $write_info['sum'] = $sum;
                      $write_info['payment_type'] = $value['payment_type'];
                      $write_info['date_time'] = $value['date_time'];

                      fputcsv($fp,$write_info);                             
            }   

       fclose($fp);
       $data['file_name']="download/report/brief_report.csv";
       $this->load->view('page/download',$data); 
}

public function student_wise_download()
{

   $search_name=$this->session->userdata('accounts_report_date_wise_search_name');
	$search_class=$this->session->userdata('accounts_report_date_wise_search_class');
	$search_payment_type=$this->session->userdata('accounts_report_date_wise_search_payment_type');
	$search_from_date=$this->session->userdata('accounts_report_date_wise_search_from_date');
	$search_to_date =$this->session->userdata('accounts_report_date_wise_search_to_date');

	$where=array();

	if($search_from_date!="") {
		$search_from_date = date("Y-m-d",strtotime($search_from_date));
		$where['where']['DATE_FORMAT(date_time,"%Y-%m-%d") >=']=$search_from_date;
	}
	if($search_to_date!="") {
		$search_to_date = date("Y-m-d",strtotime($search_to_date));
		$where['where']['DATE_FORMAT(date_time,"%Y-%m-%d") <=']=$search_to_date;
	}

	if($search_name !='')
	$where['where']['name LIKE ']="%$search_name%";		

	if($search_class !='')
	$where['where']['class_id']=$search_class;	

	if($search_payment_type !='')
	$where['where']['payment_type']=$search_payment_type;	

			
	$select=array("name","heads_name","total_amount_2", "slip_amount");		

	$table = 'view_transaction_details';

	
    $info_concat = $this->basic->get_data($table,$where,$select,$join='',$limit='',$start='',$order_by='name asc',$group_by='name');
   						
    $fp=fopen("download/report/student_wise_report.csv","w");
    $head=array("SL","Name");

    $head_names = explode(',',$info_concat[0]['heads_name']);
    foreach($head_names as $key=>$value)
    {
    	array_push($head, $value);
    }
    array_push($head, 'Total');

    fputcsv($fp,$head);
    $write_info=array();
    $serial_count =0;             

    foreach ($info_concat as $result) 
    { 
    	$serial_count++;
    	$write_info[] = $serial_count;
    	$write_info[] = $result['name'];

    	$head_amounts = explode(',',$result['slip_amount']);
    	foreach($head_amounts as $index=>$amount)
    	{
    		$write_info[] = $amount;
    	}
    	$write_info[] = $result['total_amount_2'];

    	fputcsv($fp,$write_info);

    }
    fclose($fp);
    $data['file_name']="download/report/student_wise_report.csv";
    $this->load->view('page/download',$data);

}


public function day_wise_download()

{
   $search_name=$this->session->userdata('accounts_report_date_wise_search_name');
	$search_class=$this->session->userdata('accounts_report_date_wise_search_class');
	$search_payment_type=$this->session->userdata('accounts_report_date_wise_search_payment_type');
	$search_from_date=$this->session->userdata('accounts_report_date_wise_search_from_date');
	$search_to_date =$this->session->userdata('accounts_report_date_wise_search_to_date');


	$where=array();

	if($search_from_date!="") {
		$search_from_date = date("Y-m-d",strtotime($search_from_date));
		$where['where']['DATE_FORMAT(date_time,"%Y-%m-%d") >=']=$search_from_date;
	}
	if($search_to_date!="") {
		$search_to_date = date("Y-m-d",strtotime($search_to_date));
		$where['where']['DATE_FORMAT(date_time,"%Y-%m-%d") <=']=$search_to_date;
	}

	if($search_name !='')
	$where['where']['name LIKE ']="%$search_name%";		

	if($search_class !='')
	$where['where']['class_id']=$search_class;	

	if($search_payment_type !='')
	$where['where']['payment_type']=$search_payment_type;	

			
	$select=array("date_time","heads_name","total_amount_2", "slip_amount");

	$table = 'view_transaction_details';

	
   $info_concat = $this->basic->get_data($table,$where,$select,$join='',$limit='',$start='',$order_by='date_time desc',$group_by='date_time');

   $fp=fopen("download/report/date_wise_report.csv","w");
   $head=array("SL","Date");
   $head_names = explode(',',$info_concat[0]['heads_name']);
    foreach($head_names as $key=>$value)
    {
    	array_push($head, $value);
    }
    array_push($head, 'Total');
   fputcsv($fp,$head);
   $write_info=array();
                 

   $serial_count =0;             

    foreach ($info_concat as $result) 
    { 
    	$serial_count++;
    	$write_info[] = $serial_count;
    	$write_info[] = $result['date_time'];

    	$head_amounts = explode(',',$result['slip_amount']);
    	foreach($head_amounts as $index=>$amount)
    	{
    		$write_info[] = $amount;
    	}
    	$write_info[] = $result['total_amount_2'];

    	fputcsv($fp,$write_info);
    }

   fclose($fp);
   $data['file_name']="download/report/date_wise_report.csv";
   $this->load->view('page/download',$data);
}



public function form_fees_report(){
	if(!in_array(26,$this->role_modules))  
	redirect('home/access_forbidden','location');		
	if(!in_array(1,$this->role_module_accesses_26))
	redirect('home/access_forbidden','location');

	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'admission_roll';
	$order = isset($_POST['order']) ? strval($_POST['order']) : 'ASC';
	$order_by_str=$sort." ".$order;
	
	$admission_roll=$this->input->post('admission_roll');
	$class_id=$this->input->post('class_id');
	$financial_year_id=$this->input->post('financial_year_id');
	$dept_id=$this->input->post('dept_id');
	$shift_id=$this->input->post('shift_id');
	$applicant_name = $this->input->post('applicant_name');
	$applicant_id = $this->input->post('applicant_id');
	$is_searched= $this->input->post('is_searched');
	
	if($is_searched)
	{		
		$this->session->set_userdata('online_students_data_admission_roll',$admission_roll);
		$this->session->set_userdata('online_students_data_class_id',$class_id);
		$this->session->set_userdata('online_students_data_financial_year_id',$financial_year_id);
		$this->session->set_userdata('online_students_data_dept_id',$dept_id);
		$this->session->set_userdata('online_students_data_shift_id',$shift_id);
		$this->session->set_userdata('online_students_data_applicant_name',$applicant_name);
		$this->session->set_userdata('online_students_data_applicant_id',$applicant_id);
	}
			
	$search_admission_roll=$this->session->userdata('online_students_data_admission_roll');			
	$search_class_id=$this->session->userdata('online_students_data_class_id');			
	$search_financial_year_id=$this->session->userdata('online_students_data_financial_year_id');			
	$search_dept_id=$this->session->userdata('online_students_data_dept_id');			
	$search_shift_id=$this->session->userdata('online_students_data_shift_id');				
	$search_applicant_name=$this->session->userdata('online_students_data_applicant_name');	
	$search_applicant_id=$this->session->userdata('online_students_data_applicant_id');	

		
	$where_simple=array();
	
	if($search_admission_roll)
		$where_simple['admission_roll']=$search_admission_roll;
	if($search_applicant_name)
		$where_simple['name like'] = "%".$search_applicant_name."%";
	if($search_applicant_id)
		$where_simple['id'] = $search_applicant_id;
	if($search_class_id)
		$where_simple['class_id']=$search_class_id;
	if($search_financial_year_id)
		$where_simple['session_id']=$search_financial_year_id;
	if($search_dept_id)
		$where_simple['dept_id']=$search_dept_id;
	if($search_shift_id)
		$where_simple['shift_id']=$search_shift_id;
	

	$where_simple['deleted']="0";
	$w = "is_in_merit_list is NULL";
	$this->db->where($w);
			
	$where=array('where'=>$where_simple);			
	$offset = ($page-1)*$rows;
	$result = array();		
	// print_r($where_simple);		
				
	$info=$this->basic->get_data('view_applicant_info',$where,$select='',$join='',$limit=$rows,$start=$offset,$order_by=$order_by_str,$group_by='',$num_rows=1);

	$total_rows_array=$this->basic->count_row($table="view_applicant_info",$where,$count="view_applicant_info.id",$join='');
	$total_result=$total_rows_array[0]['total_rows'];
	echo convert_to_grid_data($info,$total_result);
}


public function csv_download(){
	$search_admission_roll=$this->session->userdata('online_students_data_admission_roll');			
	$search_class_id=$this->session->userdata('online_students_data_class_id');			
	$search_financial_year_id=$this->session->userdata('online_students_data_financial_year_id');			
	$search_dept_id=$this->session->userdata('online_students_data_dept_id');			
	$search_shift_id=$this->session->userdata('online_students_data_shift_id');				
	$search_applicant_name=$this->session->userdata('online_students_data_applicant_name');	
	$search_applicant_id=$this->session->userdata('online_students_data_applicant_id');	

		
	$where_simple=array();
	
	if($search_admission_roll)
		$where_simple['admission_roll']=$search_admission_roll;
	if($search_applicant_name)
		$where_simple['name like'] = "%".$search_applicant_name."%";
	if($search_applicant_id)
		$where_simple['id'] = $search_applicant_id;
	if($search_class_id)
		$where_simple['class_id']=$search_class_id;
	if($search_financial_year_id)
		$where_simple['session_id']=$search_financial_year_id;
	if($search_dept_id)
		$where_simple['dept_id']=$search_dept_id;
	if($search_shift_id)
		$where_simple['shift_id']=$search_shift_id;	

	$where_simple['deleted']="0";
	$w = "is_in_merit_list is NULL";
	$this->db->where($w);
			
	$where=array('where'=>$where_simple);	
				
	$info=$this->basic->get_data('view_applicant_info',$where,$select='');

      $fp=fopen("download/report/from_cell_report.csv","w");
      fprintf($fp, chr(0xEF).chr(0xBB).chr(0xBF)); // for unicode chars
      $head=array($this->lang->line("sl"),$this->lang->line("name"),$this->lang->line("class"),$this->lang->line("department"),$this->lang->line("session"),$this->lang->line("amount"));
      fputcsv($fp,$head);
      $write_info=array();

      
        $serial_count =0;                       
         foreach ($info as  $value) 
            {
               $serial_count++;

                      $write_info['sl'] = $serial_count;
                      $write_info['name'] = $value['name'];
                      $write_info['class_name'] = $value['class_name'];
                      $write_info['dept_name'] = $value['dept_name'];
                      $write_info['session_name'] = $value['session_name'];                      
                      $write_info['paid_amount'] = $value['paid_amount'];                    

                      fputcsv($fp,$write_info);                            
            }   

       fclose($fp);
       $data['file_name']="download/report/from_cell_report.csv";
       $this->load->view('page/download',$data); 
	}
}