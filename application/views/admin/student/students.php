<?php $this->load->view('admin/theme/message'); ?>
<?php
    $view_permission=$edit_permission=$delete_permission=0;
    if(in_array(1,$this->role_module_accesses_19))  
      $view_permission=1;
    if(in_array(3,$this->role_module_accesses_19))  
      $edit_permission=1;
    if(in_array(4,$this->role_module_accesses_19))  
      $delete_permission=1;
?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1> <?php echo $this->lang->line('students');?> </h1>  
</section>
<?php
  if($this->session->flashdata('error_message'))
    echo '<div class="alert alert-danger text-center" id="added_flash"><h1>',$this->lang->line('an error occured'),'!!!</h1></div>';
  if($this->session->flashdata('upload_error'))
    echo '<div class="alert alert-danger text-center" id="added_flash">'.$this->session->flashdata('upload_error').'</h1></div>';
?>

<!-- Main content -->
<section class="content">  
  <div class="row">
    <div class="col-xs-12">
        <div class="grid_container">
            <table 
            id="tt"  
            class="easyui-datagrid" 
            url="<?php echo base_url()."admin_student/students_data"; ?>" 
            
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
                        <th field="admitted_at"  sortable="true" ><?php echo $this->lang->line('admission date');?></th>
                        <th field="name" sortable="true" ><?php echo $this->lang->line('student name');?></th>
                        <th field="class_name" sortable="true" ><?php echo $this->lang->line('class');?></th>
                        <th field="dept_name" sortable="true" ><?php echo $this->lang->line('group / dept.');?></th>
                        <th field="section_name" sortable="true" ><?php echo $this->lang->line('section');?></th>
                        <th field="shift_name" sortable="true" ><?php echo $this->lang->line('shift');?></th>
                        <th field="session_name" sortable="true" ><?php echo $this->lang->line('session');?></th>
                        <th field="view" formatter='action_column'><?php echo $this->lang->line('actions');?></th>                       
                    </tr>
                </thead>
            </table>                        
         </div>

       <div id="tb" style="padding:3px">
            <?php $this->load->view('admin/student/submenu'); ?>           
            <form class="form-inline" style="margin-top:20px">
                <div class="form-group">
                    <input  id="student_id" name="student_id" class="form-control" size="20" placeholder="<?php echo $this->lang->line('student id');?>" >
                </div>

                <div class="form-group">
                    <input  id="student_name" name="student_name" class="form-control" size="20" placeholder="<?php echo $this->lang->line('student name');?>" >
                </div>

                <div class="form-group">
                    <?php 
                      $class_info['']=$this->lang->line('class');                     
                      echo form_dropdown('class_id',$class_info,"",'class="form-control" id="class_id"'); 
                    ?>
                </div>

                <div class="form-group">                   
                    <?php 
                      $dept_info['']=$this->lang->line('group / dept');                     
                      echo form_dropdown('dept_id',$dept_info,"",'class="form-control" id="dept_id"'); 
                    ?>
                </div> 

                <div class="form-group">
                     <?php 
                      $session_info['']=$this->lang->line('session'); 
                      echo form_dropdown('financial_year_id',$session_info,"",'class="form-control" id="financial_year_id"'); 
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

                <button class='btn btn-info'  onclick="doSearch(event)"><?php echo $this->lang->line('search');?></button>
            </form>         
        </div>
    </div>
  </div>   
</section>


<script>       
    var base_url="<?php echo site_url(); ?>"
    
    function action_column(value,row,index)
    {               
        var details_url=base_url+'admin_student/student_profile/'+row.id;        
        var edit_url=base_url+'admin_student/edit_student_profile/'+row.id;
        var delete_url=base_url+'admin_student/delete_student/'+row.id;
        
        var str="";
        var view_permission="<?php echo $view_permission; ?>";        
        var edit_permission="<?php echo $edit_permission; ?>";   
        var delete_permission="<?php echo $delete_permission; ?>";   
        
        if(view_permission==1)     
        str="<a title=<?php echo $this->lang->line('details');?> style='cursor:pointer' target='_blank' href='"+details_url+"'>"+' <img src="<?php echo base_url("plugins/grocery_crud/themes/flexigrid/css/images/magnifier.png");?>" alt="View">'+"</a>";
        
        if(edit_permission==1)
        str=str+"&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;<a style='cursor:pointer' title=<?php echo $this->lang->line('update');?> href='"+edit_url+"'>"+' <img src="<?php echo base_url("plugins/grocery_crud/themes/flexigrid/css/images/edit.png");?>" alt="Edit">'+"</a>";
        
        if(delete_permission==1)
        str=str+"&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;<a onClick=\"return confirm(<?php echo $this->lang->line('Do you really want to delete? This action can not be undone.');?>)\" style='cursor:pointer' title=<?php echo $this->lang->line('delete');?> href='"+delete_url+"'>"+' <img src="<?php echo base_url("plugins/grocery_crud/themes/flexigrid/css/images/close.png");?>" alt="Delete">'+"</a>";
        
        return str;
    }  
   
    function doSearch(event)
    {
         event.preventDefault(); 
        $j('#tt').datagrid('load',{
          student_id:            $j('#student_id').val(),
          student_name:          $j('#student_name').val(),
          class_id:              $j('#class_id').val(),
          financial_year_id:     $j('#financial_year_id').val(),
          dept_id:               $j('#dept_id').val(),
          shift_id:              $j('#shift_id').val(),
          section_id:            $j('#sec_id').val(),
          is_searched:      1
        });
    }  
    
    $('#added_flash').fadeOut(6000);
</script>
