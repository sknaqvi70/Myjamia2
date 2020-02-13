<?php require __DIR__.'/../auth/header.php'; ?>

<div class="col-sm-8 text-left"> 
    <h1>Dashboard</h1>
    <div class="panel panel-info">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-9">
                    <h4>Year Wise Complaints Status</h4>
                </div>
                <div class="col-md-3">
                    <select name="year" id="year" class="form-control">
                        <?php foreach ($year_list->result_array() as $row) {
                        echo '<option value="'.$row["YEAR"].'">'.$row["YEAR"].'</option>';
                        }
                        ?>
                    </select>
                </div>                
            </div>
        </div>
        <div class="panel-body">
            <div style="width: 1000px; height: 100px;">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <?php if (isset($open)) { ?>  
            <a class="btn btn-info" href="<?php echo base_url() ?>Admin/complaintStatus#open_no_comp">
                <span style="font-size: 30px;"></span>
                <strong><font size="8"><?php echo $open ?></font></strong>       
                <br>&nbsp;&nbsp;<font size="4">Open Complaints</font>
            </a>
            <?php } ?>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <?php if (isset($hold)) { ?>
            <a class="btn btn-warning" href="<?php echo base_url() ?>Admin/complaintStatus#pending_no_comp">
                <span   style="font-size: 30px;"></span>
                <strong><font size="8"><?php echo $hold ?></font></strong> 
                <br>&nbsp;&nbsp;<font size="4">On Hold Complaints</font>
            </a>
            <?php } ?>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <?php if (isset($closed)) { ?> 
            <a class="btn btn-success" href="<?php echo base_url() ?>Admin/complaintStatus#closed_no_comp">
                <span    style="font-size: 30px;"></span>
                <strong><font size="8"><?php echo $closed ?></font></strong> 
                <br>&nbsp;&nbsp;<font size="4">Closed Complaints</font>
            </a>
            <?php } ?>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <?php if (isset($total)) { ?>  
            <a class="btn btn-primary " href="<?php echo base_url() ?>Admin/complaintStatus#tot_no_comp">
                <span      style="font-size: 30px;"></span>
                <strong><font size="8"><?php echo $total ?></font></strong> 
                <br>&nbsp;&nbsp;<font size="4">Total Complaint</font>
            </a>
            <?php } ?>
            </div><br><br>
            <hr class="panel panel-info">                
        </div>
        <div class="panel-body">
            <div id="chart_area" style="width: 750px; height: 400px;"></div>
        </div>        
    </div>
</div>
<!-- <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {packages:['corechart', 'bar']});
    google.charts.setOnLoadCallback();

    function load_yearwise_data(year, title)
    {
        var tem_title=title+' '+year;
        $.ajax({
            url: '<?=base_url()?>Admin/fetch_data',
            method: "POST",
            data: {year:year},
            dataType: "JSON",
            success:function(data){
                drawMonthsWiseChat(data, tem_title);
            }
        })
    }

    function drawMonthsWiseChat(chart_data, chart_main_title){
        var jsonData = chart_data;
        var data = new google.visualization.DataTable();
        data.addColumn('number', 'MONTHS');
        data.addColumn('number', 'COMPLAINTS');

        $.each(jsonData, function(i, jasonData){
            var month = jsonData.MONTHS;
            var Complaints = jsonData.COMPLAINTS;
            data.addRows([[month, Complaints]]);
        });
        var options = {
            title:charts_main_title,
            hAxis:{
                title: "Months"
            },
            vAxis:{
                title: "No of Complaints"
            }
        }
        var chart = new google.visualization.ColumnChart(document.getElementsById('chart_area'));
        chart.draw(data, options);
    }
</script>
<script type="text/javascript">
    $(document).ready(function()){
        $('#year').change(function(){
            var year = $(this).val();
            if(year != '')
            {
               load_yearwise_data(year, 'Month wise Complaints data for'); 
            }
        });
    }
</script> -->
<script src="https://code.highcharts.com/highcharts.js"></script>
    <script type="text/javascript">  
$(function () { 
  
    var data_total = <?php echo $total_data; ?>;
    var data_open = <?php echo $opend_data; ?>;
    var data_hold = <?php echo $hold_data; ?>;
    var data_closed = <?php echo $closed_data; ?>;
  
    $('#chart_area').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'Complaints Year Wise Data'
        },
        xAxis: {
            categories: ['2016','2017','2018', '2019', '2020']
        },
        yAxis: {
            title: {
                text: 'No of Complaints'
            }
        },
        series: [{
            name: 'Open Complaints',
            data: data_open
        }, {
            name: 'Total Complaints',
            data: data_total
        }, {
            name: 'Closed Complaints',
            data: data_closed
        }, {
            name: 'Put on Hold Complaints',
            data: data_hold
        }]
    });
});
  
</script>
 

 <?php require __DIR__.'/../auth/footer.php'; ?>
