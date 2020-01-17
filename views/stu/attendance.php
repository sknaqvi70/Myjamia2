<?php require __DIR__.'/../auth/header.php'; ?>
<br>
    <div class="col-sm-8 text-left"> 
      
      <!--------- Start body --------->
      <div class="panel panel-info">
        <div class="panel-heading" style="text-align: center;"><h4>Attendance Summary</h4></div>
          <div class="panel-body table-responsive">      
            <table border='0'>
            <!-- Semester -->
            <tr>
              <td><label ><h5><b>Please Select Semester/Year :</b></h5></label></td>
              <td>
                <select id='attsemester' class="form-control">
                  <option>-- Select Semester --</option>
                  <?php foreach($semester as $v_sem){
                  echo "<option value='".$v_sem['SSM_YEAR_SEMNO']."'>".$v_sem['SSM_YEAR_SEMNO']."-".$v_sem['YEAR_SEM']."</option>";
                  } ?>
                </select>
              </td>
            </tr>
            <!-- Session -->
            <tr>
              <td><label><h5><b>Please Select Session :</b></h5></label></td>
              <td>
                <select id='attsession' class="form-control">
                  <option>--- Select Session ---</option>
                </select>
              </td>
            </tr>
            <!-- Month -->
            <tr>
              <td><label><h5><b>Select Attendance for the month of : </b></h5></label></td>
              <td>
                <select id='attmonth' class="form-control">
                  <option>---- Select Month ----</option>
                 </select>
              </td>          
            </tr>    
            </table> 
             
            <!-- Image loader -->
            <div id='loader' style='display: none;text-align: center;'>
              <img src='<?= base_url(); ?>application/assets/images/Spinner-Preloader.gif' width='100px' height='100px'>
            </div><br> <br>
            <!-- Image END loader -->
            <table class="table table-striped table-bordered table-hover" align="center" style="font-size:15px; font-family:Calibri;">
            <thead>    
              <tr>
                <th>Paper Code</th>
                <th>Paper Name</th>
                <th>Classes Held</th>
                <th>Classes Attend</th>
                <th>Percentage(%)</th>
              </tr>
            </thead>
            <tbody id='atten'>      
            </tbody>
              <tbody>           
              <tr>                
                <th></th>
                <th>Total</th>
                <th></th>
                <th></th>
                <th></th>                           
              </tr>
              </tbody>            
            </table>
            <!---------- ATTENDANCE TABLE END ------------->
          </div> 
          <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
          <script type='text/javascript'>
          $(document).ready(function(){ 
          // Semester change
          $('#attsemester').change(function(){
            var v_semester = $(this).val();
            $.ajax({
                    url:'<?=base_url()?>Student/getSession',
                    method: 'post',
                    data: {v_semester: v_semester},
                    dataType: 'json',
                    success: function(response){
                    // Remove options  
                    $('#attmonth').find('option').not(':first').remove();         
                    $('#attsession').find('option').not(':first').remove();
                    // Add options
                    $.each(response,function(index,data){
                    $('#attsession').append('<option value="'+data['ATD_SES_ID']+'">'+data['SESDESC']+'</option>');
                    });
                    }
                  });
          });
 
          // Session change
          $('#attsession').change(function(){
            var v_session = $(this).val();
            // AJAX request
            $.ajax({
                    url:'<?=base_url()?>/Student/getMonths',
                    method: 'post',
                    data: {v_session: v_session},
                    dataType: 'json',
                    success: function(response){
 
                    // Remove options
                    $('#attmonth').find('option').not(':first').remove();

                    // Add options
                    $.each(response,function(index,data){
                    $('#attmonth').append('<option value="'+data['SM_ID']+'">'+data['SM_DESC']+'</option>');
                    });
                    }
            });
          });
          $('#attmonth').change(function(){
            var v_month = $(this).val();            
            // AJAX request
            $.ajax({
                    url:'<?=base_url()?>/Student/getStuAttendance',
                    method: 'post',
                    data: {v_month: v_month},
                    dataType: 'json',
                    beforeSend: function(){
                    // Show waiting image container
                    $("#loader").show();
                    },
                    success: function(response){
                    // Remove options
                    $('#atten').find('tr').remove();
                    // Add options
                    $.each(response,function(index,data){
                    $('#atten').append('<tr><td>'+data['PAPER_CODE']+'</td><td>'+data['SBD_PAPER']+'</td><td>'+data['TOTAL_CLASSES']+'</td><td>'+data['ATTEND']+'</td><td>'+data['PER']+'</td></tr>');
                    });
                    },
                    complete:function(data){
                    // Hide waiting image container
                    $("#loader").hide();
                    }
            });
          });
        });
        </script>       
      </div> 

      <!---------- end ------------->  
    </div>
    <?php require __DIR__.'/../auth/footer.php'; ?>