<section class="content-header">
   <section class="content">
   
   
   	<div class="row">
		<div class="col-xs-12 text-center"><h3><?php echo $this->lang->line("today's report");?></h3></div>
   		<div class="col-md-4 col-sm-6 col-xs-12">
			<div class="info-box" style="border:1px solid #00BFEE;border-bottom:2px solid #00BFEE;">
				<span class="info-box-icon bg-aqua"><i class="fa fa-sign-in"></i></span>
				<div class="info-box-content">
					<span class="info-box-text"><?php echo $this->lang->line("today's admitted");?></span>
					<span class="info-box-number"><?php echo number_format($todat_new_students); ?></span>
				</div><!-- /.info-box-content -->
			</div><!-- /.info-box -->
		</div><!-- /.col -->
		<div class="col-md-4 col-sm-6 col-xs-12">
			<div class="info-box" style="border:1px solid #DD4B39;border-bottom:2px solid #DD4B39;">
				<span class="info-box-icon bg-red"><i class="fa fa-dollar"></i></span>
				<div class="info-box-content">
					<span class="info-box-text"><?php echo $this->lang->line("today's payment");?></span>
					<span class="info-box-number"><?php echo number_format($total_amount); ?></span>
				</div><!-- /.info-box-content -->
			</div><!-- /.info-box -->
		</div><!-- /.col -->
		<div class="col-md-4 col-sm-6 col-xs-12">
			<div class="info-box" style="border:1px solid #00A65A;border-bottom:2px solid #00A65A;">
				<span class="info-box-icon bg-green"><i class="fa fa-bullhorn"></i></span>
				<div class="info-box-content">
					<span class="info-box-text"><?php echo $this->lang->line("today's notification sent");?></span>
					<span class="info-box-number">
						<?php 
							if(empty($today_notifications))
							{
								$notifications = 0;
							}
							else
								$notifications = $today_notifications[0]['total_notification'];
							echo number_format($notifications); 
						?>						
					</span>
				</div><!-- /.info-box-content -->
			</div><!-- /.info-box -->
		</div><!-- /.col -->
	</div>


		
	<div class="row">
		<div class="col-xs-12 text-center"><h3><?php echo $this->lang->line("this year's report");?></h3></div>
		<div class="col-md-4 col-sm-6 col-xs-12">
			<div class="info-box bg-yellow">
				<span class="info-box-icon"><i class="fa fa-sign-in"></i></span>
				<div class="info-box-content">
					<!-- <span class="info-box-text">Inventory</span> -->
					<span class="info-box-number"><?php echo number_format($this_year_students); ?></span>
					<div class="progress">
						<div class="progress-bar" style="width: 70%"></div>
					</div>
					<span class="progress-description">
						<b><?php echo $this->lang->line("this year admitted");?></b>
					</span>
				</div><!-- /.info-box-content -->
			</div><!-- /.info-box -->
		</div><!-- /.col -->
		<div class="col-md-4 col-sm-6 col-xs-12">
			<div class="info-box bg-green">
				<span class="info-box-icon"><i class="fa fa-dollar"></i></span>
				<div class="info-box-content">
					<!-- <span class="info-box-text">Inventory</span> -->
					<span class="info-box-number"><?php echo number_format($this_year_amount); ?></span>
					<div class="progress">
						<div class="progress-bar" style="width: 70%"></div>
					</div>
					<span class="progress-description">
						<b><?php echo $this->lang->line("this year payment");?></b>
					</span>
				</div><!-- /.info-box-content -->
			</div><!-- /.info-box -->
		</div><!-- /.col -->
		<div class="col-md-4 col-sm-6 col-xs-12">
			<div class="info-box bg-red">
				<span class="info-box-icon"><i class="fa fa-bullhorn"></i></span>
				<div class="info-box-content">
					<!-- <span class="info-box-text">Inventory</span> -->
					<span class="info-box-number">
						<?php 
							if(empty($this_year_notifications))
								$notifications_year = 0;
							else
								$notifications_year = $this_year_notifications[0]['total_notification'];

							echo number_format($notifications_year); 
						?>							
					</span>
					<div class="progress">
						<div class="progress-bar" style="width: 70%"></div>
					</div>
					<span class="progress-description">
						<b><?php echo $this->lang->line("this year notification sent");?></b>
					</span>
				</div><!-- /.info-box-content -->
			</div><!-- /.info-box -->
		</div><!-- /.col -->
	</div>


	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-6">
			<div class="box box-danger box-solid">
				<div class="box-header with-border">
				<h3 class="box-title"><i class="fa fa-mortar-board"></i> <?php echo $this->lang->line("Total male vs female students");?></h3>
					<div class="box-tools pull-right">
						<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					</div><!-- /.box-tools -->
				</div><!-- /.box-header -->
				<div class="box-body chart-responsive">
					<input type="hidden" id="male_female_student" value='<?php if(isset($male_female_student)) echo $male_female_student; ?>'/>

					<div class="col-xs-12">
						<div class="row">
							<div class="col-md-7 col-xs-12">
								<div class="chart-responsive">
									<canvas id="male_female_student_chart" height="220"></canvas>
								</div><!-- ./chart-responsive -->
							</div><!-- /.col -->
							<div class="col-md-5 col-xs-12" style="padding-top:35px;">
								<ul class="chart-legend clearfix" id="visitor_type_color_codes">
									<li><i class="fa fa-circle-o" style="color: #19DD89;"></i> <?php echo $this->lang->line("Male Student");?></li>
			                        <li><i class="fa fa-circle-o" style="color: #F5A196;"></i> <?php echo $this->lang->line("Female Student");?></li>
								</ul>
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div>

				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div>

		<div class="col-xs-12 col-sm-12 col-md-6">
			<div class="box box-info box-solid">
				<div class="box-header with-border">
				<h3 class="box-title"><i class="fa fa-user"></i> <?php echo $this->lang->line("Total male vs female teacher");?></h3>
					<div class="box-tools pull-right">
						<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					</div><!-- /.box-tools -->
				</div><!-- /.box-header -->
				<div class="box-body chart-responsive">
					<input type="hidden" id="male_female_teacher" value='<?php if(isset($male_female_teacher)) echo $male_female_teacher; ?>'/>

					<div class="col-xs-12">
						<div class="row">
							<div class="col-md-8 col-xs-12">
								<div class="chart-responsive">
									<canvas id="male_female_teacher_chart" height="220"></canvas>
								</div><!-- ./chart-responsive -->
							</div><!-- /.col -->
							<div class="col-md-4 col-xs-12" style="padding-top:35px;">
								<ul class="chart-legend clearfix" id="visitor_type_color_codes">
									<li><i class="fa fa-circle-o" style="color: #0099CC;"></i> <?php echo $this->lang->line("Male Teacher");?></li>
			                        <li><i class="fa fa-circle-o" style="color: #FFFF66;"></i> <?php echo $this->lang->line("Female Teacher");?></li>
								</ul>
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div>

				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div>
	</div>


	<div class="row">
		<div class="col-xs-12" style="padding-top:20px;">
			<!-- AREA CHART -->
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title text-center" style="color: #3C8DBC; word-spacing: 4px;"><?php echo $this->lang->line("session wise male vs female students");?></h3>
					<div class="box-tools pull-right">
						<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
					</div>
				</div>
				<div class="box-body">
					<input type="hidden" id="session_wise_data" value='<?php echo $session_wise_data; ?>' />
					<div class="chart">
						<div class="chart" id="session_wise_chart" style="height: 300px;"></div>
					</div>
				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div>
	</div>

	<!-- *************************library information -->
	<br/><br/>
	<div class="row">
		<div class="col-xs-12">
			<div class="row">
				<div class="col-xs-12">
					<h2><div class="well text-center" style="color: #E32E2E; font-weight: bold; font-size: 25px;"><?php echo $this->lang->line('school library information'); ?></div></h2>
				</div>
			</div>

			<div class="row">
				<div class="text-center"><h2 style="font-weight:900;"><?php echo $this->lang->line('total issued books + Expired but not returned books');?></h2></div>
				<div id="div_for_circle_chart"></div>
			</div>

			<!-- total report section -->
			<div class="row">
				<div class="text-center"><h2 style="font-weight:900;"><?php echo $this->lang->line('overall report');?></h2></div>

				<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">

					<div class="small-box bg-green">
						<div class="inner">
							<h3><?php echo $num_of_book; ?></h3>
							<p><?php echo $this->lang->line('total number of books');?></p>
						</div>
						<div class="icon">
							<i class="fa fa-book"></i>
						</div>
						<a target="_blank" href="<?php echo base_url()."admin_library/book_list"; ?>" class="small-box-footer">
							<?php echo $this->lang->line('more information');?> <i class="fa fa-arrow-circle-right"></i>
						</a>
					</div>
				</div>

				<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">

					<div class="small-box bg-red">
						<div class="inner">
							<h3><?php echo $num_issue_book; ?></h3>
							<p><?php echo $this->lang->line('total number of issued books');?></p>
						</div>
						<div class="icon">
							<i class="fa fa-book"></i><i class="fa fa-mail-forward"></i>
						</div>
						<a target="_blank" href="<?php echo base_url()."admin_library/circulation"; ?>" class="small-box-footer">
							<?php echo $this->lang->line('more information');?> <i class="fa fa-arrow-circle-right"></i>
						</a>
					</div>
				</div>

			</div>


			<!-- end of total report section -->

			<!-- Todays report section -->
			<div class="row">
				<div class="text-center"><h2 style="font-weight:900;"><?php echo $this->lang->line("today's report");?></h2></div>
				<div class="col-xs-12 col-sm-12 col-md-4">

					<div class="small-box bg-blue">
						<div class="inner">
							<h3><?php echo $num_add_book_today; ?></h3>
							<p><?php echo $this->lang->line("today's added books");?></p>
						</div>
						<div class="icon">
							<i class="fa fa-book"></i>
						</div>
						<a target="_blank" href="<?php echo base_url()."admin_library/book_list"; ?>" class="small-box-footer">
							<?php echo $this->lang->line('more information');?> <i class="fa fa-arrow-circle-right"></i>
						</a>
					</div>
				</div>

				<div class="col-xs-12 col-sm-12 col-md-4">

					<div class="small-box bg-orange">
						<div class="inner">
							<h3><?php echo $num_today_issue_book; ?></h3>
							<p><?php echo $this->lang->line("today's issued books");?></p>
						</div>
						<div class="icon">
							<i class="fa fa-book"></i><i class="fa fa-mail-forward"></i>
						</div>
						<a target="_blank" href="<?php echo base_url()."admin_library/circulation"; ?>" class="small-box-footer">
							<?php echo $this->lang->line('more information');?> <i class="fa fa-arrow-circle-right"></i>
						</a>
					</div>
				</div>

				<div class="col-xs-12 col-sm-12 col-md-4">

					<div class="small-box bg-aqua">
						<div class="inner">
							<h3><?php echo $num_today_return_book; ?></h3>
							<p><?php echo $this->lang->line("today's returned books");?></p>
						</div>
						<div class="icon">
							<i class="fa fa-book"></i><i class="fa fa-mail-reply"></i>
						</div>
						<a target="_blank" href="<?php echo base_url()."admin_library/circulation"; ?>" class="small-box-footer">
							<?php echo $this->lang->line('more information');?> <i class="fa fa-arrow-circle-right"></i>
						</a>
					</div>
				</div>
			</div>

			<!--end of Todays report section -->

			<!-- monthly report section -->
			<div class="row">
				<div class="text-center"><h2 style="font-weight:900;"><?php echo $this->lang->line("current month's report");?></h2></div>
				<div class="col-xs-12 col-sm-12 col-md-4">

					<div class="small-box bg-blue">
						<div class="inner">
							<h3><?php echo $num_add_book_this_month; ?></h3>
							<p><?php echo $this->lang->line("this month's added book");?></p>
						</div>
						<div class="icon">
							<i class="fa fa-book"></i>
						</div>
						<a target="_blank" href="<?php echo base_url()."admin_library/book_list"; ?>" class="small-box-footer">
							<?php echo $this->lang->line('more information');?> <i class="fa fa-arrow-circle-right"></i>
						</a>
					</div>
				</div>

				<div class="col-xs-12 col-sm-12 col-md-4">

					<div class="small-box bg-orange">
						<div class="inner">
							<h3><?php echo $num_issue_book_this_month; ?></h3>
							<p><?php echo $this->lang->line("this month's issued book");?></p>
						</div>
						<div class="icon">
							<i class="fa fa-book"></i><i class="fa fa-mail-forward"></i>
						</div>
						<a target="_blank" href="<?php echo base_url()."admin_library/circulation"; ?>" class="small-box-footer">
							<?php echo $this->lang->line('more information');?> <i class="fa fa-arrow-circle-right"></i>
						</a>
					</div>
				</div>

				<div class="col-xs-12 col-sm-12 col-md-4">

					<div class="small-box bg-aqua">
						<div class="inner">
							<h3><?php echo $num_return_book_this_month; ?></h3>
							<p><?php echo $this->lang->line("this month's returned book");?></p>
						</div>
						<div class="icon">
							<i class="fa fa-book"></i><i class="fa fa-mail-reply"></i>
						</div>
						<a target="_blank" href="<?php echo base_url()."admin_library/circulation"; ?>" class="small-box-footer">
							<?php echo $this->lang->line('more information');?> <i class="fa fa-arrow-circle-right"></i>
						</a>
					</div>
				</div>
			</div>

			<!--end of monthly report section -->



			<div class="row">
				<div class="text-center"><h2 style="font-weight:900;"><?php echo $this->lang->line('issued and returned report for last 12 months');?></h2></div>
				<div id='div_for_bar'></div>
			</div>


			<?php
			$bar = $chart_bar;
			$circle_bir = array(
				'0' => array(
					'label'=>$this->lang->line('expired but not returned'),
					'value'=>$not_returned[0]['not_returned']
					),
				'1' =>array(
					'label'=>$this->lang->line('total issued'),
					'value'=>$total_issued[0]['total_issued']

					)

				);

				?>

		</div>
	</div>
		
		
   </section>  
 </section>


<script>
	$j("document").ready(function(){

		// LINE CHART
		var views = $("#session_wise_data").val();
	    var line = new Morris.Bar({
	      element: 'session_wise_chart',
	      resize: true,
	      data: JSON.parse(views),
	      xkey: 'session',
	      ykeys: ['male','female'],
	      labels: ['Male Students', 'Female Students'],
	      barColors: ['#F6AC49','#E32E2E'],
	      lineWidth: 1,
	      hideHover: 'auto'
	    });



		var pieOptions = {
          //Boolean - Whether we should show a stroke on each segment
          segmentShowStroke: true,
          //String - The colour of each segment stroke
          segmentStrokeColor: "#fff",
          //Number - The width of each segment stroke
          segmentStrokeWidth: 2,
          //Number - The percentage of the chart that we cut out of the middle
          percentageInnerCutout: 10, // This is 0 for Pie charts
          //Number - Amount of animation steps
          animationSteps: 100,
          //String - Animation easing effect
          animationEasing: "easeOutBounce",
          //Boolean - Whether we animate the rotation of the Doughnut
          animateRotate: true,
          //Boolean - Whether we animate scaling the Doughnut from the centre
          animateScale: false,
          //Boolean - whether to make the chart responsive to window resizing
          responsive: true,
          // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
          maintainAspectRatio: false
        };
		//- PIE CHART -
		//-------------
		// Get context with jQuery - using jQuery's .get() method.
		var pieChartCanvas = $("#male_female_student_chart").get(0).getContext("2d");
		var pieChart = new Chart(pieChartCanvas);
		var male_female_student = $("#male_female_student").val();
		if(male_female_student != "" && male_female_student != "undefined"){
		  var PieData1 = JSON.parse(male_female_student);			  
		  // You can switch between pie and douhnut using the method below.  
		  pieChart.Doughnut(PieData1, pieOptions);
		  //-----------------
		  //- END PIE CHART -
		  //-----------------
		}


		//- PIE CHART -
		//-------------
		// Get context with jQuery - using jQuery's .get() method.
		var pieChartCanvas = $("#male_female_teacher_chart").get(0).getContext("2d");
		var pieChart = new Chart(pieChartCanvas);
		var male_female_teacher = $("#male_female_teacher").val();
		if(male_female_teacher != "" && male_female_teacher != "undefined"){
		  var PieData1 = JSON.parse(male_female_teacher);			  
		  // You can switch between pie and douhnut using the method below.  
		  pieChart.Doughnut(PieData1, pieOptions);
		  //-----------------
		  //- END PIE CHART -
		  //-----------------
		}



		var total_issued_dis="<?php echo $this->lang->line('number total returned'); ?>";
		var total_retuned_dis="<?php echo $this->lang->line('number total issued'); ?>";
		Morris.Bar({
		  element: 'div_for_bar',
		  data: <?php echo json_encode($bar); ?>,
		  xkey: 'year',
		  ykeys: ['total_issue', 'total_return'],
		  labels: [total_issued_dis, total_retuned_dis],
		  barColors: ['#CCFF33','#00FF99'],
		});

		Morris.Donut({
		  element: 'div_for_circle_chart',
		  data: <?php echo json_encode($circle_bir); ?>
		});



	});
</script>