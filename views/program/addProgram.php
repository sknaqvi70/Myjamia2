<?php require __DIR__.'/../auth/header.php'; ?>
<!-- bootstrap-daterangepicker -->
  <?= link_tag('/application/assets/vendors/bootstrap-daterangepicker/daterangepicker.css'); ?>
  <!-- Font Awesome -->
  <?= link_tag('/application/assets/vendors/font-awesome/css/font-awesome.min.css'); ?>
    <!-- bootstrap-datetimepicker -->
  <?= link_tag('/application/assets/vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css'); ?>
  <!-- Custom Theme Style -->
  <?= link_tag('/application/assets/css/postLogin/addProgram.css'); ?> <!-- 
  <?= link_tag('/application/assets/css/theme.css'); ?> -->
<br>
<div class="col-sm-8 text-left">       
<!--------- Start Complaint Registration --------->
  <div class="panel panel-info">
      <div class="panel-heading" style="text-align: center;"><h4>Registeration Form For Add Program</h4></div>     
      <div class="panel-body table-responsive"> 
      <!-- page content -->
      <div class="row">
          <div class="col-md-12 col-sm-12">
          <div class="x_panel">
            <div class="x_title">   
              <strong style="color: red;">Please fill up the information in the form given below:</strong>           
              <?php $message=$this->session->flashdata('message'); if (isset($message)) { ?>
                <?php  echo '<div class="alert  alert-success">';                  
                  echo '<strong>'.$message.'</strong>';
                  echo '</div>';
                ?>             
              <?php }?>              
            <div class="clearfix"></div>
            </div>
            <div class="x_content">
                  <?php echo form_open('/AddProgram/registerNewProgram'); ?>              
                    <span class="section">Program</span> 
                    <div class="field item form-group">
                      <label class="col-form-label col-md-3 col-sm-3  label-align">Program Name<span class="required" style="color: red; font-size: 18px;">*</span></label>
                      <div class="col-md-6 col-sm-6">                        
                        <?php echo form_dropdown('TP_Program_Type_Name', $ProgramTypeList, set_value('TP_Program_Type_Name'), "class='form-control'"); 
                          if(form_error('TP_Program_Type_Name') != '') echo '<p class="text-danger">Select Program Type</p>';?>
                      </div>
                    </div>
                    <span class="section">Program Details</span>
                    <div class="field item form-group">
                      <label class="col-form-label col-md-3 col-sm-3  label-align">Program Description<span class="required" style="color: red; font-size: 18px;">*</span></label>
                      <div class="col-md-6 col-sm-6">
                        <?php echo form_input(['name'=>'TP_Program_DESC','class'=>'form-control','placeholder'=>'Enter Program Description','id'=>'id_TP_Program_DESC','value'=>set_value('TP_Program_DESC')]); echo form_error('TP_Program_DESC');?> 
                      </div>
                    </div>
                    <div class="field item form-group">
                      <label class="col-form-label col-md-3 col-sm-3  label-align">Mode Of The Program<span class="required" style="color: red; font-size: 18px;">*</span></label>
                      <div class="col-md-6 col-sm-6">
                        <?php $ModeList=array('Select Program Mode','Online' => 'Online','Face-to-Face' => 'Face-to-Face');?>
                        <?php echo form_dropdown('TP_Program_Mode', $ModeList, set_value('TP_Program_Mode'), "class='form-control'"); 
                          if(form_error('TP_Program_Mode') != '') echo '<p class="text-danger">Select Mode of The Program</p>';?>
                      </div>
                    </div>
                    <div class="field item form-group">
                      <label class="col-form-label col-md-3 col-sm-3  label-align">Duration Of Program<span class="required" style="color: red; font-size: 18px;">*</span> </label>
                      <div class="col-md-6 col-sm-6">
                        <?php echo form_input(['name'=>'TP_Program_Duration','class'=>'form-control','placeholder'=>'Enter Program Duration','id'=>'id_TP_Program_Duration','value'=>set_value('TP_Program_Duration')]); echo form_error('TP_Program_Duration');?>   
                      </div>
                    </div>
                    <div class="field item form-group">
                      <label class="col-form-label col-md-3 col-sm-3  label-align">Program Start Date<span class="required" style="color: red; font-size: 18px;">*</span> </label>
                      <div class="col-md-6 col-sm-6">
                          <?php echo form_input(['name'=>'TP_Program_Start_Date','class'=>'form-control','placeholder'=>'Program Start Date','id'=>'id_TP_Program_Start_Date','value'=>set_value('TP_Program_Start_Date')]); echo form_error('TP_Program_Start_Date');?>
                      </div>                      
                    </div>
                    <div class="field item form-group">
                      <label class="col-form-label col-md-3 col-sm-3  label-align">Program Start Time<span class="required" style="color: red; font-size: 18px;">*</span> </label>
                      <div class="col-md-6 col-sm-6">
                          <?php echo form_input(['name'=>'TP_Program_Start_Time','class'=>'form-control','placeholder'=>'Program Start Time','id'=>'id_TP_Program_Start_Time','value'=>set_value('TP_Program_Start_Time')]); echo form_error('TP_Program_Start_Time');?>
                      </div>                      
                    </div>
                    <div class="field item form-group">
                      <label class="col-form-label col-md-3 col-sm-3  label-align">Program End Date<span class="required" style="color: red; font-size: 18px;">*</span> </label>
                      <div class="col-md-6 col-sm-6">
                        <?php echo form_input(['name'=>'TP_Program_End_Date','class'=>'form-control','placeholder'=>'Program End Date','id'=>'id_TP_Program_End_Date','value'=>set_value('TP_Program_End_Date')]); echo form_error('TP_Program_End_Date');?> 
                      </div>
                    </div>
                    <div class="field item form-group">
                      <label class="col-form-label col-md-3 col-sm-3  label-align">Program End Time<span class="required" style="color: red; font-size: 18px;">*</span> </label>
                      <div class="col-md-6 col-sm-6">
                          <?php echo form_input(['name'=>'TP_Program_End_Time','class'=>'form-control','placeholder'=>'Program Start Time','id'=>'id_TP_Program_End_Time','value'=>set_value('TP_Program_End_Time')]); echo form_error('TP_Program_End_Time');?>
                      </div>                      
                    </div>
                    <div class="field item form-group">
                      <label class="col-form-label col-md-3 col-sm-3  label-align">Course Fee<span class="required" style="color: red; font-size: 18px;">*</span> </label>
                      <div class="col-md-6 col-sm-6">
                        <?php echo form_input(['name'=>'TP_Program_Fee','class'=>'form-control','placeholder'=>'Enter Course Fee','id'=>'id_TP_Program_Fee','value'=>set_value('TP_Program_Fee')]); echo form_error('TP_Program_Fee');?> 
                      </div>
                    </div> 
                    <!-- Program end -->
                    <!-- Organizing Department info start -->                
                    <span class="section">Organizer Details</span>
                    <div class="field item form-group">
                      <label class="col-form-label col-md-3 col-sm-3  label-align">Organizing Department</label>
                      <div class="col-md-6 col-sm-6">
                            <?php echo form_dropdown('TP_Program_Organizing_Dept', $DepartmentList, set_value('TP_Program_Organizing_Dept'),'class="form-control" id="id_TP_Program_Organizing_Dept"'); 
                              if(form_error('TP_Program_Organizing_Dept') != '') echo '<p class="text-danger">Select Department</p>';?>
                      </div>
                    </div>
                    <div class="field item form-group">
                      <label class="col-form-label col-md-3 col-sm-3  label-align">Contact Person Name<span class="required" style="color: red; font-size: 18px;">*</span></label>
                      <div class="col-md-6 col-sm-9">
                        <?php echo form_input(['name'=>'TP_Program_Organizer_Name','class'=>'form-control', 'id'=>'id_TP_Program_Organizer_Name','placeholder'=>'Enter Organizer Name', 'value'=>set_value('TP_Program_Organizer_Name')]); echo form_error('TP_Program_Organizer_Name');?>                          
                      </div>
                    </div>                    
                    <div class="field item form-group">
                      <label class="col-form-label col-md-3 col-sm-3  label-align">Contact Person Email Id<span class="required" style="color: red; font-size: 18px;">*</span></label>
                      <div class="col-md-6 col-sm-6">
                        <?php echo form_input(['name'=>'TP_Program_Organizer_EmailId','class'=>'form-control','placeholder'=>'Enter Organizer Email Id','id'=>'id_TP_Program_Organizer_EmailId','value'=>set_value('TP_Program_Organizer_EmailId')]); echo form_error('TP_Program_Organizer_EmailId');?> 
                      </div>
                    </div>
                    <div class="field item form-group">
                      <label class="col-form-label col-md-3 col-sm-3  label-align">Contact Person Mobile No<span class="required" style="color: red; font-size: 18px;">*</span></label>
                      <div class="col-md-6 col-sm-6">
                        <?php echo form_input(['name'=>'TP_Program_Organizer_MobileNo','class'=>'form-control','placeholder'=>'Enter Organizer Mobile No.','id'=>'id_TP_Program_Organizer_MobileNo','value'=>set_value('TP_Program_Organizer_MobileNo')]); echo form_error('TP_Program_Organizer_MobileNo');?> 
                      </div>
                    </div>
                    <!-- Organizing Department info start -->
                    <div class="ln_solid">
                      <div class="form-group">
                        <div class="col-md-6 offset-md-3"><br>
                          <button type='submit' class="btn btn-primary">Submit</button>
                          <button type='reset' class="btn btn-success">Reset</button>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
          </div>
        </div>
      </div>

            
      </div> 
  </div> 
<!---------- end Complaint Registration ------------->  
</div>
<!-- jQuery -->
  <script src="<?php  echo base_url('application/assets/vendors/jquery/dist/jquery.min.js'); ?>"></script>  
  <!-- Bootstrap -->
  <script src="<?php  echo base_url('application/assets/vendors/bootstrap/dist/js/bootstrap.bundle.min.js'); ?>"></script>
  <!-- bootstrap-datetimepicker --> 
  <script src="<?php  echo base_url('application/assets/vendors/moment/min/moment.min.js'); ?>"></script> 
  <script src="<?php  echo base_url('application/assets/vendors/bootstrap-daterangepicker/daterangepicker.js'); ?>"></script>
  <script src="<?php  echo base_url('application/assets/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js'); ?>"></script>
  <!-- Custom Theme Scripts -->
  <script src="<?php  echo base_url('application/assets/js/postLogin/addProgram.js'); ?>"></script>

<?php require __DIR__.'/../auth/footer.php'; ?>
