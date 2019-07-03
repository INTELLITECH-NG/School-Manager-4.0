<?php if(in_array(2,$this->role_module_accesses_1)): ?>
<a class="btn btn-warning"  title='<?php echo $this->lang->line("add role");?>' href="<?php echo site_url('admin/add_role');?>">
    <i class="fa fa-plus-circle"></i> <?php echo $this->lang->line('add');?>
</a>
<?php endif; ?>