<?php require __DIR__.'/../auth/header.php'; ?>
<br>
    <div class="col-sm-8 text-left">       
      <!--------- Start Complaint Registration --------->
      <div class="panel panel-info">
        <div class="panel-heading" style="text-align: center;"><h4>Track Complaint Status</h4></div>
          <div class="panel-body table-responsive">
          <?php if(isset($comp_status)) {?>
          <!-- this table is used for fee details display -->
            <table class="table table-striped table-bordered table-hover" align="center" style="font-size:15px; font-family:Calibri;">
            <thead>    
            <tr>
              <th>S.No</th>
              <th>Ticket<br>Number</th>
              <th>Category</th>
              <th>Sub Category</th>
              <th>Complaint Description</th>
              <th>Complaint Date</th>
              <th>Complaint Close Date</th>
            </tr>
            </thead>
            <tbody>
            <?php
              $no = 0;
              foreach ($comp_status as $csd):
              $no++;
            ?>
            <tr>
              <td><?php echo $no ?></td>
              <td><a href="<?php echo site_url('Complaint/get_details_Status/'.$csd->CM_NO);?>"><?php echo $csd->CM_NO ?></a>
              </td>
              <td><?php echo $csd->CC_NAME ?></td>
              <td><?php echo $csd->CSC_NAME ?></td>
              <td><?php echo $csd->CM_COMPLAINT_TEXT ?></td>
              <td><?php echo $csd->REGDATE ?></td>
              <td><?php echo $csd->CLOSEDDATE ?></td>
            </tr>
            <?php endforeach; ?>
            </tbody>
            </table>
          <?php } ?>
          <!-- when click on view this function is call -->
          <?php if (isset($comp_status_dtl)) { ?>
          <div id="printThis">
            <center>
              <p style="font-size:20px; font-family:Calibri;">Ticket History</p>
              <img src="<?= base_url(); ?>application/assets/images/appllogo1.bmp" alt="JMI" style="width:100px;height:100px;" align="middle">             
            </center>            
            <div> 
            <?php echo $comp_status_dtl?>
            </div><br>
          </div>
          <div align="center">
            <a target="_blank" onclick="printArea('printThis');" class="btn btn-sm btn-info">Print</a>
            <a href="<?php echo site_url('Complaint/trackComplaintStatus/');?>" class="btn btn-sm btn-danger">Cancel</a>&nbsp;&nbsp;&nbsp;&nbsp;                      
            
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
    <?php require __DIR__.'/../auth/footer.php'; ?>