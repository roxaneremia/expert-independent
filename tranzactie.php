<?php
include 'conectare.php';

  function tranzactie($id_membru, $id_job, $suma, $nume_tranzactie) {
    global $sqli;

    if(mysqli_query($sqli,
        "INSERT INTO tranzactie VALUES 
      ('','".$id_job."',
        '".$id_membru."',
        '".$suma."',
        NOW(),
        '".$nume_tranzactie."',
        '0',
        'procesata')"))
      {
        ?>
        <!--<script>alert('Tranzactie efectuata!');</script>-->
        <?php
      }

      else
        {
          ?>
            <script>alert('Eroare tranzactie ...');</script>
          <?php
        }   
    
      $sql = "SELECT * FROM  membru
      WHERE  id_membru = '".$id_membru."'";

      $result = mysqli_query($sqli,$sql);

      $row = mysqli_fetch_array($result);

      $valoare = $suma + $row['venit'];

      $sql_update= "UPDATE `membru` SET
      `venit` = '".$valoare."'
      WHERE `membru`.`id_membru` = '".$id_membru."'";

      $result_update = mysqli_query($sqli,$sql_update);

    }

    //tranzactie("23","5","34","postare");

?>