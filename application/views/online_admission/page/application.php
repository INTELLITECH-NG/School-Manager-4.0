<?php 
if($this->session->flashdata('application_error') != '')
{
  echo '<div class="alert alert-danger text-center">'.$this->session->flashdata("application_error").'</div>';
}   
 ?>
<form method="POST" enctype="multipart/form-data" class="application" action="<?php echo site_url('online/application_action'); ?>">
  <div class="row">
    <div class="col-sm-12 col-xs-12 col-md-6 col-lg-6 grid_content">
      <div class="padded background_white margin_top">
        <h6 class="column-title"><i class="fa fa-user fa-2x blue"> <?php echo $this->lang->line("basic information");?></i></h6>
        <div class="account-wall"> 

          <div class="form-group">
            <label for="student_name"><?php echo $this->lang->line("applicant name");?> *</label>
            <input type="text" id="student_name" name="student_name"  value="<?php echo set_value('student_name'); ?>"  class="form-control"/>
            <span class="red"><?php echo form_error('student_name'); ?></span>
          </div> 

          <!-- <div class="form-group">
            <label for="student_name_ben"><?php echo $this->lang->line("applicant's last name");?> *</label>
            <input type="text" id="student_name_ben" name="student_name_ben"  value="<?php echo set_value('student_name_ben'); ?>"  class="form-control"/>
            <span class="red"><?php echo form_error('student_name_ben'); ?></span>
          </div>
 -->
          <div class="form-group">
            <label for="father_name"><?php echo $this->lang->line("father name");?> *</label>
            <input type="text" id="father_name" name="father_name"  value="<?php echo set_value('father_name'); ?>"  class="form-control"/>
            <span class="red"><?php echo form_error('father_name'); ?></span>
          </div> 

         <!--  <div class="form-group">
            <label for="father_name_ben"><?php echo $this->lang->line("father last name");?> </label>
            <input type="text" id="father_name_ben" name="father_name_ben"  value="<?php echo set_value('father_name_ben'); ?>"  class="form-control"/>
            <span class="red"><?php echo form_error('father_name_ben'); ?></span>
          </div>  -->

          <div class="form-group">
            <label for="mother_name"><?php echo $this->lang->line("mother name");?> *</label>
            <input type="text" id="mother_name" name="mother_name"  value="<?php echo set_value('mother_name'); ?>"  class="form-control"/>
            <span class="red"><?php echo form_error('mother_name'); ?></span>
          </div>

          <!-- <div class="form-group">
            <label for="mother_name_ben"><?php echo $this->lang->line("mother last name");?> </label>
            <input type="text" id="mother_name_ben" name="mother_name_ben"  value="<?php echo set_value('mother_name_ben'); ?>"  class="form-control"/>
            <span class="red"><?php echo form_error('mother_name_ben'); ?></span>
          </div> -->

          <div class="form-group">
            <label for="father_name"><?php echo $this->lang->line("date of birth");?> *</label>
            <input type="text" class="form-control datepicker" id="date_of_birth" name="date_of_birth" value="<?php echo set_value('date_of_birth'); ?>" placeholder="<?php echo $this->lang->line('dd-mm-yyyy');?>" />
            <span class="red"><?php echo form_error('date_of_birth'); ?></span>       
          </div>

          <!-- <div class="form-group">
            <label for="birth_certificate_no"><?php echo $this->lang->line("birth certificate no.");?> *</label>
            <input type="text" class="form-control" id="birth_certificate_no" name="birth_certificate_no" value="<?php echo set_value('birth_certificate_no'); ?>" />
            <span class="red"><?php echo form_error('birth_certificate_no'); ?></span>       
          </div> -->

          <div class="form-group">
            <label>Gender *</label>
            <label class="radio-inline">
              <input type="radio" name="gender" value="Male" <?php if($this->input->post('gender') === 'Male') echo 'checked'; ?>><?php echo $this->lang->line("male");?>
            </label>
            <label class="radio-inline">
              <input type="radio" name="gender" value="Female" <?php if($this->input->post('gender') === 'Female') echo 'checked'; ?>><?php echo $this->lang->line("female");?>
            </label>
            <span class="red"><?php echo form_error('gender'); ?></span>     
          </div>         

          <div class="form-group">
            <label for="religion"><?php echo $this->lang->line("religion");?> *</label>
            <?php 
            $religion_info['']=$this->lang->line("select religion");
            echo form_dropdown('religion',$religion_info,set_value('religion'),'class="form-control" id="religion"');  
            ?>               
            <span class="red"><?php echo form_error('religion'); ?></span>            
          </div>

          <div class="form-group">
            <label for="photo"><?php echo $this->lang->line("photo");?> *</label>
            <input type="file" id="photo" name="photo"  value="<?php echo set_value('photo'); ?>" />
            <span class="red">
              <?php 
              echo $this->session->userdata("application_upload_error");  
              $this->session->unset_userdata("application_upload_error"); 
              ?>
            </span>
            <?php echo $this->lang->line('max: 250kb, jpg/png');?>  
          </div>

          <div class="form-group">
            <label for="mobile"><?php echo $this->lang->line('mobile');?> </label>
            <input type="text" id="mobile" name="mobile"  value="<?php echo set_value('mobile'); ?>"  placeholder='' class="form-control"/>
            <span class="red"><?php echo form_error('mobile'); ?></span>
          </div> 

          <div class="form-group">
            <label for="email"><?php echo $this->lang->line('email');?> </label>
            <input type="email" id="email" name="email"  value="<?php echo set_value('email'); ?>"  placeholder='' class="form-control"/>
            <span class="red"><?php echo form_error('email'); ?></span>
          </div>
        </div>
      </div>
      <div class="col-xs-12 grid_content" style="padding:0">
      <div class="padded background_white margin_top">
        <h6 class="column-title"><i class="fa fa-key fa-2x blue"> <?php echo $this->lang->line('login information');?></i></h6>
        <div class="account-wall"> 
          <div class="form-group">
            <label for="username"><?php echo $this->lang->line('username');?> * </label>
            <input type="text" id="username" name="username"  value="<?php echo set_value('username'); ?>"  placeholder="" class="form-control"/>
            <span class="red"><?php echo form_error('username'); ?></span>
          </div>
          <div class="form-group">
            <label for="password"><?php echo $this->lang->line('password');?> * </label>
            <input type="password" id="password" name="password"  value="<?php echo set_value('password'); ?>"  placeholder="" class="form-control"/>
            <span class="red"><?php echo form_error('password'); ?></span>
          </div>
          <div class="form-group">
            <label for="confirm_password"><?php echo $this->lang->line('confirm password');?> * </label>
            <input type="password" id="confirm_password" name="confirm_password"  value="<?php echo set_value('confirm_password'); ?>"  placeholder="" class="form-control"/>
            <span class="red"><?php echo form_error('confirm_password'); ?></span>
          </div>
        </div>
      </div>
    </div> 
    </div> <!-- end col -->
    <div class="col-sm-12 col-xs-12 col-md-6 col-lg-6 grid_content">
      <div class="padded background_white margin_top">
        <h6 class="column-title"><i class="fa fa-user-plus fa-2x blue"> <?php echo $this->lang->line('gurdian information');?></i></h6>
        <div class="account-wall"> 
          <div class="form-group">
            <label for="gurdian_name"><?php echo $this->lang->line("gurdian name");?> *</label>
            <input type="text" id="gurdian_name" name="gurdian_name"  value="<?php echo set_value('gurdian_name'); ?>"  class="form-control"/>
            <span class="red"><?php echo form_error('gurdian_name'); ?></span>
          </div>

          <div class="form-group">
            <label for="gurdian_relation"><?php echo $this->lang->line('relation with gurdian');?> *</label>
            <input type="text" id="gurdian_relation" name="gurdian_relation"  value="<?php echo set_value('gurdian_relation'); ?>"  class="form-control"/>
            <span class="red"><?php echo form_error('gurdian_relation'); ?></span>
          </div>  

          <div class="form-group">
            <label for="gurdian_occupation"><?php echo $this->lang->line('occupation');?> * </label>
            <input type="text" id="gurdian_occupation" name="gurdian_occupation"  value="<?php echo set_value('gurdian_occupation'); ?>"  class="form-control"/>
            <span class="red"><?php echo form_error('gurdian_occupation'); ?></span>
          </div> 

          <div class="form-group">
            <label for="gurdian_income"><?php echo $this->lang->line('yearly income (usd)');?> * </label>
            <input type="text" id="gurdian_income" name="gurdian_income"  value="<?php echo set_value('gurdian_income'); ?>" class="form-control"/>
            <span class="red"><?php echo form_error('gurdian_income'); ?></span>
          </div> 

          <div class="form-group">
            <label for="gurdian_mobile"><?php echo $this->lang->line('mobile');?> *</label>
            <input type="text" id="gurdian_mobile" name="gurdian_mobile"  value="<?php echo set_value('gurdian_mobile'); ?>"  placeholder='' class="form-control"/>
            <span class="red"><?php echo form_error('gurdian_mobile'); ?></span>
          </div> 

          <div class="form-group">
            <label for="gurdian_email"><?php echo $this->lang->line('email');?> </label>
            <input type="email" id="gurdian_email" name="gurdian_email"  value="<?php echo set_value('gurdian_email'); ?>"  placeholder='' class="form-control"/>
            <span class="red"><?php echo form_error('gurdian_email'); ?></span>
          </div>

        </div>
      </div>
    </div> <!-- end col -->

    <div class="col-sm-12 col-xs-12 col-md-6 col-lg-6 grid_content">
      <div class="padded background_white margin_top">
        <h6 class="column-title"><i class="fa fa-mortar-board fa-2x blue"> <?php echo $this->lang->line('admission information');?></i></h6>
        <div class="account-wall">       

          <div class="form-group">
            <label for="previous_institute"><?php echo $this->lang->line('previous institute');?> </label>
            <input type="text" id="previous_institute" name="previous_institute"  value="<?php echo set_value('previous_institute'); ?>"  placeholder="" class="form-control"/>
            <span class="red"><?php echo form_error('previous_institute'); ?></span>
          </div>

          <!-- <div class="form-group">
            <label for="exam_version"><?php echo $this->lang->line('exam version')?> *</label>
            <?php 
            $exam_version_info['']=$this->lang->line('select exam version');
            echo form_dropdown('exam_version',$exam_version_info,"",'class="form-control" id="exam_version"'); 
            ?>            
            <span class="red"><?php echo form_error('exam_version'); ?></span>
          </div>  -->

          <div class="form-group">
            <label for="shift_id"><?php echo $this->lang->line('shift')?> *</label>
            <?php 
            echo form_dropdown('shift_id',$shift_info,$default_shift['id'],'class="form-control" id="shift_id"'); 
            ?>            
            <span class="red"><?php echo form_error('shift_id'); ?></span>
          </div>

          <div class="form-group">
            <label for="exam_version"><?php echo $this->lang->line('session')?> *</label>
            <?php 
            $session_info['']=$this->lang->line('select session');
            echo form_dropdown('session_id',$session_info,"",'class="form-control" id="session_id"'); 
            ?>            
            <span class="red"><?php echo form_error('session_id'); ?></span>
          </div>


          <div class="form-group">
            <label for="s_class_id"><?php echo $this->lang->line('class');?> *</label>

            <?php 
            $class_info['']= $this->lang->line('select class');                     
            echo form_dropdown('class_id',$class_info,"",'class="form-control" id="s_class_id"  onchange="get_course()"'); 
            ?>           
            <span class="red"><?php echo form_error('class_id'); ?></span>
          </div>

          <div class="form-group">
            <label for="department_id"><?php echo $this->lang->line('group / dept.');?> *</label>
            <div id="search_dept">
              <?php 
                      $dept_info['']= $this->lang->line('select group / dept');                     
                      echo form_dropdown('dept_id',$dept_info,"",'class="form-control" id="department_id"'); 
                    ?>
            </div>
            <span class="red"><?php echo form_error('dept_id'); ?></span>
          </div>

          <div class="form-group">
            <label for="student_courses"><?php echo $this->lang->line('courses')?> *</label>
            <div  id="search_courses">   
            <?php echo $this->lang->line('select class');?> &amp; <?php echo $this->lang->line('group/dept');?>           
            </div>
          </div>       

        </div>
      </div>
    </div> <!-- end col -->
    
  </div> <!-- end row -->


  <!-- <div class="row"> -->
    
    <!-- end col -->

    <!-- <div class="col-sm-12 col-xs-12 col-md-6 col-lg-6 grid_content">
        <div class="padded background_white margin_top quota_info">
        <h6 class="column-title"><i class="fa fa-user-secret fa-2x blue"> <?php echo $this->lang->line('quota information');?></i></h6>
        <div class="account-wall"> 
          <div class="form-group">
            <label for="religion"><?php echo $this->lang->line('quota');?> </label>

            <?php 
            $quota_info['']= $this->lang->line("select quota");
            echo form_dropdown('quota',$quota_info,set_value('quota'),'class="form-control" id="quota"');  
            ?>   
                        
            <span class="red"><?php echo form_error('quota'); ?></span>            
          </div>

          <div class="form-group">
            <label for="quota_description"><?php echo $this->lang->line('quota description');?> </label>
            <textarea id="quota_description" name="quota_description" class="form-control"><?php echo set_value('quota_description'); ?></textarea>
            <span class="red"><?php echo form_error('quota_description'); ?></span>
          </div>
        </div>
      </div>
    </div>  -->

  <!-- </div>  -->
  <!-- end row -->


  <div class="row">
    <div class="col-sm-12 col-xs-12 col-md-6 col-lg-6 grid_content">
      <div class="padded background_white margin_top">
        <h6 class="column-title"><i class="fa fa-home fa-2x blue"> <?php echo $this->lang->line('present address');?></i></h6>
        <div class="account-wall"> 
          <div class="form-group">
            <label for="present_district"><?php echo $this->lang->line('street address');?> * </label>
            <input type="text" id="present_district" name="present_district"  value="<?php echo set_value('present_district'); ?>"  class="form-control"/>
            <span class="red"><?php echo form_error('present_district'); ?></span>
          </div>
          <div class="form-group">
            <label for="present_thana"><?php echo $this->lang->line('city');?> * </label>
            <div id="present_thana_container">
              <input type="text" id="present_thana" name="present_thana"  value="<?php echo set_value('present_thana'); ?>"  class="form-control"/>
            </div>
            <span class="red"><?php echo form_error('present_thana'); ?></span>
          </div>
          <div class="form-group">
            <label for="present_post"><?php echo $this->lang->line('state');?> * </label>
            <input type="text" id="present_post" name="present_post"  value="<?php echo set_value('present_post'); ?>"  class="form-control"/>
            <span class="red"><?php echo form_error('present_post'); ?></span>
          </div>
          <div class="form-group">
            <label for="present_village"><?php echo $this->lang->line('post code');?> * </label>
            <input type="text" id="present_village" name="present_village"  value="<?php echo set_value('present_village'); ?>"  class="form-control"/>
            <span class="red"><?php echo form_error('present_village'); ?></span>
          </div>
        </div>
      </div>
    </div> <!-- end col -->


    <div class="col-sm-12 col-xs-12 col-md-6 col-lg-6 grid_content">
      <div class="padded background_white margin_top">
        <h6 class="column-title"><i class="fa fa-home fa-2x blue"> <?php echo $this->lang->line('permanent address');?></i></h6>
        <div class="account-wall">
          <div class="form-group">
              <input type="checkbox" id="same_as_present_address">
              <label>&nbsp; <?php echo $this->lang->line('same as present address');?></label>
          </div> 
          <div class="form-group">
            <label for="permanent_district"><?php echo $this->lang->line('street address');?> * </label>
            <input type="text" id="permanent_district" name="permanent_district"  value="<?php echo set_value('permanent_district'); ?>"  class="form-control"/>
            <span class="red"><?php echo form_error('permanent_district'); ?></span>
          </div>
          <div class="form-group">
            <label for="present_thana"><?php echo $this->lang->line('city');?> * </label>
            <div id="permanent_thana_container">
              <input type="text" id="permanent_thana" name="permanent_thana"  value="<?php echo set_value('permanent_thana'); ?>"  class="form-control"/>
            </div>
            <span class="red"><?php echo form_error('permanent_thana'); ?></span>
          </div>
          <div class="form-group">
            <label for="permanent_post"><?php echo $this->lang->line('state');?> * </label>
            <input type="text" id="permanent_post" name="permanent_post"  value="<?php echo set_value('permanent_post'); ?>"  class="form-control"/>
            <span class="red"><?php echo form_error('permanent_post'); ?></span>
          </div>
          <div class="form-group">
            <label for="permanent_village"><?php echo $this->lang->line('post code');?> * </label>
            <input type="text" id="permanent_village" name="permanent_village"  value="<?php echo set_value('permanent_village'); ?>"  class="form-control"/>
            <span class="red"><?php echo form_error('permanent_village'); ?></span>
          </div>          
        </div>
      </div>
    </div> <!-- end col -->
  </div> <!-- end row -->

  <div class="row">
    <div class="col-xs-12 grid_content">
       <div class="padded background_white margin_top text-center">         
        <input type="submit"  name="next"  value=<?php echo $this->lang->line("save");?>  class="btn btn-primary btn-lg"/>           
      </div>
    </div>
  </div>


</form>




<script type="text/javascript">

  var todate="<?php echo date('Y');?>";
  var from=todate-100;
  var to=todate;
  var str=from+":"+to;
  $('#date_of_birth').datepicker({format: "dd-mm-yyyy",changeMonth:true, changeYear:true,yearRange: str, startView: "decade" });
      
  function get_course()
  {
    var class_id = $("#s_class_id").val();
    var dept_id = $("#department_id").val();
    var session_id = $("#session_id").val();

    var img="<img src='"+"<?php echo base_url('assets/pre-loader/Fading squares.gif');?>"+"' alt=<?php $this->lang->line('loading');?>,'> <?php echo $this->lang->line('please wait');?>...";   
   
    if(dept_id == '' && class_id != '' && session_id!='')
    {
      $("#search_dept").html(img);
      var url = "<?php echo site_url('online/ajax_get_dept_based_on_class');?>";
      $.ajax({
        url: url, 
        type: 'POST',  
        data: {class_id:class_id,session_id:session_id}, 
        async: false, cache: false, 
        success: function (response){
          $('#search_dept').html(response);
        }
      });
    }

    if(class_id != '' && dept_id != '' && session_id != '')
    {
      $("#search_courses").html(img);
      var url = "<?php echo site_url('online/ajax_get_student_course');?>";
      $.ajax({
        url: url, 
        type: 'POST',  
        data: {class_id:class_id,dept_id:dept_id,session_id:session_id}, 
        async: false, cache: false, 
        success: function (response){
          $('#search_courses').html(response);
        }
      });
    }
  }

  $(document.body).on('change','#present_thana',function(){
        if($("#same_as_present_address").is(":checked")){
           var present_thana_id = $("#present_thana").val();
           $("#permanent_thana").val(present_thana_id);

         }
      });

  $(document.body).on('change','#present_district',function(){
        if($("#same_as_present_address").is(":checked")){
           var present_district_id = $("#present_district").val();
           $("#permanent_district").val(present_district_id);

         }
      });

  $(document.body).on('change','#present_post',function(){
        if($("#same_as_present_address").is(":checked")){
           var present_post_id = $("#present_post").val();
           $("#permanent_post").val(present_post_id);

         }
      });
      
       $(document.body).on('change','#present_village',function(){
        if($("#same_as_present_address").is(":checked")){
           var present_village_id = $("#present_village").val();
           $("#permanent_village").val(present_village_id);

         }
      });


      $(document.body).on('click','#same_as_present_address',function(){
        if($("#same_as_present_address").is(":checked")){
            var present_district_id = $("#present_district").val();
            var present_thana_id = $("#present_thana").val();
            var present_post_id = $("#present_post").val();
            var present_village_id = $("#present_village").val();

            $("#permanent_district").val(present_district_id);
            $("#permanent_thana").val(present_thana_id);
            $("#permanent_post").val(present_post_id);
            $("#permanent_village").val(present_village_id);
         }
      }); 

  
  
</script>


