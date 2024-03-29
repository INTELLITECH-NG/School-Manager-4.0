<style>label{padding-top:0 !important;}</style>
<section class="content-header">
	<section class="content">
		<div class="box box-info custom_box">
			<div class="box-header">
				<h3 class="box-title"><i class="fa fa-binoculars"></i> <?php echo $this->lang->line('deatils query/ complain');?></h3>
			</div><!-- /.box-header -->
			<form  class="form-horizontal">
				<div class="box-body">					
					<div class="form-group">
						<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label"><?php echo $this->lang->line('subject');?></label>
						<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 text-justify">
							<?php if(isset($query_data[0]['message_subject'])) echo $query_data[0]['message_subject']; ?>
						</div>
					</div>
					<hr/>
					<div class="form-group">
						<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label"><?php echo $this->lang->line('query/ complain');?></label>
						<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 text-justify">
							<i class="fa fa-clock-o"></i><b><?php if(isset($query_data[0]['sent_at'])) echo $query_data[0]['sent_at'];?></b><br/>
							<?php echo $query_data[0]['message_body']; ?>
						</div>
					</div>
					<hr/>
					<div class="form-group">
						<label for="student_name" class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label"><?php echo $this->lang->line('reply message');?></label>
						<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
							<?php 
								if($query_data[0]['replied']=="1")
								echo  '<i class="fa fa-clock-o"></i>'."<b>".$query_data[0]['reply_at']."</b><br/>".$query_data[0]['reply_message']; 
								else echo "<span class='label label-warning'>",$this->lang->line('not replied yet'),"</span>";
							?>
						</div>
					</div>
					
				</div><!-- /.box-body --> 
				<div class="box-footer">
				 	<br/>        
			    </div><!-- /.box-footer --> 
			</div><!-- /.box-info --> 
		</form>
	</section>
</section>
