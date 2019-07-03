
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
				<center><strong class="text-info" style="font-family:'Cooper Black'; font-size:20px"><i class="fa fa-table"></i> <?php echo $this->lang->line('class routine');?> : <?php 	echo $session_name; ?></strong></center>
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12">
				<form class="form-inline" style="margin-top:20px" method="POST" action="<?php echo site_url('teacher/routine'); ?>">
				   <div class="form-group">
				       <?php 
				        $session_info['']=$this->lang->line('session');
				        echo form_dropdown('session_id',$session_info,$this->session->userdata('teacher_panel_rt_session_id'),'class="form-control" id="session_id"'); 
				       ?>
				  </div> 
				  <button class='btn btn-info' name="search"  type="submit"><?php echo $this->lang->line('search');?></button>
				</form> 
			</div>
		</div>

		<br/>
		
			<div class="col-md-2 col-lg-12 col-sm-12 col-xs-12">
				<?php 
				$td_width=100/($count+1);
				$td_width=$td_width."%"; 
				?>
				<div class="table-responsive">	
					<table class="table table-hover" width="100%">
						<thead>
							<tr>
								<th class="text-center" <?php echo 'style="width:'.$td_width.'"'; ?>><?php echo $this->lang->line('period');?> <i class="fa fa-arrow-right"></i><br/><?php echo $this->lang->line('day');?> <i class="fa fa-arrow-down"></i></th>
								<?php 
								foreach($period as $val)
								{
									echo '<th class="text-center" '.'style="width:'.$td_width.'"'.'>'.$val['period_name'].'</th>';
								} ?>													
							</tr>						
						</thead>
						<tbody>

						<?php 							
								
								for($i=1;$i<=7;$i++)
								{
									if($i==1)
										$day = "Sat";
									elseif($i==2)
										$day = "Sun";
									elseif($i==3)
										$day = "Mon";
									elseif($i==4)
										$day = "Tue";
									elseif($i==5)
										$day = "Wed";
									elseif($i==6)
										$day = "Thu";
									elseif($i==7)
										$day = "Fri";
									
								
									echo "<tr><td class='text-center'  ".'style="width:'.$td_width.'"'."><b>".$day."</b></td>";

									for($j=1;$j<=$count;$j++)
									{
										if(!array_key_exists($i, $output) || !array_key_exists($j, $output[$i]))
										$output[$i][$j]='-<br/> &nbsp;';

										echo "<td class='text-center' ".'style="width:'.$td_width.'"'.">".$output[$i][$j]."</td>";
										
									}
									
									echo "</tr>";										
								
								}

							 ?>

						</tbody>
					</table>
				</div>
			</div>
		</div>

	</div>

