<?php require __DIR__.'/../auth/header.php';?>
<br/>
    <div class="col-sm-8 text-left"> 
      <div class="panel panel-info">
      <div class="panel-heading" style="text-align: center;"><h4>Profile Details</h4></div>
      <div class="panel-body table-responsive">
        <?php foreach($emp_dtl as $v_edtl){ ?> 
          <table class="table table-striped table-bordered table-hover">
          <tbody>
            <tr>
              <td rowspan='5'>
                <?php
                  $this->load->library('image_lib');
                  $image = new Imagick();
                  $image->readimageblob($showrow);
                  $image->setImageFormat("png");
                  echo '<img src="data:image/png;charset=utf-8;base64,' .  base64_encode($image->getimageblob())  . '" style="width: 150px; height: 180px;" />';
                ?><!-- 
                <img src="<?php echo 'data:image/tiff;charset=utf-8;base64,' . base64_encode($showrow) ?>"  style="width: 150px; height: 180px;" /> 
             -->  </td>
            </tr>
            <tr>
              <td><span style=" font-weight: bold;">Faculty:</span></td>
              <td><?php echo ucwords(strtoupper("$v_edtl->OFA_DESC")) ?></td>
            </tr>
            <tr>
              <td><span style=" font-weight: bold;">Department:</span></td>
              <td><?php echo ucwords(strtoupper("$v_edtl->DEP_DESC")) ?></td>
            </tr>
            <tr>
              <td><span style=" font-weight: bold;">Designation:</span></td>
              <td><?php echo $v_edtl->EMP_DESIGNATION ?></td>
            </tr>
            <tr>
              <td><span style=" font-weight: bold;">Employee Id:</span></td>
              <td><span style=" font-weight: bold;font-size: 18px;color: green;"><?php echo $v_edtl->EMP_ID ?></span></td>
            </tr>
            <tr>
              <td><span style=" font-weight: bold;">Name</span></td>
              <td colspan="2"><?php echo strtoupper("$v_edtl->NAME") ?></td>
            </tr>
            <tr>
              <td><span style=" font-weight: bold;">Father's Name</span></td>
              <td colspan="2" ><?php echo strtoupper("$v_edtl->EMP_FATHER") ?></td>
            </tr>
            <tr>
              <td><span style=" font-weight: bold;">Mother's Name</span></td>
              <td colspan="2"><?php echo strtoupper("$v_edtl->EMP_MOTHER") ?></td>
            </tr>
            <tr>
              <td><span style=" font-weight: bold;">Spouse Name</span></td>
              <td colspan="2"><?php echo strtoupper("$v_edtl->EMP_SPOUSE") ?></td>
            </tr>
              <td><span style=" font-weight: bold;">Gender </span></td>
              <?php if ($v_edtl->EMP_GENDER == 'M') { ?>
                <td colspan="2">Male</td>
              <?php } else {?>
              <td colspan="2">Female</td>
              <?php } ?>
            </tr>
            <tr>
              <td><span style=" font-weight: bold;">Blood Group </span></td>
              <td colspan="2"><?php echo strtoupper("$v_edtl->EMP_BLOOD_GROUP") ?></td>
            </tr>
            <tr>
              <td><span style=" font-weight: bold;">Date of Birth </span></td>
              <td colspan="2"> <?php echo $v_edtl->EMPDOB ?> </td>
            </tr>
            <tr>
              <td><span style=" font-weight: bold;">Date of Retirement </span></td>
              <td colspan="2"><?php echo $v_edtl->EMPRETDATE ?></td>
            </tr>
            
            <tr>
              <td ><span style=" font-weight: bold;">Email </span></td>
              <td colspan="2" ><?php echo $v_edtl->EMP_EMAIL_ID ?> </td>
            </tr>
            <tr>
              <td ><span style=" font-weight: bold;">Alternate Email </span></td>
              <td colspan="2"><?php echo $v_edtl->EMAIL ?></td>
            </tr>
            <!-- education  details -->
            <tr>
              <td valign="top" align="left" style="width:100%;" colspan="12">
              <table class="table table-striped table-bordered table-hover" >
              <thead style="background:#C8ECF9">
              <tr>
                <th valign="top" align="left" style=" text-align:center; " colspan="12"><strong>QUALIFICATION DETAILS </strong></th>
              </tr>
              </thead>
              <tbody>
              <tr>
                <th valign="top" align="left"><strong>S.No </strong></th>
                <th valign="top" align="left"><strong>Description </strong></th>
                <th valign="top" align="left"><strong>From </strong></th>
                <th valign="top" align="left"><strong>To </strong></th>
                <th valign="top" align="left"><strong>Grade</strong></th>
                <th valign="top" align="left"><strong>Percentage </strong></th>
                <th valign="top" align="left"><strong>University/Board </strong></th>
              </tr>
              <?php
              $no = 0;
              foreach ($edu_dtl as $v_edu):
              $no++;
              ?>
              <tr>
                <td valign="top" align="left"><?php echo $no ?></td>
                <td valign="top" align="left"><?php echo $v_edu->QUA_EDUCATION ?></td>
                <td valign="top" align="left"><?php echo $v_edu->EMQ_YR_FROM ?></td>
                <td valign="top" align="left"><?php echo $v_edu->EMQ_YR_TO ?></td>
                <td valign="top" align="left"><?php echo $v_edu->EMQ_GRADE_PCT ?></td>
                <td valign="top" align="left"><?php echo $v_edu->EMQ_PCT ?></td>
                <td valign="top" align="left"><?php echo $v_edu->EMQ_UNIV_BRD ?></td>
              </tr>
              <?php endforeach; ?>
              </tbody>
              </table>
              </td>
            </tr>

             <!-- family  details -->
            <tr>
              <td valign="top" align="left" style="width:100%;" colspan="12">
              <table class="table table-striped table-bordered table-hover" >
              <thead style="background: #C8ECF9">
              <tr>
                <th valign="top" align="left" style=" text-align:center; " colspan="12"><strong>FAMILY DETAILS </strong></th>
              </tr>
              </thead>
              <tbody>
              <tr>
                <th valign="top" align="left"><strong>S.No </strong></th>
                <th valign="top" align="left"><strong>Name </strong></th>
                <th valign="top" align="left"><strong>Relationship </strong></th>
                <th valign="top" align="left"><strong>Gender </strong></th>
                <th valign="top" align="left"><strong>D.O.B </strong></th>
                <th valign="top" align="left"><strong>Nominee<br>Dependent </strong></th>
                <th valign="top" align="left"><strong>A/C No </strong></th>
                <th valign="top" align="left"><strong>Bank Name </strong></th>
              </tr>
              <?php
              $no = 0;
              foreach ($fam_dtl as $v_fam):
              $no++;
              ?>
              <tr>
                <td valign="top" align="left"><?php echo $no ?></td>
                <td valign="top" align="left"><?php echo $v_fam->FAM_MEM_NAME ?></td>
                <td valign="top" align="left"><?php echo $v_fam->FAM_RELATIONSHIP ?></td>
                <?php if ($v_fam->FAM_GENDER == 'M') { ?>
                  <td valign="top" align="left">Male</td>
                <?php } else {?>
                  <td valign="top" align="left">Female</td>
                <?php } ?>
                <td valign="top" align="left"><?php echo $v_fam->FAMDOB ?></td>
                <?php if ($v_fam->FAM_DEPENDENT == 'Y') { ?>
                  <td valign="top" align="left">Yes</td>
                <?php } else {?>
                  <td valign="top" align="left">No</td>
                <?php } ?>
                <td valign="top" align="left"><?php echo $v_fam->FAM_ACCT_NO ?></td>
                <td valign="top" align="left"><?php echo $v_fam->FAM_BANK_NAME ?></
              </tr>
              <?php endforeach; ?>
              </tbody>
              </table>
              </td>
            </tr>

            <tr>
              <td valign="top" align="left" style="width:50%;" colspan="2">
              <table class="table" >
              <thead style="background:#C8ECF9">
              <tr>
                <th valign="top" align="left" style=" text-align:center; " colspan="2"><strong>PRESENT ADDRESS </strong></th>
              </tr>
              </thead>
              <tbody>
              <tr>
                <td width="30%" valign="top" align="left"><strong>Present Address </strong>:</td>
                <td width="70%" valign="top" align="left"><?php echo $v_edtl->C_ADD1 ?><br></td>
              </tr>
              <tr>
                <td valign="top" align="left">&nbsp;</td>
                <td valign="top" align="left"><?php echo $v_edtl->C_ADD2 ?></td>
              </tr>
              <tr>
                <td valign="top" align="left"><strong>District/City: </strong></td>
                <td valign="top" align="left"><?php echo $v_edtl->C_CITY ?></td>
              </tr>
              <tr>
                <td valign="top" align="left"><strong>Pin Code: </strong></td>
                <td valign="top" align="left"><?php echo $v_edtl->C_PINCODE ?></td>
              </tr>
              <tr>
                <td valign="top" align="left"><strong>State: </strong></td>
                <td valign="top" align="left"><?php echo $v_edtl->C_STATE ?></td>
              </tr>
              <tr>
                <td valign="top" align="left"><strong>Country: </strong></td>
                <td valign="top" align="left"><?php echo $v_edtl->EMP_NATIONALITY ?></td>
              </tr>
              <tr>
                <td valign="top" align="left"><strong>Mobile No: </strong></td>
                <td valign="top" align="left"><?php echo $v_edtl->C_MOBILE ?></td>
              </tr>
              </tbody>
              </table>
              </td>
              <td valign="top" align="left" style="width:50%;" colspan="2">
              <table class="table" >
              <thead style="background:#C8ECF9">
              <tr>
                <th valign="top" align="left" style="text-align:center;" colspan="2"><strong>PARMANENT ADDRESS </strong></th>
              </tr>
              </thead>
              <tbody>
              <tr>
                <td width="30%" valign="top" align="left"><strong>Parmanent Address </strong>:</td>
                <td width="70%" valign="top" align="left"><?php echo $v_edtl->P_ADD1 ?></td>
              </tr>
              <tr>
                <td valign="top" align="left">&nbsp;</td>
                <td valign="top" align="left"><?php echo $v_edtl->P_ADD2 ?></td>
              </tr>
              <tr>
                <td valign="top" align="left"><strong>District/City: </strong></td>
                <td valign="top" align="left"><?php echo $v_edtl->P_CITY ?></td>
              </tr>
              <tr>
                <td valign="top" align="left"><strong>Pin Code: </strong></td>
                <td valign="top" align="left"><?php echo $v_edtl->P_PINCODE ?></td>
              </tr>
              <tr>
                <td valign="top" align="left"><strong>State: </strong></td>
                <td valign="top" align="left"><?php echo $v_edtl->P_STATE ?></td>
              </tr>
              <tr>
                <td valign="top" align="left"><strong>Country: </strong></td>
                <td valign="top" align="left"><?php echo $v_edtl->EMP_NATIONALITY ?></td>
              </tr>
              <tr>
                <td valign="top" align="left"><strong>Mobile No: </strong></td>
                <td valign="top" align="left"><?php echo $v_edtl->P_MOBILE ?></td>
              </tr>
              </tbody>
              </table>
              </td>
            </tr>
            <!-- Bank  details -->
            <tr>
              <td valign="top" align="left" style="width:100%;" colspan="12">
              <table class="table table-striped table-bordered table-hover" >
              <thead style="background:#C8ECF9">
              <tr>
                <th valign="top" align="left" style=" text-align:center; " colspan="12"><strong>BANK DETAILS </strong></th>
              </tr>
              </thead>
              <tbody>
              <tr>
                <th valign="top" align="left"><strong>S.No </strong></th>
                <th valign="top" align="left"><strong>Bank Name </strong></th>
                <th valign="top" align="left"><strong>Barach Name </strong></th>
                <th valign="top" align="left"><strong>Account Type </strong></th>
                <th valign="top" align="left"><strong>Account No </strong></th>
                <th valign="top" align="left"><strong>Address </strong></th>
              </tr>
              <?php
              $no = 0;
              foreach ($bank_dtl as $v_bank):
              $no++;
              ?>
              <tr>
                <td valign="top" align="left"><?php echo $no ?></td>
                <td valign="top" align="left"><?php echo $v_bank->EMP_BANK_NAME ?></td>
                <td valign="top" align="left"><?php echo $v_bank->EMP_BRANCH ?></td>
                <?php if ($v_bank->EMP_ACC_TYPE == 'S') { ?>
                  <td valign="top" align="left">Saving Account</td>
                <?php } else {?>
                  <td valign="top" align="left">Current Account</td>
                <?php } ?>
                <td valign="top" align="left"><?php echo $v_bank->EMP_ACC_NO ?></td>
                <td valign="top" align="left"><?php echo $v_bank->EMP_BANK_ADDRESS ?></td>
              </tr>
              <?php endforeach; ?>
              </tbody>
              </table>
              </td>
            </tr>
          </tbody>
          </table>
        <?php } ?>
      </div>
      </div>  
    </div>
    <?php require __DIR__.'/../auth/footer.php' ?>