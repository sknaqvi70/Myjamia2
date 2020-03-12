<?php echo form_open('/Admin/complaintRevertStatus', 'id="revertComplaintsForm"' ); ?>
<fieldset>
<span style="color:#FF0000; font-weight:bold; font-size: 20px;" id="success_message">&nbsp;</span>
<div class="row">
    <?php foreach($single_comp as $v_single){ ?>
      <div class="col-lg-6 table-responsive">       
        <th colspan="8" align="center"><---------------- COMPLAINT DETAILS ----------------></th>
        <table class="table table-bordered" style="text-align: left;">          
          <tr>
            <td><b>Complaint No</b></td>
            <td><?php echo form_input(['name'=>'CM_NO','class'=>'form-control','readonly'=>'true', 'id'=>'id_CM_NO','placeholder'=>'Complaint No', 'value'=>$v_single->CM_NO]); ?>
            </td>
          </tr>          
          <tr>
            <td><b>Complaint Description</b></td>
            <td><?php echo form_input(['name'=>'CM_COMPLAINT_TEXT','class'=>'form-control','readonly'=>'true', 'id'=>'id_CM_COMPLAINT_TEXT','placeholder'=>'Complaint Description', 'value'=>$v_single->CM_COMPLAINT_TEXT]); ?>
            </td>            
          </tr>
          <tr>
            <td><b>Department</b></td>
            <td><?php echo form_input(['name'=>'DEP_DESC','class'=>'form-control','readonly'=>'true', 'id'=>'id_DEP_DESC','placeholder'=>'Department', 'value'=>$v_single->DEP_DESC]); ?>
            </td>            
          </tr>            
          <tr>
            <td><b>Complaint Location</b></td>
            <td><?php echo form_input(['name'=>'CM_COMPLAINT_LOCATION','class'=>'form-control','readonly'=>'true', 'id'=>'id_CM_COMPLAINT_LOCATION','placeholder'=>'Complaint Location', 'value'=>$v_single->CM_COMPLAINT_LOCATION]); ?>
            </td>            
          </tr> 
          <tr>
            <td><b>Contact Person</b></td>
            <td><?php echo form_input(['name'=>'CM_COMPLAINT_CONTACT_PERSON','class'=>'form-control','readonly'=>'true', 'id'=>'id_CM_COMPLAINT_CONTACT_PERSON','placeholder'=>'Complaint No', 'value'=>$v_single->CM_COMPLAINT_CONTACT_PERSON]); ?>              
            </td>            
          </tr>
          <tr>
            <td><b>Mobile Number</b></td>
            <td><?php echo form_input(['name'=>'CM_COMPLAINT_CONTACT_MOBILE','class'=>'form-control','readonly'=>'true', 'id'=>'id_CM_COMPLAINT_CONTACT_MOBILE','placeholder'=>'Mobile Number', 'value'=>$v_single->CM_COMPLAINT_CONTACT_MOBILE]); ?>              
            </td>
          </tr>                                          
        </table>
      </div>
      <div class="col-lg-6">  
      <th colspan="8" align="center"><---------------- ACCTION BY ADMIN ----------------></th>      
        <table class="table table-bordered" style="text-align: left;">          
          <tr>
            <td><b>Pending With</b></td>
            <td><?php echo form_dropdown('frm_Revert_User', $AssignList, set_value('frm_Revert_User'), "class='form-control'"); ?> 
                <span id="frm_Revert_User_Error" class="text-danger"></span>                       
            </td>
          </tr>
          <tr>
            <td><b>Complaint Status</b></td>
            <td>
              <select name="frm_Complaint_Revert" class="form-control">
                  <option value="">Select Complaint Status</option>
                  <option value="R">Revert Back</option>
              </select>
              <span id="frm_Complaint_Revert_Error" class="text-danger"></span>             
            </td>                       
          </tr>
          <tr>
            <td><b>Reason for Revert Back</b></td>
            <td><?php echo form_textarea(['name'=>'CM_COMPLAINT_REMARKS','class'=>'form-control', 'id'=>'id_CM_COMPLAINT_REMARKS','placeholder'=>'Please Write reason for Update complaint Status in this box']); ?> <span id="CM_COMPLAINT_REMARKS_Error" class="text-danger"></span>             
            </td>
          </tr>                              
        </table> 

      </div>
    <?php } ?>   
</div>
 <?php echo form_submit(['name'=>'from_Btn_Submit','id'=>'id_frm_Btn_Submit','value'=>'Submit','class'=>'btn btn-primary']); ?>
</fieldset>
</form>

<script>
  $(document).ready(function()  {
    $('#revertComplaintsForm').on('submit',function(event){ 
      event.preventDefault();
      $.ajax({
        url:      "<?php echo base_url() ?>Admin/complaintRevertStatus",
        method:   "POST",
        data:     $(this).serialize(),
        dataType: "json",
        beforeSend: function(){
            $('#id_frm_Btn_Submit').attr('disabled','disabled');
        },
        success: function(data) {         
        $('#success_message').html(data.message);
         if (data.error) { 
            if (data.frm_Revert_User_Error != ''){
              $('#frm_Revert_User_Error').html(data.frm_Revert_User_Error);
            } 
            else {
              $('#frm_Revert_User_Error').html('');
            }           
            if (data.frm_Complaint_Revert_Error != ''){
              $('#frm_Complaint_Revert_Error').html(data.frm_Complaint_Revert_Error);
            } 
            else {
              $('#frm_Complaint_Revert_Error').html('');
            }
            if (data.CM_COMPLAINT_REMARKS_Error != ''){
              $('#CM_COMPLAINT_REMARKS_Error').html(data.CM_COMPLAINT_REMARKS_Error);
            } 
            else {
              $('#CM_COMPLAINT_REMARKS_Error').html('');
            }
          }

          if(data.success) {
            $('#frm_Revert_User_Error').html('');
            $('#frm_Complaint_Revert_Error').html('');
            $('CM_COMPLAINT_REMARKS_Error').html('');
            $('#success_message').html(data.message);
            $('#revertComplaintsForm')[0].reset();

          } 
          $('#id_frm_Btn_Submit').attr('disabled',false);
        }
      });
    });
  });
</script>
<script type="text/javascript">
       
    </script>



     