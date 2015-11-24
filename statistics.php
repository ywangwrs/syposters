<html>
<head>
<script src="fusioncharts.js"></script>
</head>
<body>
<?php
// This is a simple example on how to draw a chart using FusionCharts and PHP.
// fusioncharts.php functions to help us easily embed the charts.
	include("fusioncharts.php");
?>

<?php
	 // Create the chart - Column 2D Chart with data given in constructor parameter
	 // Syntax for the constructor - new FusionCharts("type of chart", "unique chart id", "width of chart", "height of chart", "div id to render the chart", "type of data", "actual data")
	 $columnChart = new FusionCharts("Column2D", "weekly_numbers" , 780, 400, "chart-1", "jsonurl", "weekly_numbers.json");
	 // Render the chart
	 $columnChart->render();
	 $columnChart1= new FusionCharts("Column2D", "people_posted_numbers" , 400, 400, "chart-2", "jsonurl", "people_posted_numbers.json");
	 // Render the chart
	 $columnChart1->render();
?>
<h1>Ottawa Shen Yun Posters Weekly Report</h1>

<h2>Overall number of delivered posters</h2>
<div id="chart-1"><!-- Fusion Charts will render here--></div>

<h2>Number of posters delivered by people</h2>
<div id="chart-2"><!-- Fusion Charts will render here--></div>
</body>
</html>
