<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Welcome to MyJamia Portal</title>
	   <?php echo link_tag('/application/assets/css/bootstrap.min.css'); ?>
     
      <!-- Scripts for usingDatepicker Widget Begins Here -->

        <script type="text/javascript", 
              src="<?php echo base_url('application/assets/jquery/jquery-ui/external/jquery/jquery.js'); ?>">
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
  <div class="col-sm-12">
   <!-- m6 l6"> -->
           <img src="http://10.2.1.57:8080/SSPUSER/Assets/img/logo1.jpg" class="responsive-img center-block" style="padding-top: 5px !important;">
           <img src="http://10.2.1.57:8080/SSPUSER/Assets/img/logo2.jpg" class="responsive-img center-block" style="padding-top: 5px !important; align-items: center;">
           
</div>
 
</div>

<!-- Show Menu Bar -->

<div class="row">
  <div class="col-sm-12">
      <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a class="navbar-brand" href="<?php echo base_url(); ?>">MyJamia</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="  navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
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
      </nav>
  </div>
</div>
<br><br>

<!-- Show User Registration Form -->
<div class="row">
  <div class="col-sm-3"></div>
    <div class="col-sm-6" style="border: thin solid lightgrey; border-radius: 10px;">
      <?php echo form_open('/Welcome/register_user'); ?>
        <fieldset>
          <br/>
          <legend>User Registration Form</legend>

            <?php if ($message <> '' && strpos($message,'@') == true) 
                    echo '<div class="alert  alert-success">';
                  elseif ($message <> '' && strpos($message,'@') == false) 
                    echo '<div class="alert alert-danger">';
                  else {
                    echo '<div class="alert alert-info">' ;
                    $message = "Please fill up the information in the form given below:" ;            
                  }
            echo '<strong>'.$message.'</strong>';
            echo '</div>';
            ?> 

            <div class="form-group"> 
              <?php echo form_dropdown('frm_MJ_User_Type', $UserTypeList, set_value('frm_MJ_User_Type'), "class='form-control'"); 
                if(form_error('frm_MJ_User_Type') != '') echo '<p class="text-danger">Select Type of Account</p>';?>
            </div>
        
            <div class="form-group"> 
              <?php echo form_input(['name'=>'MJ_UR_ID_NO','class'=>'form-control', 'id'=>'id_MJ_UR_ID_NO','placeholder'=>'Your ID (Student ID/Employee ID', 'value'=>set_value('MJ_UR_ID_NO')]); 
               echo form_error('MJ_UR_ID_NO');?>
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
        <br/>
      </form>
    </div>
    <div class="col-sm-3"></div>
  </div>
</div>


<script type="text/javascript"> 
     $("#frm_id_MJ_User_DOB").datepicker({dateFormat: 'dd/mm/yy'}); 
</script>

</body>
</head>