<section class="content-header">
  <section class="content">
  <?php if($classes == 0) 
          echo "<h3><div class='alert alert-info text-center'><i class='fa fa-info'></i> ",$this->lang->line('No data to show.'),"</div></h3>";
          else{
    ?>
    <div class="box box-info custom_box">
      <div class="box-header">
        <h3 class="box-title"><i class="fa fa-binoculars"></i> <?php echo $this->lang->line('search students');?></h3>
      </div><!-- /.box-header -->

      <form class="form-horizontal" action="<?php echo base_url('teacher_attendance/get_attendance_percentage'); ?>" method="POST">
        <div class="box-body">
          <div class="col-xs-12">
            <div class="row">
              <p class="alert alert-warning text-center" id="error" style="display:none;"></p>
            </div>
            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                <select name="class_id" id="class_id" class="form-control">
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
                  <?php 
                  $sessions['']=$this->lang->line('session');                      
                      echo form_dropdown('session_id',$sessions,"",'class="form-control" id="session_id"'); 
                  ?>
              </div>

              <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                  <input type="submit" id="student_list" value="<?php echo $this->lang->line('search students');?>" class="btn btn-primary" style="margin-right:16px;">
              </div>

            </div>

            <!-- <div class="row clearfix"><br/>
              <div class="pull-right">
                <input type="submit" id="student_list" value="Search Students" class="btn btn-primary" style="margin-right:16px;">
              </div>
            </div> -->
      </form>  
            <?php if(isset($courses)) {
              foreach($percentage as $percent){
                $attendance[$percent['student_id']][$percent['course_id']] = $percent['present_percentage'];
              }
            ?>
            
              <div class="row">
                <br/><br/>
                <div class="box-header">
                  <h3 class="box-title"><?php echo $this->lang->line('students attendance report');?></h3>
                </div><!-- /.box-header -->
              </div>
              <div class="row"> 
                <div class="table-responsive">
                  <table class="table table-bordered table-zebra table-hover table-stripped background_white">
                    <tr>
                      <th><?php echo $this->lang->line('student id');?></th>
                      <th><?php echo $this->lang->line('student name');?></th>
                      <?php 
                        for($i=0;$i<count($courses);$i++) 
                          echo '<th>'.$courses[$i]['course_name'].'</th>';
                      ?>
                      <th>Total</th>
                    </tr>
                    <?php  
                      foreach($students as $student_info){
                    ?>
                      <tr>
                        <td><?php echo $student_info['student_id']; ?></td>
                        <td><?php echo $student_info['name']; ?></td>
                        <?php 
                          $total = 0;
                          $number_of_subject = 0;
                          for($i=0;$i<count($courses);$i++){
                            $p = '';
                            if(isset($attendance[$student_info["student_id"]][$courses[$i]["id"]])){
                              $number = $attendance[$student_info["student_id"]][$courses[$i]["id"]];
                              $total = $total+$number;
                              $p = number_format($number,2);
                            }
                            if($p != ''){
                              $number_of_subject++;
                              echo '<td>'.$p.' %</td>';
                            }
                            else
                              echo '<td></td>';
                          }
                        ?>
                        <td><?php echo number_format(($total/$number_of_subject),2).' %'; ?></td>
                      </tr>
                    <?php } ?>
                  </table>
                </div>
                
              </div>
            

          </div>
        </div> <!-- /.box-body -->      
      <div class="box-footer">        
      </div><!-- /.box-footer --> 
      <?php 
        } 
        } // end of else condition
        
      ?>
            
    </div><!-- /.box-info --> 

  </div>
</section>
</section>
<script type="text/javascript">

  $("#student_list").on('click',function(e){
    var class_id = $('#class_id').val();
    var shift_id = $('#shift_id').val();
    var section_id = $('#section_id').val();
    var department_id = $('#dept_id').val();
    var course_id = $('#course_id').val();
    var session_id = $('#session_id').val();
    var attendance_date = $('#attendance_date').val();
    if(class_id == '' || shift_id == '' || section_id == '' || department_id == '' ||  session_id == '' ){
      e.preventDefault();
      $('#error').show().html('<b>'+"<?php echo $this->lang->line('please select all the fields');?>"+'</b>');
    }
  });

</script>

