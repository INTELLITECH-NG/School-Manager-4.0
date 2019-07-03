<style type="text/css">
  h4.pagination_link
{
font-size: 12px;
text-align: center;
font-weight: normal;
margin-top: 12px;
}

h4.pagination_link a
{
padding: 4px 7px 4px 7px;
background: #238db6;
border-radius: 5px;
color:#fff;
border:1px solid #238db6;
font-style: normal;
text-decoration: none;
}

h4.pagination_link strong
{
padding: 4px 7px 4px 7px;
background: #E95903;
border-radius: 5px;
color:#fff;
border:1px solid #E95903;
font-style: normal;
}

h4.pagination_link a:hover
{
background: #77a2cc;
border:1px solid #77a2cc; 
color: #fff;
}
</style>
<section class="content"> 
  <div class="box box-info custom_box">   
      <div class="box-header">
        <h3 class="box-title">
          <i class="fa fa-plus-circle"></i>
          <?php echo $this->lang->line('brief history');?>
        </h3>
      </div>

      <div class="box-body">
           <form class="form-inline" role="form" method="POST" action="<?php echo site_url()."admin_account/brief"; ?>">
            <div class="form-group">             
              <input type="text" class="form-control" id="name" name= "name" placeholder="<?php echo $this->lang->line('Name');?>">                         
            </div>

            <div class="form-group">  
              <?php 
                $classes['']=$this->lang->line("class");
                echo form_dropdown('classes',$classes,set_value('classes'),'class="form-control" name="classes"');  
              ?>                          
            </div>

            <div class="form-group">            
               <?php 
                 $payment_type['']=$this->lang->line("payment type");
                 echo form_dropdown('payment_type',$payment_type,set_value('payment_type'),'class="form-control" name="payment_type"');  
               ?>         
            </div>

            <div class="form-group">             
              <input id="datepicker1" name="from_date" class="form-control" type="text" placeholder="<?php echo $this->lang->line('From Date');?>">                      
            </div>

            <div class="form-group">             
             <input id="datepicker2" name="to_date" class="form-control" type="text"  placeholder="<?php echo $this->lang->line('To Date');?>" >
             <input type="submit" class="form-control btn-info" name="search" value= "<?php echo $this->lang->line('search');?>">              
            </div>                       
          </form> 

          <div class="text-right"><a class="btn btn-warning"  title="Download" href="<?php echo site_url('admin_account/brief_download');?>">
    <i class="fa fa-download"></i> <?php echo $this->lang->line('download');?>
</a></div>
           <br/>
        <div class="table-responsive">
        <table class='table table-bordered table-zebra table-hover table-stripped background_white'>
          <tr>
            <th><?php echo $this->lang->line('sl');?></th>
            <th><?php echo $this->lang->line('Name');?></th>
            <th><?php echo $this->lang->line('Class');?></th>
            <th><?php echo $this->lang->line('Accounts heads');?></th>
            <th><?php echo $this->lang->line('Amount');?></th>
            <th><?php echo $this->lang->line('Total amount');?></th>
            <th><?php echo $this->lang->line('Payment type');?></th>         
            <th><?php echo $this->lang->line('date');?></th>					
          </tr>  
      <?php
        $sum = 0; 
        $serial_count =0;                       
         foreach ($info as $value) 
             {
               $serial_count++;
               $count =$this->uri->segment(3);
               $sl = $count + $serial_count; 
              
              for($i=0;$i<=$count;$i++){
                   $sum = $sum + $total_rows_array[$i]['total_amount_2'];
                  }

              echo "<tr>
                      <td>".$sl."</td>
                      <td>".$value['name']."</td>
                      <td>".$value['class_name']."</td>
                      <td>".$value['heads_name']."</td>
                      <td>".$value['total_amount_2']."</td>
                      <td>".$sum."</td>
                      <td>".$value['payment_type']."</td>
                      <td>".$value['date_time']."</td>                     
                   </tr>";   
              
            } 

           
        ?>
                     
        </table>
        <?php if(isset($links) && $links!="") echo '<h4  class="pagination_link"><b>Pages: </b>'.$links.'</h4>'; ?> 
        </div>       
     
      </div>
  </section>



<script>
$j("document").ready(function(){
  //for date picker in the input section.
    var todate="<?php echo date('Y');?>";
    var from=todate-70;
    var to=todate-12;
    var str=from+":"+to;
   $('#datepicker1').datepicker({format: "dd-mm-yyyy"});    
   $('#datepicker2').datepicker({format: "dd-mm-yyyy"});    
       

});

</script>

