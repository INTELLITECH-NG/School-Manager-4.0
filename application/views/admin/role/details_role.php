<?php   
	
	foreach($xrole_info as $row)  
	{
		$xrole_name=$row['name'];
		$xcenters=$row['departments'];	
		$xid=$row['id'];
		break;
	}
	
	$xcenters_array=explode(',',$xcenters);	
  ?> 	
	
 

<section class="content-header">
   <section class="content">
     <div class="box box-info custom_box">
       <div class="box-header">
         <h3 class="box-title"><i class="fa fa-binoculars"></i> <?php echo $this->lang->line('details role');?></h3>
       </div><!-- /.box-header -->    
	   
	   <div class="box-body">
		    <center><h3><span class="orange"><?php echo $xrole_name; ?></h3></span></center>	
		    <div class="table-responsive">		
				<table width="100%" align="center" class="table table-bordered">		
					<tr>
						<th class="blue" style="vertical-align:middle;"><center><?php echo $this->lang->line('modules');?></center></th>
						<th class="blue">
							<center><?php echo $this->lang->line('accesses');?><br/><br/></center>
							
							<?php
								echo '<table width="100%" class="table table-bordered">';
								    echo '<tr>';							 	
										foreach($accesses as $access)
									    { 
											echo '<td width="20%"  style="text-align:center" class="blue">';																		
												echo $access['name']."&nbsp;&nbsp;";																	
											echo '</td>';								
										}								
									 echo '<tr/>';
							     echo '</table>';?>	

						</th>
					</tr>
					
					<tr>			
						<td>
						<?php					
						 echo '<table width="100%" class="table table-bordered">';							 
							foreach($xmodules as $module)
							  { 
							  	echo '<tr>';
									echo '<td>';
										$module_name_return=get_data_helper('modules',$where=array('where'=>array('id'=>$module)),$select=array('name'),$join='',$limit='',$start='',$order_by='',$group_by='',$num_rows=0,$single_value=1); 	
										echo $module_name_return['name'];								
									echo '</td>';
								echo '</tr>';															
						      }  
							 
						 echo '</table>';
							 ?>
						</td>
						
						<td>
						<?php 
						   echo '<table width="100%" class="table table-bordered">';			
						    for($i=0;$i<count($xmodules);$i++)
							{
							 echo '<tr>';
								foreach($accesses as $access)
							    { 
									echo '<td width="20%" style="text-align:center">';							
										$temp_array=explode(',',$xaccesses[$xmodules[$i]]);								
										if(in_array($access['id'],$temp_array))  
										echo "<i class='fa fa-check'></i>";
										else echo "<i class='fa fa-remove'></i>";									
									echo '</td>';								
								}								
							 echo '<tr/>';					 							
						     }
						 echo '</table>';?>	
						</td>											
					</tr>
				</table>
			</div>
			<br/>
			<div class="table-responsive">
				<table width="100%"  class="table table-bordered" style="background:#fff">					
					<caption><h4 align='left' class='blue'><?php echo $this->lang->line('groups / depts');?> : </h4></caption>
					<tr>
						<th width="10%" class="blue"><?php echo $this->lang->line('sl');?></th>											
						<th class="blue"><?php echo $this->lang->line('class');?></th>									
						<th class="blue"><?php echo $this->lang->line('group / dept');?></th>				
					</tr>
								
					<?php
					$sl=0;					
					foreach($centers as $center)
					{
						if(in_array($center['id'],$xcenters_array))
						{
							$sl++;
							$class_name=get_data_helper("department",$where=array("where"=>array("department.id"=>$center['id'])),$select='class_name',$join=array('class'=>"class.id=department.class_id,left"),$limit='',$start='',$order_by='',$group_by='',$num_rows=0,$single_value=1);
							echo "<tr>";											
								echo "<td>".$sl."</td>";	
								echo "<td>";
									echo $class_name['class_name'];
								echo "</td>";					
								echo "<td>".$center['dept_name']."</td>";											
							echo "</tr>";
						}
						
					}
					?>
					
				</table>
			</div>
       </div> <!-- /.box-body --> 

       <div class="box-footer">
       	<br>       
       </div><!-- /.box-footer -->         
      </div><!-- /.box-info -->    
   </section>
</section>

