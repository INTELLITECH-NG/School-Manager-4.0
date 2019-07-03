<?php //echo "<pre>"; print_r($info3);  ?>

<section class="content-header">
  <section class="content">
    <div class="box box-info custom_box">
      <div class="box-header">
        <h3 class="box-title">
          <i class="fa fa-money">           
          </i>
          <?php echo $this->lang->line('marks');?>
        </h3>
      </div>
      <div class="box-body">
        <?php 
          $temp = count($info3);// variable $temp is the number of total entries in single fetch comes from database.
          if($temp==0 )
          echo "<div class='container-fluid'>                 
                <h3> <div class='alert alert-info text-center'>
                   No data to show.
                </div>
              </h3>
            </div>"; 
          else
          {  
            echo "<table style='width:100%'class='table table-bordered table-zebra table-hover table-stripped background_white'>
                <tr>
                  <th>",$this->lang->line('sl'),"</th>
                  <th>",$this->lang->line('class'),"</th>
                  <th>",$this->lang->line('term'),"</th>
                  <th>",$this->lang->line('gpa'),"</th>
                  <th>",$this->lang->line('grade'),"</th>
                  <th>",$this->lang->line('details'),"</th>                                     
              </tr>";
            for($i=0; $i<$temp; $i++)
            { 
              
                /* $i is the number of entries from database. starts with 0. and limit is less than total number of entries of database. because i starts from 0 */

                for($i=0;$i<$temp;$i++)                      
                { 
                   
                 // $j=$i+1;                          // variable $j is the number of entries in real. starts with 1.
                 // $count =$this->uri->segment(3);  // variable $count is the number of segments after base url/controller/function. starts with 0.            
                 // $sl = $count+$j;                // variable $sl is the serial number will be printed on view page. 
                  $sl = $i+1;
                  

                  echo "<tr>"; 

                    echo "<td>".$sl."</td>";

                    echo "<td>"; 
                      if (isset($info4)) 
                      {
                        if(strlen($info4)>30)
                        echo substr($info4, 0, 30)."...";
                        else echo $info4;
                      }          
                    echo "</td>";

                    

                    echo "<td>"; 
                      if (isset($info3[$i]['exam_name'])) 
                      {
                        if(strlen($info3[$i]['exam_name'])>30)
                        echo substr($info3[$i]['exam_name'], 0, 30)."...";
                        else echo $info3[$i]['exam_name'];
                      }          
                    echo "</td>"; 

                    echo "<td>";
                     if (isset($info3[$i]['obtained_gpa'])) 
                        {
                          echo $info3[$i]['obtained_gpa'];                    
                        }
                    echo "</td>"; 

                    echo "<td>";
                     if (isset($info3[$i]['grade_name'])) 
                        {
                          echo $info3[$i]['grade_name'];                    
                        }
                    echo "</td>";

                    echo "<td>";
                      $src=base_url("plugins/grocery_crud/themes/flexigrid/css/images/magnifier.png");
                      $details_url=site_url("student/show_marks_details").'/'.$info3[$i]['id'];
                      echo "<a href='".$details_url."' title='Details'><img src='".$src."' alt='Details'></a>";                        
                    echo "</td>";                       
                }          
                echo "</tr>";         
             
           } 
            echo "</table>"; 
          } 
                  
        ?> 
<!-- <p><?php echo  $links;?></p>
 -->
    </div>
  </section>
</section>
