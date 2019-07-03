
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



<div class="row">
	<div class="col-xs-12 own">
		<center><strong class="text-info" style="font-family:'Cooper Black'; font-size:20px"><i class="fa fa-table"></i> <?php echo $this->lang->line('class routine');?> : <?php 	echo $active_session; ?></strong></center>
	</div>
</div>

<br/>

<form class="form-inline" style="margin-top:20px" method="POST" action="<?php echo site_url('site/routines'); ?>">
  <div class="form-group">                   
      <?php 
        $class_info['']=$this->lang->line('class').' *';                     
        echo form_dropdown('class_id',$class_info,"",'required class="form-control" id="class_id"'); 
      ?>
  </div> 
  <div class="form-group">                   
      <?php 
        $dept_info['']=$this->lang->line('group / dept').' *';                     
        echo form_dropdown('dept_id',$dept_info,"",'required class="form-control" id="dept_id"'); 
      ?>
  </div>   
  <div class="form-group">                   
      <?php 
        $section_info['']=$this->lang->line('section').' *';                     
        echo form_dropdown('section_id',$section_info,"",'required class="form-control" id="section_id"'); 
      ?>
  </div> 
  <div class="form-group">                   
      <?php 
        $shift_info['']=$this->lang->line('shift').' *';                     
        echo form_dropdown('shift_id',$shift_info,"",'required class="form-control" id="shift_id"'); 
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
	echo  "<h3><div class='alert alert-info text-center'>",$this->lang->line('please search to load data.'),"</div></h3>";
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
					<th class="text-center" <?php echo 'style="width:'.$td_width.'"'; ?>> <?php echo $this->lang->line('Period');?> <i class="fa fa-arrow-right"></i><br/><?php echo $this->lang->line('day');?> <i class="fa fa-arrow-down"></i></th>

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



