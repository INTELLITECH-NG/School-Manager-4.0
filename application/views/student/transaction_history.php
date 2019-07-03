<section class="content-header">
  <section class="content">
    <div class="box box-info custom_box">
      <div class="box-header">
        <h3 class="box-title">
          <i class="fa fa-money">           
          </i>
          <?php echo $this->lang->line('transaction');?>
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
            <th>",$this->lang->line('class'),"</th>
            <th>",$this->lang->line('payment method'),"</th>
            <th>",$this->lang->line('paid type'),"</th>
            <th>",$this->lang->line('amount'),"</th>
            <th>",$this->lang->line('reference no.'),"</th>    
            <th>",$this->lang->line('paid at'),"</th> 
                     
          </tr>";

          /* $i is the number of entries from database. starts with 0. and limit is less than total number of entries of database. because i starts from 0 */

          for($i=0;$i<$temp;$i++)            
          { 
            $j=$i+1;                          // variable $j is the number of entries in real. starts with 1.
            $count =$this->uri->segment(3);  // variable $count is the number of segments after base url/controller/function. starts with 0.            
            $sl = $count+$j;                // variable $sl is the serial number will be printed on view page. 
            

            echo "<tr>"; 

              echo "<td>".$sl."</td>";

              echo "<td>"; 
                if (isset($info[$i]['class_name'])) 
                {
                  if(strlen($info[$i]['class_name'])>30)
                  echo substr($info[$i]['class_name'], 0, 30)."...";
                  else echo $info[$i]['class_name'];
                }          
              echo "</td>";

              echo "<td>"; 
                if (isset($info[$i]['payment_method_name'])) 
                {
                  if(strlen($info[$i]['payment_method_name'])>30)
                  echo substr($info[$i]['payment_method_name'], 0, 30)."...";
                  else echo $info[$i]['payment_method_name'];
                }          
              echo "</td>"; 

              echo "<td>";
               if (isset($info[$i]['payment_type'])) 
                  {
                    echo $info[$i]['payment_type'];                    
                  }
              echo "</td>"; 

              echo "<td>";
               if (isset($info[$i]['total_amount'])) 
                  {
                    echo $info[$i]['total_amount'];                    
                  }
              echo "</td>";


              echo "<td>";
              if (isset($info[$i]['payment_reference_no'])) echo $info[$i]['payment_reference_no'] ; 
              echo "</td>";

              echo "<td>";
                // code for formating mysql time and date in human readable format. 
                $time = strtotime($info[$i]['date_time']);
                $myFormatForView = date("d/m/y g:i A", $time);
                if (isset($myFormatForView)) echo $myFormatForView;
              echo "</td>";    

              echo "<td>";
                if (isset($array_sum_total))  echo $array_sum_total;                      
              echo "</td>";          
            echo "</tr>";          
          }          
          echo "</table>";

        }

        else
        {
          echo "<div class='container-fluid'>                 
            <h3> <div class='alert alert-info text-center'>",$this->lang->line('no data to show.'),"               
            </div>
          </h3>
        </div>";
        }
    ?> 
<p><?php echo  $links;?></p>

    </div>
  </section>
</section>
