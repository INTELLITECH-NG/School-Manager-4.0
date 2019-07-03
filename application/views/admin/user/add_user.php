<section class="content-header">
   <section class="content">
     <div class="box box-info custom_box">
       <div class="box-header">
         <h3 class="box-title"><i class="fa fa-plus-circle"></i> <?php echo $this->lang->line('add user');?></h3>
       </div><!-- /.box-header -->
       <!-- form start -->
       <form class="form-horizontal" action="<?php echo site_url().'admin/add_user_action';?>" method="POST">
         <div class="box-body">
           <div class="form-group">
             <label class="col-sm-3 control-label" for="name"><?php echo $this->lang->line('username');?> *</label>
             <div class="col-sm-9 col-md-6 col-lg-6">
               <input name="username" value="<?php echo set_value('username');?>"  class="form-control" type="text">
               <span class="red"><?php echo form_error('username'); ?></span>
             </div>
           </div>
           <div class="form-group">
             <label class="col-sm-3 control-label" for="name"><?php echo $this->lang->line('password');?> *</label>
             <div class="col-sm-9 col-md-6 col-lg-6">
               <input name="password" value="<?php echo set_value('password');?>"  class="form-control" type="password">
               <span class="red"><?php echo form_error('password'); ?></span>
             </div>
           </div> 
           <div class="form-group">
             <label class="col-sm-3 control-label" for="name"><?php echo $this->lang->line('confirm password');?> *</label>
             <div class="col-sm-9 col-md-6 col-lg-6">
               <input name="password2" value="<?php echo set_value('password2');?>"  class="form-control" type="password"> 
               <span class="red"><?php echo form_error('password2'); ?></span>           
             </div>
           </div>

           <div class="form-group">
             <label class="col-sm-3 control-label" for="name"><?php echo $this->lang->line('role');?> *</label>
             <div class="col-sm-9 col-md-6 col-lg-6">

               <?php 
                  $option['']='';
                  foreach($role_info as $row)
                    $option[$row['id']]=$row['name']; 
                  echo form_dropdown('role_name',$option,set_value('role_name'),'class="form-control"'); 
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
                <?php
                  $option1=array('1'=>$this->lang->line('active'),'0'=>$this->lang->line('inactive'));
                  echo form_dropdown('status',$option1,set_value('status'),'class="form-control"'); 
                ?>
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
                  if($this->session->flashdata('extra_validation')!='')
                  echo form_dropdown('type',$option2,'Individual','id="type"');                 
                  else
                  echo form_dropdown('type',$option2,set_value('type'),'id="type" class="form-control"'); 
                ?>
               <span class="red">
                  <?php echo form_error('type'); ?>
               </span>          
             </div>
           </div>
           <div class="form-group">
             <label class="col-sm-3 control-label" for="name"><?php echo $this->lang->line('individual type (* if individual)');?></label>
             <div class="col-sm-9 col-md-6 col-lg-6">
                <?php                
                      echo "<input type='radio' name='individual_type'  value='Teacher'>"," ",$this->lang->line("teacher");              
                      echo "&nbsp;&nbsp;&nbsp;&nbsp;<input type='radio' name='individual_type'  value='Student'>"," ",$this->lang->line("student");           
                      echo "&nbsp;&nbsp;&nbsp;&nbsp;<input type='radio' name='individual_type'  value='Employee'>","  ",$this->lang->line("Employee");          
                ?>
                <span class="red">
                <?php 
                echo "<br/>".$this->session->flashdata('extra_validation');   ?>
               </span>   
             </div>
           </div>
           <div class="form-group">
             <label class="col-sm-3 control-label" for="name"><?php echo $this->lang->line('reference id (* if individual)');?></label>
             <div class="col-sm-9 col-md-6 col-lg-6">
                 <?php 
                   echo form_input(array("name"=>"reference_id","id"=>"reference_id_search","value"=>"","class"=>"form-control"));         
                    ?>
                        <span class="red">
                        <?php                     
                   echo "<br/>".$this->session->flashdata('extra_validation2');
                    ?>
               </span>   
             </div>
           </div>           
           </div> <!-- /.box-body --> 
           <div class="box-footer">
            <div class="form-group">
             <div class="col-sm-12 text-center">
               <input name="submit" type="submit" class="btn btn-warning btn-lg" value='<?php echo $this->lang->line("save");?>'/>  
              <input type="button" class="btn btn-default btn-lg" value=<?php echo $this->lang->line("cancel");?> onclick='goBack("admin/users",0)'/>  
             </div>
           </div>
         </div><!-- /.box-footer -->         
         </div><!-- /.box-info -->       
       </form>     
     </div>
   </section>
</section>

