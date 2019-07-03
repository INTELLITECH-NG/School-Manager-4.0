<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->  
  
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
      <li><a href="<?php echo site_url()."applicant/index"; ?>"><i class="fa fa-user"></i> <span><?php echo $this->lang->line('profile');?></span></a></li>  
      <li><a href="<?php echo site_url()."applicant/reset_password_form"; ?>"><i class="fa fa-key"></i> <span><?php echo $this->lang->line('change password');?></span></a></li>  
     
      <?php if($admission_config['application_last_date']>=date("Y-m-d")) 
      { ?>
        <li><a href="<?php echo site_url()."applicant/update_application"; ?>"><i class="fa fa-pencil"></i> <span><?php echo $this->lang->line('update application');?></span></a></li>	
      <?php 
      } ?>

      <?php if($info[0]['payment_status']=="0" && $admission_config['form_price']>0) 
      { ?>
        <li><a href="<?php echo site_url()."applicant/pay_form_fees"; ?>"><i class="fa fa-money"></i> <span><?php echo $this->lang->line('pay form fees');?></span></a></li>
      <?php 
      } ?>

      <li><a href="<?php echo site_url()."applicant/download_application"; ?>"><i class="fa fa-cloud-download"></i> <span><?php echo $this->lang->line('download application');?></span></a></li>  
      
      <?php if($admission_config['is_admission_test']=="1" ) 
      { ?>
        <li><a href="<?php echo site_url()."applicant/download_admit"; ?>" target="_blank"><i class="fa fa-cloud-download"></i> <span><?php echo $this->lang->line('download admit card');?></span></a></li>
      <?php 
      } ?>

      <?php //if($admission_config['admission_last_date']>=date("Y-m-d") && $info[0]['is_in_merit_list']=="1" ) 
      //{ ?>
        <!-- <li><a href="<?php //echo site_url()."applicant/pay_admission_fees"; ?>"><i class="fa fa-check-square-o"></i> <span><?php //echo $this->lang->line('admission');?></span></a></li> -->
      <?php 
      //} ?>

      <li><a href="<?php echo site_url()."online/applicant_logout"; ?>"><i class="fa fa-sign-out"></i> <span><?php echo $this->lang->line('sign out');?></span></a></li>
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>