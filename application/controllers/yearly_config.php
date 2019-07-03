<?php 
require_once("home.php");

class Yearly_config extends Home {

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
		$this->session();
	}

	public function session($error=0)
	{	
		// ################################################# ///
		$dataTable = array(
			"class_routine"		=>	"Class Routine", 
			"course"			=>	"Course", 
			"result_exam_name"	=>	"Result Exam Name",
			"slip"				=>	"Slip"
		);

		$data['dataInfo'] = $dataTable;
		$data['form'] = $this->get_sessions();
		$data['to'] = $this->get_sessions();

		// ################################################# ///
		$data['page_title'] = $this->lang->line('yearly config');
		$data['body'] = 'admin/yearly_config/session';
		if($error==1) $data['error'] = 'Already configured.';
		$this->_viewcontroller($data);
	}


	public function session_action()
	{	
		if($_POST['data'] == 'slip'){
			$table_name = $_POST['data'];
			$form_financial = $_POST['form_session'];
			$to_financial = $_POST['to_session'];

			$table = $table_name;
			$where = array('where' => array('financial_year_id' => $to_financial));
			$results=$this->basic->get_data($table,$where,$select='',$join='',$limit='',$start='',$order_by='id asc',$group_by='',$num_rows=0);
		
			$numberOfRow = count($results);
			if($numberOfRow > 0){
				return $this->session($error=1);
			}else{
				unset($results);
				$data = array();
				$table = $table_name;
				$where = array('where' => array('financial_year_id' => $form_financial));
				$results = $this->basic->get_data($table,$where,$select='',$join='',$limit='',$order_by='id asc',$group_by='',$num_rows=0);

				$arrayLen = count($results);
				for($i=0; $i<$arrayLen; $i++){
					unset($slip_id,$slip_id_head,$slip_id_head_array);
					$slip_id = $results[$i]['id'];
					unset($results[$i]['id']);
					$results[$i]['financial_year_id'] = $to_financial;
					$data = array(
   						'slip_name'      	=> $results[$i]['slip_name'],
   						'class_id'       	=> $results[$i]['class_id'],
   						'dept_id'        	=> $results[$i]['dept_id'],
   						'slip_type'      	=> $results[$i]['slip_type'],
   						'financial_year_id' => $results[$i]['financial_year_id'],
   						'total_amount' 		=> $results[$i]['total_amount']
					);
					$this->db->insert('slip', $data);
					$slip_id_head = $this->db->insert_id();
	
					$slip_id_head_array = $this->db->query('SELECT * FROM `slip_head` WHERE `slip_id` IN("'.$slip_id.'")')->result_array();
	
					$slip_id_head_array_final = array();
					$slip_id_head_array_len = count($slip_id_head_array);
					for ($j=0; $j<$slip_id_head_array_len; $j++) { 
						unset($slip_id_head_array[$j]['id']);
						$slip_id_head_array[$j]['slip_id'] = $slip_id_head;
					}
					if(!empty($slip_id_head_array)){
						$this->db->insert_batch('slip_head',$slip_id_head_array);
					}
				}
			
				$arrayName = array('complete_success' => $this->lang->line('successfully transfer session data'));
				$this->session->set_userdata($arrayName);
				return $this->session();
			}
		}else{

			$table_name = $_POST['data'];
			$form_session = $_POST['form_session'];
			$to_session = $_POST['to_session'];
	
			$courses=array();
			$table= $table_name;
			$where=array('where'=>array('session_id'=>$to_session));
			$results=$this->basic->get_data($table,$where,$select='',$join='',$limit='',$start='',$order_by='id asc',$group_by='',$num_rows=0);
			
			$numberOfRow = count($results);
	
			if($numberOfRow>0){			
				return $this->session($error=1);
			}else{
			unset($results);
			$data = array();
			$table = $table_name;
			$where = array('where'=>array('session_id' => $form_session));
			$results = $this->basic->get_data($table,$where,$select='',$join='',$limit='',$order_by='id asc',$group_by='',$num_rows=0);
			
			$arrayLen = count($results);

			for ($i=0; $i < $arrayLen; $i++) {
				unset($results[$i]['id']); 
				$results[$i]['session_id'] = $to_session;
			}
			$this->db->insert_batch($table_name, $results);
			$arrayName = array('complete_success' => 'Successfully transfer session data');
			$this->session->set_userdata($arrayName);
			return $this->session(); 
			}
		}
	}


	function get_sessions()  
	{
		$sessions=array();
		$table='session';		
		$select=array('id','name');	
		$results=$this->basic->get_data($table,$where='',$select,$join='',$limit='',$start='',$order_by='name desc',$group_by='',$num_rows=0);
		foreach ($results as $row) 
		{
			$sessions[$row['id']]=$row['name'];
		}
		return $sessions;
	}

	public function financial_data($error=0){

		// ################################################# ///
		$dataTable = array("slip"=>"Slip");

		$data['dataInfo'] = $dataTable;
		$data['form'] = $this->get_financals();
		$data['to'] = $this->get_active_financial_year();

		// ################################################# ///
		$data['page_title'] = $this->lang->line('yearly config');
		$data['body'] = 'admin/yearly_config/financial';
		if($error==1) $data['error'] = 'Already configured.';
		$this->_viewcontroller($data);

	}

	public function financial_data_action()
	{	
		$table_name = $_POST['data'];
		$form_financial = $_POST['form_session'];
		$to_financial = $_POST['to_session'];

		$table = $table_name;
		$where = array('where' => array('financial_year_id' => $to_financial));
		$results=$this->basic->get_data($table,$where,$select='',$join='',$limit='',$start='',$order_by='id asc',$group_by='',$num_rows=0);
		
		$numberOfRow = count($results);
		if($numberOfRow > 0){
			return $this->financial_data($error=1);
		}else{
			unset($results);
			$data = array();
			$table = $table_name;
			$where = array('where' => array('financial_year_id' => $form_financial));
			$results = $this->basic->get_data($table,$where,$select='',$join='',$limit='',$order_by='id asc',$group_by='',$num_rows=0);

			$arrayLen = count($results);
			for($i=0; $i<$arrayLen; $i++){
				unset($slip_id,$slip_id_head,$slip_id_head_array);
				$slip_id = $results[$i]['id'];
				unset($results[$i]['id']);
				$results[$i]['financial_year_id'] = $to_financial;
				$data = array(
   					'slip_name'      	=> $results[$i]['slip_name'],
   					'class_id'       	=> $results[$i]['class_id'],
   					'dept_id'        	=> $results[$i]['dept_id'],
   					'slip_type'      	=> $results[$i]['slip_type'],
   					'financial_year_id' => $results[$i]['financial_year_id'],
   					'total_amount' 		=> $results[$i]['total_amount']
				);
				$this->db->insert('slip', $data);
				$slip_id_head = $this->db->insert_id();

				$slip_id_head_array = $this->db->query('SELECT * FROM `slip_head` WHERE `slip_id` IN("'.$slip_id.'")')->result_array();

				$slip_id_head_array_final = array();
				$slip_id_head_array_len = count($slip_id_head_array);
				for ($j=0; $j<$slip_id_head_array_len; $j++) { 
					unset($slip_id_head_array[$j]['id']);
					$slip_id_head_array[$j]['slip_id'] = $slip_id_head;
				}
				if(!empty($slip_id_head_array)){
					$this->db->insert_batch('slip_head',$slip_id_head_array);
				}
			}
			
			$arrayName = array('complete_success' => 'Successfully transfer financial data');
			$this->session->set_userdata($arrayName);
			return $this->financial_data();
		}
	}
}