<form class="form-inline" style="margin-top:20px" method="POST" action="<?php echo site_url('site/books'); ?>">
  <div class="form-group">
      <input  id="title" name="title" class="form-control" size="20" placeholder="Title">
  </div> 
  <div class="form-group">
      <input  id="author" name="author" class="form-control" size="20" placeholder="Author">
  </div>
  <div class="form-group">
      <input  id="category_name" name="category_name" class="form-control" size="20" placeholder="Category">
  </div>
  
  <button class='btn btn-info' name="search"  type="submit"><?php echo $this->lang->line('search');?></button>
</form> 


  <?php if(count($book_info)==0) echo "<div class='alert alert-warning text-center'><h4>No data found</h4></div>";
  else 
  { ?>
  <div class="table-responsive">
    <table class="table table-hover table-hover table-stripped">
      <thead>
        <tr>
          <th><?php echo $this->lang->line('sl');?></th>
          <th><?php echo $this->lang->line('isbn');?></th>
          <th><?php echo $this->lang->line('title');?></th>         
          <th><?php echo $this->lang->line('author');?></th>         
          <th><?php echo $this->lang->line('category');?></th>         
          <th><?php echo $this->lang->line('publication');?></th>         
          <th><?php echo $this->lang->line('series');?></th>         
          <th><?php echo $this->lang->line('available');?></th>         
        </tr>
      </thead>
      <tbody>
        <?php 
        $i=0;
        foreach($book_info as $row)
        { 
          $i++;
          echo "<tr>";
            echo "<td>";
              echo $i;
            echo "</td>";
            echo "<td>";           
              if(isset($row['isbn'])) echo $row['isbn'];
            echo "</td>";
            echo "<td>";           
              if(isset($row['title'])) echo $row['title'];
              if($row['subtitle']!="") echo "<br/>".$row['subtitle'];
            echo "</td>";
            echo "<td>";           
              if(isset($row['author'])) echo $row['author'];
            echo "</td>";
            echo "<td>";           
              if(isset($row['category_name'])) echo $row['category_name'];
            echo "</td>";
            echo "<td>";           
              if(isset($row['publisher'])) echo $row['publisher']; if(isset($row['publishing_year'])) echo " ",$row['publishing_year'];
            echo "</td>";
            echo "<td>";           
              if(isset($row['series'])) echo $row['series'];
            echo "</td>";
            echo "<td>";           
               if($row['status']=="1") echo "<span class='label label-success'>",$this->lang->line('yes'),"</span>";
               else   echo "<span class='label label-warning'>",$this->lang->line('no'),"</span>";
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