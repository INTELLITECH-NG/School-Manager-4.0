<section class="content-header">
   <section class="content">
     	<div class="box box-info custom_box">
		    	<div class="box-header">
		         <h3 class="box-title"><i class="fa fa-plus-circle"></i> <?php echo $this->lang->line('my query');?></h3>
		        </div><!-- /.box-header -->
		       		<!-- form start -->
		    <form class="form-horizontal" action="<?php echo site_url().'student/send_query_action';?>" method="POST">
		        <div class="box-body">
		           	<div class="form-group">
		              	<label class="col-sm-3 control-label" for="name"><?php echo $this->lang->line('subject');?> *
		              	</label>
		                	<div class="col-sm-9 col-md-6 col-lg-6">
		               			<input name="message_subject" value="<?php echo set_value('message_subject');?>"  class="form-control" type="text">		               
		             			<span class="red"><?php echo form_error('message_subject'); ?></span>
		             		</div>
		            </div>
		           <div class="form-group">
		             	<label class="col-sm-3 control-label" for="name"><?php echo $this->lang->line('message');?> *
		             	</label>
		             		<div class="col-sm-9 col-md-6 col-lg-6">
		               			<input name="message_body" value="<?php echo set_value('message_body');?>"  class="form-control" type="text-area">		          
		             			<span class="red"><?php echo form_error('message_body'); ?></span>
		             		</div>
		           </div> 
		               
		           </div> <!-- /.box-body --> 

		           	<div class="box-footer">
		            	<div class="form-group">
		             		<div class="col-sm-12 text-center">
		               			<input name="submit" type="submit" class="btn btn-warning btn-lg" value=<?php echo $this->lang->line("Save");?>/>  
		              			<input type="button" class="btn btn-default btn-lg" value=<?php echo $this->lang->line("Cancel");?> onclick='goBack("student/send_query_action",0)'/>  
		             		</div>
		           		</div>
		         	</div><!-- /.box-footer -->         
		        </div><!-- /.box-info -->       
		    </form>     
     	</div>
   </section>
</section>



