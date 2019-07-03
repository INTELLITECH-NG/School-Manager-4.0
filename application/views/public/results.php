<div class="row">
<?php if(isset($student_total_result) && count($student_total_result)>0) {?>
  <div class="col-xs-12 clearfix">
    <center><a id="print_link" class="btn btn-info btn-lg" href="#" onClick="PrintElem('#print_details')" >&nbsp;&nbsp;&nbsp;<i class='fa fa-print'></i> <?php echo $this->lang->line('print');?>&nbsp;&nbsp;&nbsp;</a></center>
    <br/>
    <br/>
    <div id="print_details">
      <div class="text-center" style="background:#eee;border:1px solid #ccc;"><h4 align='center' style="color:black;line-height:40px;margin:0px;font-weight:bolder;"><?php echo $student_result[0]['exam_name']." : Result";?></h4></div>
      <div style="padding:10px;background:#fff;border:1px solid #ccc;">
        <h3 align="center" class='text-center'><?php echo $student_result[0]['student_name'];?></h3>
        <h4 align="center" class='text-center'><?php echo "Student ID: ".$student_result[0]['student_id'];?></h4>
        <h4 align="center" class='text-center'><?php echo "Class: ".$student_result[0]['class_name']." (".$student_result[0]['dept_name'].")";?></h4>
        <h4 align="center" class='text-center'><?php echo "Exam: ".$student_result[0]['exam_name']." : ".$student_result[0]['session_name'];?></h4>
        <div class="table-responsive">
            <table align='center' class="table table-bordered" width="90%" border="1" style="border-collapse:collapse;">
            <tr>
              <th class="text-center"><?php echo $this->lang->ine('sl');?></th>
              <th class="text-center"><?php echo $this->lang->ine('course');?></th>
              <th class="text-center"><?php echo $this->lang->ine('grade');?></th>
              <th class="text-center"><?php echo $this->lang->ine('grade point');?></th>
              <?php 
              $row_span=count($student_result)+2;
              echo "<th class='text-center' style='vertical-align:middle;' rowspan='".$row_span."'>".strtoupper($gpa_cgpa)." - ".number_format((float)$student_total_result[0]['obtained_gpa'], 2, '.', '')."</th>";
              echo "<th class='text-center' style='vertical-align:middle;' rowspan='".$row_span."'>".$student_total_result[0]['grade_name']."</th>";
              ?>
            </tr>
            <?php 
            $sl=0;
            foreach($student_result as $row)
            {
              $sl++;
              echo "<tr>";
                echo "<td align='center'>".$sl."</td>";
                echo "<td align='center'>".$row['course_name']."</td>";
                echo "<td align='center' class='text-center'>".$row['grade']."</td>";
                echo "<td align='center' class='text-center'>".number_format((float)$row['grade_point'], 2, '.', '')."</td>";              
              echo "<tr>";
            }
            ?>          
          </table>
        </div>
      </div>
    </div>
  </div>
  <?php 
  }
  else 
  {
    if($_POST)
    echo "<div class='alert alert-info text-center'><b>", $this->lang->line('no result found.'),"</b></div>";
  }
   ?>

  <div class="col-xs-12">
    <div class="text-center" style="background:#337AB7;"><h4 style="color:white;line-height:40px;margin-bottom:0px;font-weight:bolder;"><i class="fa fa-search"></i><?php echo $this->lang->line('result search panel');?> </h4></div>
    <div style="padding-left:10px;padding-right:30px;padding-bottom:10px;padding-top:15px;background:#EEE;">
      <form class="form-horizontal" method="POST" action="<?php echo site_url('site/get_individual_result'); ?>">
      <div id="error" class="alert alert-warning text-center" style="display:none;"></div>
        <div class="form-group">
          <label for="m_class_id" class="col-xs-3 control-label"><?php echo $this->lang->line('class');?></label>
          <div class="col-xs-9">
            <?php 
            $classes['']=$this->lang->line('class');                     
                echo form_dropdown('class_id',$classes,"",'class="form-control" id="m_class_id"'); 
            ?>
          </div>
        </div>
        <div class="form-group">
          <label for="session_id" class="col-xs-3 control-label"><?php echo $this->lang->line('session');?></label>
          <div class="col-xs-9">
            <?php 
            $sessions['']=$this->lang->line('session');                
                echo form_dropdown('session_id',$sessions,"",'class="form-control" id="session_id" onchange="get_exam_name()"'); 
            ?>
          </div>
        </div>
        <div class="form-group">
          <label for="student_id" class="col-xs-3 control-label"><?php echo $this->lang->line('student id');?></label>
          <div class="col-xs-9">
            <input type="text" name="student_id" id="student_id" class="form-control" />
          </div>
        </div>
        <div class="form-group" id="exam_info">
          
        </div>
        <div class="form-group">
          <label class="col-xs-3 control-label"></label>
          <div class="col-xs-9">
            <button type="submit" class="btn btn-primary btn-lg" id="student_result"><i class="fa fa-search"></i> <?php echo $this->lang->line('search');?></button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<style>
  table,table tr td,table tr th{ border:1px solid #777 !important;}
</style>



<script type="text/javascript">
  $j('document').ready(function(){
    //dept and course change on class change , only for non - crud pages
    $("#m_class_id").change(function(){ 
      $('#session_id').val(''); 
      $('#error').hide();
      $('#exam_info').show();
      $('#student_result').show();       
                  
    });

  });


  $("#student_result").on('click',function(e){
    var class_id = $('#m_class_id').val();
    var session_id = $('#session_id').val();
    var student_id = $('#student_id').val();
    var exam_id = $('#exam_name').val();

    if(class_id == '' || session_id == '' || exam_id == '' || student_id == ''){
      e.preventDefault();
      $('#error').show().html('<b>'+"<?php echo $this->lang->line('please select all the fields');?>"+'</b>');
    }
  });

  function get_exam_name(){
    var class_id = $('#m_class_id').val();
    var session_id = $('#session_id').val();
    if(class_id == '' || session_id == ''){
      $('#session_id').val('');
      alert("Please select class first.");
      return;
    }
    var base_url="<?php echo site_url();?>";
    $.ajax
        ({
           type:'POST',
           async:false,
           url:base_url+'site/get_exam_name_for_result',
           data:{class_id:class_id,session_id:session_id},
           success:function(response)
            {
              if(response == ''){
                $('#exam_info').hide();
                $('#student_result').hide();
                $('#error').show().html("<?php echo $this->lang->line('no result is published for this session.');?>");
              }
              else{
                $('#exam_info').show().html(response);
                $('#student_result').show();
                $('#error').hide();
              }
            }
               
        }); 
  }

</script>

<script>  
  function PrintElem(elem)
    {
     
        Popup($(elem).html());
    }

    function Popup(data) 
    {
        var mywindow = window.open('', 'print_details', 'height=562,width=795');
        mywindow.document.write('<html><head><title>print_details</title>');
       // mywindow.document.write('<style> table.print_slip tbody td {border:1px solid #ccc; }</style>');
        mywindow.document.write('</head><body >');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');
        mywindow.document.close();
        mywindow.print();
        return true;
    }

</script>

