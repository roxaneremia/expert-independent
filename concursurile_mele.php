 
<?php
session_start();
  include "de-inclus.php";
  include "autentificat.php";
  //echo '<pre>'; print_r($_SESSION); echo '</pre>'; 

?>

<!DOCTYPE html>
<html>
<head>
  <title>Concursuri</title>
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

<em><h2>Concursurile mele in Expert Independent</h2></em>
<div class="lista_joburi table-responsive">
<table id="tabel_joburi" class="display table" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th style="text-align:center">Nr. crt.</th>
                <th style="text-align:center">Titlu</th>
                <th style="text-align:center">Buget propus</th>
                <th style="text-align:center">Status serviciu</th>
                <th style="text-align:center">Participa</th>
                <th style="text-align:center">Suma castigata</th>
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
    //$query = "SELECT *, postare_serviciu.titlu as titlu, postare_serviciu.descriere as descriere, 
    //postare_serviciu.termen_limita as incheiere, postare_serviciu.status_serviciu as status FROM  inregistrare_concurs 
             // RIGHT JOIN postare_serviciu ON inregistrare_concurs.id_membru=postare_serviciu.id_membru 
              //WHERE inregistrare_concurs.id_membru = '".$_SESSION['id_membru']."'
             // ORDER BY data_creare DESC"; 
    $query = "SELECT *, postare_serviciu.titlu as titlu, postare_serviciu.descriere as descriere,
            postare_serviciu.termen_limita as incheiere, postare_serviciu.status_serviciu as status FROM inregistrare_concurs 
            RIGHT JOIN postare_serviciu ON inregistrare_concurs.id_serviciu = postare_serviciu.id_serviciu 
            WHERE inregistrare_concurs.id_membru = '".$_SESSION['id_membru']."' ";

    $result = mysqli_query($sqli,$query);
          // output data of each row
    //die($query);
    while($row = mysqli_fetch_assoc($result))
          { $c++;?>

                 <tr>
                    
                    <td style="text-align:center"><?php echo $c; ?></td>
                    <td style="text-align:center"><a class="fancybox fancybox.iframe" href="descriere-job.php?id_job=<?php echo $row["id_serviciu"]; ?>&titlu=<?php echo $row['titlu'];?>" data-toggle="tooltip"><?php echo $row["titlu"]; ?></a></td>
                    <td style="text-align:center"><?php echo $row["buget_propus"]; ?> LEI</td>
                    <td style="text-align:center"><?php 

                      $nr_status = $row["status_serviciu"];

                      if($nr_status == 0) $status = "Deschis pentru ofertare";
                      if($nr_status == 1) $status = "Deschis pentru executie";
                      if($nr_status == 2) $status = "In asteptare desemnarii castigatorilor";
                      if($nr_status == 3) $status = "Finalizat";
                      if($nr_status == 4) $status = "Suplimentar";
                                          
                      echo $status;

                     ?></td>
                     <td style="text-align:center"><?php 

                      if($row['status_serviciu'] == 0)
                          echo $row['buget_propus'];
                      if($row['status_serviciu'] == 1)
                          echo '<a class="fancybox fancybox.iframe" href="participa.php?id_job='.$row["id_serviciu"].'">Participa</a>';
                      if($row['status_serviciu'] == 4 || $row['status_serviciu'] == 5) 
                          echo '<a class="fancybox fancybox.iframe" href="descriere-job.php?id_job='.$row["id_serviciu"].'">Finalizat</a>';
                     ?></td>
                     <td style="text-align:center"><?php echo $row["suma_castigata"]; ?></td>
                 </tr> 
    
            <?php
          } ?>
            
        </tbody>
    </table>    
    </div>    


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