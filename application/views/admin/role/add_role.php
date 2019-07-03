<section class="content-header">
   <section class="content">
     <div class="box box-info custom_box">
       <div class="box-header">
         <h3 class="box-title"><i class="fa fa-plus-circle"></i> <?php echo $this->lang->line('add role');?></h3>
       </div><!-- /.box-header -->
       <!-- form start -->
       <form class="form-horizontal" action="<?php echo site_url().'admin/add_role_action';?>" method="POST">
         <div class="box-body">
           <div class="form-group">
             <label class="col-sm-3 control-label" for="name"><?php echo $this->lang->line('role name');?> *</label>
             <div class="col-sm-9 col-md-6 col-lg-6">
               <input name="name" value="<?php echo set_value('name');?>"  class="form-control" type="text">
               <span class="red"><?php echo form_error('name'); ?></span>
             </div>
           </div>
           <div class="form-group">
             <label class="col-sm-3 control-label" for="name"><?php echo $this->lang->line('status')?> *</label>
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
             <label class="col-sm-3 control-label" for=""><?php echo $this->lang->line('privilleges');?> *</label>
             <div class="col-sm-9">
             <?php
               foreach($modules as $module)
               { 
                  $module_id='check'.$module['id'].'[]';
                  $check=set_radio('modules', $module['id']); ?>

                  <br/><br/><input name="modules[]" <?php echo $check; ?> type="checkbox" value="<?php echo $module['id']; ?>"/> 
                  <?php echo "<span class='blue'><b>".$module['name']."</b></span><br/>";
                                           
                  foreach($accesses as $access) 
                  {  ?>                  
                        <input  name="<?php echo $module_id;?>"  type="checkbox" value="<?php echo $access['id']; ?>"/>
                        <?php echo $access['name']; ?>                  
                     <?php 
                  }                
                                
               }  ?>
               <span class="red" ><?php echo "<br/><br/>".form_error('modules'); ?></span>  
              </div> 
             </div>
             <div class="form-group">
             <label class="col-sm-3 control-label" for=""><?php echo $this->lang->line('groups / departments');?> *</label>
             <div class="col-sm-9">
              <?php
                 foreach($centers as $class_name=>$center)
                 {                    
                    echo "<br/><br/><span class='blue'><b>Class - ".$class_name."</b></span><br/>";
                    foreach($center as $row)
                    {
                      $center_id=$row['dept_id'];
                      $name=$row['dept_name'];
                      $check=set_radio('centers',$center_id);
                      ?>
                      <input type="checkbox"  name="centers[]" <?php echo $check; ?>  value="<?php echo $center_id; ?>" /> 
                      <?php echo $name; 
                    }
                 }
              ?>
               <span class="red"><?php echo "<br/><br/>".form_error('centers'); ?></span>
              </div> 
             </div>


           </div> <!-- /.box-body --> 
           <div class="box-footer">
            <div class="form-group">
             <div class="col-sm-12 text-center">
               <input name="submit" type="submit" class="btn btn-warning btn-lg" value="<?php echo $this->lang->line('save');?>"/>         
               <input type="button" class="btn btn-default btn-lg" value="<?php echo $this->lang->line('cancel');?>" onclick='goBack("admin/roles",0)'/>
             </div>
           </div>
         </div><!-- /.box-footer -->         
         </div><!-- /.box-info -->       
       </form>     
     </div>
   </section>
</section>

