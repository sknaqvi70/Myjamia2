<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <link rel="shortcut icon" href="<?= base_url(); ?>application/assets/images/jamia.ico" type="image/ico"/>
  <title>Welcome to MyJamia Portal</title>
     <?php echo link_tag('/application/assets/css/bootstrap.min.css'); ?>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
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
      <div class="panel-heading" style="text-align: center;">
      <?php if ($message <> '' && $messageType <> 'I') 
                echo '<div class="alert  alert-danger">';
              else {
                echo '<div class="alert alert-info">'  ;  
                $message = "Welcome to MyJamia Portal" ;            
              }
                          
            echo '<strong>'.$message.'</strong>';
            echo '</div>';
      ?> 
      <?php if (isset($expired)) {
      echo '<strong>'.$expired.'</strong>';
       } ?>
      <?php if (isset($feedbackdone)) {
      echo '<strong>'.$feedbackdone.'</strong>';
       } ?> 
      <?php if (isset($VerificationResult)) { ?>
      <legend>Ticket Feedback Form</legend>
      </div><br>
      <?php echo form_open('/Feedback/setComplaintFeedback', 'id="form1"'); ?>
      <fieldset>  
      <div class="panel-body table-responsive">
        <!-- this table is used for fee details display -->
          <table class="table table-striped table-bordered table-hover " width="550" align="center" style="font-size:14px; font-family:Calibri; border-radius: 10px;border: 1px solid;">
            <thead>    
              <tr>
                <th>Ticket No</th>
                <th>Registeration Date</th>
                <th>Assigned Date</th>
                <th>Resource Name</th>
                <th>Closure Date</th>
              </tr>
            </thead>
            <tbody>
           
              <tr>
                <td><?php echo $cmno ?></td>
                <td><?php echo $RegistrationDate ?></td>
                <td><?php echo $AssignedDate ?></td>
                <td><?php echo $Rntext ?></td>
                <td><?php echo $ClousreDate ?></td>
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
                <span class="error">* <?php echo form_error('Q1_feedback'); ?></span>
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
                <span class="error">* <?php echo form_error('Q2_feedback'); ?></span>
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
              <span class="error">* <?php echo form_error('Q3_feedback'); ?></span>
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
              <span class="error">* <?php echo form_error('Q4_feedback'); ?></span>
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
              <span class="error">* <?php echo form_error('Q5_feedback'); ?></span>
            </td>           
            </tr>
            <tr>
            <td><b>6.&nbsp;&nbsp;&nbsp;&nbsp;Any other Suggestion</b></td>
              <td><?php echo form_textarea(['name'=>'FEEDBACK_SUGGESTION','class'=>'form-control', 'id'=>'id_FEEDBACK_SUGGESTION','rows'=>'4', 'placeholder'=>'Please Write any feedback & suggestion in this box']); ?> <span id="FEEDBACK_SUGGESTION_Error" class="text-danger"></span> 
              </td>
            </tr>
          <?php echo form_input(['type'=>'hidden', 'name'=>'CUID', 'value'=>$CUID]); ?>
          <?php echo form_input(['type'=>'hidden', 'name'=>'cmno', 'value'=>$cmno]); ?>
          <?php echo form_input(['type'=>'hidden', 'name'=>'RID', 'value'=>$RID]); ?>
          <?php echo form_input(['type'=>'hidden', 'name'=>'Rntext', 'value'=>$Rntext]); ?>
          <?php echo form_input(['type'=>'hidden', 'name'=>'RText', 'value'=>$RText]); ?>
          <?php echo form_input(['type'=>'hidden', 'name'=>'to', 'value'=>$to]); ?>
            </tbody>

          </table>
            <?php echo form_submit(['name'=>'from_Btn_Submit','id'=>'id_frm_Btn_Submit','value'=>'Submit','class'=>'btn btn-primary']); ?>
          <?php } ?>
        </div>
      </fieldset>
      </form>
      </div> 
    </div>
</div>
  <div class="col-sm-1"></div>
</div>
<script type="text/javascript">   
$(document).ready(function () {
    
        $("#form1").submit(function (e) {
   
            $("#id_frm_Btn_Submit").attr("disabled", true);
   
            return true;
    
        });
    }); 
</script>
</body>
</head>