
  <?php $this->load->view('include/css_include_back');?>
  <?php $this->load->view('include/js_include_back');?>

  <div class="container-fluid">
    <div class="row row-centered">
      <div class="col-xs-12 col-centered">
        <?php 
         if(!isset($body)) $body="public/theme/blank";  
          $this->load->view($body);
        ?>
      </div>
    </div>
  </div>

     