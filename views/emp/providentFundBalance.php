<?php require __DIR__.'/../auth/header.php'; ?>
<br>
    <div class="col-sm-8 text-left"> 
      
      <!--------- Start body --------->
      <div class="panel panel-info">
        <div class="panel-heading" style="text-align: center;"><h4>Provident Fund Account Annual Statement</h4></div>
          <div class="panel-body table-responsive"> 
          <input type="hidden" id="base" value="<?php echo base_url(); ?>">     
            <table border='0'>
            <!-- from -->
            <tr>
              <td><label ><h5><b>Please Financial Year (From ) :</b></h5></label></td>
              <td>
                <select id='id_fromPFPeriod' class="form-control">
                  <option>-- Select --</option>
                  <?php foreach($pfyear as $v_from){
                  echo "<option value='".$v_from['PFO_YEAR']."'>".$v_from['PFO_YEAR']."</option>";
                  } ?>
                  
                </select>
              </td>
            </tr>
            <!-- to  -->
            <tr>
              <td><label><h5><b>Please Financial Year (To ) :</b></h5></label></td>
              <td>
                <select id='id_toPFPeriod' class="form-control">
                  <option>--- Select ---</option>
                </select>
              </td>
            </tr>
            </table>
            <hr><br>              
            <!-- -->
            
              <div id="printThis">
                <div>
                <span id="id_pFEmpDtl"></span>             
                </div>
                
                <div> 
                  <!-- <?php echo $stu_pfee_dtl?> -->
                </div><br>
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
                       
            <!---------- TABLE END ------------->
          </div> 
          <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> 
          <script src="<?php  echo base_url('application/assets/js/postLogin/emp/providentFundBalance.js'); ?>"></script>         
        <!---------- end loading time waiting gif ------------->    
      </div> 
      <!---------- end ------------->  
    </div>
    <?php require __DIR__.'/../auth/footer.php'; ?>