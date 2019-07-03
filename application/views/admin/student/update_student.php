<section class="content-header">
	<section class="content">
		<div class="box box-info custom_box">
			<div class="box-header">
				<h3 class="box-title"><i class="fa fa-plus-circle"></i> <?php echo $this->lang->line("edit student's information");?></h3>
			</div><!-- /.box-header -->
			<?php
			
				if($this->session->flashdata('student_added'))
					echo '<div class="alert alert-success text-center" id="added_flash"><h1>'.$this->session->flashdata('student_added').'</h1></div>';
				if($this->session->flashdata('error_message'))
					echo '<div class="alert alert-danger text-center" id="added_flash"><h1>',$this->lang->line('An error occured'),'!!!</h1></div>';
				if($this->session->flashdata('upload_error'))
					echo '<div class="alert alert-danger text-center" id="added_flash">'.$this->session->flashdata('upload_error').'</h1></div>';
			?>
			<form method="POST" enctype="multipart/form-data" action="<?php echo site_url('admin_student/edit_student_profile_action'); ?>" class="form-horizontal">
				<div class="box-body">
					<div class="form-group">
						<label for="student_name" class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label"><?php echo $this->lang->line('name');?> *</label>
						<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
							<input required type="text" class="form-control" id="student_name" name="student_name" value="<?php echo $student_info[0]['name']; ?>" placeholder='<?php echo $this->lang->line("student's Name");?>' />
							<span class="red"><?php echo form_error('student_name'); ?></span>
						</div>
					</div>

					<div class="form-group">
						<label for="student_email" class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label"><?php echo $this->lang->line('email');?></label>
						<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
							<input type="email" class="form-control" id="student_email" name="student_email" value="<?php echo $student_info[0]['email']; ?>"  placeholder="Student's Email" />
							<span class="red"><?php echo form_error('student_email'); ?></span>
						</div>
					</div>

					<div class="form-group">
						<label for="student_mobile" class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label"><?php echo $this->lang->line('mobile no.');?></label>
						<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
							<input type="text" class="form-control" id="student_mobile" name="student_mobile" value="<?php echo $student_info[0]['mobile']; ?>" placeholder="Student's Mobile" />
							<span class="red"><?php echo form_error('student_mobile'); ?></span>
						</div>
					</div>

					<div class="form-group">
						<label for="date_of_birth" class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label"><?php echo $this->lang->line('date of birth');?></label>
						<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
							<input type="text" class="form-control" id="date_of_birth" name="date_of_birth" value="<?php echo date('d-m-Y',strtotime($student_info[0]['birth_date'])); ?>" placeholder="Student's date of birth" />
							<span class="red"><?php echo form_error('date_of_birth'); ?></span>
						</div>
					</div>

					<div class="form-group">
						<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label"><?php echo $this->lang->line('gender');?> *</label>
						<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
							<label class="radio-inline">
							 <input type="radio" name="gender" value="male" <?php if($student_info[0]['gender'] === 'Male') echo 'checked'; ?> ><?php echo $this->lang->line('Male');?>
							</label>
							<label class="radio-inline">
							 <input type="radio" name="gender" value="female" <?php if($student_info[0]['gender'] === 'Female') echo 'checked'; ?> ><?php echo $this->lang->line('Female');?>
							</label>
							<span class="red"><?php echo form_error('gender'); ?></span>
						</div>
					</div>

					<div class="form-group">
						<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label"><?php echo $this->lang->line('religion');?> *</label>
						<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
							<?php 
				              $religion['']="Religion";
				              echo form_dropdown('religion',$religion,$student_info[0]['religion'],'class="form-control" id="religion"');  
				            ?>               
				            <span class="red"><?php echo form_error('religion'); ?></span>
						</div>
					</div>

					<div class="form-group">
						<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label"><?php echo $this->lang->line('attach photo');?></label>
						<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
							<img src="<?php echo base_url()."upload/student/".$student_info[0]['image']; ?>" alt="No photo given" height="130px" width="110px"/>
							<br/>
							<?php echo form_upload('userfile'); ?>
							<span class="red"><?php echo form_error('userfile'); ?></span></p><?php echo $this->lang->line('max: 250kb, jpg/png');?>
						</div>
					</div>

					<div class="form-group">
						// <label for="father_of_student" class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label"><?php echo $this->lang->line("father's name");?> *</label>
						<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
							<input required type="text" class="form-control" id="father_of_student" name="father_of_student" value="<?php echo $student_info[0]['father_name']; ?>" placeholder="Father's Name" />
							<span class="red"><?php echo form_error('father_of_student'); ?></span>
						</div>
					</div>

					<div class="form-group">
						// <label for="mother_of_student" class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label"><?php echo $this->lang->line("mother's name");?> *</label>
						<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
							<input required type="text" class="form-control" id="mother_of_student" name="mother_of_student" value="<?php echo $student_info[0]['mother_name']; ?>" placeholder="Mother's Name" />
							<span class="red"><?php echo form_error('mother_of_student'); ?></span>
						</div>
					</div>

					<div class="form-group">
						// <label for="gurdian_of_student" class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label"><?php echo $this->lang->line("gurdian's name");?> *</label>
						<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
							<input required type="text" class="form-control" id="gurdian_of_student" name="gurdian_of_student" value="<?php echo $student_info[0]['gurdian_name']; ?>" placeholder="Student gurdian's Name" />
							<span class="red"><?php echo form_error('gurdian_of_student'); ?></span>
						</div>
					</div>

					<div class="form-group">
						// <label for="relation_with_student" class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label"><?php echo $this->lang->line("relation with student");?> *</label>
						<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
							<input required type="text" class="form-control" id="relation_with_student" name="relation_with_student" value="<?php echo $student_info[0]['gurdian_relation']; ?>" placeholder="Gurdian's relation with student" />
							<span class="red"><?php echo form_error('relation_with_student'); ?></span>
						</div>
					</div>

					<div class="form-group">
						<label for="gurdian_mobile" class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label"><?php echo $this->lang->line("gurdian mobile no.");?></label>
						<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
							<input required type="text" class="form-control" id="gurdian_mobile" name="gurdian_mobile" value="<?php echo $student_info[0]['gurdian_mobile']; ?>" placeholder="Gurdian's Mobile No." />
							<span class="red"><?php echo form_error('gurdian_mobile'); ?></span>
						</div>
					</div>

					<div class="form-group">
						<label for="gurdian_email" class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label"><?php echo $this->lang->line("gurdian email");?></label>
						<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
							<input type="email" class="form-control" id="gurdian_email" name="gurdian_email" value="<?php echo $student_info[0]['gurdian_email']; ?>"  placeholder="Gurdian's Email" />
							<span class="red"><?php echo form_error('gurdian_email'); ?></span>
						</div>
					</div>

					<div class="form-group">
						<label for="financial_year_id" class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label"><?php echo $this->lang->line("session");?> *</label>
						<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
							<?php 
					           $session_info['']=$this->lang->line("session");
					           echo form_dropdown('financial_year_id',$session_info,$student_info[0]['session_id'],'class="form-control" id="financial_year_id" required="required" onchange="get_course()"'); 
					        ?>
						</div>
						<span class="red"><?php echo form_error('financial_year_id'); ?></span>
					</div>


					<div class="form-group">
						<label for="s_class_id" class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label"><?php echo $this->lang->line('class');?> *</label>
						<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
							<?php 
				              $class_info['']=$this->lang->line('class');                    
				              echo form_dropdown('class_id',$class_info,$student_info[0]['class_id'],'class="form-control" id="s_class_id" required="required" onchange="get_course()"'); 
				            ?>
						</div>
						<span class="red"><?php echo form_error('class_id'); ?></span>
					</div>

					<div class="form-group">
						<label for="department_id" class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label"><?php echo $this->lang->line('group / dept.');?> *</label>
						<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8" id="search_dept">
							<?php 
				              $dept_info['']=$this->lang->line('group / dept.');                   
				              echo form_dropdown('dept_id',$dept_info,$student_info[0]['dept_id'],'class="form-control" id="department_id" required="required"'); 
				            ?>
						</div>
						<span class="red"><?php echo form_error('dept_id'); ?></span>
					</div>
					

					<!-- hidden field for getting course -->
					<input type="hidden" id="h_dept_id" value="<?php echo $student_info[0]['dept_id']; ?>">
					<input type="hidden" id="h_class_id" value="<?php echo $student_info[0]['class_id']; ?>">
					<input type="hidden" id="h_session_id" value="<?php echo $student_info[0]['session_id']; ?>">
					<input type="hidden" id="h_id" name="student_id" value="<?php echo $student_info[0]['id']; ?>">
					<!-- end of hidden field for getting course -->


					<div class="form-group">
						// <label for="student_courses" class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label"><?php echo $this->lang->line('Courses');?> *</label>
						<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8" id="search_courses">
							
						</div>
					</div>

					<div class="form-group">
						// <label for="shift_id" class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label"><?php echo $this->lang->line('Shift');?> *</label>
						<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
							<?php 
				              $shift_info['']= $this->lang->line('shift');
				              echo form_dropdown('shift_id',$shift_info,$student_info[0]['shift_id'],'class="form-control" id="shift_id"'); 
				            ?>
						</div>
						<span class="red"><?php echo form_error('shift_id'); ?></span>
					</div>

					<div class="form-group">
						<label for="section_id" class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label"><?php echo $this->lang->line('section');?> *</label>
						<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
							<?php 
				              $section_info['']=$this->lang->line('section');
				              echo form_dropdown('section_id',$section_info,$student_info[0]['section_id'],'class="form-control" id="section_id"'); 
				            ?>
						</div>
						<span class="red"><?php echo form_error('section_id'); ?></span>
					</div>

				</div><!-- /.box-body --> 
				<div class="box-footer">
				 	<div class="form-group">
			        	<div class="col-sm-12 text-center">
			        		<input name="submit" type="submit" class="btn btn-warning btn-lg" value="<?php echo $this->lang->line('save');?>"/>       
               				<input type="button" class="btn btn-default btn-lg" value="<?php echo $this->lang->line('cancel');?>" onclick='goBack("admin_student/index",0)'/>
			        	</div>
			        </div>        
			    </div><!-- /.box-footer --> 
			</div><!-- /.box-info --> 
		</form>
	</section>
</section>
<script type="text/javascript">
	function get_course(){
		var class_id = $("#s_class_id").val();
		var dept_id = $("#department_id").val();
		var session_id = $("#financial_year_id").val();

		if(dept_id == '' && class_id != ''){
			var url = "<?php echo base_url('admin_student/get_dept_based_on_class');?>";
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
			var url = "<?php echo base_url('admin_student/get_student_course');?>";
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


	$j("document").ready(function(){
		var class_id = $("#s_class_id").val();
		var h_dept_id = $("#h_dept_id").val();
		var h_class_id = $("#h_class_id").val();
		var h_session_id = $("#h_session_id").val();
		var h_id = $("#h_id").val();

		
		var url = "<?php echo base_url('admin_student/get_course_for_edit_student');?>";
		$.ajax({
			url: url, 
			type: 'POST',  
			data: {class_id:h_class_id,dept_id:h_dept_id,session_id:h_session_id,id:h_id}, 
			async: false, cache: false, 
			success: function (response){
				$('#search_courses').html(response);
			}
		});
		

		if(class_id != ''){
			var url = "<?php echo base_url('admin_student/get_dept_for_student_edit');?>";
			$.ajax({
				url: url, 
				type: 'POST',  
				data: {class_id:class_id,dept_id:h_dept_id}, 
				async: false, cache: false, 
				success: function (response){
					$('#search_dept').html(response);
				}
			});
		}

		var todate="<?php echo date('Y');?>";
	    var from=todate-70;
	    var to=todate-12;
	    var str=from+":"+to;
	 	$('#date_of_birth').datepicker({format: "dd-mm-yyyy",changeMonth:true, changeYear:true,yearRange: str, startView: "decade" });

		$("#search_primary_button").click(function(){
	      $("#search_primary_ul").toggle();
	    });
		$("#search_primary_done").click(function(){
	      $("#search_primary_ul").hide();
	    });

	    $('#added_flash').fadeOut(6000);

	});
	
</script>