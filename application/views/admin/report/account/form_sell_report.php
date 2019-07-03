<?php $this->load->view('admin/online_admission/message'); ?>
<?php
    // $edit_permission=0;
    // if(in_array(3,$this->role_module_accesses_2))  
    $edit_permission=1;
    $view_permission=1;
    $delete_permission=1;
?>
<style type="text/css">
  @media screen and (min-width: 980px) {
      .small_select{
      width: 96px !important;
      padding-left: 5px !important;
    }
  }
</style>
<!-- Content Header (Page header) -->
<section class="content-header">
<div id="show_message" class="text-center"></div>
  <h1> <?php echo $this->lang->line('applicants');?> </h1>  
</section>


<!-- Main content -->
<section class="content">  
  <div class="row">
    <div class="col-xs-12">
        <div class="grid_container">
            <table 
            id="tt"  
            class="easyui-datagrid" 
            url="<?php echo base_url()."admin_account/form_fees_report"; ?>" 
            
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
                        <th field="admission_roll"  sortable="true" ><?php echo $this->lang->line('admission roll');?></th>
                        <th field="registered_at"  sortable="true" ><?php echo $this->lang->line('registration date');?></th>
                        <th field="name" sortable="true" ><?php echo $this->lang->line('student name');?></th>
                        <th field="class_name" sortable="true" ><?php echo $this->lang->line('class');?></th>
                        <th field="dept_name" sortable="true" ><?php echo $this->lang->line('group / dept.');?></th>
                        <!-- <th field="section_name" sortable="true" >Section</th> -->
                        <th field="shift_name" sortable="true" ><?php echo $this->lang->line('shift');?></th>
                        <th field="session_name" sortable="true" ><?php echo $this->lang->line('session');?></th>
                        <th field="paid_amount" sortable="true" ><?php echo $this->lang->line('paid amount');?></th>
                        <!-- <th field="is_in_merit_list" sortable="true" >Is in merit list</th> -->
                        <!-- <th field="view" formatter='action_column'>Actions</th>    -->
                    </tr>
                </thead>
            </table>                        
         </div>

       <div id="tb" style="padding:3px">
            <a class="btn btn-warning" target="_blank" title="Download CSV" id="" href="<?php echo base_url('admin_account/csv_download'); ?>">
                <i class="fa fa-cloud-download"></i> <?php echo $this->lang->line('download');?>
            </a>  

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

                <!-- <div class="form-group">
                    <select class="form-control" id="is_in_merit_list">
                      <option value="">Merit listed?</option>
                      <option value="1">Is in Merit list</option>
                      <option value="2">Not in Merit list</option>
                    </select>
                </div> -->

                <button class='btn btn-info'  onclick="doSearch(event)"><?php echo $this->lang->line('search');?></button>
            </form>         
        </div>
    </div>
  </div>   
</section>


<script>       
    var base_url="<?php echo site_url(); ?>"
     
   
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
          // is_in_merit_list:      $j('#is_in_merit_list').val(),
          applicant_name:        $j('#applicant_name').val(),
          applicant_id:          $j('#applicant_id').val(),
          is_searched:      1
        });
    }  
    
    $('#added_flash').fadeOut(6000);


    $j('document').ready(function(){
      $("#add_to_merit").click(function(){      
                  
          var rows = $j('#tt').datagrid('getSelections');
          var info=JSON.stringify(rows);  
          
          if(rows=="") 
          {
            $("#show_message").addClass("alert alert-danger");
            $("#show_message").html("<h5>You haven't seleted any student.</h5>");
            return;
          }
         
          $(this).attr('disabled','yes');
          $("#show_message").addClass("alert alert-info");
          $("#show_message").show().html('<i class="fa fa-spinner fa-spin"></i> Your request is being processed, please wait...');
          $.ajax({
          type:'POST' ,
          url: "<?php echo site_url(); ?>admin_online_admission/applicant_to_merit",
          data:{info:info},
          success:function(response){
            if(response == 'error'){
              $("#add_to_merit").removeAttr('disabled');                     
              $("#show_message").addClass("alert alert-info");
              $("#show_message").html("An error has been occured !");
            }
            if(response == 'success'){
              location.reload();
            }
          }

        });   
      });
    });

</script>
