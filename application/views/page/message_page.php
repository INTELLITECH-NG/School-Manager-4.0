<!DOCTYPE html>
<html>
<head>
	<title><?php if(isset($title) && $title!="") echo $title; else echo "Error";?></title>
	<link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo base_url();?>assets/css/font-awesome.min.css" rel="stylesheet">
	<style>
	.box
	{
		border:1px solid #ccc;	
		margin: 0 auto;
		text-align: center;
		margin-top:10%;
		padding-bottom: 20px;
		background-color: #fffddd;
		color:#000;
	}
	.btn-warning
	{
		width: 200px;
	}
	</style>
</head>
<body>
<div class="container">
	<div class="row">
		<div class="col-xs-12">
			<br/><br/><br/>
			<h3>
			<div class="alert alert-warning text-center">
			<?php if(isset($message) && $message!="") echo $message; ?>			
			</div>
			</h3>	
			
		</div>
	</div>
</div>	
</body>
</html>