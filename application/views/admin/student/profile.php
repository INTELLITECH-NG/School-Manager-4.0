
<style >
	.own{
		height:40px;padding-top: 8px;border: 0px solid #000000; background: rgba(255,255,255,1);background: -moz-linear-gradient(top, rgba(255,255,255,1) 0%, rgba(255,255,255,1) 17%, rgba(246,246,246,1) 43%, rgba(239,239,239,1) 89%, rgba(237,237,237,1) 100%);
		background: -webkit-gradient(left top, left bottom, color-stop(0%, rgba(255,255,255,1)), color-stop(17%, rgba(255,255,255,1)), color-stop(43%, rgba(246,246,246,1)), color-stop(89%, rgba(239,239,239,1)), color-stop(100%, rgba(237,237,237,1)));
		background: -webkit-linear-gradient(top, rgba(255,255,255,1) 0%, rgba(255,255,255,1) 17%, rgba(246,246,246,1) 43%, rgba(239,239,239,1) 89%, rgba(237,237,237,1) 100%);
		background: -o-linear-gradient(top, rgba(255,255,255,1) 0%, rgba(255,255,255,1) 17%, rgba(246,246,246,1) 43%, rgba(239,239,239,1) 89%, rgba(237,237,237,1) 100%);
		background: -ms-linear-gradient(top, rgba(255,255,255,1) 0%, rgba(255,255,255,1) 17%, rgba(246,246,246,1) 43%, rgba(239,239,239,1) 89%, rgba(237,237,237,1) 100%);
		background: linear-gradient(to bottom, rgba(255,255,255,1) 0%, rgba(255,255,255,1) 17%, rgba(246,246,246,1) 43%, rgba(239,239,239,1) 89%, rgba(237,237,237,1) 100%);
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#ededed', GradientType=0 );

	}
</style>


<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12 own">
			<center><strong class="text-info" style="font-family:'Cooper Black'; font-size:20px"><i class="fa fa-user"></i><?php echo $this->lang->line('student profile');?></strong></center>
		</div>
	</div>
	<br/>
	<!-- setting variables -->
	<div class="row">
		<div class="col-md-3 col-lg-3 col-sm-12 col-xs-12 text-center">
		    <?php if($info[0]['image']=='' && $info[0]['gender']=="Male") $image=base_url('assets/images/avatar/boy.png');
			else if($info[0]['image']=='' && $info[0]['gender']=="Female") $image=base_url('assets/images/avatar/girl.png');
			else $image=base_url('upload/student').'/'.$info[0]['image']; ?>
			<img class="img img-thumbnail" style="width:250px; height:275px" src="<?php echo $image; ?>">
			<h3 class="text-center" style="font-family:'Cooper Black'"><?php if(isset($info[0]['name'])) echo "{$info[0]['name']}"; ?></h3>
			<h4 class="text-center gray"><?php echo $this->lang->line('student id');?>: <?php if(isset($info[0]['student_id'])) echo "{$info[0]['student_id']}"; ?></h4>

		</div>

		<div class="col-md-9 col-lg-9 col-sm-12 col-xs-12">

			<div>

				<!-- Nav tabs -->
				<ul class="nav nav-tabs" role="tablist">
					<li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab"><i class="fa fa-th-large"></i> <?php echo $this->lang->line('basic info');?></a></li>
					<li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab"><i class="fa fa-graduation-cap"></i> <?php echo $this->lang->line('gurdian info');?></a></li>
					<li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab"><i class="fa fa-user-plus"></i> <?php echo $this->lang->line('academic info');?></a></li>

				</ul>

				<!--tab one -->

				<div class="tab-content">
					<div role="tabpanel" class="tab-pane active" id="home">
						<div class="row">
							<div class="col-xs-6 col-sm-6 col-md-3 col-lg-6">
								<blockquote>
									<p><i class="fa fa-home"></i><?php echo $this->lang->line('name');?> </p>
									<footer><?php if(isset($info[0]['name'])) echo "{$info[0]['name']}"; ?></footer>
								</blockquote>
							</div>

							
							<div class="col-xs-6 col-sm-6 col-md-3 col-lg-6">
								<blockquote>
									<p><i class="fa fa-mobile-phone"></i> <?php echo $this->lang->line('father name');?></p>
									<footer><?php if(isset($info[0]['father_name'])) echo "{$info[0]['father_name']}"; ?></footer>
								</blockquote>
							</div>

						

							<div class="col-xs-6 col-sm-6 col-md-3 col-lg-6">
								<blockquote>
									<p><i class="fa fa-envelope"></i> <?php echo $this->lang->line('mother name');?></p>
									<footer><?php if(isset($info[0]['mother_name'])) echo "{$info[0]['mother_name']}"; ?></footer>
								</blockquote>
							</div>

							

							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
								<blockquote>
									<p><i class="fa fa-envelope"></i> <?php echo $this->lang->line('student email');?></p>
									<footer><?php if(isset($info[0]['email'])) echo "{$info[0]['email']}"; ?></footer>
								</blockquote>

								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
									<blockquote>
										<p><i class="fa fa-envelope"></i> <?php echo $this->lang->line('student mobile');?></p>
										<footer><?php if(isset($info[0]['mobile'])) echo "{$info[0]['mobile']}"; ?></footer>
									</blockquote>
								</div>
							</div>
						</div> <!-- end row -->
					</div>	<!-- end tab panel -->					

					<!-- tab one close -->

					<!-- tab 2 start -->

					<div role="tabpanel" class="tab-pane" id="profile">						

						<div class="row">

							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
								<blockquote>
									<p><i class="fa fa-birthday-cake"></i> <?php echo $this->lang->line('gurdian name');?></p>
									<footer><?php if(isset($info[0]['gurdian_name'])) echo "{$info[0]['gurdian_name']}"; ?></footer>
								</blockquote>
							</div>

							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
								<blockquote>
									<p><i class="fa fa-venus-mars"></i> <?php echo $this->lang->line('relation');?></p>
									<footer><?php  if(isset($info[0]['gurdian_relation'])) echo "{$info[0]['gurdian_relation']}"; ?></footer>
								</blockquote>
							</div>

							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<blockquote>
									<p><i class="fa fa-venus-mars"></i> <?php echo $this->lang->line('gurdian present address');?></p>
									<footer>

										<?php 

										if (isset($info[0]['gurdian_present_village']) && isset($info[0]['gurdian_present_post'])
											&& isset($info[0]['gurdian_present_thana']) && isset($info[0]['gurdian_present_district']))
										{
											echo
											"{$info[0]['gurdian_present_village']}".
											", ".
											"{$info[0]['gurdian_present_post']}".
											", ".
											"{$info[0]['gurdian_present_thana']}".
											", ".
											"{$info[0]['gurdian_present_district']}"
											; 
										}										 
										?>
									</footer>
								</blockquote>
							</div>

							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<blockquote>
									<p>
										<i class="fa fa-venus-mars">											
										</i>
										<?php echo $this->lang->line('gurdian permanent address');?>
									</p>
									<footer>
										<?php
										if (isset($info[0]['gurdian_permanent_village']) && isset($info[0]['gurdian_permanent_post'])
											&& isset($info[0]['gurdian_permanent_thana']) && isset($info[0]['gurdian_permanent_district']))
										{
											echo
											"{$info[0]['gurdian_permanent_village']}".
											", ".
											"{$info[0]['gurdian_permanent_post']}".
											", ".
											"{$info[0]['gurdian_permanent_thana']}".
											", ".
											"{$info[0]['gurdian_permanent_district']}"
											;
										}  
										?>
									</footer>
								</blockquote>
							</div>

							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<blockquote>
									<p>
										<i class="fa fa-venus-mars">
										</i> 
										<?php echo $this->lang->line('gurdian mobile no.')?></p>
										<footer>
											<?php if(isset($info[0]['gurdian_mobile'])) echo "{$info[0]['gurdian_mobile']}"; ?>
										</footer>
									</blockquote>
								</div>
								<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
									<blockquote>
										<p>
											<i class="fa fa-venus-mars">
											</i> 
											<?php echo $this->lang->line('gurdian mobile no.');?></p>
											<footer>
												<?php if(isset($info[0]['gurdian_email'])) echo "{$info[0]['gurdian_email']}"; ?>
											</footer>
										</blockquote>
									</div>
								</div> 
					</div>
					<!-- tab 2 closes -->

					<!-- tab three starts -->	
					<div role="tabpanel" class="tab-pane" id="messages">

						<div class="row">

							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
								<blockquote>
									<p>
										<i class="fa fa-birthday-cake">
										</i> 
										<?php echo $this->lang->line('class');?>
									</p>
									<footer><?php if(isset($info[0]['class_name'])) echo "{$info[0]['class_name']}"; ?></footer>
								</blockquote>
							</div>

							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
								<blockquote>
									<p>
										<i class="fa fa-venus-mars">
										</i> 
										<?php echo $this->lang->line('department');?>
									</p>
									<footer><?php if(isset($info[0]['dept_name'])) echo "{$info[0]['dept_name']}"; ?></footer>
								</blockquote>
							</div>

							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
								<blockquote>
									<p>
										<i class="fa fa-road">
										</i>  
										<?php echo $this->lang->line('section');?>
									</p>
									<footer><?php if(isset($info[0]['section_name'])) echo "{$info[0]['section_name']}"; ?></footer>
								</blockquote>
							</div>

							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
								<blockquote>
									<p>
										<i class="fa fa-home">
										</i> 
										<?php echo $this->lang->line('shift');?></p>
										<footer><?php if(isset($info[0]['shift_name'])) echo "{$info[0]['shift_name']}"; ?></footer>
								</blockquote>
							</div>

							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
								<blockquote>
								<p>
									<i class="fa fa-mobile-phone">
									</i> 
									<?php echo $this->lang->line('session');?></p>
									<footer><?php if(isset($info[0]['session_name']))  echo "{$info[0]['session_name']}"; ?>
									</footer>
								</blockquote>
							</div>

							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
								<blockquote>
									<p>
									<i class="fa fa-envelope">
									</i> 
									<?php echo $this->lang->line('exam version');?></p>
									<footer><?php if(isset($info[0]['exam_version'])) echo "{$info[0]['exam_version']}"; ?>
									</footer>
								</blockquote>
							</div>

							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
								<blockquote>
									<p>
										<i class="fa fa-envelope">
										</i> 
										<?php echo $this->lang->line('course');?>
									</p>
									<footer><?php if(isset($info[0]['courses'])) 
													{	
														$z = $info[0]["courses"];														
														echo str_replace("__", ",", $z);
													} 
													?>
									</footer>
								</blockquote>
							</div>

							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
								<blockquote>
									<p>
									<i class="fa fa-envelope">
									</i> 
									<?php echo $this->lang->line('Roll');?></p>
									<footer><?php if(isset($info[0]['class_roll'])) echo "{$info[0]['class_roll']}"; ?>
									</footer>
								</blockquote>
							</div>
						</div> <!-- END ROW -->
					</div>	<!-- end tab panel -->
				</div> <!-- end tab content -->
			</div>
		</div>
	</div>
</div>



