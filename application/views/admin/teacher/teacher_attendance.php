<section class="content-header">
  <section class="content">
  <?php 
      if($this->session->userdata('success')){
        echo "<h3><div class='alert alert-info text-center'><i class='fa fa-info'></i> ".$this->session->userdata('success')."</div></h3>";
        $this->session->unset_userdata('success');
      }
    ?>
    <div class="box box-info custom_box">
      <div class="box-header">
        <h3 class="box-title"><i class="fa fa-search"></i> <?php echo $this->lang->line('search teachers');?></h3>
      </div><!-- /.box-header -->
      <form class="form-horizontal" action="<?php echo base_url('admin_teacher/get_teachers'); ?>" method="POST">
        <div class="box-body">
          <div class="col-xs-12">
              <p class="alert alert-warning text-center" id="error" style="display:none;"></p>
              <div class="row clearfix">
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                  <input type="text" name="attendance_date" class="form-control" id="attendance_date" placeholder="day-month-year (Ex: 30-01-1989)">
                </div>
                <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                  <input type="submit" id="student_list" value="<?php echo $this->lang->line('Search');?>" class="btn btn-primary" >
                </div>
              </div>
      </form>  

            <?php if(isset($attendance_date)) {?>
            <form action="<?php echo base_url('admin_teacher/attendance_input'); ?>" method="POST">
              
              <input type="hidden" name="attendance_date_input" value="<?php echo $attendance_date; ?>">
              <div class="row">
                <br/><br/>
                <div class="box-header">
                  <h3 class="box-title"><?php echo $this->lang->line("teacher's attendance sheet");?></h3>
                </div><!-- /.box-header -->
              </div>
              <div class="row"> 
                <div class="table-responsive">
                  <table class="table table-bordered table-zebra table-hover table-stripped background_white">
                    <tr>
                      <th><?php echo $this->lang->line('teacher id');?></th>
                      <th><?php echo $this->lang->line('teacher name');?></th>
                      <th><?php echo date('d / M / Y',strtotime($attendance_date)); ?></th>
                    </tr>
                    <?php  
                      if(isset($attendance_status)){
                        echo '<input type="hidden" name="delete_insert" value="delete">';
                       
                    for($k=0;$k<count($teachers_info);$k++){   
                    ?>
                      <tr> <input type="hidden" name="teacher_info_id[]" value="<?php echo $teachers_info[$k]['id']; ?>"/>
                        <td><?php echo $teachers_info[$k]['teacher_no']; ?><input type="hidden" name="teacher_id[]" value="<?php echo $teachers_info[$k]['teacher_no']; ?>"/> </td>
                        <td><?php echo $teachers_info[$k]['teacher_name']; ?><input type="hidden" name="teacher_name[]" value="<?php echo $teachers_info[$k]['teacher_name']; ?>"/> </td>
                        <td>
                        <?php $temp=$teachers_info[$k]['teacher_no']; ?>
                        <input type="checkbox" name="status[<?php echo $temp;?>]" <?php if($attendance_status[$k]['status'] == '1') echo 'checked'; ?> /> </td>
                      </tr>
                    <?php 
                      } 
                      
                      }
                      else{
                        echo '<input type="hidden" name="delete_insert" value="insert">';

                        foreach($teachers_info as $teacher_info) :
                      ?>
                        <tr> <input type="hidden" name="teacher_info_id[]" value="<?php echo $teacher_info['id']; ?>"/>
                          <td><?php echo $teacher_info['teacher_no']; ?><input type="hidden" name="teacher_id[]" value="<?php echo $teacher_info['teacher_no']; ?>"/> </td>
                          <td><?php echo $teacher_info['teacher_name']; ?><input type="hidden" name="teacher_name[]" value="<?php echo $teacher_info['teacher_name']; ?>"/> </td>
                          <?php $temp=$teacher_info['teacher_no']; ?>
                          <td><input type="checkbox" name="status[<?php echo $temp;?>]" /> </td>
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
      <?php
       } 
      ?>
            
    </div><!-- /.box-info --> 

  </div>
</section>
</section>
<script type="text/javascript">

  $("#student_list").on('click',function(e){
    var attendance_date = $('#attendance_date').val();
    if(attendance_date == ''){
      e.preventDefault();
      $('#error').show().html('<b>'+"<?php echo $this->lang->line('Please select the date field.');?>"+'</b>');
    }
  });

  var todate="<?php echo date('Y');?>";
  var from=todate-70;
  var to=todate-12;
  var str=from+":"+to;
  // var current_date="01/01/"+(todate-20);
  $('#attendance_date').datepicker({ format: "dd-mm-yyyy",changeMonth:true, changeYear:true,yearRange: str, startView: "decade" });


</script>

