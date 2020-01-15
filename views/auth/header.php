<!DOCTYPE html>
<html lang="en">
<head>
  <title>MyJamia Self Service Portal</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="<?= base_url(); ?>application/assets/images/jamia.ico" type="image/ico"/>
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
      <li class="active"><a href="<?= base_url('auth/about');?>">Home</a></li>
      <li><a href="<?= base_url('auth/about');?>">About</a></li>
      <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">JMI Portals
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="http://jmi.ac.in target='_blank'">JMI Portal</a></li>
          <li><a href="http://jmicoe.in target='_blank'">Examminations Portal</a></li>
          <li><a href="http://jmiiqac.ac.in target='_blank'">IQAC Portal</a></li>
        </ul>
      </li>
      <li><a href="<?= base_url('auth/contact');?>">Contact</a></li>
    </ul>

      <ul class="nav navbar-nav navbar-right">
        <li><a href="#"><?php echo 'Welcome, ' . $_SESSION['username'] ?></a></li>
        <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Account
        <span class="glyphicon glyphicon-user"></span></a>
        <ul class="dropdown-menu">
          
          <li><a href="<?= base_url('Student/profile');?>">Profile&nbsp;
              <span class="glyphicon glyphicon-info-sign"></span></li></a>
          
          <li><a data-toggle='modal' href='#changePasswordModal'>Change Password&nbsp;
              <span class="glyphicon glyphicon-pencil"></span>
          </li></a>
          <li><a href=<?= base_url('auth/user_logout'); ?>>Logout&nbsp;
              <span class="glyphicon glyphicon-log-out"></span>
          </li></a>
        </li>
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
        else { //URL added by raquib
          echo "<a href=".base_url().$menuItem->MJ_MENU_URL."><p>".$menuItem->MJ_MENU_TEXT."</p></a>";
        } 
        
        }
        echo  "</div>
              </div>
            </div>
          </div>";
        ?>

    </div>