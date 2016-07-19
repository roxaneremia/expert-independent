<?php

session_start();
  include "de-inclus.php";
  echo '<pre>'; print_r($_POST); echo '</pre>'; //die();

 

  if(isset($_POST['alege-solutie'])) {
 die();
      $query_notifica = "SELECT *, membru.nume as clientn, membru.prenume as clientp, membru.adresa_email as adresa FROM inregistrare_concurs 
      RIGHT JOIN membru ON inregistrare_concurs.id_membru=membru.id_membru WHERE inregistrare_concurs.id_serviciu='".$_GET['id_job']."' ";

      $result_notifica = mysqli_query($sqli,$query_notifica);
      while($row_notifica = mysqli_fetch_array($result_notifica))
      {
        $notifica = new Concurs(); 
        $notifica->notificare($_SESSION['id_membru'],$_SESSION['nume'],$_SESSION['prenume'],$row1['adresa_email'],
                    $row_notifica['id_membru'], $row_notifica['clientn'], $row_notifica['clientp'], $row_notifica['adresa'], 'ALEGERE CASTIGATOR', 'Vezi cine a castigat concursul '.$_GET['titlu'].'!');
      }
     
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

          //Calcul suma castigata
          $sql_final = "SELECT * FROM postare_serviciu
          WHERE  id_serviciu = '".$_GET['id_job']."'";

          $result_final = mysqli_query($sqli,$sql_final);

          $row_final = mysqli_fetch_array($result_final);
          
          $valoare_platforma = 0.1*$row_final['pret_final'];
          //se ia din contul platformei
          tranzactie('14',$_GET['id_job'],-$valoare_platforma,"comision platforma");
          //se vireaza in contul platformei
          tranzactie('14',$_GET['id_job'],$valoare_platforma,"comision platforma");

          if($i <1) 
          {
            //DACA ESTE CASTIGATOR UNIC
            if($stele[$i] == 5) {

              $valoare_premiu = 0.9*$row_final['pret_final'];
              //se ia din contul platformei
              tranzactie('14',$_GET['id_job'],-$valoare_premiu,"plata castigator principal");
              //se vireaza in contul platformei
              tranzactie($optiuni[$i],$_GET['id_job'],$valoare_premiu,"plata castigator principal");

            }

          }
          else 
          {

            if($stele[$i] == 5) {
              $valoare_premiu_principal = 0.7*$row_final['pret_final'];
              tranzactie('14',$_GET['id_job'],-$valoare_premiu_principal,"plata castigator principal");
              //se vireaza in contul platformei
              tranzactie($optiuni[$i],$_GET['id_job'],$valoare_premiu_principal,"plata castigator principal");
            }
            else
            {
              //mai sunt 20 de stele
              $valoare_premii_secundare = 0.2*$row_final['pret_final'];
            }

          }
 
          //echo $optiuni[$i] . " ";

          $sql_update1 = "UPDATE inregistrare_concurs SET data_modificare = NOW(), numar_stele = '".$stele[$i]."',

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

<p style="text-align: center; font-size: 16px; text-transform: italic;"> Designerul ce primeste 5 stele va fi desemnat drept castigator principal.</p> 
<p style="text-align: center; font-size: 16px; text-transform: italic; margin-bottom: 5%">El este unicul concurent ce primeste 5 stele! </p>

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
	      echo '<label style="margin-left:20%;"><input type="checkbox" name="optcheck[]" value="'.$row['id_membru'].'">'.' '.$row['clientp'].' '.$row['clientn'].' - <a href="imagine.php?img='.$row['solutie'].'"><img src="img/'.$row['solutie'].'" style="width: 30px;height: 30px; padding: 3px; border-radius: 3px; border: 1px solid #ccc;"/></a></label>';

        echo '<select style="margin-left: 3%" name="numar_stele['.$row['id_membru'].']" value='.$row['numar_stele'].'>
                <option value="0">Alege numar stele</option>
                <option value="5">5 stele</option>
                <option value="4">4 stele</option>
                <option value="3">3 stele</option>
                <option value="2">2 stele</option>
                <option value="1">1 stea</option>
              </select>';
        //echo '<input type="hidden" value='.$row[''].'>'
 
        echo '<button class="large-btn ofera-feedback" onclick="window.open(\'opinie.php?membru_id='.$row['id_membru'].'&concurs_id='.$row['id_serviciu'].'&titlu='.$_GET['titlu'].'\',\'_self\')" type="button" name="ofera-feedback" style="float:right; margin-right: 15%">Ofera feedback</button><br/>';
	  }
  }

       
        $count = @mysqli_num_rows($result);

        if($count == 0)
        {
          echo '<p style="text-align: center;">Ne pare rau, nu exista solutii pentru acest serviciu!</p>';

        }
        else
        {

          echo '<button class="large-btn" type="submit" style="margin-left: 50%; margin-top: 3%" name="alege-solutie">Alege solutie</button>';

        }

   ?>
       <div class="clear:both"></div>

    </form>

</body>

</html>
