<form class="form-inline" style="margin-top:20px" method="POST" action="<?php echo site_url('site/students'); ?>">
  <div class="form-group">
      <input  id="student_name" value="<?php echo $this->session->userdata('public_st_student_name'); ?>" name="student_name" class="form-control" size="20" placeholder="Student's Name">
  </div> 
  <div class="form-group">                   
      <?php 
        $class_info['']='Class';                     
        echo form_dropdown('class_id',$class_info,$this->session->userdata('public_st_class_id'),'class="form-control" id="class_id"'); 
      ?>
  </div> 

  <div class="form-group">                   
      <?php 
        $dept_info['']='Group / Dept';                     
        echo form_dropdown('dept_id',$dept_info,$this->session->userdata('public_st_dept_id'),'class="form-control" id="dept_id"'); 
      ?>
  </div> 

  <div class="form-group">
       <?php 
        $session_info['']='Session'; 
        echo form_dropdown('session_id',$session_info,$this->session->userdata('public_st_session_id'),'class="form-control" id="session_id"'); 
       ?>
  </div> 

  <button class='btn btn-info' name="search"  type="submit"><?php echo $this->lang->line('search');?></button>
</form> 


  <?php if(count($student_info)==0) echo "<div class='alert alert-info text-center'><h4>No data found</h4></div>";
  else 
  { ?>
  <div class="table-responsive">
    <table class="table table-hover table-hover table-stripped">
      <thead>
        <tr>
          <th><?php echo $this->lang->line('sl');?></th>
          <th><?php echo $this->lang->line('photo');?></th>
          <th><?php echo $this->lang->line('student id');?></th>
          <th><?php echo $this->lang->line('name');?></th>
          <th><?php echo $this->lang->line('session');?></th>
          <th><?php echo $this->lang->line('class');?></th>
          <th><?php echo $this->lang->line('section');?></th>
          <th><?php echo $this->lang->line('shift');?></th>          
        </tr>
      </thead>
      <tbody>
        <?php 
        $i=0;
        foreach($student_info as $row)
        { 
          $i++;
          echo "<tr>";
            echo "<td>";
              echo $i;
            echo "</td>";
            echo "<td>";
              $src=base_url()."upload/student/".$row['image'];
              if($row['image']=="")
              $src=base_url()."assets/images/avatar/common.png";
              $name=$row['name'];
              echo "<a target='_BLANK' title='{$name}' href='{$src}'><img src='{$src}' alt='Photo' style='height:60px;width:55px;'/></a>";
            echo "</td>";
            echo "<td>";           
              echo $row['student_id'];
            echo "</td>";
            echo "<td>";           
              echo $name;
            echo "</td>";
            echo "<td>";           
              echo $row['session_name'];
            echo "</td>";
            echo "<td>";           
              echo $row['class_name']." (";                      
              echo $row['dept_name'].")";
            echo "</td>";
            echo "<td>";           
              echo $row['section_name'];
            echo "</td>";
            echo "<td>";           
              echo $row['shift_name'];
            echo "</td>";
          echo "</tr>";
        } 
        ?>
      </tbody>
    </table>
  </div>
  <?php
  }
  echo '<h4  class="pagination_link">'.$pages.'</h4>';
  ?>