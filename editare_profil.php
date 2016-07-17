<?php
session_start();
include "de-inclus.php";


$membru = new Membru();


if(    isset($_POST['parola']) 
       && md5(trim($_POST['parola'])) != '' 
       && md5(trim($_POST['parola'])) == md5(trim(trim($_POST['repeta_parola']))) 
) { 
      $parola_noua=md5(trim($_POST['parola']));
      $parola_update=md5(trim($_POST['parola']));
} else { $parola_update=""; }

if(isset($_POST['modifica']) && $_POST['modifica']=='ok') {

  $membru->editareProfil($_POST);

  if($parola_update != "") {

    $membru->modificareParola($parola_update);

  }

}

$utilizator = $membru->afisareProfil($_SESSION['id_membru']);

?>

<head>

 <title>Editeaza profil</title>
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

<?php include"antet.php"; ?>

<em><h2 style="margin-left: 15%">Editeaza profil</h2></em>

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
    <em>Suma in cont: <?php echo $utilizator['venit']; ?></em>
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


<form method="post" style="width: 70%; margin-left: 15%">

<div class="form-group" style="margin-top: 2%; margin-bottom: 2%;" class="schita">
  <label for="foto" class="label_schita" style="margin-right:5%;">Schimba fotografia de profil:</label>
  <input type="file" id="foto" value="Incarca" name="fotografie_profil">
</div>

<div class="form-group">
  <label for="nume">Nume:</label>
  <input type="text" class="form-control" id="nume" name="nume" value="<?php echo $utilizator['nume']; ?>">
</div>

<div class="form-group">
  <label for="prenume">Prenume:</label>
  <input type="text" class="form-control" id="prenume" name="prenume" value="<?php echo $utilizator['prenume']; ?>">
</div>

<div class="form-group">
  <label for="parola">Parola:</label>
  <input type="password" class="form-control" id="parola" name="parola">
</div>

<div class="form-group">
  <label for="repeta_parola">Modifica parola:</label>
  <input type="password" class="form-control" id="repeta_parola" name="repeta_parola">
</div>

<div class="form-group">
  <label for="cont">Cont:</label>
  <input type="text" class="form-control" id="cont" name="nume_cont" value="<?php echo $utilizator['nume_cont']; ?>">
</div>

<div class="form-group">
  <label for="email">Adresa email:</label>
  <input type="text" class="form-control" id="email" name="email" value="<?php echo $utilizator['adresa_email']; ?>">
</div>

<div class="form-group">
  <label for="gen">Selecteaza gen:</label>
  <select class="form-control" id="gen" name="gen" value="<?php echo $utilizator['gen'] ?>">
    <option value="<?php echo $utilizator['gen'] ?>"><?php 
      if($utilizator['gen'] == "m") echo 'Masculin';
      else echo 'Feminin';
    ?></option>
    <option value="<?php 
      if($utilizator['gen'] == "m") echo 'f';
      else echo 'm';
    ?>"><?php
    if($utilizator['gen'] == "m") echo 'Feminin';
    else echo 'Masculin';
     ?></option>
  </select>
</div>


<button type="submit" name="modifica" value="ok" class="btn btn-default btn-submit">Modifica profil</button>

</form>

<?php include"subsol.php"; ?>

</body>