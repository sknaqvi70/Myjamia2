<?php require __DIR__.'/../auth/header.php'; ?>
<br>
    <div class="col-sm-8 text-left">       
      <!--------- Start Complaint Registration --------->
      <div class="panel panel-info">
        <div class="panel-heading" style="text-align: center;"><h4>Complaint Registration</h4></div>       
          <div class="panel-body table-responsive"> 
          <?php echo form_open('/Complaint/complaintRegistration'); ?> 
        
            <table class="table table-hover"style="font-size:14px; font-family:Calibri;">    
              <tbody>
                  <tr>
                    <td valign="top" height="20" align="left"><strong>&nbsp;&nbsp;Contact Person : </strong></td>
                    <td valign="top" align="left" width="">
                      <?php echo form_input(['name'=>'CM_USER_NANE','class'=>'form-control', 'id'=>'id_CM_USER_NANE','placeholder'=>'Contact Person Name', 'value'=>$_SESSION['username']]); echo form_error('CM_USER_NANE');?>
                    </td>

                    <td valign="top" align="left"><strong>&nbsp;E-Mail Id: </strong></td>
                    <td valign="top" align="left">
                      <?php echo form_input(['name'=>'CM_USER_EMAIL','class'=>'form-control', 'id'=>'id_CM_USER_EMAIL','placeholder'=>'E-Mail Id', 'value'=>$_SESSION['useremail']]); echo form_error('CM_USER_EMAIL');?>
                    </td>
                  </tr>
                 
                  <tr>
                    <td valign="top" height="20" align="left"><strong>&nbsp;&nbsp;Contact No/Mobile : </strong></td>
                    <td valign="top" align="left">
                      <?php echo form_input(['name'=>'CM_USER_MOBILE','class'=>'form-control', 'id'=>'id_CM_USER_MOBILE','placeholder'=>'Mobile Number', 'value'=>set_value('CM_USER_MOBILE')]); echo form_error('CM_USER_MOBILE');?>
                    </td>
                    <!-- ------------------- -->
                    <td valign="top" align="left"><strong>&nbsp;Complaint Location : </strong></td>
                    <td valign="top" align="left">
                      <?php echo form_input(['name'=>'CM_USER_LOCATION','class'=>'form-control', 'id'=>'id_CM_USER_LOCATION','placeholder'=>'Complaint Location', 'value'=>set_value('CM_USER_LOCATION')]); echo form_error('CM_USER_LOCATION');?>
                    </td>
                  </tr>

                  <tr>
                    <td valign="top" height="20" align="left" ><strong>&nbsp;&nbsp;Complaint Type : </strong></td>
                    <td valign="top" align="left" colspan="3">
                      <?php echo form_dropdown('CM_COMPLAINT_TYPE', $ComplaintTypeList, set_value('CM_COMPLAINT_TYPE'),'class="form-control" id="id_CM_COMPLAINT_TYPE"'); 
                        if(form_error('CM_COMPLAINT_TYPE') != '') echo '<p class="text-danger">Select Type of Account</p>';?>
                    </td>
                  </tr>

                  <tr>
                    <td valign="top" height="20" align="left" ><strong>&nbsp;&nbsp;Complaint Sub Type : </strong></td>
                    <td valign="top" align="left" colspan="3">
                      <select id='id_CM_COMPLAINT_SUB_TYPE' name="CM_COMPLAINT_SUB_TYPE" class="form-control">
                        <option>Select Complaint sub Type</option>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td valign="top" height="20" align="left" ><strong>&nbsp;&nbsp;Complaint Description : </strong></td>
                    <td valign="top" align="left" colspan="3">
                      <?php echo form_textarea(['name'=>'CM_COMPLAINT_DESC','class'=>'form-control', 'id'=>'id_CM_COMPLAINT_DESC','rows'=>'4','cols'=>'100','placeholder'=>'Brief Description of Complaint', 'value'=>set_value('CM_COMPLAINT_DESC')]); echo form_error('CM_COMPLAINT_DESC');?>
                      
                    </td>
                  </tr>

                  
                </tbody>
            </table>  
            <?php echo form_submit(['name'=>'from_Btn_Submit','value'=>'Submit','class'=>'btn btn-primary']); ?>
                                
            <!---------- TABLE END ------------->
          </div> 
          <!---------- Start Ajax for fetch value ------------->
          <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
          <script type='text/javascript'>
          $(document).ready(function(){ 
          // Complaint type change
          $('#id_CM_COMPLAINT_TYPE').change(function(){
            var v_MJ_COMPLAINT_TYPE = $(this).val();
            $.ajax({
                    url:'<?=base_url()?>Complaint/getComplaintSubCategory',
                    method: 'post',
                    data: {v_MJ_COMPLAINT_TYPE: v_MJ_COMPLAINT_TYPE},
                    dataType: 'json',
                    success: function(response){
                    // Remove options           
                    $('#id_CM_COMPLAINT_SUB_TYPE').find('option').not(':first').remove();
                    // Add options
                    $.each(response,function(index,data){
                    $('#id_CM_COMPLAINT_SUB_TYPE').append('<option value="'+data['CSC_NO']+'">'+data['CSC_NAME']+'</option>');
                    });
                    }
                  });
          });       
          
        });
        </script>   
         <!---------- End Ajax------------->
          
      </div> 
      <!---------- end Complaint Registration ------------->  
    </div>
    <?php require __DIR__.'/../auth/footer.php'; ?>