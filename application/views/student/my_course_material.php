<section class="content-header">
   <section class="content">
     <div class="box box-info custom_box">
       <div class="box-header">
         <h3 class="box-title"><i class="fa  fa-file-pdf-o"></i> <?php echo $this->lang->line('my course material');?></h3>
       </div><!-- /.box-header -->
       <!-- form start -->
          <div class="box-body background_white">

          <?php
        $temp = count($info); // variable $temp is the number of total entries in single fetch comes from database.

        if($temp>0)
        {
          echo "<table style='width:100%'class='table table-bordered table-zebra table-hover table-stripped background_white'>
          <tr>
            <th>",$this->lang->line('sl'),"</th>
								<th>",$this->lang->line('teacher'),"</th>
                <th>",$this->lang->line('course'),"</th>                    
                <th>",$this->lang->line('download'),"</th>
                     
          </tr>";

          /* $i is the number of entries from database. starts with 0. and limit is less than total number of entries of database. because i starts from 0 */

          for($i=0;$i<$temp;$i++)            
          { 
            $j=$i+1;                          // variable $j is the number of entries in real. starts with 1.
            $count =$this->uri->segment(3);  // variable $count is the number of segments after base url/controller/function. starts with 0.            
            $sl = $count+$j;                // variable $sl is the serial number will be printed on view page.

            $href=base_url()."upload/material/".$info[$i]['document_url'];	
							$title=$info[$i]['title']; 


            echo "<tr>"; //

              echo "<td>".$sl."</td>"; //

              echo "<td>"; //
                if (isset($info[$i]['teacher_name'])) 
                {
                  if(strlen($info[$i]['teacher_name'])>30)
                  echo substr($info[$i]['teacher_name'], 0, 30)."...";
                  else echo $info[$i]['teacher_name'];
                }          
              echo "</td>"; //

              echo "<td>"; //
                if (isset($info[$i]['course_name'])) 
                {
                  if(strlen($info[$i]['course_name'])>30)
                  echo substr($info[$i]['course_name'], 0, 30)."...";
                  else echo $info[$i]['course_name'];
                }          
              echo "</td>"; //

              echo "<td>";
               if (isset($title) && isset($href)) 
                  {
                    echo "<a target='_BLANK' href='{$href}'>{$title}</a>";                  
                  }
              echo "</td>"; //

                  
          }          
          echo "</table>";
          // echo  $links;

        }

        else
        {
          echo "<div class='container-fluid'>                 
            <h3> <div class='alert alert-info text-center'>",$this->lang->line('No data to show.'),"               
            </div>
          </h3>
        </div>";
        }
    ?> 
 <p><?php echo  $links;?></p>
 
    </div>
  </section>
</section>
