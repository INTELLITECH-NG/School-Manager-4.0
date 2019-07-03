<?php $this->load->view('admin/theme/message'); ?>
<section class="content-header">
   <section class="content">
     	<div class="box box-info custom_box">
		    	<div class="box-header">

		         <h3 class="box-title"><i class="fa fa-pencil"></i><?php echo $this->lang->line("general configuration"); ?> </h3>
		        </div><!-- /.box-header -->
		       		<!-- form start -->
		    <form class="form-horizontal" enctype="multipart/form-data" action="<?php echo site_url().'admin_config/edit_config';?>" method="POST">
		        <div class="box-body">
		           	<div class="form-group">
		              	<label class="col-sm-3 control-label" for="name"><?php echo $this->lang->line("institute name"); ?> *
		              	</label>
		                	<div class="col-sm-9 col-md-6 col-lg-6">
		               			<input name="institute_name" value="<?php echo $this->config->item('institute_address1');?>"  class="form-control" type="text">		               
		             			<span class="red"><?php echo form_error('institute_name'); ?></span>
		             		</div>
		            </div>
		           <div class="form-group">
		             	<label class="col-sm-3 control-label" for="name"><?php echo $this->lang->line("institute address"); ?> *
		             	</label>
	             		<div class="col-sm-9 col-md-6 col-lg-6">
	               			<input name="institute_address" value="<?php echo $this->config->item('institute_address2');?>"  class="form-control" type="text">		          
	             			<span class="red"><?php echo form_error('institute_address'); ?></span>
	             		</div>
		           </div> 

		           <div class="form-group">
		             	<label class="col-sm-3 control-label" for="name"><?php echo $this->lang->line("institute email"); ?> *
		             	</label>
	             		<div class="col-sm-9 col-md-6 col-lg-6">
	               			<input name="institute_email" value="<?php echo $this->config->item('institute_email');?>"  class="form-control" type="email">		          
	             			<span class="red"><?php echo form_error('institute_email'); ?></span>
	             		</div>
		           </div> 


		           <div class="form-group">
		             	<label class="col-sm-3 control-label" for="name"><?php echo $this->lang->line("institute phone / mobile"); ?>  *
		             	</label>
	             		<div class="col-sm-9 col-md-6 col-lg-6">
	               			<input name="institute_mobile" value="<?php echo $this->config->item('institute_mobile');?>"  class="form-control" type="text">		          
	             			<span class="red"><?php echo form_error('institute_mobile'); ?></span>
	             		</div>
		           </div> 

		           <div class="form-group">
		             	<label class="col-sm-3 control-label" for="name"><?php echo $this->lang->line("favicon"); ?>
		             	</label>
	             		<div class="col-sm-9 col-md-6 col-lg-6">
		           			<div class='text-center'><img class="img-responsive" src="<?php echo base_url('assets/images/favicon.png'); ?>" alt="Logo"/></div>
	               			<?php echo $this->lang->line("max dimensioin: 32 x 32 (png, max sixe: 50kb)");?> 
	               			<input name="logo" class="form-control" type="file">		          
	             			<span class="red"> <?php echo $this->session->userdata('logo_error'); $this->session->unset_userdata('logo_error'); ?></span>
	             		</div>
		           </div> 

		           <div class="form-group">
		             	<label class="col-sm-3 control-label" for="name"><?php echo $this->lang->line("logo"); ?>   
		             	</label>
	             		<div class="col-sm-9 col-md-6 col-lg-6">
	             			<div class='text-center' style="background:#357CA5;padding:10px 0;"><img class="img-responsive center-block" src="<?php echo base_url('assets/images/logo_name.png'); ?>" alt="Logo and Name"/></div>
	               			<?php echo $this->lang->line("max dimensioin: 600 x 300 (png, max sixe: 200kb) "); ?>
	               			<input name="logo_name"  class="form-control" type="file">		          
	             			<span class="red"><?php echo $this->session->userdata('logo_name_error'); $this->session->unset_userdata('logo_name_error'); ?></span>
	             		</div>
		           </div> 

		           <div class="form-group">
		             	<label class="col-sm-3 control-label" for=""><?php echo $this->lang->line("language");?>
		             	</label>
	             		<div class="col-sm-9 col-md-6 col-lg-6">	             			
	               			<?php
							$select_lan="english";
							if($this->config->item('language')!="") $select_lan=$this->config->item('language');
							echo form_dropdown('language',$language_info,$select_lan,'class="form-control" id="language"');  ?>		          
	             			<span class="red"><?php echo form_error('language'); ?></span>
	             		</div>
		           </div>

		           		         		               
		           </div> <!-- /.box-body --> 

		           	<div class="box-footer">
		            	<div class="form-group">
		             		<div class="col-sm-12 text-center">
		               			<input name="submit" type="submit" class="btn btn-warning btn-lg" value="<?php echo $this->lang->line('save');?>"/>  
		              			<input type="button" class="btn btn-default btn-lg" value="<?php echo $this->lang->line('cancel'); ?>" onclick='goBack("admin_config",1)'/>  
		             		</div>
		           		</div>
		         	</div><!-- /.box-footer -->         
		        </div><!-- /.box-info -->       
		    </form>     
     	</div>
   </section>
</section>



