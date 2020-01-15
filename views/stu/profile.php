<?php $header_path = __DIR__.'/../auth/header.php'; 
          require $header_path; ?>
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
              <td><?php echo ucwords(strtolower("$v_sdtl->OFA_DESC")) ?></td>
            </tr>
            <tr>
              <td><span style=" font-weight: bold;">Department:</span></td>
              <td><?php echo ucwords(strtolower("$v_sdtl->DEP_DESC")) ?></td>
            </tr>
            <tr>
              <td><span style=" font-weight: bold;">Course Details:</span></td>
              <td><?php echo $v_sdtl->COURSE ?></td>
            </tr>
            <tr>
              <td><span style=" font-weight: bold;">Student Id:</span></td>
              <td colspan="2"><h4 style="font-weight: bold;"><?php echo strtoupper("$v_sdtl->STU_ID") ?></h4></td>
            </tr>
            <tr>
              <td><span style=" font-weight: bold;">Name</span></td>
              <td colspan="2"><?php echo strtoupper("$v_sdtl->NAME") ?></td>
            </tr>
            <tr>
              <td><span style=" font-weight: bold;">Father's Name</span></td>
              <td colspan="2" ><?php echo strtoupper("$v_sdtl->STU_FATHER_NAME") ?></td>
            </tr>
            <tr>
              <td><span style=" font-weight: bold;">Mother's Name</span></td>
              <td colspan="2"><?php echo strtoupper("$v_sdtl->STU_MOTHER_NAME") ?></td>
            </tr>
            <tr>
              <td><span style=" font-weight: bold;">Spouse Name</span></td>
              <td colspan="2"><?php echo strtoupper("$v_sdtl->STU_HUSBAND_NAME") ?></td>
            </tr>
              <td><span style=" font-weight: bold;">Gender </span></td>
              <td colspan="2"><?php echo strtoupper("$v_sdtl->STU_SEX") ?></td>
            </tr>
            <tr>
              <td><span style=" font-weight: bold;">Blood Group </span></td>
              <td colspan="2"><?php echo $v_sdtl->STU_BLOOD_GR ?></label></td>
            </tr>
            <tr>
              <td><span style=" font-weight: bold;">Date of Birth </span></td>
              <td colspan="2"> <?php echo strtoupper("$v_sdtl->STU_DOB") ?> </td>
            </tr>
            <tr>
              <td><span style=" font-weight: bold;">Date of Addmision </span></td>
              <td colspan="2"><?php echo $v_sdtl->STU_DOA ?></td>
            </tr>
            
            <tr>
              <td ><span style=" font-weight: bold;">Email </span></td>
              <td colspan="2" ><?php echo $v_sdtl->EMAIL ?> </td>
            </tr>
            <tr>
              <td ><span style=" font-weight: bold;">Alternate Email </span></td>
              <td colspan="2"></td>
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
                <td valign="top" align="left"><?php echo $v_sdtl->STU_NATIONALITY ?></td>
              </tr>
              <tr>
                <td valign="top" align="left"><strong>Mobile No: </strong></td>
                <td valign="top" align="left"><?php echo "+".$v_sdtl->C_MOBILE ?></td>
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
                <td valign="top" align="left"><?php echo $v_sdtl->STU_NATIONALITY ?></td>
              </tr>
              <tr>
                <td valign="top" align="left"><strong>Mobile No: </strong></td>
                <td valign="top" align="left"><?php echo "+".$v_sdtl->P_MOBILE ?></td>
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
    <?php $footer_path = __DIR__.'/../auth/footer.php'; 
          require $footer_path; ?>