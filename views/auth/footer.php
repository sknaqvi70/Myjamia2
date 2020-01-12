    <div class="col-sm-2 sidenav">
      <div class="well">
        <p>ADS</p>
      </div>
      <div class="well">
        <p>ADS</p>
      </div>
    </div>
  </div>
</div>

<footer class="container-fluid text-center">
  <p class="footer-para">MyJamia Self Service Portal<br/>Designed & Developed by FTK-Centre for Information Technology, JMI 
  Copyright@2020</p>
</footer>

<!-- ------------ MODAL FORM --------------- -->

<!-- Modal -->
  <div class="modal fade" id="changePasswordModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Change Password</h4>
        </div>
        <div class="modal-body">
          <?php echo form_open('/auth/change_password', 'id="changePasswordForm"'); ?>
            <fieldset>
              <span id="success_message">&nbsp;</span>
            <div class="form-group"> 
              <?php echo form_input(['type'=>'password','name'=>'frm_MJ_User_Password','id'=>'frm_MJ_User_Password','class'=>'form-control','placeholder'=>'Current Password']);?>
              <span id="frm_MJ_User_Password_Error" class="text-danger"></span>
            </div>

            <div class="form-group">
               <?php echo form_input(['type'=>'password','name'=>'frm_New_Password_1','id'=>'frm_New_Password_1','class'=>'form-control', 'placeholder'=>'Enter new password']);?>
               <span id="frm_New_Password_1_Error" class="text-danger"></span>
            </div>

             <div class="form-group">
               <?php echo form_input(['type'=>'password','name'=>'frm_New_Password_2','id'=>'frm_New_Password_2','class'=>'form-control', 'placeholder'=>'Retype new password']); ?>
                <span id="frm_New_Password_2_Error" class="text-danger"></span>
            </div>

            <?php echo form_submit(['name'=>'frm_Btn_Submit', 'id'=>'id_frm_Btn_Submit', 'value'=>'Change Password','class'=>'btn btn-primary']); ?>
          </fieldset>
          <br/>
      </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" id="modal-btn">Close</button>
        </div>
      </div>
      
    </div>
  </div>

</body>
</html>

<script>
  $(document).ready(function()  {
    $('#changePasswordForm').on('submit',function(event){ 
      event.preventDefault();

      $.ajax({
        url:      "<?= base_url('auth/change_password');?>",
        method:   "POST",
        data:     $(this).serialize(),
        dataType: "json",
        beforeSend: function(){
            $('#id_frm_Btn_Submit').attr('disabled','disabled');
        },
        success: function(data) {
         
        $('#success_message').html(data.message);
         if (data.error) {
            if (data.frm_MJ_User_Password_Error != ''){
              $('#frm_MJ_User_Password_Error').html(data.frm_MJ_User_Password_Error);
            } 
            else {
              $('#frm_MJ_User_Password_Error').html('');
            } 

            if (data.frm_New_Password_1_Error != ''){
              $('#frm_New_Password_1_Error').html(data.frm_New_Password_1_Error);
            } 
            else {
              $('#frm_New_Password_1_Error').html('');
            }

            if (data.frm_New_Password_2_Error != ''){
              $('#frm_New_Password_2_Error').html(data.frm_New_Password_2_Error);
            } 
            else {
              $('#frm_New_Password_2_Error').html('');
            }
          }


          if(data.success) {
            $('#frm_MJ_User_Password_Error').html('');
            $('#frm_New_Password_1_Error').html('');
            $('#frm_New_Password_2_Error').html('');
            $('#success_message').html(data.message);
            $('#changePasswordForm')[0].reset();

          } 
          $('#id_frm_Btn_Submit').attr('disabled',false);
        }

      });
    });


  $('#modal-btn').click(function(){
      $('#frm_MJ_User_Password_Error').html('');
      $('#frm_New_Password_1_Error').html('');
      $('#frm_New_Password_2_Error').html('');
      $('#success_message').html('');
      $('#changePasswordForm')[0].reset();

  });

  });
</script>
