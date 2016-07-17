 
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

<em><h2>Concururile mele in Expert Independent</h2></em>
<div class="lista_joburi">
<table id="tabel_joburi" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th style="text-align:center">Nr. crt.</th>
                <th style="text-align:center">Job</th>
                <th style="text-align:center">Suma</th>
                <th style="text-align:center">Data tranzactie</th>
                <th style="text-align:center">Nume tranzactie</th>
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
    $query = "SELECT *, postare_serviciu.titlu as titlu FROM  tranzactie 
              INNER JOIN postare_serviciu ON tranzactie.id_job=postare_serviciu.id_serviciu
              WHERE tranzactie.id_membru = '".$_SESSION['id_membru']."'"; 

    $result = mysqli_query($sqli,$query);
          // output data of each row
    while($row = mysqli_fetch_assoc($result)) 
          { $c++;?>

                 <tr>
                    
                    <td style="text-align:center"><?php echo $c; ?></td>
                    <td style="text-align:center"><?php echo $row['titlu']; ?></td>
                    <td style="text-align:center"><?php echo $row['suma']; ?> LEI</td>
                    <td style="text-align:center"><?php echo date('d-m-Y, H:i',strtotime($row["data_tranzactie"])); ?></td>
                    <td style="text-align:center"><?php echo $row['nume_tranzactie']; ?></td>

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