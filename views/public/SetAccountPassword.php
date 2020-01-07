<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Welcome to MyJamia Portal</title>
	   <?php echo link_tag('/application/assets/css/bootstrap.min.css'); ?>
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
  <div class="col-sm-6">
  <?php echo form_open('/Welcome/set_account_password'); ?>
    <fieldset>
      <legend>Set Password</legend>
      <?php if ($message <> '') 
                echo '<div class="alert  alert-danger">';
              else {
                echo '<div class="alert alert-info">'  ;  
                $message = "Welcome to MyJamia Portal" ;            
              }
        echo '<strong>'.$message.'</strong>';
        echo '</div>';
      ?> 
      <div class="form-group"> 
        <?php echo form_input(['type'=>'password', 'name'=>'MJ_USER_PASSWORD','class'=>'form-control', 'id'=>'id_MJ_USER_PASSWORD','placeholder'=>'Your Password', 'value'=>set_value('MJ_USER_PASSWORD')]); 
         echo form_error('MJ_USER_PASSWORD');?>
         <?php echo form_input(['type'=>'hidden', 'name'=>'UID', 'value'=>$UID]); ?>
      </div>
      
      <div class="form-group"> 
          <?php echo form_input(['type'=>'password', 'name'=>'MJ_USER_PASSWORD_RETRY','class'=>'form-control', 'id'=>'id_MJ_USER_PASSWORD_RETRY','placeholder'=>'Type your password again', 'value'=>set_value('MJ_USER_PASSWORD_RETRY')]); 
         echo form_error('MJ_USER_PASSWORD_RETRY');?>
      </div>

      <?php echo form_submit(['name'=>'from_Btn_Submit','value'=>'Submit','class'=>'btn btn-primary']); ?>
      <?php echo form_submit(['type'=>'reset', 'name'=>'from_Btn_Clear','value'=>'Reset','class'=>'btn btn-secondary']); ?>
    </fieldset>
  </form>
  </div>
   <div class="col-sm-3"></div>
</div>

</div>


</body>
</head>