<?php
session_start();
  include "de-inclus.php";
//echo '<pre>'; print_r($_SESSION); echo '</pre><hr/>'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Despre noi</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!--css-->
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/antet.css" type="text/css" />
  <link rel="stylesheet" href="css/despre-noi.css">
  <link rel="stylesheet" href="css/subsol.css" type="text/css" />

  <!--css-->

  <!--js-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <!--js-->

</head>
<body>
<?php include "antet.php"; ?>

<div class="container">
<h2>Despre noi</h2>
  <br>
  <div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
      <li data-target="#myCarousel" data-slide-to="3"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">
      <div class="item active">
        <img src="img/online-shopping.png" alt="Chania" width="460" height="345">
      </div>

      <div class="item">
        <img src="img/order-online.png" alt="Chania" width="460" height="345">
      </div>
    
      <div class=" item">
        <img src="img/ordering.png" alt="Chania" width="460" height="345">
      </div>

      <div class="item">
        <img src="img/expert-independent.png" alt="Chania" width="460" height="345">
      </div>
    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
      <span class="sr-only">Anteriorul</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
      <span class="sr-only">Urmatorul</span>
    </a>
  </div>
</div>
<br/><br/>



<?php include "subsol.php"; ?>
</body>
</html>
