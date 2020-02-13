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
    $('#open_comp').DataTable();
} );
$(document).ready(function() {
    $('#pending_comp').DataTable();
} );
$(document).ready(function() {
    $('#closed_comp').DataTable();
} );
$(document).ready(function() {
    $('#tot_comp').DataTable();
} );
</script>

<div class="col-sm-8 text-left"> 
  <div class="panel panel-info">
    <div class="panel-heading" style="text-align: center;"><h3>Complaints Status</h3></div>
      <div class="bs-example">
        <ul class="nav nav-tabs" id="myTab">
          <li class="nav-item">
            <a href="#open_no_comp" class="nav-link" data-toggle="tab">Open Complaints</a>
          </li>
          <li class="nav-item">
            <a href="#pending_no_comp" class="nav-link" data-toggle="tab">Pending at</a>
          </li>
          <li class="nav-item">
            <a href="#on_hold_comp" class="nav-link" data-toggle="tab">On Hold Complaints</a>
          </li>
          <li class="nav-item">
            <a href="#Closed_no_comp" class="nav-link" data-toggle="tab">Closed Complaints</a>
          </li>
          <li class="nav-item">
            <a href="#tot_no_comp" class="nav-link" data-toggle="tab">Total Complaints</a>
          </li>
        </ul>
        <div class="tab-content table-responsive">
        <div class="tab-pane fade" id="open_no_comp">
            <h4 class="mt-2">Total Number of Open complaint.</h4>
        <?php if(isset($open_no_comp)) {?> 
        <table id="open_comp" class="table table-striped table-bordered">
        <thead style="font-size:15px;">    
            <tr>
              <th>S.No</th>
              <th>Complaint Type</th>
              <th>Complainant Name </th>
              <th class="text-center">View</th>
              <th class="text-center">Action</th>
            </tr>
          </thead>
          <tbody> 
          <?php
              $no = 0;
              foreach ($open_no_comp as $v_open):
              $no++;
            ?>           
            <tr>
              <td><?php echo $no ?></td>
              <td><?php echo $v_open->CSC_NAME ?></td>
              <td><?php echo $v_open->CM_COMPLAINT_CONTACT_PERSON ?></td>
              <td><center><input type="button" class="btn btn-info btn-sm view_data" value="View" id="<?php echo $v_open->CM_NO; ?>"></center>
              </td>
              <td>
                <center>
                  <input type="button" class="btn btn-info btn-sm edit_data" value="Assign" id="<?php echo $v_open->CM_NO; ?>">
                  <input type="button" class="btn btn-info btn-sm closed_data" value="CLose" id="<?php echo $v_open->CM_NO; ?>">
                  <input type="button" class="btn btn-info btn-sm hold_data" value="Put on Hold" id="<?php echo $v_open->CM_NO; ?>">
                </center>
              </td>
              <!-- <td>
                <a href="" class="btn btn-sm btn-info">Assign</a>
                <a href="" class="btn btn-sm btn-info">CLose</a>
                <a href="" class="btn btn-sm btn-info">Put on Hold</a>
              </td> -->
            </tr>
            <?php endforeach; ?>           
          </tbody>
          </table>
          <?php } ?>          
        </div>
        <div class="tab-pane fade" id="pending_no_comp">
            <h4 class="mt-2">Total Number of Pending complaint</h4>
            <?php if(isset($pending_no_comp)) {?>
            <table id="pending_comp" class="table table-striped table-bordered">
              <thead>    
              <tr>
                <th>S.No</th>
                <th>Complaint Type</th>
                <th>Complainant Name </th>
                <th>Complainant Mobile No</th>
                <th class="text-center">View</th>
                <th class="text-center">Action</th>
              </tr>
              </thead>
              <?php
              $no = 0;
              foreach ($pending_no_comp as $v_pending):
              $no++;
              ?>           
              <tr>
                <td><?php echo $no ?></td>
                <td><?php echo $v_pending->CSC_NAME ?></td>
                <td><?php echo $v_pending->CM_COMPLAINT_CONTACT_PERSON ?></td>
                <td><?php echo $v_pending->CM_COMPLAINT_CONTACT_MOBILE ?></td>
                <td><center><input type="button" class="btn btn-info btn-sm view_data" value="View" id="<?php echo $v_pending->CM_NO; ?>"></center>
                </td>
                <td>                  
                  <a href="" class="btn btn-sm btn-info">CLose</a>
                </td>
              </tr>
              <?php endforeach; ?>           
              </tbody>
            </table>
            <?php } ?>
        </div>
        <div class="tab-pane fade" id="on_hold_comp">
            <h4 class="mt-2">On Hold complaint</h4>
            
        </div>
        <div class="tab-pane fade" id="Closed_no_comp">
            <h4 class="mt-2">Total Number of Closed Complaint</h4>
            <?php if(isset($closed_no_comp)) {?>
            <table id="closed_comp" class="table table-striped table-bordered">
              <thead>    
              <tr>
                <th>S.No</th>
                <th>Complaint Type</th>
                <th>Complainant Name </th>
                <th>Complainant Mobile No</th>
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
                <td><?php echo $v_closed->CSC_NAME ?></td>
                <td><?php echo $v_closed->CM_COMPLAINT_CONTACT_PERSON ?></td>
                <td><?php echo $v_closed->CM_COMPLAINT_CONTACT_MOBILE ?></td>
                <td><center><input type="button" class="btn btn-info btn-sm view_data" value="View" id="<?php echo $v_closed->CM_NO; ?>"></center>
                </td>
                
              </tr>
              <?php endforeach; ?>           
              </tbody>
            </table>
            <?php } ?>
        </div>
        <div class="tab-pane fade" id="tot_no_comp">
            <h4 class="mt-2">Total Number of complaint</h4>
            <?php if(isset($tot_no_comp)) {?>
            <table id="tot_comp" class="table table-striped table-bordered">
              <thead>    
              <tr>
                <th>S.No</th>
                <th>Complaint Type</th>
                <th>Complaint Department </th>
                <th class="text-center">View</th>
              </tr>
              </thead>
              <tbody> 
              <?php
              $no = 0;
              foreach ($tot_no_comp as $v_tot):
              $no++;
              ?>           
              <tr>
                <td><?php echo $no ?></td>
                <td><?php echo $v_tot->CSC_NAME ?></td>
                <td><?php echo $v_tot->DEP_DESC ?></td>
                <td><center><input type="button" class="btn btn-info btn-sm view_data" value="View" id="<?php echo $v_tot->CM_NO; ?>"></center>
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
            <div class="panel-heading" style="text-align: center;"><h3>Complaints Details</h3></div>
         </div>
       <div class="modal-body">
        <!-- Place to print the fetched phone -->
         <div id="view_result"></div>
       </div>
       </div>
       <div class="modal-footer">
         <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
                    url: "<?php echo base_url() ?>Admin/totalComplaint",
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
            $('.edit_data').click(function(){
             // Get the id of selected phone and assign it in a variable called phoneData
                var v_cm_no = $(this).attr('id');
                // Start AJAX function
                $.ajax({
                 // Path for controller function which fetches selected phone data
                    url: "<?php echo base_url() ?>Admin/AsignComplaints",
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
</body>
</html>
 <?php require __DIR__.'/../auth/footer.php'; ?>