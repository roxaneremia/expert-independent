<?php
session_start();
  include "de-inclus.php";
  //echo '<pre>'; print_r($_SESSION); echo '</pre>'; 
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

<?php include "antet.php"; ?>   

<div id="cauta_job" class="container-fluid col-md-6">
  <h1>Cauta job</h1>
  <p>Esti in cautarea unui job?</p>
 <form method="get" action="cauta.php">
    <input placeholder="Cauta un job" id="cauta_input" name="q" type="text">
    <input type="hidden" name="u" value="cauta">
    <input type="submit"id="cauta_btn" class="btn btn-primary btn-lg" value="Cauta">
</form>
</div>

<div id="posteaza_job" class="container-fluid col-md-6">
  <h1>Posteaza job</h1>
  <p>Expert Independent iti vine in ajutor!</p>
  <form action="posteaza-job.php" method="get">
    <input type="hidden" name="u" value="posteaza-job">
    <input type="hidden" name="q" value="">
    <input type="submit" id="posteaza_btn" class="btn btn-primary btn-lg" value="Posteaza un job">
  </form>
</div>

<div id="functioneaza" class="container-fluid">
  <button type="button" class="btn btn-primary btn-lg" onclick="window.open('despre-noi.php','_self')" id="about_us">Cum functioneaza?</button>
</div>

<?php include"subsol.php"; ?>
</body>
</html>
