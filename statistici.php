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
 
   <?php include_once('meta.php'); ?>

</head>

<body>

<?php  include"antet.php"; ?>

<em><h2 style="margin-left: 15%">Statistici</h2></em>


<ul>
<li><a href="statistici-membrii.php" class="fancybox fancybox.iframe">Vezi statisticile utilizatorilor platformei</a></li>
<li><a href="statistici-joburi.php" class="fancybox fancybox.iframe">Vezi statisticile proiectelor</a></li>


</ul>




<?php include"subsol.php"; ?>

</body>
</html>