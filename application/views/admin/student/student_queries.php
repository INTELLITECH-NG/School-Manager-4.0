<?php $this->load->view('admin/theme/message'); ?>
<?php
    // $edit_permission=0;
    // if(in_array(3,$this->role_module_accesses_2))  
    $edit_permission=1;
?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1> <?php echo $this->lang->line('student queries / complains');?> </h1>  
</section>

<!-- Main content -->
<section class="content">  
  <div class="row">
    <div class="col-xs-12">
        <div class="grid_container">
            <table 
            id="tt"  
            class="easyui-datagrid" 
            url="<?php echo base_url()."admin_student/student_queries_data"; ?>" 
            
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
                        <th field="student_name" sortable="true" formatter='name_to_profile'><?php echo $this->lang->line('student profile');?></th>
                        <th field="sent_at" sortable="true"><?php echo $this->lang->line('received at');?></th>
                        <th field="replied" sortable="true" formatter='is_replied'><?php echo $this->lang->line('status');?></th>                                      
                        <th field="reply_at" sortable="true" formatter="time_formatter"><?php echo $this->lang->line('reply at');?></th>                                       
                        <th field="actions" sortable="true" formatter="action_column"><?php echo $this->lang->line('actions');?></th>                                      
                    </tr>
                </thead>
            </table>                        
         </div>

       <div id="tb" style="padding:3px">        
            <form class="form-inline" style="margin-top:20px">
                <div class="form-group">
                    <?php 
                      $replied_info['']='Status';                     
                      $replied_info['1']='Replied';                     
                      $replied_info['0']='Pending';                     
                      echo form_dropdown('replied',$replied_info,"",'class="form-control" id="replied"'); 
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
    function time_formatter(value,row,index)
    {   
        if(row.replied=="1") return value;  
        else return "";             
    }  

    function is_replied(value,row,index)
    {   
        if(value=="1") return "<label class='label label-success'>Replied</label>";  
        else return "<label class='label label-warning'>Pending</label>";  
                  
    }  


    function action_column(value,row,index)
    {
        var reply_url=base_url+'admin_student/reply_query/'+row.primary_key;  
        var details_url=base_url+'admin_student/details_query/'+row.primary_key;  
        var str="";    
        // var edit_permission="<?php echo $edit_permission; ?>";   
        // if(edit_permission==1)  
        str+="<a style='cursor:pointer' title='Details' href='"+details_url+"'>"+' <img src="<?php echo base_url("plugins/grocery_crud/themes/flexigrid/css/images/magnifier.png");?>" alt="Details">'+"</a>";
        if(row.replied=="0")     
        str+="<a style='cursor:pointer' title='Reply' href='"+reply_url+"'>"+' <img src="<?php echo base_url("plugins/grocery_crud/themes/flexigrid/css/images/reply.png");?>" alt="Reply">'+"</a>";
        return str;
    }
    
    function name_to_profile(value,row,index)
    {   
        var profile_url=base_url+'admin_student/student_profile/'+row.student_info_id;  
        var str="";    
        // var edit_permission="<?php echo $edit_permission; ?>";   
        // if(edit_permission==1)       
        str="<a style='cursor:pointer' title='Profile' href='"+profile_url+"'>"+' <img src="<?php echo base_url("plugins/grocery_crud/themes/flexigrid/css/images/magnifier.png");?>" alt="Profile">'+row.student_name+"</a>";
        return str;          
    }  


    function reply_message(value,row,index)
    {
        if(value=="") return "N/A";            
        else return value; 
    }
                
   
    function doSearch(event)
    {
        event.preventDefault(); 
        $j('#tt').datagrid('load',{
          replied:          $j('#replied').val(),
          is_searched:      1
        });
    }  
    

</script>
