<?php require __DIR__.'/../auth/header.php'; ?>
<br>
    <div class="col-sm-8 text-left"> 
      
      <!--------- Start body --------->
      <div class="panel panel-info">
        <div class="panel-heading" style="text-align: center;"><h4>Earn Leave Summary</h4></div>
          <div class="panel-body table-responsive"> 
          <input type="hidden" id="base" value="<?php echo base_url(); ?>">     
            <table border='0'>
            <!-- from -->
            <tr>
              <td><label ><h5><b>Please Select Period (From ) :</b></h5></label></td>
              <td>
                <select id='id_fromPeriod' class="form-control">
                  <option>-- Select --</option>
                  <?php foreach($fromperiod as $v_from){
                  echo "<option value='".$v_from['FROM_DATE']."'>".$v_from['FROM_DATE']."</option>";
                  } ?>
                  
                </select>
              </td>
            </tr>
            <!-- to  -->
            <tr>
              <td><label><h5><b>Please Select Period ( To ) :</b></h5></label></td>
              <td>
                <select id='id_toPeriod' class="form-control">
                  <option>--- Select ---</option>
                </select>
              </td>
            </tr>
            </table>
            <hr><br>              
            <!-- -->
            
              <div id="printThis">
                <div>
                <span id="id_earnLeaveEmpDtl"></span>             
                </div>
                
                <div> 
                  <!-- <?php echo $stu_pfee_dtl?> -->
                </div><br>
                <table class="table table-striped table-bordered table-hover" align="center" style="font-size:15px; font-family:Calibri;border: 2px solid black;border-color: coral">
                  <thead>    
                    <tr>
                      <th>Leave Type</th>
                      <th>From Date</th>
                      <th>To Date</th>
                      <th>No of Leave(s)</th>
                      <th>Leave Apply Date</th>
                      <th>Closing Balance</th>
                    </tr>
                  </thead>
                  <tbody id='id_leaveTakenDtl'>      
                  </tbody>                            
                </table>
              </div>
              <div align="center">
                <a target="_blank" onclick="printArea('printThis');" class="btn btn-sm btn-info">Print</a>
              </div> 
              <script type="text/javascript">     
              function printArea(areaName)
              {
                var printContents = document.getElementById(areaName).innerHTML;
                var originalContents = document.body.innerHTML;
                document.body.innerHTML = printContents;
                window.print();
                document.body.innerHTML = originalContents;
              } 
              </script>
              <br><br>  
                       
            <!---------- ATTENDANCE TABLE END ------------->
          </div> 
          <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> 
          <script src="<?php  echo base_url('application/assets/js/postLogin/emp/earnLeaveBalance.js'); ?>"></script>         
        <!---------- end loading time waiting gif ------------->    
      </div> 
      <!---------- end ------------->  
    </div>
    <?php require __DIR__.'/../auth/footer.php'; ?>