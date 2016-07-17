<?php
session_start();
  include "de-inclus.php";
 // echo '<pre>'; print_r($_POST); echo '</pre>'; 
  if(isset($_POST['ofertare'])) {
    if(isset($_POST['buget']) && trim($_POST['buget']) != '') $buget = $_POST['buget']; else $buget = 0;

    if( ($buget) )
    {
      $inscriere = new Concurs();
      $inscriere->ofertareLicitatie($_SESSION['id_membru'],$_GET['id_job'],$_POST['buget']);

      global $sqli;

      $query = "SELECT *, membru.nume as clientn, membru.prenume as clientp, membru.adresa_email as adresa FROM  postare_serviciu 
              RIGHT JOIN membru ON postare_serviciu.id_membru=membru.id_membru 
              WHERE id_serviciu = '".$_GET['id_job']."' ";
              
      $result = mysqli_query($sqli,$query);

      $row = mysqli_fetch_assoc($result);

      $query1 = "SELECT * FROM membru WHERE id_membru = '".$_SESSION['id_membru']."' ";

      $result1 = mysqli_query($sqli,$query1);

      $row1 = mysqli_fetch_assoc($result1);

      $inscriere->notificare($_SESSION['id_membru'], $_SESSION['nume'], $_SESSION['prenume'], $row1['adresa_email'],
                  $row['id_membru'],$row['clientn'], $row['clientp'], $row['adresa'],
                  $_POST['subiect'], 'Designerul '.$_SESSION['nume'].' '.$_SESSION['prenume'].'a ofertat cu '.$_POST['buget'].'
                  LEI la serviciul cu numele '.$_GET['titlu'].'.');

    }

    else
    {?> 
      <script> alert("Nu s-a putut efectua inregistrarea!"); </script>
    <?php
    }
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

  <em><h2 style="text-align:center"> <b>Oferteaza concurs - <?php echo $_GET['titlu'] ?> </b></h2></em>
  <div class="inscriere" style="width:70%; margin-left:15%">

  <form method="post">
    <div class="form-group" style="margin-top: 10%">

      <label for="buget" style="float:left  ">Buget propus:</label>
      <input type="text" class="form-control" id="titlu" name="buget" style="float:left">
      <input type="hidden" value="<?php echo $_GET['titlu']; ?>" name="titlu">
      <input type="hidden" value="OFERTARE" name="subiect"/>
      <input type="hidden" value="<?php 
      echo 'Designerul '.$_SESSION['nume'].' '.$_SESSION['prenume'].'a bugetat cu '.$_POST['buget'].'
                    la serviciul cu numele '.$_GET['titlu'].'.';

      ?>" name="mesaj"/>
      <div style="clear:both;"></div>

      <button type="submit" class="btn btn-primary btn-lg" name="ofertare" style="margin-bottom: 15%; margin-top: 10%">Oferteaza</button>
    </div>

    </form>

  </div>

</body>
</html>