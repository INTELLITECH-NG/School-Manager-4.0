<?php //echo "<pre>"; print_r($info); exit(); ?>

<section class="content-header">
  <section class="content">
    <div class="box box-info custom_box">
      <div class="box-header">
        <h3 class="box-title">
          <i class="fa fa-money">           
          </i>
          <?php echo $this->lang->line('marks detail');?>
        </h3>
      </div>
      <div class="box-body">
        <?php       
        $temp = count($info); // variable $temp is the number of total entries in single fetch comes from database.
        if($temp>0)
        {
          echo "<table style='width:100%'class='table table-bordered table-zebra table-hover table-stripped background_white'>
          <tr>
            <th>",$this->lang->line('sl'),"</th>
            <th>",$this->lang->line('course id'),"</th>
            <th>",$this->lang->line('course'),"</th>
            <th>",$this->lang->line('department'),"</th>
            <th>",$this->lang->line('session'),"</th>
            <th>",$this->lang->line('mark'),"</th>    
            <th>",$this->lang->line('grade point'),"</th> 
            <th>",$this->lang->line('grade'),"</th> 
                     
          </tr>";

          /* $i is the number of entries from database. starts with 0. and limit is less than total number of entries of database. because i starts from 0 */
         
        
          for($i=0;$i<$temp;$i++)            
          { 
           

        //    $j=$i+1;                          // variable $j is the number of entries in real. starts with 1.
        //    $count =$this->uri->segment(3);  // variable $count is the number of segments after base url/controller/function. starts with 0.            
        //    $sl = $count+$j;                // variable $sl is the serial number will be printed on view page. 
        	  $sl = $i+1;	    

            echo "<tr>"; 

              echo "<td>".$sl."</td>";

              echo "<td>"; 
                if (isset($info[$i]['course_id'])) 
                {
                  if(strlen($info[$i]['course_id'])>30)
                  echo substr($info[$i]['course_id'], 0, 30)."...";
                  else echo $info[$i]['course_id'];
                }          
              echo "</td>";

              echo "<td>"; 
                if (isset($info[$i]['course_name'])) 
                {
                  if(strlen($info[$i]['course_name'])>30)
                  echo substr($info[$i]['course_name'], 0, 30)."...";
                  else echo $info[$i]['course_name'];
                }          
              echo "</td>"; 

              echo "<td>";
               if (isset($info[$i]['dept_name'])) 
                  {
                    echo $info[$i]['dept_name'];                    
                  }
              echo "</td>"; 

              echo "<td>";
               if (isset($info[$i]['session_name'])) 
                  {
                    echo $info[$i]['session_name'];                    
                  }
              echo "</td>";


              echo "<td>";
              if (isset($info[$i]['obtained_mark'])) echo $info[$i]['obtained_mark'] ; 
              echo "</td>";

              echo "<td>";
              if (isset($info[$i]['grade_point'])) echo $info[$i]['grade_point'] ; 
              echo "</td>";

              echo "<td>";
              if(isset($info[$i]['grade'])) echo $info[$i]['grade'];
              echo "</td>";                   
            echo "</tr>";          
          }          
          echo "</table>";
        }       
    ?> 
<!-- <p><?php echo  $links;?></p> -->

    </div>
  </section>
</section>
