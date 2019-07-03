<div class="navbar-custom-menu">
	<ul class="nav navbar-nav">
	
    <?php 
      $pro_pic=base_url().'upload/applicant/'.$this->session->userdata('app_pro_pic');
      if(!$this->session->userdata('app_pro_pic'))
      $pro_pic=base_url().'assets/images/avatar/common.png';
    ?>
    <!-- User Account: style can be found in dropdown.less -->
    <li class="dropdown user user-menu">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown">
       <i class="fa fa-user"></i>
        <span><?php echo $this->session->userdata('app_username'); ?></span>
      </a>
      <ul class="dropdown-menu">
        <!-- User image -->
        <li class="user-header">          
          <center><img src="<?php echo $pro_pic;?>" style="height:120px;width:120px;" class="img-circle"/></center>
          <p>
            <?php echo $this->session->userdata('app_real_name');?>           
          </p>
        </li>
        <!-- Menu Body -->
        <!-- <li class="user-body">
          <div class="col-xs-4 text-center">
            <a href="#">Followers</a>
          </div>
          <div class="col-xs-4 text-center">
            <a href="#">Sales</a>
          </div>
          <div class="col-xs-4 text-center">
            <a href="#">Friends</a>
          </div>
        </li> -->
        <!-- Menu Footer-->
        <li class="user-footer border_gray">
          <div class="pull-left">
            <a href="<?php echo site_url('applicant/reset_password_form') ?>" class="btn btn-info btn-flat"><?php echo $this->lang->line('change password');?></a>
          </div>
          <div class="pull-right">
            <a href="<?php echo site_url('online/applicant_logout') ?>" class="btn btn-warning btn-flat"><?php echo $this->lang->line('sign out');?></a>
          </div>
        </li>
      </ul>
    </li>
    <!-- Control Sidebar Toggle Button -->
    <!-- <li>
      <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
    </li> -->
  </ul>
</div>