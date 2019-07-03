<?php $this->load->view('admin/theme/message'); ?>

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1> <?php echo $this->lang->line('sms/ email history');?></h1>  
</section>

<!-- Main content -->
<section class="content">  
  <div class="row">
    <div class="col-xs-12">
        <div class="grid_container">
            <table 
            id="tt"  
            class="easyui-datagrid" 
            url="<?php echo base_url()."admin_sms_email/sms_email_history_data"; ?>" 
            
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
                        <th field="student_name" sortable="true" formatter='view_student_profile'><?php echo $this->lang->line('student');?></th>
                        <th field="student_id" sortable="true" formatter='student_or_teacher'><?php echo $this->lang->line('student id');?></th>
                        <th field="teacher_name"  sortable="true" formatter='view_teacher_profile'><?php echo $this->lang->line('teacher');?></th>
                        <th field="teacher_id"  sortable="true" formatter='student_or_teacher'><?php echo $this->lang->line('teacher id');?></th>
                        <th field="type" sortable="true" ><?php echo $this->lang->line('sms/ email');?></th>
                        <th field="sent_at" sortable="true" ><?php echo $this->lang->line('sent at');?></th>
                        <th field="title" sortable="true" ><?php echo $this->lang->line('subject');?></th>
                        <th field="message" sortable="true"><?php echo $this->lang->line('message');?></th>
                    </tr>
                </thead>
            </table>                        
         </div>

       <div id="tb" style="padding:3px">
             
            <form class="form-inline" style="margin-top:20px">                
               
                <div class="form-group">
                    <?php 
                      $type_info=array(''=>$this->lang->line('type'),'SMS'=>$this->lang->line('sms'),'Email'=>$this->lang->line('email'));                     
                      echo form_dropdown('type',$type_info,"",'class="form-control" id="type"'); 
                    ?>
                </div> 
    
                <button class='btn btn-info'  onclick="doSearch(event)"><?php echo $this->lang->line('search');?></button>
            </form>         
        </div>
    </div>
  </div>   
</section>







<script>       
    var base_url="<?php echo site_url(); ?>"

    function student_or_teacher(value,row,index)
    {
      if(!value) return "N/A";
      else return value;        
    }

    function view_student_profile(value,row,index){
      if(value){
        var profile_url=base_url+'admin_student/student_profile/'+row.student_info_id;  
        var str="";        
        str="<a target='_blank' style='cursor:pointer' title='Profile' href='"+profile_url+"'>"+' <img src="<?php echo base_url("plugins/grocery_crud/themes/flexigrid/css/images/magnifier.png");?>" alt="Profile">'+row.student_name+"</a>";
        return str;
      }
      else
        return "N/A";
    }

    function view_teacher_profile(value,row,index){
      if(value){
        var profile_url=base_url+'admin_teacher/view_details/'+row.teacher_info_id;  
        var str="";        
        str="<a target='_blank' style='cursor:pointer' title='Profile' href='"+profile_url+"'>"+' <img src="<?php echo base_url("plugins/grocery_crud/themes/flexigrid/css/images/magnifier.png");?>" alt="Profile">'+row.teacher_name+"</a>";
        return str;
      }
      else
        return "N/A";
    }

    function doSearch(event)
    {
         event.preventDefault(); 
        $j('#tt').datagrid('load',{
          type:               $j('#type').val(),
          is_searched:      1
        });
    } 

</script>
