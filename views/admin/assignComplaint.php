<?php echo form_open('/Admin/complaintAssignTo', 'id="assignComplaintsForm"' ); ?>
<fieldset>
<span style="color:#FF0000; font-weight:bold; font-size: 20px;" id="success_message">&nbsp;</span>
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
            <td><?php echo form_input(['name'=>'CM_NO','class'=>'form-control','readonly'=>'true', 'id'=>'id_CM_NO','placeholder'=>'Complaint No', 'value'=>$v_single->CM_NO]); ?>
            </td>
          </tr>          
          <tr>
            <td><b>Complaint Description</b></td>
            <td><?php echo form_textarea(['name'=>'CM_COMPLAINT_TEXT','class'=>'form-control','readonly'=>'true', 'id'=>'id_CM_COMPLAINT_TEXT','placeholder'=>'Complaint Description', 'value'=>$v_single->CM_COMPLAINT_TEXT]); ?>
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
      <th colspan="8" align="center"><---------------- ASSIGN TO ----------------></th>      
        <table class="table table-bordered" style="text-align: left;">          
          <tr>
            <td><b>Employee Name</b></td>
            <td>
              <?php echo form_dropdown('frm_MJ_User', $UserList, set_value('frm_MJ_User'), "class='form-control'"); ?> 
                <span id="frm_MJ_User_Error" class="text-danger"></span>             
            </td>            
          </tr>  
          <tr>
            <td><b>Priority</b></td>
            <td>
              <select name="frm_Complaint_Priority" class="form-control">
                  <option value="">Select Priority</option>
                  <option value="T">Top</option>
                  <option value="M">Medium</option>
                  <option value="L">Low</option>
              </select>
              <span id="frm_Complaint_priority_Error" class="text-danger"></span>             
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
    $('#assignComplaintsForm').on('submit',function(event){ 
      event.preventDefault();
      $.ajax({
        url:      "<?php echo base_url() ?>Admin/complaintAssignTo",
        method:   "POST",
        data:     $(this).serialize(),
        dataType: "json",
        /*beforeSend: function(){
            $('#id_frm_Btn_Submit').attr('disabled','disabled');
        },*/
        success: function(data) {         
        $('#success_message').html(data.message);
         if (data.error) {            
            if (data.frm_MJ_User_Error != ''){
              $('#frm_MJ_User_Error').html(data.frm_MJ_User_Error);
            } 
            else {
              $('#frm_MJ_User_Error').html('gfhfh');
            }
            if (data.frm_Complaint_priority_Error != ''){
              $('#frm_Complaint_priority_Error').html(data.frm_Complaint_priority_Error);
            } 
            else {
              $('#frm_Complaint_priority_Error').html('');
            }
          }

          if(data.success) {
            $('#frm_MJ_User_Error').html('');
            $('frm_Complaint_priority_Error').html('');
            $('#success_message').html(data.message);
            $('#assignComplaintsForm')[0].reset();

          } 
          $('#id_frm_Btn_Submit').attr('disabled',false);
        }
      });
    });
  });
</script>
<script type="text/javascript">
       
    </script>



     