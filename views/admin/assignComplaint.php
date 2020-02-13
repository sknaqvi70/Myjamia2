 <?php echo form_open('/Admin/AsignComplaints'); ?>
        <fieldset>
<div class="row">
  <center>
    <img style="width:80px; height: 80px;"src="<?= base_url(); ?>application/assets/images/appllogo1.bmp">
  </center><br>
    <?php foreach($single_comp as $v_single){ ?>
      <div class="col-lg-6 table-responsive">
       
        <th colspan="8" align="center"><---------------- COMPLAINTS DETAILS ----------------></th>
        <table class="table table-bordered" style="text-align: left;">          
          <tr>
            <td><b>Complaint No</b></td>
            <td><?php echo form_input(['name'=>'CM_NO','class'=>'form-control','readonly'=>'true', 'id'=>'id_CM_NO','placeholder'=>'Complaint No', 'value'=>$v_single->CM_NO]); echo form_error('CM_NO');?>
            </td>
          </tr>          
          <tr>
            <td><b>Complaint Description</b></td>
            <td><?php echo form_textarea(['name'=>'CM_COMPLAINT_TEXT','class'=>'form-control','readonly'=>'true', 'id'=>'id_CM_COMPLAINT_TEXT','placeholder'=>'Complaint Description', 'value'=>$v_single->CM_COMPLAINT_TEXT]); echo form_error('CM_COMPLAINT_TEXT');?>
            </td>            
          </tr>
          <tr>
            <td><b>Department</b></td>
            <td><?php echo form_input(['name'=>'DEP_DESC','class'=>'form-control','readonly'=>'true', 'id'=>'id_DEP_DESC','placeholder'=>'Department', 'value'=>$v_single->DEP_DESC]); echo form_error('DEP_DESC');?>
            </td>            
          </tr>            
          <tr>
            <td><b>Complaint Location</b></td>
            <td><?php echo form_input(['name'=>'CM_COMPLAINT_LOCATION','class'=>'form-control','readonly'=>'true', 'id'=>'id_CM_COMPLAINT_LOCATION','placeholder'=>'Complaint Location', 'value'=>$v_single->CM_COMPLAINT_LOCATION]); echo form_error('CM_COMPLAINT_LOCATION');?>
            </td>            
          </tr> 
          <tr>
            <td><b>Contact Person</b></td>
            <td><?php echo form_input(['name'=>'CM_COMPLAINT_CONTACT_PERSON','class'=>'form-control','readonly'=>'true', 'id'=>'id_CM_COMPLAINT_CONTACT_PERSON','placeholder'=>'Complaint No', 'value'=>$v_single->CM_COMPLAINT_CONTACT_PERSON]); echo form_error('CM_COMPLAINT_CONTACT_PERSON');?>              
            </td>            
          </tr>
          <tr>
            <td><b>Mobile Number</b></td>
            <td><?php echo form_input(['name'=>'CM_COMPLAINT_CONTACT_MOBILE','class'=>'form-control','readonly'=>'true', 'id'=>'id_CM_COMPLAINT_CONTACT_MOBILE','placeholder'=>'Mobile Number', 'value'=>$v_single->CM_COMPLAINT_CONTACT_MOBILE]); echo form_error('CM_COMPLAINT_CONTACT_MOBILE');?>              
            </td>
          </tr>                                          
        </table>
      </div>
      <div class="col-lg-6">  
      <th colspan="8" align="center"><---------------- ASSIGN TO ----------------></th>      
        <table class="table table-bordered" style="text-align: left;">          
          <tr>
            <td><b>Employee Name</b></td>
            <td>
              <?php echo form_dropdown('frm_MJ_User', $UserList, set_value('frm_MJ_User'), "class='form-control'"); 
                if(form_error('frm_MJ_User') != '') echo '<p class="text-danger">Select Employee for Assign</p>';?>
              <!-- <select id='empname' class="form-control">
                  <option>-- Select Employee --</option>
                  <?php foreach($assign_to as $v_emp){ ?>
                  <option value="<?php echo $v_emp->MJ_CHD_USER_ID ?>"><?php echo $v_emp->NAME ?></option>
                  <?php } ?>
                </select> -->
            </td>            
          </tr>                               
        </table> 

      </div>
    <?php } ?>   
</div>
 <?php echo form_submit(['name'=>'from_Btn_Submit','value'=>'Submit','class'=>'btn btn-primary']); ?>
    </fieldset>
    </form>



     