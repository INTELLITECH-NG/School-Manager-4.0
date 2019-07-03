<section class="content">
  <div class="box box-info custom_box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa fa-binoculars"></i> <?php echo $this->lang->line('financial data');?></h3>
    </div><!-- /.box-header -->

    <form class="form-horizontal" action="<?php echo base_url('yearly_config/financial_data_action'); ?>" method="POST">
        <div class="box-body">
          <?php 
          if($this->session->userdata('complete_success'))
          {
            echo "<div class='alert alert-success text-center'><h4 style='margin:0;'><i class='fa fa-check-circle'></i> ".$this->session->userdata('complete_success')."</h4></div>";
            $this->session->unset_userdata('complete_success');
          }        
          ?>
          <?php if(isset($error) && !empty($error)) echo "<div class='alert alert-danger text-center'>".$error."</div>";?>
          <div class="col-xs-12">
            <div class="row">
              <p class="alert alert-warning text-center" id="error" style="display:none;"></p>
            </div>
            <div class="row">

              <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                <?php 
                $dataInfo['']=$this->lang->line('copy data');                      
                    echo form_dropdown('data',$dataInfo,"",'class="form-control" id="m_class_id"'); 
                ?>
              </div>
                

              <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                <?php 
                  $form['']=$this->lang->line('copy from financial');                      
                      echo form_dropdown('form_session',$form,"",'class="form-control" id="shift_id"'); 
                ?>
              </div>

              <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                <?php 
                  $to['']=$this->lang->line('copy to financial');                      
                      echo form_dropdown('to_session',$to,"",'class="form-control" id="section_id"'); 
                ?>
              </div>

            </div>
            <div class="row">
            	<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
        		</div>
              <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                  <input type="submit" id="student_list" value="<?php echo $this->lang->line('submit');?>" class="btn btn-primary" style="width:100%;margin-top:7px;">
              </div>
            </div>
      </form>
  </div>
</section>