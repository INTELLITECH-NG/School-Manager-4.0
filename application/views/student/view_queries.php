
<?php $this->load->view('student/theme_student/message'); ?>  
<section class="content-header">
  <section class="content">
  <?php //if(in_array(2,$this->role_module_accesses_2)): ?> 
  <a class="btn btn-warning"  title="Send Query" href="<?php echo site_url('student/send_query_form');?>">
      <i class="fa fa-envelope"></i> <?php echo $this->lang->line('send query');?>
  </a><br/><br/>
  <?php //endif; ?>
    <div class="box box-info custom_box">
      <div class="box-header">
        <h3 class="box-title">
          <i class="fa fa-plus-circle">           
          </i>
          <?php echo $this->lang->line('query/complain');?>
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
            <th>",$this->lang->line('subject'),"</th>
            <th>",$this->lang->line('message'),"</th>
            <th>",$this->lang->line('sent at'),"</th>
            <th>",$this->lang->line('status'),"</th>    
            <th>",$this->lang->line('replied'),"</th> 
            <th>",$this->lang->line('actions'),"</th>          
          </tr>";

          /* $i is the number of entries from database. starts with 0. and limit is less than total number of entries of database. because i starts from 0 */

          for($i=0;$i<$temp;$i++)            
          { 
            $j=$i+1;                          // variable $j is the number of entries in real. starts with 1.
            $count =$this->uri->segment(3);  // variable $count is the number of segments after base url/controller/function. starts with 0.            
            $sl = $count+$j;                // variable $sl is the serial number will be printed on view page. 
            

            echo "<tr>"; //

              echo "<td>".$sl."</td>"; //

              echo "<td>"; //
                if (isset($info[$i]['message_subject'])) 
                {
                  if(strlen($info[$i]['message_subject'])>30)
                  echo substr($info[$i]['message_subject'], 0, 30)."...";
                  else echo $info[$i]['message_subject'];
                }          
              echo "</td>"; //

              echo "<td>"; //
                if (isset($info[$i]['message_body'])) 
                {
                  if(strlen($info[$i]['message_body'])>30)
                  echo substr($info[$i]['message_body'], 0, 30)."...";
                  else echo $info[$i]['message_body'];
                }          
              echo "</td>"; //

              echo "<td>";
               if (isset($info[$i]['sent_at'])) 
                  {
                    $time = strtotime($info[$i]['sent_at']);
                    $myFormatForView = date("d/m/y g:i A", $time);                    
                    if (isset($myFormatForView)) echo $myFormatForView;
                  }
              echo "</td>"; //

              echo "<td>";
              if( $info[$i]['replied'] == "1") echo "<span class='label label-success'>Replied</span>"; 
                  else echo "<span class='label label-warning'>Pending</span>"; 
              echo "</td>";

              echo "<td>";
                if (isset($info[$i]['reply_at'])) 
                    {                 
                      if ($info[$i]['reply_at'] == "0000-00-00 00:00:00")  echo "";                  
                      else
                      {               
                        $time1 = strtotime($info[$i]['reply_at']);
                        $myFormatForView1 = date("d/m/y g:i A", $time1);                    
                        if (isset($myFormatForView1))  echo $myFormatForView1;                    
                      }
                    }
              echo "</td>";    

              echo "<td>";
                $src=base_url("plugins/grocery_crud/themes/flexigrid/css/images/magnifier.png");
                $details_url=site_url("student/details_query").'/'.$info[$i]['id'];
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
               No data to show.
            </div>
          </h3>
        </div>";
        }
    ?> 
<p><?php echo  $links;?></p>

    </div>
  </section>
</section>
