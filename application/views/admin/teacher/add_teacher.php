<?php $this->session->set_userdata('count',"1");?>
<section class="content-header">
   <section class="content">
     <div class="box box-info custom_box">
       <div class="box-header">
         <h3 class="box-title"><i class="fa fa-plus-circle"></i> <?php echo $this->lang->line("add teacher");?></h3>
       </div><!-- /.box-header -->
       <!-- form start -->
        
         <form class="form-horizontal" enctype="multipart/form-data" action="<?php echo site_url().'admin_teacher/add_teacher_action';?>" method="POST" >
          <div class="box-body">

           <div class="form-group">
             <label class="col-sm-3 control-label"><?php echo $this->lang->line("name");?> *</label>
             <div class="col-sm-9 col-md-6 col-lg-6">
               <input  id ="name" class="form-control" value="<?php echo set_value('name');?>" name="name" type="text"  >
               <span class="red"><?php echo form_error('name'); ?></span>
             </div>
           </div>

           <div class="form-group">
             <label class="col-sm-3 control-label"><?php echo $this->lang->line("father's name");?> *</label>
             <div class="col-sm-9 col-md-6 col-lg-6">
               <input  id="fathers_name"  class="form-control" type="text" value="<?php echo set_value('fathers_name');?>"   name="fathers_name">
               <span class="red"><?php echo form_error('fathers_name'); ?></span>
             </div>
           </div>

           <div class="form-group">
             <label class="col-sm-3 control-label"><?php echo $this->lang->line('national id no.');?> </label>
             <div class="col-sm-9 col-md-6 col-lg-6">
               <input  id="national_id" name="national_id" class="form-control" value="<?php echo set_value('national_id');?>"  type="text"  >
               <span class="red"><?php echo form_error('national_id'); ?></span>
             </div>
           </div>


           <div class="form-group">
             <label class="col-sm-3 control-label"><?php echo $this->lang->line('date of birth');?> </label>
             <div class="col-sm-9 col-md-6 col-lg-6">
               <input id="datepicker" name="dob" class="form-control" type="text"  value="<?php echo set_value('dob');?>" >
               <span class="red"><?php echo form_error('dob'); ?></span>
             </div>
           </div>


           <div class="form-group">
             <label class="col-sm-3 control-label"><?php echo $this->lang->line('religion');?></label>
             <div class="col-sm-9 col-md-6 col-lg-6">
             <?php 
              $religion['']= $this->lang->line('religion');
              echo form_dropdown('religion',$religion,set_value('religion'),'class="form-control" id="religion"');  
             ?>               
            <span class="red"><?php echo form_error('religion'); ?></span>
                         
             </div>
           </div>


           <div class="form-group">
             <label class="col-sm-3 control-label"><?php echo $this->lang->line('gender');?></label>             
             <div class="col-sm-9 col-md-6 col-lg-6">
            <?php            
             echo form_radio('gender', 'Male')."&nbsp;&nbsp;Male&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"; 
             echo form_radio('gender', 'Female')."&nbsp;&nbsp;Female"; 
             ?>
            <span class="red"><?php echo form_error('gender'); ?></span>
             </div>
           </div>

           <!-- Here Rank is the designation of a teacher: Lecturer, Proffesor, Ass. Proffesor etc. -->
           <div class="form-group">
             <label class="col-sm-3 control-label" ><?php echo $this->lang->line('rank');?> *</label>
             <div class="col-sm-9 col-md-6 col-lg-6">
             <?php 
             $academic_rank['']=$this->lang->line('rank');
             echo form_dropdown('rank',$academic_rank,set_value('rank'),'class="form-control" id="rank"');  
             ?>             
             <span class="red"><?php echo form_error('rank'); ?></span>                          
             </div>
           </div>

        <!--    Here Administrative Rank is the Administrative post: Hall Super, Provost etc. -->
         <!--   <div class="form-group">
             <label class="col-sm-3 control-label">Administrative Rank </label>
             <div class="col-sm-9 col-md-6 col-lg-6">
             <?php 
             $administrative_rank['']="Administrative Rank";
             echo form_dropdown('administrative_rank',$administrative_rank,set_value('rank'),'class="form-control" id="administrative_rank"');  
             ?>              
             <span class="red"><?php echo form_error('administrative_rank'); ?></span>                     
             </div>
           </div> -->

           <div class="form-group">
             <label class="col-sm-3 control-label"><?php echo $this->lang->line('address');?> </label>
             <div class="col-sm-9 col-md-6 col-lg-6">
              <textarea class="form-control"  id="address"  name="address"> <?php echo set_value('address'); ?></textarea>
              <span class="red"><?php echo form_error('address'); ?></span>
             </div>
           </div>

           <!-- <div class="form-group">
             <label class="col-sm-3 control-label">Home District *</label>
             <div class="col-sm-9 col-md-6 col-lg-6">
             <?php 
             $district['']=$this->lang->line("district");
             echo form_dropdown('home_district',$district,set_value('home_district'),'class="form-control" id="home_district"');  
             ?> 
             <span class="red"><?php echo form_error('home_district'); ?></span>            
             </div>
           </div> -->
           
            <div class="form-group">
             <label class="col-sm-3 control-label"><?php echo $this->lang->line('home district');?> </label>
             <div class="col-sm-9 col-md-6 col-lg-6">
               <input id="home_district"    class="form-control" type="text" value="<?php echo set_value('home_district'); ?>"  name="home_district">
               <span class="red"><?php echo form_error('home_district'); ?></span>
             </div>
           </div>

           <div class="form-group">
             <label class="col-sm-3 control-label"><?php echo $this->lang->line('mobile no.');?> *</label>
             <div class="col-sm-9 col-md-6 col-lg-6">
               <input id="mobile_no"    class="form-control" type="text" value="<?php echo set_value('mobile'); ?>"  name="mobile">
               <span class="red"><?php echo form_error('mobile'); ?></span>
             </div>
           </div>

           <div class="form-group">
             <label class="col-sm-3 control-label"><?php echo $this->lang->line('email');?> *</label>
             <div class="col-sm-9 col-md-6 col-lg-6">
               <input id="email"    class="form-control" type="email"  value="<?php echo set_value('email'); ?>" name="email" >
               <span class="red"><?php echo form_error('email'); ?></span>
             </div>
           </div>

           <div class="form-group">
             <label class="col-sm-3 control-label"><?php echo $this->lang->line('teacher id.');?>*</label>
             <div class="col-sm-9 col-md-6 col-lg-6">
               <input id="employee_no"    class="form-control" type="text"  value="<?php echo set_value('employee_no'); ?>"  name="employee_no">
               <span class="red"><?php echo form_error('employee_no'); ?></span>
             </div>
           </div>
           <div class="form-group">
             <label class="col-sm-3 control-label"><?php echo $this->lang->line('photo');?></label>
             <div class="col-sm-9 col-md-6 col-lg-6">
               <input id="photo"    class="form-control" type="file"  value="<?php echo set_value('photo'); ?>"  name="photo">
               <span class="blue"><?php echo $this->lang->line('max 200kb (jpg,png)');?></span><br/>
               <span class="red"><?php $error=$this->session->flashdata('photo_error'); echo $error['error']; ?></span>
             </div>
           </div>
           <br/><br/>
            
           <hr/>
           <h4 class="text-center"><label class="control-label orange"><?php echo $this->lang->line('educational information');?></label></h4><br/>
            <center><button type="button" id="btn1" class="btn btn-success"><i class='fa fa-plus-circle'></i> <?php echo $this->lang->line('add education');?></button></center><br/>           
            
          <div>
             <div class="form-group" id = "education_info">
               <label class="col-sm-3 col-md-1 col-lg-1 control-label"><?php echo $this->lang->line('level');?></label>
               <div class="col-sm-9 col-md-2 col-lg-2">
                 <input class="form-control exam" type="text" name="exam[]">
               </div>
               <label class="col-sm-3 col-md-1 col-lg-1 control-label"><?php echo $this->lang->line('institute');?></label>
               <div class="col-sm-9 col-md-2 col-lg-2">
                 <input class="form-control institute" type="text" name="institute[]">
               </div>
               <label class="col-sm-3 col-md-1 col-lg-1 control-label"><?php echo $this->lang->line('year');?></label>
               <div class="col-sm-9 col-md-2 col-lg-2">
                 <input class="form-control year" type="text" name="year[]">                 
               </div>
               <label class="col-sm-3 col-md-1 col-lg-1 control-label"><?php echo $this->lang->line('result');?></label>
               <div class="col-sm-9 col-md-2 col-lg-2">
                 <input class="form-control result" type="text" name="result[]">                                 
               </div>
            </div> 
          </div> <br/><br/>

          <hr/>
          <h4 class="text-center"><label class="control-label orange"><?php echo $this->lang->line('training information');?></label></h4><br/>
          <center><button type="button" id="btn2" class="btn btn-success"><i class='fa fa-plus-circle'></i> <?php echo $this->lang->line('add training');?></button></center><br/>        
          <p id ="training_error" class="red text-center"><strong><?php echo $this->session->flashdata("train_error"); ?></strong></p>
                   
           <div>
             <div class="form-group" id = "training_info">
               <label class="col-sm-3 col-md-1 col-lg-1 control-label"><?php echo $this->lang->line('title');?></label>
               <div class="col-sm-9 col-md-2 col-lg-2">
                 <input  class="form-control t_exam" type="text" name="t_exam[]" >
               </div>
               <label class="col-sm-3 col-md-1 col-lg-1 control-label"><?php echo $this->lang->line('institute');?></label>
               <div class="col-sm-9 col-md-2 col-lg-2">
                 <input class="form-control t_institute" type="text"  name="t_institute[]">
               </div>
               <label class="col-sm-3 col-md-1 col-lg-1 control-label"><?php echo $this->lang->line('year');?></label>
               <div class="col-sm-9 col-md-2 col-lg-2">
                 <input class="form-control t_year" type="text"  name="t_year[]">                 
               </div>
               <label class="col-sm-3 col-md-1 col-lg-1 control-label"><?php echo $this->lang->line('result');?></label>
               <div class="col-sm-9 col-md-2 col-lg-2">
                 <input class="form-control t_result" type="text"  name="t_result[]">                                 
               </div>
            </div> 
          </div>
         </div><!-- /.box-body --> 
         <div class="box-footer">
            <div class="form-group">
             <div class="col-sm-12 text-center">
               <input id="submit" type="submit" class="btn btn-warning btn-lg" value="<?php echo $this->lang->line('save');?>"/>  
              <input type="button" class="btn btn-default btn-lg" value="<?php echo $this->lang->line('cancel');?>" onclick='goBack("admin_teacher/teachers",0)'/>  
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
  //for date picker in the input section.
    var todate="<?php echo date('Y');?>";
    var from=todate-70;
    var to=todate-12;
    var str=from+":"+to;
    $('#datepicker').datepicker({format: "dd-mm-yyyy",changeMonth:true, changeYear:true,yearRange: str, startView: "decade" });


 $("#btn1").click(function()
    {   
    
    var exam = "<br/><br/><label class='col-sm-3 col-md-1 col-lg-1 control-label'>Level</label> <div class='col-sm-9 col-md-2 col-lg-2'><input name='exam[]' class='form-control exam' type='text'  ></div>";
    var institute = "<label class='col-sm-3 col-md-1 col-lg-1 control-label'>Institute</label> <div class='col-sm-9 col-md-2 col-lg-2'><input class='form-control institute' name='institute[]' type='text'  ></div>";
    var year = "<label class='col-sm-3 col-md-1 col-lg-1 control-label'>Year</label> <div class='col-sm-9 col-md-2 col-lg-2'><input  class='form-control year' name='year[]' type='text'  ></div>";
    var result = "<label class='col-sm-3 col-md-1 col-lg-1 control-label'>Result</label> <div class='col-sm-9 col-md-2 col-lg-2'><input class='form-control result' name='result[]' type='text'  ></div>";
    $("#education_info").append(exam+institute+year+result);
  });

  $("#btn2").click(function()
  {    

    var exam = "<br/><br/><label class='col-sm-3 col-md-1 col-lg-1 control-label'>Title</label> <div class='col-sm-9 col-md-2 col-lg-2'><input class='form-control t_exam' name='t_exam[]' type='text'  ></div>";
    var institute = "<label class='col-sm-3 col-md-1 col-lg-1 control-label'>Institute</label> <div class='col-sm-9 col-md-2 col-lg-2'><input  class='form-control t_institute' name='t_institute[]' type='text'  ></div>";
    var year = "<label class='col-sm-3 col-md-1 col-lg-1 control-label'>Year</label> <div class='col-sm-9 col-md-2 col-lg-2'><input  class='form-control t_year' name='t_year[]' type='text '  ></div>";
    var result = "<label class='col-sm-3 col-md-1 col-lg-1 control-label'>Result</label> <div class='col-sm-9 col-md-2 col-lg-2'><input   class='form-control t_result' type='text' name='t_result[]'  ></div>";
    $("#training_info").append(exam+institute+year+result);    
  });
    

});

</script>