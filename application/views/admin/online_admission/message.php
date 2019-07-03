<?php 
	if($this->session->userdata('applicant_to_merit_success')){
		echo "<div class='alert alert-success text-center'><h4 style='margin:0;'><i class='fa fa-check-circle'></i> ".$this->session->userdata('applicant_to_merit_success'). $this->lang->line('Applicant has been moved to merit list.'). "</h4></div>";
		$this->session->unset_userdata('applicant_to_merit_success');
	}
	if($this->session->userdata('success_in_payment')){
		echo "<div class='alert alert-success text-center'><h4 style='margin:0;'><i class='fa fa-check-circle'></i> ".$this->session->userdata('success_in_payment')."</h4></div>";
		$this->session->unset_userdata('success_in_payment');
	}
	if($this->session->userdata('error_in_payment')){
		echo "<div class='alert lert-danger text-center'><h4 style='margin:0;'><i class='fa fa-check-circle'></i> ".$this->session->userdata('error_in_payment')."</h4></div>";
		$this->session->unset_userdata('error_in_payment');
	}
	
	if($this->session->userdata('error_in_admission')){
		echo "<div class='alert lert-danger text-center'><h4 style='margin:0;'><i class='fa fa-check-circle'></i> ".$this->session->userdata('error_in_admission')."</h4></div>";
		$this->session->unset_userdata('error_in_admission');
	}
	if($this->session->userdata('delete_from_merit')){
		echo "<div class='alert alert-success text-center'><h4 style='margin:0;'><i class='fa fa-check-circle'></i> ".$this->session->userdata('delete_from_merit')."</h4></div>";
		$this->session->unset_userdata('delete_from_merit');
	}
	if($this->session->userdata('success_in_admission')){
      $link = $this->session->userdata('link');
      $download_link = base_url().'/'.$link;
      $success_str = "<div class='alert alert-success text-center'><h4 style='margin:0;'><i class='fa fa-check-circle'></i> ".$this->session->userdata('success_in_admission');
      if($this->session->userdata('link') != '')
        $success_str .= "&nbsp;&nbsp;<a class='btn btn-warning border_radius' href='".$download_link."'><i class='fa fa-print'></i>".$this->lang->line("print slip")."</a></h4></div>";
      else
        $success_str .= "</h4></div>";
      echo $success_str;
      $this->session->unset_userdata('success_in_admission');
      $this->session->unset_userdata('link');
    }

?>