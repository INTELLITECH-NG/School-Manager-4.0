<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $this->config->item('product_name')." | ".$page_title;?></title>	
    <?php $this->load->view("include/css_include_front");?>    
    <?php $this->load->view("include/js_include_front"); ?>  
    <link rel="shortcut icon" href="<?php echo base_url();?>assets/images/favicon.png">    
</head>
     
            
<body class="app_body">
<div class="container-fluid sticky_top no_margin">
	<div class="row">
		<div class="col-xs-12 background_white" style="height:80px">
			<h1 class="text-center"> <a href="<?php echo site_url();?>"><?php echo $this->config->item('product_name'); ?></a></h1>
   		</div>
	</div>
</div>

<div class="container-fluid front_content">
	<!-- page content -->
	<?php $this->load->view($body);?>
	<!-- page content --> 
</div>

 <!-- footer -->
<footer id="footer" class='sticky_bottom'>
<div class="container-fluid text-center">
    <div class="row">
        <div class="col-xs-12">   
            <?php echo $this->config->item("product_name").$this->config->item("product_version");?>       
        </div>
    </div>
    </div>
</footer>
<!-- footer --> 

</body>
</html>
