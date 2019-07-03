<section class="content-header">
   <section class="content">
     <div class="box box-info custom_box">
       <div class="box-header">
         <h3 class="box-title"><i class="fa fa-binoculars"></i> <?php echo $this->lang->line('details pay slip'); ?></h3>
       </div><!-- /.box-header -->
       <!-- form start -->
       <form class="form-horizontal" action="<?php echo site_url().'admin/update_pay_slip_action';?>" method="POST">
         <div class="box-body">
          
          <div class="col xs-12 col-sm-12 col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2 well background_white no_radius text-center">
            <h4 class='blue'><?php echo $xdata_slip[0]['slip_type']; ?> Slip: <?php echo $xdata_slip[0]['slip_name'];?></h3>
            <h3 class='orange'><?php echo $this->lang->line('grand total'); ?> : <?php echo number_format($xdata_slip[0]['total_amount']);?></h4>
            <h4><?php echo $this->lang->line('class'); ?> : <?php echo $xdata_slip[0]['class_name'];?> (<?php echo $xdata_slip[0]['dept_name'];?>) , <?php echo $this->lang->line('session'); ?>: <?php echo $xdata_slip[0]['session_name'];?></h4>
          </div>
          
           <div class="col xs-12 col-sm-12 col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2">
             <?php
               $all_id_str="";
               if(count($heads)>0)
               {
                 foreach($heads as $head)
                 {  
                    echo "<br/>";
                    echo "<div style='padding:15px; background:#fefefe; border:1px solid #ccc;'>";
                      echo "<span class='blue'><b>".$head['type']."</b></span>";                  
                      echo "<hr/>";               

                      $heads_id_array=array();
                      $heads_name_array=array();
                      $heads_id_array=explode('/',$head['account_head']);
                      $heads_name_array=explode('/',$head['account_name']);  
                      $all_id_str=$all_id_str.$head['account_head']."/";

                      echo "<table class='table table-bordered table-hover table-stripped'>";
                        echo "<tr>";
                          echo "<th style='background:#fffddd;' >";
                            echo $this->lang->line("account name");
                          echo "</th>";
                          echo "<th class'text-right' style='background:#fffddd;'>";
                            echo $this->lang->line("amount");
                          echo "</th>";
                         echo "</tr>";
                         $total=0;
                         for($i=0;$i<count($heads_id_array);$i++)
                          {
                             $input_name="head_".$heads_id_array[$i];

                             $input_value=0;
                             if(array_key_exists($heads_id_array[$i],$xdata_account_head)) 
                             $input_value=$xdata_account_head[$heads_id_array[$i]];
                              $total+=$input_value;

                              echo "<tr>";
                              echo "<td>";
                                echo $heads_name_array[$i];
                              echo "</td>";
                              echo "<td class='text-right'>";
                                echo number_format($input_value);
                              echo "</td>";
                             echo "</tr>";
                          }  
                           echo "<tr>";
                              echo "<td colspan='2' class='text-right'>";
                                echo "Total : ".number_format($total);
                              echo "</td>";
                           echo "</tr>";
                         echo "</table>";
                        echo "</div>";                     
                  }  
                 
               }
               else echo '<br/><span class="red" ><b>',$this->lang->line('no account head found.'),'</b></span>';
               
               ?>             
             </div>                    

           </div> <!-- /.box-body --> 
           <div class="box-footer">
            <br>
         </div><!-- /.box-footer -->         
         </div><!-- /.box-info -->       
       </form>     
     </div>
   </section>
</section>

