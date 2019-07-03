<div class="navbar-custom-menu">
  <ul class="nav navbar-nav">
   <li>  
        <?php       
        $select_lan=$this->language;
        ?>
        <select name="language" autocomplete="off" id="language_change" class="form-control  pull-right" style="width:125px;height:40px;margin-top:5px;">
          <?php 
          foreach($language_info as $val=>$language) 
          { 
            if($select_lan==$val) $is_selected="selected='selected'";
            else $is_selected="";
            ?>
            <option <?php echo $is_selected;?> value="<?php echo $val;?>"><?php echo $language;?></option>
          <?php
          }
          ?>
        </select>  
  </li>
  <?php 
    if(in_array(1,$this->role_module_accesses_18)){ 
  ?>
     <li class="dropdown messages-menu">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <i class="fa fa-envelope-o"></i>
        <span class="label label-success">
        <?php 
          $count=count($student_query_notifications);
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
          <li class="header text-center">You have <?php echo $count2; ?> pending queries/ complains.</li>
          <li>
           <ul class="menu">
              <?php 
              foreach($student_query_notifications as $row) 
              {              
                $image_name=$row["image"];
                if($image_name=="")
                {
                  if($row["gender"]=="Female") $image_name="girl.png";
                  else $image_name="boy.png";
                }
                $image_src=base_url("upload/student/".$image_name);
                ?>
                <li class="clearfix">
                <a class="clearfix" href="<?php echo site_url().'admin_student/reply_query/'.$row['primary_key']; ?>">
                  <img class="img-circle pull-left" style="border:1px solid #ccc;width:40px;margin:0;padding:0;" src="<?php echo $image_src; ?>">
                 <div class="pull-left" style="margin:0;padding:0;">
                    <h6 style='padding-left:7px;margin:0'>                    
                      <?php echo $row['student_name'];?>
                      <br/><small><i class="fa fa-clock-o"></i><?php echo $row['sent_at'];?></small><br/>               
                    <?php 
                      if(strlen($row['message_subject'])>30)
                      echo substr($row['message_subject'], 0, 30)."...";
                      else echo $row['message_subject'];
                    ?>
                    </h6>
                 </div>
                </a>
                </li>
              <?php 
              } ?>            
          </ul>  
         </li> <?php
        } 
        else echo "<li class='text-center'>No pending query/ complain is available.</li>";?>       

        <li class="footer"><a href="<?php echo site_url().'admin_student/student_queries';?>">See all queries/ complains</a></li>
      </ul>
    </li>
	<?php 
    } // end of if in_array condition
  ?>
   
  
    <?php 
      $pro_pic=base_url().'assets/images/logo.png';
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
          <center><img src="<?php echo $pro_pic;?>" class="img-responsive"/></center>
          <p>
            <?php echo $this->session->userdata('username');?>           
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
            <a href="<?php echo site_url('change_password/reset_password_form') ?>" class="btn btn-info btn-flat"><?php echo $this->lang->line('change password');?></a>
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