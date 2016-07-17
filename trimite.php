<?php
session_start(); 
  include "de-inclus.php"; 
  //echo '<pre>'; print_r($_SESSION); echo '</pre>'; 
   
  if(isset($_POST['trimite_mesaj'])) {

     global $sqli;

    $sql = "SELECT * FROM   membru
    WHERE  id_membru = '".$_POST['expeditor']."'";
    $result = mysqli_query($sqli,$sql);
    $row = mysqli_fetch_array($result);

    $sql1 = "SELECT * FROM   membru
    WHERE  id_membru = '".$_POST['destinatar']."'";
    $result1 = mysqli_query($sqli,$sql1);
    $row1 = mysqli_fetch_array($result1);


    $conversatie = new Conversatie();
    $conversatie->trimiteMesajProfil($row['id_membru'], $row['nume'], $row['prenume'], $row['adresa_email'],
                                    $row1['id_membru'], $row1['nume'], $row1['prenume'], $row1['adresa_email'],
                                    $_POST['subiect'],$_POST['mesaj']);
  }

?>

<!DOCTYPE html>
<html>
<head>
  <title>Trimite un mesaj</title>
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

<em><h2 style="text-align:center">Trimite un mesaj</h2></em>

<form method="post" action="trimite.php" style="width: 60%; margin-left:20%">

    <div class="form-group">
      <label for="subiect">Subiect:</label>
      <input type="text" class="form-control" id="subiect" name="subiect">
    </div>

    <div class="form-group">
      <label for="mesaj">Mesajul tau:</label>
      <textarea class="form-control" rows="5" id="mesaj" name="mesaj"></textarea>
    </div>

    <input type="hidden" name="expeditor" value="<?php echo $_GET['expeditor']; ?>"/>
    <input type="hidden" name="destinatar" value="<?php echo $_GET['destinatar']; ?>"/>

    <button type="submit" name="trimite_mesaj" value="ok" class="btn btn-default btn-submit" style="float:left; margin-top: 5%; margin-left: 5%">Trimite</button>

</form>

</body>

</html>
