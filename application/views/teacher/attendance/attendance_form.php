<section class="content-header">
  <section class="content">
    <div class="box box-info custom_box">
      <div class="box-header">
        <h3 class="box-title"><i class="fa fa-plus-circle"></i> <?php echo $this->lang->line('attendance');?></h3>
      </div><!-- /.box-header -->
      <div style="padding-left:20px;margin-bottom:400px;">
        <a href="<?php echo site_url()."teacher_attendance/attendnace_sheet"; ?>"><h3><b><i class="fa fa-hand-o-right"></i> <?php echo $this->lang->line('get attendance');?></b></h3></a>
        <a href="<?php echo site_url()."teacher_attendance/attendance_percentage"; ?>"><h3><b><i class="fa fa-hand-o-right"></i> <?php echo $this->lang->line('update attendance');?></b></h3></a>
      </div>
    </div><!-- /.box-info --> 
  </section>
</section>
