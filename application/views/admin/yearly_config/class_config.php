<section class="content-header">
   <section class="content">
     <div class="box box-info custom_box">
       <div class="box-header">
         <h3 class="box-title"><i class="fa fa-plus-circle"></i> <?php echo $this->lang->line('yearly setting class');?></h3>
       </div><!-- /.box-header -->
       <!-- form start -->
       <form class="form-horizontal" action="<?php echo site_url().'yearly_config/class_config_action';?>" method="POST">
         
           <br/><br/><div class="form-group">
             <label class="col-sm-3 control-label" for="class_id"><?php echo $this->lang->line('class');?> *</label>
             <div class="col-sm-9 col-md-6 col-lg-6">
               <?php 
                $class_info['']='';
                echo form_dropdown('class_id',$class_info,set_value('class_id'),'class="form-control" id="class_id"'); 
               ?>
               <span class="red"><?php echo form_error('class_id'); ?></span>
             </div>
           </div>
           
           <div class="form-group">
             <label class="col-sm-3 control-label" for="from_session_id"><?php echo $this->lang->line('from session');?> *</label>
             <div class="col-sm-9 col-md-6 col-lg-6">
               <?php 
                $session_info['']='';
                echo form_dropdown('from_session_id',$session_info,set_value('from_session_id'),'class="form-control" id="from_session_id"'); 
               ?>
               <span class="red"><?php echo form_error('from_session_id'); ?></span>
             </div>
           </div>

           <div class="form-group">
             <label class="col-sm-3 control-label" for="to_session_id"><?php echo $this->lang->line('to session');?> *</label>
             <div class="col-sm-9 col-md-6 col-lg-6">
               <?php 
                $session_info['']='';
                echo form_dropdown('to_session_id',$session_info,set_value('to_session_id'),'class="form-control" id="to_session_id"'); 
               ?>
               <span class="red"><?php echo form_error('to_session_id'); ?></span>
             </div>
           </div><br/><br/>      

           </div> <!-- /.box-body --> 
           <div class="box-footer">
            <div class="form-group">
             <div class="col-sm-12 text-center">               
               <input name="submit" type="submit" class="btn btn-warning btn-lg" value=<?php echo $this->lang->line("save");?>/>   
                   
               <input type="button" class="btn btn-default btn-lg" value=<?php echo $this->lang->line("cancel");?> onclick='goBack("yearly_config/class_config",0)'/>
             </div>
           </div>
         </div><!-- /.box-footer -->         
         </div><!-- /.box-info -->       
       </form>     
     </div>
   </section>
</section>


