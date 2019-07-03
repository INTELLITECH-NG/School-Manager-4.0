
  <section class="content">

  <?php 
      if($this->session->userdata('complete_result_success')){
        echo "<div class='alert alert-success text-center'><h4 style='margin:0;'><i class='fa fa-check-circle'></i> ".$this->session->userdata('complete_result_success')."</h4></div>";
        $this->session->unset_userdata('complete_result_success');
      }
      if($this->session->userdata('complete_result_error')){
        echo "<div class='alert alert-warning text-center'><h4 style='margin:0;'><i class='fa fa-check-circle'></i> ".$this->session->userdata('complete_result_error')."</h4></div>";
        $this->session->unset_userdata('complete_result_error');
      }         
  ?>

    <div class="box box-info custom_box">
      <div class="box-header">
        <h3 class="box-title"><i class="fa fa-binoculars"></i> <?php echo $this->lang->line('search students');?></h3>
      </div><!-- /.box-header -->

      <form class="form-horizontal" action="<?php echo base_url('admin_result_view/get_result_sheet'); ?>" method="POST">
        <div class="box-body">
          <div class="col-xs-12">
            <div class="row">
              <p class="alert alert-warning text-center" id="error" style="display:none;"></p>
            </div>
            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                <?php 
                $classes['']=$this->lang->line('class');                      
                    echo form_dropdown('class_id',$classes,"",'class="form-control" id="m_class_id"'); 
                ?>
              </div>
                

              <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                <?php 
                  $shifts['']=$this->lang->line('shift');                      
                      echo form_dropdown('shift_id',$shifts,"",'class="form-control" id="shift_id"'); 
                ?>
              </div>

              <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                <?php 
                  $sections['']=$this->lang->line('section');                      
                      echo form_dropdown('section_id',$sections,"",'class="form-control" id="section_id"'); 
                ?>
              </div>

              <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                <select name="dept_id" id="dept_id" class="form-control">
                  <option value=""><?php echo $this->lang->line('group / dept.');?> </option>                  
                </select>
              </div>

              <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                  <?php 
                  $sessions['']= $this->lang->line('session');                      
                      echo form_dropdown('session_id',$sessions,"",'class="form-control" id="session_id" onchange="get_exam_name()"'); 
                  ?>
              </div>

              <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2" id="exam_info">
                <select name="exam_name" id="exam_name" class="form-control">
                  <option value=""><?php echo $this->lang->line('exam name');?></option>                  
                </select>
              </div>

            </div>
            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 pull-right">
                  <input type="submit" id="student_list" value="<?php echo $this->lang->line('search students');?>" class="btn btn-primary" style="width:100%;margin-top:7px;">
              </div>
            </div>
            <div class="row">
              <div style="display:none;" id="no_exam">
                <br/><br/>
                <div class="alert alert-warning text-center" id="no_exam_text">
                  
                </div>
              </div>
            </div>
      </form> 

            <?php
              if(isset($marks)) {
                foreach($marks as $mark){
                  $student_marks[$mark['student_id']][$mark['course_id']]['grade_point'] = $mark['grade_point'];
                  $student_marks[$mark['student_id']][$mark['course_id']]['grade'] = $mark['grade'];
                }
                if(empty($students)) 
                  echo "<h3><div class='alert alert-info text-center'><i class='fa fa-info'></i>",$this->lang->line("No data to show."),"</div></h3>";
                  else{
              
            ?>
        <input type="hidden" name="exam_id" id="exam_id" value="<?php echo $exam_id; ?>" />                 
              <div class="row"> 
                  <br/>
                  <?php 
                    $display_print = 'none';
                    if($is_complete == '1')
                      $display_print = 'block';
                  ?>
                  <div style="display:<?php echo $display_print; ?>">
                    <center><a id="print_link" class="btn btn-info btn-lg" href="#" onClick="PrintElem('#print_details')" >&nbsp;&nbsp;&nbsp;<i class='fa fa-print'></i> Print&nbsp;&nbsp;&nbsp;</a></center>
                    <br/><br/>
                  </div>
                  <div class="table-responsive" id="print_details">
                  <?php if(isset($exam_name) && $exam_name!="") {?>
                  <caption><?php echo "<br/><h3 align='center' class='text-center'>Class:".$students[0]['class_name']."(".$students[0]['dept_name'].")"." , Shift: ".$students[0]['shift_name']." , Section: ".$students[0]['section_name']."<br/>Session: ".$students[0]['session_name']." , Exam : ".$exam_name.'</h3>'; ?></caption>
                  <?php } ?>
                  <table cellpadding="7px"  align='center' class="table table-bordered table-zebra table-hover table-stripped background_white" width="90%" border="1" style="border-collapse:collapse;">
                    <tr>
                      <th align="left"><?php echo $this->lang->line('student id');?></th>
                      <th align="left"><?php echo $this->lang->line('student name');?></th>
                      <?php 
                        for($i=0;$i<count($courses);$i++) 
                          echo '<th>'.$courses[$i]['course_name'].'</th>';
                      ?>
                      <th><?php if($gpa_cgpa == 'gpa') echo 'GPA'; else echo 'CGPA'; ?></th>
                      <th>Grade</th>
                    </tr>
                    <?php 
                      //checking max_grade_point and lowest_grade_point from gpa_config table for gpa
                      $where['where'] = array('result_type'=>'gpa');
                      $max_grade_point = get_data_helper('gpa_config',$where,$select=array('max(grade_point) as top_grade'),$join='',$limit='',$start='',$order_by='',$group_by='',$num_rows=1,$single_value=1);
                      $lowest_grade_point = get_data_helper('gpa_config',$where,$select=array('min(grade_point) as lowest_grade'),$join='',$limit='',$start='',$order_by='',$group_by='',$num_rows=1,$single_value=1);
                      
                      //checking max_grade_point and lowest_grade_point form gpa_config table for cgpa
                      $where1['where'] = array('result_type'=>'cgpa');
                      $cgpa_max_grade_point = get_data_helper('gpa_config',$where1,$select1=array('max(grade_point) as top_grade'),$join='',$limit='',$start='',$order_by='',$group_by='',$num_rows=1,$single_value=1);
                      $cgpa_lowest_grade_point = get_data_helper('gpa_config',$where1,$select1=array('min(grade_point) as lowest_grade'),$join='',$limit='',$start='',$order_by='',$group_by='',$num_rows=1,$single_value=1);
                      
                      foreach($students as $student_info){
                        $student_list_for_result[$student_info['student_id']] = $student_info['student_id'];
                        $str = rawurlencode(implode(",",$student_list_for_result));

                        $where['where'] = array('student_id'=>$student_info['id'],'type'=>'0');
                        $select = array('course_id');
                        $optional_sub = get_data_helper('student_course',$where,$select,$join='',$limit='',$start='',$order_by='',$group_by='',$num_rows=1,$single_value=1);
                        $optional_course_id = 0;
                        if(!empty($optional_sub)) $optional_course_id = $optional_sub['course_id'];
                    ?>
                      <tr>
                        <td><?php echo $student_info['student_id']; ?></td>
                        <td><?php echo $student_info['name']; ?></td>
                        <?php 
                          $total = 0;
                          $number_of_subject = 0;
                          $optional_subject = 0;
                          $fail = 0;
                          $total_credit = 0;
                          $lost_credit = 0;

                          for($i=0;$i<count($courses);$i++)
                          {
                            $where2['where'] = array('id'=>$courses[$i]['id']);
                            $course_credit = get_data_helper('course',$where2,$select2=array('credit'),$join='',$limit='',$start='',$order_by='',$group_by='',$num_rows=1,$single_value=1);
                            $total_credit = $total_credit+$course_credit['credit'];
                          }

                          for($i=0;$i<count($courses);$i++)
                          {
                            $p = '';
                            $where2['where'] = array('id'=>$courses[$i]['id']);
                            $course_credit = get_data_helper('course',$where2,$select2=array('credit'),$join='',$limit='',$start='',$order_by='',$group_by='',$num_rows=1,$single_value=1);

                            if($courses[$i]['id'] == $optional_course_id)
                            {

                              if(isset($student_marks[$student_info["student_id"]][$courses[$i]["id"]]['grade_point']))
                              {
                                
                                $optional_sub_subtraction = get_data_helper('result_config',$where='',$select=array('value'),$join='',$limit='',$start='',$order_by='',$group_by='',$num_rows=1,$single_value=1);
                                $number = $student_marks[$student_info["student_id"]][$courses[$i]["id"]]['grade_point'];
                                $optional_subject = 1;
                                if($number > $optional_sub_subtraction['value'])
                                {
                                  $above_optional = $number - $optional_sub_subtraction['value'];
                                  $total = $total+$above_optional;
                                }
                                $p = number_format($number,2);
                              }
                            }
                            else
                            {

                              if(isset($student_marks[$student_info["student_id"]][$courses[$i]["id"]]['grade_point']))
                              {
                                if($gpa_cgpa == 'cgpa')
                                {
                                  $sub_total = ($course_credit['credit']*$student_marks[$student_info["student_id"]][$courses[$i]["id"]]['grade_point'])/$total_credit;
                                  $total = $total+$sub_total;
                                  $p = number_format($sub_total,2);
                                }
                                else
                                {
                                  $number = $student_marks[$student_info["student_id"]][$courses[$i]["id"]]['grade_point'];
                                  if($number == $lowest_grade_point['lowest_grade']) $fail = 1;
                                  $total = $total+$number; 
                                  $p = number_format($number,2);
                                }                                
                                
                              }
                            }

                            if($p != '')
                            {
                              $number_of_subject = $number_of_subject + 1;
                              echo '<td align="center">'.$student_marks[$student_info["student_id"]][$courses[$i]["id"]]['grade'].'</td>';
                            }
                            else
                              echo '<td align="center"></td>';
                          }
                        ?>
                        <td align="center">
                            <?php 
                              if($total != 0)
                              {
                                if($gpa_cgpa == 'cgpa')
                                {
                                  echo $total;
                                }
                                else
                                {
                                  if(number_format(($total/($number_of_subject-$optional_subject)),2) > $max_grade_point['top_grade'])
                                  {
                                    $total_gpa = $max_grade_point['top_grade'];
                                    echo $total_gpa;
                                  }
                                  else
                                  {
                                    $total_gpa = number_format(($total/($number_of_subject-$optional_subject)),2);
                                    echo $total_gpa;
                                  }
                                }
                                
                              }
                              else
                              {
                                $total_gpa = $lowest_grade_point['lowest_grade'];
                                echo $total_gpa;
                              } 
                                
                            ?>
                        </td>
                        <td align="center">
                            <?php 
                              if($fail == 1){
                                echo $gpa_config[0]['grade_name'];
                                $result_grade = $gpa_config[0]['grade_name'];
                              } 
                              else{
                                $grade_name = 0;
                                if($gpa_cgpa == 'cgpa')
                                {
                                  for($j=0;$j<count($cgpa_config)-1;$j++){
                                    if($j == count($cgpa_config))
                                      break;
                                    else{
                                      if($total >= $cgpa_config[$j]['grade_point'] && $total < $cgpa_config[$j+1]['grade_point']){
                                        $result_grade = $cgpa_config[$j]['grade_name'];
                                        echo $cgpa_config[$j]['grade_name'];
                                        $grade_name = 1;
                                        break;
                                      }
                                    }
                                  }
                                }
                                else
                                {
                                  for($j=0;$j<count($gpa_config)-1;$j++){
                                    if($j == count($gpa_config))
                                      break;
                                    else{
                                      if($total_gpa >= $gpa_config[$j]['grade_point'] && $total_gpa < $gpa_config[$j+1]['grade_point']){
                                        $result_grade = $gpa_config[$j]['grade_name'];
                                        echo $gpa_config[$j]['grade_name'];
                                        $grade_name = 1;
                                        break;
                                      }
                                    }
                                  }
                                }
                                
                                if($grade_name == 0){
                                  if($gpa_cgpa == 'cgpa')
                                  {
                                    $result_grade = $cgpa_config[$j]['grade_name'];
                                    echo $cgpa_config[$j]['grade_name'];
                                  }
                                  else
                                  {
                                    $result_grade = $gpa_config[$j]['grade_name'];
                                    echo $gpa_config[$j]['grade_name'];
                                  }
                                  
                                }
                              }

                            ?>
                        </td>
                      </tr>
                    <?php } ?>
                  </table>
                </div>
                
              </div>
              <div class="row">

                <?php 
                  $temp = 'block';
                  if($is_complete == '1') 
                    $temp = 'none';
                ?>
                <div class="text-center" style="display:<?php echo $temp; ?>"><a href='<?php echo base_url()."admin_result_view/complete_result/".$exam_id."/".$class_id_for_result."/".$dept_id_for_result."/".$shift_id_for_result."/".$section_id_for_result."/".$session_id_for_result; ?>' class="btn btn-primary">Complete Result</a></div>
              </div>
          </div>
        </div> <!-- /.box-body -->      
      <div class="box-footer">    
      <br/>    
      </div><!-- /.box-footer --> 
      <?php 
        } // end of else condition
        } //end of is isset marks
        
      ?>
            
    </div><!-- /.box-info -->
  </div>
 </section>


<script type="text/javascript">
  $j('document').ready(function(){
    //dept and course change on class change , only for non - crud pages
    $("#m_class_id").change(function(){ 
       $('#session_id').val('');        
       var base_url="<?php echo site_url();?>";       
       var img_src="<?php echo base_url();?>"+"assets/pre-loader/Fading squares.gif";
       var img1= "<img src='"+img_src+ "' alt=<?php echo $this->lang->Line('loading');?>...' id='dept_id'>";           
       var img2= "<img src='"+img_src+ "' alt=<?php echo $this->lang->line('loading');?>...' id='course_id'>";           
       $("#dept_id").parent().html(img1);
       $("#course_id").parent().html(img2);

      var class_id=$("#m_class_id").val();  
      var teacher_id="<?php echo $this->session->userdata('reference_id'); ?>";     
      if(class_id=='') class_id='Null';
      if(teacher_id=='') teacher_id='Null';

        $.ajax
        ({
           type:'POST',
           async:false,
           url:base_url+'home/dept_select_as_class/'+class_id+'/'+teacher_id,
           success:function(response)
            {
              $("#dept_id").parent().html(response);
              $('#no_exam').hide();
              $('#exam_info').show();
              $('#student_list').show();
            }
               
        });             
    });



  });


  $("#student_list").on('click',function(e){
    var class_id = $('#m_class_id').val();
    var shift_id = $('#shift_id').val();
    var section_id = $('#section_id').val();
    var department_id = $('#dept_id').val();
    var session_id = $('#session_id').val();
    var exam_id = $('#exam_name').val();

    if(class_id == '' || shift_id == '' || section_id == '' || department_id == '' ||  session_id == '' || exam_id == ''){
      e.preventDefault();
      $('#error').show().html('<b>'+"<?php echo $this->lang->line('please select all the fields');?>"+'</b>');
    }
  });

  function get_exam_name(){
    var class_id = $('#m_class_id').val();
    var department_id = $('#dept_id').val();
    var session_id = $('#session_id').val();
    if(class_id == '' || department_id == ''){
      $('#session_id').val('');
      alert('<?php echo $this->lang->line("please select class and group/dept. first");?>');
      return;
    }
    var base_url="<?php echo site_url();?>";
    $.ajax
        ({
           type:'POST',
           async:false,
           url:base_url+'admin_result_view/get_exam_name_for_admin',
           data:{class_id:class_id,department_id:department_id,session_id:session_id},
           success:function(response)
            {
              if(response == ''){
                $('#exam_info').hide();
                $('#student_list').hide();
                $('#no_exam').show();
                $('#no_exam_text').html('<h3>'+"<?php echo $this->lang->line('no exam is set for this class yet.');?>"+'</h3>');
              }
              else{
                $('#exam_info').show();
                $('#student_list').show();
                $('#no_exam').hide();
                $('#exam_info').html(response);
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


