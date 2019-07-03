
<?php $this->load->view('admin/online_admission/message'); ?>
<?php
    $view_permission=$edit_permission=$delete_permission=0;
    if(in_array(1,$this->role_module_accesses_29))  
      $view_permission=1;
    if(in_array(3,$this->role_module_accesses_29))  
      $edit_permission=1;
    if(in_array(4,$this->role_module_accesses_29))  
      $delete_permission=1;
?>

<style type="text/css">
  @media screen and (min-width: 980px) {
      .small_select{
      width: 96px !important;
      padding-left: 5px !important;
    }
  }
  .border_radius{
    -moz-border-radius: 8px;
    -webkit-border-radius: 8px;
    border-radius: 8px;
  }
</style>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1> <?php echo $this->lang->line('merit list');?> </h1>  
</section>

<!-- Main content -->
<section class="content">  
  <div class="row">
    <div class="col-xs-12">
        <div class="grid_container">
            <table 
            id="tt"  
            class="easyui-datagrid" 
            url="<?php echo base_url()."admin_online_admission/merit_list_data"; ?>" 
            
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
                        <th field="applicant_id"  sortable="true" ><?php echo $this->lang->line('applicant id');?></th>
                        <th field="admission_roll"  sortable="true" ><?php echo $this->lang->line('admission roll');?></th>
                        <th field="registered_at"  sortable="true" ><?php echo $this->lang->line('registration date');?></th>
                        <th field="name" sortable="true" ><?php echo $this->lang->line('student name');?></th>
                        <th field="class_name" sortable="true" ><?php echo $this->lang->line('class');?></th>
                        <th field="dept_name" sortable="true" ><?php echo $this->lang->line('group / dept.');?></th>
                        <!-- <th field="section_name" sortable="true" >Section</th> -->
                        <th field="shift_name" sortable="true" ><?php echo $this->lang->line('shift');?></th>
                        <th field="session_name" sortable="true" ><?php echo $this->lang->line('session');?></th>
                        <th field="merit_status" sortable="true" ><?php echo $this->lang->line('status');?></th>
                        <th field="view" formatter='action_column'><?php echo $this->lang->line('actions');?></th>                       
                    </tr>
                </thead>
            </table>                        
         </div>

       <div id="tb" style="padding:3px">           
          <form class="form-inline" style="margin-top:20px">
              <div class="form-group">
                  <input  id="admission_roll" name="admission_roll" class="form-control" size="15" placeholder="<?php echo $this->lang->line('admission roll');?>" >
              </div>

              <div class="form-group">
                  <input  id="applicant_id" name="applicant_id" class="form-control" size="10" placeholder="<?php echo $this->lang->line('applicant id');?>" >
              </div>

              <div class="form-group">
                  <input  id="applicant_name" name="applicant_name" class="form-control" size="10" placeholder="<?php echo $this->lang->line('name');?>" >
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

              <!-- <div class="form-group">
                <?php 
                  $section_info['']=$this->lang->line('section'); 
                  echo form_dropdown('section_id',$section_info,"",'class="form-control small_select" id="sec_id"'); 
                ?>
              </div> -->


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
        var admit_url=base_url+'admin_online_admission/merit_to_admission/'+row.id;        
        var details_url=base_url+'admin_online_admission/merit_list_applicant_profile/'+row.applicant_id;
        var delete_url=base_url+'admin_online_admission/delete_from_merit_list/'+row.id;
        
        var str="";
        var view_permission="<?php echo $view_permission; ?>";        
        // var edit_permission="<?php echo $edit_permission; ?>";   
        var delete_permission="<?php echo $delete_permission; ?>";   
        
        if(view_permission==1){     
          str="<a title='"+'<?php echo $this->lang->line("Details");?>'+"' style='cursor:pointer' target='_blank' href='"+details_url+"'>"+' <img src="<?php echo base_url("plugins/grocery_crud/themes/flexigrid/css/images/magnifier.png");?>" alt="View">'+"</a>";
          str=str+"&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;<a title='Admit to a class' style='cursor:pointer' class='btn btn-info' href='"+admit_url+"'><i class='fa fa-check'></i> Admit</a>";
        }
        // if(edit_permission==1)
          // str=str+"&nbsp;&nbsp;&nbsp;&nbsp;<a style='cursor:pointer' title='Update' href='"+edit_url+"'>"+' <img src="<?php echo base_url("plugins/grocery_crud/themes/flexigrid/css/images/edit.png");?>" alt="Edit">'+"</a>";
        
        if(delete_permission==1)
          str=str+"&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;<a onClick=\"return confirm('Do you really want to delete? This action can not be undone.')\" style='cursor:pointer' title='Delete' href='"+delete_url+"'>"+' <img src="<?php echo base_url("plugins/grocery_crud/themes/flexigrid/css/images/close.png");?>" alt="Delete">'+"</a>";
        return str;
    }  
   
    function doSearch(event)
    {
         event.preventDefault(); 
        $j('#tt').datagrid('load',{
          admission_roll:        $j('#admission_roll').val(),
          class_id:              $j('#class_id').val(),
          financial_year_id:     $j('#financial_year_id').val(),
          dept_id:               $j('#dept_id').val(),
          shift_id:              $j('#shift_id').val(),
          // section_id:            $j('#sec_id').val(),
          applicant_name:        $j('#applicant_name').val(),
          applicant_id:          $j('#applicant_id').val(),
          is_searched:      1
        });
    }  
    
    $('#added_flash').fadeOut(6000);
</script>
