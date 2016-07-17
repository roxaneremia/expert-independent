<?php

session_start();
  include "de-inclus.php";
  //echo '<pre>'; print_r($_POST); echo '</pre>'; //die();

  if(isset($_POST['alege-solutie'])) {
      $optiuni = $_POST['optcheck'];
      $stele = $_POST['numar_stele'];
      if(empty($optiuni)) 
      {
        echo "Nu ai ales nicio optiune.";
      } 
      else
      {
        $n = count($optiuni);
     
        //echo("Ai selectat $n optiuni: ");

         $concurs =  new Concurs();

         global $sqli;
          
         $sql_update = "UPDATE postare_serviciu SET status_serviciu = '3', data_modificare = NOW()

         WHERE id_serviciu = '".$_GET['id_job']."' AND id_membru = '".$_SESSION['id_membru']."'";

         mysqli_query($sqli,$sql_update) or die(mysqli_error());


        for($i=0; $i < $n; $i++)
        {
          //echo 'nr stele:'.$_POST['numar_stele'].'gata nr stele';
          $concurs->nominalizareConcurs($optiuni[$i],$_GET['id_job'], $stele[$i]);
          //echo $optiuni[$i] . " ";

          $sql_update1 = "UPDATE inregistrare_concurs SET data_modificare = NOW(), numar_stele = '".$stele[$i]."'

          WHERE id_serviciu = '".$_GET['id_job']."' AND id_membru = '".$optiuni[$i]."'";

          mysqli_query($sqli,$sql_update1) or die(mysqli_error());
          //echo($_POST['numar_stele']);
        }

      }
      //  die($optiuni);
      header('Location: servicii-suplimentare.php?id_job='.$_GET['id_job']);
  }

  else
  {
    ?>
      <!--<script>alert("Nu ai putut sa realizezi licitatie");</script>-->
    <?php
  }

?>

<!DOCTYPE html>
<html>
<head>
  <title>Expert Independent</title>
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

</head>

<body data-spy="scroll" data-target=".navbar" data-offset="50">

<em><h2 style="text-align:center;"> Solutii propuse pentru serviciul - <b><?php echo $_GET['titlu']; ?></b></h2></em>
<!--action="servicii-suplimentare.php?titlu=<?php //echo $_GET['titlu'];?>&id_job=<?php //echo $_GET['id_job'];?>"-->
    <form role="form" method="post" action="alege-castigator.php?id_job=<?php echo $_GET['id_job']; ?>&titlu=<?php echo $_GET['titlu']; ?>">
    
    <?php
    global $sqli;

    $query1 = "SELECT * FROM membru WHERE id_membru = '".$_SESSION['id_membru']."' ";

    $result1 = mysqli_query($sqli,$query1);

    $row1 = mysqli_fetch_assoc($result1);

    $c=0;

    $query = "SELECT *, inregistrare_concurs.id_membru as id_membru, membru.nume as clientn, membru.prenume as clientp, membru.adresa_email as adresa
               FROM  inregistrare_concurs 
              RIGHT JOIN membru ON inregistrare_concurs.id_membru=membru.id_membru where inregistrare_concurs.id_serviciu='".$_GET['id_job']."'
            "; 
    $result = mysqli_query($sqli,$query);
          // output data of each row
    while($row = mysqli_fetch_assoc($result)) 
          { $c++;?>
      <?php if($row['solutie'] != '') {
	      echo '<label style="margin-left:20%;"><input type="checkbox" name="optcheck[]" value="'.$row['id_membru'].'">'.' '.$row['clientp'].' '.$row['clientn'].' - <img src='.$row['solutie'].'/></label>';
        echo '<select style="margin-left: 3%" name="numar_stele[]" value='.$row['numar_stele'].'>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
              </select>';
        //echo '<input type="hidden" value='.$row[''].'>'

        $notifica = new Concurs(); 
        $notifica->notificare($_SESSION['id_membru'],$_SESSION['nume'],$_SESSION['prenume'],$row1['adresa_email'],
                    $row['id_membru'], $row['clientn'], $row['clientp'], $row['adresa'], 'ALEGERE CASTIGATOR', 'Vezi cine a castigat concursul '.$_GET['titlu'].'!');
        echo '<button class="large-btn ofera-feedback" onclick="window.open(\'opinie.php?membru_id='.$row['id_membru'].'&concurs_id='.$row['id_serviciu'].'&titlu='.$_GET['titlu'].'\',\'_self\')" type="button" name="ofera-feedback" style="float:right; margin-right: 25%">Ofera feedback</button><br/>';
	  }}

       if($row['solutie'] == '') {
        echo '<h2 style="text-align: center;">Ne pare rau, nu exista solutii pentru acest serviciu!</h2>';
       }

   ?>
       <div class="clear:both"></div>
       <?php 
          if($row['solutie'] != '') {
              echo '<button class="large-btn" type="submit" style="margin-left: 50%; margin-top: 3%" name="alege-solutie">Alege solutie</button>';
        } ?> 

    </form>

</body>

</html>
