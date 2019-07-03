<style>label{padding-top:0 !important;}</style>
<section class="content-header">
	<section class="content">
		<div class="box box-info custom_box">
			<div class="box-header">
				<h3 class="box-title"><i class="fa fa-binoculars"></i> <?php echo $this->lang->line('deatils notification');?></h3>
			</div><!-- /.box-header -->
			<form  class="form-horizontal">
				<div class="box-body">					
					<div class="form-group">
						<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label"><?php echo $this->lang->line('subject');?></label>
						<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 text-justify">
							<?php echo $query_data[0]['title']; ?>
						</div>
					</div>
					<hr/>
					<div class="form-group">
						<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label"><?php echo $this->lang->line('message');?></label>
						<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 text-justify">
							<i class="fa fa-clock-o"></i><b><?php echo $query_data[0]['sent_at'];?></b><br/>
							<?php echo $query_data[0]['message']; ?>
						</div>
					</div>
					<hr/>
					<div class="form-group">
						<label for="student_name" class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label"><?php echo $this->lang->line('type');?></label>
						<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
							<?php echo $query_data[0]['type']; ?>
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
