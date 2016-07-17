 
<?php
session_start();
  include "de-inclus.php";
  include "autentificat.php";
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
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="css/index.css" type="text/css" />
  <link rel="stylesheet" href="css/lista-joburi.css?v=<?php echo time(); ?>" type="text/css">
  <!-css-->
  
  <!--js-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <script src="js/jquery-1.12.3.js"></script>
  <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
  <!--js-->
  <?php include_once('meta.php'); ?>
</head>

<body data-spy="scroll" data-target=".navbar" data-offset="50">

<?php include "antet.php"; ?>

<em><h2>Joburile mele in Expert Independent</h2></em>
<div class="lista_joburi table-responsive">
<table id="tabel_joburi" class="display table" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th style="text-align:center">Nr. crt.</th>
                <th style="text-align:center">Titlu</th>
                <th style="text-align:center">Pret solicitat</th>
                <th style="text-align:center">Data publicare</th>
                <th style="text-align:center">Termen inscriere concurs</th>
                <th style="text-align:center">Incheiere concurs</th>
                <th style="text-align:center">Status serviciu</th>
                <th style="text-align:center">Pret executie</th>
            </tr>
        </thead>
        <!--<tfoot>
            <tr>
                <th>Name</th>
                <th>Position</th>
                <th>Office</th>
                <th>Age</th>
                <th>Start date</th>
                <th>Salary</th>
            </tr>
        </tfoot>-->
        <tbody>
           

<?php
    $c=0;
    global $sqli;
    $query = "SELECT * FROM  postare_serviciu 
              WHERE postare_serviciu.id_membru = '".$_SESSION["id_membru"]."'
              ORDER BY data_postarii DESC"; 

    $result = mysqli_query($sqli,$query);
          // output data of each row
    while($row = mysqli_fetch_assoc($result)) 
          { $c++;?>

                 <tr>
                    
                    <td style="text-align:center"><?php echo $c; ?></td>
                    <td style="text-align:center"><a class="fancybox fancybox.iframe" href="descriere-job-postat.php?id_job=<?php echo $row["id_serviciu"]; ?>&titlu=<?php echo $row['titlu'];?>"><?php echo $row["titlu"]; ?></a></td>
                    <td style="text-align:center"><?php echo $row["pret_initial"]; ?> LEI</td>
                    <td style="text-align:center"><?php

                    echo date('d-m-Y, H:i',strtotime($row["data_postarii"]));


                    ?></td>
                    <td style="text-align:center"><?php echo date('d-m-Y, H:i',strtotime($row["interval_stabilire_pret"])); ?></td>
                    <td style="text-align:center"><?php echo date('d-m-Y, H:i',strtotime($row["termen_limita"])); ?></td>
                    
                    <td style="text-align:center"><?php 

                      $nr_status = $row["status_serviciu"];

                      if($nr_status == 0) $status = "Deschis pentru ofertare";
                      if($nr_status == 1) $status = "Deschis pentru executie";
                      if($nr_status == 2) $status = "In asteptare desemnarii castigatorilor";
                      if($nr_status == 3) $status = "Finalizat";
                      if($nr_status == 4) $status = "Suplimentar";
                      if($nr_status == 5) $status = "Fara solutii";
                                          
                      echo $status;

                     ?></td>
                     
                     <td style="text-align:center">

                      
                      <?php 
                      if($row['pret_final'] == 0 && $row["status_serviciu"] != '3' && $row["status_serviciu"] != '5') {
                        echo '<a class="fancybox fancybox.iframe" href="alege-pret.php?id_job='.$row['id_serviciu'].'&titlu='.$row['titlu'].'">alege pret</a>';
                      } 
                       else if($row["status_serviciu"] != '3' && $row["status_serviciu"] != '5')
                        echo'<a class="fancybox fancybox.iframe" href="alege-castigator.php?id_job='.$row['id_serviciu'].'&titlu='.$row['titlu'].'">'.$row['pret_final'].'</a>';

                          else if($row['status_serviciu'] == 3 || $row['status_serviciu'] == 5) echo $row['pret_final'];
                        
                      ?>
                     
                     </td>
                 </tr> 
    
            <?php
          } ?>
            
        </tbody>
    </table>    
    </div>    
<?php
/*
 `id_serviciu` int(11) NOT NULL,
  `id_membru` int(11) NOT NULL,
  `titlu` varchar(255) NOT NULL,
  `descriere` varchar(255) NOT NULL,
  `pret_initial` decimal(10,2) NOT NULL,
  `data_postarii` datetime NOT NULL,
  `termen_limita` datetime NOT NULL,
  `link_descarcare` varchar(255) NOT NULL,
  `schita` varchar(255) NOT NULL,
  `interval_stabilire_pret` datetime NOT NULL,
  `pret_final` decimal(10,2) NOT NULL,
  `data_modificare` datetime NOT NULL,
  `status_serviciu` int(1) NOT NULL

*/

?>


<?php include "subsol.php"; ?>
<script>
  $(document).ready(function() {

    $('#tabel_joburi').DataTable( {
        "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Romanian.json"
        }
    });



} );
</script>
</body>
</html>