<?php $this->load->view('admin/theme/message'); ?>
<?php
	$view_permission=$edit_permission=0;
	if(in_array(1,$this->role_module_accesses_1))  
	$view_permission=1;
	if(in_array(3,$this->role_module_accesses_1))  
	$edit_permission=1;
?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1> <?php echo $this->lang->line('role');?> </h1>  
</section>

<!-- Main content -->
<section class="content">  
  <div class="row">
    <div class="col-xs-12">
        <div class="grid_container">
            <table 
            id="tt"  
            class="easyui-datagrid" 
            url="<?php echo base_url()."admin/roles_data"; ?>" 
            
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
                        <th field="name" sortable="true"><?php echo $this->lang->line('name');?></th>
                        <th field="status" sortable="true" formatter='status'><?php echo $this->lang->line('status');?></th>
                        <?php if($view_permission==1 || $edit_permission==1) { ?>
                        <th field="view"  formatter='action_column'><?php echo $this->lang->line('actions');?></th> 
                        <?php } ?>                     
                    </tr>
                </thead>
            </table>                        
         </div>
  
       <div id="tb" style="padding:3px">
            <?php $this->load->view('admin/role/submenu'); ?>           
            <form class="form-inline" style="margin-top:20px">
                <div class="form-group">
                    <input  id="name" name="name" class="form-control" size="20" placeholder="<?php echo $this->lang->line('role name');?>" >
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
        var url=base_url+'admin/details_role/'+row.id;        
        var edit_url=base_url+'admin/update_role/'+row.id;
        var str="";
        var view_permission="<?php echo $view_permission; ?>";        
        var edit_permission="<?php echo $edit_permission; ?>";   
        if(view_permission==1)     
        str="<a title='<?php echo $this->lang->line("Details");?>' style='cursor:pointer' href='"+url+"'>"+' <img src="<?php echo base_url("plugins/grocery_crud/themes/flexigrid/css/images/magnifier.png");?>" alt="View">'+"</a>";
        if(edit_permission==1)
        str=str+"&nbsp;&nbsp;&nbsp;&nbsp;<a style='cursor:pointer' title='<?php $this->lang->line("Update");?>' href='"+edit_url+"'>"+' <img src="<?php echo base_url("plugins/grocery_crud/themes/flexigrid/css/images/edit.png");?>" alt="Edit">'+"</a>";
   		
   		return str;
    }     
     
   
    function doSearch(event)
    {
        event.preventDefault(); 
        $j('#tt').datagrid('load',{
          name:             $j('#name').val(),
          is_searched:      1
        });
    }  
    

</script>
