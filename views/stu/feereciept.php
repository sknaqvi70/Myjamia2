<?php include 'C:\xampp\htdocs\CI\application\views\auth\header.php';?>
<br/>
    <div class="col-sm-8 text-left"> 
      <div class="panel panel-info">
      <div class="panel-heading" style="text-align: center;"><h4>Course Fee</h4></div>
      <div class="panel-body table-responsive">
        <?php if(isset($stu_fee_dtl)) {?>
        <!-- this table is used for fee details display -->
        <table class="table table-striped table-bordered table-hover" align="center" style="font-size:15px; font-family:Calibri;">
          <thead>    
            <tr>
              <th>S.No</th>
              <th>Program Name</th>
              <th>Fee Amount</th>
              <th>Payment Date</th>
              <th>View</th>
              <th>Download pdf</th>
            </tr>
          </thead>
          <tbody>
            <?php
              $no = 0;
              foreach ($stu_fee_dtl as $sfd):
              $no++;
            ?>
            <tr>
              <td><?php echo $no ?></td>
              <td><?php echo $sfd->COURSE ?></td>
              <td><?php echo $sfd->SFD_CHQ_AMT. "/-" ?></td>
              <td><?php echo $sfd->SFD_CHQ_DT ?></td>
              <td>
                <a href="<?php echo site_url('Student/get_pfee_view/'.$sfd->SFD_RECP_NO);?>" class="btn btn-sm btn-info">View</a>
              </td>
              <td>
              <a target="_blank" href="<?php echo site_url('Student/get_pfee_pdf/'.$sfd->SFD_RECP_NO);?>" class="btn btn-sm btn-info">Download pdf</a>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        <?php } ?>
        <!-- when click on view this function is call -->
        <?php if (isset($stu_pfee_dtl)) { ?>
        <div id="printThis">
          <center>
            <p style="font-size:25px; font-family:Calibri;">JAMIA MILLIA ISLAMIA</p>
            <p style="font-size:20px; font-family:Calibri;">Fee Payment Acknowledge Receipt</p>
            <a class="user-link" href="#">
            <img src="<?= base_url(); ?>application/assets/images/appllogo1.bmp" alt="JMI" style="width:100px;height:100px;" align="middle"></a>
            <br><br>
          </center>
            <p style="font-size:17px; font-family:Calibri;">This is to acknowledge the receipt of fee as per the</p>
          <div> 
            <?php echo $stu_pfee_dtl?>
          </div><br>
        </div>
        <div align="center">
          <a href="<?php echo site_url('Student/feereciept/');?>" class="btn btn-sm btn-info">Back</a>&nbsp;&nbsp;&nbsp;&nbsp;                      
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
        <?php } ?> 
      </div>
      </div>  
    </div>
<?php include 'C:\xampp\htdocs\CI\application\views\auth\footer.php';?>