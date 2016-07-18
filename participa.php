<?php
session_start();
  include "de-inclus.php";
  //echo '<pre>'; print_r($_SESSION); echo '</pre>'; 

  if(isset($_POST['trimite-solutie'])) {

    global $sqli;
      
    $sql_update = "UPDATE inregistrare_concurs SET solutie = '".$_POST['solutie']."', data_modificare = NOW()

    WHERE id_serviciu = '".$_GET['id_job']."' AND id_membru = '".$_SESSION['id_membru']."'";

    mysqli_query($sqli,$sql_update) or die(mysqli_error($sqli));

    
    $query1 = "SELECT * FROM membru WHERE id_membru = '".$_SESSION['id_membru']."' ";

    $result1 = mysqli_query($sqli,$query1);

    $row1 = mysqli_fetch_assoc($result1);

    $query2 = "SELECT *, membru.nume as clientn, membru.prenume as clientp, membru.adresa_email as adresa
                FROM postare_serviciu 
               RIGHT JOIN membru ON postare_serviciu.id_membru=membru.id_membru 
                WHERE id_serviciu = '".$_GET['id_job']."' ";


    $result2 = mysqli_query($sqli,$query2);

    $row2 = mysqli_fetch_assoc($result2);

    $inscriere = new Concurs();

    $inscriere->notificare($_SESSION['id_membru'], $_SESSION['nume'], $_SESSION['prenume'], $row1['adresa_email'],
                $row2['id_membru'], $row2['clientn'], $row2['clientp'], $row2['adresa'], 
                'POSTARE SOLUTIE','Designerul '.$_SESSION['nume'].' '.$_SESSION['prenume'].' a oferit o solutie
                la serviciul '.$row2['titlu'].'.');

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
<?php
  $query_titlu = "SELECT * FROM postare_serviciu WHERE id_serviciu = '".$_GET['id_job']."'";
  $result_titlu = mysqli_query($sqli,$query_titlu);

  $row_titlu = mysqli_fetch_array($result_titlu);
?>
<em><h2 style="text-align:center;">Participa la serviciul <b><?php echo $row_titlu['titlu']; ?></b></h2></em>

  <form method="post" style="width: 70%; margin-left: 15%">

    <div class="form-group" style="margin-top: 2%; margin-bottom: 2%;" class="solutie">

      <label for="foto" class="label_solutie" style="margin-right:5%;">Incarca solutie:</label>

      <input type="file" id="foto" value="Incarca" name="solutie">

    </div>

    <button type="submit" name="trimite-solutie" class="btn btn-submit">Trimite solutie</button>

  </form>

</body>

</html>