<?php 
$no_active_payment=0;
$is_free_form=0;
if($admission_config['form_price']<=0)
$is_free_form=1;
if((empty($bkash_info) && empty($dbbl_info)) || ($bkash_info['status']!="1" && $dbbl_info['status']!="1")) 
$no_active_payment=1;
?>

<section class="content-header">
   <section class="content">
      <div class="box box-info custom_box">
          <div class="box-header">
             <h3 class="box-title"><i class="fa fa-money"></i> <?php echo $this->lang->line('pay form fees');?></h3>
            </div><!-- /.box-header -->
              <!-- form start -->
            <form class="form-horizontal" action="<?php echo site_url().'applicant/pay_form_fees_action';?>" method="POST">
                <?php 

                if($this->session->userdata('transaction_error')!="") 
                {
                  echo "<br/><div style='margin:0 10px;' class='alert alert-warning text-center'><b>".$this->session->userdata('transaction_error')."</b></div><br/>";
                  $this->session->unset_userdata('transaction_error');
                }
                if($is_free_form==1) 
                echo "<br/><div style='margin:0 20px;' class='alert alert-info text-center'><b>",$this->lang->line("you do not have to pay form fees. it's free of cost."),"</b></div><br/>";
                
                else if($no_active_payment==0) 
                { ?>
                  <div class="box-body">              
                     <div class="form-group text-center">
                     <a class="btn btn-primary" data-toggle="modal" href='#payment_instruction'><?php echo $this->lang->line('how to pay?');?></a>
                     </div>
                     <div class="form-group">
                          <label class="col-sm-3 control-label" for="name"><?php echo $this->lang->line('payment method');?> *
                          </label>
                            <div class="col-sm-9 col-md-6 col-lg-6">
                              <?php 
                              if(array_key_exists("status",$bkash_info) && $bkash_info["status"]=="1")
                              { ?>
                                <input name="method"  <?php if($this->input->post('method') == $this->config->item('bkash_method_id') ) echo 'checked'; ?> type="radio" value="<?php echo $bkash_info["id"]; ?>" type="text">  <?php echo $this->lang->line('bkash');?> &nbsp;&nbsp;&nbsp;&nbsp;             
                              <?php 
                              }
                              if(array_key_exists("status",$dbbl_info) && $dbbl_info["status"]=="1")
                              { ?>
                                <input name="method"  <?php if($this->input->post('method') == $this->config->item('dbbl_method_id') ) echo 'checked'; ?> type="radio" value="<?php echo $dbbl_info["id"]; ?>" type="text">  <?php echo $this->lang->line('dbbl mobile');?>              
                              <?php 
                              } ?>                    
                              <span class="red"><?php echo form_error('method'); ?></span>
                          </div>
                      </div>

                     <div class="form-group">
                          <label class="col-sm-3 control-label" for="name"><?php echo $this->lang->line('transaction id');?> *
                          </label>
                            <div class="col-sm-9 col-md-6 col-lg-6">
                              <input name="trxid" placeholder="Transaction ID" value="<?php echo set_value("trxid"); ?>" class="form-control" type="text">                  
                            <span class="red"><?php echo form_error('trxid'); ?></span>
                          </div>
                      </div>                                
                  </div> <!-- /.box-body --> 
                  <div class="box-footer">
                    <div class="form-group">
                      <div class="col-sm-12 text-center">
                          <input name="submit" type="submit" class="btn btn-warning btn-lg" value=<?php echo $this->lang->line("submit");?>/>  
                      </div>
                    </div>
                  </div><!-- /.box-footer --> 
                <?php 
                }
                else echo "<br/><div style='margin:0 20px;' class='alert alert-warning text-center'><b>",$this->lang->line('no active payment method. please contact the administrator.'),"</b></div><br/>";
                ?>        
            </div><!-- /.box-info -->       
        </form>     
      </div>
   </section>
</section>



<?php $this->load->view('online_admission/applicant/payment_instruction.php'); ?>