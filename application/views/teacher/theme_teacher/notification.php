<div class="navbar-custom-menu">
  <ul class="nav navbar-nav">
    <li class="dropdown messages-menu">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown" title="Notifications">
        <i class="fa fa-bell-o"></i>
        <span class="label label-warning">
          <?php 
                $count=count($teacher_sms_email_notifications);
                echo $count; 
                $count2=$count;
                if($count==0) $count2="no";
              ?>
        </span>
      </a>
      <ul class="dropdown-menu">
        <?php 
            if($count>0) 
            { ?>
            <li class="header text-center">You have <?php echo $count2; ?> notifications.</li>
          <li>
            <!-- inner menu: contains the actual data -->
            <ul class="menu">
              <?php 
              foreach($teacher_sms_email_notifications as $row) 
                      { ?> 
                        <li><!-- start message -->
                        <a href="<?php echo site_url().'teacher/details_notification/'.$row['id']; ?>">                 
                          <h4 class="no_margin blue">
                            <i class="fa fa-envelope"></i> View Notification
                            <small><i class="fa fa-clock-o"></i><?php echo $row['sent_at'];?></small>
                          </h4>
                          <p class="no_margin">
                            <?php 
                                        if(strlen($row['title'])>30)
                                        echo substr($row['title'], 0, 30)."...";
                                        else echo $row['title'];
                                     ?>
                          </p>
                        </a>
                      </li><!-- end message --> 
                    <?php 
                    } ?>          
            </ul>
          </li>
        <?php 
        } 
        else echo "<li class='text-center'>No new notification is available.</li>"; ?>
        <li class="footer"><a href="<?php echo site_url().'teacher/sms_history';?>"><?php echo $this->lang->line('see all notifications');?></a></li>
      </ul>
    </li>
  
    <?php 
      $pro_pic=base_url().'upload/teacher/'.$this->session->userdata('profile_pic');
      if(!$this->session->userdata('profile_pic'))
      $pro_pic=base_url().'assets/images/avatar/common.png';
    ?>
    <!-- User Account: style can be found in dropdown.less -->
    <li class="dropdown user user-menu">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown">
       <i class="fa fa-user"></i>
        <span><?php echo $this->session->userdata('username'); ?></span>
      </a>
      <ul class="dropdown-menu">
        <!-- User image -->
        <li class="user-header">          
          <center><img src="<?php echo $pro_pic;?>" style="height:120px;width:120px;" class="img-circle"/></center>
          <p>
            <?php echo $this->session->userdata('real_username');?>           
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
            <a href="<?php echo site_url('teacher/reset_password_form') ?>" class="btn btn-info btn-flat"><?php echo $this->lang->line('change password');?></a>
          </div>
          <div class="pull-right">
            <a href="<?php echo site_url('home/logout') ?>" class="btn btn-warning btn-flat"><?php echo $this->lang->line('sign out');?></a>
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