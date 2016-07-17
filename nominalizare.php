<?php
session_start();
  include "de-inclus.php";
  //echo '<pre>'; print_r($_SESSION); echo '</pre>'; 
  $serviciu = new Serviciu();
  $job = $serviciu->afiseazaServiciu($_GET['id_job']);
  //echo '<pre>'; print_r($_SESSION); echo '</pre>';
  //echo '<pre>'; print_r($_GET); echo '</pre>';

  if(isset($_POST['inscriere'])) {
    $concurs = new Concurs();

    if($concurs->ofertareConcurs($_SESSION['id_membru'],$_GET['id_job'],  $job['titlu']) == 0) {
       $concurs->inscriereConcurs($_SESSION['id_membru'],$_GET['id_job']);

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
  <link rel="stylesheet" href="css/descriere-job.css" type="text/css">
  <!-css-->

  <!--js-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <!--js-->

</head>

<body data-spy="scroll" data-target=".navbar" data-offset="50">
 
<div class="container" style="margin-top: 3%">

  <em><p style="font-size: 25px; float:left"><b><?php echo $job['titlu'] ?></b></p></em>
  <p style="float:left; margin-left: 3%; font-size: 25px"><b><em> - <?php echo $job['pret_initial']?> LEI</em></b></p>
  <button style="float:right" type="submit" onclick="window.open('inscriere.php?id_job=<?php echo $_GET['id_job']; ?>&titlu=<?php echo $_GET['titlu']?>','_self')" class="btn btn-primary btn-lg" name="inscriere">Inscrie-te in concurs</button>
  <p style="clear:both"></p>

  <div class="jumbotron">

    <p style="float:left; margin-right: 1%; margin-bottom: 0; font-size: 13px;">Client: </p>
    <p style="float:left; margin-bottom: 0; font-size: 13px;"><?php echo $job['nume'] ?></p> 

    <p style="float:right; margin-bottom: 0; font-size: 13px;"><?php echo date('d-m-Y, H:i',strtotime($job['data_postarii'])) ?></p> 
        <p style="float:right; margin-right: 1%; margin-bottom: 0; font-size: 13px;">Publicat: </p>

    <p style="clear:both; margin-bottom: 0"></p>

    <p style="float:left; margin-right: 1%; margin-bottom: 0; font-size: 13px;">Status serviciu: </p>
    <p style="float:left; margin-bottom: 0; font-size: 13px; "><?php

    $nr_status = $job['status_serviciu'];
    if($nr_status == 0) $status = "Neinitializat";  
    if($nr_status == 1) $status = "Postat";
    if($nr_status == 2) $status = "Inscriere concurs";
    if($nr_status == 3) $status = "In desfasurare";
    if($nr_status == 4) $status = "Alegere castigator";
    if($nr_status == 5) $status = "Finalizat";

    echo $status;

     ?></p> 

    <p style="float:right; margin-bottom: 0; font-size: 13px;"><?php echo date('d-m-Y, H:i',strtotime($job['interval_stabilire_pret'])) ?></p> 
    <p style="float:right; margin-right: 1%; margin-bottom: 0; font-size: 13px;">Timp desfasurare concurs: </p> 

    <p style="clear:both; margin-bottom: 0"></p>


    <p style="float:left; margin-right: 1%; margin-bottom: 0; font-size: 13px;">Ultima modificare: </p>
    <p style="float:left; margin-bottom: 0; font-size: 13px; "><?php echo date('d-m-Y, H:i',strtotime($job['data_modificare'])) ?></p> 


    <p style="float:right; margin-bottom: 0; font-size: 13px;"><?php echo date('d-m-Y, H:i',strtotime($job['interval_stabilire_pret'])) ?></p> 
    <p style="float:right; margin-right: 1%; margin-bottom: 0; font-size: 13px;">Timp inscriere concurs: </p>
    <p style="clear:both; margin-bottom: 0"></p>

    <br/>
    <p style="float:left; margin-right: 1%; margin-bottom: 0; font-size: 13px;">Link descarcare: </p>
    <p style="float:left; margin-bottom: 0; font-size: 13px;"><a href="<?php echo $job['link_descarcare'] ?>">Descarca</a></p>
 
    <p style="float:right; margin-right: 1%; font-size: 13px; margin-right: 13%">Schita: </p>
    <p style="clear:both; margin-bottom: 0"></p>

    <p style="float:right; margin-bottom: 0; margin-right: 15%; font-size: 13px;">
       <a href="imagine.php?img=<?php echo $job['schita'] ?>">
         <img src="img/<?php echo $job['schita'] ?>" style="width: 30px;height: 30px; padding: 3px; border-radius: 3px; border: 1px solid #ccc;"/></a></p> 

    <br/>    
    <p style="float:left; margin-right: 1%; margin-bottom: 0; font-size: 13px;">Descriere: </p>
    <p style="float:left; margin-bottom: 0; font-size: 13px;"><?php echo $job['descriere']?></p> 

    <p style="clear:both; margin-bottom: 0"></p>


  </div>

</div>
</form>
</body>
</html>
