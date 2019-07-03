<section class="content-header">
   <section class="content">
     	<div class="box box-info custom_box">
	    	<div class="box-header">
	         <h3 class="box-title"><i class="fa fa-cloud-upload"></i> <?php echo $this->lang->line('upload material');?></h3>
	        </div><!-- /.box-header -->
	       	<!-- form start -->
		    <form class="form-horizontal" enctype="multipart/form-data" action="<?php echo site_url().'teacher/upload_material_action';?>" method="POST">
		        <div class="box-body">
		           	<div class="form-group">
			            <label class="col-sm-3 control-label"><?php echo $this->lang->line('session');?> *    	</label>
		               	<div class="col-sm-9 col-md-6 col-lg-6">
			                <?php 
			                  $session_info['']=$this->lang->line('session');                     
			                  echo form_dropdown('session_id',$session_info,"",'class="form-control" required id="financial_year_id" onchange="get_course()"'); 
			                ?>
		                </div>
	            	</div>
	            	<div class="form-group">
			            <label class="col-sm-3 control-label"><?php echo $this->lang->line('class');?> *    	</label>
		               	<div class="col-sm-9 col-md-6 col-lg-6">
			                <?php 
			                  $class_info['']=$this->lang->line('class');                     
			                  echo form_dropdown('class_id',$class_info,"",'class="form-control" required id="s_class_id" onchange="get_course()"'); 
			                ?>
		                </div>
	            	</div>
	            	<div class="form-group">
			            <label class="col-sm-3 control-label"><?php echo $this->lang->line('group/ dept.');?> *    	</label>
		               	<div class="col-sm-9 col-md-6 col-lg-6" id="search_dept">
			                <?php 
			                  $dept_info['']=$this->lang->line('group/ dept.');                     
			                  echo form_dropdown('dept_id',$dept_info,"",'class="form-control" required id="department_id"'); 
			                ?>
		                </div>
	            	</div>

		            <!-- <div class="form-group">
						<label class="col-sm-3 control-label"><?php //echo $this->lang->line('course');?> *</label>
						<div class="col-sm-9 col-md-6 col-lg-6" id="search_courses">	
							<?php 
			                  //$dept_info['']=$this->lang->line('courses');                     
			                  //echo form_dropdown('course_id',$course_info,"",'class="form-control" required id="department_id"'); 
			                ?>					
						</div>
					</div> -->

		           <div class="form-group">
		             	<label class="col-sm-3 control-label"><?php echo $this->lang->line('topics');?> *    	</label>
	             		<div class="col-sm-9 col-md-6 col-lg-6">
	               			<input name="title" class="form-control" required type="text" id="title"/>  
	             		</div>
		           </div> 

		           <div class="form-group">
		             	<label class="col-sm-3 control-label"><?php echo $this->lang->line('material');?> *    	</label>
	             		<div class="col-sm-9 col-md-6 col-lg-6">
	               			<input name="document_url" class="form-control" required type="file" id="document_url"/>  
	             		</div>
		           </div> 

		               
		           </div> <!-- /.box-body --> 

		           	<div class="box-footer">
		            	<div class="form-group">
		             		<div class="col-sm-12 text-center">
		               			<input name="submit" type="submit" class="btn btn-warning btn-lg" value=<?php echo $this->lang->line("save");?>>  
		              			<input type="button" class="btn btn-default btn-lg" value=<?php echo $this->lang->line("cancel");?> onclick='goBack("teacher/course_materials",0)'/>  
		             		</div>
		           		</div>
		         	</div><!-- /.box-footer -->         
		        </div><!-- /.box-info -->       
		    </form>     
     	</div>
   </section>
</section>


<script type="text/javascript">
	function get_course(){
		var class_id = $("#s_class_id").val();
		var dept_id = $("#department_id").val();
		var session_id = $("#financial_year_id").val();

		if(dept_id == '' && class_id != ''){
			var url = "<?php echo base_url('teacher/ajax_get_dept_based_on_class');?>";
			$.ajax({
				url: url, 
				type: 'POST',  
				data: {class_id:class_id}, 
				async: false, cache: false, 
				success: function (response){
					$('#search_dept').html(response);
				}
			});
		}

		if(class_id != '' && dept_id != '' && session_id != ''){
			var url = "<?php echo base_url('teacher/ajax_get_student_course');?>";
			$.ajax({
				url: url, 
				type: 'POST',  
				data: {class_id:class_id,dept_id:dept_id,session_id:session_id}, 
				async: false, cache: false, 
				success: function (response){
					$('#search_courses').html(response);
				}
			});
		}
	}
	
</script>



