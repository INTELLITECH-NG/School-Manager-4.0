<?php $this->load->view('admin/theme/message'); ?>
<?php
	$view_permission=$edit_permission=$delete_permission=0;
	if(in_array(1,$this->role_module_accesses_11))  
	$view_permission=1;
	if(in_array(3,$this->role_module_accesses_11))  
	$edit_permission=1;
?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1> <?php echo $this->lang->line('pay slip');?> </h1>  
</section>

<!-- Main content -->
<section class="content">  
  <div class="row">
    <div class="col-xs-12">
        <div class="grid_container">
            <table 
            id="tt"  
            class="easyui-datagrid" 
            url="<?php echo base_url()."admin/pay_slips_data"; ?>" 
            
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
                        <th field="slip_name" sortable="true" ><?php echo $this->lang->line('slip');?></th>
                        <th field="slip_type" sortable="true" ><?php echo $this->lang->line('slip type');?></th>
                        <th field="class_name" sortable="true"><?php echo $this->lang->line('class');?></th>
                        <th field="dept_name" sortable="true" ><?php echo $this->lang->line('group / dept.');?></th>
                        <th field="session" sortable="true">
                            <?php echo $this->lang->line('session');?>
                        </th>
                        <th field="total_amount" sortable="true">
                            <?php echo $this->lang->line('amount');?>
                        </th>                        
                        <?php if($view_permission==1 || $edit_permission==1) { ?>
                        <th field="view"  formatter='action_column'><?php echo $this->lang->line('actions');?></th> 
                        <?php } ?>                     
                    </tr>
                </thead>
            </table>                        
         </div>
  
       <div id="tb" style="padding:3px">
            <?php $this->load->view('admin/pay_slip/submenu'); ?>           
            <form class="form-inline" style="margin-top:20px">
                <div class="form-group">
                    <input  id="slip_name" name="slip_name" class="form-control" size="20" placeholder=<?php echo $this->lang->line("slip name");?>>
                </div> 
                <div class="form-group">                   
                    <?php 
                      $class_info['']= $this->lang->line('class');                     
                      echo form_dropdown('class_id',$class_info,"",'class="form-control" id="class_id"'); 
                    ?>
                </div> 

                <div class="form-group">                   
                    <?php 
                      $dept_info['']= $this->lang->line('group / dept');                     
                      echo form_dropdown('dept_id',$dept_info,"",'class="form-control" id="dept_id"'); 
                    ?>
                </div> 

                <div class="form-group">
                     <?php 
                      $session_info['']= $this->lang->line('session'); 
                      echo form_dropdown('financial_year_id',$session_info,"",'class="form-control" id="financial_year_id"'); 
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
        var url=base_url+'admin/details_pay_slip/'+row.id;        
        var edit_url=base_url+'admin/update_pay_slip/'+row.id;
        var str="";
        var view_permission="<?php echo $view_permission; ?>";        
        var edit_permission="<?php echo $edit_permission; ?>";   
        if(view_permission==1)     
        str="<a title='"+'<?php echo $this->lang->line("details");?>'+"' style='cursor:pointer' href='"+url+"'>"+' <img src="<?php echo base_url("plugins/grocery_crud/themes/flexigrid/css/images/magnifier.png");?>" alt="View">'+"</a>";
        if(edit_permission==1)
        str=str+"&nbsp;&nbsp;&nbsp;&nbsp;<a style='cursor:pointer' title='"+'<?php echo $this->lang->line("update");?>'+"' href='"+edit_url+"'>"+' <img src="<?php echo base_url("plugins/grocery_crud/themes/flexigrid/css/images/edit.png");?>" alt="Edit">'+"</a>";
   		
   		return str;
    }  
    
   
    function doSearch(event)
    {
        event.preventDefault(); 
        $j('#tt').datagrid('load',{
          slip_name:             $j('#slip_name').val(),
          class_id:              $j('#class_id').val(),
          financial_year_id:     $j('#financial_year_id').val(),
          is_searched:      1
        });
    }  
    

</script>
