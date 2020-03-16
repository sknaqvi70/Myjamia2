<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <style>
    /* Remove the navbar's default margin-bottom and rounded borders */ 
    
    .navbar {
      margin-bottom: 0;
      border-radius: 0;
    }
    
  	.navbar-inverse {
	    border-color: #008cba;
	    background-color: #008cba;
	}

	footer {
	    background-color: #008cba;
	    color: white;
	    padding: 15px;
	}

	.footer-para {
	    margin: 0 0 10px;
	    font-weight: normal;
	    font-size: small;
	}

	.navbar-inverse .navbar-nav>li>a {
    	color: #fff;
	}

	.navbar-inverse .navbar-brand {
	    color: #f2f606;
	}
    /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
    .row.content {min-height: 550px; height: 100%}
    
    /* Set gray background color and 100% height */
    .sidenav {
      padding-top: 20px;
      background-color: #f1f1f1;
      min-height: 550px;
      height: 100%;
    }
    
    /* On small screens, set height to 'auto' for sidenav and grid */
    @media screen and (max-width: 767px) {
      .sidenav {
        height: auto;
        padding: 15px;
      }
      .row.content {height:auto;} 
    }
  </style>
</head>

<body>
<div class="row text-center">
		<div class="col-sm-6 text-center"><img src="<?= base_url(); ?>application/assets/images/logo1.jpg"></div>
		<div class="col-sm-6 text-left"><img src="<?= base_url(); ?>application/assets/images/logo2.jpg"></div>
	</div>
<nav class="navbar navbar-inverse">

  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="#">MyJamia</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">

<ul class="nav navbar-nav">
      <li class="active"><a href="#">Home</a></li>
      <li><a href="#">About</a></li>
      <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">JMI Portals
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="http://jmi.ac.in">JMI Portal</a></li>
          <li><a href="http://jmicoe.in">Examminations Portal</a></li>
          <li><a href="http://jmiiqac.ac.in">IQAC Portal</a></li>
        </ul>
      </li>
      <li><a href="#">Contact</a></li>
    </ul>

      <ul class="nav navbar-nav navbar-right">
        <li><a href="#"><?php echo 'Welcome, ' . $_SESSION['username'] ?></a></li>
        <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Account
        <span class="glyphicon glyphicon-user"></span></a>
        <ul class="dropdown-menu">
          <li><a href="http://jmi.ac.in">Profile&nbsp;<span class="glyphicon glyphicon-info-sign"></span></li></a>
              <li><a data-toggle='modal' href='#changePasswordModal'>Change Password&nbsp;<span class="glyphicon glyphicon-pencil"></span></li></a>
              <li><a href=<?= base_url('Welcome/user_logout'); ?>>Logout&nbsp;<span class="glyphicon glyphicon-log-out"></span></li></a></li>
        </ul> 
      </li>
      </ul>
    </div>
  </div>
</nav>
  
<div class="container-fluid text-center">    
  <div class="row content">
    <div class="col-sm-2 sidenav">

    <!-- Menu Accordian Section Starts Here -->  
	 <div class="panel-group text-left" id="accordion">
  		

    <?php 
        $i = 0;
        $Parent_Menu_ID = '';
        
        foreach ($_SESSION['menu'] as $menuItem) {
      
        if ($Parent_Menu_ID <>  $menuItem->MJ_MENU_PARENT_ID)
          $i++;

        if ($menuItem->MJ_MENU_ORDER == 1 && $i > 1) {
          //New Menu Item has started and its not the first one
            echo "</div>
              </div>
            </div>";
          }
        if ($menuItem->MJ_MENU_ORDER == 1) {
          $Parent_Menu_ID =  $menuItem->MJ_MENU_PARENT_ID;
          echo "<div class='panel panel-default'>
        	       <div class='panel-heading'>
          	      <h4 class='panel-title'>
                    <a data-toggle='collapse' data-parent='#accordion' href='#collapse$i'>
                    <Strong>". $menuItem->MJ_MENU_TEXT."</Strong></a>
                  </h4>
                </div>

                <div id='collapse$i' class='panel-collapse collapse in'>
                  <div class='panel-body'>";
          }
        else {
          echo "<p>".$menuItem->MJ_MENU_TEXT."</p>";
        } 
        
        }
        echo  "</div>
              </div>
            </div>
          </div>";
        ?>

    </div>
    <div class="col-sm-8 text-left"> 
      <h1>Welcome</h1>
      <p class="footer-para">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
      <hr>
      <h3>Test</h3>
      <p>Lorem ipsum...</p>
    </div>
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
          <?php echo form_open('/Welcome/change_password', 'id="changePasswordForm"'); ?>
            <fieldset>
              <span id="success_message">&nbsp;</span>
            <!-- <legend>Login Form</legend> 
            < ?php if ($messageType == 'S') 
                    echo '<div class="alert  alert-success">';
                  elseif ($messageType == 'D')
                    echo '<div class="alert alert-danger">' ;
                  else 
                     echo '<div class="alert alert-info">' ;
            echo '<strong>'.$message.'</strong>';
            echo '</div>';
            ? --> 

            <div class="form-group"> 
              <?php echo form_input(['name'=>'frm_MJ_User_Password','id'=>'frm_MJ_User_Password','class'=>'form-control','placeholder'=>'Current Password']);?>
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
</div>

</body>
</html>

<script>
  $(document).ready(function()  {
    $('#changePasswordForm').on('submit',function(event){ 
      event.preventDefault();

      $.ajax({
        url:      "<?= base_url('Welcome/change_password');?>",
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
