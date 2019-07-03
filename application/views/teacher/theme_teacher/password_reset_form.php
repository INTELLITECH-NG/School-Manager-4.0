<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-12 col-md-12 col-lg-6 col-lg-offset-3">
				<?php 
				if($this->session->userdata('error'))
					echo '<div class="alert alert-warning text-center">'.$this->session->userdata('error').'</div>';
				$this->session->unset_userdata('error');
				?>
				
				<form class="" method="POST" action="<?php echo site_url('teacher/reset_password_action'); ?>">
					<div class="form-group">
						<label for="old_password"><?php echo $this->lang->line('old password');?></label>
						<div>
							<input required type="password" class="form-control" id="old_password" name="old_password" placeholder=<?php echo $this->lang->line("old password");?> >
							<span class="red"><?php echo form_error('old_password');?></span>
						</div>
					</div>
					<div class="form-group">
						<label for="new_password"><?php echo $this->lang->line('new password');?></label>
						<div>
							<input required type="password" class="form-control" id="new_password" name="new_password" placeholder=<?php echo $this->lang->line("new password");?> >
							<span class="red"><?php echo form_error('new_password');?></span>
						</div>
					</div>
					<div class="form-group">
						<label for="confirm_new_password"><?php echo $this->lang->line('confirm new password');?></label>
						<div>
							<input required type="password" class="form-control" id="confirm_new_password" name="confirm_new_password" placeholder=<?php echo $this->lang->line("confirm new password");?> >
							<span class="red"><?php echo form_error('confirm_new_password');?></span>
						</div>
					</div>
					<div class="form-group">
						<div>
							<button type="submit" class="btn btn-warning"><?php echo $this->lang->line('Reset Password');?></button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>