<section class="content-header">
   <section class="content">
	  <form class="form-inline" style="margin-top:20px" action="" method="POST">
                <div class="form-group">
                    <?php 
                      $class_info['']=$this->lang->line('class');                     
                      echo form_dropdown('class_id',$class_info,"",'class="form-control" required id="class_id"'); 
                    ?>
                </div>

                <div class="form-group">                   
                    <?php 
                      $dept_info['']=$this->lang->line('group / dept');                     
                      echo form_dropdown('dept_id',$dept_info,"",'class="form-control" required id="dept_id"'); 
                    ?>
                </div> 
				
                <div class="form-group">
                     <?php 
                      $session_info['']=$this->lang->line('session'); 
                      echo form_dropdown('financial_year_id',$session_info,"",'class="form-control" required id="financial_year_id"'); 
                     ?>
                </div> 

                <div class="form-group">
                    <?php 
                      $shift_info['']=$this->lang->line('shift'); 
                      echo form_dropdown('shift_id',$shift_info,"",'class="form-control" required id="shift_id"'); 
                    ?>
                </div>

                <div class="form-group">
                  <?php 
                    $section_info['']='Section'; 
                    echo form_dropdown('section_id',$section_info,"",'class="form-control" required id="sec_id"'); 
                  ?>
                </div>
                <input type="submit" class='btn btn-info' value="Search">
            </form>     

<!--          Displaying Routine         -->

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

<?php
$td_width=100/($count+1);
$td_width=$td_width."%"; 
?>

<?php 
if($form_error!="" || !isset($is_search) || $is_search!=1)
{
	if($this->session->userdata('public_rt_search')!=1)
	echo  "<h3><div class='alert alert-info text-center'>",$this->lang->line('please search to load data.'),"</div></h3>";
	else if($form_error!="")
	echo  "<h3><div class='alert alert-warning text-center'>".$form_error."</div></h3>";
	else
	echo  "<h3><div class='alert alert-info text-center'>",$this->lang->line('no data to show.'),"</div></h3>";
}
else
{ 
?>
               <div class="form-group">
                     <?php 
                     $period_info['']=$this->lang->line('period'); 
                      echo form_dropdown('period_id',$period_info,"",'class="form-control" id="period_id"');
                     ?>
                </div> 
				
				
				 <div class="form-group">
                     <?php 
                     $teacher_info['']=$this->lang->line('teacher'); 
                      echo form_dropdown('teacher_id',$teacher_info,"",'class="form-control" id="teacher_id"');
                     ?>
                </div> 
				
				<div class="form-group">
                     <?php 	
					$day_info=array('Sat'=>$this->lang->line('cal_saturday'),'Sun'=>$this->lang->line('cal_sunday'),'Mon'=>$this->lang->line('cal_monday'),'Tue'=>$this->lang->line('cal_tuesday'), 'Wed'=>$this->lang->line('cal_wednesday'),'Thu'=>$this->lang->line('cal_thursday'),'Fri'=>$this->lang->line('cal_friday')); 
                     $day_info['']=$this->lang->line('day'); 
                     echo form_dropdown('day_id',$day_info,"",'class="form-control" id="day_id"');
                     ?>
                </div> 
				
				
			  <div class="form-group">
                     <?php 
                     $course_info['']=$this->lang->line('course'); 
                      echo form_dropdown('course_id',$course_info,"",'class="form-control" id="course_id"');
                     ?>
                </div> 
				
			 <div class="form-group">
                   <input  id="start_time" name="start_time" class="form-control" size="20" placeholder='<?php echo $this->lang->line("start time");?>' >
           	 </div> 
			 
			 <div class="form-group">
                   <input  id="end_time" name="end_time" class="form-control" size="20" placeholder='<?php echo $this->lang->line("end time");?>' >
           	 </div> 
			 
			 <input type="button" class="btn btn-info" value='<?php echo $this->lang->line("add class");?>' name="add_routine" id="add_routine"/>
			 
	<div class="table-responsive">	
		<table class="table table-hover" width="100%">
			<thead>
				<tr>
					<th class="text-center" <?php echo 'style="width:'.$td_width.'"';?>> <?php echo $this->lang->line('period')?> <i class="fa fa-arrow-right"></i><br/><?php echo $this->lang->line('day');?> <i class="fa fa-arrow-down"></i></th>

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
							
							if(isset($output_id[$i][$j])){
								$id_field=$output_id[$i][$j];
								$id_field="id='{$id_field}'";
								$class_field="period";
							}
							else{
								$id_field="";
								$class_field="";
							}
							
						echo "<td {$id_field}  class='text-center {$class_field}' ".'style="width:'.$td_width.'"'.">".$output[$i][$j]."</td>";
						}
						echo "</tr>";										
					}

				 ?>

			</tbody>
		</table>
	</div>	
<?php 
} ?>
     </div>
   </section>
</section>

<script type="text/javascript">

$j("document").ready(function(){
	
	$("#add_routine").click(function(){
		var period_id=$("#period_id").val();
		var day_id=$("#day_id").val();
		var course_id=$("#course_id").val();
		var start_time=$("#start_time").val();
		var end_time=$("#end_time").val();
		var teacher_id=$("#teacher_id").val();
		
		if(period_id!='' && day_id!='' && course_id!='' && start_time!='' && end_time!=''){
			var base_url="<?php echo base_url(); ?>";
			$.ajax({
				type:'POST',
				url: base_url+'admin_routine/add_routine',
				data:{
					period_id:period_id,day_id:day_id,course_id:course_id,start_time:start_time,end_time:end_time,teacher_id:teacher_id
				},
				success:function(response){
					location.reload();
				}
				
			});
		}
	});
	
	$(".period").click(function(){
		var id=$(this).attr('id');
		var ans=confirm('<?php echo $this->lang->line("do you want to delete?");?>');
		if(!ans){
			return true;
		}
		var base_url="<?php echo base_url(); ?>";
		$.ajax({
			type:'POST',
			url: base_url+'admin_routine/delete_routine',
			data:{id:id},
			success:function(response){
				location.reload();
			}
		});
		
	});
	
});

</script>
