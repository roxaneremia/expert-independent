<?php
session_start();
include "de-inclus.php";

?>

<html>
<head>

 <title>Statistici</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!--css-->
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/index.css" type="text/css" />
  <!-css-->

  <!--js-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <!--js-->
  
  <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
     var data;
     var chart;

      // Load the Visualization API and the piechart package.
      google.charts.load('current', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(drawChart);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart() {

        // Create our data table.
        data = new google.visualization.DataTable();
        data.addColumn('string', 'a');
        data.addColumn('number', 'b');
        data.addRows([
		
		<?php
		global $sqli;
		
		$query_designeri = "SELECT COUNT(tip_membru) as designeri FROM membru WHERE tip_membru='2'";
        $result_designeri = mysqli_query($sqli,$query_designeri);
        $row_designeri = mysqli_fetch_array($result_designeri);
		
		$query_clienti = "SELECT COUNT(tip_membru) as clienti FROM membru WHERE tip_membru='1'";
        $result_clienti = mysqli_query($sqli,$query_clienti);
        $row_clienti = mysqli_fetch_array($result_clienti);
		
		?>
		
          ['Client', <?php echo $row_clienti['clienti']; ?>],
          ['Designer', <?php echo $row_designeri['designeri']; ?>]
        ]);

        // Set chart options
        var options = {'title':'Tipuri de utilizatori (total: <?php echo $row_clienti['clienti'] + $row_designeri['designeri']; ?>):',
                       'width':600,
                       'height':500};

        // Instantiate and draw our chart, passing in some options.
        chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        google.visualization.events.addListener(chart, 'select', selectHandler);
        chart.draw(data, options);
      }

      function selectHandler() {
        var selectedItem = chart.getSelection()[0];
        var value = data.getValue(selectedItem.row, 0);
        alert('The user selected ' + value);
      }

    </script>

</head>

<body>

<?php // include"antet.php"; ?>

<em><h2 style="margin-left: 15%">Statistici utilizatori platforma</h2></em>


    <div id="chart_div" style="width:600; height:500"></div>





<?php // include"subsol.php"; ?>

</body>
</html>