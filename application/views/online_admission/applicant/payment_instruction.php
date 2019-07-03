<style>
	.how_it_works
	{
		padding:20px 20px 20px 30px;
	}
	 .no_list_style
	{
		 list-style-type: none !important;
	}
</style>

<div class="modal fade" id="payment_instruction">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><?php echo $this->lang->line('payment instruction');?></h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-xs-12 padded">
						<ul class="how_it_works background_white border_gray text-justify">
							<li class="no_list_style">
								<h6 class="column-title"><i class="fa fa-mobile fa-2x blue"> <?php echo $this->lang->line('bkash');?> <?php if(array_key_exists("status",$bkash_info) && $bkash_info['status']!="1") echo '<font color="red">(Disabled)</font>';?></i></h6> 
							</li>
							<li class="wow fadeInDown animated animated" style="visibility: visible; animation-name: fadeInDown;">	<?php echo $this->lang->line('go to your bkash mobile menu by dialing');?> <b>*247#</b>.</li>

							<li class="wow fadeInDown animated animated" style="visibility: visible; animation-name: fadeInDown;">	<?php echo $this->lang->line('choose');?> <b><?php echo $this->lang->line('payment');?></b>. </li>

							<li class="wow fadeInDown animated animated" style="visibility: visible; animation-name: fadeInDown;">	<?php echo $this->lang->line('enter our merchant bkash account');?> <b><?php if(array_key_exists("payment_account_no",$bkash_info)) echo $bkash_info['payment_account_no']; ?></b>.</li>

							<li class="wow fadeInDown animated animated" style="visibility: visible; animation-name: fadeInDown;">	<?php echo $this->lang->line('enter');?> <b><?php echo $this->session->userdata("app_form_price"); ?></b> <?php echo $this->lang->line('in amount.');?></li>
							<li class="wow fadeInDown animated animated" style="visibility: visible; animation-name: fadeInDown;">	<?php echo $this->lang->line('enter');?> <b><?php echo "F".$this->session->userdata("app_id"); ?></b> <?php echo $this->lang->line('as reference');?></li>
							<li class="wow fadeInDown animated animated" style="visibility: visible; animation-name: fadeInDown;">	<?php echo $this->lang->line('enter 0 as');?> <b><?php echo $this->lang->line('counter');?></b> </li>
							<li class="wow fadeInDown animated animated" style="visibility: visible; animation-name: fadeInDown;">	<?php echo $this->lang->line('now enter your bkash mobile menu');?> <b><?php echo $this->lang->line('pin');?></b> <?php echo $this->lang->line('to confirm.');?></li>
							<li class="wow fadeInDown animated animated" style="visibility: visible; animation-name: fadeInDown;">	<?php echo $this->lang->line('done! you will receive a confirmation message with');?> <b><?php echo $this->lang->line('transaction id (trxid)');?></b> <?php echo $this->lang->line('from bkash.');?></li>
						</ul>
					</div>

					<div class="col-xs-12">			
						<ul class="how_it_works background_white border_gray text-justify">		
							<li class="no_list_style">
								<h6 class="column-title"><i class="fa fa-mobile fa-2x blue"> <?php echo $this->lang->line('dbbl');?> <?php if(array_key_exists("status",$dbbl_info) && $dbbl_info['status']!="1") echo '<font color="red">(Disabled)</font>';?></i></h6> 
							</li>	
							<li class="wow fadeInDown animated animated" style="visibility: visible; animation-name: fadeInDown;">	<?php echo $this->lang->line('go to your dbbl mobile menu by dialing');?> <b>*322#</b> <?php echo $this->lang->line('from any operator except citycell. in case if you are using citycell mobile phones then just send an blank sms to');?> <b>16216</b>.</li>
							<li class="wow fadeInDown animated animated" style="visibility: visible; animation-name: fadeInDown;">	<?php echo this->lang->line('select the option');?> <b>1</b>. </li>
							<li class="wow fadeInDown animated animated" style="visibility: visible; animation-name: fadeInDown;">	<?php echo $this->lang->line('enter our biller id');?> <b><?php if(array_key_exists("payment_account_no",$dbbl_info)) echo $dbbl_info['payment_account_no']; ?></b></li>
							<li class="wow fadeInDown animated animated" style="visibility: visible; animation-name: fadeInDown;">	<?php echo $this->lang('enter');?> <b><?php echo "F".$this->session->userdata("app_id"); ?></b> <?php echo $this->lang->line('as Bill No.');?></li>
							<li class="wow fadeInDown animated animated" style="visibility: visible; animation-name: fadeInDown;">	<?php echo $this->lang->line('enter');?> <b><?php echo $this->session->userdata("app_form_price"); ?></b> <?php echo $this->lang->line('in amount.');?></li>
							<li class="wow fadeInDown animated animated" style="visibility: visible; animation-name: fadeInDown;">	<?php echo $this->lang->line('now enter your bddl mobile');?> <b><?php echo $this->lang->line('pin');?></b> <?php echo $this->lang->line('to confirm.');?></li>
							<li class="wow fadeInDown animated animated" style="visibility: visible; animation-name: fadeInDown;">	<<?php echo $this->lang->line('done! you will receive a confirmation message with');?> <b><?php echo $this->lang->line('transaction id (trxid)');?></b> <?php echo $this->lang->line('from dbbl.');?></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('close');?></button>				
			</div>
		</div>
	</div>
</div>