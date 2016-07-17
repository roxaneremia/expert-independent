<?php
session_start();
  include "de-inclus.php";
  //echo '<pre>'; print_r($_SESSION); echo '</pre>'; 

  /*if(isset($_POST['alege-serviciu'])) {

    $suplimentar = new Suplimentare();
    if($_POST['optcheck1'] == 'printare')
      $suplimentar->confirmareServiciu($_GET['id_job'],$_POST['optcheck1'],$_POST['specificatii']);
    if($_POST['optcheck2'] == 'livrare')
      $suplimentar->confirmareServiciu($_GET['id_job'],$_POST['optcheck2'],$_POST['specificatii']);
  }*/

  if(isset($_POST['alege-serviciu'])) {
      $suplimentar = new Suplimentare();
      $optiuni = $_POST['optcheck'];

      if(empty($optiuni)) 
      {
        echo "Nu ai ales nicio optiune.";
      } 
      else
      {
        $n = count($optiuni);

        $concurs =  new Concurs();
     
        //echo("Ai selectat $n optiuni: ");

         global $sqli;
          
         $sql_update = "UPDATE postare_serviciu SET status_serviciu = '4', data_modificare = NOW()

         WHERE id_serviciu = '".$_GET['id_job']."' AND id_membru = '".$_SESSION['id_membru']."'";

         mysqli_query($sqli,$sql_update) or die(mysqli_error());


         $query1 = "SELECT * FROM membru WHERE id_membru = '".$_SESSION['id_membru']."' ";

         $result1 = mysqli_query($sqli,$query1);

         $row1 = mysqli_fetch_assoc($result1);

         $query_admin = "SELECT * FROM membru WHERE tip_membru = '0' ";

         $result2 = mysqli_query($sqli,$query_admin);

         $row2 = mysqli_fetch_assoc($result2);

         $query3 = "SELECT * FROM postare_serviciu WHERE id_serviciu = '".$_GET['id_job']."' ";

         $result3 = mysqli_query($sqli,$query3);

         $row3 = mysqli_fetch_assoc($result3);

        for($i=0; $i < $n; $i++)
        {

           $query_servicii_suplimentare = "SELECT * FROM servicii_suplimentare WHERE id_serviciu = '".$optiuni[$i]."' ";

           $result4 = mysqli_query($sqli,$query_servicii_suplimentare);

           $row4 = mysqli_fetch_assoc($result4);


           $suplimentar->confirmareServiciu($_GET['id_job'],$optiuni[$i],$_POST['specificatii']);
           $concurs->notificare($_SESSION['id_membru'],$_SESSION['nume'],$_SESSION['prenume'], $row1['adresa_email'],
                      $row2['id_membru'],$row2['nume'],$row2['prenume'],$row2['adresa_email'],
                      'SERVICII SUPLIMENTARE', 'Utilizatorul '.$_SESSION['nume'].' '.$_SESSION['prenume'].
                      ' comanda serviciile '.$row4['nume_serviciu'].' pentru serviciul '.$row3['titlu']);
        }

      }
      //  die($optiuni);
      //header('Location: servicii-suplimentare.php?id_job='.$_GET['id_job']);
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
  <!--css-->

  <!--js-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <!--js-->

</head>

<body data-spy="scroll" data-target=".navbar" data-offset="50">

<form method="post">


<em><h2 style="text-align:center">Servicii suplimentare</h2></em>

<form method="post">

   <?php
    global $sqli;

    $c=0;

    $query = "SELECT * FROM servicii_suplimentare WHERE 1=1"; 
    $result = mysqli_query($sqli,$query);
          // output data of each row
    while($row = mysqli_fetch_assoc($result)) 
          { $c++;
          echo '<label style="margin-left:20%;"><input type="checkbox" name="optcheck[]" value="'.$row['id_serviciu'].'">'.' '.$row['nume_serviciu'].'</label>';

        //$notifica = new Concurs(); 
       // $notifica->notificare($_SESSION['id_membru'],$_SESSION['nume'],$_SESSION['prenume'],$row1['adresa_email'],
                   // $row['id_membru'], $row['clientn'], $row['clientp'], $row['adresa'], 'ALEGERE CASTIGATOR', 'Vezi cine a castigat concursul '.$_GET['titlu'].'!');
        //echo '<button class="large-btn ofera-feedback" onclick="window.open(\'opinie.php?membru_id='.$row['id_membru'].'&concurs_id='.$row['id_serviciu'].'&titlu='.$_GET['titlu'].'\',\'_self\')" type="button" name="ofera-feedback" style="float:right; margin-right: 25%">Ofera feedback</button><br/>';
    }

      ?>
       <div class="clear:both"></div>
        <div class="form-group">
          <label for="specificatii">Specificatii:</label>
          <textarea class="form-control" rows="5" id="specificatii" name="specificatii"></textarea>
        </div>
      <button class="large-btn" type="submit" style="margin-left: 50%; margin-top: 3%" name="alege-serviciu">Confirma serviciu</button>

    </form>

</body>

</html>