<?php $this->load->view('admin/theme/message'); ?>
<?php
    // $edit_permission=0;
    // if(in_array(3,$this->role_module_accesses_2))  
    $edit_permission=1;
?>
<!-- Content Header (Page header) -->
<style type="text/css">
  @media screen and (min-width: 980px) {
      .small_select{
      width: 96px !important;
      padding-left: 5px !important;
    }
  }
</style>
<section class="content-header">
  <h1> <?php echo $this->lang->line('send notification to student/ gurdian');?></h1>  
</section>

<!-- Main content -->
<section class="content">  
  <div class="row">
    <div class="col-xs-12">
        <div class="grid_container" style="height: 500px;">
            <table 
            id="tt"  
            class="easyui-datagrid" 
            url="<?php echo base_url()."admin_sms_email/students_data"; ?>" 
            
            pagination="true" 
            rownumbers="true" 
            toolbar="#tb" 
            pageSize="10" 
            pageList="[5,10,20,50,100]"  
            fit= "true" 
            fitColumns= "true" 
            nowrap= "true" 
            view= "detailview"
            idField="id"
            >            
                <thead>
                    <tr>
                        <th field="id" checkbox="true"></th>                        
                        <th field="student_id"  sortable="true" ><?php echo $this->lang->line('student id');?></th>
                        <th field="name" sortable="true" ><?php echo $this->lang->line('name');?></th>
                        <th field="mobile" sortable="true" ><?php echo $this->lang->line('mobile');?></th>
                        <th field="email" sortable="true" ><?php echo $this->lang->line('email');?></th>
                        <th field="class_name" sortable="true" ><?php echo $this->lang->line('class');?></th>
                        <th field="dept_name" sortable="true" ><?php echo $this->lang->line('group / dept.');?></th>
                        <th field="section_name" sortable="true" ><?php echo $this->lang->line('section');?></th>
                        <th field="shift_name" sortable="true" ><?php echo $this->lang->line('shift');?></th>
                        <th field="session_name" sortable="true" ><?php echo $this->lang->line('session');?></th>                     
                        <th field="gurdian_name" sortable="true" ><?php echo $this->lang->line('gurdian');?></th>
                        <th field="gurdian_mobile" sortable="true" ><?php echo $this->lang->line('gurdian mobile');?></th>
                        <th field="gurdian_email" sortable="true" ><?php echo $this->lang->line('gurdian email');?></th>
                    </tr>
                </thead>
            </table>                        
         </div>

       <div id="tb" style="padding:3px">
            <?php $this->load->view('admin/sms_email/submenu'); ?>           
            <form class="form-inline clearfix" style="margin-top:20px">
                <!-- <div class="form-group">
                    <input  id="student_id" name="student_id" class="form-control" size="10" placeholder="Student ID" >
                </div> -->

                <div class="form-group">
                    <input  id="student_name" name="student_name" class="form-control" size="11" placeholder="<?php echo $this->lang->line('student name');?>" >
                </div>
                <div class="form-group">
                    <?php 
                      $class_info['']=$this->lang->line('class');                     
                      echo form_dropdown('class_id',$class_info,"",'class="form-control" id="s_class_id" onchange="get_department()"'); 
                    ?>
                </div>

                <div class="form-group" id="search_dept">                   
                    <?php 
                      $dept_info['']=$this->lang->line('group');                     
                      echo form_dropdown('dept_id',$dept_info,"",'class="form-control small_select" id="department_id"'); 
                    ?>
                </div> 

                <div class="form-group">
                     <?php 
                      $session_info['']=$this->lang->line('session'); 
                      echo form_dropdown('financial_year_id',$session_info,"",'class="form-control" id="financial_year_id" onchange="get_course()"'); 
                     ?>
                </div> 

                <div class="form-group">
                    <?php 
                      $shift_info['']=$this->lang->line('shift'); 
                      echo form_dropdown('shift_id',$shift_info,"",'class="form-control" id="shift_id"'); 
                    ?>
                </div>

                <div class="form-group">
                  <?php 
                    $section_info['']=$this->lang->line('section'); 
                    echo form_dropdown('section_id',$section_info,"",'class="form-control" id="sec_id"'); 
                  ?>
                </div>

                <div class="form-group" id="search_courses">
                  <select class="form-control small_select" id="course_id">
                    <option value=""><?php echo $this->lang->line('course')?></option>
                  </select>
                </div>

                <div class="form-group">
                    <input  id="from_date" name="from_date" class="form-control" size="8" placeholder="<?php echo $this->lang->line('From date')?>" onclick="select_course()"/>
                </div>

                <div class="form-group">
                    <input  id="to_date" name="to_date" class="form-control" size="7" placeholder="<?php echo $this->lang->line('To date')?>" onclick="select_course()"/>
                </div>

                <div class="form-group">
                  <select name="attendance_status" id="attendance_status" class="form-control small_select" onchange="select_course()">
                    <option value=""><?php echo $this->lang->line('select');?></option>
                    <option value="1"><?php echo $this->lang->line('absent');?></option>
                    <option value="2"><?php echo $this->lang->line('present');?></option>
                  </select>
                </div>

                <div class="form-group pull-right" style="padding-right:10px;padding-top:3px;">
                  <button class='btn btn-info'  onclick="doSearch(event)"><?php echo $this->lang->line('search');?></button>
                </div>

            </form>         
        </div>
    </div>
  </div>   
</section>



<!--Modal for Send SMS  Email-->
  
<div id="modal_send_sms_email" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 id="SMS" class="modal-title"> <i class="fa fa-envelope"></i> <b><?php echo $this->lang->line('send notification');?></b></h4>
      </div>

      <div id="modalBody" class="modal-body">        
        <div id="show_message" class="text-center"></div>
        <div class="form-group">
          <b><?php echo $this->lang->line('send to');?> *</b> <br/> 
          <input type="radio" checked="checked" name="send_to" class="send_to" value="guardian"/> <?php echo $this->lang->line('guardian');?>
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <input type="radio" name="send_to" class="send_to" value="student"/> <?php echo $this->lang->line('student');?>
        </div>
        <div class="form-group">
           <label for="sms_content"><?php echo $this->lang->line('notification type');?> *</label><br/>
           <select class="form-control" required id="message_type">
            <option value="Notification" selected="selected"><?php echo $this->lang->line('only notification');?></option>
            <option value="Email" ><?php echo $this->lang->line('email');?> &amp; <?php echo $this->lang->line('notification');?></option>
            <option value="SMS"><?php echo $this->lang->line('sms');?> &amp; <?php echo $this->lang->line('notification');?></option>
          </select>
        </div>

        <div class="form-group">
          <label for="sms_content"><?php echo $this->lang->line('subject');?> *</label><br/>
          <input type="text" id="sms_subject" required class="form-control" placeholder="Message Subject"/>
        </div>

        <div class="form-group">
          <label for="sms_content"><?php echo $this->lang->line('message');?> *</label><br/>
          <textarea name="sms_content" required style="width:100%;height:200px;" id="sms_content"></textarea>
        </div>

        <div id="text_count"></div>
     
      </div>

      <div class="modal-footer clearfix">
           <button id="send_sms_email" class="btn btn-warning pull-left" > <i class="fa fa-envelope"></i>  <?php echo $this->lang->line('send');?></button>
           <button type="button" class="btn btn-default pull-right" data-dismiss="modal"><?php echo $this->lang->line('close');?></button>
      </div>
    </div>
  </div>
</div>

<script>

    function select_course(){
      var course_id = $('#course_id').val();
      if(course_id == ''){
        $('#attendance_status').val('');
        $('.datepicker').blur().hide();
        $('#course_id').focus();
        alert('Please select course first.');
      }
    }
    
    function get_department(){
      var class_id = $("#s_class_id").val();
      var img="<img src='"+"<?php echo base_url('assets/pre-loader/Fading squares.gif');?>"+"' alt=<?php echo $this->lang->line('loading');?>...'/> <?php echo $this->lang->line('please wait');?>...";

      $("#search_dept").html(img);
      var url = "<?php echo site_url('admin_sms_email/ajax_get_dept_based_on_class');?>";
      $.ajax({
        url: url, 
        type: 'POST',  
        data: {class_id:class_id}, 
        async: false, cache: false, 
        success: function (response){
          $('#search_dept').html(response);
        }
      });
    }

    function get_course()
    {
      var img="<img src='"+"<?php echo base_url('assets/pre-loader/Fading squares.gif');?>"+"' alt=<?php echo $this->lang->line('loading');?>...'/> <?php echo $this->lang->line('please wait');?>...";
      var class_id = $("#s_class_id").val();
      var dept_id = $("#department_id").val();
      var session_id = $("#financial_year_id").val();

      if(class_id != '' && dept_id != '' && session_id != '')
      {
        $("#search_courses").html(img);
        var url = "<?php echo site_url('admin_sms_email/ajax_get_student_course');?>";
        $.ajax({
          url: url, 
          type: 'POST',  
          data: {class_id:class_id,dept_id:dept_id,session_id:session_id}, 
          async: false, cache: false, 
          success: function (response){
            $('#search_courses').html(response);
          }
        });

      }
    }   
    var base_url="<?php echo site_url(); ?>"
   
    function doSearch(event)
    {
        event.preventDefault(); 
        $j('#tt').datagrid('load',{
          student_name:          $j('#student_name').val(),
          class_id:              $j('#s_class_id').val(),
          financial_year_id:     $j('#financial_year_id').val(),
          department_id:         $j('#department_id').val(),
          course_id:             $j('#course_id').val(),
          shift_id:              $j('#shift_id').val(),
          section_id:            $j('#sec_id').val(),
          from_date:             $j('#from_date').val(),
          to_date:               $j('#to_date').val(),
          attendance_status:     $j('#attendance_status').val(),
          is_searched:      1
        });
    }

    // function sms_send_email_ui()
    // {
    //   $("#modal_send_sms_email").modal();
    // }  
    
    $j("document").ready(function(){

      var todate="<?php echo date('Y');?>";
      var from=todate-70;
      var to=todate-12;
      var str=from+":"+to;
      $('#from_date').datepicker({format: "dd-mm-yyyy",changeMonth:true, changeYear:true,yearRange: str, startView: "decade" });
      $('#to_date').datepicker({format: "dd-mm-yyyy",changeMonth:true, changeYear:true,yearRange: str, startView: "decade" });

      $("#sms_content").keyup(function(){
        var content=$("#sms_content").val();
        var length= content.length;
        var no_sms= parseInt(length)/160;
        no_sms=Math.ceil(no_sms); 
        $("#text_count").html(length+'/'+no_sms);
      });
      
      $("#send_sms_email").click(function(){      
                  
          var subject=$("#sms_subject").val();
          var content=$("#sms_content").val();
          var type= $("#message_type").val();
          var rows = $j('#tt').datagrid('getSelections');
          var info=JSON.stringify(rows);  
          var student_or_gurdian = $(".send_to:checked").val();
          
          if(rows=="") 
          {
            $("#show_message").addClass("alert alert-warning");
            $("#show_message").html("<b>"+"<?php echo $this->lang->line('you do not selected any student.');?>"+"</b>");
            return;
          }
          
          if(subject=="" || content=="" || type=="")
          {
            $("#show_message").addClass("alert alert-warning");
            $("#show_message").html('<?php echo $this->lang->line("something is missing.");?>');
            return;
          }

          $(this).attr('disabled','yes');
          $("#show_message").addClass("alert alert-info");
          $("#show_message").show().html('<i class="fa fa-spinner fa-spin"></i> '+"<?php echo $this->lang->line('sending');?>"+' '+type+', '+"<?php echo $this->lang->line('please wait');?>"+'...');
          $.ajax({
          type:'POST' ,
          url: "<?php echo site_url(); ?>admin_sms_email/student_send_sms_email",
          data:{content:content,type:type,info:info,student_or_gurdian:student_or_gurdian,subject:subject},
          success:function(response){
            $("#send_sms_email").removeAttr('disabled');                     
            $("#show_message").addClass("alert alert-info");
            $("#show_message").html(response);
          }
        });   
      }); 
  });

</script>
