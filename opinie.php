<?php
session_start();
  include "de-inclus.php";
  //echo '<pre>'; print_r($_SESSION); echo '</pre>'; 
  if(isset($_POST['feedback'])) {

  		global $sqli;
      
    	$sql_update = "UPDATE inregistrare_concurs SET opinie_client = '".$_POST['opinie']."', data_modificare = NOW()

    	WHERE id_serviciu = '".$_GET['concurs_id']."' AND id_membru = '".$_GET['membru_id']."'";

   	 	mysqli_query($sqli,$sql_update) or die(mysqli_error($sqli));

   	  header('Location: alege-castigator.php?id_job='.$_GET['concurs_id'].'&titlu='.$_GET['titlu'].'');

		  exit;

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

<form method="post"  action="opinie.php?concurs_id=<?php echo $_GET['concurs_id']; ?>&membru_id=<?php echo $_GET['membru_id']; ?>&titlu=<?php echo $_GET['titlu']; ?>">

  <div class="form-group">
    <label for="opinie">Parerea mea este ca:</label>
    <textarea class="form-control" rows="5" id="opiniem" name="opinie"></textarea>
  </div>

  <button type="submit" class="btn btn-large feedback" name="feedback">Feedback</button>

</form>

</body>