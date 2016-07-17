<?php
session_start();
include "de-inclus.php";

$membru = new Membru();

if(isset($_POST['trimite']) && $_POST['trimite']=='ok') {

  echo($_POST['adresa_email']); 
}

$utilizator = $membru->afisareProfil($_GET['id_membru']);

?>

<head>

 <title>Profil public</title>
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

<body>

<em><h2 style="margin-left: 15%">Profilul utilizatorului <?php echo $utilizator['nume']; echo " "; echo $utilizator['prenume']; ?></h2></em>

<div class="fotografie_profil" style="margin-left: 15%; margin-top: 2%;">
    <img src="<?php 

        echo URL."/img/".$utilizator['fotografie_profil']; 

    ?>" style="width:200px; float:left"/>
</div>

<div clas="date_profil" style="float:left; margin-left: 50px;">
    <em>Data creare profil: <?php echo $utilizator['data_creare']; ?></em>
    <br><br>
    <em>Ultima actualizare: <?php echo $utilizator['data_actualizare']; ?></em>
    <br><br>
    <em>Tip utilizator: <?php
      if($utilizator['tip_membru'] == 1)
        echo "client"; 
      if($utilizator['tip_membru'] == 2)
        echo "designer";
      if($utilizator['tip_membru'] == 3)
        echo "client + designer";
      if($utilizator['tip_membru'] == 0) 
        echo "administrator";
    ?></em>
    <br><br>
</div>

<div style="clear:both"></div>

<br>

<form method="post" style="width: 70%; margin-left: 15%" action="trimite.php?expeditor=<?php echo $_SESSION['id_membru']; ?>&destinatar=<?php echo $utilizator['id_membru']; ?>">

<div style="float:left">

    <div class="nume">
      <span> Nume: </span>
      <span> <?php echo $utilizator['nume']; ?></span>
    </div>

    <div class="prenume">
      <span> Prenume: </span>
      <span> <?php echo $utilizator['prenume']; ?></span>
    </div>

    <div class="nume_cont">
      <span> Cont: </span>
      <span> <?php echo $utilizator['nume_cont']; ?></span>
    </div>

    <div class="nume_cont">
      <span> Adresa email: </span>
      <span> <?php echo $utilizator['adresa_email']; ?></span>
    </div>

    <div class="nume_cont">
      <span> Gen: </span>
      <span> <?php echo $utilizator['gen']; ?></span>
    </div>

</div>

<button type="submit" name="trimite" value="ok" class="btn btn-default btn-submit" style="float:left; margin-top: 5%; margin-left: 5%">Trimite-i un mesaj</button>

<div style="clear:both"></div>

</form>

</body>