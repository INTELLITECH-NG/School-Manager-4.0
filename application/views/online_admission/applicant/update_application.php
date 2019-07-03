<?php 
if($this->session->flashdata('application_error') != '')
{
  echo '<div class="alert alert-danger text-center">'.$this->session->flashdata("application_error").'</div>';
}   
?>
<form method="POST" enctype="multipart/form-data" class="application" action="<?php echo site_url('applicant/update_application_action'); ?>">
  <div class="row">
    <div class="col-sm-12 col-xs-12 col-md-6 col-lg-6 grid_content">
      <div class="padded background_white margin_top basic_info">
        <h6 class="column-title"><i class="fa fa-user fa-2x blue"> <?php echo $this->lang->line("basic information");?></i></h6>
        <div class="account-wall"> 

          <div class="form-group">
            <label for="student_name"><?php echo $this->lang->line("applicant name");?> *</label>
            <input type="text" id="student_name" name="student_name"  value="<?php echo $xdata['name']; ?>"  class="form-control"/>
            <span class="red"><?php echo form_error('student_name'); ?></span>
          </div> 

        <!--   <div class="form-group">
            <label for="student_name_ben"><?php echo $this->lang->line("applicant's last name");?> *</label>
            <input type="text" id="student_name_ben" name="student_name_ben"  value="<?php echo $xdata['name_bangla']; ?>"  class="form-control"/>
            <span class="red"><?php echo form_error('student_name_ben'); ?></span>
          </div>
 -->
          <div class="form-group">
            <label for="father_name"><?php echo $this->lang->line("father name");?> *</label>
            <input type="text" id="father_name" name="father_name"  value="<?php echo $xdata['father_name']; ?>"  class="form-control"/>
            <span class="red"><?php echo form_error('father_name'); ?></span>
          </div> 

          <!-- <div class="form-group">
            <label for="father_name_ben"><?php echo $this->lang->line("father's last name");?> </label>
            <input type="text" id="father_name_ben" name="father_name_ben"  value="<?php echo $xdata['father_name_bangla']; ?>"  class="form-control"/>
            <span class="red"><?php echo form_error('father_name_ben'); ?></span>
          </div>  -->

          <div class="form-group">
            <label for="mother_name"><?php echo $this->lang->line("mother name");?> *</label>
            <input type="text" id="mother_name" name="mother_name"  value="<?php echo $xdata['mother_name']; ?>"  class="form-control"/>
            <span class="red"><?php echo form_error('mother_name'); ?></span>
          </div>

        <!--   <div class="form-group">
            <label for="mother_name_ben"><?php echo $this->lang->line("mother's last name");?></label>
            <input type="text" id="mother_name_ben" name="mother_name_ben"  value="<?php echo $xdata['mother_name_bangla']; ?>"  class="form-control"/>
            <span class="red"><?php echo form_error('mother_name_ben'); ?></span>
          </div> -->

          <div class="form-group">
            <label for="father_name"><?php echo $this->lang->line("date of birth");?> *</label>
            <input type="text" class="form-control" id="date_of_birth" name="date_of_birth" value="<?php echo date("d-m-Y",strtotime($xdata['birth_date'])); ?>" placeholder="dd-mm-yyyy" />
            <span class="red"><?php echo form_error('date_of_birth'); ?></span>       
          </div>
<!-- 
          <div class="form-group">
            <label for="birth_certificate_no"><?php echo $this->lang->line("birth certificate no.");?> *</label>
            <input type="text" class="form-control" id="birth_certificate_no" name="birth_certificate_no" value="<?php echo $xdata['birth_certificate_no']; ?>" />
            <span class="red"><?php echo form_error('birth_certificate_no'); ?></span>       
          </div> -->

          <div class="form-group">
            <label><?php echo $this->lang->line('gender');?> *</label>
            <label class="radio-inline">
              <input type="radio" name="gender" value="Male" <?php if($xdata['gender'] === 'Male') echo 'checked'; ?> ><?php echo $this->lang->line('male');?>
            </label>
            <label class="radio-inline">
              <input type="radio" name="gender" value="Female" <?php if($xdata['gender'] === 'Female') echo 'checked'; ?> ><?php echo $this->lang->line('female');?>
            </label>
            <span class="red"><?php echo form_error('gender'); ?></span>     
          </div>         

          <div class="form-group">
            <label for="religion"><?php echo $this->lang->line('religion');?> *</label>

            <?php 
            $religion_info['']=$this->lang->line("select religion");
            echo form_dropdown('religion',$religion_info,$xdata['religion'],'class="form-control" id="religion"');  
            ?>               
            <span class="red"><?php echo form_error('religion'); ?></span>            
          </div>

          <div class="form-group">
            <label for="photo"><?php echo $this->lang->line('photo');?> *</label>
            <br/><img src="<?php echo base_url()."upload/applicant/".$xdata['image']; ?>" alt="Photo" height="130px" width="110px"/>
            <input type="file" id="photo" name="photo" />
            <span class="red">
              <?php 
              echo $this->session->userdata("application_upload_error");  
              $this->session->unset_userdata("application_upload_error"); 
              ?>
            </span>
            <?php echo $this->lang->line('max: 250kb, jpg/png');?>    
          </div>

          <div class="form-group">
            <label for="mobile"><?php echo $this->lang->line('mobile');?></label>
            <input type="text" id="mobile" name="mobile"  value="<?php echo $xdata['mobile']; ?>"  placeholder="Applicant's Mobile (01XXXXXXXXX)" class="form-control"/>
            <span class="red"><?php echo form_error('mobile'); ?></span>
          </div> 

          <div class="form-group">
            <label for="email"><?php echo $this->lang->line('email');?> </label>
            <input type="email" id="email" name="email"  value="<?php echo $xdata['email']; ?>"  placeholder="Applicant's Email" class="form-control"/>
            <span class="red"><?php echo form_error('email'); ?></span>
          </div>
        </div>

        <br/>
       <!--  <h6 class="column-title"><i class="fa fa-user-secret fa-2x blue"> <?php echo $this->lang->line('quota information');?></i></h6>
        <div class="account-wall"> 
          <div class="form-group">
            <label for="religion"><?php echo $this->lang->line('quota');?> </label>

            <?php 
            $quota_info['']= $this->lang->line("select quota");
            echo form_dropdown('quota',$quota_info,$xdata['quota_id'],'class="form-control" id="quota"');  
            ?>   

            <span class="red"><?php echo form_error('quota'); ?></span>            
          </div>

          <div class="form-group">
            <label for="quota_description"><?php echo $this->lang->line('quota description');?> </label>
            <textarea id="quota_description" name="quota_description" class="form-control"><?php echo $xdata['quota_description']; ?></textarea>
            <span class="red"><?php echo form_error('quota_description'); ?></span>
          </div>
        </div> -->
      </div>
    </div> <!-- end col -->
    <div class="col-sm-12 col-xs-12 col-md-6 col-lg-6 grid_content">
      <div class="padded background_white margin_top">
        <h6 class="column-title"><i class="fa fa-user-plus fa-2x blue"> <?php echo $this->lang->line("gurdian information");?></i></h6>
        <div class="account-wall"> 
          <div class="form-group">
            <label for="gurdian_name"><?php echo $this->lang->line("gurdian's name");?> *</label>
            <input type="text" id="gurdian_name" name="gurdian_name"  value="<?php echo $xdata['gurdian_name']; ?>"  class="form-control"/>
            <span class="red"><?php echo form_error('gurdian_name'); ?></span>
          </div>

          <div class="form-group">
            <label for="gurdian_relation"><?php echo $this->lang->line("relation with gurdian");?> *</label>
            <input type="text" id="gurdian_relation" name="gurdian_relation"  value="<?php echo $xdata['gurdian_relation']; ?>"  class="form-control"/>
            <span class="red"><?php echo form_error('gurdian_relation'); ?></span>
          </div>  

          <div class="form-group">
            <label for="gurdian_occupation"><?php echo $this->lang->line("occupation");?> * </label>
            <input type="text" id="gurdian_occupation" name="gurdian_occupation"  value="<?php echo $xdata['gurdian_occupation']; ?>"  class="form-control"/>
            <span class="red"><?php echo form_error('gurdian_occupation'); ?></span>
          </div> 

          <div class="form-group">
            <label for="gurdian_income"><?php echo $this->lang->line("yearly income (taka)");?> * </label>
            <input type="text" id="gurdian_income" name="gurdian_income"  value="<?php echo $xdata['gurdian_income']; ?>" class="form-control"/>
            <span class="red"><?php echo form_error('gurdian_income'); ?></span>
          </div> 

          <div class="form-group">
            <label for="gurdian_mobile"><?php echo $this->lang->line('mobile');?> *</label>
            <input type="text" id="gurdian_mobile" name="gurdian_mobile"  value="<?php echo $xdata['gurdian_mobile']; ?>"  placeholder="Gurdian's Mobile (01XXXXXXXXX)" class="form-control"/>
            <span class="red"><?php echo form_error('gurdian_mobile'); ?></span>
          </div> 

          <div class="form-group">
            <label for="gurdian_email"><?php echo $this->lang->line('email');?> </label>
            <input type="email" id="gurdian_email" name="gurdian_email"  value="<?php echo $xdata['gurdian_email']; ?>"  placeholder="Gurdian's Email" class="form-control"/>
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
            <input type="text" id="previous_institute" name="previous_institute"  value="<?php echo $xdata['previous_institute']; ?>"  placeholder="If Available" class="form-control"/>
            <span class="red"><?php echo form_error('previous_institute'); ?></span>
          </div>

          <!-- <div class="form-group" style="display: none">
            <label for="exam_version"><?php echo $this->lang->line('exam version');?> *</label>
            <?php 
            $exam_version_info['']= $this->lang->line('select exam version');
            echo form_dropdown('exam_version',$exam_version_info,$xdata['exam_version'],'class="form-control" id="exam_version"'); 
            ?>            
            <span class="red"><?php echo form_error('exam_version'); ?></span>
          </div> -->

          <div class="form-group">
            <label for="shift_id"><?php echo $this->lang->line('shift');?> *</label>
            <?php 
            echo form_dropdown('shift_id',$shift_info,$xdata['shift_id'],'class="form-control" id="shift_id"'); 
            ?>            
            <span class="red"><?php echo form_error('shift_id'); ?></span>
          </div>
          <br/>
          <div class="form-group">
            <label for="s_class_id"><?php echo $this->lang->line('class');?> *</label>
            <?php echo $xdata['class_name']; ?>
          </div>

          <div class="form-group">
            <label for="department_id"><?php echo $this->lang->line('group / dept.');?> *</label>
            <?php echo $xdata['dept_name']; ?>
          </div>
          <br/><br/>            
          <div class="form-group">
            <label for="student_courses"><?php echo $this->lang->line('courses');?> *</label>

            <?php 
              $xcourse_ids=array();
              $xcourse_types=array();
              $j=0;
              foreach($xcourses as $course)
              {
                $xcourse_ids[$j]=$course['course_id'];
                $xcourse_types[$xcourse_ids[$j]]=$course['type'];
                $j++;
              }
              echo "<pre>";              
              echo "<div class='table-responsive'>";
              echo "<table width='100%'>";
              foreach($courses as $course)
              {
                echo "<tr>";
                echo "<td style='padding-top:10px !important;'>";
                  echo "<input type='hidden' name='course_id[]' value='".$course['id']."'/>";
                  echo $course['course_name'].' '.$course['course_code'];
                echo "</td>";
                echo "<td style='padding-top:10px !important;'>";                         
                  echo '<select name="type[]"  required class="form-control" style="display:inline !important;">'; 
                    
                    $selected1="";
                    $selected2="";
                    $selected0="";
                    if(in_array($course['id'], $xcourse_ids) && $xcourse_types[$course['id']]=="1") $selected1="selected='selected'";              
                    else if(in_array($course['id'], $xcourse_ids) && $xcourse_types[$course['id']]=="0") $selected0="selected='selected'";
                    else $selected2="selected='selected'";

                    echo '<option '.$selected1.' value="1">',$this->lang->line('mandatory'),'</option>';
                    echo '<option '.$selected2.' value="2">',$this->lang->line('not interested'),'</option>';
                    echo '<option '.$selected0.' value="0">',$this->lang->line('optional'),'</option>'; 
                  echo '</select>';
                echo "</td>";
                echo "</tr>";
              } 
              echo "</table>";
              echo "</div>"; 
              echo "</pre>"; 
               ?>
          </div>       

        </div>
      </div>
    </div> <!-- end col -->
    
  </div> <!-- end row -->



  <div class="row">
    <div class="col-sm-12 col-xs-12 col-md-6 col-lg-6 grid_content">
      <div class="padded background_white margin_top">
        <h6 class="column-title"><i class="fa fa-home fa-2x blue"> <?php echo $this->lang->line('present address');?></i></h6>
        <div class="account-wall"> 
          <div class="form-group">
            <label for="present_district"><?php echo $this->lang->line('street');?> * </label>            

            <input type="text" id="present_district" name="present_district"  value="<?php echo $xdata['gurdian_present_district']; ?>"  class="form-control"/>
            <span class="red"><?php echo form_error('present_district'); ?></span>
          </div>
          <div class="form-group">
            <label for="present_thana"><?php echo $this->lang->line('city');?> * </label>
            <div id="present_thana_container">              
              <input type="text" id="present_thana" name="present_thana"  value="<?php echo $xdata['gurdian_present_thana']; ?>"  class="form-control"/>
            </div>
            <span class="red"><?php echo form_error('present_thana'); ?></span>
          </div>
          <div class="form-group">
            <label for="present_post"><?php echo $this->lang->line('state');?> * </label>
            <input type="text" id="present_post" name="present_post"  value="<?php echo $xdata['gurdian_present_post']; ?>"  class="form-control"/>
            <span class="red"><?php echo form_error('present_post'); ?></span>
          </div>
          <div class="form-group">
            <label for="present_village"><?php echo $this->lang->line('post code');?> * </label>
            <input type="text" id="present_village" name="present_village"  value="<?php echo $xdata['gurdian_present_village']; ?>"  class="form-control"/>
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
            <label for="permanent_district"><?php echo $this->lang->line('street');?> * </label>           
             <input type="text" id="permanent_district" name="permanent_district"  value="<?php echo $xdata['gurdian_permanent_district']; ?>"  class="form-control"/>
            <span class="red"><?php echo form_error('permanent_district'); ?></span>
          </div>
          <div class="form-group">
            <label for="permanent_thana"><?php echo $this->lang->line('city');?> * </label>
            <div id="permanent_thana_container">              
              <input type="text" id="permanent_thana" name="permanent_thana"  value="<?php echo $xdata['gurdian_permanent_thana']; ?>"  class="form-control"/>
            </div>
            <span class="red"><?php echo form_error('permanent_thana'); ?></span>
          </div>
          <div class="form-group">
            <label for="permanent_post"><?php echo $this->lang->line('state');?> * </label>
            <input type="text" id="permanent_post" name="permanent_post"  value="<?php echo $xdata['gurdian_permanent_post']; ?>"  class="form-control"/>
            <span class="red"><?php echo form_error('permanent_post'); ?></span>
          </div>
          <div class="form-group">
            <label for="permanent_village"><?php echo $this->lang->line('post code');?> * </label>
            <input type="text" id="permanent_village" name="permanent_village"  value="<?php echo $xdata['gurdian_permanent_village']; ?>"  class="form-control"/>
            <span class="red"><?php echo form_error('permanent_village'); ?></span>
          </div>          
        </div>
      </div>
    </div> <!-- end col -->
  </div> <!-- end row -->

  <div class="row">
    <div class="col-xs-12 grid_content">
       <div class="padded background_white margin_top text-center">         
        <input type="submit"  name="next"  value=<?php echo $this->lang->line("update application");?>  class="btn btn-warning btn-lg"/>           
      </div>
    </div>
  </div>


</form>




<script type="text/javascript">
 
 $j("document").ready(function(){

      var todate="<?php echo date('Y');?>";
      var from=todate-100;
      var to=todate;
      var str=from+":"+to;
      $('#date_of_birth').datepicker({format: "dd-mm-yyyy",changeMonth:true, changeYear:true,yearRange: str, startView: "decade" });


      $("#present_district").on('change',function(){        
      var base_url="<?php echo base_url();?>";
      var img_src=base_url+"assets/pre-loader/Fading squares.gif";
      var img= "<img src='"+img_src+ "' alt=<?php $this->lang->line('loading');?>,'> <?php echo $this->lang->line('please wait');?>...";           
      $("#present_thana_container").html(img);     
      var district_id=$("#present_district").val();

      if(district_id=='') district_id='Null';

      $.ajax
      ({
        type:'POST',
        async:false,
        url:"<?php echo site_url();?>"+'home/thana_select_as_district/'+district_id+'/present_thana',
        success:function(response)
        {               
          $("#present_thana_container").html(response);
        }                
      });                         
    });

    $("#permanent_district").on('change',function(){        
      var base_url="<?php echo base_url();?>";
      var img_src=base_url+"assets/pre-loader/Fading squares.gif";
      var img= "<img src='"+img_src+ "' alt=<?php $this->lang->line('loading');?>,'> <?php echo $this->lang->line('please wait');?>...";         
      $("#permanent_thana_container").html(img);     
      var district_id=$("#permanent_district").val();

      if(district_id=='') district_id='Null';

      $.ajax
      ({
        type:'POST',
        async:false,
        url:"<?php echo site_url();?>"+'home/thana_select_as_district/'+district_id+'/permanent_thana',
        success:function(response)
        {               
          $("#permanent_thana_container").html(response);
        }                
      });                         
    });

  });
  
</script>


<style type="text/css">
  .content-wrapper{background:#f5f5f5 !important;}
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