<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Welcome to MyJamia Portal</title>
	   <?php echo link_tag('/application/assets/css/bootstrap.min.css'); ?>
     
      <!-- Scripts for usingDatepicker Widget Begins Here -->

        <script type="text/javascript", 
              src="<?php $this->load->helper('url'); echo base_url('application/assets/jquery/jquery-ui/external/jquery/jquery.js'); ?>">
        </script>

        <script type="text/javascript", 
              src="<?php  echo base_url('application/assets/jquery/jquery-ui/jquery-ui.min.js'); ?>">
        </script>

        <?php echo link_tag('application/assets/jquery/jquery-ui/jquery-ui.min.css'); ?>
     
     <!-- Scripts for usingDatepicker Widget Ends Here-->
  
</head>
<body>

<div class="container">

<!-- Show Page Banner -->
<div class="row">
   <!-- m6 l6"> -->
           <img src="http://10.2.1.57:8080/SSPUSER/Assets/img/logo1.jpg" class="responsive-img" style="padding-top: 5px !important;">
           <img src="http://10.2.1.57:8080/SSPUSER/Assets/img/logo2.jpg" class="responsive-img" style="padding-top: 5px !important; align-items: center;">
 
</div>

<!-- Show Menu Bar -->

<div class="row">
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <a class="navbar-brand" href="#">MyJamia</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarColor01">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">About</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">JMI Portals</a>
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="text" placeholder="Search">
      <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
    </form>
</div>
</div>
<br><br>

<!-- Show User Registration Form -->
<div class="row">
  <?php echo form_open('/Welcome/register_user'); ?>
    <fieldset>
      <legend>User Registration Form</legend>

      <div class="form-group"> 
        <?php echo form_dropdown('frm_MJ_User_Type', $UserTypeList, set_value('frm_MJ_User_Type'), "class='form-control'"); 
          if(form_error('frm_MJ_User_Type') != '') echo '<p class="text-danger">Select Type of Account</p>';?>
      </div>
  
      <div class="form-group"> 
        <?php echo form_input(['name'=>'frm_MJ_User_Login','class'=>'form-control', 'id'=>'frm_id_MJ_User_Login','placeholder'=>'Your ID (Student ID/Employee ID', 'value'=>set_value('frm_MJ_User_Login')]); 
         echo form_error('frm_MJ_User_Login');?>
      </div>
  
      <div class="form-group"> 
        <?php echo form_input(['name'=>'frm_MJ_User_Name','class'=>'form-control', 'id'=>'frm_id_MJ_User_Name','placeholder'=>'Your Name as printed on your ID Card', 'value'=>set_value('frm_MJ_User_Name')]);
         echo form_error('frm_MJ_User_Name'); ?>
      </div>

      <div class="form-group"> 
        <?php echo form_input(['name'=>'frm_MJ_User_DOB','class'=>'form-control', 'id'=>'frm_id_MJ_User_DOB','placeholder'=>'Your Date of Birth', 'value'=>set_value('frm_MJ_User_DOB') ]);
         echo form_error('frm_MJ_User_DOB');
        ?> 
      </div>

      <?php echo form_submit(['name'=>'from_Btn_Submit','value'=>'Submit','class'=>'btn btn-primary']); ?>
      <?php echo form_submit(['type'=>'reset', 'name'=>'from_Btn_Clear','value'=>'Reset','class'=>'btn btn-secondary']); ?>
    </fieldset>
  </form>
  </div>

</div>


<script type="text/javascript"> 
     $("#frm_id_MJ_User_DOB").datepicker({dateFormat: 'dd/mm/yy'}); 
</script>

</body>
</head>