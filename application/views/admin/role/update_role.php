<?php
  $xcenters_array=explode(',',$xdata[0]['departments']); 
?>  

  <section class="content-header">
   <section class="content">
     <div class="box box-info custom_box">
       <div class="box-header">
         <h3 class="box-title"><i class="fa fa-pencil"></i> <?php echo $this->lang->line('edit role');?></h3>
       </div><!-- /.box-header -->
       <!-- form start -->
       <form class="form-horizontal" action="<?php echo site_url().'admin/update_role_action';?>" method="POST">
         <div class="box-body">
           <div class="form-group">
             <label class="col-sm-3 control-label" for="name"><?php echo $this->lang->line('role name');?> *</label>
             <div class="col-sm-9 col-md-6 col-lg-6">
               <input name="hidden_id" value="<?php echo $xdata[0]['id'];?>" type="hidden">
               <input disabled="disabled" name="name" value="<?php echo $xdata[0]['name'];?>" class="form-control" type="text">             
             </div>
           </div>
            <div class="form-group">
               <label class="col-sm-3 control-label" for="">Status *</label>
               <div class="col-sm-9 col-md-6 col-lg-6">
                  <select name="status" class="form-control">
                     <option  value="1" <?php if($xdata[0]['status']==1) echo 'selected="yes"'; ?>><?php echo $this->lang->line('active');?></option>
                     <option  value="0" <?php if($xdata[0]['status']==0) echo 'selected="yes"'; ?>><?php echo $this->lang->line('inactive');?></option>
                  </select>
                  <span class="red"><?php echo form_error('status'); ?></span>
               </div>
             </div>
           <div class="form-group">
             <label class="col-sm-3 control-label" for=""><?php echo $this->lang->line('privilleges');?> *</label>
             <div class="col-sm-9">
                <!-- <div style='margin-left:5%'>  -->
                  <?php 
                    foreach($modules as $module)
                    { 
                       $module_id='check'.$module['id'].'[]';?>               
                       <br/><br/> 
                       <?php
                          if(in_array($module['id'],$xmodules)) 
                          {?>
                             <input name="modules[]" checked="checked" type="checkbox" value="<?php echo $module['id']; ?>"/><?php 
                          } 
                          else 
                          { ?>
                             <input name="modules[]" type="checkbox" value="<?php echo $module['id']; ?>"/><?php 
                          }                
                       ?>
                       <?php echo "<span class='blue'><b>".$module['name']."</b></span><br/>";
                                                
                       foreach($accesses as $access) 
                       {  
                          if(array_key_exists($module['id'],$xaccesses))
                          {
                             if(in_array($access['id'],explode(',',$xaccesses[$module['id']]))) 
                             {?>                  
                                <input  name="<?php echo $module_id;?>" checked="checked" type="checkbox" value="<?php echo $access['id']; ?>"/><?php 
                             }
                             else
                             { ?>
                                <input  name="<?php echo $module_id;?>"  type="checkbox" value="<?php echo $access['id']; ?>"/><?php 
                             }                  
                          }
                          else
                          { ?>
                             <input  name="<?php echo $module_id;?>"  type="checkbox" value="<?php echo $access['id']; ?>"/><?php 
                          } 
                          echo " ".$access['name']; 
                       }                                       
                    }  
                    ?>                
               <span class="red" ><?php echo "<br/><br/>".form_error('modules'); ?></span>  
              <!-- </div> -->
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
                      $check="";
                      if(in_array($center_id, $xcenters_array))
                      $check="checked";
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
               <input name="submit" type="submit" class="btn btn-warning btn-lg" value="<?php echo $this->lang->line('update')?>"/>
               <input type="button" class="btn btn-default btn-lg" value="<?php echo $this->lang->line('cancel')?>" onclick='goBack("admin/roles",1)'/>    
             </div>
           </div>
         </div><!-- /.box-footer -->         
         </div><!-- /.box-info -->       
       </form>     
     </div>
   </section>
</section>

