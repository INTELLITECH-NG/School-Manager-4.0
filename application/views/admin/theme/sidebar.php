<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->  
  
    <ul class="sidebar-menu">
		<?php if(in_array(16,$this->role_modules)): ?>
		    <li><a href="<?php echo site_url()."admin_dashboard/"; ?>"><i class="fa fa-tachometer"></i> <span><?php echo $this->lang->line('dashboard');?></span></a></li>
    <?php endif; ?>
		
        <li class="treeview">
          <a href="#">
            <i class="fa fa-cogs"></i> <span><?php echo $this->lang->line('administration');?></span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">

          	<li><a href="<?php echo site_url()."admin_config/configuration"; ?>"><i class="fa fa-circle-o"></i> <?php echo $this->lang->line('general settings');?></a></li>
            
            <?php if(in_array(31,$this->role_modules)): ?>
              <li><a href="<?php echo site_url()."admin/sms_configuration"; ?>"><i class="fa fa-circle-o"></i> <?php echo $this->lang->line('sms settings');?></a></li>
            <?php endif; ?>

            <?php if(in_array(31,$this->role_modules)): ?>
              <li><a href="<?php echo site_url()."admin_config_email/index"; ?>"><i class="fa fa-circle-o"></i> <?php echo $this->lang->line('email settings');?></a></li>
            <?php endif; ?>

            <?php if(in_array(3,$this->role_modules)): ?>
              <li><a href="<?php echo site_url()."admin/financial_years"; ?>"><i class="fa fa-circle-o"></i> <?php echo $this->lang->line('financial year management');?></a></li>
            <?php endif; ?>

            <?php if(in_array(3,$this->role_modules)): ?>
              <li><a href="<?php echo site_url()."admin/sessions"; ?>"><i class="fa fa-circle-o"></i> <?php echo $this->lang->line('session management');?></a></li>               
            <?php endif; ?>
            
            <?php if(in_array(4,$this->role_modules)): ?>
              <li>
                <a href="#"><i class="fa fa-circle-o"></i> <?php echo $this->lang->line('class management');?> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                  <li><a href="<?php echo site_url()."admin/classes"; ?>"><i class="fa fa-circle-o"></i> <?php echo $this->lang->line('class');?></a></li>
                  <li><a href="<?php echo site_url()."admin/periods"; ?>"><i class="fa fa-circle-o"></i> <?php echo $this->lang->line('period');?></a></li>
                  <li><a href="<?php echo site_url()."admin/sections"; ?>"><i class="fa fa-circle-o"></i> <?php echo $this->lang->line('section');?></a></li>
                  <li><a href="<?php echo site_url()."admin/shifts"; ?>"><i class="fa fa-circle-o"></i> <?php echo $this->lang->line('shift');?></a></li>             
                  <li><a href="<?php echo site_url()."admin/departments"; ?>"><i class="fa fa-circle-o"></i> <?php echo $this->lang->line('group / dept.');?></a></li>                    
                </ul>
              </li>
            <?php endif; ?>
                      
            
            <?php if(in_array(5,$this->role_modules)): ?>
              <li><a href="<?php echo site_url()."admin/courses"; ?>"><i class="fa fa-circle-o"></i> <?php echo $this->lang->line('course management')?></a></li>
            <?php endif; ?>
            
            <?php if(in_array(13,$this->role_modules)): ?>
              <li><a href="<?php echo site_url()."admin/online_admission_configure"; ?>"> <i class="fa fa-circle-o"></i> <?php echo $this->lang->line('online admission management')?></a></li>
            <?php endif; ?>

            <?php if(in_array(14,$this->role_modules)): ?>
              <li>
                <a href="#"><i class="fa fa-circle-o"></i> <?php echo $this->lang->line('result management');?> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                  <li><a href="<?php echo site_url()."admin/exam_name_config"; ?>"><i class="fa fa-circle-o"></i> <?php echo $this->lang->line('exam')?> </a></li>                   
                  <li><a href="<?php echo site_url()."admin/gpa_config"; ?>"><i class="fa fa-circle-o"></i> <?php echo $this->lang->line('gpa')?></a></li>                   
                  <li><a href="<?php echo site_url()."admin/cgpa_config"; ?>"><i class="fa fa-circle-o"></i> <?php echo $this->lang->line('cgpa')?></a></li>                   
                  <li><a href="<?php echo site_url()."admin/result_config"; ?>"><i class="fa fa-circle-o"></i> <?php echo $this->lang->line('optional course')?></a></li>
                </ul>
              </li>
            <?php endif; ?>

            <?php if(in_array(1,$this->role_modules)): ?>
              <li><a href="<?php echo site_url()."admin/roles"; ?>"> <i class="fa fa-circle-o"></i> <?php echo $this->lang->line('role management');?></a></li>
            <?php endif; ?>

            <?php if(in_array(2,$this->role_modules)): ?>
              <li><a href="<?php echo site_url()."admin/users"; ?>"> <i class="fa fa-circle-o"></i> <?php echo $this->lang->line('user management');?></a></li>
            <?php endif; ?>
            
            <?php if(in_array(8,$this->role_modules)): ?>
              <li>
                <a href="#"><i class="fa fa-circle-o"></i> <?php echo $this->lang->line('accounts management')?><i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                  <li><a href="<?php echo site_url()."admin/account_types"; ?>"><i class="fa fa-circle-thin"></i> <?php echo $this->lang->line('account type');?></a></li>
                  <li><a href="<?php echo site_url()."admin/account_heads"; ?>"><i class="fa fa-circle-thin"></i> <?php echo $this->lang->line('account head');?></a></li>
                  <li><a href="<?php echo site_url()."admin/pay_slips"; ?>"><i class="fa fa-circle-thin"></i> <?php echo $this->lang->line('pay slip');?></a></li>
                  <?php /*<li><a href="<?php echo site_url()."admin/payment_methods"; ?>"><i class="fa fa-circle-thin"></i> <?php echo $this->lang->line('payment method');?></a></li> */ ?>                  
                  <li><a href="<?php echo site_url()."admin/payment_setting_admin"; ?>"><i class="fa fa-circle-thin"></i> <?php echo $this->lang->line('payment config');?></a></li>                    
                </ul>
              </li>
            <?php endif; ?>

             <?php if(in_array(15,$this->role_modules)): ?>
              <li>
                <a href="#"><i class="fa fa-circle-o"></i> <?php echo $this->lang->line('library management');?> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                   <li><a href="<?php echo site_url()."admin/book_categories"; ?>"><i class="fa fa-circle-o"></i> <?php echo $this->lang->line('book category');?></a></li> 
                    <li><a href="<?php echo site_url()."admin/config_circulation"; ?>"><i class="fa fa-circle-o"></i> <?php echo $this->lang->line('circulation');?></a></li>
                </ul>
              </li>
            <?php endif; ?>
            
            
            <?php if(in_array(10,$this->role_modules)): ?>
              <li>
                <a href="#"><i class="fa fa-circle-o"></i> <?php echo $this->lang->line('designation management');?> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                  <li><a href="<?php echo site_url()."admin/ranks"; ?>"><i class="fa fa-circle-o"></i><?php echo $this->lang->line('teacher');?></a></li>
                  <li><a href="<?php echo site_url()."admin/ranks_employee"; ?>"><i class="fa fa-circle-o"></i><?php echo $this->lang->line('staff');?></a></li>
                </ul>
              </li>
            <?php endif; ?>

            <?php if(in_array(9,$this->role_modules)): ?>
              <li><a href="<?php echo site_url()."admin/certificates"; ?>"> <i class="fa fa-circle-o"></i> <?php echo $this->lang->line('template management');?></a></li>
            <?php endif; ?>


            <?php if(in_array(33,$this->role_modules)): ?>
              <li>
                <a href="<?php echo site_url()."yearly_config/session"; ?>"><i class="fa fa-circle-o"></i> <?php echo $this->lang->line('yearly config');?> <?php /*<i class="fa fa-angle-left pull-right"></i> */ ?></a>
                <?php /*<ul class="treeview-menu">
                   <li><a href="<?php echo site_url()."yearly_config/session"; ?>"><i class="fa fa-circle-o"></i> <?php echo $this->lang->line('session data');?></a></li> 
                    <li><a href="<?php echo site_url()."yearly_config/financial_data"; ?>"><i class="fa fa-circle-o"></i> <?php echo $this->lang->line('financial data');?></a></li>
                </ul> */?>
              </li>
            <?php endif; ?>
            

          </ul>
        </li> <!-- end administrator -->	

        
        <?php if(in_array(18,$this->role_modules)): ?>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-envelope"></i>
              <span><?php echo $this->lang->line('notification');?></span>
              <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
              <li><a href="<?php echo site_url()."admin_sms_email/students"; ?>"><i class="fa fa-circle-o"></i> <?php echo $this->lang->line('student / gurdian');?></a></li>
              <li><a href="<?php echo site_url()."admin_sms_email/teachers"; ?>"><i class="fa fa-circle-o"></i> <?php echo $this->lang->line('teacher');?></a></li>
              <li><a href="<?php echo site_url()."admin_sms_email/sms_email_history"; ?>"><i class="fa fa-circle-o"></i> <?php echo $this->lang->line('history');?></a></li>
            </ul> 	              
          </li> <!-- end notification -->
        <?php endif; ?>

        <?php if(in_array(29,$this->role_modules)): ?>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-check-square"></i>
              <span><?php echo $this->lang->line('online admission');?></span>
              <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
              <li><a href="<?php echo site_url()."admin_online_admission/index"; ?>"><i class="fa fa-circle-o"></i> <?php echo $this->lang->line('applicants');?></a></li>
              <li><a href="<?php echo site_url()."admin_online_admission/merit_list"; ?>"><i class="fa fa-circle-o"></i> <?php echo $this->lang->line('merit list');?></a></li>
            </ul> 
          </li> <!-- end online admission -->
        <?php endif; ?>
        

        <?php if(in_array(19,$this->role_modules) || in_array(20,$this->role_modules) || in_array(21,$this->role_modules)): ?>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-user"></i>
              <span><?php echo $this->lang->line('student');?></span>
              <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
              <?php if(in_array(19,$this->role_modules)): ?>
                <li><a href="<?php echo site_url()."admin_student/index"; ?>"><i class="fa fa-circle-o"></i> <?php echo $this->lang->line('admission');?></a></li>
                <li><a href="<?php echo site_url()."promotion/index"; ?>"><i class="fa fa-circle-o"></i> <?php echo $this->lang->line('promotion');?></a></li>    
              <?php endif; ?>
              <?php if(in_array(20,$this->role_modules)): ?>
                <li><a href="<?php echo site_url()."admin_student/certificates"; ?>"><i class="fa fa-circle-o"></i> <?php echo $this->lang->line('certificate download');?></a></li>
              <?php endif; ?>
              <?php if(in_array(21,$this->role_modules)): ?>
                <li><a href="<?php echo site_url()."admin_student/student_queries"; ?>"><i class="fa fa-circle-o"></i> <?php echo $this->lang->line('query / complain');?></a></li>
              <?php endif; ?>
            </ul> 
          </li> <!-- end student -->
        <?php endif; ?>

        <?php if(in_array(27,$this->role_modules)): ?>
          <li><a href="<?php echo site_url()."admin_result_view/result_sheet"; ?>"><i class="fa  fa-table"></i> <span> <?php echo $this->lang->line('result');?></span></a></li>
        <?php endif; ?>



        <?php if(in_array(22,$this->role_modules) || in_array(23,$this->role_modules) || in_array(30,$this->role_modules)): ?>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-user-secret "></i>
              <span><?php echo $this->lang->line('teacher')?></span>
              <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
              <?php if(in_array(22,$this->role_modules)): ?>
                <li><a href="<?php echo site_url()."admin_teacher/teachers"; ?>"><i class="fa fa-circle-o"></i> <?php echo $this->lang->line('teacher');?></a></li>
              <?php endif; ?>
              <?php if(in_array(23,$this->role_modules)): ?>
                <li><a href="<?php echo site_url()."admin_routine/index"; ?>"><i class="fa fa-circle-o"></i> <?php echo $this->lang->line('assign class');?></a></li>
              <?php endif; ?>
              <?php if(in_array(30,$this->role_modules)): ?>
                <li><a href="<?php echo site_url()."admin_teacher/teacher_attendance"; ?>"><i class="fa fa-circle-o"></i> <?php echo $this->lang->line('attendance');?></a></li>
              <?php endif; ?>
            </ul> 	              
          </li> <!-- end teacher -->
        <?php endif; ?>

        
        <?php if(in_array(24,$this->role_modules)): ?>
          <li><a href="<?php echo site_url()."admin_staff/index"; ?>"><i class="fa  fa-user-plus"></i> <span> <?php echo $this->lang->line('staff');?></span></a></li>
        <?php endif; ?> 

          <?php if(in_array(28,$this->role_modules)): ?>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-book"></i> <span><?php echo $this->lang->line('library');?></span>
              <i class="fa fa-angle-left pull-right"></i>
            </a>             
            <ul class="treeview-menu">
               <?php if(in_array(28,$this->role_modules)): ?>
                <li><a href="<?php echo site_url()."admin_library/book_list"; ?>"><i class="fa  fa-book"></i> <span> <?php echo $this->lang->line('book');?></span></a></li>
              <?php endif; ?>    

              <?php if(in_array(28,$this->role_modules)): ?>
                <li><a href="<?php echo site_url()."admin_library/circulation"; ?>"><i class="fa  fa-retweet"></i> <span> <?php echo $this->lang->line('circulation');?></span></a></li>
              <?php endif; ?>   
            </ul>
          </li> <!-- end accounts -->
        <?php endif; ?>

        
       


        <?php if(in_array(25,$this->role_modules) || in_array(26,$this->role_modules)): ?>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-money"></i> <span><?php echo $this->lang->line('accounts');?></span>
              <i class="fa fa-angle-left pull-right"></i>
            </a>             
            <ul class="treeview-menu">
              <?php if(in_array(25,$this->role_modules)): ?>
                <li><a href="<?php echo site_url()."admin_account/student_wise"; ?>"><i class="fa fa-circle-o"></i> <?php echo $this->lang->line('student-wise report');?></a></li>
                <li><a href="<?php echo site_url()."admin_account/day_wise"; ?>"><i class="fa fa-circle-o"></i> <?php echo $this->lang->line('date-wise report');?></a></li>
                <li><a href="<?php echo site_url()."admin_account/brief"; ?>"><i class="fa fa-circle-o"></i> <?php echo $this->lang->line('brief report');?></a></li>                                  
              <?php endif; ?>

              <?php //if(in_array(26,$this->role_modules)): ?>
                <!--<li><a href="<?php //echo site_url()."admin_account/form_fees"; ?>"><i class="fa fa-circle-o"></i> <?php echo $this->lang->line('form fees report');?></a></li> -->                                 
              <?php //endif; ?>

            </ul>
          </li> <!-- end accounts -->
        <?php endif; ?>

       <li style="margin-bottom:200px">&nbsp;</li>   
      

    </ul>  <!-- end menu -->
  </section> <!-- /.sidebar -->
</aside>


