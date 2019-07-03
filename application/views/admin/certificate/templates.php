<?php $this->load->view('admin/theme/message'); ?>
<section class="content-header">
<h1> <?php echo $this->lang->line("certificate template");?> </h1>
</section>
<div style="margin:15px;">
	<ul class="nav nav-tabs" role="tablist">
		<li role="presentation" class="active"><a href="#character" aria-controls="character" role="tab" data-toggle="tab"><i class="fa fa-certificate"></i><?php echo $this->lang->line("character");?></a></li>
		<li role="presentation"><a href="#testimonial" aria-controls="testimonial" role="tab" data-toggle="tab"><i class="fa fa-certificate"></i> <?php echo $this->lang->line("testimonial");?></a></li>
		<li role="presentation"><a href="#transfer" aria-controls="transfer" role="tab" data-toggle="tab"><i class="fa fa-certificate"></i> <?php echo $this->lang->line("transfer");?></a></li>
		<li role="presentation"><a href="#appeared" aria-controls="appeared" role="tab" data-toggle="tab"><i class="fa fa-certificate"></i> <?php echo $this->lang->line("appeared");?></a></li>
		<li role="presentation"><a href="#student" aria-controls="student" role="tab" data-toggle="tab"><i class="fa fa-certificate"></i> <?php echo $this->lang->line("studentship");?></a></li>
	</ul>

	<div class="tab-content">
		<div role="tabpanel" class="tab-pane active" id="character">
			<textarea class="ckeditor" id="char_text" name='char_text'><?php echo $character_data[0]['content']; ?></textarea>
			<br/><center><input type="button" value='<?php echo $this->lang->line("save template");?>' class="btn btn-lg btn-warning" id="char_submit" /><span class="loading"></span></center>
			<script> CKEDITOR.replace( 'char_text') </script>
		</div>	 
		<div role="tabpanel" class="tab-pane" id="testimonial">		
			<textarea class="ckeditor" id="test_text" name='test_text'><?php echo $testimonial_data[0]['content']; ?></textarea>
			<br/><center><input type="button" value='<?php echo $this->lang->line("save template");?>' class="btn btn-lg btn-warning" id="test_submit" /><span class="loading"></span></center>
			<script> CKEDITOR.replace( 'test_text') </script>				
		</div>
		<div role="tabpanel" class="tab-pane" id="transfer">
			<textarea class="ckeditor" id="tran_text" name='tran_text'><?php echo $transfer_data[0]['content']; ?></textarea>
			<br/><center><input type="button" value='<?php echo $this->lang->line("save template");?>' class="btn btn-lg btn-warning" id="tran_submit" /><span class="loading"></span></center>
			<script> CKEDITOR.replace( 'tran_text') </script>
		</div>	
		<div role="tabpanel" class="tab-pane" id="appeared">
			<textarea class="ckeditor" id="appe_text" name='appe_text'><?php echo $appeared_data[0]['content']; ?></textarea>
			<br/><center><input type="button" value='<?php echo $this->lang->line("save template");?>' class="btn btn-lg btn-warning" id="appe_submit" /><span class="loading"></span></center>
			<script> CKEDITOR.replace( 'appe_text') </script>
		</div>	
		<div role="tabpanel" class="tab-pane" id="student">
			<textarea class="ckeditor" id="stud_text" name='stud_text'><?php echo $studentship_data[0]['content']; ?></textarea>
			<br/><center><input type="button" value='<?php echo $this->lang->line("save template");?>' class="btn btn-lg btn-warning" id="stud_submit" /><span class="loading"></span></center>
			<script> CKEDITOR.replace( 'stud_text') </script>
		</div>					
	</div>
</div>



<script>
	$("#char_submit").click( function(){
		var loading_src="&nbsp;&nbsp;&nbsp;<img src='<?php echo base_url();?>assets/pre-loader/Thin fading line.gif' height='16px' width='16px' alt=''/>";
		$(".loading").html(loading_src+" <b> "+"<?php echo $this->lang->line('loading,updating changes...');?>"+"</b>");
		var base_url="<?php echo site_url(); ?>";
		var text = CKEDITOR.instances.char_text.getData();			
		var name="Character";	
		$.ajax({        
        type:'POST',
        url:base_url+'admin/update_certificate',
        data:{text:text,name:name},
        success:function(response){
           location.reload(); 
           
        }
        
        });
	 });

      $("#test_submit").click( function(){
		var loading_src="&nbsp;&nbsp;&nbsp;<img src='<?php echo base_url();?>assets/pre-loader/Thin fading line.gif' height='16px' width='16px' alt=''/>";
		$(".loading").html(loading_src+" <b> "+"<?php echo $this->lang->line('loading,updating changes...');?>"+"</b>");
		var base_url="<?php echo site_url(); ?>";
		var text = CKEDITOR.instances.test_text.getData();
		var name="Testimonial";	

		$.ajax({        
        type:'POST',
        url:base_url+'admin/update_certificate',
        data:{text:text,name:name},
        success:function(response){
           location.reload(); 
        	}
        
        	});
 		});

        $("#tran_submit").click( function(){
		var loading_src="&nbsp;&nbsp;&nbsp;<img src='<?php echo base_url();?>assets/pre-loader/Thin fading line.gif' height='16px' width='16px' alt=''/>";
		$(".loading").html(loading_src+" <b> "+"<?php echo $this->lang->line('loading,updating changes...');?>"+"</b>");
		var base_url="<?php echo site_url(); ?>";
		var text = CKEDITOR.instances.tran_text.getData();
		var name="Transfer";	

		$.ajax({        
        type:'POST',
        url:base_url+'admin/update_certificate',
        data:{text:text,name:name},
        success:function(response){
            location.reload(); 
        	}
        
        	});
		 });

        $("#appe_submit").click( function(){
		var loading_src="&nbsp;&nbsp;&nbsp;<img src='<?php echo base_url();?>assets/pre-loader/Thin fading line.gif' height='16px' width='16px' alt=''/>";
		$(".loading").html(loading_src+" <b> "+"<?php echo $this->lang->line('loading,updating changes...');?>"+"</b>");
		var base_url="<?php echo site_url(); ?>";
		var text = CKEDITOR.instances.appe_text.getData();
		var name="Appeared";	

		$.ajax({        
        type:'POST',
        url:base_url+'admin/update_certificate',
        data:{text:text,name:name},        success:function(response){
            location.reload(); 
        	}
        
        	});
		 });


        $("#stud_submit").click( function(){
		var loading_src="&nbsp;&nbsp;&nbsp;<img src='<?php echo base_url();?>assets/pre-loader/Thin fading line.gif' height='16px' width='16px' alt=''/>";
		$(".loading").html(loading_src+" <b> "+"<?php echo $this->lang->line('loading,updating changes...');?>"+"</b>");
		var base_url="<?php echo site_url(); ?>";
		var text = CKEDITOR.instances.stud_text.getData();
		var name="Studentship";	

		$.ajax({        
        type:'POST',
        url:base_url+'admin/update_certificate',
        data:{text:text,name:name},
        success:function(response){
            location.reload(); 
        	}
        
        });
	});


</script>