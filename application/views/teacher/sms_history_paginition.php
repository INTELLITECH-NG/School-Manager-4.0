<section class="content-header">
  <section class="content">
    <div class="box box-info custom_box">
      <div class="box-header">
        <h3 class="box-title">
          <i class="fa fa-plus-circle">         	
          </i>
          <?php echo $this->lang->line('my notification');?>
        </h3>
      </div>
      <div class="box-body">
        <?php 
        $temp = count($info);
        if($temp>0)
        {
          echo "<table style='width:100%'class='table table-bordered table-zebra table-hover table-stripped background_white'>
          <tr>
            <th>",$this->lang->line('sl'),"</th>
            <th>",$this->lang->line('subject'),"</th>
            <th>",$this->lang->line('message'),"</th>
            <th>",$this->lang->line('type'),"</th>
            <th>",$this->lang->line('time'),"</th>         
            <th>",$this->lang->line('actions'),"</th>   			
          </tr>";


          for($i=0;$i<$temp;$i++)
          {	
            $j=$i+1;
            $count =$this->uri->segment(3);            
            $sl = $count+$j;
            $time = strtotime($info[$i]['sent_at']);
            $myFormatForView = date("d/m/y g:i A", $time);

            echo "<tr>";
              echo "<td>".$sl."</td>";
              echo "<td>";
                if (isset($info[$i]['title'])) 
                {
                  if(strlen($info[$i]['title'])>30)
                  echo substr($info[$i]['title'], 0, 30)."...";
                  else echo $info[$i]['title'];
                }          
              echo "</td>";
              echo "<td>";
                if (isset($info[$i]['title'])) 
                {
                  if(strlen($info[$i]['message'])>30)
                  echo substr($info[$i]['message'], 0, 30)."...";
                  else echo $info[$i]['message'];
                }          
              echo "</td>";
              echo "<td>".$info[$i]['type']."</td>";
              echo "<td>".$myFormatForView."</td>";
              echo "<td>";
                $src=base_url("plugins/grocery_crud/themes/flexigrid/css/images/magnifier.png");
                $details_url=site_url("teacher/details_notification").'/'.$info[$i]['id'];
                echo "<a href='".$details_url."' title='Details'><img src='".$src."' alt='Details'></a>";                        
              echo "</td>";          
            echo "</tr>";          
          }          
          echo "</table>";

        }

        else
        {
          echo "<div class='container-fluid'>                 
            <h3> <div class='alert alert-info text-center'>
               ",$this->lang->line('no data to show.'),"
            </div>
          </h3>
        </div>";
        }
    ?> 
 <p><?php echo $links; ?></p>

    </div>
  </section>
</section>