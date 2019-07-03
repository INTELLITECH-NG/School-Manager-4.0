<?php $this->load->view('admin/theme/message'); ?>

<?php	
	foreach($sms_configuration as $info)
	{
		$gateway=$info['name'];
		$auth_id=$info['auth_id'];
		$token=$info['token'];
		$phone_number=$info['phone_number'];
		$api_id=$info['api_id'];
	}
?>

<section class="content-header">
   <section class="content">
     	<div class="box box-info custom_box">
		    	<div class="box-header">
		         <h3 class="box-title"><i class="fa fa-envelope"></i> <?php echo $this->lang->line('sms configuration');?></h3>
		        </div><!-- /.box-header -->
		       		<!-- form start -->
		    <form class="form-horizontal" <?php echo base_url().'/admin/sms_configuration'; ?> method="POST">
		        <div class="box-body">
		           	<div class="form-group">
		              	<label class="col-sm-3 control-label" for="name"><?php echo $this->lang->line('sms gateway');?> * </label>
	                	<div class="col-sm-9 col-md-6 col-lg-6">
	               			<div class="radio">
							<label><input <?php if(isset($gateway) and $gateway=='planet')  echo "checked='yes'"; ?>  type="radio" value="planet" name="sms_gateway" class="sms_gateway">Planet IT (http://planetgroupbd.com/) </label>
							</div>	
							<div class="radio">
								  <label><input <?php if(isset($gateway) and $gateway=='plivo')  echo "checked='yes'"; ?> type="radio" value="plivo" name="sms_gateway" class="sms_gateway">Plivo (https://www.plivo.com)</label>
							</div>
							<div class="radio">
							 	 <label><input <?php if(isset($gateway) and $gateway=='twilio')  echo "checked='yes'"; ?> type="radio" value="twilio" name="sms_gateway" class="sms_gateway" >Twilio (https://www.twilio.com/)</label>
							</div>
							
							<div class="radio">
							 	 <label><input <?php if(isset($gateway) and $gateway=='2-way')  echo "checked='yes'"; ?> type="radio" value="2-way" name="sms_gateway" class="sms_gateway" >2-way sms (www.2-waysms.com)</label>
							</div>							
							<div class="radio">
							 	 <label><input <?php if(isset($gateway) and $gateway=='clickatell')  echo "checked='yes'"; ?> type="radio" value="clickatell" name="sms_gateway" class="sms_gateway" >Clickatell (https://www.clickatell.com)</label>
							</div>
	             		</div>
		            </div>

		            <div class="form-group">
		             	<label class="col-sm-3 control-label" for="name"><?php echo $this->lang->line('auth id / username');?> *	</label>
	             		<div class="col-sm-9 col-md-6 col-lg-6">
	               			<input value="<?php if(isset($auth_id)) echo $auth_id; ?>" required id="auth_id" name="auth_id" class="form-control" size="20" placeholder="<?php echo $this->lang->line('auth id / username')?>" >
	             		</div>
		           </div> 

		           <div class="form-group">
		             	<label class="col-sm-3 control-label" for="name"><?php echo $this->lang->line('auth token / password');?> *	</label>
	             		<div class="col-sm-9 col-md-6 col-lg-6">
	               			 <input value="<?php if(isset($token)) echo $token; ?>" required id="auth_token" name="auth_token" class="form-control" size="20" placeholder="<?php echo $this->lang->line('auth token / password')?>" >
                		</div>
		           </div> 

		           <div class="form-group">
		             	<label class="col-sm-3 control-label" for="name"><?php echo $this->lang->line('phone number/ mask');?>	</label>
	             		<div class="col-sm-9 col-md-6 col-lg-6">
	               			<input value="<?php if(isset($phone_number)) echo $phone_number; ?>" id="phone_number" name="phone_number" class="form-control" size="20" placeholder="<?php echo $this->lang->line('phone number/ mask');?>" >
             			</div>
		           </div> 

		           <div class="form-group">
		             	<label class="col-sm-3 control-label" for="name"><?php echo $this->lang->line('api id (clickatell gateway)');?>	</label>
	             		<div class="col-sm-9 col-md-6 col-lg-6">
	               			<input value="<?php if(isset($api_id)) echo $api_id; ?>" id="phone_number" name="api_id" class="form-control" size="20" placeholder="<?php echo $this->lang->line('api id(optional/need for clickatell gateway)')?>" >
                        </div>
		           </div> 
		         		               
		           </div> <!-- /.box-body --> 

		           	<div class="box-footer">
		            	<div class="form-group">
		             		<div class="col-sm-12 text-center">
		               			<input name="submit" type="submit" class="btn btn-warning btn-lg" value="<?php echo $this->lang->line('save');?>"/>  
		              			<input type="button" class="btn btn-default btn-lg" value="<?php echo $this->lang->line('cancel');?>" onclick='goBack("admin/sms_configuration",1)'/>  
		             		</div>
		           		</div>
		         	</div><!-- /.box-footer -->         
		        </div><!-- /.box-info -->       
		    </form>     
     	</div>
   </section>
</section>





