<?php include 'C:\xampp\htdocs\CI\application\views\auth\header.php';?>

    <div class="col-sm-8 text-left"> 
      <br>
      <!--------- Start body --------->
      <div class="panel panel-info">
        <div class="panel-heading" style="text-align: center;"><h4>Course Fee</h4></div>
          <div class="panel-body table-responsive">      
            <table class="table table-striped table-bordered table-hover" align="center" style="font-size:15px; font-family:Calibri;">
            <thead>    
              <tr>
                <th>S.No</th>
                <th>Program Name</th>
                <th>Reciept No</th>
                <th>Fee Amount</th>
                <th>Last Date</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
            <?php
                $no = 0;
                foreach ($stu_fee_pay as $sfp):
                $no++;
              ?>
              <tr>
                <td><?php echo $no ?></td>
                <td><?php echo $sfp->COURSE ?></td>
                <td><?php echo $sfp->SFD_RECP_NO ?></td>
                <td><?php echo $sfp->SFD_CHQ_AMT. "/-" ?></td>
                <td><?php echo $sfp->LAST_DT ?></td>
                <?php $last_date=$sfp->LAST_DT; $current_date=date('d-m-y');if($current_date>$last_date) {?>
                <td>
                   <a target="_blank" href="http://14.139.62.116/JOLF/Students/Students/getStudentFeeDetailsAction? " class="btn btn-sm btn-info">Pay</a>
                </td>
              <?php }else{?>
                <td>
                   <a target="_blank" href="http://14.139.62.116/JOLF/Students/Students/getStudentFeeDetailsAction? " class="btn btn-sm btn-info disabled">Pay</a>
                </td>
              <?php }?>
              </tr>
            <?php endforeach; ?>            
            </tbody>
            </table> 
          </div>        
      </div>       
      <!---------- end ------------->  
    </div>
<?php include 'C:\xampp\htdocs\CI\application\views\auth\footer.php';?>