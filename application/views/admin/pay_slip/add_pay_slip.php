<section class="content-header">
   <section class="content">
     <div class="box box-info custom_box">
       <div class="box-header">
         <h3 class="box-title"><i class="fa fa-plus-circle"></i><?php echo $this->lang->line('add pay slip'); ?> </h3>
       </div><!-- /.box-header -->
       <!-- form start -->
       <form class="form-horizontal" action="<?php echo site_url().'admin/add_pay_slip_action';?>" method="POST">
         <div class="box-body">
           <div class="form-group">
             <label class="col-sm-3 control-label" for="name"><?php echo $this->lang->line('slip name'); ?> *</label>
             <div class="col-sm-9 col-md-6 col-lg-6">
               <input name="name" value="<?php echo set_value('name');?>"  class="form-control" type="text">
               <span class="red"><?php echo form_error('name'); ?></span>
             </div>
           </div>
           <div class="form-group">
             <label class="col-sm-3 control-label" for="class_id"><?php echo $this->lang->line('class'); ?> *</label>
             <div class="col-sm-9 col-md-6 col-lg-6">
               <?php 
                $class_info['']=$this->lang->line('class'); 
                echo form_dropdown('class_id',$class_info,set_value('class_id'),'class="form-control" id="class_id"'); 
               ?>
               <span class="red"><?php echo form_error('class_id'); ?></span>
             </div>
           </div>
           <div class="form-group">
             <label class="col-sm-3 control-label" for="dept_id"><?php echo $this->lang->line('group / dept.'); ?> *</label>
             <div class="col-sm-9 col-md-6 col-lg-6">
               <?php 
                $dept_info['']=$this->lang->line('group / dept.'); 
                echo form_dropdown('dept_id',$dept_info,set_value('dept_id'),'class="form-control" id="dept_id"'); 
               ?>
               <span class="red"><?php echo form_error('dept_id'); ?></span>
             </div>
           </div>
           <div class="form-group">
             <label class="col-sm-3 control-label" for="session_id"><?php echo $this->lang->line('session'); ?> *</label>
             <div class="col-sm-9 col-md-6 col-lg-6">
               <?php 
                $session_info['']= $this->lang->line('session');
                echo form_dropdown('session_id',$session_info,set_value('session_id'),'class="form-control" id="session_id"'); 
               ?>
               <span class="red"><?php echo form_error('session_id'); ?></span>
             </div>
           </div>

           <div class="form-group">
             <label class="col-sm-3 control-label" for="class_id"><?php echo $this->lang->line('slip type'); ?> *</label>
             <div class="col-sm-9 col-md-6 col-lg-6">
               <?php 
                $slip_types['']=$this->lang->line('slip type');
                echo form_dropdown('slip_type',$slip_types,set_value('slip_type'),'class="form-control" id="slip_type"'); 
               ?>
               <span class="red"><?php echo form_error('slip_type'); ?></span>
             </div>
           </div>


           <div class="form-group">             
             <div class="col-sm-12">
               <h2 class='orange text-center'><?php echo $this->lang->line('grand total'); ?> : <span id="grand_total">0</span></h2>
               <hr>
             </div>
           </div>

           <div class="form-group">
             <label class="col-sm-3 control-label" for=""><?php echo $this->lang->line('account heads'); ?> *</label>
             <div class="col-sm-9 col-md-6 col-lg-6">
             
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

                      for($i=0;$i<count($heads_id_array);$i++)
                      {
                         $input_name="head_".$heads_id_array[$i];
                         echo $heads_name_array[$i];
                         echo "<input class='form-control head_amount' placeholder={$this->lang->line('Amount')} style='display:inline' type='text' name='".$input_name."' value='".set_value($input_name)."'/><br/>";
                         echo' <span class="red">'.form_error($input_name).'</span>';
                      }  
                    echo "</div>";                     
                 }  
                 $all_id_str=trim($all_id_str,"/");
                 echo "<input type='hidden' name='all_id_str' value='".$all_id_str."'/>";
               }
               else echo '<br/><span class="red" ><b>',$this->lang->line('no account head found.'),'</b></span>';
               
               ?>
               <span class="red" ><?php echo "<br/><br/>".$this->session->flashdata('head_error'); ?></span>  
              </div> 
             </div>          

           </div> <!-- /.box-body --> 
           <div class="box-footer">
            <div class="form-group">
             <div class="col-sm-12 text-center">
               <?php if(count($heads)>0){ ?>
               <input name="submit" type="submit" class="btn btn-warning btn-lg" value=<?php echo $this->lang->line("save");?>>   
               <?php } ?>      
               <input type="button" class="btn btn-default btn-lg" value=<?php echo $this->lang->line("cancel");?> onclick='goBack("admin/pay_slips",0)'/>
             </div>
           </div>
         </div><!-- /.box-footer -->         
         </div><!-- /.box-info -->       
       </form>     
     </div>
   </section>
</section>

<script>
$j("document").ready(function(){
  $(".head_amount").change(function(){  
    var grand_total=0;
    $('.head_amount').each(function(i){    
        if($(this).val()!='')
        grand_total=grand_total+ parseFloat($(this).val());
      }); 
    $("#grand_total").html(grand_total);
  });
});
</script>
