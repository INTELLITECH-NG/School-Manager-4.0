<?php
require_once("home.php");

/**
* class member
* @category controller
*/
class Admin_member extends Home
{
    /**
    * load constructor method
    * @access public
    * @return void
    */
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('logged_in')!= 1) {
            redirect('home/login', 'location');
        }
        // $this->important_feature();
    }

    /**
    * method to read online pdf books
    * @access public
    * @return void
    */
    public function read_online($book_id=0,$is_uploaded=0)
    {
        if ($book_id == 0) {
            exit();
        }
        $where['where'] = array('id' => $book_id);
        $select = array('pdf');
        $link = $this->basic->get_data('library_book_info',$where,$select);

        if($is_uploaded == 1)
            $directory_link = base_url()."upload/e_books/".$link[0]['pdf'];
        else
            $directory_link = $link[0]['pdf'];

        $tmp = explode('.',$link[0]['pdf']);
        $ext = trim(array_pop($tmp));
        if ($ext == 'pdf') {
            $data['pdf_link'] = $directory_link;
            $data['page_title'] = $this->lang->line('read online');
            $data["body"] = "member/read_online";
        }
        else {
            $data['epub_link'] = $directory_link;
            $this->load->view('member/read_online_epub',$data); return true;
            $data['body'] = "member/read_online_epub";
        }

       
        if($this->session->userdata('logged_in')==1 && $this->session->userdata('type_details')=='Student')
        {
            $this->_student_viewcontroller($data);
        }
        if($this->session->userdata('logged_in')==1 && $this->session->userdata('user_type')=='Operator') 
        {
            $this->_viewcontroller($data);
        }

    }

}
