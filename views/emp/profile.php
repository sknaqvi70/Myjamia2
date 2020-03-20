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
                <?php $filePath='\\\\'."10.2.0.41\mis_emp_photo".'\\'.$v_edtl->EMP_ID.".JFIF"; ?> 
            
              <img class="media-object img-thumbnail user-img" style="width: 150px;"
              src="<?php echo $filePath ?>" /> 
              </td>
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
              <td colspan="2"> <?php echo strtoupper("$v_edtl->EMP_DOB") ?> </td>
            </tr>
            <tr>
              <td><span style=" font-weight: bold;">Date of Retirement </span></td>
              <td colspan="2"><?php echo $v_edtl->EMP_RET_DATE ?></td>
            </tr>
            
            <tr>
              <td ><span style=" font-weight: bold;">Email </span></td>
              <td colspan="2" ><?php echo $v_edtl->EMP_EMAIL_ID ?> </td>
            </tr>
            <tr>
              <td ><span style=" font-weight: bold;">Alternate Email </span></td>
              <td colspan="2"><?php echo $v_edtl->EMAIL ?></td>
            </tr>
            <tr>
              <td valign="top" align="left" style="width:50%;" colspan="2">
              <table class="table" >
              <thead style="background:#008cba1f">
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
              <thead style="background:#008cba1f">
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
          </tbody>
          </table>
        <?php } ?>
      </div>
      </div>  
    </div>
    <?php require __DIR__.'/../auth/footer.php' ?>