<br/>
<form class="form-inline" style="margin-top:20px" method="POST" action="<?php echo site_url('site/show_stat_course'); ?>">
   <div class="form-group">
       <?php 
        $session_info['']=$this->lang->line('session'); 
        echo form_dropdown('session_id',$session_info,$this->session->userdata('public_cr_session_id'),'class="form-control" id="session_id"'); 
       ?>
  </div> 
  <button class='btn btn-info' name="search"  type="submit"><?php echo $this->lang->line('search');?></button>
</form> 

<?php 
    $i=0;
    foreach ($result1 as $value)
     {
        echo"<h4 class='blue'>".$value['class_name']."</h4>";
        $course_num = count($info[$i]);       
        
        echo "<div class='table-responsive'><table style='width:100%'class='table table-bordered table-zebra table-hover table-stripped background_white'>
          <tr>
            <th>", $this->lang->line('sl'),"</th>           
            <th>", $this->lang->line('group/dept'),"</th>
            <th>", $this->lang->line('course code'),"</th>
            <th>", $this->lang->line('course name'),"</th>                                
            <th>", $this->lang->line('marks'),"</th>                          
          </tr>";
          if($course_num!=0)
          {
            $sl =1;
            for($j=0;$j<$course_num;$j++){
              echo "<tr>";
              echo "<td>".$sl."</td>";
              echo "<td>".$info[$i][$j]['dept_name']."</td>";
              echo "<td>".$info[$i][$j]['course_code']."</td>";
              echo "<td>".$info[$i][$j]['course_name']."</td>";
              echo "<td>".$info[$i][$j]['marks']."</td>";
              
              echo "<tr/>";
              $sl++;
            }
           
          }
          else echo "<tr><td colspan='5' class='text-center'>",$this->lang->line('no data to show.'),"</td></tr>";
          echo "</table></div>";
        echo "<br/>";
        $i++;         
    }
   
 ?>

