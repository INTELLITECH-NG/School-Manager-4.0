<style type="text/css">
  .padded
  {
    padding:20px;
  }
  .margin_top
  {
    margin: 10px;
  }
  .column-title
  {
    text-align: left;
    font-size: 9px;
    font-family: 'Open Sans';
  }
  .column-title::after {
      border-bottom: 1px solid #45aed6;
      bottom: -1px;
      content: " ";
      left: 0;
      position: absolute;
      width: 40%;
  }
  .column-title {
      border-bottom: 1px solid #eee;
      margin-bottom: 15px;
      margin-top: 0;
      padding-bottom: 15px;
      position: relative;
  }
  .border_radius{
    -moz-border-radius: 8px;
    -webkit-border-radius: 8px;
    border-radius: 8px;
  }
</style>

<section class="content-header">
  <section class="content">
    <div class="box box-info custom_box">
      <div class="box-header">
        <h3 class="box-title"><i class="fa fa-plus-circle"></i> <?php echo $this->lang->line("add student");?></h3>
      </div><!-- /.box-header -->
      <?php
        if($this->session->flashdata('student_added')){
          $link = $this->session->userdata('link');
          $download_link = base_url().'/'.$link;
          $success_str = "<div class='alert alert-success text-center'><h4 style='margin:0;'><i class='fa fa-check-circle'></i> ".$this->session->flashdata('student_added');
          if($this->session->userdata('link') != '')
            $success_str .= "&nbsp;&nbsp;<a class='btn btn-warning border_radius' href='".$download_link."'><i class='fa fa-print'></i> ".$this->lang->line('print slip')."</a></h4></div>";
          else
            $success_str .= "</h4></div>";
          echo $success_str;
          $this->session->unset_userdata('link');
        }
        if($this->session->flashdata('error_message'))
          echo '<div class="alert alert-danger text-center" id="added_flash"><h1>',$this->lang->line('an error occured'),'!!!','</h1></div>';
        if($this->session->flashdata('upload_error'))
          echo '<div class="alert alert-danger text-center" id="">'.$this->session->flashdata('upload_error').'</h1></div>';
      ?>
      <div class="box-body">
        <form method="POST" enctype="multipart/form-data" action="<?php echo site_url('admin_student/add_student_action'); ?>" class="application">
        <div class="row">

          <div class="col-sm-12 col-xs-12 col-md-6 col-lg-6 grid_content">
            <div class="padded background_white margin_top basic_info">
              <h6 class="column-title"><i class="fa fa-user fa-2x blue"> <?php echo $this->lang->line("basic information");?></i></h6>
              <div class="account-wall">
                
                <div class="form-group">
                  <label for="student_name"><?php echo $this->lang->line("name");?> *</label>
                    <input required type="text" class="form-control" id="student_name" name="student_name" value="<?php echo set_value('student_name'); ?>" placeholder='<?php echo $this->lang->line("Student's Name");?>' />
                    <span class="red"><?php echo form_error('student_name'); ?></span>
                </div>

                <div class="form-group">
                  <label for="student_email"><?php echo $this->lang->line("email");?></label>
                    <input type="email" class="form-control" id="student_email" name="student_email" value="<?php echo set_value('student_email'); ?>"  placeholder='<?php echo $this->lang->line("Student's Email");?>' />
                    <span class="red"><?php echo form_error('student_email'); ?></span>
                </div>

                <div class="form-group">
                  <label for="student_mobile"><?php echo $this->lang->line("mobile no.");?></label>
                    <input type="text" class="form-control" id="student_mobile" name="student_mobile" value="<?php echo set_value('student_mobile'); ?>" placeholder='<?php echo $this->lang->line("student's Mobile");?>' />
                    <span class="red"><?php echo form_error('student_mobile'); ?></span>
                </div>

                <div class="form-group">
                  <label for="date_of_birth"><?php echo $this->lang->line("date of birth");?> *</label>
                    <input type="text" class="form-control" id="date_of_birth" name="date_of_birth" value="<?php echo set_value('date_of_birth'); ?>" placeholder='<?php echo $this->lang->line("student's date of birth");?>' />
                    <span class="red"><?php echo form_error('date_of_birth'); ?></span>
                </div>

                <div class="form-group">
                  <label><?php echo $this->lang->line("gender")?> *</label>
                    <label class="radio-inline">
                      <input type="radio" name="gender" value="male" <?php if($this->input->post('gender') === 'male') echo 'checked'; ?> >Male
                    </label>
                    <label class="radio-inline">
                      <input type="radio" name="gender" value="female" <?php if($this->input->post('gender') === 'female') echo 'checked'; ?> >Female
                    </label>
                    <span class="red"><?php echo form_error('gender'); ?></span>
                </div>

                <div class="form-group">
                  <label><?php echo $this->lang->line("religion");?> *</label>
                    <?php 
                      $religion['']=$this->lang->line("religion");
                      echo form_dropdown('religion',$religion,set_value('religion'),'class="form-control" id="religion"');  
                    ?>               
                    <span class="red"><?php echo form_error('religion'); ?></span>
                </div>

                <div class="form-group">
                  <label><?php echo $this->lang->line("attach photo");?></label>
                    <?php echo form_upload('userfile'); ?>
                    <span class="red"><?php echo form_error('userfile'); ?></span><p><?php echo $this->lang->line("max: 250kb, jpg/png");?></p> 
                </div>

              </div>
            </div>
          </div> <!-- end of col -->

          <div class="col-sm-12 col-xs-12 col-md-6 col-lg-6 grid_content">
            <div class="padded background_white margin_top basic_info">
              <h6 class="column-title"><i class="fa fa-user-plus fa-2x blue"> <?php echo $this->lang->line("gurdian information");?></i></h6>
              <div class="account-wall">

                <div class="form-group">
                  <label for="father_of_student"><?php echo $this->lang->line("father's name");?> *</label>
                    <input required type="text" class="form-control" id="father_of_student" name="father_of_student" value="<?php echo set_value('father_of_student'); ?>" placeholder="<?php echo $this->lang->line('father name');?>" />
                    <span class="red"><?php echo form_error('father_of_student'); ?></span>
                </div>

                <div class="form-group">
                  <label for="mother_of_student"><?php echo $this->lang->line("mother's name");?> *</label>
                    <input required type="text" class="form-control" id="mother_of_student" name="mother_of_student" value="<?php echo set_value('mother_of_student'); ?>" placeholder="<?php echo $this->lang->line('mother name');?>" />
                    <span class="red"><?php echo form_error('mother_of_student'); ?></span>
                </div>

                <div class="form-group">
                  <label for="gurdian_of_student"><?php echo $this->lang->line("gurdian's name");?> *</label>
                    <input required type="text" class="form-control" id="gurdian_of_student" name="gurdian_of_student" value="<?php echo set_value('gurdian_of_student'); ?>" placeholder="<?php echo $this->lang->line('student gurdians name');?>" />
                    <span class="red"><?php echo form_error('gurdian_of_student'); ?></span>
                </div>

                <div class="form-group">
                  <label for="relation_with_student"><?php echo $this->lang->line("relation with student");?> *</label>
                    <input required type="text" class="form-control" id="relation_with_student" name="relation_with_student" value="<?php echo set_value('relation_with_student'); ?>" placeholder="<?php echo $this->lang->line('gurdian relation with student');?>" />
                    <span class="red"><?php echo form_error('relation_with_student'); ?></span>
                </div>

                <div class="form-group">
                  <label for="gurdian_mobile"><?php echo $this->lang->line("gurdian's mobile no.");?> *</label>
                    <input required type="text" class="form-control" id="gurdian_mobile" name="gurdian_mobile" value="<?php echo set_value('gurdian_mobile'); ?>" placeholder="<?php echo $this->lang->line('gurdian mobile no.');?>" />
                    <span class="red"><?php echo form_error('gurdian_mobile'); ?></span>
                </div>

                <div class="form-group">
                  <label for="gurdian_email"><?php echo $this->lang->line("gurdian's email");?></label>
                    <input type="email" class="form-control" id="gurdian_email" name="gurdian_email" value="<?php echo set_value('gurdian_email'); ?>"  placeholder="<?php echo $this->lang->line('gurdian email');?>" />
                    <span class="red"><?php echo form_error('gurdian_email'); ?></span>
                </div>

              </div>
            </div>
          </div> <!-- end of col -->

        </div> <!-- end of row -->
        <div class="row">
          <div class="col-sm-12 col-xs-12 col-md-6 col-lg-6 grid_content">
            <div class="padded background_white margin_top basic_info">
              <h6 class="column-title"><i class="fa fa-graduation-cap fa-2x blue"> <?php echo $this->lang->line("academic information");?></i></h6>
              <div class="account-wall">
                <div class="form-group">
                  <label for="financial_year_id"><?php echo $this->lang->line("session");?> *</label>
                    <?php 
                       $session_info['']=$this->lang->line('session'); 
                       echo form_dropdown('financial_year_id',$session_info,"",'class="form-control" id="financial_year_id" required="required" onchange="get_course()"'); 
                    ?>
                  <span class="red"><?php echo form_error('financial_year_id'); ?></span>
                </div>

                <div class="form-group">
                  <label for="s_class_id"><?php echo $this->lang->line("class");?> *</label>

                    <?php 
                      $class_info['']=$this->lang->line("class");               
                      echo form_dropdown('class_id',$class_info,"",'class="form-control" id="s_class_id" required="required" onchange="get_department()"'); 
                    ?>

                  <span class="red"><?php echo form_error('class_id'); ?></span>
                </div>

                <div class="form-group">
                  <label for="department_id"><?php echo $this->lang->line("group / dept.");?> *</label>
                  <div id="search_dept">

                    <?php 
                      $dept_info['']=$this->lang->line("group / dept.");
                      echo form_dropdown('dept_id',$dept_info,"",'class="form-control" id="department_id" required="required"'); 
                    ?>

                  </div>
                  <span class="red"><?php echo form_error('dept_id'); ?></span>
                </div>


                <div class="form-group">
                  <label for="student_courses"><?php echo $this->lang->line("courses");?> *</label>
                  <div id="search_courses">
                    
                  </div>
                </div>

                <div class="form-group">
                  <label for="shift_id"><?php echo $this->lang->line("shift");?></label>

                    <?php 
                      $shift_info['']=$this->lang->line("shift");
                      echo form_dropdown('shift_id',$shift_info,$default_shift['id'],'class="form-control" id="shift_id"'); 
                    ?>

                  <span class="red"><?php echo form_error('shift_id'); ?></span>
                </div>

                <div class="form-group">
                  <label for="section_id"><?php echo $this->lang->line("section");?></label>

                    <?php 
                      $section_info['']=$this->lang->line("section");
                      echo form_dropdown('section_id',$section_info,$default_section['id'],'class="form-control" id="section_id"'); 
                    ?>

                  <span class="red"><?php echo form_error('section_id'); ?></span>
                </div>

              </div>
            </div>
          </div> <!-- end of col -->
          <div class="col-sm-12 col-xs-12 col-md-6 col-lg-6 grid_content">
            <div class="padded background_white margin_top basic_info">
              <h6 class="column-title"><i class="fa fa-money fa-2x blue"> <?php echo $this->lang->line("payment information");?></i></h6>
              <div class="account-wall">
                <div id="payment_info">
                  
                </div>
              </div>
            </div>
          </div> <!-- end of col -->

        </div> <!-- end of row -->

      </div> <!-- end of box-body -->

      <div class="box-footer">
        <div class="form-group">
          <div class="col-sm-12 text-center">
            <input name="submit" type="submit" class="btn btn-warning btn-lg" value="<?php echo $this->lang->line('save');?>"/>      
            <input type="button" class="btn btn-default btn-lg" value="<?php echo $this->lang->line('cancel');?>" onclick='goBack("admin_student/index",1)'/>
          </div>
        </div>        
      </div><!-- /.box-footer --> 

    </div> <!-- end of box-info -->
  </section>
</section>


<script type="text/javascript">

  function get_department(){
    var class_id = $("#s_class_id").val();
    var img="<img src='"+"<?php echo base_url('assets/pre-loader/Fading squares.gif');?>"+"' alt=<?php echo $this->lang->line('loading');?>...'/> <?php echo $this->lang->line('please wait');?>...";

    $("#search_dept").html(img);
    var url = "<?php echo site_url('admin_student/ajax_get_dept_based_on_class');?>";
    $.ajax({
      url: url, 
      type: 'POST',  
      data: {class_id:class_id}, 
      async: false, cache: false, 
      success: function (response){
        $('#search_dept').html(response);
        $('#payment_info').html('');
        $('#search_courses').html('');
      }
    });
  }

  function get_course()
  {
    var class_id = $("#s_class_id").val();
    var dept_id = $("#department_id").val();
    var session_id = $("#financial_year_id").val();

    var img="<img src='"+"<?php echo base_url('assets/pre-loader/Fading squares.gif');?>"+"' alt='Loading...'/> Please wait...";

    if(class_id != '' && dept_id != '' && session_id != '')
    {
      $("#search_courses").html(img);
      var url = "<?php echo site_url('admin_student/ajax_get_student_course');?>";
      $.ajax({
        url: url, 
        type: 'POST',  
        data: {class_id:class_id,dept_id:dept_id,session_id:session_id}, 
        async: false, cache: false, 
        success: function (response){
          $('#search_courses').html(response);
        }
      });

      var url_1 = "<?php echo site_url('admin_student/ajax_get_student_payment_info');?>";
      $.ajax({
        url: url_1, 
        type: 'POST',  
        data: {class_id:class_id,dept_id:dept_id,session_id:session_id}, 
        async: false, cache: false, 
        success: function (response){
          $('#payment_info').html(response);
        }
      });

    }
  }


 $j("document").ready(function(){
    var todate="<?php echo date('Y');?>";
      var from=todate-70;
      var to=todate-12;
      var str=from+":"+to;
    $('#date_of_birth').datepicker({format: "dd-mm-yyyy",changeMonth:true, changeYear:true,yearRange: str, startView: "decade" });

    $('#added_flash').fadeOut(6000);

    $(document.body).on('click','#print_slip',function(){
      var fees = $('#fees').is(":checked");
      // alert(fees);
      if(fees == false){
        $(this).removeAttr('checked');
        alert('Please select the pay fees first');
      }
    });
    $(document.body).on('click','#fees',function(){
      var fees = $('#fees').is(":checked");
      // alert(fees);
      if(fees == false){
        $('#print_slip').removeAttr('checked');
      }
    });

  });
  
</script>