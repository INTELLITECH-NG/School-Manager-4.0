<style>
	.top_menu{margin-bottom:5px;width:180px;}
</style>

<div class="container-fluid">
	<!-- setting variables -->	
	<br/>
	<br>
	<div class="row">
		<div class="col-md-3 col-lg-3 col-sm-12 col-xs-12 text-center">
		    <?php if($info[0]['image']=='' && $info[0]['gender']=="Male") $image=base_url('assets/images/avatar/boy.png'); 
			else if($info[0]['image']=='' && $info[0]['gender']=="Female") $image=base_url('assets/images/avatar/girl.png');
			else $image=base_url('upload/applicant').'/'.$info[0]['image']; ?>
			<img class="img img-thumbnail img-circle" style="width:250px !important; height:250px !important" src="<?php echo $image; ?>">
			<h3 class="text-center" style="font-family:'Cooper Black'"><b><?php if(isset($info[0]['name'])) echo "{$info[0]['name']}"; ?></b></h3>
			<br/>
			<h4><b><?php echo $this->lang->line('applicant id');?> : <?php if(isset($info[0]['id'])) echo "{$info[0]['id']}"; ?></b></h4>
			<h4><b><?php echo $this->lang->line('admission roll');?> : <?php if(isset($info[0]['admission_roll'])) echo "{$info[0]['admission_roll']}"; ?></b></h4>
			<br/><br/>
			

		</div>

		<div class="col-md-9 col-lg-9 col-sm-12 col-xs-12">

			<div>

				<!-- Nav tabs -->
				<ul class="nav nav-tabs" role="tablist">
					<li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab"><i class="fa fa-user"></i> <?php echo $this->lang->line('basic info');?></a></li>
					<li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab"><i class="fa fa-user-plus"></i> <?php echo $this->lang->line('gurdian info');?></a></li>
					<li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab"><i class="fa fa-graduation-cap"></i> <?php echo $this->lang->line('academic info');?></a></li>

				</ul>

				<!--tab one -->

				<div class="tab-content">
					<div role="tabpanel" class="tab-pane active" id="home">
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
								<blockquote>
									<p><i class="fa fa-user"></i> <?php echo $this->lang->line('name');?></p>
									<footer><?php if(isset($info[0]['name'])) echo "{$info[0]['name']}"; ?></footer>
								</blockquote>
							</div>

							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
								<blockquote>
									<p><i class="fa fa-user"></i> <?php echo $this->lang->line('name(bangla)');?></p>
									<footer><?php if(isset($info[0]['name_bangla'])) echo "{$info[0]['name_bangla']}"; ?></footer>
								</blockquote>
							</div>
						</div>

						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
								<blockquote>
									<p><i class="fa fa-male"></i> <?php echo $this->lang->line('father name');?></p>
									<footer><?php if(isset($info[0]['father_name'])) echo "{$info[0]['father_name']}"; ?></footer>
								</blockquote>
							</div>

							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
								<blockquote>
									<p><i class="fa fa-male"></i> <?php echo $this->lang->line('father name(bangla)');?></p>
									<footer><?php if(isset($info[0]['father_name_bangla']))  echo "{$info[0]['father_name_bangla']}"; ?></footer>
								</blockquote>
							</div>
						</div>

						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
								<blockquote>
									<p><i class="fa fa-female"></i> <?php echo $this->lang->line('mother name');?></p>
									<footer><?php if(isset($info[0]['mother_name'])) echo "{$info[0]['mother_name']}"; ?></footer>
								</blockquote>
							</div>

							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
								<blockquote>
									<p><i class="fa fa-female"></i> <?php echo $this->lang->line('mother name(bangla)');?></p>
									<footer><?php  if(isset($info[0]['mother_name_bangla'])) echo "{$info[0]['mother_name_bangla']}"; ?></footer>
								</blockquote>
							</div>
						</div>

						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
								<blockquote>
									<p><i class="fa fa-birthday-cake"></i> <?php echo $this->lang->line('date of birth');?></p>
									<footer><?php if(isset($info[0]['birth_date'])) echo date('d/m/Y',strtotime($info[0]['birth_date'])); ?></footer>
								</blockquote>
							</div>

							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
								<blockquote>
									<p><i class="fa  fa-sort-numeric-asc"></i> <?php echo $this->lang->line('birth certificate no.');?></p>
									<footer><?php if(isset($info[0]['birth_certificate_no'])) echo "{$info[0]['birth_certificate_no']}"; ?></footer>
								</blockquote>
							</div>
							
						</div> <!-- end row -->

						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
								<blockquote>
									<p><i class="fa fa-transgender"></i> <?php echo $this->lang->line('gender');?></p>
									<footer><?php if(isset($info[0]['gender'])) echo $info[0]['gender']; ?></footer>
								</blockquote>
							</div>

							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
								<blockquote>
									<p><i class="fa  fa-road"></i> <?php echo $this->lang->line('religion');?></p>
									<footer><?php if(isset($info[0]['religion'])) echo "{$info[0]['religion']}"; ?></footer>
								</blockquote>
							</div>
							
						</div> <!-- end row -->

						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
								<blockquote>
									<p><i class="fa fa-envelope"></i> <?php echo $this->lang->line('email');?></p>
									<footer><?php if(isset($info[0]['email'])) echo "{$info[0]['email']}"; ?></footer>
								</blockquote>
							</div>

							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
								<blockquote>
									<p><i class="fa fa-mobile-phone"></i> <?php echo $this->lang->line('mobile');?></p>
									<footer><?php if(isset($info[0]['mobile'])) echo "{$info[0]['mobile']}"; ?></footer>
								</blockquote>
							</div>
							
						</div> <!-- end row -->
					</div>	<!-- end tab panel -->					

					<!-- tab one close -->

					<!-- tab 2 start -->

					<div role="tabpanel" class="tab-pane" id="profile">						

						<div class="row">

							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
								<blockquote>
									<p><i class="fa fa-user"></i> <?php echo $this->lang->line('name');?></p>
									<footer><?php if(isset($info[0]['gurdian_name'])) echo "{$info[0]['gurdian_name']}"; ?></footer>
								</blockquote>
							</div>

							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
								<blockquote>
									<p><i class="fa fa-chain"></i> <?php echo $this->lang->line('relation');?></p>
									<footer><?php  if(isset($info[0]['gurdian_relation'])) echo "{$info[0]['gurdian_relation']}"; ?></footer>
								</blockquote>
							</div>

							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
								<blockquote>
									<p><i class="fa fa-certificate"></i> <?php echo $this->lang->line('occupation');?></p>
									<footer><?php if(isset($info[0]['gurdian_occupation'])) echo "{$info[0]['gurdian_occupation']}"; ?></footer>
								</blockquote>
							</div>

							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
								<blockquote>
									<p><i class="fa fa-money"></i> <?php echo $this->lang->line('yearly income (bdt.)');?></p>
									<footer><?php  if(isset($info[0]['gurdian_income'])) echo "{$info[0]['gurdian_income']}"; ?></footer>
								</blockquote>
							</div>							

							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<blockquote>
									<p>
										<i class="fa fa-mobile">
										</i> 
										<?php echo $this->lang->line('mobile no.');?></p>
										<footer>
											<?php if(isset($info[0]['gurdian_mobile'])) echo "{$info[0]['gurdian_mobile']}"; ?>
										</footer>
									</blockquote>
								</div>
								<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
									<blockquote>
										<p>
											<i class="fa fa-envelope">
											</i> 
											<?php echo $this->lang->line('email');?></p>
											<footer>
												<?php if(isset($info[0]['gurdian_email'])) echo "{$info[0]['gurdian_email']}"; ?>
											</footer>
									</blockquote>
								</div>

								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<blockquote>
										<p><i class="fa fa-anchor"></i> <?php echo $this->lang->line('present address');?></p>
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
											<i class="fa fa-home">											
											</i>
											 <?php echo $this->lang->line('permanent address');?>
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
							</div> 
					</div>
					<!-- tab 2 closes -->

					<!-- tab three starts -->	
					<div role="tabpanel" class="tab-pane" id="messages">

						<div class="row">

							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
								<blockquote>
									<p>
										<i class="fa  fa-th-large">
										</i> 
										<?php echo $this->lang->line('class');?>
									</p>
									<footer><?php if(isset($info[0]['class_name'])) echo "{$info[0]['class_name']}"; ?></footer>
								</blockquote>
							</div>

							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
								<blockquote>
									<p>
										<i class="fa  fa-building">
										</i> 
										<?php echo $this->lang->line('group/ department');?>
									</p>
									<footer><?php if(isset($info[0]['dept_name'])) echo "{$info[0]['dept_name']}"; ?></footer>
								</blockquote>
							</div>

					
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
								<blockquote>
									<p>
										<i class="fa fa-bell-o">
										</i> 
										<?php echo $this->lang->line('shift');?></p>
										<footer><?php if(isset($info[0]['shift_name'])) echo "{$info[0]['shift_name']}"; ?></footer>
								</blockquote>
							</div>

							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
								<blockquote>
								<p>
									<i class="fa fa-clock-o">
									</i> 
									<?php echo $this->lang->line('session');?></p>
									<footer><?php if(isset($info[0]['session_name']))  echo "{$info[0]['session_name']}"; ?>
									</footer>
								</blockquote>
							</div>

							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
								<blockquote>
									<p>
									<i class="fa fa-pencil-square-o">
									</i> 
									<?php echo $this->lang->line('exam version');?></p>
									<footer><?php if(isset($info[0]['exam_version'])) echo "{$info[0]['exam_version']}"; ?>
									</footer>
								</blockquote>
							</div>

							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
								<blockquote>
									<p>
									<i class="fa  fa-sort-numeric-asc">
									</i> 
									<?php echo $this->lang->line('admission roll');?></p>
									<footer><?php if(isset($info[0]['admission_roll'])) echo "{$info[0]['admission_roll']}"; ?>
									</footer>
								</blockquote>
							</div>

							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<blockquote>
									<p>
										<i class="fa fa-book">
										</i> 
										<?php echo $this->lang->line('course');?>
									</p>
									<footer><?php if(isset($info[0]['courses'])) echo "{$info[0]['courses']}"; ?></footer>
								</blockquote>
							</div>
							
						</div> <!-- END ROW -->
					</div>	<!-- end tab panel -->
				</div> <!-- end tab content -->
			</div>
		</div>
	</div>
</div>



<br/>