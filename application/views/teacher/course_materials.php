<?php $this->load->view('teacher/theme_teacher/message'); ?>
<section class="content-header">
  <section class="content">
  <?php //if(in_array(2,$this->role_module_accesses_2)): ?> 
  <a class="btn btn-warning"  title="Upload Material" href="<?php echo site_url('teacher/upload_material');?>">
      <i class="fa fa-cloud-upload"></i> <?php echo $this->lang->line('upload material');?>
  </a><br/><br/>
  <?php //endif; ?>
    <div class="box box-info custom_box">
      <div class="box-header">
        <h3 class="box-title">
          <i class="fa  fa-file-pdf-o">         	
          </i>
          <?php echo $this->lang->line('course material');?>
        </h3>
      </div>
      <div class="box-body">
        <a href=""></a>
        <?php 
        $temp = count($info);
        if($temp>0)
        {
          echo "<table style='width:100%'class='table table-bordered table-zebra table-hover table-stripped background_white'>
          <tr>
            <th>",$this->lang->line('sl'),"</th>
            <th>",$this->lang->line('class'),"</th>
            <th>",$this->lang->line('course'),"</th>
            <th>",$this->lang->line('session'),"</th>      
            <th>",$this->lang->line('topics'),"</th>      
            <th>",$this->lang->line('download'),"</th>					
          </tr>";


          for($i=0;$i<$temp;$i++)
          {	
            $sl = $i + 1;
            
            echo "<tr>";
              echo "<td>".$sl."</td>";
              echo "<td>".$info[$i]['class_name']."</td>";
              echo "<td>".$info[$i]['course_name']."</td>";
              echo "<td>".$info[$i]['session']."</td>";                    
              echo "<td>".$info[$i]['title']."</td>";                    
              echo "<td>";
                echo "<a target='_BLANK' title='Download' href='".base_url()."upload/material/".$info[$i]['document_url']."'>".$info[$i]['document_url']."</a>";
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

    </div>
  </section>
</section>