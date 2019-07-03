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


<section class="content-header">
  <section class="content"> 
  <div class="box box-info custom_box">   
      <div class="box-header">
        <h3 class="box-title">
          <i class="fa fa-plus-circle"></i>
          <?php echo $this->lang->line('student wise report');?>
        </h3>
      </div>

      <div class="box-body">
           <form class="form-inline" role="form" method="POST" action="<?php echo site_url()."admin_account/student_wise"; ?>">
            <div class="form-group">             
              <input type="text" class="form-control small" id="name" name= "name" placeholder="<?php echo $this->lang->line('Name');?>">                        
            </div>

            <div class="form-group">  
              <?php 
              $classes['']=$this->lang->line("Class");
              echo form_dropdown('classes',$classes,set_value('classes'),'class="form-control" name="classes"');  
             ?>           
                         
            </div>

            <div class="form-group">             
             
               <?php 
                 $payment_type['']=$this->lang->line("Payment Type");
                 echo form_dropdown('payment_type',$payment_type,set_value('payment_type'),'class="form-control" name="payment_type"');  
               ?>         
            </div>

            <div class="form-group">             
              <input id="datepicker1" name="from_date" class="form-control small" type="text" placeholder="<?php echo $this->lang->line('From Date');?>">
                      
            </div>
            <div class="form-group">             
             <input id="datepicker2" name="to_date" class="form-control small" type="text"  placeholder="<?php echo $this->lang->line('To Date');?>" >
              <input type="submit" class="form-control btn-info" name="search" value= "<?php echo $this->lang->line('Search');?>">              
            </div>  
   
          </form> 
          <a class="btn btn-warning pull-right" target="_BLANK" title="Download" href="<?php echo site_url('admin_account/student_wise_download');?>">
            <i class="fa fa-download"></i> <?php echo $this->lang->line('Download');?>
          </a> 
          <br/><br/> 
            
        <div class="table-responsive">
        <table class='table table-bordered table-zebra table-hover table-stripped'>

        <?php
        if(empty($info_concat))
        {
          echo "<h3>
                  <div class='alert alert-info text-center'>"
                  .$this->lang->line('No data to show.').
                  "</div>
                </h3>"; 
        }
        else
        {
          echo "<tr>
                  <th>SL</th>
                  <th>Name</th>";
          $head_names = explode(',',$info_concat[0]['heads_name']);
          foreach($head_names as $key=>$value)
          {
            echo "<th>".$value."</th>";
          }
          echo "<th>Total Amount</th>
                </tr>";

          $serial_count = 0;
          foreach($info_concat as $value)
          {
            $serial_count++;
            echo "<tr>
                    <th>".$serial_count."</th>
                    <th>".$value['name']."</th>";

            $head_amounts = explode(',',$value['slip_amount']);
            foreach($head_amounts as $index=>$amount)
            {
              echo "<th>".$amount."</th>";
            }
            echo "<th>".$value['total_amount_2']."</th>
                  </tr>";

          }
              

        }
        ?>
        </table>
        <?php if(isset($links) && $links!="") echo '<h4  class="pagination_link"><b>Pages: </b>'.$links.'</h4>'; ?> 
        </div>  
         
      </div>
  </section>
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

