
<div class="container-fluid">
	<br/>
	<div class="row">
		<div class="col-md-3 col-lg-3 col-sm-12 col-xs-12 text-center">
			<?php if($teacher_info['image']=='' && $teacher_info['gender']=="Male") $image=base_url('assets/images/avatar/boy.png');
			else if($teacher_info['image']=='' && $teacher_info['gender']=="Female") $image=base_url('assets/images/avatar/girl.png');
			else $image=base_url('upload/teacher').'/'.$teacher_info['image']; ?>			
			<img class="img img-thumbnail" style="width:250px; height:275px" src="<?php echo $image; ?>"><h3 class="text-center" style="font-family:'Cooper Black'"><?php echo $teacher_info['teacher_name']; ?></h3>
			<h4 class="text-center gray"><?php echo $this->lang->line('teacher id');?>: <?php echo $teacher_info['teacher_no']; ?></h4>
			<h4 class="text-center"><i class="fa fa-street-view "></i> <?php echo $teacher_info['rank_name']; ?></h4>
			
		</div>
		<div class="col-md-9 col-lg-9 col-sm-12 col-xs-12">
		
			<div>

				<!-- Nav tabs -->
				<ul class="nav nav-tabs" role="tablist">
					<li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab"><i class="fa fa-th-large"></i> <?php echo $this->lang->line('basic');?></a></li>
					<li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab"><i class="fa fa-graduation-cap"></i> <?php echo $this->lang->line('education');?></a></li>
					<li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab"><i class="fa fa-user-plus"></i> <?php echo $this->lang->line('training');?></a></li>
					
				</ul>

				<div class="tab-content">
					<div role="tabpanel" class="tab-pane active" id="home">


						<div class="row">
							<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
								<blockquote>
									<p><i class="fa fa-birthday-cake"></i> <?php echo $this->lang->line('date of birth');?></p>
									<footer>
										<?php 
										if (isset($teacher_info['date_of_birth']))
										{									
											if ($teacher_info['date_of_birth']== "0000-00-00")  echo "";									
											else
											{								
												$time1 = strtotime($teacher_info['date_of_birth']);
												$myFormatForView1 = date("d/m/Y", $time1);										
												if (isset($myFormatForView1))  echo $myFormatForView1;										
											}
										}
										?>
									</footer>
								</blockquote>
							</div>
							<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
								<blockquote>
									<p><i class="fa fa-venus-mars"></i> <?php echo $this->lang->line('gender');?></p>
									<footer><?php echo $teacher_info['gender']; ?></footer>
								</blockquote>
							</div>
							<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
								<blockquote>
									<p><i class="fa fa-road"></i> <?php echo $this->lang->line('religion');?></p>
									<footer><?php echo $teacher_info['religion']; ?></footer>
								</blockquote>
							</div>
							<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
								<blockquote>
									<p><i class="fa fa-home"></i><?php echo $this->lang->line('home district');?></p>
									<footer><?php echo $teacher_info['district_name']; ?></footer>
								</blockquote>
							</div>
							<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
								<blockquote>
									<p><i class="fa fa-mobile-phone"></i> <?php echo $this->lang->line('mobile no.');?></p>
									<footer><?php echo $teacher_info['mobile']; ?></footer>
								</blockquote>
							</div>
							<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
								<blockquote>
									<p><i class="fa fa-envelope"></i> <?php echo $this->lang->line('email');?></p>
									<footer><?php echo $teacher_info['email']; ?></footer>
								</blockquote>
							</div>

						</div>
						
					</div>
					 
					<div role="tabpanel" class="tab-pane" id="profile">
						<table class="table table-hover">
							<thead>
								<tr>
									<th><?php echo $this->lang->line('level');?></th>
									<th><?php echo $this->lang->line('institute name');?></th>
									<th><?php echo $this->lang->line('passing year');?></th>
									<th><?php echo $this->lang->line('result');?></th>
								</tr>
							</thead>
							<tbody>
								
									<?php 
										foreach ($teacher_education_info as $value)

										 {
										 	echo '<tr>';

										 	echo '<td>';
											echo $value['level'];
											echo '</td>';

											echo '<td>';
											echo $value['institute'];
											echo '</td>';

											echo '<td>';
											echo $value['duration'];
											echo '</td>';

											echo '<td>';
											echo $value['result'];
											echo '</td>';

											echo '</tr>';
										 }
									 ?>
								
								
							</tbody>
						</table>
					</div>
					<div role="tabpanel" class="tab-pane" id="messages">
						<table class="table table-hover">
							<thead>
								<tr>
									<th><?php echo $this->lang->line('training name');?></th>
									<th><?php echo $this->lang->line('institute name');?></th>
									<th><?php echo $this->lang->line('duration');?></th>
									<th><?php echo $this->lang->line('result');?></th>
								</tr>
							</thead>
							<tbody>
								
									<?php 
										foreach ($teacher_training_info as $value)

										 {
										 	echo '<tr>';

										 	echo '<td>';
											echo $value['training_name'];
											echo '</td>';

											echo '<td>';
											echo $value['institute_name'];
											echo '</td>';

											echo '<td>';
											echo $value['duration'];
											echo '</td>';

											echo '<td>';
											echo $value['remarks'];
											echo '</td>';

											echo '</tr>';
										 }
									 ?>
								
								
							</tbody>
						</table>

					 </div>
					
				</div>
		
		</div>
	

	
		</div>
	</div>

</div>
