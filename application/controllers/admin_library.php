<?php

require_once("home.php");

class Admin_library extends Home
{
	public function __construct()
	{
		// calling parent class function explicitly
		parent::__construct();	
		if($this->session->userdata('logged_in')!=1)
		redirect('home/login','location');

		if($this->session->userdata('user_type')!='Operator')
		redirect('home/login','location');

		// $this->important_feature();
        // $this->periodic_check();

        $this->load->helper('form');
        $this->load->library('upload');
        $this->load->library('image_lib');
        $this->upload_path = realpath(APPPATH . '../upload');
		
	}

	public function index()
	{	
		// redirect to method book_list to show books
		$this->book_list();
	}

	// a method to show grid page
	public function book_list()	
	{
		if(!in_array(28,$this->role_modules))  
		redirect('home/access_forbidden','location');

		$data["body"] = "admin/library/view_library.php";
		// load category of books
		$data['category_info'] = $this->get_book_category();	
		$this->_viewcontroller($data);
	}

	// a method to pass data to grid
	public function book_list_data()
	{
		if(!in_array(28,$this->role_modules))  
		redirect('home/access_forbidden','location');

		// setting variables for pagination
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 15;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'title';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'ASC';
        $order_by_str = $sort." ".$order;

        // setting properties for search
        $isbn = trim($this->input->post('isbn', true));
        $book_id = trim($this->input->post('book_id', true));
        $title = trim($this->input->post('title', true));
        $author = trim($this->input->post("author", true));
        $category = trim($this->input->post('category_id', true));
        $from_date = $this->input->post('from_date', true);
        if($from_date != '')
            $from_date = date('Y-m-d', strtotime($from_date));
        $to_date = $this->input->post('to_date', true);
        if($to_date != '')
            $to_date = date('Y-m-d', strtotime($to_date));


        // setting a new properties for $is_searched to set session if search occured
        $is_searched= $this->input->post('is_searched', true);


        if ($is_searched) {
            // if search occured, saving user input data to session. name of method is important before field
            $this->session->set_userdata('book_list_isbn', $isbn);
            $this->session->set_userdata('book_list_book_id', $book_id);
            $this->session->set_userdata('book_list_title', $title);
            $this->session->set_userdata('book_list_author', $author);
            $this->session->set_userdata('book_list_category', $category);
            $this->session->set_userdata('book_list_from_date', $from_date);
            $this->session->set_userdata('book_list_to_date', $to_date);
        }
        // saving session data to different search parameter variables
        $search_isbn = $this->session->userdata('book_list_isbn');
        $search_book_id = $this->session->userdata('book_list_book_id');
        $search_title = $this->session->userdata('book_list_title');
        $search_author = $this->session->userdata('book_list_author');
        $search_category = $this->session->userdata('book_list_category');
        $search_from_date = $this->session->userdata('book_list_from_date');
        $search_to_date = $this->session->userdata('book_list_to_date');

        // creating a blank where_simple array
        $where_simple = array();

        // trimming data
        if ($search_isbn) {
            $where_simple['isbn like '] = "%".$search_isbn."%";
        }
        if ($search_book_id) {
            $where_simple['id'] = $search_book_id;
        }
        // if($search_book_id) $where_simple['id like ']= "%".$search_book_id."%";
        if ($search_title) {
            $where_simple['title like '] = "%".$search_title."%";
        }
        if ($search_author) {
            $where_simple['author like '] = "%".$search_author."%";
        }

        if ($search_from_date != '') {
            $where_simple["Date_Format(add_date,'%Y-%m-%d') >="] = $search_from_date;
        }
        if ($search_to_date != '') {
            $where_simple["Date_Format(add_date,'%Y-%m-%d') <="] = $search_to_date;
        }

        // FIND_IN_SET is used to find one single value from many values. here multiple category exists
        if ($search_category) {
            $this->db->where("FIND_IN_SET('$search_category',category_id) !=", 0);
        }

        $where_simple['deleted'] = "0";
        $where = array('where' => $where_simple);
        $offset = ($page-1)*$rows;
        $result = array();

        $table = "library_book_info";
        $info = $this->basic->get_data($table, $where, $select = '', $join='', $limit = $rows, $start = $offset, $order_by = $order_by_str);

        $total_rows_array = $this->basic->count_row($table, $where, $count = "id");
        $total_result = $total_rows_array[0]['total_rows'];

        echo convert_to_grid_data($info, $total_result);	

	}

	// a function to show details view of book information
	public function view_details($id = 0)
	{
		if(!in_array(28,$this->role_modules))  
        redirect('home/access_forbidden','location');

        $data["body"] = "admin/library/view_details.php";

        $table = "library_book_info";
        $where['where'] = array('library_book_info.id' => $id);
        $result = $this->basic->get_data($table, $where, $select = '', $join = '', $limit = "", $start = "", $order_by = "");

        $result1 = $this->basic->get_data("library_category", $where = "", $select = '', $join = '', $limit = '', $start = null, $order_by = '');

        $cat_string = $result[0]['category_id'];    // extracting category id from data array
        $temp = explode(",", $cat_string);            // creating array from a string through explode function

        $data['info'] = $result;

        $data['all_category'] = $result1;
        $data['page_title'] = $this->lang->line("book details");

        $data['existing_category'] = $temp;
        $this->_viewcontroller($data);				
	}
	
	// a method to update existing book information
	public function update_book($id=0)
	{
		
		if(!in_array(28,$this->role_modules))  
		redirect('home/access_forbidden','location');
        if(!in_array(3,$this->role_module_accesses_28))
        redirect('home/access_forbidden','location');

	////////////

		/*$data['body'] = "admin/library/edit_book.php";
    	$table = 'library_book_info';	
    	$table2 = 'library_book_category';	

		$where_simple = array("library_book_info.id"=>$id); 	


		$where = array('where'=> $where_simple);		
		$result = $this->basic->get_data($table, $where, $select='', $join='', $limit='', $start=NULL, $order_by='');	
		$data['info'] = $result[0];


		// calling two methods to show enum value.
		$data['size_all']=$this->get_book_size();
		$data['status_all']=$this->get_book_status();

		$where_simple2 = array("library_book_category.book_id"=>$id); 	
	
		$where2 = array('where'=> $where_simple2);	

		$join = array( "library_category" => "library_category.id=library_book_category.category_id,left" );

		$result2 = $this->basic->get_data($table2, $where2, $select='', $join, $limit='', $start=NULL, $order_by='');
		
		$data['existing_category'] = $result2;		

		$id = null;
		$table3 = 'library_category';

		$where_simple3 = array("library_category.id"=>$id); 
		$where3 = array('where'=> $where_simple3);	
		$result3 = $this->basic->get_data($table3, $where3=array("id"=> $id), $select='', $join='', $limit='', $start=NULL, $order_by='');		

		$data['all_category'] = $result3;*/	

	//////////
	
		$data['body'] = "admin/library/edit_book"; // setting view path
        $data['page_title'] = $this->lang->line('edit book');
        $table = 'library_book_info';
        $table2 = 'library_category';

        $where_simple = array("library_book_info.id" => $id);
        $where = array('where' => $where_simple);

        // pulling data from book_info table
        $result = $this->basic->get_data($table, $where);

        $cat_string = $result[0]['category_id'];    // extracting category id from data array
        $temp = explode(",", $cat_string);            // creating array from a string through explode function

        $data['info'] = $result[0];                    // setting data form view

        // calling some methods to show enum value.
        $data['size_all'] = $this->get_book_size();
        // $data['status_all'] = $this->get_book_status();

        $data['all_physical_form'] = $this->get_physical_form();

        $data['all_source_details'] = $this->get_book_source_details();

        $data['existing_category'] = $temp; // setting data array of existing_category to

        $id = null;
        $table3 = 'library_category';

        $result3 = $this->basic->get_data($table3, $where3 = '', $select = '', $join = '', $limit = '', $start = null, $order_by = '');

        $data['all_category'] = $result3;	

		$this->_viewcontroller($data);		
	}


	public function update_book_action($id=0)
	{
		if(!in_array(28,$this->role_modules))  
		redirect('home/access_forbidden','location');		
		if(!in_array(3,$this->role_module_accesses_28))
		redirect('home/access_forbidden','location');

		 if ($_POST) {
            
            $this->form_validation->set_rules('author',                '<b>'.$this->lang->line("author").'</b>',              'trim|required');
            $this->form_validation->set_rules('title',                 '<b>'.$this->lang->line("title").'</b>',               'trim|required');
            $this->form_validation->set_rules('edition',               '<b>'.$this->lang->line("edition").'</b>',             'trim|required');
            $this->form_validation->set_rules('isbn',                  '<b>'.$this->lang->line("ISBN").'</b>',                'trim');
            $this->form_validation->set_rules('subtitle',              '<b>'.$this->lang->line("subtitle").'</b>',            'trim');
            $this->form_validation->set_rules('edition_year',          '<b>'.$this->lang->line("edition year").'</b>',        'trim|integer|exact_length[4]');
            $this->form_validation->set_rules('physical_form',         '<b>'.$this->lang->line("physical form").'</b>',       'trim');
            $this->form_validation->set_rules('publisher',             '<b>'.$this->lang->line("publisher").'</b>',           'trim');
            $this->form_validation->set_rules('series',                '<b>'.$this->lang->line("series").'</b>',              'trim');
            $this->form_validation->set_rules('size1',                 '<b>'.$this->lang->line("size").'</b>',                'trim');
            $this->form_validation->set_rules('price',                 '<b>'.$this->lang->line("price").'</b>',               'trim');
            $this->form_validation->set_rules('call_no',               '<b>'.$this->lang->line("call no").'</b>',             'trim');
            $this->form_validation->set_rules('location',              '<b>'.$this->lang->line("location").'</b>',            'trim');
            $this->form_validation->set_rules('clue_page',             '<b>'.$this->lang->line("clue page").'</b>',           'trim');
            $this->form_validation->set_rules('editor',                '<b>'.$this->lang->line("editor").'</b>',              'trim');
            $this->form_validation->set_rules('publishing_year',       '<b>'.$this->lang->line("publication year").'</b>',    'trim|integer|exact_length[4]');
            $this->form_validation->set_rules('publication_place',     '<b>'.$this->lang->line("publication place").'</b>',   'trim');
            $this->form_validation->set_rules('number_of_pages',       '<b>'.$this->lang->line("total pages").'</b>',         'trim');
            $this->form_validation->set_rules('source_details',        '<b>'.$this->lang->line("source").'</b>',              'trim');
            $this->form_validation->set_rules('notes',                 '<b>'.$this->lang->line("notes").'>/b>',               'trim');
            $this->form_validation->set_rules('link',                  '<b>'.$this->lang->line("link").'>/b>',                'trim');


            if ($this->form_validation->run() == false) {
                return $this->update_book($id);
            } else {
                // $single_group = $this->input->post('single_group', true);
                $temp = $this->input->post('cat', true);
                $category = '';
                if ($temp) {
                    $category = implode($temp, ',');
                }

            //  $accession_no =     $this->input->post('accession_no');
                $physical_form        =     strip_tags($this->input->post('physical_form', true));
                $author               =     strip_tags($this->input->post('author', true));
                $subtitle             =     strip_tags($this->input->post('subtitle', true));
                $edition_year         =     strip_tags($this->input->post('edition_year', true));
                $publisher            =     strip_tags($this->input->post('publisher', true));
                $series               =     strip_tags($this->input->post('series', true));
                $size1                =     strip_tags($this->input->post('size1', true));
                $price                =     strip_tags($this->input->post('price', true));
                $call_no              =     strip_tags($this->input->post('call_no', true));
                $location             =     strip_tags($this->input->post('location', true));
                $clue_page            =     strip_tags($this->input->post('clue_page', true));
                $editor               =     strip_tags($this->input->post('editor', true));
                $title                =     strip_tags($this->input->post('title', true));
                $edition              =     strip_tags($this->input->post('edition', true));
                $publishing_year      =     strip_tags($this->input->post('publishing_year', true));
                $publication_place    =     strip_tags($this->input->post('publication_place', true));
                $number_of_pages      =     strip_tags($this->input->post('number_of_pages', true));
                // $dues              =     $this->input->post('dues', true);
                $isbn                 =     strip_tags($this->input->post('isbn', true));
                $source_details       =     strip_tags($this->input->post('source_details', true));
                $notes                =     strip_tags($this->input->post('notes', true));
                $add_date             =     date("Y-m-d G:i:s"); //   $this->input->post('add_date');
                $status               =     strip_tags($this->input->post('status', true));
                $link =     strip_tags($this->input->post('link', true));


                $pdf = '';
                $not_pdf_but_link_uploaded = '';


                if($link != ''){
                    $not_pdf_but_link_uploaded = '0';
                    $pdf = $link;
                }
                else {
                    if ($_FILES['pdf']['size'] != 0) {
                    	$temp = array_pop(explode('.',$_FILES['pdf']['name']));
                        $ext=trim($temp);
                        if($ext=="pdf" || $ext=="epub")
                        {
                            $space_stripped_file_name = time().'.'.$ext;
                            $config1['upload_path'] = $this->upload_path.'/e_books/';
                            $config1['allowed_types'] = '*';
                            $config1['file_name'] = $space_stripped_file_name;
                            $config1['overwrite'] = true;
                            $this->upload->initialize($config1);
                            $this->load->library('upload', $config1);
                            $is_uploaded = 1;

                            if ($_FILES['pdf']['size'] != 0 && !$this->upload->do_upload("pdf")) {
                                //if any photo selected and if photo upload error occurs then reload form and show upload error
                                $is_uploaded=0;
                                $error = $this->upload->display_errors();
                                $this->session->set_userdata('pdf_error', $error);
                                return $this->update_book($id);
                                // redirect('','refresh')
                            }
                            if ($is_uploaded == 1) {
                                $pdf = $space_stripped_file_name;
                            }
                        }
                    }
                }               


                //  $deleted=$this->input->post('deleted');
                $image = "";
                if ($_FILES['photo']['size'] != 0) {
                	$temp = array_pop(explode('.',$_FILES['photo']['name']));
                    $ext=trim($temp);
                    $space_stripped_image_name = time().'.'.$ext;
                    $config2['upload_path'] = './upload/cover_images/';
                    $config2['allowed_types'] = 'jpg|png|jpeg';
                    $config2['file_name']    = $space_stripped_image_name;
                    $config2['overwrite']    =  true;
                    $config2['max_size']    =  250;
                    $config2['max_width']    =  600;
                    $config2['max_height']    =  1000;

                    $this->upload->initialize($config2);
                    $this->load->library('upload', $config2);

                    $is_uploaded = 1;
                    if ($_FILES['photo']['size'] != 0 && !$this->upload->do_upload("photo")) {
                        //if any photo selected and if photo upload error occurs then reload form and show upload error
                        $is_uploaded = 0;
                        $error = $this->upload->display_errors();
                        $this->session->set_userdata('photo_error', $error);
                        return $this->update_book($id);
                    }

                    if ($_FILES['photo']['size'] == 0) {
                        $image = 'cover_default'.'.jpg';
                        $is_uploaded = 0;
                    }

                    if ($is_uploaded == 1) {
                        // forming image name
                        $image = $space_stripped_image_name;
                    }
                }


                $data = array(
                //  'accession_no' => $accession_no,
                    'physical_form'  => $physical_form,
                    'author'  => $author,
                    'subtitle'  => $subtitle,
                    'edition_year'  => $edition_year,
                    'publisher'  => $publisher,
                    'series'  => $series,
                    'size1'  => $size1,
                    'price'  => $price,
                    'call_no'  => $call_no,
                    'location'  => $location,
                    'clue_page'  => $clue_page,
                    'editor'  => $editor,
                    'title'  => $title,
                    'edition'  => $edition,
                    'publishing_year'  => $publishing_year,
                    'publication_place'  => $publication_place,
                    'number_of_pages'  => $number_of_pages,
                    // 'dues'  => $dues,
                    'isbn'  => $isbn,
                    'source_details'  => $source_details,
                    'notes'  => $notes,
                    'add_date'  => $add_date,
                    'status'  => $status,
                    );

                if ($image != '') {
                    $data['cover']=$image;
                }
                if ($pdf != '') {
                    $data['pdf']=$pdf;
                }
                if ($category != '') {
                    $data['category_id'] = $category;
                }

                if ($not_pdf_but_link_uploaded != '') {
                    $data['is_uploaded'] = $not_pdf_but_link_uploaded;
                } else {
                    $data['is_uploaded'] = '1';
                }

                //if($image!="") $data['cover']=$image;
                if ($image) {
                    //creating thumbnail
                    $config3 = array();
                    $config3['image_library'] = 'gd2';
                    $config3['source_image'] = $this->upload_path.'/cover_images/'.$image;
                    $config3['create_thumb'] =  true;
                    $config3['new_image'] = $this->upload_path.'/cover_images/thumbnail_cover_images/';
                    $config3['width'] = 160;
                    $config3['height'] = 210;
                    $this->image_lib->initialize($config3);
                    $this->load->library('upload', $config3);
                    $this->image_lib->resize();

                    $rename_image = explode(".", $image);
                    $old_image_file = $this->upload_path.'/cover_images/thumbnail_cover_images/'.$rename_image[0].'_thumb.jpg';
                    $new_image_file = $this->upload_path.'/cover_images/thumbnail_cover_images/'.$image;
                    rename($old_image_file, $new_image_file);
                }


                if (!empty($data)) {
                    // echo "has data"; exit();
                    $group_info = $this->basic->get_data('library_book_info', $where=array('where'=>array('id'=>$id)));
                    $title = $group_info[0]['title'];
                    $author = $group_info[0]['author'];
                    $edition = $group_info[0]['edition'];
                    $where_update = array('title'=>$title,'author'=>$author,'edition'=>$edition);
                    $this->basic->update_data("library_book_info", $where_update, $data);
                    $this->session->set_flashdata('success_message', 1);
                    redirect('admin_library/book_list', 'location');
                } else {
                    // echo 'has_no_data'; exit();
                    $this->session->set_flashdata("error_message", 1);
                    redirect('admin/update_book/'.$id, 'location');
                }
            }
        }
    }


    public function add_book($id=0)    
    {

    	if(!in_array(28,$this->role_modules))  
		redirect('home/access_forbidden','location');
        if(!in_array(2,$this->role_module_accesses_28))
        redirect('home/access_forbidden','location');
    	
    	/*$data['body'] = "admin/library/add_book.php";  

    	$table = 'library_book_info';	
    	$table2 = 'library_category';	

		$where_simple = array("library_book_info.id"=>$id); 		
		$where = array('where'=> $where_simple);	
	
		$where_simple2 = array("library_category.id"=>$id); 	

		$where2 = array('where'=> $where_simple2);	

		$result = $this->basic->get_data($table, $where, $select='', $join='', $limit='', $start=NULL, $order_by='');	
		$result2 = $this->basic->get_data($table2, $where2=array("id"=> $id), $select='', $join='', $limit='', $start=NULL, $order_by='');	
	
		$data['info'] = $result;
		$data['info2'] = $result2;	
		$data['size_all']=$this->get_book_size();
		$data['status_all']=$this->get_book_status();*/

		$data['body'] = "admin/library/add_book";
        $data['page_title'] = $this->lang->line('add book');
        $table = 'library_book_info';
        $table2 = 'library_category';

        $result = $this->basic->get_data($table, $where='', $select='', $join='', $limit='', $start=null, $order_by='');
        $result2 = $this->basic->get_data($table2, $where='');

        $data['info'] = $result;
        $data['info2'] = $result2;
        $data['size_all'] = $this->get_book_size();

        // $data['status_all']=$this->get_book_status();
        $data['all_physical_form']=$this->get_physical_form();
        $data['all_source_details']=$this->get_book_source_details();

	    $this->_viewcontroller($data);	
    }


	public function add_book_action()
	{
		if(!in_array(28,$this->role_modules))  
		redirect('home/access_forbidden','location');		
		if(!in_array(2,$this->role_module_accesses_28))
		redirect('home/access_forbidden','location');


		 if ($_POST) {
            $this->form_validation->set_rules('author',                '<b>'.$this->lang->line("author").'</b>',              'trim|required');
            $this->form_validation->set_rules('title',                 '<b>'.$this->lang->line("title").'</b>',               'trim|required');
            $this->form_validation->set_rules('edition',               '<b>'.$this->lang->line("edition").'</b>',             'trim|required');
            $this->form_validation->set_rules('number_of_books',       '<b>'.$this->lang->line("number of copies").'</b>',    'trim|required|integer');
            $this->form_validation->set_rules('isbn',                  '<b>'.$this->lang->line("ISBN").'</b>',                'trim');
            $this->form_validation->set_rules('subtitle',              '<b>'.$this->lang->line("subtitle").'</b>',            'trim');
            $this->form_validation->set_rules('edition_year',          '<b>'.$this->lang->line("edition year").'</b>',        'trim|integer|exact_length[4]');
            $this->form_validation->set_rules('physical_form',         '<b>'.$this->lang->line("physical form").'</b>',       'trim');
            $this->form_validation->set_rules('publisher',             '<b>'.$this->lang->line("publisher").'</b>',           'trim');
            $this->form_validation->set_rules('series',                '<b>'.$this->lang->line("series").'</b>',              'trim');
            $this->form_validation->set_rules('size1',                 '<b>'.$this->lang->line("size").'</b>',                'trim');
            $this->form_validation->set_rules('price',                 '<b>'.$this->lang->line("price").'</b>',               'trim');
            $this->form_validation->set_rules('call_no',               '<b>'.$this->lang->line("call no").'</b>',             'trim');
            $this->form_validation->set_rules('location',              '<b>'.$this->lang->line("location").'</b>',            'trim');
            $this->form_validation->set_rules('clue_page',             '<b>'.$this->lang->line("clue page").'</b>',           'trim');
            $this->form_validation->set_rules('editor',                '<b>'.$this->lang->line("editor").'</b>',              'trim');
            $this->form_validation->set_rules('publishing_year',       '<b>'.$this->lang->line("publication year").'</b>',    'trim|integer|exact_length[4]');
            $this->form_validation->set_rules('publication_place',     '<b>'.$this->lang->line("publication place").'</b>',   'trim');
            $this->form_validation->set_rules('number_of_pages',       '<b>'.$this->lang->line("total pages").'</b>',         'trim');
            $this->form_validation->set_rules('source_details',        '<b>'.$this->lang->line("source").'</b>',              'trim');
            $this->form_validation->set_rules('notes',                 '<b>'.$this->lang->line("notes").'>/b>',               'trim');
            $this->form_validation->set_rules('link',                  '<b>'.$this->lang->line("link").'>/b>',                'trim');



            if ($this->form_validation->run() == false) {
                return $this->add_book();
            }
            else
            {
                $temp = $this->input->post('cat', true);
                $category = '';
                if ($temp) 
                {
                    $category = implode($temp, ',');
                }

            //  $accession_no =     $this->input->post('accession_no');
                $physical_form =        strip_tags($this->input->post('physical_form', true));
                $author=                strip_tags($this->input->post('author', true));
                $subtitle=              strip_tags($this->input->post('subtitle', true));
                $edition_year =         strip_tags($this->input->post('edition_year', true));
                $publisher=             strip_tags($this->input->post('publisher', true));
                $series =               strip_tags($this->input->post('series', true));
                $size1 =                strip_tags($this->input->post('size1', true));
                $price=                 strip_tags($this->input->post('price', true));
                $call_no =              strip_tags($this->input->post('call_no', true));
                $location=              strip_tags($this->input->post('location', true));
                $clue_page=             strip_tags($this->input->post('clue_page', true));
                $editor =               strip_tags($this->input->post('editor', true));
                $title=                 strip_tags($this->input->post('title', true));
                $edition =              strip_tags($this->input->post('edition', true));
                $publishing_year=       strip_tags($this->input->post('publishing_year', true));
                $publication_place=     strip_tags($this->input->post('publication_place', true));
                $number_of_pages=       strip_tags($this->input->post('number_of_pages', true));
                $number_of_books =      strip_tags($this->input->post('number_of_books', true));
                // $dues =      $this->input->post('dues', true);
                $isbn =                 strip_tags($this->input->post('isbn', true));
                $source_details =       strip_tags($this->input->post('source_details', true));
                $notes =                strip_tags($this->input->post('notes', true));
                $link =     strip_tags($this->input->post('link', true));
                //  $cover =        $this->input->post('cover');
                $add_date=  date("Y-m-d G:i:s"); // $this->input->post('add_date');

                $pdf = '';
                $not_pdf_but_link_uploaded = '';



                if($link != ''){
                    $not_pdf_but_link_uploaded = '0';
                    $pdf = $link;
                }
                else {
                    if ($_FILES['pdf']['size'] != 0) {
                        $temp = explode('.',$_FILES['pdf']['name']);
                    	$temp = array_pop($temp);
                        $ext=trim($temp);
                        if($ext=="pdf" || $ext=="epub")
                        {
                            $space_stripped_pdf_name = time().'.'.$ext;

                            $config1['upload_path'] = $this->upload_path.'/e_books/';
                            $config1['allowed_types'] = '*';
                            $config1['file_name']    = $space_stripped_pdf_name;
                            $config1['overwrite']    =  true;
                            $this->upload->initialize($config1);
                            $this->load->library('upload', $config1);
                            $is_uploaded=1;

                            if ($_FILES['pdf']['size'] != 0 && !$this->upload->do_upload("pdf")) {
                                //if any photo selected and if photo upload error occurs then reload form and show upload error
                                $is_uploaded=0;
                                $error = $this->upload->display_errors();
                                $this->session->set_userdata('pdf_error', $error);
                                return $this->add_book();
                                // redirect('admin/add_book','location');
                            }
                            if ($is_uploaded == 1) {
                                $pdf= $space_stripped_pdf_name;
                            }
                        }
                    }
                }
                

            // photo upload
                $temp = explode('.',$_FILES['photo']['name']);
                $ext=trim(array_pop($temp));
                
                $space_stripped_image_name = time().'.'.$ext;

                $config2['upload_path'] = './upload/cover_images/';
                $config2['allowed_types'] = 'jpg|png|jpeg';
                $config2['file_name']    = $space_stripped_image_name;
                $config2['max_size']    =  1024;
                $config2['max_width']    =  1200;
                $config2['max_height']    =  2000;

                $this->upload->initialize($config2);
                $this->load->library('upload', $config2);

                $is_uploaded=1;

                if ($_FILES['photo']['size'] != 0 && !$this->upload->do_upload("photo")) {
                    //if any photo selected and if photo upload error occurs then reload form and show upload error
                    $is_uploaded=0;
                    $error = $this->upload->display_errors();
                    $this->session->set_userdata('photo_error', $error);
                    return $this->add_book();
                    // redirect('admin/add_book','location');
                }
                $image="";
                if ($_FILES['photo']['size'] == 0) {
                    $image='cover_default'.'.jpg';
                    $is_uploaded=0;
                }

                if ($is_uploaded==1) {
                    // forming image name
                    $image=$space_stripped_image_name;
                }

            // photo upload ends

                if ($image) {
                    $config3['image_library'] = 'gd2';
                    $config3['source_image'] = $this->upload_path.'/cover_images/'.$image;
                    $config3['create_thumb'] =  true;
                    $config3['new_image'] = $this->upload_path.'/cover_images/thumbnail_cover_images/';
                    $config3['width'] = 160;
                    $config3['height'] = 210;
                    $this->image_lib->initialize($config3);
                    $this->load->library('upload', $config3);
                    $this->image_lib->resize();

                    $rename_image = explode(".", $image);
                    $old_image_file = $this->upload_path.'/cover_images/thumbnail_cover_images/'.$rename_image[0].'_thumb.jpg';
                    $new_image_file = $this->upload_path.'/cover_images/thumbnail_cover_images/'.$image;
                    rename($old_image_file, $new_image_file);
                }


                $data = array(
                    'physical_form'  => $physical_form,
                    'author'  => $author,
                    'subtitle'  => $subtitle,
                    'edition_year'  => $edition_year,
                    'publisher'  => $publisher,
                    'series'  => $series,
                    'size1'  => $size1,
                    'price'  => $price,
                    'call_no'  => $call_no,
                    'location'  => $location,
                    'clue_page'  => $clue_page,
                    'editor'  => $editor,
                    'title'  => $title,
                    'edition'  => $edition,
                    'publishing_year'  => $publishing_year,
                    'publication_place'  => $publication_place,
                    'number_of_pages'  => $number_of_pages,
                    'isbn'  => $isbn,
                    'source_details'  => $source_details,
                    'notes'  => $notes,
                    'add_date'  => $add_date,
                    'status' => '1'

                    );

                if ($image != '') {
                    $data['cover'] = $image;
                }
                if ($pdf != '') {
                    $data['pdf'] = $pdf;
                }
                if ($category != '') {
                    $data['category_id']  = $category;
                }
                if ($not_pdf_but_link_uploaded != '') {
                    $data['is_uploaded'] = $not_pdf_but_link_uploaded;
                } else {
                    $data['is_uploaded'] = '1';
                }

                $this->db->trans_start();
                $total_book = 0;
                $where_for_update_check['where'] = array(
                    'author'  => $author,
                    'title'  => $title,
                    'edition'  => $edition
                    );
                $exiting_info = $this->basic->get_data('library_book_info',$where_for_update_check,$select=array('number_of_books'));
                if ($exiting_info) {
                    $total_book = $exiting_info[0]['number_of_books'];
                    $total_book = $total_book + $number_of_books;
                    $update_where = array(
                        'author'  => $author,
                        'title'  => $title,
                        'edition'  => $edition
                        );
                    $update_data = array('number_of_books' => $total_book);
                    $this->basic->update_data('library_book_info',$update_where,$update_data);
                }

                if($total_book == 0)
                    $data['number_of_books'] = $number_of_books;
                else
                    $data['number_of_books'] = $total_book;


                $accession_no = array();
                $success = 0;
                if (!empty($data)) {
                    for ($i=0;$i<$number_of_books;$i++) {
                        $this->basic->insert_data('library_book_info', $data);
                        $accession_no[$i]['accession_no'] = $this->db->insert_id();
                    }
                    $success = 1;
                    $this->session->set_flashdata('success_message', 1);
                } else {
                    $this->session->set_flashdata("error_message", 1);
                    // return $this->add_book();
                    redirect('admin_library/add_book', 'location');
                }

                $this->db->trans_complete();
                if($this->db->trans_status() === false) {
                    $this->session->set_flashdata("error_message", 1);
                    redirect('admin_library/add_book', 'location');
                }


                if ($success == 1) {
                    $str = "";

                    $str .= "<div class='row' style='margin-top:27px;margin-left:20px;margin-right:20px;'>
                            <style>
                                @media print {
                                    div.page_break {page-break-after: always;}
                                }
                            </style>
                            <div class='col-xs-12'>
                    <link href='".base_url()."bootstrap/css/bootstrap.min.css' rel='stylesheet' type='text/css' />
                    <style>.btn{border-radius:0 !important;-moz-border-radius:0 !important;-webkit-border-radius:0 !important;}a{text-decoration:none !important;}</style>";
                    $i = 0;
                    foreach ($accession_no as $barcode) {
                        $src=base_url()."barcode.php?code=".$barcode['accession_no'];
                        $str .= "<div class='col-xs-6' style='padding:10px;'>
                        <div style='border:2px solid gray;height:230px;padding:10px;'>
                            <p><b>".$this->lang->line("title")." :</b>".$title."</p>
                            <p><b>".$this->lang->line("author")." :</b>".$author."</p>
                            <p><b>".$this->lang->line("edition")." :</b>".$edition."</p>
                            <p><b>".$this->lang->line("ISBN")." :</b>".$isbn."</p><br/>
                            <img src='".$src."' width='150px' height='35px' style='float:left;margin-top:0in;'/>
                        </div>
                    </div>";
                        $i++;
                        if ($i==8) {
                            $i=0;
                            $str .= "<div class='page_break'></div><br/><br/>";
                        }
                    }
                    $str .= "</div></div>";

                    $this->session->set_userdata('book_isbn_file_name', 1);
                    redirect("admin_library/book_list");
                    // $data['book_ids'] = $str;
                    // $data['category_info'] = $this->get_book_category();

                    // $data['body']='admin/library/view_library.php';
                    // return $this->_viewcontroller($data);					
				}
            }
        }
    }


	public function members()
    {
        $this->load->database();
        $this->load->library('grocery_CRUD');
        $crud = new grocery_CRUD();
        $crud->set_theme('flexigrid');
        $crud->set_table('student_info');
        $crud->order_by('id');
        $crud->where('deleted', '0');
        $crud->set_subject($this->lang->line("member types"));
        $crud->required_fields('class_roll');
        $crud->columns('id', 'class_roll','student_id','name');
        $crud->fields('class_roll','student_id');
        $crud->display_as('id', $this->lang->line("student id"));
        $crud->display_as('class_roll', $this->lang->line("class_roll"));
        $crud->display_as('student_id', $this->lang->line("student_id"));
        $crud->display_as('name', $this->lang->line("name"));

        $crud->set_rules('class_roll',$this->lang->line("Class roll"), 'required|is_unique[student_info.class_roll]');

        $crud->callback_after_insert(array($this, 'add_circulation_new_type'));
        $crud->unset_read();
        $crud->unset_print();
        $crud->unset_export();

        $output = $crud->render();
        $data['output']=$output;
        $data['crud']=1;
        $data['page_title'] = "Member Type";

        $this->_viewcontroller($data);
    }

    public function delete_book_action($id=0)
    {
        if(!in_array(28,$this->role_modules))  
        redirect('home/access_forbidden','location');       
        if(!in_array(4,$this->role_module_accesses_28))
        redirect('home/access_forbidden','location');

        $where_simple = array("library_book_info.id"=>$id);
        $where = array('where'=> $where_simple);
        $deleted = "1";  // binary values are considered string here

        // creating array of data
        $data = array( "deleted" => $deleted );

        // data insert and update both will be performed by $update_data function from basic model
        if (isset($data)) {
            $this->basic->update_data($table="library_book_info", $where=array("id" => $id), $update_data = $data);
            $this->session->set_flashdata('delete_success_message', 1);
            redirect('admin_library/book_list', 'location');
        }
    }


    ////////////////////////////////////////

    public function import_book_action_ajax(){

       if($_FILES['csv_file']['type'] == 'text/comma-separated-values' || $_FILES['csv_file']['type'] == 'application/vnd.ms-excel' || $_FILES['csv_file']['type'] == 'text/csv')
        {
        	$temp = explode('.',$_FILES['csv_file']['name']);

            $ext = trim(array_pop($temp));
            $username = $this->session->userdata('username');           
            $download_id = time();           

            $photo = $username."_".$download_id.".".$ext;  
            $photo=str_replace(" ","_",$photo);          
            $config = array
            (
                "allowed_types" => "*",
                "upload_path" => "./upload/book_import/",
                "file_name" => $photo,
                "overwrite" => TRUE
            );           

            $this->upload->initialize($config);
            $this->load->library('upload', $config);
            $this->upload->do_upload('csv_file');
            $photo_name = $photo;
            $path = FCPATH."upload/book_import/".$photo_name;
            $path=str_replace("\\", "/", $path);

        $table = 'library_book_info';
//section for getting last id.****************************
        $select_last_id = 'id';      
        $order_by_last_id='id desc';
        $limit_last_id=1;

       $info = $this->basic->get_data($table, $where='', $select_last_id, $join='', $limit_last_id, $start=null, $order_by_last_id);
       $last_id = 0;
       if(!empty($info))    $last_id = $info[0]['id'];
//end of section last id.*********************************


//section for insertinr csv data. ************************
        $query="LOAD DATA LOCAL INFILE '$path'
                INTO TABLE {$table}
                Fields TERMINATED BY ','
                LINES TERMINATED BY '\n'
                (isbn, title, author,edition, edition_year, number_of_books, pdf)";        
        $this->db->query($query);
//end of section of inserting csv data. ********************  


//section for update add-date.*****************************

        $add_date = date("Y-m-d H:i:s");
        $this->basic->update_data($table,array('id >'=>$last_id),array('add_date'=>$add_date));

//end of section update add_date.***************************
        

//Section to delete first row of csv file.***********************
      $table = 'library_book_info';
      $where = array('isbn' => 'ISBN');
      $data = array('deleted' => '1');

      $this->basic->update_data($table, $where, $data);

//End of the section of delete first row. *************************

        echo "Your data inserted successfully";
       
        }
        else
            echo "Sorry! (".$_FILES['csv_file']['type'].") type is not allowed.";
    }


    public function barcode_generate_id(){
   	if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            redirect('home/access_forbidden', 'location');
        }

        $info=$this->input->post('info', true);
        $info=json_decode($info, true);
        $str = '<br><br/>';
        $str .= "<style>
                    p{margin-bottom:6px !important;font-size:13px;}
                    @media print {
                        div.page_break {page-break-after: always;}

                    }
                </style>
                <link href='".base_url()."bootstrap/css/bootstrap.min.css' rel='stylesheet' type='text/css' />
                <style>.btn{border-radius:0 !important;-moz-border-radius:0 !important;-webkit-border-radius:0 !important;}a{text-decoration:none !important;}</style>";
        $i = 0;
        foreach ($info as $barcode) 
        {           
            $i++;           

            $src=base_url()."barcode.php?code=".$barcode['id'];
            $class="pull-left";
            $style="";
            if($i%2==0) {$class="pull-right"; $style='margin-right:.15in;';}
            $img_url = base_url().'assets/images/logo.png';
            if($i%2!=0 || $i==1) 
            $str .= "<div class='row clearfix' style='width:100%;min-height:2.3in !important;margin-left:.15in;'>";
                $str .= "<div class='clearfix {$class}' style='padding:10px;width:3.36in !important;height:2.125in !important;border:1px solid gray; {$style}'>
                   
                        <img class='img-responsive pull-left' style='height:30px;margin-top:3px;' src='".$img_url."' alt='Logo'>
                        <img class='pull-right' src='".$src."' width='150px' height='35px' style='margin-top:0in;'/>
                        <p style='margin-top:50px;'><hr style='margin:5px 0;'>
                        <p><b>".$this->lang->line("name")." : </b>".$barcode['name']."</p>
                        <p><b>".$this->lang->line("member types")." : </b>".$barcode['type_id']."</p>
                        <p><b>".$this->lang->line("address")." : </b>".$barcode['address']."</p>
                        <p><b>".$this->lang->line("email")." : </b>".$barcode['email']."</p>
                        <p><b>".$this->lang->line("mobile")." : </b>".$barcode['mobile']."</p>
                    
                </div>";
                
            if($i%2==0) 
            $str.="</div>";

            if ($i==8) 
            {
                $i=0;
                $str .= "<div class='page_break'></div><br/><br/>";
            }
        }

        echo $str;

   }


   public function barcode_generate()
    {
        if(!in_array(28,$this->role_modules))  
        redirect('home/access_forbidden','location'); 
         
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            redirect('home/access_forbidden', 'location');
        }

        $info=$this->input->post('info', true);
        $info=json_decode($info, true);
        $str = "";
        $str .= "<div class='row' style='margin-top:27px;margin-left:20px;margin-right:20px;'>
                <div class='col-xs-12'>
                <style>
                    @media print {
                        div.page_break {page-break-after: always;}
                    }
                </style>
                <link href='".base_url()."bootstrap/css/bootstrap.min.css' rel='stylesheet' type='text/css' />
                <style>.btn{border-radius:0 !important;-moz-border-radius:0 !important;-webkit-border-radius:0 !important;}a{text-decoration:none !important;}</style>";
        $i = 0;
        foreach ($info as $barcode) {
            $src=base_url()."barcode.php?code=".$barcode['id'];
            $str .= "<div class='col-xs-6' style='padding:10px;'>
                <div style='border:2px solid gray;height:230px;padding:10px;'>
                    <p><b>".$this->lang->line("title")." :</b>".$barcode['title']."</p>
                    <p><b>".$this->lang->line("author")." :</b>".$barcode['author']."</p>
                    <p><b>".$this->lang->line("edition")." :</b>".$barcode['edition']."</p>
                    <p><b>".$this->lang->line("ISBN")." :</b>".$barcode['isbn']."</p><br/>
                    <img src='".$src."' width='150px' height='35px' style='float:left;margin-top:0in;'/>
                </div>
            </div>";
            $i++;
            if ($i==8) {
                $i=0;
                $str .= "<div class='page_break'></div><br/><br/>";
            }
        }
        $str .= "</div></div>";

        echo $str;
    }



    public function circulation()
    {
        if(!in_array(28,$this->role_modules))  
        redirect('home/access_forbidden','location');  

        $data['body'] = 'admin/library/circulation';
        $data['page_title'] = 'Book Circulation';
        $this->_viewcontroller($data);
    }


    public function circulation_data()
    {
        if(!in_array(28,$this->role_modules))  
        redirect('home/access_forbidden','location');  

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            redirect('home/access_forbidden', 'location');
        }


        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 15;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'member_id';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'ASC';
        $order_by_str = $sort." ".$order;

        // setting properties for search
        $book_id = trim($this->input->post('book_id', true));
        $member_name = trim($this->input->post('name', true));
        $book_title  = trim($this->input->post('book_title', true));
        $author      = trim($this->input->post("author", true));
        $return_status      = trim($this->input->post("return_status", true));

        $from_date = $this->input->post('from_date');
        if ($from_date != '') {
            $from_date = date('Y-m-d', strtotime($from_date));
        }

        $to_date = $this->input->post('to_date');
        if ($to_date != '') {
            $to_date = date('Y-m-d', strtotime($to_date));
        }

        // setting a new properties for $is_searched to set session if search occured
        $is_searched = $this->input->post('is_searched', true);

        if ($is_searched) {
            // if search occured, saving user input data to session. name of method is important before field
            $this->session->set_userdata('circulation_data_book_id', $book_id);
            $this->session->set_userdata('circulation_data_name', $member_name);
            $this->session->set_userdata('circulation_data_book_title', $book_title);
            $this->session->set_userdata('circulation_data_author', $author);
            $this->session->set_userdata('circulation_data_from_date', $from_date);
            $this->session->set_userdata('circulation_data_to_date', $to_date);
            $this->session->set_userdata('circulation_data_status', $return_status);
        //  $this->session->set_userdata('book_list_category',$category_id);
        }

        // saving session data to different search parameter variables
        $search_book_id = $this->session->userdata('circulation_data_book_id');
        $search_member_name = $this->session->userdata('circulation_data_name');
        $search_book_title  = $this->session->userdata('circulation_data_book_title');
        $search_author = $this->session->userdata('circulation_data_author');
        $search_to_date = $this->session->userdata('circulation_data_to_date');
        $search_from_date = $this->session->userdata('circulation_data_from_date');
        $search_status = $this->session->userdata('circulation_data_status');
    //  $search_category=$this->session->userdata('book_list_category');

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
        if ($search_book_id) {
            $where_simple['book_id'] = $search_book_id;
        }
        if ($search_member_name) {
            $where_simple['student_info.name like'] = "%".$search_member_name."%";
        }
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

        $where  = array('where' => $where_simple);

        $offset = ($page-1)*$rows;
        $result = array();

        $join = array(
            "student_info" => "student_info.id = circulation.member_id,left",
            "library_book_info" => "library_book_info.id = circulation.book_id,left"
            );

        $table = 'circulation';

        $info = $this->basic->get_data($table, $where, $select='', $join, $limit = $rows, $start = $offset, $order_by = $order_by_str);

        $total_rows_array = $this->basic->count_row($table, $where, $count="circulation.id", $join);
        $total_result = $total_rows_array[0]['total_rows'];     
        

        echo convert_to_grid_data($info, $total_result);
    }

    public function add_circulation()
    {
        if(!in_array(28,$this->role_modules))  
        redirect('home/access_forbidden','location');       
        if(!in_array(2,$this->role_module_accesses_28))
        redirect('home/access_forbidden','location');

        $data['body'] = 'admin/library/add_circulation';
        $data['page_title'] = 'Add Circulation Data';
        $this->_viewcontroller($data);
    }

    public function add_circulation_action()
    {
        if(!in_array(28,$this->role_modules))  
        redirect('home/access_forbidden','location');       
        if(!in_array(2,$this->role_module_accesses_28))
        redirect('home/access_forbidden','location');

        $data['body'] = 'admin/library/add_circulation';

        $this->session->set_userdata("srarch_member_id", $this->input->post('member_id'));
        $member_id = $this->session->userdata("srarch_member_id");

        $table = 'student_info';
        $where_issue_limit['where'] = array('student_info.id' => $member_id);

        // $join = array('circulation_config' => "student_info.type_id=circulation_config.member_type_id,left");

        if ($this->basic->get_data($table, $where_issue_limit, $select = '')) {
            $info_issue = $this->basic->get_data($table, $where_issue_limit, $select = '');
            $info_issue_1 = $this->basic->get_data('circulation_config');
            $fine_per_day = $info_issue_1[0]['fine_per_day'];
            $book_limit = $info_issue_1[0]['issu_book_limit'];
            $member_name = $info_issue[0]['name'];
            $day_limit = $info_issue_1[0]['issue_day_limit'];
            $data['fine_per_day'] = $fine_per_day;
            $data['book_limit'] = $book_limit;
            $data['member_name'] = $member_name;
            $data['day_limit'] = $day_limit;
        } else {
            $member_exist = array();
            $data['member_exist'] = $member_exist;
        }

        $table = 'student_info';
        $where['where'] = array('id' => $member_id);
        if ($this->basic->get_data($table, $where)) {
            $table = 'circulation';
            $where['where'] = array('member_id' => $member_id, 'is_returned' => 0);
            $join = array('library_book_info'=>'library_book_info.id = circulation.book_id,left');
            $info = $this->basic->get_data($table, $where,$select='',$join);
            $data['info'] = $info;
            $member_exist = array('exist');
            $data['member_exist'] = $member_exist;
            $data['row'] = count($data['info']);
        } else {
            $member_exist = array();
            $data['member_exist'] = $member_exist;
        }
        $this->_viewcontroller($data);
    }

    public function get_suggestion_for_book()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            redirect('home/access_forbidden', 'location');
        }

        $book_name = $this->input->post('book_name', true);
        if ($book_name != '') {
            $where_book['or_where'] = array('title like '=> '%'.$book_name.'%','id like ' => $book_name.'%');
            $where_book['where'] = array('status' => '1');
            $select_book = array('id','title');
            $results = $this->basic->get_data('library_book_info', $where_book, $select_book, $join='', $limit=20);
            $str = "<table class='table table-hover'>";
            foreach ($results as $result) {
                $str .= "<tr class='book_name' book_id='".$result['id']."'><td>".$result['title']." | book id- ".$result['id']."</td></tr>";
            }
            $str .= "</table>";
            echo $str;
        } else {
            echo '';
        }
    }


    public function get_suggestion_for_member()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            redirect('home/access_forbidden', 'location');
        }

        $member_name = $this->input->post('member_name', true);
        if ($member_name != '') {
            $where_member['or_where'] = array('name like '=> '%'.$member_name.'%','student_id like' => $member_name.'%');
           
            $select_member = array('id','name');
            $results = $this->basic->get_data('student_info', $where_member, $select_member, $join = '', $limit = 20);
            $str = "<table class='table table-hover'>";
            foreach ($results as $result) {
                $str .= "<tr class='member_name' member_id='".$result['id']."'><td>".$result['name']." | member id- ".$result['id']."</td></tr>";
            }
            $str .= "</table>";
            echo $str;
        } else {
            echo '';
        }
    }

    public function new_issue_action()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            redirect('home/access_forbidden', 'location');
        }

        if(!in_array(28,$this->role_modules))  
        redirect('home/access_forbidden','location');       
        if(!in_array(2,$this->role_module_accesses_28))
        redirect('home/access_forbidden','location');

        $book_id = $this->input->post("book_id", true);
        $member_id = $this->session->userdata("srarch_member_id");

        //section check for availability of this book.

        $table_avl_check = 'circulation';
        $where_avl_check['where'] = array('book_id' => $book_id, 'is_returned' => '0');

        $where_present_check['where'] = array('book_id' => $book_id);

        if ($this->basic->get_data($table_avl_check, $where_present_check)) {
            if ($this->basic->get_data($table_avl_check, $where_avl_check)) {
                echo 'unavail';
                exit();
            }
        }
        //end of section check for availability of this book.

        //Secction:(A) for finding the issue day limit for a specific member.

        // $table = 'student_info';
        // $where['where'] = array('member.id' => $member_id);
        // $join = array('circulation_config' => "member.type_id=circulation_config.member_type_id,left");
        // $info_issue = $this->basic->get_data($table, $where, $select = '', $join);

        $info_issue = $this->basic->get_data('circulation_config');

        $day_limit = $info_issue[0]['issue_day_limit'];
        $book_limit = $info_issue[0]['issu_book_limit'];

        //get total issued book of this user.
        $select = array('count(id) as total_issued');
        $where['where'] = array('member_id' => $member_id, 'is_returned' => '0');
        $total_issued_book_info = $this->basic->get_data('circulation', $where, $select);

        $member_issued_book = $total_issued_book_info[0]['total_issued'];
        if ($book_limit != 0) {
            if ($book_limit <= $member_issued_book) {
                echo '0';
                exit();
            }
        }

     //End of Section(A).


    //Section(C) for updating book_info Table(In case of Issueing a book).

        $where = array('id' => $book_id);
        $data = array('status' => '0');
        $this->basic->update_data('library_book_info', $where, $data);

    //End of Section(c).


     //Section:(B) for for inserting new issue in the circulation table.

        $table_insert = 'circulation';
        $issue_date = date("Y-m-d");
        $expire_date = date('Y-m-d', strtotime($issue_date." +$day_limit day"));


        $data = array(
            'member_id' => $member_id,
            'book_id' => $book_id,
            'issue_date' => $issue_date,
            'expire_date' => $expire_date,
            'is_returned' => 0
            );
        if ($this->basic->insert_data($table_insert, $data)) {
            $circulation_id = $this->db->insert_id();
            $join = array('library_book_info'=>'library_book_info.id = circulation.book_id,left');
            $where['where'] = array('member_id' => $member_id, 'circulation.id' => $circulation_id);
            $new_issue = $this->basic->get_data($table_insert, $where,$select='',$join);
            $new_issue = $new_issue[0];

            echo "<tr id = 'tr_{$new_issue['id']}' class = 'display_row'>
            <td>{$new_issue['book_id']}</td>
            <td>{$new_issue['title']}</td>
            <td>{$new_issue['author']}</td>
            <td>{$new_issue['issue_date']}</td>
            <td>{$new_issue['expire_date']}</td>
            <td>{$new_issue['fine_amount']}</td>
            <td><a id='return_{$new_issue['id']}' class='btn btn-warning return'><i class='fa fa-reply'></i> ".$this->lang->line("return")."</a></td>

            </tr>";
        } else {
            echo "failed";
        }

        //End of section(B);

    }

    /**
    * Issue checking
    * @access public
    * @return string
    */
    public function new_issue_check()
    {
        if(!in_array(28,$this->role_modules))  
        redirect('home/access_forbidden','location');

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            redirect('home/access_forbidden', 'location');
        }

        $book_id = $this->input->post('book_id', true);

        $table = 'library_book_info';
        $where['where'] = array('id' => $book_id);
        if ($this->basic->get_data($table, $where)) {
            $check_info = $this->basic->get_data($table, $where);
            $check_info = $check_info[0];
            $cover = site_url('upload/cover_images').'/'.$check_info['cover'];
        } else {
            $cover = 'wrong_id';
        }
        echo $cover;

    }    

    public function update_circulation()
    {
        if(!in_array(28,$this->role_modules))  
        redirect('home/access_forbidden','location');       
        if(!in_array(3,$this->role_module_accesses_28))
        redirect('home/access_forbidden','location');

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            redirect('home/access_forbidden', 'location');
        }

        $table = 'circulation';
        $id = $this->input->post('id', true);
        $expire_flag = '0';

        //Section:(A) for get Member ID and Expire Date.
        $get_where['where'] = array('book_id' => $id);
        $info = $this->basic->get_data($table, $get_where);

        $return_date = date("Y-m-d");
        $expire_date = $info[0]['expire_date'];
        $member_id =  $info[0]['member_id'];
        //End of Section:(A).


        //Section:(B) for getting  fine_per_day.
        /*$table = 'student_info';
        $where_issue_limit['where'] = array('student_info.id' => $member_id);
*/
        // $join = array('circulation_config' => "member.type_id=circulation_config.member_type_id,left");

        // $info_issue = $this->basic->get_data($table, $where_issue_limit, $select = '', $join);
        $info_issue_1 = $this->basic->get_data('circulation_config');
        $fine_per_day = $info_issue_1[0]['fine_per_day'];

        //End of Section:(B).

        //Section:(C) for calculating 2 date differecne and fine.

        if (strtotime($return_date) > strtotime($expire_date)) {
            $diff = abs(strtotime($return_date) - strtotime($expire_date));
            $years = floor($diff / (365*60*60*24));
            $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
            $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
            $fine_amount = $fine_per_day * $days;
            $expire_flag = '1';
        } else {
            $fine_amount = 0;
            $fine_per_day =0;
        }

        //End of Section:(C)

        $table = 'circulation';
        $where = array('book_id' => $id);
        $data = array(
            'is_returned'=>1,
            'fine_amount'=>$fine_amount,
            'return_date'=>$return_date,
            'is_expired'=>$expire_flag
            );
        $this->basic->update_data($table, $where, $data);

    //Section(D) for updating book_info Table(In case of returning a book).
   
        $where['where'] = array('book_id' => $id);
        $book_id = $this->basic->get_data('circulation', $where);
        $book_id = $book_id[0]['book_id']; 

        $where = array('id' => $book_id);
        $data = array('status' => '1');
        $this->basic->update_data('library_book_info', $where, $data);
        
    //End of Section(D).

    }




}