<?php

session_start();
  include "de-inclus.php";
  //echo '<pre>'; print_r($_SESSION); echo '</pre>'; 

  if(isset($_POST['alege-pret'])) {
    //echo($_GET['id_job']);
    $concurs =  new Concurs();
    $concurs->licitatiePret($_GET['id_job'],$_POST['optradio']);
    //echo("didi");
    global $sqli;
      
    $sql_update = "UPDATE postare_serviciu SET status_serviciu = '1', data_modificare = NOW()

    WHERE id_serviciu = '".$_GET['id_job']."' AND id_membru = '".$_SESSION['id_membru']."'";

    mysqli_query($sqli,$sql_update) or die(mysqli_error());

    //NOTIFICARE
    $query1 = "SELECT * FROM membru WHERE id_membru = '".$_SESSION['id_membru']."' ";

    $result1 = mysqli_query($sqli,$query1);

    $row1 = mysqli_fetch_assoc($result1);

    $c=0;
    //global $sqli;
    $query = "SELECT *, inregistrare_concurs.id_membru as id_membru, membru.nume as clientn, membru.prenume as clientp, membru.adresa_email as adresa 
              FROM  inregistrare_concurs 
              RIGHT JOIN membru ON inregistrare_concurs.id_membru=membru.id_membru where inregistrare_concurs.id_serviciu='".$_GET['id_job']."'
            "; 
    $result = mysqli_query($sqli,$query);
    $notifica = new Concurs(); 
          // output data of each row
    while($row = mysqli_fetch_assoc($result)) {

      $c++;
      $notifica->notificare($_SESSION['id_membru'],$_SESSION['nume'],$_SESSION['prenume'],$row1['adresa_email'],
                      $row['id_membru'], $row['clientn'], $row['clientp'], $row['adresa'], 
                      'LICITATIE PRET', 'Vezi ce pret are serviciul '.$_GET['titlu'].'!');
    }

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

<em><h2 style="text-align:center;"> Oferte serviciu - <b><?php echo $_GET['titlu']; ?></b></h2></em>

<?php

  

?>

    <form role="form" method="post">
    
    <?php
    $c=0;
    global $sqli;
    $query = "SELECT *, inregistrare_concurs.id_membru as id_membru, membru.nume as clientn, membru.prenume as clientp, membru.adresa_email as adresa 
              FROM  inregistrare_concurs 
              RIGHT JOIN membru ON inregistrare_concurs.id_membru=membru.id_membru where inregistrare_concurs.id_serviciu='".$_GET['id_job']."'
            "; 
    $result = mysqli_query($sqli,$query);
    $notifica = new Concurs(); 
          // output data of each row
    while($row = mysqli_fetch_assoc($result)) 
          { $c++;

          //echo $c;
          //echo '<br/>';
          //echo $_SESSION['id_membru'];
          //echo '<br/>';
          
          //$notifica->notificare($_SESSION['id_membru'],$_SESSION['nume'],$_SESSION['prenume'],$row1['adresa_email'],
                     // $row['id_membru'], $row['clientn'], $row['clientp'], $row['adresa'], 
                      //'LICITATIE PRET', 'Vezi ce pret are serviciul '.$_GET['titlu'].'!');

          ?>  

      <div class="radio">
        <label><input type="radio" name="optradio" value="<?php echo $row['id_membru']; ?>"><?php echo $row['clientp']." ".$row['clientn']; 
        echo " - "; echo $row['buget_propus']; echo " LEI";
         ?></label>
      </div>
     <?php } 
        ?>
 
    <button class="large-btn" type="submit" name="alege-pret">Alege pret</button>

</body>

</html>
