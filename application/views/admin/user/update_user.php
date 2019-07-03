<section class="content-header">
   <section class="content">
     <div class="box box-info custom_box">
       <div class="box-header">
         <h3 class="box-title"><i class="fa fa-pecil"></i> <?php echo $this->lang->line('edit user');?></h3>
       </div><!-- /.box-header -->
       <!-- form start -->
       <form class="form-horizontal" action="<?php echo site_url().'admin/update_user_action';?>" method="POST">
         <div class="box-body">
           <div class="form-group">
             <label class="col-sm-3 control-label" for="name"><?php echo $this->lang->line('username');?> *</label>
             <div class="col-sm-9 col-md-6 col-lg-6">
               <input name="hidden_id" value="<?php echo $xdata[0]['id'];?>" type="hidden">
               <input disabled="yes" name="username" value="<?php echo $xdata[0]['username'];?>"  class="form-control" type="text">
               <span class="red"><?php echo form_error('username'); ?></span>
             </div>
           </div>
           <div class="form-group">
             <label class="col-sm-3 control-label" for="name"><?php echo $this->lang->line('password');?> *</label>
             <div class="col-sm-9 col-md-6 col-lg-6">
               <input name="password" value="password" placeholder=""  class="form-control" type="password">
               <span class="red"><?php echo form_error('password'); ?></span>
             </div>
           </div> 
           <div class="form-group">
             <label class="col-sm-3 control-label" for="name"><?php echo $this->lang->line('confirm password');?> *</label>
             <div class="col-sm-9 col-md-6 col-lg-6">
                <input name="password2" value="password" placeholder=""  class="form-control" type="password">
               <span class="red"><?php echo form_error('password2'); ?></span>           
             </div>
           </div>
           <div class="form-group">
             <label class="col-sm-3 control-label" for="name"><?php echo $this->lang->line('role');?> *</label>
             <div class="col-sm-9 col-md-6 col-lg-6">

                 <?php 
                      echo "<select name='role_name' class='form-control'>";              
                        echo "<option value=''></option>";
                        foreach($role_info as $row)
                               {
                                   if($xdata[0]['role_id']==$row['id'])
                                   echo "<option value='".$row['id']."' selected='selected' >".$row['name']."</option>";
                                   else
                                   echo "<option value='".$row['id']."' >".$row['name']."</option>";
                               }
                      echo "</select>"; 
                  ?>

                  <span class="red">
                  <?php echo form_error('role_name'); ?>
                  </span>         
             </div>
           </div>
           <div class="form-group">
             <label class="col-sm-3 control-label" for="name"><?php echo $this->lang->line('status');?> *</label>
             <div class="col-sm-9 col-md-6 col-lg-6">
                <div class="controls">
                 <select name="status" class='form-control'>
                    <option  value="1" <?php if($xdata[0]['status']==1) echo 'selected="yes"'; ?>><?php echo $this->lang->line('active');?></option>
                    <option  value="0" <?php if($xdata[0]['status']==0) echo 'selected="yes"'; ?>><?php echo $this->lang->line('inactive');?></option>
                 </select>
                 <span class="red">
                    <?php echo form_error('status'); ?>
                 </span>          
                </div>
              </div>
           </div>
           <div class="form-group">
             <label class="col-sm-3 control-label" for="name"><?php echo $this->lang->line('user type');?> *</label>
             <div class="col-sm-9 col-md-6 col-lg-6">
               <?php 
                $option2=array(''=>'','Operator'=>'Operator','Individual'=>'Individual');
                if($xdata[0]['user_type']=='Individual') $user_type='Individual'; else $user_type='Operator';
                echo form_dropdown('type',$option2,$user_type,'id="type" class="form-control"'); 
               ?>
               <span class="red">
                  <?php echo form_error('type'); ?>
               </span>        
             </div>
           </div>
           <div class="form-group">
             <label class="col-sm-3 control-label" for="name"><?php echo $this->lang->line('individual type (* if individual)');?></label>
             <div class="col-sm-9 col-md-6 col-lg-6">
                <input type='radio' name='individual_type'  value='Teacher' <?php if($xdata[0]['type_details']=='Teacher') echo "checked"; ?>> <?php echo $this->lang->line('teacher');?>       
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type='radio' name='individual_type'  value='Student' <?php if($xdata[0]['type_details']=='Student') echo "checked"; ?>> <?php echo $this->lang->line('student');?>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type='radio' name='individual_type'  value='Employee' <?php if($xdata[0]['type_details']=='Employee') echo "checked"; ?>> <?php echo $this->lang->line('employee');?>
                <span class="red">
                 <?php                    
                  echo "<br/>".$this->session->flashdata('extra_validation'); 
                 ?>
                </span>   
             </div>
           </div>
           <div class="form-group">
             <label class="col-sm-3 control-label" for="name"><?php echo $this->lang->line('reference id (* if individual)')?></label>
             <div class="col-sm-9 col-md-6 col-lg-6">
                <?php 
                $ref=$xdata[0]['reference_id'];
                echo form_input(array("name"=>"reference_id","id"=>"reference_id_search","value"=>$ref,"class"=>"form-control"));         
                ?>
               <span class="red">
                <?php echo "<br/>".$this->session->flashdata('extra_validation2'); ?>
               </span>   
             </div>
           </div>           
           </div> <!-- /.box-body --> 
           <div class="box-footer">
            <div class="form-group">
             <div class="col-sm-12 text-center">
               <input name="submit" type="submit" class="btn btn-warning btn-lg" value=<?php echo $this->lang->line("update");?>/>  
              <input type="button" class="btn btn-default btn-lg" value=<?php echo $this->lang->line("cancel");?> onclick='goBack("admin/users",1)'/>  
             </div>
           </div>
         </div><!-- /.box-footer -->         
         </div><!-- /.box-info -->       
       </form>     
     </div>
   </section>
</section>

