<form class="form-inline" style="margin-top:20px" method="POST" action="<?php echo site_url('site/teachers'); ?>">
  <div class="form-group">
      <input  id="teacher_name" name="teacher_name" class="form-control" size="20" placeholder="Teacher's Name">
  </div> 
  <div class="form-group">                   
      <?php 
        $rank_info['']='Designation';                     
        echo form_dropdown('rank_id',$rank_info,"",'class="form-control" id="rank_id"'); 
      ?>
  </div> 
  <button class='btn btn-info' name="search"  type="submit"><?php echo $this->lang->line('search');?></button>
</form> 


  <?php if(count($teacher_info)==0) echo "<div class='alert alert-warning text-center'><h4>", $this->lang->line('No data found'),"</h4></div>";
  else 
  { ?>
  <div class="table-responsive">
    <table class="table table-hover table-hover table-stripped">
      <thead>
        <tr>
          <th><?php echo $this->lang->line('sl');?></th>
          <th><?php echo $this->lang->line('photo');?></th>
          <th><?php echo $this->lang->line('teacher id');?></th>
          <th><?php echo $this->lang->line('name');?></th>         
          <th><?php echo $this->lang->line('rank');?></th>         
          <th><?php echo $this->lang->line('mobile');?></th>         
          <th><?php echo $this->lang->line('email');?></th>         
          <th><?php echo $this->lang->line('profile');?></th>         
        </tr>
      </thead>
      <tbody>
        <?php 
        $i=0;
        foreach($teacher_info as $row)
        { 
          $i++;
          echo "<tr>";
            echo "<td>";
              echo $i;
            echo "</td>";
            echo "<td>";
              $image=base_url('upload/teacher').'/'.$row['image'];
              if($row['image']=="")
              $image=base_url()."assets/images/avatar/common.png";
              $name=$row['teacher_name'];
              $teacher_id=$row['id'];
              echo "<a target='_BLANK' title='{$name}' href='{$image}'><img src='{$image}' alt='Photo' style='height:60px;width:55px;'/></a>";
            echo "</td>";
            echo "<td>";           
              echo $row['teacher_no'];
            echo "</td>";
            echo "<td>";           
              echo $name;
            echo "</td>";
            echo "<td>";           
              echo $row['rank_name'];
            echo "</td>";            
            echo "<td>";           
              echo $row['mobile'];
            echo "</td>";
            echo "<td>";           
              echo $row['email'];
            echo "</td>";
            echo "<td>";   
              $profile_url=site_url("site/teacher_profile/".$teacher_id);        
              echo "<a href='{$profile_url}'><i class='fa fa-binoculars'></i> Profile</a>";
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