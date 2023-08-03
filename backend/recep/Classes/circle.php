<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .highcharts-figure,
.highcharts-data-table table {
    min-width: 320px;
    max-width: 660px;
    margin: 1em auto;
}

.highcharts-data-table table {
    font-family: Verdana, sans-serif;
    border-collapse: collapse;
    border: 1px solid #ebebeb;
    margin: 10px auto;
    text-align: center;
    width: 100%;
    max-width: 500px;
}
.highcharts-data-table caption {
    padding: 1em 0;
    font-size: 1.2em;
    color: #555;
}
.highcharts-data-table th {
    font-weight: 600;
    padding: 0.5em;
}
.highcharts-data-table td,
.highcharts-data-table th,
.highcharts-data-table caption {
    padding: 0.5em;
}

.highcharts-data-table thead tr,
.highcharts-data-table tr:nth-child(even) {
    background: #f8f8f8;
}

.highcharts-data-table tr:hover {
    background: #f1f7ff;
}
    </style>
</head>
<body>
<figure class="highcharts-figure">
    <div id="container"></div>
    <p class="highcharts-description">
        This pie chart shows how the chart legend can be used to provide
        information about the individual slices.
    </p>
    
</figure>
    


<?php
include('../assets/inc/config.php');
$sql="SELECT pat_village, COUNT(*) AS occurance 
FROM his_patients GROUP BY pat_village";
$stmt=$mysqli->prepare($sql);
$stmt->execute();
$result=$stmt->get_result();
$data=[];
while($row=$result->fetch_object())
{
    $data=[
        'pat_village'=>$row->pat_village,
        'occarence'=>$row->occurance,
    ];
    $json_data=json_encode($data);
    echo $json_data;
}
   ?>
   
<script>
    // Data retrieved from https://netmarketshare.com/
// Build the chart
Highcharts.chart('container', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Browser market shares in March, 2022',
        align: 'left'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    accessibility: {
        point: {
            valueSuffix: '%'
        }
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: false
            },
            showInLegend: true
        }
    },
    series: [{
        name: 'Brands',
        colorByPoint: true,
        data: [{ 
            <?php 
                $sql="SELECT pat_village, COUNT(*) AS occurance 
                FROM his_patients GROUP BY pat_village";
                $stmt=$mysqli->prepare($sql);
                $stmt->execute();
                $result=$stmt->get_result();
                $data=[];
                while($row=$result->fetchAll())
                {               
              ?>
                    
                    name: '<?php echo $row->pat_village; ?>',
                    y: <?php echo $row->occurance; ?> ,
                   

             <?php   }
                ?>
                    // sliced: true,
                    // selected: true
            
        }
        // ,  {
        //     name: 'Manzese',
        //     y: 12.82
        // },  {
        //     name: 'Mwangeza ',
        //     y: 4.63
        // }, {
        //     name: 'Ikolo',
        //     y: 2.44
        // }, {
        //     name: 'Internet Explorer',
        //     y: 2.02
        // }, {
        //     name: 'Other',
        //     y: 3.28
        // }
    ]
    }]
});

</script>

</body>
</html>