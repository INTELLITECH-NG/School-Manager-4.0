<section class="content-header">
	<section class="content">
		<div class="box box-info custom_box">
			<div class="box-header">
				<h3 class="box-title"><i class="fa fa-location-arrow"></i> <?php echo $this->lang->line('reply query / complain');?></h3>
			</div><!-- /.box-header -->
			<form method="POST" action="<?php echo site_url('admin_student/reply_query_action'); ?>" class="form-horizontal">
				<div class="box-body">				
					<div class="form-group">
						<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label"><?php echo $this->lang->line('from');?></label>
						<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 text-justify">
							<?php echo "<a title='Profile' href='".site_url().'admin_student/student_profile/'.$query_data[0]['student_info_id']."'>". $query_data[0]['student_name']."</a>";?>
							 &nbsp;&nbsp;&nbsp; <i class="fa fa-clock-o"></i><b><?php echo $query_data[0]['sent_at'];?></b>
						</div>
					</div>
					<div class="form-group">
						<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label"><?php echo $this->lang->line('subject');?></label>
						<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 text-justify">
							<?php echo $query_data[0]['message_subject']; ?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label"><?php echo $this->lang->line('query/ complain');?></label>
						<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 text-justify">
							<?php echo $query_data[0]['message_body']; ?>
						</div>
					</div>
					<div class="form-group">
						<label for="student_name" class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label"><?php echo $this->lang->line('reply');?> *</label>
						<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
							<input type="hidden" value="<?php echo $query_data[0]['primary_key']; ?>" name="student_query_id"/>
							<textarea name="reply" required style="width:100%;height:250px;"></textarea>
						</div>
					</div>
					
				</div><!-- /.box-body --> 
				<div class="box-footer">
				 	<div class="form-group">
			        	<div class="col-sm-12 text-center">
			        		 <input name="submit" type="submit" class="btn btn-warning btn-lg" value="<?php echo $this->lang->line('save');?>"/>         
               				 <input type="button" class="btn btn-default btn-lg" value="<?php echo $this->lang->line('cancel');?>" onclick='goBack("admin_student/student_queries",0)'/>
			        	</div>
			        </div>        
			    </div><!-- /.box-footer --> 
			</div><!-- /.box-info --> 
		</form>
	</section>
</section>
