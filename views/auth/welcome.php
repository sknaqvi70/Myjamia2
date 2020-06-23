<?php include 'header.php';?>

    <div class="col-sm-8 text-left"> 
      <h1>Welcome</h1>
      <p>MyJamia Portal has been developed by FTK-Centre for Information Technology to provide access to various university services to all users including students, faculty members, university staff & alumni etc. </p>
      <hr>
      <?php if($_SESSION['usertype'] == 1){ ?>      
      <h3>Students Services</h3>
      <ol>
        <li>View Attendance</li>
        <li>Course Registration</li>
        <li>Feedback Recording</li>
        <li>Download Fee slips</li>
        <li>Make Fee Payment</li>
        <li>Internet Account Registration Request</li>
        <li>EMail Account Registration Request</li>
        <li>Complaint Registration</li>
      </ol>   
      <?php } elseif ($_SESSION['usertype'] == 2) { ?>
        <h3>Employee Services</h3>
        <ol>
          <li>To Download Salary Slip</li>
          <li>Wifi Account Registration Request</li>
          <li>EMail Account Registration Request</li>
          <li>Complaint Registration</li>
        </ol>
      <?php } else { ?> 
        <h3></h3>
        <ol>          
          <li>Internet Account Registration Request</li>
          <li>EMail Account Registration Request</li>
          <li>Complaint Registration</li>
        </ol>
    <?php } ?>
    </div>
<?php include 'footer.php';?>
