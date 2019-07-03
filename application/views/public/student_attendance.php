<br/>
<form class="form-inline" style="margin-top:20px" method="POST" action="<?php echo site_url('site/daily_attendance_counter'); ?>">
   <div class="form-group">
       <?php 
        $session_info['']= $this->lang->line('session'); 
        echo form_dropdown('session_id',$session_info,$this->session->userdata('public_att_session_id'),'class="form-control" id="session_id"'); 
       ?>
  </div> 
  <div class="form-group">
     <input type="text" class="form-control" value="<?php echo $this->session->userdata('public_att_attendance_date'); ?>" name="attendance_date" id="attendance_date" placeholder="<?php echo $this->lang->line('date (yyyy-mm-dd)');?>"/>
  </div> 
  <button class='btn btn-info' name="search"  type="submit"><?php echo $this->lang->line('search');?></button>
</form> 

<style type="text/css">
	tr:nth-child(even){
		background: #fafafa;
	}
</style>
<?php 
	echo "<h4 class='blue'>Date: ".date("d M Y")."</h4>";
	if($attendance_counter != ''){
	echo '<div class="table-responsive"><table style="width:100%"class="table table-bordered">';
	foreach ($attendance_counter as $key => $class) {
		echo '<tr>';
		$class_name = get_data_helper('class',$where=array('where'=>array('id'=>$key)),$select=array('class_name'),$join='',$limit='',$start='',$order_by='',$group_by='',$num_rows=1,$single_value=1);
		echo '<td style="vertical-align:middle !important;" ><h4> ',$this->lang->line('class'),' : '.$class_name['class_name'].'</h4></td>';
		echo '<td style="vertical-align:middle !important;" ><table style="width:100%">';
		foreach ($class as $key => $shift) {
			echo '<tr>';
			$shift_name = get_data_helper('class_shift',$where=array('where'=>array('id'=>$key)),$select=array('shift_name'),$join='',$limit='',$start='',$order_by='',$group_by='',$num_rows=1,$single_value=1);
			echo '<td style="vertical-align:middle !important;width:200px;" ><h4> ',$this->lang->line('shift'),' : '.$shift_name['shift_name'].'</h4></td>';
			echo '<td style="vertical-align:middle !important;" ><table style="width:100%">';

			foreach ($shift as $key => $section) {
				echo '<tr>';
				$section_name = get_data_helper('class_section',$where=array('where'=>array('id'=>$key)),$select=array('section_name'),$join='',$limit='',$start='',$order_by='',$group_by='',$num_rows=1,$single_value=1);
				echo '<td style="vertical-align:middle !important;width:200px;" ><h4> ',$this->lang->line('section'),' : '.$section_name['section_name'].'</h4></td>';
				echo '<td style="vertical-align:middle !important;" >';
					$total=$section['absent_student']+$section['present_student'];
					echo '<h4>',$this->lang->line('present'),' : '.$section['present_student']." <br/> ",$this->lang->line('absent')," : ".$section['absent_student']." <br/>",$this->lang->line('total')," : ".$total."</h4>";
				echo '</td>';
				echo '</tr>';				
			}
			echo '</table></td>';
			echo '</tr>';
		}
		echo '</table></td>';
		echo '</tr>';
	}
	echo '</table></div>';
	}
	else
		echo '<br/><h4><div class="alert alert-info text-center">',$this->lang->line('no data found.'),'</div> </h4>';
?>