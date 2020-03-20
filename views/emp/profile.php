<?php require __DIR__.'/../auth/header.php';?>
<br/>
    <div class="col-sm-8 text-left"> 
      <div class="panel panel-info">
      <div class="panel-heading" style="text-align: center;"><h4>Profile Details</h4></div>
      <div class="panel-body table-responsive">
        <?php foreach($stu_dtl as $v_sdtl){ ?> 
          <table class="table table-striped table-bordered table-hover">
          <tbody>
            <tr>
              <td rowspan='5'> 
              <img class="media-object img-thumbnail user-img" style="width: 150px;"
              src="<?= base_url("Assets/img/user_icon.png")?>" /> 
              </td>
            </tr>
            <tr>
              <td><span style=" font-weight: bold;">Faculty:</span></td>
              <td><?php echo ucwords(strtoupper("$v_sdtl->OFA_DESC")) ?></td>
            </tr>
            <tr>
              <td><span style=" font-weight: bold;">Department:</span></td>
              <td><?php echo ucwords(strtoupper("$v_sdtl->DEP_DESC")) ?></td>
            </tr>
            <tr>
              <td><span style=" font-weight: bold;">Designation:</span></td>
              <td><?php echo $v_sdtl->EMP_DESIGNATION ?></td>
            </tr>
            <tr>
              <td><span style=" font-weight: bold;">Employee Id:</span></td>
              <td><span style=" font-weight: bold;font-size: 18px;color: green;"><?php echo $v_sdtl->EMP_ID ?></span></td>
            </tr>
            <tr>
              <td><span style=" font-weight: bold;">Name</span></td>
              <td colspan="2"><?php echo strtoupper("$v_sdtl->NAME") ?></td>
            </tr>
            <tr>
              <td><span style=" font-weight: bold;">Father's Name</span></td>
              <td colspan="2" ><?php echo strtoupper("$v_sdtl->EMP_FATHER") ?></td>
            </tr>
            <tr>
              <td><span style=" font-weight: bold;">Mother's Name</span></td>
              <td colspan="2"><?php echo strtoupper("$v_sdtl->EMP_MOTHER") ?></td>
            </tr>
            <tr>
              <td><span style=" font-weight: bold;">Spouse Name</span></td>
              <td colspan="2"><?php echo strtoupper("$v_sdtl->EMP_SPOUSE") ?></td>
            </tr>
              <td><span style=" font-weight: bold;">Gender </span></td>
              <?php if ($v_sdtl->EMP_GENDER == 'M') { ?>
                <td colspan="2">Male</td>
              <?php } else {?>
              <td colspan="2">Female</td>
            <?php } ?>
            </tr>
            <tr>
              <td><span style=" font-weight: bold;">Blood Group </span></td>
              <td colspan="2"><?php echo strtoupper("$v_sdtl->EMP_BLOOD_GROUP") ?></td>
            </tr>
            <tr>
              <td><span style=" font-weight: bold;">Date of Birth </span></td>
              <td colspan="2"> <?php echo strtoupper("$v_sdtl->EMP_DOB") ?> </td>
            </tr>
            <tr>
              <td><span style=" font-weight: bold;">Date of Retirement </span></td>
              <td colspan="2"><?php echo $v_sdtl->EMP_RET_DATE ?></td>
            </tr>
            
            <tr>
              <td ><span style=" font-weight: bold;">Email </span></td>
              <td colspan="2" ><?php echo $v_sdtl->EMP_EMAIL_ID ?> </td>
            </tr>
            <tr>
              <td ><span style=" font-weight: bold;">Alternate Email </span></td>
              <td colspan="2"><?php echo $v_sdtl->EMAIL ?></td>
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
                <td width="70%" valign="top" align="left"><?php echo $v_sdtl->C_ADD1 ?><br></td>
              </tr>
              <tr>
                <td valign="top" align="left">&nbsp;</td>
                <td valign="top" align="left"><?php echo $v_sdtl->C_ADD2 ?></td>
              </tr>
              <tr>
                <td valign="top" align="left"><strong>District/City: </strong></td>
                <td valign="top" align="left"><?php echo $v_sdtl->C_CITY ?></td>
              </tr>
              <tr>
                <td valign="top" align="left"><strong>Pin Code: </strong></td>
                <td valign="top" align="left"><?php echo $v_sdtl->C_PINCODE ?></td>
              </tr>
              <tr>
                <td valign="top" align="left"><strong>State: </strong></td>
                <td valign="top" align="left"><?php echo $v_sdtl->C_STATE ?></td>
              </tr>
              <tr>
                <td valign="top" align="left"><strong>Country: </strong></td>
                <td valign="top" align="left"><?php echo $v_sdtl->EMP_NATIONALITY ?></td>
              </tr>
              <tr>
                <td valign="top" align="left"><strong>Mobile No: </strong></td>
                <td valign="top" align="left"><?php echo $v_sdtl->C_MOBILE ?></td>
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
                <td width="70%" valign="top" align="left"><?php echo $v_sdtl->P_ADD1 ?></td>
              </tr>
              <tr>
                <td valign="top" align="left">&nbsp;</td>
                <td valign="top" align="left"><?php echo $v_sdtl->P_ADD2 ?></td>
              </tr>
              <tr>
                <td valign="top" align="left"><strong>District/City: </strong></td>
                <td valign="top" align="left"><?php echo $v_sdtl->P_CITY ?></td>
              </tr>
              <tr>
                <td valign="top" align="left"><strong>Pin Code: </strong></td>
                <td valign="top" align="left"><?php echo $v_sdtl->P_PINCODE ?></td>
              </tr>
              <tr>
                <td valign="top" align="left"><strong>State: </strong></td>
                <td valign="top" align="left"><?php echo $v_sdtl->P_STATE ?></td>
              </tr>
              <tr>
                <td valign="top" align="left"><strong>Country: </strong></td>
                <td valign="top" align="left"><?php echo $v_sdtl->EMP_NATIONALITY ?></td>
              </tr>
              <tr>
                <td valign="top" align="left"><strong>Mobile No: </strong></td>
                <td valign="top" align="left"><?php echo $v_sdtl->P_MOBILE ?></td>
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