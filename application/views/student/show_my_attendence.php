<section class="content-header">
   <section class="content">
     <div class="box box-info custom_box">
       <div class="box-header">
         <h3 class="box-title"><i class="fa fa-plus-circle"></i> <?php echo $this->lang->line('my attendence');?></h3>
       </div><!-- /.box-header -->
       <!-- form start -->
          <div class="box-body background_white"> 

          <?php
          
          		if(empty($info))
          	      echo "<div class='container-fluid'>
  			 				
  			 				    <h3>
  			 				   		<div class='alert alert-info text-center'>
    			 					 	",$this->lang->line('no data to show.'),"
    			 					</div>
    			 				</h3>
    			  		</div>";   
    			else{ 
           
         		echo "<table style='width:100%' class='table table-bordered table-hover'>          
          		                	
				<tr>
					<th>",$this->lang->line('sl'),"</th>
					<th>",$this->lang->line('teacher name'),"</th>
					<th>",$this->lang->line('course'),"</th>
					<th class='text-right'>",$this->lang->line('total class'),"</th>
					<th class='text-right'>",$this->lang->line('attended class'),"</th>					
					<th class='text-right'>",$this->lang->line('attendence'),"</th>
				</tr>
				";
				?>				
           	

				<?php 
				$percentage1 = array();   // extracting percentage using foreach loop.
				foreach ($info as $percentage)
				{
					$percentage1[]=$percentage['present_percentage'];					
				}
				
				$array_sum_percentage = array_sum($percentage1);				
				

				$total_class1 = array();      // extracting total_class from info array.
				foreach ($info as $total_class)
				{
					$total_class1[]=$total_class['total_class'];
				}

				$array_sum_total_class = array_sum($total_class1);						

				$present_class1 = array();    // extracting present_class from info array.
				foreach ($info as $present_class)
				{
					$present_class1[]=$present_class['present_class'];
				}

				$array_sum_present_class = array_sum($present_class1);

				//  creating a foreach loop. but first we initiate a variable $i which is the serial number.
					$i=0;
						foreach($info as $row)
						{ 
							$i++;							
							?>			
							<tr>		
								<td>
								<?php if (isset($i)) echo $i ;?>
								</td>

								<td>
								<?php if (isset($row['teacher_name'] )) echo $row['teacher_name'] ; ?> 
								</td>
								<td>

								<?php 
								if (isset($row['course_name'])) echo $row['course_name'] . " ";
								if (isset($row['course_code'])) echo $row['course_code'] ; 																
								?>
								</td>

								<td class="text-right">
								<?php if (isset($row['total_class'] )) echo $row['total_class']; ?> 
								</td>

								<td class="text-right">
								<?php if (isset($row['present_class'] )) echo $row['present_class']  ;  ?> 								
								</td>	

								<td class="text-right">
								<?php 
								$Attendence1 = $row['present_percentage'] ;
								$formated_attendence = number_format((float)$Attendence1, 2, '.', '') . " %";
								if (isset($formated_attendence)) echo $formated_attendence;															
								?> 
								</td>						
								
				<?php
						}
				?>							

				<tr>	
				<td colspan="3" class="text-right"></td>			
				<td class="text-right">
					<?php echo $this->lang->line('total classes');?>:
					<?php if (isset($array_sum_total_class)) echo $array_sum_total_class; ?>
				</td>				
				<td  class="text-right">
					<?php echo $this->lang->line('attended');?>:
					<?php if ($array_sum_present_class) echo $array_sum_present_class; ?>
				</td>
				
				<td  class="text-right" >
				<?php echo $this->lang->line('attendence');?>:
				<?php 
				// $total_number_of_courses = $i;	
				$avergare_attendence = $array_sum_present_class/$array_sum_total_class*100;
				echo"<strong>";

				$formated_date = number_format((float)$avergare_attendence, 2, '.', '') . " %";
				if (isset($formated_date)) echo  $formated_date;							
				echo"</strong>";		
				} // else completed
				?> 
				 </td>
				 </tr>					
			</table>
	        </div> <!-- /.box-body --> 
	            <div class="box-footer">
	            	<div class="form-group">
	             		<div class="col-sm-12 text-center">
	              		  <br/> 
	             		</div>
	           		</div>
	            </div><!-- /.box-footer -->         
	        </div><!-- /.box-info -->              
     	</div>
   </section><!--  -->
</section>