<br/>

<form class="form-inline" style="margin-top:20px" method="POST" action="<?php echo site_url('site/routines'); ?>">
  <div class="form-group">                   
      <?php 
        $class_info['']=$this->lang->line('class'). " *";                     
        echo form_dropdown('class_id',$class_info, $this->session->userdata('public_rt_class_id'),'required class="form-control" id="class_id"'); 
      ?>
  </div> 
  <div class="form-group">                   
      <?php 
        $dept_info['']=$this->lang->line('group / dept'). " *";                     
        echo form_dropdown('dept_id',$dept_info,$this->session->userdata('public_rt_dept_id'),'required class="form-control" id="dept_id"'); 
      ?>
  </div>   
  <div class="form-group">                   
      <?php 
        $section_info['']=$this->lang->line('section'). " *";                     
        echo form_dropdown('section_id',$section_info,$this->session->userdata('public_rt_section_id'),'required class="form-control" id="section_id"'); 
      ?>
  </div> 
  <div class="form-group">                   
      <?php 
        $shift_info['']=$this->lang->line('shift'). " *";                     
        echo form_dropdown('shift_id',$shift_info,$this->session->userdata('public_rt_shift_id'),'required class="form-control" id="shift_id"'); 
      ?>
  </div> 
   <div class="form-group">
       <?php 
        $session_info['']=$this->lang->line('session'); 
        echo form_dropdown('session_id',$session_info,$this->session->userdata('public_rt_session_id'),'class="form-control" id="session_id"'); 
       ?>
  </div> 
  <button class='btn btn-info' name="search"  type="submit"><?php echo $this->lang->line('search');?></button>
</form> 


<?php
$td_width=100/($count+1);
$td_width=$td_width."%"; 
?>
<?php 
if(count($output)==0 || $form_error!="")
{
	if($this->session->userdata('public_rt_search')!=1)
	echo  "<h3><div class='alert alert-info text-center'>", $this->lang->line('please search to load data.'),"</div></h3>";
	else if($form_error!="")
	echo  "<h3><div class='alert alert-warning text-center'>".$form_error."</div></h3>";
	else
	echo  "<h3><div class='alert alert-info text-center'>",$this->lang->line('no data to show.'),"</div></h3>";
}
else
{ ?>
	<div class="table-responsive">	
		<table class="table table-hover" width="100%">
			<thead>
				<tr>
					<th class="text-center" <?php echo 'style="width:'.$td_width.'"'; ?>>Period <i class="fa fa-arrow-right"></i><br/>Day <i class="fa fa-arrow-down"></i></th>
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
<?php 
} ?>


