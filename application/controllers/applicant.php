<?php

require_once("home.php");
include("mpdf/mpdf.php");

class Applicant extends Home 

{
	function __construct()
	{
		parent::__construct();					// calling parent class methods explicity.
		$this->load->helper("url");				// loading url helper
		
		if($this->session->userdata('app_logged_in')!=1)
			redirect('online/applicant_login','location');
		$this->load->library('paypal_class');
		$this->user_id=$this->session->userdata('user_id');	
	}		

	public function index()
	{		
		$this->_app_viewcontroller();
	}	

	function download_view()
	{
		$data['file_name']=$this->session->userdata('app_dowload_file_name');
		$this->session->unset_userdata('app_dowload_file_name');
		if($data['file_name']!="")
		$this->load->view("page/download",$data);		
	}

	function _app_viewcontroller($data=array())
	{			
	
		if(!isset($data['body']))		
		$data['body'] = 'online_admission/applicant/profile';
	
		if(!isset($data['page_title']))
		$data['page_title']= $this->lang->line("applicant panel");

		if(!isset($data['crud']))
		$data['crud']=0;

		// getting admission config data
		$dept_id=$this->session->userdata('app_dept_id');
		$class_id=$this->session->userdata('app_class_id');
		$session_id=$this->session->userdata('app_session_id');

		$admission_config=array();
		$config_results=$this->basic->get_data("online_admission_configure",array('where'=>array('dept_id'=>$dept_id,'class_id'=>$class_id,'session_id'=>$session_id,"is_admission_open"=>"1","admission_last_date >= "=>date("Y-m-d")))); 
		foreach($config_results as $val)
		{
			$admission_config['form_price'] = $val['form_price']; 
			$this->session->set_userdata("app_form_price",$val['form_price']);
			$admission_config['is_admission_open'] = $val['is_admission_open']; 
			$admission_config['is_admission_test'] = $val['is_admission_test']; 			
			$admission_config['application_last_date'] = $val['application_last_date']; 
			$admission_config['send_sms_after_admission'] = $val['send_sms_after_admission']; 
			$admission_config['admission_test_date'] = $val['admission_test_date']; 
			$admission_config['result_publish_date'] = $val['result_publish_date']; 
			$admission_config['admission_last_date'] = $val['admission_last_date']; 
			$admission_config['notice_for_applicant'] = $val['notice_for_applicant']; 
			break;			
		}
		if(empty($admission_config))
		{
			$data=array("title"=>$this->lang->line("access revoked"),"message"=>$this->lang->line("you have no loger access to this page."));
			$this->load->view('page/message_page',$data);
			exit();
		}
		$data['admission_config']=$admission_config;
		// getting admission config data

		// getting profile data
		$id = $this->session->userdata('app_id');	
		$table = 'view_applicant_info';
		$where_simple = array("id" => $id);				
		$where = array('where'=> $where_simple);
		$result = $this->basic->get_data($table, $where);					
		$data['info'] = $result;
		// getting profile data	

		//getting slip data

		$class_id=$this->session->userdata("app_class_id");
		$dept_id=$this->session->userdata("app_dept_id");
		$session_id=$this->session->userdata("app_session_id");			
		$table = 'slip';
		$where_simple = array("class_id" => $class_id,"dept_id"=>$dept_id,"financial_year_id"=>$session_id,"slip_type"=>"Admission");				
		$where = array('where'=> $where_simple);
		$result = $this->basic->get_data($table, $where);
		if(count($result)==0 || (count($result)>0 && $result[0]['total_amount']<=0)) 
		{
			$data=array("title"=>"No Slip Found","message"=>$this->lang->line("no slip has been configured, please contact system administrator."));
			return $this->load->view('page/message_page',$data);
			exit();
		}

		else 
		$payment_amount = $result[0]['total_amount'];


		//for paypal
		$cancel_url=base_url()."applicant/index";
		$success_url=base_url()."applicant/index";

		$where['where'] = array('deleted'=>'0');
		$payment_config = $this->basic->get_data('payment_config',$where,$select='');
		if(!empty($payment_config)) {			
			$paypal_email = $payment_config[0]['paypal_email'];
            $currency = $payment_config[0]['currency'];
		} 

		else {
			$payment_amount = "";
			$paypal_email = "";
		}

		$this->paypal_class->mode="live";
		$this->paypal_class->cancel_url=$cancel_url;
		$this->paypal_class->success_url=$success_url;
		$this->paypal_class->notify_url=site_url()."paypal_ipn/ipn_notify";
        $this->paypal_class->amount=$payment_amount;
		$this->paypal_class->currency=$currency; //currency 
		$this->paypal_class->user_id=$id;
		$this->paypal_class->business_email=$paypal_email;
		$button = $this->paypal_class->set_button();	

		$data['button']= $button;

		$this->load->view('online_admission/theme_online/theme_online',$data);
	}

	public function download_application()
	{		
		//include("mpdf/mpdf.php");
		ini_set("memory_limit", "-1");
		set_time_limit(0);

		$mpdf = new mpdf("","A4",9,"");
		$mpdf->ignore_invalid_utf8 = true;
		// $mpdf->SetDisplayMode("fullpage");
		$mpdf->SetImportUse();
		$pagecount = $mpdf->SetSourceFile("templates/application.pdf");
		$tplid = $mpdf->ImportPage($pagecount);
		$mpdf->SetPageTemplate($tplid);
		$mpdf->AddPage();

		$id = $this->session->userdata('app_id');	
		$table = 'view_applicant_info';
		$where_simple = array("id" => $id);				
		$where = array('where'=> $where_simple);
		$results = $this->basic->get_data($table, $where);

		$date="Date: ".date("d/m/Y");
		$institute_name = $this->config->item('institute_address1');				
		foreach ($results as $row) 
		{
			$name_eng           = $row['name'];
			$name_bng           = $row['name_bangla'];
			$name_fth           = $row['father_name'];
			$name_mth           = $row['mother_name'];
			$name_grd           = $row['gurdian_name'];
			$grd_mobile         = $row['gurdian_mobile'];
			$grd_email          = $row['gurdian_email'];
			$applicant_email    = $row['email'];
			$applicant_mobile   = $row['mobile'];
			$prs_village        = $row['gurdian_present_village'];
			$prs_thana          = $row['gurdian_present_thana'];
			$prs_post_office    = $row['gurdian_present_post'];
			$prs_district       = $row['gurdian_present_district'];
			$prm_village        = $row['gurdian_permanent_village'];
			$prm_thana          = $row['gurdian_permanent_thana'];
			$prm_post_office    = $row['gurdian_permanent_post'];
			$prm_district       = $row['gurdian_permanent_district'];
			$date_of_birth      = date("d/m/Y",strtotime($row['birth_date']));
			$religion           = $row['religion'];
			$quota              = $row['quota_name'];
			$birth_certificate  = $row['birth_certificate_no'];
			$gender             = $row['gender'];
			$courses            = $row['courses'];
			$image            	= $row['image'];
			$class_name			= $row['class_name'];
			$dept_name			= $row['dept_name'];
			$shift_name			= $row['shift_name'];
			$session_name		= $row['session_name'];
		}
		if($quota=="") $quota="N/A";		

	
		$mpdf->writetext(166,25,     $date);
		$mpdf->writetext(54,85.5,    $name_eng);
		// $mpdf->writetext(54,93,      $name_bng);
		$mpdf->writetext(54,101.5,   $name_fth);
		$mpdf->writetext(54,109,     $name_mth);
		$mpdf->writetext(54,118.5,   $name_grd);
		$mpdf->writetext(54,126,     $grd_mobile);
		$mpdf->writetext(54,134,     $applicant_mobile);
		$mpdf->writetext(144,126,    $grd_email);
		$mpdf->writetext(144,133.5,  $applicant_email);
		$mpdf->writetext(54,149.5,   $prs_village);
		$mpdf->writetext(54,157.5,   $prs_thana);
		$mpdf->writetext(142,149,    $prs_post_office);
		$mpdf->writetext(142,157,    $prs_district);
		$mpdf->writetext(54,172.5,   $prm_village);
		$mpdf->writetext(54,180.3,   $prm_thana);
		$mpdf->writetext(142,172.6,  $prm_post_office);
		$mpdf->writetext(142,180.4,  $prm_district);
		$mpdf->writetext(54,187.8,   $date_of_birth);
		$mpdf->writetext(54,196,     $religion);
		$mpdf->writetext(58,203.5,   $quota);
		$mpdf->writetext(144,188,    $birth_certificate);
		$mpdf->writetext(144,196,    $gender);
		$mpdf->writetext(36,211.5,   $courses);


		$html="";
		$html="<h3 align='center'>{$institute_name} - Admission Form</h3>";
		$html.="<h4 align='center'>Session: {$session_name}</h4>";
		$html.="<h4 align='center'>Class: {$class_name}</h4>";
		$html.="<h4 align='center'>Group/ Dept.: {$dept_name}</h4>";
		$html.="<h4 align='center'>Shift: {$shift_name}</h4>";	
		$mpdf->writehtml($html);

		$src=base_url()."/barcode.php?code=".$id;
		$img="<img src='{$src}' width='150px' height='35px' style='float:left;margin-top:0in;'/>";
		$mpdf->WriteHTML($img);

		// $logo_src=$this->config->item('logo_path');
		// if($logo_src!="")
		// {
		// 	$logo="<img src='{$logo_src}' width='100px' height='100px' style='float:left;margin-top:-1.5in;'/>";
		// 	$mpdf->writehtml($logo);
		// }

		$src1=base_url().'upload/applicant/'.$image;
		$img1="<img src='{$src1}' width='125px' height='130px' style='float:right;margin-top:-.8in;'/>";
		$mpdf->writehtml($img1);

		$pdfFileName='download/applicant/admission_form/'.$id.'.pdf';
		$mpdf->output($pdfFileName);
		$this->session->set_userdata('app_dowload_file_name',$pdfFileName);
		redirect('applicant/download_view','location');
	}
	public function detail_pay_slip_data($id=0){

		if($id==0)
		redirect('home/access_forbidden','location');

		$where=array('where'=>array("status"=>"1"));
		$select=array("GROUP_CONCAT(CAST(account_head.id AS CHAR) SEPARATOR '/') AS account_head","GROUP_CONCAT(account_name SEPARATOR '/') AS account_name","type","account_type.id as account_type_id");
		$join=array('account_type'=>"account_type.id=account_head.account_type_id,left");
		$data['heads']=$this->basic->get_data('account_head',$where,$select,$join,$limit='',$start='',$order_by='account_name asc',$group_by='account_type_id',$num_rows=0);

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
        $all_id_str="";
                if(count($data['heads'])>0){
            foreach($data['heads'] as $head){ 
              	$heads_id_array=array();
              	$heads_name_array=array();
              	$heads_id_array=explode('/',$head['account_head']);
              	$heads_name_array=explode('/',$head['account_name']);  
              	$all_id_str=$all_id_str.$head['account_head']."/";

                for($i=0;$i<count($heads_id_array);$i++){
            	 	$input_name="head_".$heads_id_array[$i];
            	 	$input_value="";
            	 	if(array_key_exists($heads_id_array[$i],$data['xdata_account_head'])) 
            	 	$input_value=$data['xdata_account_head'][$heads_id_array[$i]];
            	 	$heads_name[] = $heads_name_array[$i];
            	 	$heads_value[] = $input_value;
                }  
            }

            $heads_array_len = count($heads_name);
            for ($i=0; $i < $heads_array_len; $i++){
               	$varLen = strlen($heads_name[$i]); 
                if($varLen>19){
                 	$final_heads_name[$i] = substr($heads_name[$i],0,17)."...";
                }else{
                 	$final_heads_name[$i] = $heads_name[$i];
                }
            }

            $slipData = array_combine($final_heads_name,$heads_value);
            return $slipData;
        }
	}
	public function download_slip_data(){

		$id = $this->session->userdata('app_id');
		$table = 'applicant_info';
		$where_simple = array("id" => $id);
		$where = array('where'=> $where_simple);
		$results = $this->basic->get_data($table, $where);

		$class_id = $results[0]['class_id'];
		$dept_id = $results[0]['dept_id'];
		$gender = $results[0]['gender'];
		$slip_type = "Admission";
		$financial_year_id = $results[0]['session_id'];

		$table = 'slip';
		$where_simple = array("class_id" => $class_id, "dept_id" => $dept_id, "slip_type" => $slip_type, "financial_year_id" => $financial_year_id);
		$where = array('where'=> $where_simple);
		$select = array('id');
		$results = $this->basic->get_data($table, $where, $select);

		$slip_id = $results[0]['id'];
		
		$pay_slip_data = $this->detail_pay_slip_data($slip_id);

		return $pay_slip_data;
	}

	public function download_slip(){
		$app_id = $this->session->userdata('app_id');

		$table = 'view_applicant_info';
		$where_simple = array("id" => $app_id);
		$where = array('where'=> $where_simple);
		$select = array('name','dept_name','id','session_name');
		$headingData = $this->basic->get_data($table, $where, $select);

		$slipData = $this->download_slip_data();
		$totalAmountForAppUser = array_sum($slipData);
		$inWordTotalAmountForAppUser = numtowords($totalAmountForAppUser);

		$arrayLen = sizeof($slipData);

		$leftSideSlipData = array_slice($slipData, 0, 20);
		$rightSideSlipData = array_slice($slipData, 20);

		$leftSideSlipDataKey = array_keys($leftSideSlipData);
		$leftSideSlipDataValue = array_values($leftSideSlipData);

		$rightSideSlipDataKey = array_keys($rightSideSlipData);
		$rightSideSlipDataValue = array_values($rightSideSlipData);

		$sizeLeftSideData = sizeof($leftSideSlipData);

		$instituteName = $this->config->item('institute_address1');

		ini_set("memory_limit", "-1");
    	set_time_limit(0);

    	$mpdf =  new mPDF('utf-8', array(279,220),10);

    	$mpdf->ignore_invalid_utf8 = true;
    	$mpdf->SetDisplayMode("fullpage");
    	$mpdf->SetImportUse();

    	$pagecount = $mpdf->SetSourceFile("templates/pay_info.pdf");

    	$tplid = $mpdf->ImportPage($pagecount);
    	$mpdf->SetPageTemplate($tplid);
    	$mpdf->AddPage();
    	$page_no = 0;
    	$html = "";
    	$k=0;

    	$src=base_url()."/barcode.php?code=".$headingData[0]['id'];
    	$img="<img src='{$src}' width='150px' height='35px' style='float:left;margin-top:0in;'/>";
		$mpdf->WriteFixedPosHTML($img,35,20,150,40);
		$mpdf->WriteFixedPosHTML($img,119,20,150,40);	
		$mpdf->WriteFixedPosHTML($img,203,20,150,40);

		// $logo_img_src = base_url()."/assets/images/logo_name.png";
		// $logo_img = "<img src='{$logo_img_src}' width='40px' height='40px' style='float:left;margin-top:0in;'/>";
		// $mpdf->WriteFixedPosHTML($logo_img,20,10,40,40);

		// echo "<pre>";
		// print_r($headingData);
		// echo "</pre>";die();


		for($i=0;$i<3;$i++){
    		$mpdf->writetext(15+$k,43,"Name: ".$headingData[0]['name']);
    		$mpdf->writetext(15+$k,48,"Dept.: ".$headingData[0]['dept_name']);   
    		$mpdf->writetext(15+$k,53,"Applicant Id: ".$headingData[0]['id']);   
    		$mpdf->writetext(15+$k,58,"Honours: 1st");   
    		$mpdf->writetext(50+$k,58,"Session: ".$headingData[0]['session_name']);
    		//$mpdf->Line(52+$k, 60, 52+$k, 175);
    		$k = $k+88; 
    	}

    	$currencyArray = $this->db->query("SELECT currency FROM `payment_config` WHERE 1")->result_array();
		$currencyValue = $currencyArray[0]['currency'];

    	//$mpdf->line(6,15,95,15); //first line
    	//$mpdf->line(95,20,184,20); // mid line
    	//$mpdf->line(184,15,273,15); // last line
    	//$mpdf->line(6,80,94,80);

    	$mpdf->line( 6,60, 6,175);
    	$mpdf->writetext(10,65,"Details");
    	$mpdf->line(37,60,37,175);
    	$mpdf->writetext(40,65,$currencyValue);
    	$mpdf->line(50,60,50,175);
    	$mpdf->writetext(54,65,"Details");
    	$mpdf->line(81,60,81,175);
    	$mpdf->writetext(84,65,$currencyValue);
    	$mpdf->line(94,60,94,175); //first block last line

    	$mpdf->line( 97,60, 97,175);
    	$mpdf->writetext(101,65,"Details");
    	$mpdf->line(128,60,128,175);
    	$mpdf->writetext(131,65,$currencyValue);
    	$mpdf->line(140,60,140,175);
    	$mpdf->writetext(144,65,"Details");
    	$mpdf->line(171,60,171,175);
    	$mpdf->writetext(174,65,$currencyValue);
    	$mpdf->line(183,60,183,175); // 2nd block last line

    	$mpdf->line(185,60,185,175);
    	$mpdf->writetext(189,65,"Details");
    	$mpdf->line(216,60,216,175);
    	$mpdf->writetext(219,65,$currencyValue);
    	$mpdf->line(229,60,229,175);
    	$mpdf->writetext(233,65,"Details");
    	$mpdf->line(260,60,260,175);
    	$mpdf->writetext(263,65,$currencyValue);
    	$mpdf->Line(273,60,273,175); // 3nd block last line

    	$mpdf->Line(6,60,273,60); //hr line first
    	$mpdf->Line(6,67,273,67); //hr line 2nd6

    	
    	//$mpdf->Line(6+88, 60, 6+88, 175); //first block last line
    	//$mpdf->Line(6+90, 60, 6+90, 175);
    	//$mpdf->Line(10+86+84, 60, 10+86+84, 175);
    	
    	//$mpdf->Line(10+84+84+84+84, 60, 10+84+84+84+84, 175);
	
    	$mpdf->SetFontSize(15);
		$mpdf->writetext(15,36,$instituteName);
		$mpdf->writetext(103,36,$instituteName);
		$mpdf->writetext(190,36,$instituteName);
    	$k=0;

    	// for($i=0;$i<6;$i++){
    		// $mpdf->writetext(10+$k,65,"Details");
    		//$mpdf->Line(40+$k, 60, 40+$k, 175);
    		// $mpdf->writetext(42+$k,65,"Taka");
    		// $k = $k+44;
		// }

		$mpdf->SetFontSize(7);

		 $k=0;
		 $xAxisData=0;
		 for($x=0; $x<3; $x++){
			for ($i=0; $i<$sizeLeftSideData; $i++) { 
				$mpdf->writetext(5+4+$xAxisData,75+$k,trim($leftSideSlipDataKey[$i]));
				$mpdf->writetext(42+$xAxisData,75+$k,trim($leftSideSlipDataValue[$i]));
				$mpdf->writetext(54+$xAxisData,75+$k,trim($rightSideSlipDataKey[$i]));
				$mpdf->writetext(84+$xAxisData,75+$k,trim($rightSideSlipDataValue[$i]));
				$k = $k+5;
			}
			$k=0;
			$xAxisData = $xAxisData + 90;
		}
		$mpdf->Line(10, 175, 346, 175);
		$mpdf->Line(10, 187, 346, 187);
		$k=0;
		for($i=0;$i<3;$i++){
    		$mpdf->SetFont('Arial','B',12);
    		$mpdf->writetext(25+$k,180,"Total Amount:");
    		$mpdf->writetext(60+$k,180,$totalAmountForAppUser." /=");
    		$mpdf->SetFont('Arial','',10);
    		//$mpdf->writetext(12+$k,186,"In Word:");
    		$mpdf->writetext(12+$k,185,$inWordTotalAmountForAppUser." taka only");
    		$mpdf->writetext(12+$k,195,"Receiver's Sign");
    		$mpdf->writetext(12+$k,210,"Date:");
    		$mpdf->writetext(12+$k+42,195,"Receiver's Sign");
    		$mpdf->writetext(12+$k+42,210,"Date:");
    		$k = $k+90; 
    	}
    	
    	$name_of_file = "ra.pdf";
    	$mpdf->output();

	}

	public function download_admit()
	{
		
		$id = $this->session->userdata('app_id');	
		$table = 'view_applicant_info';
		$where_simple = array("id" => $id);				
		$where = array('where'=> $where_simple);
		$results = $this->basic->get_data($table, $where);
		$date="Date: ".date("d/m/Y");
		$institute_name = $this->config->item('institute_address1');				
		foreach ($results as $row) 
		{
			$class_name=$row['class_name'];
			$class_id=$row['class_id'];
			$dept_name=$row['dept_name'];
			$dept_id=$row['dept_id'];
			$name_of_examinee=$row['name'];
			$name_of_father=$row['father_name'];
			$name_of_mother=$row['mother_name'];
			$date_of_birth=date("d/m/Y",strtotime($row['birth_date']));
			$exam_version=$row['exam_version'];
			$admission_roll=$row['admission_roll'];
			$session_name=$row['session_name'];	
			$session_id=$row['session_id'];	
			$shift_name=$row['shift_name'];	
			$image=$row['image'];	
		}
		$institute_name = $this->config->item('institute_address1');

		$admission_config=array();
		$config_results=$this->basic->get_data("online_admission_configure",array('where'=>array('dept_id'=>$dept_id,'class_id'=>$class_id,'session_id'=>$session_id,"is_admission_test"=>"1","admission_test_date >= "=>date("Y-m-d")))); 
		foreach($config_results as $val)		
		{			
			$admission_config['admission_test_date'] = date("d/m/Y",strtotime($val['admission_test_date'])); 
			break;			
		}

		if(empty($admission_config))
		{
			//$this->load->view("online_admission/page/expired");
			echo "No configuration found.";
			exit();
		}

		$exam_date="Exam Date: ".$admission_config['admission_test_date'];



		// include("mpdf/mpdf.php");
		ini_set("memory_limit", "-1");
		set_time_limit(0);
		$mpdf = new mpdf("","A4",9,"");
		$mpdf->ignore_invalid_utf8 = true;
		$mpdf->SetImportUse();
		$pagecount = $mpdf->SetSourceFile("templates/admit_card.pdf");
		$tplid = $mpdf->ImportPage($pagecount);
		$mpdf->SetPageTemplate($tplid);
		$mpdf->AddPage();

	
		// set a larger font for heading. set the function to default font size after use.
		$mpdf->writetext(50,84.7,       $name_of_examinee);
		$mpdf->writetext(50,93.2,    	$name_of_father);
		$mpdf->writetext(50,101.5,    	$name_of_mother);
		$mpdf->writetext(172,84.7,     	$admission_roll);
		$mpdf->writetext(172,93,   		$id);
		$mpdf->writetext(172,101.4,   	$date_of_birth);
		$mpdf->writetext(13,127,   	   $exam_date);

  		$html="";
		$html.="<h2 align='center'>{$institute_name}</h2>";		
		$html.="<h4 align='center'>Admission Test : {$session_name}</h4>";		
		$html.="<h4 align='center'>Class: {$class_name}</h4>";	
		$html.="<h4 align='center'>Group/ Dept.: {$dept_name}</h4>";
		$html.="<h4 align='center'>Shift: {$shift_name}</h4>";

		$mpdf->writehtml($html);

		$src=base_url()."/barcode.php?code=".$admission_roll;
		$img="<img src='{$src}' width='170px' height='30px' style='margin-top:-1i;'/>";
		$mpdf->WriteHTML($img);

	
		$src1=base_url().'upload/applicant/'.$image;
		$img1="<img src='{$src1}' style='float:right;height:130px;width:120px;margin-top:-1.4in;'/>";
		
		$pdfFileName="download/applicant/admit_card/".$id.".pdf";
		$mpdf->writehtml($img1);
		$mpdf->output($pdfFileName);
		$this->session->set_userdata('app_dowload_file_name',$pdfFileName);
		redirect('applicant/download_view','location');
		

	}

	public function update_application()
	{
		$data['body']='online_admission/applicant/update_application';
		$data['page_title']="Update Applicant";
		$data['quota_info']=$this->get_quotas();
		$data['shift_info']=$this->get_shifts();		
		$data['religion_info']=$this->religion_generator();
		$data['exam_version_info']=$this->get_exam_versions();
		// $data['district_info']=$this->get_districts();

		
		// getting xdata
		$id = $this->session->userdata('app_id');	
		$table = 'view_applicant_info';
		$where_simple = array("id" => $id);				
		$where = array('where'=> $where_simple);
		$result = $this->basic->get_data($table, $where);					
		$data['xdata'] = $result[0];
		// getting xdata	

		
		//getting xcourse
		$class_id = $result[0]['class_id'];
		$dept_id = $result[0]['dept_id'];
		$session_id = $result[0]['session_id'];
		$where_course['where'] = array
		(
			'class_id' => $class_id,
			'dept_id' => $dept_id,
			'session_id' => $session_id
		);
		$select_course = array('id','course_code','course_name','type');
		$data['courses'] = $this->basic->get_data('course',$where_course,$select_course);

		$where_xcourse['where'] = array("applicant_id"=>$id);
		$data['xcourses'] = $this->basic->get_data('applicant_course',$where_xcourse);
		//getting xcourse

		$this->_app_viewcontroller($data);
	}

	public function update_application_action() 
	{		
		if($_SERVER['REQUEST_METHOD'] === 'GET') 
		redirect('home/access_forbidden','location');

		$id = $this->session->userdata('app_id');

		if($_POST)
		{
			$this->form_validation->set_rules('student_name','<b>'.$this->lang->line("applicant name").'</b>', 'trim|required');	
			// $this->form_validation->set_rules('student_name_ben','<b>'.$this->lang->line("applicant\'s name").' (bengali)</b>', 'trim|required');	
			$this->form_validation->set_rules('father_name','<b>'.$this->lang->line("father name").'</b>', 'trim|required');	
			// $this->form_validation->set_rules('father_name_ben','<b>'.$this->lang->line("father\'s name").'</b>', 'trim');	
			$this->form_validation->set_rules('mother_name','<b>'.$this->lang->line("mother name").'</b>', 'trim|required');	
			// $this->form_validation->set_rules('mother_name_ben','<b>'.$this->lang->line("mother\'s name").'</b>', 'trim|required');	
			$this->form_validation->set_rules('date_of_birth','<b>'.$this->lang->line("date of birth").'</b>', 'trim|required');	
			// $birth_certificate_no_val = "applicant_info.birth_certificate_no.".$id;
			// $this->form_validation->set_rules('birth_certificate_no','<b>'.$this->lang->line('birth certificate no.').'</b>', "trim|required|is_unique[$birth_certificate_no_val]");	
			$this->form_validation->set_rules('gender','<b>'.$this->lang->line('gender').'</b>', 'trim|required');	
			$this->form_validation->set_rules('religion','<b>'.$this->lang->line('religion').'</b>', 'trim|required');	
			$this->form_validation->set_rules('mobile','<b>'.$this->lang->line('mobile').'</b>', 'trim|xss_clean');	
			$this->form_validation->set_rules('email','<b>'.$this->lang->line('email').'</b>', 'trim|xss_clean|valid_email');	
			$this->form_validation->set_rules('gurdian_name','<b>'.$this->lang->line("gurdian\'s name").'</b>', 'trim|required');	
			$this->form_validation->set_rules('gurdian_relation','<b>'.$this->lang->line('relation with gurdian').'</b>', 'trim|required');	
			$this->form_validation->set_rules('gurdian_occupation','<b>'.$this->lang->line('occupation').'</b>', 'trim|required');	
			$this->form_validation->set_rules('gurdian_income','<b>'.$this->lang->line('yearly income').'</b>', 'trim|required');	
			$this->form_validation->set_rules('gurdian_mobile','<b>'.$this->lang->line('mobile').'</b>', 'trim|required|xss_clean');	
			$this->form_validation->set_rules('gurdian_email','<b>'.$this->lang->line('email').'</b>', 'trim|xss_clean|valid_email');
			$this->form_validation->set_rules('previous_institute','<b>'.$this->lang->line('previous institute').'</b>', 'trim');	
			// $this->form_validation->set_rules('exam_version','<b>'.$this->lang->line('exam version').'</b>', 'trim');	
			$this->form_validation->set_rules('shift_id','<b>'.$this->lang->line('shift').'</b>', 'trim|required');					
			// $this->form_validation->set_rules('quota','<b>'.$this->lang->line('quota').'</b>', 'trim');				
			// $this->form_validation->set_rules('quota_description','<b>'.$this->lang->line('quota description').'</b>', 'trim');				
			$this->form_validation->set_rules('present_district','<b>'.$this->lang->line('present district').'</b>', 'trim|required');	
			$this->form_validation->set_rules('present_thana','<b>'.$this->lang->line('present thana').'</b>', 'trim|required');	
			$this->form_validation->set_rules('present_post','<b>'.$this->lang->line('present post').'</b>', 'trim|required');	
			$this->form_validation->set_rules('present_village','<b>'.$this->lang->line('permanent village').'</b>', 'trim|required');	
			$this->form_validation->set_rules('permanent_district','<b>'.$this->lang->line('permanent district').'</b>', 'trim|required');	
			$this->form_validation->set_rules('permanent_thana','<b>'.$this->lang->line('permanent thana').'</b>', 'trim|required');	
			$this->form_validation->set_rules('permanent_post','<b>'.$this->lang->line('permanent post').'</b>', 'trim|required');	
			$this->form_validation->set_rules('permanent_village','<b>'.$this->lang->line('permanent village').'</b>', 'trim|required');	
									
									
			if ($this->form_validation->run() == FALSE)
			{
				$this->update_application(); 
			}
			else
			{
				
				$xtable = 'view_applicant_info';
				$xwhere_simple = array("id" => $id);				
				$xwhere = array('where'=> $xwhere_simple);
				$xresult = $this->basic->get_data($xtable, $xwhere);
				$class_id=$xresult[0]['class_id'];	
				$dept_id=$xresult[0]['dept_id'];	
				$session_id=$xresult[0]['session_id'];	

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
				$courses = $this->input->post('course_id');
				$types = $this->input->post('type');							
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
						"overwrite"=>TRUE,
						"file_name" => $photo
					);
					$this->load->library('upload', $config);
					if($this->upload->do_upload('photo'))
					$photo_name = $photo;						
					else
					{
						$this->session->set_userdata('application_upload_error',$this->upload->display_errors());	
						return $this->update_application();

					}
				}				

				$this->db->trans_start();

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
				'shift_id' => $shift_id,
				'birth_date' => $birth_date,
				// 'birth_certificate_no' => $birth_certificate_no,
				'gender' => $gender,
				'registered_at'=>date("Y-m-d G:i:s"),	
				// 'exam_version'=>$exam_version				
				);			
				if($email != '') $data['email'] = $email;	
				else  $data['email'] = NULL;	
				if($gurdian_email != '') $data['gurdian_email'] = $gurdian_email;	
				else  $data['gurdian_email'] = NULL;	
				if($photo_name != '') $data['image'] = $photo_name ;		
				
				$this->basic->update_data('applicant_info',array("id"=>$id),$data);
				$applicant_id = $id;

				$this->basic->delete_data('applicant_course',array("applicant_id"=>$id));

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
					return $this->update_application();
				}	
				else	
				{
					$this->session->set_flashdata("application_success",$this->lang->line("your application has been updated successfully."));
					redirect('applicant/index','location');	
				}
			} //end else
		} //end if	
	}

	public function pay_form_fees()
	{			
		$bkash_info=array(0=>array());
		$dbbl_info =array(0=>array());
		$bkash_info=$this->basic->get_data("payment_method",array('where'=>array('id'=>$this->config->item('bkash_method_id'))));
		$dbbl_info =$this->basic->get_data("payment_method",array('where'=>array('id'=>$this->config->item('dbbl_method_id'))));
		$data['bkash_info']=$bkash_info[0];
		$data['dbbl_info']=$dbbl_info[0];
		$data['body']='online_admission/applicant/pay_form_fees';
		$data['page_title']= $this->lang->line("pay form fees");
		$this->_app_viewcontroller($data);
	}

	public function pay_form_fees_action()
	{
		if($_SERVER['REQUEST_METHOD'] === 'GET') 
		redirect('home/access_forbidden','location');

		
		$this->form_validation->set_rules('method','<b>'.$this->lang->line('payment method').'</b>', 'trim|required');	
		$this->form_validation->set_rules('trxid','<b>'.$this->lang->line('transaction id').'</b>', 'trim|required|integer');		
								
		if ($this->form_validation->run() == FALSE)
		{
			return $this->pay_form_fees(); 
		}
		

		$trxid=$this->input->post('trxid');
		$payment_method=$this->input->post('method');
		$app_id=$this->session->userdata('app_id'); 		
		$price=$this->session->userdata("app_form_price");
		$paid_amount=0;
		$transaction_reference=NULL;
		$bkash_valid_transaction=0; // flag to check transaction is valid or not 
		$response=1;

		//checking if the trxid is already used or not
		$where=array('where'=>array('transaction_id'=>$trxid,'payment_method_id'=>$payment_method));	
		$count_rows=$this->basic->get_data("form_sell",$where,$select="",$join='',$limit='',$start='',$order_by='',$group_by='',$num_rows=1);
		$num_rows=$count_rows['extra_index']['num_rows'];
			if($num_rows>0)
		{
			$response="TrxID already used.";	
			$this->session->set_userdata('transaction_error', $response);
			return $this->pay_form_fees(); 
		}					
							
		if($payment_method==$this->config->item('bkash_method_id')) // if bkash
		{
			$transaction_details=$this->bkash_api->get_info_by_trxid($trxid);	
			$transaction_status="";						
			foreach($transaction_details as $transaction)
			{
				$transaction_status=$transaction->trxStatus;
				if($transaction_status=="0000") // if transaction okay
				{
					$bkash_valid_transaction=1; 
					$transaction_amount=$transaction->amount;
					$transaction_reference=$transaction->reference;
					$paid_amount=$transaction_amount;
				}																
			}
			if($bkash_valid_transaction==1) // if transaction okay
			{
				if($transaction_reference!="F".$app_id)
				$response= $this->lang->line("trxid does not match with refference ID");
				else if($transaction_amount<$price)
				$response= $this->lang->line("insufficient payment.");
			} 
			else
			{
				switch($transaction_status)
				{
					case 0010:
					$response= $this->lang->line("TrxID is valid but transaction is in pending state.");
					break;
						
					case 0011:
					$response=  $this->lang->line("TrxID is valid but transaction is in pending state.");
					break;
					
					case 0100:
					$response= $this->lang->line("TrxID is valid but transaction has been reversed.");
					break;
					
					case 0111:
					$response= $this->lang->line("TrxID is valid but transaction has failed.");
					break;
						
					case 1001:
					$response= $this->lang->line("Invalid MSISDN input. Try with correct mobile no.");
					break;
					
					case 1002:
					$response= $this->lang->line("Invalid TrxID, it does not exist.");
					break;
					
					case 9999:
					$response= $this->lang->line("Could not process request.");
					break;
						
					case 1004:
					$response= $this->lang->line("TrxID is not related to this username.");
					break;	
				}
			}

		 } //end of bkask

		else if($payment_method==$this->config->item('dbbl_method_id')) //if dbbl
		{
			$transaction_details=$this->dbbl_transaction->get_info_by_trxid($trxid);	
			
			if($transaction_details['response']=='ok')
			{
				$paid_amount=$transaction_details['amount'];
				$transaction_reference=$transaction_details['bill_id'];

			}

			if($transaction_details['response']=='Error')
			$response= $this->lang->line("invalid trxid, it does not exist.");
			else if($transaction_details['response']=='ok' && $transaction_details['amount']<$price)
			$response=$this->lang->line("Insufficient payment.");
			else if($transaction_details['response']=='ok' && $transaction_details['bill_id']!="F".$app_id)
			$response=$this->lang->line("trxid does not match with bill id");			
		} //end of dbbl

		if(empty($transaction_details))
		{
			$this->session->set_userdata('transaction_error', $this->lang->line("something went wrong. please try again."));
			return $this->pay_admission_fees(); 
		}

		else if($response!=1)
		{
			$this->session->set_userdata('transaction_error', $response);
			return $this->pay_form_fees(); 
		}
		else
		{
			$insert_data=array
			(
				'applicant_id'=>$app_id,
				'price'=>$price,
				'payment_method_id'=>$payment_method,
				'payment_reference_no'=>$transaction_reference,
				'transaction_id'=>$trxid,
				'paid_amount'=>$paid_amount,
				'sold_at' => date("Y-m-d G:i:s"),
				'remarks' => "Online Form Sell"
			);
			if($this->basic->insert_data("form_sell",$insert_data))
			{
				$this->basic->update_data("applicant_info",array("id"=>$app_id),array("payment_status"=>"1"));
				$this->session->set_userdata('transaction_successfull', $this->lang->line("we have received your payment successfully."));
				redirect('applicant/index','location');
			}
		}

	}


	// public function pay_admission_fees()
	// {			
	// 	$bkash_info=array(0=>array());
	// 	$dbbl_info =array(0=>array());
	// 	$bkash_info=$this->basic->get_data("payment_method",array('where'=>array('id'=>$this->config->item('bkash_method_id'))));
	// 	$dbbl_info =$this->basic->get_data("payment_method",array('where'=>array('id'=>$this->config->item('dbbl_method_id'))));
	// 	$data['bkash_info']=$bkash_info[0];
	// 	$data['dbbl_info']=$dbbl_info[0];
	// 	$data['body']='online_admission/applicant/pay_admission_fees';
	// 	$data['page_title']= $this->lang->line("pay form fees");

	// 	// getting slip data
	// 	$class_id=$this->session->userdata("app_class_id");
	// 	$dept_id=$this->session->userdata("app_dept_id");
	// 	$session_id=$this->session->userdata("app_session_id");
	// 	$id = $this->session->userdata('app_id');	
	// 	$table = 'slip';
	// 	$where_simple = array("class_id" => $class_id,"dept_id"=>$dept_id,"financial_year_id"=>$session_id,"slip_type"=>"Admission");				
	// 	$where = array('where'=> $where_simple);
	// 	$result = $this->basic->get_data($table, $where);
	// 	if(count($result)==0 || (count($result)>0 && $result[0]['total_amount']<=0)) 
	// 	{
	// 		$data=array("title"=>$this->lang->line("no slip found"),"message"=>$this->lang->line("no slip has been configured. please contact system administrator."));
	// 		$this->load->view('page/message_page',$data);
	// 		exit();
	// 	}
	// 	$data['slip_info'] = $result;
	// 	$this->session->set_userdata('app_admission_fee',$result[0]['total_amount']);
	// 	// getting slip data	
	
	// 	$this->_app_viewcontroller($data);
	// }

	// public function pay_admission_fees_action()
	// {
	// 	if($_SERVER['REQUEST_METHOD'] === 'GET') 
	// 	redirect('home/access_forbidden','location');

		
	// 	$this->form_validation->set_rules('method','<b>'.$this->lang->line('payment method').'</b>', 'trim|required');	
	// 	$this->form_validation->set_rules('trxid','<b>'.$this->lang->line('transaction id').'</b>', 'trim|required|integer');		
								
	// 	if ($this->form_validation->run() == FALSE)
	// 	{
	// 		return $this->pay_admission_fees(); 
	// 	}
		

	// 	$trxid=$this->input->post('trxid');
	// 	$payment_method=$this->input->post('method');
	// 	$app_id=$this->session->userdata('app_id'); 		
	// 	$price=$this->session->userdata("app_admission_fee");
	// 	$paid_amount=0;
	// 	$transaction_reference=NULL;
	// 	$bkash_valid_transaction=0; // flag to check transaction is valid or not 
	// 	$response=1;

	// 	//checking if the trxid is already used or not
	// 	$where=array('where'=>array('transaction_id'=>$trxid,'payment_method_id'=>$payment_method));	
	// 	$count_rows=$this->basic->get_data("transaction_history",$where,$select="",$join='',$limit='',$start='',$order_by='',$group_by='',$num_rows=1);
	// 	$num_rows=$count_rows['extra_index']['num_rows'];
	// 	if($num_rows>0)
	// 	{
	// 		$response= $this->lang->line("trxid already used.");	
	// 		$this->session->set_userdata('transaction_error', $response);
	// 		return $this->pay_admission_fees(); 
	// 	}					
		

						
	// 	if($payment_method==$this->config->item('bkash_method_id')) // if bkash
	// 	{
	// 		$transaction_details=$this->bkash_api->get_info_by_trxid($trxid);
									
	// 		foreach($transaction_details as $transaction)
	// 		{
	// 			$transaction_status=$transaction->trxStatus;
	// 			if($transaction_status=="0000") // if transaction okay
	// 			{
	// 				$bkash_valid_transaction=1; 
	// 				$transaction_amount=$transaction->amount;
	// 				$transaction_reference=$transaction->reference;
	// 				$paid_amount=$transaction_amount;
	// 			}																
	// 		}
	// 		if($bkash_valid_transaction==1) // if transaction okay
	// 		{
	// 			if($transaction_reference!=$app_id)
	// 			$response= $this->lang->line("trxid does not match with refference id");
	// 			else if($transaction_amount<$price)
	// 			$response= $this->lang->line("insufficient payment.");
	// 		} 
	// 		else
	// 		{
	// 			switch($transaction_status)
	// 			{
	// 				case 0010:
	// 				$response= $this->lang->line("trxid is valid but transaction is in pending state.");
	// 				break;
						
	// 				case 0011:
	// 				$response=  $this->lang->line("trxid is valid but transaction is in pending state.");
	// 				break;
					
	// 				case 0100:
	// 				$response= $this->lang->line("trxid is valid but transaction has been reversed.");
	// 				break;
					
	// 				case 0111:
	// 				$response= $this->lang->line("trxid is valid but transaction has failed.");
	// 				break;
						
	// 				case 1001:
	// 				$response= $this->lang->line("invalid msisdn input. try with correct mobile no.");
	// 				break;
					
	// 				case 1002:
	// 				$response= $this->lang->line("invalid trxid, it does not exist.");
	// 				break;
					
	// 				case 9999:
	// 				$response= $this->lang->line("could not process request.");
	// 				break;
						
	// 				case 1004:
	// 				$response= $this->lang->line("trxid is not related to this username.");
	// 				break;	
	// 			}
	// 		}

	// 	 } //end of bkask

	// 	else if($payment_method==$this->config->item('dbbl_method_id')) //if dbbl
	// 	{
	// 		$transaction_details=$this->dbbl_transaction->get_info_by_trxid($trxid);	
			
	// 		if($transaction_details['response']=='ok')
	// 		{
	// 			$paid_amount=$transaction_details['amount'];
	// 			$transaction_reference=$transaction_details['bill_id'];

	// 		}

	// 		if($transaction_details['response']=='Error')
	// 		$response= $this->lang->line("Invalid TrxID, it does not exist.");
	// 		else if($transaction_details['response']=='ok' && $transaction_details['amount']<$price)
	// 		$response=$this->lang->line("Insufficient payment.");
	// 		else if($transaction_details['response']=='ok' && $transaction_details['bill_id']!=$app_id)
	// 		$response=$this->lang->line("TrxID does not match with Bill ID");			
	// 	} //end of dbbl

	// 	if(empty($transaction_details))
	// 	{
	// 		$this->session->set_userdata('transaction_error', $this->lang->line("something went wrong. please try again."));
	// 		return $this->pay_admission_fees(); 
	// 	}
	// 	else if($response!=1)
	// 	{
	// 		$this->session->set_userdata('transaction_error', $response);
	// 		return $this->pay_admission_fees(); 
	// 	}

	// 	else
	// 	{
	// 		$this->db->trans_start();

	// 		$id=$app_id;
	// 		$default_section = $this->get_default_section();
	// 		$where= array('where'=>array('id' => $id));
	// 		$applicant_info = $this->basic->get_data('view_applicant_info',$where,$select='');

	// 		$session_id = $applicant_info[0]['session_id'];
	// 		$dept_id = $applicant_info[0]['dept_id'];
	// 		$shift_id = $applicant_info[0]['shift_id'];
	// 		$student_info = $this->_get_student_id($session_id,$dept_id,$shift_id);
				
	// 			$data = array(
	// 				'student_id' => $student_info['student_id'],
	// 				'name' => $applicant_info[0]['name'],
	// 				'father_name' => $applicant_info[0]['father_name'],
	// 				'mother_name' => $applicant_info[0]['mother_name'],
	// 				'gurdian_name' => $applicant_info[0]['gurdian_name'],
	// 				'gurdian_relation' => $applicant_info[0]['gurdian_relation'],
	// 				'gurdian_mobile' => $applicant_info[0]['gurdian_mobile'],
	// 				'class_roll' => $student_info['class_roll'],
	// 				'class_id' => $applicant_info[0]['class_id'],
	// 				'religion' => $applicant_info[0]['religion'],
	// 				'dept_id' => $applicant_info[0]['dept_id'],
	// 				'section_id' => $default_section['id'],
	// 				'shift_id' => $applicant_info[0]['shift_id'],
	// 				'session_id' => $applicant_info[0]['session_id'],
	// 				'birth_date' => $applicant_info[0]['birth_date'],
	// 				'gender' => $applicant_info[0]['gender'],
	// 				'name_bangla' => $applicant_info[0]['name_bangla'],
	// 				'father_name_bangla' => $applicant_info[0]['father_name_bangla'],
	// 				'mother_name_bangla' => $applicant_info[0]['mother_name_bangla'],
	// 				'gurdian_occupation' => $applicant_info[0]['gurdian_occupation'],
	// 				'gurdian_income' => $applicant_info[0]['gurdian_income'],
	// 				'gurdian_present_village' => $applicant_info[0]['gurdian_present_village'],
	// 				'gurdian_present_post' => $applicant_info[0]['gurdian_present_post'],
	// 				'gurdian_present_thana' => $applicant_info[0]['gurdian_present_thana'],
	// 				'gurdian_present_district' => $applicant_info[0]['gurdian_present_district'],
	// 				'gurdian_permanent_village' => $applicant_info[0]['gurdian_permanent_village'],
	// 				'gurdian_permanent_post' => $applicant_info[0]['gurdian_permanent_post'],
	// 				'gurdian_permanent_thana' => $applicant_info[0]['gurdian_permanent_thana'],
	// 				'gurdian_permanent_district' => $applicant_info[0]['gurdian_permanent_district'],
	// 				'quota_id' => $applicant_info[0]['quota_id'],
	// 				'quota_description' => $applicant_info[0]['quota_description'],
	// 				'previous_institute' => $applicant_info[0]['previous_institute'],
	// 				'status' => '1',
	// 				'payment_status' => '1'
	// 				);
	// 			if($applicant_info[0]['mobile'] != '') $data['mobile'] = $applicant_info[0]['mobile'];	
	// 			if($applicant_info[0]['gurdian_email'] != '') $data['gurdian_email'] = $applicant_info[0]['gurdian_email'];			
	// 			if($applicant_info[0]['email'] != '') $data['email'] = $applicant_info[0]['email'];			
	// 			if($applicant_info[0]['birth_certificate_no'] != '') $data['birth_certificate_no'] = $applicant_info[0]['birth_certificate_no'];	
	// 			if($applicant_info[0]['image'] != '') 
	// 			{
	// 				$ext=array_pop(explode('.',$applicant_info[0]['image']));
	// 				$data['image'] = $applicant_info[0]['birth_certificate_no'].".".$ext;	
	// 			}
	// 			$this->basic->insert_data('student_info',$data);

	// 			$student_info_id = $this->db->insert_id();

	// 			//copy applicant image from applicant folder to student folder
	// 			$image_extension = array_pop(explode('.',$applicant_info[0]['image']));
	// 			$old_path = base_url()."upload/applicant/".$applicant_info[0]['image'];
	// 			$new_path = "upload/student/".$applicant_info[0]['birth_certificate_no'].".".$image_extension;
	// 			copy($old_path,$new_path);
	// 			//end of copy applicant image from applicant folder to student folder

	// 			$where1 = array('id' => $id);
	// 			$data1 = array('deleted' => '1','status' => '0');
	// 			$this->basic->update_data('applicant_info',$where1,$data1);

	// 			$where2 = array('applicant_id' => $id);
	// 			$this->basic->delete_data('online_admission_merit_list',$where2);

	// 			$where3['where'] = array('applicant_id' => $id);
	// 			$courses = $this->basic->get_data('applicant_course',$where3,$select3='');

	// 			foreach($courses as $course){
	// 				$data3 = array(
	// 					'student_id' => $student_info_id,
	// 					'class_id' => $course['class_id'],
	// 					'course_id' => $course['course_id'],
	// 					'dept_id' => $course['dept_id'],
	// 					'session_id' => $course['session_id'],
	// 					'type' => $course['type']
	// 					);
	// 				$this->basic->insert_data('student_course',$data3);
	// 			}

				
	// 			$password = $this->_random_number_generator();
	// 			$data4 = array(
	// 				'username' => $student_info['student_id'],
	// 				'password' => md5($password),
	// 				'role_id' => $this->config->item('student_role_id'),
	// 				'user_type' => 'Individual',
	// 				'type_details' => 'Student',
	// 				'reference_id' => $student_info_id
	// 				);
	// 			if($applicant_info[0]['email'] != '') $data4['email'] = $applicant_info[0]['email'];
	// 			$this->basic->insert_data('users',$data4);


	// 			$where5['where'] = array(
	// 				'class_id' => $applicant_info[0]['class_id'],
	// 				'dept_id' => $applicant_info[0]['dept_id'],
	// 				'financial_year_id' => $applicant_info[0]['session_id'],
	// 				'slip_type' => 'Admission'
	// 				);
	// 			$slip=array();
	// 			$slip = $this->basic->get_data('slip',$where5,$select5='');

				
	// 			$data6 = array(
	// 				'student_info_id' => $student_info_id,
	// 				'slip_id' => $slip[0]['id'],
	// 				'class_id' => $applicant_info[0]['class_id'],
	// 				'payment_type' => $slip[0]['slip_type'],
	// 				'total_amount' => $slip[0]['total_amount'],
	// 				'date_time' => date('Y-m-d'),
	// 				'payment_method_id' => $this->config->item('offline_method_id')
	// 				);
	// 			$this->basic->insert_data('transaction_history',$data6);
				


	// 			$name_of_file = '';
	// 			//mpdf starts here for generating admission confirmation slip
	// 			include("mpdf/mpdf.php");
	// 			ini_set("memory_limit", "-1");
	// 			set_time_limit(0);


	// 			$mpdf = new mpdf("","A4",16,"");
	// 			$mpdf->ignore_invalid_utf8 = true;
	// 			$mpdf->SetDisplayMode("fullpage");
	// 			$mpdf->SetImportUse();
	// 			$pagecount = $mpdf->SetSourceFile("templates/slip.pdf");
	// 			$tplid = $mpdf->ImportPage($pagecount);
	// 			$mpdf->SetPageTemplate($tplid);
	// 			$mpdf->AddPage();
	// 			$page_no = 0;
	// 			$html = "";

	// 			$institute_name = $this->config->item('institute_address1');
			
	// 			$mpdf->writetext(67,86,        $applicant_info[0]['name']);
	// 			$mpdf->writetext(67,97,        $applicant_info[0]['father_name']);
	// 			$mpdf->writetext(67,107.5,     $applicant_info[0]['mother_name']);
	// 			$mpdf->writetext(67,117.5,     $applicant_info[0]['class_name']);
	// 			$mpdf->writetext(67,128,       $student_info['class_roll']);
	// 			$mpdf->writetext(67,138,       $student_info['student_id']);
	// 			$mpdf->writetext(67,149,       $slip[0]['total_amount']);
	// 			$mpdf->writetext(67,159.5,     $student_info['student_id']);
	// 			$mpdf->writetext(67,175.5,     $password);
	// 			$mpdf->SetFont("","",10);
	// 			$mpdf->writetext(67,190,       "Log in @ ".base_url()."home/login");
	// 			$mpdf->writetext(67,195,       "We recommend to change your password when you log in.");
	// 			$mpdf->SetFont("","",20);
	// 			$mpdf->writetext(67,40, $institute_name);
	// 			$mpdf->SetFont("","",16);
	// 			$temp_name = $applicant_info[0]['class_name']."_".$student_info['class_roll']."_".$student_info['student_id'];
	// 			$hash_name = md5($temp_name);
	// 			$name_of_file = "download/applicant/admission_confirmation_slip/".$hash_name.".pdf";
	// 			$mpdf->output($name_of_file);
	// 			//end of mpdf

	// 			$this->db->trans_complete();
	// 			//transaction ends here

	// 			if($this->db->trans_status() === FALSE)
	// 			{
	// 	  			$this->session->set_userdata("error_in_online_admission",$this->lang->line("An error occured ! Please try again."));
	// 	  			redirect('applicant/pay_admission_fees','Location');
	// 		  	}
	// 		  	else
	// 		  	{
	// 		  		$page_message="";
	// 				$page_message.=$this->lang->line("congratulations").", ". $applicant_info[0]['name']."! ".$this->lang->line("your admission has been completed sucessfully");
	// 				$page_message.="<h3 class='red'>".$this->lang->line('student id')." : ".$student_info['student_id']." <br/> ".$this->lang->line('username')." : ".$student_info['student_id']." <br/> ".$this->lang->line('password').": ".$password."</h3>";
	// 				$page_message.= $this->lang->line("we recommend to chage your password when you log in.")."<br/>";
	// 				$page_message.= "&nbsp;&nbsp;".$this->lang->line('click here to download admission confirmation slip')." : "."<a class='btn btn-warning border_radius' title=Download Slip href='".base_url().'/'.$name_of_file."'><i class='fa fa-cloud-download'></i> ".$this->lang->line('download slip')."</a></div>";
			
	// 				$this->session->set_userdata('success_in_online_admission',$page_message);
					
	// 				$message="";
	// 				$message.=$this->lang->line("congrats!your admission has been completed sucessfully.");
	// 				$message.=$this->lang->line("student id/username").": ".$student_info['student_id']." ".$this->lang->line('and')." ". $this->lang->line('password').": ".$password.".";
				
	// 				$subject=$this->config->item('institute_address1')." | ".$this->lang->line("online admission successfull");
	// 				$this->_mail_sender($from=$this->config->item('institute_email'),$to=$applicant_info[0]['email'],$subject,$message,$mask=$this->config->item('institute_address1'));
	// 				$this->_mail_sender($from=$this->config->item('institute_email'),$to=$applicant_info[0]['gurdian_email'],$subject,$message,$mask=$this->config->item('institute_address1'));
					
	// 				$send_sms_after_admission='0';
	// 				$config_results=$this->basic->get_data("online_admission_configure",array('where'=>array('dept_id'=> $applicant_info[0]['dept_id'],'class_id'=>$applicant_info[0]['class_id'],'session_id'=> $applicant_info[0]['session_id']))); 
	// 				foreach($config_results as $val)
	// 				{
	// 					$send_sms_after_admission=$val['send_sms_after_admission']; 
	// 					break;			
	// 				}

	// 				if($send_sms_after_admission=='1') 
	// 				$this->_sms_sender($message,$applicant_info[0]['mobile']);						

	// 				redirect('home/login','location');	
	// 		  	}
	// 	}

	// }


	public function reset_password_form()
	{
		$data['title'] = $this->lang->line('password reset');
		$data['body'] = 'online_admission/page/password_reset_form';
		$this->_app_viewcontroller($data);
	}

	public function reset_password_action()
	{

		if($_SERVER['REQUEST_METHOD'] === 'GET') 
		redirect('defaults/access_forbidden','location');

		$this->form_validation->set_rules('old_password', '<b>'.$this->lang->line('Old Password').'</b>', 'trim|required|xss_clean');
		$this->form_validation->set_rules('new_password', '<b>'.$this->lang->line('New Password').'</b>', 'trim|required|xss_clean');
		$this->form_validation->set_rules('confirm_new_password', '<b>Confirm New Password</b>', 'trim|required|xss_clean|matches[new_password]');
		if($this->form_validation->run() == FALSE)
		$this->reset_password_form();
		
		else
		{
			$app_id = $this->session->userdata('app_id');
			$password = $this->input->post('old_password');
			$new_password = $this->input->post('new_password');
			$table = 'applicant_info';
			$where['where'] = array('id' => $app_id,'password' => md5($password));
			$select = array('username');
			if($this->basic->get_data($table,$where,$select))
			{
				$where = array('id' => $app_id);
				$data = array('password' => md5($new_password));
				$this->basic->update_data($table,$where,$data);
				$this->session->set_userdata('app_logged_in',0);
				$this->session->set_flashdata('app_reset_success',$this->lang->line('please login with new password'));
				redirect('online/applicant_login','location');
			}
			else
			{
				$this->session->set_userdata('error',$this->lang->line('the old password you have given is wrong!'));
				$this->reset_password_form();
			}
		}
	}   
}
	






