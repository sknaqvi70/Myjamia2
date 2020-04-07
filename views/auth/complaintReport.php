<?php require __DIR__.'/../auth/header.php'; ?>
<br>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap.min.css">
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap.min.js"></script>
    <div class="col-sm-8 text-left">       
      <!--------- Start Complaint Registration --------->
      <div class="panel panel-info">
        <div class="panel-heading" style="text-align: center;"><h4>Print Complaint Report</h4></div>
          <div class="panel-body table-responsive">
          <font color="red" size="5"> Click on Complaint Number for Print</font><br><br>
          <?php if(isset($comp)) {?>
          <!-- this table is used for complaint details display for print -->
          <table id="dtBasicExample" class="table table-striped table-bordered table-responsive" cellspacing="0" width="100%" align="center" style="font-size:15px; font-family:Calibri;">
          <thead>    
            <tr>
              <th class="th-sm">S.No</th>
              <th class="th-sm">Complaint No.</th>
              <th class="th-sm">Complaint</th>
              <th class="th-sm">Complaint Attended By</th>
              <th class="th-sm">Units</th>
              <th class="th-sm">Complaint Reg. Date</th>
              <th class="th-sm">Complaint Closure Date</th>
              <!-- <th class="th-sm">Action</th> -->
            </tr>
          </thead>
          <tbody>
            <?php
              $no = 0;
              foreach ($comp as $cd):
              $no++;
            ?>
            <tr>
              <td><?php echo $no ?></td>
              <td><a target="_blank" href="<?php echo site_url('Complaint/getComplaintDtlForPrint/'.$cd->CM_NO.$cd->MJ_CAD_ID);?>"><?php echo $cd->CM_NO ?></td>
              <td><?php echo $cd->CSC_NAME ?></td>
              <td><?php echo $cd->EMPNAME ?></td>
              <td><?php echo $cd->NO_UNIT ?></td>
              <td><?php echo $cd->REGDATE ?></td>
              <?php if ($cd->CLOSEDDATE == '') { ?>
                <td>Complaint Not Closed</td>
              <?php }else { ?>
                <td><?php echo $cd->CLOSEDDATE ?></td>
              <?php } ?>
              <!-- <td><a href="<?php echo site_url('Complaint/getComplaintDtlForPrint/'.$cd->CM_NO.$cd->MJ_CAD_ID);?>" class="btn btn-sm btn-info">Print Details</a></td> -->
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        <script type="text/javascript">
        $(document).ready(function () {
            $('#dtBasicExample').DataTable({
              "pagingType": "simple" // "simple" option for 'Previous' and 'Next' buttons only
            });
            $('.dataTables_length').addClass('bs-select');
          });
        </script>
        <br><br>
        <?php } ?> 
        </div>
      </div> 
    </div>
<?php require __DIR__.'/../auth/footer.php'; ?>