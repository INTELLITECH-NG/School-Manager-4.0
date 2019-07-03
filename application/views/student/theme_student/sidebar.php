<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->  
  
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
         <li><a href="<?php echo site_url()."student/index"; ?>"><i class="fa fa-user"></i> <span><?php echo $this->lang->line('profile');?></span></a></li>	
         <li><a href="<?php echo site_url()."student/routine"; ?>"><i class="fa fa-calendar"></i> <span><?php echo $this->lang->line('routine');?></span></a></li>
         <li><a href="<?php echo site_url()."student/show_my_attendence"; ?>"><i class="fa fa-check-square-o"></i> <span><?php echo $this->lang->line('attendence');?></span></a></li>
         <li><a href="<?php echo site_url()."student/my_course_material"; ?>"><i class="fa  fa-file-pdf-o"></i> <span><?php echo $this->lang->line('course material');?></span></a></li> 
         <li><a href="<?php echo site_url()."student/sms_history"; ?>"><i class="fa fa-envelope"></i> <span><?php echo $this->lang->line('notification');?></span></a></li>  
         <li><a href="<?php echo site_url()."student/student_query"; ?>"><i class="fa fa-question"></i> <span><?php echo $this->lang->line('query/ complain');?></span></a></li>
         <li><a href="<?php echo site_url()."student/transaction_history"; ?>"><i class="fa fa-money"></i> <span><?php echo $this->lang->line('transaction');?></span></a></li>  
         <li><a href="<?php echo site_url()."student/show_marks_home"; ?>"><i class="fa fa-list-alt"></i> <span><?php echo $this->lang->line('result');?></span></a></li>  

    </ul>
  </section>
  <!-- /.sidebar -->
</aside>