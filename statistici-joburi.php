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
		
        $result_ofertat = mysqli_query($sqli,"SELECT COUNT(id_serviciu) as ofertat FROM postare_serviciu WHERE status_serviciu='0'");
        $row_ofertat = mysqli_fetch_array($result_ofertat);
		
		$result_executie = mysqli_query($sqli,"SELECT COUNT(id_serviciu) as executie FROM postare_serviciu WHERE status_serviciu='1'");
        $row_executie = mysqli_fetch_array($result_executie);
		
		$result_desemnare = mysqli_query($sqli,"SELECT COUNT(id_serviciu) as desemnare FROM postare_serviciu WHERE status_serviciu='2'");
        $row_desemnare = mysqli_fetch_array($result_desemnare);
		
		$result_finalizat = mysqli_query($sqli,"SELECT COUNT(id_serviciu) as finalizat FROM postare_serviciu WHERE status_serviciu='3'");
        $row_finalizat = mysqli_fetch_array($result_finalizat);
		
		$result_suplimentar = mysqli_query($sqli,"SELECT COUNT(id_serviciu) as suplimentar FROM postare_serviciu WHERE status_serviciu='4'");
        $row_suplimentar = mysqli_fetch_array($result_suplimentar);
		
		
		?>
		
          ['Deschise pentru ofertare', <?php echo $row_ofertat['ofertat']; ?>],
          ['Deschise pentru executie', <?php echo $row_executie['executie']; ?>],
		  ['Desemnare castigator', <?php echo $row_desemnare['desemnare']; ?>],
		  ['Proiect finalizat', <?php echo $row_finalizat['finalizat']; ?>],
		  ['Proiect cu servicii suplimentare', <?php echo $row_suplimentar['suplimentar']; ?>]
        ]);

        // Set chart options
        var options = {'title':'Tipuri de proiecte (total: <?php echo $row_ofertat['ofertat'] + $row_executie['executie'] + $row_desemnare['desemnare'] + $row_finalizat['finalizat'] + $row_suplimentar['suplimentar']; ?>):',
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