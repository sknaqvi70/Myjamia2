<?php require __DIR__.'/../auth/header.php'; ?>
<style>

.previous {
  background-color: #4CAF50;
  color: white;
}

.round {
  border-radius: 100%;
}
</style>

<br/>
    <div class="col-sm-8 text-left"> 
      <div class="panel panel-info">
      <div class="panel-heading" style="text-align: center;"><h4>Pay Slip </h4></div>
      <div class="panel-body table-responsive">             
        <?php if(isset($year)) {?>        
          
          <table class="table table-striped table-hover" align="center" style="font-size:15px; font-family:Calibri;">          
          <tr>
          <?php 
            $i = 0;
            foreach ($year as $yr) {
            if ($i % 5 === 0) {
            echo '</tr><tr>';
            } ?>        
            <td align="left"><br><a class="user-link" href="<?php echo site_url('Employee/getSalMonth/'.$yr->YEAR);?>"><img src="<?= base_url(); ?>application/assets/images/payslip.png" alt="JMI" style="width:100px;height:100px;" align="middle"></a><br>&nbsp;&nbsp;&nbsp;&nbsp;
                <?php echo '<font size="6" color="#13A6DD">'.$yr->YEAR.'</font>' ?><br><br>
            </td>
            <?php $i++;
        }?> 
        </tr>
        </table>        
        <?php } ?>

        <?php if(isset($month)) {?>
        <!-- this table is used for fee details display -->
        <font size="4" color="red">Note : </font> Password of pdf is in the Format of <font size="3" color="red">'EmployeeID@DateOfBirth(DDMMYYYY)'</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <a aling="text-left" href="<?php echo site_url('Employee/salary_slip/');?>"class="previous">&laquo;Back</a><br>
        <p align="center"><font size="5" color="blue"><?php echo 'Pay Slip of year - '.$selectedyear ?></font></p>
          <table class="table table-striped table-hover" align="center" style="font-size:15px; font-family:Calibri;">          
          <tr>
          <?php 
            $i = 0;
            foreach ($month as $mon) {
            if ($i % 6 === 0) {
            echo '</tr><tr>';
            } ?>        
            <td align="left"><br><a class="user-link" target="_blank" href="<?php echo site_url('Employee/getSalDetailsPdf/'.$mon->MONTH.$selectedyear);?>"><img src="<?= base_url(); ?>application/assets/images/pdfimage.png" alt="JMI" style="width:100px;height:100px;" align="middle"></a><br>&nbsp;&nbsp;&nbsp;&nbsp;
                <?php if ($mon->MONTH == 1) {
                  echo '<font size="5">January</font>';
                } ?>
                <?php if ($mon->MONTH == 2) {
                  echo '<font size="5">February</font>';
                } ?>
                <?php if ($mon->MONTH == 3) {
                  echo '<font size="5">March</font>';
                } ?>
                <?php if ($mon->MONTH == 4) {
                  echo '<font size="5">April</font>';
                } ?>
                <?php if ($mon->MONTH == 5) {
                  echo '<font size="5">May</font>';
                } ?>
                <?php if ($mon->MONTH == 6) {
                  echo '<font size="5">June</font>';
                } ?>
                <?php if ($mon->MONTH == 7) {
                  echo '<font size="5">July</font>';
                } ?>
                <?php if ($mon->MONTH == 8) {
                  echo '<font size="5">August</font>';
                } ?>
                <?php if ($mon->MONTH == 9) {
                  echo '<font size="5">September</font>';
                } ?>
                <?php if ($mon->MONTH == 10) {
                  echo '<font size="5">October</font>';
                } ?>
                <?php if ($mon->MONTH == 11) {
                  echo '<font size="5">November</font>';
                } ?>
                <?php if ($mon->MONTH == 12) {
                  echo '<font size="5">December</font>';
                } ?><br><br>
            </td>
            <?php $i++;
        }?> 
        </tr>
        </table>
        
        

        <br><br>  
        <?php } ?> 
      </div>
      </div>  
    </div>
    <?php require __DIR__.'/../auth/footer.php'; ?>
