<section class="content-header">
  <section class="content">
  <?php 
      if($this->session->userdata('success')){
        echo "<h3><div class='alert alert-info text-center'><i class='fa fa-info'></i> ".$this->session->userdata('success')."</div></h3>";
        $this->session->unset_userdata('success');
      }
      if($classes == 0) 
          echo "<h3><div class='alert alert-info text-center'><i class='fa fa-info'></i> ",$this->lang->line('today you have no class.'),"</div></h3>";
          else{
    ?>
    <div class="box box-info custom_box">
      <div class="box-header">
        <h3 class="box-title"><i class="fa fa-plus-circle"></i> <?php echo $this->lang->line('search students');?></h3>
      </div><!-- /.box-header -->
      <form class="form-horizontal" action="<?php echo base_url('teacher_marks_entry/get_students'); ?>" method="POST">
        <div class="box-body">
          <div class="col-xs-12">
            <div class="row">
              <p class="alert alert-warning text-center" id="error" style="display:none;"></p>
            </div>
            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                <select name="class_id" id="m_class_id" class="form-control">
                  <option value=""><?php echo $this->lang->line('class');?></option>
                  <?php 
                  foreach($classes as $class)
                    echo '<option value="'.$class['id'].'">'.$class['class_name'].'</option>';
                  ?>
                </select>
              </div>

              <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                <select name="shift_id" id="shift_id" class="form-control">
                  <option value=""><?php echo $this->lang->line('shift');?></option>
                  <?php 
                  foreach($shifts as $shift)
                    echo '<option value="'.$shift['id'].'">'.$shift['shift_name'].'</option>';
                  ?>
                </select>
              </div>

              <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                <select name="section_id" id="section_id" class="form-control">
                  <option value=""><?php echo $this->lang->line('section');?></option>
                  <?php 
                  foreach($sections as $section)
                    echo '<option value="'.$section['id'].'">'.$section['section_name'].'</option>';
                  ?>
                </select>
              </div>

              <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                <select name="dept_id" id="dept_id" class="form-control">
                  <option value=""><?php echo $this->lang->line('group/dept.');?> </option>
                  
                </select>
              </div>
              <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                <select name="course_id" id="course_id" class="form-control">
                  <option value=""><?php echo $this->lang->line('course');?></option>
                  
                </select>
              </div>
              <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                  <?php 
                  $sessions['']=$this->lang->line('session');                      
                      echo form_dropdown('session_id',$sessions,"",'class="form-control" id="session_id" onchange="get_exam_name()"'); 
                  ?>
              </div>
              <!-- <div class=""><br/><br/>
                <input type="submit" id="student_list" value="Search Students" class="btn btn-primary pull-right" style="margin-right:16px;">
              </div> -->
            </div>
            <div class="row clearfix"><br/>
              <!-- <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                <input type="text" name="marks_entry_date" class="form-control" id="marks_entry_date" placeholder="day-month-year (Ex: 30-01-1989)">
              </div> -->
              <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2" id="exam_info">
                <select name="exam_name" id="exam_name" class="form-control">
                  <option value=""><?php echo $this->lang->line('exam name');?></option>
                  
                </select>
              </div>
              <div class="pull-right">
                <input type="submit" id="student_list" value="<?php echo $this->lang->line('search students');?>" class="btn btn-primary" style="margin-right:16px;">
              </div>
            </div>
            <div style="display:none;" id="no_exam">
              <br/><br/>
              <div class="alert alert-warning text-center" id="no_exam_text">
                
              </div>
            </div>
      </form>  
            <?php if(isset($class_id)) {?>
            <form action="<?php echo base_url('teacher_marks_entry/marks_entry_input'); ?>" method="POST">
              <input type="hidden" name="class_id" value="<?php echo $class_id; ?>">
              <input type="hidden" name="course_id" value="<?php echo $course_id; ?>">
              <input type="hidden" name="section_id" value="<?php echo $section_id; ?>">
              <input type="hidden" name="shift_id" value="<?php echo $shift_id; ?>">
              <input type="hidden" name="department_id" value="<?php echo $department_id; ?>">
              <input type="hidden" name="session_id" value="<?php echo $session_id; ?>">
              <input type="hidden" name="exam_name" value="<?php echo $exam_name; ?>">
              <!-- <input type="hidden" name="marks_entry_date_input" value="<?php echo $marks_entry_date; ?>"> -->
              <div class="row">
                <br/><br/>
                <div class="box-header">
                  <h3 class="box-title"><?php echo $this->lang->line('students marks input sheet');?></h3>
                </div><!-- /.box-header -->
              </div>
              <div class="row"> 
                <div class="table-responsive">
                  <table class="table table-bordered table-zebra table-hover table-stripped background_white">
                    <tr>
                      <th><?php echo $this->lang->line('student id');?></th>
                      <th><?php echo $this->lang->line('student name');?></th>
                      <th>
                        <?php 
                          echo $course_name; 
                          $where['where'] = array('id'=>$course_id);
                          $course_mark = get_data_helper('course',$where,$select=array('marks'),$join='',$limit='',$start='',$order_by='',$group_by='',$num_rows=1,$single_value=1);
                        ?>
                      </th>
                    </tr>
                    <?php  
                      if(isset($has_marks)){
                        echo '<input type="hidden" name="delete_insert" value="delete">';
                       
                    for($k=0;$k<count($students_info);$k++){   
                    ?>
                      <tr> <input type="hidden" name="student_info_id[]" value="<?php echo $students_info[$k]['id']; ?>"/>
                        <td><?php echo $students_info[$k]['student_id']; ?><input type="hidden" name="student_id[]" value="<?php echo $students_info[$k]['student_id']; ?>"/> </td>
                        <td><?php echo $students_info[$k]['name']; ?><input type="hidden" name="student_name[]" value="<?php echo $students_info[$k]['name']; ?>"/> </td>
                        <td><input type="number" step=".1" max="<?php echo $course_mark['marks']; ?>" style="padding-left:10px;" name="marks[]" value="<?php if(isset($has_marks[$students_info[$k]['student_id']])) echo $has_marks[$students_info[$k]['student_id']]; ?>" /> </td>
                      </tr>
                    <?php 
                      } 
                      
                      }
                      else{
                        echo '<input type="hidden" name="delete_insert" value="insert">';
                        foreach($students_info as $student_info) :
                      ?>
                        <tr> <input type="hidden" name="student_info_id[]" value="<?php echo $student_info['id']; ?>"/>
                          <td><?php echo $student_info['student_id']; ?><input type="hidden" name="student_id[]" value="<?php echo $student_info['student_id']; ?>"/> </td>
                          <td><?php echo $student_info['name']; ?><input type="hidden" name="student_name[]" value="<?php echo $student_info['name']; ?>"/> </td>
                          <td><input type="number" step=".1" max="<?php echo $course_mark['marks']; ?>" style="padding-left:10px;" name="marks[]" value="" /> </td>
                        </tr>
                      <?php
                        endforeach;
                      }
                      ?>
                  </table>
                </div>
                
              </div>
            

          </div>
        </div> <!-- /.box-body -->      
      <div class="box-footer">
        <center><input type="submit" class="btn btn-primary" value="submit"></center>         
      </div><!-- /.box-footer --> 
      </form>
      <?php } //end of first if $classes = 0
       } ?>
            
    </div><!-- /.box-info --> 

  </div>
</section>
</section>


<script type="text/javascript">
  $j('document').ready(function(){
    //dept and course change on class change , only for non - crud pages
    $("#m_class_id").change(function(){ 
       $('#session_id').val('');        
       var base_url="<?php echo site_url();?>";       
       var img_src="<?php echo base_url();?>"+"assets/pre-loader/Fading squares.gif";
       var img1= "<img src='"+img_src+ "' alt='Loading...' id='dept_id'>";           
       var img2= "<img src='"+img_src+ "' alt='Loading...' id='course_id'>";           
       $("#dept_id").parent().html(img1);
       $("#course_id").parent().html(img2);

      var class_id=$("#m_class_id").val();  
      var teacher_id="<?php echo $this->session->userdata('reference_id'); ?>";     
      if(class_id=='') class_id='Null';
      if(teacher_id=='') teacher_id='Null';

        $.ajax
        ({
           type:'POST',
           async:false,
           url:base_url+'home/dept_select_as_class/'+class_id+'/'+teacher_id,
           success:function(response)
            {
                $("#dept_id").parent().html(response);
                $('#no_exam').hide();
                $('#exam_info').show();
                $('#student_list').show();
            }
               
        });  

        $.ajax
        ({
           type:'POST',
           async:false,
           url:base_url+'home/course_select_as_class/'+class_id+'/'+teacher_id,
           success:function(response)
            {
                $("#course_id").parent().html(response);
            }
               
        });   
           
    });



  });


  function get_exam_name(){
    var class_id = $('#m_class_id').val();
    var department_id = $('#dept_id').val();
    var session_id = $('#session_id').val();
    if(class_id == '' || department_id == ''){
      $('#session_id').val('');
      alert("<?php echo $this->lang->line('please select class and group/dept. first');?>");
      return;
    }
    var base_url="<?php echo site_url();?>";
    $.ajax
        ({
           type:'POST',
           async:false,
           url:base_url+'teacher_marks_entry/get_exam_name',
           data:{class_id:class_id,department_id:department_id,session_id:session_id},
           success:function(response)
            {
              if(response == ''){
                $('#exam_info').hide();
                $('#student_list').hide();
                $('#no_exam').show();
                $('#no_exam_text').html('<h3>'+"<?php echo $this->lang->line('no exam is set for this class or you are not authorized for marks entry.');?>"+'</h3>');
              }
              else
                $('#exam_info').show();
                $('#student_list').show();
                $('#no_exam').hide();
                $('#exam_info').html(response);
            }
               
        }); 
  }


  $("#student_list").on('click',function(e){
    var class_id = $('#m_class_id').val();
    var shift_id = $('#shift_id').val();
    var section_id = $('#section_id').val();
    var department_id = $('#dept_id').val();
    var course_id = $('#course_id').val();
    var session_id = $('#session_id').val();
    var exam_name = $('#exam_name').val();
    // var marks_entry_date = $('#marks_entry_date').val();
    if(exam_name == '' || class_id == '' || shift_id == '' || section_id == '' || department_id == '' || course_id == '' || session_id == '' ){
      e.preventDefault();
      $('#error').show().html('<b>Please select all the fields</b>');
    }
  });

  // var todate="<?php echo date('Y');?>";
  // var from=todate-70;
  // var to=todate-12;
  // var str=from+":"+to;
  // var current_date="01/01/"+(todate-20);
  // $('#marks_entry_date').datepicker({ format: "dd-mm-yyyy",changeMonth:true, changeYear:true,yearRange: str, startView: "decade" });


</script>

