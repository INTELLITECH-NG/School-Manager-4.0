<?php 
require_once("home.php");

class Admin extends Home {

	function __construct()
	{
		parent::__construct();

		if($this->session->userdata('logged_in')!=1)
		redirect('home/login','location');

		if($this->session->userdata('user_type')!='Operator')
		redirect('home/login','location');

		$this->important_feature();
        $this->periodic_check();

	}


	public function index()
	{		
		$this->_viewcontroller();
	}

	
	public function roles()
	{
		if(!in_array(1,$this->role_modules))  
		redirect('home/access_forbidden','location');	
		$data['body']='admin/role/roles';
		$this->_viewcontroller($data);	
	}

	public function roles_data()
	{			
		if(!in_array(1,$this->role_modules))  
		redirect('home/access_forbidden','location');

		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 5;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'name';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'ASC';
		$order_by_str=$sort." ".$order;
		
		$role_name=$this->input->post('name');
		$is_searched= $this->input->post('is_searched');
		
		if($is_searched)
		{		
			$this->session->set_userdata('roles_role_name',$role_name);
		}
				
		$search_role_name=$this->session->userdata('roles_role_name');			
			
		$where_simple=array("editable"=>"1");
		
		if($search_role_name)
		$where_simple['name like']='%'.$search_role_name.'%';
				
		$where=array('where'=>$where_simple);			
		$offset = ($page-1)*$rows;
		$result = array();		
				
		$info=$this->basic->get_data('roles',$where,$select='',$join='',$limit=$rows,$start=$offset,$order_by=$order_by_str,$group_by='',$num_rows=1);
		$total_rows_array=$this->basic->count_row($table="roles",$where,$count="roles.id",$join='');
		$total_result=$total_rows_array[0]['total_rows'];
			
		echo convert_to_grid_data($info,$total_result);

	}


	public function add_role()
	{		
		if(!in_array(1,$this->role_modules))  
		redirect('home/access_forbidden','location');		
		if(!in_array(2,$this->role_module_accesses_1))
		redirect('home/access_forbidden','location');

		$data['body']='admin/role/add_role';		
			
		$data['modules']=$this->basic->get_data('modules',$where='',$select='',$join='',$limit='',$start='',$order_by='name asc',$group_by='',$num_rows=0);
		
		$classes=$this->basic->get_data('class',$where='',$select='',$join='',$limit='',$start='',$order_by='ordering asc',$group_by='',$num_rows=0);
		foreach($classes as $class)
		$data['centers'][$class['class_name']]=$this->basic->get_data('department',$where=array('where'=>array('class_id'=>$class['id'])),$select=array('department.dept_name','department.id as dept_id','class.class_name'),$join=array('class'=>"class.id=department.class_id,left"),$limit='',$start='',$order_by='dept_name asc',$group_by='',$num_rows=0);
		
		$data['accesses']=$this->basic->get_data('accesses',$where='',$select='',$join='',$limit='',$start='',$order_by='id asc',$group_by='',$num_rows=0);
		
		$this->_viewcontroller($data);
	}


	public function add_role_action() 
	{
		if($_SERVER['REQUEST_METHOD'] === 'GET') 
		redirect('home/access_forbidden','location');

		if(!in_array(1,$this->role_modules))  
		redirect('home/access_forbidden','location');		
		if(!in_array(2,$this->role_module_accesses_1))
		redirect('home/access_forbidden','location');

		if($_POST)
		{
			$this->form_validation->set_rules('name', '<b>'.$this->lang->line('role name').'</b>', 'trim|required|is_unique[roles.name]');	
			$this->form_validation->set_rules('modules','<b>'.$this->lang->line('privilleges').'</b>','required');			
			$this->form_validation->set_rules('centers','<b>'.$this->lang->line('groups / departments').'</b>','required');			
			$this->form_validation->set_rules('status','<b>'.$this->lang->line('status').'</b>','required');			
				
			if ($this->form_validation->run() == FALSE)
			{
				$this->add_role(); 
			}
			else
			{
				$role_name=$this->input->post('name');
				$status=$this->input->post('status');
				
				if(count($this->input->post('modules'))>0)  
				{
					$modules=$this->input->post('modules');							
				}	

				if(count($this->input->post('centers'))>0)  
				{
					$center_array=$this->input->post('centers');							
				}

				$centers_str=implode(',',$center_array);
						
				for($i=0;$i<count($modules);$i++)
				{
					$check_name='check'.$modules[$i];  				
					if($this->input->post($check_name))
					$accesses[$i]=$this->input->post($check_name);				
				}
				
				for($i=0;$i<count($modules);$i++)
				{
					if(!empty($accesses[$i]))
					$accesses_str[$i]=implode(',',$accesses[$i]);
					else
					$accesses_str[$i]='1';		
				}
					
				
				$data=array
				(
					'name'=>$role_name,
					'departments'=>$centers_str,
					'status'=>$status
				);
				
				$this->db->trans_start();
			    $this->basic->insert_data('roles',$data); 										
				$role_id=$this->db->insert_id(); 
				for($i=0;$i<count($modules);$i++)
				{
					$module_to_insert=$modules[$i];
					$access_to_insert=$accesses_str[$i];
					$data=array(
					'role_id'=>$role_id,
					'modules'=>$module_to_insert,
					'accesses'=>$access_to_insert					
					);
					
					$this->basic->insert_data('role_privilleges',$data);						
				}
				$this->db->trans_complete();	
				
				if ($this->db->trans_status() === FALSE)										
				$this->session->set_flashdata('error_message',1);	
				else	
				$this->session->set_flashdata('success_message',1);		
				
				redirect('admin/roles','location');					
				
			}
		}	
	}


	public function details_role($id=0)
	{
		
		if($id==0)
		redirect('home/access_forbidden','location');

		if(!in_array(1,$this->role_modules))  
		redirect('home/access_forbidden','location');		

		$data['body']='admin/role/details_role';

		$table1='modules';		
		$data['modules']=$this->basic->get_data($table1,$where='',$select='',$join='',$limit='',$start='',$order_by='name asc',$group_by='',$num_rows=0);
		

		$table2='accesses';		
		$data['accesses']=$this->basic->get_data($table2,$where='',$select='',$join='',$limit='',$start='',$order_by='id asc',$group_by='',$num_rows=0);
	
		$table3='roles';
		$where_simple1=array('id'=>$id);
		$where1=array('where'=>$where_simple1);	
		$data['xrole_info']=$this->basic->get_data($table3,$where1,$select='',$join='',$limit='',$start='',$order_by='',$group_by='',$num_rows=0);
	
		
		$table4='role_privilleges';
		$select1=array('role_privilleges.modules','role_privilleges.accesses');
		$where_simple2=array('role_id'=>$id);
		$where2=array('where'=>$where_simple2);
		$temp['xrole_privillege']=$this->basic->get_data($table4,$where2,$select1,$join='',$limit='',$start='',$order_by='',$group_by='',$num_rows=0);
	
		$table5='department';	
		$data['centers']=$this->basic->get_data($table5,$where='',$select='',$join='',$limit='',$start='',$order_by='class_id asc',$group_by='',$num_rows=0);
		
		
		for($i=0;$i<count($temp['xrole_privillege']);$i++)  
		{
			$xrole_modules[$i]=$temp['xrole_privillege'][$i]['modules'];
			$xrole_accesses[$xrole_modules[$i]]=$temp['xrole_privillege'][$i]['accesses'];
		}
		
		$data['xmodules']=$xrole_modules;  
		$data['xaccesses']=$xrole_accesses;	
					
		$this->_viewcontroller($data);	
	}


	public function update_role($id=0)
	{		
		if($id==0)
		redirect('home/access_forbidden','location');

		if(!in_array(1,$this->role_modules))  
		redirect('home/access_forbidden','location');		
		if(!in_array(3,$this->role_module_accesses_1))
		redirect('home/access_forbidden','location');

		$data['body']='admin/role/update_role';
		
		$table='modules';		
		$data['modules']=$this->basic->get_data($table,$where='',$select='',$join='',$limit='',$start='',$order_by='name asc',$group_by='',$num_rows=0);
		
		$classes=$this->basic->get_data('class',$where='',$select='',$join='',$limit='',$start='',$order_by='ordering asc',$group_by='',$num_rows=0);
		foreach($classes as $class)
		$data['centers'][$class['class_name']]=$this->basic->get_data('department',$where=array('where'=>array('class_id'=>$class['id'])),$select=array('department.dept_name','department.id as dept_id','class.class_name'),$join=array('class'=>"class.id=department.class_id,left"),$limit='',$start='',$order_by='dept_name asc',$group_by='',$num_rows=0);
		
		$table='accesses';			
		$data['accesses']=$this->basic->get_data($table,$where='',$select='',$join='',$limit='',$start='',$order_by='id asc',$group_by='',$num_rows=0);
		
		$table='role_privilleges';
		$where=array('where'=>array('role_id'=>$id));		
		$xprivilleges=$this->basic->get_data($table,$where,$select='',$join='',$limit='',$start='',$order_by='',$group_by='',$num_rows=0);

		foreach($xprivilleges as $row)
		{
			$xmodules[]=$row['modules'];
			$xaccesses[$row['modules']]=$row['accesses'];
		}

		$table='roles';
		$where=array('where'=>array('id'=>$id));		
		$data['xdata']=$this->basic->get_data($table,$where,$select='',$join='',$limit='',$start='',$order_by='',$group_by='',$num_rows=0);

		$data['xmodules']=$xmodules;
		$data['xaccesses']=$xaccesses;		

		$this->_viewcontroller($data);
	}


	public function update_role_action() 
	{
		if($_SERVER['REQUEST_METHOD'] === 'GET') 
		redirect('home/access_forbidden','location');

		if(!in_array(1,$this->role_modules))  
		redirect('home/access_forbidden','location');		
		if(!in_array(3,$this->role_module_accesses_1))
		redirect('home/access_forbidden','location');

		if($_POST)
		{
			$this->form_validation->set_rules('modules','<b>Privilleges</b>','required');			
			$this->form_validation->set_rules('centers','<b>Groups /  Depts.</b>','required');			
			$this->form_validation->set_rules('status','<b>Status</b>','required');			
			$role_id=$this->input->post('hidden_id');

			if ($this->form_validation->run() == FALSE)
			{
				$this->update_role($role_id); 
			}
			else
			{			
				$status=$this->input->post('status');
				if(count($this->input->post('modules'))>0)  
				{
					$modules=$this->input->post('modules');			
							
				}	

				if(count($this->input->post('centers'))>0)  
				{
					$center_array=$this->input->post('centers');			
							
				}

				$centers_str=implode(',',$center_array);
						
				for($i=0;$i<count($modules);$i++)
				{
					$check_name='check'.$modules[$i];  				
					if($this->input->post($check_name))
					$accesses[$i]=$this->input->post($check_name);				
				}
				
				for($i=0;$i<count($modules);$i++)
				{
					if(!empty($accesses[$i]))
					$accesses_str[$i]=implode(',',$accesses[$i]);
					else
					$accesses_str[$i]='1';		
				}
					
				
				$data1=array
				(
					'departments'=>$centers_str,
					'status'=>$status
				);
				
				
			    $this->db->trans_start();
			    $this->basic->update_data('roles',$where=array('id'=>$role_id),$data1);
				$this->basic->delete_data('role_privilleges',$where=array('role_id'=>$role_id));					
				for($i=0;$i<count($modules);$i++)
				{
					$module_to_update=$modules[$i];
					$access_to_update=$accesses_str[$i];
					$data2=array(
					'role_id'=>$role_id,
					'modules'=>$module_to_update,
					'accesses'=>$access_to_update					
					);
					
					$this->basic->insert_data('role_privilleges',$data2);
						
				}	
				$this->db->trans_complete();

				if ($this->db->trans_status() === FALSE)		
				$this->session->set_flashdata('error_message',1);		
				else
				$this->session->set_flashdata('success_message',1);		
				redirect('admin/roles','location');						
			}
		}	
	}


	public function users()
	{		
		if(!in_array(2,$this->role_modules))  
		redirect('home/access_forbidden','location');		
		$data['body']='admin/user/users';
		$this->_viewcontroller($data);	
	}


	public function users_data()
	{			
		if(!in_array(2,$this->role_modules))  
		redirect('home/access_forbidden','location');

		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 5;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'name';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'ASC';
		$order_by_str=$sort." ".$order;
		
		$username=$this->input->post('username');
		$is_searched= $this->input->post('is_searched');
		
		if($is_searched)
		{		
			$this->session->set_userdata('users_username',$username);
		}
				
		$search_username=$this->session->userdata('users_username');			
			
		$where_simple=array();
		
		if($search_username)
		$where_simple['username like']='%'.$search_username.'%';
				
		$where=array('where'=>$where_simple);			
		$offset = ($page-1)*$rows;
		$result = array();		
				
		
		$table='users';
		$select=array
			(
			'users.*',
			'roles.name as role_name'
			);		
		$join=array('roles'=>"roles.id=users.role_id,left");			
		$info=$this->basic->get_data($table,$where,$select,$join,$limit=$rows,$start=$offset,$order_by=$order_by_str,$group_by='',$num_rows=1);

		$total_rows_array=$this->basic->count_row($table="users",$where,$count="users.id",$join);
		$total_result=$total_rows_array[0]['total_rows'];
			
		echo convert_to_grid_data($info,$total_result);

	}


	public function add_user()
	{		
		if(!in_array(2,$this->role_modules))  
		redirect('home/access_forbidden','location');		
		if(!in_array(2,$this->role_module_accesses_2))
		redirect('home/access_forbidden','location');

		$table='roles';
		$where_simple=array('status'=>"1","editable"=>"1");
		$where=array('where'=>$where_simple);	
		$data['role_info']=$this->basic->get_data($table,$where,$select='',$join='',$limit='',$start='',$order_by='name asc',$group_by='',$num_rows=0);
			
		$data['body']='admin/user/add_user';
		$this->_viewcontroller($data);
	}

	public function add_user_action() 
	{		
		if($_SERVER['REQUEST_METHOD'] === 'GET') 
		redirect('home/access_forbidden','location');

		if(!in_array(2,$this->role_modules))  
		redirect('home/access_forbidden','location');		
		if(!in_array(2,$this->role_module_accesses_2))
		redirect('home/access_forbidden','location');

		if($_POST)
		{
			$this->form_validation->set_rules('username', 	'<b>'.$this->lang->line('username').'</b>', 			'trim|required|is_unique[users.username.0]');	
			$this->form_validation->set_rules('password', 	'<b>'.$this->lang->line('password').'</b>', 			'trim|required');	
			$this->form_validation->set_rules('password2', 	'<b>'.$this->lang->line('confirm password').'</b>',  'trim|required|matches[password]');		
			$this->form_validation->set_rules('role_name', 	'<b>'.$this->lang->line('role').'</b>', 				'trim|required');	
			$this->form_validation->set_rules('status', 	'<b>'.$this->lang->line('status').'</b>', 			'trim|required');	
			$this->form_validation->set_rules('type', 		'<b>'.$this->lang->line('user type').'</b>', 		'trim|required');	
			// $this->form_validation->set_rules('ward', 		'<b>Ward</b>',							'required');	

									
			if ($this->form_validation->run() == FALSE)
			{
				$this->add_user(); 
			}
			else
			{
				if( ($this->input->post('type')=='Individual') && ($this->input->post('individual_type')==''))
				{
					$this->session->set_flashdata('extra_validation',"<b>".$this->lang->line('individual type')."</b> ".$this->lang->line('is required'));
					redirect('admin/add_user','location');
				}

				if( ($this->input->post('type')=='Individual') && ($this->input->post('reference_id')==''))
				{
					$this->session->set_flashdata('extra_validation2',"<b>Reference ID</b> is required");
					redirect('admin/add_user','location');
				}
								
				$username=$this->input->post('username');
				$password=$this->input->post('password');
				$password=md5($password);
				$email=$this->input->post('email');
				$role_id=$this->input->post('role_name');
				$status=$this->input->post('status');
				$type=$this->input->post('type');
				
				if($type=='Individual')
				{
					$individual_type=$this->input->post('individual_type');
					$reference_id=$this->input->post('reference_id');
					
					$data=array
					(
						 'username'=>$username,
						 'password'=>$password, 					 
						 'role_id'=>$role_id, 
						 'status'=>$status, 
						 'user_type'=>$type, 
						 'type_details'=>$individual_type, 
						 'reference_id'=>$reference_id
					);				
				}
				
				else
				{
					$data=array
					(
						 'username'=>$username,
						 'password'=>$password,					
						 'role_id'=>$role_id, 
						 'status'=>$status, 
						 'user_type'=>$type	
					);
				}			
									
			    if($this->basic->insert_data('users',$data)) 
				{							
					$this->session->set_flashdata('success_message',1);
					redirect('admin/users','location');
					
				}
				
			}
		}	
	}


	public function update_user($id=0)
	{		
		if(!in_array(2,$this->role_modules))  
		redirect('home/access_forbidden','location');		
		if(!in_array(3,$this->role_module_accesses_2))
		redirect('home/access_forbidden','location');

		if($id==0)
		redirect('home/access_forbidden','location');

		$data['body']='admin/user/update_user';
		$table='roles';
		$where_simple=array('status'=>"1","editable"=>"1");
		$where=array('where'=>$where_simple);	
		$data['role_info']=$this->basic->get_data($table,$where,$select='',$join='',$limit='',$start='',$order_by='name asc',$group_by='',$num_rows=0);
		
		$table2='users';
		$where2=array('where'=>array('id'=>$id));		
		$data['xdata']=$this->basic->get_data($table2,$where2,$select='',$join='',$limit='',$start='',$order_by='',$group_by='',$num_rows=0);
		
		$this->_viewcontroller($data);
	}


	public function update_user_action() 
	{		
		if($_SERVER['REQUEST_METHOD'] === 'GET') 
		redirect('home/access_forbidden','location');

		if(!in_array(2,$this->role_modules))  
		redirect('home/access_forbidden','location');		
		if(!in_array(3,$this->role_module_accesses_2))
		redirect('home/access_forbidden','location');

		if($_POST)
		{	
			$user_id=$this->input->post('hidden_id');
			$update_password=0;

			if($this->input->post('password')!='password' || $this->input->post('password2')!='password')
			{
				$update_password=1;
				$this->form_validation->set_rules('password', 	'<b>'.$this->lang->line('Password').'</b>', 			'trim|required');	
				$this->form_validation->set_rules('password2',  '<b>'.$this->lang->line('Confirm Password').'</b>',  'trim|required|matches[password]');		
			}

			$this->form_validation->set_rules('role_name',  '<b>'.$this->lang->line('Role').'</b>', 				'trim|required');	
			$this->form_validation->set_rules('status', 	'<b>'.$this->lang->line('Status').'</b>', 			'trim|required');	
			$this->form_validation->set_rules('type', 		'<b>'.$this->lang->line('User Type').'</b>', 		'trim|required');	
			// $this->form_validation->set_rules('ward', 		'<b>Ward</b>',				'required');	
									
			if ($this->form_validation->run() == FALSE)
			{
				$this->update_user($user_id); 
			}
			else
			{
				if( ($this->input->post('type')=='Individual') && ($this->input->post('individual_type')==''))
				{
					$this->session->set_flashdata('extra_validation',"<b>".$this->lang->line('individual type').'</b> '. $this->lang->line('is required'));
					$redirect="admin/update_user/".$user_id;
					redirect($redirect,'location');
				}
				if( ($this->input->post('type')=='Individual') && ($this->input->post('reference_id')==''))
				{
					$this->session->set_flashdata('extra_validation2',"<b>".$this->lang->line('reference id').'</b> '.$this->lang->line('is required'));
					$redirect="admin/update_user/".$user_id;
					redirect($redirect,'location');
				}
				
							
				$password=$this->input->post('password');
				$password=md5($password);
				$email=$this->input->post('email');
				$role_id=$this->input->post('role_name');
				$status=$this->input->post('status');
				$type=$this->input->post('type');

								
				if($type=='Individual')
				{
					$individual_type=$this->input->post('individual_type');
					$reference_id=$this->input->post('reference_id');
					
					$data=array
					(						 					 
						 'role_id'=>$role_id, 
						 'status'=>$status, 
						 'user_type'=>$type, 
						 'type_details'=>$individual_type, 
						 'reference_id'=>$reference_id
					);	
					if($update_password==1)
					$data['password']=$password;			
				}
				
				else
				{
					$data=array
					(						 				
						 'role_id'=>$role_id, 
						 'status'=>$status, 
						 'user_type'=>$type,
						 'type_details'=>'', 
						 'reference_id'=>''			
					);
					if($update_password==1)
					$data['password']=$password;
				}			
									
			    if($this->basic->update_data('users',array('id'=>$user_id),$data)) 
				{							
					$this->session->set_flashdata('success_message',1);
					redirect('admin/users','location');					
				}
				
			}
		}	
	}


	public function financial_years()
	{		

		if(!in_array(3,$this->role_modules))  
		redirect('home/access_forbidden','location');

		// default data loads according to active session only
		// $active_session_array=$this->get_active_financial_year();
		// foreach ($active_session_array as $key=>$row) 
		// {
		// 	$active_session_name=$row;
		// 	$active_session_id=$key;
		// 	break;
		// }
		// $this->session->set_userdata('fy_active_session',$active_session_id);
		// default data loads according to active session only

		$this->load->database();
		$this->load->library('grocery_CRUD');
		$crud = new grocery_CRUD();
		$crud->set_theme('flexigrid');
		$crud->set_table('financial_year');
		$crud->order_by('name');
		$crud->set_subject($this->lang->line('financial year'));
		$crud->required_fields('name','status');
		$crud->columns('name','status');		
		$crud->add_fields('name','status');
		$crud->edit_fields('name','status');
		$crud->display_as('name',$this->lang->line('financial year'));
		$crud->display_as('status',$this->lang->line('status'));
		$crud->callback_column('status',array($this,'status_display_crud'));
		$crud->callback_field('status',array($this,'status_field_crud'));

		// Only one session can be active at a time
    	$crud->callback_after_insert(array($this, 'make_up_active_financial_year'));
    	$crud->callback_after_update(array($this, 'make_up_active_financial_year_edit'));

		if(!in_array(2,$this->role_module_accesses_3))
		$crud->unset_add();
		if(!in_array(3,$this->role_module_accesses_3))
		$crud->unset_edit();

		$crud->unset_delete();
		$crud->unset_read();
		$crud->unset_print();
		$crud->unset_export();
	
		$output = $crud->render();
		$data['output']=$output;
		$data['crud']=1;
		$this->_viewcontroller($data);
	}

	function make_up_active_financial_year($post_array,$primary_key)
	{
	    if($post_array['status']=='1')
	    {
	    	$table="financial_year";
	    	$where=array('id !='=> $primary_key);
	    	$data=array("status"=>"0");
			$this->basic->update_data($table,$where,$data);
			$this->db->last_query();
	    }

	    /*$copy_from_session=$this->session->userdata("fy_active_session");
		$this->session->unset_userdata("fy_active_session");

		$this->db->trans_start();*/
		//configuring class_roll
		/*$class_roll_data=$this->basic->get_data($table="class_roll",$where=array("where"=>array("session_id"=>$copy_from_session)));
		foreach($class_roll_data as $row)
		{
			$insert_data=array("session_id"=>$primary_key,"dept_id"=>$row["dept_id"],"shift_id"=>$row["shift_id"],"last_used_roll"=>0);
			$this->basic->insert_data($table="class_roll",$insert_data);
		}*/
		//configuring class_roll	
		
		//configuring class_routine
		/*$class_routine_data=$this->basic->get_data($table="class_routine",$where=array("where"=>array("session_id"=>$copy_from_session)));
		foreach($class_routine_data as $row)
		{	
			$insert_data=array(
				"class_id"	=>$row["class_id"],
				"course_id"	=>$row["course_id"],
				"period_id"	=>$row["period_id"],
				"day"		=>$row["day"],
				"start_time"=>$row["start_time"],
				"end_time"	=>$row["end_time"],
				"teacher_id"=>$row["teacher_id"],
				"section_id"=>$row["section_id"],
				"dept_id"	=>$row["dept_id"],
				"shift_id"	=>$row["shift_id"],
				"session_id"=>$primary_key,
				"status"	=>$row["status"]
				);
			$this->basic->insert_data($table="class_routine",$insert_data);
		}*/
		//configuring class_routine
		
		
		//configuring course
		/*$course_data=$this->basic->get_data($table="course",$where=array("where"=>array("session_id"=>$copy_from_session)));	
		foreach($course_data as $row)
		{	
			$insert_data=array(
				"course_code"	=>$row["course_code"],
				"course_name"	=>$row["course_name"],				
				"dept_id"		=>$row["dept_id"],
				"type"			=>$row["type"],
				"class_id"		=>$row["class_id"],
				"session_id"	=>$primary_key,
				"marks"			=>$row["marks"]
				);
			$this->basic->insert_data($table="course",$insert_data);
		}*/
		//configuring course 
		
		//configuring slip		
		/*$slip_data=$this->basic->get_data($table="slip",$where=array("where"=>array("financial_year_id"=>$copy_from_session)));
		foreach($slip_data as $row)
		{	
			
			$insert_data=array(
				"slip_name"			=>$row["slip_name"],
				"class_id"			=>$row["class_id"],
				"dept_id"			=>$row["dept_id"],
				"slip_type"			=>$row["slip_type"],
				"financial_year_id"	=>$primary_key,
				"total_amount"		=>$row["total_amount"]
				);
			$xslip_id=$row['id'];
			$this->basic->insert_data($table="slip",$insert_data);
			$slip_id=$this->db->insert_id();
			$sql="INSERT INTO slip_head(slip_id,account_id,amount) SELECT $slip_id,account_id,amount FROM slip_head WHERE slip_id='$xslip_id'";
			$this->basic->execute_complex_query($sql);
		}*/
		//configuring slip		
		// $this->db->trans_complete(); 

	    return true;
	}

	function make_up_active_financial_year_edit($post_array,$primary_key)
	{
	    if($post_array['status']=='1')
	    {
	    	$table="financial_year";
	    	$where=array('id !='=> $primary_key);
	    	$data=array("status"=>"0");
			$this->basic->update_data($table,$where,$data);
			$this->db->last_query();
	    }  
	    return true;
	}


	public function sessions()
	{		

		if(!in_array(3,$this->role_modules))  
		redirect('home/access_forbidden','location');

		$this->load->database();
		$this->load->library('grocery_CRUD');
		$crud = new grocery_CRUD();
		$crud->set_theme('flexigrid');
		$crud->set_table('session');
		$crud->order_by('name');
		$crud->set_subject($this->lang->line('session'));
		$crud->required_fields('name');
		$crud->columns('name');		
		$crud->add_fields('name');
		$crud->edit_fields('name');
		$crud->display_as('name',$this->lang->line('session name'));


		if(!in_array(2,$this->role_module_accesses_3))
		$crud->unset_add();
		if(!in_array(3,$this->role_module_accesses_3))
		$crud->unset_edit();

		$crud->unset_delete();
		$crud->unset_read();
		$crud->unset_print();
		$crud->unset_export();
	
		$output = $crud->render();
		$data['output']=$output;
		$data['crud']=1;
		$this->_viewcontroller($data);
	}


	public function classes()
	{		

		if(!in_array(4,$this->role_modules))  
		redirect('home/access_forbidden','location');

		$this->load->database();
		$this->load->library('grocery_CRUD');
		$crud = new grocery_CRUD();
		$crud->set_theme('flexigrid');
		$crud->set_table('class');
		$crud->order_by('ordering');
		$crud->set_subject($this->lang->line('class'));
		$crud->required_fields('class_name','ordering');
		$crud->columns('class_name','ordering');		
		$crud->fields('class_name','ordering');
		$crud->display_as('class_name',$this->lang->line('class name'));
		$crud->display_as('ordering',$this->lang->line('class order'));
		$crud->callback_field('ordering',array($this,'class_ordering_field_crud'));
		$crud->callback_edit_field('ordering',array($this,'class_ordering_field_crud_edit'));
		$crud->callback_after_insert(array($this, 'insert_dept_shift_section_on_class'));
		$crud->unique_fields('ordering');
		
		
		if(!in_array(2,$this->role_module_accesses_4))
		$crud->unset_add();
		if(!in_array(3,$this->role_module_accesses_4))
		$crud->unset_edit();	

		$crud->unset_delete();
		$crud->unset_read();
		$crud->unset_print();
		$crud->unset_export();
	
		$output = $crud->render();
		$data['output']=$output;
		$data['crud']=1;
		$this->_viewcontroller($data);
	}

	
	public function courses()
	{	
		if(!in_array(5,$this->role_modules))  
		redirect('home/access_forbidden','location');

		$this->load->database();
		$this->load->library('grocery_CRUD');
		$crud = new grocery_CRUD();
		$crud->set_theme('flexigrid');
		$crud->set_table('course');
		$crud->order_by('course_name');
		$crud->set_subject($this->lang->line('course'));
		$crud->required_fields('course_name','class_id','marks','dept_id','session_id','type');
		$crud->columns('course_name','course_code','marks','credit','class_id','dept_id','session_id','type');		
		$crud->fields('course_name','course_code','marks','credit','class_id','dept_id','session_id','type');
		$crud->display_as('course_name',$this->lang->line('course name'));		
		$crud->display_as('course_code',$this->lang->line('course code'));		
		$crud->display_as('marks',$this->lang->line('marks'));		
		$crud->display_as('type',$this->lang->line('type'));		
		$crud->display_as('credit',$this->lang->line('credit'));		
		$crud->callback_column('type',array($this,'course_type_display_crud'));
		$crud->callback_field('type',array($this,'course_type_field_crud'));		
		$crud->display_as('class_id',$this->lang->line('class'));
		$crud->set_relation('class_id','class','class_name',null,'ordering ASC');
		$crud->display_as('dept_id',$this->lang->line('group / dept.'));
	
		$crud->set_relation('dept_id','department','dept_name',null,'dept_name ASC');
		$crud->display_as('session_id',$this->lang->line('session'));
		$crud->set_relation('session_id','session','name',null,'name ASC');
		
		if(!in_array(2,$this->role_module_accesses_5))
		$crud->unset_add();
		if(!in_array(3,$this->role_module_accesses_5))
		$crud->unset_edit();

		$crud->unset_delete();
		$crud->unset_read();
		$crud->unset_print();
		$crud->unset_export();
	
		$output = $crud->render();
		$data['output']=$output;
		$data['crud']=1;
		$this->_viewcontroller($data);
	}


	
	public function sections()
	{	
		if(!in_array(6,$this->role_modules))  
		redirect('home/access_forbidden','location');

		$this->load->database();
		$this->load->library('grocery_CRUD');
		$crud = new grocery_CRUD();
		$crud->set_theme('flexigrid');
		$crud->set_table('class_section');
		$crud->order_by('section_name');
		$crud->set_subject($this->lang->line('section'));
		$crud->required_fields('section_name');
		$crud->columns('section_name');		
		$crud->fields('section_name');
		$crud->display_as('section_name',$this->lang->line('section name'));
		
		if(!in_array(2,$this->role_module_accesses_6))
		$crud->unset_add();
		if(!in_array(3,$this->role_module_accesses_6))
		$crud->unset_edit();

		$crud->unset_delete();
		$crud->unset_read();
		$crud->unset_print();
		$crud->unset_export();
	
		$output = $crud->render();
		$data['output']=$output;
		$data['crud']=1;
		$this->_viewcontroller($data);
	}

	public function departments()
	{	
		if(!in_array(7,$this->role_modules))  
		redirect('home/access_forbidden','location');

		$this->load->database();
		$this->load->library('grocery_CRUD');
		$crud = new grocery_CRUD();
		$crud->set_theme('flexigrid');
		$crud->set_table('department');
		$crud->order_by('class_id');
		$crud->set_subject( $this->lang->line('group / department'));
		$crud->required_fields('dept_name','class_id','start_roll','seat');
		$crud->columns('dept_name','class_id','start_roll','seat');		
		$crud->fields('dept_name','class_id','start_roll','seat');
		$crud->display_as('seat', $this->lang->line('no. of seat'));
		$crud->display_as('class_id', $this->lang->line('class'));
		$crud->display_as('start_roll', $this->lang->line('start roll'));
		$crud->display_as('dept_name', $this->lang->line('group / department'));
		$crud->display_as('form_price', $this->lang->line('admission form price'));
		$crud->set_relation('class_id','class','class_name',null,'ordering ASC');
		
		if(!in_array(2,$this->role_module_accesses_7))
		$crud->unset_add();
		if(!in_array(3,$this->role_module_accesses_7))
		$crud->unset_edit();

		$crud->unset_delete();
		$crud->unset_read();
		$crud->unset_print();
		$crud->unset_export();
	
		$output = $crud->render();
		$data['output']=$output;
		$data['crud']=1;
		$this->_viewcontroller($data);
	}

	public function shifts()
	{	
		if(!in_array(8,$this->role_modules))  
		redirect('home/access_forbidden','location');

		$this->load->database();
		$this->load->library('grocery_CRUD');
		$crud = new grocery_CRUD();
		$crud->set_theme('flexigrid');
		$crud->set_table('class_shift');
		$crud->order_by('shift_name');
		$crud->set_subject($this->lang->line('shift'));
		$crud->required_fields('shift_name');
		$crud->columns('shift_name');		
		$crud->fields('shift_name');
		$crud->display_as('shift_name',$this->lang->line('shift name'));
		
		if(!in_array(2,$this->role_module_accesses_8))
		$crud->unset_add();
		if(!in_array(3,$this->role_module_accesses_8))
		$crud->unset_edit();

		$crud->unset_delete();
		$crud->unset_read();
		$crud->unset_print();
		$crud->unset_export();
	
		$output = $crud->render();
		$data['output']=$output;
		$data['crud']=1;
		$this->_viewcontroller($data);
	}


	public function certificates()
	{
		if(!in_array(9,$this->role_modules))  
		redirect('home/access_forbidden','location');	
		if(!in_array(3,$this->role_module_accesses_9))
		redirect('home/access_forbidden','location');

		$data['body']='admin/certificate/templates';
		$data['character_data']=$this->basic->get_data('certificate_template',array('where'=>array('id'=>$this->config->item('character_certificate_id'))));
		$data['testimonial_data']=$this->basic->get_data('certificate_template',array('where'=>array('id'=>$this->config->item('testimonial_certificate_id'))));
		$data['transfer_data']=$this->basic->get_data('certificate_template',array('where'=>array('id'=>$this->config->item('transfer_certificate_id'))));
		$data['appeared_data']=$this->basic->get_data('certificate_template',array('where'=>array('id'=>$this->config->item('appeared_certificate_id'))));
		$data['studentship_data']=$this->basic->get_data('certificate_template',array('where'=>array('id'=>$this->config->item('studentship_certificate_id'))));
		$this->_viewcontroller($data);	
	}

	
	public function update_certificate()
	{
		if($_SERVER['REQUEST_METHOD'] === 'GET') 
		redirect('home/access_forbidden','location');

		if(!in_array(9,$this->role_modules))  
		redirect('home/access_forbidden','location');	
		if(!in_array(3,$this->role_module_accesses_9))
		redirect('home/access_forbidden','location');

		$name=$this->input->post('name');
		$text=$_POST['text'];

		if($this->basic->update_data('certificate_template',array("name"=>$name),array('content'=>$text)))
		$this->session->set_flashdata('success_message',1);	
		else
		$this->session->set_flashdata('error_message',1);			
			
	}


	public function ranks()
	{	
		if(!in_array(10,$this->role_modules))  
		redirect('home/access_forbidden','location');

		$this->load->database();
		$this->load->library('grocery_CRUD');
		$crud = new grocery_CRUD();
		$crud->set_theme('flexigrid');
		$crud->set_table('rank');		
		$crud->where('for','Teacher');
		$crud->order_by('rank_name');
		$crud->set_subject($this->lang->line('rank'));
		$crud->required_fields('rank_name','for');
		$crud->columns('rank_name','for');		
		$crud->fields('rank_name','for');
		$crud->display_as('rank_name',$this->lang->line('designation'));
		$crud->display_as('for',$this->lang->line('for'));
		// $crud->display_as('type','Designation Type');
		// $crud->callback_field('type',array($this,'teacher_rank_field_crud'));
		$crud->callback_field('for',array($this,'teacher_rank_for_field_crud'));
		// $crud->callback_column('type',array($this,'teacher_rank_type_display_crud'));
		
		if(!in_array(2,$this->role_module_accesses_10))
		$crud->unset_add();
		if(!in_array(3,$this->role_module_accesses_10))
		$crud->unset_edit();

		$crud->unset_search();
		$crud->unset_delete();
		$crud->unset_read();
		$crud->unset_print();
		$crud->unset_export();
	
		$output = $crud->render();
		$data['output']=$output;
		$data['crud']=1;
		$this->_viewcontroller($data);
	}

	public function ranks_employee()
	{	
		if(!in_array(10,$this->role_modules))  
		redirect('home/access_forbidden','location');

		$this->load->database();
		$this->load->library('grocery_CRUD');
		$crud = new grocery_CRUD();
		$crud->set_theme('flexigrid');
		$crud->set_table('rank');
		$crud->where('for','Employee');
		$crud->order_by('rank_name');
		$crud->set_subject($this->lang->line('staff rank'));
		$crud->required_fields('rank_name','for');
		$crud->columns('rank_name','for');		
		$crud->fields('rank_name','for');
		$crud->display_as('rank_name',$this->lang->line('name'));		
		$crud->display_as('for',$this->lang->line('for'));		
		// $crud->callback_field('type',array($this,'employee_rank_field_crud'));
		$crud->callback_field('for',array($this,'employee_rank_for_field_crud'));		
		// $crud->callback_column('type',array($this,'employee_rank_type_display_crud'));
		
		if(!in_array(2,$this->role_module_accesses_10))
		$crud->unset_add();
		if(!in_array(3,$this->role_module_accesses_10))
		$crud->unset_edit();

		$crud->unset_search();
		$crud->unset_delete();
		$crud->unset_read();
		$crud->unset_print();
		$crud->unset_export();
	
		$output = $crud->render();
		$data['output']=$output;
		$data['crud']=1;
		$this->_viewcontroller($data);
	}

	public function book_categories()
	{	
		if(!in_array(15,$this->role_modules))  
		redirect('home/access_forbidden','location');

		$this->load->database();
		$this->load->library('grocery_CRUD');
		$crud = new grocery_CRUD();
		$crud->set_theme('flexigrid');
		$crud->set_table('library_category');
		$crud->order_by('category_name');
		$crud->set_subject($this->lang->line('book category'));
		$crud->required_fields('category_name');
		$crud->columns('category_name');		
		$crud->fields('category_name');
		$crud->display_as('category_name',$this->lang->line('category'));		
		
		if(!in_array(2,$this->role_module_accesses_15))
		$crud->unset_add();
		if(!in_array(3,$this->role_module_accesses_15))
		$crud->unset_edit();

		$crud->unset_search();
		$crud->unset_delete();
		$crud->unset_read();
		$crud->unset_print();
		$crud->unset_export();
	
		$output = $crud->render();
		$data['output']=$output;
		$data['crud']=1;
		$this->_viewcontroller($data);
	}


    public function config_circulation()
    {
        if(!in_array(15,$this->role_modules))  
		redirect('home/access_forbidden','location');

		$currency = $this->config->item('currency');

        $this->load->database();
        $this->load->library('grocery_CRUD');
        $crud = new grocery_CRUD();
        $crud->set_theme('flexigrid');

        $crud->set_table('circulation_config');
        $crud->set_subject($this->lang->line('circulation settings'));
        $crud->order_by('id');
        $crud->where('circulation_config.deleted', '0');
        $crud->required_fields('issue_day_limit', 'issu_book_limit', 'fine_per_day');
        $crud->columns( 'issue_day_limit', 'issu_book_limit', 'fine_per_day');
        $crud->fields('issue_day_limit', 'issu_book_limit', 'fine_per_day');
        // $crud->display_as('member_type_id', 'Member Type');
        // $crud->set_relation('member_type_id', 'member_type', 'member_type_name', null, 'member_type_name ASC');

        $crud->display_as('issue_day_limit',$this->lang->line('issue limit - days'));
        $crud->display_as('fine_per_day',$this->lang->line('fine per day')." - ".$currency);
        $crud->display_as('issu_book_limit',$this->lang->line('issue limit - books'));
        // $crud->display_as('member_type_id',$this->lang->line('member types'));

        $crud->unset_add();
        $crud->unset_read();
        $crud->unset_print();
        $crud->unset_export();
        $crud->unset_delete();

        $output = $crud->render();
        $data['output'] = $output;
        $data['crud'] = 1;
        $data['page_title'] = "Circulation Settings";

        $this->_viewcontroller($data);
    }



	public function payment_methods()
	{	
		if(!in_array(11,$this->role_modules))  
		redirect('home/access_forbidden','location');

		$this->load->database();
		$this->load->library('grocery_CRUD');
		$crud = new grocery_CRUD();
		$crud->set_theme('flexigrid');
		$crud->set_table('payment_method');		
		$crud->order_by('payment_method_name');
		$crud->set_subject($this->lang->line('payment method'));
		$crud->required_fields('payment_method_name','payment_method_type','payment_account_no','status');
		$crud->columns('payment_method_name','payment_method_type','payment_account_no','api_username','api_password','comment','status');		
		$crud->fields('payment_method_name','payment_method_type','payment_account_no','api_username','api_password','comment','status');
		$crud->display_as('payment_method_name', $this->lang->line('method name'));
		$crud->display_as('payment_method_type',$this->lang->line('type'));
		$crud->display_as('payment_account_no',$this->lang->line('a/c no.'));
		$crud->display_as('comment',$this->lang->line('comment'));
		$crud->display_as('status',$this->lang->line('status'));
		$crud->display_as('api_username',$this->lang->line('api username'));
		$crud->display_as('api_password',$this->lang->line('api password'));
		$crud->callback_column('status',array($this,'status_display_crud'));
		$crud->callback_field('status',array($this,'status_field_crud'));
		
		if(!in_array(2,$this->role_module_accesses_11))
		$crud->unset_add();
		if(!in_array(3,$this->role_module_accesses_11))
		$crud->unset_edit();

		$crud->unset_delete();
		$crud->unset_read();
		$crud->unset_print();
		$crud->unset_export();
	
		$output = $crud->render();
		$data['output']=$output;
		$data['crud']=1;
		$this->_viewcontroller($data);
	}

	public function payment_setting_admin()
    {
        if(!in_array(11,$this->role_modules))  
		redirect('home/access_forbidden','location');
        
		$this->load->database();
		$this->load->library('grocery_CRUD');
		$crud = new grocery_CRUD();
		$crud->set_theme('flexigrid');
		$crud->set_table('payment_config');
		$crud->order_by('id');
		$crud->where('deleted', '0');
		$crud->set_subject($this->lang->line("payment settings"));
		$crud->required_fields('currency');
		$crud->columns('paypal_email','currency');		
		$crud->fields('paypal_email','currency');
		$crud->display_as('paypal_email',$this->lang->line("paypal email"));
		$crud->display_as('currency',$this->lang->line("currency"));
		
        $crud->unset_add();
		$crud->unset_search();
		$crud->unset_delete();
		$crud->unset_read();
		$crud->unset_print();
		$crud->unset_export();
	
		$output = $crud->render();
        $data['output']=$output;
		$data['page_title']=$this->lang->line("payment settings");
		$data['crud']=1;
		$this->_viewcontroller($data);
    }

 


	public function account_types()
	{	
		if(!in_array(11,$this->role_modules))  
		redirect('home/access_forbidden','location');

		$this->load->database();
		$this->load->library('grocery_CRUD');
		$crud = new grocery_CRUD();
		$crud->set_theme('flexigrid');
		$crud->set_table('account_type');		
		$crud->order_by('type');
		$crud->set_subject($this->lang->line('account type'));
		$crud->required_fields('type');
		$crud->columns('type');		
		$crud->fields('type');
		$crud->display_as('type',$this->lang->line('account type'));
		
		if(!in_array(2,$this->role_module_accesses_11))
		$crud->unset_add();
		if(!in_array(3,$this->role_module_accesses_11))
		$crud->unset_edit();
		
		// custom delete related code
		// $crud->where('account_type.deleted','0');
		// if(in_array(4,$this->role_module_accesses_11))
		// {
		// 	$this->session->set_userdata('crud_delete',array('table'=>'account_type','redirect_function'=>'account_types'));
		// 	$icon_path=base_url().'plugins/grocery_crud/themes/flexigrid/css/images/';
		// 	$icon_delete=$icon_path.'close.png';
		// 	$crud->add_action('Delete',$icon_delete,'','delete_crud',array($this,'delete_field_link'));
		// }
		// custom delete related code

		$crud->unset_delete();
		$crud->unset_read();
		$crud->unset_print();
		$crud->unset_export();
	
		$output = $crud->render();
		$data['output']=$output;
		$data['crud']=1;
		$this->_viewcontroller($data);
	}


	public function account_heads()
	{	
		if(!in_array(11,$this->role_modules))  
		redirect('home/access_forbidden','location');

		$this->load->database();
		$this->load->library('grocery_CRUD');
		$crud = new grocery_CRUD();
		$crud->set_theme('flexigrid');
		$crud->set_table('account_head');		
		$crud->order_by('account_name');
		$crud->set_subject($this->lang->line('account head'));
		$crud->required_fields('account_name','account_type_id','status');
		$crud->columns('account_name','account_type_id','remarks','status');		
		$crud->fields('account_name','account_type_id','remarks','status');
		$crud->display_as('account_name',$this->lang->line('account name'));
		$crud->display_as('account_type_id',$this->lang->line('account type'));
		$crud->display_as('remarks',$this->lang->line('remarks'));
		$crud->display_as('status',$this->lang->line('status'));
		$crud->callback_column('status',array($this,'status_display_crud'));
		$crud->callback_field('status',array($this,'status_field_crud'));
		$crud->set_relation('account_type_id','account_type','type',null,'type ASC');
		
		if(!in_array(2,$this->role_module_accesses_11))
		$crud->unset_add();
		if(!in_array(3,$this->role_module_accesses_11))
		$crud->unset_edit();

		$crud->unset_delete();
		$crud->unset_read();
		$crud->unset_print();
		$crud->unset_export();
	
		$output = $crud->render();
		$data['output']=$output;
		$data['crud']=1;
		$this->_viewcontroller($data);
	}


	public function pay_slips()
	{
		if(!in_array(11,$this->role_modules))  
		redirect('home/access_forbidden','location');

		$data['class_info']=$this->get_classes();
		$data['session_info']=$this->get_sessions();
		$data['body']='admin/pay_slip/pay_slips';
		$this->_viewcontroller($data);	
	}

	public function pay_slips_data()
	{			
		if(!in_array(11,$this->role_modules))  
		redirect('home/access_forbidden','location');

		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 5;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'slip_name';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'ASC';
		$order_by_str=$sort." ".$order;
		
		$slip_name=$this->input->post('slip_name');
		$class_id=$this->input->post('class_id');
		$financial_year_id=$this->input->post('financial_year_id');
		$is_searched= $this->input->post('is_searched');
		
		if($is_searched)
		{		
			$this->session->set_userdata('pay_slips_slip_name',$slip_name);
			$this->session->set_userdata('pay_slips_class_id',$class_id);
			$this->session->set_userdata('pay_slips_financial_year_id',$financial_year_id);
		}
				
		$search_slip_name=$this->session->userdata('pay_slips_slip_name');			
		$search_class_id=$this->session->userdata('pay_slips_class_id');			
		$search_financial_year_id=$this->session->userdata('pay_slips_financial_year_id');			
			
		$where_simple=array();
		
		if($search_slip_name)
		$where_simple['slip_name like']='%'.$search_slip_name.'%';
		if($search_class_id)
		$where_simple['slip.class_id']=$search_class_id;
		if($search_financial_year_id)
		$where_simple['slip.financial_year_id']=$search_financial_year_id;
				
		$where=array('where'=>$where_simple);			
		$offset = ($page-1)*$rows;
		$result = array();		
				
		$select=array("slip.id","slip.slip_name","slip.total_amount","slip.slip_type","class.class_name","department.dept_name","financial_year.name as session");
		$join=array('class'=>"class.id=slip.class_id,left",'department'=>"department.id=slip.dept_id,left",'financial_year'=>"financial_year.id=slip.financial_year_id,left");
		$info=$this->basic->get_data('slip',$where,$select,$join,$limit=$rows,$start=$offset,$order_by=$order_by_str,$group_by='',$num_rows=1);
		
		$total_rows_array=$this->basic->count_row($table="slip",$where,$count="slip.id",$join);
		$total_result=$total_rows_array[0]['total_rows'];

		echo convert_to_grid_data($info,$total_result);

	}

	public function add_pay_slip()
	{		
		if(!in_array(11,$this->role_modules))  
		redirect('home/access_forbidden','location');		
		if(!in_array(2,$this->role_module_accesses_11))
		redirect('home/access_forbidden','location');

		$data['body']='admin/pay_slip/add_pay_slip';		
		$where=array('where'=>array("status"=>"1"));
		$select=array("GROUP_CONCAT(CAST(account_head.id AS CHAR) SEPARATOR '/') AS account_head","GROUP_CONCAT(account_name SEPARATOR '/') AS account_name","type","account_type.id as account_type_id");
		$join=array('account_type'=>"account_type.id=account_head.account_type_id,left");
		$data['heads']=$this->basic->get_data('account_head',$where,$select,$join,$limit='',$start='',$order_by='account_name asc',$group_by='account_type_id',$num_rows=0);
		$data['class_info']=$this->get_classes();
		$data['session_info']=$this->get_sessions();
		$data['slip_types']=$this->get_slip_types();
		$this->_viewcontroller($data);
	}


	public function add_pay_slip_action() 
	{
		if($_SERVER['REQUEST_METHOD'] === 'GET') 
		redirect('home/access_forbidden','location');

		if(!in_array(11,$this->role_modules))  
		redirect('home/access_forbidden','location');		
		if(!in_array(2,$this->role_module_accesses_11))
		redirect('home/access_forbidden','location');

		if($_POST)
		{
			$this->form_validation->set_rules('name', '<b>'.$this->lang->line('slip name').'</b>', 'trim|required');	
			$this->form_validation->set_rules('class_id', '<b>'.$this->lang->line('class').'</b>', 'trim|required');	
			$this->form_validation->set_rules('dept_id', '<b>'.$this->lang->line('group / dept.').'</b>', 'trim|required');	
			$this->form_validation->set_rules('session_id', '<b>'.$this->lang->line('session').'</b>', 'trim|required');				
			$this->form_validation->set_rules('slip_type', '<b>'.$this->lang->line('slip type').'</b>', 'trim|required');				
			
			if ($this->form_validation->run() == FALSE)
			{
				$this->add_pay_slip(); 
			}
			else
			{	
				$all_id_str=$this->input->post('all_id_str');
				$all_head_id_array=explode('/',$all_id_str);

				$count=0;
				$total=0;
				for($i=0;$i<count($all_head_id_array);$i++)
				{
					$field_name="head_".$all_head_id_array[$i];
					$temp="";
					$temp=$this->input->post($field_name);
					if($temp!="")
					{
						$count++;
						$total+=$temp;
					}
				}

				if($count==0)
				{
					$this->session->set_flashdata('head_error',"<b>".$this->lang->line('account heads').'</b> ' .$this->lang->line('is required').'.');
					$this->add_pay_slip();  
				}

			
				$slip_name=$this->input->post('name');
				$class_id=$this->input->post('class_id');
				$dept_id=$this->input->post('dept_id');
				$session_id=$this->input->post('session_id');		   		
				$slip_type=$this->input->post('slip_type');		   		
				
				$data=array
				(
					'slip_name'=>$slip_name,
					'class_id'=>$class_id,
					'dept_id'=>$dept_id,
					'financial_year_id'=>$session_id,
					'slip_type'=>$slip_type,
					'total_amount'=>$total
				);
								
			    $this->db->trans_start();
			    $this->basic->insert_data('slip',$data); 	
			    $slip_id=$this->db->insert_id();	    
				for($i=0;$i<count($all_head_id_array);$i++)
				{
					$temp2="";
					$field_name="head_".$all_head_id_array[$i];
					$temp2=$this->input->post($field_name);
					if($temp2!="")
					{
						$data_slip_head=array("slip_id"=>$slip_id,"account_id"=>$all_head_id_array[$i],"amount"=>$temp2);
						$this->basic->insert_data('slip_head',$data_slip_head); 
					}
				}
				$this->db->trans_complete();

				
				if($this->db->trans_status() === FALSE)
				$this->session->set_flashdata('error_message',1);
				else		
				$this->session->set_flashdata('success_message',1);	

				redirect('admin/pay_slips','location');
					
				
			}
		}	
	}

	public function details_pay_slip($id=0)
	{		
		if($id==0)
		redirect('home/access_forbidden','location');

		if(!in_array(11,$this->role_modules))  
		redirect('home/access_forbidden','location');	

		$data['body']='admin/pay_slip/details_pay_slip';		
		$where=array('where'=>array("status"=>"1"));
		$select=array("GROUP_CONCAT(CAST(account_head.id AS CHAR) SEPARATOR '/') AS account_head","GROUP_CONCAT(account_name SEPARATOR '/') AS account_name","type","account_type.id as account_type_id");
		$join=array('account_type'=>"account_type.id=account_head.account_type_id,left");
		$data['heads']=$this->basic->get_data('account_head',$where,$select,$join,$limit='',$start='',$order_by='account_name asc',$group_by='account_type_id',$num_rows=0);
		$data['class_info']=$this->get_classes();
		$data['session_info']=$this->get_sessions();
		
		$where=array('where'=>array('slip.id'=>$id));	
		$select=array("slip.*","department.dept_name","class.class_name","financial_year.name as session_name");
		$join=array('department'=>"department.id=slip.dept_id,left",'class'=>"class.id=slip.class_id,left",'financial_year'=>"financial_year.id=slip.financial_year_id,left");
		$data['xdata_slip']=$this->basic->get_data("slip",$where,$select,$join);

		$where=array('where'=>array('slip_id'=>$id));		
		$xslip_head=$this->basic->get_data("slip_head",$where);

		foreach($xslip_head as $row)
		{
			$xaccount_head[$row['account_id']]=$row['amount'];
		}

		$data['xdata_account_head']=$xaccount_head;

		$this->_viewcontroller($data);
	}


	public function update_pay_slip($id=0)
	{		
		if($id==0)
		redirect('home/access_forbidden','location');

		if(!in_array(11,$this->role_modules))  
		redirect('home/access_forbidden','location');		
		if(!in_array(3,$this->role_module_accesses_11))
		redirect('home/access_forbidden','location');

		$data['body']='admin/pay_slip/update_pay_slip';		
		$where=array('where'=>array("status"=>"1"));
		$select=array("GROUP_CONCAT(CAST(account_head.id AS CHAR) SEPARATOR '/') AS account_head","GROUP_CONCAT(account_name SEPARATOR '/') AS account_name","type","account_type.id as account_type_id");
		$join=array('account_type'=>"account_type.id=account_head.account_type_id,left");
		$data['heads']=$this->basic->get_data('account_head',$where,$select,$join,$limit='',$start='',$order_by='account_name asc',$group_by='account_type_id',$num_rows=0);
		$data['class_info']=$this->get_classes();
		$data['session_info']=$this->get_sessions();
		
		$where=array('where'=>array('slip.id'=>$id));	
		$select=array("slip.*","department.dept_name");
		$join=array('department'=>"department.id=slip.dept_id,left");
		$data['xdata_slip']=$this->basic->get_data("slip",$where,$select,$join);

		$where=array('where'=>array('slip_id'=>$id));		
		$xslip_head=$this->basic->get_data("slip_head",$where);

		foreach($xslip_head as $row)
		{
			$xaccount_head[$row['account_id']]=$row['amount'];
		}

		$data['xdata_account_head']=$xaccount_head;
		$data['slip_types']=$this->get_slip_types();

		$this->_viewcontroller($data);
	}


	public function update_pay_slip_action() 
	{
		if($_SERVER['REQUEST_METHOD'] === 'GET') 
		redirect('home/access_forbidden','location');

		if(!in_array(11,$this->role_modules))  
		redirect('home/access_forbidden','location');		
		if(!in_array(3,$this->role_module_accesses_11))
		redirect('home/access_forbidden','location');

		if($_POST)
		{
			$xslip_id= $this->input->post('hidden_id');	 
			
			$this->form_validation->set_rules('name', '<b>'.$this->lang->line('slip name').'</b>', 'trim|required');	
			$this->form_validation->set_rules('class_id', '<b>'.$this->lang->line('class').'</b>', 'trim|required');	
			$this->form_validation->set_rules('dept_id', '<b>'.$this->lang->line('group / dept').'</b>', 'trim|required');	
			$this->form_validation->set_rules('session_id', '<b>'.$this->lang->line('session').'</b>', 'trim|required');				
			$this->form_validation->set_rules('slip_type', '<b>'.$this->lang->line('slip type').'</b>', 'trim|required');				
			
			if ($this->form_validation->run() == FALSE)
			{
				$this->update_pay_slip($xslip_id); 
			}
			else
			{	
				$all_id_str=$this->input->post('all_id_str');
				$all_head_id_array=explode('/',$all_id_str);

				$count=0;
				$total=0;
				for($i=0;$i<count($all_head_id_array);$i++)
				{
					$field_name="head_".$all_head_id_array[$i];
					$temp="";
					$temp=$this->input->post($field_name);
					if($temp!="")
					{
						$count++;
						$total+=$temp;
					}
				}

				if($count==0)
				{
					$this->session->set_flashdata('head_error',"<b>".$this->lang->line('Account Heads').'</b> '.$this->lang->line('is required').".");
					$this->add_pay_slip(); 
				}
			
				$slip_name=$this->input->post('name');
				$class_id=$this->input->post('class_id');
				$dept_id=$this->input->post('dept_id');
				$session_id=$this->input->post('session_id');		
				$slip_type=$this->input->post('slip_type');						
				
				$data=array
				(
					'slip_name'=>$slip_name,
					'class_id'=>$class_id,
					'dept_id'=>$dept_id,
					'financial_year_id'=>$session_id,
					'slip_type'=>$slip_type,
					'total_amount'=>$total
				);
								
			    $this->db->trans_start();
			    $this->basic->delete_data("slip",array("id"=>$xslip_id));
			    $this->basic->delete_data("slip_head",array("slip_id"=>$xslip_id));
			    $this->basic->insert_data('slip',$data); 	
			    $slip_id=$this->db->insert_id();	    
				for($i=0;$i<count($all_head_id_array);$i++)
				{
					$temp2="";
					$field_name="head_".$all_head_id_array[$i];
					$temp2=$this->input->post($field_name);
					if($temp2!="")
					{
						$data_slip_head=array("slip_id"=>$slip_id,"account_id"=>$all_head_id_array[$i],"amount"=>$temp2);
						$this->basic->insert_data('slip_head',$data_slip_head); 
					}
				}
				$this->db->trans_complete();

				
				if($this->db->trans_status() === FALSE)
				$this->session->set_flashdata('error_message',1);
				else		
				$this->session->set_flashdata('success_message',1);	

				redirect('admin/pay_slips','location');
					
				
			}
		}	
	}


	public function periods()
	{	
		if(!in_array(12,$this->role_modules))  
		redirect('home/access_forbidden','location');

		$this->load->database();
		$this->load->library('grocery_CRUD');
		$crud = new grocery_CRUD();
		$crud->set_theme('flexigrid');
		$crud->set_table('class_period');		
		$crud->order_by('ordering');
		$crud->set_subject($this->lang->line('period'));
		$crud->required_fields('period_name','ordering');
		$crud->columns('period_name','ordering');		
		$crud->fields('period_name','ordering');
		$crud->display_as('period_name',$this->lang->line('period name'));
		$crud->display_as('ordering', $this->lang->line('period no.'));
		$crud->callback_field('ordering',array($this,'period_ordering_field_crud'));
		$crud->callback_edit_field('ordering',array($this,'period_ordering_field_crud_edit'));
		$crud->unique_fields('ordering');
		$crud->callback_column('ordering',array($this,'period_ordering_display_crud'));
		
		
		if(!in_array(2,$this->role_module_accesses_12))
		$crud->unset_add();
		if(!in_array(3,$this->role_module_accesses_12))
		$crud->unset_edit();

		$crud->unset_delete();
		$crud->unset_read();
		$crud->unset_print();
		$crud->unset_export();
	
		$output = $crud->render();
		$data['output']=$output;
		$data['crud']=1;
		$this->_viewcontroller($data);
	}



	public function online_admission_configure()
	{	
		if(!in_array(13,$this->role_modules))  
		redirect('home/access_forbidden','location');

		$this->load->database();
		$this->load->library('grocery_CRUD');
		$crud = new grocery_CRUD();
		$crud->set_theme('flexigrid');
		$crud->set_table('online_admission_configure');
		$crud->order_by('class_name');
		$crud->set_subject($this->lang->line('online_admission_configure'));
		$crud->required_fields('session_id','class_id','dept_id','is_admission_open','is_admission_test','application_last_date','admission_last_date');
		$crud->columns('session_id','class_id','dept_id','is_admission_open','is_admission_test','application_last_date','send_sms_after_application','admission_test_date','send_sms_after_admission','result_publish_date','admission_last_date');		
		$crud->fields('session_id','class_id','dept_id','is_admission_open','is_admission_test','application_last_date','send_sms_after_application','admission_test_date','send_sms_after_admission','result_publish_date','admission_last_date','notice_for_applicant');		
		
		$crud->callback_field('is_admission_open',array($this,'is_admission_open_field_crud'));
		$crud->callback_field('is_admission_test',array($this,'is_admission_test_field_crud'));
		$crud->callback_field('send_sms_after_application',array($this,'is_send_sms_after_application_field_crud'));
		$crud->callback_field('send_sms_after_admission',array($this,'is_send_sms_after_admission_field_crud'));
		$crud->callback_column('is_admission_open',array($this,'is_admission_open_display_crud'));
		$crud->callback_column('is_admission_test',array($this,'is_admission_test_display_crud'));
		$crud->callback_column('send_sms_after_application',array($this,'is_send_sms_after_application_display_crud'));
		$crud->callback_column('send_sms_after_admission',array($this,'is_send_sms_after_admission_display_crud'));
		
		$crud->display_as('class_id',$this->lang->line('class'));
		$crud->display_as('dept_id',$this->lang->line('group/dept.'));
		$crud->display_as('session_id',$this->lang->line('session'));
		$crud->display_as('is_admission_open',$this->lang->line('admission status'));
		$crud->display_as('is_admission_test',$this->lang->line('admission test'));
		$crud->display_as('form_price',$this->lang->line('form price'));
		$crud->display_as('send_sms_after_application',$this->lang->line('send sms after application'));
		$crud->display_as('send_sms_after_admission',$this->lang->line('send sms after admission'));
		$crud->display_as('notice_for_applicant',$this->lang->line('notice for applicants'));		
		$crud->display_as('application_last_date',$this->lang->line('application last date'));		
		$crud->display_as('admission_test_date',$this->lang->line('admission test date'));		
		$crud->display_as('result_publish_date',$this->lang->line('result publish date'));		
		$crud->display_as('admission_last_date',$this->lang->line('admission last date'));		

		$crud->set_relation('class_id','class','class_name',null,'ordering ASC');
		$crud->set_relation('dept_id','department','dept_name',null,'dept_name ASC');
		$crud->set_relation('session_id','session','name',null,'name ASC');
		
		if(!in_array(2,$this->role_module_accesses_5))
		$crud->unset_add();
		if(!in_array(3,$this->role_module_accesses_5))
		$crud->unset_edit();

		$crud->unset_delete();
		$crud->unset_read();
		$crud->unset_print();
		$crud->unset_export();
	
		$output = $crud->render();
		$data['output']=$output;
		$data['crud']=1;
		$this->_viewcontroller($data);
	}


	public function result_config()
	{	
		if(!in_array(14,$this->role_modules))  
		redirect('home/access_forbidden','location');

		$this->load->database();
		$this->load->library('grocery_CRUD');
		$crud = new grocery_CRUD();
		$crud->set_theme('flexigrid');
		$crud->set_table('result_config');	
		$crud->set_subject($this->lang->line('optional course configuration'));
		$crud->required_fields('key','value');
		$crud->columns('key','value');		
		$crud->fields('key','value');

		$crud->display_as('key',$this->lang->line('grade'));
		$crud->display_as('value',$this->lang->line('grade point'));

		if(!in_array(2,$this->role_module_accesses_14))
		$crud->unset_add();
		if(!in_array(3,$this->role_module_accesses_14))
		$crud->unset_edit();

		$crud->unset_delete();
		$crud->unset_read();
		$crud->unset_print();
		$crud->unset_export();
	
		$output = $crud->render();
		$data['output']=$output;
		$data['crud']=1;
		$this->_viewcontroller($data);
	}



	public function gpa_config()
	{	
		if(!in_array(14,$this->role_modules))  
		redirect('home/access_forbidden','location');

		$this->load->database();
		$this->load->library('grocery_CRUD');
		$crud = new grocery_CRUD();
		$crud->set_theme('flexigrid');
		$crud->set_table('gpa_config');	
		$crud->set_subject($this->lang->line('gpa configuration'));
		$crud->required_fields(	'start_mark','end_mark','grade_point','grade_name');
		$crud->columns('start_mark','end_mark','grade_point','grade_name');		
		$crud->fields('start_mark','end_mark','grade_point','grade_name');
		$crud->display_as('start_mark',$this->lang->line('start marks'));
		$crud->display_as('end_mark',$this->lang->line('end marks'));
		$crud->display_as('grade_point',$this->lang->line('grade point'));
		$crud->display_as('grade_name',$this->lang->line('grade name'));
		$crud->where('result_type','gpa');
		$crud->callback_after_insert(array($this, 'add_default_value_for_result_type_gpa'));

		if(!in_array(2,$this->role_module_accesses_14))
		$crud->unset_add();
		if(!in_array(3,$this->role_module_accesses_14))
		$crud->unset_edit();

		// $crud->unset_delete();
		$crud->unset_read();
		$crud->unset_print();
		$crud->unset_export();
	
		$output = $crud->render();
		$data['output']=$output;
		$data['crud']=1;
		$this->_viewcontroller($data);
	}

	function add_default_value_for_result_type_gpa($post_array,$primary_key)
	{
	    
    	$table="gpa_config";
    	$where=array('id'=> $primary_key);
    	$data=array("result_type"=>"gpa");
		$this->basic->update_data($table,$where,$data);
		$this->db->last_query();
	   
	    return true;
	}


	public function cgpa_config()
	{	
		if(!in_array(14,$this->role_modules))  
		redirect('home/access_forbidden','location');

		$this->load->database();
		$this->load->library('grocery_CRUD');
		$crud = new grocery_CRUD();
		$crud->set_theme('flexigrid');
		$crud->set_table('gpa_config');	
		$crud->set_subject($this->lang->line('cgpa configuration'));
		$crud->required_fields(	'start_mark','end_mark','grade_point','grade_name');
		$crud->columns('start_mark','end_mark','grade_point','grade_name');		
		$crud->fields('start_mark','end_mark','grade_point','grade_name');
		$crud->display_as('start_mark',$this->lang->line('start marks'));
		$crud->display_as('end_mark',$this->lang->line('end marks'));
		$crud->display_as('grade_point',$this->lang->line('grade point'));
		$crud->display_as('grade_name',$this->lang->line('grade name'));
		$crud->where('result_type','cgpa');
		$crud->callback_after_insert(array($this, 'add_default_value_for_result_type_cgpa'));

		if(!in_array(2,$this->role_module_accesses_14))
		$crud->unset_add();
		if(!in_array(3,$this->role_module_accesses_14))
		$crud->unset_edit();

		// $crud->unset_delete();
		$crud->unset_read();
		$crud->unset_print();
		$crud->unset_export();
	
		$output = $crud->render();
		$data['output']=$output;
		$data['crud']=1;
		$this->_viewcontroller($data);
	}

	function add_default_value_for_result_type_cgpa($post_array,$primary_key)
	{
	    
    	$table="gpa_config";
    	$where=array('id'=> $primary_key);
    	$data=array("result_type"=>"cgpa");
		$this->basic->update_data($table,$where,$data);
		$this->db->last_query();
	   
	    return true;
	}


	public function exam_name_config()
	{	
		if(!in_array(14,$this->role_modules))  
		redirect('home/access_forbidden','location');

		$this->load->database();
		$this->load->library('grocery_CRUD');
		$crud = new grocery_CRUD();
		$crud->set_theme('flexigrid');
		$crud->set_table('result_exam_name');
		$crud->order_by('exam_name');
		$crud->set_subject($this->lang->line('exam'));
		$crud->required_fields('exam_name','class_id','dept_id','session_id','result_type','is_complete');
		$crud->columns('exam_name','class_id','dept_id','session_id','result_type','is_complete');		
		$crud->fields('exam_name','class_id','dept_id','session_id','result_type','is_complete');
		
		
		$crud->callback_field ('is_complete',array($this,'is_complete_field_crud'));
		$crud->callback_column('is_complete',array($this,'is_complete_display_crud'));

		$crud->display_as('class_id',$this->lang->line('class'));
		$crud->display_as('dept_id',$this->lang->line('group / dept.'));
		$crud->display_as('session_id',$this->lang->line('session'));
		$crud->display_as('result_type',$this->lang->line('result type'));
		$crud->display_as('is_complete',$this->lang->line('status'));
		$crud->display_as('exam_name',$this->lang->line('exam name'));

		$crud->set_relation('class_id','class','class_name',null,'ordering ASC');
		$crud->set_relation('dept_id','department','dept_name',null,'dept_name ASC');
		$crud->set_relation('session_id','session','name',null,'name ASC');
		
		if(!in_array(2,$this->role_module_accesses_14))
		$crud->unset_add();
		if(!in_array(3,$this->role_module_accesses_14))
		$crud->unset_edit();

		$crud->unset_delete();
		$crud->unset_read();
		$crud->unset_print();
		$crud->unset_export();
	
		$output = $crud->render();
		$data['output']=$output;
		$data['crud']=1;
		$this->_viewcontroller($data);
	}


	function period_ordering_field_crud($value = '', $primary_key = null)
	{
	    $str='';
	    $str.="<select name='ordering' id='field-ordering' class='form-control'><option value=''></option>";
	    for($i=1;$i<=12;$i++)
	    {
	    	$disabled="";
	    	if(!$this->basic->is_exist("class_period",$where=array("ordering"=>$i),$select='id'))	    	
	    	$str.='<option value="'.$i.'">'.numtophrase($i).'</option>';
	    }
	    $str.="</select>";
	    return $str;
	}

	function period_ordering_field_crud_edit($value = '', $primary_key = null)
	{
	    $str='';
	    $str.="<select name='ordering' id='field-ordering' class='form-control'><option value=''></option>";
	    for($i=1;$i<=12;$i++)
	    {
	    	$disabled="";	    	    	
	    	$str.='<option value="'.$i.'">'.numtophrase($i).'</option>';
	    }
	    $str.="</select>";
	    return $str;
	}

	public function period_ordering_display_crud($value, $row)
	{
		return numtophrase($value);
	}

	function class_ordering_field_crud($value = '', $primary_key = null)
	{
	    $str='';
	    $str.="<select name='ordering' id='field-ordering' class='form-control'><option value=''></option>";
	    for($i=1;$i<=20;$i++)
	    {
	    	$disabled="";
	    	if(!$this->basic->is_exist("class",$where=array("ordering"=>$i),$select='id'))	    	
	    	$str.='<option value="'.$i.'">'.$i.'</option>';
	    }
	    $str.="</select>";
	    return $str;
	}

	function class_ordering_field_crud_edit($value = '', $primary_key = null)
	{
	    $str='';
	    $str.="<select name='ordering' id='field-ordering' class='form-control'><option value=''></option>";
	    for($i=1;$i<=20;$i++)
	    {
	    	$disabled="";	    		    	
	    	$str.='<option value="'.$i.'">'.$i.'</option>';
	    }
	    $str.="</select>";
	    return $str;
	}

	function insert_dept_shift_section_on_class($post_array,$primary_key) // creats default group/dept for a new class
	{
		// default dept for that class
		$insert_data = array(
        "dept_name" => "No Group/ Dept.",
        "class_id" => $primary_key,
        "default" => "1",
        "start_roll" => 1
	    );	 
	    $this->basic->insert_data('department',$insert_data);	   
	    
	    // default section
	    if(!$this->basic->is_exist($table="class_section",$where=array("default"=>"1"),$select=array("id") ) ) // if there is no default section
	    $this->basic->insert_data('class_section',$data=array("section_name"=>"No Section","default"=>"1"));
		    
	    // default shift
	    if(!$this->basic->is_exist($table="class_shift",$where=array("default"=>"1"),$select=array("id") ) ) // if there is no default shift
	    $this->basic->insert_data('class_shift',$data=array("shift_name"=>"No Shift","default"=>"1"));
	   	    	 
	    return true;
	}
	

	function status_field_crud($value, $row)
	{
		 if($value=='') $value=1;
		 return form_dropdown('status',array(0=>$this->lang->line('inactive'),1=>$this->lang->line('active')),$value,'class="form-control" id="field-status"');
	}

	function status_display_crud($value, $row)
	{
		 if($value==1) 
		 	return "<span class='label label-success'>".$this->lang->line('active')."</sapn>";
		 else
		 	return "<span class='label label-warning'>".$this->lang->line('inactive')."</sapn>";
	}

	function course_type_field_crud($value, $row)
	{
		 if($value=='') $value=1;
		 return form_dropdown("type",array(0=>$this->lang->line('optional'),1=>$this->lang->line('Mandatory')),$value,'class="form-control" id="field-type"');
	}

	function course_type_display_crud($value, $row)
	{
		 if($value==1)
		 return "<span class='label label-success'>".$this->lang->line('mandatory')."</sapn>";
		 else
		 return "<span class='label label-warning'>".$this->lang->line('optional')."</sapn>";
	}

	function is_admission_open_field_crud($value, $row)
	{
		 if($value=='') $value=1;
		 return form_dropdown('is_admission_open',array(0=>$this->lang->line('close'),1=>$this->lang->line('open')),$value,'class="form-control" id="field-is_admission_open"');
	}


	function is_admission_open_display_crud($value, $row)
	{
		 if($value==1)
		 return "<span class='label label-success'>".$this->lang->line('open')."</sapn>";
		 else
		 return "<span class='label label-warning'>".$this->lang->line('close')."</sapn>";
	}

	function is_admission_test_field_crud($value, $row)
	{
		 if($value=='') $value=0;
		 return form_dropdown('is_admission_test',array(0=>$this->lang->line('no'),1=>$this->lang->line('yes')),$value,'class="form-control" id="field-is_admission_test"');
	}
	
	function is_admission_test_display_crud($value, $row)
	{
		 if($value==1)
		 return "<span class='label label-success'>".$this->lang->line('yes')."</sapn>";
		 else
		 return "<span class='label label-warning'>".$this->lang->line('no')."</sapn>";
	}

	function is_send_sms_after_application_field_crud($value, $row)
	{
		 if($value=='') $value=0;
		 return form_dropdown('send_sms_after_application',array(0=>$this->lang->line('no'),1=>$this->lang->line('Yes')),$value,'class="form-control" id="field-send_sms_after_application"');
	}
	
	function is_send_sms_after_application_display_crud($value, $row)
	{
		 if($value==1)
		 return "<span class='label label-success'>".$this->lang->line('yes')."</sapn>";
		 else
		 return "<span class='label label-warning'>".$this->lang->line('no')."</sapn>";
	}

	function is_send_sms_after_admission_field_crud($value, $row)
	{
		 if($value=='') $value=0;
		 return form_dropdown('send_sms_after_admission',array(0=>$this->lang->line('No'),1=>$this->lang->line('Yes')),$value,'class="form-control" id="field-send_sms_after_admission"');
	}
	
	function is_send_sms_after_admission_display_crud($value, $row)
	{
		 if($value==1)
		 return "<span class='label label-success'>".$this->lang->line('yes')."</sapn>";
		 else
		 return "<span class='label label-warning'>".$this->lang->line('no')."</sapn>";
	}

	function is_complete_field_crud($value, $row)
	{
		 if($value=='') $value=1;
		 return form_dropdown('is_complete',array(0=>$this->lang->line('incomplete'),1=>$this->lang->line('complete')),$value,'class="form-control" id="field-is_complete"');
	}

	function is_complete_display_crud($value, $row)
	{
		 if($value==1)
		 return "<span class='label label-success'>".$this->lang->line('complete')."</sapn>";
		 else
		 return "<span class='label label-warning'>".$this->lang->line('incomplete')."</sapn>";
	}


	/*function employee_rank_field_crud()
	{
		return form_dropdown('type',array("Academic"=>"Designation","Administrative"=>"Rank"),"",'class="form-control" id="field-type"');
	}*/
	function employee_rank_for_field_crud()
	{
		return form_dropdown('for',array("Employee"=>$this->lang->line("employee")),"Employee",'class="form-control" id="field-for"');
	}
	/*function employee_rank_type_display_crud($value, $row)
	{
		 if($value=="Academic")
		 return "<span class='label label-success'>Designation</sapn>";
		 else
		 return "<span class='label label-warning'>Rank</sapn>";
	}*/	
	/*function teacher_rank_field_crud()
	{
		return form_dropdown('type',array("Academic"=>"Academic","Administrative"=>"Administrative"),"",'class="form-control" id="field-type"');
	}*/
	function teacher_rank_for_field_crud()
	{
		return form_dropdown('for',array("Teacher"=>$this->lang->line("teacher")),"Teacher",'class="form-control" id="field-for"');
	}

	/*function teacher_rank_type_display_crud($value, $row)
	{
		 if($value=="Academic")
		 return "<span class='label label-success'>Academic</sapn>";
		 else
		 return "<span class='label label-warning'>Administrative</sapn>";
	}*/



	//custom delete functions for crud  
	// function delete_field_link($primary_key , $row)
	// {
	// 	return site_url().'admin/delete_field_crud/'.$row->id;				
	// }

	// function delete_field_crud($id=0)
	// {
	// 	$session=array();
	// 	if($this->session->userdata('crud_delete') && $id!=0)
	// 	{
	// 		$session=$this->session->userdata('crud_delete');	
	// 		$table=$session['table'];
	// 		$redirect_function=$session['redirect_function'];
	// 		$this->basic->update_data($table,array("id"=>$id),array("deleted"=>"1"));		
	// 		$this->session->set_flashdata('delete_success_message',1);
	// 	}
	// 	else
	// 	{
	// 		$redirect_function="index";
	// 		$this->session->set_flashdata('delete_error_message',1);
	// 	}
	// 	$this->session->unset_userdata('crud_delete');
	// 	$redirect="admin/".$redirect_function;
	// 	redirect($redirect,'location');	
	// }
	//custom delete functions for crud 
	
	

	function sms_configuration()
	{

		if(!in_array(31,$this->role_modules))  
		redirect('home/access_forbidden','location');	

		if(isset($_POST['submit'])){
			$gateway=$this->input->post('sms_gateway',TRUE);
			$auth_id=$this->input->post('auth_id',TRUE);
			$token=$this->input->post('auth_token',TRUE);
			$phone_number=$this->input->post('phone_number',TRUE);
			$api_id=$this->input->post('api_id',TRUE);
			
			$update_data=array(
				'name'=>$gateway,
				'auth_id'=>$auth_id,
				'token'=>$token,
				'phone_number'=>$phone_number,
				'api_id'=>$api_id
			);
			
			$this->db->update("sms_config",$update_data);
			$this->session->set_flashdata('success_message',1);
			redirect('admin/sms_configuration','location');
		}
				
		$data['sms_configuration']=$this->basic->get_data('sms_config',$where='',$select='',$join='',$limit='',$start='',$order_by='',$group_by='',$num_rows=0);

		$data['body']='admin/sms_config/sms_config';	
		$this->_viewcontroller($data);
		
	}
		
		
}
