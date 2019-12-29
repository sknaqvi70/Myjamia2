<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Welcome to MyJamia Portal</title>
	<?= link_tag('/application/assets/css/bootstrap.min.css'); ?>
</head>
<body>

<div class="container">

<div class="row">
  <div class="col s4"> <!-- m6 l6"> -->
           <img src="http://10.2.1.57:8080/SSPUSER/Assets/img/logo1.jpg" class="responsive-img" style="padding-top: 5px !important;">
           <img src="http://10.2.1.57:8080/SSPUSER/Assets/img/logo2.jpg" class="responsive-img" style="padding-top: 5px !important; align-items: center;">
  </div>
</div>

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

  <!--  Login Form Section Begins Here ------>
</div>
<br><br>

<div class="row">
  <?php echo form_open('/Welcome/user_login'); ?>
    <fieldset>
      <legend>Login Form</legend>

      <div class="form-group"> 
        <?php echo form_input(['name'=>'frm_MJ_User_Login','class'=>'form-control', 'id'=>'frm_id_MJ_User_Login','placeholder'=>'Enter your Id', 'value'=>set_value('frm_MJ_User_Login')]);?> 
        <?php echo form_error('frm_MJ_User_Login');?>
      </div>

      <div class="form-group">
         <?php echo form_input(['type'=>'password','name'=>'frm_MJ_User_Password','class'=>'form-control', 'id'=>'frm_id_MJ_User_Password','placeholder'=>'Enter your Password']);?>
         <?php echo form_error('frm_MJ_User_Password');?>

      </div>
      <?php echo form_submit(['name'=>'frm_Btn_Submit','value'=>'Submit','class'=>'btn btn-primary']); ?>
      <?php echo form_submit(['name'=>'frm_Btn_Register_User','value'=>'New User Register','class'=>'btn btn-secondary']); ?>
    </fieldset>
  </form>

    <!-- Login Form Section Ends Here ---------->
  </div>

</div>

</body>
</head>