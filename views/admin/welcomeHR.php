<?php require __DIR__.'/../auth/header.php'; ?>

<div class="col-sm-8 text-left"> 
    <h1>Dashboard</h1>
    <div class="panel panel-info">
    	<div class="panel-heading">
            <div class="row">
                <div class="col-md-10">
                    <?php $C_date = date('d-m-Y'); ?>
                    <h4>Total Complaints Till Date <?php echo $C_date; ?></h4>
                </div>
               <!--  <div class="col-md-3">
                    <?php echo form_dropdown('CM_YEAR', $year_list, set_value('CM_YEAR'),'class="form-control" id="id_CM_YEAR"'); 
                    ?>
                </div>  -->                             
            </div>
        </div>
        <div class="panel-body">
            <div style="width: 1000px; height: 100px;">
                &nbsp;&nbsp;&nbsp;
            <?php if (isset($pending_comp)) { ?>  
            <a class="btn btn-info" href="<?php echo base_url() ?>Admin/complaintStatus#open_no_comp">
                <span style="font-size: 30px;"></span>
                <strong><font size="8"><?php echo $pending_comp ?></font></strong>       
                <br>&nbsp;&nbsp;<font size="4">Pending for Accept</font>
            </a>
            <?php } ?>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <?php if (isset($accepted_comp)) { ?>
            <a class="btn btn-warning" href="<?php echo base_url() ?>Admin/complaintStatus#on_hold_comp">
                <span   style="font-size: 30px;"></span>
                <strong><font size="8"><?php echo $accepted_comp ?></font></strong> 
                <br>&nbsp;&nbsp;<font size="4">Accepted Complaints</font>
            </a>
            <?php } ?>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <?php if (isset($closed_comp)) { ?> 
            <a class="btn btn-success" href="<?php echo base_url() ?>Admin/complaintStatus#closed_no_comp">
                <span    style="font-size: 30px;"></span>
                <strong><font size="8"><?php echo $closed_comp ?></font></strong> 
                <br>&nbsp;&nbsp;<font size="4">Closed Complaints</font>
            </a>
            <?php } ?>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <?php if (isset($total_assigned)) { ?>  
            <a class="btn btn-primary " href="<?php echo base_url() ?>Admin/complaintStatus#tot_no_comp">
                <span      style="font-size: 30px;"></span>
                <strong><font size="8"><?php echo $total_assigned ?></font></strong> 
                <br>&nbsp;&nbsp;<font size="4">Total Assigned</font>
            </a>
            <?php } ?>
            </div><br><br>
            <hr class="panel panel-info">                
        </div>
        <div class="panel-body">
        <?php
            $dataPoints = array(
            array("label"=> "Pending for Accept", "y"=> $pending_comp),
            array("label"=> "Accepted Complaints", "y"=> $accepted_comp),
            //array("label"=> "On Hold Complaints", "y"=> $hold),
            array("label"=> "Closed Complaints", "y"=> $closed_comp),
            //array("label"=> "Total Complaints", "y"=> $pending)
            );    
        ?>
        <script>
            window.onload = function () {
            var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            exportEnabled: true, 
            title:{
                    text: "Total Complaints Assigned - <?php echo $total_assigned ?>"
            },
            data: [{
                type: "pie",
                showInLegend: "true",
                legendText: "{label}",
                indexLabelFontSize: 16,
                indexLabel: "{label} - #percent%",
                yValueFormatString: "##0",
                dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
            }]
            });
                chart.render(); 
            }
        </script>

        <div id="chartContainer" style="height: 370px; width: 100%;"></div>
        <script src="<?= base_url(); ?>application/assets/js/canvasjs.min.js"></script>
        </div>          
    </div>        
</div>



 <?php require __DIR__.'/../auth/footer.php'; ?>
