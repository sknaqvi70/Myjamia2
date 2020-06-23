<?php require __DIR__.'/../auth/header.php'; ?>
<br>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap.min.css">
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap.min.js"></script>
<style>
  .bs-example{
      margin: 20px;
    }
  .table{
   width:100%; 
   font-size:15px; 
   font-family:Calibri; 
  } 
</style>
<script>
$(document).ready(function(){ 
  $("#myTab li:eq(0) a").tab('show'); // show 2nd tab on page load
});
$(document).ready(function() {
    $('#pending_accept_comp').DataTable();
} );
$(document).ready(function() {
    $('#accept_comp').DataTable();
} );
$(document).ready(function() {
    $('#hold_compt').DataTable();
} );
$(document).ready(function() {
    $('#closed_comp').DataTable();
} );
$(document).ready(function() {
    $('#tot_assigned').DataTable();
} );
</script>

<div class="col-sm-8 text-left"> 
  <div class="panel panel-info">
    <div class="panel-heading" style="text-align: center;"><h3>Complaints Status</h3></div>
    <?php if($error = $this->session->flashdata('msg')){ ?>
      <h3 class="text-success"><?php echo  $error; ?></h3>
    <?php } ?>
      <div class="bs-example">
        <ul class="nav nav-tabs" id="myTab">
          <li class="nav-item">
            <a href="#pending_accept" class="nav-link" data-toggle="tab">Pending Acceptance</a>
          </li>
          <li class="nav-item">
            <a href="#accepted_comp" class="nav-link" data-toggle="tab">Accepted Complaints</a>
          </li>
          <li class="nav-item">
            <a href="#hold_comp" class="nav-link" data-toggle="tab">On Hold Complaints</a>
          </li>
          <li class="nav-item">
            <a href="#closed_compt" class="nav-link" data-toggle="tab">Closed Complaints</a>
          </li>
          <li class="nav-item">
            <a href="#tot_no_assigned" class="nav-link" data-toggle="tab">Total Assigned</a>
          </li>
        </ul>
        <div class="tab-content table-responsive">
        <div class="tab-pane fade" id="pending_accept">
            <h4 class="mt-2">Total Number of complaints for Acceptance.</h4>
        <?php if(isset($pending_accept)) {?> 
        <table id="pending_accept_comp" class="table table-striped table-bordered">
        <thead style="font-size:15px;">    
            <tr>
              <th>S.No</th>
              <th>Complaint No</th>
              <th>Complainant Type </th>
              <th>Complainant Assign date </th>
              <th class="text-center">View</th>
              <th class="text-center">Action</th>
            </tr>
          </thead>
          <tbody> 
          <?php
              $no = 0;
              foreach ($pending_accept as $v_pending):
              $no++;
            ?>           
            <tr>
              <td><?php echo $no ?></td>
              <td><?php echo $v_pending->MJ_CAD_CM_NO ?></td>
              <td><?php echo $v_pending->CSC_NAME ?></td>
              <td><?php echo $v_pending->MJ_CAD_ASSIGN_DATE ?></td>
              <td><center><input type="button" class="btn btn-sm btn-warning view_data " value="VIEW" id="<?php echo $v_pending->MJ_CAD_CM_NO; ?>"></center>
              </td>
              <td>
                <center>
                  <!-- <input type="button" class="btn btn-sm btn-danger assign_data" value="REQUEST FOR ACCEPT" id="<?php echo $v_open->MJ_CAD_CM_NO; ?>"> -->
                  <button class="btn btn-danger hr_acceptance" uid="<?php echo $v_pending->MJ_CAD_CM_NO; ?>">REQUEST FOR ACCEPT</button>
                </center>
                <script type="text/javascript">
                  $(document).on('click','.hr_acceptance',function(){
                  var id = $(this).attr('uid');
                  $('#user_id').val(id);
                  $('#modal_popup').modal({backdrop: 'static', keyboard: true, show: true});
                  });
                </script>
                <div class="modal modal-danger fade" id="modal_popup">
                  <div class="modal-dialog modal-sm">
                  <!-- create form to change user status -->
                  <form action="<?php echo base_url(); ?>Admin/hr_acceptance" method="post"> 
                    <div class="modal-content">
                      <div class="modal-header" style="height: 150px;">
                      <h4 style="margin-top: 50px;text-align: center;">Are you sure, do you Accept this Complaint?</h4>
                      <!-- getting value in hidden field with the hep of ID's -->
                      <input type="hidden" name="id" id="user_id" value="">
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">No</button>
                        <button type="submit" name="submit" class="btn btn-success">Yes</button>
                      </div>
                    </div>
                  </form>
                  </div>
                </div>
              </td>
            </tr>
            <?php endforeach; ?>           
          </tbody>
          </table>
          <?php } ?>          
        </div>
        <div class="tab-pane fade" id="accepted_comp">
            <h4 class="mt-2">Total Number of Accepted complaints</h4>
            <?php if(isset($accepted_comp)) {?>
            <table id="accept_comp" class="table table-striped table-bordered">
              <thead>    
              <tr>
                <th>S.No</th>
                <th>Complaint No</th>
                <th>Complainant Type </th>
                <th>Complainant Assign date</th>
                <th class="text-center">View</th>
                <th class="text-center">Action</th>
              </tr>
              </thead>
              <?php
              $no = 0;
              foreach ($accepted_comp as $v_accepted):
              $no++;
              ?>           
              <tr>
                <td><?php echo $no ?></td>
                <td><?php echo $v_accepted->MJ_CAD_CM_NO ?></td>
                <td><?php echo $v_accepted->CSC_NAME ?></td>
                <td><?php echo $v_accepted->MJ_CAD_ASSIGN_DATE ?></td>
                <td><center><input type="button" class="btn btn-warning btn-sm view_data" value="VIEW" id="<?php echo $v_accepted->MJ_CAD_CM_NO; ?>"></center>
                </td>
                <td>                  
                  <center><input type="button" class="btn btn-info btn-sm status_update" value="UPDATE STATUS" id="<?php echo $v_accepted->MJ_CAD_CM_NO; ?>">
                  </center>
                </td>
              </tr>
              <?php endforeach; ?>           
              </tbody>
            </table>
            <?php } ?>
        </div>
        <div class="tab-pane fade" id="hold_comp">
            <h4 class="mt-2">Total Number of On Hold complaints</h4>
            <?php if(isset($hold_comp)) {?>
            <table id="hold_compt" class="table table-striped table-bordered">
              <thead>    
              <tr>
                <th>S.No</th>
                <th>Complaint No</th>
                <th>Complainant Type </th>
                <th>Complainant Assign date</th>
                <th class="text-center">View</th>
                <th class="text-center">Action</th>
              </tr>
              </thead>
              <?php
              $no = 0;
              foreach ($hold_comp as $v_hold):
              $no++;
              ?>           
              <tr>
                <td><?php echo $no ?></td>
                <td><?php echo $v_hold->MJ_CAD_CM_NO ?></td>
                <td><?php echo $v_hold->CSC_NAME ?></td>
                <td><?php echo $v_hold->MJ_CAD_ASSIGN_DATE ?></td>
                <td><center><input type="button" class="btn btn-warning btn-sm view_data" value="VIEW" id="<?php echo $v_hold->MJ_CAD_CM_NO; ?>"></center>
                </td>
                <td>                  
                  <center><input type="button" class="btn btn-info btn-sm status_update" value="UPDATE STATUS" id="<?php echo $v_hold->MJ_CAD_CM_NO; ?>">
                  </center>
                </td>
              </tr>
              <?php endforeach; ?>           
              </tbody>
            </table>
            <?php } ?>           
        </div>
        <div class="tab-pane fade" id="closed_compt">
            <h4 class="mt-2">Total Number of Closed Complaints</h4>
            <?php if(isset($closed_no_comp)) {?>
            <table id="closed_comp" class="table table-striped table-bordered">
              <thead>    
              <tr>
                <th>S.No</th>
                <th>Complaint No</th>
                <th>Complainant Type </th>
                <th>Complainant Assign date</th>
                <th>Complainant Closed date</th>
                <th class="text-center">View</th>
              </tr>
              </thead>
              <?php
              $no = 0;
              foreach ($closed_no_comp as $v_closed):
              $no++;
              ?>           
              <tr>
                <td><?php echo $no ?></td>
                <td><?php echo $v_closed->MJ_CAD_CM_NO ?></td>
                <td><?php echo $v_closed->CSC_NAME ?></td>
                <td><?php echo $v_closed->MJ_CAD_ASSIGN_DATE ?></td>
                <td><?php echo $v_closed->MJ_CAD_ASSIGN_DATE ?></td>
                <td><center><input type="button" class="btn btn-warning btn-sm view_data" value="VIEW" id="<?php echo $v_closed->MJ_CAD_CM_NO; ?>"></center>
                </td>
                
              </tr>
              <?php endforeach; ?>           
              </tbody>
            </table>
            <?php } ?>
        </div>
        <div class="tab-pane fade" id="tot_no_assigned">
            <h4 class="mt-2">Total Number of Assigned Complaints</h4>
            <?php if(isset($tot_no_assigned)) {?>
            <table id="tot_assigned" class="table table-striped table-bordered">
              <thead>    
              <tr>
                <th>S.No</th>
                <th>Complaint No</th>
                <th>Complaint Type </th>
                <th>Date of Assign </th>
                <th class="text-center">View</th>
              </tr>
              </thead>
              <tbody> 
              <?php
              $no = 0;
              foreach ($tot_no_assigned as $v_tot):
              $no++;
              ?>           
              <tr>
                <td><?php echo $no ?></td>
                <td><?php echo $v_tot->MJ_CAD_CM_NO ?></td>
                <td><?php echo $v_tot->CSC_NAME ?></td>
                <td><?php echo $v_tot->MJ_CAD_ASSIGN_DATE ?></td>
                <td><center><input type="button" class="btn btn-warning btn-sm view_data" value="View" id="<?php echo $v_tot->MJ_CAD_CM_NO; ?>"></center>
                </td>                
              </tr>
              <?php endforeach; ?>           
              </tbody>
            </table>
            <?php } ?>
        </div>
      </div>
      </div>
  </div>
</div>
<!-- view Modal -->
 <div class="modal fade" id="complaintModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true" style="margin-top: -20px;">
   <div class="modal-dialog modal-lg">
     <div class="modal-content">
       <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
         <div class="panel panel-info">
            <div class="panel-heading" style="text-align: center;"><h3>Complaint Details</h3></div>
         </div>
       <div class="modal-body">
         <div id="view_result"></div>
       </div>
       </div>
       <div class="modal-footer">
         <button type="button" class="btn btn-default" data-dismiss="modal" id="modal-btn">Close</button>
       </div>
     </div>
   </div>
 </div>
 <script type="text/javascript">
     // Start jQuery function after page is loaded
        $(document).ready(function(){
         // Initiate DataTable function comes with plugin
         $('#dataTable').DataTable();
         // Start jQuery click function to view Bootstrap modal when view info button is clicked
            $('.view_data').click(function(){
             // Get the id of selected phone and assign it in a variable called phoneData
                var v_cm_no = $(this).attr('id');
                // Start AJAX function
                $.ajax({
                 // Path for controller function which fetches selected phone data
                    url: "<?php echo base_url() ?>Admin/viewComplaintDetailsHR",
                    // Method of getting data
                    method: "POST",
                    // Data is sent to the server
                    data: {v_cm_no:v_cm_no},
                    // Callback function that is executed after data is successfully sent and recieved
                    success: function(data){
                     // Print the fetched data of the selected phone in the section called #view_result 
                     // within the Bootstrap modal
                        $('#view_result').html(data);
                        // Display the Bootstrap modal
                        $('#complaintModal').modal('show');
                    }
             });
             // End AJAX function
         });
     });  
  </script>
<!-- Js for Assign complaints -->
<script type="text/javascript">
     // Start jQuery function after page is loaded
        $(document).ready(function(){
         // Initiate DataTable function comes with plugin
         $('#dataTable').DataTable();
         // Start jQuery click function to view Bootstrap modal when view info button is clicked
            $('.status_update').click(function(){
             // Get the id of selected phone and assign it in a variable called phoneData
                var v_cm_no = $(this).attr('id');
                // Start AJAX function
                $.ajax({
                 // Path for controller function which fetches selected phone data
                    url: "<?php echo base_url() ?>Admin/ComplaintStatusUpdate",
                    // Method of getting data
                    method: "POST",
                    // Data is sent to the server
                    data: {v_cm_no:v_cm_no},
                    // Callback function that is executed after data is successfully sent and recieved
                    success: function(data){
                     // Print the fetched data of the selected phone in the section called #view_result 
                     // within the Bootstrap modal
                        $('#view_result').html(data);
                        // Display the Bootstrap modal
                        $('#complaintModal').modal('show');
                    }
                    
             });
             // End AJAX function
             // when modal form close parent page will refreshed
             $('#complaintModal').on('hidden.bs.modal', function () {
                location.reload();
              });
         });
     });  
</script>
</body>
</html>
 <?php require __DIR__.'/../auth/footer.php'; ?>