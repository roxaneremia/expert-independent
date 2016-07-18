<?php
session_start();
  //echo '<pre>'; print_r($_GET); echo '</pre>';  die();
include "de-inclus.php";
include "autentificat.php";


  if(isset($_POST['posteaza'])) {

    if(isset($_POST['titlu']) && trim($_POST['titlu']) != '') $titlu = $_POST['titlu']; else $titlu = 0;
    if(isset($_POST['descriere']) && trim($_POST['descriere']) != '') $descriere = $_POST['descriere']; else $descriere = 0;
    if(isset($_POST['pret_initial']) && trim($_POST['pret_initial']) != '') $pret_initial = $_POST['pret_initial']; else $pret_initial = 0;

    if( ($titlu) && ($descriere) && ($pret_initial) )
    {
      //stabilire termen licitatie pret

          $date_now = date('Y-M-d h:i:s');
          $date_now = strtotime($date_now);
          $date_new = strtotime("+".$_POST['interval_pret']." day", $date_now);
          $date_new = date('Y-m-d H:i:s', $date_new);


        //stabilire termen finalizare concurs

          $termen_acum = date('Y-M-d h:i:s');
          $termen_acum = strtotime($termen_acum);
          $termen_limita = strtotime("+".$_POST['termen_limita']." day", $termen_acum);
          $termen_limita = date('Y-m-d H:i:s', $termen_limita);

          //verific sa am bani suficienti in cont
          if($_POST['pret_initial'] <= $_SESSION['venit']) 
          {
              $serviciu = new Serviciu();
              $serviciu->posteazaServiciu($_POST,$_SESSION['id_membru'],$date_new,$termen_limita,$_POST['interval_pret']);

              global $sqli;
              $venit_actualizat = $_SESSION['venit'] - $_POST['pret_initial'];
              $sql_update = "UPDATE membru SET venit = '".$venit_actualizat."' WHERE id_membru = '".$_SESSION['id_membru']."' ";
              mysqli_query($sqli,$sql_update) or die(mysqli_error($sqli));

              $_SESSION['venit'] = $venit_actualizat;

              header('Location: servicii_postate.php');

          }
          else
          {
            echo 'Nu ai bani suficienti pentru a posta acest serviciu! Reincarca contul.';
          }

    }

    else {?>
      <script>alert('Nu ati introdus toate datele necesare postarii unui serviciu ...');</script>
    <?php }

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
  <link rel="stylesheet" href="css/posteaza-job.css" type="text/css" />
  <!-css-->

  <!--js-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <!--js-->

</head>

<body data-spy="scroll" data-target=".navbar" data-offset="50">

<?php include 'antet.php'; ?>

<em><h2> Posteaza serviciu </h2></em>

<div style="width: 70%; margin-left: 15%;">
    <div class="row">
        <div class="col-md-5"> 
            <p> Mai ai in cont:<?php echo $_SESSION['venit']; ?> LEI</p>
            <p> Daca nu ai bani suficienti incarca contul! </p>
        </div>
        <div class="col-md-7">
            <form class="paypal" action="confirmare-plata.php" method="post" id="paypal_form" target="_blank">
                <input type="hidden" name="cmd" value="_xclick" />
                <input type="hidden" name="no_note" value="1" />
                <input type="hidden" name="lc" value="RO" />
                <input type="hidden" name="currency_code" value="EUR" />
                <input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest" />
                <input type="hidden" name="first_name" value="Roxana" />
                <input type="hidden" name="last_name" value="Eremia" />
                <input type="hidden" name="payer_email" value="client@roxanaeremia.com" />
                <input type="hidden" name="item_number" value="123456" / >
                <input class="form-control" type="text" name="suma_incarcata" value="50" />
                <input class="btn btn-large" type="submit" name="submit" value="Incarca"/>
            </form>
        </div>
    </div>
</div>


<form method="post">	 


  <div class="form-group">
    <label for="titlu">Titlu:</label>
    <input type="text" class="form-control" id="titlu" name="titlu">
  </div>

  <div class="form-group">
    <label for="descriere">Descriere:</label>
    <textarea class="form-control" rows="5" id="descriere" name="descriere"></textarea>
  </div>

  <div class="form-group">
    <label for="pret_initial">Pret initial:</label>
    <input type="text" class="form-control" id="pret_initial" name="pret_initial">
  </div>


  <div style="clear:both"></div>


  <div class="form-group">
    <label for="termen_limita">Durata concurs(numar zile):</label>
    <input type="text" class="form-control" id="termen_limita" name="termen_limita">
  </div>

  <div class="form-group">
    <label for="link_descarcare">Link de descarcare:</label>
    <input type="text" class="form-control" id="link_descarcare" name="link_descarcare">
  </div>

  <div class="form-group" style="margin-bottom: 10%; margin-top: 3%;" class="schita">
    <label for="schita" class="label_schita" style="margin-right:5%;">Schita:</label>
    <input type="file" id="schita" value="Incarca" class="input_schita" name="schita">
  </div>

  <div class="form-group" style="clear:both">
    <label for="interval_pret">Interval stabilire pret:</label>
    <select class="form-control" id="interval_pret" name="interval_pret">
      <option>Alege interval</option>
      <option value="0">0 zile</option>
      <option value="1">1 zi</option>
      <option value="2">2 zile</option>
      <option value="3">3 zile</option>
      <option value="4">4 zile</option>
      <option value="5">5 zile</option>
    </select>
  </div>

  <button type="submit" class="btn btn-primary btn-lg" name="posteaza">Posteaza</button>


</form>

<?php include "subsol.php"; ?>
</body>

</html>

