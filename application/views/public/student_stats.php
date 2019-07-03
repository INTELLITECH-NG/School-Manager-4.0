<br/>
<form class="form-inline" style="margin-top:20px" method="POST" action="<?php echo site_url('site/dept_seat'); ?>">
   <div class="form-group">
       <?php 
        $session_info['']= $this->lang->line('session'); 
        echo form_dropdown('session_id',$session_info,$this->session->userdata('public_seat_session_id'),'class="form-control" id="session_id"'); 
       ?>
  </div> 
  <button class='btn btn-info' name="search"  type="submit"><?php echo $this->lang->line('search');?></button>
</form> 

<?php
	echo "<div class='table-responsive'><table style='width:100%'class='table table-zebra table-hover'>
          <tr>
            <th>",$this->lang->line('sl'),"</th>
            <th>",$this->lang->line('class'),"</th>
            <th>",$this->lang->line('group/dept'),"</th>
            <th>",$this->lang->line('no. of seats'),"</th>
            <th>",$this->lang->line('no. of admitted students'),"</th>            					
                   					
          </tr>";
          $total_seat = 0;
          $total_student = 0;
          $sl=1;
          foreach ($info as  $value) 
          {
          	if($value['seat']!=0)
          	{
          	echo "<tr>";
          	echo "<td>".$sl."</td>";
          	echo "<td>".$value['class_name']."</td>";
          	echo "<td>".$value['dept_name']."</td>";
          	echo "<td>".$value['seat']."</td>";          
          	echo "<td>".$value['num_student']."</td>";          
          	echo "</tr>";
          	$sl++;
            $total_student = $total_student + $value['num_student'];
            $total_seat = $total_seat + $value['seat'];
            }
           	
          
		 }
		 echo "<tr>";
  	echo "<td></td>";
  	echo "<td></td>";
  	echo "<td></td>";
  	echo "<td><b>",$this->lang->line('total'),": ".$total_seat."</b></td>";          
  	echo "<td><b>",$this->lang->line('total'),": ".$total_student ."</b></td>";          
    echo "</tr>";
  	echo "</table></div>";

 ?>