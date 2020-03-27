<div class="row">
    <?php foreach($single_comp as $v_single){ ?>
      <div class="col-lg-6 table-responsive">
        <th colspan="8" align="center"><---------------- COMPLAINT DETAILS ----------------></th>
        <table class="table table-bordered" style="text-align: left;">
          <tr>
            <td><b>Complaint No</b></td>
            <td><?php echo $v_single->CM_NO ?></td>
          </tr>
          <tr>
            <td><b>Complaint Type</b></td>
            <td><?php echo $v_single->CSC_NAME ?></td>            
          </tr> 
          <tr>
            <td><b>Complaint Description</b></td>
            <td><?php echo $v_single->CM_COMPLAINT_TEXT ?></td>            
          </tr>
          <tr>
            <td><b>Department</b></td>
            <td><?php echo $v_single->DEP_DESC ?></td>            
          </tr>            
          <tr>
            <td><b>Complaint Location</b></td>
            <td><?php echo $v_single->CM_COMPLAINT_LOCATION ?></td>            
          </tr>
          <tr>
            <td><b>Complaint Status</b></td>
            <?php if ($v_single->CM_COMPLAINT_STATUS == 'R') {?>
            <td>Registered</td>  
            <?php } elseif ($v_single->CM_COMPLAINT_STATUS == 'O') { ?>
              <td>Registered</td> 
            <?php } elseif ($v_single->CM_COMPLAINT_STATUS == 'O') { ?> 
            <?php } elseif ($v_single->CM_COMPLAINT_STATUS == 'P') { ?>
              <td>Pending</td>   
            <?php } elseif ($v_single->CM_COMPLAINT_STATUS == 'C') { ?>
              <td>Closed</td>
            <?php } else { ?> 
              <td>On Hold</td>  
            <?php } ?>   
          </tr>                                  
        </table>
      </div>
      <div class="col-lg-6">
        <th colspan="8" align="center"><---------------- COMPLAINANT DETAILS ----------------></th>
        <table class="table table-bordered" style="text-align: left;">
          <tr>
            <td><b>Complainant Name</b></td>
            <td><?php echo $v_single->NAME ?></td>            
          </tr>
          <tr>
            <td><b>Contact Person</b></td>
            <td><?php echo $v_single->CM_COMPLAINT_CONTACT_PERSON ?></td>            
          </tr>
          <tr>
            <td><b>Mobile Number</b></td>
            <td><?php echo $v_single->CM_COMPLAINT_CONTACT_MOBILE ?></td>
          </tr>                        
          <tr>
            <td><b>Email Id</b></td>
            <td><?php echo $v_single->CM_COMPLAINT_CONTACT_EMAIL ?></td>            
          </tr>                                    
          <tr>
            <td><b>FTS No</b></td>
            <td><?php echo $v_single->CM_COMPLAINT_FTS_NO ?></td>            
          </tr>                        
          <tr>
            <td><b>Registration Date</b></td>
            <td><?php echo $v_single->CM_COMPLAINT_DATE ?></td>            
          </tr>                                  
        </table>       
      </div>
    <?php } ?>
</div>


     