<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title><?php echo $this->config->item('product_name')." | Login"; ?></title>    
    <link rel="shortcut icon" href="<?php echo base_url();?>assets/images/favicon.png"> 
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.4 -->
    <link href="<?php echo base_url();?>bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- FontAwesome 4.3.0 -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="<?php echo base_url();?>css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- iCheck -->
    <link href="<?php echo base_url();?>plugins/iCheck/square/blue.css" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style type="text/css" media="screen">
      html,body{height: 100%;}
      .login-page
      {
          background-color: #357ca5;
          background-image: url("assets/images/bg-section-1.png");
          background-position: center center;
          background-size: cover;
          box-shadow: 0 -10px 80px rgba(0, 0, 0, 0.8) inset;
          padding: 70px 0;
          width: 100%;
      }
      .login-box-body
      {
        background: transparent;
        border: 1px solid #fff;
        color: #fff !important;
      }
      .login-box-body a
      {
        color: #fff !important;        
      }
      .login-box
      {
        margin: auto auto;
      }
      .login-box button
      {
        background: #01A0DB;
      }
      .login-box button:hover
      {
        border: 1px solid #fff;
      }
    </style>
  </head>
  <body class="login-page">
    <div class="login-box">
      <div class="login-logo"> 
      <a href="<?php echo site_url();?>"><b><img style="max-width:200px" src="<?php echo base_url().'assets/images/logo.png' ?>" alt="<?php echo $this->config->item("product_name");?>" class='center-block'></b></a>
      </div><!-- /.login-logo -->
      <br/>
      <div class="login-box-body">
        <?php 
          if($this->session->flashdata('login_msg')!='') 
          {
              echo "<div class='alert alert-danger text-center'>"; 
                  echo $this->session->flashdata('login_msg');
              echo "</div>"; 
          }   
          if($this->session->flashdata('reg_success') != '')
          echo '<div class="alert alert-success text-center">'.$this->session->flashdata("reg_success").'</div>';
            
          if($this->session->flashdata('reset_success')!="")
          {
            echo '<div class="alert alert-success text-center">'.$this->session->flashdata("reset_success").'</div>';  
            $this->session->unset_userdata('reset_success');
          }   

          if($this->session->userdata('success_in_online_admission')!="")
          echo '<div class="alert alert-success text-center">'.$this->session->userdata("success_in_online_admission").'</div>';  
          
        ?>
        <h4 class="text-center"><p class="login-box-msg">User Log in</p></h4>
        <form action="<?php site_url('home/login'); ?>" method="post">
          <div class="form-group has-feedback">
            <input type="text" class="form-control" name="username" placeholder="Username" />
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
            <span style="color:red"><?php echo form_error('username'); ?></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" name="password" placeholder="Password" />
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            <span style="color:red"><?php echo form_error('password'); ?></span>
          </div>
          <div class="row">            
            <div class="col-xs-12">
              <button type="submit" class="btn btn-primary btn-block btn-flat"><?php echo $this->lang->line('log in');?></button>
            </div><!-- /.col -->
          </div>
        </form>
       <br/><center><a href="<?php echo site_url('home/forgot_password'); ?>"><?php echo $this->lang->line('forget password?');?></a></center>
      </div><!-- /.login-box-body -->
     
    </div><!-- /.login-box -->

    <!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url();?>plugins/jQuery/jQuery-2.1.4.min.js" type="text/javascript"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="<?php echo base_url();?>bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- iCheck -->
    <script src="<?php echo base_url();?>plugins/iCheck/icheck.min.js" type="text/javascript"></script>
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>
  </body>
</html>
