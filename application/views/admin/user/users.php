<?php $this->load->view('admin/theme/message'); ?>
<?php
    $edit_permission=0;
    if(in_array(3,$this->role_module_accesses_2))  
    $edit_permission=1;
?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1> <?php echo $this->lang->line('user');?> </h1>  
</section>

<!-- Main content -->
<section class="content">  
  <div class="row">
    <div class="col-xs-12">
        <div class="grid_container">
            <table 
            id="tt"  
            class="easyui-datagrid" 
            url="<?php echo base_url()."admin/users_data"; ?>" 
            
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
                        <th field="username"  sortable="true" ><?php echo $this->lang->line('username');?></th>
                        <th field="role_name" sortable="true" ><?php echo $this->lang->line('role name');?></th>
                        <th field="user_type" sortable="true" ><?php echo $this->lang->line('user type');?></th>
                        <th field="type_details" sortable="true" formatter='type_details'><?php echo $this->lang->line('type details');?></th>
                        <th field="reference_id" sortable="true" formatter='reference'   ><?php echo $this->lang->line('reference no.');?></th>
                        <th field="status"    sortable="true" formatter='status'><?php echo $this->lang->line('status');?></th>
                         <?php if($edit_permission==1) { ?>
                         <th field="view" formatter='action_column'><?php echo $this->lang->line('actions');?></th> 
                         <?php } ?>                         
                    </tr>
                </thead>
            </table>                        
         </div>
  
       <div id="tb" style="padding:3px">
            <?php $this->load->view('admin/user/submenu'); ?>           
            <form class="form-inline" style="margin-top:20px">
                <div class="form-group">
                    <input  id="username" name="username" class="form-control" size="20" placeholder=<?php echo $this->lang->line("Username");?> >
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
        var edit_url=base_url+'admin/update_user/'+row.id;  
        var str="";    
        var edit_permission="<?php echo $edit_permission; ?>";   
        if(edit_permission==1)       
        str="<a style='cursor:pointer' title='Update' href='"+edit_url+"'>"+' <img src="<?php echo base_url("plugins/grocery_crud/themes/flexigrid/css/images/edit.png");?>" alt="Edit">'+"</a>";
        return str;
    }  

    function type_details(value,row,index)
    {   
        if(row.user_type=='Individual')
        return row.type_details;
        else
        return 'N/A';         
    }  

    function reference(value,row,index)
    {   
        if(row.user_type=='Individual')
        return row.reference_id;
        else
        return 'N/A';        
    }          
         
   
    function doSearch(event)
    {
        event.preventDefault(); 
        $j('#tt').datagrid('load',{
          username:             $j('#username').val(),
          is_searched:      1
        });
    }  
    

</script>
