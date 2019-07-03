<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	// public $flexigrid_icon_path;
	// public $flexigrid_icon_add;
	// public $flexigrid_icon_read;
	// public $flexigrid_icon_edit;
	// public $flexigrid_icon_delete;
	// public $crud;
	public $role_modules=array();
	public $role_module_accesses=array();
	public $role_module_accesses_1=array();
	public $role_module_accesses_2=array();
	public $role_module_accesses_3=array();
	public $role_module_accesses_4=array();
	public $role_module_accesses_5=array();
	public $role_module_accesses_6=array();
	public $role_module_accesses_7=array();
	public $role_module_accesses_8=array();
	public $role_module_accesses_9=array();
	public $role_module_accesses_10=array();
	public $role_module_accesses_11=array();
	public $role_module_accesses_12=array();
	public $role_module_accesses_13=array();
	public $role_module_accesses_14=array();
	public $role_module_accesses_15=array();
	public $role_module_accesses_16=array();
	public $role_module_accesses_17=array();
	public $role_module_accesses_18=array();
	public $role_module_accesses_19=array();
	public $role_module_accesses_20=array();
	public $role_module_accesses_21=array();
	public $role_module_accesses_22=array();
	public $role_module_accesses_23=array();
	public $role_module_accesses_24=array();
	public $role_module_accesses_25=array();
	public $role_module_accesses_26=array();
	public $role_module_accesses_27=array();
	public $role_module_accesses_28=array();
	public $role_module_accesses_29=array();
	public $role_module_accesses_30=array();
	public $role_module_accesses_31=array();
	public $role_module_accesses_32=array();
	public $language;
    public $is_rtl;

	function __construct()
	{
		parent::__construct();	
		set_time_limit(0);
		$this->load->helper('my_helper');

		$this->is_rtl=FALSE;
        $this->language="";
        $this->_language_loader();

        $seg = $this->uri->segment(2);
        if ($seg!="installation" && $seg!= "installation_action") {
            if (file_exists(APPPATH.'install.txt')) {
                redirect('home/installation', 'location');
            }
        }

		if(!file_exists(APPPATH.'install.txt'))
		{
			
			$this->load->library('email');
			$this->load->library('sms_manager');				
			$this->load->library('dbbl_transaction');				
			$this->load->library('bkash_api');				
			$this->load->database();				
			$this->load->model('basic');	
			$query="SET SESSION sql_mode = ''";
			$this->db->query($query);			
			$this->_time_zone_set();

			$this->upload_path = realpath( APPPATH . '../upload');	

			if($this->session->userdata('logged_in')==1 && $this->session->userdata('user_type')=='Operator')
			{
				$this->role_modules 				=	$this->session->userdata('role_module_array');		
				$this->role_module_accesses 		=	$this->session->userdata('role_access_array');	
				if(in_array(1,$this->role_modules)) 
					$this->role_module_accesses_1 	=	explode(',',$this->role_module_accesses[1]);		
				if(in_array(2,$this->role_modules)) 
					$this->role_module_accesses_2 	=	explode(',',$this->role_module_accesses[2]);	
				if(in_array(3,$this->role_modules)) 
					$this->role_module_accesses_3 	=	explode(',',$this->role_module_accesses[3]);
				if(in_array(4,$this->role_modules)) 
					$this->role_module_accesses_4 	=	explode(',',$this->role_module_accesses[4]);
				if(in_array(5,$this->role_modules)) 
					$this->role_module_accesses_5 	=	explode(',',$this->role_module_accesses[5]);
				if(in_array(6,$this->role_modules)) 
					$this->role_module_accesses_6 	=	explode(',',$this->role_module_accesses[6]);
				if(in_array(7,$this->role_modules)) 
					$this->role_module_accesses_7 	=	explode(',',$this->role_module_accesses[7]);
				if(in_array(8,$this->role_modules)) 
					$this->role_module_accesses_8 	=	explode(',',$this->role_module_accesses[8]);
				if(in_array(9,$this->role_modules)) 
					$this->role_module_accesses_9 	=	explode(',',$this->role_module_accesses[9]);
				if(in_array(10,$this->role_modules)) 
					$this->role_module_accesses_10 	=	explode(',',$this->role_module_accesses[10]);
				if(in_array(11,$this->role_modules)) 
					$this->role_module_accesses_11 	=	explode(',',$this->role_module_accesses[11]);
				if(in_array(12,$this->role_modules)) 
					$this->role_module_accesses_12 	=	explode(',',$this->role_module_accesses[12]);
				if(in_array(13,$this->role_modules)) 
					$this->role_module_accesses_13 	=	explode(',',$this->role_module_accesses[13]);
				if(in_array(14,$this->role_modules)) 
					$this->role_module_accesses_14 	=	explode(',',$this->role_module_accesses[14]);
				if(in_array(15,$this->role_modules)) 
					$this->role_module_accesses_15 	=	explode(',',$this->role_module_accesses[15]);
				if(in_array(16,$this->role_modules)) 
					$this->role_module_accesses_16 	=	explode(',',$this->role_module_accesses[16]);
				if(in_array(17,$this->role_modules)) 
					$this->role_module_accesses_17 	=	explode(',',$this->role_module_accesses[17]);
				if(in_array(18,$this->role_modules)) 
					$this->role_module_accesses_18 	=	explode(',',$this->role_module_accesses[18]);
				if(in_array(19,$this->role_modules)) 
					$this->role_module_accesses_19 	=	explode(',',$this->role_module_accesses[19]);
				if(in_array(20,$this->role_modules)) 
					$this->role_module_accesses_20 	=	explode(',',$this->role_module_accesses[20]);
				if(in_array(21,$this->role_modules)) 
					$this->role_module_accesses_21 	=	explode(',',$this->role_module_accesses[21]);
				if(in_array(22,$this->role_modules)) 
					$this->role_module_accesses_22 	=	explode(',',$this->role_module_accesses[22]);
				if(in_array(23,$this->role_modules)) 
					$this->role_module_accesses_23 	=	explode(',',$this->role_module_accesses[23]);
				if(in_array(24,$this->role_modules)) 
					$this->role_module_accesses_24 	=	explode(',',$this->role_module_accesses[24]);
				if(in_array(25,$this->role_modules)) 
					$this->role_module_accesses_25 	=	explode(',',$this->role_module_accesses[25]);
				if(in_array(26,$this->role_modules)) 
					$this->role_module_accesses_26 	=	explode(',',$this->role_module_accesses[26]);
				if(in_array(26,$this->role_modules)) 
					$this->role_module_accesses_26 	=	explode(',',$this->role_module_accesses[26]);
				if(in_array(27,$this->role_modules)) 
					$this->role_module_accesses_27 	=	explode(',',$this->role_module_accesses[27]);
				if(in_array(28,$this->role_modules)) 
					$this->role_module_accesses_28 	=	explode(',',$this->role_module_accesses[28]);
				if(in_array(29,$this->role_modules)) 
					$this->role_module_accesses_29 	=	explode(',',$this->role_module_accesses[29]);
				if(in_array(30,$this->role_modules)) 
					$this->role_module_accesses_30 	=	explode(',',$this->role_module_accesses[30]);
				if(in_array(31,$this->role_modules)) 
					$this->role_module_accesses_31 	=	explode(',',$this->role_module_accesses[31]);
				if(in_array(32,$this->role_modules)) 
					$this->role_module_accesses_32 	=	explode(',',$this->role_module_accesses[32]);
			}
		}
		
		// $this->flexigrid_icon_path=base_url().'plugins/grocery_crud/themes/flexigrid/css/images/';		
		// $this->flexigrid_icon_add=$this->flexigrid_icon_path.'add.png';
		// $this->flexigrid_icon_view=$this->flexigrid_icon_path.'magnifier.png';
		// $this->flexigrid_icon_edit=$this->flexigrid_icon_path.'edit.png';
		// $this->flexigrid_icon_delete=$this->flexigrid_icon_path.'close.png';

	}


	function index()
	{			
		$this->login(); 		
	}


	function installation()
	{	
		if(!file_exists(APPPATH.'install.txt'))
		redirect('home/login','location');

		$data = array("body" => "page/install", "page_title" => "Install Package","language_info" => $this->_language_list());
		$this->_front_viewcontroller($data);
	}

	function installation_action()
	{
		
		if(!file_exists(APPPATH.'install.txt'))
		redirect('home/login','location');
		
		if($_POST)
		{	
			// validation
			$this->form_validation->set_rules('host_name', 				'<b>'.$this->lang->line('host name').'</b>',  				'trim|required');			
			$this->form_validation->set_rules('database_name', 			'<b>'.$this->lang->line('database name').'</b>',  			'trim|required');			
			$this->form_validation->set_rules('database_username', 		'<b>'.$this->lang->line('database username').'</b>',  		'trim|required');				
			$this->form_validation->set_rules('app_username', 			'<b>'.$this->lang->line('application username').'</b>',  	'trim|required');			
			$this->form_validation->set_rules('app_password', 			'<b>'.$this->lang->line('application password').'</b>',  	'trim|required');			
			$this->form_validation->set_rules('database_password', 		'<b>'.$this->lang->line('database password').'</b>',  		'trim');			
			$this->form_validation->set_rules('institute_name', 		'<b>'.$this->lang->line('institute name').'</b>',  			'trim');			
			$this->form_validation->set_rules('institute_address', 		'<b>'.$this->lang->line('institute address').'</b>',  		'trim');			
			$this->form_validation->set_rules('institute_email', 		'<b>'.$this->lang->line('institute email').'</b>',  			'trim|required|valid_email');	
			$this->form_validation->set_rules('institute_mobile', 		'<b>'.$this->lang->line('institute phone / mobile').'</b>',	'trim');			
			$this->form_validation->set_rules('language',                '<b>Language</b>',                    'trim');
			// go to config form page if validation wrong
			if ($this->form_validation->run() == FALSE)
			{
				return $this->installation(); 
			}

			else
			{	
				
				$host_name=addslashes(strip_tags($this->input->post('host_name',true)));
				$database_name=addslashes(strip_tags($this->input->post('database_name',true)));
				$database_username=addslashes(strip_tags($this->input->post('database_username',true)));
				$database_password=addslashes(strip_tags($this->input->post('database_password',true)));	
				$app_username=$this->input->post('app_username',true);
				$app_password=$this->input->post('app_password',true);
				$institute_name=addslashes(strip_tags($this->input->post('institute_name',true)));
				$institute_address=addslashes(strip_tags($this->input->post('institute_address',true)));
				$institute_email=addslashes(strip_tags($this->input->post('institute_email',true)));
				$institute_mobile=addslashes(strip_tags($this->input->post('institute_mobile',true)));
				$language = addslashes(strip_tags($this->input->post('language', true)));

				$con=@mysqli_connect($host_name, $database_username, $database_password);
                if (!$con) {
                    $this->session->set_userdata('mysql_error', "Could not conenect to MySQL.");
                    return $this->installation();
                }
                if (!@mysqli_select_db($con,$database_name)) {
                    $this->session->set_userdata('mysql_error', "Database not found.");
                    return $this->installation();
                }
                mysqli_close($con);		         
				 // writing application/config/my_config
		       	  $app_my_config_data = "<?php ";          
	              $app_my_config_data.="\n\$config['default_page_url']='page/blank';\n";
	              $app_my_config_data.="\$config['product_name']='".$this->config->item("product_name")."';\n";
	              $app_my_config_data.="\$config['product_short_name']='".$this->config->item("product_short_name")."' ;\n";
	              $app_my_config_data.="\$config['product_version']=' ".$this->config->item("product_version")."';\n";
	              $app_my_config_data.="\$config['product_slogan']='".$this->config->item("product_slogan")."';\n";	              
	              $app_my_config_data.="\$config['institute_address1']='$institute_name';\n";
	              $app_my_config_data.="\$config['institute_address2']='$institute_address';\n";
	              $app_my_config_data.="\$config['institute_email']='$institute_email';\n";
	              $app_my_config_data.="\$config['institute_mobile']='$institute_mobile';\n\n";
	              $app_my_config_data.="\$config['admin_role_id'] =".$this->config->item("admin_role_id").";\n";
				  $app_my_config_data.="\$config['student_role_id'] =".$this->config->item("student_role_id").";\n";
	              $app_my_config_data.="\$config['teacher_role_id'] = ".$this->config->item("teacher_role_id").";\n";
				  $app_my_config_data.="\$config['staff_role_id'] = ".$this->config->item("staff_role_id").";\n";
	              $app_my_config_data.="\$config['offline_method_id'] = ".$this->config->item("offline_method_id").";\n";
	              $app_my_config_data.="\$config['paypal_method_id'] = ".$this->config->item("paypal_method_id").";\n";
	              $app_my_config_data.="\$config['stripe_method_id'] = ".$this->config->item("stripe_method_id").";\n";
	              $app_my_config_data.="\$config['bank_method_id'] = ".$this->config->item("bank_method_id").";\n";
	              $app_my_config_data.="\$config['character_certificate_id'] =".$this->config->item("character_certificate_id").";\n";
	              $app_my_config_data.="\$config['testimonial_certificate_id'] =".$this->config->item("testimonial_certificate_id").";\n";
	              $app_my_config_data.="\$config['transfer_certificate_id'] =".$this->config->item("transfer_certificate_id").";\n";
	              $app_my_config_data.="\$config['appeared_certificate_id'] =".$this->config->item("appeared_certificate_id").";\n";
	              $app_my_config_data.="\$config['studentship_certificate_id'] =".$this->config->item("studentship_certificate_id").";\n\n";
	              $app_my_config_data.= "\$config['currency'] = '".$this->config->item('currency')."';\n";
	              // $app_my_config_data.= "\$config['language'] = '".$this->config->item('language')."';\n";
	              $app_my_config_data.= "\$config['language'] = '$language';\n";
	              $app_my_config_data.="\$config['sess_use_database']	= TRUE;\n";
	              $app_my_config_data.="\$config['sess_table_name']		= 'ci_sessions';\n";
				  file_put_contents(APPPATH.'config/my_config.php', $app_my_config_data,LOCK_EX);
				  //writting  application/config/my_config

				  //writting application/config/database
				  $database_data="";
				  $database_data.="<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');\n
					\$active_group = 'default';
					\$active_record = TRUE;
					\$db['default']['hostname'] = '$host_name';
					\$db['default']['username'] = '$database_username';
					\$db['default']['password'] = '$database_password';
					\$db['default']['database'] = '$database_name';
					\$db['default']['dbdriver'] = 'mysqli';
					\$db['default']['dbprefix'] = '';
					\$db['default']['pconnect'] = TRUE;
					\$db['default']['db_debug'] = TRUE;
					\$db['default']['cache_on'] = FALSE;
					\$db['default']['cachedir'] = '';
					\$db['default']['char_set'] = 'utf8';
					\$db['default']['dbcollat'] = 'utf8_general_ci';
					\$db['default']['swap_pre'] = '';
					\$db['default']['autoinit'] = TRUE;
					\$db['default']['stricton'] = FALSE;";				  
				  file_put_contents(APPPATH.'config/database.php', $database_data,LOCK_EX);
				  //writting application/config/database				  
				  
				  // loding database library, because we need to run queries below and configs are already written
				  $this->load->database();				
				  $this->load->model('basic');
				  // loding database library, because we need to run queries below and configs are already written				  
  			   		 
		   		  $dump_file_name='eimis_initial_db.sql';
		   		  $dump_sql_path= 'assets/backup_db/'.$dump_file_name;
		   		  // dumping sql
		   		  $this->basic->import_dump($dump_sql_path);
		   		  
				 //generating hash password for admin and updaing database
				  $app_password = md5($app_password);
				  
				  $this->basic->insert_data($table="users",$insert_data=array("username"=>$app_username,'email'=>$institute_email,"password"=>$app_password,"role_id"=>$this->config->item("admin_role_id"),"user_type"=>"Operator","status"=>"1","deleted"=>"0"));
				  //generating hash password for admin and updaing database
				  
		          //deleting the install.txt file,because installation is complete
				  if(file_exists(APPPATH.'install.txt'))
				  unlink(APPPATH.'install.txt');
				  //deleting the install.txt file,because installation is complete
				  redirect('home/login');	
			}
		} 		
	}

	public function _language_loader()
    {       

        if(!$this->config->item("language") || $this->config->item("language")=="")
        $this->language="english";
        else $this->language=$this->config->item('language');

        if($this->session->userdata("selected_language")!="")
        $this->language = $this->session->userdata("selected_language");
        else if(!$this->config->item("language") || $this->config->item("language")=="") 
        $this->language="english";
        else $this->language=$this->config->item('language');

        if($this->language=="arabic")
        $this->is_rtl=TRUE;

    	if (file_exists(APPPATH.'language/'.$this->language.'/admin_lang.php'))
        $this->lang->load('admin', $this->language);

    	if (file_exists(APPPATH.'language/'.$this->language.'/online_admission_lang.php'))
        $this->lang->load('online_admission', $this->language);

    	if (file_exists(APPPATH.'language/'.$this->language.'/teacher_lang.php'))
        $this->lang->load('teacher', $this->language);

    	if (file_exists(APPPATH.'language/'.$this->language.'/student_lang.php'))
        $this->lang->load('student', $this->language);

    	if (file_exists(APPPATH.'language/'.$this->language.'/common_lang.php'))
        $this->lang->load('common', $this->language);

        
        if (file_exists(APPPATH.'language/'.$this->language.'/calendar_lang.php'))
        $this->lang->load('calendar', $this->language);
        
        if (file_exists(APPPATH.'language/'.$this->language.'/date_lang.php'))
        $this->lang->load('date', $this->language);
        
        if (file_exists(APPPATH.'language/'.$this->language.'/db_lang.php'))
        $this->lang->load('db', $this->language);
        
        if (file_exists(APPPATH.'language/'.$this->language.'/email_lang.php'))
        $this->lang->load('email', $this->language);
        
        if (file_exists(APPPATH.'language/'.$this->language.'/form_validation_lang.php'))
        $this->lang->load('form_validation', $this->language);
        
        if (file_exists(APPPATH.'language/'.$this->language.'/ftp_lang.php'))
        $this->lang->load('ftp', $this->language);
        
        if (file_exists(APPPATH.'language/'.$this->language.'/imglib_lang.php'))
        $this->lang->load('imglib', $this->language);
        
        if (file_exists(APPPATH.'language/'.$this->language.'/migration_lang.php'))
        $this->lang->load('migration', $this->language);
        
        if (file_exists(APPPATH.'language/'.$this->language.'/number_lang.php'))
        $this->lang->load('number', $this->language);
        
        if (file_exists(APPPATH.'language/'.$this->language.'/pagination_lang.php'))
        $this->lang->load('pagination', $this->language);
        
        if (file_exists(APPPATH.'language/'.$this->language.'/profiler_lang.php'))
        $this->lang->load('profiler', $this->language);
        
        if (file_exists(APPPATH.'language/'.$this->language.'/unit_test_lang.php'))
        $this->lang->load('unit_test', $this->language);
        
        if (file_exists(APPPATH.'language/'.$this->language.'/upload_lang.php'))
        $this->lang->load('upload', $this->language); 

    	if (file_exists(APPPATH.'language/'.$this->language.'/message_lang.php'))
        $this->lang->load('message', $this->language); 

        if (file_exists(APPPATH.'language/'.$this->language.'/library_lang.php'))
        $this->lang->load('library', $this->language);    

    	if (file_exists(APPPATH.'language/'.$this->language.'/misc_lang.php'))
        $this->lang->load('misc', $this->language);  
    }


     function _language_list() 
     {
        
        //$img_tag = '<img style="height: 15px; width: 20px;" src="'.$url.'BN.png" alt="flag" />';
         $language = array
         (
            "bengali"=>'Bengali',            
            "dutch"=>'Dutch',
            "english"=>"English",
            "french"=>"French",
            "german"=>"German",
            "greek"=>"Greek",
            "italian"=>"Italian",            
            "portuguese"=>"Portuguese",
            "russian"=>"Russian",
            "spanish"=>"Spanish",            
            "turkish"=>"Turkish"
         );
         // print_r($language);
         return $language;
     }

     public function language_changer()
    {
        $language=$this->input->post("language");
        $this->session->set_userdata("selected_language",$language);
    }	
	
	function _time_zone_set()
	{
		ini_set('date.timezone', 'Asia/Dhaka');
		
		/*$time_zone_query="SET SESSION time_zone='Asia/Dhaka'";
		$this->db->query($time_zone_query);*/
		
		
		/*$time_zone_query="SET GLOBAL time_zone='Asia/Dhaka'";
		$this->db->query($time_zone_query);*/
	}


	function _disable_cache() 
	{
	    header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
	    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	    header("Cache-Control: post-check=0, pre-check=0", false);
	    header("Pragma: no-cache");
	}


	function _mysql_date($date='')
	{
		if($date=='') 
		redirect('home/access_forbidden','location');

		if (strpos($date, '/') !== false)
		{ 
			$receive_date_arr = explode('/',$date);
			$mysql_date = $receive_date_arr[2]."-".$receive_date_arr[1]."-".$receive_date_arr[0];
			return $mysql_date;
		}
		else
		{
			$receive_date_arr = explode('-',$date);
			$mysql_date = $receive_date_arr[2]."-".$receive_date_arr[1]."-".$receive_date_arr[0];
			return $mysql_date;
		}
	}

		
	function access_forbidden()
	{		
		$data=array("title"=>$this->lang->line("access forbidden."),"message"=>$this->lang->line("access forbidden."));
		$this->load->view('page/message_page',$data);
	}


	function page_not_found()
	{		
		$data=array("title"=>$this->lang->line("page not found"),"message"=>"404 ! ".$this->lang->line('page not found'));
		$this->load->view('page/message_page',$data);
	}


	function _public_viewcontroller($data=array())
	{
		
		$this->load->view('public/theme/theme_public',$data);
	}

	function _front_viewcontroller($data=array())
	{			
		// $this->_disable_cache();
		if(!isset($data['body']))
		$data['body']=$this->config->item('default_page_url');
	
		if(!isset($data['page_title']))
		$data['page_title']=$this->lang->line("online admission");

		$this->load->view('front/theme_front',$data);
	}

	// fetch all pending student queries to show in admin notification area
	public function _admin_notifications()
	{
		if($this->session->userdata('logged_in')!=1 || $this->session->userdata('user_type')!='Operator')
		return array();

		$where=array('where'=>array("replied"=>"0"));		
		$select=array("student_query.message_subject","student_query.id as primary_key","DATE_FORMAT(student_query.sent_at, '%d/%m/%y %l:%m %p') as sent_at","student_info.name as student_name","student_info.student_id","student_info.image","student_info.gender");
		$join=array('student_info'=>"student_query.student_info_id=student_info.id,left");	
		$info=$this->basic->get_data('student_query',$where,$select,$join,$limit=5,$start="",$order_by="sent_at DESC");	
		return $info;			
	}

	function _viewcontroller($data=array())
	{			
		// $this->_disable_cache();
		if(!isset($data['body']))
		$data['body']=$this->config->item('default_page_url');
	
		if(!isset($data['page_title']))
		$data['page_title']=$this->lang->line("admin panel");

		if(!isset($data['crud']))
		$data['crud']=0;
		// fetch all pending student queries to show in admin notification area
		$data['student_query_notifications']=$this->_admin_notifications();
		$data["language_info"] = $this->_language_list();
		$this->load->view('admin/theme/theme',$data);
	}

	public function _teacher_sms_email_notifications()
	{
		if($this->session->userdata('logged_in')!=1 || $this->session->userdata('type_details')!='Teacher')
		return array();

		$id=$this->session->userdata("reference_id");
		$where=array('where'=>array("teacher_id"=>$id,"viewed"=>"0"));		
		$select=array("sms_email_history.id","sms_email_history.title","DATE_FORMAT(sms_email_history.sent_at, '%d/%m/%y %l:%m %p') as sent_at");
		$info=$this->basic->get_data('sms_email_history',$where,$select,$join="",$limit=5,$start="",$order_by="sent_at DESC");	
		return $info;			
	}


	function _teacher_viewcontroller($data=array())
	{			
		// $this->_disable_cache();
		if(!isset($data['body']))
		$data['body']=$this->config->item('default_page_url');
	
		if(!isset($data['page_title']))
		$data['page_title']=$this->lang->line("teacher panel");

		if(!isset($data['crud']))
		$data['crud']=0;

		$data["teacher_sms_email_notifications"]=$this->_teacher_sms_email_notifications();
			
		$this->load->view('teacher/theme_teacher/theme_teacher',$data);
	}

	// fetch student's notification and query reply to show in student panel notification area
	public function _student_query_notifications()
	{
		if($this->session->userdata('logged_in')!=1 || $this->session->userdata('type_details')!='Student')
		return array();

		$id=$this->session->userdata("reference_id");
		$where=array('where'=>array("replied"=>"1","student_info_id"=>$id,"reply_viewed"=>"0"));		
		$select=array("student_query.id","student_query.reply_message","DATE_FORMAT(student_query.reply_at, '%d/%m/%y %l:%m %p') as reply_at");
		$info=$this->basic->get_data('student_query',$where,$select,$join="",$limit=5,$start="",$order_by="sent_at DESC");	
		return $info;			
	}
	// fetch student's sms/email/general notifications to show in student panel notification area



	public function _student_sms_email_notifications()
	{
		if($this->session->userdata('logged_in')!=1 || $this->session->userdata('type_details')!='Student')
		return array();

		$id=$this->session->userdata("reference_id");
		$where=array('where'=>array("student_info_id"=>$id,"viewed"=>"0"));		
		$select=array("sms_email_history.id","sms_email_history.title","DATE_FORMAT(sms_email_history.sent_at, '%d/%m/%y %l:%m %p') as sent_at");
		$info=$this->basic->get_data('sms_email_history',$where,$select,$join="",$limit=5,$start="",$order_by="sent_at DESC");	
		return $info;			
	}

	function _student_viewcontroller($data=array())
	{			
		// $this->_disable_cache();
		if(!isset($data['body']))
		$data['body']=$this->config->item('default_page_url');
	
		if(!isset($data['page_title']))
		$data['page_title']=$this->lang->line("student panel");

		if(!isset($data['crud']))
		$data['crud']=0;

		$data["student_query_notifications"]=$this->_student_query_notifications();
		$data["student_sms_email_notifications"]=$this->_student_sms_email_notifications();
			
		$this->load->view('student/theme_student/theme_student',$data);
	}


	function login() //loads home view page after login (this )
	{
		if(file_exists(APPPATH.'install.txt'))
		redirect('home/installation','location');

		$this->session->unset_userdata('app_logged_in'); // unsetting applicant session

		if($this->session->userdata('logged_in')==1 && $this->session->userdata('user_type')=='Operator')
		{
			if(in_array(16,$this->role_modules))  
			redirect('admin_dashboard/index','location');	
			else redirect('admin/index','location');
		}

		if($this->session->userdata('logged_in')==1 && $this->session->userdata('type_details')=='Student')
		redirect('student/index','location');

		if($this->session->userdata('logged_in')==1 && $this->session->userdata('type_details')=='Teacher')
		redirect('teacher/index','location');	

		$this->form_validation->set_rules('username', "<b>".$this->lang->line('username')."</b>", 'trim|required|xss_clean');
		$this->form_validation->set_rules('password', "<b>".$this->lang->line('password')."</b>", 'trim|required|xss_clean');
				
		if ($this->form_validation->run() == FALSE)
		$this->load->view('page/login'); //if validation test becomes false,reloads it
		
		else
		{	
			$username=$_POST['username'];
			$password=md5($_POST['password']);

			$table='users';
			$where_simple=array('username'=>$username,'password'=>$password,'users.status'=>"1",'roles.status'=>"1");
			$where=array('where'=>$where_simple);		
			$join=array('roles'=>"users.role_id=roles.id,left");
			$select = array('users.*');
			$info=$this->basic->get_data($table,$where,$select,$join,$limit='',$start='',$order_by='',$group_by='',$num_rows=1);		
			$count=$info['extra_index']['num_rows'];

			if($count==0)
			{
				$this->session->set_flashdata('login_msg',$this->lang->line('invalid username or password'));
				redirect(uri_string());
			}
			else
			{
				unset($info['extra_index']);			
				
				foreach($info as $row)
				{
					$user_id=$row['id'];
					$username=$row['username'];
					$role_id=$row['role_id'];
					$user_type=$row['user_type'];
					$type_details=$row['type_details'];
					$reference_id=$row['reference_id'];
				}

								
				if($type_details=="Student" || $type_details=="Teacher")
				{
					
					if($type_details=="Student") 
					{
						$table_pic="student_info";
						$select_pic=array("image","name");
					}
					else 
					{
						$table_pic="teacher_info";						
						$select_pic=array("image","teacher_name");
					}				

					$profile_pic_data=$this->basic->get_data($table_pic,array('where'=>array('id'=>$reference_id)),$select_pic);
					$profile_pic=$profile_pic_data[0]['image'];

					if(array_key_exists("name",$profile_pic_data[0]))  $real_name=$profile_pic_data[0]['name'];
					else  $real_name=$profile_pic_data[0]['teacher_name'];

					$this->session->set_userdata('profile_pic',$profile_pic);
					$this->session->set_userdata('real_username',$real_name);
				}

				
				else
				{
					$table2='roles';
					$where_simple2=array('id'=>$role_id,'status'=>'1');
					$where2=array('where'=>$where_simple2);		
					$role_info=$this->basic->get_data($table2,$where2,$select='',$join='',$limit='',$start='',$order_by='',$group_by='',$num_rows=0);
					
					foreach($role_info as $row2)
					{								
						$departments=$row2['departments'];					
					}
					$department_array=explode(',',$departments);	
					$this->session->set_userdata('department_access_array',$department_array);		
					
					$table3='role_privilleges';
					$where_simple3=array('role_id'=>$role_id);
					$where3=array('where'=>$where_simple3);		
					$module_info=$this->basic->get_data($table3,$where3,$select='',$join='',$limit='',$start='',$order_by='',$group_by='',$num_rows=0);
					
					foreach($module_info as $row3)
					{
						$accesses[$row3['modules']]=$row3['accesses'];	
						$modules[]=$row3['modules'];	
					}
					$this->session->set_userdata('role_module_array',$modules);
					$this->session->set_userdata('role_access_array',$accesses);
				}
				
				$this->session->set_userdata('logged_in',1);
				$this->session->set_userdata('user_id',$user_id);
				$this->session->set_userdata('username',$username);
				$this->session->set_userdata('role_id',$role_id);
				$this->session->set_userdata('user_type',$user_type);
				$this->session->set_userdata('type_details',$type_details);						
				$this->session->set_userdata('reference_id',$reference_id);					
				
				if($this->session->userdata('logged_in')==1 && $this->session->userdata('user_type')=='Operator')
				{
					// if(in_array(16,$this->role_modules))  
					redirect('admin_dashboard/index','location');	
					// else redirect('admin/index','location');
				}

				if($this->session->userdata('logged_in')==1 && $this->session->userdata('type_details')=='Student')
				redirect('student/index','location');

				if($this->session->userdata('logged_in')==1 && $this->session->userdata('type_details')=='Teacher')
				redirect('teacher/index','location');										
			}			
		}			
	}



	function logout() 
	{		
		$this->session->sess_destroy();
		redirect('home/login','location');		
	}

	

	function _mail_sender($from = '', $to = '', $subject = '', $message = '', $mask = "", $html = 0, $smtp = 1)
    {
        if ($to!= '' && $subject!='' && $message!= '') 
        {     

            if ($smtp == '1') {
                $where2 = array("where" => array('status' => '1','deleted' => '0'));
                $email_config_details = $this->basic->get_data("email_config", $where2, $select = '', $join = '', $limit = '', $start = '',
                                                        $group_by = '', $num_rows = 0);

                if (count($email_config_details) == 0) {
                    $this->load->library('email');
                } else {
                    foreach ($email_config_details as $send_info) {
                        $send_email = trim($send_info['email_address']);
                        $smtp_host = trim($send_info['smtp_host']);
                        $smtp_port = trim($send_info['smtp_port']);
                        $smtp_user = trim($send_info['smtp_user']);
                        $smtp_password = trim($send_info['smtp_password']);
                    }

            /*****Email Sending Code ******/
                $config = array(
                  'protocol' => 'smtp',
                  'smtp_host' => "{$smtp_host}",
                  'smtp_port' => "{$smtp_port}",
                  'smtp_user' => "{$smtp_user}", // change it to yours
                  'smtp_pass' => "{$smtp_password}", // change it to yours
                  'mailtype' => 'html',
                  'charset' => 'utf-8',
                  'newline' =>  "\r\n",
                  'smtp_timeout' => '30'
                 );

                    $this->load->library('email', $config);
                }
            } /*** End of If Smtp== 1 **/

            if (isset($send_email) && $send_email!= "") {
                $from = $send_email;
            }
            $this->email->from($from, $mask);
            $this->email->to($to);
            $this->email->subject($subject);
            $this->email->message($message);
            if ($html == 1) {
                $this->email->set_mailtype('html');
            }

            if ($this->email->send()) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }


	function _sms_sender($message='',$mobile='')
	{
		
		if($message!='' && $mobile!='')
		{
			//if(strlen($mobile)==11) $mobile='88'.$mobile;
			if($this->sms_manager->send_sms($message,$mobile))
			return true;
			else return false;
		}
		else return false;	
	}

	function thana_select_as_district($district_id,$name_and_id="thana_id")  
	{
		$table='thana';
		$where_simple=array('district_id'=>$district_id);
		$where=array('where'=>$where_simple);
		$results=$this->basic->get_data($table,$where,$select='',$join='',$limit='',$start='',$order_by='thana_name asc');

		$str='';
	    $str.='<select id="'.$name_and_id.'" class="form-control" name="'.$name_and_id.'">';
	    $str.='<option value="">'.$this->lang->line('select thana').'</option>';
		for($i=0;$i<count($results);$i++)
      	{ 
      		$str.='<option value="'.$results[$i]['id'].'">'.$results[$i]['thana_name'].'</option>';      		
      	} 
      	$str.='</select>';		
		echo $str;	 	
	}

	
	function _random_number_generator($length=6)
	{

		$rand = substr(uniqid(mt_rand(), true) , 0, $length);
		return $rand;
	}

	function forgot_password()
	{
		$data['body']='page/forgot_password';
		$data['page_title']= $this->lang->line("forget password");
		$this->_front_viewcontroller($data);
	}

	function code_genaration()
	{
		if($_SERVER['REQUEST_METHOD'] === 'GET') 
		redirect('home/access_forbidden','location');

		$email=trim($this->input->post('email'));
		$result=$this->basic->get_data('users',array('where'=>array('email'=>$email)),array('count(*) as num'));
		
		if($result[0]['num']==1)
		{
			//entry to forget_password table
			$expiration=date("Y-m-d H:i:s", strtotime('+1 day', time()));
			$code=$this->_random_number_generator();
			$url=site_url().'home/password_recovery';

			$table='forget_password';
			$info=array(
				'confirmation_code'=>$code,
				'email'=>$email,
				'expiration'=>$expiration
				);
			if($this->basic->insert_data($table,$info))
			{
			//email to user
				$message="<p>". $this->lang->line('to reset your password please perform the following steps').":"."</p>
							<ol>
								<li>".$this->lang->line('go to this url').":".$url."</li>
								<li>".$this->lang->line('enter this code').":".$code."</li>
								<li>".$this->lang->line('reset password')."</li>
							<ol>
							<h4>".$this->lang->line('the code and the url will expire after 24 hours')."</h4>";
				
				$from=$this->config->item('support_email');
				$to=$email;
				$subject=$this->config->item('product_name')." | Reset Password";
				$mask=$subject;
				$html=1;
				$this->_mail_sender($from,$to,$subject,$message,$mask,$html);					
			}

		}
		else
		{
			echo 0;
		}
	
	}

	function password_recovery()
	{
		$data['body']='page/password_recovery';
		$data['page_title']= $this->lang->line("forget recovery");
		$this->_front_viewcontroller($data);
	}


	function recovery_check()
	{
		if($_POST)
		{
			$code=trim($this->input->post('code'));
			$newp=md5($this->input->post('newp'));
			$conf=md5($this->input->post('conf'));

			$table='forget_password';
			$where['where']=array('confirmation_code'=>$code,'success'=>0);
			$select=array('email','expiration');

			$result=$this->basic->get_data($table,$where,$select);

			if(empty($result))
			{
				echo 0;
			}
			else
			{
				foreach($result as $row)
				{
					$email=$row['email'];
					$expiration=$row['expiration'];
				}

				$now=time();
				$exp=strtotime($expiration);

				if($now>$exp)
				{
					echo 1;
				}
				else
				{
					$this->basic->update_data('users',array('email'=>$email),array('password'=>$newp));
					$this->basic->update_data('forget_password',array('confirmation_code'=>$code),array('success'=>1));
					echo 2;
				}
			}			
		}

	}

	/**** This function returns an array with the 'student_id' and 'class_roll' ****/
	public function _get_student_id($session_id=0,$dept_id=0,$shift_id=0)
	{
		
		if($session_id==0 || $dept_id==0 || $shift_id==0) return array('student_id'=>NULL,'class_roll'=>NULL);

		/****** Get the session_name *****/
		
		$where_simple=array('id'=>$session_id);
		$where=array('where'=>$where_simple);	
		$session_info=$this->basic->get_data('session',$where,$select='',$join='',$limit='',$start='',$order_by='',$group_by='',$num_rows=0);	
		/***Take firsr year from two year***/
		$session_name=$session_info[0]['name'];
		$session_sep=explode("-",$session_name);
		$session=$session_sep[0];
		
		/***padding the department id as two digit***/
		$department=str_pad($dept_id,2,'0',STR_PAD_LEFT);
		$shift=str_pad($shift_id,2,'0',STR_PAD_LEFT);
		
		
		/****** update class_roll table as the last_used_roll. **********/
		$this->basic->update_last_roll($session_id,$dept_id,$shift_id);
		
		/*** Get the last_roll used ****/
		$where_simple=array('session_id'=>$session_id,"dept_id"=>$dept_id,"shift_id"=>$shift_id);
		$where=array('where'=>$where_simple);	
		$last_roll_info=$this->basic->get_data('class_roll',$where,$select='',$join='',$limit='',$start='',$order_by='',$group_by='',
												$num_rows=0);
		
		/***If already admitted any student , then in database a row will be available, but if not, then no row will be avaialable there. So just need to check already available not not. If not available then let the last_used_roll = department.start_roll ***/		
		if(isset($last_roll_info[0]['last_used_roll'])){
				$last_used_roll=$last_roll_info[0]['last_used_roll'];
		}
		
		$used_roll=str_pad($last_used_roll,3,'0',STR_PAD_LEFT);
		
		$id=trim($session).$department.$shift.$used_roll; 
		
		$st_info=array('student_id'=>$id,'class_roll'=>$used_roll);
		
		return $st_info;
	}



	function blood_group_generator()
	{		
		$blood_groups=array(
		''=>'Blood Group',
		'A+'=>'A+',
		'A-'=>'A-',	
		'B+'=>'B+',	
		'B-'=>'B-',
		'O+'=>'O+',	
		'O-'=>'O-',
		'AB+'=>'AB+',
		'AB-'=>'AB-'			
		);		
		return $blood_groups;
	}	

	function religion_generator()    
	{
		$religion=array
		(
			'Islam'=>'Islam',
			'Hinduism'=>'Hinduism',
			'Christanity'=>'Christanity',
			'Buddhist'=>'Buddhist',
			'Others'=>'Others'
		);			
		
		return $religion;		
	}

	function year_generator($end_year,$starting_year)    
	{	
		$year=array();
		$year['']='Year';
		for($i=$end_year;$i>=$starting_year;$i--)                
		{	
			$year[$i]=$i;				
		}
		 return $year;		
	}		
	
	function get_active_financial_year() // active financial year
	{
		$sessions=array();
		$table='financial_year';		
		$select=array('id','name');	
		$where=array('where'=>array('status'=>'1'));
		$results=$this->basic->get_data($table,$where,$select);
		foreach ($results as $row) 
		{
			$sessions[$row['id']]=$row['name'];
			break;
		}
		return $sessions;
	}
	
	function get_session_info($session_id)
	{
		
		$sessions=array();
		$table='session';		
		$select=array('id','name');	
		$where=array('where'=>array('id'=>$session_id));
		$results=$this->basic->get_data($table,$where,$select);
		foreach ($results as $row) 
		{
			$sessions[$row['id']]=$row['name'];
			break;
		}
		return $sessions;
	}

	function get_dept_info($dept_id)
	{
		
		$depts=array();
		$table='department';		
		$select=array('id','dept_name');	
		$where=array('where'=>array('id'=>$dept_id));
		$results=$this->basic->get_data($table,$where,$select);
		foreach ($results as $row) 
		{
			$depts[$row['id']]=$row['dept_name'];
			break;
		}
		return $depts;
	}	

	function get_ranks($for="Teacher")  
	{
		$ranks=array();
		$table='rank';		
		$select=array('id','rank_name');	
		$where=array('where'=>array('for'=>$for));
		$results=$this->basic->get_data($table,$where,$select,$join='',$limit='',$start='',$order_by='rank_name asc');
		foreach ($results as $row) 
		{
			$ranks[$row['id']]=$row['rank_name'];
		}
		return $ranks;
	}

	function get_sessions()  
	{
		$sessions=array();
		$table='session';		
		$select=array('id','name');	
		$results=$this->basic->get_data($table,$where='',$select,$join='',$limit='',$start='',$order_by='name asc',$group_by='',$num_rows=0);
		foreach ($results as $row) 
		{
			$sessions[$row['id']]=$row['name'];
		}
		return $sessions;
	}

	function get_financals(){
		$sessions=array();
		$table='financial_year';		
		$select=array('id','name');	
		$results=$this->basic->get_data($table,$where='',$select,$join='',$limit='',$start='',$order_by='name asc',$group_by='',$num_rows=0);
		foreach ($results as $row) 
		{
			$sessions[$row['id']]=$row['name'];
		}
		return $sessions;
	}

	function get_latest_session()  
	{
		$sessions=array();
		$select=array('id','name');	
		$table="session";
		$results=$this->basic->get_data($table,$where='',$select,$join='',$limit='1',$start='0',$order_by='id DESC');
		foreach ($results as $row) 
		{
			$sessions[$row['id']]=$row['name'];
			break;
		}
		return $sessions;
	}


	function get_sessions_online()  // sessions that has online admission configured
	{
		$sessions=array();
		$table='online_admission_configure';		
		$select=array('distinct(session_id)');	
		$results=$this->basic->get_data($table,$where=array('where'=>array('is_admission_open'=>'1','application_last_date >=' =>date("Y-m-d"))),$select);
		foreach ($results as $row) 
		{
			$sessions[]=$row['session_id'];
		}

		$online_sessions=array();
		$table='session';		
		$select=array('id','name');	
		$online_results=$this->basic->get_data($table,$where=array('where_in'=>array('id'=>$sessions)),$select,$join='',$limit='',$start='',$order_by='name asc');
		foreach ($online_results as $row) 
		{
			$online_sessions[$row['id']]=$row['name'];
		}
		return $online_sessions;

	}

	function get_sections()  
	{
		$sections=array();
		$table='class_section';		
		$select=array('id','section_name');	
		$results=$this->basic->get_data($table,$where='',$select,$join='',$limit='',$start='',$order_by='section_name asc',$group_by='',$num_rows=0);
		foreach ($results as $row) 
		{
			$sections[$row['id']]=$row['section_name'];
		}
		return $sections;
	}

	function get_quotas() 
	{
		$quotas=array();
		$table='quota';		
		$select=array('id','quota_name');	
		$results=$this->basic->get_data($table,$where='',$select,$join='',$limit='',$start='',$order_by='quota_name asc',$group_by='',$num_rows=0);
		foreach ($results as $row) 
		{
			$quotas[$row['id']]=$row['quota_name'];
		}
		return $quotas;
	}


	function get_districts()
	{
		
		$table='district';
		$where['where'] = array('status' => 1);		
		$results=$this->basic->get_data($table,$where);
		$districts=array();
		foreach ($results as $row) 
		{
			$districts[$row['id']]=$row['district_name'];
		}
		return $districts;
	}


	function get_boards()   
	{
		$universities=array();
		$table='university_board';		
		$select=array('id','institute_name');	
		$where_simple=array('is_university '=>0);
		$where=array('where'=>$where_simple);
		$results=$this->basic->get_data($table,$where,$select,$join='',$limit='',$start='',$order_by='institute_name asc',$group_by='',$num_rows=0);
		foreach ($results as $row) 
		{
			$universities[$row['id']]=$row['institute_name'];
		}
		return $universities;
		 		
	}
	
	function get_universities()  
	{
		$universities=array();
		$table='university_board';		
		$select=array('id','institute_name');	
		$where_simple=array('is_university '=>1);
		$where=array('where'=>$where_simple);
		$results=$this->basic->get_data($table,$where,$select,$join='',$limit='',$start='',$order_by='institute_name asc',$group_by='',$num_rows=0);
		foreach ($results as $row) 
		{
			$universities[$row['id']]=$row['institute_name'];
		}
		return $universities;
	}

	function get_classes()  
	{
		$classes=array();
		$table='class';		
		$select=array('id','class_name');	
		$results=$this->basic->get_data($table,$where='',$select,$join='',$limit='',$start='',$order_by='ordering asc',$group_by='',$num_rows=0);
		foreach ($results as $row) 
		{
			$classes[$row['id']]=$row['class_name'];
		}
		return $classes;
	}


	function get_classes_online()  // classes that has online admission configured
	{
		$classes=array();
		$table='online_admission_configure';		
		$select=array('distinct(class_id)');	
		$results=$this->basic->get_data($table,$where=array('where'=>array('is_admission_open'=>'1','application_last_date >=' =>date("Y-m-d"))),$select);
		foreach ($results as $row) 
		{
			$classes[]=$row['class_id'];
		}
		$online_classes=array();
		$table='class';		
		$select=array('id','class_name');	
		$online_results=$this->basic->get_data($table,$where=array('where_in'=>array('id'=>$classes)),$select,$join='',$limit='',$start='',$order_by='class_name asc');
		foreach ($online_results as $row) 
		{
			$online_classes[$row['id']]=$row['class_name'];
		}
		return $online_classes;

	}


	function get_classes_search()  
	{
		$classes=array();
		$table='class';		
		$select=array('id','class_name');	
		$results=$this->basic->get_data($table,$where='',$select,$join='',$limit='',$start='',$order_by='ordering asc',$group_by='',$num_rows=0);
		foreach ($results as $row) 
		{
			$classes[$row['class_name']]=$row['class_name'];
		}
		return $classes;
	}

	function get_shifts()  
	{
		$shifts=array();
		$table='class_shift';		
		$select=array('id','shift_name');	
		$results=$this->basic->get_data($table,$where='',$select,$join='',$limit='',$start='',$order_by='id asc',$group_by='',$num_rows=0);
		foreach ($results as $row) 
		{
			$shifts[$row['id']]=$row['shift_name'];
		}
		return $shifts;
	}

	function get_book_category()  
	{
		$category=array();
		$table='library_category';		
		$select=array('id','category_name');	
		$results=$this->basic->get_data($table,$where='',$select,$join='',$limit='',$start='',$order_by='category_name asc',$group_by='',$num_rows=0);
		foreach ($results as $row) 
		{
			$category[$row['id']]=$row['category_name'];
		}
		return $category;
	}

	function get_periods()  
	{
		$periods=array();
		$table='class_period';		
		$select=array('id','period_name');	
		$results=$this->basic->get_data($table,$where='',$select,$join='',$limit='',$start='',$order_by='ordering asc',$group_by='',$num_rows=0);
		$i=1;
		foreach ($results as $row) 
		{
			$periods[$i]=array('period_name'=>$row['period_name'],'period_id'=>$row['id']);
			$i++;
		}
		return $periods;
	}
	
	function get_course($dept_id,$class_id,$session_id)
	{
		$courses=array();
		$table="course";
		$where=array('where'=>array('dept_id'=>$dept_id,'class_id'=>$class_id,'session_id'=>$session_id));
		$results=$this->basic->get_data($table,$where,$select='',$join='',$limit='',$start='',$order_by='id asc',$group_by='',$num_rows=0);
		foreach ($results as $row) 
		{
			$courses[$row['id']]=$row['course_name']."(".$row['course_code'].")";
		}
		return $courses;
	}

	function get_notice_types() // 'Notice','News-Events','Syllabus','Miscellaneous'
	{
		$notice_types=$this->basic->get_enum_values($table="notice",$column="type");
		foreach($notice_types as $row)
		$return_array[trim($row)]=trim($row);
		return $return_array;
	}


	function get_slip_types() // Admission, Post Admission
	{
		$payment_types=$this->basic->get_enum_values($table="slip",$column="slip_type");
		foreach($payment_types as $row)
		$return_array[trim($row)]=trim($row);
		return $return_array;
	}

	function get_book_size()
	{
		$book_sizes=$this->basic->get_enum_values($table="library_book_info",$column="size1");
		foreach($book_sizes as $row)
		$return_array[trim($row)]=trim($row);
		return $return_array;
	}
	function get_book_status()
		{
			$all_book_status=$this->basic->get_enum_values($table="library_book_info",$column="status");
			foreach($all_book_status as $row)
			$return_array[trim($row)]=trim($row);
			return $return_array;
		}

	function get_exam_versions() 
	{
		$result=$this->basic->get_enum_values($table="applicant_info",$column="exam_version");
		foreach($result as $row)
		{
			$exam_version[$row]=$row;
		}
		return $exam_version;
	}
	
	function get_teacher()
	{
	
		$teachers=array();
		$table="teacher_info";
		$results=$this->basic->get_data($table,$where='',$select='',$join='',$limit='',$start='',$order_by='id asc',$group_by='',$num_rows=0);
		foreach ($results as $row) 
		{
			$teachers[$row['id']]=$row['teacher_name'];
		}
		return $teachers;
	}

	public function get_default_shift()
	{
		$select = array('id','shift_name');
		$where['where'] = array('default' => '1');
		$active_shifts = $this->basic->get_data('class_shift',$where,$select);
		foreach($active_shifts as $active_shift){
			$default_shift['id'] = $active_shift['id'];
			$default_shift['shift_name'] = $active_shift['shift_name'];
		}
		return $default_shift;
	}

	public function get_default_section()
	{
		$select = array('id','section_name');
		$where['where'] = array('default' => '1');
		$active_sections = $this->basic->get_data('class_section',$where,$select);
		foreach($active_sections as $active_section){
			$default_section['id'] = $active_section['id'];
			$default_section['section_name'] = $active_section['section_name'];
		}
		return $default_section;
	}


	public function get_default_department($class_id=0)
	{
		if($class_id==0) return array();
		$select = array('id','dept_name');
		$where['where'] = array('default' => '1','class_id'=>$class_id);
		$default_dept_array = $this->basic->get_data('department',$where,$select);
		foreach($default_dept_array as $default_dept)
		{
			$default_dept['id'] = $default_dept['id'];
			$default_dept['dept_name'] = $default_dept['dept_name'];
		}
		return $default_dept;
	}

	// =====================AJAX on change fuctions=====================
	function dept_select_as_class_crud($class_id='Null',$teacher_id="Null")  
	{
		if($_SERVER['REQUEST_METHOD'] === 'GET') 
		redirect('home/access_forbidden','location');
		
		if($teacher_id=="Null")
		{
			$table='department';
			$where_simple=array('class_id'=>$class_id);
			$where=array('where'=>$where_simple);
			$results=$this->basic->get_data($table,$where,$select='',$join='',$limit='',$start='',$order_by='dept_name asc',$group_by='',$num_rows=0);
		}
		else
		{
			$table='view_class_routine';
			$select=array("id","dept_name");
			$where_simple=array('class_id'=>$class_id,'teacher_id'=>$teacher_id);
			$where=array('where'=>$where_simple);
			$results=$this->basic->get_data($table,$where,$select,$join='',$limit='',$start='',$order_by='dept_name asc',$group_by='dept_id',$num_rows=0);
		}

		$str='';
	    $str.='<select id="field-dept_id" name="dept_id">';
	    $str.='<option value="">'.$this->lang->line('group / dept.').'</option>';
		for($i=0;$i<count($results);$i++)
      	{ 
      		$str.='<option value="'.$results[$i]['id'].'">'.$results[$i]['dept_name'].'</option>';      		
      	} 
      	$str.='</select>';		
		echo $str;	 	
	}

	function course_select_as_class_crud($class_id='Null',$teacher_id="Null")  
	{
		if($_SERVER['REQUEST_METHOD'] === 'GET') 
		redirect('home/access_forbidden','location');
		
		if($teacher_id=="Null")
		{
			$table='course';
			$where_simple=array('class_id'=>$class_id);
			$where=array('where'=>$where_simple);
			$results=$this->basic->get_data($table,$where,$select='',$join='',$limit='',$start='',$order_by='course_name asc',$group_by='',$num_rows=0);
		}
		else
		{
			$table='view_class_routine';
			$select=array("id","course_name");
			$where_simple=array('class_id'=>$class_id,'teacher_id'=>$teacher_id);
			$where=array('where'=>$where_simple);
			$results=$this->basic->get_data($table,$where,$select,$join='',$limit='',$start='',$order_by='course_name asc',$group_by='course_id',$num_rows=0);
		}

		$str='';
	    $str.='<select id="field-course_id" name="course_id">';
	    $str.='<option value="">'.$this->lang->line('course').'</option>';
		for($i=0;$i<count($results);$i++)
      	{ 
      		$str.='<option value="'.$results[$i]['id'].'">'.$results[$i]['course_name'].'</option>';      		
      	} 
      	$str.='</select>';		
		echo $str;	 	
	}


	function dept_select_as_class($class_id='Null',$teacher_id="Null")  
	{
		if($_SERVER['REQUEST_METHOD'] === 'GET') 
		redirect('home/access_forbidden','location');
		
		if($teacher_id=="Null")
		{
			$table='department';
			$where_simple=array('class_id'=>$class_id);
			$where=array('where'=>$where_simple);
			$results=$this->basic->get_data($table,$where,$select='',$join='',$limit='',$start='',$order_by='dept_name asc',$group_by='',$num_rows=0);
			$str='';
		    $str.='<select id="dept_id" name="dept_id" class="form-control">';
		    $str.='<option value="">'.$this->lang->line('group / dept.').'</option>';
			for($i=0;$i<count($results);$i++)
	      	{ 
	      		$str.='<option value="'.$results[$i]['id'].'">'.$results[$i]['dept_name'].'</option>';      		
	      	} 
	      	$str.='</select>';		
			echo $str;	
		}
		else
		{
			$table='view_class_routine';
			$select=array("id","dept_name","dept_id");
			$where_simple=array('class_id'=>$class_id,'teacher_id'=>$teacher_id);
			$where=array('where'=>$where_simple);
			$results=$this->basic->get_data($table,$where,$select,$join='',$limit='',$start='',$order_by='dept_name asc',$group_by='dept_id',$num_rows=0);
			$str='';
		    $str.='<select id="dept_id" name="dept_id" class="form-control">';
		    $str.='<option value="">'.$this->lang->line('group / dept.').'</option>';
			for($i=0;$i<count($results);$i++)
	      	{ 
	      		$str.='<option value="'.$results[$i]['dept_id'].'">'.$results[$i]['dept_name'].'</option>';      		
	      	} 
	      	$str.='</select>';		
			echo $str;	
		}

		 	
	}

	function course_select_as_class($class_id='Null',$teacher_id="Null")  
	{
		if($_SERVER['REQUEST_METHOD'] === 'GET') 
		redirect('home/access_forbidden','location');
		
		if($teacher_id=="Null")
		{
			$table='course';
			$where_simple=array('class_id'=>$class_id);
			$where=array('where'=>$where_simple);
			$results=$this->basic->get_data($table,$where,$select='',$join='',$limit='',$start='',$order_by='course_name asc',$group_by='',$num_rows=0);
			$str='';
		    $str.='<select id="course_id" name="course_id" class="form-control">';
		    $str.='<option value="">'.$this->lang->line('course').'</option>';
			for($i=0;$i<count($results);$i++)
	      	{ 
	      		$str.='<option value="'.$results[$i]['id'].'">'.$results[$i]['course_name'].'</option>';      		
	      	} 
	      	$str.='</select>';		
			echo $str;	
		}
		else
		{
			$table='view_class_routine';
			$select=array("id","course_name","course_id");
			$where_simple=array('class_id'=>$class_id,'teacher_id'=>$teacher_id);
			$where=array('where'=>$where_simple);
			$results=$this->basic->get_data($table,$where,$select,$join='',$limit='',$start='',$order_by='course_name asc',$group_by='course_id',$num_rows=0);
			
			$str='';
		    $str.='<select id="course_id" name="course_id" class="form-control">';
		    $str.='<option value="">'.$this->lang->line('course').'</option>';
			for($i=0;$i<count($results);$i++)
	      	{ 
	      		$str.='<option value="'.$results[$i]['course_id'].'">'.$results[$i]['course_name'].'</option>';      		
	      	} 
	      	$str.='</select>';		
			echo $str;	
		}

		 	
	}
	//=====================AJAX on change fuctions=====================

	public function get_physical_form()
    {
        $all_physical_form = $this->basic->get_enum_values($table = "library_book_info", $column = "physical_form");
        foreach ($all_physical_form as $row) {
            $return_array[trim($row)] = $this->lang->line(trim($row));
        }
        return $return_array;
    }

     public function get_book_source_details()
    {
        $all_source_details = $this->basic->get_enum_values($table = "library_book_info", $column = "source_details");
        foreach ($all_source_details as $row) {
            $return_array[trim($row)] = $this->lang->line(trim($row));
        }
        return $return_array;
    }


    // ************************************************************* //


    function get_general_content($url,$proxy=""){
        $ch = curl_init(); // initialize curl handle
        /* curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);*/
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible;)");
        curl_setopt($ch, CURLOPT_AUTOREFERER, false);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 7);
        curl_setopt($ch, CURLOPT_REFERER, 'http://'.$url);
        curl_setopt($ch, CURLOPT_URL, $url); // set url to post to
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);// allow redirects
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // return into a variable
        curl_setopt($ch, CURLOPT_TIMEOUT, 50); // times out after 50s
        curl_setopt($ch, CURLOPT_POST, 0); // set POST method

     
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_COOKIEJAR, "my_cookies.txt");
        curl_setopt($ch, CURLOPT_COOKIEFILE, "my_cookies.txt");
        
        $content = curl_exec($ch); // run the whole process
        
        curl_close($ch);
        
        return $content;
            
    }

    public function member_validity()
    {
        if($this->session->userdata('logged_in') == 1 && $this->session->userdata('user_type') != 'Admin') {
            $where['where'] = array('id'=>$this->session->userdata('user_id'));
            $user_expire_date = $this->basic->get_data('users',$where,$select=array('expired_date'));
            $expire_date = strtotime($user_expire_date[0]['expired_date']);
            $current_date = strtotime(date("Y-m-d"));
            $package_data=$this->basic->get_data("users",$where=array("where"=>array("users.id"=>$this->session->userdata("user_id"))),$select="package.price as price",$join=array('package'=>"users.package_id=package.id,left"));
            if(is_array($package_data) && array_key_exists(0, $package_data))
            $price=$package_data[0]["price"];
            if($price=="Trial") $price=1;
            if ($expire_date < $current_date && ($price>0 && $price!=""))
            redirect('payment/member_payment_history','Location');
        }
    }
    


    public function important_feature(){

         if(file_exists(APPPATH.'config/licence.txt') && file_exists(APPPATH.'core/licence.txt')){
            $config_existing_content = file_get_contents(APPPATH.'config/licence.txt');
            $config_decoded_content = json_decode($config_existing_content, true);

            $core_existing_content = file_get_contents(APPPATH.'core/licence.txt');
            $core_decoded_content = json_decode($core_existing_content, true);

            if($config_decoded_content['is_active'] != md5($config_decoded_content['purchase_code']) || $core_decoded_content['is_active'] != md5(md5($core_decoded_content['purchase_code']))){
              redirect("home/credential_check", 'Location');
            }
            
        } else {
            redirect("home/credential_check", 'Location');
        }

    }


    public function credential_check()
    {
        $data['body'] = 'front/credential_check';
        $data['page_title'] = "Credential Check";
        $this->_front_viewcontroller($data);
    }

    public function credential_check_action()
    {
        $domain_name = $this->input->post("domain_name",true);
        $purchase_code = $this->input->post("purchase_code",true);
        $only_domain = get_domain_only($domain_name);
       $response=$this->code_activation_check_action($purchase_code,$only_domain);
       echo $response;

    }


    

    public function code_activation_check_action($purchase_code,$only_domain){

        $url = "http://xeroneit.net/development/envato_license_activation/purchase_code_check.php?purchase_code={$purchase_code}&domain={$only_domain}&item_name=sitespy";

        $credentials = $this->get_general_content($url);
        $decoded_credentials = json_decode($credentials);
        if($decoded_credentials->status == 'success'){
            $content_to_write = array(
                'is_active' => md5($purchase_code),
                'purchase_code' => $purchase_code,
                'item_name' => $decoded_credentials->item_name,
                'buy_at' => $decoded_credentials->buy_at,
                'licence_type' => $decoded_credentials->license,
                'domain' => $only_domain,
                'checking_date'=>date('Y-m-d')
                );
            $config_json_content_to_write = json_encode($content_to_write);
            file_put_contents(APPPATH.'config/licence.txt', $config_json_content_to_write, LOCK_EX);

            $content_to_write['is_active'] = md5(md5($purchase_code));
            $core_json_content_to_write = json_encode($content_to_write);
            file_put_contents(APPPATH.'core/licence.txt', $core_json_content_to_write, LOCK_EX);

            return json_encode("success");

        } else {
            if(file_exists(APPPATH.'core/licence.txt')) unlink(APPPATH.'core/licence.txt');
            return json_encode($decoded_credentials);
        }
    }

    public function periodic_check(){

        $today= date('d');

        if($today%7==0){

          if(file_exists(APPPATH.'config/licence.txt') && file_exists(APPPATH.'core/licence.txt')){
                $config_existing_content = file_get_contents(APPPATH.'config/licence.txt');
                $config_decoded_content = json_decode($config_existing_content, true);
                $last_check_date= $config_decoded_content['checking_date'];
                $purchase_code  = $config_decoded_content['purchase_code'];
                $base_url = base_url();
                $domain_name    = get_domain_only($base_url);

                if( strtotime(date('Y-m-d')) != strtotime($last_check_date)){
                    $this->code_activation_check_action($purchase_code,$domain_name);         
                }
        }
     }
    }

    public function php_info($code="")
    {
        if($code=="1717")
        echo phpinfo();        
    }





}
