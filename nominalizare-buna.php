<?php

session_start();
  include "de-inclus.php";
  //echo '<pre>'; print_r($_SESSION); echo '</pre>'; 

  if(isset($_POST['alege-pret'])) {
    $concurs =  new Concurs();
    $concurs->licitatiePret($_GET['id_job'],$_POST['optradio']);
    
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

    <form role="form" method="post" action="javascript:history.go(-1);">
    
    <?php
    $c=0;
    global $sqli;
    $query = "SELECT *, inregistrare_concurs.id_membru as id_membru, membru.nume as clientn, membru.prenume as clientp FROM  inregistrare_concurs 
              RIGHT JOIN membru ON inregistrare_concurs.id_membru=membru.id_membru where inregistrare_concurs.id_serviciu='".$_GET['id_job']."'
            "; 
    $result = mysqli_query($sqli,$query);
          // output data of each row
    while($row = mysqli_fetch_assoc($result)) 
          { $c++;?>  

      <div class="radio">
        <label><input type="radio" name="optradio" value="<?php echo $row['id_membru']; ?>"><?php echo $row['clientp']." ".$row['clientn']; 
        echo " - "; echo $row['buget_propus']; echo " LEI";
         ?></label>
      </div>
     <?php } ?>

    <button class="large-btn" type="submit" name="alege-pret">Alege pret</button>

</body>

</html>
