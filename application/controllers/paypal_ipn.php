<?php

class Paypal_ipn extends CI_Controller
{

    public function __construct()
    {
         parent::__construct();
        $this->load->library('paypal_class');
        $this->load->model('basic');
        set_time_limit(0);
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
        $session=trim($session_sep[0]);
        
        /***padding the department id as two digit***/
        $department=str_pad($dept_id,2,'0',STR_PAD_LEFT);
        $shift=str_pad($shift_id,2,'0',STR_PAD_LEFT);
        
        
        /****** update class_roll table as the last_used_roll. **********/
        $this->basic->update_last_roll($session_id,$dept_id,$shift_id);
        
        /*** Get the last_roll used ****/
        $where_simple=array('session_id'=>$session_id,"dept_id"=>$dept_id,"shift_id"=>$shift_id);
        $where=array('where'=>$where_simple);   
        $last_roll_info=$this->basic->get_data('class_roll',$where,$select='',$join='',$limit='',$start='',$order_by='',$group_by='',$num_rows=0);
        
        /***If already admitted any student , then in database a row will be available, but if not, then no row will be avaialable there. So just need to check already available not not. If not available then let the last_used_roll = department.start_roll ***/        
        if(isset($last_roll_info[0]['last_used_roll'])){
            $last_used_roll=$last_roll_info[0]['last_used_roll'];
        }
        
        $used_roll=str_pad($last_used_roll,3,'0',STR_PAD_LEFT);
        
        $id=trim($session).$department.$shift.$used_roll;
        
        $st_info=array('student_id'=>$id,'class_roll'=>$used_roll);
        
        return $st_info;
    }

    public function _random_number_generator($length=6)
    {

        $rand = substr(uniqid(mt_rand(), true) , 0, $length);
        return $rand;
    }




    
        public function ipn_notify(){
    
        $payment_info=$this->paypal_class->run_ipn();


        $verify_status=$payment_info['verify_status'];
        $first_name=$payment_info['data']['first_name'];
        $last_name=$payment_info['data']['last_name'];
        $buyer_email=$payment_info['data']['payer_email'];
        $receiver_email=$payment_info['data']['receiver_email'];
        $country=$payment_info['data']['address_country'];
        $payment_date=$payment_info['data']['payment_date'];
        $transaction_id=$payment_info['data']['txn_id'];
        $payment_type=$payment_info['data']['payment_type'];
        $payment_amount=$payment_info['data']['mc_gross'];
        $user_id=$payment_info['data']['custom'];

            //applicant change to  student**************************************************************************

     

            $this->db->trans_start();

            $id=$user_id; 
            $default_section = $this->get_default_section();


            $where= array('where'=>array('id' => $id));
            $applicant_info = $this->basic->get_data('view_applicant_info',$where,$select='');

            $session_id = $applicant_info[0]['session_id'];
            $dept_id = $applicant_info[0]['dept_id'];
            $shift_id = $applicant_info[0]['shift_id'];
            $student_info = $this->_get_student_id($session_id,$dept_id,$shift_id);



            $user_id = $student_info['student_id'];
                
                $data = array(
                    'student_id' => $student_info['student_id'],
                    'name' => $applicant_info[0]['name'],
                    'father_name' => $applicant_info[0]['father_name'],
                    'mother_name' => $applicant_info[0]['mother_name'],
                    'gurdian_name' => $applicant_info[0]['gurdian_name'],
                    'gurdian_relation' => $applicant_info[0]['gurdian_relation'],
                    'gurdian_mobile' => $applicant_info[0]['gurdian_mobile'],
                    'class_roll' => $student_info['class_roll'],
                    'class_id' => $applicant_info[0]['class_id'],
                    'religion' => $applicant_info[0]['religion'],
                    'dept_id' => $applicant_info[0]['dept_id'],
                    'section_id' => $default_section['id'],
                    'shift_id' => $applicant_info[0]['shift_id'],
                    'session_id' => $applicant_info[0]['session_id'],
                    'birth_date' => $applicant_info[0]['birth_date'],
                    'gender' => $applicant_info[0]['gender'],
                    'name_bangla' => $applicant_info[0]['name_bangla'],
                    'father_name_bangla' => $applicant_info[0]['father_name_bangla'],
                    'mother_name_bangla' => $applicant_info[0]['mother_name_bangla'],
                    'gurdian_occupation' => $applicant_info[0]['gurdian_occupation'],
                    'gurdian_income' => $applicant_info[0]['gurdian_income'],
                    'gurdian_present_village' => $applicant_info[0]['gurdian_present_village'],
                    'gurdian_present_post' => $applicant_info[0]['gurdian_present_post'],
                    'gurdian_present_thana' => $applicant_info[0]['gurdian_present_thana'],
                    'gurdian_present_district' => $applicant_info[0]['gurdian_present_district'],
                    'gurdian_permanent_village' => $applicant_info[0]['gurdian_permanent_village'],
                    'gurdian_permanent_post' => $applicant_info[0]['gurdian_permanent_post'],
                    'gurdian_permanent_thana' => $applicant_info[0]['gurdian_permanent_thana'],
                    'gurdian_permanent_district' => $applicant_info[0]['gurdian_permanent_district'],
                    'quota_id' => $applicant_info[0]['quota_id'],
                    'quota_description' => $applicant_info[0]['quota_description'],
                    'previous_institute' => $applicant_info[0]['previous_institute'],
                    'status' => '1',
                    'payment_status' => '1'
                    );

  



                if($applicant_info[0]['mobile'] != '') $data['mobile'] = $applicant_info[0]['mobile'];  
                if($applicant_info[0]['gurdian_email'] != '') $data['gurdian_email'] = $applicant_info[0]['gurdian_email'];         
                if($applicant_info[0]['email'] != '') $data['email'] = $applicant_info[0]['email'];         
                if($applicant_info[0]['birth_certificate_no'] != '') $data['birth_certificate_no'] = $applicant_info[0]['birth_certificate_no'];    
                if($applicant_info[0]['image'] != '') 
                {   
                    $ext= explode('.',$applicant_info[0]['image']);
                    $ext=array_pop($ext);
                    $data['image'] = $applicant_info[0]['birth_certificate_no'].".".$ext;   
                }

                $this->basic->insert_data('student_info',$data);

                $student_info_id = $this->db->insert_id();

                //copy applicant image from applicant folder to student folder
                $image_extension = explode('.',$applicant_info[0]['image']);
                $image_extension = array_pop($image_extension);
                $old_path = base_url()."upload/applicant/".$applicant_info[0]['image'];
                $new_path = "upload/student/".$applicant_info[0]['birth_certificate_no'].".".$image_extension;
                copy($old_path,$new_path);
                //end of copy applicant image from applicant folder to student folder

                $where1 = array('id' => $id);
                $data1 = array('deleted' => '1','status' => '0');
                $this->basic->update_data('applicant_info',$where1,$data1);

                $where2 = array('applicant_id' => $id);
                $this->basic->delete_data('online_admission_merit_list',$where2);

                $where3['where'] = array('applicant_id' => $id);
                $courses = $this->basic->get_data('applicant_course',$where3,$select3='');

                foreach($courses as $course){
                    $data3 = array(
                        'student_id' => $student_info_id,
                        'class_id' => $course['class_id'],
                        'course_id' => $course['course_id'],
                        'dept_id' => $course['dept_id'],
                        'session_id' => $course['session_id'],
                        'type' => $course['type']
                        );
                    $this->basic->insert_data('student_course',$data3);
                }


                
                $password = $this->_random_number_generator();
                $data4 = array(
                    'username' => $student_info['student_id'],
                    'password' => md5($student_info['student_id']),
                    'role_id' => $this->config->item('student_role_id'),
                    'user_type' => 'Individual',
                    'type_details' => 'Student',
                    'reference_id' => $student_info_id
                    );
                if($applicant_info[0]['email'] != '') $data4['email'] = $applicant_info[0]['email'];
                $this->basic->insert_data('users',$data4);

                $where5['where'] = array(
                    'class_id' => $applicant_info[0]['class_id'],
                    'dept_id' => $applicant_info[0]['dept_id'],
                    'financial_year_id' => $applicant_info[0]['session_id'],
                    'slip_type' => 'Admission'
                    );

                $payment_info = $this->basic->get_data('slip',$where5,$select='');
                $slip_id = $payment_info[0]['id'];


        //insert into transacton_history table                
                
                $insert_data=array(
                "payment_date"      =>date('Y-m-d H:i:s'),
                "payment_type"      =>$payment_type,
                "transaction_id"    =>$transaction_id,
                "user_id"           =>$student_info_id,
                "slip_id"           =>$slip_id,
                "payment_method"    =>'Online',
                "paid_amount"   => $payment_amount,
                "total_amount"   => $payment_amount,
                'date_time' => date('Y-m-d H:i:s'),
                'class_id' => $applicant_info[0]['class_id'],
                'student_info_id' => $student_info_id
            );
        //insert into transacton_history table            
            

        $this->basic->insert_data('transaction_history', $insert_data);

        $this->db->trans_complete();
                


                $name_of_file = '';
                //mpdf starts here for generating admission confirmation slip
                include("mpdf/mpdf.php");
                ini_set("memory_limit", "-1");
                set_time_limit(0);


                $mpdf = new mpdf("","A4",16,"");
                $mpdf->ignore_invalid_utf8 = true;
                $mpdf->SetDisplayMode("fullpage");
                $mpdf->SetImportUse();
                $pagecount = $mpdf->SetSourceFile("templates/slip.pdf");
                $tplid = $mpdf->ImportPage($pagecount);
                $mpdf->SetPageTemplate($tplid);
                $mpdf->AddPage();
                $page_no = 0;
                $html = "";

                $institute_name = $this->config->item('institute_address1');
            
                $mpdf->writetext(67,86,        $applicant_info[0]['name']);
                $mpdf->writetext(67,97,        $applicant_info[0]['father_name']);
                $mpdf->writetext(67,107.5,     $applicant_info[0]['mother_name']);
                $mpdf->writetext(67,117.5,     $applicant_info[0]['class_name']);
                $mpdf->writetext(67,128,       $student_info['class_roll']);
                $mpdf->writetext(67,138,       $student_info['student_id']);
                $mpdf->writetext(67,149,       $slip[0]['total_amount']);
                $mpdf->writetext(67,159.5,     $student_info['student_id']);
                $mpdf->writetext(67,175.5,     $student_info['student_id']);
                $mpdf->SetFont("","",10);
                $mpdf->writetext(67,190,       "Log in @ ".base_url()."home/login");
                $mpdf->writetext(67,195,       $this->lang->line("we recommend to change your password when you log in."));
                $mpdf->SetFont("","",20);
                $mpdf->writetext(67,40, $institute_name);
                $mpdf->SetFont("","",16);
                $temp_name = $applicant_info[0]['class_name']."_".$student_info['class_roll']."_".$student_info['student_id'];
                $hash_name = md5($temp_name);
                $name_of_file = "download/applicant/admission_confirmation_slip/".$hash_name.".pdf";
                $mpdf->output($name_of_file);
                //end of mpdf

                 $name_of_file =base_url("download/applicant/admission_confirmation_slip/".$hash_name.".pdf");
          
                //transaction ends here

                    
                    $message="";
                    $message.=$this->lang->line("congrats!your admission has been completed sucessfully.<br/>");
                    $message.=$this->lang->line("Ploease download your confirmation slip from here : ");
                    $message.= " ";
                    $message.=$name_of_file;
                    $message.=" ";
                    $message.=$this->lang->line("student id/username").": ".$student_info['student_id']." ".$this->lang->line('and')." ".$this->lang->line("Password")." : ".$student_info['student_id'].".";
                
                    $subject=$this->config->item('institute_address1')." | ".$this->lang->line('online admission successfull');
                    $this->_mail_sender($from=$this->config->item('institute_email'),$to=$applicant_info[0]['email'],$subject,$message,$mask=$this->config->item('institute_address1'));
                    
                    $this->_mail_sender($from=$this->config->item('institute_email'),$to=$applicant_info[0]['gurdian_email'],$subject,$message,$mask=$this->config->item('institute_address1'));

                    
                    $send_sms_after_admission='0';
                    $config_results=$this->basic->get_data("online_admission_configure",array('where'=>array('dept_id'=> $applicant_info[0]['dept_id'],'class_id'=>$applicant_info[0]['class_id'],'session_id'=> $applicant_info[0]['session_id']))); 
                    foreach($config_results as $val)
                    {
                        $send_sms_after_admission=$val['send_sms_after_admission']; 
                        break;          
                    }

                    $sms_message="";
                    $sms_message.=$this->lang->line("congrats!your admission has been completed sucessfully.");
                    $sms_message.=$this->lang->line("Confirmation slip: ");
                    $sms_message.=$name_of_file;
                    $sms_message.=$this->lang->line("student id/username").": ".$student_info['student_id']." ".$this->lang->line('and')." ".$this->lang->line("Password")." : ".$student_info['student_id'].".";

                    if($send_sms_after_admission=='1') 
                    $this->_sms_sender($sms_message,$applicant_info[0]['mobile']); 


//applicant change to  student***************************************************************************** 
        
        
    }


    function _mail_sender($from = '', $to = '', $subject = '', $message = '', $mask = "", $html = 0, $smtp = 1)
    {
        if ($from!= '' && $to!= '' && $subject!='' && $message!= '') {
            if (!is_array($to)) {
                $to=array($to);
            }

            if ($smtp == '1') {
                $where2 = array("where" => array('status' => '1'));
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
                  'newline' =>  '\r\n',
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
    
    

}

