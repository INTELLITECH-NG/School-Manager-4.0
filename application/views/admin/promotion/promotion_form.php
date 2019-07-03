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
        <h3 class="box-title"><i class="fa fa-plus-circle"></i> <?php echo $this->lang->line('promotion student');?></h3>
      </div><!-- /.box-header -->
      
      <div class="box-body">
        <form method="POST" enctype="multipart/form-data" action="<?php echo site_url('promotion/promotion_student_form_action'); ?>" class="application">
       
        <div class="row">
          <div class="col-sm-12 col-xs-12 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3 grid_content">
            <div class="padded background_white margin_top basic_info">
              <h6 class="column-title"><i class="fa fa-graduation-cap fa-2x blue"> <?php echo $this->lang->line('new academic information for');?> [<?php echo $name; ?>]</i></h6>
              <div class="account-wall">
                <div class="form-group">
                  <label for="financial_year_id"><?php echo $this->lang->line('session');?> *</label>
                    <?php 
                       $session_info['']=$this->lang->line('session'); 
                       echo form_dropdown('financial_year_id',$session_info,"",'class="form-control" id="financial_year_id" required="required" onchange="get_course()"'); 
                    ?>
                  <span class="red"><?php echo form_error('financial_year_id'); ?></span>
                </div>

                <div class="form-group">
                  <label for="s_class_id"><?php echo $this->lang->line('Class');?> *</label>
                    <?php 
                      $class_info['']=$this->lang->line('class');                     
                      echo form_dropdown('class_id',$class_info,"",'class="form-control" id="s_class_id" required="required" onchange="get_department()"'); 
                    ?>
                  <span class="red"><?php echo form_error('class_id'); ?></span>
                </div>

                <div class="form-group">
                  <label for="department_id"><?php echo $this->lang->line('group / dept.');?> *</label>
                  <div id="search_dept">
                    <?php 
                      $dept_info['']= $this->lang->line('group / dept');                     
                      echo form_dropdown('dept_id',$dept_info,"",'class="form-control" id="department_id" required="required"'); 
                    ?>
                  </div>
                  <span class="red"><?php echo form_error('dept_id'); ?></span>
                </div>


                <div class="form-group">
                  <label for="student_courses"><?php echo $this->lang->line('courses');?> *</label>
                  <div id="search_courses">
                    
                  </div>
                </div>

                <div class="form-group">
                  <label for="shift_id"><?php echo $this->lang->line('shift');?></label>
                    <?php 
                      $shift_info['']=$this->lang->line('shift'); 
                      echo form_dropdown('shift_id',$shift_info,$default_shift['id'],'class="form-control" id="shift_id"'); 
                    ?>
                  <span class="red"><?php echo form_error('shift_id'); ?></span>
                </div>

                <div class="form-group">
                  <label for="section_id"><?php echo $this->lang->line('Section');?></label>
                    <?php 
                      $section_info['']=$this->lang->line('section'); 
                      echo form_dropdown('section_id',$section_info,$default_section['id'],'class="form-control" id="section_id"'); 
                    ?>
                  <span class="red"><?php echo form_error('section_id'); ?></span>
                </div>

              </div>
            </div>
          </div> <!-- end of col -->       
                

        </div> <!-- end of row -->
        <div class="row">
        <div class="col-sm-12 col-xs-12 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3 grid_content">
            <div class="padded background_white margin_top basic_info">
              <h6 class="column-title"><i class="fa fa-money fa-2x blue"> <?php echo $this->lang->line('payment information');?></i></h6>
              <div class="account-wall">
                <div id="payment_info">
                  
                </div>
              </div>
            </div>
          </div>
        </div> 

      </div> <!-- end of box-body -->

      <div class="box-footer">
        <div class="form-group">
          <div class="col-sm-12 text-center">
            <input name="submit" type="submit" class="btn btn-warning btn-lg" value="Save"/>      
            <input type="button" class="btn btn-default btn-lg" value="Cancel" onclick='goBack("promotion/promotion_student",1)'/>
          </div>
        </div>        
      </div><!-- /.box-footer --> 

    </div> <!-- end of box-info -->
  </section>
</section>


<script type="text/javascript">

  function get_department(){
    var class_id = $("#s_class_id").val();
    var img="<img src='"+"<?php echo base_url('assets/pre-loader/Fading squares.gif');?>"+"' alt='<?php echo $this->lang->line("loading");?>...'/> <?php echo $this->lang->line("please wait");?>...";

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

    var img="<img src='"+"<?php echo base_url('assets/pre-loader/Fading squares.gif');?>"+"' alt='<?php echo $this->lang->line("loading");?>...'/> <?php echo $this->lang->line("please wait");?>...";

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
        alert("<?php echo $this->lang->line('Please select the pay fees first');?>");
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