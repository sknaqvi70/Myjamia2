<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <link rel="shortcut icon" href="<?= base_url(); ?>application/assets/images/jamia.ico" type="image/ico"/>
  <title>Welcome to MyJamia Portal</title>
     <?php echo link_tag('/application/assets/css/bootstrap.min.css'); ?>
</head>
<body>

<div class="container">

<!-- Show Page Banner -->

  <div class="row text-center">
    <div class="col-sm-6 text-center"><img src="<?= base_url(); ?>application/assets/images/logo1.jpg"></div>
    <div class="col-sm-6 text-left"><img src="<?= base_url(); ?>application/assets/images/logo2.jpg"></div>
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
  <div class="col-sm-1"></div> 
  <div class="col-sm-10 text-left">       
      <!--------- Start Complaint Registration --------->
      <div class="panel panel-info">
        <div class="panel-heading" style="text-align: center;"><legend>Ticket Feedback Form</legend></div><br>
          <div class="panel-body table-responsive">
          <!-- this table is used for fee details display -->
          <table class="table table-striped table-bordered table-hover " width="550" align="center" style="font-size:14px; font-family:Calibri; border-radius: 10px;border: 1px solid;">
            <thead>    
              <tr>
                <th>Ticket No</th>
                <th>Registeration Date</th>
                <th>Assigned Date</th>
                <th>Resource Name</th>
                <th>Closue Date</th>
              </tr>
            </thead>
            <tbody>
           
              <tr>
                <td>547</td>
                <td>3-3-2020 5:14:50 PM</td>
                <td>13-03-2020 11:27:56 AM</td>
                <td>Virender Pal Singh</td>
                <td>13-03-2020 11:27:56 AM</td>
              </tr>                        
            </tbody>  
          </table>
          <table class="table table-striped table-bordered table-hover " width="550" align="center" style="font-size:14px; font-family:Calibri; border-radius: 10px;border: 1px solid;">
            <tbody>
            <tr>
              <td>1.&nbsp;&nbsp;&nbsp;&nbsp; Solution Provided to the rported Problem :</td>
                <td>
                  <?php echo form_radio('Q1_feedback', 5, set_checkbox('Q1_feedback', 5)); ?> Excellent&nbsp;&nbsp;&nbsp;&nbsp;               
                  <?php echo form_radio('Q1_feedback', 4, set_checkbox('Q1_feedback', 4)); ?> Very Good&nbsp;&nbsp;&nbsp;&nbsp;
                  <?php echo form_radio('Q1_feedback', 3, set_checkbox('Q1_feedback', 3)); ?> Good&nbsp;&nbsp;&nbsp;&nbsp;              
                  <?php echo form_radio('Q1_feedback', 2, set_checkbox('Q1_feedback', 2)); ?> Average&nbsp;&nbsp;&nbsp;&nbsp;
                  <?php echo form_radio('Q1_feedback', 1, set_checkbox('Q1_feedback', 1)); ?> Poor               
              </td>          
            </tr>
            <tr>
              <td>2.&nbsp;&nbsp;&nbsp;&nbsp; Assessment of time management demostration by the Resource person :</td>
                <td>
                  <?php echo form_radio('Q2_feedback', 5, set_checkbox('Q2_feedback', 5)); ?> Excellent&nbsp;&nbsp;&nbsp;&nbsp;               
                  <?php echo form_radio('Q2_feedback', 4, set_checkbox('Q2_feedback', 4)); ?> Very Good&nbsp;&nbsp;&nbsp;&nbsp;
                  <?php echo form_radio('Q2_feedback', 3, set_checkbox('Q2_feedback', 3)); ?> Good&nbsp;&nbsp;&nbsp;&nbsp;              
                  <?php echo form_radio('Q2_feedback', 2, set_checkbox('Q2_feedback', 2)); ?> Average&nbsp;&nbsp;&nbsp;&nbsp;
                  <?php echo form_radio('Q2_feedback', 1, set_checkbox('Q2_feedback', 1)); ?> Poor               
              </td>           
            </tr>
            <tr>
              <td>3.&nbsp;&nbsp;&nbsp;&nbsp; Technical Understatnding & skills of the resource person  :</td>
                <td>
                  <?php echo form_radio('Q3_feedback', 5, set_checkbox('Q3_feedback', 5)); ?> Excellent&nbsp;&nbsp;&nbsp;&nbsp;               
                  <?php echo form_radio('Q3_feedback', 4, set_checkbox('Q3_feedback', 4)); ?> Very Good&nbsp;&nbsp;&nbsp;&nbsp;
                  <?php echo form_radio('Q3_feedback', 3, set_checkbox('Q3_feedback', 3)); ?> Good&nbsp;&nbsp;&nbsp;&nbsp;              
                  <?php echo form_radio('Q3_feedback', 2, set_checkbox('Q3_feedback', 2)); ?> Average&nbsp;&nbsp;&nbsp;&nbsp;
                  <?php echo form_radio('Q3_feedback', 1, set_checkbox('Q3_feedback', 1)); ?> Poor               
              </td>          
            </tr>
            <tr>
              <td>4.&nbsp;&nbsp;&nbsp;&nbsp; Behaviour of the Resource Person :</td>
                <td>
                  <?php echo form_radio('Q4_feedback', 5, set_checkbox('Q4_feedback', 5)); ?> Excellent&nbsp;&nbsp;&nbsp;&nbsp;               
                  <?php echo form_radio('Q4_feedback', 4, set_checkbox('Q4_feedback', 4)); ?> Very Good&nbsp;&nbsp;&nbsp;&nbsp;
                  <?php echo form_radio('Q4_feedback', 3, set_checkbox('Q4_feedback', 3)); ?> Good&nbsp;&nbsp;&nbsp;&nbsp;              
                  <?php echo form_radio('Q4_feedback', 2, set_checkbox('Q4_feedback', 2)); ?> Average&nbsp;&nbsp;&nbsp;&nbsp;
                  <?php echo form_radio('Q4_feedback', 1, set_checkbox('Q4_feedback', 1)); ?> Poor               
              </td>          
            </tr>
            <tr>
              <td>5.&nbsp;&nbsp;&nbsp;&nbsp; Assessment for assigning him similer job for future :</td>
                <td>
                  <?php echo form_radio('Q5_feedback', 5, set_checkbox('Q5_feedback', 5)); ?> Excellent&nbsp;&nbsp;&nbsp;&nbsp;               
                  <?php echo form_radio('Q5_feedback', 4, set_checkbox('Q5_feedback', 4)); ?> Very Good&nbsp;&nbsp;&nbsp;&nbsp;
                  <?php echo form_radio('Q5_feedback', 3, set_checkbox('Q5_feedback', 3)); ?> Good&nbsp;&nbsp;&nbsp;&nbsp;              
                  <?php echo form_radio('Q5_feedback', 2, set_checkbox('Q5_feedback', 2)); ?> Average&nbsp;&nbsp;&nbsp;&nbsp;
                  <?php echo form_radio('Q5_feedback', 1, set_checkbox('Q5_feedback', 1)); ?> Poor               
              </td>           
            </tr>
            <tr>
            <td><b>6.&nbsp;&nbsp;&nbsp;&nbsp;Any other Suggestion</b></td>
              <td><?php echo form_textarea(['name'=>'FEEDBACK_SUGGESTION','class'=>'form-control', 'id'=>'id_FEEDBACK_SUGGESTION','rows'=>'5', 'placeholder'=>'Please Write any feedback suggestion in this box']); ?> <span id="FEEDBACK_SUGGESTION_Error" class="text-danger"></span> 
              </td>
            </tr>
            </tbody>

          </table>
            <?php echo form_submit(['name'=>'from_Btn_Submit','id'=>'id_frm_Btn_Submit','value'=>'Submit','class'=>'btn btn-primary']); ?>
         </div>
      </div> 
    </div>
</div>
  <div class="col-sm-1"></div>
</div>
</body>
</head>