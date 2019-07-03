<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->  
  
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu"> 
      <li><a href="<?php echo site_url().'teacher/index'; ?>"><i class="fa fa-user"></i> <span><?php echo $this->lang->line('profile');?></span></a></li>
      <li><a href="<?php echo site_url().'teacher/routine'; ?>"><i class="fa fa-calendar"></i> <span><?php echo $this->lang->line('class routine');?></span></a></li>
      <li><a href="<?php echo site_url().'teacher/sms_history_paginition'; ?>"><i class="fa fa-envelope"></i><span><?php echo $this->lang->line('notification');?></span></a></li>
      <li><a href="<?php echo site_url().'teacher/course_materials'; ?>"><i class="fa  fa-file-pdf-o"></i> <span><?php echo $this->lang->line('course material');?></span></a></li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-check-square-o"></i>
          <span><?php echo $this->lang->line('attendance');?></span>
          <i class="fa fa-angle-left pull-right"></i>
        </a> 
        <ul class="treeview-menu">
          <li><a href="<?php echo site_url().'teacher_attendance/attendnace_sheet'; ?>"><i class="fa fa-circle-o"></i> <span><?php echo $this->lang->line('daily attendence sheet');?></span></a></li>
          <li><a href="<?php echo site_url().'teacher_attendance/attendance_percentage'; ?>"><i class="fa fa-circle-o"></i> <span><?php echo $this->lang->line('attendence report');?></span></a></li>
        </ul>
      </li>
     <li><a href="<?php echo site_url().'teacher_marks_entry/marks_entry_sheet'; ?>"><i class="fa  fa-file-pdf-o"></i> <span><?php echo $this->lang->line('marks entry');?></span></a></li>
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>