<?php
session_start();
include "conectare.php";

	global $sqli;
	$sql_insert = "INSERT INTO tranzactie 
    	VALUES ('', '0', '".$_SESSION['id_membru']."', '".$_SESSION['suma_incarcata']."', NOW(), 'incarcare cont', '0', 'procesata')";
    if(mysqli_query($sqli, $sql_insert)) {
    	?>
        <script>alert('Tranzactie efectuata!');</script>
        <?php
    }
      else
        {
          ?>
            <script>alert('Eroare tranzactie ...');</script>
          <?php
        }  

      $sql = "SELECT * FROM  membru
      WHERE  id_membru = '".$_SESSION['id_membru']."'";

      $result = mysqli_query($sqli,$sql);

      $row = mysqli_fetch_array($result);

      $valoare = $_SESSION['suma_incarcata']*4.47 + $row['venit'];

      $sql_update= "UPDATE `membru` SET
      `venit` = '".$valoare."'
      WHERE `membru`.`id_membru` = '".$_SESSION['id_membru']."'";

      $result_update = mysqli_query($sqli,$sql_update);

?>

<h1>Plata acceptata</h1>

<p>Inapoi la platforma <a href="posteaza-job.php"><em>Expert Independent</em></a></p>

   