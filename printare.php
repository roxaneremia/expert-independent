<?php
session_start();
  include "de-inclus.php";
  //echo '<pre>'; print_r($_SESSION); echo '</pre>'; 
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

 <form method="post">

    <em><h2 style="text-align:center">Printeaza solutia</h2></em>

    <div class="form-group" style="margin-top: 2%">

      <label for="tip" style="float:left  ">Tip produs:</label>
        <input type="text" class="form-control" id="titlu" name="tip" style="float:left">
        <input type="hidden" value="<?php echo $_GET['tip'] ?>" name="titlu">
      <div style="clear:both;"></div>

      <label for="bucati" style="float:left  ">Nr bucati:</label>
        <input type="text" class="form-control" id="titlu" name="buget" style="float:left">
        <input type="hidden" value="<?php echo $_GET['bucati'] ?>" name="bucati">
      <div style="clear:both;"></div>

      <button type="submit" class="btn btn-primary btn-lg" name="printare" style="margin-bottom: 15%; margin-top: 10%">Printeaza</button>

    </div>

    </form>

</body>

</html>