<?php $this->load->view('admin/theme/message'); ?>
<?php
    // $edit_permission=0;
    // if(in_array(3,$this->role_module_accesses_2))  
    $edit_permission=1;
?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1> <?php echo $this->lang->line('send notification to teacher');?></h1>  
</section>

<!-- Main content -->
<section class="content">  
  <div class="row">
    <div class="col-xs-12">
        <div class="grid_container" style="height: 500px;">
            <table 
            id="tt"  
            class="easyui-datagrid" 
            url="<?php echo base_url()."admin_sms_email/teachers_data"; ?>" 
            
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
                        <th field="teacher_name" sortable="true" ><?php echo $this->lang->line('name');?></th>
                        <th field="teacher_no"  sortable="true" ><?php echo $this->lang->line('teacher id');?></th>
                        <th field="rank_name" sortable="true" ><?php echo $this->lang->line('rank');?></th>
                        <th field="religion" sortable="true" ><?php echo $this->lang->line('religion');?></th>
                        <th field="gender" sortable="true" ><?php echo $this->lang->line('gender');?></th>
                        <th field="mobile" sortable="true" ><?php echo $this->lang->line('mobile');?></th>
                        <th field="email" sortable="true" ><?php echo $this->lang->line('email');?></th>
                    </tr>
                </thead>
            </table>                        
         </div>

       <div id="tb" style="padding:3px">
            <?php $this->load->view('admin/sms_email/submenu'); ?>           
            <form class="form-inline" style="margin-top:20px">
                
                <div class="form-group">
                    <input  id="teacher_name" name="teacher_name" class="form-control" size="15" placeholder="<?php echo $this->lang->line('teacher name');?>" >
                </div>
                <div class="form-group">
                    <?php 
                      $rank_info['']=$this->lang->line('rank');                     
                      echo form_dropdown('rank_id',$rank_info,"",'class="form-control" id="rank_id"'); 
                    ?>
                </div>

                <button class='btn btn-info'  onclick="doSearch(event)"><?php echo $this->lang->line('search');?></button>
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
    var base_url="<?php echo site_url(); ?>"
   
    function doSearch(event)
    {
         event.preventDefault(); 
        $j('#tt').datagrid('load',{
          teacher_name:          $j('#teacher_name').val(),
          rank_id:               $j('#rank_id').val(),
          is_searched:      1
        });
    }

    function sms_send_email_ui()
    {
      $("#modal_send_sms_email").modal();
    }  
    
    $j("document").ready(function(){

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
          
          if(rows=="") 
          {
            $("#show_message").addClass("alert alert-warning");
            $("#show_message").html("<b>"+"<?php echo $this->lang->line('You do not selected any teacher.');?>"+"</b>");
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
          url: "<?php echo site_url(); ?>admin_sms_email/teacher_send_sms_email",
          data:{content:content,type:type,info:info,subject:subject},
          success:function(response){
            $("#send_sms_email").removeAttr('disabled');                     
            $("#show_message").addClass("alert alert-info");
            $("#show_message").html(response);
          }
        });   
      }); 
  });

</script>
