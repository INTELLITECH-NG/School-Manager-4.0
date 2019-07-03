<style>
	.top_menu{margin-bottom:5px;width:180px;}
</style>
<?php
  if( $admission_config['notice_for_applicant']!="" || $info[0]['is_in_merit_list']=="1")
  {
	  $str="";
	  if($admission_config['notice_for_applicant']!="")
	  $str.="<h5 class='no_margin no_padding'><div class='alert alert-warning text-center no_margin' style='padding:8px 0 !important;background:#FCF8E3 !important;color:#66512C !important;'><marquee><b>".$admission_config['notice_for_applicant']."</b></marquee>";
	  
	  if($info[0]['is_in_merit_list']=="1")
	  {
	    $congrats_message="<h4 style='margin:8px 0;' class='text-center'><b>Congratulations, ".$info[0]['name']." ! You are in merit list. You are suggested to get admitted within ".date("d/m/Y",strtotime($admission_config['admission_last_date'])).".</b>";
	    $str.= $congrats_message."</h4>";
	  }
	  else $str.="</div></h5>";
	  echo $str;
  }
  if($this->session->flashdata('application_success')!='')
  echo '<div class="alert alert-success text-center">'.$this->session->flashdata('application_success').'</div>';

  if($this->session->userdata('transaction_successfull')!='')
  {
  	echo '<div class="alert alert-success text-center">'.$this->session->userdata('transaction_successfull').'</div>';
  	$this->session->unset_userdata('transaction_successfull');
  }
 ?>
<div class="container-fluid">
	<!-- setting variables -->	
	<br/>
	<div class="row">
		<div class="col-xs-12 text-center">
			<?php 
				if($info[0]['is_in_merit_list']=="1"){
					echo $button;
				}
			?>
			<?php if($admission_config['application_last_date']>=date("Y-m-d")) 
			{ ?>
				<a href="<?php echo site_url('applicant/update_application');?>" class="btn btn-default top_menu"> <i class="fa fa-pencil"></i> Update Application</a>
			<?php 
			} ?>

			<?php if($info[0]['payment_status']=="0" && $admission_config['form_price']>0 ) 
			{ ?>
				<a href="<?php echo site_url('applicant/pay_form_fees');?>" class="btn btn-default top_menu"> <i class="fa fa-money"></i> Pay Form Fees</a>
			<?php 
			} ?>			
			
			<a href="<?php echo site_url('applicant/download_application');?>" target="_BLANK" class="btn btn-default top_menu"> <i class="fa fa-cloud-download"></i> Download Application</a>
				

			<?php if($admission_config['is_admission_test']=="1" ) 
			{ ?>
				<a href="<?php echo site_url('applicant/download_admit');?>" target="_BLANK" class="btn btn-default top_menu"> <i class="fa fa-cloud-download"></i> Download Admit Card</a>
			<?php 
			} ?>

			<?php if($admission_config['admission_last_date']>=date("Y-m-d") && $info[0]['is_in_merit_list']=="1" ) 
			{ ?>
				<a href="<?php echo site_url('applicant/download_slip');?>" class="btn btn-default top_menu"> <i class="fa fa-check-square-o"></i>Download Slip</a>
			<?php 
			} ?>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-md-3 col-lg-3 col-sm-12 col-xs-12 text-center">
		    <?php if($info[0]['image']=='' && $info[0]['gender']=="Male") $image=base_url('assets/images/avatar/boy.png'); 
			else if($info[0]['image']=='' && $info[0]['gender']=="Female") $image=base_url('assets/images/avatar/girl.png');
			else $image=base_url('upload/applicant').'/'.$info[0]['image']; ?>
			<img class="img img-thumbnail img-circle" style="width:250px !important; height:250px !important" src="<?php echo $image; ?>">
			<h3 class="text-center" style="font-family:'Cooper Black'"><b><?php if(isset($info[0]['name'])) echo "{$info[0]['name']}"; ?></b></h3>
			<br/>
			<h4><b>Applicant ID : <?php if(isset($info[0]['id'])) echo "{$info[0]['id']}"; ?></b></h4>
			<h4><b>Admission Roll : <?php if(isset($info[0]['admission_roll'])) echo "{$info[0]['admission_roll']}"; ?></b></h4>
			<br/><br/>
			<div class="table-responsive">
				<table class="table table-hover">				
					<tbody>										
						<?php if($admission_config['is_admission_test']=="1" && $admission_config['admission_test_date']!="0000-00-00") 
						{ ?>
							<tr>
								<td>Admission Test</td>
								<th><?php echo date("d/m/Y",strtotime($admission_config['admission_test_date'])) ?></th>
							</tr>
							<?php 
						} ?>
						<?php if($admission_config['is_admission_test']=="1" && $admission_config['result_publish_date']!="0000-00-00") 
						{ ?>
							<tr>
								<td>Result Publish</td>
								<th><?php echo date("d/m/Y",strtotime($admission_config['result_publish_date'])) ?></th>
							</tr>
							<?php 
						} ?>
						<?php if($admission_config['admission_last_date']!="0000-00-00") 
						{ ?>
							<tr>
								<td>Admission Last Date</td>
								<th><?php echo date("d/m/Y",strtotime($admission_config['admission_last_date'])) ?></th>
							</tr>
							<?php 
						} ?>
					</tbody>
				</table>
			</div>

		</div>

		<div class="col-md-9 col-lg-9 col-sm-12 col-xs-12">

			<div>

				<!-- Nav tabs -->
				<ul class="nav nav-tabs" role="tablist">
					<li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab"><i class="fa fa-user"></i> Basic Info</a></li>
					<li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab"><i class="fa fa-user-plus"></i> Gurdian Info</a></li>
					<li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab"><i class="fa fa-graduation-cap"></i> Academic Info</a></li>

				</ul>

				<!--tab one -->

				<div class="tab-content">
					<div role="tabpanel" class="tab-pane active" id="home">
						<div class="row">
							<div class="col-xs-12">
								<blockquote>
									<p><i class="fa fa-user"></i> Name</p>
									<footer><?php if(isset($info[0]['name'])) echo "{$info[0]['name']}"; ?></footer>
								</blockquote>
							</div>

							<!-- <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
								<blockquote>
									<p><i class="fa fa-user"></i> Name(bangla)</p>
									<footer><?php if(isset($info[0]['name_bangla'])) echo "{$info[0]['name_bangla']}"; ?></footer>
								</blockquote>
							</div> -->
						</div>

						<div class="row">
							<div class="col-xs-12">
								<blockquote>
									<p><i class="fa fa-male"></i> Father name</p>
									<footer><?php if(isset($info[0]['father_name'])) echo "{$info[0]['father_name']}"; ?></footer>
								</blockquote>
							</div>

<!-- 							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
								<blockquote>
									<p><i class="fa fa-male"></i> Father name(bangla)</p>
									<footer><?php if(isset($info[0]['father_name_bangla']))  echo "{$info[0]['father_name_bangla']}"; ?></footer>
								</blockquote>
							</div> -->
						</div>

						<div class="row">
							<div class="col-xs-12">
								<blockquote>
									<p><i class="fa fa-female"></i> Mother name</p>
									<footer><?php if(isset($info[0]['mother_name'])) echo "{$info[0]['mother_name']}"; ?></footer>
								</blockquote>
							</div>

							<!-- <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
								<blockquote>
									<p><i class="fa fa-female"></i> Mother name(bangla)</p>
									<footer><?php  if(isset($info[0]['mother_name_bangla'])) echo "{$info[0]['mother_name_bangla']}"; ?></footer>
								</blockquote>
							</div> -->
						</div>

						<div class="row">
							<div class="col-xs-12">
								<blockquote>
									<p><i class="fa fa-birthday-cake"></i> Date of Birth</p>
									<footer><?php if(isset($info[0]['birth_date'])) echo $info[0]['birth_date']; ?></footer>
								</blockquote>
							</div>

							<!-- <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
								<blockquote>
									<p><i class="fa  fa-sort-numeric-asc"></i> Birth Certificate No.</p>
									<footer><?php if(isset($info[0]['birth_certificate_no'])) echo "{$info[0]['birth_certificate_no']}"; ?></footer>
								</blockquote>
							</div> -->
							
						</div> <!-- end row -->

						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
								<blockquote>
									<p><i class="fa fa-transgender"></i> Gender</p>
									<footer><?php if(isset($info[0]['gender'])) echo $info[0]['gender']; ?></footer>
								</blockquote>
							</div>

							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
								<blockquote>
									<p><i class="fa  fa-road"></i> Religion</p>
									<footer><?php if(isset($info[0]['religion'])) echo "{$info[0]['religion']}"; ?></footer>
								</blockquote>
							</div>
							
						</div> <!-- end row -->

						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
								<blockquote>
									<p><i class="fa fa-envelope"></i> Email</p>
									<footer><?php if(isset($info[0]['email'])) echo "{$info[0]['email']}"; ?></footer>
								</blockquote>
							</div>

							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
								<blockquote>
									<p><i class="fa fa-mobile-phone"></i> Mobile</p>
									<footer><?php if(isset($info[0]['mobile'])) echo "{$info[0]['mobile']}"; ?></footer>
								</blockquote>
							</div>

							 <!-- <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
								<blockquote>
									<p><i class="fa fa-mobile-phone"></i> SSC Roll</p>
									<footer><?php if(isset($info[0]['roll_ssc'])) echo "{$info[0]['roll_ssc']}"; ?></footer>
								</blockquote>
							</div> -->

							<!-- <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
								<blockquote>
									<p><i class="fa fa-mobile-phone"></i> SSC Registration</p>
									<footer><?php if(isset($info[0]['reg_ssc'])) echo "{$info[0]['reg_ssc']}"; ?></footer>
								</blockquote>
							</div> --> 
							
						</div> <!-- end row -->
					</div>	<!-- end tab panel -->					

					<!-- tab one close -->

					<!-- tab 2 start -->

					<div role="tabpanel" class="tab-pane" id="profile">						

						<div class="row">

							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
								<blockquote>
									<p><i class="fa fa-user"></i> Name</p>
									<footer><?php if(isset($info[0]['gurdian_name'])) echo "{$info[0]['gurdian_name']}"; ?></footer>
								</blockquote>
							</div>

							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
								<blockquote>
									<p><i class="fa fa-chain"></i> Relation</p>
									<footer><?php  if(isset($info[0]['gurdian_relation'])) echo "{$info[0]['gurdian_relation']}"; ?></footer>
								</blockquote>
							</div>

							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
								<blockquote>
									<p><i class="fa fa-certificate"></i> Occupation</p>
									<footer><?php if(isset($info[0]['gurdian_occupation'])) echo "{$info[0]['gurdian_occupation']}"; ?></footer>
								</blockquote>
							</div>

							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
								<blockquote>
									<p><i class="fa fa-money"></i> Yearly Income (BDT.)</p>
									<footer><?php  if(isset($info[0]['gurdian_income'])) echo "{$info[0]['gurdian_income']}"; ?></footer>
								</blockquote>
							</div>							

							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<blockquote>
									<p>
										<i class="fa fa-mobile">
										</i> 
										Mobile No.</p>
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
											Email</p>
											<footer>
												<?php if(isset($info[0]['gurdian_email'])) echo "{$info[0]['gurdian_email']}"; ?>
											</footer>
									</blockquote>
								</div>

								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<blockquote>
										<p><i class="fa fa-anchor"></i> Present Address</p>
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
											 Permanent Address
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
										Class
									</p>
									<footer><?php if(isset($info[0]['class_name'])) echo "{$info[0]['class_name']}"; ?></footer>
								</blockquote>
							</div>

							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
								<blockquote>
									<p>
										<i class="fa  fa-building">
										</i> 
										Group/ Department
									</p>
									<footer><?php if(isset($info[0]['dept_name'])) echo "{$info[0]['dept_name']}"; ?></footer>
								</blockquote>
							</div>

					
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
								<blockquote>
									<p>
										<i class="fa fa-bell-o">
										</i> 
										Shift</p>
										<footer><?php if(isset($info[0]['shift_name'])) echo "{$info[0]['shift_name']}"; ?></footer>
								</blockquote>
							</div>

							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
								<blockquote>
								<p>
									<i class="fa fa-clock-o">
									</i> 
									Session</p>
									<footer><?php if(isset($info[0]['session_name']))  echo "{$info[0]['session_name']}"; ?>
									</footer>
								</blockquote>
							</div>

							<!-- <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
								<blockquote>
									<p>
									<i class="fa fa-pencil-square-o">
									</i> 
									Exam version</p>
									<footer><?php if(isset($info[0]['exam_version'])) echo "{$info[0]['exam_version']}"; ?>
									</footer>
								</blockquote>
							</div> -->

							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
								<blockquote>
									<p>
									<i class="fa  fa-sort-numeric-asc">
									</i> 
									Admission Roll</p>
									<footer><?php if(isset($info[0]['admission_roll'])) echo "{$info[0]['admission_roll']}"; ?>
									</footer>
								</blockquote>
							</div>

							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<blockquote>
									<p>
										<i class="fa fa-book">
										</i> 
										Course
									</p>
									<footer>
									<?php 
									if(isset($info[0]['courses'])) 
									{
										$courses=str_replace("__",", ",$info[0]['courses']);
										echo $courses; 
									}
									?>
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



<br/>