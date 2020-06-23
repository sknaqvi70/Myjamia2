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
            <div align="center" style="width: 840px; height: 100px;">                
            <?php if (isset($open)) { ?>  
            <a class="btn btn-info" href="<?php echo base_url() ?>Admin/complaintStatusDep#open_no_comp">
                <span style="font-size: 30px;"></span>
                <strong><font size="8"><?php echo $open ?></font></strong>       
                <br>&nbsp;&nbsp;<font size="4">Open Complaints</font>
            </a>
            <?php } ?>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <?php if (isset($pending_at)) { ?>
            <a class="btn btn-danger" href="<?php echo base_url() ?>Admin/complaintStatusDep#on_hold_comp">
                <span   style="font-size: 30px;"></span>
                <strong><font size="8"><?php echo $pending_at ?></font></strong> 
                <br>&nbsp;&nbsp;<font size="4">Pending Acceptance</font>
            </a>
            <?php } ?>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <?php if (isset($pending)) { ?>
            <a class="btn btn-warning" href="<?php echo base_url() ?>Admin/complaintStatusDep#on_hold_comp">
                <span   style="font-size: 30px;"></span>
                <strong><font size="8"><?php echo $pending ?></font></strong> 
                <br>&nbsp;&nbsp;<font size="4">Pending Complaints</font>
            </a>
            <?php } ?><br><br>
            
            <?php if (isset($hold)) { ?>
            <a class="btn btn-warning" href="<?php echo base_url() ?>Admin/complaintStatusDep#on_hold_comp">
                <span   style="font-size: 30px;"></span>
                <strong><font size="8"><?php echo $hold ?></font></strong> 
                <br>&nbsp;&nbsp;<font size="4">On Hold Complaints</font>
            </a>
            <?php } ?>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <?php if (isset($closed)) { ?> 
            <a class="btn btn-success" href="<?php echo base_url() ?>Admin/complaintStatusDep#closed_no_comp">
                <span    style="font-size: 30px;"></span>
                <strong><font size="8"><?php echo $closed ?></font></strong> 
                <br>&nbsp;&nbsp;<font size="4">Closed Complaints</font>
            </a>
            <?php } ?>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <?php if (isset($total)) { ?>  
            <a class="btn btn-primary " href="<?php echo base_url() ?>Admin/complaintStatusDep#tot_no_comp">
                <span      style="font-size: 30px;"></span>
                <strong><font size="8"><?php echo $total ?></font></strong> 
                <br>&nbsp;&nbsp;<font size="4">Total Complaint</font>
            </a>
            <?php } ?>

            </div><br><br><br><br><br><br>
            <hr class="panel panel-info">                
        </div>
        <div class="panel-body">
        <?php
            $dataPoints = array(
            array("label"=> "Open Complaints", "y"=> $open),
            array("label"=> "Pending Acceptance", "y"=> $pending_at),
            array("label"=> "Closed Complaints", "y"=> $closed),
            array("label"=> "Pending Complaints at Engineer", "y"=> $pending),
            array("label"=> "On Hold Complaints", "y"=> $hold),
            
            //array("label"=> "Total Complaints", "y"=> $pending)
            );    
        ?>
        <script>
            window.onload = function () {
            var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            exportEnabled: true, 
            title:{
                    text: "Total Complaints of Department <?php echo $DepDesc.' - '.$total ?>"
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
